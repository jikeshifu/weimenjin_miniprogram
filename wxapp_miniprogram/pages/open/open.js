const app = getApp();
Page({
  data: {
    successimg: '../../images/success.png',
    successadimg: '../../images/success.png',
    closeAd: true, // 广告弹层是否关闭 false不关闭
    qrshowminiad:true,
    index: null,
    phone: '',
    user_id: 0,   // 管理员id，不是小程序用户的id
    lock_id: 0, // 用app.js里的lock_id
    realname: '', // 申请人名
    remark: '', // 备注
    auth_status: 0, // 审核状态 已审核|1,未审核|0   204代表1不需要审核直接开门，203代表0需要审核
    apply: false, // 是否显示申请信息 false不显示申请信息
    isBindPhone: false, // 是否显示绑定手机
    latitude: '',
    longitude: ''
  },
  onShow:function () {
    console.log('open-onShow')
    var that = this;
    wx.showLoading({
      title: '命令执行中',
      mask: true
    });
    if (app.globalData.userid < 1) {
      setTimeout(function(){
        if (app.globalData.userid < 1) {
          wx.hideLoading();
          wx.navigateTo({
            url: '../wxlogin/wxlogin'
          })
        }else{
          that.getLock();
        }
      },2000);
    }else{
      that.getLock();
    }
  },
  onLoad: function (options) {
    console.log('options:');
    console.log(options);
    console.log('token:');
    console.log(app.globalData.token)
    var that = this;
    console.log(app.globalData)

    var user_id = this.data.user_id;
    var lock_id = app.globalData.lock_id;
    if(options.q){
      var scene = decodeURIComponent(options.q)  // 使用decodeURIComponent解析  获取当前二维码的网址
      // scene.decodeURL()
      console.log('scene:'+scene);
      var pos = scene.indexOf("?");
      if (pos >=0) {
        console.log('pos1:'+pos);
        pos = parseInt(pos) +1;
        var str = scene.substr(pos);
        console.log('str:'+str);
        var strarr = str.split('&');
        console.log('strarr:');
        console.log(strarr);
        var paramobj = {};
        for (var i = 0; i < strarr.length; i++) {
          var tmparr = strarr[i].split('=');
          paramobj[tmparr[0]] = tmparr[1];
        }
        console.log('paramobj:');
        console.log(paramobj);
        if (paramobj['user_id'] != undefined && paramobj['user_id'] >0) {
          user_id = paramobj['user_id'];
          that.setData({
            user_id: paramobj['user_id']
          });
        }
        if (paramobj['lock_id'] != undefined && paramobj['lock_id'] > 0) {
          lock_id = paramobj['lock_id'];
          // that.setData({
          //   lock_id: paramobj['lock_id']
          // });
          app.globalData.lock_id = lock_id
        }
      }
    }
    if (options.user_id != undefined && options.user_id >0) {
      user_id = options.user_id
      that.setData({
        user_id: user_id
      });
    }
    if (options.lock_id != undefined && options.lock_id >0) {
      lock_id = options.lock_id
      // that.setData({
      //   lock_id: lock_id
      // });
      app.globalData.lock_id = lock_id
    }
  },
  // 现获取锁信息,判断是否限制距离
  getLock:function () {
    var that = this;
    var adminid = that.data.user_id; // 管理员user_id的值
    var lock_id = app.globalData.lock_id; //
    // 先查询锁是否支持距离
    wx.request({
      url: app.globalData.domain+'/api/Lock/view',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        lock_id: lock_id
      },
      success: function (res) {
        // console.log('getLock-res');
        // console.log(res);
        // create_time: "1584287501"
        // location: "{"longitude":106.683309,"latitude":26.547251,"address":"贵州省贵阳市南明区太慈社区服务中心车水路74号望水苑"}"
        // location_check: "200"
        // lock_id: "11"
        // lock_name: "演示门锁"
        // lock_qrcode: "https://wxapp.wmj.com.cn/qrdata/qrcode/1585852461.png"
        // lock_sn: "WMJ16106666"
        // lock_type: "1"
        // mobile_check: "1"
        // online: ""
        // status: "1"
        // user_id: "1"
        if (res.data.status=='200') {
          var lock = res.data.data;
          var lock_latitude = 0; //
          var lock_longitude = 0; //
          if (lock['location'] != '' && lock['location'] != null) {
            var tmplocation = JSON.parse(lock['location']); // "{"longitude":106.710689,"latitude":26.574774,"address":"贵州省贵阳市南明区市府社区服务中心都司路9号"}"
            lock_latitude = tmplocation['latitude']; //
            lock_longitude = tmplocation['longitude']; //
          }
          var location_check = lock['location_check'];
          var latitude = that.data.latitude;
          var longitude = that.data.longitude;
          location_check = parseInt(location_check);
          if (location_check > 0){ // 现在判断小于1，一会判断大于0
            if (latitude=='' || longitude==''){
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
                    }else{
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
                              duration: 2000
                            })
                            return false;
                          }
                        }
                      })
                    }
                  }else{
                    timedelay = 3800;
                    that.getLocation();
                    wx.showLoading({
                      title: '获取定位中...',
                      mask: true
                    })
                  }
                }
              })
              if (timedelay){
                setTimeout(function(){
                  if (that.data.latitude == '' || that.data.longitude == '') {
                    wx.showToast({
                      title: '获取不到定位，开门失败',
                      icon: 'none',
                      mask: true, // 防止触摸穿透
                      duration: 2000
                    });
                    that.getLocation();
                    return false;
                  }else{
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
                      setTimeout(function(){
                        that.setData({
                          closeAd: true
                        })
                        wx.switchTab({
                          url: '../index/index'
                        })
                      },2000);
                      return false;
                    }else{
                      that.doOpen(adminid,lock_id);
                    }
                  }
                },timedelay);
              }
            }else{
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
                setTimeout(function(){
                  that.setData({
                    closeAd: true
                  })
                  wx.switchTab({
                    url: '../index/index'
                  })
                },2000);
                return false;
              }else{
                that.doOpen(adminid,lock_id);
              }
            }
          }else{
            // 不需要判断距离，直接开门
            that.doOpen(adminid,lock_id);
          }
        }else{
          wx.hideLoading();
          wx.showToast({
            title: '设备不存在',
            icon: 'none',
            mask: true,
            duration: 2000
          })
        }
      }
    })
  },
  doOpen:function (adminid,lock_id) {
    console.log('doOpen-lock_id');
    console.log(lock_id);
    var that = this;
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
        type: 1
      },
      success: function (res) {
        console.log('opendoor-res');
        console.log(res);
        wx.hideLoading();
        if (res.data.opendoor_status=='200') {
          that.setData({
            closeAd: false,
            successimg: app.globalData.domain+res.data.successimg,
            successadimg: app.globalData.domain+res.data.successadimg,
            qrshowminiad:res.data.qrshowminiad
          })
          setTimeout(function(){
            that.setData({
              closeAd: true
            })
            wx.switchTab({
              url: '../index/index'
            })
          },3000);
        }else if (res.data.opendoor_status=='202') {
          that.setData({
            isBindPhone:true
          })
        }else if (res.data.opendoor_status=='203') {
          that.setData({
            apply: true,
            auth_status: 0
          })
        }else if (res.data.opendoor_status=='204') {
          that.setData({
            apply: true,
            auth_status: 1
          })
        }else{
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true,
            duration: 2000
          })
        }
      }
    })
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
      },
      fail: function (res) {
        wx.showToast({
          title: '获取不到定位，开门失败',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        setTimeout(function(){
          wx.switchTab({
            url: '../index/index'
          })
        },2000);
      }
    })
  },
  realnameInput:function(e){
    this.setData({
      realname: e.detail.value
    });
  },
  remarkInput:function(e){
    this.setData({
      remark: e.detail.value
    });
  },
  getPhoneNumber: function (e) {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      });
      return false;
    }
    wx.showLoading({
      title: '获取中',
      mask: true
    });
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
              if (phone!=null && phone!= undefined) {
                that.setData({
                  phone: phone,
                  isBindPhone: true
                });
              }
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
                  that.setData({
                    isBindPhone: false
                  })
                  wx.hideLoading();
                  wx.showLoading({
                    title: '开门中',
                    mask: true
                  });
                  var adminid = that.data.user_id; // 管理员user_id的值
                  var lock_id = app.globalData.lock_id; //
                  that.doOpen(adminid,lock_id);
                }
              })
            }
          })
        }
      })
    }
  },
  uploadData() {
    wx.showLoading({
      title: '申请中',
      mask: true
    })
    var that = this;
    var realname = that.data.realname;
    var remark = that.data.remark;
    var adminid = that.data.user_id; // 管理员user_id的值
    var lock_id = app.globalData.lock_id; //
    var auth_status = that.data.auth_status; // 审核状态 已审核|1,未审核|0 204代表1不需要审核直接开门，203代表0需要审核
    if (!realname) {
      wx.hideLoading();
      wx.showToast({
        title: '请输入申请人',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    var tmpdata2 = {
      member_id: app.globalData.userid,
      remark: remark,
      lock_id: lock_id,
      user_id: adminid,
      realname: realname
    };
    console.log('applyauth-uploadData-tmpdata2')
    console.log(tmpdata2)
    wx.request({
      url: app.globalData.domain+'/api/LockAuth/applyauth',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: app.globalData.userid,
        remark: remark,
        lock_id: lock_id,
        user_id: adminid,
        realname: realname,
        auth_status: auth_status
      },
      success: function (res) {
        console.log('uploadData-res');
        console.log(res);
        wx.hideLoading();
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          // that.setData({
          //   apply:false
          // })
          if (auth_status>0) {
            // 直接开门
            that.getLock();
          }else{
            setTimeout(function(){
              wx.switchTab({
                url: '../index/index'
              })
            },2000);
          }
        }else{
          // 申请失败跳到首页
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