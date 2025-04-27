<template>
	<view>
		<!-- #ifdef APP-PLUS -->
		<custom-nav-bar title="微门禁" @plus-click="onTopPlusClick"></custom-nav-bar>
		<!-- #endif -->
		<view class="content">
			<view class="background"></view>
			<view class="big-box">
				<view class="cell-box">
					<view class="welcome">欢迎使用</view>
					<view class="dot"></view>
					<view class="equipment">
						<view class="flex-box" @click="clickGrouping">
							<view class="name">{{ device_group_name }}</view>
							<i class="iconfont icon-xiala"></i>
						</view>
						<view class="position" v-if="grouping_show">
							<view class="icon">
								<image src="../../static/sanjiao.png"></image>
							</view>
						</view>
					</view>
					<view class="list-box" v-if="grouping_show">
						<view class="scroll-box">
							<view :class="['item', item.device_group_id == grouping_index ? 'active' : '']"
								v-for="(item, index) in groupingList" :key="index" @click="changeGrouping(item)">
								<view class="name">{{ item.device_group_name }}</view>
								<image src="../../static/queding.png" class="pitch-on"
									v-if="item.device_group_id == grouping_index"></image>
							</view>
						</view>
						<view class="manage" @click="goGrouping">
							<view class="text">分组管理</view>
							<image src="../../static/shezhi-on.png"></image>
						</view>

					</view>
				</view>
				<view class="list">
					<view v-for="(item, index) in dataList" :key="index"
						:class="['item', item.loading ? 'loading' : '', item.status !== 1 || item.lock.switch_state ? 'item-on' : '']">
						<!-- 超级管理员标识 -->
						<view v-if="item.auth_isadmin === 1 && item.auth_member_id === 0" class="super-admin-badge">
							<span class="super-admin-text">超管</span>
						</view>
						<view v-if="item.auth_isadmin === 1 && item.auth_member_id !== 0" class="admin-badge">
							<span class="admin-text">管理员</span>
						</view>
						<view class="flex-box">
							<view class="share">
								<image src="../../static/fenxiang.png" @click="onShare(item)"
									v-if="item.status !== 1 ||item.lock.switch_state"></image>
								<block v-else>
									<image src="../../static/fenxiang-on.png" @click="onShare(item)"
										v-if="item.lock.online == 1"></image>
									<image src="../../static/fenxiang-hui.png" @click="onShare(item)" v-else></image>
								</block>
							</view>
							<view class="site" @click="changeSite(index,item)">
								<image src="../../static/shezhi.png" v-if="item.status !== 1 ||item.lock.switch_state">
								</image>
								<block v-else>
									<image src="../../static/shezhi-on.png" v-if="item.lock.online == 1"></image>
									<image src="../../static/shezhi-hui.png" v-else></image>
								</block>
								<image src="../../static/sanjiao.png" class="position-icon" v-if="set_index == index">
								</image>
							</view>
						</view>

						<view class="name">
							<view class="text" v-if="item.lock">{{ item.lock.lock_name }}</view>
						</view>
						<view class="indate" v-if="item.lock">{{ item.auth_starttime1 }}</view>
						<view class="indate" v-if="item.lock">{{ item.auth_endtime1 }}</view>

						<view class="key">
							<view class="btn btn-on" v-if="item.lock.status !== 1 ||item.lock.switch_state">
								<i class="iconfont icon-yuechi icon-default icon-on" @click="unlocking(item,index)"
									v-if="item.device_type === 'lock'"></i>
								<i class="iconfont icon-yuechi icon-default icon-on"
									v-if="item.device_type === 'switchLock'"></i>
								<i class="iconfont icon-shandian icon-default icon-on" @click="onSwitch(item)"
									v-if="item.device_type === 'switch'"></i>
								<i class="iconfont icon-laba icon-default icon-on"
									v-if="item.device_type === 'horn'"></i>
							</view>
							<block v-else>
								<view class="btn" @click="unlocking(item,index)" v-if="item.device_type === 'lock'">
									<i class="iconfont icon-yuechi icon-default"></i>
								</view>
								<view class="btn" @click="onSwitch(item)" v-if="item.device_type === 'switch'">
									<i class="iconfont icon-shandian icon-default"></i>
								</view>
								<view class="btn" @click="onSwitchLock(item)" v-if="item.device_type === 'switchLock'">
									<i class="iconfont icon-yuechi  icon-default"></i>
								</view>
								<view class="btn" @click="onPlay(item)" v-if="item.device_type === 'horn'">
									<i class="iconfont icon-laba icon-default"></i>
								</view>
							</block>
						</view>
						<view class="indate" v-if="item.lock">{{ item.auth_limit }}</view>
						<view class="pop-up-box" v-if="set_index === index"
							:style="{ left: set_index % 2 == 0 ? '20rpx' : 'initial', right: set_index % 2 == 0 ? 'initial' : '20rpx'}">
							<view class="cell-list">
								<block v-if="item.auth_isadmin === 1">
									<view class="cell-item"
										@click="goDetail('/pages/equipment/equipment?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-shebei"></i>
										<view class="text">设备信息</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/operateList/operateList?lock_id=' + item.lock_id)">
										<i class="iconfont icon-yewucaozuo"></i>
										<view class="text">操作记录</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/keyList/keyList?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-yuechi"></i>
										<view class="text">权限管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/arguments/arguments?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-canshu"></i>
										<view class="text">参数设置</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/realTime/realTime?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.realTime_status === 1">
										<i class="iconfont icon-shebei"></i>
										<view class="text">用电情况</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/passwordList/passwordList?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.pwd_status === 1">
										<i class="iconfont icon-mima"></i>
										<view class="text">密码管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/fingerprintList/fingerprintList?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.finger_status === 1">
										<i class="iconfont icon-zhiwen"></i>
										<view class="text">指纹列表</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/doorCardList/doorCardList?lock_id=' + item.lock_id+ '&auth_isadmin=' + item.auth_isadmin)"
										v-if="item.lock_ability.card_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">门卡管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/linkresponse/linkresponse?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.linkresponse_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">联动管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/audioConfig/audioConfig?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.audioConfig_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">语音设置</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/transfer/transfer?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-a-zhuanyi4"></i>
										<view class="text">转移权限</view>
									</view>
								</block>
								<view 
									class="cell-item"
									@click="goDetail('/pages/faceList/faceList?lock_id=' + item.lock_id + '&auth_isadmin=' + item.auth_isadmin+ '&face_text=' + item.lock_ability.face_text)"
									v-if="item.lock_ability.face_status === 1">
									<i class="iconfont icon-renlianshibie"></i>
									<view class="text">
										{{ item.lock_ability.face_text ? item.lock_ability.face_text + '管理' : '图片管理' }}
									</view>
								</view>
								<view class="cell-item"
									@click="goDetail('/pages/authinfo/authinfo?lockauth_id=' + item.lockauth_id)">
									<i class="iconfont icon-yuechi"></i>
									<view class="text">钥匙排序</view>
								</view>
								<view class="cell-item" @click="onDelete(item)">
									<i class="iconfont icon-shanchu"></i>
									<view class="text" style="color: #FF0000;">
										删&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;除
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>
				<view class="site-mask" v-if="showMask" @click="clickMask"></view>
				<uni-load-more :status="noMore" empty_text="暂无数据～" style="margin-top: 40rpx;">
					<view v-if="status === 'nodata'" class="retry-container">
						<button class="retry-button" @click="retry">重试</button>
					</view>
				</uni-load-more>
			</view>
			<view class="horn-popup" @touchmove.stop.prevent v-if="showHornBox" @click="showHornBox = false">
				<view class="cell-box">
					<view class="content-box" @click.stop>
						<view class="cell-item">
							<view class="label">内容：</view>
							<scroll-view style="max-height: 200rpx;" scroll-y="true">
								<textarea placeholder="我是一个灵动声甜的云喇叭,请输入您想播放的内容,Get On the cart."
									placeholder-class="placeholder" v-model="tts" />
							</scroll-view>
						</view>
						<view class="cell-item">
							<view class="label">音量：</view>
							<picker mode="selector" :range="volumeOptions" :value="volume" @change="onVolumeChange">
								<view class="picker">{{ volumeOptions[volume] || '请选择音量' }}</view>
							</picker>
						</view>
						<view class="cell-item">
							<view class="label">循环播放：</view>
							<switch :checked="isLoopEnabled" @change="toggleLoop"></switch>
						</view>
						<view class="cell-item" v-if="isLoopEnabled">
							<view class="label">间隔时长（秒）：</view>
							<input type="number" placeholder="设置间隔时长" placeholder-class="placeholder"
								v-model="loopInterval" />
						</view>
						<view class="born-btn" @click.stop="playhorn">立即播放</view>
						<view class="born-btn" @click.stop="stophorn">停止播放</view>
					</view>
				</view>
			</view>
			<!-- 隐私协议 -->
			<!-- #ifdef MP-WEIXIN -->
			<privacy-popup ref="privacyComponent"></privacy-popup>
			<!-- #endif -->
			<block v-if="pageType === 'phone'">
				<view class="bindPhoneModal">
					<view class="bindPhone">
						<button type="primary" class="btn" open-type="getPhoneNumber" @getphonenumber="getphonenumber"
							hover-class="none">绑定手机号</button>
						<view class="btn cancel-btn" @click="cbindbutton">取消</view>
					</view>
				</view>
			</block>
		</view>
		<popup v-if="showPopup">
			<view class="popup-content">
				<view class="button-container">
					<view v-for="i in deviceLine" :key="i">
						<button @click="openDoor(i)">
							<i class="iconfont icon-yuechi icon-default"></i> 开门 {{ i }}
						</button>
					</view>
				</view>
				<button class="close-button" @click="closePopup">关闭</button>
			</view>
		</popup>
	</view>
