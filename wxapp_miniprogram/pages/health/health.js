const app = getApp();
Page({
  data: {
    index: null,
    username: '', // 姓名
    phone: '',
    curaddress: '', // 当前位置
    latitude: '',
    longitude: '',
    address1: '',
    address2: '',
    job: '',
    registerArr: ['村居(物业)', '乡镇社区', '区县', '交通运输', '校园'], // 登记类型 默认1村居(物业),2乡镇社区,3区县,4交通运输,5校园
    registerIndex: 0,
    yiquArr: ['是', '否'], // 14日内是否来自疫区:1是,默认2否
    yiquIndex: 1,
    healthArr: ['健康', '发热', '发热咳嗽', '头晕乏力', '腹泻', '其他'], // 健康状况:默认1健康,2发热,3发热咳嗽,4头晕乏力,5腹泻,6其他
    healthIndex: 0,
    manyouimg: '../../images/upload.png', // 漫游截图
    txzimg: '../../images/upload.png',     // 通行证截图
    uploadmanyou: '',     // 服务器端返回的漫游截图路径
    uploadtxz: '',        // 服务器端返回的通行证路径  cuIcon-locationfill
    user_id: 0,   // 管理员id，不是小程序用户的id
    regpoint_id: 0,  //登记点id
    userAgree: false,
    lock_id: 0 // 此值大于0跳到open页执行开门流程
  },
  goToUserLicence1: function(){
    wx.navigateTo({
      url: '/pages/memberps/privacypolicy',
      success: function(res) {},
      fail: function(res) {},
      complete: function(res) {},
    })
  },
  goToUserLicence2: function(){
    wx.navigateTo({
      url: '/pages/memberps/serviceagreement',
      success: function(res) {},
      fail: function(res) {},
      complete: function(res) {},
    })
  },
  tipAgree:function(){
    this.setData({
      userAgree:true
    })
  },
  onShow:function () {
    //console.log('health-onShow')
    var that = this;
    //console.log('phone:'+that.data.phone);
    //console.log(app.globalData)
    if (app.globalData.phone =='' || app.globalData.phone == null) {
    }else{
      that.setData({
        phone: app.globalData.phone
      })
    }
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      wx.getSetting({
        success: (res) => {
          //console.log(JSON.stringify(res))
          // res.authSetting['scope.userLocation'] == undefined    表示 初始化进入该页面
          // res.authSetting['scope.userLocation'] == false    表示 非初始化进入该页面,且未授权
          // res.authSetting['scope.userLocation'] == true    表示 地理位置授权
          if (res.authSetting['scope.userLocation']!= true) {
            wx.getLocation({
              type: 'gcj02', //返回可以用于wx.openLocation的经纬度
              success (res) {
                //console.log('请求授权')
              }
            })
          }
        }
      })
      // 获取上次录入信息
      wx.request({
        url: app.globalData.domain+'/api/Health/viewrecently',
        method: 'POST',
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          openid: app.globalData.openid
        },
        success: function (res) {
          //console.log('viewrecently-res');
          //console.log(res);
          if (res.data.status ==200) {
            var tmpdata = res.data.data[0];
            var tmpregisterIndex = parseInt(tmpdata.register_type)-1;
            var tmpyiquIndex = parseInt(tmpdata.yiqu)-1;
            var tmphealthIndex = parseInt(tmpdata.health)-1;
            var tmpmanyouimg = '../../images/upload.png';
            var tmpuploadmanyou = '';
            if (tmpdata.manyou != '') {
              tmpmanyouimg = app.globalData.domain+tmpdata.manyou;
              tmpuploadmanyou = tmpdata.manyou;
            }
            var tmptxzimg = '../../images/upload.png';
            var tmpuploadtxz = '';
            if (tmpdata.manyou != '') {
              tmptxzimg = app.globalData.domain+tmpdata.txz;
              tmpuploadtxz = tmpdata.txz;
            }
            that.setData({
              username: tmpdata.name,
              phone: tmpdata.mobile,
              address1: tmpdata.first_address,
              address2: tmpdata.second_address,
              job: tmpdata.job,
              registerIndex: tmpregisterIndex,
              healthIndex: tmphealthIndex,
              yiquIndex: tmpyiquIndex,
              manyouimg: tmpmanyouimg,
              uploadmanyou: tmpuploadmanyou,
              txzimg: tmptxzimg,
              uploadtxz: tmpuploadtxz
            })
          }
        }
      })
    }
  },
  onLoad: function (options) {
    //console.log('options:');
    //console.log(options);
    //console.log('token:');
    //console.log(app.globalData.token)
    var that = this;
    //console.log(app.globalData)
    var userAgree = wx.getStorageSync('userAgree') || false
    that.setData({
        userAgree
    })
    if (app.globalData.phone =='' || app.globalData.phone == null) {
    }else{
      that.setData({
        phone: app.globalData.phone
      })
    }
    var user_id = this.data.user_id;
    var regpoint_id = this.data.regpoint_id;
    var lock_id = this.data.lock_id;
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
        if (paramobj['regpoint_id'] != undefined && paramobj['regpoint_id'] > 0) {
          regpoint_id = paramobj['regpoint_id'];
          that.setData({
            regpoint_id: paramobj['regpoint_id']
          });
        }
        if (paramobj['lock_id'] != undefined && paramobj['lock_id'] > 0) {
          lock_id = paramobj['lock_id'];
          that.setData({
            lock_id: paramobj['lock_id']
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
    if (options.regpoint_id != undefined && options.regpoint_id > 0) {
      regpoint_id = options.regpoint_id
      that.setData({
        regpoint_id: regpoint_id
      });
    }
    if (options.lock_id != undefined && options.lock_id > 0) {
      lock_id = options.lock_id
      that.setData({
        lock_id: lock_id
      });
    }
    // var healthkey = "health"+app.globalData.userid;
    // var healthlog = wx.getStorageSync(healthkey);
    // //console.log('healthkey:'+healthkey)
    // //console.log(healthlog)
    // if (healthlog != undefined && healthlog != '') {
    //   healthlog = JSON.parse(healthlog);
    //   this.setData({
    //     username: healthlog.username,
    //     phone: healthlog.phone,
    //     address1: healthlog.address1,
    //     address2: healthlog.address2,
    //     job: healthlog.job,
    //   })
    // }
  },
  usernameInput:function(e){
    this.setData({
      username: e.detail.value
    });
  },
  phoneInput:function(e){
    this.setData({
      phone: e.detail.value
    });
  },
  curaddressInput:function(e){
    this.setData({
      curaddress: e.detail.value
    });
  },
  addressInput1:function(e){
    this.setData({
      address1: e.detail.value
    });
  },
  addressInput2:function(e){
    this.setData({
      address2: e.detail.value
    });
  },
  jobInput:function(e){
    this.setData({
      job: e.detail.value
    });
  },
  yiquChange(e) {
    //console.log(e);
    this.setData({
      yiquIndex: e.detail.value
    })
  },
  registerChange(e) {
    //console.log(e);
    this.setData({
      registerIndex: e.detail.value
    })
  },
  healthChange(e) {
    //console.log(e);
    this.setData({
      healthIndex: e.detail.value
    })
  },
  uploadManyou() {
    var that = this;
    wx.chooseImage({
      count: 1, //默认9
      sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album'], //从相册选择
      success: (res) => {
        //console.log(res)
        wx.uploadFile({
          url: app.globalData.domain+'/api/base/upload', //
          filePath: res.tempFilePaths[0],
          name: 'file',
          formData: {
            token: app.globalData.token
          },
          header:{
            "Authorization": app.globalData.token
          },
          success (resa){
            //console.log('resa')
            //console.log(resa)
            var uploadmanyou =  JSON.parse(resa.data);
            uploadmanyou = uploadmanyou['data'];
            that.setData({
              uploadmanyou: uploadmanyou
            })
          }
        })
        that.setData({
          manyouimg: res.tempFilePaths[0]
        })
      }
    });
  },
  uploadtxz(){
    var that = this;
    wx.chooseImage({
      count: 1, //默认9
      sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
      sourceType: ['album'], //从相册选择
      success: (res) => {
        //console.log(res)
        wx.uploadFile({
          url: app.globalData.domain+'/api/base/upload',// url: 'https://wxapp.wmj.com.cn/api/upload/uploadimg',
          filePath: res.tempFilePaths[0],
          name: 'file',
          formData: {
            token: app.globalData.token
          },
          header:{
            "Authorization": app.globalData.token
          },
          success (resa){
            //console.log('resa')
            //console.log(resa)
            var uploadtxz =  JSON.parse(resa.data);
            uploadtxz = uploadtxz['data'];
            that.setData({
              uploadtxz: uploadtxz
            })
          }
        })
        that.setData({
          txzimg: res.tempFilePaths[0]
        })
      }
    });
  },
  bindTapLocation(){
    //console.log('aaa');
    var that = this;
    wx.getSetting({
      success: (res) => {
        //console.log(JSON.stringify(res))
        if (res.authSetting['scope.userLocation']!= true) {
          //console.log('scope.userLocation!=true')
          wx.openSetting({
            success: function (dataAu) {
              //console.log('dataAu')
              //console.log(dataAu)
              if (dataAu.authSetting["scope.userLocation"] == true) {
                that.getLocation();
              } else {
                wx.showToast({
                  title: '请先授权',
                  icon: 'none',
                  mask: true,
                  duration: 1500
                })
              }
            },
            fail(res){
              //console.log('openSetting-fail-res')
              //console.log(res)
            }
          })
        }else{
          //console.log('scope.userLocation==true')
          that.getLocation();
        }
      },
      fail(res){
        //console.log('getSetting-fail-res')
        //console.log(res)
      }
    })
    /**/
  },
  getLocation(){
    var that = this;
    //console.log('getLocation-that.data');
    //console.log(that.data);
    wx.getLocation({
      type: 'gcj02', //返回可以用于wx.openLocation的经纬度
      success (res) {
        //console.log('getLocation-res');
        //console.log(res)
        wx.chooseLocation({
          latitude: res.latitude,
          longitude: res.longitude,
          success(resa){
            //console.log('getLocation-resa')
            //console.log(resa)
            that.setData({
              curaddress: resa.name,
              latitude: resa.latitude,
              longitude: resa.longitude
            });
          }
        })
      }
    })
  },
  uploadData() {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    var timestamp = Date.parse(new Date());
    timestamp = timestamp /1000;
    var that = this;
    // //console.log('thatdata');
    // //console.log(that.data);
    var phone = that.data.phone;
    var username = that.data.username;
    var address1 = that.data.address1;
    var address2 = that.data.address2;
    var job = that.data.job;
    var userid = app.globalData.userid;
    var user_id = that.data.user_id;
    var regpoint_id = that.data.regpoint_id;
    var lock_id = that.data.lock_id;
    var healthlog = {phone:phone,username:username,address1:address1,address2:address2,job:job};
    if (!that.data.username) {
      wx.showToast({
        title: '请输入姓名',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    var myreg = /^[1][1-9][0-9]{9}$/;
    if (!myreg.test(phone)) {
      wx.showToast({
        title: '请输入正确手机号',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    if (!that.data.curaddress) {
      wx.showToast({
        title: '请选择当前位置',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    if (!that.data.address1) {
      wx.showToast({
        title: '请输入居住地址',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }

    if (!that.data.job) {
      wx.showToast({
        title: '请输入工作或学习单位',
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      return false;
    }
    // if (!that.data.uploadmanyou) {
    //   wx.showToast({
    //     title: '请上传漫游地截图',
    //     icon: 'none',
    //     mask: true, // 防止触摸穿透
    //     duration: 2000
    //   });
    //   return false;
    // }
    // if (!that.data.uploadtxz) {
    //   wx.showToast({
    //     title: '请上传证明截图',
    //     icon: 'none',
    //     mask: true, // 防止触摸穿透
    //     duration: 2000
    //   });
    //   return false;
    // }
    var yiquIndex = parseInt(that.data.yiquIndex);
    yiquIndex = yiquIndex + 1;
    var postdata = {
      user_id: user_id,
      regpoint_id: regpoint_id,
      openid: app.globalData.openid,
      name: username,
      mobile: phone,
      position: that.data.curaddress,
      lat: that.data.latitude,
      lng: that.data.longitude,
      first_address: address1,
      second_address: address2,
      job: job,
      yiqu: parseInt(that.data.yiquIndex) + 1,
      register_type: parseInt(that.data.registerIndex)+1,
      health: parseInt(that.data.healthIndex)+1,
      manyou: that.data.uploadmanyou,
      txz: that.data.uploadtxz,
      utime:timestamp
    };
    //console.log('postdata:')
    //console.log(postdata)
    wx.request({
      url: app.globalData.domain+'/api/Health/add',
      method: 'POST',
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        user_id: user_id,
        regpoint_id: regpoint_id,
        openid: app.globalData.openid,
        name: username,
        mobile: phone,
        position: that.data.curaddress,
        lat: that.data.latitude,
        lng: that.data.longitude,
        first_address: address1,
        second_address: address2,
        job: job,
        yiqu: parseInt(that.data.yiquIndex) + 1,
        register_type: parseInt(that.data.registerIndex)+1,
        health: parseInt(that.data.healthIndex)+1,
        manyou: that.data.uploadmanyou,
        txz: that.data.uploadtxz,
        utime:timestamp
      },
      success: function (res) {
        //console.log('uploadData-res');
        //console.log(res);
        wx.showToast({
          title: res.data.msg,
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        if (res.data.status ==200) {
          // wx.setStorage({
          //   key:"health"+userid,
          //   data:JSON.stringify(healthlog)
          // })
          if (lock_id > 0) {
            wx.navigateTo({
              url: '../open/open?user_id='+user_id+'&lock_id='+lock_id
            });
          }else{
            wx.navigateTo({
              url: '../healthlist/healthlist'
            });
          }
        }
      }
    })
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
      wx.login({
        success: res => {
          //console.log('res.code:'+res.code)
          wx.request({
            url: app.globalData.domain+'/api/Member/getphonenumber',
            data: {
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
                  phone: phone
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
                  wx.hideLoading();
                }
              })
            }
          })
        }
      })
    }
  }
})