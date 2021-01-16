const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
  },
  onLoad: function () {
    var that = this;
  },
  tourl: function () {
    var curversion = app.globalData.version;
    if (app.compareVersion(curversion,'1.3.0')) {
      // 基础库 1.3.0 开始支持，低版本需做
      wx.navigateToMiniProgram({
        appId: 'wxfa309773f6845379',
        path: 'pages/index/index?id=123',
        extraData: {
          foo: 'bar'
        },
        envVersion: 'develop',
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
  }
})