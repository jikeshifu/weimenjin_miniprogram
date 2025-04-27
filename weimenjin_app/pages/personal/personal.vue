<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content" :style="{ position: showAuthorizationModal ? 'fixed' : 'relative', top: showAuthorizationModal ? scrollTop : '' }">
      <view class="version-info">版本号: 2.0.12</view>
	  <view class="user-box">
        <image :src="getImgPath(userInfo.headimgurl)" class="user-img"></image>
        <view class="user-name">
          {{ userInfo.nickname }}{{ userInfo.nickname ? ',' : '' }}<span class="points"> 积分:{{ points }}</span>
          <span v-if="userInfo.member_id === 1" class="daily-stats"> 当日统计: {{ countshow }},{{ countcomplete }} </span>
        </view>
      </view>
      <view class="renew" @click="toggleModal">更新头像和昵称</view>
      <view class="cell-box" @click="goPage('/pages/operateList/operateList')">
        <view class="label">我的操作记录</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/member/account')">
        <view class="label">后台账号</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goPage('/pages/addEquipment/addEquipment')">
        <view class="label">添加设备</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="bindPhone">
        <view class="label">绑定手机号</view>
        <view class="flex-box">
          <view class="phone" v-if="userInfo.mobile">
            {{ userInfo.mobile.replace(/^(.{3})(?:\d+)(.{4})$/, "$1****$2") }}</view>
          <image src="../../static/jiantouyou.png"></image>
        </view>
      </view>
      <view class="cell-box" @click="goDetail('/pages/bluetooth/bluetooth')">
        <view class="label">蓝牙配网工具（ 适用W7X ）</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/wifi/wifi')">
        <view class="label">WiFi配网工具（ 适用W8X ）</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/hotspot/hotspot')">
        <view class="label">批量配网（ 热点配网 ）</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/test/test')" v-if="userInfo.level">
        <view class="label">测试人员</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/sim/sim')">
        <view class="label">sim卡查询</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/open/open?user_id=1&lock_id=2&isscan=1')">
        <view class="label">开门演示</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="clearCacheAndReload">
        <view class="label">清除缓存</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
    </view>

    <!-- 弹出授权框 -->
    <tuniaoui-wx-user-info 
      v-model="showAuthorizationModal"
      @updated="updatedUserInfoEvent" 
      @close="handleModalClose">
    </tuniaoui-wx-user-info>
  </view>
</template>

<script>
import { ref, onMounted, reactive } from 'vue';
import TnuiWxUserInfo from '@/components/uni-dateformat/components/uni-dateformat/uni-dateformat.vue';
import {
  userInfo_api,
  adlog_getpointsapi,
  editMember_api
} from '../../api/index.js';
import { imgPath } from '@/libs/filters.js';

export default {
  components: {
    TnuiWxUserInfo,
  },
  setup() {
    const showAuthorizationModal = ref(false);
    const userInfo = reactive({
      headimgurl: '',
      nickname: '',
      member_id: 0,
      mobile: '',
      level: 0
    });
    const points = ref(0);
    const countshow = ref(0);
    const countcomplete = ref(0);
    const scrollTop = ref('');

    const getUserInfo = async () => {
      let res = await userInfo_api();
      if (res.code === 0) {
        Object.assign(userInfo, res.data);
        console.log("userInfo", userInfo);
      }
    };

    const loadPoints = async () => {
      try {
        let response = await adlog_getpointsapi();
        points.value = response.points;
        countshow.value = response.countshow;
        countcomplete.value = response.countcomplete;
      } catch (error) {
        console.error('加载积分失败', error);
      }
    };
	const goDetail = (url) => {
	      uni.navigateTo({
	        url: url
	      });
	    };
    const goPage = (url) => {
      uni.navigateTo({
        url: url
      });
    };

    const getImgPath = (url) => imgPath(url);

    const clearCacheAndReload = () => {
      uni.clearStorageSync();
      uni.showToast({
        title: '缓存清除成功',
        icon: 'success',
        duration: 2000,
        complete: () => {
          setTimeout(() => {
            uni.reLaunch({
              url: '/pages/index/index'
            });
          }, 2000);
        }
      });
    };

    const updatedUserInfoEvent = async (info) => {
      uni.showLoading({ title: '加载中...', mask: true });
      try {
        let res = await editMember_api({ nickname: info.nickname, headimgurl: info.avatar });
        if (res.code === 0) {
          showAuthorizationModal.value = false;
          uni.showToast({ title: '更新成功' });
          getUserInfo();
        } else {
          uni.showToast({ title: res.msg, icon: 'none' });
        }
      } catch (error) {
        console.error('更新用户信息失败', error);
      } finally {
        uni.hideLoading();
      }
    };
	
    const bindPhone = () => {
      if (!userInfo.mobile) {
        uni.navigateTo({
          url: '/pages/open/open?type=phone'
        });
      }
    };

    const toggleModal = () => {
      showAuthorizationModal.value = true;
      console.log("Modal triggered", showAuthorizationModal.value);
    };

    const handleModalClose = () => {
      showAuthorizationModal.value = false;
    };
    onMounted(() => {
      getUserInfo();
      loadPoints();
    });

    return {
      showAuthorizationModal,
      userInfo,
      points,
      countshow,
      countcomplete,
      scrollTop,
      getUserInfo,
      loadPoints,
      goPage,
	  goDetail,
      getImgPath,
      clearCacheAndReload,
      updatedUserInfoEvent,
      bindPhone,
      toggleModal,
      handleModalClose
    };
  }
};
</script>

<style scoped lang="scss">
  @import './personal.scss';
</style>
