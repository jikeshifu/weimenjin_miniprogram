const app = getApp()
Page({
  data: {
    openid: '',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    looding: '../../images/looding.gif',
    offline: '../../images/offline.png',
    online: '../../images/online.png',
    successimg: '../../images/success.png',
    successadimg: '../../images/success.png',
    hidelood: false,
    nodata: false,
    listarr: [],
    listlen: 1,
    page: 1,
    num: 20,
    aaa:'aa',
    scrollHeight: 0,
    close: true,  // 登录弹层是否关闭 false不关闭
    closeAd: true, // 广告弹层是否关闭 false不关闭
    location_check: false, // 是否需要定位，false不需要
    latitude: '',
    longitude: ''
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: []
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
  onLoad: function () {
    console.log('index.js-onLoad')
    var that = this;
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          scrollHeight: res.windowHeight
        });
      }
    });
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
      wx.request({
        url: app.globalData.domain+'/api/LockAuth/getauthlistbymemid',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          member_id: app.globalData.userid,
          limit: num,
          page: page,
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
                tmpobj['guoqi'] = true; // 默认不过期,过期不显示分享按钮，true显示分享按钮，false不显示
                if (arrdata[i]['auth_endtime']>0) {
                  if (arrdata[i]['auth_endtime'] < timestamp) {
                    tmpobj['time'] = '已过期';
                    tmpobj['guoqi'] = false;
                  }else{
                    if (arrdata[i]['auth_starttime']>timestamp) {
                      tmpobj['guoqi'] = false; // 钥匙还不能用，不显示分享按钮
                      tmpobj['time'] = '有效时间：'+that.timestampToTime(arrdata[i]['auth_starttime'])+'-'+that.timestampToTime(arrdata[i]['auth_endtime']);
                    }else{
                      tmpobj['time'] = '有效时间：'+that.timestampToTime(arrdata[i]['auth_endtime'])
                    }
                  }
                }else{
                  tmpobj['time'] = '永不过期';
                }
                tmpobj['lock_name'] = arrdata[i]['lock_name'];
                tmpobj['online'] = arrdata[i]['online'] == 1 ? true : false;
                tmpobj['lock_id'] = arrdata[i]['lock_id'];
                tmpobj['user_id'] = arrdata[i]['user_id']; // 锁的管理员id
                tmpobj['auth_status'] = arrdata[i]['auth_status']; // 已审核|1,未审核|0
                tmpobj['location_check'] = arrdata[i]['location_check']; //
                tmpobj['auth_shareability'] = arrdata[i]['auth_shareability']; //auth_shareability为0时或已过期时，不能分享，审核中不能分享
                tmpobj['longitude'] = 0;
                tmpobj['latitude'] = 0;
                if (arrdata[i]['location'] != '' && arrdata[i]['location'] != null) {
                  var tmplocation = JSON.parse(arrdata[i]['location']); // "{"longitude":106.710689,"latitude":26.574774,"address":"贵州省贵阳市南明区市府社区服务中心都司路9号"}"
                  tmpobj['longitude'] = tmplocation['longitude'];
                  tmpobj['latitude'] = tmplocation['latitude'];
                }
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
  opendoor: function(e) {
    var that = this;
    var adminid = e.currentTarget.dataset['adminid']; // 管理员user_id的值
    var lock_id = e.currentTarget.dataset['lockid']; //
    var lock_latitude = e.currentTarget.dataset['latitude']; //
    var lock_longitude = e.currentTarget.dataset['longitude']; //
    var location_check = e.currentTarget.dataset['locationcheck']+''; //
    location_check = parseInt(location_check);
    var latitude = that.data.latitude;
    var longitude = that.data.longitude;
    if (location_check > 0)
    { // 现在判断小于1，一会判断大于0
      if (latitude=='' || longitude=='')
      {
        var timedelay = 3800; // 延迟时间
        wx.getSetting({
          success: (res) => {
            console.log(JSON.stringify(res))
            if (res.authSetting['scope.userLocation']!= true)
            {
              console.log('scope.userLocation false')
              if (res.authSetting['scope.userLocation'] == undefined)
              {
                console.log('scope.userLocation undefined')
                timedelay = 3800; // 3秒延迟
                that.getLocation();
                wx.showLoading({
                  title: '获取定位中...',
                  mask: true
                })
              }
              else
              {
                wx.openSetting({
                  success: function (dataAu) {
                    console.log('dataAu')
                    console.log(dataAu)
                    if (dataAu.authSetting["scope.userLocation"] == true) {
                      that.getLocation();
                      wx.showLoading({
                        title: '获取定位中...',
                        mask: true
                      })
                    } else {
                      wx.showToast({
                        title: '请先授权获取定位',
                        icon: 'none',
                        mask: true,
                        duration: 1500
                      })
                      return false;
                    }
                  }
                })
              }
            }
            else
            {
              timedelay = 3800;
              that.getLocation();
              wx.showLoading({
                title: '获取定位中...',
                mask: true
              })
            }
          }
        })
        if (timedelay)
        {
          setTimeout(function()
          {
            if (that.data.latitude == '' || that.data.longitude == '') {
              wx.showToast({
                title: '获取不到定位，开门失败',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
              that.getLocation();
              return false;
            }
            else
            {
              // 计算开门距离，判断允许开门不  wx.hideLoading();
              var s = that.distance(lock_latitude, lock_longitude, that.data.latitude, that.data.longitude);
              console.log('scope.userLocation s')
              console.log(s)
              if (s > location_check) {
                wx.showToast({
                  title: '失败,不在开门范围,距离' + s + '米',
                  icon: 'none',
                  mask: true, // 防止触摸穿透
                  duration: 2000
                });
                that.getLocation();
                return false;
              }else{
                that.doOpen(adminid,lock_id);
              }
            }
          },timedelay);
        }
      }
      else
      {
        // 计算开门距离，判断允许开门不
        var s = that.distance(lock_latitude, lock_longitude, that.data.latitude, that.data.longitude);
        console.log('scope.userLocation2 s')
        console.log(s)
        if (s > location_check) {
          wx.showToast({
            title: '失败,不在开门范围,距离' + s + '米',
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          that.getLocation();
          return false;
        }else{
          that.doOpen(adminid,lock_id);
        }
      }
    }else{
      // 不需要判断距离，直接开门
      that.doOpen(adminid,lock_id);
    }
  },
  distance: function (la1, lo1, la2, lo2) {
    la1 = la1 || 0;
    lo1 = lo1 || 0;
    la2 = la2 || 0;
    lo2 = lo2 || 0;
    var La1 = la1 * Math.PI / 180.0;
    var La2 = la2 * Math.PI / 180.0;
    var La3 = La1 - La2;
    var Lb3 = lo1 * Math.PI / 180.0 - lo2 * Math.PI / 180.0;
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(La3 / 2), 2) + Math.cos(La1) * Math.cos(La2) * Math.pow(Math.sin(Lb3 / 2), 2)));
    s = s * 6378.137;//地球半径
    s = Math.round(s * 10000) / 10; // 单位m
    // console.log("计算结果", s)
    return s
  },
  doOpen:function(adminid,lock_id) {
    var that = this;
    wx.showLoading({
      title: '开门中',
      mask: true
    })
    wx.request({
      url: app.globalData.domain+'/api/Lock/opendoor',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        user_id: adminid,
        lock_id: lock_id,
        member_id: app.globalData.userid,
        type: 2
      },
      success: function (res) {
        console.log('opendoor-res');
        console.log(res);
        wx.hideLoading();
        if (res.data.opendoor_status == '200') {
          that.setData({
            closeAd: false,
            successimg: app.globalData.domain+res.data.successimg,
            successadimg: app.globalData.domain+res.data.successadimg
          })
          setTimeout(function(){
            that.setData({
              closeAd: true
            })
          },2000);
        }else{
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      }
    })
  },
  closemask:function(){
    this.setData({
      close:true
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
                    url: app.globalData.domain+'/api/Member/viewuserid',
                    method: 'POST',
                    header:{
                      "Authorization": resa.data.token
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
  getLocation(){
    var that = this;
    console.log('getLocation-that.data');
    console.log(that.data);
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success (res) {
        that.setData({
          latitude: res.latitude,
          longitude: res.longitude,
        });

        // wx.chooseLocation({
        //   latitude: res.latitude,
        //   longitude: res.longitude,
        //   success(resa){
        //     console.log('getLocation-resa')
        //     console.log(resa)

        //   }
        // })
      }
    })
  },
  goShare: function (e) {
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../sharekeys/sharekeys?lock_id='+lock_id
    })
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