<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<block v-if="pageType === 'apply'">
				<view class="top-box">
					<view class="cell-item">
						<view class="label">申请人</view>
						<input placeholder="请输入申请人" placeholder-class="placeholder" v-model="user_name" />
					</view>
					<view class="cell-item">
						<view class="label">备注</view>
						<input placeholder="请输入备注" placeholder-class="placeholder" v-model="aremark" />
					</view>
				</view>
				<view class="bottom-box">
					<view class="bottom-btn" @click="onSubmit">立即申请</view>
				</view>
			</block>

			<block v-if="pageType === 'phone'">
				<view class="bindPhone">
					<button type="primary" class="btn" open-type="getPhoneNumber" @getphonenumber="getphonenumber"
						hover-class="none">绑定手机号</button>
				</view>
			</block>

			<block v-if="pageType === 'succeed'">
				<view class="succeed-box" @click="goPage('/pages/index/index')">
					<view class="succeed-img">
						<image :src="successimg"></image>
					</view>
				</view>
			</block>

		</view>

		<!-- 隐私协议 -->

		<!-- #ifdef MP-WEIXIN -->
		<privacy-popup ref="privacyComponent"></privacy-popup>
		<!-- #endif -->
	</view>

</template>

<script>
	import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue';
	import device from '../../module/device/index.js'
	import lockServer from '../../module/device/lock.js'
	import ble from '../../module/ble/index.js'


	import {
		getQueryString
	} from '../../libs/utils.js';
	import {
		qrOpenLock_api,
		wxXcxMobile_api,
		zfbXcxMobile_api,
		zfb_edit_info,
		applyAuth_api
	} from '../../api/index.js';
	export default {
		components: {
			PrivacyPopup
		},
		data() {
			return {
				pageType: '',
				lock_id: '',
				isQropen: true,
				user_name: '',
				aremark: '',
				successimg: '',
				latitude: '',
				longitude: ''
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			if (option.lock_id) {
				this.lock_id = option.lock_id;
			}
			// #ifdef MP-WEIXIN
			// 扫码带的参数
			if (option.q) {
				let scene = decodeURIComponent(option.q) // 使用decodeURIComponent解析  获取当前二维码的网址
				let paramobj = getQueryString(scene).lock_id
				console.log(getQueryString(scene))
				console.log(paramobj)
				this.lock_id = paramobj
			}
			// #endif

			// #ifdef MP-ALIPAY
			let qrcodeLockId = uni.getStorageSync("qrcodeLockId")
			if (qrcodeLockId) {
				this.lock_id = qrcodeLockId
			}
			// #endif


			console.log('option', option)




			// 从‘我的-绑定手机号进入’
			if (option.type) {
				this.pageType = option.type
				this.isQropen = false
			}

			if (this.pageType === 'phone') {
				uni.setNavigationBarTitle({
					title: '绑定手机号'
				})
				return
			}

			this.getLocation()
		},
		methods: {
			async qrOpenLock() {
				uni.showLoading({
					title: '加载中...'
				})
				let res = await qrOpenLock_api({
					lock_id: this.lock_id,
					latitude: this.latitude,
					longitude: this.longitude
				})
				if (res.code === 0) 
				{
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
					}

					if (res.data.successimg) {
						this.pageType = 'succeed'
						this.successimg = res.data.successimg
					} else {
						this.showToast(res.msg)
						let timer = setTimeout(() => {
							uni.switchTab({
								url: '/pages/index/index'
							})
							clearTimeout(timer)
						}, 3000)
					}
					uni.hideLoading() 
				} 
				else if (res.code === 1001) 
				{
					this.pageType = 'phone'
					uni.hideLoading()
				} else if (res.code === 1002) 
				{
					this.pageType = 'apply'
					uni.hideLoading()
				} else if (res.code === 1003) 
				{
					console.log("DeviceInfo：", res)

					let DeviceInfo = res.data
						console.log("DeviceInfo：", DeviceInfo)
					if (DeviceInfo.lock_sn.indexOf('WMJ62') > -1 || DeviceInfo.lock_sn.indexOf('W76') > -1) {
						let OpenBluetoothAdapterRes = await ble.OpenBluetoothAdapter()

						if (OpenBluetoothAdapterRes.err != null) {
							setTimeout(function() {
								uni.switchTab({
									url: '/pages/index/index'
								})
							}, 3000)
							wx.showToast({
								title: OpenBluetoothAdapterRes.err,
								icon: "none",
								mask: true, // 是否显示透明蒙层，防止触摸穿透
								duration: 2000
							});
							return
						}
						await device.OpenLockBle(DeviceInfo.lock_sn, DeviceInfo.lock_id)
						setTimeout(function() {
							uni.switchTab({
								url: '/pages/index/index'
							})
						}, 3000)
						return
					} else {
						uni.showToast({
							title: '设备不在线！',
							icon: 'none',
						})
					}
				} 
				else {

					this.showToast(res.msg)
					let timer = setTimeout(() => {
						uni.switchTab({
							url: '/pages/index/index'
						})
						clearTimeout(timer)
					}, 3000)
					// this.showToast(res.msg)
					setTimeout(() => {
							uni.hideLoading() 
					}, 3000)
				}
			},
			// 申请钥匙
			async onSubmit() {
				if (!this.user_name) {
					this.showToast('请填写申请人名称')
					return
				}
				uni.showLoading({
					title: '申请中...',
					mask: true
				})
				let res = await applyAuth_api({
					lock_id: this.lock_id,
					aremark: this.aremark,
					user_name: this.user_name
				})
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast(res.msg)
					let timer = setTimeout(() => {
						uni.switchTab({
							url: '/pages/index/index'
						})
						clearTimeout(timer)
					}, 1000)
				} else if (res.code == 1001) {
					this.qrOpenLock()
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			async getphonenumber(e) {
				// #ifdef MP-ALIPAY
				my.getPhoneNumber({
					success: (res) => {
						zfbXcxMobile_api(res.response).then(res1 => {
							if (res1.code == 10000) {
								uni.hideLoading()
								zfb_edit_info({
									mobile: res1.mobile
								}).then(info => {

								})
								if (this.isQropen) {
									this.qrOpenLock()
								} else {
									this.showToast('绑定成功')
									let timer = setTimeout(() => {
										uni.navigateBack({
											delta: 1
										})
										clearTimeout(timer)
									}, 1000)

								}
							} else {
								this.showToast(res1.msg)
								uni.hideLoading()
							}
						})

					}
				})
				// #endif
				// #ifdef MP-WEIXIN
				uni.login({
					provider: 'weixin',
					success: async loginRes => {
						console.log('e', e)
						console.log('loginRes', loginRes)
						if (e.detail.iv && e.detail.encryptedData) {
							uni.showLoading({
								title: '加载中...',
								mask: true
							})
							let res = await wxXcxMobile_api({
								code: e.detail.code
							});
							if (res.code === 0) {
								uni.hideLoading()
								if (this.isQropen) {
									this.qrOpenLock()
								} else {
									this.showToast('绑定成功')
									let timer = setTimeout(() => {
										uni.navigateBack({
											delta: 1
										})
										clearTimeout(timer)
									}, 1000)

								}
							} else {
								this.showToast(res.msg)
								uni.hideLoading()
							}
						}
					},
					fail: err => {
						uni.showToast({
							title: '错误信息：' + err,
							icon: 'none'
						});
					}
				});

				// #endif
			},
			getLocation() {
				// #ifdef MP-ALIPAY
				this.getAddress();
				return;
				// #endif
				let that = this;
				uni.authorize({
					scope: 'scope.userLocation',
					success() {
						that.getAddress()
					},
					fail() {
						uni.showModal({
							content: '设备需要获取您的位置，是否去打开？',
							confirmText: '确认',
							cancelText: '取消',
							success: msg => {
								if (msg.confirm) {
									uni.openSetting({
										success: v => {
											that.getAddress()
										}
									});
								} else {
									uni.switchTab({
										url: '/pages/index/index'
									})
									return false;
								}
							},
							fail: err => {}
						});
						return false;
					}
				});
			},

			// 获取位置信息
			getAddress() {
				uni.getLocation({
					type: 'gcj02',
					success: res => {
						this.latitude = res.latitude
						this.longitude = res.longitude
						this.qrOpenLock()
					},
					fail: err => {
						console.log(err);
						this.qrOpenLock()
					}
				});
			},
			goPage(url) {
				uni.switchTab({
					url: url
				})
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'error',
					duration:4000,
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './open.scss';
</style>