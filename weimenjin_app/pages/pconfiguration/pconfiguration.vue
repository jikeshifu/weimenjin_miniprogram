<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view class="top-box">
        <view class="cell-item">
          <view class="flex-box">
            <view class="label">设备序列号(SN)</view>
            <input placeholder="可点击查找附近设备获取" v-model="device_sn" placeholder-class="placeholder" @input="updateCache('device_sn', device_sn)" />
          </view>
          <image src="../../static/saomiao.png" @click="scanCode"></image>
        </view>
        <view class="cell-item">
          <view class="label">devkey</view>
          <input placeholder="请输入devkey" placeholder-class="placeholder" v-model="formData.devkey" @input="updateCache('devkey', formData.devkey)" />
        </view>
        <view class="cell-item">
          <view class="label">appkey</view>
          <input placeholder="请输入appkey" placeholder-class="placeholder" v-model="formData.appkey" @input="updateCache('appkey', formData.appkey)" />
        </view>
        <view class="cell-item">
          <view class="label">server</view>
          <input placeholder="请输入域名或IP" placeholder-class="placeholder" v-model="formData.mqtthost" @input="updateCache('mqtthost', formData.mqtthost)" />
        </view>
        <view class="cell-item">
          <view class="label">sm4key</view>
          <input placeholder="请输入sm4key" placeholder-class="placeholder" v-model="formData.sm4key" @input="updateCache('sm4key', formData.sm4key)" />
        </view>
        <view class="cell-item">
          <view class="label">sm4offset</view>
          <input placeholder="请输入sm4offset" placeholder-class="placeholder" v-model="formData.sm4offset" @input="updateCache('sm4offset', formData.sm4offset)" />
        </view>
      </view>
      <view class="bottom-box">
        <view class="bottom-btn" @click="searchDevice">查找附近设备</view>
        <view class="bottom-btn" @click="DeviceNetWorkSet">设置</view>
      </view>
      <view class="explain">
        <view class="text">1.本功能适用于私有化部署硬件云</view>
        <view class="text">2.使用前请打开手机蓝牙</view>
        <view class="text">3.确保设备进入配网模式</view>
      </view>
    </view>
  </view>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import bleServer from '../../module/ble/server.js';
import Ble from '../../module/ble/index.js';

export default {
  setup() {
    const device_sn = ref("");
    const formData = reactive({
      device_pwd: "12345687",
      devkey: "",
      appkey: "",
      mqtthost: "",
      sm4key: "",
      sm4offset: ""
    });
    const loadingVisible = ref(false);

    onMounted(() => {
      const cachedData = uni.getStorageSync("bluetoothPCFormData") || {};
      device_sn.value = cachedData.device_sn || "";
      formData.devkey = cachedData.devkey || "";
      formData.appkey = cachedData.appkey || "";
      formData.mqtthost = cachedData.mqtthost || "";
      formData.sm4key = cachedData.sm4key || "";
      formData.sm4offset = cachedData.sm4offset || "";
    });

    const updateCache = (key, value) => {
      const cachedData = uni.getStorageSync("bluetoothPCFormData") || {};
      cachedData[key] = value;
      uni.setStorageSync("bluetoothPCFormData", cachedData);
    };

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
          loadingVisible.value = false;
        }
      }
    };

    const DeviceNetWorkSet = async () => {
      showLoading("正在配网...");
      uni.setStorageSync("bluetoothPCFormData", formData);

      if (!device_sn.value) {
        hideLoading();
        uni.showToast({
          title: "设备序列号不能为空",
          icon: 'none',
        });
        return;
      }

      let bleDeviceInfoRes = await bleServer.SearchDevicewBleName(device_sn.value);
      if (bleDeviceInfoRes.err != null) {
        hideLoading();
        uni.showToast({
          title: bleDeviceInfoRes.err,
          icon: 'none',
        });
        return;
      }

      await bleServer.ConnectionBle(bleDeviceInfoRes.data.deviceId);

      await Ble.NotifyBLECharacteristicValueChange(
        bleDeviceInfoRes.data.deviceId,
        "00000D38-0000-1000-8000-00805F9B34FB",
        "000033FF-0000-1000-8000-00805F9B34FB"
      );

      let WriteBLECharacteristicValueRes = await bleServer.WriteBLECharacteristicValue(
        bleDeviceInfoRes.data.deviceId,
        "00000D38-0000-1000-8000-00805F9B34FB",
        "000033FF-0000-1000-8000-00805F9B34FB",
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
          mask: true,
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

      let itemList6 = itemList.length > 6 ? itemList.slice(0, 6) : itemList;

      uni.showActionSheet({
        itemList: itemList6,
        success(res) {
          device_sn.value = itemList[res.tapIndex];
          updateCache('device_sn', device_sn.value);
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
          updateCache('device_sn', device_sn.value);
          console.log(res);
        }
      });
    };

    return {
      device_sn,
      formData,
      DeviceNetWorkSet,
      searchDevice,
      scanCode,
      updateCache
    };
  }
};
</script>

