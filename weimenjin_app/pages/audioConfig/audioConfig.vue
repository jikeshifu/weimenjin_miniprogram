<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">播放内容</view>
						<input placeholder="请输入播放内容" placeholder-class="placeholder" v-model="tts" />
					</view>
				</view>
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">播放音量</view>
						<input placeholder="请输入播放音量1-7" type="number" placeholder-class="placeholder"
							v-model="volume" />
					</view>
				</view>

				<view class="play-btn" @click="playhorn">设置</view>

			</view>
		</view>

	</view>
</template>

<script>
	import {

		audioConfig,
		audioConfigSet,

	} from '../../api/index.js'
	export default {
		data() {
			return {
				lock_id: '',

				volume: 5, // 音量大小
				tts: '门已打开', //播放内容
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		async onLoad(option) {
			this.lock_id = option.lock_id
			let location = uni.getStorageSync('location')
			this.longitude = location.longitude
			this.latitude = location.latitude

			let audioConfigRes = await audioConfig({
				"lock_id": this.lock_id
			})
			this.tts = audioConfigRes.data.openttscontent
			this.volume = audioConfigRes.data.volume
		},
		methods: {

			// 立即播放
			async playhorn() {
				if (!this.tts) {
					uni.showToast({
						title: '请输入播放内容',
						icon: 'none',
					})
					return
				}
				if (!this.volume) {
					uni.showToast({
						title: '请输入播放音量',
						icon: 'none',
					})
					return
				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await audioConfigSet({
					lock_id: this.lock_id,
					volume: this.volume,
					tts: this.tts,

				})
				if (res.code === 0) {
					uni.showToast({
						title: '设置成功',
						icon: 'none',
					})
					// this.tts = ''
				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			scanCode() {
				uni.scanCode({
					success: (res) => {
						this.lock_sn = res.result
					}
				});
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './audioConfig.scss';
</style>
