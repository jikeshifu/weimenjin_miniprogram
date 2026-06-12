<template>
	<view>
		<web-view v-if="url" :src="url" @message="onMessage"></web-view>
	</view>
</template>

<script>
import { camWebUrl } from '@/config/domain.js';
import { loadRuntimeConfig } from '@/config/runtime.js';

export default {
	data() {
		return {
			url: "",
			options:null
		}
	},
	onLoad(val) {
		this.options = val
		this.setPlaybackUrl()
		this.refreshPlaybackUrl()
	},
	onHide() {
	},
	onShow() {
	},
	onUnload() {
		this.url = ""
	},
	onMessage(event) {
	},
	methods: {
		setPlaybackUrl(camwebUrl = '') {
			const userInfo = uni.getStorageSync("USERINFO") || {};
			this.url = camWebUrl('/playback', {
				device_sn: this.options.device_sn,
				member_id: this.options.member_id || userInfo.member_id || '',
				t: +new Date()
			}, camwebUrl);
			console.info('camera playback webview url', this.url);
		},
		async refreshPlaybackUrl() {
			const runtimeConfig = await loadRuntimeConfig();
			const miniapp = runtimeConfig.miniapp || {};
			if (miniapp.camweb_url) {
				this.setPlaybackUrl(miniapp.camweb_url);
			}
		}
	}

}
</script>
