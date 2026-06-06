const STREAM_RECORDER_FORMAT = 'mp3';
const STREAM_PAYLOAD_FORMAT = 'mp3';
const STREAM_DEFAULT_FRAME_SIZE_KB = 1;
const STREAM_DEFAULT_CHUNK_DELAY_MS = 30;
const STREAM_PENDING_CHUNKS_MAX = 24;
const STREAM_PENDING_BYTES_MAX = 32 * 1024;
const STREAM_RECORDER_FORMATS = ['mp3', 'aac', 'pcm'];

function extractErrorMessage(error) {
	if (!error) {
		return '';
	}

	if (typeof error === 'string') {
		return error.trim();
	}

	if (typeof error.message === 'string' && error.message.trim()) {
		return error.message.trim();
	}

	if (typeof error.errMsg === 'string' && error.errMsg.trim()) {
		return error.errMsg.trim();
	}

	if (typeof error.msg === 'string' && error.msg.trim()) {
		return error.msg.trim();
	}

	if (error.data && typeof error.data === 'object') {
		return extractErrorMessage(error.data);
	}

	return '';
}

function normalizeError(error, fallbackMessage) {
	const message = extractErrorMessage(error) || fallbackMessage;
	if (error instanceof Error && error.message) {
		return error;
	}

	const wrapped = new Error(message);
	if (error && typeof error === 'object') {
		Object.keys(error).forEach((key) => {
			if (!(key in wrapped)) {
				wrapped[key] = error[key];
			}
		});
	}

	return wrapped;
}

function normalizePath(path) {
	if (!path) {
		return '';
	}

	return path.startsWith('/') ? path : `/${path}`;
}

function delay(ms) {
	return new Promise((resolve) => setTimeout(resolve, Math.max(0, Number(ms) || 0)));
}

function getArrayBufferView(arrayBuffer) {
	if (!arrayBuffer || typeof arrayBuffer.byteLength !== 'number') {
		return null;
	}
	return new Uint8Array(arrayBuffer);
}

function readAscii(view, start, length) {
	if (!view || view.length < start + length) {
		return '';
	}
	let result = '';
	for (let index = start; index < start + length; index += 1) {
		result += String.fromCharCode(view[index]);
	}
	return result;
}

function detectAudioFormat({ url = '', contentType = '', arrayBuffer = null } = {}) {
	const normalizedUrl = String(url || '').trim().toLowerCase();
	const normalizedContentType = String(contentType || '').trim().toLowerCase();
	const view = getArrayBufferView(arrayBuffer);

	if (normalizedContentType.includes('audio/wav') || normalizedContentType.includes('audio/x-wav') || normalizedUrl.endsWith('.wav')) {
		return 'wav';
	}
	if (normalizedContentType.includes('audio/mpeg') || normalizedContentType.includes('audio/mp3') || normalizedUrl.endsWith('.mp3')) {
		return 'mp3';
	}
	if (view && readAscii(view, 0, 4) === 'RIFF' && readAscii(view, 8, 4) === 'WAVE') {
		return 'wav';
	}
	if (view && readAscii(view, 0, 3) === 'ID3') {
		return 'mp3';
	}
	if (view && view.length >= 2 && view[0] === 0xff && (view[1] & 0xe0) === 0xe0) {
		return 'mp3';
	}
	return '';
}

function parseWavMetadata(arrayBuffer) {
	const view = getArrayBufferView(arrayBuffer);
	if (!view || view.length < 44) {
		return {};
	}
	if (readAscii(view, 0, 4) !== 'RIFF' || readAscii(view, 8, 4) !== 'WAVE') {
		return {};
	}
	const dataView = new DataView(arrayBuffer);
	const byteRate = Number(dataView.getUint32(28, true) || 0);
	const dataSize = Number(dataView.getUint32(40, true) || Math.max(0, view.length - 44));
	return {
		channels: Number(dataView.getUint16(22, true) || 0),
		sampleRate: Number(dataView.getUint32(24, true) || 0),
		bitsPerSample: Number(dataView.getUint16(34, true) || 0),
		bitrate: byteRate > 0 ? byteRate * 8 : 0,
		byteRate,
		dataSize,
		durationMs: byteRate > 0 ? Math.round((dataSize * 1000) / byteRate) : 0,
	};
}

