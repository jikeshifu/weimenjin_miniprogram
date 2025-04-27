const apiUrl = "https://demo.wmj.com.cn/api"; // 公共路径

// 请求封装
export default function request(url, data, method = 'GET', header = { 'Content-Type': 'application/json' }) {
    return new Promise((resolve, reject) => {
        uni.request({
            url: apiUrl + url,
            data: data,
            method: method,
            header: header,
            success: function (res) {
                if (res.statusCode === 200) {
                    resolve(res.data);
                } else if (res.statusCode === 403) {
                    uni.showToast({
                        title: '403：拒绝访问',
                        duration: 2000,
                        icon: 'none'
                    });
                    resolve(res);
                } else if (res.statusCode === 404) {
                    uni.showToast({
                        title: '404：网络请求不存在',
                        duration: 2000,
                        icon: 'none'
                    });
                    resolve(res);
                } else if (res.statusCode === 500) {
                    uni.showToast({
                        title: '500：服务器异常',
                        duration: 2000,
                        icon: 'none'
                    });
                    resolve(res);
                } else {
                    uni.showToast({
                        title: '未知错误',
                        duration: 2000,
                        icon: 'none'
                    });
                    resolve(res);
                }
            },
            fail: function (e) {
                console.log('e', e);
                reject("网络出错");
            }
        });
    });
}
