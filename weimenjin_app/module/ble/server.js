import ble from './index.js'; // 默认导入

async function SearchDevice(timeOut = 4000) {
  let res = { err: null };

  return new Promise(async (resolve) => {
    uni.showLoading({ title: '开始查找设备', mask: true });
    
    setTimeout(function () {
      uni.hideLoading();
      ble.StopBluetoothDevicesDiscovery();
      resolve();
    }, timeOut);

    // 开启监听
    uni.onBluetoothDeviceFound(function (devices) {
      //console.log('new device list has founded');
      //console.log(devices);
	  ble.ab2hex(devices.devices[0].advertisData)
      //console.log();
    });

    ble.StartBluetoothDevicesDiscovery();
  });
}

async function SearchDevicewBleName(bleName, timeOut = 4000, services = ["0D38"]) {
  let res = { err: null, data: null };

  return new Promise(async (resolve) => {
    uni.showLoading({ title: '开始查找设备', mask: true });

    let GetBluetoothDevicesRes = await ble.GetBluetoothDevices();
    if (GetBluetoothDevicesRes.err != null) {
      res.err = GetBluetoothDevicesRes.err;
      resolve(res);
    }

    GetBluetoothDevicesRes.devices.forEach(function (item) {
      if (bleName == item.name || bleName == item.localName) {
        res.data = item;
        uni.hideLoading();
        resolve(res);
      }
    });

    setTimeout(function () {
      uni.hideLoading();
      ble.StopBluetoothDevicesDiscovery();
      res.err = '找不到设备';
      resolve(res);
    }, timeOut);

    uni.onBluetoothDeviceFound(function (devices) {
      if (devices.devices[0].localName == bleName || devices.devices[0].name == bleName) {
        res.data = devices.devices[0];
        ble.StopBluetoothDevicesDiscovery();
        uni.hideLoading();
        resolve(res);
      }
    });

    ble.StartBluetoothDevicesDiscovery(services);
  });
}

async function ConnectionBle(deviceId, serverid = "00000D38-0000-1000-8000-00805F9B34FB") {
  let res = { err: null, data: null };
  uni.showLoading({ title: '开始连接设备', mask: true });

  return new Promise(async (resolve) => {
    await ble.CreateBLEConnection(deviceId);
    setTimeout(function () {
      uni.hideLoading();
      resolve(res);
    }, 1000);
    await ble.SetBLEMTU(deviceId);
    await ble.GetBLEDeviceServices(deviceId);
    await ble.GetBLEDeviceCharacteristics(deviceId, serverid);
  });
}

async function WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data) {
  let res = { err: null, data: null };
  uni.showLoading({ title: '开始写入数据', mask: true });

  return new Promise(async (resolve) => {
    setTimeout(function () {
      uni.hideLoading();
      ble.StopBluetoothDevicesDiscovery();
      res.err = '等待设备回复超时';
      resolve(res);
    }, 5000);

    uni.onBLECharacteristicValueChange(function (res) {
      res.data = ble.ab2str(res.value);
      res.hexData = ble.ab2hex(res.value);
      uni.hideLoading();
      resolve(res);
    });

    await ble.WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data);
  });
}

export default {
  SearchDevice,
  SearchDevicewBleName,
  ConnectionBle,
  WriteBLECharacteristicValue,
};
