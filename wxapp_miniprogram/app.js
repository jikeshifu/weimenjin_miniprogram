//app.js
App({
  onLaunch: function () {
    // 展示本地存储能力
    // var logs = wx.getStorageSync('logs') || []
    // var logs = wx.getStorageSync('logs') || '';
    // logs.unshift(Date.now())
    // wx.setStorageSync('logs', logs)
    console.log('app.js-onLaunch');
    var that = this;
    var version = wx.getSystemInfoSync().SDKVersion;
    this.globalData.version = version;
    // 登录
    wx.login({
      success: res => {
        // 发送 res.code 到后台换取 openId, sessionKey, unionId
        // //console.log(res.code);
        if (res.code) {
          wx.getUserInfo({
            success: resuser => {
              console.log('getUserInfo-resuser')
              console.log(resuser)
              // 可以将 res 发送给后台解码出 unionId
              this.globalData.userInfo = resuser.userInfo
              //发起网络请求
              wx.request({
                url: this.globalData.domain+'/api/Member/login',
                data: {
                  code: res.code,
                  encryptedData: resuser.encryptedData,
                  iv: resuser.iv
                },
                method: 'POST',
                success: function (resa) {
                  //console.log('app.js-login-resa');
                  //console.log(resa);
                  if (resa.data.status == 200) {
                    that.globalData.token = resa.data.token;
                    that.globalData.userid = resa.data.data.member_id;
                    that.globalData.openid = resa.data.data.openid;
                    that.globalData.phone = resa.data.data.mobile;
                  }
                  // if (resa.data.data.useradmininfo.user_id != undefined) {
                  //   that.globalData.user_id = resa.data.data.useradmininfo.user_id;
                  // }else{}
                  var tmpdata3 = {member_id: resa.data.data.member_id};
                  console.log('app.js-onLaunch-login-tmpdata3')
                  console.log(tmpdata3)
                  wx.request({
                    url: that.globalData.domain+'/api/Member/viewuserid',
                    method: 'POST',
                    header:{
                      "Authorization": resa.data.token
                    },
                    data: {
                      member_id: resa.data.data.member_id
                    },
                    success: function (resb) {
                      console.log('app.js-onLaunch-login-resb');
                      console.log(resb);
                      if (resb.data.status == 200) {
                        var tmpuser_id = resb.data.data.user_id;
                        if (tmpuser_id != '') {
                          that.globalData.user_id = resb.data.data.user_id;
                          that.globalData.adminInfo = resb.data.data;
                        }
                      }
                    }
                  })
                }
              })
            },
            fail: resuser => {
              console.log('fail-resuser')
              console.log(resuser)
            }
          })
        }
      }
    })
  },
  globalData: {
    token: '', // 用户token
    phone: '', // 用户绑定的手机号
    domain: 'https://wxapp.wmj.com.cn',
    xcxname:'微门禁',
    shareImg: '/static/img/shareimg.jpg',
    userInfo: null,
    ishas: false,   // 默认没有微信用户信息
    openid: '',
    userid: 0,      // 自己的用户id  即member_id
    user_id: 0,     // 管理员id
    lock_id: 0,     // 扫码开的锁id
    adminInfo:null, // 管理员信息
    sessionkey: '',
    version: '',
    successimg: '',
    successadimg: '',
    openadurl: '',
    adnum: 1, // 显示开门成功样式几： 1原来的两张图片的,2新的只显示一张图片的
    qrshowminiad: false,
  },
  compareVersion: function(v1, v2) { // 1是v1>v2,0是v1=v2,-1是v1<v2
    v1 = v1.split('.');
    v2 = v2.split('.');
    const len = Math.max(v1.length, v2.length);
    while (v1.length < len) {
      v1.push('0');
    }
    while (v2.length < len) {
      v2.push('0');
    }
    for (let i = 0; i < len; i++) {
      const num1 = parseInt(v1[i]);
      const num2 = parseInt(v2[i]);
      if (num1 > num2) {
        return 1;
      } else if (num1 < num2) {
        return -1;
      }
    }
    return 0;
  },
})