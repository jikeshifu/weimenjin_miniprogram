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

			<block v-if="pageType === 'cabinet'">
				<view class="top-box">
					<view class="cell-item">
						<view class="label">柜门编号</view>
						<view class="value">{{ global_lock }}</view>
					</view>
					<view class="cell-item">
						<view class="label">取货方式</view>
						<radio-group @change="onPickupModeChange" class="radio-group">
							<label class="radio-item">
								<radio value="self" :checked="cabinetPickupMode === 'self'" color="#07c160" />
								<text>仅本人取</text>
							</label>
							<label class="radio-item">
								<radio value="phone" :checked="cabinetPickupMode === 'phone'" color="#07c160" />
								<text>指定手机号</text>
							</label>
						</radio-group>
					</view>
					<view class="cell-item" v-if="cabinetPickupMode === 'phone'">
						<view class="label">取货人手机号</view>
						<input placeholder="请输入取货人手机号" placeholder-class="placeholder" v-model="recipientMobile" />
					</view>
				</view>
				<view class="bottom-box">
					<view class="bottom-btn" @click="onCabinetAction(1)">存入</view>
					<view class="bottom-btn" style="margin-top: 20rpx; background: #ffffff; color: #07c160; border: 1px solid #07c160;" @click="onCabinetAction(0)">取出</view>
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
		<privacy-popup ref="privacyComponent" @agree="onPrivacyAgree"></privacy-popup>
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
		adUnitId_api,
		deviceInfo_api,
		verifyScanAdfree_api,
		setW75LockUsage_api,
			getW75ScanInfo_api,
			createW75StorageOrder_api,
			storagePayAndOpenW75_api
	} from '../../api/index.js';
	export default {
		components: {
			PrivacyPopup
		},
		data() {
			return {
				pageType: '',
				lock_id: '',
				relay_num: '', // W76F继电器路数
				global_lock: '', // W75柜门锁编号
				cabinetPickupMode: 'self',
				recipientMobile: '',
				cabinetScanData: null, // W75柜门扫码信息
				isQropen: true,
				user_name: '',
				aremark: '',
				successimg: '',
				latitude: '',
				longitude: '',
				isLogin: false,
				interstitialAd: null, // 插屏广告实例
				adShowCount: 0, // 初始化广告显示计数器
				adUnitId: '', // 用于存储从后台获取的 adUnitId
				defaultAdUnitId: 'adunit-9e867d2c8cf7f169', // 本地默认插屏广告ID
				maxDailyAds: 6, // 每日最大广告显示次数，限制为6次
				adRetryCount: 0, // 广告重试次数
				maxRetryCount: 3, // 最大重试次数
				isAdShowing: false, // 广告显示状态控制
				scanPath: '', // 扫码路径类型：'scan'、'minilock' 或 'minicabinet'
				showAd: true, // 是否显示广告，免广告订阅用户为false
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		mounted() {
			// 广告优先逻辑：进入页面后优先显示广告，只显示一次
			// let lastDate = wx.getStorageSync('lastUseDate');
			// let today = new Date().toLocaleDateString('zh-CN', {
			// 	timeZone: 'Asia/Shanghai',
			// 	year: 'numeric',
			// 	month: '2-digit',
			// 	day: '2-digit'
			// }).replace(/\//g, '-'); // 获取当前日期，格式为 YYYY-MM-DD
			// if (lastDate !== today) {
			// 	this.adShowCount = 0; // 如果不是同一天，则重置广告显示计数器
			// 	wx.setStorageSync('adShowCount', this.adShowCount); // 更新本地存储中的计数
			// } else {
			// 	this.adShowCount = wx.getStorageSync('adShowCount') || 0; // 如果是同一天，从本地存储恢复计数
			// }
			// wx.setStorageSync('lastUseDate', today); // 更新存储的日期
			// // 进入页面后优先显示广告，只显示一次
			// if (this.interstitialAd && this.adShowCount < this.maxDailyAds && this.pageType !== 'phone') {
			// 	this.showAd();
			// }
		},
		methods: {
			async checkDeviceAndOpenLock() {
				// 查询设备信息，判断是否需要定位
				try {
					const res = await deviceInfo_api({ lock_id: this.lock_id });
					if (res.code === 0 && res.deviceinfo) {
						const deviceinfo = res.deviceinfo;
						// W75智能柜门锁处理
						if (deviceinfo.lock_sn && deviceinfo.lock_sn.startsWith('W75')) {
							await this.handleW75Cabinet();
							return;
						}
						if (deviceinfo.location_check > 0) {
							// 需要定位
							this.getLocation();
						} else {
							// 不需要定位，直接开门
							this.qrOpenLock();
						}
					} else {
						// 查询失败，兜底走原有流程
						this.getLocation();
					}
				} catch (e) {
					// 网络异常等，兜底走原有流程
					this.getLocation();
				}
			},

			// W75柜门锁扫码处理
			async handleW75Cabinet() {
				if (!this.global_lock) {
					// 扫的是设备主二维码（不带global_lock），提示用户使用柜门二维码
					uni.showModal({
						title: '提示',
						content: '请扫描柜门专属二维码进行存取操作',
						showCancel: false,
						confirmText: '知道了',
						success: () => {
							uni.switchTab({ url: '/pages/index/index' });
						}
					});
					return;
				}

				// 获取扫码信息（工作模式、是否管理员等）
				uni.showLoading({ title: '加载中...' });
				try {
					const scanRes = await getW75ScanInfo_api({
						lock_id: this.lock_id,
						global_lock: this.global_lock
					});
					uni.hideLoading();

					if (scanRes.code !== 0) {
						uni.showToast({ title: scanRes.msg || '获取信息失败', icon: 'none' });
						return;
					}

					const scanData = scanRes.data;

					// 不区分管理员，统一按工作模式处理
					if (scanData.work_mode === 2) {
						// 售卖模式 -> 跳转到购买页面
						if (!scanData.sku) {
							uni.showModal({
								title: '提示',
								content: '该柜门暂无商品可购买',
								showCancel: false,
								success: () => {
									uni.switchTab({ url: '/pages/index/index' });
								}
							});
							return;
						}
						// 跳转到商品购买页面
						uni.redirectTo({
							url: `/pages/W75Buy/W75Buy?lock_id=${this.lock_id}&global_lock=${this.global_lock}`
						});
					} else {
						// 存取模式 -> 进入存取页面
						this.cabinetScanData = scanData;
						this.pageType = 'cabinet';
					}
				} catch (e) {
					uni.hideLoading();
					console.error('获取柜门信息失败:', e);
					uni.showToast({ title: '网络异常，请重试', icon: 'none' });
				}
			},
			// 隐私协议同意后的回调
			onPrivacyAgree() {
				// 继续执行开门逻辑
				this.checkDeviceAndOpenLock();
			},
			async qrOpenLock(cabinetAction = '') {
				uni.showLoading({
					title: '加载中...'
				})
				let params = {
					lock_id: this.lock_id,
					latitude: this.latitude,
					longitude: this.longitude
				}
				// W75柜门二维码，传递global_lock参数
				if (this.global_lock) {
					params.global_lock = this.global_lock
				}
				if (cabinetAction) {
					params.cabinet_action = cabinetAction
				}
				// 如果是W76F继电器二维码，传递relay_num参数
				if (this.relay_num) {
					params.relay_num = this.relay_num
				}
				let res
				let openSuccess = false
				try {
					res = await qrOpenLock_api(params)
				} catch (e) {
					// 网络异常处理
					uni.hideLoading()
					uni.showToast({
						title: '网络异常，请重试',
						icon: 'none',
						duration: 3000
					})
					setTimeout(() => {
						uni.switchTab({
							url: '/pages/index/index'
						})
					}, 3000)
					return false
				}
				uni.hideLoading()
				if (res.code === 0) {
					openSuccess = true
					// #ifdef MP-WEIXIN
					// if (this.adShowCount < this.maxDailyAds) {
					// 	this.showAd(); // 插屏广告同时弹出，不阻塞开门流程
					// }
					// #endif
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
					}
					if (res.data.successimg) {
						this.pageType = 'succeed'
						this.successimg = res.data.successimg
					}
					uni.showToast({
						title: res.msg,
						duration: 8000
					})
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
							uni.showToast({
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
						return false
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

				return openSuccess
			},
			async fetchAdUnitId() {
				try {
					const res = await adUnitId_api(); // 假设你已经有一个API可以获取广告ID
					if (res.code === 0 && res.adUnitId) {
						this.adUnitId = res.adUnitId; // 使用后台获取的广告ID
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
						return openSuccess
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
			onPickupModeChange(e) {
				this.cabinetPickupMode = e.detail.value;
				if (this.cabinetPickupMode === 'self') {
					this.recipientMobile = '';
				}
			},
			async onCabinetAction(isUsed) {
				if (!this.lock_id || !this.global_lock) {
					uni.showToast({
						title: '二维码参数不完整',
						icon: 'none'
					})
					return
				}
				if (isUsed === 1 && this.cabinetPickupMode === 'phone') {
					const mobile = this.recipientMobile.trim();
					if (!/^1[3-9]\d{9}$/.test(mobile)) {
						uni.showToast({
							title: '请输入正确手机号',
							icon: 'none'
						})
						return
					}
				}
				const storageConfig = this.cabinetScanData && this.cabinetScanData.storage_config ? this.cabinetScanData.storage_config : null;
				const chargeEnabled = storageConfig && parseInt(storageConfig.charge_enabled) === 1;
				const chargePayer = storageConfig ? parseInt(storageConfig.charge_payer) : 1;
				const needPay = chargeEnabled && ((isUsed === 1 && chargePayer === 1) || (isUsed === 0 && chargePayer === 2));

				if (needPay) {
					await this.handleStoragePay(isUsed);
					return;
				}

				const action = isUsed === 1 ? 'store' : 'pick';
				const ok = await this.qrOpenLock(action)
				if (!ok) {
					return
				}
				try {
					await setW75LockUsage_api({
						lock_id: this.lock_id,
						global_lock: this.global_lock,
						is_used: isUsed,
						self_only: isUsed === 1 && this.cabinetPickupMode === 'self' ? 1 : 0,
						pickup_mobile: isUsed === 1 && this.cabinetPickupMode === 'phone' ? this.recipientMobile.trim() : ''
					})
					uni.showToast({
						title: isUsed === 1 ? '已存入' : '已取出',
						icon: 'success'
					})
				} catch (e) {
					// 状态更新失败不影响开门流程
				}
			},
			async handleStoragePay(isUsed) {
				try {
					uni.showLoading({ title: '创建订单中...' });
					const action = isUsed === 1 ? 'store' : 'retrieve';
					const orderRes = await createW75StorageOrder_api({
						lock_id: this.lock_id,
						global_lock: this.global_lock,
						action
					});

					if (orderRes.code !== 0) {
						uni.hideLoading();
						uni.showToast({ title: orderRes.msg || '创建订单失败', icon: 'none' });
						return;
					}

					const orderData = orderRes.data || {};
					const payData = orderData.payData || orderData;

					// #ifdef MP-WEIXIN
					uni.hideLoading();
					wx.requestPayment({
						timeStamp: payData.timeStamp,
						nonceStr: payData.nonceStr,
						package: payData.package,
						signType: payData.signType || 'RSA',
						paySign: payData.paySign,
						success: async () => {
							uni.showLoading({ title: '开门中...' });
							try {
								const openRes = await storagePayAndOpenW75_api({
									order_no: orderData.order_no
								});
								uni.hideLoading();
								if (openRes.code === 0) {
									if (isUsed === 1) {
										// 付费存入后补充取货人信息
										try {
											await setW75LockUsage_api({
												lock_id: this.lock_id,
												global_lock: this.global_lock,
												is_used: 1,
												self_only: this.cabinetPickupMode === 'self' ? 1 : 0,
												pickup_mobile: this.cabinetPickupMode === 'phone' ? this.recipientMobile.trim() : ''
											});
										} catch (e) {}
									}
									uni.showModal({
										title: '支付成功',
										content: isUsed === 1 ? '柜门已打开，请存入物品' : '柜门已打开，请取出物品',
										showCancel: false,
										success: () => {
											uni.switchTab({ url: '/pages/index/index' });
										}
									});
								} else {
									uni.showModal({
										title: '提示',
										content: openRes.msg || '开门失败，请联系管理员',
										showCancel: false
									});
								}
							} catch (e) {
								uni.hideLoading();
								uni.showModal({
									title: '提示',
									content: '支付成功但开门失败，请联系管理员',
									showCancel: false
								});
							}
						},
						fail: () => {
							uni.showToast({ title: '支付取消', icon: 'none' });
						}
					});
					// #endif

					// #ifndef MP-WEIXIN
					uni.hideLoading();
					uni.showToast({ title: '请使用微信小程序完成支付', icon: 'none' });
					// #endif
				} catch (e) {
					uni.hideLoading();
					uni.showToast({ title: '网络异常，请重试', icon: 'none' });
				}
			},
			getLocation() {
			    let that = this;

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
			initInterstitialAd() {
				// 若在开发者工具中无法预览广告，请切换开发者工具中的基础库版本
				if (wx.createInterstitialAd) {
					this.interstitialAd = wx.createInterstitialAd({
						adUnitId: this.adUnitId
					})
					this.interstitialAd.onLoad(() => {
						this.adLog('qropen', 'load', 30, true, '插屏广告加载成功')
						this.adRetryCount = 0 // 重置重试次数
					})
					this.interstitialAd.onError((err) => {
						console.error('插屏广告加载失败', err)
						this.adLog('qropen', 'error', 30, false, `插屏广告加载失败: ${err.errMsg}`, 0)
						// 加载失败时自动重试，提升广告曝光率
						this.retryLoadAd()
					})
					this.interstitialAd.onClose(() => {
						this.adLog('qropen', 'close', 30, true, '用户关闭插屏广告', 1)
						// 广告关闭后立即重新加载，为下次展示做准备
						setTimeout(() => {
							this.interstitialAd.load()
						}, 1000)
					})
				}
			},
			showAd() {
				// 在适合的场景显示插屏广告
				if (this.interstitialAd && this.adShowCount < this.maxDailyAds && !this.isAdShowing) {
					this.isAdShowing = true; // 标记广告正在显示
					this.interstitialAd.show().then(() => {
						this.adLog('qropen', 'show', 30, true, '插屏广告展示成功', 0)
						this.adShowCount += 1 // 增加广告显示次数
						wx.setStorageSync('adShowCount', this.adShowCount) // 将计数保存到本地存储
						this.adRetryCount = 0 // 重置重试次数
						this.isAdShowing = false; // 广告显示完成，重置状态
					}).catch((err) => {
						console.error('插屏广告显示失败', err)
						this.adLog('qropen', 'show_fail', 30, false, `插屏广告显示失败: ${err.errMsg}`, 0)
						// 显示失败时尝试重新加载广告
						this.retryLoadAd()
						this.isAdShowing = false; // 广告显示失败，重置状态
					})
				}
			},
			// 广告重试加载方法，提升广告曝光率
			retryLoadAd() {
				if (this.adRetryCount < this.maxRetryCount && this.interstitialAd) {
					this.adRetryCount++
					setTimeout(() => {
						this.interstitialAd.load().then(() => {
						}).catch((err) => {
							console.error('广告重试加载失败', err)
							if (this.adRetryCount < this.maxRetryCount) {
								this.retryLoadAd() // 递归重试
							}
						})
					}, 2000) // 2秒后重试
				}
			},
			adLog(adlog_page, adlog_type, adlog_adtime, adlog_result, adlog_msg, adlog_points) {
				// 异步静默记录广告日志，不影响主流程
				try {
					adlog_api({
						adlog_page: adlog_page,
						adlog_type: adlog_type,
						adlog_adtime: adlog_adtime,
						adlog_result: adlog_result,
						adlog_msg: adlog_msg,
						adlog_points: adlog_points,
					}).catch(() => {
						// 静默处理失败
					});
				} catch (e) {
					// 静默处理异常
				}
			},
			// #endif
		},
		async onLoad(option) {
			//处理通过普通链接传递的参数 lock_id
			if (option.lock_id) {
				this.lock_id = option.lock_id;
			}
			// 处理通过普通链接传递的参数 relay_num (W76F继电器路数)
			if (option.relay_num) {
				this.relay_num = option.relay_num;
			}
			// 处理通过普通链接传递的参数 global_lock (W75柜门编号)
			if (option.global_lock) {
				this.global_lock = option.global_lock;
			}
			// 页面加载时，先获取广告ID
			// this.fetchAdUnitId().then(() => {
			// 	this.initInterstitialAd(); // 初始化插屏广告
			// });
			// 扫码带的参数
			if (option.q) {
				let scene = decodeURIComponent(option.q) // 使用decodeURIComponent解析  获取当前二维码的网址
				let paramobj = getQueryString(scene)
				this.lock_id = paramobj.lock_id
				// W76F继电器二维码，解析relay_num参数
				if (paramobj.relay_num) {
					this.relay_num = paramobj.relay_num
				}
				// W75柜门二维码，解析global_lock参数
				if (paramobj.global_lock) {
					this.global_lock = paramobj.global_lock
				}
				// 检测扫码路径类型：/scan 为免广告二维码，/minilock 为普通二维码
				if (scene.indexOf('/scan') > -1 || scene.indexOf('/scan?') > -1) {
					this.scanPath = 'scan';
				} else if (scene.indexOf('/minilock') > -1) {
					this.scanPath = 'minilock';
				}
			}

			// 如果是免广告二维码路径，必须验证订阅状态，无订阅则阻止开门
			if (this.scanPath === 'scan' && this.lock_id) {
				try {
					const verifyRes = await verifyScanAdfree_api({ lock_id: this.lock_id });
					if (verifyRes.code === 0 && verifyRes.data && verifyRes.data.is_valid) {
						// 有效订阅，允许开门，不显示广告
						this.showAd = false;
					} else {
						// 无效订阅或已过期，阻止开门并提示
						uni.showModal({
							title: '无法开门',
							content: '该二维码需要免广告订阅才能使用，请联系设备管理员购买订阅或使用普通二维码开门。',
							showCancel: false,
							confirmText: '知道了',
							success: () => {
								uni.switchTab({
									url: '/pages/index/index'
								});
							}
						});
						return; // 阻止后续开门流程
					}
				} catch (e) {
					// 验证失败，阻止开门
					uni.showModal({
						title: '验证失败',
						content: '订阅验证失败，请稍后重试或使用普通二维码开门。',
						showCancel: false,
						confirmText: '知道了',
						success: () => {
							uni.switchTab({
								url: '/pages/index/index'
							});
						}
					});
					return; // 阻止后续开门流程
				}
			}

			// 支付宝小程序从缓存中读取二维码参数
			// #ifdef MP-ALIPAY
			let qrcodeLockId = uni.getStorageSync("qrcodeLockId")
			if (qrcodeLockId) {
				this.lock_id = qrcodeLockId
			}
			let qrcodeRelayNum = uni.getStorageSync("qrcodeRelayNum")
			if (qrcodeRelayNum) {
				this.relay_num = qrcodeRelayNum
			}
			let qrcodeGlobalLock = uni.getStorageSync("qrcodeGlobalLock")
			if (qrcodeGlobalLock) {
				this.global_lock = qrcodeGlobalLock
			}
			// #endif
			//console.log('option', option)
			// 从'我的-绑定手机号进入'
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
				}
				// W76F继电器二维码，解析relay_num参数
				if (dynamicParams.relay_num) {
					this.relay_num = dynamicParams.relay_num;
				}
				// W75柜门二维码，解析global_lock参数
				if (dynamicParams.global_lock) {
					this.global_lock = dynamicParams.global_lock;
				}
			}
			if (typeof tt !== 'undefined' && tt.checkSession) {
				tt.checkSession({
					success: () => {
						this.isLogin = true
					},
				});
			}
			// #endif
			// #ifdef APP-PLUS
			const platform = uni.getSystemInfoSync().platform;
			if (platform === 'ios' || platform === 'android') {
				this.lock_id = option.lock_id; // 设置 lock_id
			}
			// #endif
			// 检查隐私协议是否已同意，若无需授权则直接开门
			if (typeof wx !== 'undefined' && wx.getPrivacySetting) {
				wx.getPrivacySetting({
					success: (res) => {
						if (res.needAuthorization === false) {
							// 已同意隐私协议，直接开门
							this.checkDeviceAndOpenLock();
						}
						// 否则等用户同意后 onPrivacyAgree 再执行
					}
				});
			} else {
				// 兼容老版本，直接开门
				this.checkDeviceAndOpenLock();
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './open.scss';
</style>
