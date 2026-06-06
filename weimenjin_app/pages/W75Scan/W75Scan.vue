<template>
  <view class="scan-page">
    <view class="hero-card">
      <view class="hero-top">
        <view>
          <view class="hero-title">{{ pageTitle }}</view>
          <view class="hero-subtitle">{{ pageSubtitle }}</view>
        </view>
        <view class="hero-badge" :class="workMode === 2 ? 'sell' : 'storage'">
          {{ workMode === 2 ? '售卖模式' : '存取模式' }}
        </view>
      </view>

      <view class="hero-stats" v-if="!isSingleDoor && scanData">
        <view class="stat-item" v-if="workMode === 1">
          <view class="stat-value">{{ availableDoors.length }}</view>
          <view class="stat-label">空闲柜门</view>
        </view>
        <view class="stat-item" v-if="workMode === 1">
          <view class="stat-value">{{ ownerDoors.length }}</view>
          <view class="stat-label">我投递的</view>
        </view>
        <view class="stat-item" v-if="workMode === 1">
          <view class="stat-value">{{ recipientDoors.length }}</view>
          <view class="stat-label">我待取的</view>
        </view>
        <view class="stat-item" v-if="workMode === 2">
          <view class="stat-value">{{ sellDoors.length }}</view>
          <view class="stat-label">可售商品</view>
        </view>
      </view>
    </view>

    <view v-if="loading" class="state-card">
      <view class="state-title">加载中</view>
      <view class="state-desc">{{ statusText }}</view>
    </view>

    <view v-else-if="errorText" class="state-card">
      <view class="state-title">暂时无法进入</view>
      <view class="state-desc">{{ errorText }}</view>
      <view class="state-actions">
        <button class="ghost-btn" @click="loadScanData">重试</button>
        <button class="primary-btn" @click="goHome">返回首页</button>
      </view>
    </view>

    <block v-else-if="!isSingleDoor && scanData">
      <view v-if="workMode === 1" class="panel-card">
        <view class="panel-tabs">
          <view
            class="tab-item"
            :class="{ active: activeTab === 'store' }"
            @click="activeTab = 'store'"
          >
            我要存入
          </view>
          <view
            class="tab-item"
            :class="{ active: activeTab === 'owner' }"
            @click="activeTab = 'owner'"
          >
            我投递的
          </view>
          <view
            class="tab-item"
            :class="{ active: activeTab === 'recipient' }"
            @click="activeTab = 'recipient'"
          >
            我待取的
          </view>
        </view>

        <view v-if="activeTab === 'store'">
          <view class="section-tip">请选择一个空闲柜门。开门放入物品后，还需要点击“已存入”生成取件订单。</view>
          <view v-if="availableDoors.length" class="door-list">
            <view class="door-card" v-for="door in availableDoors" :key="'store-' + door.global_lock">
              <view>
                <view class="door-name">{{ door.door_name }}</view>
                <view class="door-meta">柜门 #{{ door.global_lock }} · 空闲可用</view>
              </view>
              <button class="primary-btn mini-btn" @click="goStorageDoor(door, 'store')">使用</button>
            </view>
          </view>
          <view v-else class="empty-card">当前没有空闲柜门可供存入。</view>
        </view>

        <view v-else-if="activeTab === 'owner'">
          <view class="section-tip">这里展示你已经投递完成的柜门。你自己也可以回来取，或进入订单页继续分享给收货人。</view>
          <view v-if="ownerDoors.length" class="door-list">
            <view class="door-card" v-for="door in ownerDoors" :key="'owner-' + door.global_lock">
              <view>
                <view class="door-name">{{ door.door_name }}</view>
                <view class="door-meta">
                  柜门 #{{ door.global_lock }}
                  <text v-if="door.pickup_mobile"> · 收货人 {{ maskMobile(door.pickup_mobile) }}</text>
                  <text v-else> · 仅本人可取</text>
                </view>
              </view>
              <view class="door-actions">
                <button class="ghost-btn mini-btn" @click="goOwnerOrder(door)">查看订单</button>
                <button class="primary-btn mini-btn" @click="goStorageDoor(door, 'pickup')">我来取回</button>
              </view>
            </view>
          </view>
          <view v-else class="empty-card">当前没有我投递的柜门。</view>
        </view>

        <view v-else>
          <view class="section-tip">这里展示分享给你的柜门，取件前会再次确认你已在柜门旁边。</view>
          <view v-if="recipientDoors.length" class="door-list">
            <view class="door-card" v-for="door in recipientDoors" :key="'recipient-' + door.global_lock">
              <view>
                <view class="door-name">{{ door.door_name }}</view>
                <view class="door-meta">柜门 #{{ door.global_lock }} · 分享给我的</view>
              </view>
              <button class="primary-btn mini-btn" @click="goStorageDoor(door, 'pickup')">取出</button>
            </view>
          </view>
          <view v-else class="empty-card">当前没有我待取的柜门。</view>
        </view>
      </view>

      <view v-else class="panel-card">
        <view class="section-tip">请选择有货的柜门进入购买流程。</view>
        <view v-if="sellDoors.length" class="product-list">
          <view class="product-card" v-for="door in sellDoors" :key="'sell-' + door.global_lock" @click="goBuyDoor(door)">
            <image
              class="product-image"
              :src="getImgPath(door.sku.sku_image)"
              mode="aspectFill"
            ></image>
            <view class="product-body">
              <view class="product-title-row">
                <view class="product-title">{{ door.sku.sku_name }}</view>
                <view class="product-door">#{{ door.global_lock }}</view>
              </view>
              <view class="product-desc" v-if="door.sku.sku_desc">{{ door.sku.sku_desc }}</view>
              <view class="product-footer">
                <view>
                  <text class="price">¥{{ formatPrice(door.sku.price) }}</text>
                  <text class="origin-price" v-if="door.sku.original_price > door.sku.price">
                    ¥{{ formatPrice(door.sku.original_price) }}
                  </text>
                </view>
                <view class="stock-text">库存 {{ door.sku.stock }}</view>
              </view>
            </view>
          </view>
        </view>
        <view v-else class="empty-card">当前没有可售商品，请稍后再试。</view>
      </view>
    </block>
  </view>
