//获取应用实例
const app = getApp();

Page({
  data: {
    logo: '../../images/logo.png',
    openid: '',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    route:''
  },
  //事件处理函数
  // bindViewTap: function() {
  //   wx.navigateTo({
  //     url: '../logs/logs'
  //   })
  // },
  onLoad: function () {
    console.log('wxlogin-onLoad-app.globalData');
    console.log(app.globalData);
    var pages = getCurrentPages();
    console.log('pages')
    console.log(pages)
    var len = pages.length;
    var route = '';
    if (len>=2) {
      var prevpage = pages[pages.length - 2];
      if (prevpage.route=="pages/user/user") {
        route = prevpage.route;
        this.setData({
          route: route
        })
      }
    }
    // console.log(prevpage.route);
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
      if (route=="pages/user/user") {
        wx.switchTab({
          url: '../index/index'
        })
      }else{
        wx.navigateBack({
          delta: 1
        });
      }
    } else if (this.data.canIUse){
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      console.log('else-if');
      app.userInfoReadyCallback = res => {
        console.log(res.userInfo);
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        });
        if (route=="pages/user/user") {
          wx.switchTab({
            url: '../index/index'
          })
        }else{
          wx.navigateBack({
            delta: 1
          });
        }
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      console.log('else');
      wx.getUserInfo({
        success: res => {
          console.log(res.userInfo);
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
          this.updateUserInfo(res);
        }
      })
    }
  },
  closemask: function () {
    wx.switchTab({
      url: '../index/index'
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
    var route = that.data.route;
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
                url: app.globalData.domain+'/api/Member/login',
                data: {
                  code: res.code,
                  encryptedData: resuser.encryptedData,
                  iv: resuser.iv
                },
                method: 'POST',
                success: function (resa) {
                  console.log('app-resa');
                  console.log(resa);
                  if (resa.data.status == 200) {
                    app.globalData.token = resa.data.token;
                    app.globalData.userid = resa.data.data.member_id;
                    app.globalData.openid = resa.data.data.openid;
                    app.globalData.phone = resa.data.data.mobile;
                  }
                  var tmpdata1 = {member_id: resa.data.data.member_id};
                  console.log('wxlogin-updateUserInfo-tmpdata1')
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
                      console.log('wxlogin-updateUserInfo-resb');
                      console.log(resb);
                      if (resb.data.status == 200) {
                        var tmpuser_id = resb.data.data.user_id;
                        if (tmpuser_id != '') {
                          app.globalData.user_id = resb.data.data.user_id;
                          app.globalData.adminInfo = resb.data.data;
                        }
                        setTimeout(function(){
                          wx.hideLoading();
                          if (route=="pages/user/user") {
                            wx.switchTab({
                              url: '../index/index'
                            })
                          }else{
                            wx.navigateBack({
                              delta: 1
                            });
                          }
                        },1500);
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
  }
})
