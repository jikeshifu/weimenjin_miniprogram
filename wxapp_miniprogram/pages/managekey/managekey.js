const app = getApp()
Page({
  data: {
    looding: '../../images/looding.gif',
    successimg: '../../images/success.png',
    avatarUrl: '../../images/avatar.png',
    hidelood: false,
    nodata: false,
    listarr: [],
    listlen: 1,
    page: 1,
    num: 20,
    scrollHeight: 0,
    close: true,  // 登录弹层是否关闭 false不关闭
    closeAd: true, // 广告弹层是否关闭 false不关闭
    lock_id: 0,
    user_id: 0, //锁管理员id
    auth_status: '0', // 0待审核，1已通过
    tabarr: [true,false] // 切换tab
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: [],
      listlen: 1
    })
    if (app.globalData.userid) {
      this.getmore(1, this.data.num,0);
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
      this.getmore(curpage,num,1);
    }
  },
  onShow:function () {
    console.log('index-onShow');
    var that = this
    wx.showLoading({
      title: '正在加载',
      mask: true
    })
    if (app.globalData.userid < 1) {
      setTimeout(function(){
        if (app.globalData.userid < 1) {
          wx.hideLoading();
          that.setData({
            close:false
          })
        }else{
          if (that.data.listarr.length <1) {
            that.getmore(1,that.data.num,0);
          } else {
            wx.hideLoading();
          }
        }
      },2000);
    }else{
      if (that.data.listarr.length <1) {
        that.getmore(1,that.data.num,0);
      } else {
        wx.hideLoading();
      }
    }
  },
  onLoad: function (options) {
    console.log('managekey-onload-options:');
    console.log(options);
    var that = this;
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });
    if (options.lock_id != undefined && options.lock_id >0) {
      that.setData({
        lock_id: options.lock_id
      });
    }
    // if (options.user_id != undefined && options.user_id >0) {
    //   that.setData({
    //     user_id: options.user_id //锁管理员id
    //   });
    // }
  },
  swichtab: function (e) {
    var that = this;
    var id = e.currentTarget.dataset['id'];
    id = id+'';
    console.log('id:'+id);
    if (id=='0') {
      that.setData({
        auth_status: id,
        tabarr: [true,false]
      });
    }else{
      that.setData({
        auth_status: id,
        tabarr: [false,true]
      });
    }
    that.getmore(1, that.data.num,0);
  },
  getmore: function(page,num,addto){ // addto为0覆盖原有数据，为1在原有数据基础上追加数据
    console.log('index.js-getmore')
    var that = this;
    wx.showLoading({
      title: '正在加载',
      mask: true
    });
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
      var aaa = {
          lock_id: that.data.lock_id,
          auth_status: that.data.auth_status,
          limit: num,
          page: page
        };
        console.log('aaa')
        console.log(aaa);
      wx.request({
        url: app.globalData.domain+'/api/LockAuth/getauthlistbylockid',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          lock_id: that.data.lock_id,
          auth_status: that.data.auth_status,
          limit: num,
          page: page
        },
        success: function (resa) {
          console.log('that.data.lock_id:'+that.data.lock_id)
          console.log('getmore-success-resa');
          console.log(resa);
          wx.hideLoading();
          var arr = [];
          if (resa.data.status == 200) {
            var arrdata = resa.data.data.list
            if(arrdata.length > 0){
              var timestamp = Date.parse(new Date())/1000;
              var tmpdroparr = [];
              for (var i = 0; i < arrdata.length; i++) {
                tmpdroparr.push(false);
                var tmpobj = {};
                tmpobj['headimgurl'] = arrdata[i]['headimgurl'];
                tmpobj['nickname'] = arrdata[i]['nickname'];
                tmpobj['mobile'] = arrdata[i]['mobile'];
                tmpobj['lockauth_id'] = arrdata[i]['lockauth_id'];
                arr.push(tmpobj);
              }
              if (addto>0) {
                var newdata = that.data.listarr.concat(arr);
                var newdroparr = that.data.dropArr.concat(tmpdroparr);
              }else{
                var newdata = arr;
                var newdroparr = tmpdroparr;
              }
              var tmplistlen = newdata.length;
              that.setData({
                listarr: newdata,
                hidelood: false,
                listlen: tmplistlen,
                dropArr: newdroparr
              });
            }else{
              if (addto<1) { // 不追加,覆盖
                var newdata = arr;
                var tmplistlen = arr.length;
                var newdroparr = tmpdroparr;
              }else{
                var newdata = that.data.listarr; // 追加，但是没有查到数据，赋值原来的数据
                var tmplistlen = that.data.listarr.length;
                var newdroparr = that.data.dropArr;
              }
              that.setData({
                listarr: newdata,
                hidelood: false,
                nodata: true,
                listlen: tmplistlen,
                dropArr: newdroparr
              });
            }
          }
        },
        fail: function (res) {
          wx.hideLoading();
          // wx.showToast({
          //   title: '网络故障，请稍后重试',
          //   icon: 'none',
          //   mask: true, // 防止触摸穿透
          //   duration: 2000
          // });
        }
      });
    }
  },
  scrollfun: function(){
  },
  auditKey: function (e) {
    var lockauth_id = e.currentTarget.dataset['lockauthid']; //
    wx.navigateTo({
      url: '../auditkey/auditkey?lockauth_id='+lockauth_id
    })
  },
  deleteKey: function (e) {
    var that = this;
    var id = e.currentTarget.dataset['id']; //
    wx.showModal({
      title: '删除',
      content: '您确定要删除此条数据吗？',
      success (res) {
        if (res.confirm) {
          console.log('用户点击确定')
          console.log(id)
          wx.showLoading({
            title: '执行中',
            mask: true
          });
          wx.request({
            url: app.globalData.domain+'/api/LockAuth/delete',
            method: "POST",
            header:{
              "Authorization": app.globalData.token
            },
            data: {
              lockauth_ids: id,
            },
            success: function (resa)
            {
              console.log('删除反馈')
              console.log(resa)
              wx.hideLoading();
              wx.showToast({
                title: '删除成功',
                icon: 'success',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
              that.getmore(1,that.data.num,0);
            },
            fail: function (res) {
              wx.hideLoading();
              wx.showToast({
                title: '网络故障，请稍后重试',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          });
        } else if (res.cancel) {
          console.log('用户点击取消')
        }
      }
    })
  }
})