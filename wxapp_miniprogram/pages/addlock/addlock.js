const app = getApp();
var request = require('../../module/request/index');
Page({
    data: {
        lock_sn: '',
        lock_name: '',
        user_id: 0,   // 管理员id，不是小程序用户的id
    },
    onShow: function () {
        //console.log('addlock-onShow')
        // app.globalData.user_id = 0;
        var that = this;

        if (app.globalData.user_id < 1) {
            wx.redirectTo({
                url: '../adduser/adduser'
            })
        }
    },
    onLoad: function () {
    },
    locksnInput: function (e) {
        this.setData({
            lock_sn: e.detail.value
        });
    },
    locknameInput: function (e) {
        this.setData({
            lock_name: e.detail.value
        });
    },
    bindScan() {
        var that = this;
        wx.scanCode({
            onlyFromCamera: true, // 只允许从相机扫码
            scanType: "qrCode",
            success: (res) => {
                // res.result 是二维码扫码的结果
                that.setData({
                    lock_sn: res.result
                });
            },
            fail: (res) => {
                wx.showToast({
                    title: '扫码失败请重试',
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
            }
        })
    },
    doSubmit: async function () {

        wx.showLoading({
            title: '执行中',
            mask: true
        })
        var that = this;
        //console.log('thatdata');
        //console.log(that.data);
        var lock_sn = that.data.lock_sn;
        var lock_name = that.data.lock_name;
        if (!lock_sn) {
            wx.showToast({
                title: '请输入序列号',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
            });
            return false;
        }
        if (!lock_name) {
            wx.showToast({
                title: '请输入设备名称',
                icon: 'none',
                mask: true, // 防止触摸穿透
                duration: 2000
            });
            return false;
        }
        var postdata = {
            member_id: app.globalData.userid,
            user_id: app.globalData.user_id,
            lock_sn: that.data.lock_sn,
            lock_name: that.data.lock_name
        };
        //console.log('postdata:')
        //console.log(postdata)

        let addRes = await request.HttpPost("Lock/add", postdata).catch((err)=>{
          console.log("err",err)
          if( err.status ===203){
            wx.navigateTo({
              url: '../adduser/adduser'
            })
          }
         
        })
        if (!addRes) {
          return
        }
      wx.showToast({
        title: addRes.data.msg,
        icon: 'none',
        mask: true, // 防止触摸穿透
        duration: 2000
      });
      wx.switchTab({
        url: '../index/index'
      })

    }
})
