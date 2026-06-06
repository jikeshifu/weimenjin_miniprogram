<script>
  // #ifdef MP-ALIPAY
  // 支付宝扫码带的参数处理
  import { getQueryString } from './libs/utils.js';
  // #endif

  export default {
    onLaunch: function (option) {
      // 处理支付宝小程序的扫码参数
      // #ifdef MP-ALIPAY
      let qrstr = option.query ? option.query.qrCode : '';
      if (qrstr) {
        let url = decodeURIComponent(qrstr); // 解析二维码中的 URL
        let lock_ids = getQueryString(url).lock_id;
        let relay_num = getQueryString(url).relay_num;
        uni.setStorageSync('qrcodeLockId', lock_ids); // 存储锁 ID
        if (relay_num) {
          uni.setStorageSync('qrcodeRelayNum', relay_num); // 存储继电器路数
        }
      }
      // #endif

      // 处理微信小程序的扫码参数
      // #ifdef MP-WEIXIN
      if (option.scene === 1011 || option.scene === 1012 || option.scene === 1013) {
        let qrstr = option.query ? option.query.q : '';
        if (qrstr) {
          let lock_ids = getQueryString(qrstr).lock_id;
          let relay_num = getQueryString(qrstr).relay_num;
          uni.setStorageSync('qrcodeLockId', lock_ids); // 存储锁 ID
          if (relay_num) {
            uni.setStorageSync('qrcodeRelayNum', relay_num); // 存储继电器路数
          }
        }
      }
      // #endif

      // 处理抖音小程序的扫码参数
      // #ifdef MP-TOUTIAO
      let qrstr = option.query ? option.query.q : '';
      if (qrstr) {
        let url = decodeURIComponent(qrstr);
        let lock_ids = getQueryString(url).lock_id;
        let relay_num = getQueryString(url).relay_num;
        uni.setStorageSync('qrcodeLockId', lock_ids);
        if (relay_num) {
          uni.setStorageSync('qrcodeRelayNum', relay_num);
        }
      }
      // #endif

      // 处理小程序更新
      this.handleUpdate();
    },

    // 应用显示时
    onShow: function () {
      // 清除二维码锁定 ID
      uni.removeStorageSync('qrcodeLockId');
      uni.removeStorageSync('qrcodeRelayNum');
    },

    // 小程序隐藏时执行的逻辑
    onHide: function () {
      // 清除缓存信息
      uni.removeStorageSync('qrcodeLockId');
      uni.removeStorageSync('qrcodeRelayNum');
    },

    methods: {
      handleUpdate() {
        // 处理微信、抖音小程序更新
        // #ifdef MP-WEIXIN || MP-TOUTIAO
        const updateManager = wx.getUpdateManager();
        updateManager.onCheckForUpdate(function (res) {
          if (res.hasUpdate) {
            updateManager.onUpdateReady(function () {
              wx.showModal({
                title: '更新提示',
                content: '新版本已经准备好，是否重启应用？',
                success: function (res) {
                  if (res.confirm) {
                    wx.clearStorageSync();
                    updateManager.applyUpdate();
                  }
                }
              });
            });

            updateManager.onUpdateFailed(function () {
              wx.showModal({
                title: '更新失败',
                content: '新版本下载失败，请检查网络设置并重试'
              });
            });
          }
        });
        // #endif

        // 支付宝小程序更新逻辑
        // #ifdef MP-ALIPAY
        const updateManager = my.getUpdateManager();
        updateManager.onCheckForUpdate(function (res) {
          if (res.hasUpdate) {
            updateManager.onUpdateReady(function () {
              my.confirm({
                title: '更新提示',
                content: '新版本已经准备好，是否重启应用？',
                success: (res) => {
                  if (res.confirm) {
                    my.clearStorageSync();
                    updateManager.applyUpdate();
                  }
                }
              });
            });
          }
        });
        // #endif
      }
    }
  };
</script>

<style lang="scss">
/* 通用样式 */
@import './iconfont/iconfont.css';
page {
  width: 100%;
  height: 100%;
  background: #f7f7fa;
}
body,
html {
  width: 100%;
  height: 100%;
  background: #f7f7fa;
}
.swiper,
.wrap {
  width: 100% !important;
  height: 100% !important;
}
image {
  width: 100%;
  height: 100%;
}

/* 针对微信、支付宝等平台的 Picker 样式 */
.uni-picker-container .uni-picker-header {
  background: #21cf3e !important;
  color: #ffffff;
}
.uni-picker-container .uni-picker-action.uni-picker-action-cancel,
.uni-picker-container .uni-picker-action.uni-picker-action-confirm {
  font-size: 30rpx;
  color: #ffffff;
}
.lb-picker-content {
  height: 440rpx;
}

/* 针对 H5 平台的样式优化 */
@media (min-width: 768px) {
  .swiper {
    display: none;
  }
}

/* 针对 iOS 平台优化字体渲染 */
html[data-platform='ios'] .text {
  -webkit-font-smoothing: antialiased;
}

/* 针对 Android 平台优化字体渲染 */
html[data-platform='android'] .text {
  -webkit-font-smoothing: auto;
}

/* iconfont 样式兼容性 */
.iconfont {
  font-family: 'iconfont' !important;
  font-size: 16px;
  font-style: normal;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* 全局去掉 H5 滚动条 */
#app {
  width: 100%;
  height: 100%;
  background-color: #f7f7fa;
}

::-webkit-scrollbar {
  width: 0;
}
</style>
