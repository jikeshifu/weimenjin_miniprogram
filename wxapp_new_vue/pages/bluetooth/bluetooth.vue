<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">设备序列号(SN)</view>
						<input placeholder="可点击查找附近设备获取" v-model="device_sn" placeholder-class="placeholder" />

					</view>
					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>
				<view class="cell-item">
					<view class="label">Wi-Fi名称</view>
					<input placeholder="请输入Wi-Fi名称" placeholder-class="placeholder" v-model="formData.wifi_name" />
				</view>

				<view class="cell-item">
					<view class="label">Wi-Fi密码</view>
					<input placeholder="请输入Wi-Fi密码" placeholder-class="placeholder" v-model="formData.wifi_pwd" />
				</view>

			</view>
			<view class="bottom-box">
				<view class="bottom-btn" @click="searchDevice">查找附近设备</view>
				<view class="bottom-btn" @click="DeviceNetWorkSet">配网</view>
			</view>

			<view class="explain">
				<view class="text">1.本功能利用蓝牙给设备配置网络</view>
				<view class="text">2.使用前请打开手机蓝牙</view>
				<view class="text">3.确保设备进入配网模式</view>
			</view>
		</view>

	</view>
</template>

<script>
	import bleServer from '../../module/ble/server.js'
	import Ble from '../../module/ble/index.js'
	export default {
		data() {
			return {
				device_sn: "",
				formData: {
					wifi_name: "",
					wifi_pwd: "",
					device_pwd: "12345687",

				},
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {},
		async onShow() {
		 let bluetoothFormData=	uni.getStorageSync("bluetoothFormData")

			if(bluetoothFormData){
				  this.formData=  bluetoothFormData
			}
            		//初始化蓝牙
			let openBluetoothAdapter = await Ble.OpenBluetoothAdapter()
			if (openBluetoothAdapter.err != null) {
				console.log(openBluetoothAdapter)
				uni.showToast({
					icon: "none",
					title: openBluetoothAdapter.err,
					duration: 2000
				});
				return
			}


		},
		methods: {
			async DeviceNetWorkSet() {


				uni.setStorageSync("bluetoothFormData", this.formData)
				if (!this.device_sn) {
					uni.showToast({
						title: "设备序列号不能为空",
						icon: 'none',

					});
					return
				}
				//开启搜索找到设备
				let bleDeviceInfoRes = await bleServer.SearchDevicewBleName(this.device_sn)
				if (bleDeviceInfoRes.err != null) {
					uni.showToast({
						title: bleDeviceInfoRes.err,
						icon: 'none',

					});
					return
				}
				//连接上设备
				await bleServer.ConnectionBle(bleDeviceInfoRes.data.deviceId)
				//订阅特征值
				await Ble.NotifyBLECharacteristicValueChange(bleDeviceInfoRes.data.deviceId,
					"00000D38-0000-1000-8000-00805F9B34FB", "000032FF-0000-1000-8000-00805F9B34FB")

				let WriteBLECharacteristicValueRes = await bleServer.WriteBLECharacteristicValue(bleDeviceInfoRes.data
					.deviceId, "00000D38-0000-1000-8000-00805F9B34FB", "000031FF-0000-1000-8000-00805F9B34FB", JSON
					.stringify(this.formData))
				console.log("WriteBLECharacteristicValueRes", WriteBLECharacteristicValueRes)
				if (WriteBLECharacteristicValueRes.err != null) {
					uni.showToast({
						title: WriteBLECharacteristicValueRes.err,
						icon: 'none',

					});
					return
				}
				let bleDataS = WriteBLECharacteristicValueRes.data
				let data = bleDataS.substring(bleDataS.indexOf('{'), bleDataS.lastIndexOf('}') + 1);

				console.log("data:", data)
				let dataObj = JSON.parse(data)
				Ble.OpenBluetoothAdapter()
				if (dataObj.state === 1) {
					uni.showToast({
						title: "配置成功",

						mask: true, // 是否显示透明蒙层，防止触摸穿透
						duration: 2000
					});
					return
				} else {
					uni.showToast({
						title: "配置失败",
						icon: 'none',

					});
				}
			},
			async searchDevice() {


				//开启搜索
				await bleServer.SearchDevice()
				let GetBluetoothDevicesRes = await Ble.GetBluetoothDevices()
				console.log("GetBluetoothDevicesRes:",GetBluetoothDevicesRes)
				if(GetBluetoothDevicesRes.err !=null ) {
					uni.showToast({
						icon: "none",
						title: GetBluetoothDevicesRes.err,
						duration: 2000
					});
					return
				}
				if( GetBluetoothDevicesRes.devices.length<1) {
					uni.showToast({
						icon: "none",
						title: "没有发现设备请重试",
						duration: 2000
					});
					return
				}
				let itemList = [];
				GetBluetoothDevicesRes.devices.forEach(function(item, index) {
					if (item.name) {
						itemList.push(item.name)
					} else if (item.localName) {
						itemList.push(item.localName)
					}

					console.log("item", item, )
					console.log("index", index, )
				})
				let itemList6 = itemList
				if (itemList.length > 6) {
					itemList6 = itemList.slice(0, 6)
				}

				let _this = this
				uni.showActionSheet({
					itemList: itemList6,
					success(res) {
						_this.device_sn = itemList[res.tapIndex]
						uni.setClipboardData({
							data: itemList[res.tapIndex],
							success(res) {
								console.log('success', res);
								uni.showToast({
									title: "复制序列号成功",

								});
							}
						})

					},
					fail(res) {
						console.log(res.errMsg)
					}
				})


			},
			scanCode() {



			let _this =this
			uni.scanCode({
				success: (res) => {
					_this.device_sn =res.result
					// 二维码内容
					console.log(res)
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
	@import './bluetooth.scss';
</style>
