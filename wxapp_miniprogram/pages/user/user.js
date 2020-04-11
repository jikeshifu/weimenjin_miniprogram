const app = getApp()
Page({
  data: {
    tmpuserInfo:{
      "avatarUrl": '../../images/avatar.png',
      "nickName": '游客'
    },
    imgarrow:"../../images/arrowr.png",
    phone: null,
    phoneArr: [],
    hasPhone: false,
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    dropArr: [true, false] // 控制下拉显示隐藏 true折叠起来
  },
  onShow:function () {
    console.log('user-onShow')
    var that = this;
    console.log(app.globalData)
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      });
    }else{
      that.setData({
        phone: app.globalData.phone,
        userInfo: app.globalData.userInfo,
        tmpuserInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    }
  },
  onLoad: function () {
    var that = this;
    if (app.globalData.userInfo) {
      that.setData({
        phone: app.globalData.phone,
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
      url: '../health/health'
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
    console.log('getPhoneNumber-e');
    console.log(e);
    if (e != undefined) {}
    if (e.detail.errMsg == "getPhoneNumber:ok") {
      wx.login({
        success: res => {
          console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
              encryptedData: e.detail.encryptedData,
              iv: e.detail.iv,
              code: res.code
            },
            method: "post",
            success: function (resa) {
              console.log('getphonenumber-resa');
              console.log(resa);
              app.globalData.phone = resa.data.phoneNumber;
              that.setData({
                phone: resa.data.phoneNumber
              })
            }
          })
        }
      })
    }
  }
})
