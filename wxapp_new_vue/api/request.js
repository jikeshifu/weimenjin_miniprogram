const commonUrl = "https://wxapp.wmj.com.cn/api"; //公共路径

const HTTPS = 'https://wxapp.wmj.com.cn/api'
const imgurl = 'https://wxapp.wmj.com.cn'
const httpRequest = require('./http/request.js');
import {
	getToken,
	setToken,
	removeToken
} from '@/libs/auth';
import {
	login
} from '@/api/user';
import {
	getRoute
} from '@/libs/utils.js'


// post请求封装
async function myRequest(url, data, method = "GET" || "POST" || "PUT" || "DELETE") {

	let header = {
		"content-type": "application/json"
	}
	if (!getToken()) {
		await login()
	}
	header.Authorization = getToken()
	let requestRes = await httpRequest.request(url, data, method, header)
	// console.log("requestRes", requestRes)
	if (requestRes.code === 101) {
		// 登录过期
		await login()
		header.Authorization = getToken()
		requestRes = await httpRequest.request(url, data, method, header)
	}
	// console.log("requestRes2", requestRes)
	return requestRes

}



// 图片上传封装
function uploadImg(url, data) {
	let promise = new Promise((resolve, reject) => {
		let header = {
			"Accept": "application/json",
			"Authorization": getToken()
		}
		uni.uploadFile({
			url: commonUrl + url,
			filePath: data.image,
			name: 'image',
			header: header,
			success: res => {
				res.data = JSON.parse(res.data)
				if (res.statusCode == 200) {
					// 网络请求成功时返回
					resolve(res.data);
				} else if (res.statusCode === 101) {
					// 登录过期
					removeToken('token');
					uni.switchTab({
						url: '/pages/index/index'
					})
					resolve(res);
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
			fail: err => {
				console.log(err)
				reject("网络出错:" + err);
			}
		});

	});
	return promise;
}

module.exports = {
	myRequest: myRequest,
	commonUrl: commonUrl,
	uploadImg: uploadImg,
	HTTPS: HTTPS,
	imgurl: imgurl
};