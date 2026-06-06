<template>
  <view class="container">
    <!-- 商品信息 -->
    <view class="product-card" v-if="skuInfo">
      <image class="product-image" :src="getImgPath(skuInfo.sku_image)" mode="aspectFill"></image>
      <view class="product-info">
        <view class="product-name">{{ skuInfo.sku_name }}</view>
        <view class="product-desc" v-if="skuInfo.sku_desc">{{ skuInfo.sku_desc }}</view>
        <view class="product-price">
          <text class="price">¥{{ skuInfo.price.toFixed(2) }}</text>
          <text class="original-price" v-if="skuInfo.original_price > skuInfo.price">¥{{ skuInfo.original_price.toFixed(2) }}</text>
        </view>
        <view class="product-stock">库存: {{ skuInfo.stock }}</view>
      </view>
    </view>

    <!-- 柜门信息 -->
    <view class="door-info" v-if="skuInfo">
      <view class="info-item">
        <text class="label">柜门编号</text>
        <text class="value">#{{ global_lock }}</text>
      </view>
      <view class="info-item">
        <text class="label">柜门名称</text>
        <text class="value">{{ skuInfo.lock_name }}</text>
      </view>
    </view>

    <!-- 购买按钮 -->
    <view class="buy-section" v-if="skuInfo">
      <view class="buy-btn" @click="onBuy" v-if="!paying">
        <text>立即购买 ¥{{ skuInfo.price.toFixed(2) }}</text>
      </view>
      <view class="buy-btn disabled" v-else>
        <text>支付中...</text>
      </view>
    </view>

    <!-- 加载中 -->
    <view class="loading-box" v-if="loading">
      <text>加载中...</text>
    </view>

    <!-- 错误提示 -->
    <view class="error-box" v-if="errorMsg">
      <text>{{ errorMsg }}</text>
      <view class="retry-btn" @click="loadSkuInfo">重试</view>
    </view>
  </view>
</template>

<script>
import { imgPath } from '@/libs/filters.js';
import { getQueryString } from '../../libs/utils.js';
import {
  getW75SkuDetail_api,
  createW75Order_api,
  payAndOpenW75_api
} from '../../api/index.js';

export default {
  data() {
    return {
      lock_id: '',
      global_lock: '',
      skuInfo: null,
      loading: true,
      paying: false,
      errorMsg: ''
    };
  },

  onLoad(options) {
    this.lock_id = options.lock_id;
    this.global_lock = options.global_lock;
    this.parseScanOptions(options);
    this.loadSkuInfo();
  },

  methods: {
    parseScanOptions(options) {
      if (!options) {
        return;
      }

      if (options.q) {
        try {
          const scene = decodeURIComponent(options.q);
          const params = getQueryString(scene);
          this.lock_id = params.lock_id || this.lock_id;
          this.global_lock = params.global_lock || this.global_lock;
        } catch (err) {
          console.error('W75售卖页扫码参数解析失败:', err);
        }
      }

      if (options.scene && !this.lock_id) {
        try {
          const scene = decodeURIComponent(options.scene);
          const params = getQueryString(`?${scene.replace(/^\?/, '')}`);
          this.lock_id = params.lock_id || this.lock_id;
          this.global_lock = params.global_lock || this.global_lock;
        } catch (err) {
          console.error('W75售卖页场景值解析失败:', err);
        }
      }
    },
    getImgPath(url) {
      return imgPath(url);
    },

    async loadSkuInfo() {
      this.loading = true;
      this.errorMsg = '';

      try {
        const res = await getW75SkuDetail_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock
        });

        if (res.code === 0 && res.data) {
          this.skuInfo = res.data;
          uni.setNavigationBarTitle({
            title: res.data.sku_name || '商品购买'
          });
        } else {
          this.errorMsg = res.msg || '获取商品信息失败';
        }
      } catch (e) {
        console.error('获取商品信息失败:', e);
        this.errorMsg = '网络异常，请重试';
      } finally {
        this.loading = false;
      }
    },

    async onBuy() {
      if (this.paying) return;

      this.paying = true;
      uni.showLoading({ title: '创建订单中...' });

      try {
        // 创建订单
        const orderRes = await createW75Order_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock
        });

        if (orderRes.code !== 0 || !orderRes.data) {
          uni.hideLoading();
          uni.showToast({ title: orderRes.msg || '创建订单失败', icon: 'none' });
          this.paying = false;
          return;
        }

        const orderData = orderRes.data;
        const payData = this.normalizePayData(orderData);
        if (!payData || !payData.timeStamp) {
          uni.hideLoading();
          uni.showToast({ title: '支付参数异常', icon: 'none' });
          this.paying = false;
          return;
        }

        // 调起微信支付
        // #ifdef MP-WEIXIN
        uni.hideLoading();
        wx.requestPayment({
          timeStamp: payData.timeStamp,
          nonceStr: payData.nonceStr,
          package: payData.package,
          signType: payData.signType || 'RSA',
          paySign: payData.paySign,
          success: async () => {
            // 支付成功，开门取货
            uni.showLoading({ title: '开门中...' });
            try {
              const openRes = await payAndOpenW75_api({
                order_no: orderData.order_no
              });
              uni.hideLoading();

              if (openRes.code === 0) {
                uni.showModal({
                  title: '购买成功',
                  content: '柜门已打开，请取走您的商品',
                  showCancel: false,
                  success: () => {
                    uni.switchTab({ url: '/pages/index/index' });
                  }
                });
              } else {
                uni.showModal({
                  title: '提示',
                  content: openRes.msg || '开门失败，请联系管理员',
                  showCancel: false
                });
              }
            } catch (e) {
              uni.hideLoading();
              uni.showModal({
                title: '提示',
                content: '支付成功但开门失败，请联系管理员',
                showCancel: false
              });
            }
          },
          fail: (err) => {
            console.log('支付取消或失败:', err);
            uni.showToast({ title: '支付取消', icon: 'none' });
          },
          complete: () => {
            this.paying = false;
          }
        });
        // #endif

        // #ifdef MP-ALIPAY
        uni.hideLoading();
        my.tradePay({
          tradeNO: orderData.trade_no,
          success: async (payRes) => {
            if (payRes.resultCode === '9000') {
              // 支付成功
              uni.showLoading({ title: '开门中...' });
              try {
                const openRes = await payAndOpenW75_api({
                  order_no: orderData.order_no
                });
                uni.hideLoading();

                if (openRes.code === 0) {
                  uni.showModal({
                    title: '购买成功',
                    content: '柜门已打开，请取走您的商品',
                    showCancel: false,
                    success: () => {
                      uni.switchTab({ url: '/pages/index/index' });
                    }
                  });
                } else {
                  uni.showModal({
                    title: '提示',
                    content: openRes.msg || '开门失败，请联系管理员',
                    showCancel: false
                  });
                }
              } catch (e) {
                uni.hideLoading();
                uni.showModal({
                  title: '提示',
                  content: '支付成功但开门失败，请联系管理员',
                  showCancel: false
                });
              }
            } else {
              uni.showToast({ title: '支付取消', icon: 'none' });
            }
          },
          fail: () => {
            uni.showToast({ title: '支付失败', icon: 'none' });
          },
          complete: () => {
            this.paying = false;
          }
        });
        // #endif

      } catch (e) {
        uni.hideLoading();
        console.error('购买失败:', e);
        uni.showToast({ title: '网络异常，请重试', icon: 'none' });
        this.paying = false;
      }
    },
    normalizePayData(orderData) {
      if (!orderData) {
        return null;
      }
      return orderData.payData || orderData;
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
  background: #f5f5f5;
  padding: 20rpx;
}

