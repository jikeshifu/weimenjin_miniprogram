<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <!-- 标签栏切换 -->
      <view class="tab-bar">
        <view :class="['tab-item', currentTab === 'speaker' ? 'active' : '']" @click="changeTab('speaker')">联动云喇叭</view>
        <view :class="['tab-item', currentTab === 'switch' ? 'active' : '']" @click="changeTab('switch')">联动空开</view>
      </view>

      <!-- 设备列表 -->
      <view class="list">
        <view class="item" v-for="item in dataList" :key="item.id">
          <view class="left-box">
            <view class="user-info">
              <view class="user-name">{{ item.linkspeaker_name || item.linkswitch_name }}</view>
              <view class="phone">序列号：{{ item.linkspeaker_sn || item.linkswitch_sn }}</view>
            </view>
          </view>
          <view class="right-box">
            <view class="edit-btn" @click="editItem(item)">编辑</view>
            <view class="delete-btn" @click="deleteItem(item.id)">删除</view>
          </view>
        </view>
        <!-- <uni-load-more :status="noMore" empty_text="无设备数据～" style="padding-top: 40rpx;"></uni-load-more> -->
      </view>
    </view>

    <!-- 添加按钮 -->
    <view class="bottom-btn" @click="addDevice">
      <view class="btn">添加设备</view>
    </view>
  </view>
</template>

<script>
import {
  getlinkSpeakers_api,
  getlinkSwitches_api,
  deletelinkSpeaker_api,
  deletelinkSwitch_api
} from '@/api/index.js'

export default {
  data() {
    return {
      currentTab: 'speaker',
      dataList: [],
      noMore: 'loading',
      page: 1,
      lock_id: ''
    }
  },
  onLoad(option) {
    this.lock_id = option.lock_id;
    this.fetchData();
  },
  onShow() {
    if (uni.getStorageSync('shouldRefreshDeviceList')) {
      this.page = 1;
      this.dataList = [];
      this.fetchData();
      uni.removeStorageSync('shouldRefreshDeviceList');
    }
  },
  methods: {
    changeTab(tab) {
      if (this.currentTab !== tab) {
        this.currentTab = tab;
        this.page = 1;
        this.dataList = [];
        this.fetchData();
      }
    },
    async fetchData() {
      const api = this.currentTab === 'speaker' ? getlinkSpeakers_api : getlinkSwitches_api;
      const params = {
        page: this.page,
        limit: 10,
        lock_id: this.lock_id
      };
      try {
        const res = await api(params);
        if (res.code !== 0) throw new Error(res.msg || '请求失败');
        const list = res.data || [];

        if (this.page === 1 && list.length === 0) {
          this.noMore = 'nodata';
          return;
        } else if (list.length < 10) {
          this.noMore = 'noMore';
        } else {
          this.noMore = 'loading';
        }

        this.dataList = this.dataList.concat(list);
      } catch (error) {
        this.noMore = 'noMore';
        uni.showToast({
          title: error.message || '加载失败',
          icon: 'none'
        });
      }
    },
    editItem(item) {
      const url = this.currentTab === 'speaker' ?
        '/pages/addlinkspeaker/addlinkspeaker' :
        '/pages/addlinkswitch/addlinkswitch';
      const sn = this.currentTab === 'speaker' ? item.linkspeaker_sn : item.linkswitch_sn;
      uni.navigateTo({
        url: `${url}?lock_id=${this.lock_id}&sn=${sn}`
      });
    },
    async deleteItem(id) {
      const api = this.currentTab === 'speaker' ? deletelinkSpeaker_api : deletelinkSwitch_api;
      uni.showModal({
        title: '提示',
        content: '确定删除该设备吗?',
        success: async (res) => {
          if (res.confirm) {
            try {
              const result = await api({ id });
              if (result.code === 0) {
                uni.showToast({
                  title: '删除成功！',
                  icon: 'none'
                });
                this.page = 1;
                this.dataList = [];
                this.fetchData();
              } else {
                uni.showToast({
                  title: result.msg,
                  icon: 'none'
                });
              }
            } catch (error) {
              uni.showToast({
                title: '删除失败',
                icon: 'none'
              });
            }
          }
        }
      });
    },
    addDevice() {
      const url = this.currentTab === 'speaker' ?
        '/pages/addlinkspeaker/addlinkspeaker' :
        '/pages/addlinkswitch/addlinkswitch';
      uni.navigateTo({
        url: `${url}?lock_id=${this.lock_id}`
      });
    }
  }
}
</script>

