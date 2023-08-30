var dateTimePicker = require('../../utils/dateTimePicker.js');
let request = require('../../module/request/index');
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
    dateIndex: [1,1,0,0,0,0],
    dateTimeArray1: null,
    dateTime1: null,
    dateIndex1: [0,0,0,0,0,0],
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
  onShow:async function () {
    // //console.log('getkeys-onShow');
    var that = this;
    let getauthdetailbyid=  await request.HttpPost("LockAuth/getauthdetailbyid",{
      lockauth_id: that.data.lockauth_id
    }).catch(()=>{})

    if(!getauthdetailbyid){
      return
    }
    console.log("getauthdetailbyid",getauthdetailbyid)
    var result = getauthdetailbyid.data[0];
    var auth_starttime = that.timestampToTime(result.auth_starttime,'Y-m-d H:i:s');
    var auth_endtime = that.timestampToTime(result.auth_endtime,'Y-m-d H:i:s');
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,auth_starttime);
    var obj1 = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,auth_endtime);
    that.setData({
      dateIndex: obj.dateTime,
      dateIndex1: obj1.dateTime,
      nickname: result.nickname,
      mobile: result.mobile,
      starttime: auth_starttime,
      endtime: auth_endtime,
      shareability: result.auth_shareability, //1是可以分享,0不可分享
      isadmin: result.auth_isadmin, // 0不是管理员,1是管理员
      sharelimit: result.auth_sharelimit, //
      auth_status: result.auth_status, // 1通过审核,0未通过
      openlimit: result.auth_openlimit, // 可开次数
      user_id: result.auth_user_id, // 管理员id
      remark: result.remark //
    });

  },
  onLoad: function (options) {
    //console.log('getkeys-onload-options:');
    //console.log(options);
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
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,nowdate);
    var obj1 = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,enddate);
    // 精确到分的处理，将数组的秒去掉
    // var lastArray = obj1.dateTimeArray.pop();
    // var lastTime = obj1.dateTime.pop();

    that.setData({
      dateIndex: obj.dateTime,
      dateTimeArray: obj.dateTimeArray,
      dateTimeArray1: obj1.dateTimeArray,
      dateIndex1: obj1.dateTime
    });
  },
  // 查询可开门时间段
  getTimes: async function () {
    var that = this;

  let getopentimes=  await request.HttpPost("Locktimes/getopentimes",{
      lock_id: that.data.lock_id,
      limit: 100,
      page:1
    })
    if (!getopentimes){
      return
    }
    var arr = [];
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
    // //console.log('starttime')
    // //console.log(e);
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var starttime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex: dateTime,
      starttime: starttime
    });
  },
  endDate: function(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex1: dateTime,
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
  deleteKey:  function () {
    var that = this;
    var lockauth_id = that.data.lockauth_id;
    wx.showModal({
      title: '删除',
      content: '您确定要删除此条数据吗？',
      success :async (res) =>{
        if (res.confirm) {
          wx.showLoading({
            title: '执行中',
            mask: true
          });

      let LockAuthdelete=  await request.HttpPost("LockAuth/delete", {
            lockauth_ids: lockauth_id,
          }).catch(()=>{})
          if(!LockAuthdelete){
            return
          }
          console.log('deleteKey');
          console.log(resa)
          wx.hideLoading();
          wx.showToast({
            title: LockAuthdelete.data.msg,
            icon: 'success',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.navigateBack({
              delta: 1
            });
          },2000);
        } else if (res.cancel) {
          //console.log('用户点击取消')
        }
      }
    })
  },
  doSubmit: async function() {
    wx.showLoading({
      title: '执行中',
      mask: true
    })
    var that = this;
    let verifyauth = await request.HttpPost("LockAuth/verifyauth",{
      lockauth_id: that.data.lockauth_id, // 钥匙id
      auth_sharelimit: that.data.sharelimit,
      auth_openlimit: that.data.openlimit,
      auth_isadmin: that.data.isadmin,
      auth_starttime: that.data.starttime,
      auth_endtime: that.data.endtime,
      auth_shareability: that.data.shareability,
      auth_opentimes: that.data.opentimes,
      remark: that.data.remark,
      auth_status: that.data.auth_status,
      auth_member_id:app.globalData.userid
    }).catch(()=>{})
    if (!verifyauth){
      return
    }
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
