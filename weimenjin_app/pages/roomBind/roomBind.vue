<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
        <view class="tab-list">
          <view
            :class="['tab-item', activeTab === 0 ? 'tab-item-on' : '']"
            @click="activeTab = 0"
          >
            已绑定
          </view>
          <view
            :class="['tab-item', activeTab === 1 ? 'tab-item-on' : '']"
            @click="activeTab = 1"
          >
            申请记录
          </view>
        </view>
      </view>

      <!-- 已绑定房间Tab -->
      <view v-if="activeTab === 0" class="list">
        <view v-if="loadingRooms" class="loading">加载中...</view>
        <view v-else-if="myRooms.length === 0" class="empty">
          <view class="empty-icon">🏠</view>
          <view class="empty-text">暂无绑定房间</view>
          <view class="empty-desc">点击下方按钮添加房间</view>
        </view>
        <view v-else class="room-list">
          <view v-for="(room, index) in myRooms" :key="index" class="room-card">
            <view class="room-header">
              <view class="room-title">{{ room.area_name }} {{ room.building_name }} {{ room.unit_name }} {{ room.room_name }}</view>
              <view class="room-status" :class="{ 'status-active': room.status === 1 }">
                {{ room.status === 1 ? '已激活' : '未激活' }}
              </view>
            </view>
            <view class="room-info">
              <view class="info-item">
                <text class="info-label">绑定时间：</text>
                <text class="info-value">{{ formatTime(room.create_time) }}</text>
              </view>
            </view>
          </view>
        </view>
        <uni-load-more :status="noMoreRooms ? 'noMore' : 'loading'" empty_text="没有更多了～"></uni-load-more>
      </view>

      <!-- 申请记录Tab -->
      <view v-if="activeTab === 1" class="list">
        <view v-if="loadingApplications" class="loading">加载中...</view>
        <view v-else-if="myApplications.length === 0" class="empty">
          <view class="empty-icon">📋</view>
          <view class="empty-text">暂无申请记录</view>
          <view class="empty-desc">点击下方按钮申请绑定</view>
        </view>
        <view v-else class="application-list">
          <view v-for="(app, index) in myApplications" :key="index" class="app-card">
            <view class="app-header">
              <view class="app-title">{{ app.area_name }} {{ app.building_name }} {{ app.unit_name }} {{ app.room_name }}</view>
              <view class="app-status" :class="{
                'status-pending': app.status === 0,
                'status-approved': app.status === 1,
                'status-rejected': app.status === 2
              }">
                {{ getStatusText(app.status) }}
              </view>
            </view>
            <view class="app-info">
              <view class="info-item">
                <text class="info-label">申请时间：</text>
                <text class="info-value">{{ formatTime(app.create_time) }}</text>
              </view>
              <view class="info-item" v-if="app.status === 2">
                <text class="info-label">拒绝原因：</text>
                <text class="info-value">{{ app.reject_reason || '-' }}</text>
              </view>
            </view>
          </view>
        </view>
        <uni-load-more :status="noMoreApplications ? 'noMore' : 'loading'" empty_text="没有更多了～"></uni-load-more>
      </view>
    </view>

    <!-- 浮动按钮 -->
    <view class="fab-container">
      <view class="fab-button qrcode-btn" @click="scanQRCode">
        <uni-icons type="scan" size="32" color="#ffffff"></uni-icons>
      </view>
      <view class="fab-button key-btn" @click="goToApplyPage('key')">
        <uni-icons type="plusempty" size="32" color="#ffffff"></uni-icons>
      </view>
    </view>
  </view>
</template>

<script>
import { roomBindGetMyRooms, roomBindGetApplications, roomBindParseQRCode } from '@/api/index.js'
import { formatDate } from '@/libs/filters.js'

