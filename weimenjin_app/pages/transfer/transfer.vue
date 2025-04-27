<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view class="flex-box">
        <view class="label">手机号</view>
        <input placeholder="请输入对方手机号" placeholder-class="placeholder" type="number" v-model="mobile" />
      </view>
      <view class="inquire" @click="inquire">查询用户</view>
      <!-- 查询有用户后展示 -->
      <view class="cell-box" v-if="userInfo.member_id">
        <image :src="getImgPath(userInfo.headimgurl)" class="user-img"></image>
        <view class="user-name">{{ userInfo.nickname }}</view>
        <view class="phone">{{ userInfo.mobile }}</view>
        <view class="btn" @click="onsubmit">转移给对方</view>
      </view>
    </view>
  </view>
</template>

<script>
import { ref } from 'vue';
import { transfer_api, memberInfo_api } from '@/api/index.js';
import { imgPath } from '@/libs/filters.js';

export default {
  setup(props) {
    const mobile = ref('');
    const userInfo = ref({});
    const lockauth_id = ref('');
    
    const inquire = async () => {
      if (!mobile.value) {
        showToast('请输入对方手机号！');
        return;
      }
      uni.showLoading({ title: '查询中...', mask: true });
      let res = await memberInfo_api({ mobile: mobile.value });
      uni.hideLoading();
      if (res.code === 0) {
        userInfo.value = res.data;
      } else {
        userInfo.value = {};
        showToast(res.msg);
      }
    };

    const onsubmit = async () => {
      uni.showModal({
        title: '提示',
        content: `确定要转移权限给 ${userInfo.value.nickname} 吗？`,
        success: async (msg) => {
          if (msg.confirm) {
            uni.showLoading({ title: '转移中...', mask: true });
            let res = await transfer_api({ lockauth_id: lockauth_id.value, member_id: userInfo.value.member_id });
            uni.hideLoading();
            if (res.code === 0) {
              showToast('权限转移成功!');
              setTimeout(() => {
                uni.navigateBack({ delta: 1 });
              }, 1000);
            } else {
              showToast(res.msg);
            }
          }
        }
      });
    };

    const showToast = (msg) => {
      uni.showToast({
        title: msg,
        icon: 'none',
        mask: true
      });
    };

    const getImgPath = (path) => imgPath(path);

    return {
      mobile,
      userInfo,
      lockauth_id,
      inquire,
      onsubmit,
      getImgPath
    };
  },
  onLoad(option) {
      // 使用uniapp的onLoad来获取参数
      this.lockauth_id = option.lockauth_id;
    }
};
</script>

<style scoped lang="scss">
	@import './transfer.scss';
</style>