<style scoped lang="scss">
.big-box {
  min-height: 100vh;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  position: relative;
  overflow: hidden;

  .background {
    width: 100%;
    height: 400rpx;
    background: rgba(33, 207, 62, 0.2);
    box-shadow: 0 8rpx 374rpx rgba(58, 137, 254, 0.2);
    filter: blur(120rpx);
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
  }

  .content {
    position: relative;
    z-index: 10;
    padding-bottom: 150rpx; // 留出底部按钮空间
  }

  .tab-bar {
    display: flex;
    height: 100rpx;
    justify-content: space-around;
    background: #ffffff;
    border-radius: 20rpx;
    margin: 30rpx;
    box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.08);

    .tab-item {
      flex: 1;
      text-align: center;
      font-size: 32rpx;
      line-height: 100rpx;
      color: #666;
      transition: all 0.3s;

      &.active {
        color: #1aad19;
        font-weight: 600;
        background: #e8f5e9;
        border-radius: 20rpx;
      }
    }
  }

  .list {
    padding: 0 30rpx;

    .item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 30rpx;
      margin-bottom: 20rpx;
      background: #ffffff;
      border-radius: 20rpx;
      box-shadow: 0 6rpx 20rpx rgba(0, 0, 0, 0.08);
      transition: all 0.3s;

      &:hover {
        transform: translateY(-2rpx);
        box-shadow: 0 8rpx 24rpx rgba(0, 0, 0, 0.1);
      }

      .left-box {
        .user-info {
          .user-name {
            font-size: 30rpx;
            color: #333;
            font-weight: 500;
          }

          .phone {
            font-size: 26rpx;
            color: #666;
            margin-top: 10rpx;
          }
        }
      }

      .right-box {
        display: flex;
        align-items: center;

        .edit-btn,
        .delete-btn {
          width: 100rpx;
          height: 60rpx;
          line-height: 60rpx;
          text-align: center;
          border-radius: 12rpx;
          font-size: 28rpx;
          color: #fff;
          margin-left: 20rpx;
          transition: all 0.3s;
        }

        .edit-btn {
          background: linear-gradient(90deg, #1aad19, #2ecc71);
          box-shadow: 0 4rpx 12rpx rgba(26, 173, 25, 0.3);

          &:hover {
            transform: translateY(-2rpx);
            box-shadow: 0 6rpx 16rpx rgba(26, 173, 25, 0.4);
          }
        }

        .delete-btn {
          background: linear-gradient(90deg, #ff4d4f, #ff7875);
          box-shadow: 0 4rpx 12rpx rgba(255, 77, 79, 0.3);

          &:hover {
            transform: translateY(-2rpx);
            box-shadow: 0 6rpx 16rpx rgba(255, 77, 79, 0.4);
          }
        }
      }
    }
  }

  .bottom-btn {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(to top, rgba(255, 255, 255, 0.9), transparent);
    padding: 20rpx 0;
    z-index: 30;

    .btn {
      margin: 0 30rpx;
      height: 90rpx;
      background: linear-gradient(90deg, #1aad19, #2ecc71);
      border-radius: 45rpx;
      font-size: 32rpx;
      color: #fff;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 6rpx 20rpx rgba(26, 173, 25, 0.3);
      transition: all 0.3s;

      &:hover {
        transform: translateY(-2rpx);
        box-shadow: 0 8rpx 24rpx rgba(26, 173, 25, 0.4);
      }
    }
  }
}
</style>
