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
        <view class="device-name">{{ formData.linkswitch_name || '请选择序列号以显示名称' }}</view>
      </view>

      <!-- 开门后 -->
      <view class="form-item">
        <text class="label">开门后</text>
        <view class="picker" @click="toggleOpenDropdown">
          <text>{{ selectedOpenOption || '请选择开电方式' }}</text>
          <text class="arrow">▼</text>
        </view>
        <view class="dropdown" v-if="showOpenDropdown">
          <view
            v-for="(option, index) in openOptions"
            :key="index"
            class="dropdown-item"
            @click="selectOpenAction(option.id)"
          >
            {{ option.text }}
          </view>
        </view>
      </view>

      <!-- 开电后 -->
      <view class="form-item">
        <text class="label">开电后</text>
        <view class="picker" @click="toggleCloseDropdown">
          <text>{{ selectedCloseOption || '请选择关电延时' }}</text>
          <text class="arrow">▼</text>
        </view>
        <view class="dropdown" v-if="showCloseDropdown">
          <view
            v-for="(option, index) in closeOptions"
            :key="index"
            class="dropdown-item"
            @click="selectCloseDelay(option.id)"
          >
            {{ option.text }}
          </view>
        </view>
      </view>
    </view>

    <!-- 提交按钮 -->
    <view class="submit-btn" @click="onSubmit">立即提交</view>

    <!-- 自定义时间弹层 -->
    <view class="modal" v-if="showCustomModal" @click="closeCustomModal">
      <view class="modal-content" @click.stop>
        <view class="modal-title">{{ customModalType === 'open' ? '自定义开门后时间' : '自定义开电后时间' }}</view>
        <view class="modal-input">
          <input
            type="number"
            :value="customModalType === 'open' ? customOpenMinutes : customCloseMinutes"
            @input="updateCustomMinutes"
            placeholder="请输入分钟数"
            class="custom-input"
          />
          <text class="unit">分钟</text>
        </view>
        <view class="modal-buttons">
          <view class="modal-btn cancel" @click="closeCustomModal">取消</view>
          <view class="modal-btn confirm" @click="confirmCustomTime">确定</view>
        </view>
      </view>
    </view>
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
        open_action: 0, // 直接表示分钟数
        close_delay: 0  // 直接表示分钟数
      },
      deviceOptions: [],
      selectedDeviceIndex: -1,
      showDeviceDropdown: false,
      openOptions: [
        { id: 0, text: '立即开电', minutes: 0 },
        { id: 1, text: '延迟1分钟开电', minutes: 1 },
        { id: 2, text: '延迟5分钟开电', minutes: 5 },
        { id: 3, text: '延迟10分钟开电', minutes: 10 },
        { id: 4, text: '延迟30分钟开电', minutes: 30 },
        { id: 5, text: '自定义时间开电', minutes: null }
      ],
      closeOptions: [
        { id: 0, text: '不自动关电', minutes: 0 },
        { id: 1, text: '1分钟后关电', minutes: 1 },
        { id: 2, text: '5分钟后关电', minutes: 5 },
        { id: 3, text: '10分钟后关电', minutes: 10 },
        { id: 4, text: '30分钟后关电', minutes: 30 },
        { id: 5, text: '自定义时间关电', minutes: null }
      ],
      selectedOpenId: 0,  // 操作选项的 ID
      selectedCloseId: 0, // 操作选项的 ID
      showOpenDropdown: false,
      showCloseDropdown: false,
      showCustomModal: false,
      customModalType: '',
      customOpenMinutes: '',
      customCloseMinutes: '',
      verifyData: {
        lock_id: '缺少锁ID',
        linkswitch_sn: '请选择联动空开',
        open_action: '请选择开电方式',
        close_delay: '请选择关电延时'
      },
      isEdit: false
    }
  },
  computed: {
    selectedOpenOption() {
      const option = this.openOptions.find(opt => opt.id === this.selectedOpenId);
      if (option && option.id === 5 && this.formData.open_action > 0) {
        return `自定义${this.formData.open_action}分钟`;
      }
      return option ? option.text : '';
    },
    selectedCloseOption() {
      const option = this.closeOptions.find(opt => opt.id === this.selectedCloseId);
      if (option && option.id === 5 && this.formData.close_delay > 0) {
        return `自定义${this.formData.close_delay}分钟`;
      }
      return option ? option.text : '';
    }
  },
  async onLoad(option) {
    this.formData.lock_id = option.lock_id || '';
    this.isEdit = !!option.sn;

    await this.fetchDeviceOptions();

    if (option.sn) {
      await this.fetchSwitchData(option.sn);
    }
  },
  methods: {
    async fetchSwitchData(linkswitch_sn) {
      try {
        const res = await getlinkswitchBySn_api({ linkswitch_sn });
        if (res.code === 0 && res.data) {
          const data = res.data;
          this.formData = {
            lock_id: this.formData.lock_id,
            linkswitch_sn: data.linkswitch_sn,
            linkswitch_name: data.linkswitch_name,
            open_action: data.open_action,
            close_delay: data.close_delay
          };
          this.selectedDeviceIndex = this.deviceOptions.findIndex(device => device.lock_sn === data.linkswitch_sn);

          // 回显开门后选项
          const openOption = this.openOptions.find(opt => opt.minutes === data.open_action);
          this.selectedOpenId = openOption ? openOption.id : 5; // 如果分钟数不在预设中，则为自定义
          if (this.selectedOpenId === 5) {
            this.customOpenMinutes = String(data.open_action);
          }

          // 回显开电后选项
          const closeOption = this.closeOptions.find(opt => opt.minutes === data.close_delay);
          this.selectedCloseId = closeOption ? closeOption.id : 5; // 如果分钟数不在预设中，则为自定义
          if (this.selectedCloseId === 5) {
            this.customCloseMinutes = String(data.close_delay);
          }
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
            .filter(device => device.lock_sn.startsWith('W71') || device.lock_sn.startsWith('W72'))
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
      this.showOpenDropdown = false;
      this.showCloseDropdown = false;
    },
    selectDevice(index) {
      this.selectedDeviceIndex = index;
      const selectedDevice = this.deviceOptions[index];
      this.formData.linkswitch_sn = selectedDevice.lock_sn;
      this.formData.linkswitch_name = selectedDevice.lock_name;
      this.showDeviceDropdown = false;
    },
    toggleOpenDropdown() {
      this.showOpenDropdown = !this.showOpenDropdown;
      this.showDeviceDropdown = false;
      this.showCloseDropdown = false;
    },
    toggleCloseDropdown() {
      this.showCloseDropdown = !this.showCloseDropdown;
      this.showDeviceDropdown = false;
      this.showOpenDropdown = false;
    },
    selectOpenAction(id) {
      this.selectedOpenId = id;
      this.showOpenDropdown = false;
      const option = this.openOptions.find(opt => opt.id === id);
      if (id === 5) {
        this.showCustomModal = true;
        this.customModalType = 'open';
      } else {
        this.formData.open_action = option.minutes;
        this.customOpenMinutes = '';
      }
    },
    selectCloseDelay(id) {
      this.selectedCloseId = id;
      this.showCloseDropdown = false;
      const option = this.closeOptions.find(opt => opt.id === id);
      if (id === 5) {
        this.showCustomModal = true;
        this.customModalType = 'close';
      } else {
        this.formData.close_delay = option.minutes;
        this.customCloseMinutes = '';
      }
    },
    updateCustomMinutes(e) {
      if (this.customModalType === 'open') {
        this.customOpenMinutes = e.detail.value;
      } else {
        this.customCloseMinutes = e.detail.value;
      }
    },
    closeCustomModal() {
      this.showCustomModal = false;
      this.customModalType = '';
    },
    confirmCustomTime() {
      const minutes = this.customModalType === 'open' ? this.customOpenMinutes : this.customCloseMinutes;
      if (!minutes || parseInt(minutes) <= 0) {
        this.showToast('请输入有效的分钟数');
        return;
      }
      if (this.customModalType === 'open') {
        this.formData.open_action = parseInt(this.customOpenMinutes);
        this.selectedOpenId = 5;
      } else {
        this.formData.close_delay = parseInt(this.customCloseMinutes);
        this.selectedCloseId = 5;
      }
      this.showCustomModal = false;
    },
    async onSubmit() {
      for (let key in this.verifyData) {
        if (this.verifyData[key] && !this.formData[key] && this.formData[key] !== 0) {
          this.showToast(this.verifyData[key]);
          return false;
        }
      }

      uni.showLoading({ title: '提交中...', mask: true });
      let res;
      if (!this.isEdit) {
        res = await addlinkswitch_api(this.formData);
      } else {
        res = await editlinkswitch_api(this.formData);
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

/* 自定义时间弹层样式 */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 100;
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: #fff;
  width: 80%;
  padding: 40rpx;
  border-radius: 20rpx;
  box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.2);
}

.modal-title {
  font-size: 32rpx;
  color: #333;
  text-align: center;
  margin-bottom: 30rpx;
}

.modal-input {
  display: flex;
  align-items: center;
  height: 80rpx;
  background: #f8f8f8;
  border-radius: 12rpx;
  padding: 0 20rpx;
  margin-bottom: 30rpx;
}

.custom-input {
  flex: 1;
  font-size: 28rpx;
  color: #333;
  height: 100%;
}

.unit {
  font-size: 28rpx;
  color: #666;
  margin-left: 10rpx;
}

.modal-buttons {
  display: flex;
  justify-content: space-between;
}

.modal-btn {
  width: 45%;
  height: 80rpx;
  line-height: 80rpx;
  text-align: center;
  font-size: 28rpx;
  border-radius: 12rpx;
}

.cancel {
  background: #f0f0f0;
  color: #666;
}

.confirm {
  background: #1aad19;
  color: #fff;
}
</style>
