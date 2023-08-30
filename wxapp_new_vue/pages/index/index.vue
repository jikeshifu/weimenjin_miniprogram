<template>
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
				<view :class="['item', item.status !== 1 ? 'item-on' : '']" v-for="(item, index) in dataList"
					:key="index">
					<view class="flex-box">
						<view class="share">
							<image src="../../static/fenxiang.png" v-if="item.status !== 1"></image>
							<block v-else>
								<image src="../../static/fenxiang-on.png" @click="onShare(item)"
									v-if="item.auth_shareability === 1 && item.lock.online == 1"></image>
								<image src="../../static/fenxiang-hui.png" @click="onShare(item)" v-else></image>
							</block>
						</view>
						<view class="site" @click="changeSite(index,item)">
							<image src="../../static/shezhi.png" v-if="item.status !== 1"></image>
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
					<view class="indate" v-if="item.lock">{{ item.auth_endtime1 }}</view>
					<view class="key">
						<view class="btn btn-on" v-if="item.status !== 1">
							<i class="iconfont icon-yuechi icon-default icon-on" v-if="item.device_type === 'lock'"></i>
							<i class="iconfont icon-shandian icon-default icon-on"
								v-if="item.device_type === 'switch'"></i>
							<i class="iconfont icon-laba icon-default icon-on" v-if="item.device_type === 'horn'"></i>
						</view>
						<block v-else>
							<block v-if="item.lock.online === 1">
								<view class="btn" @click="unlocking(item)" v-if="item.device_type === 'lock'">
									<i class="iconfont icon-yuechi icon-default"></i>
								</view>
								<view class="btn" @click="onSwitch(item)" v-if="item.device_type === 'switch'">
									<i class="iconfont icon-shandian icon-default"></i>
								</view>
								<view class="btn" @click="onPlay(item)" v-if="item.device_type === 'horn'">
									<i class="iconfont icon-laba icon-default"></i>
								</view>
							</block>
							<block v-else>
								<view class="btn offline" @click="offline(item)" v-if="item.device_type === 'lock'">
									<i class="iconfont icon-yuechi icon-default"></i>
								</view>
								<view class="btn offline" @click="offline(item)" v-if="item.device_type === 'switch'">
									<i class="iconfont icon-shandian icon-default"></i>
								</view>
								<view class="btn offline" @click="offline(item)" v-if="item.device_type === 'horn'">
									<i class="iconfont icon-laba icon-default"></i>
								</view>
							</block>

						</block>

					</view>
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
									<view class="text">实时状态</view>
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
									@click="goDetail('/pages/doorCardList/doorCardList?lock_id=' + item.lock_id)"
									v-if="item.lock_ability.card_status === 1">
									<i class="iconfont icon-menjin"></i>
									<view class="text">门卡管理</view>
								</view>


								<view class="cell-item"
									@click="goDetail('/pages/audioConfig/audioConfig?lock_id=' + item.lock_id)"
									v-if="item.lock_ability.audioConfig_status === 1">
									<i class="iconfont icon-menjin"></i>
									<view class="text">语音设置</view>
								</view>
								<view class="cell-item"
									@click="goDetail('/pages/transfer/transfer?lockauth_id=' + item.lockauth_id)">
									<i class="iconfont icon-a-zhuanyi2"></i>
									<view class="text">转移权限</view>
								</view>

							</block>
							<view class="cell-item"
								@click="goDetail('/pages/faceList/faceList?lock_id=' + item.lock_id)"
								v-if="item.lock_ability.face_status === 1">
								<i class="iconfont icon-renlianshibie"></i>
								<view class="text">人脸管理</view>
							</view>

							<view class="cell-item" @click="onDelete(item)">
								<i class="iconfont icon-shanchu"></i>
								<view class="text" style="color: #FF0000;">删&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;除
								</view>
							</view>
						</view>
					</view>
				</view>
			</view>
			<view class="site-mask" v-if="showMask" @click="clickMask"></view>
			<uni-load-more :status="noMore" empty_text="暂无数据～" style="margin-top: 40rpx;"></uni-load-more>

		</view>

		<view type="center" class="horn-popup" @touchmove.stop.prevent v-if="showHornBox" @click="showHornBox = false">
			<view class="cell-box">
				<view class="content-box" @click.stop>
					<view class="cell-item">
						<view class="label">内容：</view>
						<input placeholder="请输入播放内容" placeholder-class="placeholder" v-model="tts" />
					</view>
					<view class="cell-item">
						<view class="label">音量：</view>
						<input placeholder="请输入播放音量" type="number" placeholder-class="placeholder" v-model="volume" />
					</view>
					<view class="born-btn" @click.stop="playhorn">立即播放</view>
				</view>
			</view>
		</view>

		<!-- 隐私协议 -->

		<!-- #ifdef MP-WEIXIN -->
		<privacy-popup ref="privacyComponent"></privacy-popup>
		<!-- #endif -->

	</view>
