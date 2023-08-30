const app = getApp();
let request = require('../../module/request/index');
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
  onShow:async function () {
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

    console.log("app.globalData.adminInfo",app.globalData.adminInfo)
      if (app.globalData.adminInfo&&app.globalData.adminInfo.length !=0 )
      {
        that.setData({
          realname: app.globalData.adminInfo.name,
          username: app.globalData.adminInfo.user,
          btn: '重置密码',
          manageurl:app.globalData.domain
        });
      } else {
        let viewuserid=  await request.HttpPost("Member/viewuserid",{
          member_id: app.globalData.userid
        }).catch(()=>{})
        if(!viewuserid){
return
        }

        var tmpuser_id = viewuserid.data.user_id;
        if (tmpuser_id != '') {
          that.setData({
            realname: viewuserid.data.name,
            username: viewuserid.data.user,
            btn: '重置密码',
          })
        }

      }

  },
  onLoad: function (options) {
    //console.log('adduser-onLoad-app.globalData');
    //console.log(app.globalData);
  },
  copyYhm(){

        var sn = this.data.username; //

        wx.setClipboardData({
            data: sn,
            success(res) {
                console.log('success', res);
                wx.showToast({
                    title: "复制用户成功",
             
                    mask: true, // 防止触摸穿透
                    duration: 2000
                });
            }
        })
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
  uploadData:async function() {
    var user_id = app.globalData.user_id;

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

     let updatePasswordRes =await request.HttpPost("User/updatePassword", {
        user_id: user_id,
        pwd: pwd,
        repwd: repwd
      }).catch((res)=>{})
      if(!updatePasswordRes){
        return
      }

      wx.showToast({
        title: updatePasswordRes.msg,
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      setTimeout(function(){
        wx.switchTab({
          url: '../user/user'
        })
      },2000);

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

     let adduser= await request.HttpPost("User/adduser",{
       member_id: app.globalData.userid,
       name: realname,
       user: username,
       pwd: pwd
     }).catch()

    if(!adduser){
      return
    }
      console.log("adduser",adduser)
      app.globalData.user_id = adduser.user_id;
      app.globalData.adminInfo = {name:realname,user:username,user_id:adduser.user_id}
      let UserInfo=  wx.getStorageSync('UserInfo')
      UserInfo.useradmininfo =    app.globalData.adminInfo
      wx.setStorageSync('UserInfo',UserInfo)
      setTimeout(function(){
        wx.switchTab({
          url: '../user/user'
        })
      },2000);
    }
  }
})
