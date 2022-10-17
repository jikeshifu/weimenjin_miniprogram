const app = getApp();
Page({
  data: {
    successimg: '../../images/success.png',
    successadimg: '../../images/success.png',
    closeAd: true, // 广告弹层是否关闭 false不关闭
    onlyimg: '../../images/ad.jpg',
    adnum: 1, // 显示开门成功样式几： 1原来的两张图片的,2新的只显示一张图片的
    openadurl: '', // 点击图片打开的链接
    cleartime: '', // 定时器
    adw:600, // 广告弹层的宽单位rpx
    qrshowminiad:true,
    index: null,
    phone: '',
    user_id: 0,   // 管理员id，不是小程序用户的id
    lock_id: 0, // 用app.js里的lock_id
    st: 0, // 二维码上的参数
    realname: '', // 申请人名
    remark: '', // 备注
    auth_status: 0, // 审核状态 已审核|1,未审核|0   204代表1不需要审核直接开门，203代表0需要审核
    apply: false, // 是否显示申请信息 false不显示申请信息
    isBindPhone: false, // 是否显示绑定手机
    latitude: '',
    longitude: '',
    canIUseGetUserProfile: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    hasheadimgurl: true, // true默认头像，登录后没有头像再改成false，false显示登录
    isscan: false, // 打开页面方式:false不是扫码，true是扫码
  },
  onShow:function () {
    //console.log('open-onShow')
    var that = this;
    var pages = getCurrentPages();
    if (wx.getUserProfile) {
      that.setData({canIUseGetUserProfile:true})
    }
    //console.log('pages')
    //console.log(pages)
    var len = pages.length;
    var isweb = false;
    if (len>=2) {
      var prevpage = pages[pages.length - 2];
      if (prevpage.route=="pages/web/web") {
        if (url.length > 0) {
          isweb = true;
        }
      }
    }
    if (isweb) {
      wx.switchTab({
        url: '../index/index'
      })
    }else{
      // wx.showLoading({
      //   title: '命令执行中',
      //   mask: true
      // });
      var isscan = that.data.isscan;
      if (isscan) {
        if (app.globalData.userid < 1) {
          that.login();
          // setTimeout(function(){
          //   if (app.globalData.userid < 1) {
          //     wx.hideLoading();
          //     wx.navigateTo({
          //       url: '../wxlogin/wxlogin'
          //     })
          //   }
          //   else{
          //     that.getLock();
          //   }
          // },2000);
        }else{
          that.getLock();
        }
      }else{
        wx.switchTab({
          url: '../index/index'
        })
      }
    }
  },
  onLoad: function (options) {
    var that = this;
    //console.log(app.globalData)
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          adw: res.windowWidth * 2-60,
        });
      }
    });
    var user_id = this.data.user_id;
    var lock_id = app.globalData.lock_id;
    var st = that.data.st;
    if(options.q){
      var scene = decodeURIComponent(options.q)  // 使用decodeURIComponent解析  获取当前二维码的网址
      // scene.decodeURL()
      //console.log('scene:'+scene);
      var pos = scene.indexOf("?");
      if (pos >=0) {
        //console.log('pos1:'+pos);
        pos = parseInt(pos) +1;
        var str = scene.substr(pos);
        //console.log('str:'+str);
        var strarr = str.split('&');
        //console.log('strarr:');
        //console.log(strarr);
        var paramobj = {};
        for (var i = 0; i < strarr.length; i++) {
          var tmparr = strarr[i].split('=');
          paramobj[tmparr[0]] = tmparr[1];
        }
        //console.log('paramobj:');
        //console.log(paramobj);
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
          that.setData({
            isscan: true,
          });
        }
        if (paramobj['st'] != undefined && paramobj['st'] > 0) {
          st = paramobj['st'];
          that.setData({
            st: paramobj['st']
          });
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
      that.setData({
        isscan: false,
      });
    }
    if (options.isscan != undefined && options.isscan >0) {
      that.setData({
        isscan: true,
      });
    }
    if (options.st != undefined && options.st >0) {
      st = options.st
      that.setData({
        st: st
      });
    }
  },
  login: function () {
    var that = this;
    // 登录
    wx.login({
      success: res => {
        console.log('open-login-success-res')
        console.log(res)
        if (res.code) {
          // 可以将 res 发送给后台解码出 unionId
          //发起网络请求
          wx.request({
            url: app.globalData.domain + '/api/Member/login',
            data: {
              code: res.code,
            },
            method: 'POST',
            success: function (resa) {
              console.log('login-resa');
              console.log(resa);
              if (resa.data.status + "" == "200") {
                app.globalData.token = resa.data.token;
                app.globalData.userid = resa.data.data.member_id;
                app.globalData.openid = resa.data.data.openid;
                app.globalData.nickname = resa.data.data.nickname;
                app.globalData.headimgurl = resa.data.data.headimgurl;
                app.globalData.phone = resa.data.data.mobile == null ? '' : resa.data.data.mobile;
                if (resa.data.data.useradmininfo.user_id != undefined) {
                  app.globalData.user_id = resa.data.data.useradmininfo.user_id;
                }
                if (resa.data.data.headimgurl == '' || resa.data.data.headimgurl==app.globalData.defaultimg) {
                  that.setData({hasheadimgurl:false}); // 显示登录按钮
                }else{
                  that.getLock();
                }
              }
            }
          })
        }
      },
      fail: res => {}
    })
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
        // //console.log('getLock-res');
        // //console.log(res);
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
                  //console.log(JSON.stringify(res))
                  if (res.authSetting['scope.userLocation']!= true)
                  {
                    //console.log('scope.userLocation false')
                    if (res.authSetting['scope.userLocation'] == undefined)
                    {
                      //console.log('scope.userLocation undefined')
                      timedelay = 3800; // 3秒延迟
                      that.getLocation();
                      wx.showLoading({
                        title: '获取定位中...',
                        mask: true
                      })
                    }else{
                      wx.openSetting({
                        success: function (dataAu) {
                          //console.log('dataAu')
                          //console.log(dataAu)
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
                    //console.log('scope.userLocation s')
                    //console.log(s)
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
              //console.log('scope.userLocation2 s')
              //console.log(s)
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
    //console.log('doOpen-lock_id');
    //console.log(lock_id);
    var that = this;
    var jsondata = {
      user_id: adminid,
      lock_id: lock_id,
      member_id: app.globalData.userid,
      type: 1
    };
    if (that.data.st > 0) {
      jsondata['st'] = that.data.st;
    }
    wx.request({
      url: app.globalData.domain+'/api/Lock/opendoor',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: jsondata,
      success: function (res) {
        //console.log('opendoor-res');
        //console.log(res);
        wx.hideLoading();
        if (res.data.opendoor_status=='200') {
          // that.setData({
          //   closeAd: false,
          //   successimg: app.globalData.domain+res.data.successimg,
          //   successadimg: app.globalData.domain+res.data.successadimg,
          //   openadurl: res.data.openadurl,
          //   adnum: res.data.adnum,
          //   qrshowminiad:res.data.qrshowminiad
          // })
          // var cleartime = setTimeout(function(){
          //   that.setData({
          //     closeAd: true
          //   })
          //   wx.switchTab({
          //     url: '../index/index'
          //   })
          // },5000);
          // that.setData({
          //   cleartime: cleartime
          // })
          app.globalData.successimg = app.globalData.domain+res.data.successimg;
          app.globalData.successadimg = app.globalData.domain+res.data.successadimg;
          app.globalData.openadurl = res.data.openadurl;
          app.globalData.adnum = res.data.adnum;
          app.globalData.qrshowminiad = res.data.qrshowminiad;
          wx.redirectTo({
            url: '../opensuccess/opensuccess'
          })
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
    // //console.log("计算结果", s)
    return s
  },
  getLocation(){
    var that = this;
    //console.log('getLocation-that.data');
    //console.log(that.data);
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
        //     //console.log('getLocation-resa')
        //     //console.log(resa)

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
    //console.log('getPhoneNumber-e');
    //console.log(e);
    //console.log(app.globalData)
    if (e.detail.errMsg == "getPhoneNumber:ok") {
      var phonecode = '';
      if (e.detail.code != undefined) {
        phonecode = e.detail.code;
      }
      wx.login({
        success: res => {
          //console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
              phonecode: phonecode,
              encryptedData: e.detail.encryptedData,
              iv: e.detail.iv,
              code: res.code
            },
            method: "post",
            success: function (resa) {
              //console.log('getphonenumber-resa');
              //console.log(resa);
              var phone = resa.data.phoneNumber;
              if (phone!=null && phone!= undefined) {
                that.setData({
                  phone: phone,
                  isBindPhone: true
                });
              }
              app.globalData.phone = phone;
              var userInfo = app.globalData.userInfo;
              if (userInfo) {
                userInfo['nickName'] = userInfo['nickName'] ? userInfo['nickName'] : '我是游客';
                userInfo['avatarUrl'] = userInfo['avatarUrl'] ? userInfo['avatarUrl'] : 'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132';
                userInfo['gender'] = userInfo['gender'] ? userInfo['gender'] : '1';
              }else{
                userInfo={};
                userInfo['nickName'] = '未登录';
                userInfo['avatarUrl'] = 'https://thirdwx.qlogo.cn/mmopen/vi_32/POgEwh4mIHO4nibH0KlMECNjjGxQUq24ZEaGT4poC6icRiccVGKSyXwibcPq4BWmiaIGuG1icwxaQX6grC9VemZoJ8rg/132';
                userInfo['gender'] = '1';
              }
              var dataobj = {
                member_id: app.globalData.userid,
                nickname: userInfo.nickName,
                headimgurl: userInfo.avatarUrl,
                openid: app.globalData.openid,
                mobile: phone,
                sex: userInfo.gender
              };
              //console.log('dataobj')
              //console.log(dataobj);
              wx.request({
                url: app.globalData.domain+'/api/Member/update',
                method: "post",
                header:{
                  "Authorization": app.globalData.token
                },
                data: dataobj,
                success: function (resb) {
                  //console.log('update-resb');
                  //console.log(resb);
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
                },
                fail: function (res) {
                  wx.showToast({
                    title: '操作失败',
                    icon: 'none',
                    mask: true, // 防止触摸穿透
                    duration: 2000
                  });
                }
              })
            },
            fail: function (res) {
              wx.showToast({
                title: '操作失败',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          })
        },
        fail: function (res) {
          wx.hideLoading();
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
    wx.requestSubscribeMessage({
      tmplIds: ['ZefHClTYrAuPe9MAxoX2nbRPtpeu_cdgxKpDLv7azGw'], // 此处可填写多个模板 ID，但低版本微信不兼容只能授权一个
      success (res) {
       //console.log('已授权接收订阅消息')
      }
     });
    //console.log('applyauth-uploadData-tmpdata2')
    //console.log(tmpdata2)
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
        //console.log('uploadData-res');
        //console.log(res);
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
      },
      fail: function (res) {
        wx.hideLoading();
      }
    })
  },
  openweb: function (e) {
    var tmpopenadurl = this.data.openadurl;
    if (tmpopenadurl) {
      clearTimeout(this.data.cleartime);
      wx.redirectTo({
        url: '../web/web?url='+tmpopenadurl
      })
      /*wx.navigateTo({
        url: '../web/web?url='+tmpopenadurl
      })*/
    }
  },
  getUserProfile(e) {
    // console.log('getUserProfile-e');
    // console.log(e);
    var that = this;
    // 推荐使用wx.getUserProfile获取用户信息，开发者每次通过该接口获取用户个人信息均需用户确认
    // 开发者妥善保管用户快速填写的头像昵称，避免重复弹窗
    wx.getUserProfile({
      desc: '用于登录获取用户头像', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
      success: (res) => {
        wx.showLoading({
          title: '登录中',
          mask: true
        })
        // 用户授权获取用户信息后，直接更新用户信息到用户表
        var userInfo = res.userInfo;
        app.globalData.userInfo = userInfo;
        app.globalData.nickname = userInfo.nickName;
        app.globalData.headimgurl = userInfo.headimgurl;
        // this.updateUserInfo(e.detail);
        wx.request({
          url: app.globalData.domain+'/api/Member/update',
          method: 'POST',
          header:{
            "Authorization": app.globalData.token
          },
          data: {
            member_id: app.globalData.userid,
            nickname: userInfo.nickName,
            headimgurl: userInfo.avatarUrl,
            openid: app.globalData.openid,
            mobile: app.globalData.phone,
            sex: userInfo.gender,
            member_ps: 1,
          },
          success: function (resa) {
            wx.hideLoading();
            if (resa.data.status == 200) {
              that.setData({hasheadimgurl:true});
              that.getLock();
            }else{
              wx.showToast({
                title: resa.data.msg,
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
              });
            }
          }
        })
      }
    })
  },
  getUserInfo: function(e) {
    var that = this;
    wx.showLoading({
      title: '登录中',
      mask: true
    })
    //console.log('getUserInfo-e');
    //console.log(e);
    var userInfo = e.detail.userInfo
    app.globalData.userInfo = userInfo;
    app.globalData.nickname = userInfo.nickName;
    app.globalData.headimgurl = userInfo.headimgurl;
    // this.updateUserInfo(e.detail);
    wx.request({
      url: app.globalData.domain+'/api/Member/update',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        member_id: app.globalData.userid,
        nickname: userInfo.nickName,
        headimgurl: userInfo.avatarUrl,
        openid: app.globalData.openid,
        mobile: app.globalData.phone,
        sex: userInfo.gender,
        member_ps: 1,
      },
      success: function (resa) {
        //console.log('index-resa');
        //console.log(resa);
        wx.hideLoading();
        if (resa.data.status == 200) {
          that.setData({hasheadimgurl:true});
          that.getLock();
        }else{
          wx.showToast({
            title: resa.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
        }
      }
    })
  },
})