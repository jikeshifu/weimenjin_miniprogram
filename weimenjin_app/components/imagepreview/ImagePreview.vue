<template>
  <view v-if="visible" class="preview-container">
    <view class="preview-overlay" @click="closePreview"></view>
    <!-- 确保图片模式和样式正确 -->
    <image :src="url" class="preview-image" mode="widthFix" @error="onImageError"></image>
    <view class="close-button" @click="closePreview">关闭</view>
  </view>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      visible: true
    };
  },
  methods: {
    closePreview() {
      this.visible = false;
      this.$emit('close');
    },
    onImageError() {
      console.error("Failed to load image:", this.url);  // 输出加载失败的错误
    }
  }
};
</script>

<style scoped>
.preview-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.preview-image {
  width: 80%;  /* 调整图片宽度 */
  height: auto; /* 保持比例 */
}
.close-button {
  position: absolute;
  top: 30px;
  right: 30px;
  color: white;
  font-size: 40rpx;
  background-color: rgba(0, 0, 0, 0.5);
  padding: 10rpx;
  border-radius: 50%;
}
.preview-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
