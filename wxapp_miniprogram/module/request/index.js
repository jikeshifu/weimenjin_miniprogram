let member = require('../member/index');
let request = require('./request');


let HttpPost = async function (url, data = {}) {
    let token = wx.getStorageSync('token')
    if (!token) {
        await member.Login().catch((err) => {
            console.log("loginerr", err)
        })
    }
    wx.showLoading({
        title: '加载中',
    });
    return new Promise(async function (resolve, reject) {
      let requestRes =   await request.requestPost(url, data).catch(async (err) => {
   
            if (err.code === 101) {
                await member.Login().catch((err) => {
                    console.log("loginerr", err)
                })

                let reRequest = await request.requestPost(url, data).catch((err) => {
                    reject(err);
                    return
                })

                resolve(reRequest);
                return
            }else{
                console.log("err32:",err)
                let errMsg="网络错误"
                if(err.msg){
                    errMsg=err.msg
                }

                wx.showToast({
                    title: errMsg,
                    icon: 'none',
                    mask: true, // 防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })
        if(!requestRes){
          return
      }
        wx.stopPullDownRefresh();
        wx.hideLoading();
        resolve(requestRes);
        return

    })
}


module.exports = {
    HttpPost
}