</template>

<script>
	import CustomNavBar from '@/components/CustomNavBar/CustomNavBar.vue';
	import {
		OpenLockBle
	} from '../../module/device/index.js'
	import ble from '../../module/ble/index.js'
	import lockServer from '../../module/device/lock.js'
	import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue';
	import {
		getDeviceGroup_api,
		deviceList_api,
		openLock_api,
		openDoor_api,
		turnOn_api,
		turnOff_api,
		delDevice_api,
		loginQrCode_api,
		playHorn_api,
		openApi,
		adlog_api,
		closeApi,
		wxXcxMobile_api,
		zfbXcxMobile_api,
		toutiaoXcxMobile_api,
		zfb_edit_info,
		tt_edit_info,
		deviceStatusBySerial_api,
		pauseAapi,
		adUnitId_api
	} from "../../api/index.js";
	import {
		wechatoauth_api,

	} from '../../api/user.js';
	import {
		setToken,
		getToken
	} from "../../libs/auth.js"
	import {
		getQueryString
	} from '../../libs/utils.js'
	export default {
		components: {
			PrivacyPopup,
			// #ifdef APP-PLUS 
			CustomNavBar
			// #endif 

		},
		data() {
			return {
				grouping_index: 0,
				grouping_show: false,
				set_index: -1,
				set_pop_show: false,
				groupingList: [],
				device_group_name: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				showMask: false,
				lockItem: {},
				showHornBox: false,
				volume: 3,
				volumeOptions: ['1', '2', '3', '4', '5', '6', '7'], // 音量选项
				tts: '', //播放内容
				hornItem: {},
				longitude: '',
				latitude: '',
				pageType: '',
				isLoopEnabled: false, // 循环播放开关
				loopInterval: 30, // 循环间隔时长，默认5秒
				showPrivacyPopup: false,
				isLogin: false,
				videoAd: null,
				adShowCount: 0, // 初始化广告显示计数器
				adUnitId: '', // 用于存储从后台获取的 adUnitId
				defaultAdUnitId: 'adunit-b43dfa956b9afbff', // 本地默认广告ID
				showPopup: false,
				deviceLine: 1,
				device_authid: 0,
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			// 初始化页面数据
			this.dataList = [];
			this.page = 1;
			this.getDeviceGroup();

			// 检查是否是通过二维码登录
			if (option.q) {
				let scene = decodeURIComponent(option.q); // 解析二维码场景参数
				let paramobj = getQueryString(scene).key;
				this.loginQrCode(paramobj); // 调用扫码登录逻辑
			}

			// 微信小程序平台登录逻辑
			// #ifdef MP-WEIXIN
			console.log('运行在微信小程序');
			this.fetchAdUnitId().then(() => {
				this.initVideoAd(); // 初始化广告
			});
			if (option.q) {
				let scene = decodeURIComponent(option.q);
				let paramobj = getQueryString(scene).key;
				this.loginQrCode(paramobj); // 扫码登录
			}
			// #endif

			// 抖音小程序平台登录逻辑
			// #ifdef MP-TOUTIAO
			console.log('运行在抖音小程序');
			tt.checkSession({
				success: () => {
					this.isLogin = true; // 检查抖音小程序的登录状态
				},
			});
			// #endif

			// 处理手机号绑定类型页面
			if (option.type) {
				this.pageType = option.type;
				this.isQropen = false;
			}
			if (this.pageType === 'phone') {
				uni.setNavigationBarTitle({
					title: '绑定手机号',
				});
				return;
			}
		},
		onShow() {
			// #ifdef MP-WEIXIN
			if (wx.getPrivacySetting) {
				wx.getPrivacySetting({
					success: (res) => {
						if (res.needAuthorization) {
							this.showPrivacyPopup = true;
							this.$nextTick(() => {
								if (this.$refs.privacyComponent) {
									this.$refs.privacyComponent.showPrivacy = true;
								}
							});
						}
					},
				});
			}
			let lastDate = wx.getStorageSync('lastUseDate');
			let today = new Date().toLocaleDateString('zh-CN', {
				timeZone: 'Asia/Shanghai',
				year: 'numeric',
				month: '2-digit',
				day: '2-digit'
			}).replace(/\//g, '-'); // 获取当前日期，格式为 YYYY-MM-DD
			console.log("today", today)
			if (lastDate !== today) {
				this.adShowCount = 0; // 如果不是同一天，则重置广告显示计数器
				wx.setStorageSync('adShowCount', this.adShowCount); // 更新本地存储中的计数
			} else {
				this.adShowCount = wx.getStorageSync('adShowCount') || 0; // 如果是同一天，从本地存储恢复计数
			}
			wx.setStorageSync('lastUseDate', today); // 更新存储的日期
			// #endif

		},
		onHide() {

			this.latitude = ""
			this.longitude = ""

			// #ifdef MP-WEIXIN
			ble.CloseBluetoothAdapter()
			// #endif
		},
		mounted() {
			// 如果本地存储中有值，则使用该值，否则使用默认值
			this.tts = wx.getStorageSync('tts') !== '' ? wx.getStorageSync('tts') : '我是一个灵动声甜的云喇叭';
			this.volume = wx.getStorageSync('volume') !== '' ? wx.getStorageSync('volume') : 5;
			// 对于布尔值需要特别处理
			this.isLoopEnabled = (wx.getStorageSync('isLoopEnabled') !== '') ? wx.getStorageSync('isLoopEnabled') :
				false; // 默认为 false
			this.loopInterval = wx.getStorageSync('loopInterval') !== '' ? wx.getStorageSync('loopInterval') : 30;
		},
		watch: {
			tts(newVal) {
				wx.setStorageSync('tts', newVal);
			},
			volume(newVal) {
				wx.setStorageSync('volume', newVal);
			},
			isLoopEnabled(newVal) {
				wx.setStorageSync('isLoopEnabled', newVal);
			},
			loopInterval(newVal) {
				wx.setStorageSync('loopInterval', newVal);
			},
			dataList(newVal) {
				if (newVal && newVal.length > 0) {
					this.fetchDeviceStatusBySerial();
				}
			}
			// 其他监听...
		},
		methods: {
			// 小程序扫码登录
			async loginQrCode(key) {
				let res = await loginQrCode_api({
					key: key
				})
			},
			onTopPlusClick() {
				// 点击 "+" 号后的逻辑，例如显示扫一扫功能
				uni.showActionSheet({
					itemList: ['扫一扫'],
					success: (res) => {
						if (res.tapIndex === 0) {
							this.scanCode();
						}
					},
					fail: (err) => {
						console.log("操作取消或失败: ", err);
					}
				});
			},
			retry() {
			      // 清理缓存并重新加载页面
			      uni.clearStorageSync(); // 清空缓存
			      uni.showToast({
			        title: '缓存已清理，重新加载',
			        icon: 'success',
			        duration: 1500,
			        complete: () => {
			          setTimeout(() => {
			            uni.reLaunch({
			              url: '/pages/index/index' // 替换为你的页面路径
			            });
			          }, 1500); // 等待提示完成后重新加载页面
			        }
			      });
			    },
			scanCode() {
				uni.scanCode({
					success: (res) => {
						console.log('扫码成功: ', res);
					},
					fail: (err) => {
						console.error('扫码失败: ', err);
					}
				});
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'error',
					duration: 4000,
					mask: true
				})
			},
			showPhoneLoginPage() {
				uni.navigateTo({
					url: '/pages/login/login', // 跳转到手机号登录页面
				});
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
			cbindbutton() {
				this.pageType = ''
			},
			itemClass(item) {
				// 假设状态信息中有一个名为 'switch_state' 的字段
				console.log("switch_state");
				return 'fixed-class-name'; // 测试用固定类名
			},
			async fetchDeviceStatusBySerial() {
				//console.log("for");
				for (let item of this.dataList) {
					// 添加判断条件，仅当设备序列号前三位为W71或W72时执行请求
					//console.log(`deviceSn start: ${item.lock.lock_sn.substring(0, 3)}`);
					if (item.lock.lock_sn.startsWith('W71') || item.lock.lock_sn.startsWith('W72')) {
						let params = {
							deviceSn: item.lock.lock_sn
						};
						let response = await deviceStatusBySerial_api(params); // 使用序列号请求状态
						//console.log(response);
						// 确保response存在且包含switch_state属性，避免可能的错误
						if (response && response.switch_state !== undefined) {
							item.lock.switch_state = response.switch_state;
							item.statusInfo = response;
						} else {
							console.warn(`No switch_state found in the response for deviceSn: ${item.lock.lock_sn}`);
						}
					}
				}
				//console.log(this.dataList);
			},

			async unlocking(item, index) {
				// #ifdef MP-WEIXIN
				if (item.lock.location_check === 1) {
					await this.getLocation()
				}
				// #endif
				if (item.lock_ability.line > 1) {
					this.deviceLine = item.lock_ability.line;
					this.device_authid = item.lockauth_id;
					this.showPopup = true;
				} else {
					item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
					uni.showLoading({
						title: '响应中...',
						mask: true
					})
					this.openLock(item, index)
					this.$forceUpdate()
					item.status = 1
				}
			},
			async openDoor(doorIndex) {
				console.log("openDoor item", doorIndex);
				// 准备请求参数
				const payload = {
					lockauth_id: this.device_authid, // 设备 ID
					line: doorIndex, // 路数
					longitude: this.longitude, // 如果有地理位置
					latitude: this.latitude // 如果有地理位置
				};
				// 显示加载状态
				uni.showLoading({
					title: '开门中...'
				});
				try {
					// 调用后端接口
					let res = await openDoor_api(payload); // 假设 openDoor_api 是你定义的接口调用函数

					// 更新状态
					if (res.code === 0) {
						// 处理成功逻辑
						console.log(`开门 ${doorIndex} 成功`, res.msg);
						uni.showToast({
							title: res.msg,
							duration: 2000
						});
						// 这里可以添加其他成功后的逻辑，比如刷新设备列表等
					} else if (res.code === 1001) {
						console.log("bindphone");
						this.pageType = 'phone'; // 处理需要绑定手机的情况
					} else {
						uni.showToast({
							title: res.msg,
							duration: 2000
						});
					}
				} catch (error) {
					console.error("开门请求失败", error);
					uni.showToast({
						title: '请求失败',
						duration: 2000
					});
				} finally {
					uni.hideLoading();
				}
			},
			closePopup() {
				this.showPopup = false;
			},
			// 开锁
			async openLock(item, index) {
				console.log("openLockitem", index)
				// #ifdef MP-WEIXIN
				if (item.lock.location_check === 1) {
					await this.getLocation()
				}
				// #endif
				let res = await openLock_api({
					lockauth_id: item.lockauth_id,
					longitude: this.longitude,
					latitude: this.latitude
				})
				item.status = 1
				uni.hideLoading()
				if (res.code === 0) {
					await this.refreshDeviceList(index);
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
					}

					uni.showToast({
						title: res.msg,
						duration: 5000
					})
					// #ifdef MP-WEIXIN
					if (item.lock.qrshowminiad === 1 && this.adShowCount < 3) {
						console.log("showAd")
						this.showAd()
					}
					//console.log("showAd")
					//this.showAd()
					// #endif
				} else if (res.code === 1001) {
					console.log("bindphone")
					this.pageType = 'phone'
					uni.hideLoading()
				} else {
					if (res.msg == "设备不在线") {
						await this.offline(item)
					} else {
						uni.showToast({
							title: res.msg,
							icon: 'none'
						})
					}


				}
				this.$forceUpdate()
			},
			toggleLoop(event) {
				this.isLoopEnabled = event.detail.value;
				wx.setStorageSync('isLoopEnabled', this.isLoopEnabled);
			},
			onVolumeChange(e) {
				this.volume = e.detail.value;
			},
			// 开/关动作
			onSwitch(item) {
				//console.log(item)
				uni.showActionSheet({
					itemList: ['开', '关'],
					success: async (msg) => {
						item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
						uni.showLoading({
							title: '加载中...',
							mask: true
						})

						this.$forceUpdate()
						if (msg.tapIndex === 0) {
							let res = await turnOn_api({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							item.lock.switch_state = 1;
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
							this.$forceUpdate()
						} else {

							let res = await turnOff_api({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							item.lock.switch_state = 0
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
							this.$forceUpdate()
						}
					},
				});
			},
			onSwitchLock(item) {
				//console.log(item)
				item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
				this.$forceUpdate()

				uni.showActionSheet({
					itemList: ['开', '关', '停'],
					success: async (msg) => {

						uni.showLoading({
							title: '加载中...',
							mask: true
						})


						if (msg.tapIndex === 0) {
							let res = await openApi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							item.lock.switch_state = 1;
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

						} else if (msg.tapIndex === 1) {

							let res = await closeApi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})


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

						} else {

							let res = await pauseAapi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})


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

						}

						item.status = 1
						item.lock.switch_state = 0
						uni.hideLoading()
						//console.log(123)
						this.$forceUpdate()
					},
				});

			},
			// 播放
			onPlay(item) {
				this.tts = item.lock.openttscontent || '请输入播放内容';
				this.showHornBox = true
				this.hornItem = item
				this.isLoopEnabled = wx.getStorageSync('isLoopEnabled')
				console.log(item)
			},
			// 立即播放
			async playhorn() {
				this.hornItem.status = 2
				this.$forceUpdate()
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await playHorn_api({
					lockauth_id: this.hornItem.lockauth_id,
					volume: this.volume,
					tts: this.tts,
					stopplay: false,
					longitude: this.longitude,
					latitude: this.latitude,
					isLoopEnabled: this.isLoopEnabled,
					loopInterval: this.loopInterval
				})
				if (res.code === 0) {
					this.hornItem.status = 1
					this.$forceUpdate();
					this.showHornBox = true
					uni.showToast({
						title: '播放成功',
						icon: 'none',
					})

				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			// 停止播放
			async stophorn() {
				this.hornItem.status = 2
				this.$forceUpdate()
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await playHorn_api({
					lockauth_id: this.hornItem.lockauth_id,
					volume: this.volume,
					tts: this.tts,
					stopplay: true,
					isLoopEnabled: this.isLoopEnabled,
					loopInterval: this.loopInterval
				})
				if (res.code === 0) {
					this.hornItem.status = 1
					this.$forceUpdate();
					this.showHornBox = false
					uni.showToast({
						title: '操作成功',
						icon: 'none',
					})

				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			clickMask() {
				this.showMask = false;
				this.set_index = -1
				this.grouping_show = false
			},
			clickGrouping() {
				this.showMask = true
				this.grouping_show = !this.grouping_show
				this.set_index = -1
			},
			login() {
				// 微信小程序登录
				// #ifdef MP-WEIXIN
				uni.login({
					provider: 'weixin',
					success: async (loginRes) => {
						let res = await wechatoauth_api({
							code: loginRes.code
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif

				// 支付宝小程序登录
				// #ifdef MP-ALIPAY
				uni.login({
					scopes: 'auth_base',
					success: async (loginRes) => {
						let res = await alipayoauth_api({
							code: loginRes.authCode
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif

				// 抖音小程序登录
				// #ifdef MP-TOUTIAO
				uni.login({
					success: async (loginRes) => {
						let res = await toutiaoauth_api({
							code: loginRes.code
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif
			},
			async getDeviceGroup() {
				let res = await getDeviceGroup_api()
				this.groupingList = res.data
				this.grouping_index = res.data.length ? res.data[0].device_group_id : 0
				this.device_group_name = res.data.length ? res.data[0].device_group_name : ''
				this.getList()

			},
			async getList() {
				this.noMore = 'loading';
				let params = {
					page: this.page,
					limit: 10,
					device_group_id: this.grouping_index
				};
				let res = await deviceList_api(params);
				this.groupInfo = res.data.info

				if (this.page !== 1 && !res.data.length) {
					this.noMore = 'noMore';
					return;
				} else if (this.page === 1 && !res.data.length) {
					this.dataList = [];
					this.dataList = res.data;
					this.noMore = 'nodata';
					return;
				}
				this.dataList = this.dataList.concat(res.data); //将数据拼接在一起

				if (this.dataList.length < 10) {
					this.noMore = 'noMore';
				}

				if (this.dataList.length > 0) {
					this.dataList.forEach((item) => {
						item.status = 1
					})
				}

			},
			async refreshDeviceList(index) {
				let lparams = {
					page: this.page,
					limit: 10,
					device_group_id: this.grouping_index
				};
				let res = await deviceList_api(lparams);

				if (res.code === 0 && res.data && res.data[index] && res.data[index].auth_openlimit) {
					//console.log("this.dataList：", this.dataList[index].auth_limit)
					//console.log("res.data：", res.data)
					this.dataList[index].auth_limit = res.data[index].auth_limit
					//this.dataList = res.data; // 假设返回的整个设备列表直接赋给dataList
					//this.$forceUpdate(); // 强制Vue更新视图
				} else {
					uni.showToast({
						title: '刷新数据失败',
						icon: 'none',
					});
				}

			},
			changeGrouping(item) {
				this.grouping_index = item.device_group_id;
				this.device_group_name = item.device_group_name;
				this.grouping_show = false;
				this.showMask = false
				this.dataList = []
				this.page = 1
				this.getList()
			},
			changeSite(index, item) {
				this.lockItem = item
				this.grouping_show = false
				if (index === this.set_index) {
					this.set_index = -1
					this.showMask = false
					return
				}
				this.set_index = index
				this.showMask = true
			},
			async offline(DeviceInfo) {
				//console.log("DeviceInfo：", DeviceInfo)

				if (DeviceInfo.lock.lock_sn.indexOf('WMJ62') > -1 || DeviceInfo.lock.lock_sn.indexOf('W76') > -1) {
					let OpenBluetoothAdapterRes = await ble.OpenBluetoothAdapter()
					//console.log("OpenBluetoothAdapterRes：", OpenBluetoothAdapterRes)
					if (OpenBluetoothAdapterRes.err) {
						uni.showToast({
							title: OpenBluetoothAdapterRes.err,
							icon: 'none',
						})
						return
					}
					await OpenLockBle(DeviceInfo.lock.lock_sn, DeviceInfo.lock.lock_id)
					return
				} else {
					uni.showToast({
						title: '设备不在线!',
						icon: 'none',
					})
				}
			},
			goDetail(url) {
				if (url.indexOf('transfer') !== -1) {
					if (this.lockItem.auth_isadmin !== 1 || this.lockItem.auth_member_id !== 0) {
						uni.showToast({
							title: '抱歉，无转移权限',
							icon: 'none',
							mask: true
						})
						return
					}
				}

				uni.navigateTo({
					url: url
				})
				this.showMask = false
				this.set_index = -1
			},
			goGrouping() {
				this.showMask = false
				this.set_index = -1
				this.grouping_show = false
				uni.navigateTo({
					url: '/pages/familyList/familyList'
				})
			},
			onShare(item) {
				if (item.auth_shareability !== 1) {
					uni.showToast({
						title: '抱歉，您没有分享权限',
						icon: 'none',
						mask: true
					})
					return
				}
				uni.navigateTo({
					url: '/pages/share/share?lockauth_id=' + item.lockauth_id
				})
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
										this.pageType = ''; // 手机号绑定成功，关闭弹层
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
											delta: 1,
										})
										this.pageType = ''
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
											delta: 1,

										})
										this.pageType = ''
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

				if (this.latitude) {
					return
				}
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
									//console.log('取消');
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
						//console.log('地址', res)
						this.latitude = res.latitude
						this.longitude = res.longitude
						uni.setStorageSync('location', {
							latitude: this.latitude,
							longitude: this.longitude
						})
					},
					fail: function(err) {
						//console.log(err);
					}
				});
			},
			async onDelete(item) {
				uni.showModal({
					title: '提示',
					content: '确定删除？',
					success: async (msg) => {
						if (msg.confirm) {
							let res = await delDevice_api({
								lockauth_id: item.lockauth_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功',
									icon: 'none',
								})
								this.dataList = []
								this.page = 1
								this.showMask = false
								this.set_index = -1
								this.getList()
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none',
								})
							}

						}
					}
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
						//this.adLog('index', 'load',30, true, '广告加载成功'); // 记录广告加载成功
					});

					// 广告加载失败
					this.videoAd.onError((err) => {
						console.error('激励视频广告加载失败', err);
						this.adLog('index', 'error', 30, false, `广告加载失败: ${err.errMsg}`, 0); // 记录广告加载失败
					});

					// 用户关闭广告
					this.videoAd.onClose((res) => {
						// 处理用户看完广告和关闭广告的逻辑
						if (res && res.isEnded) {
							// 用户完整观看广告
							console.log('用户完整观看广告');
							this.adLog('index', 'close', 30, true, '用户完整观看广告', 1); // 记录用户完整观看广告
						} else {
							// 用户提前关闭广告
							console.log('用户提前关闭广告');
							this.adLog('index', 'close', 30, false, '用户提前关闭广告', 0); // 记录用户提前关闭广告
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
						this.adShowCount += 1; // 增加广告显示次数
						this.adLog('index', 'show', 30, true, '激励视频广告展示成功', 0); // 请替换'member_id'与实际的会员ID或其他标识符
						wx.setStorageSync('adShowCount', this.adShowCount); // 将计数保存到本地存储
					}).catch((err) => {
						// 展示失败，尝试重新加载广告
						console.error('激励视频广告加载失败，尝试重新加载', err);
						this.adLog('index', 'load_fail', 30, false, `激励视频广告加载失败，尝试重新加载:${err.errMsg}`,
							0); // 记录加载失败的日志，替换'member_id'
						this.videoAd.load().then(() => {
							this.videoAd.show().then(() => {
								// 重新加载后广告展示成功，记录成功日志
								console.log('激励视频广告重新加载后展示成功');
								this.adLog('index', 'reload_show', 30, true, '激励视频广告重新加载后展示成功',
									0); // 请替换'member_id'
							}).catch(err => {
								// 重新加载后依然失败，记录失败日志
								console.error('激励视频广告重新加载后展示失败', err);
								this.adLog('index', 'reload_fail', 30, false,
									`激励视频广告重新加载后展示失败:${err.errMsg}`, 0); // 请替换'member_id'
							});
						}).catch(err => {
							// 重新加载失败，记录失败日志
							console.error('激励视频广告重新加载失败', err);
							this.adLog('index', 'reload_fail', 30, false, `激励视频广告重新加载失败:${err.errMsg}`,
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
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++; //每触底一次 page +1
			this.getList();
		},
		async onPullDownRefresh() {
			try {
				this.page = 1; // 初始化分页
				this.dataList = []; // 清空数据列表
				await this.getList(); // 调用异步获取数据的方法
			} catch (error) {
				console.error("Error in onPullDownRefresh:", error);
				uni.showToast({
					title: '刷新失败，请稍后再试',
					icon: 'none'
				});
			} finally {
				uni.stopPullDownRefresh(); // 确保下拉刷新状态被停止
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './index.scss';
</style>