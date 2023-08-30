//初始化蓝牙
import ble from './index.js'

async function SearchDevice(timeOut = 4000) {
	let res = {
		"err": null,

	}

	return new Promise(async (resolve, reject) => {
		uni.showLoading({
			title: '开始查找设备',
			mask: true
		});
		setTimeout(function() {
			uni.hideLoading();
			ble.StopBluetoothDevicesDiscovery()

			resolve()
		}, timeOut)
		//开启监听
		uni.onBluetoothDeviceFound(function(devices) {
			console.log('new device list has founded')
			console.dir(devices)
			console.log(ble.ab2hex(devices.devices[0].advertisData))
		})

		ble.StartBluetoothDevicesDiscovery()


	})


	console.log(openBluetoothAdapter)

}


async function SearchDevicewBleName(bleName, timeOut = 4000,services= ["0D38"]) {
	let res = {
		"err": null,
		"data": null
	}

	return new Promise(async (resolve, reject) => {

		uni.showLoading({
			title: '开始查找设备',
			mask: true
		});

		let GetBluetoothDevicesRes = await ble.GetBluetoothDevices()
		console.log("GetBluetoothDevicesRes:",GetBluetoothDevicesRes)
		if(GetBluetoothDevicesRes.err !=null || GetBluetoothDevicesRes.devices.length<1){
			res.err = "找不到设备"
			resolve(res)
		}


		GetBluetoothDevicesRes.devices.forEach(function(item, index) {
			if (bleName == item.name || bleName == item.localName) {
				console.log("找到设备", item, )
				res.data = item
				uni.hideLoading();
				resolve(res)

			}

		})

		if (res.data != null) {
			return
		}

		setTimeout(function() {
			uni.hideLoading();
			ble.StopBluetoothDevicesDiscovery()
			res.err = "找不到设备"
			resolve(res)
		}, timeOut)
		//开启监听
		uni.onBluetoothDeviceFound(function(devices) {
			console.log('new device list has founded')
			console.dir(devices)
				console.log(devices.devices.localName, bleName )
			if (devices.devices[0].localName == bleName || devices.devices[0].name == bleName) {

				console.log("找到设备2", devices.devices[0] )
				res.data = devices.devices[0]

				ble.StopBluetoothDevicesDiscovery()
				uni.hideLoading();
				resolve(res)
			}
			console.log(ble.ab2hex(devices.devices[0].advertisData))
		})

		ble.StartBluetoothDevicesDiscovery(services)


	})


	console.log(openBluetoothAdapter)

}

async function ConnectionBle(deviceId, serverid = "00000D38-0000-1000-8000-00805F9B34FB") {
	let res = {
		"err": null,
		"data": null
	}
	uni.showLoading({
		title: '开始连接设备',
		mask: true
	});

	return new Promise(async (resolve, reject) => {


		//连接设备
		await ble.CreateBLEConnection(deviceId)
		setTimeout(function() {
			uni.hideLoading();
			resolve(res)
		}, 1000)
		//设置mtu
		await ble.SetBLEMTU(deviceId)
		//获取设备服务
		await ble.GetBLEDeviceServices(deviceId)
		//获取设备服务下特征值
		await ble.GetBLEDeviceCharacteristics(deviceId, serverid)


	})

}



async function WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data) {
	let res = {
		"err": null,
		"data": null
	}
	uni.showLoading({
		title: '开始写入数据',
		mask: true
	});

	return new Promise(async (resolve, reject) => {

		setTimeout(function() {
			uni.hideLoading();
			ble.StopBluetoothDevicesDiscovery()
			res.err = "等待设备回复超时"
			resolve(res)
		}, 5000)

		uni.onBLECharacteristicValueChange(function(res) {
			console.log(
				`characteristic ${res.characteristicId} has changed, now is ${res.value}`)
			console.log(ble.ab2hex(res.value))
			console.log(ble.ab2str(res.value))

			res.data = ble.ab2str(res.value)
			uni.hideLoading();
			resolve(res)
		})

		//获取设备服务下特征值
		await ble.WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data)


	})

}

module.exports = {
	SearchDevice,
	SearchDevicewBleName,
	ConnectionBle,
	WriteBLECharacteristicValue
};
