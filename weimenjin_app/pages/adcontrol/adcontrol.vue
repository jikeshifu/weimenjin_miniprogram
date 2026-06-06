<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <block v-if="pageType === 'error'">
        <view class="error-box">
          <text>{{ errorMsg }}</text>
        </view>
      </block>
      <block v-if="pageType === 'succeed'">
        <view class="succeed-box">
          <view class="succeed-img">
            <image :src="successimg"></image>
          </view>
          <view class="download-box">
            <text>广告已观看完成,谢谢!</text>
          </view>
        </view>
      </block>
    </view>

    <!-- 隐私协议 -->
    <privacy-popup ref="privacyComponent"></privacy-popup>
  </view>
</template>

<script>
import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue';
import { getQueryString } from '../../libs/utils.js';
import { adlog_api, adControlUnitId_api, updateAdStatus_api } from '../../api/index.js';
import { assetUrl } from '@/config/domain.js';

export default {
  components: {
    PrivacyPopup,
  },
  data() {
    return {
      pageType: '',
      token: '',
      softwareId: '',
      successimg: assetUrl('/static/img/adok.jpg'),
      errorMsg: '',
      videoAd: null,
      interstitialAd: null,
      adShowCount: 0,
      adUnitId: '',
      defaultAdUnitId: 'adunit-9e867d2c8cf7f169',
      interstitialAdUnitId: 'adunit-55a602453119e2af',
    };
  },
  onShareAppMessage() {},
  onShareTimeline() {},
  onLoad(option) {
	if (option.token) {
		this.token = option.token;
		this.softwareId = option.softwareId
	}
    // 微信小程序扫码参数
    if (option.q) {
      let scene = decodeURIComponent(option.q);
      const params = getQueryString(scene);
      this.token = params.token || '';
      this.softwareId = params.softwareId || '';
    }

    // 检查二维码参数
    if (!this.token || !this.softwareId) {
      this.pageType = 'error';
      this.errorMsg = '二维码参数缺失';
      this.showToast('二维码参数缺失');
      // return;
    }

    // 初始化并展示广告
    this.fetchAdUnitId().then(() => {
      this.initVideoAd();
      this.initInterstitialAd();
      this.showInterstitialAd();
    });
  },
  mounted() {
    let lastDate = wx.getStorageSync('lastUseDate');
    let today = new Date()
      .toLocaleDateString('zh-CN', {
        timeZone: 'Asia/Shanghai',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
      })
      .replace(/\//g, '-');
    if (lastDate !== today) {
      this.adShowCount = 0;
      wx.setStorageSync('adShowCount', this.adShowCount);
    } else {
      this.adShowCount = wx.getStorageSync('adShowCount') || 0;
    }
    wx.setStorageSync('lastUseDate', today);
  },
  methods: {
    async sendAdFeedback(isWatched) {
      try {
        const res = await updateAdStatus_api({
          token: this.token,
          softwareId: this.softwareId,
          isWatched: isWatched ? 1 : 0,
        });
        if (res.code !== 1) {
          console.error('广告观看反馈发送失败', res.msg);
        }
      } catch (error) {
        console.error('广告观看反馈请求失败', error);
      }
    },
    async fetchAdUnitId() {
      try {
        const res = await adControlUnitId_api();
        if (res.code === 0 && res.adUnitId) {
          this.adUnitId = res.adUnitId;
        } else {
          this.adUnitId = this.defaultAdUnitId;
          console.error('获取激励视频广告ID失败，使用本地默认ID');
        }
      } catch (error) {
        this.adUnitId = this.defaultAdUnitId;
        console.error('API请求失败，使用本地默认激励视频广告ID', error);
      }
    },
    showToast(msg) {
      uni.showToast({
        title: msg,
        icon: 'error',
        duration: 4000,
        mask: true,
      });
    },
    initVideoAd() {
      if (wx.createRewardedVideoAd) {
        this.videoAd = wx.createRewardedVideoAd({
          adUnitId: this.adUnitId,
        });

        this.videoAd.onLoad(() => {
          this.adLog('qropen', 'load', 30, true, '激励视频广告加载成功', 0);
        });

        this.videoAd.onError((err) => {
          console.error('激励视频广告加载失败', err);
          this.adLog(
            'qropen',
            'error',
            30,
            false,
            `激励视频广告加载失败: ${err.errMsg}`,
            0
          );
          this.pageType = 'succeed';
          this.sendAdFeedback(false);
        });

        this.videoAd.onClose((res) => {
          if (res && res.isEnded) {
            this.adLog('qropen', 'close', 30, true, '用户完整观看激励视频广告', 1);
            this.sendAdFeedback(true);
          } else {
            this.adLog('qropen', 'close', 30, false, '用户提前关闭激励视频广告', 0);
            this.sendAdFeedback(false);
          }
          this.pageType = 'succeed';
        });
      }
    },
    initInterstitialAd() {
      if (wx.createInterstitialAd) {
        this.interstitialAd = wx.createInterstitialAd({
          adUnitId: this.interstitialAdUnitId,
        });

        this.interstitialAd.onLoad(() => {
          this.adLog('qropen_interstitial', 'load', 30, true, '插屏广告加载成功', 0);
        });

        this.interstitialAd.onError((err) => {
          console.error('插屏广告加载失败', err);
          this.adLog(
            'qropen_interstitial',
            'error',
            30,
            false,
            `插屏广告加载失败: ${err.errMsg}`,
            0
          );
          this.showAd();
        });

        this.interstitialAd.onClose(() => {
          this.adLog('qropen_interstitial', 'close', 30, true, '插屏广告关闭', 0);
          this.sendAdFeedback(true); // 更新广告状态
          this.showAd();
        });
      }
    },
    showAd() {
      if (this.videoAd && this.adShowCount < 3) {
        this.videoAd
          .show()
          .then(() => {
            this.adLog('qropen', 'show', 30, true, '展示成功', 0);
            this.adShowCount++;
            wx.setStorageSync('adShowCount', this.adShowCount);
          })
          .catch((err) => {
            console.error('激励视频广告加载失败，尝试重新加载', err);
            this.adLog(
              'qropen',
              'load_fail',
              30,
              false,
              `激励视频广告加载失败: ${err.errMsg}`,
              0
            );
            this.videoAd.load().then(() => {
              this.videoAd
                .show()
                .then(() => {
                  this.adLog(
                    'qropen',
                    'reload_show',
                    30,
                    true,
                    '激励视频广告重新加载后展示成功',
                    0
                  );
                })
                .catch((err) => {
                  console.error('激励视频广告重新加载失败', err);
                  this.adLog(
                    'qropen',
                    'reload_fail',
                    30,
                    false,
                    `激励视频广告重新加载失败: ${err.errMsg}`,
                    0
                  );
                  this.pageType = 'succeed';
                  this.sendAdFeedback(false);
                });
            });
          });
      } else {
        this.adLog(
          'qropen',
          'show_fail',
          30,
          false,
          '激励视频广告未初始化或展示次数已达上限',
          0
        );
        this.pageType = 'succeed';
        this.sendAdFeedback(false);
      }
    },
    showInterstitialAd() {
      if (this.interstitialAd) {
        this.interstitialAd
          .show()
          .then(() => {
            this.adLog('qropen_interstitial', 'show', 30, true, '插屏广告展示成功', 0);
          })
          .catch((err) => {
            console.error('插屏广告显示失败', err);
            this.adLog(
              'qropen_interstitial',
              'show_fail',
              30,
              false,
              `插屏广告显示失败: ${err.errMsg}`,
              0
            );
            this.showAd();
          });
      } else {
        this.adLog(
          'qropen_interstitial',
          'show_fail',
          30,
          false,
          '插屏广告未初始化',
          0
        );
        this.showAd();
      }
    },
    adLog(adlog_page, adlog_type, adlog_adtime, adlog_result, adlog_msg, adlog_points) {
      try {
        adlog_api({
          adlog_page,
          adlog_type,
          adlog_adtime,
          adlog_result,
          adlog_msg,
          adlog_points,
          token: this.token,
          softwareId: this.softwareId,
        }).catch(() => {
          // 静默处理错误
        });
      } catch (error) {
        // 静默处理错误
      }
    },
  },
};
</script>

<style scoped lang="scss">
.big-box {
  height: 100vh;
  display: flex;
  flex-direction: column;
}

.background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #f0f0f0;
  z-index: -1;
}

.content {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.succeed-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 20px;
  .succeed-img {
    width: 100%;
    max-width: 300px;
    margin-bottom: 20px;
    image {
      width: 100%;
      height: auto;
    }
  }
  .download-box {
    text-align: center;
    text {
      font-size: 16px;
      color: #333;
      margin-bottom: 10px;
    }
  }
}

.error-box {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  text-align: center;
  font-size: 16px;
  color: #ff0000;
  padding: 20px;
}
</style>
