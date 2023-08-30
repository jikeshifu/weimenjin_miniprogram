var ble = require('./ble');
//进行10秒搜索对应的设备
let BleSearch = async function (BleName,timeOut=10000) {
    console.log(123)
    wx.showToast({
        title:"正在初始化蓝牙",
        icon: 'loading',
        mask: true, // 是否显示透明蒙层，防止触摸穿透
        duration: 3000
    });
    let bleInit = await ble.OpenBluetoothAdapter().catch(()=>{})
    if (!bleInit) {
        return
    }
    console.log("bleInit",bleInit)
    wx.showToast({
        title:"正在搜索设备",
        icon: 'loading',
        mask: true, // 是否显示透明蒙层，防止触摸穿透
        duration: timeOut
    });
    let StartBluetoothDevicesDiscoveryInit = await ble.StartBluetoothDevicesDiscovery().catch(()=>{})
    if (!StartBluetoothDevicesDiscoveryInit) {
        return
    }
    console.log("StartBluetoothDevicesDiscoveryInit",StartBluetoothDevicesDiscoveryInit)
    return new Promise(function (resolve, reject) {
        setTimeout(function () {
            wx.stopBluetoothDevicesDiscovery({
                success (res) {
                    reject(res)
                    console.log(res)
                }
            })
        },timeOut)

        wx.onBluetoothDeviceFound(function(res) {
            var devices = res.devices;
            console.log('new device list has founded')
            if(devices[0].name ==BleName ||devices[0].localName ==BleName){
                wx.stopBluetoothDevicesDiscovery({
                    success (res) {

                        console.log(res)
                    }
                })
                resolve(devices[0])


            }
            console.log(devices[0].name)
            console.log(devices[0].localName)
            console.log(ble.ab2hex(devices[0].advertisData))
        })
    })


}


module.exports = BleSearch
