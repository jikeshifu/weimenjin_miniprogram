const app = getApp();
Page({
  data: {
    regpointname: '', // 登记点名称
    locknameArr: ["请选择门锁"], // 钥匙名
    lockidArr: [0], // 钥匙id
    lockIndex: 0, // 钥匙下标
    lock_id: 0  // 锁id，默认0
  },
  onShow:function () {
    var that = this;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    if (app.globalData.user_id < 1) {
      wx.redirectTo({
        url: '../adduser/adduser'
      })
      return false;
    }
    wx.request({
      url: app.globalData.domain+'/api/LockAuth/getauthlistisadmin',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: app.globalData.userid
      },
      success: function (res) {
        //console.log('getauthlistisadmin-res');
        //console.log(res);
        var tmpnamearr = ["请选择门锁"];
        var tmpidarr = [0];
        if (res.data.status == 200) {
          var arrdata = res.data.data.list
          if(arrdata.length > 0){
            for (var i = 0; i < arrdata.length; i++) {
              tmpnamearr.push(arrdata[i]['lock_name']);
              tmpidarr.push(arrdata[i]['lock_id']);
            }
          }
          //console.log(tmpnamearr);
          //console.log(tmpidarr);
          that.setData({
            locknameArr: tmpnamearr,
            lockidArr: tmpidarr
          });
        }
      }
    })
  },
  onLoad: function (options) {
  },
  nameInput:function(e){
    this.setData({
      regpointname: e.detail.value
    });
  },
  lockChange(e) {
    //console.log(e);
    var tmpindex = e.detail.value;
    this.setData({
      lock_id: this.data.lockidArr[tmpindex],
      lockIndex:tmpindex
    })
  },
  uploadData() {
    // var timestamp = Date.parse(new Date());
    // timestamp = timestamp /1000;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    if (app.globalData.user_id < 1) {
      wx.redirectTo({
        url: '../adduser/adduser'
      })
      return false;
    }
    var that = this;
    //console.log(that.data);
    var regpointname = that.data.regpointname;
    if (!regpointname) {
      wx.showToast({
        title: '请输入登记点名称',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    //console.log('lock_id:'+that.data.lock_id);
    wx.request({
      url: app.globalData.domain+'/api/Regpoint/add',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        regpointname: regpointname,
        member_id: app.globalData.userid,
        user_id: app.globalData.user_id,
        lock_id: that.data.lock_id,
        regpointurl: 'https://wxapp.wmj.com.cn/miniprogram?user_id='
      },
      success: function (res) {
        //console.log('uploadData-res');
        //console.log(res);
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          setTimeout(function(){
            wx.navigateTo({
              url: '../regpointlist/regpointlist'
            })
          },2000);
        }
      }
    })
  }
})