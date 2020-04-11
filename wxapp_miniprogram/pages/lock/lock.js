// pages/lock/lock.js
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log('options:');
    console.log(options);
    console.log('token:');
    console.log(app.globalData.token)
    var that = this;
    console.log(app.globalData)
    if (app.globalData.phone == '' || app.globalData.phone == null) {
    } else {
      that.setData({
        phone: app.globalData.phone
      })
    }
    var user_id = this.data.user_id;
    var lock_id = this.data.lock_id;
    if (options.q) {
      var scene = decodeURIComponent(options.q)  // 使用decodeURIComponent解析  获取当前二维码的网址
      // scene.decodeURL()
      console.log('scene:' + scene);
      var pos = scene.indexOf("?");
      if (pos >= 0) {
        console.log('pos1:' + pos);
        pos = parseInt(pos) + 1;
        var str = scene.substr(pos);
        console.log('str:' + str);
        var strarr = str.split('&');
        console.log('strarr:');
        console.log(strarr);
        var paramobj = {};
        for (var i = 0; i < strarr.length; i++) {
          var tmparr = strarr[i].split('=');
          paramobj[tmparr[0]] = tmparr[1];
        }
        console.log('paramobj:');
        console.log(paramobj);
        if (paramobj['user_id'] != undefined && paramobj['user_id'] > 0) {
          user_id = paramobj['user_id'];
          that.setData({
            user_id: paramobj['user_id']
          });
        }
        if (paramobj['lock_id'] != undefined && paramobj['lock_id'] > 0) {
          lock_id = paramobj['lock_id'];
          that.setData({
            lock_id: paramobj['lock_id']
          });
        }
      }
    }
    if (options.user_id != undefined && options.user_id > 0) {
      user_id = options.user_id
      that.setData({
        user_id: user_id
      });
    }
    if (options.lock_id != undefined && options.lock_id > 0) {
      lock_id = options.lock_id
      that.setData({
        lock_id: lock_id
      });
    }
    // var healthkey = "health"+app.globalData.userid;
    // var healthlog = wx.getStorageSync(healthkey);
    // console.log('healthkey:'+healthkey)
    // console.log(healthlog)
    // if (healthlog != undefined && healthlog != '') {
    //   healthlog = JSON.parse(healthlog);
    //   this.setData({
    //     username: healthlog.username,
    //     phone: healthlog.phone,
    //     address1: healthlog.address1,
    //     address2: healthlog.address2,
    //     job: healthlog.job,
    //   })
    // }
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})