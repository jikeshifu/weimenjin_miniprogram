<template>
	<view>
		<web-view v-if="showWebView" :src="url" @message="onMessage"></web-view>
	</view>
</template>

<script>
import { camWebUrl } from '@/config/domain.js';

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
		this.$nextTick(() => {
			const userInfo = uni.getStorageSync("USERINFO") || {};
			this.url = camWebUrl('/playback', {
				device_sn: this.options.device_sn,
				member_id: this.options.member_id || userInfo.member_id || '',
				t: +new Date()
			});
		})
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
	}

}
</script>
