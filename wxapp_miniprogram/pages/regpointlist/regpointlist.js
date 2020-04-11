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
    alertModal: false,
    gridCol:3,
    gridBorder: true,
    iconList: [{
      url: '../../images/qrcode.png',
      name: 'VR'
    }, {
      url: '../../images/qrcode.png',
      name: 'VR'
    }],
    qrcode:'../../images/qrcode.png', // 弹层展示的二维码
    qrcodeid: 0,   // 弹层二维码的user_id
    url: app.globalData.domain+'/upload/a.jpg',
    showDialog: false
  },
  showModal(e) {
    this.setData({
      alertModal: true,
      qrcode: e.currentTarget.dataset['img']
      // modalName: e.currentTarget.dataset.target
    })
  },
  hideModal(e) {
    this.setData({
      alertModal: false,
      qrcode: '../../images/qrcode.png'
      // modalName: null
    })
  },
  saveImage() {
    var that =this;
    this.wxToPromise('downloadFile', {
      url: this.data.url
    })
    .then(res => this.wxToPromise('saveImageToPhotosAlbum', {
      filePath: res.tempFilePath
    }))
    .then(res => {
      console.log(res);
      // this.hide();
      wx.showToast({
        title: '保存成功~',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      that.setData({
        showDialog: false,
        alertModal: false
      });
    })
    .catch(({ errMsg }) => {
      console.log(errMsg)
      // if (~errMsg.indexOf('cancel')) return;
      if (!~errMsg.indexOf('auth')) {
        wx.showToast({
          title: '图片保存失败，稍后再试',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
      } else {
        // 调用授权提示弹框
        that.setData({
          showDialog: true
        })
      };
    })
  },
  // callback to promise
  wxToPromise(method, opt) {
    return new Promise((resolve, reject) => {
      wx[method]({
        ...opt,
        success(res) {
          opt.success && opt.success();
          resolve(res)
        },
        fail(err) {
          opt.fail && opt.fail();
          reject(err)
        }
      })
    });
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: []
    })
    if (app.globalData.user_id < 1) {
      wx.redirectTo({
        url: '../adduser/adduser'
      })
      return false;
    }
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
        url: app.globalData.domain+'/api/Regpoint/index',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          user_id: app.globalData.user_id,
          limit: num,
          page: page,
        },
        success: function (resa) {
          console.log('qrcode-getmore-success-resa');
          console.log(resa);
          wx.hideLoading();
          var arr = [];
          if (resa.data.status == 200) {
            var arrdata = resa.data.data.list
            if(arrdata.length > 0){
              for (var i = 0; i < arrdata.length; i++) {
                // arrdata[i]['create_time'] = that.timestampToTime(arrdata[i]['create_time']);
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