function readSynchsafeInteger(view, start) {
	if (!view || view.length < start + 4) {
		return 0;
	}
	return ((view[start] & 0x7f) << 21)
		| ((view[start + 1] & 0x7f) << 14)
		| ((view[start + 2] & 0x7f) << 7)
		| (view[start + 3] & 0x7f);
}

function parseMp3FrameHeader(view, offset) {
	if (!view || view.length < offset + 4) {
		return null;
	}
	const b0 = view[offset];
	const b1 = view[offset + 1];
	const b2 = view[offset + 2];
	const b3 = view[offset + 3];
	if (b0 !== 0xff || (b1 & 0xe0) !== 0xe0) {
		return null;
	}

	const versionBits = (b1 >> 3) & 0x03;
	const layerBits = (b1 >> 1) & 0x03;
	const bitrateIndex = (b2 >> 4) & 0x0f;
	const sampleRateIndex = (b2 >> 2) & 0x03;
	const paddingBit = (b2 >> 1) & 0x01;
	const channelMode = (b3 >> 6) & 0x03;

	if (versionBits === 1 || layerBits !== 1 || bitrateIndex === 0 || bitrateIndex === 15 || sampleRateIndex === 3) {
		return null;
	}

	const bitrateTableV1L3 = [0, 32, 40, 48, 56, 64, 80, 96, 112, 128, 160, 192, 224, 256, 320, 0];
	const bitrateTableV2L3 = [0, 8, 16, 24, 32, 40, 48, 56, 64, 80, 96, 112, 128, 144, 160, 0];
	const sampleRateTable = {
		0: [11025, 12000, 8000],
		2: [22050, 24000, 16000],
		3: [44100, 48000, 32000],
	};

	const bitrateKbps = (versionBits === 3 ? bitrateTableV1L3 : bitrateTableV2L3)[bitrateIndex];
	const sampleRate = (sampleRateTable[versionBits] || [])[sampleRateIndex] || 0;
	if (!bitrateKbps || !sampleRate) {
		return null;
	}

	const bitrate = bitrateKbps * 1000;
	const samplesPerFrame = versionBits === 3 ? 1152 : 576;
	const frameLength = Math.floor(((versionBits === 3 ? 144 : 72) * bitrate) / sampleRate) + paddingBit;
	const sideInfoSize = versionBits === 3
		? (channelMode === 3 ? 17 : 32)
		: (channelMode === 3 ? 9 : 17);
	return {
		bitrate,
		sampleRate,
		channels: channelMode === 3 ? 1 : 2,
		versionBits,
		channelMode,
		sideInfoSize,
		samplesPerFrame,
		frameLength,
	};
}

function stripMp3StreamingHeaders(arrayBuffer) {
	const view = getArrayBufferView(arrayBuffer);
	if (!view || view.length < 4) {
		return arrayBuffer;
	}

	let offset = 0;
	if (readAscii(view, 0, 3) === 'ID3') {
		offset = Math.max(0, 10 + readSynchsafeInteger(view, 6));
	}

	while (offset <= view.length - 4) {
		const frameHeader = parseMp3FrameHeader(view, offset);
		if (!frameHeader || !frameHeader.frameLength || offset + frameHeader.frameLength > view.length) {
			break;
		}

		const frameDataOffset = offset + 4 + frameHeader.sideInfoSize;
		if (frameDataOffset + 4 > view.length) {
			break;
		}

		const marker = readAscii(view, frameDataOffset, 4);
		if (marker === 'Xing' || marker === 'Info' || marker === 'LAME') {
			offset += frameHeader.frameLength;
			continue;
		}

		const lameOffset = frameDataOffset + 0x24;
		if (lameOffset + 4 <= view.length && readAscii(view, lameOffset, 4) === 'LAME') {
			offset += frameHeader.frameLength;
			continue;
		}

		break;
	}

	if (offset <= 0) {
		return arrayBuffer;
	}
	if (offset >= view.length) {
		return arrayBuffer.slice(0);
	}
	return arrayBuffer.slice(offset);
}

