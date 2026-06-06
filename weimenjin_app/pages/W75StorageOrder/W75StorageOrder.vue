<template>
  <view class="order-page">
    <view v-if="loading" class="state-card">
      <view class="state-title">加载中</view>
      <view class="state-desc">正在获取订单信息...</view>
    </view>

    <view v-else-if="errorText" class="state-card">
      <view class="state-title">暂时无法打开</view>
      <view class="state-desc">{{ errorText }}</view>
      <view class="state-actions">
        <button class="ghost-btn" @click="loadPageData">重试</button>
        <button class="primary-btn" @click="goHome">返回首页</button>
      </view>
    </view>

    <block v-else-if="orderDetail">
      <view class="hero-card">
        <view class="hero-top">
          <view>
            <view class="hero-title">{{ orderDetail.door_name }}</view>
            <view class="hero-subtitle">订单号 {{ orderDetail.order_no }}</view>
          </view>
          <view class="hero-badge" :class="orderDetail.is_active ? 'active' : 'done'">
            {{ orderDetail.is_active ? '待取件' : '已完成' }}
          </view>
        </view>
        <view class="hero-desc">{{ roleText }}</view>
      </view>

      <view class="panel-card">
        <view class="section-title">订单信息</view>
        <view class="info-row">
          <text class="info-label">设备名称</text>
          <text class="info-value">{{ orderDetail.device_name }}</text>
        </view>
        <view class="info-row">
          <text class="info-label">柜门编号</text>
          <text class="info-value">#{{ orderDetail.global_lock }}</text>
        </view>
        <view class="info-row">
          <text class="info-label">存入时间</text>
          <text class="info-value">{{ orderDetail.create_time_str }}</text>
        </view>
        <view class="info-row">
          <text class="info-label">收货方式</text>
          <text class="info-value">{{ orderDetail.recipient_mobile_masked }}</text>
        </view>
        <view class="info-row" v-if="pickupNeedPay">
          <text class="info-label">取件费用</text>
          <text class="info-value price-value">¥{{ pickupFeeText }}</text>
        </view>
      </view>

      <view v-if="orderDetail.need_bind_phone" class="panel-card">
        <view class="section-title">先绑定手机号</view>
        <view class="hint-text">取件权限需要通过手机号校验，请先完成手机号绑定。</view>
        <button class="primary-btn block-btn" open-type="getPhoneNumber" @getphonenumber="handleBindPhone">
          一键绑定手机号
        </button>
      </view>

      <view v-if="orderDetail.permission_message" class="panel-card">
        <view class="section-title">当前不可取件</view>
        <view class="hint-text">{{ orderDetail.permission_message }}</view>
      </view>

      <view v-if="orderDetail.can_share" class="panel-card">
        <view class="section-title">分享给收货人</view>
        <view class="hint-text">把这张订单页面分享给收货人，对方打开后需要再次确认在柜门旁边，才会真正开门。</view>
        <button class="primary-btn block-btn" open-type="share">分享到微信</button>
      </view>

      <view class="panel-card">
        <view class="section-title">取件说明</view>
        <view class="hint-text">收货人打开后，需要先确认已在柜门旁，再执行开门，避免远程误开门导致柜门无法及时关闭。</view>
        <view class="hint-text" v-if="pickupNeedPay">当前设备设置为取件方支付，支付成功后才会开门。</view>
        <view class="hint-text" v-if="!orderDetail.is_active">这个订单对应的物品已经取走，分享链接仅保留查看用途。</view>
      </view>

      <button
        v-if="orderDetail.can_pickup && userMobile"
        class="submit-btn"
        :disabled="submitting"
        @tap="handlePickup"
      >
        {{ submitting ? '处理中...' : pickupButtonText }}
      </button>
    </block>
  </view>
</template>

<script>
import {
  userInfo_api,
  wxXcxMobile_api,
  getW75StorageOrderDetail_api,
  createW75StorageOrder_api,
  storagePayAndOpenW75_api,
  openW75Lock_api,
  setW75LockUsage_api
} from '../../api/index.js';
import { getQueryString } from '../../libs/utils.js';

