const assert = require('assert');
const fs = require('fs');
const path = require('path');
const vm = require('vm');

function loadLiveTalkClient() {
	const filePath = path.join(__dirname, '..', 'module', 'liveTalk', 'liveTalkClient.js');
	const source = fs.readFileSync(filePath, 'utf8');
	const transformed = source.replace('export default class LiveTalkClient', 'class LiveTalkClient');
	const wrapped = `${transformed}\nmodule.exports = LiveTalkClient;`;
	const script = new vm.Script(wrapped, { filename: filePath });
	const sandbox = {
		module: { exports: {} },
		exports: {},
		require,
		console,
		setTimeout,
		clearTimeout,
		uni: global.uni,
	};
	script.runInNewContext(sandbox);
	return sandbox.module.exports;
}

function createSocketTask(state) {
	return {
		onOpen(handler) {
			state.handlers.open = handler;
		},
		onError(handler) {
			state.handlers.error = handler;
		},
		onClose(handler) {
			state.handlers.close = handler;
		},
		onMessage(handler) {
			state.handlers.message = handler;
		},
		send(payload) {
			state.sent.push(payload);
		},
		close(payload) {
			state.closed.push(payload);
			if (state.handlers.close) {
				state.handlers.close({ code: 1000, reason: 'closed' });
			}
		},
	};
}

function createRecorder(state) {
	return {
		onStart(handler) {
			state.handlers.start = handler;
		},
		onStop(handler) {
			state.handlers.stop = handler;
		},
		onError(handler) {
			state.handlers.error = handler;
		},
		onFrameRecorded(handler) {
			state.handlers.frame = handler;
		},
		start(options) {
			state.starts.push(options);
			if (state.handlers.start) {
				state.handlers.start();
			}
		},
		stop() {
			state.stopCalls += 1;
			const stopResult = state.stopResult || {
				tempFilePath: '/tmp/live-talk.mp3',
				duration: 1200,
				fileSize: 2048,
			};
			const emitStop = () => {
				if (state.handlers.stop) {
					state.handlers.stop(stopResult);
				}
			};
			if (state.stopDelayMs && state.stopDelayMs > 0) {
				setTimeout(emitStop, state.stopDelayMs);
				return;
			}
			emitStop();
		},
	};
}

function createWavBuffer({ sampleRate = 8000, channels = 1, bitsPerSample = 16, dataSize = 1600 } = {}) {
	const headerSize = 44;
	const totalSize = headerSize + dataSize;
	const buffer = new ArrayBuffer(totalSize);
	const view = new DataView(buffer);
	const bytes = new Uint8Array(buffer);
	const writeAscii = (offset, text) => {
		for (let index = 0; index < text.length; index += 1) {
			bytes[offset + index] = text.charCodeAt(index);
		}
	};

	writeAscii(0, 'RIFF');
	view.setUint32(4, totalSize - 8, true);
	writeAscii(8, 'WAVE');
	writeAscii(12, 'fmt ');
	view.setUint32(16, 16, true);
	view.setUint16(20, 1, true);
	view.setUint16(22, channels, true);
	view.setUint32(24, sampleRate, true);
	view.setUint32(28, sampleRate * channels * bitsPerSample / 8, true);
	view.setUint16(32, channels * bitsPerSample / 8, true);
	view.setUint16(34, bitsPerSample, true);
	writeAscii(36, 'data');
	view.setUint32(40, dataSize, true);

	for (let index = headerSize; index < totalSize; index += 1) {
		bytes[index] = index % 255;
	}

	return buffer;
}

function createMp3Buffer({ byteLength = 2500 } = {}) {
	const size = Math.max(4, byteLength);
	const bytes = new Uint8Array(size);
	bytes[0] = 0xff;
	bytes[1] = 0xf3;
	bytes[2] = 0x48;
	bytes[3] = 0xc4;
	for (let index = 4; index < size; index += 1) {
		bytes[index] = index % 255;
	}
	return bytes.buffer;
}