function parseMp3Metadata(arrayBuffer) {
	const view = getArrayBufferView(arrayBuffer);
	if (!view || view.length < 4) {
		return {};
	}

	let offset = 0;
	if (readAscii(view, 0, 3) === 'ID3') {
		offset = 10 + readSynchsafeInteger(view, 6);
	}

	for (let index = offset; index <= view.length - 4; index += 1) {
		const frameHeader = parseMp3FrameHeader(view, index);
		if (!frameHeader) {
			continue;
		}
		const payloadSize = Math.max(0, view.length - index);
		return {
			sampleRate: frameHeader.sampleRate,
			channels: frameHeader.channels,
			bitrate: frameHeader.bitrate,
			durationMs: frameHeader.bitrate > 0 ? Math.round((payloadSize * 8 * 1000) / frameHeader.bitrate) : 0,
		};
	}

	return {};
}

export default class LiveTalkClient {
	constructor(options = {}) {
		this.onStateChange = options.onStateChange || (() => {});
		this.onError = options.onError || (() => {});
		this.onClose = options.onClose || (() => {});
		this.onRecordReady = options.onRecordReady || (() => {});
		this.recorder = typeof uni.getRecorderManager === 'function' ? uni.getRecorderManager() : null;
		this.recorderBound = false;
		this.socketTask = null;
		this.session = null;
		this.state = 'idle';
		this.socketOpen = false;
		this.recorderStarted = false;
		this.stopping = false;
		this.stopPromise = null;
		this.lastLocalRecord = null;
		this.audioProfile = null;
		this.currentMode = '';
		this.recorderStopPromise = null;
		this.recorderStopResolve = null;
		this.streamReady = false;
		this.pendingBinaryChunks = [];
		this.pendingBinaryBytes = 0;
		this.streamStartedAt = 0;
		this.firstFrameAt = 0;

		if (this.recorder) {
			this.bindRecorderEvents();
		}
	}

	isSocketSupported() {
		return typeof uni.connectSocket === 'function';
	}

	isRecorderSupported() {
		return !!(this.recorder && typeof this.recorder.onFrameRecorded === 'function');
	}

	isSupported() {
		return !!this.recorder && this.isSocketSupported() && this.isRecorderSupported();
	}

	ensureRecordPermission() {
		return new Promise((resolve, reject) => {
			if (typeof uni.authorize !== 'function') {
				resolve();
				return;
			}

			uni.authorize({
				scope: 'scope.record',
				success: () => resolve(),
				fail: (error) => {
					reject(normalizeError(error, '请先开启麦克风权限'));
				},
			});
		});
	}

	setState(state, extra = {}) {
		this.state = state;
		this.onStateChange({
			state,
			mode: extra.mode || this.currentMode,
			...extra,
		});
	}

	bindRecorderEvents() {
		if (!this.recorder || this.recorderBound) {
			return;
		}

		this.recorderBound = true;
		this.recorder.onStart(() => {
			this.recorderStarted = true;
			this.setState('talking', {
				session: this.session,
			});
		});
		this.recorder.onStop((res = {}) => {
			this.recorderStarted = false;
			const audioProfile = this.audioProfile || {};
			this.lastLocalRecord = {
				tempFilePath: res.tempFilePath || '',
				duration: Number(res.duration || 0),
				fileSize: Number(res.fileSize || 0),
				audioFormat: audioProfile.recorderFormat || STREAM_RECORDER_FORMAT,
				codec: audioProfile.codec || STREAM_PAYLOAD_FORMAT,
				playbackSupported: audioProfile.playbackSupported !== false,
				createdAt: Date.now(),
			};
			this.resolveRecorderStop(this.lastLocalRecord);
			this.onRecordReady(this.lastLocalRecord);
		});
		this.recorder.onError((error) => {
			this.resolveRecorderStop(null);
			this.handleError(normalizeError(error, '录音失败'));
		});
		this.recorder.onFrameRecorded((res) => {
			if (!res || !res.frameBuffer) {
				return;
			}
			try {
				if (!this.firstFrameAt) {
					this.firstFrameAt = Date.now();
					if (this.streamStartedAt) {
						console.log('[LiveTalk] first recorder frame latency', this.firstFrameAt - this.streamStartedAt);
					}
				}
				this.sendOrQueueBinaryChunk(res.frameBuffer);
			} catch (error) {
				this.handleError(normalizeError(error, '发送音频分片失败'));
			}
		});
	}

