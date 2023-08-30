let OpenBluetoothAdapter = function () {
    //初始化蓝牙
    return new Promise(function (resolve, reject) {
        //初始化蓝牙
        wx.openBluetoothAdapter({
            success(res) {
                resolve(res)

            }, fail(err) {
                wx.showToast({
                    title: "请打开蓝牙",
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}

let CreateBLEConnection = function (deviceId) {
    //初始化蓝牙
    return new Promise(function (resolve, reject) {
        //启动搜索
        wx.createBLEConnection({
            deviceId,
            success(res) {
                resolve(res)
            }, fail(err) {
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}


let GetBLEDeviceServices = function (deviceId) {
    //初始化蓝牙
    return new Promise(function (resolve, reject) {
        //启动搜索
        wx.getBLEDeviceServices({
            deviceId,
            success(res) {
                resolve(res)
            }, fail(err) {
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })
}


let GetBLEDeviceCharacteristics = function (deviceId, serviceId) {

    return new Promise(function (resolve, reject) {
        //启动搜索
        wx.getBLEDeviceCharacteristics({
            deviceId,
            serviceId,
            success(res) {
                console.log("GetBLEDeviceCharacteristics", res)
                resolve(res)
            }, fail(err) {
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })
}
let StartBluetoothDevicesDiscoveryNoServices = function () {
    //初始化蓝牙
    return new Promise(function (resolve, reject) {
        //启动搜索
        wx.startBluetoothDevicesDiscovery({
            allowDuplicatesKey: true,

            success(res) {
                resolve(res)
            }, fail(err) {
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}
let StartBluetoothDevicesDiscovery = function () {
    //初始化蓝牙
    return new Promise(function (resolve, reject) {
        //启动搜索
        wx.startBluetoothDevicesDiscovery({
            allowDuplicatesKey: true,
            services: ["0d38"],
            success(res) {
                resolve(res)
            }, fail(err) {
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}


let WriteBLECharacteristicValue = function (deviceId, serviceId, characteristicId, data) {

    return new Promise(function (resolve, reject) {

        wx.writeBLECharacteristicValue({
            // 这里的 deviceId 需要在 getBluetoothDevices 或 onBluetoothDeviceFound 接口中获取
            deviceId,
            // 这里的 serviceId 需要在 getBLEDeviceServices 接口中获取
            serviceId,
            // 这里的 characteristicId 需要在 getBLEDeviceCharacteristics 接口中获取
            characteristicId,
            // 这里的value是ArrayBuffer类型
            value: str2ab(data),
            success(res) {
                resolve(res)
                console.log('writeBLECharacteristicValue success', res.errMsg)
            }, fail(err) {
                wx.closeBluetoothAdapter({
                    success (res) {
                        console.log(res)
                    }
                })
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}
let WriteBLECharacteristicValueOnBLECharacteristicValueChange = async function (deviceId, serviceId, characteristicId, data) {

    return new Promise(async function (resolve, reject) {
        //
        wx.onBLECharacteristicValueChange(function (res) {
            console.log(`characteristic ${res.characteristicId} has changed, now is ${res.value}`)
            console.log(ab2hex(res.value))
            resolve(res.value)

        })
        setTimeout(function () {
            reject("监听回调超时")
        }, 5000)
        await WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data).catch(() => {
        })
        wx.showToast({
            title: "数据写入成功等待返回数据",
            icon: 'loading',
            mask: true, // 是否显示透明蒙层，防止触摸穿透
            duration: 10000
        });
    })


}

let NotifyBLECharacteristicValueChange = function (deviceId, serviceId, characteristicId) {

    return new Promise(function (resolve, reject) {

        wx.notifyBLECharacteristicValueChange({
            state: true, // 启用 notify 功能
            // 这里的 deviceId 需要在 getBluetoothDevices 或 onBluetoothDeviceFound 接口中获取
            deviceId,
            // 这里的 serviceId 需要在 getBLEDeviceServices 接口中获取
            serviceId,
            // 这里的 characteristicId 需要在 getBLEDeviceCharacteristics 接口中获取
            characteristicId,
            // 这里的value是ArrayBuffer类型

            success(res) {
                resolve(res)
                console.log('writeBLECharacteristicValue success', res.errMsg)
            }, fail(err) {
                wx.closeBluetoothAdapter({
                    success (res) {
                        console.log(res)
                    }
                })
                wx.showToast({
                    title: err.errMsg,
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
                reject(err)
            }
        })

    })


}


let ab2hex = function (buffer) {
    var hexArr = Array.prototype.map.call(
        new Uint8Array(buffer),
        function (bit) {
            return ('00' + bit.toString(16)).slice(-2)
        }
    )
    return hexArr.join('');
}


/**
 * 将字符串转类型化数组
 */
let str2ab = function (str) {
    var buf = new ArrayBuffer(str.length * 2); // 每个字符占用2个字节
    var bufView = new Uint8Array(buf);// Uint8Array可换成其它
    for (var i = 0, strLen = str.length; i < strLen; i++) {
        bufView[i] = str.charCodeAt(i);
    }
    return buf;
}
/**
 * 类型化数组将转字符串
 */
function ab2str(arrayBuffer) {
    return String.fromCharCode.apply(null, new Uint8Array(arrayBuffer));
}

let GetBluetoothDevices=function(){

    return new Promise(function (resolve, reject) {
        wx.getBluetoothDevices({
            success: function (res) {
                console.log(res)
                if (res.devices[0]) {
                    console.log(ab2hex(res.devices[0].advertisData))
                }
                resolve(res.devices)
            },fail(err) {
                reject(err)
            }
        })
    })

}
module.exports = {
    OpenBluetoothAdapter,
    GetBluetoothDevices,
    CreateBLEConnection,
    GetBLEDeviceServices,
    GetBLEDeviceCharacteristics,
    WriteBLECharacteristicValue,
    WriteBLECharacteristicValueOnBLECharacteristicValueChange,
    NotifyBLECharacteristicValueChange,
    ab2hex,
    str2ab,
    ab2str,
    StartBluetoothDevicesDiscovery,
    StartBluetoothDevicesDiscoveryNoServices
}
