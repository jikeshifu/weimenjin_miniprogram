var dateTimePicker = require('../../utils/dateTimePicker.js');
var BleSearch = require('../../module/ble/bleSearch');
var Ble = require('../../module/ble/ble');
var BleConnection = require('../../module/ble/bleConnection');
const app = getApp();
Page({
    data: {
        lockcard_sn: '',
        device_sn: '',
        lockcard_username: '',
        lockcard_remark: '',
        dateTimeArray: null,
        dateTime: null,
        dateIndex: [0, 0, 0, 0, 0, 0],
        endtime: '', // 过期时间
        startYear: 2020,
        endYear: 2050,
        user_id: 0,   // 管理员id，不是小程序用户的id
        lock_id: 0, // 锁id
        lockauth_id: 0, // 钥匙ID，当传此值时查询当前钥匙下绑定的卡
        formData: {
            wifi_name: "",
            wifi_pwd: "",
            device_pwd: "12345687",

        },
        bleList:[]
    },
    onShow: function () {

  
    },
    onHide: function () {

        wx.closeBluetoothAdapter({
            success(res) {
                console.log(res)
            }
        })

    },
    onLoad: function (options) {


        var timestamp = Date.parse(new Date());
        timestamp = timestamp / 1000;

        var nowdate = this.timestampToTime(timestamp, 'Y-m-d H:i:s', 0);
        var enddate = this.timestampToTime(timestamp, 'Y-m-d H:i:s', 1);
        //console.log('today:'+today);
        //console.log('nowdate:'+nowdate);
        // 获取完整的年月日 时分秒，以及默认显示的数组
        var obj = dateTimePicker.dateTimePicker(this.data.startYear, this.data.endYear, nowdate);

       let formData= wx.getStorageSync('wifiConfig')
     
      if(formData){
        this.setData({
          formData: formData,
      });
      }
   

        this.setData({
     
            endtime: enddate,
            dateTime: obj.dateTime,
            dateTimeArray: obj.dateTimeArray
        });
    },
    pwdNameSet: function (e) {

        let formData = this.data.formData
        formData.pwd_name = e.detail.value
        this.setData({
            formData: formData
        });
    },
    deviceSnSet: function (e) {


        this.setData({
            device_sn: e.detail.value
        });
    },
    wifiNameSet: function (e) {

        let formData = this.data.formData
        formData.wifi_name = e.detail.value
        wx.setStorageSync('wifiConfig', formData)
        this.setData({
            formData: formData
        });
    }, wifiPwdSet: function (e) {

        let formData = this.data.formData
        formData.wifi_pwd = e.detail.value
        wx.setStorageSync('wifiConfig', formData)
        this.setData({
            formData: formData
        });
    }, devicePwdSet: function (e) {

        let formData = this.data.formData
        formData.device_pwd = e.detail.value
        this.setData({
            formData: formData
        });
    },
    endDate: function (e) {
        var dateTimeArray = this.data.dateTimeArray;
        var dateTime = e.detail.value;
        var endtime = dateTimeArray[0][dateTime[0]] + '-' + dateTimeArray[1][dateTime[1]] + '-' + dateTimeArray[2][dateTime[2]] + ' ' + dateTimeArray[3][dateTime[3]] + ':' + dateTimeArray[4][dateTime[4]] + ':' + dateTimeArray[5][dateTime[5]];
        this.setData({
            dateIndex: dateTime,
            endtime: endtime
        });
    },
    bindScan() {
        //console.log('aaa');
        var that = this;
        wx.scanCode({
            onlyFromCamera: true, // 只允许从相机扫码
            scanType: "qrCode",
            success: (res) => {
                // res.result 是二维码扫码的结果
                that.setData({
                    device_sn: res.result
                });
            },
            fail: (res) => {
                wx.showToast({
                    title: '扫码失败请重试',
                    icon: 'none',
                    mask: true, // 是否显示透明蒙层，防止触摸穿透
                    duration: 2000
                });
            }
        })
    },
    search: async function () {
      let this1 =this
        //搜索对应的设备
      await BleSearch(123,5000).catch((err) => {
          console.log(err,err)
      })
      let GetBluetoothDevices=   await  Ble.GetBluetoothDevices().catch()
        console.log("GetBluetoothDevices:",GetBluetoothDevices)

        this.setData({
            "bleList":GetBluetoothDevices,
        })
        var itemList = [];

      if (GetBluetoothDevices.length<1){
       
          wx.showModal({
            title: '提示',
            content: '没有找到设备,是否重试',
            success (res) {
              if (res.confirm) {
                console.log('用户点击确定')
                this1.search()
              } else if (res.cancel) {
                console.log('用户点击取消')
           
              }
            }
          })
          return
      }
        GetBluetoothDevices.forEach(function (item, index) {
            if(item.name){
                itemList.push(item.name)
            }else if(item.localName){
                itemList.push(item.localName)
            }

                console.log("item",item, )
                console.log("index",index, )
        })
        wx.closeBluetoothAdapter({
            success(res) {
                console.log(res)
            }
        })
        console.log("itemList",itemList, )
        let _this =this
        let itemList6=itemList
        
        if(itemList.length>6){
          itemList6=itemList.slice(0,6)
        }
        wx.showActionSheet({
            itemList: itemList6,
            success (res) {
                _this.setData({
                    device_sn:itemList[res.tapIndex]
                })
                wx.setClipboardData({
                    data: itemList[res.tapIndex],
                    success(res) {
                        console.log('success', res);
                        wx.showToast({
                            title: "复制序列号成功",

                            mask: true, // 防止触摸穿透
                            duration: 2000
                        });
                    }
                })

            },
            fail (res) {
                console.log(res.errMsg)
            }
        })

    },
    doSubmit: async function () {
        console.log("this.data.device_sn",this.data.device_sn)
        if (!this.data.device_sn){
            wx.showToast({
                title: "设备序列号不能为空",
                icon: 'none',
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        if (!this.data.formData.wifi_name){
            wx.showToast({
                title: "wifi名称不能为空",
                icon: 'none',
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        if (!this.data.formData.device_pwd){
            wx.showToast({
                title: "设备密码不能为空",
                icon: 'none',
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        //搜索对应的设备
        let deviceInfo = await BleSearch(this.data.device_sn).catch((err) => {
            wx.showToast({
                title: "未找到设备请重试",
                icon: 'none',
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
        })
        console.log("deviceInfo", deviceInfo)
        if (!deviceInfo) {
            return
        }
        wx.showToast({
            title: "正在连接蓝牙",
            icon: 'loading',
            mask: true, // 是否显示透明蒙层，防止触摸穿透
            duration: 2000
        });
        //连接设备
        let BleConnectionRes = await BleConnection(deviceInfo.deviceId).catch(() => {
        })
        if (!BleConnectionRes) {
            return
        }
        wx.showToast({
            title: "正在配网",
            icon: 'loading',
            mask: true, // 是否显示透明蒙层，防止触摸穿透
            duration: 3000
        });
        //开启订阅
        await Ble.NotifyBLECharacteristicValueChange(deviceInfo.deviceId, "00000D38-0000-1000-8000-00805F9B34FB", "000032FF-0000-1000-8000-00805F9B34FB")
        //写入数据同时监听回调
        let Write = await Ble.WriteBLECharacteristicValueOnBLECharacteristicValueChange(deviceInfo.deviceId, "00000D38-0000-1000-8000-00805F9B34FB", "000031FF-0000-1000-8000-00805F9B34FB", JSON.stringify(this.data.formData)).catch(() => {
        })
        wx.closeBluetoothAdapter({
            success(res) {
                console.log(res)
            }
        })

        if (!Write) {
            wx.showToast({
                title: "配置失败",
                icon: 'none',
                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }


        let WriteStr =Ble.ab2str(Write)
            console.log("WriteStr",WriteStr)
        const json1 = WriteStr.substring(WriteStr.indexOf('{'), WriteStr.lastIndexOf('}') + 1);
        console.log("json1",json1)
        let WriteObj = JSON.parse(json1)
        console.log("WriteObj",WriteObj)
        if (WriteObj.state===1) {
            wx.showToast({
                title: "配置成功",

                mask: true, // 是否显示透明蒙层，防止触摸穿透
                duration: 2000
            });
            return
        }
        wx.showToast({
            title: "配置失败",
            icon: 'none',
            mask: true, // 是否显示透明蒙层，防止触摸穿透
            duration: 2000
        });

        console.log("Write", Ble.ab2str(Write))
        console.log("cs", this.data.formData)
    },
    timestampToTime: function (timestamp, format, push) {
        if (timestamp == undefined || timestamp == 0) {
            return '';
        }
        var date = new Date(timestamp * 1000);
        if (push < 1) {
            var Y = date.getFullYear() + '-';
        } else {
            var Y = date.getFullYear();
            Y = Y + 1;
            Y = Y + '-';
        }
        var m = (date.getMonth() + 1 < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1) + '-';
        var d = date.getDate() < 10 ? '0' + date.getDate() + ' ' : date.getDate() + ' ';
        var H = date.getHours() < 10 ? '0' + date.getHours() + ':' : date.getHours() + ':';
        var i = date.getMinutes() < 10 ? '0' + date.getMinutes() + ':' : date.getMinutes() + ':';
        var s = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
        if (format == 'Y-m-d') {
            return Y + m + d;
        }
        return Y + m + d + H + i + s;
    }
})
