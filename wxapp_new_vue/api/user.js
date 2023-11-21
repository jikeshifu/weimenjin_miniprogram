
const httpRequest = require('./http/request.js');
import { setToken, getToken } from "../libs/auth.js"


// 登录
export function login(){

	return  new Promise((resolve, reject) => {
		uni.login({
			// provider: 'payment',
			// provider: 'weixin',
			success: async (loginRes) => {
				// #ifdef MP-WEIXIN
				let res = await wechatoauth_api({ code: loginRes.code }).catch((err)=>{
					resolve({err:reject})
				})
				if (res.code === 0) {
					setToken(res.data.token)
					resolve({err:0})
				}
				// #endif
				// #ifdef MP-ALIPAY
				let res = await alipayoauth_api({ code: loginRes.code }).catch((err)=>{
					resolve({err:reject})
				})
				if (res.status+'' == '200') {
					setToken(res.token)
					resolve({err:0})
				}
				// #endif

				resolve({err:res})
			}
		})

	})

}
// 登录
function wechatoauth_api(params){
	return httpRequest.request('/member.Member/login', params, 'POST');
}

function alipayoauth_api(params){
	return httpRequest.request('/member/alipaylogin', params, 'POST');
}
