// var dateTimePicker = require('../../utils/dateTimePicker.js');
let request = require('../../module/request/index');
const app = getApp()
Page({
    data: {
        lock_id:0,
        formData:{
            "available_electricity": 0, //暂未使用
            "electric_current": 0,  //当前电路（单位：A）
            "heartbeat":0,  //业务参数：断路器工作状态1: 正常 0：异常
            "iccid": "",  //iccid
            "imei": "",  //imei
            "power": 0,  //当前功率（单位：W）
            "project": "", //
            "rssi": -0,    //rssi
            "switch_state": 0, //断路器状态1:打开0:断开
            "total_electricity": 0, //总用电量（单位：kw*h）
            "version": "0.0.0",  //version
            "voltage": 0  //当前电压（单位：V）

        }

    },
    onShow: async function () {
       let info =  await  request.HttpPost("device.Device/info",{
                "lock_id":this.data.lock_id
            }).catch(()=>{})
        if(!info){

            setTimeout(function () {
                wx.switchTab({
                    url: '../index/index'
                })
            },1500)

            return
        }
        this.setData({
            formData: info.data
        });

    },
    onLoad: function (options) {
        console.log(options)
        this.setData({
            lock_id: options.lock_id
        });
    },


})
