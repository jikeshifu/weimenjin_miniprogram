var dateTimePicker = require('../../utils/dateTimePicker.js');
var BleSearch = require('../../module/ble/bleSearch');
var Ble = require('../../module/ble/ble');
var BleConnection = require('../../module/ble/bleConnection');
const app = getApp();
Page({
    data: {
        rd:'',
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
        this.setData({
            formData: formData
        });
    }, wifiPwdSet: function (e) {

        let formData = this.data.formData
        formData.wifi_pwd = e.detail.value
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

    }, rdCp: function (e) {

      wx.setClipboardData({
        data: this.data.rd,
        success(res) {
            console.log('success', res);
            wx.showToast({
                title: "复制热点名称成功",

                mask: true, // 防止触摸穿透
                duration: 2000
            });
        }
    })
  },
    doSubmit: async function () {
      console.log("this.data.formData.wifi_name.lenght",this.data.formData)
      if(!this.data.formData.wifi_name|| this.data.formData.wifi_name.length <1 ){
        wx.showToast({
          title: "请输入wifi名称",
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
      });
      return
      }
      //^wmj^0KGIoT*^_^*9638527410
       let rd= "^wmj^0"+ this.data.formData.wifi_name+"*^_^*"+ this.data.formData.wifi_pwd
        console.log('rd.lenght：',rd.length)
       if(rd.length >63 ){
        wx.showToast({
          title: "wifi名称密码过长",
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
      });
      return
      }
      console.log('this.data.wifi_pwd', rd)
      this.setData({
        rd:rd
    })
      wx.setClipboardData({
        data: rd,
        success(res) {
            console.log('success', res);
            wx.showToast({
                title: "复制热点名称成功",

                mask: true, // 防止触摸穿透
                duration: 2000
            });
        }
    })
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
