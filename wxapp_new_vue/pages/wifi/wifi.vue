<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">设备序列号</view>
						<input v-model="data.device_ssid" placeholder="请输入设备序列号" placeholder-class="placeholder"
							:focus="focusLink === 'device_ssid'" @focus="focusClick('device_ssid')" />

					</view>
					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>
				<view class="cell-item">
					<view class="label">WiFi信号名称</view>
					<input placeholder="请输入WiFi信号名称" v-model="data.ssid" placeholder-class="placeholder"
						:focus="focusLink === 'ssid'" @focus="focusClick('ssid')" />
				</view>

				<view class="cell-item">
					<view class="flex-box">
						<view class="label">WiFi密码</view>
						<input placeholder="请输入WiFi密码" v-model="data.pwd" :password="inputType"
							placeholder-class="placeholder" :focus="focusLink === 'pwd'" @focus="focusClick('pwd')" />
					</view>
					<i class="iconfont icon-bukejian" v-if="inputType" @click="inputType = !inputType"></i>
					<i class="iconfont icon-kejian" v-else @click="inputType = !inputType"></i>
				</view>

			</view>
			<view class="bottom-box">
				<view class="bottom-btn" @click="set_wifi">确定</view>
			</view>

			<view class="explain">
				<view class="text">1.仅支持2.4GHz频段，非中文信号名称</view>
				<view class="text">2.多开微信无权限调用WiFi接口</view>
			</view>
		</view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				data: {
					device_ssid: "",
					join_wifi: false,
					ssid: "",
					pwd: ""
				},
				inputType: true,
				focusLink: ''
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {},
		onShow() {
			let WifiData = uni.getStorageSync("WifiData")
			//初始化蓝牙
			if (WifiData) {
				this.data = WifiData
			}
		},
		methods: {
			focusClick(key) {
				setTimeout(() => {
					this.focusLink = key;
				}, 500)
			},
			scanCode() {
				let _this = this
				uni.scanCode({
					success: (res) => {
						_this.data.device_ssid = res.result
						// 二维码内容
						console.log(res)
					}
				});
			},
			show_toast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask: true
				})
			},
			set_device() {
				if (!this.data.device_ssid) {
					this.show_toast("请先获取设备序列号")
					return;
				}
				uni.showLoading({
					title: "正在连接设备...",
					mask: true
				})
				var _this = this;
				uni.startWifi({
					success: (startWifiRes) => {
						console.log("startWifiRes", startWifiRes)
						//连接wifi
						uni.connectWifi({
							SSID: this.data.device_ssid,
							password: "",
							forceNewApi: true,
							success: (res) => {
								setTimeout(() => {
									_this.show_toast("设备连接成功")
									//连接成功后去配网
									_this.set_wifi();
								}, 500)
								//关闭wifi模块
								uni.stopWifi()
							},
							fail(err) {
								console.log("err", err)
								setTimeout(() => {
									_this.show_toast("请检查设备是否进入了配网模式或是否已打开WiFi！")
								}, 500)
							},
							complete() {
								_this.data.join_wifi = true;
								uni.hideLoading();
							}
						})
					},
					fail: (res) => {
						uni.hideLoading();
						setTimeout(() => {
							_this.show_toast("请使用手机进行操作！")
						}, 500)
					},
				});

			},
			set_wifi() {
				uni.setStorageSync("WifiData", this.data)
				if (!this.data.device_ssid) {
					this.show_toast("请先获取设备序列号(SN)")
					return;
				}
				if (!this.data.join_wifi) {
					this.set_device();
					return;
				}

				if (!this.data.ssid) {
					this.show_toast("WiFi名称不能为空")
					return;
				}
				if (!this.data.pwd) {
					this.show_toast("密码不能为空")
					return;
				}
				uni.setStorageSync("wifi_name", this.data.ssid);
				uni.setStorageSync("wifi_pwd", this.data.pwd);
				uni.showLoading({
					title: "正在配网中...",
					mask: true
				})
				let _this = this;
				uni.request({
					url: 'http://192.168.11.1',
					method: 'POST',
					timeout: 10000,
					data: {
						ssid: this.data.ssid,
						passwd: this.data.pwd,
					},
					success: (res) => {
						_this.data.restart = true;
						console.log('返回', res)
						if (res.data.state === 0) {
							_this.show_toast("配置成功")
							return;
						}
						if (res.data.state === 1) {
							_this.show_toast("配置失败")
							return;
						}
						if (res.data.state === 2) {
							_this.show_toast("WiFi连接失败")
							return;
						}
					},
					fail() {
						uni.hideLoading();
						_this.show_toast("请检查手机是否连上配置信号")
						_this.data.join_wifi = false;
					}
				});
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './wifi.scss';
</style>