<template>
	<view class="container">
		<view class="form-section">
			<view class="form-item">
				<text class="label">序列号：</text>
				<picker mode="selector" :range="deviceOptions" range-key="displayName" :value="selectedDeviceIndex" @change="onDeviceChange">
					<view class="picker">
						{{ deviceOptions[selectedDeviceIndex]?.displayName || '请选择序列号' }}
					</view>
				</picker>
			</view>
			
			<!-- 显示设备名称 -->
			<view class="form-item">
				<text class="label">设备名称：</text>
				<view class="device-name">{{ formData.linkswitch_name || '请选择序列号以显示名称' }}</view>
			</view>

			<view class="form-item">
				<text class="label">开门后：</text>
				<picker mode="selector" :range="openOptions" :value="formData.open_action" @change="onOpenActionChange">
					<view class="picker">
						{{ openOptions[formData.open_action] || '请选择开电方式' }}
					</view>
				</picker>
			</view>

			<view class="form-item">
				<text class="label">开电后：</text>
				<picker mode="selector" :range="closeOptions" :value="formData.close_delay" @change="onCloseDelayChange">
					<view class="picker">
						{{ closeOptions[formData.close_delay] || '请选择关电延时' }}
					</view>
				</picker>
			</view>
		</view>

		<view class="submit-btn" @click="onSubmit">立即提交</view>
	</view>
</template>

<script>
import {
  getuserdevices_api,
  addlinkswitch_api,
  editlinkswitch_api,
  getlinkswitchBySn_api
} from '@/api/index.js'
export default {
  data() {
    return {
      formData: {
        lock_id: '',
        linkswitch_sn: '',
        linkswitch_name: '',
        open_action: 0, // 用于开门后立即开电或延迟分钟数
        close_delay: 0  // 用于关电的延迟时间
      },
      deviceOptions: [], // 存储设备选项，包含设备名称和序列号的组合
      selectedDeviceIndex: -1, // 当前选择的设备索引
      openOptions: ['立即开电', '延迟1分钟', '延迟5分钟', '延迟10分钟', '延迟30分钟'], // 开门后开电选项
      closeOptions: ['不自动关电', '1分钟后关电', '5分钟后关电', '10分钟后关电', '30分钟后关电'], // 关电延时选项
      verifyData: {
        lock_id: '缺少锁ID',
        linkswitch_sn: '请选择联动空开',
        open_action: '请选择开电方式',
        close_delay: '请选择关电延时'
      },
      isEdit: false
    }
  },
  async onLoad(option) {
    console.log("onLoad options:", option);
    this.formData.lock_id = option.lock_id || '';
    this.isEdit = !!option.sn;

    await this.fetchDeviceOptions(); // 调用接口获取设备选项

    // 如果是编辑模式，通过序列号获取联动空开信息
    if (option.sn) {
      await this.fetchSwitchData(option.sn); // 通过接口获取设备详情
    }
  },
  methods: {
    // 获取联动空开信息
    async fetchSwitchData(linkswitch_sn) {
      try {
        const res = await getlinkswitchBySn_api({ linkswitch_sn }); // 请求接口
        if (res.code === 0 && res.data) {
          this.formData = {
            ...this.formData,
            linkswitch_sn: res.data.linkswitch_sn,
            linkswitch_name: res.data.linkswitch_name,
            open_action: res.data.open_action,
            close_delay: res.data.close_delay
          };
          
          // 设置 selectedDeviceIndex 以匹配返回的设备序列号
          this.selectedDeviceIndex = this.deviceOptions.findIndex(device => device.lock_sn === res.data.linkswitch_sn);
        } else {
          this.showToast(res.msg || '获取设备数据失败');
        }
      } catch (error) {
        this.showToast('请求设备数据失败');
      }
    },
    // 获取设备选项
    async fetchDeviceOptions() {
      try {
        const res = await getuserdevices_api();
        if (res.code === 0) {
          this.deviceOptions = res.data
            .filter(device => device.lock_sn.startsWith('W71'))
            .map(device => ({
              ...device,
              displayName: `${device.lock_name} (${device.lock_sn})` // 拼接名称和序列号
            }));
        } else {
          this.showToast(res.msg || '获取设备失败');
        }
      } catch (error) {
        this.showToast('请求设备数据失败');
      }
    },
    // 当选择序列号时触发
    onDeviceChange(e) {
      this.selectedDeviceIndex = e.detail.value;
      const selectedDevice = this.deviceOptions[this.selectedDeviceIndex];
      this.formData.linkswitch_sn = selectedDevice.lock_sn;
      this.formData.linkswitch_name = selectedDevice.lock_name; // 同步设备名称
    },
    // 当选择开电方式时触发
    onOpenActionChange(e) {
      this.formData.open_action = e.detail.value;
    },
    // 当选择关电延时时触发
    onCloseDelayChange(e) {
      this.formData.close_delay = e.detail.value;
    },
    async onSubmit() {
      for (let key in this.formData) {
        if (this.verifyData[key] && !this.formData[key] && this.formData[key] !== 0) {
          this.showToast(this.verifyData[key]);
          return false;
        }
      }
      uni.showLoading({
        title: '提交中...',
        mask: true
      });
      let res;
      if (!this.isEdit) {
        res = await addlinkswitch_api(this.formData);
      } else {
        res = await editlinkswitch_api(this.formData);
      }
      uni.hideLoading();
      if (res.code === 0) {
        this.showToast('操作成功!');
		uni.setStorageSync('shouldRefreshDeviceList', true); // 设置刷新标记
        setTimeout(() => {
          uni.navigateBack({ delta: 1 });
        }, 1000);
      } else {
        this.showToast(res.msg || '操作失败');
      }
    },
    showToast(msg) {
      uni.showToast({
        title: msg,
        icon: 'none',
        mask: true
      });
    }
  }
}
</script>


<style scoped lang="scss">
	.container {
		padding: 20rpx;
		background-color: #f8f9fb;
		height: 100%;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}
	.form-section {
		background-color: #ffffff;
		padding: 20rpx;
		border-radius: 16rpx;
		box-shadow: 0 4rpx 16rpx rgba(0, 0, 0, 0.1);
	}
	.form-item {
		margin-bottom: 20rpx;
	}
	.label {
		font-size: 28rpx;
		color: #333333;
		margin-bottom: 8rpx;
	}
	.device-name {
		font-size: 28rpx;
		color: #666666;
		margin-left: 20rpx;
	}
	.picker {
		height: 90rpx;
		line-height: 90rpx;
		background-color: #f4f4f4;
		border-radius: 8rpx;
		padding: 0 20rpx;
		font-size: 28rpx;
		color: #666666;
	}
	.submit-btn {
		width: 90%;
		height: 90rpx;
		background-color: #1aad19;
		border-radius: 8rpx;
		text-align: center;
		line-height: 90rpx;
		font-size: 32rpx;
		color: #ffffff;
		font-weight: bold;
		box-shadow: 0 4rpx 16rpx rgba(0, 0, 0, 0.2);
		position: fixed;
		bottom: 30rpx;
		left: 5%;
	}

	::v-deep .placeholder {
		font-size: 28rpx;
		color: #999999;
	}
</style>
