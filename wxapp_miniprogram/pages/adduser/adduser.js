const app = getApp();
Page({
  data: {
    realname: '', // 真实姓名
    username: '', // 用户名
    pwd: '',
    btn: '立即提交'
  },
  onShow:function () {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function (options) {
    console.log('adduser-onLoad-app.globalData');
    console.log(app.globalData);
    if (app.globalData.adminInfo) {
      this.setData({
        realname: app.globalData.adminInfo.name,
        username: app.globalData.adminInfo.user,
        btn: '修改密码'
      });
    }
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
  uploadData() {
    // var timestamp = Date.parse(new Date());
    // timestamp = timestamp /1000;
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
      return false;
    }
    var that = this;
    console.log(that.data);
    var btn = that.data.btn;
    if (btn=='修改密码') {
      wx.navigateTo({
        url: '../editpwd/editpwd'
      });
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
          title: '请输入用户名',
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
      console.log('adduser-uploadData-tmpdata2')
      console.log(tmpdata2)
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
          console.log('uploadData-res');
          console.log(res);
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