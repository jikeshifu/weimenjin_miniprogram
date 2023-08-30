var dateTimePicker = require('../../utils/dateTimePicker.js');
let request = require('../../module/request/index');
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
    lockcard_id: 0, // 门卡ID
  },
  onShow: async function () {
    //console.log('onShow')
    var that = this;
  let viewcarddetail= await  request.HttpPost("LockCard/viewcarddetail",{
      lockcard_id: that.data.lockcard_id
    }).catch(()=>{})
    if(!viewcarddetail){
      return
    }

    var card = viewcarddetail.data;
    var endtime = that.timestampToTime(card.lockcard_endtime,'Y-m-d H:i:s');
    var tmpobj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,endtime);
    that.setData({
      lockcard_username: card.lockcard_username,
      lockcard_remark: card.lockcard_remark,
      endtime: endtime,
      dateIndex: tmpobj.dateTime
    });


  },
  onLoad: function (options) {
    var that = this;
    var lockcard_id = that.data.lockcard_id;
    if (options.lockcard_id != undefined && options.lockcard_id >0) {
      lockcard_id = options.lockcard_id
      that.setData({
        lockcard_id: lockcard_id
      });
    }
    var timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;
    var nowdate = that.timestampToTime(timestamp,'Y-m-d H:i:s',0);
    var enddate = that.timestampToTime(timestamp, 'Y-m-d H:i:s',1);
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,enddate);
    that.setData({
      endtime: enddate,
      dateIndex: obj.dateTime,
      dateTimeArray: obj.dateTimeArray
    });
  },
  // lockcardsnInput:function(e){
  //   this.setData({
  //     lockcard_sn: e.detail.value
  //   });
  // },
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
  doSubmit: async function() {


    var that = this;

    var lockcard_username = that.data.lockcard_username;

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
      lockcard_id: that.data.lockcard_id,
      // lockcard_sn: that.data.lockcard_sn,
      lockcard_username: that.data.lockcard_username,
      lockcard_remark: that.data.lockcard_remark,
      lockcard_endtime: that.data.endtime
    };
    //console.log('postdata:')
    //console.log(postdata)
    let updatecard= await request.HttpPost("LockCard/updatecard",postdata).catch(()=>{})
    if (!updatecard){
      return
    }
    wx.showToast({
      title: updatecard.msg,
      icon: 'none',
      mask: true, // 防止触摸穿透
      duration: 2000
    });
    wx.navigateBack({
      delta: 1
    });

  },
  getDateIndex: function (time) {
    // time 是 Y-m-d H:i:s格式 2020-06-01 12:00:12
    if (time != undefined && time != '') {
      var Y = time.substr(0,4)+'';
      var m = time.substr(5,2)+'';
      var d = time.substr(8,2)+'';
      var H = time.substr(11,2)+'';
      var i = time.substr(14,2)+'';
      var s = time.substr(17,2)+'';
      var dateTimeArray = this.data.dateTimeArray;
      var timeobj = {"Y":0,"m":0,"d":0,"H":0,"i":0,"s":0};
      var indexarr = [];
      if (dateTimeArray) {
        for (var i = 0; i < dateTimeArray[0].length; i++) {
          if(Y===dateTimeArray[0][i]){
            //console.log(dateTimeArray[0][i]);
            timeobj['Y'] = i;
          }
        }
        for (var i = 0; i < dateTimeArray[1].length; i++) {
          if(m===dateTimeArray[1][i]){
            timeobj['m'] = i;
          }
        }
        for (var i = 0; i < dateTimeArray[2].length; i++) {
          if(d===dateTimeArray[2][i]){
            timeobj['d'] = i;
          }
        }
        for (var i = 0; i < dateTimeArray[3].length; i++) {
          if(H===dateTimeArray[3][i]){
            timeobj['H'] = i;
          }
        }
        for (var i = 0; i < dateTimeArray[4].length; i++) {
          if(i===dateTimeArray[4][i]){
            timeobj['i'] = i;
          }
        }
        for (var i = 0; i < dateTimeArray[5].length; i++) {
          if(s===dateTimeArray[5][i]){
            timeobj['s'] = i;
          }
        }
        var k;
        for (k in timeobj) {
          indexarr.push(timeobj[k]);
        }
        return indexarr;
      }else{
        return [0,0,0,0,0,0];
      }
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
