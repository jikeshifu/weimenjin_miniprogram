<template>
  <view class="container">
    <view class="settings-list">
      <!-- 名称输入 -->
      <view class="setting-item">
        <text class="label">名称</text>
        <input
          class="input"
          placeholder="请输入锁名称"
          placeholder-class="placeholder"
          v-model="formData.lock_name"
          @blur="autoSave"
        />
      </view>

      <!-- 开关项 -->
      <view class="setting-group">
        <view class="setting-item switch-item" @click="toggleSwitch('status')">
          <text class="label">设备状态</text>
          <switch
            :checked="formData.status"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('mobile_check')">
          <text class="label">需手机号</text>
          <switch
            :checked="formData.mobile_check"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('applyauth')">
          <text class="label">扫码登记</text>
          <switch
            :checked="formData.applyauth"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('applyauth_check')">
          <text class="label">登记审核</text>
          <switch
            :checked="formData.applyauth_check"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('xcx_sound')">
          <text class="label">程序提示音</text>
          <switch
            :checked="formData.xcx_sound"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('device_sound')">
          <text class="label">设备提示音</text>
          <switch
            :checked="formData.device_sound"
            color="#1aad19"
            class="switch"
          />
        </view>

        <view class="setting-item switch-item" @click="toggleSwitch('opsucnt')">
          <text class="label">开门通知</text>
          <switch
            :checked="formData.opsucnt"
            color="#1aad19"
            class="switch"
          />
        </view>
      </view>

      <!-- 开门成功图片 -->
      <view class="setting-item success-img-item">
        <text class="label">成功图片</text>
        <view class="success-img-container">
          <view class="img-preview" v-if="successImg" @click="previewImage">
            <image :src="successImg" mode="aspectFit" class="preview-image"></image>
            <view class="img-size" v-if="imgSize">{{ imgSize }}</view>
            <view class="delete-btn" @click.stop="deleteImage">
              <uni-icons type="close" size="14" color="#fff"></uni-icons>
            </view>
          </view>
          <view class="upload-btn" @click="chooseImage" v-else>
            <uni-icons type="plusempty" size="24" color="#ccc"></uni-icons>
            <text class="upload-tip">点击上传</text>
          </view>
        </view>
      </view>

      <!-- 开门限距 -->
      <view class="setting-item" @click="toggleDistanceDropdown">
        <text class="label">使用限距</text>
        <view class="picker">
          <text>{{ displayDistance }}</text>
          <text class="arrow">▼</text>
        </view>
        <view class="dropdown" v-if="showDistanceDropdown">
          <view
            v-for="(option, index) in distanceOptions"
            :key="index"
            class="dropdown-item"
            @click.stop="selectDistance(option.value)"
          >
            {{ option.text }}
          </view>
        </view>
      </view>

      <!-- W767设备继电器延时设置 -->
      <view class="setting-item relay-delay-item" v-if="showRelayDelaySetting">
        <text class="label">继电器延时</text>
        <view class="relay-control">
          <view class="slider-container">
            <slider
              class="relay-slider"
              :value="relayDelaySeconds"
              min="1"
              max="30"
              @change="onRelaySliderChange"
            />
          </view>
          <view class="relay-value">{{ relayDelaySeconds }}s</view>
        </view>
      </view>

      <!-- W767设备继电器模式设置 -->
      <view class="setting-item relay-mode-item" v-if="showRelayDelaySetting">
        <text class="label">继电器模式</text>
        <view class="mode-segment">
          <view
            class="mode-btn"
            :class="{ active: relayNoncMode === 0 }"
            @click="relayNoncMode = 0; saveRelayNoncMode();"
          >
            门常闭
          </view>
          <view
            class="mode-btn"
            :class="{ active: relayNoncMode === 1 }"
            @click="relayNoncMode = 1; saveRelayNoncMode();"
          >
            门常开
          </view>
        </view>
      </view>
    </view>

    <!-- 自定义输入弹窗 -->
    <view class="modal" v-if="showCustomInput" @click="closeCustomInput">
      <view class="modal-content" @click.stop>
        <view class="modal-title">自定义开门限距</view>
        <view class="modal-input">
          <input
            type="number"
            class="custom-input"
            placeholder="请输入大于50的数字"
            v-model="customDistance"
            @focus="clearPlaceholder"
            @blur="validateInput"
          />
          <text class="unit">米</text>
        </view>
        <view class="modal-buttons">
          <view class="modal-btn cancel" @click="closeCustomInput">取消</view>
          <view class="modal-btn confirm" @click="confirmCustomDistance">确定</view>
        </view>
      </view>
    </view>

    <!-- 隐藏的canvas用于图片压缩 -->
    <canvas canvas-id="compressCanvas" style="position: fixed; top: -1000px; left: -1000px; width: 506px; height: 900px;"></canvas>
  </view>
