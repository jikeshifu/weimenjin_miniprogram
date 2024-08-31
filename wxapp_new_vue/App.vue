<script>
	// #ifdef MP-ALIPAY
	// 支付宝扫码带的参数
	import {
		getQueryString
	} from './libs/utils.js';
			// #endif
export default {
	onLaunch: function(option) {
		// #ifdef MP-ALIPAY
		// 支付宝扫码带的参数
		let qrstr = option.query ? option.query.qrCode : "";
		if (qrstr) {
	
			let url = decodeURIComponent(qrstr) // 使用decodeURIComponent解析  获取当前二维码的网址
			let lock_ids = getQueryString(url).lock_id
			//console.log("lock_ids",lock_ids)
			uni.setStorageSync("qrcodeLockId",lock_ids)
		}
		// #endif
		// #ifdef MP-WEIXIN
		  const updateManager = wx.getUpdateManager();
		  updateManager.onCheckForUpdate(function(res) {
		    if (res.hasUpdate) {
		      updateManager.onUpdateReady(function() {
		        wx.showModal({
		          title: '更新提示',
		          content: '新版本已经准备好，是否重启应用？',
		          success: function(res) {
		            if (res.confirm) {
		              wx.clearStorageSync();
		              updateManager.applyUpdate();
		            }
		          }
		        })
		      });
		
		      updateManager.onUpdateFailed(function() {
		        wx.showModal({
		          title: '更新失败',
		          content: '新版本下载失败，请检查网络设置并重试',
		        })
		      });
		    }
		  });
		  // #endif
		  // #ifdef MP-ALIPAY
		  const updateManager = my.getUpdateManager();
		  updateManager.onCheckForUpdate(function(res) {
		    // 在支付宝小程序中，不需要手动检查更新，这里仅作为示例
		  });
		  updateManager.onUpdateReady(function() {
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
		  updateManager.onUpdateFailed(function() {
		    // 新版本下载失败
		    my.alert({
		      title: '更新失败',
		      content: '新版本下载失败，请检查网络设置并重试',
		    });
		  });
		  // #endif
		// #ifdef MP-TOUTIAO
		const updateManager = tt.getUpdateManager();
		updateManager.onCheckForUpdate(function(res) {
		  if (res.hasUpdate) {
		    updateManager.onUpdateReady(function() {
		      tt.showModal({
		        title: '更新提示',
		        content: '新版本已经准备好，是否重启应用？',
		        success: function(res) {
		          if (res.confirm) {
		            tt.clearStorageSync();
		            updateManager.applyUpdate();
		          }
		        }
		      })
		    });
		
		    updateManager.onUpdateFailed(function() {
		      tt.showModal({
		        title: '更新失败',
		        content: '新版本下载失败，请检查网络设置并重试',
		      })
		    });
		  }
		});
		// #endif
	},
	onShow: function() {
		// console.log('App Show')
	},
	onHide: function() {
			uni.removeStorageSync("qrcodeLockId")
		// console.log('App Hide')
	}
};
</script>

<style lang="scss">
/*每个页面公共css */
@import './iconfont/iconfont.css';
* {
	-webkit-overflow-scrolling: touch;
}
page {
	width: 100%;
	height: 100%;
	background: #F7F7FA;
}
body,
html {
	width: 100%;
	height: 100%;
	background: #F7F7FA;
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
.simple-address__header {
	height: 80rpx;
	background: #48e5fd;
}
.simple-address__header-text {
	line-height: 80rpx !important;
}
uni-rich-text table {
	border: 1px solid #666666;
}
uni-rich-text table td {
	border: 1px solid #666666;
}
.uni-picker-container .uni-picker-header {
	background: #21cf3e !important;
	color: #ffffff;
}
.uni-picker-container .uni-picker-action.uni-picker-action-cancel {
	font-size: 30rpx;
	color: #ffffff;
}
.uni-picker-container .uni-picker-action.uni-picker-action-confirm {
	font-size: 30rpx;
	color: #ffffff;
}
.lb-picker-content {
	height: 440rpx;
}
.lb-picker-header-actions {
	background: #2db4b8 !important;
}
.uni-popup__wrapper-box {
	width: 100%;
	height: 100%;
}
.car-count .uni-swipe_box {
	background: inherit !important;
}
.share button::after {
	position: initial;
	border: none;
}
/* #ifdef H5 */
/* 通过样式穿透，隐藏H5下，scroll-view下的滚动条 */
::-webkit-scrollbar {
	width: 0;
	height: 1px;
}
::-webkit-scrollbar-thumb {
	border-radius: 5px;
	-webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
	background: rgba(0, 0, 0, 0.2);
}
uni-checkbox:not([disabled]) .uni-checkbox-input:hover {
	border-color: #d1d1d1;
}
/* #endif */
</style>
