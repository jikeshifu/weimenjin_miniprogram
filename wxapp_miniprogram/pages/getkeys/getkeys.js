const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    successimg: '../../images/success.png',
    hidelood: false,
    member_id: 0,
    lockauth_id: 0  // 钥匙id
  },
  onShow:function () {
    var that = this;
    wx.showLoading({
      title: '领取钥匙中',
      mask: true
    })
    if (app.globalData.userid < 1) {
      setTimeout(function(){
        if (app.globalData.userid < 1) {
          wx.hideLoading();
          wx.showToast({
            title: '钥匙领取失败',
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.hideLoading();
            wx.switchTab({
              url: '../index/index'
            })
          },2000);
        }else{
          that.getkey();
        }
      },2000);
    }else{
      that.getkey();
    }
  },
  onLoad: function (options) {
    console.log('getkeys-onload-options:');
    console.log(options);
    console.log(app.globalData.userid);
    var that = this;
    if (options.member_id != undefined && options.member_id >0) {
      that.setData({
        //member_id: options.member_id
        member_id: app.globalData.userid
      });
    }
    if (options.lockauth_id != undefined && options.lockauth_id >0) {
      that.setData({
        lockauth_id: options.lockauth_id //锁管理员id
      });
    }
  },
  getkey: function() {
    var that = this;
    wx.request({
      url: app.globalData.domain +'/api/LockAuth/getkey',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: that.data.member_id, //
        lockauth_id: that.data.lockauth_id
      },
      success: function (res) {
        console.log('getkeys-onShow-res');
        console.log(res);
        if (res.data.status ==200) {
          wx.hideLoading();
          wx.showToast({
            title: '钥匙领取成功',
            icon: 'success',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.hideLoading();
            wx.switchTab({
              url: '../index/index'
            })
          },2000);
        }else{
          wx.hideLoading();
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.switchTab({
              url: '../index/index'
            })
          },2000);
        }
      },
      fail: function (res) {
        wx.hideLoading();
        wx.showToast({
          title: '领取钥匙失败',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        setTimeout(function(){
          wx.switchTab({
            url: '../index/index'
          })
        },2000);
      }
    })
  }
})