</template>

<script>
import { configSet_api, config_api, setRelayDelay, setRelayNoncMode, images_api } from '@/api/index.js'
import { imgPath } from '@/libs/filters.js'

export default {
  data() {
    return {
      lockauth_id: '',
      formData: {},
      distanceOptions: [
        { value: '50', text: '50米' },
        { value: '100', text: '100米' },
        { value: '200', text: '200米' },
        { value: '0', text: '不限制' },
        { value: 'custom', text: '自定义' }
      ],
      showDistanceDropdown: false,
      showCustomInput: false,
      customDistance: '',
      showRelayDelaySetting: false,
      relayDelaySeconds: 1,
      relayNoncMode: 0,
      successImg: '',
      imgSize: '',
      compressing: false
    }
  },
  computed: {
    displayDistance() {
      const distance = parseInt(this.formData.location_check);
      if (this.formData.location_check === '0') {
        return '不限制';
      }
      const option = this.distanceOptions.find(opt => opt.value === this.formData.location_check);
      if (option) {
        return option.text;
      }
      // 如果是自定义值（非预设值）
      return distance > 50 ? `${distance}米` : '50米'; // 默认回退到50米
    }
  },
  onLoad(option) {
    this.lockauth_id = option.lockauth_id;
    this.getInfo();
  },
  methods: {
    async getInfo() {
      let res = await config_api({ lockauth_id: this.lockauth_id });
      if (res.code === 0) {
        let item = res.data;
        this.formData = {
          lockauth_id: this.lockauth_id,
          lock_name: item.lock_name || '',
          mobile_check: !!item.mobile_check,
          applyauth: !!item.applyauth,
          xcx_sound: !!item.xcx_sound,
          device_sound: item.device_sound !== undefined ? !!item.device_sound : true, // 默认开启设备提示音
          opsucnt: !!item.opsucnt,
          applyauth_check: !!item.applyauth_check,
          location_check: item.location_check !== undefined ? String(item.location_check) : '50', // 默认 50 米
          status: !!item.status,
          advertising_enabled: !!item.qrshowminiad
        };

        // 初始化继电器延时值
        if (item.relay_delay) {
          this.relayDelaySeconds = parseInt(item.relay_delay);
        } else {
          this.relayDelaySeconds = 1; // 默认1秒
        }

        // 初始化继电器模式
        if (item.relay_nonc_mode !== undefined) {
          this.relayNoncMode = parseInt(item.relay_nonc_mode);
        } else {
          this.relayNoncMode = 0; // 默认常闭
        }

        // 检查是否是 W767 设备，并并有继电器延时设置能力
        if (item.lock_ability && item.lock_ability.relay_delay_status === 1) {
          this.showRelayDelaySetting = true;
        } else {
          this.showRelayDelaySetting = false;
        }

        // 初始化开门成功图片
        if (item.successimg) {
          this.successImg = imgPath(item.successimg);
        }
      } else {
        this.showToast(res.msg);
      }
    },
    async autoSave() {
      uni.showLoading({
        title: '保存中...',
        mask: true
      });
      let res = await configSet_api(this.formData);
      uni.hideLoading();
      this.showToast(res.code === 0 ? '保存成功' : res.msg);
    },
    toggleSwitch(field) {
      this.formData[field] = !this.formData[field];
      this.autoSave();
    },
    toggleDistanceDropdown() {
      this.showDistanceDropdown = !this.showDistanceDropdown;
    },
    selectDistance(value) {
      if (value === 'custom') {
        this.showCustomInput = true;
        this.customDistance = '';
      } else {
        this.formData.location_check = value;
        this.showDistanceDropdown = false; // 选择后关闭下拉框
        this.autoSave();
      }
    },
    clearPlaceholder() {
      this.customDistance = '';
    },
    validateInput() {
      const distance = parseInt(this.customDistance);
      if (isNaN(distance) || distance <= 50) {
        this.showToast('请输入大于50的数字');
        this.customDistance = '';
      }
    },
    confirmCustomDistance() {
      const distance = parseInt(this.customDistance);
      if (isNaN(distance) || distance <= 50) {
        this.showToast('请输入大于50的数字');
      } else {
        this.formData.location_check = String(distance);
        this.showCustomInput = false;
        this.showDistanceDropdown = false; // 确认自定义值后关闭下拉框
        this.autoSave();
      }
    },
    closeCustomInput() {
      this.showCustomInput = false;
      this.customDistance = '';
    },
    onRelaySliderChange(event) {
      this.relayDelaySeconds = parseInt(event.detail.value);
      this.saveRelayDelay();
    },
    async saveRelayDelay() {
      uni.showLoading({
        title: '保存中...',
        mask: true
      });

      try {
        let res = await setRelayDelay({
          lockauth_id: this.lockauth_id,
          relay_delay: this.relayDelaySeconds
        });
        uni.hideLoading();

        if (res.code === 0) {
          this.showToast('继电器延时设置成功');
        } else {
          this.showToast(res.msg || '设置失败');
        }
      } catch (error) {
        uni.hideLoading();
        this.showToast('设置失败: ' + error.message);
      }
    },
    onRelayNoncModeChange(event) {
      this.relayNoncMode = event.detail.value ? 1 : 0;
      this.saveRelayNoncMode();
    },
    async saveRelayNoncMode() {
      uni.showLoading({
        title: '保存中...',
        mask: true
      });

      try {
        let res = await setRelayNoncMode({
          lockauth_id: this.lockauth_id,
          nonc_mode: this.relayNoncMode
        });
        uni.hideLoading();

        if (res.code === 0) {
          this.showToast('继电器模式设置成功');
        } else {
          this.showToast(res.msg || '设置失败');
        }
      } catch (error) {
        uni.hideLoading();
        this.showToast('设置失败: ' + error.message);
      }
    },
    // 选择图片
    chooseImage() {
      uni.chooseImage({
        count: 1,
        sizeType: ['compressed'],
        sourceType: ['album', 'camera'],
        success: async (res) => {
          const tempFilePath = res.tempFilePaths[0];

          uni.showLoading({ title: '处理图片中...', mask: true });

          try {
            // 先缩放图片尺寸
            const resizedPath = await this.resizeImage(tempFilePath);
            // 再压缩到100KB以内
            const compressedPath = await this.compressImageToSize(resizedPath, 80, 100 * 1024);

            uni.showLoading({ title: '上传中...', mask: true });
            // 上传图片
            await this.uploadImage(compressedPath);
          } catch (error) {
            uni.hideLoading();
            this.showToast(error.message || error || '处理失败');
          }
        }
      });
    },
    // 使用 canvas 调整图片尺寸到 506x900
    resizeImage(src) {
      return new Promise((resolve, reject) => {
        uni.getImageInfo({
          src: src,
          success: (imgInfo) => {
            const canvasId = 'compressCanvas';
            const ctx = uni.createCanvasContext(canvasId, this);

            // 目标尺寸
            const targetWidth = 506;
            const targetHeight = 900;

            // 计算缩放和裁剪，保持中心区域
            const imgRatio = imgInfo.width / imgInfo.height;
            const targetRatio = targetWidth / targetHeight;

            let sx = 0, sy = 0, sw = imgInfo.width, sh = imgInfo.height;

            if (imgRatio > targetRatio) {
              // 图片更宽，左右裁剪
              sw = imgInfo.height * targetRatio;
              sx = (imgInfo.width - sw) / 2;
            } else {
              // 图片更高，上下裁剪
              sh = imgInfo.width / targetRatio;
              sy = (imgInfo.height - sh) / 2;
            }

            // 清空画布
            ctx.clearRect(0, 0, targetWidth, targetHeight);

            // 绘制图片
            ctx.drawImage(src, sx, sy, sw, sh, 0, 0, targetWidth, targetHeight);

            ctx.draw(false, () => {
              setTimeout(() => {
                uni.canvasToTempFilePath({
                  canvasId: canvasId,
                  x: 0,
                  y: 0,
                  width: targetWidth,
                  height: targetHeight,
                  destWidth: targetWidth,
                  destHeight: targetHeight,
                  quality: 1,
                  success: (res) => {
                    resolve(res.tempFilePath);
                  },
                  fail: (err) => {
                    console.error('canvasToTempFilePath fail:', err);
                    reject('图片处理失败');
                  }
                }, this);
              }, 200);
            });
          },
          fail: (err) => {
            console.error('getImageInfo fail:', err);
            reject('获取图片信息失败');
          }
        });
      });
    },
    // 压缩图片到指定大小
    compressImageToSize(filePath, quality = 80, maxSize = 100 * 1024) {
      return new Promise((resolve, reject) => {
        uni.compressImage({
          src: filePath,
          quality: quality,
          success: (res) => {
            uni.getFileInfo({
              filePath: res.tempFilePath,
              success: (fileInfo) => {
                this.imgSize = this.formatSize(fileInfo.size);
                if (fileInfo.size <= maxSize || quality <= 10) {
                  resolve(res.tempFilePath);
                } else {
                  // 继续压缩
                  this.compressImageToSize(filePath, quality - 10, maxSize)
                    .then(resolve)
                    .catch(reject);
                }
              },
              fail: () => reject('获取文件信息失败')
            });
          },
          fail: () => reject('图片压缩失败')
        });
      });
    },
    // 上传图片
    async uploadImage(filePath) {
      try {
        const res = await images_api({ image: filePath });
        uni.hideLoading();

        if (res.code === 0 && res.data) {
          // 保存原始路径用于后端存储
          this.formData.successimg = res.data;
          // 显示用完整URL
          this.successImg = imgPath(res.data);
          await this.saveSuccessImg();
        } else {
          this.showToast(res.msg || '上传失败');
        }
      } catch (error) {
        uni.hideLoading();
        this.showToast('上传失败');
      }
    },
    // 保存开门成功图片
    async saveSuccessImg() {
      try {
        let res = await configSet_api({
          lockauth_id: this.lockauth_id,
          successimg: this.formData.successimg
        });
        if (res.code === 0) {
          this.showToast('保存成功');
        } else {
          this.showToast(res.msg || '保存失败');
        }
      } catch (error) {
        this.showToast('保存失败');
      }
    },
    // 删除图片
    deleteImage() {
      const that = this;
      uni.showModal({
        title: '提示',
        content: '确定删除开门成功图片吗？',
        success(res) {
          if (res.confirm) {
            that.successImg = '';
            that.imgSize = '';
            that.formData.successimg = '';
            that.saveSuccessImg();
          }
        }
      });
    },
    // 预览图片
    previewImage() {
      if (this.successImg) {
        uni.previewImage({
          urls: [this.successImg],
          current: this.successImg
        });
      }
    },
    // 格式化文件大小
    formatSize(size) {
      if (size < 1024) {
        return size + 'B';
      } else if (size < 1024 * 1024) {
        return (size / 1024).toFixed(1) + 'KB';
      } else {
        return (size / 1024 / 1024).toFixed(2) + 'MB';
      }
    },
    showToast(msg) {
      uni.showToast({
        title: msg,
        icon: 'none',
        duration: 1500
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
}

.settings-list {
  background: #ffffff;
  border-radius: 20rpx;
  padding: 30rpx;
  box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.08);
}

.setting-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20rpx 0;
  position: relative;

  &.switch-item:not(:last-child) {
    border-bottom: 1rpx solid #f0f0f0;
  }
}

.label {
  font-size: 30rpx;
  color: #333;
  font-weight: 500;
  width: 160rpx;
}

.input {
  text-align: right;
  font-size: 28rpx;
  color: #333;
  width: 400rpx;
  background: #f8f8f8;
  border-radius: 12rpx;
  padding: 20rpx;
}

.switch {
  transform: scale(0.8);
  transform-origin: right;
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

  &:hover {
    background: #f0f0f0;
  }
}

.arrow {
  font-size: 24rpx;
  color: #999;
}

.dropdown {
  position: absolute;
  top: 100rpx;
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

  &:hover {
    background: #f5f5f5;
  }

  &:last-child {
    border-bottom: none;
  }
}

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
  background: linear-gradient(90deg, #1aad19, #2ecc71);
  color: #fff;
}

::v-deep .placeholder {
  font-size: 28rpx;
  color: #999;
}

.relay-delay-item {
  flex-direction: column;
  align-items: flex-start;
  padding: 20rpx 0 30rpx 0;
  border-bottom: 1rpx solid #f0f0f0;
}

.relay-control {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 15rpx;
  margin-top: 20rpx;
}

.slider-container {
  flex: 1;
  min-width: 200rpx;
  padding-right: 20rpx;
}

.relay-slider {
  width: 100%;
}

.relay-value {
  font-size: 26rpx;
  color: #333;
  font-weight: 500;
  min-width: 80rpx;
  text-align: right;
}

.relay-mode-item {
  border-bottom: 1rpx solid #f0f0f0;
  padding: 25rpx 0;
  flex-direction: column;
  align-items: stretch;
}

.mode-segment {
  display: flex;
  gap: 10rpx;
  margin-top: 15rpx;
  width: 100%;
}

.mode-btn {
  flex: 1;
  padding: 15rpx;
  text-align: center;
  border: 1rpx solid #ccc;
  border-radius: 8rpx;
  background-color: #f5f5f5;
  color: #666;
  font-size: 28rpx;
  font-weight: 500;
  transition: all 0.3s ease;
}

.mode-btn.active {
  background-color: #21CF3E;
  color: #fff;
  border-color: #21CF3E;
}

.relay-btn {
  background: linear-gradient(90deg, #1aad19, #2ecc71);
  color: #fff;
  font-size: 26rpx;
  padding: 12rpx 24rpx;
  border-radius: 8rpx;
  text-align: center;
  min-width: 80rpx;
}

// 开门成功图片样式
.success-img-item {
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
}

.success-img-container {
  flex-shrink: 0;
}

.img-preview {
  position: relative;
  width: 112rpx;  // 506:900 ≈ 1:1.78，高度=112*1.78≈0200rpx
  height: 200rpx;
  border-radius: 8rpx;
  overflow: hidden;
  border: 2rpx solid #eee;
  background: #f5f5f5;

  .preview-image {
    width: 100%;
    height: 100%;
  }

  .img-size {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    font-size: 18rpx;
    text-align: center;
    padding: 4rpx 0;
  }

  .delete-btn {
    position: absolute;
    top: 4rpx;
    right: 4rpx;
    width: 28rpx;
    height: 28rpx;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}

.upload-btn {
  width: 112rpx;
  height: 200rpx;
  border: 2rpx dashed #ccc;
  border-radius: 12rpx;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background: #fafafa;

  .upload-tip {
    font-size: 24rpx;
    color: #999;
    margin-top: 10rpx;
  }

  .upload-hint {
    font-size: 20rpx;
    color: #ccc;
    margin-top: 6rpx;
  }
}
</style>
