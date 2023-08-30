Page({
    data: {
        //是否已经连接上设备
        join_wifi:false,
//设备是否在重启
        restart: false,
//设备ssid
        device_ssid: "",
//wifi-ssid KGIoT
        ssid: '',
//wifi密码 9638527410
        pwd: '',
//是否显示密码
        show_pwd: false,
        //设备列表
        device_up:false,
//是否显示弹窗
        pop_up: false,
//wifi列表
        wifi_list: [],
        //sn列表
       sn_arr: [],
       //选择的数组下标
       sn_key:0,
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad(options) {
        wx.setNavigationBarTitle({
            title: 'WiFi配网工具'
        })
        // this.get_wifi_sn();
    },
    /**
     * 生命周期函数--监听页面显示
     */
    onShow() {
          let name=wx.getStorageSync("wifi_name");
          if(name)this.setData({ssid:name})
          let pwd=wx.getStorageSync("wifi_pwd");
          if(pwd)this.setData({pwd:pwd})
    },
    set_show_pwd(val) {
        this.setData({show_pwd:val.currentTarget.dataset['index']})
    },
    bindPickerChange: function(e) {
        this.setData({
          sn_key: e.detail.value,
          device_ssid:this.data.sn_arr[e.detail.value]
        })
      },
 //通过wifi获取sn也就是wifi名称
 get_wifi_sn(){
    let _this = this;
    // _this.setData({sn_arr:[]});
    let arr=[];
    wx.startWifi({
        success (res) {
            wx.onGetWifiList(res=>{
                // console.log(res.wifiList)
                res.wifiList.forEach(item=>{
                    if(item.SSID.indexOf("W8")!=-1){
                        arr.push(item.SSID)
                    }
                })
                _this.setData({sn_arr:arr});
                _this.setData({device_up:true})
               
            })
            wx.getWifiList({
                fail(){
                    _this.show_toast("获取列表失败请重试") 
                }
            })
        },
        fail(){
            _this.show_toast("请打开wifi") 
        }
      })
 },
//扫码获取设备ssid
    get_device() {
        let _this = this;
        wx.scanCode({
            success: function (res) {
               _this.setData({device_ssid:res.result})
                // _this.data.restart = false;
                // _this.set_device();
            }
        });
    },
    set_wifi() {
      
        if (!this.data.device_ssid) {
            this.show_toast("请先获取设备序列号(SN)")
            return;
        }
        if (!this.data.join_wifi) {
            this.set_device();
            return;
        }
    
        if (!this.data.ssid) {
            this.show_toast("WiFi名称不能为空")
            return;
        }
        if (!this.data.pwd) {
            this.show_toast("密码不能为空")
            return;
        }
        wx.setStorageSync("wifi_name",this.data.ssid);
        wx.setStorageSync("wifi_pwd",this.data.pwd);
        wx.showLoading({
            title: "正在配网中...",
            mask: true
        })
        let _this = this; 
        wx.request({
            url: 'http://192.168.11.1',
            method: 'POST',
            timeout:10000,
            data: {
                ssid: this.data.ssid,
                passwd: this.data.pwd,
            },
            success: (res) => {
                _this.data.restart = true;
                console.log('返回',res)
                if (res.data.state === 0) {
                    _this.show_toast("配置成功")
                    return;
                }
                if (res.data.state === 1) {
                    _this.show_toast("配置失败")
                    return;
                }
                if (res.data.state === 2) {
                    _this.show_toast("WiFi连接失败")
                    return;
                }
            },
            fail(){
                wx.hideLoading();
                _this.show_toast("请检查手机是否连上配置信号")
            }
        });
    },
//设置wifi名称
    set_ssid(val) {
        this.setData({ssid:val.currentTarget.dataset['index']})
    },
    //是否显示弹窗
    set_pop_up(val) {
        this.setData({pop_up:val.currentTarget.dataset['index']})
    },
     //设置sn
     set_sn(val) {
        this.setData({device_ssid:val.currentTarget.dataset['index']})
        this.setData({device_up:false})
        this.setData({restart:false})
        this.setData({join_wifi:false});
        this.set_device();
    },
    //当sn改变时
    sn_change(){
        this.setData({restart:false})
        this.setData({join_wifi:false});
    },
     //是否显示弹窗
     set_device_up(val) {
        this.setData({device_up:val.currentTarget.dataset['index']})
    },
//获取wifi列表
    get_wifi() {
        if (!this.data.device_ssid) {
            this.show_toast("请先获取设备序列号")
            return;
        }
        console.log('加入了设备wifi',this.data.join_wifi)
        if (!this.data.join_wifi) {
            this.set_device();
            return;
        }
        let _this = this;
        this.setData({pop_up:true})
        let arr = [];
        wx.showLoading({
            title: "正在获取wifi列表...",
            mask: true
        })
        setTimeout(()=>{
            wx.hideLoading();
        },5000)
        wx.request({
            url: 'http://192.168.11.1/scanningwifi',
            method: 'GET',
            success: (res) => {
                wx.hideLoading();
                this.setData({wifi_list:res.data})
            },
            fail:(res)=>{
                wx.hideLoading();
                console.log(res)
                this.show_toast("请检查手机是否连上配置信号")
            }
        });
    },
//弹窗提醒
    show_toast(val) {
        wx.showToast({
            icon: "none",
            title: val
        })
    },
//连接设备
    set_device() {
        if (!this.data.device_ssid) {
            this.show_toast("请先获取设备序列号")
            return;
        }
        wx.showLoading({
            title: "正在连接设备...",
            mask: true
        })
        var _this = this;
        wx.startWifi({
            success: () => {
                //连接wifi
                wx.connectWifi({
                    SSID: this.data.device_ssid,
                    password: "",
                    success: (res) => {
                        setTimeout(() => {
                            _this.show_toast("设备连接成功")
                            //连接成功后去配网
                            _this.set_wifi();
                        }, 500)
                        //关闭wifi模块
                        wx.stopWifi()
                    },
                    fail(res) {
                        setTimeout(() => {
                            _this.show_toast("请检查设备是否进入了配网模式或是否已打开WiFi！")
                        }, 500)
                    },
                    complete() {
                        _this.setData({join_wifi:true});
                        wx.hideLoading();
                    }
                })
            },
            fail: (res) => {
                wx.hideLoading();
                setTimeout(() => {
                    _this.show_toast("请使用手机进行操作！")
                }, 500)
            },
        });

    }


})