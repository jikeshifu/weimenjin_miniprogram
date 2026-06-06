<template>
  <view class="container">
    <!-- 头部标题和错误提示 -->
    <view class="header">
      <view class="title-row">
        <view class="title">{{ deviceName }} <text class="device-sn">SN: {{ device_sn }}</text></view>
        <view class="action-btn" @click="showConfigPopup">
          <uni-icons type="gear" size="22" color="#666" />
        </view>
      </view>
      <view v-if="showMsgText" class="msg-text">
        <uni-icons type="info" size="40" color="red" />
        <view class="msg-content">{{ showMsgText }}</view>
      </view>
    </view>

    <!-- 继电器卡片列表 -->
    <view class="relay-list">
      <view class="relay-item" v-for="relay in relays" :key="relay.id">
        <view class="relay-card" :class="getCardClass(relay)">
          <!-- 卡片头部 -->
          <view class="card-header">
            <view class="relay-name">{{ relay.relay_name }}</view>
            <view class="mode-badge" :class="'mode-' + relay.relay_mode">
              {{ relay.relay_mode == 0 ? '点动' : '锁定' }}
            </view>
          </view>

          <!-- 延迟时间显示 -->
          <view class="delay-info">
            <text v-if="relay.relay_mode == 0">延迟: {{ relay.relay_delay }}ms</text>
            <text v-else style="opacity: 0;">占位</text>
          </view>

          <!-- 控制按钮区域 -->
          <view class="control-area">
            <!-- 点动模式：钥匙按钮 -->
            <view v-if="relay.relay_mode == 0" class="key-button" @click="triggerRelay(relay, 1)">
              <view class="key-circle" :class="{ 'key-rotating': relay.isRotating }">
                <i class="iconfont icon-yuechi"></i>
              </view>
            </view>

            <!-- 锁定模式：开关滑块 -->
            <view v-else class="switch-control">
              <switch
                :checked="relay.status === 1"
                @change="onSwitchChange(relay, $event)"
                color="#07c160"
                style="transform: scale(1.2);"
              />
            </view>
          </view>

          <!-- 操作按钮 -->
          <view class="action-buttons">
            <view class="action-item" @click="editRelayName(relay)">
              <uni-icons type="compose" size="16" color="#07c160" />
              <text>编辑</text>
            </view>
            <view class="action-item" @click="showQRCode(relay)">
              <uni-icons type="qrcode" size="16" color="#ff9800" />
              <text>二维码</text>
            </view>
          </view>
        </view>
      </view>
    </view>

    <!-- 编辑弹窗 -->
    <uni-popup ref="editNamePopup" type="center">
      <view class="popup-content edit-popup">
        <view class="popup-title">继电器配置</view>

        <!-- 名称输入 -->
        <view class="form-item">
          <view class="form-label">名称</view>
          <input
            class="form-input"
            v-model="editingName"
            placeholder="请输入名称"
            maxlength="20"
          />
        </view>

        <!-- 工作模式 -->
        <view class="form-item">
          <view class="form-label">工作模式</view>
          <radio-group @change="onModeChange" class="radio-group">
            <label class="radio-item">
              <radio value="0" :checked="editingMode == 0" color="#07c160" />
              <text>点动模式</text>
              <text class="mode-desc">(自动关闭)</text>
            </label>
            <label class="radio-item">
              <radio value="1" :checked="editingMode == 1" color="#07c160" />
              <text>锁定模式</text>
              <text class="mode-desc">(手动切换)</text>
            </label>
          </radio-group>
        </view>

        <!-- 延迟时间(仅点动模式) -->
        <view class="form-item" v-if="editingMode == 0">
          <view class="form-label">延迟时间</view>
          <view class="delay-input-group">
            <input
              class="form-input"
              v-model.number="editingDelay"
              type="number"
              placeholder="延迟时间"
            />
            <text class="unit">毫秒</text>
          </view>
          <view class="form-tips">范围: 100-60000毫秒 (0.1-60秒)</view>
        </view>

        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="cancelEdit">取消</button>
          <button class="popup-btn confirm-btn" @click="confirmEdit">确定</button>
        </view>
      </view>
    </uni-popup>

    <!-- 二维码弹窗 -->
    <uni-popup ref="qrcodePopup" type="center">
      <view class="qrcode-content">
        <view class="qrcode-title">{{ currentRelay.relay_name }} - 专属二维码</view>
        <view class="qrcode-image">
          <image :src="qrcodeUrl" mode="aspectFit" v-if="qrcodeUrl"></image>
          <view class="loading" v-else>生成中...</view>
        </view>
        <view class="qrcode-tips">扫描此二维码只会开启该路继电器</view>
        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="closeQRCode">关闭</button>
          <button class="popup-btn confirm-btn" @click="saveQRCodeToAlbum">保存</button>
        </view>
      </view>
    </uni-popup>

    <!-- 路数配置弹窗 -->
    <uni-popup ref="configPopup" type="center">
      <view class="popup-content">
        <view class="popup-title">设置继电器路数</view>
        <view class="config-tips">当前设备有多少路继电器?(1-16路)</view>
        <input
          class="name-input"
          v-model.number="configRelayCount"
          type="number"
          placeholder="请输入路数(1-16)"
          :maxlength="2"
        />
        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="cancelConfig">取消</button>
          <button class="popup-btn confirm-btn" @click="confirmConfig">确定</button>
        </view>
      </view>
    </uni-popup>
  </view>
