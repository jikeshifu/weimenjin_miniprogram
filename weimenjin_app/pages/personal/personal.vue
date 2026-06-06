<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content" :style="{ position: showAuthorizationModal ? 'fixed' : 'relative', top: showAuthorizationModal ? scrollTop : '' }">
      <view class="version-info">版本号: {{ appVersion }}</view>
      <view class="user-box">
        <image :src="getImgPath(userInfo.headimgurl)" class="user-img"></image>
        <view class="user-name">
          {{ userInfo.nickname }}{{ userInfo.nickname ? ',' : '' }}<span class="points"> 积分:{{ points }}</span>
          <span v-if="userInfo.member_id === 1" class="daily-stats"> 当日统计: {{ countshow }},{{ countcomplete }} </span>
        </view>
      </view>
      <view class="renew" @click="toggleModal">更新头像和昵称</view>
      <view class="cell-box" @click="goPage('/pages/operateList/operateList')">
        <view class="label">操作记录</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/roomBind/roomBind')">
        <view class="label">房间绑定</view>
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
        <view class="label">{{ userInfo.mobile ? '已绑手机' : '绑定手机号' }}</view>
        <view class="flex-box">
          <view class="phone" v-if="userInfo.mobile">
            {{ userInfo.mobile.replace(/^(.{3})(?:\d+)(.{4})$/, "$1****$2") }}</view>
          <image src="../../static/jiantouyou.png"></image>
        </view>
      </view>
      <view class="cell-box" @click="goDetail('/pages/bluetooth/bluetooth')">
        <view class="label">蓝牙配网</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/wifi/wifi')">
        <view class="label">WiFi配网</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
      <view class="cell-box" @click="goDetail('/pages/hotspot/hotspot')">
        <view class="label">热点配网</view>
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
      <view class="cell-box" @click="goDetail('/pages/W75Scan/W75Scan?device_sn=W7521958851&lock_id=8724')">
        <view class="label">柜门演示</view>
        <image src="../../static/jiantouyou.png"></image>
      </view>
	  <!-- <view class="cell-box" @click="goDetail('/pages/adcontrol/adcontrol?token=demo&softwareId=3&isscan=1')">
	          <view class="label">广告演示</view>
	          <image src="../../static/jiantouyou.png"></image>
	        </view> -->
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

    <!-- 注销确认弹层 -->
    <view class="modal-overlay" v-if="showUnbindModal" @click="closeUnbindModal">
      <view class="modal-content" @click.stop>
        <view class="modal-title">手机号</view>
        <view class="modal-text">当前绑定号码：{{ userInfo.mobile }}<br></view>
        <view class="modal-buttons">
          <view class="btn cancel" @click="closeUnbindModal">取消</view>
          <view class="btn confirm" @click="confirmUnbind">注销绑定</view>
        </view>
      </view>
    </view>
  </view>
</template>

<script>
import { ref, onMounted, reactive } from 'vue';
import TnuiWxUserInfo from '@/components/uni-dateformat/components/uni-dateformat/uni-dateformat.vue';
import manifestJson from '../../manifest.json';
import {
  userInfo_api,
  adlog_getpointsapi,
  editMember_api,
  unbindPhone_api,
} from '../../api/index.js';
import { imgPath } from '@/libs/filters.js';

export default {
  components: {
    TnuiWxUserInfo,
  },
  setup() {
    const showAuthorizationModal = ref(false);
    const appVersion = ref(manifestJson.versionName || '');
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
    const showUnbindModal = ref(false);

    const getUserInfo = async () => {
      let res = await userInfo_api();
      if (res.code === 0) {
        Object.assign(userInfo, res.data);
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
      } else {
        showUnbindModal.value = true;
      }
    };

    const toggleModal = () => {
      showAuthorizationModal.value = true;
    };

    const handleModalClose = () => {
      showAuthorizationModal.value = false;
    };

    const closeUnbindModal = () => {
      showUnbindModal.value = false;
    };

    const confirmUnbind = async () => {
      uni.showLoading({ title: '处理中...', mask: true });
      try {
        // 解绑API 来处理解绑
        const res = await unbindPhone_api();
        if (res.code === 0) {
          userInfo.mobile = ''; // 清空手机号
          showUnbindModal.value = false;
          uni.showToast({ title: '解绑成功' });
        } else {
          uni.showToast({ title: res.msg, icon: 'none' });
        }
      } catch (error) {
        console.error('解绑失败', error);
        uni.showToast({ title: '解绑失败', icon: 'none' });
      } finally {
        uni.hideLoading();
      }
    };

    const loadAppVersion = () => {
      let version = manifestJson.versionName || '';

      // #ifdef MP-WEIXIN
      try {
        if (typeof uni.getAccountInfoSync === 'function') {
          const accountInfo = uni.getAccountInfoSync();
          const miniProgramVersion = accountInfo?.miniProgram?.version;
          if (miniProgramVersion) {
            version = miniProgramVersion;
          }
        }
      } catch (error) {
        console.error('读取微信小程序版本失败', error);
      }
      // #endif

      // #ifdef APP-PLUS
      if (typeof plus !== 'undefined' && plus.runtime && plus.runtime.version) {
        version = plus.runtime.version;
      }
      // #endif

      appVersion.value = version;
    };

    onMounted(() => {
      loadAppVersion();
      getUserInfo();
      loadPoints();
    });

    return {
      showAuthorizationModal,
      appVersion,
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
      handleModalClose,
      loadAppVersion,
      showUnbindModal,
      closeUnbindModal,
      confirmUnbind
    };
  }
};
</script>

<style scoped lang="scss">
  @import './personal.scss';

  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    background: #fff;
    border-radius: 10rpx;
    padding: 40rpx;
    width: 80%;
    text-align: center;
  }

  .modal-title {
    font-size: 34rpx;
    font-weight: bold;
    margin-bottom: 20rpx;
  }

  .modal-text {
    font-size: 30rpx;
    color: #666;
    margin-bottom: 40rpx;
  }

  .modal-buttons {
    display: flex;
    justify-content: space-between;
  }

  .btn {
    width: 45%;
    padding: 20rpx 0;
    border-radius: 8rpx;
    font-size: 32rpx;
  }

  .cancel {
    background: #f5f5f5;
    color: #666;
  }

  .confirm {
    background: #007AFF;
    color: #fff;
  }
</style>
