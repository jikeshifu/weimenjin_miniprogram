<template>
	<view class="camera-page">
		<web-view
			v-if="showWebView"
			:src="url"
			@message="onMessage"
		></web-view>
	</view>
</template>

<script>
import { camWebUrl } from '@/config/domain.js';

export default {
	data() {
		return {
			url: "",
			showWebView: true,
			options: null,
			deviceName: '摄像头'
		}
	},
	onLoad(val) {
		this.options = val
		this.deviceName = val.device_name ? decodeURIComponent(val.device_name) : (val.device_sn || '摄像头')
		uni.setNavigationBarTitle({
			title: this.deviceName
		})
		this.$nextTick(() => {
			const userInfo = uni.getStorageSync("USERINFO") || {};
			const memberId = this.options.member_id || userInfo.member_id || '';
			if (!memberId) {
				uni.showToast({
					title: '缺少用户授权信息，请重新登录后再试',
					icon: 'none'
				})
				this.showWebView = false;
				return;
			}
			this.url = camWebUrl('/', {
				device_sn: this.options.device_sn,
				member_id: memberId,
				t: +new Date()
			});
		})
	},
	onHide() {
		this.showWebView = false;
	},
	onShow() {
		this.showWebView = true;
	},
	onUnload() {
		this.url = ""
		this.showWebView = false;
	},
	onMessage(event) {
	},
	methods: {
		goBack() {
			uni.navigateBack({
				delta: 1,
				fail: () => {
					uni.switchTab({
						url: '/pages/index/index'
					})
				}
			})
		}
	}
}
</script>

<style scoped lang="scss">
.camera-page {
	min-height: 100vh;
	background: #f5f7fa;
}
</style>
