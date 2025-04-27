<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
        <view class="search-box">
          <image src="../../static/sousuo.png"></image>
          <input 
            placeholder="请输入关键词" 
            placeholder-class="placeholder" 
            class="search-input"
            confirm-type="search" 
            @confirm="confirm" 
            v-model="search_key" 
          />
        </view>
      </view>
      <view class="list">
        <view class="item" v-for="item in dataList" :key="item.lockcard_id">
          <view class="left-box">
            <view class="user-info">
              <view class="user-name">
                <template v-if="item.lockcard_username || item.lockcard_remark">
                  {{ item.lockcard_username }}
                  <template v-if="item.lockcard_remark"> ({{ item.lockcard_remark }})</template>
                </template>
                <template v-else>未实名</template>
              </view>
              <view class="phone">门卡号：{{ item.lockcard_sn }}</view>
            </view>
          </view>
          <view class="right-box">
            <view class="delete-btn" style="background: #21CF3E;" @click="goDetail(item)">发卡</view>
            <view class="delete-btn" style="background: orange;" @click="edit(item)">编辑</view>
            <view class="delete-btn" @click="onDelete(item.lockcard_id)">删除</view>
          </view>
        </view>
        <uni-load-more :status="noMore" empty_text="暂无门卡数据～" style="padding-top: 40rpx;"></uni-load-more>
      </view>

      <view class="bottom-btn" @click="operation">
        <view class="btn">操作</view>
      </view>
    </view>
  </view>
</template>

<script>
import { cardList_api, delCard_api, clearCards_api } from '../../api/index.js'

export default {
  data() {
    return {
      scrollTop: 0,
      noMore: 'loading',
      page: 1,
      dataList: [],
      lock_id: '',
      search_key: '',
      isAdmin: false // 是否是管理员
    }
  },
  onPageScroll(e) {
    this.scrollTop = e.scrollTop;
  },
  onLoad(option) {
    this.lock_id = option.lock_id;
    this.isAdmin = option.auth_isadmin === '1'; // 判断是否是管理员
  },
  onShow() {
    // 页面返回时刷新列表
    this.page = 1;
    this.dataList = [];
    this.getList();
  },
  onReachBottom() {
    if (this.noMore === 'noMore' || this.noMore === 'nodata') {
      return;
    }
    this.page++; // 每触底一次 page +1
    this.getList();
  },
  async onPullDownRefresh() {
    this.page = 1;
    this.dataList = [];
    await this.getList();
    uni.stopPullDownRefresh();
  },
  methods: {
    edit(item) {
      uni.navigateTo({
        url: '/pages/addCard/addCard?item=' + encodeURIComponent(JSON.stringify(item))
      });
    },
    async onDelete(lockcard_id) {
      uni.showModal({
        title: '提示',
        content: '确定删除该门卡吗?',
        success: async (msg) => {
          if (msg.confirm) {
            uni.showLoading({
              title: '删除中...',
              mask: true
            });
            try {
              let res = await delCard_api({ lockcard_id });
              if (res.code === 0) {
                uni.showToast({
                  title: '门卡删除成功！',
                  icon: 'none'
                });
                this.page = 1;
                this.dataList = [];
                this.getList();
              } else {
                uni.showToast({
                  title: res.msg,
                  icon: 'none'
                });
              }
            } catch (error) {
              uni.showToast({
                title: '删除失败',
                icon: 'none'
              });
            } finally {
              uni.hideLoading();
            }
          }
        }
      });
    },
    confirm(e) {
      this.search_key = e.detail.value;
      this.page = 1;
      this.dataList = [];
      this.getList();
    },
    goDetail(item) {
      uni.navigateTo({
        url: '/pages/issue/issue?item=' + encodeURIComponent(JSON.stringify(item))
      });
    },
    async getList() {
      this.noMore = 'loading';
      const params = {
        page: this.page,
        limit: 10,
        lock_id: this.lock_id,
        search_key: this.search_key
      };
      try {
        const res = await cardList_api(params);
        if (res.code !== 0) {
          throw new Error(res.msg || '请求失败');
        }
        const list = res.data || [];
        if (this.page === 1 && list.length === 0) {
          this.noMore = 'nodata';
          this.dataList = [];
          return;
        }
        if (list.length === 0) {
          this.noMore = 'noMore';
          return;
        }
        this.dataList = this.dataList.concat(list);
        if (this.dataList.length >= res.count) {
          this.noMore = 'noMore';
        }
      } catch (error) {
        this.noMore = 'noMore';
        uni.showToast({
          title: error.message || '加载失败',
          icon: 'none'
        });
      }
    },
    operation() {
      const itemList = ['添加门卡'];
      if (this.isAdmin) {
        itemList.push('同步门卡', '清空设备门卡', '清空云端及设备门卡');
      }
      uni.showActionSheet({
        itemList,
        success: (res) => {
          if (res.tapIndex === 0) {
            uni.navigateTo({
              url: '/pages/addCard/addCard?lock_id=' + this.lock_id
            });
          } else if (res.tapIndex === 1 && this.isAdmin) {
            uni.navigateTo({
              url: '/pages/synchroData/synchroData?lock_id=' + this.lock_id + '&type=card'
            });
          } else if (res.tapIndex === 2 && this.isAdmin) {
            this.clearCards('local');
          } else if (res.tapIndex === 3 && this.isAdmin) {
            this.clearCards('cloud');
          }
        }
      });
    },
    async clearCards(type) {
      const content = type === 'local'
        ? '确定清空设备门卡数据吗？此操作不可恢复！'
        : '确定清空云端及设备所有门卡数据吗？此操作不可恢复！';

      uni.showModal({
        title: '警告',
        content,
        success: async (res) => {
          if (res.confirm) {
            uni.showLoading({
              title: '清空中...',
              mask: true
            });
            try {
              const response = await clearCards_api({ lock_id: this.lock_id, type });
              if (response.code === 0) {
                const message = type === 'local'
                  ? '设备门卡清空成功！'
                  : '云端及设备门卡清空成功！';
                uni.showToast({
                  title: message,
                  icon: 'none'
                });
                this.page = 1;
                this.dataList = [];
                this.getList();
              } else {
                uni.showToast({
                  title: response.msg,
                  icon: 'none'
                });
              }
            } catch (error) {
              uni.showToast({
                title: '清空失败',
                icon: 'none'
              });
            } finally {
              uni.hideLoading();
            }
          }
        }
      });
    }
  }
};
</script>

<style scoped lang="scss">
@import './doorCardList.scss';
</style>
