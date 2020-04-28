var dateTimePicker = require('../../utils/dateTimePicker.js');
const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    hidelood: false,
    lock_id: 0,
    user_id: 0, //锁管理员id
    date: '2018-10-01',
    time: '12:00',
    dateTimeArray: null,
    dateTime: null,
    dateTimeArray1: null,
    dateTime1: null,
    startYear: 2020,
    endYear: 2050,
    nickname: '张三',
    mobile: '18211110000',
    shareability:0,
    isadmin:0,
    sharelimit: 0,
    openlimit: 0,
    auth_status: 1,
    nowdate: '',
    starttime: '',
    endtime: '',
    opentimes: '', // 多个逗号分隔  可开时段
    remark: '',
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
      // that.getTimes();
      wx.request({
        url: app.globalData.domain+'/api/LockAuth/getauthdetailbyid',
        method: 'POST',
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          lockauth_id: that.data.lockauth_id
        },
        success: function (res) {
          console.log(res);
          if (res.data.status == 200) {
            var result = res.data.data[0];
            that.setData({
              nickname: result.nickname,
              mobile: result.mobile,
              starttime: that.timestampToTime(result.auth_starttime,'Y-m-d H:i:s'),
              endtime: that.timestampToTime(result.auth_endtime,'Y-m-d H:i:s'),
              shareability: result.auth_shareability, //1是可以分享,0不可分享
              isadmin: result.auth_isadmin, // 0不是管理员,1是管理员
              sharelimit: result.auth_sharelimit, //
              auth_status: result.auth_status, // 1通过审核,0未通过
              openlimit: result.auth_openlimit, // 可开次数
              user_id: result.auth_user_id, // 管理员id
              remark: result.remark //
            });
          }
        }
      })
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
    var enddate = that.timestampToTime(timestamp+3600*24*7, 'Y-m-d H:i:s');
    that.setData({
      nowdate: nowdate,
      starttime: nowdate,
      endtime: enddate
    });
    if (options.lockauth_id != undefined && options.lockauth_id >0) {
      that.setData({
        lockauth_id: options.lockauth_id
      });
    }
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear);
    var obj1 = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear);
    // 精确到分的处理，将数组的秒去掉
    // var lastArray = obj1.dateTimeArray.pop();
    // var lastTime = obj1.dateTime.pop();

    that.setData({
      dateTime: obj.dateTime,
      dateTimeArray: obj.dateTimeArray,
      dateTimeArray1: obj1.dateTimeArray,
      dateTime1: obj1.dateTime
    });
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
  nicknameDate: function(e) {
    this.setData({
      nickname: e.detail.value
    });
  },
  mobileDate: function(e) {
    this.setData({
      mobile: e.detail.value
    });
  },
  startDate: function(e) {
    console.log('starttime')
    console.log(e);
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var starttime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      starttime: starttime
    });
  },
  endDate: function(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      endtime: endtime
    });
  },
  sharelimitInput: function(e) {
    this.setData({
      sharelimit: e.detail.value
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
  shareabilityChange: function(e) {
    this.setData({
      shareability: e.detail.value ? 1 : 0
    });
  },
  isadminChange: function(e) {
    this.setData({
      isadmin: e.detail.value ? 1 : 0
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
  deleteKey: function () {
    var that = this;
    var lockauth_id = that.data.lockauth_id;
    wx.showModal({
      title: '删除',
      content: '您确定要删除此条数据吗？',
      success (res) {
        if (res.confirm) {
          wx.showLoading({
            title: '执行中',
            mask: true
          });
          wx.request({
            url: app.globalData.domain+'/api/LockAuth/delete',
            method: "POST",
            header:{
              "Authorization": app.globalData.token
            },
            data: {
              lockauth_ids: lockauth_id,
            },
            success: function (resa)
            {
              console.log('deleteKey');
              console.log(resa)
              wx.hideLoading();
              wx.showToast({
                title: '删除成功',
                icon: 'success',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
              setTimeout(function(){
                wx.navigateBack({
                  delta: 1
                });
              },2000);
            },
            fail: function (res) {
              wx.hideLoading();
              wx.showToast({
                title: '网络故障，请稍后重试',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          });
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  },
  doSubmit: function() {
    wx.showLoading({
      title: '执行中',
      mask: true
    })
    var that = this;
    wx.request({
      url: app.globalData.domain +'/api/LockAuth/verifyauth',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        lockauth_id: that.data.lockauth_id, // 钥匙id
        lock_id: that.data.lock_id,
        auth_sharelimit: that.data.sharelimit,
        auth_openlimit: that.data.openlimit,
        auth_isadmin: that.data.isadmin,
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
            title: '审核成功',
            icon: 'success',
            mask: false, // 此处允许触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.navigateBack({
              delta: 1
            });
          },2000);
        }else{
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: false, // 此处允许触摸穿透
            duration: 2000
          });
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