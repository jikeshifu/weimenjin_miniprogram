<template>
  <view class="big-box">
    <view class="content">
      <view v-for="(link, index) in links" :key="index" @click="openwmjLink(link)" class="cell-box">
        <image :src="link.wservice_icon" alt="icon" class="icon-image"></image>
        <view class="text">{{ link.wservice_name }}</view>
      </view>
    </view>
  </view>
</template>

<script>
// 假设 wmjservice_api 已经是跨平台兼容的
import { wmjservice_api } from '@/api/index.js'

export default {
  data() {
    return {
      links: [], // 存放从后端获取的链接数据
    };
  },
  onShow() {
    this.fetchLinks(); // 获取链接数据
  },
  methods: {
    async fetchLinks() {
      let res = await wmjservice_api();
      if (res && res.data && res.data.list) {
        this.links = res.data.list;
      }
    },
    goPage(url) {
      // 平台检测和跳转
      if (typeof wx !== 'undefined') {
        wx.navigateTo({ url });
      } else if (typeof my !== 'undefined') {
        my.navigateTo({ url });
      } else if (typeof tt !== 'undefined') {
        tt.navigateTo({ url });
      }
    },
    openwmjLink(link) {
      switch (link.wservice_type) {
        case "1":
          // 内部小程序链接
          this.goPage(link.wservice_url);
          break;
        case "2":
          // 外部小程序链接
          if (typeof wx !== 'undefined') {
            wx.navigateToMiniProgram({
              appId: link.wservice_appid,
              path: link.wservice_url,
              extraData: { 'data1': 'test' }
            });
          } else if (typeof my !== 'undefined') {
            my.navigateToMiniProgram({
              appId: link.wservice_appid,
              path: link.wservice_url,
              extraData: { 'data1': 'test' }
            });
          } else if (typeof tt !== 'undefined') {
            tt.navigateToMiniProgram({
              appId: link.wservice_appid,
              path: link.wservice_url,
              extraData: { 'data1': 'test' }
            });
          }
          break;
        case "3":
          // 外部网页链接
          this.goPage('/pages/webview/webview?url=' + link.wservice_url);
          break;
        default:
          console.error("未知的链接类型");
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import './service.scss';  
</style>
