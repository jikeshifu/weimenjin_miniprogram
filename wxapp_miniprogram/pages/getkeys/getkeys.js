const app = getApp()
var request = require('../../module/request/index');
Page({
    data: {
        looding: '../../images/looding.gif',
        successimg: '../../images/success.png',
        hidelood: false,
        member_id: 0,
        lockauth_id: 0,  // 钥匙id
        close: true  // 登录弹层是否关闭 false不关闭
    },
    onShow: function () {
        var that = this;
        wx.showLoading({
            title: '领取钥匙中',
            mask: true
        })
        //console.log('getkeys-onShow')
        //console.log(app.globalData);
        // if (app.globalData.userid > 1) {
        setTimeout(function () {
            //console.log('getkeys-onShow-setTimeout')
            that.getkey();
        }, 2000);
        // }else{
        //   that.getkey();
        // }
    },
    onLoad: function (options) {
        //console.log('getkeys-onload-options:');
        //console.log(options);
        //console.log(app.globalData.userid);
        var that = this;
        if (options.member_id != undefined && options.member_id > 0) {
            that.setData({
                //member_id: options.member_id
                member_id: app.globalData.userid
            });
        }
        if (options.lockauth_id != undefined && options.lockauth_id > 0) {
            that.setData({
                lockauth_id: options.lockauth_id //锁管理员id
            });
        }
    },
    cancelLogin: function () {
        var that = this;
        that.setData({
            close: true
        })
        wx.showToast({
            title: '登录后才能领取钥匙',
            icon: 'none',
            mask: true,
            duration: 2000
        })
        setTimeout(function () {
            that.setData({
                close: false
            })
        }, 2000);
    },
    closemask: function () {
        this.setData({
            close: true
        })
    },
    getUserInfo: function (e) {
        wx.showLoading({
            title: '登录中',
            mask: true
        })
        //console.log('getUserInfo-e');
        //console.log(e);
        app.globalData.userInfo = e.detail.userInfo
        this.setData({
            userInfo: e.detail.userInfo,
            hasUserInfo: true
        })
        this.updateUserInfo(e.detail);
    },
    updateUserInfo: function (data) {
        //console.log('updateUserInfo');

    },
    getkey: async function () {
        var that = this;


        let getkey = await request.HttpPost("LockAuth/getkey", {
            member_id: that.data.member_id, //
            lockauth_id: that.data.lockauth_id
        }).catch((err) => {
            console.log("取钥匙err",err)
            wx.showToast({
                title: err.msg,
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
            });
            setTimeout(function () {
                wx.switchTab({
                    url: '../index/index'
                })
            }, 2000);
        })
        if (!getkey) {
     return
        }
      wx.showToast({
        title: '钥匙领取成功',
        icon: 'success',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      setTimeout(function () {
        // wx.hideLoading();
        wx.switchTab({
          url: '../index/index'
        })
      }, 2000);


    }
})
