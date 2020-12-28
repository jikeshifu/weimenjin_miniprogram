//获取应用实例
const app = getApp();

Page({
  data: {
    url:''
  },
  onShow:function () {
    //console.log('web-onShow')
    var that = this;
    var pages = getCurrentPages();
    //console.log('pages')
    //console.log(pages)
    var len = pages.length;
  },
  onLoad: function (options) {
    //console.log(options.url);
    this.setData({
      url: options.url
    })
  }
})