	resetBinaryQueue() {
		this.pendingBinaryChunks = [];
		this.pendingBinaryBytes = 0;
		this.streamReady = false;
		this.streamStartedAt = 0;
		this.firstFrameAt = 0;
	}

	sendOrQueueBinaryChunk(data) {
		if (!data || typeof data.byteLength !== 'number') {
			return;
		}
		if (this.socketOpen && this.socketTask && this.streamReady) {
			this.socketTask.send({
				data,
			});
			return;
		}

		const byteLength = Number(data.byteLength || 0);
		if (byteLength <= 0) {
			return;
		}
		this.pendingBinaryChunks.push(data);
		this.pendingBinaryBytes += byteLength;
		while (this.pendingBinaryChunks.length > STREAM_PENDING_CHUNKS_MAX ||
			this.pendingBinaryBytes > STREAM_PENDING_BYTES_MAX) {
			const dropped = this.pendingBinaryChunks.shift();
			this.pendingBinaryBytes -= Number(dropped && dropped.byteLength ? dropped.byteLength : 0);
		}
	}

	flushPendingBinaryChunks() {
		if (!this.socketOpen || !this.socketTask || !this.streamReady || !this.pendingBinaryChunks.length) {
			return;
		}
		const chunks = this.pendingBinaryChunks;
		this.pendingBinaryChunks = [];
		this.pendingBinaryBytes = 0;
		chunks.forEach((chunk) => {
			if (chunk && typeof chunk.byteLength === 'number' && chunk.byteLength > 0) {
				this.socketTask.send({
					data: chunk,
				});
			}
		});
	}

	createRecorderStopPromise() {
		if (this.recorderStopPromise) {
			return this.recorderStopPromise;
		}
		this.recorderStopPromise = new Promise((resolve) => {
			this.recorderStopResolve = resolve;
		});
		return this.recorderStopPromise;
	}

	resolveRecorderStop(record) {
		if (this.recorderStopResolve) {
			this.recorderStopResolve(record || null);
		}
		this.recorderStopResolve = null;
		this.recorderStopPromise = null;
	}

	waitForRecorderStop(timeoutMs = 1500) {
		if (!this.recorderStarted) {
			return Promise.resolve(this.lastLocalRecord || null);
		}
		const stopPromise = this.createRecorderStopPromise();
		return Promise.race([
			stopPromise,
			new Promise((resolve) => {
				setTimeout(() => resolve(this.lastLocalRecord || null), Math.max(200, Number(timeoutMs) || 1500));
			}),
		]);
	}

	resolveAudioProfile(session = {}) {
		const requestedCodec = String(
			session.app_upload_codec || session.codec || session.format || ''
		).trim().toLowerCase();
		const recorderFormat = STREAM_RECORDER_FORMATS.includes(requestedCodec)
			? requestedCodec
			: STREAM_RECORDER_FORMAT;

		// 默认使用 mp3 保持兼容；后端可返回 app_upload_codec=pcm/aac 来降低实时喊话首帧延迟。
		return {
			recorderFormat,
			payloadFormat: recorderFormat,
			codec: recorderFormat,
			playbackSupported: recorderFormat === STREAM_RECORDER_FORMAT,
			requestedCodec,
			transcodingRequired: recorderFormat !== STREAM_PAYLOAD_FORMAT,
		};
	}

	resolveRemoteAudioProfile(session = {}, source = {}) {
		const format = detectAudioFormat(source);
		if (!format) {
			throw new Error('仅支持 MP3 或 WAV 音频文件');
		}
		const normalizedArrayBuffer = format === 'mp3' ? stripMp3StreamingHeaders(source.arrayBuffer) : source.arrayBuffer;
		const metadata = format === 'wav' ? parseWavMetadata(normalizedArrayBuffer) : parseMp3Metadata(normalizedArrayBuffer);
		const sampleRate = Number(metadata.sampleRate || session.sample_rate || 16000);
		const channels = Number(metadata.channels || session.channels || 1);
		const encodeBitrate = Number(session.encode_bitrate || metadata.bitrate || 64000);
		return {
		audioProfile: {
				recorderFormat: format,
				payloadFormat: format,
				codec: format,
				playbackSupported: false,
				requestedCodec: format,
				transcodingRequired: format !== STREAM_PAYLOAD_FORMAT,
			},
			sampleRate,
			channels,
			encodeBitrate,
			durationMs: Number(metadata.durationMs || 0),
			arrayBuffer: normalizedArrayBuffer,
			metadata,
		};
	}