export default {
  data() {
    return {
      activeTab: 0,
      scrollTop: 0,
      myRooms: [],
      myApplications: [],
      loadingRooms: false,
      loadingApplications: false,
      noMoreRooms: false,
      noMoreApplications: false,
      pageRooms: 1,
      pageApplications: 1
    }
  },
  onPageScroll(e) {
    this.scrollTop = e.scrollTop
  },
  onPullDownRefresh() {
    this.pageRooms = 1
    this.pageApplications = 1
    this.loadMyRooms()
    this.loadMyApplications()
    setTimeout(() => {
      uni.stopPullDownRefresh()
    }, 1500)
  },
  onShow() {
    this.loadMyRooms()
    this.loadMyApplications()
  },
  methods: {
    async loadMyRooms() {
      this.loadingRooms = true
      try {
        const res = await roomBindGetMyRooms({ page: this.pageRooms, limit: 20 })
        if (res.code === 0) {
          this.myRooms = res.data || []
          this.noMoreRooms = !res.data || res.data.length < 20
        }
      } catch (error) {
        uni.showToast({ title: '加载房间失败', icon: 'error' })
      } finally {
        this.loadingRooms = false
      }
    },
    async loadMyApplications() {
      this.loadingApplications = true
      try {
        const res = await roomBindGetApplications({ page: this.pageApplications, limit: 20 })
        if (res.code === 0) {
          this.myApplications = res.data || []
          this.noMoreApplications = !res.data || res.data.length < 20
        }
      } catch (error) {
        uni.showToast({ title: '加载申请记录失败', icon: 'error' })
      } finally {
        this.loadingApplications = false
      }
    },
    goToApplyPage(method) {
      uni.navigateTo({
        url: `/pages/roomBindApply/roomBindApply?method=${method}`
      })
    },
    scanQRCode() {
      // 直接拉起扫码，扫码成功后进入申请页面
      uni.scanCode({
        success: async (res) => {
          uni.showLoading({ title: '识别中...', mask: true })
          try {
            // 解析二维码
            const parseRes = await roomBindParseQRCode({ qr_code: res.result })
            uni.hideLoading()
            if (parseRes.code === 0) {
              // 扫码成功，进入申请页面并传递扫码数据（包括名称）
              const params = {
                method: 'qrcode',
                qr_code: encodeURIComponent(res.result),
                area_id: parseRes.data.area_id || 0,
                area_name: encodeURIComponent(parseRes.data.area_name || ''),
                building_id: parseRes.data.building_id || 0,
                building_name: encodeURIComponent(parseRes.data.building_name || ''),
                unit_id: parseRes.data.unit_id || 0,
                unit_name: encodeURIComponent(parseRes.data.unit_name || ''),
                lock_id: parseRes.data.lock_id || 0
              }
              const queryStr = Object.keys(params).map(k => `${k}=${params[k]}`).join('&')
              uni.navigateTo({
                url: `/pages/roomBindApply/roomBindApply?${queryStr}`
              })
            } else {
              uni.showToast({ title: parseRes.msg || '识别失败', icon: 'error' })
            }
          } catch (error) {
            uni.hideLoading()
            uni.showToast({ title: '解析二维码失败', icon: 'error' })
          }
        },
        fail: () => {
          // 用户取消扫码，不显示错误提示
        }
      })
    },
    getStatusText(status) {
      const statusMap = { 0: '待审核', 1: '已通过', 2: '已拒绝' }
      return statusMap[status] || '未知'
    },
    formatTime(timestamp) {
      return formatDate(timestamp, 'yyyy-MM-dd hh:mm:ss')
    }
  }
}
</script>

<style scoped lang="scss">
.big-box {
  .background {
    width: 100%;
    height: 352rpx;
    background: rgb(33, 207, 62);
    opacity: 0.2;
    box-shadow: 0px 8rpx 374rpx rgb(58, 137, 254);
    filter: blur(120rpx);
    position: absolute;
    top: 0;
    left: 0;
  }
  .content {
    position: relative;
    z-index: 10;
    padding: 120rpx 30rpx 200rpx;
    .top-box {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 10;
      width: 100%;
      background-color: initial;
      transition: background-color 0.6s;
    }
    .tab-list {
      display: flex;
      gap: 30rpx;
      padding: 20rpx 30rpx;
      background: #f7f7fa;
      .tab-item {
        flex: 1;
        text-align: center;
        padding: 20rpx 0;
        font-size: 28rpx;
        color: #999999;
        font-weight: 500;
        border-bottom: 2px solid transparent;
      }
      .tab-item-on {
        color: #21CF3E;
        border-bottom-color: #21CF3E;
      }
    }
    .top-box-active {
      background-color: #F7F7FA;
      box-shadow: 0rpx -30rpx 100rpx rgba(117, 160, 232, 0.5);
    }
    .list {
      padding-top: 100rpx;
      min-height: 600rpx;
      .loading {
        text-align: center;
        padding: 40rpx 0;
        color: #999999;
      }
      .empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80rpx 30rpx;
        .empty-icon {
          font-size: 80rpx;
          margin-bottom: 20rpx;
        }
        .empty-text {
          font-size: 28rpx;
          color: #333333;
          margin-bottom: 10rpx;
        }
        .empty-desc {
          font-size: 24rpx;
          color: #999999;
        }
      }
      .room-list, .application-list {
        display: flex;
        flex-direction: column;
        gap: 20rpx;
        .room-card, .app-card {
          margin: 0 0 20rpx 0;
          background: linear-gradient(180deg, rgb(255, 255, 255), rgba(255, 255, 255, 0.6) 100%);
          box-shadow: 16rpx 16rpx 66rpx rgba(117, 160, 232, 0.2);
          border-radius: 24rpx;
          padding: 24rpx;
          .room-header, .app-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16rpx;
            .room-title, .app-title {
              font-size: 28rpx;
              color: #333333;
              font-weight: 500;
              flex: 1;
            }
            .room-status, .app-status {
              padding: 8rpx 16rpx;
              border-radius: 20rpx;
              font-size: 20rpx;
              white-space: nowrap;
              &.status-active {
                background: #21CF3E;
                color: #ffffff;
              }
              &.status-pending {
                background: #FFA500;
                color: #ffffff;
              }
              &.status-approved {
                background: #21CF3E;
                color: #ffffff;
              }
              &.status-rejected {
                background: #FF6B6B;
                color: #ffffff;
              }
            }
          }
          .room-info, .app-info {
            .info-item {
              display: flex;
              padding: 8rpx 0;
              .info-label {
                color: #999999;
                font-size: 24rpx;
                min-width: 120rpx;
              }
              .info-value {
                color: #333333;
                font-size: 24rpx;
              }
            }
          }
        }
      }
    }
  }
}

.fab-container {
  position: fixed;
  bottom: 60rpx;
  right: 30rpx;
  display: flex;
  flex-direction: column;
  gap: 16rpx;
  z-index: 99;
  .fab-button {
    width: 80rpx;
    height: 80rpx;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4rpx 12rpx rgba(0, 0, 0, 0.15);
    transition: all 0.3s;
    &:active {
      transform: scale(0.95);
    }
  }
  .qrcode-btn {
    background: #21CF3E;
  }
  .key-btn {
    background: #21CF3E;
  }
}
</style>
