import request from './http/request.js';
import {
	setToken,
	getToken
} from '../libs/auth.js';
import { apiUrl } from '@/config/domain.js';
// 登录
export function login() {
	return new Promise((resolve, reject) => {
		const token = getToken(); // 检查是否已有登录 token

		if (token) {
			// 如果已登录，直接返回成功
			console.log('用户已登录，无需重复登录');
			resolve({
				err: 0
			});
			return;
		}

		// 检查是哪个平台，并处理不同平台的登录逻辑
		// #ifdef MP-WEIXIN
		console.log('正在执行微信小程序登录');
		uni.login({
			success: async (loginRes) => {
				let res = await wechatoauth_api({
					code: loginRes.code
				}).catch((err) => {
					reject({
						err
					});
				});
				if (res.code === 0) {
					setToken(res.data.token);
					uni.setStorageSync("USERINFO", res.data.memberInfo);
					resolve({
						err: 0
					});
				} else {
					reject({
						err: res
					});
				}
			}
		});
		// #endif

		// #ifdef MP-ALIPAY
		console.log('正在执行支付宝小程序登录');
		uni.login({
			success: async (loginRes) => {
				let res = await alipayoauth_api({
					code: loginRes.authCode
				}).catch((err) => {
					reject({
						err
					});
				});
				if (res.code === 0) {
					setToken(res.token);
					resolve({
						err: 0
					});
				} else {
					reject({
						err: res
					});
				}
			}
		});
		// #endif

		// #ifdef MP-TOUTIAO
		console.log('正在执行抖音小程序登录');
		uni.login({
			success: async (loginRes) => {
				let res = await toutiaoauth_api({
					code: loginRes.code
				}).catch((err) => {
					reject({
						err
					});
				});
				if (res.code === 0) {
					setToken(res.token);
					resolve({
						err: 0
					});
				} else {
					reject({
						err: res
					});
				}
			}
		});
		// #endif

		// iOS 和安卓原生应用登录逻辑
		// #ifdef APP-PLUS
		console.log('正在执行原生App登录');
		const platform = uni.getSystemInfoSync().platform;
		if (platform === 'ios' || platform === 'android') {
			// 跳转到登录页面
			console.log('iOS或安卓应用，跳转到登录页面');
			uni.navigateTo({
				url: '/pages/login/login' // 假设你有一个 login 页面
			});
			reject({
				err: '跳转到登录页面'
			});
		}
		// #endif
	});
}

// 微信小程序授权API
export function wechatoauth_api(params) {
	let url = apiUrl + '/member.Member/login';
	return request(url, params, 'POST');
}

// 支付宝小程序授权API
export function alipayoauth_api(params) {
	let url = apiUrl + '/member/alipaylogin';
	return request(url, params, 'POST');
}

// 抖音小程序授权API
export function toutiaoauth_api(params) {
	let url = apiUrl + '/Member/toutiaoauth';
	return request(url, params, 'POST');
}

// 发送短信验证码
export function sendSms_api(params) {
	let url = apiUrl + '/member.Member/sendSms';
	return request(url, params, 'POST');
}

// 验证码登录
export function smsLogin_api(params) {
	let url = apiUrl + '/member.Member/smsLogin';
	return request(url, params, 'POST');
}