	async start(session) {
		if (!this.isSupported()) {
			throw new Error('当前环境不支持实时喊话');
		}

		await this.ensureRecordPermission();

		if (this.state !== 'idle') {
			await this.stop('restart');
		}

		this.session = session;
		this.socketOpen = false;
		this.recorderStarted = false;
		this.stopping = false;
		this.lastLocalRecord = null;
		this.audioProfile = this.resolveAudioProfile(session);
		this.currentMode = 'record';
		this.resetBinaryQueue();
		this.setState('connecting', {
			session,
		});

		const connectPromise = this.connectSocket(session.app_ws_url, session);
		this.streamStartedAt = Date.now();
		this.startRecorder(session, this.audioProfile);
		try {
			await connectPromise;
			this.sendJson(this.buildStartPayload(session, this.audioProfile));
			this.streamReady = true;
			this.flushPendingBinaryChunks();
		} catch (error) {
			try {
				if (this.recorderStarted) {
					this.recorder.stop();
				}
			} catch (innerError) {
			}
			throw error;
		}
	}

	buildStartPayload(session = {}, audioProfile = this.audioProfile || this.resolveAudioProfile(session)) {
		const startPayload = {
			type: 'app_talk',
			state: 'start',
			talk_id: session.talk_id,
			sample_rate: session.sample_rate || 16000,
			channels: session.channels || 1,
			encode_bitrate: session.encode_bitrate || 64000,
			...(session.app_start_payload || {}),
			format: audioProfile.payloadFormat,
			codec: audioProfile.codec,
		};

		if (audioProfile.requestedCodec && audioProfile.requestedCodec !== audioProfile.codec) {
			startPayload.source_codec = audioProfile.requestedCodec;
		}

		return startPayload;
	}

	createSessionWithAudioParams(session = {}, overrides = {}) {
		const startPayload = {
			...(session.app_start_payload || {}),
		};
		const sampleRate = Number(overrides.sampleRate || session.sample_rate || 16000);
		const channels = Number(overrides.channels || session.channels || 1);
		const encodeBitrate = Number(overrides.encodeBitrate || session.encode_bitrate || 64000);
		startPayload.sample_rate = sampleRate;
		startPayload.channels = channels;
		startPayload.encode_bitrate = encodeBitrate;
		return {
			...session,
			sample_rate: sampleRate,
			channels,
			encode_bitrate: encodeBitrate,
			app_start_payload: startPayload,
		};
	}

	startRecorder(session, audioProfile = this.audioProfile || this.resolveAudioProfile(session)) {
		const frameSizeKb = Math.max(1, Number(session.frame_size_kb || STREAM_DEFAULT_FRAME_SIZE_KB));
		const options = {
			duration: Math.max(60, Number(session.max_duration_sec || 90)) * 1000,
			sampleRate: Number(session.sample_rate || 16000),
			numberOfChannels: Number(session.channels || 1),
			format: audioProfile.recorderFormat,
			frameSize: frameSizeKb,
			encodeBitRate: Number(session.encode_bitrate || 64000),
		};

		this.setState('starting', {
			session,
		});

		try {
			this.recorder.start(options);
		} catch (error) {
			throw normalizeError(error, '打开麦克风失败');
		}
	}

	buildSocketUrl(url, session = {}) {
		let socketUrl = String(url || '').trim();

		if (!socketUrl) {
			const protocol = String(session.app_ws_protocol || 'wss').trim() || 'wss';
			const host = String(session.app_ws_host || '').trim();
			const port = session.app_ws_port ? `:${Number(session.app_ws_port)}` : '';
			const path = normalizePath(String(session.app_ws_path || '').trim());
			if (host && path) {
				socketUrl = `${protocol}://${host}${port}${path}`;
			}
		}

		if (!socketUrl && session.public_wss_base && session.talk_id) {
			socketUrl = `${String(session.public_wss_base).replace(/\/$/, '')}/ws/horn/live/app/${session.talk_id}`;
		}

		if (!socketUrl) {
			return '';
		}

		const token = String(session.app_ws_token || '').trim();
		if (!token || /([?&])token=/.test(socketUrl)) {
			return socketUrl;
		}

		return `${socketUrl}${socketUrl.includes('?') ? '&' : '?'}token=${encodeURIComponent(token)}`;
	}

