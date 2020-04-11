const app = getApp()
Page({
  data: {
    userInfo: {}
  },
  onShow:function () {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function () {
    console.log('bindphone-onLoad');
    console.log(app.globalData);
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo
      })
    }
  },
  getPhoneNumber: function (e) {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      });
      return false;
    }
    var that = this;
    console.log('getPhoneNumber-e');
    console.log(e);
    console.log(app.globalData)
    if (e.detail.errMsg == "getPhoneNumber:ok") {
      wx.login({
        success: res => {
          console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
              encryptedData: e.detail.encryptedData,
              iv: e.detail.iv,
              code: res.code
            },
            method: "post",
            success: function (resa) {
              console.log('getphonenumber-resa');
              console.log(resa);
              var phone = resa.data.phoneNumber;
              app.globalData.phone = phone;
              var dataobj = {
                  member_id: app.globalData.userid,
                  nickname: app.globalData.userInfo.nickName,
                  headimgurl: app.globalData.userInfo.avatarUrl,
                  openid: app.globalData.openid,
                  mobile: phone,
                  sex: app.globalData.userInfo.gender
                };
                console.log('dataobj')
                console.log(dataobj);
              wx.request({
                url: app.globalData.domain+'/api/Member/update',
                method: "post",
                header:{
                  "Authorization": app.globalData.token
                },
                data: dataobj,
                success: function (resb) {
                  console.log('update-resb');
                  console.log(resb);
                  wx.showToast({
                    title: resb.data.msg,
                    icon: 'none',
                    mask: true, // 防止触摸穿透
                    duration: 2000
                  });
                  if (resb.data.status ==200) {
                    setTimeout(function(){
                      wx.switchTab({
                        url: '../index/index'
                      })
                    },2000);
                  }
                }
              })
            }
          })
        }
      })
    }
  }
})
