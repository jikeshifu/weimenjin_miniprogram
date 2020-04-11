const app = getApp();
Page({
  data: {
    pwd: '',
    repwd: ''
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
    }
  },
  onLoad: function (options) {
  },
  pwdInput:function(e){
    this.setData({
      pwd: e.detail.value
    });
  },
  repwdInput:function(e){
    this.setData({
      repwd: e.detail.value
    });
  },
  uploadData() {
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
    var timestamp = Date.parse(new Date());
    timestamp = timestamp /1000;
    var that = this;
    console.log(that.data);
    var user_id = app.globalData.user_id;
    if (user_id < 1) {
      wx.showToast({
        title: '请先添加管理员',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      setTimeout(function(){
        wx.redirectTo({
          url: '../adduser/adduser'
        });
      },2000);
      return false;
    }
    var pwd = that.data.pwd;
    var repwd = that.data.repwd;
    var myreg = /(.+){6,20}$/;
    if (!myreg.test(pwd)) {
      wx.showToast({
        title: '新密码6-20位',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    if (pwd != repwd) {
      wx.showToast({
        title: '两次密码不一致',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    wx.request({
      url: app.globalData.domain+'/api/User/updatePassword',
      method: "POST",
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        user_id: user_id,
        pwd: pwd,
        repwd: repwd
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
            wx.switchTab({
              url: '../user/user'
            })
          },2000);
        }
      }
    })
  }
})