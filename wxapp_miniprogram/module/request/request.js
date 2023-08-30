
const urlApi ="https://wxapp.wmj.com.cn/api/"

let requestPost = function (url, data) {
    return new Promise(function (resolve, reject) {

        data.httpPost = 1
        wx.request({
            url:urlApi + url,
            method: "POST",
            header: {
                "Authorization": wx.getStorageSync('token')
            },
            data: data,
            success: async function (res) {

                console.log("res", res)
                let resData = res.data
                if (resData.code === 0 || resData.status === "200" || resData.opendoor_status === "200") {

                    resolve(res.data);
                    return
                } else {



                    reject(resData);
                    return
                }

            },
            fail: function (res) {

                wx.showToast({
                    title: '网络故障，请稍后重试',
                    icon: 'none',
                    mask: true, // 防止触摸穿透
                    duration: 2000
                });
                reject(res);
            }
        });

    })
}
module.exports = {
    requestPost
}