function createTaggedMp3Buffer() {
	const id3Size = 20;
	const firstFrameLength = 144;
	const secondFrameLength = 288;
	const totalSize = id3Size + firstFrameLength + secondFrameLength;
	const bytes = new Uint8Array(totalSize);

	bytes[0] = 0x49;
	bytes[1] = 0x44;
	bytes[2] = 0x33;
	bytes[3] = 0x04;
	bytes[4] = 0x00;
	bytes[5] = 0x00;
	bytes[6] = 0x00;
	bytes[7] = 0x00;
	bytes[8] = 0x00;
	bytes[9] = 0x0a;

	const writeFrame = (offset, marker) => {
		bytes[offset] = 0xff;
		bytes[offset + 1] = 0xf3;
		bytes[offset + 2] = 0x48;
		bytes[offset + 3] = 0xc4;
		if (marker) {
			for (let index = 0; index < marker.length; index += 1) {
				bytes[offset + 13 + index] = marker.charCodeAt(index);
			}
		}
		for (let index = offset + 4; index < offset + firstFrameLength; index += 1) {
			if (bytes[index] === 0) {
				bytes[index] = index % 255;
			}
		}
	};

	writeFrame(id3Size, 'Info');
	writeFrame(id3Size + firstFrameLength, '');
	for (let index = id3Size + firstFrameLength + 4; index < totalSize; index += 1) {
		bytes[index] = (index * 7) % 255;
	}

	return bytes.buffer;
}