export default {
  data() {
    return {
      orderNo: '',
      loading: true,
      submitting: false,
      errorText: '',
      orderDetail: null,
      userMobile: '',
      shareMode: 0
    };
  },

  computed: {
    roleText() {
      if (!this.orderDetail) {
        return '';
      }
      if (this.orderDetail.is_owner) {
        return this.orderDetail.can_share ? '你已完成存入，可以把订单分享给收货人。' : '这是你创建的存入订单。';
      }
      if (this.orderDetail.is_recipient) {
        return '这是分享给你的取件订单，开门前会再次确认。';
      }
      return '订单详情';
    },
    pickupNeedPay() {
      if (!this.orderDetail || !this.orderDetail.storage_config) {
        return false;
      }
      const config = this.orderDetail.storage_config;
      return parseInt(config.charge_enabled || 0) === 1 && parseInt(config.charge_payer || 1) === 2;
    },
    pickupFeeText() {
      if (!this.orderDetail || !this.orderDetail.storage_config) {
        return '0.00';
      }
      return Number(this.orderDetail.storage_config.charge_price || 0).toFixed(2);
    },
    pickupButtonText() {
      if (this.pickupNeedPay) {
        return `确认在柜门旁，支付并取件 ¥${this.pickupFeeText}`;
      }
      return '确认在柜门旁，立即取件';
    }
  },

  async onLoad(options) {
    this.parseOptions(options);
    await this.loadPageData();
  },

  onShareAppMessage() {
    return {
      title: `${this.orderDetail ? this.orderDetail.door_name : '柜门'}取件通知`,
      path: `/pages/W75StorageOrder/W75StorageOrder?order_no=${encodeURIComponent(this.orderNo)}&share=1`
    };
  },

  methods: {
    parseOptions(options) {
      this.orderNo = options.order_no || '';
      this.shareMode = options.share ? 1 : 0;

      if (options.q) {
        try {
          const scene = decodeURIComponent(options.q);
          const params = getQueryString(scene);
          this.orderNo = params.order_no || this.orderNo;
          this.shareMode = params.share ? 1 : this.shareMode;
        } catch (err) {
          console.error('W75订单页扫码参数解析失败:', err);
        }
      }
    },
    async loadPageData() {
      this.loading = true;
      this.errorText = '';
      try {
        const [userRes, orderRes] = await Promise.all([
          userInfo_api({}),
          getW75StorageOrderDetail_api({ order_no: this.orderNo })
        ]);

        if (userRes.code === 0 && userRes.data) {
          this.userMobile = userRes.data.mobile || '';
        }

        if (orderRes.code !== 0 || !orderRes.data) {
          this.errorText = orderRes.msg || '获取订单失败';
          return;
        }

        this.orderDetail = orderRes.data;
        uni.setNavigationBarTitle({
          title: orderRes.data.door_name || '存取订单'
        });
      } catch (err) {
        console.error('W75订单页加载失败:', err);
        this.errorText = '网络异常，请稍后重试';
      } finally {
        this.loading = false;
      }
    },
    async handleBindPhone(e) {
      // #ifdef MP-WEIXIN
      try {
        if (!e.detail || !e.detail.code) {
          uni.showToast({
            title: '未获取到手机号授权',
            icon: 'none'
          });
          return;
        }
        uni.showLoading({
          title: '绑定中...'
        });
        const res = await wxXcxMobile_api({
          code: e.detail.code
        });
        uni.hideLoading();
        if (res.code === 0) {
          await this.loadPageData();
          uni.showToast({
            title: '绑定成功',
            icon: 'success'
          });
        } else {
          uni.showToast({
            title: res.msg || '绑定失败',
            icon: 'none'
          });
        }
      } catch (err) {
        uni.hideLoading();
        console.error('W75订单页绑定手机号失败:', err);
        uni.showToast({
          title: '绑定失败，请重试',
          icon: 'none'
        });
      }
      // #endif

      // #ifndef MP-WEIXIN
      uni.showToast({
        title: '请到个人中心绑定手机号',
        icon: 'none'
      });
      // #endif
    },
    confirmNearby() {
      return new Promise((resolve) => {
        uni.showModal({
          title: '开门确认',
          content: '请确认你已在柜门旁边，开门后请及时取出物品并关闭柜门。',
          confirmText: '确认开门',
          cancelText: '稍后再取',
          success: (res) => resolve(!!res.confirm),
          fail: () => resolve(false)
        });
      });
    },
    async handlePickup() {
      if (this.submitting) {
        return;
      }
      if (!this.orderDetail) {
        uni.showToast({
          title: '订单信息加载中，请稍后重试',
          icon: 'none'
        });
        return;
      }
      if (!this.userMobile) {
        uni.showToast({
          title: '请先绑定手机号',
          icon: 'none'
        });
        return;
      }
      if (!this.orderDetail.is_active) {
        uni.showToast({
          title: '这个订单已完成，不能再取回',
          icon: 'none'
        });
        return;
      }
      if (!this.orderDetail.can_pickup) {
        uni.showToast({
          title: this.orderDetail.permission_message || '当前账号暂无取件权限',
          icon: 'none'
        });
        return;
      }
      const confirmed = await this.confirmNearby();
      if (!confirmed) {
        return;
      }

      this.submitting = true;
      try {
        if (this.pickupNeedPay) {
          await this.handlePaidPickup();
        } else {
          await this.handleFreePickup();
        }
      } finally {
        this.submitting = false;
      }
    },
    async handlePaidPickup() {
      try {
        uni.showLoading({
          title: '创建订单中...'
        });
        const orderRes = await createW75StorageOrder_api({
          lock_id: this.orderDetail.lock_id,
          global_lock: this.orderDetail.global_lock,
          action: 'retrieve'
        });
        if (orderRes.code !== 0 || !orderRes.data) {
          uni.hideLoading();
          uni.showToast({
            title: orderRes.msg || '创建订单失败',
            icon: 'none'
          });
          return;
        }

        const payData = (orderRes.data.payData || orderRes.data);
        if (!payData || !payData.timeStamp) {
          uni.hideLoading();
          uni.showToast({
            title: '支付参数异常',
            icon: 'none'
          });
          return;
        }

        uni.hideLoading();

        // #ifdef MP-WEIXIN
        await new Promise((resolve) => {
          wx.requestPayment({
            timeStamp: payData.timeStamp,
            nonceStr: payData.nonceStr,
            package: payData.package,
            signType: payData.signType || 'RSA',
            paySign: payData.paySign,
            success: async () => {
              await this.finishPaidPickup(orderRes.data.order_no);
              resolve();
            },
            fail: () => {
              uni.showToast({
                title: '支付取消',
                icon: 'none'
              });
              resolve();
            }
          });
        });
        // #endif

        // #ifndef MP-WEIXIN
        uni.showToast({
          title: '请使用微信小程序完成支付',
          icon: 'none'
        });
        // #endif
      } catch (err) {
        uni.hideLoading();
        console.error('W75收费取件失败:', err);
        uni.showToast({
          title: '网络异常，请稍后重试',
          icon: 'none'
        });
      }
    },
    async finishPaidPickup(orderNo) {
      try {
        uni.showLoading({
          title: '开门中...'
        });
        const openRes = await storagePayAndOpenW75_api({
          order_no: orderNo
        });
        uni.hideLoading();
        if (openRes.code !== 0) {
          uni.showModal({
            title: '提示',
            content: openRes.msg || '开门失败，请联系管理员',
            showCancel: false
          });
          return;
        }
        this.showOrderCompleted();
      } catch (err) {
        uni.hideLoading();
        console.error('W75收费取件开门失败:', err);
        uni.showModal({
          title: '提示',
          content: '支付成功但开门失败，请联系管理员',
          showCancel: false
        });
      }
    },
    async handleFreePickup() {
      try {
        uni.showLoading({
          title: '开门中...'
        });
        const openRes = await openW75Lock_api({
          device_sn: this.orderDetail.device_sn,
          global_lock: this.orderDetail.global_lock
        });
        if (openRes.code !== 0) {
          uni.hideLoading();
          uni.showToast({
            title: openRes.msg || '开门失败',
            icon: 'none'
          });
          return;
        }
        const syncRes = await setW75LockUsage_api({
          lock_id: this.orderDetail.lock_id,
          global_lock: this.orderDetail.global_lock,
          is_used: 0
        });
        uni.hideLoading();
        if (!syncRes || syncRes.code !== 0) {
          uni.showModal({
            title: '已开门',
            content: '柜门已打开，但状态同步失败，请联系管理员核查。',
            showCancel: false
          });
          return;
        }
        this.showOrderCompleted();
      } catch (err) {
        uni.hideLoading();
        console.error('W75免费取件失败:', err);
        uni.showToast({
          title: '网络异常，请稍后重试',
          icon: 'none'
        });
      }
    },
    showPickupSuccess() {
      uni.showModal({
        title: '取件成功',
        content: '柜门已打开，请及时取出物品并关闭柜门。',
        showCancel: false,
        success: async () => {
          await this.loadPageData();
        }
      });
    },
    showOrderCompleted() {
      uni.showModal({
        title: '取件成功',
        content: '柜门已打开，请及时取出物品并关好柜门。当前订单会保留在本页，并更新为已完成。',
        showCancel: false,
        success: async () => {
          await this.loadPageData();
        }
      });
    },
    goHome() {
      uni.switchTab({
        url: '/pages/index/index'
      });
    }
  }
};
</script>

