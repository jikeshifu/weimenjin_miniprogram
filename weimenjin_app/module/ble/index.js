//初始化蓝牙
async function OpenBluetoothAdapter() {
  await CloseBluetoothAdapter();

  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.openBluetoothAdapter({
      success(res) {
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//关闭蓝牙
function CloseBluetoothAdapter() {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.closeBluetoothAdapter({
      success(res) {
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//设置mtu
function SetBLEMTU(deviceId, mtu = 200) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.setBLEMTU({
      deviceId,
      mtu,
      success(res) {
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

// ArrayBuffer转16进制字符串
function ab2hex(buffer) {
  const hexArr = Array.prototype.map.call(new Uint8Array(buffer), function (bit) {
    return ('00' + bit.toString(16)).slice(-2);
  });
  return hexArr.join('');
}

// 字符串转ArrayBuffer
function str2ab(str) {
  var buf = new ArrayBuffer(str.length * 2); 
  var bufView = new Uint8Array(buf);
  for (var i = 0, strLen = str.length; i < strLen; i++) {
    bufView[i] = str.charCodeAt(i);
  }
  return buf;
}

// ArrayBuffer 转字符串
function ab2str(arrayBuffer) {
  return String.fromCharCode.apply(null, new Uint8Array(arrayBuffer));
}

// 获取已发现的设备
function GetBluetoothDevices(services = ["0D38"]) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.getBluetoothDevices({
      success(ok) {
        res.devices = ok.devices;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//开启蓝牙搜索
function StartBluetoothDevicesDiscovery(services = ["0D38"]) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.startBluetoothDevicesDiscovery({
      services,
      allowDuplicatesKey: true,
      success(res) {
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//停止蓝牙搜索
function StopBluetoothDevicesDiscovery() {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.stopBluetoothDevicesDiscovery({
      success(stopBluetoothDevicesDiscoveryRes) {
        res.data = stopBluetoothDevicesDiscoveryRes;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//连接设备
function CreateBLEConnection(deviceId) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.createBLEConnection({
      deviceId,
      success(createBLEConnectionRes) {
        res.data = createBLEConnectionRes;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//获取设备服务
function GetBLEDeviceServices(deviceId) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.getBLEDeviceServices({
      deviceId,
      success(getBLEDeviceServicesRes) {
        res.data = getBLEDeviceServicesRes;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//获取设备服务下特征值
function GetBLEDeviceCharacteristics(deviceId, serviceId) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.getBLEDeviceCharacteristics({
      deviceId,
      serviceId,
      success(getBLEDeviceServicesRes) {
        res.data = getBLEDeviceServicesRes;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//订阅特征值
function NotifyBLECharacteristicValueChange(deviceId, serviceId, characteristicId) {
  let res = {
    err: null,
  };
  return new Promise((resolve, reject) => {
    uni.notifyBLECharacteristicValueChange({
      state: true,
      deviceId,
      serviceId,
      characteristicId,
      success(notifyBLECharacteristicValueChangeRes) {
        res.data = notifyBLECharacteristicValueChangeRes;
        resolve(res);
      },
      fail(err) {
        res.err = err.errMsg;
        resolve(res);
      },
    });
  });
}

//写入数据
function WriteBLECharacteristicValue(deviceId, serviceId, characteristicId, data) {
  let res = {
    err: null,
  };
  return new Promise(function (resolve, reject) {
    setTimeout(function () {
      uni.writeBLECharacteristicValue({
        deviceId,
        serviceId,
        characteristicId,
        value: str2ab(data),
        success(writeBLECharacteristicValueRes) {
          res.data = writeBLECharacteristicValueRes;
          resolve(res);
        },
        fail(err) {
          res.err = err.errMsg;
          resolve(res);
        },
      });
    }, 500);
  });
}

// 导出 ble 对象
const ble = {
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

export default ble;