	buildSocketHeaders(session = {}) {
		const token = String(session.app_ws_token || '').trim();
		if (!token) {
			return undefined;
		}

		return {
			Authorization: `Bearer ${token}`,
		};
	}

	fetchArrayBuffer(url) {
		return new Promise((resolve, reject) => {
			if (!url) {
				reject(new Error('音频地址不能为空'));
				return;
			}
			if (typeof uni.request !== 'function') {
				reject(new Error('当前环境不支持下载音频文件'));
				return;
			}

			uni.request({
				url,
				method: 'GET',
				responseType: 'arraybuffer',
				success: (res) => {
					if (Number(res.statusCode) !== 200) {
						reject(new Error(`音频下载失败(${res.statusCode || 'unknown'})`));
						return;
					}
					if (!res.data || typeof res.data.byteLength !== 'number') {
						reject(new Error('音频文件内容为空'));
						return;
					}
					const headers = res.header || res.headers || {};
					const contentType = headers['Content-Type'] || headers['content-type'] || '';
					resolve({
						arrayBuffer: res.data,
						fileSize: Number(res.data.byteLength || 0),
						contentType: String(contentType || ''),
					});
				},
				fail: (error) => {
					reject(normalizeError(error, '音频下载失败'));
				},
			});
		});
	}

	readArrayBufferFromFile(filePath) {
		return new Promise((resolve, reject) => {
			if (!filePath) {
				reject(new Error('文件路径不能为空'));
				return;
			}
			if (typeof uni.getFileSystemManager !== 'function') {
				reject(new Error('当前环境不支持读取本地录音文件'));
				return;
			}
			const fileSystemManager = uni.getFileSystemManager();
			if (!fileSystemManager || typeof fileSystemManager.readFile !== 'function') {
				reject(new Error('当前环境不支持读取本地录音文件'));
				return;
			}
			fileSystemManager.readFile({
				filePath,
				success: (res) => {
					if (!res.data || typeof res.data.byteLength !== 'number') {
						reject(new Error('本地录音文件内容为空'));
						return;
					}
					resolve({
						arrayBuffer: res.data,
						fileSize: Number(res.data.byteLength || 0),
					});
				},
				fail: (error) => {
					reject(normalizeError(error, '读取本地录音文件失败'));
				},
			});
		});
	}

	sendBinaryChunk(data) {
		if (!this.socketTask) {
			throw new Error('发送前 WebSocket 尚未建立');
		}
		this.socketTask.send({
			data,
		});
	}

	async sendArrayBufferInChunks(arrayBuffer, options = {}) {
		const chunkSize = Math.max(1024, Number(options.chunkSize || 4096));
		const totalLength = Number(arrayBuffer && arrayBuffer.byteLength ? arrayBuffer.byteLength : 0);
		if (totalLength <= 0) {
			throw new Error('音频文件内容为空');
		}
		const chunkDelayMs = Math.max(0, Number(options.chunkDelayMs || STREAM_DEFAULT_CHUNK_DELAY_MS));

		let offset = 0;
		while (offset < totalLength) {
			const nextOffset = Math.min(totalLength, offset + chunkSize);
			this.sendBinaryChunk(arrayBuffer.slice(offset, nextOffset));
			offset = nextOffset;
			if (offset < totalLength && chunkDelayMs > 0) {
				await delay(chunkDelayMs);
			}
		}
	}

