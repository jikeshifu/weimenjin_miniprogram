const app = getApp()
Page({
  data: {
    tmpuserInfo:{
      "avatarUrl": '../../images/avatar.png',
      "nickName": '开门游客'
    },
    avatarUrl: '../../images/avatar.png',
    nickName: '开门游客',
    imgarrow:"../../images/arrowr.png",
    phone: null,
    jiamiphone: null,
    phoneArr: [],
    hasPhone: false,
    userInfo: {},
    hasUserInfo: false,
    canIUseGetUserProfile: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    dropArr: [true, false], // 控制下拉显示隐藏 true折叠起来
    user_id: 0     // 管理员id 大于0显示添加设备
  },
  onShow:function () {
    //console.log('user-onShow')
    var that = this;
    if (wx.getUserProfile) {
      this.setData({canIUseGetUserProfile:true})
    }
    //console.log(app.globalData)
    if (app.globalData.userid < 1 || app.globalData.defaultimg == app.globalData.headimgurl || app.globalData.headimgurl == '') {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      });
    }else{
      var avatarUrl = that.data.avatarUrl;
      var nickName = that.data.nickName;
      var tmpuserInfo = that.data.tmpuserInfo;
      if (app.globalData.userInfo != null) {
        avatarUrl = app.globalData.userInfo.avatarUrl ? app.globalData.userInfo.avatarUrl : app.globalData.avatarUrl;
        nickName = app.globalData.userInfo.nickName ? app.globalData.userInfo.nickName : app.globalData.nickname;
      }
      var tmpphone = app.globalData.phone;
      that.setData({
        user_id: app.globalData.user_id,
        phone: app.globalData.phone,
        jiamiphone: tmpphone.substr(0,3)+"****"+ tmpphone.substr(7),
        avatarUrl: avatarUrl,
        nickName: nickName,
        hasUserInfo: true
      })
    }
  },
  onLoad: function () {
    var that = this;
    if (app.globalData.userInfo) {
      var tmpphone = app.globalData.phone;
      that.setData({
        phone: app.globalData.phone,
        jiamiphone: tmpphone.substr(0,3)+"****"+ tmpphone.substr(7),
        userInfo: app.globalData.userInfo,
        tmpuserInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    }
  },
  drop: function(e) {
    var that = this
    var on = e.currentTarget.dataset['on'];
    var index = e.currentTarget.dataset['index'];
    if (on) {
      on = false;
    }else{
      on = true;
    }
    var dropArr = that.data.dropArr;
    dropArr[index] = on;
    that.setData({
      dropArr: dropArr
    });
  },
  addLock: function() {
    wx.navigateTo({
      url: '../addlock/addlock'
    });
  },
  openLock: function() {
    wx.navigateTo({
      url: '../open/open?user_id=1&lock_id=11&isscan=1'
    });
  },
  openlogs: function() {
    wx.navigateTo({
      url: '../openlogs/openlogs'
    });
  },
  health: function() {
    wx.navigateTo({
      url: '../health/health?user_id=1&regpoint_id=47&lock_id=82'
    });
  },
  healthList: function() {
    wx.navigateTo({
      url: '../healthlist/healthlist'
    });
  },
  addRegpoint: function() {
    wx.navigateTo({
      url: '../addregpoint/addregpoint'
    });
  },
  regpointList: function() {
    wx.navigateTo({
      url: '../regpointlist/regpointlist'
    });
  },
  adduser: function() {
    wx.navigateTo({
      url: '../adduser/adduser'
    });
  },
  editpwd: function() {
    wx.navigateTo({
      url: '../editpwd/editpwd'
    });
  },
  bindPhone: function() {
    wx.navigateTo({
      url: '../bindphone/bindphone'
    });
  },
  getPhoneNumber: function (e) {
    var that = this;
    //console.log('getPhoneNumber-e');
    //console.log(e);
    if (e != undefined) {}
    if (e.detail.errMsg == "getPhoneNumber:ok") {
      var phonecode = '';
      if (e.detail.code != undefined) {
        phonecode = e.detail.code;
      }
      wx.login({
        success: res => {
          //console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
              phonecode: phonecode,
              encryptedData: e.detail.encryptedData,
              iv: e.detail.iv,
              code: res.code
            },
            method: "post",
            success: function (resa) {
              //console.log('getphonenumber-resa');
              //console.log(resa);
              app.globalData.phone = resa.data.phoneNumber;
              var tmpphone = resa.data.phoneNumber;
              that.setData({
                phone: resa.data.phoneNumber,
                jiamiphone: tmpphone.substr(0,3)+"****"+ tmpphone.substr(7)
              })
            },
            fail: function (res) {
              wx.showToast({
                title: '操作失败',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          })
        }
      })
    }
  },
  getUserProfile(e) {
    var that = this;
    // 推荐使用wx.getUserProfile获取用户信息，开发者每次通过该接口获取用户个人信息均需用户确认
    // 开发者妥善保管用户快速填写的头像昵称，避免重复弹窗
    wx.getUserProfile({
      desc: '用于登录获取用户头像', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
      success: (res) => {
        wx.showLoading({
          title: '更新中',
          mask: true
        })
        // console.log('userInfo',res.userInfo);
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
              that.setData({
                avatarUrl: userInfo.avatarUrl,
                nickName: userInfo.nickName,
                hasUserInfo: true
              })
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
      title: '更新中',
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
          that.setData({
            avatarUrl: userInfo.avatarUrl,
            nickName: userInfo.nickName,
            hasUserInfo: true
          })
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
  },
  onShareAppMessage: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
      path: "/pages/index/index"
    };
  },
  onShareTimeline: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
    }
  }
})
