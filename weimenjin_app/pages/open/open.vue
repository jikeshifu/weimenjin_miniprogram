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
	import {
		OpenLockBle
	} from '../../module/device/index.js'
	import lockServer from '../../module/device/lock.js'
	import ble from '../../module/ble/index.js'


	import {
		getQueryString
	} from '../../libs/utils.js';
	import {
		qrOpenLock_api,
		wxXcxMobile_api,
		zfbXcxMobile_api,
		toutiaoXcxMobile_api,
		zfb_edit_info,
		tt_edit_info,
		adlog_api,
		applyAuth_api,
		adUnitId_api
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
				longitude: '',
				isLogin: false,
				videoAd: null,
				adShowCount: 0, // 初始化广告显示计数器
				adUnitId: '', // 用于存储从后台获取的 adUnitId
				defaultAdUnitId: 'adunit-9e867d2c8cf7f169', // 本地默认广告ID
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			console.log("Page Open: ", option);
			//处理通过普通链接传递的参数 lock_id
			if (option.lock_id) {
				this.lock_id = option.lock_id;
				console.log("this.lock_id: ", this.lock_id);
			}
			// 页面加载时，先获取广告ID
			// #ifdef MP-WEIXIN
			this.fetchAdUnitId().then(() => {
				this.initVideoAd();
			});
			// 扫码带的参数
			if (option.q) {
				let scene = decodeURIComponent(option.q) // 使用decodeURIComponent解析  获取当前二维码的网址
				let paramobj = getQueryString(scene).lock_id
				this.lock_id = paramobj
			}
			// #endif
			// 支付宝小程序从缓存中读取二维码参数
			// #ifdef MP-ALIPAY
			let qrcodeLockId = uni.getStorageSync("qrcodeLockId")
			if (qrcodeLockId) {
				this.lock_id = qrcodeLockId
			}
			// #endif
			//console.log('option', option)
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
			// 抖音小程序登录
			// #ifdef MP-TOUTIAO
			// 抖音小程序扫码传递参数处理
			if (option.q) {
				// 解析 query.q 中的动态参数（二维码信息）
				let dynamicParams = JSON.parse(decodeURIComponent(option.q));
				if (dynamicParams.lock_id) {
					this.lock_id = dynamicParams.lock_id; // 设置 lock_id
					console.log("tt qrcode param: ", dynamicParams);
				}
				// 获取扫码传递的完整URL
				if (option.url) {
					console.log("All URL: ", option.url);
				}
				// 打印扫码时间
				if (option.scancode_time) {
					console.log("Scan time: ", option.scancode_time);
				}
			}
			tt.checkSession({
				success: () => {
					this.isLogin = true
				},
			});
			// #endif
			// #ifdef APP-PLUS
			console.log('APP-PLUS');
			const platform = uni.getSystemInfoSync().platform;
			if (platform === 'ios' || platform === 'android') {
				// 跳转到登录页面
				console.log('iOS or Android');
				this.lock_id = option.lock_id; // 设置 lock_id
				console.log("APP-PLUS_option.lock_id: ", option.lock_id);
			}
			// #endif
			this.getLocation()
		},
		mounted() {
			// 如果本地存储中有值，则使用该值，否则使用默认值
			// #ifdef MP-WEIXIN
			let lastDate = wx.getStorageSync('lastUseDate');
			let today = new Date().toLocaleDateString('zh-CN', {
				timeZone: 'Asia/Shanghai',
				year: 'numeric',
				month: '2-digit',
				day: '2-digit'
			}).replace(/\//g, '-'); // 获取当前日期，格式为 YYYY-MM-DD
			if (lastDate !== today) {
				this.adShowCount = 0; // 如果不是同一天，则重置广告显示计数器
				wx.setStorageSync('adShowCount', this.adShowCount); // 更新本地存储中的计数
			} else {
				this.adShowCount = wx.getStorageSync('adShowCount') || 0; // 如果是同一天，从本地存储恢复计数
			}
			wx.setStorageSync('lastUseDate', today); // 更新存储的日期
			// #endif
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
				uni.hideLoading()
				if (res.code === 0) {
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
						console.log("OpenLockMp3：")
					}
					if (res.data.successimg) {
						this.pageType = 'succeed'
						this.successimg = res.data.successimg
					}
					uni.showToast({
						title: res.msg,
						duration: 8000
					})
					// #ifdef MP-WEIXIN
					console.log("res.data：", res.data)
					//this.showAd()
					if (res.data.qrshowminiad === 1 && this.adShowCount < 3) {
						setTimeout(() => {
							this.showAd()
						}, 1000) // 延迟2秒执行showAd
					}
					// #endif
				} else if (res.code === 1001) {
					this.pageType = 'phone'
					uni.hideLoading()
				} else if (res.code === 1002) {
					this.pageType = 'apply'
					uni.hideLoading()
				} else if (res.code === 1004) {
					this.pageType = 'toutiao'
					uni.hideLoading()
				} else if (res.code === 1003) {
					//console.log("DeviceInfo：", res)

					let DeviceInfo = res.data
					//console.log("DeviceInfo：", DeviceInfo)
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
						await OpenLockBle(DeviceInfo.lock_sn, DeviceInfo.lock_id)
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
				} else {

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
			async fetchAdUnitId() {
				try {
					const res = await adUnitId_api(); // 假设你已经有一个API可以获取广告ID
					if (res.code === 0 && res.adUnitId) {
						this.adUnitId = res.adUnitId; // 使用后台获取的广告ID
						console.log('获取广告ID成功,', this.adUnitId);
					} else {
						this.adUnitId = this.defaultAdUnitId; // 后台返回失败或无广告ID时使用本地默认值
						console.error('获取广告ID失败，使用本地默认ID');
					}
				} catch (error) {
					this.adUnitId = this.defaultAdUnitId; // 请求失败时使用本地默认广告ID
					console.error('API请求失败，使用本地默认广告ID', error);
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
					}, 10000)
				} else if (res.code == 1001) {
					this.qrOpenLock()
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			async getphonenumber(e) {
				// #ifdef MP-TOUTIAO
				if (this.isLogin) {
					if (e.detail.errMsg.slice(-2) === "ok") {
						// 处理加密手机号数据
						console.log("获取手机号的加密数据成功: ", e);

						// 提取加密数据和iv
						const encryptedData = e.detail.encryptedData;
						const iv = e.detail.iv;

						// 显示加载中
						uni.showLoading({
							title: '处理中...'
						});

						// 调用 toutiaoXcxMobile_api 发送加密数据到后端
						toutiaoXcxMobile_api({
							encryptedData,
							iv
						}).then(res1 => {
							if (res1.code === 10000) {
								uni.hideLoading();

								// 更新手机号信息
								tt_edit_info({
									mobile: res1.data.phoneNumber
								}).then(info => {
									// 可在此处处理成功后的操作
								});

								// 判断是否扫码开锁
								if (this.isQropen) {
									this.qrOpenLock();
								} else {
									this.showToast('绑定成功');
									let timer = setTimeout(() => {
										uni.navigateBack({
											delta: 1
										});
										clearTimeout(timer);
									}, 1000);
								}
							} else {
								this.showToast(res1.msg);
								uni.hideLoading();
							}
						}).catch(err => {
							// 错误处理
							console.error("API 请求失败: ", err);
							this.showToast('请求失败，请重试');
							uni.hideLoading();
						});

					} else {
						console.log("获取手机号的加密数据失败: ", e);
						tt.showToast({
							title: "获取手机号失败",
							icon: "none",
						});
					}
				} else {
					tt.showToast({
						title: "请先登录",
						icon: "none",
					});
				}
				// #endif
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
						//console.log('e', e)
						//console.log('loginRes', loginRes)
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
			    let that = this;
			    console.log("getLocation");
			
			    // 支付宝小程序专属处理
			    //#ifdef MP-ALIPAY
			    this.getAddress(); // 假设getAddress是获取地理位置信息的方法
			    return;
			    //#endif
			
			    // 通用授权逻辑：微信小程序、抖音小程序、iOS、安卓
			    const getAuth = (platform) => {
			        const showModal = (content) => {
			            uni.showModal({
			                title: '需要授权', 
			                content: content,
			                confirmText: '确认',
			                cancelText: '取消',
			                success: (res) => {
			                    if (res.confirm) {
			                        // 打开设置界面，用户可以手动授予权限
			                        uni.openSetting({
			                            success: (settingData) => {
			                                if (platform === 'MP-WEIXIN' && settingData.authSetting['scope.userLocation']) {
			                                    that.getAddress();
			                                } else if (platform === 'MP-TOUTIAO' && settingData.authSetting['scope.userLocation']) {
			                                    that.getAddress();
			                                } else if (platform === 'APP' && settingData.authSetting['scope.userLocation']) {
			                                    that.getAddress();
			                                }
			                            }
			                        });
			                    } else {
			                        // 用户拒绝授权，返回首页或执行其他逻辑
			                        uni.switchTab({
			                            url: '/pages/index/index'
			                        });
			                    }
			                }
			            });
			        };
			
			        // 直接尝试获取位置信息
			        that.getAddress();
			    };
			
			    // 微信小程序
			    //#ifdef MP-WEIXIN
			    getAuth('MP-WEIXIN');
			    //#endif
			
			    // 抖音小程序
			    //#ifdef MP-TOUTIAO
			    getAuth('MP-TOUTIAO');
			    //#endif
			
			    // iOS 和安卓 App 环境
			    //#ifdef APP-PLUS
			    getAuth('APP');
			    //#endif
			},
			// 获取位置信息
			getAddress() 
			{
				console.log("getAddressAndDoQrcodeOpen");
				uni.getLocation({
					type: 'gcj02',
					success: res => {
						this.latitude = res.latitude
						this.longitude = res.longitude
						this.qrOpenLock()
					},
					fail: err => {
						//console.log(err);
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
					duration: 4000,
					mask: true
				})
			},
			// #ifdef MP-WEIXIN
			initVideoAd() {
				if (wx.createRewardedVideoAd) {
					// 创建激励视频广告实例
					this.videoAd = wx.createRewardedVideoAd({
						adUnitId: this.adUnitId,
					});

					// 广告加载成功
					this.videoAd.onLoad(() => {
						console.log('广告加载成功');
						//this.adLog('qropen', 'load',30, true, '广告加载成功'); // 记录广告加载成功
					});

					// 广告加载失败
					this.videoAd.onError((err) => {
						console.error('激励视频广告加载失败', err);
						this.adLog('qropen', 'error', 30, false, `广告加载失败: ${err.errMsg}`, 0); // 记录广告加载失败
					});

					// 用户关闭广告
					this.videoAd.onClose((res) => {
						// 处理用户看完广告和关闭广告的逻辑
						if (res && res.isEnded) {
							// 用户完整观看广告
							console.log('用户完整观看广告');
							this.adLog('qropen', 'close', 30, true, '用户完整观看广告', 1); // 记录用户完整观看广告
						} else {
							// 用户提前关闭广告
							console.log('用户提前关闭广告');
							this.adLog('qropen', 'close', 30, false, '用户提前关闭广告', 0); // 记录用户提前关闭广告
						}
					});
				}
			},
			showAd() {
				// 展示激励视频广告
				if (this.videoAd) {
					this.videoAd.show().then(() => {
						// 广告展示成功，记录成功日志
						console.log('激励视频广告展示成功');
						this.adLog('qropen', 'show', 30, true, '激励视频广告展示成功', 0); // 请替换'member_id'与实际的会员ID或其他标识符
						this.adShowCount += 1; // 增加广告显示次数
						wx.setStorageSync('adShowCount', this.adShowCount); // 将计数保存到本地存储
					}).catch((err) => {
						// 展示失败，尝试重新加载广告
						console.error('激励视频广告加载失败，尝试重新加载', err);
						this.adLog('qropen', 'load_fail', 30, false, `激励视频广告加载失败，尝试重新加载:${err.errMsg}`,
							0); // 记录加载失败的日志，替换'member_id'
						this.videoAd.load().then(() => {
							this.videoAd.show().then(() => {
								// 重新加载后广告展示成功，记录成功日志
								console.log('激励视频广告重新加载后展示成功');
								this.adLog('qropen', 'reload_show', 30, true, '激励视频广告重新加载后展示成功',
									0); // 请替换'member_id'
							}).catch(err => {
								// 重新加载后依然失败，记录失败日志
								console.error('激励视频广告重新加载后展示失败', err);
								this.adLog('qropen', 'reload_fail', 30, false,
									`激励视频广告重新加载后展示失败:${err.errMsg}`, 0); // 请替换'member_id'
							});
						}).catch(err => {
							// 重新加载失败，记录失败日志
							console.error('激励视频广告重新加载失败', err);
							this.adLog('qropen', 'reload_fail', 30, false, `激励视频广告重新加载失败:${err.errMsg}`,
								0); // 请替换'member_id'
						});
					});
				}
			},
			adLog(adlog_page, adlog_type, adlog_adtime, adlog_result, adlog_msg, adlog_points) {
				// 调用 adlog_api 接口
				adlog_api({
					adlog_page: adlog_page,
					adlog_type: adlog_type,
					adlog_adtime: adlog_adtime,
					adlog_result: adlog_result,
					adlog_msg: adlog_msg,
					adlog_points: adlog_points,
				}).then(res => {
					console.log('广告日志记录成功', res);
				}).catch(err => {
					console.error('广告日志记录失败', err);
				});
			},
			// #endif
		}
	}
</script>

<style scoped lang="scss">
	@import './open.scss';
</style>