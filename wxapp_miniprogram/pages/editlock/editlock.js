// var dateTimePicker = require('../../utils/dateTimePicker.js');
let request = require('../../module/request/index');
const app = getApp()
Page({
    data: {
        looding: '../../images/looding.gif',
        lock_id: 0,
        lock_qrcode: '',
        lock_sn: '',
        mobile_check: '',
        applyauth: '', // 申请钥匙
        applyauth_check: '', // 审核钥匙
        location_check: 0, // 开门距离
        status: '', // 启用/禁用
    },
    onShow: async function () {
        //console.log('editlock-onShow');
        var that = this;
        let LockInfo = await request.HttpPost("Lock/view", {
            lock_id: that.data.lock_id
        }).catch((err) => {
            console.log("err", err)
        })
        if (!LockInfo) {
        return
        }
      var result = LockInfo.data;
      console.log("result", result)
      that.setData({
        lock_name: result.lock_name,
        lock_sn: result.lock_sn,
        mobile_check: result.mobile_check,
        applyauth: result.applyauth,
        applyauth_check: result.applyauth_check,
        location_check: result.location_check,
        status: result.status,
      });

    },
    onLoad: function (options) {
        var that = this;
        if (options.lock_id != undefined && options.lock_id > 0) {
            that.setData({
                lock_id: options.lock_id
            });
        }
    },
    locknameInput: function (e) {
        this.setData({
            lock_name: e.detail.value
        });
    },
    mobilecheckChange: function (e) {
        this.setData({
            mobile_check: e.detail.value ? 1 : 0
        });
    },
    applyauthChange: function (e) {
        this.setData({
            applyauth: e.detail.value ? 1 : 0
        });
    },
    applyauthcheckChange: function (e) {
        this.setData({
            applyauth_check: e.detail.value ? 1 : 0
        });
    },
    locationcheckInput: function (e) {
        this.setData({
            location_check: e.detail.value
        });
    },
    statusChange: function (e) {
        this.setData({
            status: e.detail.value ? 1 : 0
        });
    },
    doSubmit: function () {
        wx.showLoading({
            title: '执行中',
            mask: true
        })
        var that = this;
       let res = request.HttpPost("Lock/update",{
          lock_id: that.data.lock_id, // 锁id
          lock_name: that.data.lock_name,
          mobile_check: that.data.mobile_check,
          applyauth: that.data.applyauth,
          applyauth_check: that.data.applyauth_check,
          location_check: that.data.location_check,
          status: that.data.status
        })
      if(!res){
        return
      }
      wx.showToast({
        title: '修改成功',
        icon: 'success',
        mask: false, // 此处允许触摸穿透
        duration: 2000
      });
      setTimeout(function () {
        wx.navigateBack({
          delta: 1
        });
      }, 2000);

    }
})
