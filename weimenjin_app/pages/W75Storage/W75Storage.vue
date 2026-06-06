<template>
  <view class="storage-page">
    <view class="hero-card" v-if="doorData">
      <view class="hero-top">
        <view>
          <view class="hero-title">{{ doorTitle }}</view>
          <view class="hero-subtitle">柜门 #{{ global_lock }} · {{ actionLabel }}</view>
        </view>
        <view class="hero-badge" :class="actionType">
          {{ actionType === 'pickup' ? '取件流程' : '存入流程' }}
        </view>
      </view>
      <view class="status-line">{{ statusText }}</view>
    </view>

    <view v-if="loading" class="state-card">
      <view class="state-title">加载中</view>
      <view class="state-desc">正在确认柜门状态...</view>
    </view>

    <view v-else-if="errorText" class="state-card">
      <view class="state-title">当前无法操作</view>
      <view class="state-desc">{{ errorText }}</view>
      <view class="state-actions">
        <button class="ghost-btn" @click="loadDoorData">重试</button>
        <button class="primary-btn" @click="goBackToScan">重新选柜门</button>
      </view>
    </view>

    <view v-else-if="doorData" class="panel-card">
      <view class="summary-card">
        <view class="summary-row">
          <text class="summary-label">设备名称</text>
          <text class="summary-value">{{ deviceTitle }}</text>
        </view>
        <view class="summary-row">
          <text class="summary-label">当前状态</text>
          <text class="summary-value">{{ doorData.is_used === 1 ? '已占用' : '空闲可用' }}</text>
        </view>
        <view class="summary-row">
          <text class="summary-label">本次费用</text>
          <text class="summary-value" :class="needPay ? 'price-value' : 'free-value'">
            {{ needPay ? `¥${feeText}` : '免费' }}
          </text>
        </view>
      </view>

      <view v-if="actionType === 'store' && !storeOpened" class="form-card">
        <view class="section-title">发件人手机号</view>
        <view v-if="userMobile" class="bound-box">
          <view class="bound-value">{{ maskMobile(userMobile) }}</view>
          <view class="bound-desc">已绑定，可直接用于本次存入订单</view>
        </view>
        <view v-else class="bind-box">
          <view class="bind-title">请先绑定手机号</view>
          <view class="bind-desc">存入订单需要绑定手机号，便于后续分享取件和身份校验。</view>
          <button
            class="primary-btn bind-btn"
            open-type="getPhoneNumber"
            @getphonenumber="handleBindPhone"
          >
            一键绑定手机号
          </button>
        </view>

        <view class="section-title">取件方式</view>
        <radio-group class="pickup-mode-group" @change="onPickupModeChange">
          <label class="mode-option">
            <radio value="self" :checked="pickupMode === 'self'" color="#16a34a" />
            <view>
              <view class="mode-title">仅本人可取</view>
              <view class="mode-desc">存入后由当前账号自己取件，不需要分享给他人。</view>
            </view>
          </label>
          <label class="mode-option">
            <radio value="phone" :checked="pickupMode === 'phone'" color="#16a34a" />
            <view>
              <view class="mode-title">分享给收货人</view>
              <view class="mode-desc">输入收货人手机号，存入后生成订单并分享给对方微信。</view>
            </view>
          </label>
        </radio-group>

        <view class="input-block" v-if="pickupMode === 'phone'">
          <view class="input-label">收货人手机号</view>
          <input
            v-model="recipientMobile"
            class="mobile-input"
            type="number"
            maxlength="11"
            placeholder="请输入收货人手机号"
            placeholder-class="placeholder"
          />
        </view>
      </view>

      <view v-else-if="actionType === 'store' && storeOpened" class="opened-card">
        <view class="section-title">柜门已打开</view>
        <view class="tip-item">请放入物品并关闭柜门，确认无误后点击下面的“已存入”。</view>
        <view class="tip-item" v-if="pickupMode === 'phone'">本单将分享给 {{ recipientMobile }} 对应的微信账号。</view>
        <view class="tip-item" v-else>本单设置为仅本人可取，不会显示分享按钮。</view>
      </view>

      <view class="tips-card">
        <view class="section-title">操作说明</view>
        <view class="tip-item" v-if="actionType === 'store' && !storeOpened">选择空闲柜门后会立即开门，请在柜门旁再继续。</view>
        <view class="tip-item" v-if="actionType === 'store' && needPay">当前设备设置为存入方支付，支付成功后才会开门。</view>
        <view class="tip-item" v-if="actionType === 'pickup'">点击取件前会再次确认，避免不在柜门旁误开门。</view>
        <view class="tip-item" v-if="actionType === 'pickup' && needPay">当前设备设置为取件方支付，支付完成后将自动开门。</view>
      </view>

      <button
        v-if="actionType === 'store' && !storeOpened"
        class="submit-btn"
        :disabled="submitting"
        @tap="submitAction"
      >
        {{ submitButtonText }}
      </button>
      <button
        v-else-if="actionType === 'store' && storeOpened"
        class="submit-btn"
        :disabled="submitting"
        @tap="confirmStored"
      >
        {{ submitting ? '处理中...' : '已存入，生成取件订单' }}
      </button>
      <button
        v-else
        class="submit-btn"
        :disabled="submitting"
        @tap="submitAction"
      >
        {{ submitButtonText }}
      </button>

      <button class="ghost-btn block-btn" :disabled="submitting" @click="goBackToScan">
        重新选择柜门
      </button>
    </view>
  </view>
