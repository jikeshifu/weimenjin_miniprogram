const apiUrl = "https://wxapp.wmj.com.cn"; //公共路径
const apirequestUrl = apiUrl+"/api"; 


function request(url, data, method, header) {
    return new Promise((resolve, reject) => {
		
	
        uni.request({
            url: apirequestUrl + url,
            data: data,
            method: method,
            header: header,
            success: function (res) {

                //返回什么就相应的做调整
                if (res.statusCode === 200) {
                    resolve(res.data);
                } else  if (res.statusCode === 403) {
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
                console.log('e', e)
                reject("网络出错");
            }
        });

    });

}


module.exports = {

    request: request,

};
