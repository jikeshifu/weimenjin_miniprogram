const app = getApp();
Page({
  data: {
    headimgurl: '',
    nickname: '',
    member_id: 0, // 接收人的会员ID
    findmobile: '',
    mobile: '',
    user_id:0  ,   // 接收人的管理员ID
    lock_id: 0, // 锁id
    lockauth_id: 0, // 钥匙id
  },
  onShow:function () {
    console.log('configaudio-onShow')
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function (options) {
    // console.log('onLoad-options');
    // console.log(options);
    var that = this;
    // console.log(app.globalData)
    var lock_id = that.data.lock_id;
    var lockauth_id = that.data.lockauth_id;
    if(options.q){
      var scene = decodeURIComponent(options.q)  // 使用decodeURIComponent解析  获取当前二维码的网址
      // scene.decodeURL()
      console.log('scene:'+scene);
      var pos = scene.indexOf("?");
      if (pos >=0) {
        pos = parseInt(pos) +1;
        var str = scene.substr(pos);
        var strarr = str.split('&');
        var paramobj = {};
        for (var i = 0; i < strarr.length; i++) {
          var tmparr = strarr[i].split('=');
          paramobj[tmparr[0]] = tmparr[1];
        }
        if (paramobj['lock_id'] != undefined && paramobj['lock_id'] >0) {
          lock_id = paramobj['lock_id'];
          that.setData({
            lock_id: paramobj['lock_id']
          });
        }
        if (paramobj['lockauth_id'] != undefined && paramobj['lockauth_id'] > 0) {
          lockauth_id = paramobj['lockauth_id'];
          that.setData({
            lockauth_id: paramobj['lockauth_id']
          });
        }
      }
    }
    if (options.lock_id != undefined && options.lock_id >0) {
      lock_id = options.lock_id
      that.setData({
        lock_id: lock_id
      });
    }
    if (options.lockauth_id != undefined && options.lockauth_id >0) {
      lockauth_id = options.lockauth_id
      that.setData({
        lockauth_id: lockauth_id
      });
    }
  },
  mobileInput: function(e){
    this.setData({
      mobile: e.detail.value
    });
  },
  findmobile: function() {
    var that = this;
    wx.showLoading({
      title: '执行中',
      mask: true
    })
    wx.request({
      url: app.globalData.domain+'/api/Member/getuserbymobile',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        mobile: that.data.mobile
      },
      success: function (res) {
        console.log('findmobile-res');
        console.log(res);
        wx.hideLoading();
        if (res.data.status == 200) {
          var result = res.data.data;
          that.setData({
            headimgurl: result.headimgurl,
            nickname: result.nickname,
            member_id: result.member_id,
            findmobile: result.mobile,
            user_id: result.user_id
          });
        }else{
          that.setData({
            headimgurl: '',
            nickname: '',
            member_id: 0,
            findmobile: '',
            user_id: 0
          });
        }
      }
    })
  },
  doSubmit() {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    wx.showLoading({
      title: '执行中',
      mask: true
    })
    var that = this;
    // console.log('thatdata');
    // console.log(that.data);
    var member_id = that.data.member_id;
    var user_id = that.data.user_id;
    if (member_id < 1) {
      wx.showToast({
        title: '请对方先注册为用户',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    if (user_id < 1) {
      wx.showToast({
        title: '请对方先注册为管理员',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      setTimeout(function(){
        wx.navigateTo({
          url: '../adduser/adduser'
        });
      },2000);
      return false;
    }
    var postdata = {
      lock_id: that.data.lock_id,
      lockauth_id: that.data.lockauth_id,
      member_id: member_id,
      user_id: user_id
    };
    console.log('postdata:')
    console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/Lock/townership',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: postdata,
      success: function (res) {
        console.log('doSubmit-res');
        console.log(res);
        wx.hideLoading();
        if (res.data.status ==200) {
          wx.showToast({
            title: res.data.msg,
            icon: 'success',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.switchTab({
              url: '../index/index'
            })
          },2000);
        }else{
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      }
    })
  }
})