.product-card {
  background: #fff;
  border-radius: 16rpx;
  overflow: hidden;
  margin-bottom: 20rpx;

  .product-image {
    width: 100%;
    height: 400rpx;
  }

  .product-info {
    padding: 24rpx;

    .product-name {
      font-size: 32rpx;
      font-weight: 600;
      color: #333;
      margin-bottom: 12rpx;
    }

    .product-desc {
      font-size: 26rpx;
      color: #666;
      margin-bottom: 16rpx;
      line-height: 1.5;
    }

    .product-price {
      display: flex;
      align-items: baseline;
      margin-bottom: 12rpx;

      .price {
        font-size: 40rpx;
        font-weight: 600;
        color: #ff4d4f;
      }

      .original-price {
        font-size: 26rpx;
        color: #999;
        text-decoration: line-through;
        margin-left: 16rpx;
      }
    }

    .product-stock {
      font-size: 24rpx;
      color: #999;
    }
  }
}

.door-info {
  background: #fff;
  border-radius: 16rpx;
  padding: 24rpx;
  margin-bottom: 20rpx;

  .info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16rpx 0;
    border-bottom: 1px solid #f0f0f0;

    &:last-child {
      border-bottom: none;
    }

    .label {
      font-size: 28rpx;
      color: #666;
    }

    .value {
      font-size: 28rpx;
      color: #333;
      font-weight: 500;
    }
  }
}

.buy-section {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 20rpx 30rpx;
  padding-bottom: calc(20rpx + env(safe-area-inset-bottom));
  background: #fff;
  box-shadow: 0 -4rpx 20rpx rgba(0, 0, 0, 0.1);

  .buy-btn {
    height: 88rpx;
    background: linear-gradient(135deg, #ff9800 0%, #ff5722 100%);
    border-radius: 44rpx;
    display: flex;
    align-items: center;
    justify-content: center;

    text {
      font-size: 32rpx;
      color: #fff;
      font-weight: 600;
    }

    &.disabled {
      background: #ccc;
    }
  }
}

.loading-box, .error-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 100rpx 0;

  text {
    font-size: 28rpx;
    color: #999;
  }
}

.error-box {
  .retry-btn {
    margin-top: 30rpx;
    padding: 16rpx 40rpx;
    background: #07c160;
    color: #fff;
    border-radius: 8rpx;
    font-size: 28rpx;
  }
}
</style>
