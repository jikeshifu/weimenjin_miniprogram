var dateTimePicker = require('../../utils/dateTimePicker.js');
const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    hidelood: false,
    lock_id: 0,
    user_id: 0, //锁管理员id
    dateTimeArray: null,
    dateTime: null,
    dateIndex: [0,0,0,0,0,0],
    dateTimeArray1: null,
    dateTime1: null,
    dateIndex1: [0,0,0,0,0,0],
    startYear: 2020,
    endYear: 2050,
    sharelimit: 0,
    openlimit: 0,
    nowdate: '',
    starttime: '2020-01-01',
    endtime: '2090-01-01',
    shareability: 0,
    opentimes: '', // 多个逗号分隔  可开时段
    remark: '',
    auth_status: 1,
    isshare: false, // true显示立即分享按钮
    lockauth_id: 0,  // 生成的钥匙id
    opentimesarr: []
  },
  onShow:function () {
    console.log('getkeys-onShow');
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      that.getTimes();
    }
  },
  onLoad: function (options) {
    console.log('getkeys-onload-options:');
    console.log(options);
    var that = this;
    var date = new Date();
    var timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;
    var nowdate = that.timestampToTime(timestamp,'Y-m-d H:i:s');
    var enddate = that.timestampToTime(timestamp+31536000, 'Y-m-d H:i:s');
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,nowdate);
    var obj1 = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,enddate);
    // 精确到分的处理，将数组的秒去掉
    // var lastArray = obj1.dateTimeArray.pop();
    // var lastTime = obj1.dateTime.pop();
    that.setData({
      dateIndex: obj.dateTime,
      dateTimeArray: obj.dateTimeArray,
      dateTimeArray1: obj1.dateTimeArray,
      dateIndex1: obj1.dateTime,
      nowdate: nowdate,
      starttime: nowdate,
      endtime: enddate
    });
    if (options.lock_id != undefined && options.lock_id >0) {
      that.setData({
        lock_id: options.lock_id
      });
    }
    if (options.user_id != undefined && options.user_id >0) {
      that.setData({
        user_id: options.user_id //锁管理员id
      });
    }
  },
  // 查询可开门时间段
  getTimes: function () {
    var that = this;
    wx.request({
      url: app.globalData.domain+'/api/Locktimes/getopentimes',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        lock_id: that.data.lock_id,
        limit: 100,
        page:1
      },
      success: function (res) {
        // console.log('getTimes-res');
        // console.log(res);
        var arr = [];
        if (res.data.status == 200) {
          var arrdata = res.data.data.list
          if(arrdata.length > 0){
            for (var i = 0; i < arrdata.length; i++) {
              arrdata[i]['id'] = arrdata[i]['locktimes_id'];
              arrdata[i]['name'] = arrdata[i]['locktimesname'];
              arr.push(arrdata[i]);
            }
          }
          that.setData({
            opentimesarr: arr
          });
        }
      }
    })
  },
  startDate(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex: dateTime,
      starttime: endtime
    });
  },
  endDate(e) {
    var dateTimeArray = this.data.dateTimeArray1;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex1: dateTime,
      endtime: endtime
    });
  },
  sharelimitChange: function(e) {
    this.setData({
      sharelimit: e.detail.value ? 1 : 0
    });
  },
  openlimitInput: function(e) {
    this.setData({
      openlimit: e.detail.value
    });
  },
  shareabilityChange: function(e) {
    this.setData({
      shareability: e.detail.value ? 1 : 0
    });
  },
  remarkInput: function(e) {
    this.setData({
      remark: e.detail.value
    });
  },
  statusChange: function(e) {
    this.setData({
      auth_status: e.detail.value ? 1 : 0
    });
  },
  checkboxChange: function(e) {
    var arr = e.detail.value;
    var str = '';
    if (arr.length>0) {
      str = arr.join();
    }
    this.setData({
      opentimes: str
    });
  },
  onShareAppMessage: function (e) {
    var lockauth_id = this.data.lockauth_id;
    console.log('lockauth_id:'+lockauth_id)
    return {
      title: '点击领取钥匙', // 转发后 所显示的title
      path: '/pages/getkeys/getkeys?member_id='+app.globalData.userid+'&lockauth_id='+lockauth_id, // 相对的路径
      imageUrl: ''//that.data.successimg
    }
  },
  getkey: function() {
    wx.showLoading({
      title: '生成钥匙中',
      mask: true
    })
    var that = this;
    wx.request({
      url: app.globalData.domain +'/api/LockAuth/shareauth',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        user_id: that.data.user_id, // 锁的管理员id
        lock_id: that.data.lock_id,
        auth_member_id: app.globalData.userid,
        auth_sharelimit: that.data.sharelimit,
        auth_openlimit: that.data.openlimit,
        auth_starttime: that.data.starttime,
        auth_endtime: that.data.endtime,
        auth_shareability: that.data.shareability,
        auth_opentimes: that.data.opentimes,
        remark: that.data.remark,
        auth_status: that.data.auth_status
      },
      success: function (res) {
        console.log('getkey-res');
        console.log(res);
        wx.hideLoading();
        if (res.data.status ==200) {
          wx.showToast({
            title: '生成钥匙成功',
            icon: 'success',
            mask: false, // 此处允许触摸穿透
            duration: 2000
          });
          that.setData({
            isshare:true,
            lockauth_id: res.data.data
          })
        }
      }
    })
  },
  timestampToTime: function (timestamp,format) {
    if (timestamp == undefined || timestamp==0){
      return '';
    }
    var date = new Date(timestamp * 1000);
    var Y = date.getFullYear() + '-';
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