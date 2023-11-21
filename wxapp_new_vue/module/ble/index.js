//初始化蓝牙

async function OpenBluetoothAdapter() {
	await CloseBluetoothAdapter()

	let res = {
		"err": null,

	}
	return new Promise((resolve, reject) => {

		uni.openBluetoothAdapter({
			success(res) {
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})
	})

}

//关闭蓝牙
function CloseBluetoothAdapter() {

	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.closeBluetoothAdapter({
			success(res) {
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}

//设置mtu
function SetBLEMTU(deviceId, mtu = 200) {

	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.setBLEMTU({
			deviceId,
			mtu,
			success(res) {
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}
// ArrayBuffer转16进度字符串示例
function ab2hex(buffer) {
	const hexArr = Array.prototype.map.call(
		new Uint8Array(buffer),
		function(bit) {
			return ('00' + bit.toString(16)).slice(-2)
		}
	)
	return hexArr.join('')
}
// 字符串转ArrayBuffer
function str2ab(str) {
	var buf = new ArrayBuffer(str.length * 2); // 每个字符占用2个字节
	var bufView = new Uint8Array(buf); // Uint8Array可换成其它
	for (var i = 0, strLen = str.length; i < strLen; i++) {
		bufView[i] = str.charCodeAt(i);
	}
	return buf;
}

function ab2str(arrayBuffer) {
	return String.fromCharCode.apply(null, new Uint8Array(arrayBuffer));
}
//获取一发现的设备
function GetBluetoothDevices(services = ["0D38"]) {
	console.log("获取已发现的设备")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.getBluetoothDevices({


			success(ok) {
				res.devices = ok.devices
				console.log("获取已发现的设备", ok)
				resolve(res)
			},
			fail(err) {
				console.log("获取已发现的设备错误", err)
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}



//开启蓝牙搜索
function StartBluetoothDevicesDiscovery(services = ["0D38"]) {
	console.log("蓝牙开始搜索", services)
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.startBluetoothDevicesDiscovery({
			services,
			allowDuplicatesKey: true,

			success(res) {
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}


//停止蓝牙搜索
function StopBluetoothDevicesDiscovery(services = ["0D38"]) {
	console.log("蓝牙停止搜索")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.stopBluetoothDevicesDiscovery({

			success(stopBluetoothDevicesDiscoveryRes) {
				res.data = stopBluetoothDevicesDiscoveryRes
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}





//连接设备
function CreateBLEConnection(deviceId) {
	console.log("连接设备")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.createBLEConnection({
			deviceId,
			success(createBLEConnectionRes) {
				res.data = createBLEConnectionRes
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}


//获取设备服务
function GetBLEDeviceServices(deviceId) {
	console.log("获取设备服务")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.getBLEDeviceServices({
			deviceId,
			success(getBLEDeviceServicesRes) {
				console.log("获取设备服务", getBLEDeviceServicesRes)
				res.data = getBLEDeviceServicesRes
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}


//获取设备服务下特征值
function GetBLEDeviceCharacteristics(deviceId, serviceId) {
	console.log("获取设备服务下特征值")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.getBLEDeviceCharacteristics({
			deviceId,
			serviceId,
			success(getBLEDeviceServicesRes) {
				console.log("获取设备服务下特征值", getBLEDeviceServicesRes)
				res.data = getBLEDeviceServicesRes
				resolve(res)
			},
			fail(err) {
				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}



//订阅特征值
function NotifyBLECharacteristicValueChange(deviceId, serviceId, characteristicId) {
	console.log("订阅特征值")
	let res = {
		"err": null,
	}
	return new Promise((resolve, reject) => {
		uni.notifyBLECharacteristicValueChange({
			state: true, // 启用 notify 功能
			deviceId,
			serviceId,
			characteristicId,
			success(notifyBLECharacteristicValueChangeRes) {
				console.log("订阅特征值", notifyBLECharacteristicValueChangeRes)
				res.data = notifyBLECharacteristicValueChangeRes
				resolve(res)
			},
			fail(err) {
				console.log("订阅错误", err)

				res.err = err.errMsg
				resolve(res)
			}
		})

	})

}

//写入数据
function WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data) {
	let res = {
		"err": null,
	}
	return new Promise(function(resolve, reject) {
		setTimeout(function() {
			uni.writeBLECharacteristicValue({
				// 这里的 deviceId 需要在 getBluetoothDevices 或 onBluetoothDeviceFound 接口中获取
				deviceId,
				// 这里的 serviceId 需要在 getBLEDeviceServices 接口中获取
				serviceId,
				// 这里的 characteristicId 需要在 getBLEDeviceCharacteristics 接口中获取
				characteristicId,
				// 这里的value是ArrayBuffer类型
				value: str2ab(data),
				success(writeBLECharacteristicValueRes) {
					console.log("写入数据", writeBLECharacteristicValueRes)
					res.data = writeBLECharacteristicValueRes
					resolve(res)
				},
				fail(err) {
					res.err = err.errMsg
					resolve(res)
				}
			})
		}, 500)


	})


}




module.exports = {
	CloseBluetoothAdapter,
	OpenBluetoothAdapter,
	ab2hex,
	SetBLEMTU,
	StartBluetoothDevicesDiscovery,
	StopBluetoothDevicesDiscovery,
	CreateBLEConnection,
	GetBLEDeviceServices,
	GetBluetoothDevices,
	GetBLEDeviceCharacteristics,
	NotifyBLECharacteristicValueChange,
	str2ab,
	ab2str,
	WriteBLECharacteristicValue,
};