const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    lock_id: 0,
    lock_qrcode: '',
    lock_sn: '',
    configlcd: 0, // 显示设置到显示屏
    addcardmode: 1, // 1为进入发卡模式，默认2为退出发卡模式
    btnstr: '进入发卡模式' // addcardmode为1时是“进入发卡模式”，为2时是“退出发卡模式”
  },
  onShow:function () {
    //console.log('lock-onShow');
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      wx.request({
        url: app.globalData.domain+'/api/Lock/view',
        method: 'POST',
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          lock_id: that.data.lock_id
        },
        success: function (res) {
          //console.log(res);
          if (res.data.status == 200) {
            var result = res.data.data;
            var tmplock_sn = result.lock_sn;
            var tmpconfiglcd = 0;
            if (tmplock_sn.indexOf("WMJ62") >=0) { // 只有WMJ62的支持
              tmpconfiglcd = 1;
            }
            var tmpaddcardmode = result.addcardmode;
            if (tmpaddcardmode == 2) {
              tmpaddcardmode = 1;
              var tmpbtnstr = '进入发卡模式';
            }else{
              tmpaddcardmode = 2;
              var tmpbtnstr = '退出发卡模式';
            }
            that.setData({
              lock_qrcode: result.lock_qrcode,
              lock_sn: result.lock_sn,
              configlcd: tmpconfiglcd,
              addcardmode: tmpaddcardmode,
              btnstr: tmpbtnstr
            });
          }
        }
      })
    }
  },
  onLoad: function (options) {
    //console.log('lock-onload-options:');
    //console.log(options);
    var that = this;
    if (options.lock_id != undefined && options.lock_id >0) {
      that.setData({
        lock_id: options.lock_id
      });
    }
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
    var postdata = {
      // user_id: that.data.user_id,
      lock_id: that.data.lock_id
    };
    //console.log('postdata:')
    //console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/Lock/configlcd',
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
          setTimeout(function(){
            wx.navigateBack({
             delta: 1
            });
          },2000);
          // wx.navigateTo({
          //   url: '../cardlist/cardlist?lock_id='+that.data.lock_id
          // });
        }
      }
    })
  },
  // 进入/退出发卡模式
  devaddcard() {
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
    var tmpaddcardmode = that.data.addcardmode;
    var postdata = {
      addcardmode: tmpaddcardmode,
      lock_id: that.data.lock_id
    };
    //console.log('postdata:')
    //console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/Lock/devaddcard',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: postdata,
      success: function (res) {
        //console.log('devaddcard-res');
        //console.log(res);
        wx.hideLoading();
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          if (tmpaddcardmode == 2) {
            tmpaddcardmode = 1;
            var tmpbtnstr = '进入发卡模式';
          }else{
            tmpaddcardmode = 2;
            var tmpbtnstr = '退出发卡模式';
          }
          that.setData({
            addcardmode: tmpaddcardmode,
            btnstr: tmpbtnstr
          });
        }
      }
    })
  }
})