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
				<view class="device-name">{{ formData.linkspeaker_name || '请选择序列号以显示名称' }}</view>
			</view>

			<view class="form-item">
				<text class="label">播放内容：</text>
				<textarea class="textarea" placeholder="请输入播放内容" placeholder-class="placeholder" v-model="formData.linkspeaker_tts"></textarea>
			</view>

			<view class="form-item">
				<text class="label">音量：</text>
				<picker mode="selector" :range="volumeLevels" :value="formData.linkspeaker_volume" @change="onVolumeChange">
					<view class="picker">
						{{ formData.linkspeaker_volume || '请选择音量' }}
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
  addlinkspeaker_api,
  editlinkspeaker_api,
  getlinkspeakerBySn_api // 确保引入接口
} from '@/api/index.js'
export default {
  data() {
    return {
      formData: {
        lock_id: '',
        linkspeaker_sn: '',
        linkspeaker_name: '',
        linkspeaker_tts: '',
        linkspeaker_volume: ''
      },
      deviceOptions: [], // 存储设备选项，包含设备名称和序列号的组合
      selectedDeviceIndex: -1, // 当前选择的设备索引
      volumeLevels: ['1', '2', '3', '4', '5', '6', '7'], // 音量选择范围
      verifyData: {
        lock_id: '缺少锁ID',
        linkspeaker_tts: '请输入播放内容',
        linkspeaker_sn: '请选择联动喇叭',
        linkspeaker_volume: '请选择音量',
      },
      isEdit: false
    }
  },
  async onLoad(option) {
    console.log("onLoad options:", option);
    this.formData.lock_id = option.lock_id || '';
    this.isEdit = !!option.sn;

    await this.fetchDeviceOptions(); // 调用接口获取设备选项

    // 如果是编辑模式，通过序列号获取联动喇叭信息
    if (option.sn) {
      await this.fetchSpeakerData(option.sn); // 通过接口获取设备详情
    }
  },
  methods: {
    // 获取联动喇叭信息
    async fetchSpeakerData(linkspeaker_sn) {
      try {
        const res = await getlinkspeakerBySn_api({ linkspeaker_sn }); // 请求接口
        if (res.code === 0 && res.data) {
          this.formData = {
            ...this.formData,
            linkspeaker_sn: res.data.linkspeaker_sn,
            linkspeaker_name: res.data.linkspeaker_name,
            linkspeaker_tts: res.data.linkspeaker_tts,
            linkspeaker_volume: String(res.data.linkspeaker_volume) // 确保音量为字符串
          };
          
          // 设置 selectedDeviceIndex 以匹配返回的设备序列号
          this.selectedDeviceIndex = this.deviceOptions.findIndex(device => device.lock_sn === res.data.linkspeaker_sn);
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
            .filter(device => device.lock_sn.startsWith('W70'))
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
      this.formData.linkspeaker_sn = selectedDevice.lock_sn;
      this.formData.linkspeaker_name = selectedDevice.lock_name; // 同步设备名称
    },
    // 当选择音量时触发
    onVolumeChange(e) {
      this.formData.linkspeaker_volume = this.volumeLevels[e.detail.value];
    },
    async onSubmit() {
      for (let key in this.formData) {
        if (!this.formData[key] && this.verifyData[key]) {
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
        res = await addlinkspeaker_api(this.formData);
      } else {
        res = await editlinkspeaker_api(this.formData);
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
	.textarea {
		width: 100%;
		height: 200rpx;
		background-color: #f4f4f4;
		border-radius: 8rpx;
		padding: 20rpx;
		font-size: 28rpx;
		color: #333333;
		box-sizing: border-box;
		overflow: hidden;
		resize: none;
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
