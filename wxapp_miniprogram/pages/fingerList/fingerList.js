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
    onShow: function () {
        this.list()
    },
    addPwd() {
        wx.navigateTo({
            url: '../fingerList/fingerAdd/index?lock_id=' + this.data.formData.lock_id
        })
    },
    pwdDel: async function (e) {
        let finger_id = e.currentTarget.dataset.finger_id
        let _this = this
        wx.showModal({
            title: '删除',
            content: '您确定要删除该指纹吗？',
            success: async function (res) {
                if (res.confirm) {
                    let delPwdRes = await request.HttpPost("device.Finger/del", {
                        finger_id: finger_id,
                        lock_id: _this.data.formData.lock_id,
                    })
                    if (delPwdRes) {
                        _this.list()
                    }
                } else if (res.cancel) {
                    //console.log('用户点击取消')
                }
            }
        })
    },
    pwdEdit: async function (e) {
        let finger_id = e.currentTarget.dataset.finger_id

        wx.navigateTo({
            url: '../fingerList/fingerEdit/index?finger_id=' + finger_id
        })
    },
    list: async function () {
        let list = await request.HttpPost("device.Finger/list", this.data.formData)
        if (list) {
            this.setData({
                List: list.data,
                listlen: list.data.length
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