async function testPcmSessionFallsBackToMp3Streaming() {
	const recorderState = { handlers: {}, starts: [], stopCalls: 0 };
	const socketState = { handlers: {}, sent: [], closed: [] };

	global.uni = {
		getRecorderManager() {
			return createRecorder(recorderState);
		},
		authorize({ success }) {
			success();
		},
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	await client.start({
		talk_id: 'talk_001',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_001',
		app_ws_token: 'token_001',
		sample_rate: 16000,
		channels: 1,
		codec: 'pcm_s16le',
	});

	assert.strictEqual(recorderState.starts.length, 1, 'recorder should start once');
	assert.strictEqual(recorderState.starts[0].format, 'mp3', 'recorder should use mp3 frame streaming');
	assert.strictEqual(recorderState.starts[0].frameSize, 1, 'frameSize should default to low-latency 1KB chunks');

	assert.strictEqual(socketState.sent.length, 1, 'socket should send a start payload');
	const payload = JSON.parse(socketState.sent[0].data);
	assert.strictEqual(payload.format, 'mp3', 'start payload format should match actual upload format');
	assert.strictEqual(payload.codec, 'mp3', 'start payload codec should match actual upload format');
	assert.strictEqual(payload.source_codec, 'pcm_s16le', 'original requested codec should be retained for debugging');
}

async function testConnectSocketNormalizesErrMsg() {
	const recorderState = { handlers: {}, starts: [], stopCalls: 0 };

	global.uni = {
		getRecorderManager() {
			return createRecorder(recorderState);
		},
		authorize({ success }) {
			success();
		},
		connectSocket({ fail }) {
			process.nextTick(() => {
				fail({ errMsg: 'connectSocket:fail invalid url' });
			});
			return createSocketTask({ handlers: {}, sent: [], closed: [] });
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();

	let thrown = null;
	try {
		await client.start({
			talk_id: 'talk_002',
			app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_002',
		});
	} catch (error) {
		thrown = error;
	}

	assert(thrown, 'start should reject when socket connection fails');
	assert.match(thrown.message, /connectSocket:fail invalid url/, 'error message should preserve errMsg content');
}

async function testFrameSizeHonorsPositiveSessionOverride() {
	const recorderState = { handlers: {}, starts: [], stopCalls: 0 };
	const socketState = { handlers: {}, sent: [], closed: [] };

	global.uni = {
		getRecorderManager() {
			return createRecorder(recorderState);
		},
		authorize({ success }) {
			success();
		},
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	await client.start({
		talk_id: 'talk_004',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_004',
		app_ws_token: 'token_004',
		frame_size_kb: 2,
	});

	assert.strictEqual(recorderState.starts[0].frameSize, 2, 'positive session frame_size_kb should still be honored');
}

async function testStreamMp3UploadsBinaryChunks() {
	const socketState = { handlers: {}, sent: [], closed: [] };
	const mp3Bytes = new Uint8Array(2500);
	for (let index = 0; index < mp3Bytes.length; index += 1) {
		mp3Bytes[index] = index % 255;
	}

	global.uni = {
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
		request({ success }) {
			process.nextTick(() => {
				success({
					statusCode: 200,
					data: mp3Bytes.buffer,
				});
			});
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	const record = await client.streamMp3({
		talk_id: 'talk_003',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_003',
		app_ws_token: 'token_003',
		sample_rate: 16000,
		channels: 1,
	}, {
		url: 'https://example.com/test.mp3',
		chunkSize: 4,
		chunkDelayMs: 0,
	});

	assert.strictEqual(socketState.sent.length, 4, 'socket should send one start payload and three binary chunks');
	const startPayload = JSON.parse(socketState.sent[0].data);
	assert.strictEqual(startPayload.state, 'start', 'first payload should be start control');
	assert.strictEqual(startPayload.format, 'mp3', 'MP3 test should declare mp3 payload format');
	assert(socketState.sent.slice(1).every((payload) => payload.data instanceof ArrayBuffer), 'binary frames should be sent as ArrayBuffer chunks');
	assert.strictEqual(record.codec, 'mp3', 'record codec should track uploaded mp3');
	assert.strictEqual(record.playbackSupported, false, 'remote MP3 test records should be marked non-playable locally');
	assert.strictEqual(record.fileSize, mp3Bytes.byteLength, 'record should retain downloaded MP3 size');
	const consumed = client.consumeLastRecord();
	assert.strictEqual(consumed.remoteUrl, 'https://example.com/test.mp3', 'record should preserve source URL for debugging');
}

async function testStreamWavUsesDetectedWavPayload() {
	const socketState = { handlers: {}, sent: [], closed: [] };
	const wavBuffer = createWavBuffer({ sampleRate: 8000, channels: 1, dataSize: 1500 });

	global.uni = {
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
		request({ success }) {
			process.nextTick(() => {
				success({
					statusCode: 200,
					header: {
						'content-type': 'audio/wav',
					},
					data: wavBuffer,
				});
			});
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	const record = await client.streamMp3({
		talk_id: 'talk_003_wav',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_003_wav',
		app_ws_token: 'token_003_wav',
		sample_rate: 16000,
		channels: 1,
	}, {
		url: 'https://example.com/test.wav',
		chunkSize: 1024,
		chunkDelayMs: 0,
	});

	const startPayload = JSON.parse(socketState.sent[0].data);
	assert.strictEqual(startPayload.format, 'wav', 'WAV file should declare wav payload format');
	assert.strictEqual(startPayload.codec, 'wav', 'WAV file should declare wav codec');
	assert.strictEqual(startPayload.sample_rate, 8000, 'WAV sample rate should be parsed from header');
	assert.strictEqual(startPayload.channels, 1, 'WAV channel count should be parsed from header');
	assert.strictEqual(record.codec, 'wav', 'record codec should track detected wav upload');
	assert.strictEqual(record.duration, 94, 'WAV duration should be parsed from header for paced upload and stop timing');
}

async function testStreamMp3UsesDetectedBitrateInStartPayload() {
	const socketState = { handlers: {}, sent: [], closed: [] };
	const mp3Buffer = createMp3Buffer({ byteLength: 8640 });

	global.uni = {
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
		request({ success }) {
			process.nextTick(() => {
				success({
					statusCode: 200,
					header: {
						'content-type': 'audio/mpeg',
					},
					data: mp3Buffer,
				});
			});
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	await client.streamMp3({
		talk_id: 'talk_003_mp3_bitrate',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_003_mp3_bitrate',
		app_ws_token: 'token_003_mp3_bitrate',
		sample_rate: 16000,
		channels: 1,
		encode_bitrate: 64000,
		app_start_payload: {
			encode_bitrate: 64000,
		},
	}, {
		url: 'https://example.com/welcome.mp3',
		chunkSize: 1024,
		chunkDelayMs: 0,
	});

	const startPayload = JSON.parse(socketState.sent[0].data);
	assert.strictEqual(startPayload.sample_rate, 16000, 'MP3 sample rate should be parsed from frame header');
	assert.strictEqual(startPayload.channels, 1, 'MP3 channels should be parsed from frame header');
	assert.strictEqual(startPayload.encode_bitrate, 64000, 'MP3 remote push should keep the session bitrate aligned with local recording resend');
}

async function testStreamMp3StripsTaggedHeadersBeforeUpload() {
	const socketState = { handlers: {}, sent: [], closed: [] };
	const taggedMp3Buffer = createTaggedMp3Buffer();

	global.uni = {
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
		request({ success }) {
			process.nextTick(() => {
				success({
					statusCode: 200,
					header: {
						'content-type': 'audio/mpeg',
					},
					data: taggedMp3Buffer,
				});
			});
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	const record = await client.streamMp3({
		talk_id: 'talk_003_mp3_strip',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_003_mp3_strip',
		app_ws_token: 'token_003_mp3_strip',
		sample_rate: 16000,
		channels: 1,
	}, {
		url: 'https://example.com/tagged.mp3',
		chunkSize: 1024,
		chunkDelayMs: 0,
	});

	const uploadedBuffer = socketState.sent[1].data;
	const uploadedView = new Uint8Array(uploadedBuffer);
	assert.strictEqual(uploadedView[0], 0xff, 'uploaded mp3 should start from a real frame header after stripping tags');
	assert.strictEqual(uploadedView[1], 0xf3, 'uploaded mp3 should preserve the actual audio frame sync');
	assert(record.fileSize < taggedMp3Buffer.byteLength, 'record size should reflect stripped MP3 payload size');
}

async function testStopWaitsForRecorderOnStop() {
	const recorderState = {
		handlers: {},
		starts: [],
		stopCalls: 0,
		stopDelayMs: 30,
		stopResult: {
			tempFilePath: '/tmp/delayed-live-talk.mp3',
			duration: 1800,
			fileSize: 4096,
		},
	};
	const socketState = { handlers: {}, sent: [], closed: [] };

	global.uni = {
		getRecorderManager() {
			return createRecorder(recorderState);
		},
		authorize({ success }) {
			success();
		},
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	await client.start({
		talk_id: 'talk_005',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_005',
		app_ws_token: 'token_005',
	});
	await client.stop('tap_stop');

	const record = client.consumeLastRecord();
	assert(record, 'stop should wait until recorder onStop produces a record');
	assert.strictEqual(record.tempFilePath, '/tmp/delayed-live-talk.mp3', 'delayed recorder result should be preserved');
}

async function testStreamFileUploadsLocalRecording() {
	const socketState = { handlers: {}, sent: [], closed: [] };
	const fileBytes = new Uint8Array(1800);
	for (let index = 0; index < fileBytes.length; index += 1) {
		fileBytes[index] = (index * 3) % 255;
	}

	global.uni = {
		connectSocket() {
			const socketTask = createSocketTask(socketState);
			process.nextTick(() => {
				socketState.handlers.open && socketState.handlers.open({});
			});
			return socketTask;
		},
		getFileSystemManager() {
			return {
				readFile({ success }) {
					process.nextTick(() => {
						success({
							data: fileBytes.buffer,
						});
					});
				},
			};
		},
	};

	const LiveTalkClient = loadLiveTalkClient();
	const client = new LiveTalkClient();
	const record = await client.streamFile({
		talk_id: 'talk_006',
		app_ws_url: 'wss://dispatch.example.com/ws/horn/live/app/talk_006',
		app_ws_token: 'token_006',
	}, {
		filePath: '/tmp/history-live-talk.mp3',
		chunkSize: 1024,
		chunkDelayMs: 0,
	});

	assert.strictEqual(socketState.sent.length, 3, 'local file resend should send one start payload and two binary chunks');
	assert.strictEqual(record.tempFilePath, '/tmp/history-live-talk.mp3', 'record should preserve local file path');
	assert.strictEqual(record.playbackSupported, true, 'local recording resend should remain locally playable');
}

async function main() {
	await testPcmSessionFallsBackToMp3Streaming();
	await testConnectSocketNormalizesErrMsg();
	await testFrameSizeHonorsPositiveSessionOverride();
	await testStreamMp3UploadsBinaryChunks();
	await testStreamWavUsesDetectedWavPayload();
	await testStreamMp3UsesDetectedBitrateInStartPayload();
	await testStreamMp3StripsTaggedHeadersBeforeUpload();
	await testStopWaitsForRecorderOnStop();
	await testStreamFileUploadsLocalRecording();
	console.log('liveTalkClient tests passed');
}

main().catch((error) => {
	console.error(error);
	process.exitCode = 1;
});
