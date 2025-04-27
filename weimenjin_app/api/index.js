// const request = require('./request.js');
import {
	myRequest,
	uploadImg
} from './request.js';

// 获取分组
export function getDeviceGroup_api(params) {
	return myRequest('/device.DeviceGroup/all', params, 'GET');
}

// 添加分组
export function addDeviceGroup_api(params) {
	return myRequest('/device.DeviceGroup/add', params, 'POST');
}

// 分组详情
export function DeviceGroupDetail_api(params) {
	return myRequest('/device.Device/all', params, 'POST');
}

// 删除分组
export function delDeviceGroup_api(params) {
	return myRequest('/device.DeviceGroup/del', params, 'POST');
}

// 修改分组
export function editDeviceGroup_api(params) {
	return myRequest('/device.DeviceGroup/edit', params, 'POST');
}

// 删除钥匙
export function delDevice_api(params) {
	return myRequest('/device.Device/del', params, 'POST');
}

// 添加设备
export function addDevice_api(params) {
	return myRequest('/device.Device/add', params, 'POST');
}
// 添加设备
export function simInfo(params) {
	return myRequest('/device.Device/simInfo', params, 'POST');
}
// 首页获取设备
export function deviceList_api(params) {
	return myRequest('/device.Device/list', params, 'POST');
}
// 首页获取设备
export function deviceStatusBySerial_api(params) {
	return myRequest('/device.Device/getDeviceStatus', params, 'POST');
}
// 获取设备状态
export function deviceStatus_api(params) {
	return myRequest('/device.Device/getStatus', params, 'POST');
}
// 指纹列表
export function fingerList_api(params) {
	return myRequest('/device.Finger/list', params, 'POST');
}
//清空指纹
export function clearFinger_api(params) {
	return myRequest('/device.Finger/clearFinger', params, 'POST');
}
// 添加指纹
export function addFinger_api(params) {
	return myRequest('/device.Finger/add', params, 'POST');
}

// 修改指纹
export function editFinger_api(params) {
	return myRequest('/device.Finger/edit', params, 'POST');
}

// 删除指纹
export function delFinger_api(params) {
	return myRequest('/device.Finger/del', params, 'POST');
}

// 开锁
export function openDoor_api(params) {
	return myRequest('/device.Device/openDoor', params, 'POST');
}
// 开锁
export function openLock_api(params) {
	return myRequest('/device.Device/openLock', params, 'POST');
}
// 开锁测试
export function openLockApiTest(params) {
	return myRequest('/device.Device/openLockTest', params, 'POST');
}

// 开动作
export function turnOn_api(params) {
	return myRequest('/device.Device/start', params, 'POST');
}

// 开
export function openApi(params) {
	return myRequest('/device.Device/open', params, 'POST');
}

// 关
export function closeApi(params) {
	return myRequest('/device.Device/close', params, 'POST');
}

// 停
export function pauseAapi(params) {
	return myRequest('/device.Device/pause', params, 'POST');
}

// 开动作测试
export function turnOnApiTest(params) {
	return myRequest('/device.Device/startTest', params, 'POST');
}

// 关动作
export function turnOff_api(params) {
	return myRequest('/device.Device/stop', params, 'POST');
} // 关动作测试
export function turnOffApiTest(params) {
	return myRequest('/device.Device/stopTest', params, 'POST');
}

// 生成钥匙
export function shareAuth_api(params) {
	return myRequest('/device.LockAuth/shareAuth', params, 'POST');
}

// 领取钥匙
export function getShareAuth_api(params) {
	return myRequest('/device.LockAuth/getShareAuth', params, 'POST');
}

// 小程序扫码登录
export function loginQrCode_api(params) {
	return myRequest('/member.Member/loginQrCode', params, 'POST');
}

// 扫码开门
export function qrOpenLock_api(params) {
	return myRequest('/device.Device/qrOpenLock', params, 'POST');
}

