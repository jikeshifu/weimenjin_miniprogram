const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    hidelood: false,
    nodata: false,
    listarr: [],
    page: 1,
    num: 20,
    scrollHeight: 0,
    registerArr: ['村居(物业)','村居(物业)','乡镇社区','区县','交通运输'], // 登记类型 默认1村居(物业),2乡镇社区,3区县,4交通运输
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: []
    })
    if (app.globalData.userid) {
      this.getmore(1, this.data.num);
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
      this.getmore(curpage,num);
    }
  },
  onShow:function () {
    console.log('healthlist-onShow')
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });
    wx.showLoading({
      title: '正在加载',
      mask: true
    })
    if (app.globalData.userid){
      if (that.data.listarr.length <1) {
        that.getmore(1,that.data.num);
      } else {
        wx.hideLoading();
      }
    } else {
      wx.hideLoading();
    }
  },
  getmore: function(page,num){
    var that = this;
    if (page == undefined) {
      page = 1;
    }
    if (num == undefined) {
      num = 20;
    }
    that.setData({
      page: page
    });
    if (app.globalData.userid) {
      wx.request({
        url: app.globalData.domain+'/api/Health/list',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          openid: app.globalData.openid,
          limit: num,
          page: page,
        },
        success: function (resa) {
          console.log('getmore-success-resa');
          console.log(resa);
          wx.hideLoading();
          var arr = [];
          if (resa.data.status == 200) {
            var arrdata = resa.data.data.list
            if(arrdata && arrdata.length > 0){
              for (var i = 0; i < arrdata.length; i++) {
                arrdata[i]['create_time'] = that.timestampToTime(arrdata[i]['create_time']);
                arrdata[i]['register_type'] = that.data.registerArr[arrdata[i]['register_type']];
                arr.push(arrdata[i]);
              }
              var newdata = that.data.listarr.concat(arr);
              that.setData({
                listarr: newdata,
                hidelood: false
              });
            }else{
              that.setData({
                hidelood: false,
                nodata: true
              });
            }
          }
        },
        fail: function (res) {
          wx.showToast({
            title: '网络故障，请稍后重试',
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      });
    }
  },
  scrollfun: function(){
    //
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