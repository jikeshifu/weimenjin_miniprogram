const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    successimg: '../../images/success.png',
    hidelood: false,
    member_id: 0,
    lockauth_id: 0,  // 钥匙id
    close: true  // 登录弹层是否关闭 false不关闭
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
          that.setData({
            close: false
          });
          /*wx.showToast({
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
          },2000);*/
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
  cancelLogin:function () {
    var that = this;
    that.setData({
      close:true
    })
    wx.showToast({
      title: '登录后才能领取钥匙',
      icon: 'none',
      mask: true,
      duration: 2000
    })
    setTimeout(function(){
      that.setData({
        close:false
      })
    },2000);
  },
  closemask:function(){
    this.setData({
      close:true
    })
  },
  getUserInfo: function(e) {
    wx.showLoading({
      title: '登录中',
      mask: true
    })
    console.log('getUserInfo-e');
    console.log(e);
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
    this.updateUserInfo(e.detail);
  },
  updateUserInfo: function(data) {
    console.log('updateUserInfo');
    var that = this;
    // 登录
    wx.login({
      success: res => {
        if (res.code) {
          wx.getUserInfo({
            success: resuser => {
              // 可以将 res 发送给后台解码出 unionId
              app.globalData.userInfo = resuser.userInfo
              //发起网络请求
              wx.request({
                url: app.globalData.domain+'/api/Member/xcxlogin',
                data: {
                  code: res.code,
                  encryptedData: resuser.encryptedData,
                  iv: resuser.iv
                },
                method: 'POST',
                success: function (resa) {
                  console.log('index-resa');
                  console.log(resa);
                  if (resa.data.status == 200) {
                    app.globalData.token = resa.data.token;
                    app.globalData.userid = resa.data.data.member_id;
                    app.globalData.openid = resa.data.data.openid;
                    app.globalData.phone = resa.data.data.mobile;
                    that.setData({
                      member_id: resa.data.data.member_id
                    });
                  }
                  var tmpdata1 = {member_id: resa.data.data.member_id};
                  console.log('getkey-updateUserInfo-tmpdata1')
                  console.log(tmpdata1)
                  wx.request({
                    url: app.globalData.domain+'/api/Member/viewuserid',
                    method: 'POST',
                    header:{
                      "Authorization": resa.data.token
                    },
                    data: {
                      member_id: resa.data.data.member_id
                    },
                    success: function (resb) {
                      console.log('getkey-updateUserInfo-resb');
                      console.log(resb);
                      wx.hideLoading();
                      if (resb.data.status == 200) {
                        var tmpuser_id = resb.data.data.user_id;
                        if (tmpuser_id != '') {
                          app.globalData.user_id = resb.data.data.user_id;
                          app.globalData.adminInfo = resb.data.data;
                        }
                        that.closemask();
                        that.getkey();
                      }else{
                        wx.showToast({
                          title: '登录失败，请稍后重试',
                          icon: 'none',
                          mask: true,
                          duration: 1500
                        })
                      }
                    }
                  })
                }
              })
            }
          })
        }
      }
    })
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