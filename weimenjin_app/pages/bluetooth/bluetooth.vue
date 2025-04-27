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
			<view class="bottom-box">
				<view class="bottom-btn" @click="navigateToPconfiguration">硬件云配置</view>
			</view>
		</view>
	</view>
</template>

<script>
	import {
		ref,
		reactive,
		onMounted
	} from 'vue';
	import bleServer from '../../module/ble/server.js';
	import Ble from '../../module/ble/index.js';

	export default {
		setup() {
			const device_sn = ref("");
			const formData = reactive({
				wifi_name: "",
				wifi_pwd: "",
				device_pwd: "12345687",
			});
			const loadingVisible = ref(false);

			onMounted(async () => {
				const bluetoothFormData = uni.getStorageSync("bluetoothFormData");
				if (bluetoothFormData) {
					formData.wifi_name = bluetoothFormData.wifi_name;
					formData.wifi_pwd = bluetoothFormData.wifi_pwd;
				}

				// 初始化蓝牙
				const openBluetoothAdapter = await Ble.OpenBluetoothAdapter();
				if (openBluetoothAdapter.err != null) {
					console.log(openBluetoothAdapter);
					uni.showToast({
						icon: "none",
						title: openBluetoothAdapter.err,
						duration: 2000,
					});
					return;
				}
			});

			const showLoading = (message) => {
				if (!loadingVisible.value) {
					loadingVisible.value = true;
					uni.showLoading({
						title: message,
						mask: true,
					});
				}
			};

			const hideLoading = () => {
				if (loadingVisible.value) {
					try {
						uni.hideLoading();
						loadingVisible.value = false;
					} catch (e) {
						console.warn('hideLoading failed:', e);
					} finally {
						loadingVisible.value = false; // 确保最终设置为 false，避免多次尝试隐藏
					}
				}
			};

			const DeviceNetWorkSet = async () => {
				showLoading("正在配网...");

				uni.setStorageSync("bluetoothFormData", formData);
				if (!device_sn.value) {
					hideLoading();
					uni.showToast({
						title: "设备序列号不能为空",
						icon: 'none',
					});
					return;
				}

				// 开启搜索找到设备
				let bleDeviceInfoRes = await bleServer.SearchDevicewBleName(device_sn.value);
				if (bleDeviceInfoRes.err != null) {
					hideLoading();
					uni.showToast({
						title: bleDeviceInfoRes.err,
						icon: 'none',
					});
					return;
				}

				// 连接上设备
				await bleServer.ConnectionBle(bleDeviceInfoRes.data.deviceId);

				// 订阅特征值
				await Ble.NotifyBLECharacteristicValueChange(
					bleDeviceInfoRes.data.deviceId,
					"00000D38-0000-1000-8000-00805F9B34FB",
					"000032FF-0000-1000-8000-00805F9B34FB",
					"000031FF-0000-1000-8000-00805F9B34FB",
				);

				let WriteBLECharacteristicValueRes = await bleServer.WriteBLECharacteristicValue(
					bleDeviceInfoRes.data.deviceId,
					"00000D38-0000-1000-8000-00805F9B34FB",
					"000031FF-0000-1000-8000-00805F9B34FB",
					JSON.stringify(formData)
				);
				if (typeof WriteBLECharacteristicValueRes.data === 'string') {
					WriteBLECharacteristicValueRes.data = JSON.parse(WriteBLECharacteristicValueRes.data);
				}

				hideLoading();
				if (WriteBLECharacteristicValueRes.err != null) {
					uni.showToast({
						title: WriteBLECharacteristicValueRes.err,
						icon: 'none',
					});
					return;
				}

				let bleDataS = WriteBLECharacteristicValueRes.data;
				let data = bleDataS.state;
				if (data == 1) {
					uni.showToast({
						title: "配置成功",
						mask: true, // 是否显示透明蒙层，防止触摸穿透
						duration: 2000,
					});
				} else {
					uni.showToast({
						title: "配置失败",
						icon: 'none',
					});
				}
			};

			const searchDevice = async () => {
				showLoading("正在搜索设备...");

				// 开启搜索
				await bleServer.SearchDevice();
				let GetBluetoothDevicesRes = await Ble.GetBluetoothDevices();
				console.log("GetBluetoothDevicesRes:", GetBluetoothDevicesRes);
				hideLoading();
				if (GetBluetoothDevicesRes.err != null) {
					uni.showToast({
						icon: "none",
						title: GetBluetoothDevicesRes.err,
						duration: 2000,
					});
					return;
				}
				if (GetBluetoothDevicesRes.devices.length < 1) {
					uni.showToast({
						icon: "none",
						title: "没有发现设备请重试",
						duration: 2000,
					});
					return;
				}
				let itemList = [];
				GetBluetoothDevicesRes.devices.forEach(function(item) {
					if (item.name) {
						itemList.push(item.name);
					} else if (item.localName) {
						itemList.push(item.localName);
					}
				});
				let itemList6 = itemList;
				if (itemList.length > 6) {
					itemList6 = itemList.slice(0, 6);
				}

				uni.showActionSheet({
					itemList: itemList6,
					success(res) {
						device_sn.value = itemList[res.tapIndex];
						uni.setClipboardData({
							data: itemList[res.tapIndex],
							success(res) {
								console.log('success', res);
								uni.showToast({
									title: "复制序列号成功",
								});
							}
						});
					},
					fail(res) {
						console.log(res.errMsg);
					}
				});
			};

			const scanCode = () => {
				uni.scanCode({
					success: (res) => {
						device_sn.value = res.result;
						console.log(res);
					}
				});
			};
			const navigateToPconfiguration = () => {
				uni.navigateTo({
					url: '/pages/pconfiguration/pconfiguration'
				});
			};
			return {
				device_sn,
				formData,
				DeviceNetWorkSet,
				searchDevice,
				scanCode,
				navigateToPconfiguration,
			};
		}
	};
</script>

<style scoped lang="scss">
	@import './bluetooth.scss';
</style>