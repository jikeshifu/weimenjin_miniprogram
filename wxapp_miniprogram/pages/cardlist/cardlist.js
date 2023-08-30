var dateTimePicker = require('../../utils/dateTimePicker.js');
let request = require('../../module/request/index');
const app = getApp()
Page({
  data: {
    search: '../../images/search.png',
    avatar: '../../images/avatar.png',
    looding: '../../images/looding.gif',
    hidelood: false,
    nodata: false,
    listarr: [],
    listlen: 1,
    page: 1,
    num: 20,
    dateTimeArray: null,
    dateTime: null,
    dateIndex: [0,0,0,0,0,0],
    dateTimeArray1: null,
    dateTime1: null,
    dateIndex1: [0,0,0,0,0,0],
    startYear: 2020,
    endYear: 2050,
    scrollHeight: 0,
    close: true, //弹层是否关闭 false不关闭
    lock_id: 0, // 锁id
    lockauth_id: 0, // 钥匙ID，当传此值时查询当前钥匙下绑定的卡
    keyword: '', // 搜索关键词
    create_time: '', // 开始时间
    end_time: '' // 结束时间
  },
  startSearch(){
    this.setData({
      close: false
    })
  },
  keywordInput(e) {
    this.setData({
      keyword: e.detail.value
    })
  },
  startDate(e) {
    var dateTimeArray = this.data.dateTimeArray;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex: dateTime,
      create_time: endtime
    });
  },
  endDate(e) {
    var dateTimeArray = this.data.dateTimeArray1;
    var dateTime = e.detail.value;
    var endtime = dateTimeArray[0][dateTime[0]]+'-'+dateTimeArray[1][dateTime[1]]+'-'+dateTimeArray[2][dateTime[2]]+' '+dateTimeArray[3][dateTime[3]]+':'+dateTimeArray[4][dateTime[4]]+':'+dateTimeArray[5][dateTime[5]];
    this.setData({
      dateIndex1: dateTime,
      end_time: endtime
    });
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: [],
      listlen: 1  //
    })
    if (app.globalData.userid) {
      this.getmore(1, this.data.num,0);
    }
    setTimeout(function(){
      if (wx.stopPullDownRefresh) {
        wx.stopPullDownRefresh();
      }
    },3000);
  },
  scrolltoupper: function(){
    //
  },
  scrolltolower: function(){
    this.setData({
      hidelood: true
    });
    var curpage = this.data.page +1;
    var num = this.data.num;
    if (app.globalData.userid){
      this.getmore(curpage,num,1);
    }
  },
  onShow:function () {
    //console.log('openlogs-onShow')
    // //console.log(app.globalData.userid)
    var that = this

      wx.showLoading({
        title: '正在加载',
        mask: true
      })
    if (that.data.listarr.length <1) {
      that.getmore(1,that.data.num,0);
    } else {
      wx.hideLoading();
    }

  },
  onLoad: function (options) {
    var that = this;
    if (options.lock_id != undefined && options.lock_id >0) {
      that.setData({
        lock_id: options.lock_id
      });
    }
    if (options.lockauth_id != undefined && options.lockauth_id >0) {
      that.setData({
        lockauth_id: options.lockauth_id
      });
    }
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });
    var timestamp = Date.parse(new Date());
    timestamp = timestamp/1000;
    var nowdate = that.timestampToTime(timestamp,'Y-m-d H:i:s');
    // 获取完整的年月日 时分秒，以及默认显示的数组
    var obj = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,nowdate);
    var obj1 = dateTimePicker.dateTimePicker(that.data.startYear, that.data.endYear,nowdate);
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
  getmore: async function(page,num,addto){ // addto为0覆盖原有数据，为1在原有数据基础上追加数据
    var that = this;
    wx.showLoading({
      title: '正在加载',
      mask: true
    });
    if (page == undefined) {
      page = 1;
    }
    if (num == undefined) {
      num = 20;
    }
    that.setData({
      page: page
    });
    let getcardlistbylockid= await request.HttpPost("LockCard/getcardlistbylockid", {
      lock_id: that.data.lock_id,
      limit: num,
      page: page,
      keyword: that.data.keyword,
      create_time: that.data.create_time,
      end_time: that.data.end_time,
    })
    if(!getcardlistbylockid){
      return
    }
    var arr = [];
    var arrdata = getcardlistbylockid.data.list
    if(arrdata && arrdata.length > 0){
      for (var i = 0; i < arrdata.length; i++) {
        var tmpobj = {};
        tmpobj['lockcard_endtime'] = that.timestampToTime(arrdata[i]['lockcard_endtime'])
        tmpobj['lockcard_sn'] = arrdata[i]['lockcard_sn'];
        tmpobj['lockcard_id'] = arrdata[i]['lockcard_id'];
        tmpobj['lock_id'] = arrdata[i]['lock_id'];
        tmpobj['lockauth_id'] = arrdata[i]['lockauth_id'];
        tmpobj['lockcard_username'] = arrdata[i]['lockcard_username'];
        tmpobj['headimgurl'] = arrdata[i]['headimgurl'] ? arrdata[i]['headimgurl'] :that.data.avatar;
        // tmpobj['lock_id'] = arrdata[i]['lock_id'];
        // tmpobj['user_id'] = arrdata[i]['user_id']; // 锁的管理员id
        arr.push(tmpobj);
      }
      if (addto>0) {
        var newdata = that.data.listarr.concat(arr);
      }else{
        var newdata = arr;
      }
      var tmplistlen = newdata.length;
      that.setData({
        listarr: newdata,
        hidelood: false,
        listlen: tmplistlen
      });
    }else{
      if (addto<1) { // 不追加,覆盖
        var newdata = arr;
        var tmplistlen = arr.length;
      }else{
        var newdata = that.data.listarr; // 追加，但是没有查到数据，赋值原来的数据
        var tmplistlen = that.data.listarr.length;
      }
      that.setData({
        listarr: newdata,
        hidelood: false,
        nodata: true,
        listlen: tmplistlen
      });
    }


  },
  scrollfun: function(){
  },
  // 执行搜索
  doSearch: function(e) {
    var that = this;
    that.getmore(1,that.data.num,0);
    that.closemask();
  },
  closemask:function(){
    this.setData({
      close:true,
      keyword: '',
      create_time: '',
      end_time:''
    })
  },
  faCard: function (e) {
    var lockcardid = e.currentTarget.dataset['lockcardid'];
    wx.navigateTo({
      url: '../facard/facard?lockcard_id='+lockcardid
    })
  },
  editCard: function (e) {
    var lockcardid = e.currentTarget.dataset['lockcardid'];
    wx.navigateTo({
      url: '../editcard/editcard?lockcard_id='+lockcardid
    })
  },
  deleteCard: async function (e) {
    var that = this;
    var lockcardid = e.currentTarget.dataset['lockcardid']; //
    wx.showModal({
      title: '删除',
      content: '您确定要删除此卡片吗？',
      success:async (res)=> {
        if (res.confirm) {
          //console.log(lockcardid)
          wx.showLoading({
            title: '执行中',
            mask: true
          });
       let delcard= await  request.HttpPost("LockCard/delcard",{
            lockcard_ids: lockcardid,
          }).catch(()=>{})
          if (!delcard){
            return
          }
          wx.showToast({
            title: '删除成功',
            icon: 'success',
            mask: true, // 防止触摸穿透
            duration: 2000
          });

          that.getmore(1,that.data.num,0);

        } else if (res.cancel) {
          //console.log('用户点击取消')
        }
      }
    })
  },
  timestampToTime: function (timestamp) {
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
    return Y+m+d+H+i+s;
  }
})