</template>

<script>
import {
  getW76FConfig_api,
  setW76FRelayConfig_api,
  controlW76FRelay_api,
  createW76FQrcode_api,
  getW76FSta_api,
  setW76FRelayCount_api
} from '../../api/index.js';

export default {
  data() {
    return {
      device_sn: '',
      lockauth_id: '',
      deviceName: '多路控制器',
      relays: [],
      relayCount: 5, // 默认5路
      showMsgText: '',
      editingRelay: null,
      editingName: '',
      editingMode: 0, // 0=点动 1=锁定
      editingDelay: 1000, // 延迟时间(毫秒)
      currentRelay: {},
      qrcodeUrl: '',
      configRelayCount: 5,
      rotatingRelays: {} // 记录旋转动画状态
    };
  },
  async onLoad(options) {
    this.device_sn = options.device_sn;
    this.lockauth_id = options.lockauth_id;

    await this.loadRelayConfig();

    // 如果没有配置路数，直接弹出配置弹窗
    if (this.relays.length === 0) {
      setTimeout(() => {
        this.$refs.configPopup.open();
      }, 300);
    } else {
      await this.getDeviceStatus();
    }
  },
  methods: {
    // 加载继电器配置（名称等）
    async loadRelayConfig() {
      try {
        const res = await getW76FConfig_api({
          lockauth_id: this.lockauth_id
        });

        if (res.code === 0 && res.data) {
          // 只有当relays有数据且relay_count大于0时，才认为已配置
          if (res.data.relays && res.data.relays.length > 0) {
            this.relayCount = res.data.relay_count || 5;
            this.configRelayCount = this.relayCount;

            this.relays = res.data.relays.map(relay => ({
              id: relay.relay_num,
              relay_num: relay.relay_num,
              relay_name: relay.relay_name,
              relay_mode: relay.relay_mode || 0,
              relay_delay: relay.relay_delay || 1000,
              status: relay.status || 0
            }));
          } else {
            // 未配置时，初始化为空数组
            this.relays = [];
            this.configRelayCount = 5; // 默认建议5路
          }

          this.device_sn = res.data.device_sn;
          // 设置设备名称
          if (res.data.lock_name) {
            this.deviceName = res.data.lock_name;
          }
        }
      } catch (err) {
        console.error('加载配置失败:', err);
        uni.showToast({
          title: '加载配置失败',
          icon: 'none'
        });
      }
    },

    // 获取设备状态
    async getDeviceStatus() {
      try {
        const res = await getW76FSta_api({
          device_sn: this.device_sn
        });

        if (res.code === 0 && res.data && res.data.info) {
          const info = res.data.info;
          // 更新各路继电器状态
          this.relays = this.relays.map(relay => ({
            ...relay,
            status: info[`relay${relay.relay_num}`] || 0
          }));
        }
      } catch (err) {
        console.error('获取状态失败:', err);
        uni.showToast({
          title: '获取设备状态失败',
          icon: 'none'
        });
      }
    },

    // 获取卡片样式类
    getCardClass(relay) {
      return {
        'active': relay.status === 1,
        'lockup': relay.lockup === 1
      };
    },

    // 触发继电器开关
    async triggerRelay(relay, action) {
      // 点动模式显示旋转动画
      if (relay.relay_mode == 0) {
        this.$set(relay, 'isRotating', true);
      }

      // 根据模式选择命令
      let cmd_type;
      if (relay.relay_mode == 0) {
        // 点动模式：统一使用 relay_ctrl
        cmd_type = 'relay_ctrl';
      } else {
        // 锁定模式：使用 turn_on/turn_off
        cmd_type = action === 1 ? 'turn_on' : 'turn_off';
      }

      try {
        const res = await controlW76FRelay_api({
          device_sn: this.device_sn,
          relay: relay.relay_num,
          cmd_type: cmd_type
        });

        if (res.code === 0) {
          relay.status = action;
          uni.vibrateShort();
          uni.showToast({
            title: action === 1 ? '已开启' : '已关闭',
            icon: 'success'
          });

          // 1秒后刷新状态并停止动画
          setTimeout(() => {
            this.$set(relay, 'isRotating', false);
            this.getDeviceStatus();
          }, 1000);
        } else {
          this.$set(relay, 'isRotating', false);
          uni.showToast({
            title: res.msg || '操作失败',
            icon: 'none'
          });
        }
      } catch (err) {
        this.$set(relay, 'isRotating', false);
        console.error('操作失败:', err);
        uni.showToast({
          title: '操作失败',
          icon: 'none'
        });
      }
    },

    // 开关切换事件
    async onSwitchChange(relay, e) {
      const checked = e.detail.value;
      await this.triggerRelay(relay, checked ? 1 : 0);
    },

    // 编辑继电器名称
    editRelayName(relay) {
      this.editingRelay = relay;
      this.editingName = relay.relay_name;
      this.editingMode = relay.relay_mode || 0;
      this.editingDelay = relay.relay_delay || 1000;
      this.$refs.editNamePopup.open();
    },

    // 取消编辑
    cancelEdit() {
      this.$refs.editNamePopup.close();
      this.editingRelay = null;
      this.editingName = '';
      this.editingMode = 0;
      this.editingDelay = 1000;
    },

    // 模式切换
    onModeChange(e) {
      this.editingMode = parseInt(e.detail.value);
    },

    // 确认编辑
    async confirmEdit() {
      if (!this.editingName.trim()) {
        uni.showToast({
          title: '名称不能为空',
          icon: 'none'
        });
        return;
      }

      // 验证延迟时间
      const delay = parseInt(this.editingDelay);
      if (delay < 100 || delay > 60000) {
        uni.showToast({
          title: '延迟时间范围: 100-60000毫秒',
          icon: 'none'
        });
        return;
      }

      try {
        const res = await setW76FRelayConfig_api({
          lockauth_id: this.lockauth_id,
          relay_num: this.editingRelay.relay_num,
          relay_name: this.editingName,
          relay_mode: this.editingMode,
          relay_delay: delay
        });

        if (res.code === 0) {
          this.editingRelay.relay_name = this.editingName;
          this.editingRelay.relay_mode = this.editingMode;
          this.editingRelay.relay_delay = delay;
          this.$refs.editNamePopup.close();
          uni.showToast({
            title: '保存成功',
            icon: 'success'
          });
        } else {
          uni.showToast({
            title: res.msg || '保存失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('保存失败:', err);
        uni.showToast({
          title: '保存失败',
          icon: 'none'
        });
      }
    },

    // 显示二维码
    async showQRCode(relay) {
      this.currentRelay = relay;
      this.qrcodeUrl = '';
      this.$refs.qrcodePopup.open();

      try {
        const res = await createW76FQrcode_api({
          lockauth_id: this.lockauth_id,
          relay_num: relay.relay_num
        });

        if (res.code === 0 && res.data) {
          this.qrcodeUrl = res.data.qrcode_url;
        } else {
          uni.showToast({
            title: res.msg || '生成失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('生成二维码失败:', err);
        uni.showToast({
          title: '生成失败',
          icon: 'none'
        });
      }
    },

    // 保存二维码到相册
    async saveQRCodeToAlbum() {
      if (!this.qrcodeUrl) {
        uni.showToast({
          title: '二维码未生成',
          icon: 'none'
        });
        return;
      }

      try {
        uni.showLoading({ title: '保存中...' });

        // 下载图片到本地
        const downloadRes = await new Promise((resolve, reject) => {
          uni.downloadFile({
            url: this.qrcodeUrl,
            success: (res) => {
              if (res.statusCode === 200) {
                resolve(res.tempFilePath);
              } else {
                reject(new Error('下载失败'));
              }
            },
            fail: reject
          });
        });

        // 保存到相册
        await new Promise((resolve, reject) => {
          uni.saveImageToPhotosAlbum({
            filePath: downloadRes,
            success: resolve,
            fail: reject
          });
        });

        uni.hideLoading();
        uni.showToast({
          title: '保存成功',
          icon: 'success'
        });
      } catch (err) {
        uni.hideLoading();
        console.error('保存失败:', err);

        // 判断是否是权限问题
        if (err.errMsg && err.errMsg.includes('auth')) {
          uni.showModal({
            title: '提示',
            content: '需要您授权保存图片到相册',
            success: (res) => {
              if (res.confirm) {
                uni.openSetting();
              }
            }
          });
        } else {
          uni.showToast({
            title: '保存失败',
            icon: 'none'
          });
        }
      }
    },

    // 关闭二维码
    closeQRCode() {
      this.$refs.qrcodePopup.close();
    },

    // 显示配置弹窗
    showConfigPopup() {
      this.$refs.configPopup.open();
    },

    // 取消配置
    cancelConfig() {
      this.configRelayCount = this.relayCount;
      this.$refs.configPopup.close();
    },

    // 确认配置
    async confirmConfig() {
      const count = parseInt(this.configRelayCount);

      if (!count || count < 1 || count > 16) {
        uni.showToast({
          title: '请输入1-16之间的数字',
          icon: 'none'
        });
        return;
      }

      try {
        const res = await setW76FRelayCount_api({
          lockauth_id: this.lockauth_id,
          relay_count: count
        });

        if (res.code === 0) {
          uni.showToast({
            title: '设置成功',
            icon: 'success'
          });

          this.$refs.configPopup.close();

          // 重新加载配置
          await this.loadRelayConfig();
          await this.getDeviceStatus();
        } else {
          uni.showToast({
            title: res.msg || '设置失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('设置路数失败:', err);
        uni.showToast({
          title: '设置失败',
          icon: 'none'
        });
      }
    }
  }
};
</script>

<style scoped lang="scss">
.container {
  padding: 30rpx;
  background: #f5f5f5;
  min-height: 100vh;
}

.header {
  margin-bottom: 30rpx;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20rpx;
}

.title {
  font-size: 36rpx;
  font-weight: bold;
  color: #333;
  flex: 1;

  .device-sn {
    font-size: 24rpx;
    color: #999;
    font-weight: normal;
    margin-left: 12rpx;
  }
}

.action-btn {
  padding: 10rpx;
  cursor: pointer;
}

.msg-text {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20rpx;
  background: #fff3f3;
  border-radius: 8rpx;
  color: #f56c6c;
  font-size: 26rpx;
}

.msg-content {
  margin-left: 10rpx;
}

.relay-list {
  display: flex;
  flex-wrap: wrap;
  margin: 0 -10rpx;
}

.empty-tip {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 100rpx 40rpx;
  background: #fff;
  border-radius: 16rpx;
  margin: 0 10rpx;

  .empty-text {
    font-size: 32rpx;
    color: #333;
    margin-top: 30rpx;
    font-weight: bold;
  }

  .empty-desc {
    font-size: 26rpx;
    color: #999;
    margin-top: 16rpx;
    text-align: center;
    line-height: 1.6;
  }
}

.relay-item {
  width: 50%;
  padding: 0 10rpx;
  margin-bottom: 20rpx;
  box-sizing: border-box;
}

.relay-card {
  background: #fff;
  border-radius: 16rpx;
  padding: 24rpx;
  box-shadow: 0 4rpx 12rpx rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;

  &.active {
    border: 2rpx solid #07c160;
  }
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12rpx;
}

.relay-name {
  font-size: 28rpx;
  font-weight: bold;
  color: #333;
  flex: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  margin-right: 8rpx;
}

.mode-badge {
  display: inline-flex;
  align-items: center;
  padding: 4rpx 10rpx;
  border-radius: 6rpx;
  font-size: 20rpx;
  white-space: nowrap;

  &.mode-0 {
    background: #e6f7ff;
    color: #1890ff;
  }

  &.mode-1 {
    background: #f0f5ff;
    color: #722ed1;
  }
}

.delay-info {
  font-size: 22rpx;
  color: #999;
  margin-bottom: 12rpx;
}

.control-area {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20rpx 0;
  min-height: 160rpx;
}

.key-button {
  width: 100%;
  display: flex;
  justify-content: center;
}

.key-circle {
  width: 120rpx;
  height: 120rpx;
  border-radius: 50%;
  background: linear-gradient(135deg, #21CF3E 0%, #1ab32e 100%);
  border: 2rpx solid #fff;
  box-shadow: 0 12rpx 24rpx rgba(33, 207, 62, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;

  &:active {
    transform: scale(0.95);
    box-shadow: 0 8rpx 16rpx rgba(33, 207, 62, 0.4);
  }

  .iconfont {
    font-size: 56rpx;
    color: #fff;
  }

  &.key-rotating {
    animation: rotate 1s linear;
  }
}

@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.switch-control {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

.action-buttons {
  display: flex;
  gap: 8rpx;
  padding-top: 12rpx;
  border-top: 1rpx solid #f0f0f0;
}

.action-item {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4rpx;
  padding: 8rpx;
  background: #f5f5f5;
  border-radius: 8rpx;
  font-size: 22rpx;
  color: #666;

  &:active {
    background: #e5e5e5;
  }
}

// 弹窗样式
.popup-content {
  width: 600rpx;
  background: #fff;
  border-radius: 16rpx;
  padding: 40rpx;

  &.edit-popup {
    width: 640rpx;
  }
}

.config-tips {
  font-size: 28rpx;
  color: #666;
  margin-bottom: 20rpx;
  line-height: 1.5;
}

.popup-title {
  font-size: 32rpx;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30rpx;
  color: #333;
}

.name-input {
  width: 100%;
  height: 80rpx;
  padding: 0 20rpx;
  border: 1rpx solid #ddd;
  border-radius: 8rpx;
  font-size: 28rpx;
  box-sizing: border-box;
  margin-bottom: 30rpx;
}

.form-item {
  margin-bottom: 30rpx;
}

.form-label {
  font-size: 28rpx;
  color: #333;
  margin-bottom: 12rpx;
  font-weight: 500;
}

.form-input {
  width: 100%;
  height: 80rpx;
  padding: 0 20rpx;
  border: 1rpx solid #ddd;
  border-radius: 8rpx;
  font-size: 28rpx;
  box-sizing: border-box;
}

.radio-group {
  display: flex;
  flex-direction: column;
  gap: 16rpx;
}

.radio-item {
  display: flex;
  align-items: center;
  padding: 16rpx 20rpx;
  background: #f5f5f5;
  border-radius: 8rpx;

  radio {
    margin-right: 12rpx;
  }

  text {
    font-size: 28rpx;
    color: #333;
  }

  .mode-desc {
    font-size: 24rpx;
    color: #999;
    margin-left: 8rpx;
  }
}

.delay-input-group {
  display: flex;
  align-items: center;
  gap: 12rpx;

  .form-input {
    flex: 1;
  }

  .unit {
    font-size: 28rpx;
    color: #666;
  }
}

.form-tips {
  margin-top: 8rpx;
  font-size: 24rpx;
  color: #999;
}

.popup-buttons {
  display: flex;
  gap: 20rpx;
}

.popup-btn {
  flex: 1;
  height: 80rpx;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12rpx;
  font-size: 28rpx;
  border: none;

  &.cancel-btn {
    background: #f5f5f5;
    color: #666;
  }

  &.confirm-btn {
    background: linear-gradient(135deg, #07c160 0%, #32c18d 100%);
    color: #fff;
  }
}

.qrcode-content {
  width: 600rpx;
  background: #fff;
  border-radius: 16rpx;
  padding: 40rpx;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.qrcode-title {
  font-size: 32rpx;
  font-weight: bold;
  margin-bottom: 30rpx;
  color: #333;
}

.qrcode-image {
  width: 400rpx;
  height: 400rpx;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5f5;
  border-radius: 12rpx;
  margin-bottom: 20rpx;

  image {
    width: 100%;
    height: 100%;
  }

  .loading {
    color: #999;
    font-size: 28rpx;
  }
}

.qrcode-tips {
  font-size: 24rpx;
  color: #999;
  text-align: center;
  margin-bottom: 30rpx;
}
</style>
