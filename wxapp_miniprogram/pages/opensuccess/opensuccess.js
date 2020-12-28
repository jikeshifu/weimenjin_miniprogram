const app = getApp();
Page({
  data: {
    successimg: '../../images/success.png',
    successadimg: '../../images/success.png',
    closeAd: false, // 广告弹层是否关闭 false不关闭
    adnum: 1, // 显示开门成功样式几： 1原来的两张图片的,2新的只显示一张图片的
    openadurl: '', // 点击图片打开的链接
    cleartime: '', // 定时器
    adw: 600, // 广告弹层的宽单位rpx
    qrshowminiad: true,
  },
  onShow:function () {
    //console.log('opensuccess-onShow')
    var that = this;
    var successimg = app.globalData.successimg != '' ?app.globalData.successimg : that.data.successimg;
    var successadimg = app.globalData.successadimg != '' ?app.globalData.successadimg : that.data.successadimg;
    var openadurl = app.globalData.openadurl != '' ?app.globalData.openadurl : that.data.openadurl;
    var adnum = app.globalData.adnum;
    var qrshowminiad = app.globalData.qrshowminiad;
    that.setData({
      successimg: successimg,
      successadimg: successadimg,
      openadurl: openadurl,
      adnum: adnum,
      qrshowminiad: qrshowminiad
    })
    var cleartime = setTimeout(function(){
      that.setData({
        closeAd: true
      })
      wx.switchTab({
        url: '../index/index'
      })
    },4000);
    that.setData({
      cleartime: cleartime
    })
  },
  onLoad: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          adw: res.windowWidth * 2-60,
        });
      }
    });
  },
  openweb: function (e) {
    var tmpopenadurl = this.data.openadurl;
    if (tmpopenadurl) {
      clearTimeout(this.data.cleartime);
      wx.redirectTo({
        url: '../web/web?url='+tmpopenadurl
      })
    }
  }
})