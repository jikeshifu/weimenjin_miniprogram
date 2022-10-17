const app = getApp();
Page({
  data: {
    realname: '', // 真实姓名
    username: '', // 用户名
    pwd: '',
    repwd: '',
    btn: '立即提交',
    manageurl:'',
    editpwd: false, // false注册管理员, true修改密码
  },
  onShow:function () {
    var user_id = app.globalData.user_id;
    console.log('user_id',user_id);
    var that = this;
    if (user_id > 0) {
      var title =  '管理员信息';
      var editpwd = true;
    }else{
      var title = '注册管理员'
      var editpwd = false;
    }
    wx.setNavigationBarTitle({
      title: title
    });
    that.setData({
      editpwd: editpwd,
      manageurl: app.globalData.domain
    });
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }else{
      if (app.globalData.adminInfo) 
      {
        that.setData({
          realname: app.globalData.adminInfo.name,
          username: app.globalData.adminInfo.user,
          btn: '重置密码',
          manageurl:app.globalData.domain
        });
      } else {
        wx.request({
          url: app.globalData.domain+'/api/Member/viewuserid',
          method: 'POST',
          header:{
            "Authorization": app.globalData.token
          },
          data: {
            member_id: app.globalData.userid
          },
          success: function (resb) {
            console.log('app.js-onLaunch-login-resb',resb);
            if (resb.data.status == 200) {
              var tmpuser_id = resb.data.data.user_id;
              if (tmpuser_id != '') {
                that.setData({
                  realname: resb.data.data.name,
                  username: resb.data.data.user,
                  btn: '重置密码',
                })
              }
            }
          }
        })
      }
    }
  },
  onLoad: function (options) {
    //console.log('adduser-onLoad-app.globalData');
    //console.log(app.globalData);
  },
  realnameInput:function(e){
    this.setData({
      realname: e.detail.value
    });
  },
  usernameInput:function(e){
    this.setData({
      username: e.detail.value
    });
  },
  pwdInput:function(e){
    this.setData({
      pwd: e.detail.value
    });
  },
  repwdInput:function(e){
    this.setData({
      repwd: e.detail.value
    });
  },
  uploadData() {
    var user_id = app.globalData.user_id;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    var that = this;
    this.data.btn = that.data.btn;
    console.log('app.globalData.adminInfo',app.globalData.adminInfo);
    if (app.globalData.user_id>0) {
      var pwd = that.data.pwd;
      var repwd = that.data.repwd;
      var myreg = /(.+){6,20}$/;
      if (!myreg.test(pwd)) {
        wx.showToast({
          title: '新密码6-20位字母数字组合',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        return false;
      }
      if (pwd != repwd) {
        wx.showToast({
          title: '两次密码不一致',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        return false;
      }
      wx.request({
        url: app.globalData.domain+'/api/User/updatePassword',
        method: "POST",
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          user_id: user_id,
          pwd: pwd,
          repwd: repwd
        },
        success: function (res) {
          //console.log('uploadData-res',res);
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          if (res.data.status ==200) {
            setTimeout(function(){
              wx.switchTab({
                url: '../user/user'
              })
            },2000);
          }
        }
      })
    }else{
      var realname = that.data.realname;
      var username = that.data.username;
      var pwd = that.data.pwd;
      if (!realname) {
        wx.showToast({
          title: '请输入真实姓名',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        return false;
      }
      if (!username) {
        wx.showToast({
          title: '请输入用户名,一般为字母数字组成',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        return false;
      }
      var myreg = /(.+){6,20}$/;
      if (!myreg.test(pwd)) {
        wx.showToast({
          title: '密码6-20位',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
        return false;
      }
      var tmpdata2 = {
        member_id: app.globalData.userid,
        name: realname,
        user: username,
        pwd: pwd
      };
      console.log('adduser-uploadData-tmpdata2',tmpdata2)
      wx.request({
        url: app.globalData.domain+'/api/User/adduser',
        method: 'POST',
        header:{
          "Authorization": app.globalData.token
        },
        data: {
          member_id: app.globalData.userid,
          name: realname,
          user: username,
          pwd: pwd
        },
        success: function (res) {
          ////console.log('uploadData-res');
          ////console.log(res);
          wx.showToast({
            title: res.data.msg,
            icon: 'none',
            mask: true, // 防止触摸穿透
            duration: 2000
          });
          if (res.data.status ==200) {
            app.globalData.user_id = res.data.user_id;
            app.globalData.adminInfo = {name:realname,user:username,user_id:res.data.user_id}
            setTimeout(function(){
              wx.switchTab({
                url: '../user/user'
              })
            },2000);
          }
        }
      })
    }
  }
})