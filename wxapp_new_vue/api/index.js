const request = require('./request.js');


// 获取分组
export function getDeviceGroup_api(params){
	return request.myRequest('/device.DeviceGroup/all', params, 'GET');
}

// 添加分组
export function addDeviceGroup_api(params){
	return request.myRequest('/device.DeviceGroup/add', params, 'POST');
}

// 分组详情
export function DeviceGroupDetail_api(params){
	return request.myRequest('/device.Device/all', params, 'POST');
}

// 删除分组
export function delDeviceGroup_api(params){
	return request.myRequest('/device.DeviceGroup/del', params, 'POST');
}

// 修改分组
export function editDeviceGroup_api(params){
	return request.myRequest('/device.DeviceGroup/edit', params, 'POST');
}

// 删除钥匙
export function delDevice_api(params){
	return request.myRequest('/device.Device/del', params, 'POST');
}

// 添加设备
export function addDevice_api(params){
	return request.myRequest('/device.Device/add', params, 'POST');
}
// 添加设备
export function simInfo(params){
	return request.myRequest('/device.Device/simInfo', params, 'POST');
}
// 首页获取设备
export function deviceList_api(params){
	return request.myRequest('/device.Device/list', params, 'POST');
}

// 指纹列表
export function fingerList_api(params){
	return request.myRequest('/device.Finger/list', params, 'POST');
}

// 添加指纹
export function addFinger_api(params){
	return request.myRequest('/device.Finger/add', params, 'POST');
}

// 修改指纹
export function editFinger_api(params){
	return request.myRequest('/device.Finger/edit', params, 'POST');
}

// 删除指纹
export function delFinger_api(params){
	return request.myRequest('/device.Finger/del', params, 'POST');
}

// 开锁
export function openLock_api(params){
	return request.myRequest('/device.Device/openLock', params, 'POST');
}
// 开锁测试
export function openLockApiTest(params){
	return request.myRequest('/device.Device/openLockTest', params, 'POST');
}

// 开动作
export function turnOn_api(params){
	return request.myRequest('/device.Device/start', params, 'POST');
}
// 开动作测试
export function turnOnApiTest(params){
	return request.myRequest('/device.Device/startTest', params, 'POST');
}

// 关动作
export function turnOff_api(params){
	return request.myRequest('/device.Device/stop', params, 'POST');
}// 关动作测试
export function turnOffApiTest(params){
	return request.myRequest('/device.Device/stopTest', params, 'POST');
}

// 生成钥匙
export function shareAuth_api(params){
	return request.myRequest('/device.LockAuth/shareAuth', params, 'POST');
}

// 领取钥匙
export function getShareAuth_api(params){
	return request.myRequest('/device.LockAuth/getShareAuth', params, 'POST');
}

// 小程序扫码登录
export function loginQrCode_api(params){
	return request.myRequest('/member.Member/loginQrCode', params, 'POST');
}

// 扫码开门
export function qrOpenLock_api(params){
	return request.myRequest('/device.Device/qrOpenLock', params, 'POST');
}

// 绑定手机号
export function wxXcxMobile_api(params){
	return request.myRequest('/member.Member/wxXcxMobile', params, 'POST');
}

// 获取用户信息
export function userInfo_api(params){
	return request.myRequest('/member.Member/info', params, 'POST');
}

// 申请钥匙
export function applyAuth_api(params){
	return request.myRequest('/device.LockAuth/applyAuth', params, 'POST');
}

// 设备信息
export function equipmentInfo_api(params){
	return request.myRequest('/device.Device/infoV2', params, 'POST');
}
// 设置二维码
export function SaveQr(params){
	return request.myRequest('/device.Device/qrSave', params, 'POST');
}

// 设置二维码
export function DevAddCard(params){
	return request.myRequest('/device.Device/devAddCard', params, 'POST');
}
// 门卡列表
export function cardList_api(params){
	return request.myRequest('/device.Card/list', params, 'POST');
}

// 门卡编辑
export function editCard_api(params){
	return request.myRequest('/device.Card/edit', params, 'POST');
}

