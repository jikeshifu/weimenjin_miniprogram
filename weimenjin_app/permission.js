// 页面白名单
const whiteList = [
	'/pages/personal/personal',
	'/pages/search/search'
]
let pages, currentPage


function hasPermission(url) {
	pages = getCurrentPages() //获取加载的页面
	currentPage = pages[pages.length - 1] //获取当前页面的对象


	let access_token = uni.getStorageSync('token')
	// 在白名单中或有token，直接跳转
	if (whiteList.indexOf(url) === -1 || access_token) {
		return true
	}
	return false
}

uni.addInterceptor('navigateTo', {
	// 页面跳转前进行拦截, invoke根据返回值进行判断是否继续执行跳转
	invoke(e) {
		if (!hasPermission(e.url)) {
			uni.setStorageSync('backPath', e) // 记录下登录成功返回页面
			uni.navigateTo({
				url: '/pages/login/login'
			})
			return false
		}
		return true
	},
	success(e) {
		// console.log(e)
	}
})

uni.addInterceptor('switchTab', {
	// tabbar页面跳转前进行拦截
	invoke(e) {
		if (!hasPermission(e.url)) {
			uni.setStorageSync('backPath', e)
			uni.navigateTo({
				url: '/pages/login/login'
			})
			return false
		}
		return true
	},
	success(e) {
		// console.log(e)
	}
})


// 在mian.js中 import './permission'