// 支付宝绑定手机号
export function zfbXcxMobile_api(params) {
	return myRequest('/Member/getalipayphonenumber', params, 'POST');
}
// 头条绑定手机号
export function toutiaoXcxMobile_api(params) {
	console.log("toutiaoXcxMobile_api")
	return myRequest('/Member/gettoutiaophonenumber', params, 'POST');
}
// 支付宝修改手机号
export function zfb_edit_info(params) {
	return myRequest('/Member/update', params, 'POST');
}
// tt修改手机号
export function tt_edit_info(params) {
	return myRequest('/Member/update', params, 'POST');
}
// 绑定手机号
export function wxXcxMobile_api(params) {
	return myRequest('/member.Member/wxXcxMobile', params, 'POST');
}
// 添加广告日志
export function adlog_api(params) {
	return myRequest('/member.Member/addadlog', params, 'POST');
}
// 获取积分
export function adlog_getpointsapi(params) {
	return myRequest('/member.Member/getpoints', params, 'POST');
}
// 获取用户信息
export function userInfo_api(params) {
	return myRequest('/member.Member/info', params, 'POST');
}
// 获取广告ID
export function adUnitId_api(params) {
	return myRequest('/member.Member/adUnitId', params, 'POST');
}
// 申请钥匙
export function applyAuth_api(params) {
	return myRequest('/device.LockAuth/applyAuth', params, 'POST');
}

// 设备信息
export function equipmentInfo_api(params) {
	return myRequest('/device.Device/infoV2', params, 'POST');
}
// 重启设备
export function restartDevice_api(params) {
	return myRequest('/device.Device/restartDevice', params, 'POST');
}
// 设置二维码
export function SaveQr(params) {
	return myRequest('/device.Device/qrSave', params, 'POST');
}

// 设置进出发卡模式
export function DevAddCard(params) {
	return myRequest('/device.Device/devAddCard', params, 'POST');
}
//设置进出常开常闭模式
export function DevNoNc(params) {
	return myRequest('/device.Device/devNoNc', params, 'POST');
}
//设置开启和关闭抓拍
export function DevToggleCapture(params) {
	return myRequest('/device.Device/devToggleCapture', params, 'POST');
}
// 门卡列表
export function cardList_api(params) {
	return myRequest('/device.Card/list', params, 'POST');
}

// 门卡编辑
export function editCard_api(params) {
	return myRequest('/device.Card/edit', params, 'POST');
}

// 门卡添加
export function addCard_api(params) {
	return myRequest('/device.Card/add', params, 'POST');
}

// 门卡删除
export function delCard_api(params) {
	return myRequest('/device.Card/del', params, 'POST');
}

// 清空门卡
export function clearCards_api(params) {
	return myRequest('/device.Card/clearcards', params, 'POST');
}
// 编辑用户信息
export function editMember_api(params) {
	return myRequest('/member.Member/edit', params, 'POST');
}

// 人脸列表
export function faceList_api(params) {
	return myRequest('/device.Face/list', params, 'POST');
}

// 人脸添加
export function addFace_api(params) {
	return myRequest('/device.Face/add', params, 'POST');
}

// 人脸删除
export function delFace_api(params) {
	return myRequest('/device.Face/del', params, 'POST');
}

// 人脸删除
export function clearFaces_api(params) {
	return myRequest('/device.Face/clearallface', params, 'POST');
}

// 人脸编辑
export function editFace_api(params) {
	return myRequest('/device.Face/edit', params, 'POST');
}

// 操作记录
export function record_api(params) {
	return myRequest('/device.Device/record', params, 'POST');
}
// 电量记录
export function power_api(params) {
	return myRequest('/device.Device/power', params, 'POST');
}
// 上下线记录
export function onoffline_api(params) {
	return myRequest('/device.Device/onoffline', params, 'POST');
}
// 钥匙管理-钥匙列表
export function LockAuthList_api(params) {
	return myRequest('/device.LockAuth/list', params, 'POST');
}

// 钥匙详情
export function lockAuthInfo_api(params) {
	return myRequest('/device.LockAuth/info', params, 'POST');
}

// 编辑钥匙
export function editLockAuth_api(params) {
	return myRequest('/device.LockAuth/edit', params, 'POST');
}

// 密码列表
export function pwdList_api(params) {
	return myRequest('/device.Pwd/list', params, 'POST');
}

// 添加密码
export function addPwd_api(params) {
	return myRequest('/device.Pwd/add', params, 'POST');
}

// 删除密码
export function delPwd_api(params) {
	return myRequest('/device.Pwd/del', params, 'POST');
}

// 离线密码
export function temporaryPassword_api(params) {
	return myRequest('/device.Pwd/temporaryPassword', params, 'POST');
}

// 获取参数
export function config_api(params) {
	return myRequest('/device.Device/config', params, 'POST');
}
// 获取参数
export function authconfig_api(params) {
	return myRequest('/device.Device/authconfig', params, 'POST');
}
// 编辑参数
export function configSet_api(params) {
	return myRequest('/device.Device/configSet', params, 'POST');
}
// 编辑参数
export function authconfigSet_api(params) {
	return myRequest('/device.Device/authconfigSet', params, 'POST');
}

