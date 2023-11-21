import bleServer from '../ble/server.js'
import ble from '../ble/index.js'
import request from '../../api/request.js';
let OpenLockBle = function(deviceSn, lock_id = 0, data = null) {

	return new Promise(async function(resolve, reject) {

		setTimeout(() => {
			resolve()
		}, 10000)
		//8E400001-B5A3-F393-E0A9-E50E24DCCAAE
		//找到设备
		let bleInfo = await bleServer.SearchDevicewBleName(deviceSn, 5000, [])
		console.log("搜索设备：", bleInfo)
		if (bleInfo.err != null) {
			setTimeout(() => {
				resolve()
			}, 2000)
			wx.showToast({
				title: "离线查找设备失败",
				icon: "none",
				mask: true, // 是否显示透明蒙层，防止触摸穿透
				duration: 2000
			});
			return
		}

		let deviceId = bleInfo.data.deviceId

		let bleData = null
		let serviceId = "8E400001-B5A3-F393-E0A9-E50E24DCCAAE"
		let NotifycharacteristicId = "8E400002-B5A3-F393-E0A9-E50E24DCCAAE"
		let WritecharacteristicId = "8E400003-B5A3-F393-E0A9-E50E24DCCAAE"
		if (deviceSn.indexOf('W76') > -1) {
			serviceId = "0000FEE0-0000-1000-8000-00805F9B34FB"
			NotifycharacteristicId = "0000FEE2-0000-1000-8000-00805F9B34FB"
			WritecharacteristicId = "0000FEE1-0000-1000-8000-00805F9B34FB"

			let temporaryPasswordRes = await request.myRequest('/device.Pwd/temporaryPassword', {

				"lock_id": lock_id,
			}, 'POST');
			console.log("temporaryPasswordRes:", temporaryPasswordRes)

			bleData = {
				"cmd_type": "ble_pwd_open_lock",
				"info": {
					"data": temporaryPasswordRes.data.pwd
				}
			};
			bleData = JSON.stringify(bleData)
		} else {
			var opencode = deviceSn.slice(-6);
			opencode = parseInt(opencode);
			data = opencode * 3;
			bleData = data.toString()
		}




		console.log("err", 20)
		//连接上设备
		let BleConnectionRes = await bleServer.ConnectionBle(deviceId, serviceId)

		if (BleConnectionRes.err != null) {
			setTimeout(() => {
				resolve()
			}, 2000)
			wx.showToast({
				title: "连接设备失败",
				icon: "none",
				mask: true, // 是否显示透明蒙层，防止触摸穿透
				duration: 2000
			});
			return
		}

		await ble.NotifyBLECharacteristicValueChange(deviceId, serviceId, NotifycharacteristicId)
		let bleServerRes = await bleServer.WriteBLECharacteristicValue(deviceId, serviceId,
			WritecharacteristicId, bleData)
		console.log("bleServerRes", bleServerRes)


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


		if (deviceSn.indexOf('WMJ62') > -1) {
			if (bleServerRes.data && bleServerRes.data != "btsuccess") {
				wx.showToast({
					title: "离线开门失败",
					icon: "none",
					duration: 2000
				});

				setTimeout(() => {
					resolve()
				}, 2000)
				return
			}
		}

		console.log("WriteBLECharacteristicValue:", bleServerRes.data)
		if (bleServerRes.data && bleServerRes.data.info.code != 0) {
			wx.showToast({
				title: bleServerRes.data.info.msg,
				icon: "none",
				duration: 2000
			});
			setTimeout(() => {
				resolve()
			}, 2000)
			return
		}

		if (!bleServerRes.data) {
			wx.showToast({
				title: "离线开门失败",
				icon: "none",
			});
			return
		}
		await request.myRequest('/LockLog/add', {
			"status": lockOpen,
			"lock_id": lock_id,
		}, 'POST');


		setTimeout(() => {
			resolve()
		}, 2000)

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