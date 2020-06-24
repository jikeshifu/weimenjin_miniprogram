//获取应用实例
const app = getApp();

Page({
  data: {
    url:''
  },
  onLoad: function (options) {
    console.log(options.url);
    this.setData({
      url: options.url
    })
  }
})