	async streamMp3(session, options = {}) {
		if (!this.isSocketSupported()) {
			throw new Error('当前环境不支持 WebSocket');
		}

		const url = String(options.url || '').trim();
		if (!url) {
			throw new Error('请提供音频文件地址');
		}

		if (this.state !== 'idle') {
			await this.stop('restart');
		}

		try {
			const fileResult = await this.fetchArrayBuffer(url);
			const remoteAudio = this.resolveRemoteAudioProfile(session, {
				url,
				contentType: fileResult.contentType,
				arrayBuffer: fileResult.arrayBuffer,
			});
			const effectiveSession = this.createSessionWithAudioParams(session, {
				sampleRate: remoteAudio.sampleRate,
				channels: remoteAudio.channels,
				encodeBitrate: remoteAudio.encodeBitrate,
			});
			this.session = effectiveSession;
			this.socketOpen = false;
			this.recorderStarted = false;
			this.stopping = false;
			this.lastLocalRecord = null;
			this.audioProfile = remoteAudio.audioProfile;
			this.currentMode = 'mp3';
			this.resetBinaryQueue();
			this.setState('connecting', {
				session: effectiveSession,
				mode: 'mp3',
			});
			await this.connectSocket(effectiveSession.app_ws_url, effectiveSession);
			this.sendJson(this.buildStartPayload(effectiveSession, this.audioProfile));
			this.streamReady = true;
			this.setState('talking', {
				session: effectiveSession,
				mode: 'mp3',
			});
			const uploadArrayBuffer = remoteAudio.arrayBuffer || fileResult.arrayBuffer;
			await this.sendArrayBufferInChunks(uploadArrayBuffer, options);
			this.lastLocalRecord = {
				tempFilePath: '',
				duration: Number(remoteAudio.durationMs || 0),
				fileSize: Number(uploadArrayBuffer.byteLength || fileResult.fileSize || 0),
				audioFormat: this.audioProfile.payloadFormat,
				codec: this.audioProfile.codec,
				playbackSupported: false,
				remoteUrl: url,
				createdAt: Date.now(),
			};
			this.onRecordReady(this.lastLocalRecord);
			return this.lastLocalRecord;
		} catch (error) {
			await this.stop('mp3_failed');
			throw normalizeError(error, 'MP3 推送测试失败');
		}
	}

	async streamFile(session, options = {}) {
		if (!this.isSocketSupported()) {
			throw new Error('当前环境不支持 WebSocket');
		}

		const filePath = String(options.filePath || '').trim();
		if (!filePath) {
			throw new Error('请提供本地录音文件');
		}

		if (this.state !== 'idle') {
			await this.stop('restart');
		}

		this.session = session;
		this.socketOpen = false;
		this.recorderStarted = false;
		this.stopping = false;
		this.lastLocalRecord = null;
		this.audioProfile = this.resolveAudioProfile({
			...session,
			codec: STREAM_PAYLOAD_FORMAT,
			format: STREAM_PAYLOAD_FORMAT,
		});
		this.currentMode = 'record_file';
		this.resetBinaryQueue();
		this.setState('connecting', {
			session,
			mode: 'record_file',
		});

		try {
			await this.connectSocket(session.app_ws_url, session);
			this.sendJson(this.buildStartPayload(session, this.audioProfile));
			this.streamReady = true;
			this.setState('talking', {
				session,
				mode: 'record_file',
			});
			const fileResult = await this.readArrayBufferFromFile(filePath);
			await this.sendArrayBufferInChunks(fileResult.arrayBuffer, {
				...options,
				durationMs: Number(options.duration || 0),
			});
			this.lastLocalRecord = {
				tempFilePath: filePath,
				duration: Number(options.duration || 0),
				fileSize: Number(fileResult.fileSize || 0),
				audioFormat: STREAM_RECORDER_FORMAT,
				codec: STREAM_PAYLOAD_FORMAT,
				playbackSupported: true,
				createdAt: Date.now(),
			};
			this.onRecordReady(this.lastLocalRecord);
			return this.lastLocalRecord;
		} catch (error) {
			await this.stop('record_file_failed');
			throw normalizeError(error, '历史喊话重新推送失败');
		}
	}

