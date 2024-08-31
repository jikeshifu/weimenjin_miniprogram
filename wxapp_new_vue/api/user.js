import httpRequest from './http/request.js';
import { setToken, getToken } from "../libs/auth.js"

// 登录
export function login() {
  return new Promise((resolve, reject) => {
    uni.login({
      success: async (loginRes) => {
        // 微信小程序登录
        // #ifdef MP-WEIXIN
        let res = await wechatoauth_api({ code: loginRes.code }).catch(err => {
          resolve({ err: reject });
        });
        if (res.code === 0) {
          setToken(res.data.token);
          resolve({ err: 0 });
        }
        // #endif

        // 支付宝小程序登录
        // #ifdef MP-ALIPAY
        let res = await alipayoauth_api({ code: loginRes.authCode }).catch(err => {
          resolve({ err: reject });
        });
        if (res.status + '' === '200') {
          setToken(res.token);
          resolve({ err: 0 });
        }
        // #endif

        // 抖音小程序登录
        // #ifdef MP-TOUTIAO
        let res = await toutiaoauth_api({ code: loginRes.code }).catch(err => {
		console.log("toutiaoauth_api")
          resolve({ err: reject });
        });
        if (res.status + '' === '200') {
          setToken(res.token);
          resolve({ err: 0 });
        }
        // #endif

        resolve({ err: res });
      }
    });
  });
}

// 微信小程序授权API
function wechatoauth_api(params) {
  return httpRequest.request('/member.Member/login', params, 'POST');
}

// 支付宝小程序授权API
function alipayoauth_api(params) {
  return httpRequest.request('/member/alipaylogin', params, 'POST');
}

// 抖音小程序授权API
function toutiaoauth_api(params) {
  return httpRequest.request('/Member/toutiaoauth', params, 'POST');
}
