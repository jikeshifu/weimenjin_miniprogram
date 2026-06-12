<template>
	<view>
		<web-view v-if="showWebView && url" :src="url" @message="onMessage"></web-view>
	</view>
</template>

<script>
import { camWebUrl } from '@/config/domain.js';
import { loadRuntimeConfig } from '@/config/runtime.js';

export default {
	data() {
		return {
			url: "",
			showWebView: true,
			options:null
		}
	},
	onLoad(val) {
		this.options = val
		this.setPlaybackUrl()
		this.refreshPlaybackUrl()
	},
	onHide() {
		this.showWebView = false;
	},
	onShow() {
		// 如果需要每次显示都刷新，可在此重新设置 url
		// this.url = `新的url&t=${+new Date()}`
		this.showWebView = true;
	},
	onUnload() {
		this.url = ""
		this.showWebView = false;
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
