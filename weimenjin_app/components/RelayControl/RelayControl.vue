<template>
  <view class="relay-component" :class="[active ? 'active' : '', type]" :style="screenSizeStyle">
    <!-- 电磁线圈 -->
    <view class="coil" :class="{ energized: active }">
      <view class="coil-windings"></view>
    </view>

    <!-- 触点 -->
    <view class="contacts">
      <!-- 常开触点 (NO) -->
      <view class="contact-pair no">
        <text class="contact-label">NO</text>
        <view class="fixed-contact"></view>
        <view class="movable-contact" :class="{ closed: active }"></view>
        <view class="contact-line" :class="{ connected: active }"></view>
      </view>
    </view>

    <!-- 指示灯 -->
    <view class="indicator" :class="{ on: active }"></view>
  </view>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'on',
    },
    active: {
      type: Boolean,
      default: false,
    },
    screenSize: {
      type: String,
      default: 'medium',
    },
  },
  computed: {
    screenSizeStyle() {
      return {
        transform: this.screenSize === 'small' ? 'scale(0.8)' : (this.screenSize === 'medium' ? 'scale(1)' : 'scale(1.2)'),
      };
    },
  },
  watch: {
    active(newVal) {
      console.log(`RelayComponent active changed to ${newVal} for type: ${this.type}`);
      if (newVal) {
        uni.vibrateShort({ type: 'medium' });
      }
    },
  },
};
</script>

<style scoped>
.relay-component {
  width: 100%;
  height: 200rpx;
  position: relative;
  background-color: #f7f7f7;
  border-radius: 8rpx;
  overflow: hidden;
  box-shadow: inset 0 2rpx 8rpx rgba(0, 0, 0, 0.1);
}

.coil {
  position: absolute;
  left: 50%;
  bottom: 13rpx;
  width: 120rpx;
  height: 80rpx;
  background-color: #d9d9d9;
  border-radius: 8rpx;
  transform: translateX(-50%);
  border: 4rpx solid #bfbfbf;
  overflow: hidden;
  transition: all 0.3s ease;
}

.coil.energized {
  background-color: #3b82f6;
  box-shadow: 0 0 20rpx rgba(59, 130, 246, 0.5);
}

.coil-windings {
  position: absolute;
  inset: 8rpx;
  border-radius: 4rpx;
  background-image: repeating-linear-gradient(
    to bottom,
    #bfbfbf,
    #bfbfbf 4rpx,
    #d9d9d9 4rpx,
    #d9d9d9 8rpx
  );
  transition: all 0.3s ease;
}

.coil.energized .coil-windings {
  background-image: repeating-linear-gradient(
    to bottom,
    #2563eb,
    #2563eb 4rpx,
    #3b82f6 4rpx,
    #3b82f6 8rpx
  );
}

.contacts {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}

.contact-pair {
  position: absolute;
  width: 180rpx;
  height: 40rpx;
}

.contact-pair.no {
  right: 20rpx;
  top: 60rpx;
}

.contact-label {
  position: absolute;
  left: -60rpx;
  top: 4rpx;
  font-size: 24rpx;
  font-family: monospace;
  color: #6b7280;
}

.fixed-contact {
  position: absolute;
  right: 0;
  top: 0;
  width: 60rpx;
  height: 12rpx;
  background-color: #4b5563;
  border-radius: 4rpx;
}

.movable-contact {
  position: absolute;
  left: 0;
  top: 0;
  width: 60rpx;
  height: 12rpx;
  background-color: #4b5563;
  border-radius: 4rpx;
  transition: transform 0.3s ease;
}

.movable-contact.closed {
  transform: translateX(40rpx);
}

.contact-line {
  position: absolute;
  top: 4rpx;
  left: 80rpx;
  width: 40rpx;
  height: 4rpx;
  background-color: #facc15;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.contact-line.connected {
  opacity: 1;
}

.indicator {
  position: absolute;
  top: 20rpx;
  right: 20rpx;
  width: 32rpx;
  height: 32rpx;
  border-radius: 50%;
  background-color: #d9d9d9;
  border: 4rpx solid #bfbfbf;
  transition: all 0.3s ease;
}

.indicator.on {
  box-shadow: 0 0 20rpx currentColor;
}

.on .indicator.on {
  background-color: #07c160;
  border-color: #05a54e;
}

.off .indicator.on {
  background-color: #e34d59;
  border-color: #c1353f;
}

.standby .indicator.on {
  background-color: #ed7b2f;
  border-color: #d46a1e;
}
</style>
