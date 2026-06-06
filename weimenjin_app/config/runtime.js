import { apiUrl, assetUrl } from '@/config/domain.js';

const defaults = {
	miniapp: {},
	live_talk: {
		enabled: false,
		app_ws_protocol: 'wss',
		app_ws_host: '',
		app_ws_port: '',
		app_ws_path_prefix: '/ws/horn/live/app',
		public_wss_base: '',
		sample_rate: 16000,
		channels: 1,
		encode_bitrate: 64000,
		frame_size_kb: 1,
		chunk_delay_ms: 40,
		max_duration_sec: 90,
		app_upload_codec: 'mp3',
		default_audio_url: assetUrl('/audio/wmj.mp3'),
	},
};

let cachedConfig = null;
let loadingPromise = null;

function normalizeRuntimeConfig(data = {}) {
	const liveTalk = data.live_talk && typeof data.live_talk === 'object' ? data.live_talk : {};
	return {
		miniapp: data.miniapp && typeof data.miniapp === 'object' ? data.miniapp : {},
		live_talk: {
			...defaults.live_talk,
			...liveTalk,
			enabled: liveTalk.enabled === true || liveTalk.enabled === 1 || liveTalk.enabled === '1',
			sample_rate: Number(liveTalk.sample_rate || defaults.live_talk.sample_rate),
			channels: Number(liveTalk.channels || defaults.live_talk.channels),
			encode_bitrate: Number(liveTalk.encode_bitrate || defaults.live_talk.encode_bitrate),
			frame_size_kb: Number(liveTalk.frame_size_kb || defaults.live_talk.frame_size_kb),
			chunk_delay_ms: Number(liveTalk.chunk_delay_ms || defaults.live_talk.chunk_delay_ms),
			max_duration_sec: Number(liveTalk.max_duration_sec || defaults.live_talk.max_duration_sec),
		},
	};
}

function requestRuntimeConfig() {
	return new Promise((resolve, reject) => {
		uni.request({
			url: `${apiUrl}/AppConfig/runtime`,
			method: 'GET',
			header: {
				'content-type': 'application/json',
			},
			success: (res) => {
				if (Number(res.statusCode) !== 200) {
					reject(new Error(`runtime config status ${res.statusCode || 'unknown'}`));
					return;
				}
				const body = res.data || {};
				const ok = Number(body.code) === 0 || String(body.status) === '200';
				if (!ok) {
					reject(new Error(body.msg || 'runtime config failed'));
					return;
				}
				resolve(normalizeRuntimeConfig(body.data || {}));
			},
			fail: (error) => {
				reject(error);
			},
		});
	});
}

export function getRuntimeConfig() {
	return cachedConfig || defaults;
}

export async function loadRuntimeConfig(force = false) {
	if (cachedConfig && !force) {
		return cachedConfig;
	}
	if (loadingPromise && !force) {
		return loadingPromise;
	}
	loadingPromise = requestRuntimeConfig()
		.then((config) => {
			cachedConfig = config;
			return config;
		})
		.catch((error) => {
			console.warn('load runtime config failed', error);
			cachedConfig = cachedConfig || defaults;
			return cachedConfig;
		})
		.finally(() => {
			loadingPromise = null;
		});
	return loadingPromise;
}

export function buildLiveTalkSession(session = {}, runtimeConfig = getRuntimeConfig()) {
	const liveTalk = runtimeConfig.live_talk || {};
	const talkId = session.talk_id || '';
	const pathPrefix = String(liveTalk.app_ws_path_prefix || '/ws/horn/live/app').replace(/\/$/, '');
	const appWsPath = session.app_ws_path || (talkId ? `${pathPrefix}/${talkId}` : pathPrefix);
	return {
		...session,
		public_wss_base: session.public_wss_base || liveTalk.public_wss_base || '',
		app_ws_protocol: session.app_ws_protocol || liveTalk.app_ws_protocol || 'wss',
		app_ws_host: session.app_ws_host || liveTalk.app_ws_host || '',
		app_ws_port: session.app_ws_port || liveTalk.app_ws_port || '',
		app_ws_path: appWsPath,
		sample_rate: Number(session.sample_rate || liveTalk.sample_rate || defaults.live_talk.sample_rate),
		channels: Number(session.channels || liveTalk.channels || defaults.live_talk.channels),
		encode_bitrate: Number(session.encode_bitrate || liveTalk.encode_bitrate || defaults.live_talk.encode_bitrate),
		frame_size_kb: Number(session.frame_size_kb || liveTalk.frame_size_kb || defaults.live_talk.frame_size_kb),
		max_duration_sec: Number(session.max_duration_sec || liveTalk.max_duration_sec || defaults.live_talk.max_duration_sec),
		app_upload_codec: session.app_upload_codec || liveTalk.app_upload_codec || defaults.live_talk.app_upload_codec,
	};
}
