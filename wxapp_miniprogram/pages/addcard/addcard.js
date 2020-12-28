var dateTimePicker = require('../../utils/dateTimePicker.js');
const app = getApp();
Page({
  data: {
    lockcard_sn: '',
    lockcard_username: '',
    lockcard_remark: '',
    dateTimeArray: null,
    dateTime: null,
    dateIndex: [0,0,0,0,0,0],
    endtime: '', // 过期时间
    startYear: 2020,
    endYear: 2050,
    user_id:0  ,   // 管理员id，不是小程序用户的id
    lock_id: 0, // 锁id
    lockauth_id: 0, // 钥匙ID，当传此值时查询当前钥匙下绑定的卡

  },
  onShow:function () {
    //console.log('addlock-onShow')
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function (options) {
    //console.log('onLoad-options');
    //console.log(options);
    var that = this;
    //console.log(app.globalData)
    var lock_id = that.data.lock_id;
    var user_id = that.data.user_id;
    var lockauth_id = that.data.lockauth_id;
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
        if (paramobj['lockauth_id'] != undefined && paramobj['lockauth_id'] > 0) {
          lockauth_id = paramobj['lockauth_id'];
          that.setData({
            lockauth_id: paramobj['lockauth_id']
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
    if (options.lockauth_id != undefined && options.lockauth_id >0) {
      lockauth_id = options.lockauth_id
      that.setData({
        lockauth_id: lockauth_id
      });
    }
    if (options.user_id != undefined && options.user_id >0) {
      user_id = options.user_id
      that.setData({
        user_id: user_id
      });
    }
    var date = new Date();
    var timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;
    var today = that.timestampToTime(timestamp,'Y-m-d',0);
    var nowdate = that.timestampToTime(timestamp,'Y-m-d H:i:s',0);
    var enddate = that.timestampToTime(timestamp, 'Y-m-d H:i:s',1);
    //console.log('today:'+today);
    //console.log('nowdate:'+nowdate);
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,nowdate);
    that.setData({
      endtime: enddate,
      dateTime: obj.dateTime,
      dateTimeArray: obj.dateTimeArray
    });
  },
  lockcardsnInput:function(e){
    this.setData({
      lockcard_sn: e.detail.value
    });
  },
  lockcardusernameInput:function(e){
    this.setData({
      lockcard_username: e.detail.value
    });
  },
  lockcardremarkInput:function(e){
    this.setData({
      lockcard_remark: e.detail.value
    });
  },
  endDate: function(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex: dateTime,
      endtime: endtime
    });
  },
  bindScan(){
    //console.log('aaa');
    var that = this;
    wx.scanCode({
      onlyFromCamera: true, // 只允许从相机扫码
      scanType: "qrCode",
      success: (res) => {
        // res.result 是二维码扫码的结果
        that.setData({
          lockcard_sn: res.result
        });
      },
      fail: (res) => {
        wx.showToast({
          title: '扫码失败请重试',
          icon: 'none',
          mask: true, // 是否显示透明蒙层，防止触摸穿透
          duration: 2000
        });
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
    //console.log('thatdata');
    //console.log(that.data);
    var lockcard_sn = that.data.lockcard_sn;
    var lockcard_username = that.data.lockcard_username;
    var lockauth_id = that.data.lockauth_id;
    if (!lockcard_sn) {
      wx.showToast({
        title: '请输入卡号',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    if (!lockcard_username) {
      wx.showToast({
        title: '请输入持有人姓名',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    var postdata = {
      user_id: that.data.user_id,
      lock_id: that.data.lock_id,
      lockcard_sn: that.data.lockcard_sn,
      lockcard_username: that.data.lockcard_username,
      lockcard_remark: that.data.lockcard_remark,
      lockcard_endtime: that.data.endtime
    };
    if (lockauth_id>0) {
      postdata['lockauth_id'] = lockauth_id;
    }
    //console.log('postdata:')
    //console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/LockCard/addauthcard',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: postdata,
      success: function (res) {
        //console.log('doSubmit-res');
        //console.log(res);
        wx.hideLoading();
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          //wx.navigateBack({
           // delta: 1
         // });
           wx.navigateTo({
             url: '../cardlist/cardlist?lock_id='+that.data.lock_id
           });
        }
      }
    })
  },
  timestampToTime: function (timestamp,format,push) {
    if (timestamp == undefined || timestamp==0){
      return '';
    }
    var date = new Date(timestamp * 1000);
    if (push<1) {
      var Y = date.getFullYear() + '-';
    }else{
      var Y = date.getFullYear();
      Y = Y + 1;
      Y = Y + '-';
    }
    var m = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var d = date.getDate() < 10 ? '0'+date.getDate()+' ' : date.getDate()+' ';
    var H = date.getHours() < 10 ? '0'+date.getHours()+':' : date.getHours()+':';
    var i = date.getMinutes() < 10 ? '0'+date.getMinutes()+':' : date.getMinutes()+':';
    var s = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds();
    if (format == 'Y-m-d') {
      return Y+m+d;
    }
    return Y+m+d+H+i+s;
  }
})