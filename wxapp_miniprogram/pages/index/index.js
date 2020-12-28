const app = getApp()
Page({
  data: {
    openid: '',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo'),
    looding: '../../images/looding.gif',
    lock_close: '../../images/lock_close.png',
    lock_open: '../../images/lock_open.png',
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
    closeAd: true, // 广告弹层是否关闭 false 不关闭
    onlyimg: '../../images/ad.jpg',
    adnum: 1, // 显示开门成功样式几： 1原来的两张图片的,2新的只显示一张图片的
    openadurl: '', // 点击图片打开的链接
    adw:600, // 广告弹层的宽单位rpx
    hitshowminiad: false,
    location_check: false, // 是否需要定位，false不需要
    latitude: '',
    longitude: '',
    dropArr:[],
    dropIndex: -1 // 管理下拉显示的索引，-1全不显示下拉。大于-1显示对应索引的下拉
  },
  onPullDownRefresh: function () {
    this.setData({
      listarr: [],
      listlen: 1,  //
      dropArr:[]
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
    wx.showToast({
      title: '正在加载',
      icon: 'none',
      mask: true, // 防止触摸穿透
      duration: 2000
    });
    console.log(app.globalData)
    if (app.globalData.userid < 1) {
      that.login();
      // setTimeout(function(){
      //   if (app.globalData.userid < 1) {
      //     wx.hideLoading();
      //     that.setData({
      //       close:false
      //     })
      //   }else{
      //     // if (that.data.listarr.length <1) {
      //       that.getmore(1,that.data.num,0);
      //     // } else {
      //     //   wx.hideLoading();
      //     // }
      //   }
      // },2000);
    }else{
      that.getmore(1,that.data.num,0);
    }
    var aaa = setInterval(function(){
      //console.log('aa');
      that.getmore(1,that.data.num,0);
    },5000);
  },
  onLoad: function () {
    var that = this;
    wx.getSystemInfo({
      success: function (res){
        that.setData({
          scrollHeight: res.windowHeight,
          adw: res.windowWidth * 2-60,
        });
      }
    });
  },
  getmore: function(page,num,addto){ // addto为0覆盖原有数据，为1在原有数据基础上追加数据
    console.log('index.js-getmore')
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
          //console.log('getmore-success-resa');
          //console.log(resa);
          var arr = [];
          var tmpdropIndex = that.data.dropIndex;
          if (resa.data.status == 200) {
            var arrdata = resa.data.data.list
            if(arrdata.length > 0){
              var timestamp = Date.parse(new Date())/1000;
              var tmpdroparr = [];
              for (var i = 0; i < arrdata.length; i++) {
                tmpdroparr.push(false);
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
                tmpobj['lockauth_id'] = arrdata[i]['lockauth_id']; // 钥匙id
                tmpobj['user_id'] = arrdata[i]['user_id']; // 锁的管理员id
                tmpobj['auth_status'] = arrdata[i]['auth_status']; // 已审核|1,未审核|0
                tmpobj['auth_isadmin'] = arrdata[i]['auth_isadmin'];
                tmpobj['location_check'] = arrdata[i]['location_check']; //
                tmpobj['auth_shareability'] = arrdata[i]['auth_shareability']; //auth_shareability为0时或已过期时，不能分享，审核中不能分享
                tmpobj['lockstatus'] = arrdata[i]['lockstatus']; // 0是关上的，1是打开的
                tmpobj['type'] = arrdata[i]['type']; // 9在锁名后面显示开门状态
                tmpobj['longitude'] = 0;
                tmpobj['latitude'] = 0;
                if (arrdata[i]['location'] != '' && arrdata[i]['location'] != null) {
                  var tmplocation = JSON.parse(arrdata[i]['location']); // "{"longitude":106.710689,"latitude":26.574774,"address":"贵州省贵阳市南明区市府社区服务中心都司路9号"}"
                  tmpobj['longitude'] = tmplocation['longitude'];
                  tmpobj['latitude'] = tmplocation['latitude'];
                }
                tmpobj['showcard'] = 0; // 是否显示卡片菜单，0不显示，1显示
                var tmplock_sn = arrdata[i]['lock_sn'];
                if (tmplock_sn.indexOf("WMJ62") >=0 || tmplock_sn.indexOf("WMJ42") >=0) {
                  tmpobj['showcard'] = 1;
                }
                tmpobj['audio'] = 0; // 语音配置,0不支持，1支持
                if (tmplock_sn.indexOf("WMJ62") >=0) { // 只有WMJ62的支持
                  tmpobj['audio'] = 1;
                }
                arr.push(tmpobj);
              }
              if (addto>0) {
                var newdata = that.data.listarr.concat(arr);
                var newdroparr = that.data.dropArr.concat(tmpdroparr);
              }else{
                var newdata = arr;
                var newdroparr = tmpdroparr;
              }
              if (tmpdropIndex > -1) {
                newdroparr[tmpdropIndex] = true;
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
              if (tmpdropIndex > -1) {
                newdroparr[tmpdropIndex] = true;
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
              }
              else
              {
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
    // //console.log("计算结果", s)
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
        //console.log('opendoor-res');
        //console.log(res);
        wx.hideLoading();
        if (res.data.opendoor_status == '200') {
          that.setData({
            closeAd: false,
            successimg: app.globalData.domain+res.data.successimg,
            successadimg: app.globalData.domain+res.data.successadimg,
            openadurl: res.data.openadurl,
            adnum: res.data.adnum,
            hitshowminiad:res.data.hitshowminiad
          })
          setTimeout(function(){
            that.setData({
              closeAd: true
            })
          },5000);
        }else if (res.data.opendoor_status=='202') {
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          setTimeout(function(){
            wx.navigateTo({
              url: '../bindphone/bindphone'
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
      close:true,
      listlen:0
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
    app.globalData.userInfo = e.detail.userInfo
    that.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
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
        mobile: '',
        sex: userInfo.gender,
        member_ps: 1,
      },
      success: function (resa) {
        //console.log('index-resa');
        //console.log(resa);
        wx.hideLoading();
        if (resa.data.status == 200) {
          that.setData({
            close: true
          });
          that.getmore(1,that.data.num,0);
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
  updateUserInfo: function(data) {
    //console.log('updateUserInfo');
    var that = this;
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
                  //console.log('index-resa');
                  //console.log(resa);
                  if (resa.data.status == 200) {
                    app.globalData.token = resa.data.token;
                    app.globalData.userid = resa.data.data.member_id;
                    app.globalData.openid = resa.data.data.openid;
                    app.globalData.phone = resa.data.data.mobile;
                  }
                  var tmpdata1 = {member_id: resa.data.data.member_id};
                  //console.log('index-updateUserInfo-tmpdata1')
                  //console.log(tmpdata1)
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
                      //console.log('index-updateUserInfo-resb');
                      //console.log(resb);
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
  login: function () {
    var that = this;
    // 登录
    wx.login({
      success: res => {
        console.log('index-login-success-res')
        console.log(res)
        if (res.code) {
          // 可以将 res 发送给后台解码出 unionId
          //发起网络请求
          wx.request({
            url: app.globalData.domain+'/api/Member/login',
            data: {
              code: res.code,
            },
            method: 'POST',
            success: function (resa) {
              console.log('login-resa');
              console.log(resa);
              if (resa.data.status+"" == "200") {
                app.globalData.token = resa.data.token;
                app.globalData.userid = resa.data.data.member_id;
                app.globalData.openid = resa.data.data.openid;
                app.globalData.phone = resa.data.data.mobile == null ? '' :resa.data.data.mobile;
                if (resa.data.data.useradmininfo.user_id != undefined) {
                  app.globalData.user_id = resa.data.data.useradmininfo.user_id;
                }
                if (resa.data.data.headimgurl == null || resa.data.data.headimgurl == '') {
                  that.setData({
                    close:false
                  })
                }else{
                  var tmpuserInfo = {};
                  tmpuserInfo['avatarUrl'] = resa.data.data.headimgurl;
                  tmpuserInfo['nickName'] = resa.data.data.nickName;
                  app.globalData.userInfo = tmpuserInfo;
                  that.getmore(1,that.data.num,0);
                }
              }
              // that.getmore(1,that.data.num,0);
            }
          })
        }
      },
      fail: res =>{
      }
    })
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
      }
    })
  },
  goShare: function (e) {
    var adminid = e.currentTarget.dataset['adminid']; // 锁管理员user_id
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../sharekeys/sharekeys?lock_id='+lock_id+'&user_id='+adminid
    })
  },
  switchBox: function(e) {
    var index = e.currentTarget.dataset['index'];
    var tmpdrop = this.data.dropArr;
    if (tmpdrop[index]) {
      tmpdrop[index] = false;
    }else{
      tmpdrop[index] = true;
    }
    this.setData({
      dropIndex: index,
      dropArr: tmpdrop
    });
  },
  manageKey: function (e) {
    var adminid = e.currentTarget.dataset['adminid']; // 锁管理员user_id
    var lock_id = e.currentTarget.dataset['lockid']; //
    var showcard = e.currentTarget.dataset['showcard']; // 0不显示添加卡,1显示
    wx.navigateTo({
      url: '../managekey/managekey?lock_id='+lock_id+'&user_id='+adminid+'&showcard='+showcard
    })
  },
  allopenlogs: function (e) {
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../allopenlogs/allopenlogs?lock_id='+lock_id
    })
  },
  lockdetail: function (e) {
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../lock/lock?lock_id='+lock_id
    })
  },
  //修改
  editlock: function (e) {
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../editlock/editlock?lock_id='+lock_id
    })
  },
  cardlist: function (e) {
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../cardlist/cardlist?lock_id='+lock_id
    })
  },
  addcard: function (e) {
    var adminid = e.currentTarget.dataset['adminid']; // 管理员user_id的值
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../addcard/addcard?lock_id='+lock_id+'&user_id='+adminid
    })
  },
  configaudio: function (e) {
    var adminid = e.currentTarget.dataset['adminid']; // 管理员user_id的值
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../configaudio/configaudio?lock_id='+lock_id+'&user_id='+adminid
    })
  },
  townership: function (e) {
    var lockauth_id = e.currentTarget.dataset['lockauthid']; // 钥匙id
    var lock_id = e.currentTarget.dataset['lockid']; //
    wx.navigateTo({
      url: '../townership/townership?lock_id='+lock_id+'&lockauth_id='+lockauth_id
    })
  },
  openweb: function (e) {
    var tmpopenadurl = this.data.openadurl;
    if (tmpopenadurl) {
      wx.navigateTo({
        url: '../web/web?url='+tmpopenadurl
      })
    }
  },
  deleteKey: function (e) {
    var that = this;
    var id = e.currentTarget.dataset['lockauthid']; //
    wx.showModal({
      title: '删除',
      content: '您确定要丢弃此钥匙吗？',
      success (res) {
        if (res.confirm) {
          //console.log('用户点击确定')
          //console.log(id)
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
              //console.log('删除反馈')
              //console.log(resa)
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
          //console.log('用户点击取消')
        }
      }
    })
  },
  getAdmin: function () {
    wx.request({
      url: app.globalData.domain+'/api/Member/viewuserid',
      method: 'POST',
      header:{
        "Authorization": resa.data.token
      },
      data: {
        member_id: app.globalData.userid
      },
      success: function (resb) {
        //console.log('index-updateUserInfo-resb');
        //console.log(resb);
        if (resb.data.status == 200) {
          var tmpuser_id = resb.data.data.user_id;
          if (tmpuser_id != '') {
            app.globalData.user_id = resb.data.data.user_id;
          }
        }
      }
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
  },

  onShareAppMessage: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
      path: "/pages/index/index"
    };
  },
  onShareTimeline: function () {
    return {
      title: app.globalData.xcxname,
      imageUrl: app.globalData.domain+app.globalData.shareImg,
    }
  }
})