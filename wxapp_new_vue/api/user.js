
const httpRequest = require('./http/request.js');
import { setToken, getToken } from "../libs/auth.js"
// 登录
export function login(){

	return  new Promise((resolve, reject) => {

		uni.login({
			provider: 'weixin',
			success: async (loginRes) => {
				let res = await wechatoauth_api({ code: loginRes.code }).catch((err)=>{
					resolve({err:reject})
				})
				console.log("wechatoauth_api:",res)
				if (res.code === 0) {
					setToken(res.data.token)
					resolve({err:0})
				}
				resolve({err:res})
			}
		})

	})

}
// 登录
 function wechatoauth_api(params){
	return httpRequest.request('/member.Member/login', params, 'POST');
}