</template>

<script>
import {
  getW75ScanData_api,
  openW75Lock_api,
  setW75LockUsage_api,
  createW75StorageOrder_api,
  storagePayAndOpenW75_api,
  completeW75Store_api,
  userInfo_api,
  wxXcxMobile_api
} from '../../api/index.js';
import { getQueryString } from '../../libs/utils.js';

export default {
  data() {
    return {
      lock_id: '',
      global_lock: '',
      device_sn: '',
      actionIntent: '',
      loading: true,
      submitting: false,
      errorText: '',
      doorData: null,
      pickupMode: 'self',
      recipientMobile: '',
      userMobile: '',
      storeOpened: false,
      storeOrderNo: ''
    };
  },

  computed: {
    actionType() {
      if (this.actionIntent === 'pickup' && this.canPickup) {
        return 'pickup';
      }
      if (this.actionIntent === 'store' && this.canStore) {
        return 'store';
      }
      if (this.canStore) {
        return 'store';
      }
      if (this.canPickup) {
        return 'pickup';
      }
      return 'store';
    },
    canStore() {
      return !!(this.doorData && parseInt(this.doorData.is_used) !== 1);
    },
    canPickup() {
      return !!(this.doorData && parseInt(this.doorData.is_used) === 1 && this.doorData.can_pickup);
    },
    storageConfig() {
      return this.doorData && this.doorData.storage_config ? this.doorData.storage_config : null;
    },
    needPay() {
      if (!this.storageConfig || parseInt(this.storageConfig.charge_enabled) !== 1) {
        return false;
      }
      const payer = parseInt(this.storageConfig.charge_payer || 1);
      return (this.actionType === 'store' && payer === 1) || (this.actionType === 'pickup' && payer === 2);
    },
    feeText() {
      return Number(this.storageConfig && this.storageConfig.charge_price ? this.storageConfig.charge_price : 0).toFixed(2);
    },
    deviceTitle() {
      return this.doorData && this.doorData.lock_name ? this.doorData.lock_name : '柜门设备';
    },
    doorTitle() {
      return this.doorData && this.doorData.door_name ? this.doorData.door_name : '柜门操作';
    },
    actionLabel() {
      return this.actionType === 'pickup' ? '取出物品' : '存入物品';
    },
    statusText() {
      if (!this.doorData) {
        return '';
      }
      if (this.actionType === 'pickup') {
        return '这是你当前有权限取出的柜门。';
      }
      if (this.storeOpened) {
        return '柜门已打开，放入物品并关好柜门后，再生成取件订单。';
      }
      return '柜门当前空闲，可以开始存入流程。';
    },
    submitButtonText() {
      if (this.submitting) {
        return '处理中...';
      }
      if (this.needPay) {
        return this.actionType === 'pickup' ? `支付并开门取件 ¥${this.feeText}` : `支付并开门存入 ¥${this.feeText}`;
      }
      return this.actionType === 'pickup' ? '确认在柜门旁，立即取件' : '打开柜门开始存入';
    }
  },

  async onLoad(options) {
    this.lock_id = options.lock_id || '';
    this.global_lock = options.global_lock || '';
    this.device_sn = options.device_sn || '';
    this.actionIntent = options.intent === 'pick' ? 'pickup' : (options.intent === 'store' ? 'store' : '');
    this.parseScanOptions(options);

    await Promise.all([this.loadUserInfo(), this.loadDoorData()]);
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
          this.device_sn = params.device_sn || this.device_sn;
        } catch (err) {
          console.error('W75存取页扫码参数解析失败:', err);
        }
      }

      if (options.scene && !this.lock_id) {
        try {
          const scene = decodeURIComponent(options.scene);
          const params = getQueryString(`?${scene.replace(/^\?/, '')}`);
          this.lock_id = params.lock_id || this.lock_id;
          this.global_lock = params.global_lock || this.global_lock;
          this.device_sn = params.device_sn || this.device_sn;
        } catch (err) {
          console.error('W75存取页场景值解析失败:', err);
        }
      }
    },
    async loadUserInfo() {
      try {
        const res = await userInfo_api({});
        if (res.code === 0 && res.data) {
          this.userMobile = res.data.mobile || '';
        }
      } catch (err) {
        console.error('获取用户信息失败:', err);
      }
    },
    async loadDoorData() {
      this.loading = true;
      this.errorText = '';

      try {
        const res = await getW75ScanData_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock
        });

        if (res.code !== 0 || !res.data) {
          this.errorText = res.msg || '获取柜门信息失败';
          return;
        }

        this.doorData = res.data;
        this.device_sn = this.device_sn || res.data.device_sn || '';

        if (parseInt(res.data.work_mode || 1) !== 1) {
          uni.redirectTo({
            url: `/pages/W75Buy/W75Buy?lock_id=${encodeURIComponent(this.lock_id)}&global_lock=${encodeURIComponent(this.global_lock)}`
          });
          return;
        }

        if (!this.canStore && !this.canPickup) {
          this.errorText = parseInt(res.data.is_used) === 1 ? '该柜门已被他人占用，请返回选择其他柜门。' : '当前账号暂无该柜门的取件权限。';
          return;
        }

        if (this.actionIntent === 'store' && !this.canStore) {
          this.errorText = '这个柜门已被占用，请返回重新选择空闲柜门。';
          return;
        }

        if (this.actionIntent === 'pickup' && !this.canPickup) {
          this.errorText = '这个柜门暂时不能由当前账号取件，请返回重新选择。';
          return;
        }

        uni.setNavigationBarTitle({
          title: res.data.door_name || '存取柜门'
        });
      } catch (err) {
        console.error('W75存取页加载失败:', err);
        this.errorText = '网络异常，请稍后重试';
      } finally {
        this.loading = false;
      }
    },
    maskMobile(mobile) {
      if (!mobile || mobile.length !== 11) {
        return mobile || '';
      }
      return `${mobile.slice(0, 3)}****${mobile.slice(-4)}`;
    },
    onPickupModeChange(e) {
      this.pickupMode = e.detail.value;
      if (this.pickupMode === 'self') {
        this.recipientMobile = '';
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
          await this.loadUserInfo();
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
        console.error('W75绑定手机号失败:', err);
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
    async submitAction() {
      if (this.submitting || !this.doorData) {
        if (!this.doorData) {
          uni.showToast({
            title: '柜门信息加载中，请稍后重试',
            icon: 'none'
          });
        }
        return;
      }

      if (this.actionType === 'store') {
        if (!this.userMobile) {
          uni.showToast({
            title: '请先绑定手机号',
            icon: 'none'
          });
          return;
        }
        if (this.pickupMode === 'phone' && !/^1[3-9]\d{9}$/.test(this.recipientMobile.trim())) {
          uni.showToast({
            title: '请输入正确的收货人手机号',
            icon: 'none'
          });
          return;
        }
      }

      if (this.actionType === 'pickup' && !this.canPickup) {
        uni.showToast({
          title: '当前账号暂无取回权限',
          icon: 'none'
        });
        return;
      }

      this.submitting = true;
      try {
        if (this.actionType === 'store') {
          await this.openStoreDoor();
        } else {
          await this.openPickupDoor();
        }
      } finally {
        this.submitting = false;
      }
    },
    async openStoreDoor() {
      if (this.needPay) {
        const orderNo = await this.createPaidOrderAndOpen('store');
        if (orderNo) {
          this.storeOrderNo = orderNo;
          this.storeOpened = true;
        }
        return;
      }

      const ok = await this.openDoorDirectly();
      if (ok) {
        this.storeOpened = true;
      }
    },
    async openPickupDoor() {
      const confirmed = await this.confirmNearby('确认你已经在柜门旁边，开门后请及时取件并关闭柜门。');
      if (!confirmed) {
        return;
      }

      if (this.needPay) {
        await this.createPaidOrderAndOpen('retrieve', true);
        return;
      }

      const ok = await this.openDoorDirectly();
      if (!ok) {
        return;
      }

      const syncOk = await this.syncPickupState();
      if (!syncOk) {
        uni.showModal({
          title: '已开门',
          content: '柜门已打开，但状态同步失败，请联系管理员核查。',
          showCancel: false,
          success: () => {
            uni.switchTab({ url: '/pages/index/index' });
          }
        });
        return;
      }
      this.showPickupSuccess();
    },
    async confirmStored() {
      if (this.submitting) {
        return;
      }
      this.submitting = true;
      try {
        uni.showLoading({
          title: '生成订单中...'
        });
        const res = await completeW75Store_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock,
          order_no: this.storeOrderNo,
          self_only: this.pickupMode === 'self' ? 1 : 0,
          pickup_mobile: this.pickupMode === 'phone' ? this.recipientMobile.trim() : ''
        });
        uni.hideLoading();
        if (res.code !== 0 || !res.data || !res.data.order_no) {
          uni.showToast({
            title: res.msg || '生成订单失败',
            icon: 'none'
          });
          return;
        }
        uni.redirectTo({
          url: `/pages/W75StorageOrder/W75StorageOrder?order_no=${encodeURIComponent(res.data.order_no)}`
        });
      } catch (err) {
        uni.hideLoading();
        console.error('W75生成存入订单失败:', err);
        uni.showToast({
          title: '网络异常，请稍后重试',
          icon: 'none'
        });
      } finally {
        this.submitting = false;
      }
    },
    async createPaidOrderAndOpen(action, showSuccess = false) {
      try {
        uni.showLoading({
          title: '创建订单中...'
        });

        const orderRes = await createW75StorageOrder_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock,
          action
        });

        if (orderRes.code !== 0 || !orderRes.data) {
          uni.hideLoading();
          uni.showToast({
            title: orderRes.msg || '创建订单失败',
            icon: 'none'
          });
          return '';
        }

        const orderData = orderRes.data;
        const payData = this.normalizePayData(orderData);
        if (!payData || !payData.timeStamp) {
          uni.hideLoading();
          uni.showToast({
            title: '支付参数异常',
            icon: 'none'
          });
          return '';
        }

        uni.hideLoading();

        // #ifdef MP-WEIXIN
        let paidOpenSuccess = false;
        await new Promise((resolve) => {
          wx.requestPayment({
            timeStamp: payData.timeStamp,
            nonceStr: payData.nonceStr,
            package: payData.package,
            signType: payData.signType || 'RSA',
            paySign: payData.paySign,
            success: async () => {
              paidOpenSuccess = await this.finishPaidOpen(orderData.order_no);
              if (paidOpenSuccess && showSuccess) {
                this.showPickupSuccess();
              }
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
        return paidOpenSuccess ? (orderData.order_no || '') : '';
        // #endif

        // #ifndef MP-WEIXIN
        uni.showToast({
          title: '请使用微信小程序完成支付',
          icon: 'none'
        });
        return '';
        // #endif
      } catch (err) {
        uni.hideLoading();
        console.error('W75支付开门失败:', err);
        uni.showToast({
          title: '网络异常，请稍后重试',
          icon: 'none'
        });
        return '';
      }
    },
    async finishPaidOpen(orderNo) {
      try {
        uni.showLoading({
          title: '开门中...'
        });
        const openRes = await storagePayAndOpenW75_api({
          order_no: orderNo,
          self_only: this.actionType === 'store' && this.pickupMode === 'self' ? 1 : 0,
          pickup_mobile: this.actionType === 'store' && this.pickupMode === 'phone' ? this.recipientMobile.trim() : ''
        });
        uni.hideLoading();
        if (openRes.code !== 0) {
          uni.showModal({
            title: '提示',
            content: openRes.msg || '开门失败，请联系管理员',
            showCancel: false
          });
          return false;
        }
        return true;
      } catch (err) {
        uni.hideLoading();
        console.error('W75支付后开门失败:', err);
        uni.showModal({
          title: '提示',
          content: '支付成功但开门失败，请联系管理员',
          showCancel: false
        });
        return false;
      }
    },
    async openDoorDirectly() {
      try {
        uni.showLoading({
          title: '开门中...'
        });
        const res = await openW75Lock_api({
          device_sn: this.device_sn || this.doorData.device_sn,
          global_lock: this.global_lock
        });
        uni.hideLoading();
        if (res.code !== 0) {
          uni.showToast({
            title: res.msg || '开门失败',
            icon: 'none'
          });
          return false;
        }
        return true;
      } catch (err) {
        uni.hideLoading();
        console.error('W75开门失败:', err);
        uni.showToast({
          title: '网络异常，请稍后重试',
          icon: 'none'
        });
        return false;
      }
    },
    async syncPickupState() {
      try {
        const res = await setW75LockUsage_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock,
          is_used: 0
        });
        return res && res.code === 0;
      } catch (err) {
        console.error('W75取件状态同步失败:', err);
        return false;
      }
    },
    normalizePayData(orderData) {
      if (!orderData) {
        return null;
      }
      return orderData.payData || orderData;
    },
    confirmNearby(content) {
      return new Promise((resolve) => {
        uni.showModal({
          title: '开门确认',
          content,
          confirmText: '我已在柜门旁',
          cancelText: '暂不开门',
          success: (res) => {
            resolve(!!res.confirm);
          },
          fail: () => resolve(false)
        });
      });
    },
    showPickupSuccess() {
      uni.showModal({
        title: '取件成功',
        content: '柜门已打开，请及时取出物品并关闭柜门。',
        showCancel: false,
        success: () => {
          uni.switchTab({
            url: '/pages/index/index'
          });
        }
      });
    },
    goBackToScan() {
      if (!this.lock_id) {
        this.goHome();
        return;
      }
      uni.redirectTo({
        url: `/pages/W75Scan/W75Scan?lock_id=${encodeURIComponent(this.lock_id)}`
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
.storage-page {
  min-height: 100vh;
  padding: 24rpx;
  box-sizing: border-box;
  background: linear-gradient(180deg, #eef6f1 0%, #f8fafc 32%, #f8fafc 100%);
}

.hero-card,
.panel-card,
.state-card,
.summary-card,
.form-card,
.tips-card,
.opened-card {
  background: #ffffff;
  border-radius: 24rpx;
  box-shadow: 0 16rpx 44rpx rgba(15, 23, 42, 0.07);
}

.hero-card,
.panel-card,
.state-card {
  margin-bottom: 24rpx;
  padding: 32rpx;
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
  margin-top: 12rpx;
  font-size: 26rpx;
  color: #6b7280;
}

.hero-badge {
  padding: 12rpx 20rpx;
  border-radius: 999rpx;
  font-size: 24rpx;
  font-weight: 600;
}

.hero-badge.store {
  color: #166534;
  background: #dcfce7;
}

.hero-badge.pickup {
  color: #1d4ed8;
  background: #dbeafe;
}

.status-line {
  margin-top: 24rpx;
  font-size: 26rpx;
  color: #475569;
}

.state-title,
.section-title {
  font-size: 34rpx;
  font-weight: 700;
  color: #111827;
}

.state-desc {
  margin-top: 18rpx;
  font-size: 26rpx;
  color: #64748b;
  line-height: 1.7;
}

.state-actions {
  display: flex;
  gap: 20rpx;
  margin-top: 28rpx;
}

.summary-card,
.form-card,
.tips-card,
.opened-card {
  padding: 28rpx;
}

.summary-card,
.form-card,
.opened-card {
  margin-bottom: 20rpx;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20rpx;
  padding: 18rpx 0;
  border-bottom: 1rpx solid #eef2f7;
}

.summary-row:last-child {
  border-bottom: none;
}

.summary-label {
  font-size: 26rpx;
  color: #64748b;
}

.summary-value {
  font-size: 28rpx;
  font-weight: 600;
  color: #0f172a;
  text-align: right;
}

.price-value {
  color: #dc2626;
}

.free-value {
  color: #16a34a;
}

.bound-box,
.bind-box {
  margin-top: 18rpx;
  margin-bottom: 28rpx;
  padding: 22rpx;
  border-radius: 18rpx;
  background: #f8fafc;
  border: 1rpx solid #e2e8f0;
}

.bound-value,
.bind-title {
  font-size: 30rpx;
  font-weight: 600;
  color: #0f172a;
}

.bound-desc,
.bind-desc {
  margin-top: 10rpx;
  font-size: 24rpx;
  line-height: 1.7;
  color: #64748b;
}

.bind-btn {
  margin-top: 20rpx;
}

.pickup-mode-group {
  margin-top: 20rpx;
}

.mode-option {
  display: flex;
  align-items: flex-start;
  gap: 16rpx;
  padding: 20rpx 0;
  border-bottom: 1rpx solid #eef2f7;
}

.mode-option:last-child {
  border-bottom: none;
}

.mode-title {
  font-size: 28rpx;
  font-weight: 600;
  color: #0f172a;
}

.mode-desc {
  margin-top: 8rpx;
  font-size: 24rpx;
  color: #64748b;
  line-height: 1.6;
}

.input-block {
  margin-top: 24rpx;
}

.input-label {
  margin-bottom: 14rpx;
  font-size: 26rpx;
  color: #334155;
}

.mobile-input {
  height: 92rpx;
  padding: 0 24rpx;
  border-radius: 18rpx;
  background: #f8fafc;
  border: 1rpx solid #dbe3ef;
  font-size: 30rpx;
  color: #0f172a;
}

.placeholder {
  color: #94a3b8;
}

.tip-item {
  margin-top: 16rpx;
  font-size: 25rpx;
  line-height: 1.7;
  color: #475569;
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
  margin-top: 20rpx;
  width: 100%;
}

.ghost-btn {
  color: #166534;
  background: #edfdf3;
  border: 1rpx solid #bbf7d0;
}
</style>
