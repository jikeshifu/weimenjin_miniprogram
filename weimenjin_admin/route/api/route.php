<?php

//接口路由文件

use think\facade\Route;

Route::rule('LockAuth/getauthlistbymemid', 'LockAuth/getauthlistbymemid')->middleware(['JwtAuth']);	//根据会员id查询钥匙;
Route::rule('LockLog/getopenlog', 'LockLog/getopenlog')->middleware(['JwtAuth']);	//获取开门日志;
Route::rule('Locktimes/getopentimes', 'Locktimes/getopentimes')->middleware(['JwtAuth']);	//查询可开门时段;
Route::rule('LockCard/getcardlistbylockid', 'LockCard/getcardlistbylockid')->middleware(['JwtAuth']);	//获取锁下卡列表;
Route::rule('User/update', 'User/update')->middleware(['JwtAuth']);	//修改账户;
Route::rule('User/updatePassword', 'User/updatePassword')->middleware(['JwtAuth']);	//修改密码;
Route::rule('Health/list', 'Health/list')->middleware(['JwtAuth']);	//;
//Route::rule('Member/update', 'Member/update')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('Member/view', 'Member/view')->middleware(['JwtAuth']);	//查看用户信息;
Route::rule('device.LockAuth/applyAuth', 'device.LockAuth/applyAuth')->middleware(['JwtAuth']);	//申请钥匙;
Route::rule('device.Device/qrOpenLock', 'device.Device/qrOpenLock')->middleware(['JwtAuth']);	//二维码开门;
Route::rule('device.Device/openLock', 'device.Device/openLock')->middleware(['JwtAuth']);	//开门;
Route::rule('Health/view', 'Health/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('Regpoint/update', 'Regpoint/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Regpoint/delete', 'Regpoint/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Regpoint/view', 'Regpoint/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('User/view', 'User/view')->middleware(['JwtAuth']);	//;
Route::rule('Member/viewuserid', 'Member/viewuserid')->middleware(['JwtAuth']);	//查询管理员ID;
Route::rule('Lock/update', 'Lock/update')->middleware(['JwtAuth']);	//修改;
Route::rule('Lock/delete', 'Lock/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('Lock/view', 'Lock/view')->middleware(['JwtAuth']);	//根据lock_id查询锁信息;
//Route::rule('Lock/opendoor', 'Lock/opendoor')->middleware(['JwtAuth']);	//编辑数据;
Route::rule('LockAuth/applyauth', 'LockAuth/applyauth')->middleware(['JwtAuth']);	//申请钥匙;
Route::rule('LockAuth/verifyauth', 'LockAuth/verifyauth')->middleware(['JwtAuth']);	//审核钥匙;
Route::rule('LockAuth/delete', 'LockAuth/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockLog/add', 'LockLog/add')->middleware(['JwtAuth']);	//添加;
Route::rule('LockLog/update', 'LockLog/update')->middleware(['JwtAuth']);	//修改;
Route::rule('LockLog/delete', 'LockLog/delete')->middleware(['JwtAuth']);	//删除;
Route::rule('LockLog/view', 'LockLog/view')->middleware(['JwtAuth']);	//查看数据;
Route::rule('LockAuth/shareauth', 'LockAuth/shareauth')->middleware(['JwtAuth']);	//生成分享前的临时钥匙;
Route::rule('LockAuth/getkey', 'LockAuth/getkey')->middleware(['JwtAuth']);	//领取钥匙;
Route::rule('LockAuth/getauthlistbylockid', 'LockAuth/getauthlistbylockid')->middleware(['JwtAuth']);	//;
Route::rule('LockLog/getopenlogbylockid', 'LockLog/getopenlogbylockid')->middleware(['JwtAuth']);	//;
Route::rule('LockCard/addauthcard', 'LockCard/addauthcard')->middleware(['JwtAuth']);	//添加钥匙下的卡;
Route::rule('LockCard/updatecard', 'LockCard/updatecard')->middleware(['JwtAuth']);	//更新卡;
Route::rule('LockCard/delcard', 'LockCard/delcard')->middleware(['JwtAuth']);	//删除卡;
Route::rule('LockCard/viewcarddetail', 'LockCard/viewcarddetail')->middleware(['JwtAuth']);	//查看卡数据;
Route::rule('Lock/configaudio', 'Lock/configaudio')->middleware(['JwtAuth']);	//修改语音设置;
Route::rule('Lock/configlcd', 'Lock/configlcd')->middleware(['JwtAuth']);	//配置显示屏二维码;
Route::rule('Member/getuserbymobile', 'Member/getuserbymobile')->middleware(['JwtAuth']);	//根据手机号查询用户;
Route::rule('device.Face/add', 'device.Face/add')->middleware(['JwtAuth']);	//根据手机号查询用户;
Route::rule('Base/Upload', 'Base/Upload')->middleware(['JwtAuth']);	//图片上传;
Route::rule('Lock/add', 'Lock/add')->middleware(['JwtAuth']);	//添加设备;
Route::rule('Member/loginQrCode', 'Member/loginQrCode')->middleware(['JwtAuth']);	//添加设备;
Route::rule('device.Device/list', 'device.Device/list')->middleware(['JwtAuth']);


/*start*/
Route::rule('User/adduser', 'User/adduser')->middleware(['JwtAuth']);	//添加;
//Route::rule('Member/getphonenumber', 'Member/getphonenumber')->middleware(['JwtAuth']);	//添加;

Route::rule('device.Device/electricityStop', 'device.Device/electricityStop')->middleware(['JwtAuth']);	//添加;
Route::rule('device.Device/electricityStart', 'device.Device/electricityStart')->middleware(['JwtAuth']);	//添加;


//分组管理
Route::rule('device.DeviceGroup/all', 'device.DeviceGroup/all')->middleware(['JwtAuth']);
Route::rule('device.DeviceGroup/add', 'device.DeviceGroup/add')->middleware(['JwtAuth']);
/*end*/


Route::group(function (){
    //4G开关----相关
    Route::post("device.Switch4G/GetSta","device.Switch4G/GetSta");
    Route::post("device.Switch4G/Operation","device.Switch4G/Operation");
    Route::post("device.Switch4G/Lockup","device.Switch4G/Lockup");

    //W76F继电器----相关
    Route::post("device.W76FSwitch/getConfig","device.W76FSwitch/getConfig");
    Route::post("device.W76FSwitch/setRelayConfig","device.W76FSwitch/setRelayConfig");
    Route::post("device.W76FSwitch/controlRelay","device.W76FSwitch/controlRelay");
    Route::post("device.W76FSwitch/createQrcode","device.W76FSwitch/createQrcode");
    Route::post("device.W76FSwitch/GetSta","device.W76FSwitch/GetSta");
    Route::post("device.W76FSwitch/setRelayCount","device.W76FSwitch/setRelayCount");

    //W71 WiFi空开----相关
    Route::post("device.W71Switch/getStatus","device.W71Switch/getStatus");
    Route::post("device.W71Switch/turnOn","device.W71Switch/turnOn");
    Route::post("device.W71Switch/turnOff","device.W71Switch/turnOff");
    Route::post("device.W71Switch/getSchedules","device.W71Switch/getSchedules");
    Route::post("device.W71Switch/setSchedules","device.W71Switch/setSchedules");
    Route::post("device.W71Switch/setSchedule","device.W71Switch/setSchedule");
    Route::post("device.W71Switch/clearSchedule","device.W71Switch/clearSchedule");
    Route::post("device.W71Switch/clearAllSchedules","device.W71Switch/clearAllSchedules");

    //TTS定时播报----相关
    Route::post("device.TtsSchedule/getSchedules","device.TtsSchedule/getSchedules");
    Route::post("device.TtsSchedule/setSchedules","device.TtsSchedule/setSchedules");
    Route::post("device.TtsSchedule/setSchedule","device.TtsSchedule/setSchedule");
    Route::post("device.TtsSchedule/clearSchedule","device.TtsSchedule/clearSchedule");
    Route::post("device.TtsSchedule/clearAllSchedules","device.TtsSchedule/clearAllSchedules");
    Route::post("device.TtsSchedule/getSpeakers","device.TtsSchedule/getSpeakers");

    //房间绑定----相关
    Route::post("room.RoomBind/getMyRooms","room.RoomBind/getMyRooms");
    Route::post("room.RoomBind/getMyApplications","room.RoomBind/getMyApplications");
    Route::post("room.RoomBind/getAreas","room.RoomBind/getAreas");
    Route::post("room.RoomBind/getBuildings","room.RoomBind/getBuildings");
    Route::post("room.RoomBind/getUnits","room.RoomBind/getUnits");
    Route::post("room.RoomBind/getRooms","room.RoomBind/getRooms");
    Route::post("room.RoomBind/getAreaInfoByLockQr","room.RoomBind/getAreaInfoByLockQr");
    Route::post("room.RoomBind/applyBind","room.RoomBind/applyBind");
    Route::post("room.RoomBind/getMyKeys","room.RoomBind/getMyKeys");

    //摄像头----相关
    Route::post("device.Camera/getToken","device.Camera/getToken");
    Route::post("device.Camera/rtspStart","device.Camera/rtspStart");
    Route::post("device.Camera/SetPtz","device.Camera/SetPtz");
    Route::post("device.Camera/SetMute","device.Camera/SetMute");
    Route::post("device.Camera/SetNightAuto","device.Camera/SetNightAuto");
    Route::post("device.Camera/SetNight","device.Camera/SetNight");
    Route::post("device.Camera/SetRot","device.Camera/SetRot");
    Route::post("device.Camera/GetConfig","device.Camera/GetConfig");
    Route::post("device.Camera/Register","device.Camera/Register");
    Route::post("device.Camera/Reboot","device.Camera/Reboot");
    Route::post("device.Camera/getDeviceInfo","device.Camera/getDeviceInfo");
    Route::post("device.Camera/getRemoteControl","device.Camera/getRemoteControl");
    Route::post("device.Camera/addControl","device.Camera/addControl");
    Route::post("device.Camera/delControl","device.Camera/delControl");
    Route::post("device.Camera/controlStudy","device.Camera/controlStudy");
    Route::post("device.Camera/controlStudyStop","device.Camera/controlStudyStop");
    Route::post("device.Camera/controlRmt","device.Camera/controlRmt");
    Route::post("device.Camera/switchVideoCodec","device.Camera/switchVideoCodec");
    Route::post("device.Camera/getReplayDate","device.Camera/getReplayDate");
    Route::post("device.Camera/getReplayTime","device.Camera/getReplayTime");
    Route::post("device.Camera/getReplayFind","device.Camera/getReplayFind");
    Route::post("device.Camera/setSdFormat","device.Camera/setSdFormat");
    Route::post("device.Camera/replayRtspStart","device.Camera/replayRtspStart");

    //设备配置----相关
    Route::post("device.Device/voiceConfigSet","device.Device/voiceConfigSet");
    Route::post("device.Device/relayNoncModeSet","device.Device/relayNoncModeSet");
    Route::post("device.Device/relayDelaySet","device.Device/relayDelaySet");
    Route::post("device.Device/getHornHistory","device.Device/getHornHistory");

    //会员----相关
    Route::post("member.Member/adControlUnitId","member.Member/adControlUnitId");
    Route::post("member.Member/unbindPhone","member.Member/unbindPhone");
})->middleware(['JwtAuth']);