	connectSocket(url, session = {}) {
		return new Promise((resolve, reject) => {
			const socketUrl = this.buildSocketUrl(url, session);
			if (!socketUrl) {
				reject(new Error('调度平台 WebSocket 地址为空'));
				return;
			}

			let settled = false;
			const headers = this.buildSocketHeaders(session);
			let socketTask = null;

			try {
				socketTask = uni.connectSocket({
					url: socketUrl,
					header: headers,
					success: () => {},
					fail: (error) => {
						if (!settled) {
							settled = true;
							reject(normalizeError(error, '连接调度平台失败'));
						}
					},
				});
			} catch (error) {
				reject(normalizeError(error, '连接调度平台失败'));
				return;
			}

			if (!socketTask || typeof socketTask.onOpen !== 'function') {
				reject(new Error('调度平台 WebSocket 初始化失败'));
				return;
			}

			this.socketTask = socketTask;
			socketTask.onOpen(() => {
				this.socketOpen = true;
				if (!settled) {
					settled = true;
					resolve();
				}
			});
			socketTask.onError((error) => {
				const normalizedError = normalizeError(error, '实时喊话连接异常');
				if (!settled) {
					settled = true;
					reject(normalizedError);
					return;
				}
				this.handleError(normalizedError);
			});
			socketTask.onClose((event) => {
				this.socketOpen = false;
				this.socketTask = null;
				this.streamReady = false;
				if (!settled) {
					settled = true;
					reject(normalizeError(event, '连接已关闭'));
					return;
				}
				if (this.stopping) {
					this.finishStop();
					return;
				}
				this.onClose(event || {});
			});
			socketTask.onMessage((message) => {
				if (!message || !message.data) {
					return;
				}
				try {
					const parsed = typeof message.data === 'string' ? JSON.parse(message.data) : null;
					if (parsed && parsed.state === 'error') {
						this.handleError(new Error(parsed.msg || '实时喊话失败'));
					}
				} catch (error) {
				}
			});
		});
	}

	sendJson(data) {
		if (!this.socketTask) {
			return;
		}
		this.socketTask.send({
			data: JSON.stringify(data),
		});
	}

	async stop(reason = 'user_stop') {
		if (this.stopPromise) {
			return this.stopPromise;
		}

		if (this.state === 'idle') {
			return Promise.resolve();
		}

		this.stopPromise = new Promise((resolve) => {
			let finalized = false;
			let recorderStopped = Promise.resolve(this.lastLocalRecord || null);
			const finalize = () => {
				if (finalized) {
					return;
				}
				finalized = true;
				Promise.resolve(recorderStopped)
					.catch(() => null)
					.finally(() => {
						this.stopPromise = null;
						resolve();
					});
			};

			this.stopping = true;
			this.setState('stopping', {
				reason,
			});

			try {
				if (this.session) {
					const stopPayload = this.session.app_stop_payload || {
						type: 'app_talk',
						state: 'stop',
						talk_id: this.session.talk_id,
						reason,
					};
					this.sendJson(stopPayload);
				}
			} catch (error) {
			}

			if (this.recorderStarted) {
				recorderStopped = this.waitForRecorderStop();
				try {
					this.recorder.stop();
				} catch (error) {
					this.resolveRecorderStop(this.lastLocalRecord || null);
				}
			}

			if (this.socketTask) {
				setTimeout(() => {
					if (!this.socketTask) {
						finalize();
						return;
					}
					try {
						this.socketTask.close({
							code: 1000,
							reason: 'client_stop',
						});
					} catch (error) {
						this.finishStop();
						finalize();
					}
				}, 120);
				setTimeout(() => {
					if (this.state === 'idle') {
						finalize();
						return;
					}
					this.finishStop();
					finalize();
				}, 800);
				return;
			}

			this.finishStop();
			finalize();
		});

		return this.stopPromise;
	}

	consumeLastRecord() {
		const record = this.lastLocalRecord;
		this.lastLocalRecord = null;
		return record;
	}

	finishStop() {
		this.session = null;
		this.socketTask = null;
		this.socketOpen = false;
		this.recorderStarted = false;
		this.stopping = false;
		this.audioProfile = null;
		this.currentMode = '';
		this.resetBinaryQueue();
		this.resolveRecorderStop(this.lastLocalRecord || null);
		this.setState('idle');
	}

	handleError(error) {
		const normalizedError = normalizeError(error, '实时喊话失败');
		this.onError(normalizedError);
		try {
			if (this.recorderStarted) {
				this.recorder.stop();
			}
		} catch (innerError) {
		}
		try {
			if (this.socketTask) {
				this.socketTask.close({
					code: 1011,
					reason: 'client_error',
				});
			}
		} catch (innerError) {
		}
		this.session = null;
		this.socketTask = null;
		this.socketOpen = false;
		this.recorderStarted = false;
		this.stopping = false;
		this.audioProfile = null;
		this.currentMode = '';
		this.resetBinaryQueue();
		this.resolveRecorderStop(this.lastLocalRecord || null);
		this.setState('idle');
	}
}
