<template>
	<view class="big-box">
		<view class="background"></view>
	</view>
</template>

<script>
	import {
		getShareAuth_api
	} from '../../api/index.js'
	export default {
		data() {
			return {
				share_lockauth_id: ''
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			if (option.share_lockauth_id) {
				this.share_lockauth_id = option.share_lockauth_id
				this.getShareAuth()
			}
		},
		methods: {
			// 领取钥匙
			async getShareAuth() {
				uni.showLoading({
					title: '领取钥匙中...',
					mask: true
				})
				let res = await getShareAuth_api({
					share_lockauth_id: this.share_lockauth_id
				})
				if (res.code === 0) {
					uni.hideLoading()
					uni.showToast({
						title: '领取成功',
						icon: 'none'
					})
					setTimeout(() => {
						uni.switchTab({
							url: '/pages/index/index'
						})
					}, 800)
				} else {
					uni.hideLoading()
					uni.showToast({
						title: res.msg,
						icon: 'none'
					})
					setTimeout(() => {
						uni.switchTab({
							url: '/pages/index/index'
						})
					}, 800)

				}
			},
		}
	}
</script>

<style scoped>
	.background {
		width: 100%;
		height: 352rpx;
		background: rgb(33, 207, 62);
		opacity: 0.2;
		box-shadow: 0px 8rpx 374rpx rgb(58, 137, 254);
		filter: blur(120rpx);
		position: absolute;
		top: 0;
		left: 0;
	}
</style>