import bleServer from '../ble/server.js'
import ble from '../ble/index.js'
import request from '../../api/request.js';
let OpenLockBle = function(deviceSn, lock_id = 0) {
	return new Promise(async function(resolve, reject) {
		//8E400001-B5A3-F393-E0A9-E50E24DCCAAE
		//找到设备
		let bleInfo = await bleServer.SearchDevicewBleName(deviceSn, 5000, [])

		if (bleInfo.err != null) {
			wx.showToast({
				title: "离线时不能远程开门",
				icon: "none",
				mask: true, // 是否显示透明蒙层，防止触摸穿透
				duration: 2000
			});
			return
		}

		let deviceId = bleInfo.data.deviceId
		const serviceId = "8E400001-B5A3-F393-E0A9-E50E24DCCAAE"

		//开锁发送蓝牙数据
		var opencode = deviceSn.slice(-6);
		opencode = parseInt(opencode);

		let data = opencode * 3;
		console.log("err", 20)
		//连接上设备
		let BleConnectionRes = await bleServer.ConnectionBle(deviceId, serviceId)

		if (BleConnectionRes.err != null) {
			wx.showToast({
				title: "连接设备失败",
				icon: "none",
				mask: true, // 是否显示透明蒙层，防止触摸穿透
				duration: 2000
			});
			return
		}

		await ble.NotifyBLECharacteristicValueChange(deviceId, serviceId,
			"8E400002-B5A3-F393-E0A9-E50E24DCCAAE")
		let bleServerRes = await bleServer.WriteBLECharacteristicValue(deviceId, serviceId,
			"8E400003-B5A3-F393-E0A9-E50E24DCCAAE", data.toString())



		let lockOpen = 1;
		if (bleServerRes.err != null) {
			wx.showToast({
				title: bleServerRes.err,
				icon: "none",
				mask: true, // 是否显示透明蒙层，防止触摸穿透
				duration: 2000
			});
			lockOpen = 0
		}



		if (!bleServerRes.data || bleServerRes.data != "btsuccess") {

		}

		request.myRequest('/LockLog/add', {
			"status": lockOpen,
			"lock_id": lock_id,
		}, 'POST');



		console.log("WriteBLECharacteristicValue:", bleServerRes.data)

		wx.showToast({
			title: "蓝牙开门成功",
			icon: "success",
			mask: true, // 是否显示透明蒙层，防止触摸穿透
			duration: 2000
		});

	})
}


module.exports = {
	OpenLockBle

};