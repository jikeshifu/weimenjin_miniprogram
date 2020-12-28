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
    lock_id: '0', // 这个卡片对应的锁id，不更新，剔除这张卡
    lockauth_id: 0, // 这张卡对应的钥匙id，添加卡时统一用这个
    lockcard_id: 0, // 门卡ID
    lockarr: [], // {"lock_id":1,"lock_name":"设备1","lockauth_id":"1"}
    lock_user_arr: [], // lock_id=>user_id
    selectLockid: [], // 选中的门禁id
  },
  onShow:function () {
    //console.log('onShow')
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      wx.request({
        url: app.globalData.domain+'/api/LockCard/viewcarddetail',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          lockcard_id: that.data.lockcard_id
        },
        success: function (resa) {
          //console.log('onShow-success-resa');
          //console.log(resa);
          //wx.hideLoading();
          if (resa.data.status == 200) {
            var card = resa.data.data;
            var endtime = that.timestampToTime(card.lockcard_endtime,'Y-m-d H:i:s');
            var tmpobj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,endtime);
            that.setData({
              lockcard_sn: card.lockcard_sn,
              lockcard_username: card.lockcard_username,
              lockcard_remark: card.lockcard_remark,
              lock_id: card.lock_id,
              endtime: endtime,
              dateIndex: tmpobj.dateTime
            });
          }
          that.getLock();
        },
        fail: function (res) {
          // wx.hideLoading();
        }
      });
    }
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
  checkboxChange: function(e) {
    var arr = e.detail.value;
    //console.log('checkboxChange-arr')
    //console.log(arr)
    this.setData({
      selectLockid: arr
    });
  },
  getLock: function () {
    var that = this;
    var lock_id = that.data.lock_id;
    wx.request({
      url: app.globalData.domain+'/api/LockAuth/getauthlistbymemid',
      method: "POST",
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: app.globalData.userid,
        limit: 100,
        page: 1,
      },
      success: function (resa) {
        //console.log('getLock-success-resa');
        //console.log(resa);
        var arr = [];
        var tmplock_user_arr = {};
        if (resa.data.status == 200) {
          var arrdata = resa.data.data.list
          if(arrdata.length > 0){
            var timestamp = Date.parse(new Date())/1000;
            for (var i = 0; i < arrdata.length; i++) {
              var tmplockidstr = 'l'+ arrdata[i]['lock_id'];
              var tmpobj = {};
              tmpobj['lock_name'] = arrdata[i]['lock_name'];
              tmpobj['online'] = arrdata[i]['online'] == 1 ? true : false;
              tmpobj['lockauth_id'] = arrdata[i]['lockauth_id'];
              tmpobj['lock_id'] = arrdata[i]['lock_id'];
              tmpobj['user_id'] = arrdata[i]['user_id']; // 锁的管理员id
              if ('1' == arrdata[i]['auth_isadmin']+'' && arrdata[i]['lock_id'] != lock_id) {
                arr.push(tmpobj);
                tmplock_user_arr[tmplockidstr] = arrdata[i]['user_id'];// 锁的管理员id
              }
            }
            that.setData({
              lockarr: arr,
              lock_user_arr: tmplock_user_arr
            });
          }
        }
      },
      fail: function (res) {
        wx.hideLoading();
        // wx.showToast({
        //   title: '网络故障，请稍后重试',
        //   icon: 'none',
        //   mask: true, // 防止触摸穿透
        //   duration: 2000
        // });
      }
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
  addCard: function (postdata) {
    var that = this;
    //console.log('addCard-postdata:')
    //console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/LockCard/addauthcard',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: postdata,
      success: function (res) {
        //console.log('addCard-res');
        //console.log(res);
        if (res.data.status ==200) {
          return true;
        }
      }
    })
    return false;
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
    var lockcard_username = that.data.lockcard_username;
    var lockauth_id = that.data.lockauth_id;
    if (!lockcard_username) {
      wx.showToast({
        title: '请输入持有人姓名',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    var selectLockid = that.data.selectLockid;
    var lock_user_arr = that.data.lock_user_arr;
    //console.log('doSubmit-lock_user_arr')
    //console.log(lock_user_arr)
    var fanum = selectLockid.length;
    //console.log('fanum:'+fanum);
    var hasfanum = 0;
    var aaa = setInterval(function(){
        if (hasfanum < fanum) {
          var tmplock_id = selectLockid[hasfanum];
          //console.log('tmplock_id:'+tmplock_id);
          //console.log('hasfanum1:'+hasfanum);
          var tmplockidstr = 'l'+tmplock_id;
          var postdata = {
            lockauth_id: that.data.lockauth_id,
            lockcard_sn: that.data.lockcard_sn,
            lockcard_username: that.data.lockcard_username,
            lockcard_remark: that.data.lockcard_remark,
            lockcard_endtime: that.data.endtime
          };
          postdata['user_id'] = lock_user_arr[tmplockidstr];
          postdata['lock_id'] = tmplock_id;
          var fares = that.addCard(postdata);
          hasfanum = hasfanum + 1;
          //console.log('hasfanum2:'+hasfanum);
        }else{
          //console.log('clear');
          clearInterval(aaa);  //清除定时器
          wx.hideLoading();
          wx.showToast({
            title: '发卡成功',
            icon: 'success',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
        //console.log('这是定时器，每隔一定时间执行一次');
    },1000);
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