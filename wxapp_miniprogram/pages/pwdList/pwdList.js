var request = require('../../module/request/index');
Page({
    data: {
        search: '../../images/search.png',
        avatar: '../../images/avatar.png',
        formData: {
            lock_id: 0,

        },
        List: [],
        listlen: 0,
        looding: '../../images/looding.gif',
        hidelood: false,
        nodata: false,
    },

    onPullDownRefresh: function () {

        this.list()

    },
    bindscrolltolower: function () {

    },
    onShow: function (options) {
      this.setData({
        formData: {
            lock_id: options.lock_id
        }
    })
    this.list()
    },
    addPwd(){
   
    },
    operate(){
      let _this =this
      wx.showActionSheet({
        itemList: ['添加密码', '离线密码'],
         success  : async(res)=>{
          console.log(res.tapIndex )
          if(res.tapIndex ==0){
            wx.navigateTo({
              url: '../pwdList/pwdAdd/index?lock_id=' + _this.data.formData.lock_id
          })
            return
          }

          if(res.tapIndex ==1){
            let temporaryPassword = await request.HttpPost("device.Pwd/temporaryPassword", this.data.formData)
            if(temporaryPassword){
                console.log("temporaryPassword",temporaryPassword.data.pwd)
                wx.showModal({
                  title: '提示',
                  content: '临时密码：'+temporaryPassword.data.pwd,
                  showCancel:false,
                  confirmText:"复制密码",
                  success (res) {
                    if (res.confirm) {

                      wx.setClipboardData({
                        data: temporaryPassword.data.pwd,
                        success(res) {
                            console.log('success', res);
                            wx.showToast({
                                title: "复制临时密码成功",
                         
                                mask: true, // 防止触摸穿透
                                duration: 2000
                            });
                        }
                    })
                      console.log('用户点击确定')
                    } else if (res.cancel) {
                      console.log('用户点击取消')
                    }
                  }
                })

            }
            return
          }
        },
        fail (res) {
          console.log(res.errMsg)
        }
      })
    },
    pwdDel:async function(e){
        let pwd_id =e.currentTarget.dataset.pwd_id
        let _this =this
        wx.showModal({
            title: '删除',
            content: '您确定要删除该密码吗？',
            success : async function(res) {
                if (res.confirm) {
                    let delPwdRes = await request.HttpPost("device.Pwd/del", {
                        pwd_id:pwd_id,
                        lock_id:_this.data.formData.lock_id,
                    })
                    if(delPwdRes){
                        _this.list()
                    }
                } else if (res.cancel) {
                    //console.log('用户点击取消')
                }
            }
        })
    },
    list: async function () {
        let list = await request.HttpPost("device.Pwd/list", this.data.formData)
        if (list) {
            this.setData({
                List:list.data,
                listlen :list.data.length
            })


        }
        console.log("list", list)
    },
    onLoad: function (options) {
        this.setData({
            formData: {
                lock_id: options.lock_id
            }
        })
        this.list()

    },

    timestampToTime: function (timestamp) {
        if (timestamp == undefined || timestamp == 0) {
            return '';
        }
        var date = new Date(timestamp * 1000);
        var Y = date.getFullYear() + '-';
        var m = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
        var d = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
        var H = date.getHours() < 10 ? '0' + date.getHours() + ':' : date.getHours() + ':';
        var i = date.getMinutes() < 10 ? '0' + date.getMinutes() + ':' : date.getMinutes() + ':';
        var s = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
        return Y + m + d + H + i + s;
    }
})
