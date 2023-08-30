const TOKEN = 'token';

export function getToken() {	
	try {
		return uni.getStorageSync(TOKEN);  
	} catch (e) {
		console.log(e)
	}
}
export function setToken(token) {
	try {
		return uni.setStorageSync(TOKEN, token);
	} catch (e) {
		console.log(e)
	}
}
export function removeToken() {
	try {
		return uni.removeStorageSync(TOKEN);
	} catch (e) {
		console.log(e)
	}
}