</template>

<script>
import { getW75ScanData_api } from '../../api/index.js';
import { imgPath } from '@/libs/filters.js';
import { getQueryString } from '../../libs/utils.js';

export default {
  data() {
    return {
      lock_id: '',
      global_lock: '',
      device_sn: '',
      loading: true,
      errorText: '',
      statusText: '正在识别柜门信息...',
      scanData: null,
      activeTab: 'store'
    };
  },

  computed: {
    isSingleDoor() {
      return !!this.global_lock;
    },
    workMode() {
      return this.scanData ? parseInt(this.scanData.work_mode || 1) : 1;
    },
    availableDoors() {
      return this.scanData && this.scanData.available_doors ? this.scanData.available_doors : [];
    },
    ownerDoors() {
      return this.scanData && this.scanData.owner_doors ? this.scanData.owner_doors : [];
    },
    recipientDoors() {
      return this.scanData && this.scanData.recipient_doors ? this.scanData.recipient_doors : [];
    },
    sellDoors() {
      return this.scanData && this.scanData.sell_doors ? this.scanData.sell_doors : [];
    },
    pageTitle() {
      if (this.scanData && this.scanData.lock_name) {
        return this.scanData.lock_name;
      }
      return '柜门操作';
    },
    pageSubtitle() {
      if (this.isSingleDoor) {
        return `柜门 #${this.global_lock}`;
      }
      if (this.workMode === 2) {
        return '选择商品所在柜门后继续购买';
      }
      return '查看空闲柜门、我投递的，或我待取的';
    }
  },

  async onLoad(options) {
    this.lock_id = options.lock_id || '';
    this.global_lock = options.global_lock || '';
    this.device_sn = options.device_sn || '';
    this.parseScanOptions(options);

    await this.loadScanData();
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
          console.error('W75扫码参数解析失败:', err);
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
          console.error('W75场景值解析失败:', err);
        }
      }
    },
    getImgPath(url) {
      return imgPath(url);
    },
    maskMobile(mobile) {
      if (!mobile || mobile.length !== 11) {
        return mobile || '';
      }
      return `${mobile.slice(0, 3)}****${mobile.slice(-4)}`;
    },
    formatPrice(value) {
      return Number(value || 0).toFixed(2);
    },
    async loadScanData() {
      this.loading = true;
      this.errorText = '';
      this.statusText = this.isSingleDoor ? '正在进入柜门...' : '正在加载柜门列表...';

      try {
        const res = await getW75ScanData_api({
          lock_id: this.lock_id,
          global_lock: this.global_lock
        });

        if (res.code !== 0 || !res.data) {
          this.errorText = res.msg || '获取柜门信息失败';
          this.loading = false;
          return;
        }

        this.scanData = res.data;
        uni.setNavigationBarTitle({
          title: this.isSingleDoor ? (res.data.door_name || '柜门操作') : (res.data.lock_name || '柜门操作')
        });

        if (this.isSingleDoor) {
          this.handleSingleDoor();
          return;
        }

        if (this.workMode === 1) {
          if (this.availableDoors.length > 0) {
            this.activeTab = 'store';
          } else if (this.recipientDoors.length > 0) {
            this.activeTab = 'recipient';
          } else if (this.ownerDoors.length > 0) {
            this.activeTab = 'owner';
          }
        }

        this.loading = false;
      } catch (err) {
        console.error('W75扫码页加载失败:', err);
        this.errorText = '网络异常，请稍后重试';
        this.loading = false;
      }
    },
    handleSingleDoor() {
      if (!this.scanData) {
        this.errorText = '获取柜门信息失败';
        this.loading = false;
        return;
      }

      if (this.workMode === 2) {
        if (!this.scanData.sku) {
          this.errorText = '该柜门暂无可售商品';
          this.loading = false;
          return;
        }
        uni.redirectTo({
          url: `/pages/W75Buy/W75Buy?lock_id=${encodeURIComponent(this.lock_id)}&global_lock=${encodeURIComponent(this.global_lock)}`
        });
        return;
      }

      if (parseInt(this.scanData.is_used || 0) === 1 && this.scanData.order_no) {
        uni.redirectTo({
          url: `/pages/W75StorageOrder/W75StorageOrder?order_no=${encodeURIComponent(this.scanData.order_no)}`
        });
        return;
      }

      uni.redirectTo({
        url: `/pages/W75Storage/W75Storage?lock_id=${encodeURIComponent(this.lock_id)}&global_lock=${encodeURIComponent(this.global_lock)}&device_sn=${encodeURIComponent(this.device_sn || this.scanData.device_sn || '')}`
      });
    },
    goStorageDoor(door, action) {
      if (action === 'pickup' && door && door.order_no) {
        uni.navigateTo({
          url: `/pages/W75StorageOrder/W75StorageOrder?order_no=${encodeURIComponent(door.order_no)}`
        });
        return;
      }
      const intent = action === 'pickup' ? 'pick' : 'store';
      uni.navigateTo({
        url: `/pages/W75Storage/W75Storage?lock_id=${encodeURIComponent(this.lock_id)}&global_lock=${encodeURIComponent(door.global_lock)}&device_sn=${encodeURIComponent(this.scanData && this.scanData.device_sn ? this.scanData.device_sn : '')}&intent=${intent}`
      });
    },
    goOwnerOrder(door) {
      if (!door || !door.order_no) {
        uni.showToast({
          title: '暂未找到订单',
          icon: 'none'
        });
        return;
      }
      uni.navigateTo({
        url: `/pages/W75StorageOrder/W75StorageOrder?order_no=${encodeURIComponent(door.order_no)}`
      });
    },
    goBuyDoor(door) {
      uni.navigateTo({
        url: `/pages/W75Buy/W75Buy?lock_id=${encodeURIComponent(this.lock_id)}&global_lock=${encodeURIComponent(door.global_lock)}`
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
.scan-page {
  min-height: 100vh;
  padding: 24rpx;
  background: linear-gradient(180deg, #f2f7f4 0%, #f7f7fa 28%, #f7f7fa 100%);
  box-sizing: border-box;
}

.hero-card,
.panel-card,
.state-card,
.empty-card {
  background: #ffffff;
  border-radius: 24rpx;
  box-shadow: 0 14rpx 40rpx rgba(15, 23, 42, 0.06);
}

.hero-card {
  padding: 32rpx;
  margin-bottom: 24rpx;
}

.hero-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
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
  flex-shrink: 0;
  padding: 10rpx 18rpx;
  border-radius: 999rpx;
  font-size: 24rpx;
  font-weight: 600;
}

.hero-badge.storage {
  background: #e9f8ee;
  color: #15803d;
}

.hero-badge.sell {
  background: #fff3e6;
  color: #c2410c;
}

.hero-stats {
  display: flex;
  gap: 16rpx;
  margin-top: 28rpx;
}

.stat-item {
  flex: 1;
  background: #f8fafc;
  border-radius: 18rpx;
  padding: 20rpx;
}

.stat-value {
  font-size: 40rpx;
  font-weight: 700;
  color: #111827;
}

.stat-label {
  margin-top: 8rpx;
  font-size: 24rpx;
  color: #64748b;
}

.panel-card,
.state-card {
  padding: 28rpx;
}

.panel-tabs {
  display: flex;
  gap: 12rpx;
  margin-bottom: 24rpx;
}

.tab-item {
  flex: 1;
  text-align: center;
  padding: 18rpx 0;
  border-radius: 16rpx;
  background: #f3f4f6;
  color: #6b7280;
  font-size: 28rpx;
  font-weight: 600;
}

.tab-item.active {
  background: #16a34a;
  color: #ffffff;
}

.section-tip,
.state-desc {
  font-size: 26rpx;
  color: #6b7280;
  line-height: 1.7;
}

.door-list,
.product-list {
  display: flex;
  flex-direction: column;
  gap: 18rpx;
  margin-top: 24rpx;
}

.door-card,
.product-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20rpx;
  padding: 24rpx;
  background: #f8fafc;
  border-radius: 20rpx;
}

.door-actions {
  display: flex;
  align-items: center;
  gap: 16rpx;
  flex-shrink: 0;
}

.door-name,
.product-title {
  font-size: 30rpx;
  font-weight: 600;
  color: #111827;
}

.door-meta,
.product-desc,
.stock-text {
  margin-top: 8rpx;
  font-size: 24rpx;
  color: #6b7280;
}

.product-card {
  align-items: stretch;
}

.product-image {
  width: 160rpx;
  height: 160rpx;
  border-radius: 18rpx;
  background: #e5e7eb;
  flex-shrink: 0;
}

.product-body {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.product-title-row,
.product-footer {
  display: flex;
  justify-content: space-between;
  gap: 16rpx;
  align-items: flex-start;
}

.product-door {
  flex-shrink: 0;
  font-size: 24rpx;
  color: #16a34a;
  background: #e9f8ee;
  border-radius: 999rpx;
  padding: 6rpx 14rpx;
}

.price {
  font-size: 34rpx;
  font-weight: 700;
  color: #dc2626;
}

.origin-price {
  margin-left: 10rpx;
  font-size: 22rpx;
  color: #9ca3af;
  text-decoration: line-through;
}

.state-title {
  font-size: 34rpx;
  font-weight: 700;
  color: #111827;
  margin-bottom: 16rpx;
}

.empty-card {
  margin-top: 24rpx;
  padding: 28rpx;
  font-size: 26rpx;
  color: #6b7280;
  line-height: 1.7;
}

.state-actions {
  display: flex;
  gap: 16rpx;
  margin-top: 24rpx;
}

.primary-btn,
.ghost-btn {
  border: none;
  border-radius: 16rpx;
  font-size: 28rpx;
}

.primary-btn {
  background: #16a34a;
  color: #ffffff;
}

.ghost-btn {
  background: #f3f4f6;
  color: #374151;
}

.mini-btn {
  margin: 0;
  padding: 0 28rpx;
  height: 72rpx;
  line-height: 72rpx;
  font-size: 26rpx;
}
</style>