<style scoped lang="scss">
  .big-box {
  	height: 100%;
  	.background {
  		width: 100%;
  		height: 352rpx;
  		background: rgb(33, 207, 62);
  		opacity: 0.2;
  		box-shadow: 0px 8rpx 374rpx rgb(58, 137, 254);
  		filter: blur(120rpx);
  		position: absolute;
  		top: 0;
  		left: 0;
  	}
  	.content {
  		height: 100%;
  		display: flex;
  		flex-direction: column;
  		overflow: hidden;
  		position: relative;
  		z-index: 10;
  		.top-box {
  			margin: 0 30rpx;
  			.cell-item {
  				display: flex;
  				align-items: center;
  				justify-content: space-between;
  				height: 140rpx;
  				background: linear-gradient(180.00deg, rgb(255, 255, 255),rgba(255, 255, 255, 0.4) 100%);
  				box-shadow: 16rpx 16rpx 66rpx rgba(117, 160, 232, 0.2);
  				border-radius:24rpx;
  				margin-top: 36rpx;
  				padding: 0 40rpx;
  				overflow: hidden;
  				image {
  					width: 30rpx;
  					height: 30rpx;
  				}
  				.label {
  					font-size: 28rpx;
  					flex-shrink: 0;
  				}
  				input {
  					font-size: 28rpx;
  					flex: 1;
  					margin-left: 30rpx;
  					height: 100%;
  				}
  				.flex-box {
  					display: flex;
  					align-items: center;
  					height: 100%;
  					flex: 1;
  					margin-right: 40rpx;
  					input {
  						text-align:left !important;
  						width: 100%;
  					}
  					
  				}
  				.right-box {
  					display: flex;
  					align-items: center;
  					flex: 1;
  					height: 100%;
  					justify-content: flex-end;
  					.text {
  						margin-right: 30rpx;
  						font-size: 28rpx;
  					}
  					image {
  						width: 16rpx;
  						height: 22rpx;
  					}
  				}
  			}
  		}
  		.bottom-box {
  			display: flex;
  			align-items: center;
  			justify-content: space-around;
  			margin: 0 30rpx;
  		}
  		.bottom-btn {
  			flex: 1;
  			margin: 60rpx 20rpx;
  			height: 90rpx;
  			background: rgb(33, 207, 62);
  			box-shadow: 16rpx 16rpx 66rpx rgba(117, 160, 232, 0.3);
  			border-radius:100rpx;
  			display: flex;
  			align-items: center;
  			justify-content: center;
  			font-size: 28rpx;
  			color: #fff;
  		}
  	}
  	
  }
  ::v-deep .placeholder {
  	font-size: 28rpx;
  	color: #999999;
  }
  .explain {
  	margin: 20rpx 40rpx 0;
  	font-size: 28rpx;
  	opacity: 0.7;
  	.text {
  		margin-bottom: 20rpx;
  	}
  }
</style>