<style scoped lang="scss">
.order-page {
  min-height: 100vh;
  padding: 24rpx;
  box-sizing: border-box;
  background: linear-gradient(180deg, #f3f8f4 0%, #f8fafc 32%, #f8fafc 100%);
}

.hero-card,
.panel-card,
.state-card {
  background: #ffffff;
  border-radius: 24rpx;
  box-shadow: 0 16rpx 44rpx rgba(15, 23, 42, 0.07);
  padding: 32rpx;
  margin-bottom: 24rpx;
}

.hero-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 24rpx;
}

.hero-title {
  font-size: 40rpx;
  font-weight: 700;
  color: #111827;
}

.hero-subtitle {
  margin-top: 10rpx;
  font-size: 24rpx;
  color: #6b7280;
}

.hero-badge {
  padding: 12rpx 20rpx;
  border-radius: 999rpx;
  font-size: 24rpx;
  font-weight: 600;
}

.hero-badge.active {
  color: #92400e;
  background: #fef3c7;
}

.hero-badge.done {
  color: #166534;
  background: #dcfce7;
}

.hero-desc,
.hint-text,
.state-desc {
  margin-top: 18rpx;
  font-size: 25rpx;
  line-height: 1.7;
  color: #475569;
}

.state-title,
.section-title {
  font-size: 34rpx;
  font-weight: 700;
  color: #111827;
}

.info-row {
  display: flex;
  justify-content: space-between;
  gap: 20rpx;
  padding: 18rpx 0;
  border-bottom: 1rpx solid #eef2f7;
}

.info-row:last-child {
  border-bottom: none;
}

.info-label {
  font-size: 26rpx;
  color: #64748b;
}

.info-value {
  max-width: 60%;
  text-align: right;
  font-size: 27rpx;
  font-weight: 600;
  color: #0f172a;
}

.price-value {
  color: #dc2626;
}

.state-actions {
  display: flex;
  gap: 20rpx;
  margin-top: 28rpx;
}

.submit-btn,
.primary-btn,
.ghost-btn {
  border-radius: 18rpx;
  font-size: 30rpx;
  font-weight: 600;
}

.submit-btn,
.primary-btn {
  color: #ffffff;
  background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
}

.block-btn {
  width: 100%;
  margin-top: 20rpx;
}

.ghost-btn {
  color: #166534;
  background: #edfdf3;
  border: 1rpx solid #bbf7d0;
}
</style>
