const app = getApp()
Page({
  data: {
    search: '../../images/search.png',
    looding: '../../images/looding.gif',
    hidelood: false,
    nodata: false,
    listarr: [],
    listlen: 1,
    page: 1,
    num: 20,
    scrollHeight: 0,
    lock_id: 0, // 锁id
    close: true, //弹层是否关闭 false不关闭
    keyword: '', // 搜索关键词
    create_time: '', // 开始时间
    end_time: '' // 结束时间
  },
  startSearch(){
    this.setData({
      close: false
    })
  },
  keywordInput(e) {
    this.setData({
      keyword: e.detail.value
    })
  },
  startDate(e) {
    this.setData({
      create_time: e.detail.value
    })
  },
  endDate(e) {
    this.setData({
      end_time: e.detail.value
    })
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: [],
      listlen: 1  //
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
    console.log('openlogs-onShow')
    // console.log(app.globalData.userid)
    var that = this
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      wx.showLoading({
        title: '正在加载',
        mask: true
      })
      if (app.globalData.userid){
        if (that.data.listarr.length <1) {
          that.getmore(1,that.data.num,0);
        } else {
          wx.hideLoading();
        }
      } else {
        // wx.hideLoading();
      }
    }
  },
  onLoad: function (options) {
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
  },
  getmore: function(page,num,addto){ // addto为0覆盖原有数据，为1在原有数据基础上追加数据
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
      wx.request({
        url: app.globalData.domain+'/api/LockLog/getopenlogbylockid',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          limit: num,
          page: page,
          keyword: that.data.keyword,
          lock_id: that.data.lock_id,
          create_time_start: that.data.create_time,
          create_time_end: that.data.end_time,
        },
        success: function (resa) {
          console.log('getmore-success-resa');
          console.log(resa);
          wx.hideLoading();
          var arr = [];
          if (resa.data.status == 200) {
            var arrdata = resa.data.data.list
            if(arrdata.length > 0){
              var timestamp = Date.parse(new Date())/1000;
              for (var i = 0; i < arrdata.length; i++) {
                var tmpobj = {};
                tmpobj['create_time'] = that.timestampToTime(arrdata[i]['create_time'])
                tmpobj['lock_name'] = arrdata[i]['lock_name'];
                tmpobj['headimgurl'] = arrdata[i]['headimgurl'];
                tmpobj['nickname'] = arrdata[i]['nickname'];
                tmpobj['mobile'] = arrdata[i]['mobile'];
                tmpobj['type'] = arrdata[i]['type'];
                // tmpobj['lock_id'] = arrdata[i]['lock_id'];
                // tmpobj['user_id'] = arrdata[i]['user_id']; // 锁的管理员id
                arr.push(tmpobj);
              }
              if (addto>0) {
                var newdata = that.data.listarr.concat(arr);
              }else{
                var newdata = arr;
              }
              var tmplistlen = newdata.length;
              that.setData({
                listarr: newdata,
                hidelood: false,
                listlen: tmplistlen
              });
            }else{
              if (addto<1) { // 不追加,覆盖
                var newdata = arr;
                var tmplistlen = arr.length;
              }else{
                var newdata = that.data.listarr; // 追加，但是没有查到数据，赋值原来的数据
                var tmplistlen = that.data.listarr.length;
              }
              that.setData({
                listarr: newdata,
                hidelood: false,
                nodata: true,
                listlen: tmplistlen
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
  // 执行搜索
  doSearch: function(e) {
    var that = this;
    that.getmore(1,that.data.num,0);
    that.closemask();
  },
  closemask:function(){
    this.setData({
      close:true,
      keyword: '',
      create_time: '',
      end_time:''
    })
  },
  getUserInfo: function(e) {
    wx.showLoading({
      title: '登录中',
      mask: true
    })
    console.log('getUserInfo-e');
    console.log(e);
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
    this.updateUserInfo(e.detail);
  },
  updateUserInfo: function(data) {
    console.log('updateUserInfo');
    var that = this;
    var route = that.data.route;
    // 登录
    wx.login({
      success: res => {
        if (res.code) {
          wx.getUserInfo({
            success: resuser => {
              // 可以将 res 发送给后台解码出 unionId
              app.globalData.userInfo = resuser.userInfo
              //发起网络请求
              wx.request({
                url: app.globalData.domain+'/api/Member/xcxlogin',
                data: {
                  code: res.code,
                  encryptedData: resuser.encryptedData,
                  iv: resuser.iv
                },
                method: 'POST',
                success: function (resa) {
                  console.log('index-resa');
                  console.log(resa);
                  if (resa.data.status == 200) {
                    app.globalData.token = resa.data.token;
                    app.globalData.userid = resa.data.data.member_id;
                    app.globalData.openid = resa.data.data.openid;
                    app.globalData.phone = resa.data.data.mobile;
                  }
                  var tmpdata1 = {member_id: resa.data.data.member_id};
                  console.log('index-updateUserInfo-tmpdata1')
                  console.log(tmpdata1)
                  wx.request({
                    url: app.globalData.domain+'/api/Member/view',
                    method: 'POST',
                    header:{
                      "Authorization": app.globalData.token
                    },
                    data: {
                      member_id: resa.data.data.member_id
                    },
                    success: function (resb) {
                      console.log('index-updateUserInfo-resb');
                      console.log(resb);
                      wx.hideLoading();
                      if (resb.data.status == 200) {
                        var tmpuser_id = resb.data.data.user_id;
                        if (tmpuser_id != '') {
                          app.globalData.user_id = resb.data.data.user_id;
                          app.globalData.adminInfo = resb.data.data;
                        }
                        that.getmore(1,that.data.num,0);
                        that.closemask();
                      }else{
                        wx.showToast({
                          title: '登录失败，请稍后重试',
                          icon: 'none',
                          mask: true,
                          duration: 1500
                        })
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
  },
  callPhone: function (e) {
    var phone = e.currentTarget.dataset['phone'];
    wx.showActionSheet({
      itemList: [phone],
      success: function (res) {
        console.log(res) // 点击手机号执行拨打电话
        wx.makePhoneCall({
          phoneNumber: phone, //此号码并非真实电话号码，仅用于测试
          success: function () {
            console.log("拨打电话成功！")
          },
          fail: function () {
            console.log("拨打电话失败！")
          }
        })
        if (!res.cancel) {
          console.log(res.tapIndex)//console出了下标
        }
      }
    });
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