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
  },
  globalData: {
    token: '', // 用户token
    phone: '', // 用户绑定的手机号
    domain: 'https://wx.wmj.com.cn',
    xcxname:'微门禁',
    shareImg: '/static/img/shareimg.jpg',
    userInfo: null,
    nickname: '未登录游客', // 微信昵称
    headimgurl: 'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132', // 微信头像
    defaultimg: 'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132', // 微信错误头像
    avatarUrl:'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132',
    gender:'0',
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