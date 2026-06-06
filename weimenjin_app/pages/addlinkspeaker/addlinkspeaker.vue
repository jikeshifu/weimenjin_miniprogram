<template>
  <view class="container">
    <view class="form-section">
      <!-- 序列号选择 -->
      <view class="form-item">
        <text class="label">序列号</text>
        <view class="picker" @click="toggleDeviceDropdown">
          <text>{{ deviceOptions[selectedDeviceIndex]?.displayName || '请选择序列号' }}</text>
          <text class="arrow">▼</text>
        </view>
        <view class="dropdown" v-if="showDeviceDropdown">
          <view
            v-for="(option, index) in deviceOptions"
            :key="index"
            class="dropdown-item"
            @click="selectDevice(index)"
          >
            {{ option.displayName }}
          </view>
        </view>
      </view>

      <!-- 设备名称 -->
      <view class="form-item">
        <text class="label">设备名称</text>
        <view class="device-name">{{ formData.linkspeaker_name || '请选择序列号以显示名称' }}</view>
      </view>

      <!-- 播放内容 -->
      <view class="form-item">
        <text class="label">播放内容</text>
        <textarea class="textarea" placeholder="请输入播放内容" placeholder-class="placeholder" v-model="formData.linkspeaker_tts"></textarea>
      </view>

      <!-- 音量 -->
      <view class="form-item">
        <text class="label">音量</text>
        <view class="picker" @click="toggleVolumeDropdown">
          <text>{{ formData.linkspeaker_volume || '请选择音量' }}</text>
          <text class="arrow">▼</text>
        </view>
        <view class="dropdown" v-if="showVolumeDropdown">
          <view
            v-for="(level, index) in volumeLevels"
            :key="index"
            class="dropdown-item"
            @click="selectVolume(level)"
          >
            {{ level }}
          </view>
        </view>
      </view>
    </view>

    <!-- 提交按钮 -->
    <view class="submit-btn" @click="onSubmit">立即提交</view>
  </view>
</template>

<script>
import {
  getuserdevices_api,
  addlinkspeaker_api,
  editlinkspeaker_api,
  getlinkspeakerBySn_api
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
      deviceOptions: [],
      selectedDeviceIndex: -1,
      volumeLevels: ['1', '2', '3', '4', '5', '6', '7'],
      showDeviceDropdown: false,
      showVolumeDropdown: false,
      verifyData: {
        lock_id: '缺少锁ID',
        linkspeaker_tts: '请输入播放内容',
        linkspeaker_sn: '请选择联动喇叭',
        linkspeaker_volume: '请选择音量'
      },
      isEdit: false
    }
  },
  async onLoad(option) {
    this.formData.lock_id = option.lock_id || '';
    this.isEdit = !!option.sn;

    await this.fetchDeviceOptions();

    if (option.sn) {
      await this.fetchSpeakerData(option.sn);
    }
  },
  methods: {
    async fetchSpeakerData(linkspeaker_sn) {
      try {
        const res = await getlinkspeakerBySn_api({ linkspeaker_sn });
        if (res.code === 0 && res.data) {
          this.formData = {
            ...this.formData,
            linkspeaker_sn: res.data.linkspeaker_sn,
            linkspeaker_name: res.data.linkspeaker_name,
            linkspeaker_tts: res.data.linkspeaker_tts,
            linkspeaker_volume: String(res.data.linkspeaker_volume)
          };
          this.selectedDeviceIndex = this.deviceOptions.findIndex(device => device.lock_sn === res.data.linkspeaker_sn);
        } else {
          this.showToast(res.msg || '获取设备数据失败');
        }
      } catch (error) {
        this.showToast('请求设备数据失败');
      }
    },
    async fetchDeviceOptions() {
      try {
        const res = await getuserdevices_api();
        if (res.code === 0) {
          this.deviceOptions = res.data
            .filter(device => device.lock_sn.startsWith('W70'))
            .map(device => ({
              ...device,
              displayName: `${device.lock_name} (${device.lock_sn})`
            }));
        } else {
          this.showToast(res.msg || '获取设备失败');
        }
      } catch (error) {
        this.showToast('请求设备数据失败');
      }
    },
    toggleDeviceDropdown() {
      this.showDeviceDropdown = !this.showDeviceDropdown;
      this.showVolumeDropdown = false; // 关闭其他下拉菜单
    },
    selectDevice(index) {
      this.selectedDeviceIndex = index;
      const selectedDevice = this.deviceOptions[index];
      this.formData.linkspeaker_sn = selectedDevice.lock_sn;
      this.formData.linkspeaker_name = selectedDevice.lock_name;
      this.showDeviceDropdown = false;
    },
    toggleVolumeDropdown() {
      this.showVolumeDropdown = !this.showVolumeDropdown;
      this.showDeviceDropdown = false; // 关闭其他下拉菜单
    },
    selectVolume(level) {
      this.formData.linkspeaker_volume = level;
      this.showVolumeDropdown = false;
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
        uni.setStorageSync('shouldRefreshDeviceList', true);
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
  padding: 30rpx;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

.form-section {
  background: #ffffff;
  padding: 30rpx;
  border-radius: 20rpx;
  box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.08);
  margin-bottom: 60rpx;
}

.form-item {
  margin-bottom: 30rpx;
  position: relative;
}

.label {
  font-size: 30rpx;
  color: #333;
  font-weight: 500;
  margin-right: 20rpx;
  display: inline-block;
  width: 160rpx;
}

.device-name {
  font-size: 28rpx;
  color: #666;
  line-height: 80rpx;
}

.picker {
  height: 80rpx;
  line-height: 80rpx;
  background: #f8f8f8;
  border-radius: 12rpx;
  padding: 0 20rpx;
  font-size: 28rpx;
  color: #333;
  display: flex;
  justify-content: space-between;
  align-items: center;
  transition: all 0.3s;
}

.picker:hover {
  background: #f0f0f0;
}

.arrow {
  font-size: 24rpx;
  color: #999;
}

.dropdown {
  position: absolute;
  top: 90rpx;
  left: 160rpx;
  right: 0;
  background: #fff;
  border-radius: 12rpx;
  box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.1);
  z-index: 10;
  max-height: 400rpx;
  overflow-y: auto;
}

.dropdown-item {
  padding: 20rpx 30rpx;
  font-size: 28rpx;
  color: #333;
  border-bottom: 1rpx solid #f0f0f0;
  transition: background 0.2s;
}

.dropdown-item:hover {
  background: #f5f5f5;
}

.dropdown-item:last-child {
  border-bottom: none;
}

.textarea {
  width: 100%;
  height: 200rpx;
  background: #f8f8f8;
  border-radius: 12rpx;
  padding: 20rpx;
  font-size: 28rpx;
  color: #333;
  box-sizing: border-box;
  overflow: hidden;
  resize: none;
}

.submit-btn {
  width: 80%;
  height: 90rpx;
  background: linear-gradient(90deg, #1aad19, #2ecc71);
  border-radius: 45rpx;
  text-align: center;
  line-height: 90rpx;
  font-size: 32rpx;
  color: #fff;
  font-weight: 600;
  box-shadow: 0 6rpx 20rpx rgba(26, 173, 25, 0.3);
  margin: 0 auto 100rpx;
  transition: all 0.3s;
}

.submit-btn:hover {
  transform: translateY(-2rpx);
  box-shadow: 0 8rpx 24rpx rgba(26, 173, 25, 0.4);
}

::v-deep .placeholder {
  font-size: 28rpx;
  color: #999;
}
</style>
