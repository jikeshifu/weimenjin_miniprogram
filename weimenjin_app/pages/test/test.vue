<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<image src="../../static/sousuo.png"></image>
						<input placeholder="请输入关键词/或扫一扫" placeholder-class="placeholder" v-model="lock_sn" />
					</view>
					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>

				<view class="btn-box">
					<view :class="['btn', clickLock ? 'btn-off' : '']" @click="unlocking">
						<i class="iconfont icon-yuechi icon-default"></i>
						<view class="text">开锁</view>
					</view>


					<view :class="['btn', clickSwitch ? 'btn-off' : '']" @click="onSwitch">
						<i class="iconfont icon-shandian icon-default"></i>
						<view class="text">开关</view>
					</view>
				</view>

				<view class="cell-item">
					<view class="flex-box">
						<view class="label">播放内容</view>
						<input placeholder="请输入播放内容" placeholder-class="placeholder" v-model="tts" />
					</view>
				</view>
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">播放音量</view>
						<input placeholder="请输入播放音量" type="number" placeholder-class="placeholder" v-model="volume"/>
					</view>
				</view>

				<view class="play-btn" @click="playhorn">立即播放</view>
<view class="btn-box">
					<view :class="['btn',]" @click="binding">

						<view class="text">绑定</view>
					</view>


					<view :class="['btn', ]" @click="Unbinding">

						<view class="text">解绑</view>
					</view>
				</view>
			</view>
		</view>

	</view>
</template>

<script>
	import {
		openLockApiTest,
		turnOnApiTest,
		turnOffApiTest,
		playHornApiTest,
		bindingApiTest,
		UnbindingApiTest
	} from '../../api/index.js'
	export default {
		data() {
			return {
				lock_sn: '',
				clickLock: false,
				clickSwitch: false,
				longitude: '',
				latitude: '',
				volume: 5, // 音量大小
				tts: '', //播放内容
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			let location = uni.getStorageSync('location')
			this.longitude = location.longitude
			this.latitude = location.latitude
		},
		methods: {
			// 开锁
			async unlocking() {
				if (!this.lock_sn) {
					this.showToast('请填入设备序列号！')
					return
				}
				this.clickLock = true
				uni.showLoading({
					title: '开锁中...',
					mask: true
				})
				let res = await openLockApiTest({
					lock_sn: this.lock_sn,
					longitude: this.longitude,
					latitude: this.latitude
				})
				uni.hideLoading()
				if (res.code === 0) {
					uni.showToast({
						title: res.msg,
					})
				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none'
					})
				}
				this.clickLock = false
			},
			// 绑定
			async binding() {
				if (!this.lock_sn) {
					this.showToast('请填入设备序列号！')
					return
				}
	
				uni.showLoading({
					title: '绑定中...',
					mask: true
				})


				let res = await bindingApiTest({
					lock_sn: this.lock_sn,

				})
				uni.hideLoading()
				if (res.code === 0) {
					uni.showToast({
						title: res.msg,
					})
				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none'
					})
				}
	
			},
// 解绑
			async Unbinding() {
				if (!this.lock_sn) {
					this.showToast('请填入设备序列号！')
					return
				}
	
				uni.showLoading({
					title: '解绑中...',
					mask: true
				})
				let res = await UnbindingApiTest({
					lock_sn: this.lock_sn,

				})
				uni.hideLoading()
				if (res.code === 0) {
					uni.showToast({
						title: res.msg,
					})
				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none'
					})
				}
	
			},
			// 开关动作
			onSwitch() {
				uni.showActionSheet({
					itemList: ['开', '关'],
					success: async (msg) => {
						this.clickSwitch = true
						uni.showLoading({
							title: '加载中...',
							mask: true
						})
						if (msg.tapIndex === 0) {
							let res = await turnOnApiTest({
								lock_sn: this.lock_sn,
								longitude: this.longitude,
								latitude: this.latitude
							})
							uni.hideLoading()
							if (res.code === 0) {
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}
							this.clickSwitch = false
						} else {
							let res = await turnOffApiTest({
								lock_sn: this.lock_sn,
								longitude: this.longitude,
								latitude: this.latitude
							})
							uni.hideLoading()
							if (res.code === 0) {
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}
							this.clickSwitch = false
						}
					},
				});
			},

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
				let res = await playHornApiTest({
					lock_sn: this.lock_sn,
					volume: this.volume,
					tts: this.tts,
					longitude: this.longitude,
					latitude: this.latitude
				})
				if (res.code === 0) {
					uni.showToast({
						title: '播放成功',
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
	@import './test.scss';
</style>
