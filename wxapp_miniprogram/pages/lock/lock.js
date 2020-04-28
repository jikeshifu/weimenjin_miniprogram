const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    lock_id: 0,
    lock_qrcode: '',
    lock_sn: ''
  },
  onShow:function () {
    console.log('lock-onShow');
    var that = this;
    if (app.globalData.userid < 1) {
      // wx.navigateTo({
      //   url: '../wxlogin/wxlogin'
      // })
    }else{
      wx.request({
        url: app.globalData.domain+'/api/Lock/view',
        method: 'POST',
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          lock_id: that.data.lock_id
        },
        success: function (res) {
          console.log(res);
          if (res.data.status == 200) {
            var result = res.data.data;
            that.setData({
              lock_qrcode: result.lock_qrcode,
              lock_sn: result.lock_sn
            });
          }
        }
      })
    }
  },
  onLoad: function (options) {
    console.log('lock-onload-options:');
    console.log(options);
    var that = this;
    if (options.lock_id != undefined && options.lock_id >0) {
      that.setData({
        lock_id: options.lock_id
      });
    }
  }
})