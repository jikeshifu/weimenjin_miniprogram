const app = getApp();
Page({
  data: {
    regpointname: '' // 登记点名称
  },
  onShow:function () {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    if (app.globalData.user_id < 1) {
      wx.redirectTo({
        url: '../adduser/adduser'
      })
      return false;
    }
  },
  onLoad: function (options) {
  },
  nameInput:function(e){
    this.setData({
      regpointname: e.detail.value
    });
  },
  uploadData() {
    // var timestamp = Date.parse(new Date());
    // timestamp = timestamp /1000;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    if (app.globalData.user_id < 1) {
      wx.redirectTo({
        url: '../adduser/adduser'
      })
      return false;
    }
    var that = this;
    console.log(that.data);
    var regpointname = that.data.regpointname;
    if (!regpointname) {
      wx.showToast({
        title: '请输入登记点名称',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    wx.request({
      url: app.globalData.domain+'/api/Regpoint/add',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        regpointname: regpointname,
        member_id: app.globalData.userid,
        user_id: app.globalData.user_id,
        regpointurl: 'https://wxapp.wmj.com.cn/miniprogram?user_id='
      },
      success: function (res) {
        console.log('uploadData-res');
        console.log(res);
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          setTimeout(function(){
            wx.navigateTo({
              url: '../regpointlist/regpointlist'
            })
          },2000);
        }
      }
    })
  }
})