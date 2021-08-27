//获取应用实例
const app = getApp();

Page({
  data: {
    logo: '../../images/logo.png',
    openid: '',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    route:'',
    canIUseGetUserProfile: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
  },
  //事件处理函数
  // bindViewTap: function() {
  //   wx.navigateTo({
  //     url: '../logs/logs'
  //   })
  // },
  onShow:function () {
    //console.log('open-onShow')
    if (wx.getUserProfile) {
      this.setData({canIUseGetUserProfile:true})
    }
    if (app.globalData.userid < 1) {
      this.login();
    }
  },
  onLoad: function () {
    //console.log('wxlogin-onLoad-app.globalData');
    //console.log(app.globalData);
    var pages = getCurrentPages();
    //console.log('pages')
    //console.log(pages)
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
    // //console.log(prevpage.route);
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
    }
  },
  closemask: function () {
    wx.switchTab({
      url: '../index/index'
    })
  },
  login: function () {
    var that = this;
    // 登录
    wx.login({
      success: res => {
        console.log('wxlogin-success-res')
        console.log(res)
        if (res.code) {
          // 可以将 res 发送给后台解码出 unionId
          //发起网络请求
          wx.request({
            url: app.globalData.domain + '/api/Member/login',
            data: {
              code: res.code,
            },
            method: 'POST',
            success: function (resa) {
              console.log('login-resa');
              console.log(resa);
              if (resa.data.status + "" == "200") {
                app.globalData.token = resa.data.token;
                app.globalData.userid = resa.data.data.member_id;
                app.globalData.openid = resa.data.data.openid;
                app.globalData.nickname = resa.data.data.nickname;
                app.globalData.headimgurl = resa.data.data.headimgurl;
                app.globalData.phone = resa.data.data.mobile == null ? '' : resa.data.data.mobile;
                if (resa.data.data.useradmininfo.user_id != undefined) {
                  app.globalData.user_id = resa.data.data.useradmininfo.user_id;
                }
              }
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
                  //console.log('wxlogin-updateUserInfo-resb');
                  //console.log(resb);
                  if (resb.data.status == 200) {
                    var tmpuser_id = resb.data.data.user_id;
                    if (tmpuser_id != '') {
                      app.globalData.user_id = resb.data.data.user_id;
                      app.globalData.adminInfo = resb.data.data;
                    }
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
      },
      fail: res => {}
    })
  },
  getUserProfile(e) {
    // console.log('getUserProfile-e');
    // console.log(e);
    var that = this;
    // 推荐使用wx.getUserProfile获取用户信息，开发者每次通过该接口获取用户个人信息均需用户确认
    // 开发者妥善保管用户快速填写的头像昵称，避免重复弹窗
    wx.getUserProfile({
      desc: '用于登录获取用户头像', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
      success: (res) => {
        wx.showLoading({
          title: '登录中',
          mask: true
        })
        // 用户授权获取用户信息后，直接更新用户信息到用户表
        var userInfo = res.userInfo;
        app.globalData.userInfo = userInfo;
        app.globalData.nickname = userInfo.nickName;
        app.globalData.headimgurl = userInfo.headimgurl;
        // this.updateUserInfo(e.detail);
        wx.request({
          url: app.globalData.domain+'/api/Member/update',
          method: 'POST',
          header:{
            "Authorization": app.globalData.token
          },
          data: {
            member_id: app.globalData.userid,
            nickname: userInfo.nickName,
            headimgurl: userInfo.avatarUrl,
            openid: app.globalData.openid,
            mobile: app.globalData.phone,
            sex: userInfo.gender,
            member_ps: 1,
          },
          success: function (resa) {
            wx.hideLoading();
            if (resa.data.status == 200) {
              if (that.data.route=="pages/user/user") {
                wx.switchTab({
                  url: '../index/index'
                })
              }else{
                wx.navigateBack({
                  delta: 1
                });
              }
            }else{
              wx.showToast({
                title: resa.data.msg,
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          }
        })
      }
    })
  },
  getUserInfo: function(e) {
    var that = this;
    wx.showLoading({
      title: '登录中',
      mask: true
    })
    //console.log('getUserInfo-e');
    //console.log(e);
    var userInfo = e.detail.userInfo
    app.globalData.userInfo = userInfo;
    app.globalData.nickname = userInfo.nickName;
    app.globalData.headimgurl = userInfo.headimgurl;
    // this.updateUserInfo(e.detail);
    wx.request({
      url: app.globalData.domain+'/api/Member/update',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: app.globalData.userid,
        nickname: userInfo.nickName,
        headimgurl: userInfo.avatarUrl,
        openid: app.globalData.openid,
        mobile: app.globalData.phone,
        sex: userInfo.gender,
        member_ps: 1,
      },
      success: function (resa) {
        //console.log('index-resa');
        //console.log(resa);
        wx.hideLoading();
        if (resa.data.status == 200) {
          if (that.data.route=="pages/user/user") {
            wx.switchTab({
              url: '../index/index'
            })
          }else{
            wx.navigateBack({
              delta: 1
            });
          }
        }else{
          wx.showToast({
            title: resa.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      }
    })
  }
})
