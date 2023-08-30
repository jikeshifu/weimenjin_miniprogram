var dateTimePicker = require('../../../utils/dateTimePicker.js');
var request = require('../../../module/request/index');
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
    formData:{
      lock_id:0,
      finger_id:0,
      finger_name:"",
      end_time:""
    },
  },
  onShow:function () {
    //console.log('addlock-onShow')
    var that = this;

  },
  onLoad:async function (options) {



    var timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;

    var nowdate = this.timestampToTime(timestamp,'Y-m-d H:i:s',0);
    var enddate = this.timestampToTime(timestamp, 'Y-m-d H:i:s',1);
    //console.log('today:'+today);
    //console.log('nowdate:'+nowdate);
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(this.data.startYear, this.data.endYear,nowdate);
    let formData =this.data.formData
    formData.lock_id=options.lock_id
    formData.finger_id=options.finger_id
    let info= await request.HttpPost("device.Finger/info",{
      finger_id: options.finger_id
    })
    console.log("info", info)


    formData.finger_name=info.data.finger_name
    formData.finger_id= options.finger_id
    formData.finger_id= options.finger_id
    formData.end_time= info.data.end_time
    formData.lock_id= info.data.lock_id
    enddate = this.timestampToTime(info.data.end_time, 'Y-m-d H:i:s',0);

    this.setData({
      formData:formData,
      endtime: enddate,
      dateTime: obj.dateTime,
      dateTimeArray: obj.dateTimeArray
    });
  },
  pwdNameSet:function(e){

    let formData =this.data.formData
    formData.finger_name=e.detail.value
    this.setData({
      formData: formData
    });
  },
  pwdSet:function(e){

    let formData =this.data.formData
    formData.pwd=e.detail.value
    this.setData({
      formData: formData
    });
  },
  endDate: function(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    let formData =this.data.formData
    formData.end_time=endtime
    this.setData({
      dateIndex: dateTime,
      endtime: endtime,
      formData: formData,
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
  doSubmit :async function() {

    wx.showLoading({
      title: '执行中',
      mask: true
    })
    console.log("this.data.formData",this.data.formData)

    if (!this.data.formData.finger_name) {
      wx.showToast({
        title: '请输入持有人姓名',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    let pwdAdd = await request.HttpPost("device.Finger/edit", this.data.formData)
    if(pwdAdd){
      wx.redirectTo({
        url: '../fingerList?lock_id=' + this.data.formData.lock_id
      })
    }
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