// 门卡添加
export function addCard_api(params){
	return request.myRequest('/device.Card/add', params, 'POST');
}

// 门卡删除
export function delCard_api(params){
	return request.myRequest('/device.Card/del', params, 'POST');
}

// 编辑用户信息
export function editMember_api(params){
	return request.myRequest('/member.Member/edit', params, 'POST');
}

// 人脸列表
export function faceList_api(params){
	return request.myRequest('/device.Face/list', params, 'POST');
}

// 人脸添加
export function addFace_api(params){
	return request.myRequest('/device.Face/add', params, 'POST');
}

// 人脸删除
export function delFace_api(params){
	return request.myRequest('/device.Face/del', params, 'POST');
}

// 人脸编辑
export function editFace_api(params){
	return request.myRequest('/device.Face/edit', params, 'POST');
}

// 操作记录
export function record_api(params){
	return request.myRequest('/device.Device/record', params, 'POST');
}

// 钥匙管理-钥匙列表
export function LockAuthList_api(params){
	return request.myRequest('/device.LockAuth/list', params, 'POST');
}

// 钥匙详情
export function lockAuthInfo_api(params){
	return request.myRequest('/device.LockAuth/info', params, 'POST');
}

// 编辑钥匙
export function editLockAuth_api(params){
	return request.myRequest('/device.LockAuth/edit', params, 'POST');
}

// 密码列表
export function pwdList_api(params){
	return request.myRequest('/device.Pwd/list', params, 'POST');
}

// 添加密码
export function addPwd_api(params){
	return request.myRequest('/device.Pwd/add', params, 'POST');
}

// 删除密码
export function delPwd_api(params){
	return request.myRequest('/device.Pwd/del', params, 'POST');
}

// 离线密码
export function temporaryPassword_api(params){
	return request.myRequest('/device.Pwd/temporaryPassword', params, 'POST');
}

// 获取参数
export function config_api(params){
	return request.myRequest('/device.Device/config', params, 'POST');
}

// 编辑参数
export function configSet_api(params){
	return request.myRequest('/device.Device/configSet', params, 'POST');
}

// 转移权限
export function transfer_api(params){
	return request.myRequest('/device.Device/transfer', params, 'POST');
}

// 手机号查询用户信息
export function memberInfo_api(params){
	return request.myRequest('/device.Device/memberInfo', params, 'POST');
}

// 喇叭操作
export function playHorn_api(params){
	return request.myRequest('/device.Device/horn', params, 'POST');
}

// 喇叭操作测试
export function playHornApiTest(params){
	return request.myRequest('/device.Device/hornTest', params, 'POST');
}


// 语音设置
export function audioConfig(params){
	return request.myRequest('/device.Device/audioConfig', params, 'POST');
}

// 语音设置
export function audioConfigSet(params){
	return request.myRequest('/device.Device/audioConfigSet', params, 'POST');
}


// 用户手机信息
export function memberDeviceInfo(params){
	return request.myRequest('/member.Member/deviceInfoSet', params, 'POST');
}
// 上传图片
export function images_api(params) {
	return request.uploadImg('/file.Images/upload', params, 'POST');
}

// 实时状态
export function realTime_api(params) {
	return request.myRequest('/device.Device/info', params, 'POST');
}

// 绑定
export function bindingApiTest(params){
	return request.myRequest('/device.Device/binding', params, 'POST');
}

// 解绑
export function UnbindingApiTest(params){
	return request.myRequest('/device.Device/Unbinding', params, 'POST');
}

// 发卡-卡列表
export function listCard_api(params){
	return request.myRequest('/device.Device/listCard', params, 'POST');
}

// 确认发卡
export function sendCard_api(params){
	return request.myRequest('/device.Device/sendCard', params, 'POST');
}

// 查询充值列表
export function simRenew_api(params){
	return request.myRequest('/device.Device/simRenew', params, 'POST');
}

// 下单
export function simOrder_api(params){
	return request.myRequest('/device.Device/simOrder', params, 'POST');
}

// 订单列表
export function orderList_api(params){
	return request.myRequest('/order.Order/list', params, 'POST');
}

