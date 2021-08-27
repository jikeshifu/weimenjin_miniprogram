const app = getApp()
Page({
  data: {
    tmpuserInfo:{
      "avatarUrl": '../../images/avatar.png',
      "nickName": '游客'
    },
    imgarrow:"../../images/arrowr.png",
    phone: null,
    jiamiphone: null,
    phoneArr: [],
    hasPhone: false,
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    dropArr: [true, false], // 控制下拉显示隐藏 true折叠起来
    user_id: 0     // 管理员id 大于0显示添加设备
  },
  onShow:function () {
    //console.log('user-onShow')
    var that = this;
    //console.log(app.globalData)
    if (app.globalData.userid < 1 || app.globalData.defaultimg == app.globalData.headimgurl || app.globalData.headimgurl == '') {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      });
    }else{
      var tmpuserInfo = that.data.tmpuserInfo;
      if (app.globalData.userInfo != null) {
        tmpuserInfo = app.globalData.userInfo;
      }
      var tmpphone = app.globalData.phone;
      that.setData({
        user_id: app.globalData.user_id,
        phone: app.globalData.phone,
        jiamiphone: tmpphone.substr(0,3)+"****"+ tmpphone.substr(7),
        userInfo: tmpuserInfo,
        tmpuserInfo: tmpuserInfo,
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
      url: '../open/open?user_id=1&lock_id=11'
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
      wx.login({
        success: res => {
          //console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
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
            }
          })
        }
      })
    }
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