// 转移权限
export function transfer_api(params) {
	return myRequest('/device.Device/transfer', params, 'POST');
}

// 手机号查询用户信息
export function memberInfo_api(params) {
	return myRequest('/device.Device/memberInfo', params, 'POST');
}

// 喇叭操作
export function playHorn_api(params) {
	return myRequest('/device.Device/horn', params, 'POST');
}

// 喇叭操作测试
export function playHornApiTest(params) {
	return myRequest('/device.Device/hornTest', params, 'POST');
}


// 语音设置
export function audioConfig(params) {
	return myRequest('/device.Device/audioConfig', params, 'POST');
}

// 语音设置
export function audioConfigSet(params) {
	return myRequest('/device.Device/audioConfigSet', params, 'POST');
}


// 用户手机信息
export function memberDeviceInfo(params) {
	return myRequest('/member.Member/deviceInfoSet', params, 'POST');
}
// 上传图片
export function images_api(params) {
	return uploadImg('/file.Images/upload', params, 'POST');
}

// 实时状态
export function realTime_api(params) {
	return myRequest('/device.Device/info', params, 'POST');
}
// 获取用电量
export function getLastUsage_api(params) {
	return myRequest('/device.Device/getLastUsage', params, 'POST');
}
// 绑定
export function bindingApiTest(params) {
	return myRequest('/device.Device/binding', params, 'POST');
}

// 解绑
export function UnbindingApiTest(params) {
	return myRequest('/device.Device/Unbinding', params, 'POST');
}

// 发卡-卡列表
export function listCard_api(params) {
	return myRequest('/device.Device/listCard', params, 'POST');
}

// 确认发卡
export function sendCard_api(params) {
	return myRequest('/device.Device/sendCard', params, 'POST');
}

// 查询充值列表
export function simRenew_api(params) {
	return myRequest('/device.Device/simRenew', params, 'POST');
}

// 下单
export function simOrder_api(params) {
	return myRequest('/device.Device/simOrder', params, 'POST');
}

// 订单列表
export function orderList_api(params) {
	return myRequest('/order.Order/list', params, 'POST');
}

// 切换分组
export function switch_api(params) {
	return myRequest('/device.DeviceGroup/switch', params, 'POST');
}

// 同步数据-卡
export function syncCard_api(params) {
	return myRequest('/device.Card/sync', params, 'POST');
}

// 人脸设备列表
export function listFace_api(params) {
	return myRequest('/device.Device/listFace', params, 'POST');
}

// 同步数据-人脸
export function syncFace_api(params) {
	return myRequest('/device.Face/sync', params, 'POST');
}

// 服务列表
export function wmjservice_api(params) {
	return myRequest('/Wservice/index', params, 'POST');
}
// 获取用户下的所有设备列表
export function getuserdevices_api(params) {
	return myRequest('/device.Device/getuserdevice', params, 'POST');
}
// 添加联动喇叭
export function addlinkspeaker_api(params) {
	return myRequest('/device.Device/addlinkspeaker', params, 'POST');
}
// 编辑联动喇叭
export function editlinkspeaker_api(params) {
	return myRequest('/device.Device/editlinkspeaker', params, 'POST');
}
// 添加联动空开
export function addlinkswitch_api(params) {
	return myRequest('/device.Device/addlinkswitch', params, 'POST');
}
// 编辑联动空开
export function editlinkswitch_api(params) {
	return myRequest('/device.Device/editlinkswitch', params, 'POST');
}

export function getlinkSpeakers_api(params) {
	return myRequest('/device.Device/getlinkSpeakers', params, 'POST');
}
export function getlinkSwitches_api(params) {
	return myRequest('/device.Device/getlinkSwitches', params, 'POST');
}
export function getlinkspeakerBySn_api(params) {
	return myRequest('/device.Device/getlinkspeakerBySn', params, 'POST');
}
export function getlinkswitchBySn_api(params) {
	return myRequest('/device.Device/getlinkswitchBySn', params, 'POST');
}
export function deletelinkSpeaker_api(params) {
	return myRequest('/device.Device/deleteLinkSpeaker', params, 'POST');
}
export function deletelinkSwitch_api(params) {
	return myRequest('/device.Device/deleteLinkSwitch', params, 'POST');
}
