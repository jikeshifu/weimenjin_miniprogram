var ble = require('./ble');
var request = require('../request/index');
var bleConnection = require('./bleConnection');

let OpenLock = function (deviceSn,lock_id) {
    return new Promise(async function (resolve, reject) {
        //8E400001-B5A3-F393-E0A9-E50E24DCCAAE
        //找到设备
        let bleInfo = await BleSearch(deviceSn).catch((err) => {
            console.log("BleSearch:", err)
        })
        console.log("bleInfo:", bleInfo)


        if (!bleInfo) {
            wx.showToast({
                title: "离线时不能远程开门",
                icon: "none",
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }

        let deviceId =bleInfo.deviceId
        const serviceId ="8E400001-B5A3-F393-E0A9-E50E24DCCAAE"

        //开锁发送蓝牙数据
        var opencode = deviceSn.slice(-6);
        opencode = parseInt(opencode);

        let data  = opencode * 3;
        console.log("err", 20)
        //连接上设备
        let BleConnectionRes =  await bleConnection(deviceId, serviceId).catch((err)=>{
            console.log("bleConnection:", err)
        })

        if (!BleConnectionRes) {
            wx.showToast({
                title: "连接设备失败",
                icon: "none",
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        //订阅回调数据
       await ble.NotifyBLECharacteristicValueChange(deviceId, serviceId,"8E400002-B5A3-F393-E0A9-E50E24DCCAAE")


       let  WriteBLECharacteristicValue=  await ble.WriteBLECharacteristicValueOnBLECharacteristicValueChange(deviceId, serviceId, "8E400003-B5A3-F393-E0A9-E50E24DCCAAE", data.toString()).catch(() => {
            console.log("WriteBLECharacteristicValueErr:", err)
        })
        //关闭蓝牙
        wx.closeBluetoothAdapter({
            success(res) {
                console.log(res)
            }
        })
        let lockOpen =1;
        if (!WriteBLECharacteristicValue ||ble.ab2str(WriteBLECharacteristicValue) != "btsuccess") {
            lockOpen =0
        }


        request.HttpPost("LockLog/add",{
            "status":lockOpen,
            "lock_id":lock_id,
        })


        if (lockOpen===0){
            wx.showToast({
                title: "开锁失败",
                icon: "none",
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        console.log("WriteBLECharacteristicValue:",ble.ab2str(WriteBLECharacteristicValue))

        wx.showToast({
            title: "蓝牙开门成功",
            icon: "success",
            mask: true, // 是否显示透明蒙层，防止触摸穿透
            duration: 2000
        });

    })
}

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
    let StartBluetoothDevicesDiscoveryInit = await ble.StartBluetoothDevicesDiscoveryNoServices().catch(()=>{})
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


module.exports = {
    OpenLock
}
