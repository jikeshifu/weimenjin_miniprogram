const app = getApp()
Page({
  data: {
    menus: [
      // {
      //   "wservice_id":"2",
      //   "wservice_type":"1",
      //   "wservice_name":"开门记录",
      //   "wservice_appid":"",
      //   "wservice_url":"/pages/logs/logs",
      //   "wservice_icon":"https://wxapp.wmj.com.cn/uploads/admin/202101/5ff95acbeeecb.png"
      // }
    ],
    gridCol:3,
  },
  openurl: function(e) {
    var that = this;
    var index = e.currentTarget.dataset['index'];
    var menus = that.data.menus;
    console.log('index:'+index)
    if (menus[index] != undefined) {
      if (menus[index]['wservice_type'] == 1) { // 1内部小程序,2外部小程序,3外部页面
        wx.navigateTo({
          url: menus[index]['wservice_url']
        });
      }else if (menus[index]['wservice_type'] == 2) {
        var curversion = app.globalData.version;
        if (app.compareVersion(curversion,'1.3.0')) {
          // 基础库 1.3.0 开始支持，低版本需做
          wx.navigateToMiniProgram({
            appId: menus[index]['wservice_appid'],
            path: menus[index]['wservice_url'],
            extraData: {
            },
            // envVersion: 'develop',
            success(res) {
              // 打开成功
              console.log('success-res')
              console.log(res)
            },
            fail(res) {
              console.log('fail-res')
              console.log(res)
            },
          })
        }else{
          wx.showToast({
            title: '当前版本太低，请升级版本',
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      }else{
        wx.navigateTo({
          url: '../web/web?url='+menus[index]['wservice_url']
        })
      }
    }
  },
  onShow: function () {
    console.log('service-onShow');
    var that = this;
    wx.request({
      url: app.globalData.domain+'/api/Wservice/index',
      method: "POST",
      header:{
        "Authorization": app.globalData.token
      },
      data: {
      },
      success: function (res) {
        console.log(res);
        var arr = [];
        if (res.data.status == 200) {
          that.setData({
            menus: res.data.data.list
          });
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
  },
  onLoad: function () {
    // if (app.globalData.userid < 1) {
    //   wx.redirectTo({
    //     url: '../wxlogin/wxlogin'
    //   });
    // }
  },
  onShareAppMessage: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
      path: "/pages/index/index"
    };
  },
  onShareTimeline: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
    }
  }
})
