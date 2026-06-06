// const request = require('./request.js');
import {
	myRequest,
	myAdRequest,
	softwareRequest,
	uploadImg,
	uploadFileRequest
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
// 用lockid获取设备信息
export function deviceInfo_api(params) {
	return myRequest('/device.Device/deviceInfo', params, 'POST');
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
	return myAdRequest('/member.Member/addadlog', params, 'POST');
}

// 添加广告日志
export function updateAdStatus_api(params) {
	return softwareRequest('/index/software/updateAdStatus', params, 'POST');
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
// 获取广告ID
export function adControlUnitId_api(params) {
	return myRequest('/member.Member/adControlUnitId', params, 'POST');
}
// 申请钥匙
export function applyAuth_api(params) {
	return myRequest('/device.LockAuth/applyAuth', params, 'POST');
}

// 设备信息
export function equipmentInfo_api(params) {
	return myRequest('/device.Device/infoV2', params, 'POST');
}
// 刷新设备信息（在线时调用getdevinfo接口更新）
export function refreshDeviceInfo_api(params) {
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
//设置开启和关闭抶拍
export function DevToggleCapture(params) {
	return myRequest('/device.Device/devToggleCapture', params, 'POST');
}
// 设置继电器延时
export function setRelayDelay(params) {
	return myRequest('/device.Device/relayDelaySet', params, 'POST');
}

// 设置继电器常开/常闭模式
export function setRelayNoncMode(params) {
	return myRequest('/device.Device/relayNoncModeSet', params, 'POST');
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

// 编辑用户信息
export function unbindPhone_api(params) {
	return myRequest('/member.Member/unbindPhone', params, 'POST');
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

// 人脸详情（从设备查询）
export function findFace_api(params) {
	return myRequest('/device.Face/find', params, 'POST');
}

// 获取用户有权限的人脸设备列表
export function getFaceDevices_api(params) {
	return myRequest('/device.Device/listFace', params, 'POST');
}

// 批量同步人脸到多台设备
export function syncFaceToDevices_api(params) {
	return myRequest('/device.Face/syncToDevices', params, 'POST');
}

// 批量删除人脸（从多台设备删除）
export function delFaceFromDevices_api(params) {
	return myRequest('/device.Face/delFromDevices', params, 'POST');
}

// 人脸校对 - 比对云端与设备的人脸数据
export function compareFace_api(params) {
	return myRequest('/device.Face/compare', params, 'POST');
}

// 同步差异人脸到设备
export function syncDiffFace_api(params) {
	return myRequest('/device.Face/syncDiff', params, 'POST');
}

// 创建异步同步任务
export function createSyncTask_api(params) {
	return myRequest('/device.Face/createSyncTask', params, 'POST');
}

// 查询异步同步任务进度
export function getSyncTaskProgress_api(params) {
	return myRequest('/device.Face/getSyncTaskProgress', params, 'POST');
}

// 处理异步同步任务（分批处理）
export function processSyncTask_api(params) {
	return myRequest('/device.Face/processSyncTask', params, 'POST');
}

// 清理云端重复人脸记录
export function cleanDuplicateFace_api(params) {
	return myRequest('/device.Face/cleanDuplicate', params, 'POST');
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
// 编辑喇叭参数
export function voiceConfigSet_api(params) {
	return myRequest('/device.Device/voiceConfigSet', params, 'POST');
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

// 获取喇叭播报历史
export function getHornHistory_api(params) {
	return myRequest('/device.Device/getHornHistory', params, 'POST');
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
// 上传开门成功图片（后端自动压缩到506*900，100KB以内）
export function uploadSuccessImg_api(params) {
	return uploadImg('/file.Images/uploadSuccessImg', params, 'POST');
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

// =============== 免广告二维码订阅相关 ===============
// 获取订阅套餐列表
export function getAdfreePackages_api(params) {
	return myRequest('/device.AdfreeSubscription/getPackages', params, 'POST');
}

// 获取设备订阅状态
export function getAdfreeStatus_api(params) {
	return myRequest('/device.AdfreeSubscription/getStatus', params, 'POST');
}

// 创建订阅订单
export function createAdfreeOrder_api(params) {
	return myRequest('/device.AdfreeSubscription/createOrder', params, 'POST');
}

// 生成免广告二维码
export function generateAdfreeQrcode_api(params) {
	return myRequest('/device.AdfreeSubscription/generateQrcode', params, 'POST');
}

// 获取订阅历史
export function getAdfreeHistory_api(params) {
	return myRequest('/device.AdfreeSubscription/getHistory', params, 'POST');
}

export function hornTalkCreate_api(params) {
	return myRequest('/device.Device/hornTalkCreate', params, 'POST');
}

export function hornTalkStop_api(params) {
	return myRequest('/device.Device/hornTalkStop', params, 'POST');
}

export function hornTalkStatus_api(params) {
	return myRequest('/device.Device/hornTalkStatus', params, 'POST');
}

export function hornTalkPrepareAudio_api(params) {
	return myRequest('/device.Device/hornTalkPrepareAudio', params, 'POST');
}

export function hornTalkHistory_api(params) {
	return myRequest('/device.Device/hornTalkHistory', params, 'POST');
}

export function hornTalkUploadRecord_api(filePath, params = {}) {
	return uploadFileRequest('/device.Device/hornTalkUploadRecord', {
		filePath,
		name: 'file',
		formData: params,
	});
}

export function verifyScanAdfree_api(params) {
	return myRequest('/device.AdfreeSubscription/verifyScan', params, 'POST');
}
// =============== 免广告二维码订阅结束 ===============

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
//查询设备配置
export function getDeviceCfg_api(params) {
	return myRequest('/device.Camera/GetConfig', params, 'POST');
}

// ============= 房间绑定相关接口 =============
// 获取已绑定房间
export function roomBindGetMyRooms(params) {
	return myRequest('/room.RoomBind/getMyRooms', params, 'POST');
}

// 获取申请记录
export function roomBindGetApplications(params) {
	return myRequest('/room.RoomBind/getMyApplications', params, 'POST');
}

// 获取区域列表
export function roomBindGetAreas(params) {
	return myRequest('/room.RoomBind/getAreas', params, 'POST');
}

// 获取楼栋列表
export function roomBindGetBuildings(params) {
	return myRequest('/room.RoomBind/getBuildings', params, 'POST');
}

// 获取单元列表
export function roomBindGetUnits(params) {
	return myRequest('/room.RoomBind/getUnits', params, 'POST');
}

// 获取房间列表
export function roomBindGetRooms(params) {
	return myRequest('/room.RoomBind/getRooms', params, 'POST');
}

// 解析二维码获取房间信息
export function roomBindParseQRCode(params) {
	return myRequest('/room.RoomBind/getAreaInfoByLockQr', params, 'POST');
}

// 提交绑定申请
export function roomBindApply(params) {
	return myRequest('/room.RoomBind/applyBind', params, 'POST');
}

// 获取用户拥有的钥匙（房间绑定用）
export function userGetMyKeys(params) {
	return myRequest('/room.RoomBind/getMyKeys', params, 'POST');
}

// ========== W76F 5路继电器相关接口 ==========
// 获取W76F设备配置
export function getW76FConfig_api(params) {
	return myRequest('/device.W76FSwitch/getConfig', params, 'POST');
}

// 设置W76F继电器配置(名称、模式、延迟)
export function setW76FRelayConfig_api(params) {
	return myRequest('/device.W76FSwitch/setRelayConfig', params, 'POST');
}

// 控制W76F指定路继电器
export function controlW76FRelay_api(params) {
	return myRequest('/device.W76FSwitch/controlRelay', params, 'POST');
}

// 生成W76F单路二维码
export function createW76FQrcode_api(params) {
	return myRequest('/device.W76FSwitch/createQrcode', params, 'POST');
}

// 获取W76F设备状态
export function getW76FSta_api(params) {
	return myRequest('/device.W76FSwitch/GetSta', params, 'POST');
}

// 设置W76F设备路数
export function setW76FRelayCount_api(params) {
	return myRequest('/device.W76FSwitch/setRelayCount', params, 'POST');
}

// ========== W75 柜门锁系列相关接口 (W751=WiFi, W752=4G, W753=网线) ==========
// 获取W75柜门配置
export function getW75Config_api(params) {
	return myRequest('/device.W75Cabinet/getConfig', params, 'POST');
}

// 设置W75柜门配置(名称、延迟)
export function setW75LockConfig_api(params) {
	return myRequest('/device.W75Cabinet/setLockConfig', params, 'POST');
}

// 开启指定柜门
export function openW75Lock_api(params) {
	return myRequest('/device.W75Cabinet/openLock', params, 'POST');
}

// 批量开锁
export function openW75Locks_api(params) {
	return myRequest('/device.W75Cabinet/openLocks', params, 'POST');
}

// 查询门状态
export function getW75DoorStatus_api(params) {
	return myRequest('/device.W75Cabinet/getDoorStatus', params, 'POST');
}

// 生成W75设备总二维码
export function createW75Qrcode_api(params) {
	return myRequest('/device.W75Cabinet/createQrcode', params, 'POST');
}

// 生成W75单个柜门二维码
export function createW75LockQrcode_api(params) {
	return myRequest('/device.W75Cabinet/createLockQrcode', params, 'POST');
}

// 设置W75柜门总数
export function setW75LockCount_api(params) {
	return myRequest('/device.W75Cabinet/setLockCount', params, 'POST');
}

// 扫描下位机板子
export function scanW75Boards_api(params) {
	return myRequest('/device.W75Cabinet/scanBoards', params, 'POST');
}

// 更新柜门使用状态（存入/取出）
export function setW75LockUsage_api(params) {
	return myRequest('/device.W75Cabinet/setLockUsage', params, 'POST');
}

// 设置W75工作模式 (1=存取模式, 2=售卖模式)
export function setW75WorkMode_api(params) {
	return myRequest('/device.W75Cabinet/setWorkMode', params, 'POST');
}

// 设置W75柜门商品SKU（售卖模式）
export function setW75Sku_api(params) {
	return myRequest('/device.W75Cabinet/setSku', params, 'POST');
}

// 获取W75柜门商品详情（用户扫码后展示）
export function getW75SkuDetail_api(params) {
	return myRequest('/device.W75Cabinet/getSkuDetail', params, 'POST');
}

// 创建W75购买订单
export function createW75Order_api(params) {
	return myRequest('/device.W75Cabinet/createOrder', params, 'POST');
}

// 支付成功后开门取货
export function payAndOpenW75_api(params) {
	return myRequest('/device.W75Cabinet/payAndOpen', params, 'POST');
}

// 获取W75售卖订单列表
export function getW75Orders_api(params) {
	return myRequest('/device.W75Cabinet/getOrders', params, 'POST');
}

// 设置W75存取模式收费配置
export function setW75StorageCharge_api(params) {
	return myRequest('/device.W75Cabinet/setStorageCharge', params, 'POST');
}

// 创建W75存取订单（存入或取回付费）
export function createW75StorageOrder_api(params) {
	return myRequest('/device.W75Cabinet/createStorageOrder', params, 'POST');
}

// W75存取订单支付成功后开门
export function storagePayAndOpenW75_api(params) {
	return myRequest('/device.W75Cabinet/storagePayAndOpen', params, 'POST');
}

// W75存入完成，生成/更新存取订单
export function completeW75Store_api(params) {
	return myRequest('/device.W75Cabinet/completeStore', params, 'POST');
}

// 获取W75存取订单详情（用于分享取件）
export function getW75StorageOrderDetail_api(params) {
	return myRequest('/device.W75Cabinet/getStorageOrderDetail', params, 'POST');
}

// 获取W75扫码信息（用于判断工作模式和用户权限）
export function getW75ScanInfo_api(params) {
	return myRequest('/device.W75Cabinet/getScanInfo', params, 'POST');
}

export function getW75ScanData_api(params) {
	return myRequest('/device.W75Cabinet/getScanData', params, 'POST');
}

// ========== W71 WiFi空开相关接口 ==========
// 获取W71设备状态
export function getW71Status_api(params) {
	return myRequest('/device.W71Switch/getStatus', params, 'POST');
}

// W71开启
export function turnOnW71_api(params) {
	return myRequest('/device.W71Switch/turnOn', params, 'POST');
}

// W71关闭
export function turnOffW71_api(params) {
	return myRequest('/device.W71Switch/turnOff', params, 'POST');
}

// 获取W71计划任务
export function getW71Schedules_api(params) {
	return myRequest('/device.W71Switch/getSchedules', params, 'POST');
}

// 设置W71所有计划任务
export function setW71Schedules_api(params) {
	return myRequest('/device.W71Switch/setSchedules', params, 'POST');
}

// 设置W71单个计划任务
export function setW71Schedule_api(params) {
	return myRequest('/device.W71Switch/setSchedule', params, 'POST');
}

// 清除W71单个计划任务
export function clearW71Schedule_api(params) {
	return myRequest('/device.W71Switch/clearSchedule', params, 'POST');
}

// 清除W71所有计划任务
export function clearW71AllSchedules_api(params) {
	return myRequest('/device.W71Switch/clearAllSchedules', params, 'POST');
}

// 获取云喇叭定时播报任务
export function getTtsSchedules_api(params) {
	return myRequest('/device.TtsSchedule/getSchedules', params, 'POST');
}

// 设置云喇叭所有定时播报任务
export function setTtsSchedules_api(params) {
	return myRequest('/device.TtsSchedule/setSchedules', params, 'POST');
}

// 设置云喇叭单个定时播报任务
export function setTtsSchedule_api(params) {
	return myRequest('/device.TtsSchedule/setSchedule', params, 'POST');
}

// 清除云喇叭单个定时播报任务
export function clearTtsSchedule_api(params) {
	return myRequest('/device.TtsSchedule/clearSchedule', params, 'POST');
}

// 清除云喇叭所有定时播报任务
export function clearAllTtsSchedules_api(params) {
	return myRequest('/device.TtsSchedule/clearAllSchedules', params, 'POST');
}

// 获取云喇叭发音人列表
export function getTtsSpeakers_api(params) {
	return myRequest('/device.TtsSchedule/getSpeakers', params, 'POST');
}
