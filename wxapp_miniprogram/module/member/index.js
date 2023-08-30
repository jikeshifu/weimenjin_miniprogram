
let request = require('../request/request');

function getCode() {
    return new Promise(function (resolve, reject) {

        wx.login({
            success:  res => {
                console.log('index-login-success-res', res)
                if (res.code) {
                    resolve(res.code)
                }
                reject("获取失败")
            },
            fail: res => {
                console.log("getCodeErr", err)
                reject(res)
            }
        })
    })
}

let Login =async function () {
    return new Promise(async function (resolve, reject) {
        let code = await getCode().catch(() => {
        })
        console.log("code",code)
 
        if (!code) {
            reject("登录失败")
            return
        }
        let UserInfo = await request.requestPost("Member/login", {
            code: code,
        }).catch((err) => {
            console.log("err", err)
            reject(err)
        })
        if(!UserInfo){
            reject("登录失败")
            return
        }


        wx.setStorageSync('token', UserInfo.token)
        wx.setStorageSync('UserInfo', UserInfo.data)
        wx.setStorageSync('tokenTimeOut', (Date.parse(new Date())+(3600*1000*24*7)))

        getApp().globalData.userInfo = UserInfo.data
        getApp().globalData.userid  =UserInfo.data.member_id
        getApp().globalData.phone = UserInfo.data.mobile
        getApp().globalData.token  =UserInfo.token
        if(UserInfo.data.useradmininfo){
            getApp().globalData.user_id  = UserInfo.data.useradmininfo.user_id
            getApp().globalData.adminInfo  =UserInfo.data.useradmininfo
        }



        setTimeout(()=>{
            resolve(UserInfo)
        },100)
    })


}

module.exports = {
    Login,

}