</template>

<script>
	import device from '../../module/device/index.js'
	import ble from '../../module/ble/index.js'
	import lockServer from '../../module/device/lock.js'
	import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue';
	import {
		wechatoauth_api,
		getDeviceGroup_api,
		deviceList_api,
		openLock_api,
		turnOn_api,
		turnOff_api,
		delDevice_api,
		loginQrCode_api,
		playHorn_api
	} from "../../api/index.js";
	import {
		setToken,
		getToken
	} from "../../libs/auth.js"
	import {
		getQueryString
	} from '../../libs/utils.js'
	export default {
		components: {
			PrivacyPopup
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
				volume: 5, // 音量大小
				tts: '', //播放内容
				hornItem: {},
				longitude: '',
				latitude: '',
			}
		},
		onLoad(option) {
			console.log('option', option)
			if (option.q) {
				let scene = decodeURIComponent(option.q) // 使用decodeURIComponent解析  获取当前二维码的网址
				let paramobj = getQueryString(scene).key
				this.loginQrCode(paramobj)
			}


			this.dataList = []
			this.page = 1
			this.getDeviceGroup()

			// #ifdef MP-WEIXIN
			this.getLocation()
			// #endif
		},
		onShow() {
			
			this.$refs.privacyComponent.csinit()
		},
		onHide() {
			// #ifdef MP-WEIXIN
			ble.CloseBluetoothAdapter()
			// #endif
		},
		methods: {
			// 小程序扫码登录
			async loginQrCode(key) {
				let res = await loginQrCode_api({
					key: key
				})
			},
			unlocking(item) {
				item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
				uni.showLoading({
					title: '响应中...',
					mask: true
				})
				this.openLock(item)
				this.$forceUpdate()
			},
			// 开锁
			async openLock(item) {
				let res = await openLock_api({
					lockauth_id: item.lockauth_id,
					longitude: this.longitude,
					latitude: this.latitude
				})
				item.status = 1
				uni.hideLoading()
				if (res.code === 0) {
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
					}

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
			},
			// 开/关动作
			onSwitch(item) {
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
			// 播放
			onPlay(item) {
				this.showHornBox = true
				this.hornItem = item
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
					longitude: this.longitude,
					latitude: this.latitude
				})
				if (res.code === 0) {
					this.hornItem.status = 1
					this.$forceUpdate();
					this.showHornBox = false
					uni.showToast({
						title: '播放成功',
						icon: 'none',
					})
					this.tts = ''

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
				uni.login({
					provider: 'weixin',
					success: async (loginRes) => {
						let res = await wechatoauth_api({
							code: loginRes.code
						})
						if (res.code === 0) {
							setToken(res.data.token)
						}
					}
				})
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
				console.log("DeviceInfo：", DeviceInfo)
				if (DeviceInfo.lock.lock_sn.indexOf('WMJ62') > -1) {
					ble.OpenBluetoothAdapter()
					await device.OpenLockBle(DeviceInfo.lock.lock_sn, DeviceInfo.lock.lock_id)
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
			getLocation() {
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
											// that.getAddress()
										}
									});
								} else {
									console.log('取消');
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
						console.log('地址', res)
						this.latitude = res.latitude
						this.longitude = res.longitude
						uni.setStorageSync('location', {
							latitude: this.latitude,
							longitude: this.longitude
						})
					},
					fail: function(err) {
						console.log(err);
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

			}
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++; //每触底一次 page +1
			this.getList();
		},
		async onPullDownRefresh() {
			let that = this;
			this.page = 1;

			that.dataList = [];
			await that.getList();
			uni.stopPullDownRefresh();
		}
	}
</script>

<style scoped lang="scss">
	@import './index.scss';
</style>