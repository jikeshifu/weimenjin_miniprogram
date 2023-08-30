var ble = require('./ble');





let BleConnection =  function (deviceId,serviceId="00000D38-0000-1000-8000-00805F9B34FB") {

    return new Promise(async function (resolve, reject) {
        //连接设备
        await ble.CreateBLEConnection(deviceId).catch((err) => {
            reject(err)
        })

        //设置mtu
        wx.setBLEMTU({
            deviceId,
            mtu: 213,
            success(res) {

            }
        })
        //获取所有服务
        await ble.GetBLEDeviceServices(deviceId).catch(() => {
            reject(err)
        })
        //获取对应服务下所有特征
        await ble.GetBLEDeviceCharacteristics(deviceId, serviceId).catch(() => {
            reject(err)
        })

        resolve("连接成功")
    })

}




module.exports = BleConnection
