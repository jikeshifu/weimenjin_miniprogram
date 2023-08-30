const app = getApp();
let request = require('../../module/request/index');
Page({
  data: {
    sound: '',
    volume: 5,
    user_id:0  ,   // 管理员id，不是小程序用户的id
    lock_id: 0, // 锁id
  },
  onShow:async function () {
    //console.log('configaudio-onShow')
    var that = this;
  let info = await request.HttpPost("Lock/view",{
      lock_id: that.data.lock_id
    }).catch(()=>{})
    if (!info){
      return
    }
    var result = info.data;
    that.setData({
      sound: result.openttscontent,
      volume: result.volume
    });

  },
  onLoad: function (options) {
    // //console.log('onLoad-options');
    // //console.log(options);
    var that = this;
    // //console.log(app.globalData)
    var lock_id = that.data.lock_id;
    var user_id = that.data.user_id;
    if(options.q){
      var scene = decodeURIComponent(options.q)  // 使用decodeURIComponent解析  获取当前二维码的网址
      // scene.decodeURL()
      //console.log('scene:'+scene);
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
        if (paramobj['user_id'] != undefined && paramobj['user_id'] > 0) {
          user_id = paramobj['user_id'];
          that.setData({
            user_id: paramobj['user_id']
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
    if (options.user_id != undefined && options.user_id >0) {
      user_id = options.user_id
      that.setData({
        user_id: user_id
      });
    }
  },
  soundInput:function(e){
    this.setData({
      sound: e.detail.value
    });
  },
  sliderChange: function(e){
    this.setData({
      volume: e.detail.value
    });
  },
  doSubmit:async function() {

    wx.showLoading({
      title: '执行中',
      mask: true
    })
    var that = this;
    //console.log('thatdata');
    //console.log(that.data);
    var sound = that.data.sound;
    var volume = that.data.volume;
    if (!sound || sound==' ') {
      wx.showToast({
        title: '请输入语音提示内容',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    var postdata = {
      // user_id: that.data.user_id,
      lock_id: that.data.lock_id,
      openttscontent: that.data.sound,
      volume: that.data.volume
    };
    //console.log('postdata:')
    //console.log(postdata)
   let configaudio =await request.HttpPost("Lock/configaudio",postdata).catch(()=>{})
    if(!configaudio){
      return
    }
    console.log("configaudio",configaudio)
    wx.showToast({
      title: configaudio.msg,
      icon: 'none',
      mask: true, // 防止触摸穿透
      duration: 2000
    });


  }
})
