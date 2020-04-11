const app = getApp();
Page({
  data: {
    username: '', // 姓名
    phone: '',
    curaddress: '', // 当前位置
    address1: '',
    address2: '',
    job: '',
    registerArr: ['村居(物业)', '乡镇社区', '区县', '交通运输', '校园'], // 登记类型 默认1村居(物业),2乡镇社区,3区县,4交通运输
    registerIndex: 0,
    yiquArr: ['','是', '否'], // 30日内是否来自疫区:1是,默认2否
    yiquIndex: 0,
    healthArr: ['健康', '发热', '发热咳嗽', '头晕乏力', '腹泻', '其他'], // 健康状况:默认1健康,2异常,3其他
    healthIndex: 0,
    manyouimg: '../../images/upload.png', // 漫游截图
    txzimg: '../../images/upload.png',     // 通行证截图
    create_time:''
  },
  onShow:function () {
    if (app.globalData.userid < 1) {
      wx.navigateTo({
        url: '../wxlogin/wxlogin'
      })
    }
  },
  onLoad: function (options) {
    var that = this;
    console.log(options)
    console.log('token:');
    console.log(app.globalData.token)
    wx.request({
      url: app.globalData.domain+'/api/Health/view',
      method: "POST",
      header:{
        "Authorization": app.globalData.token
      },
      data: {
        health_id: options.id,
        //health_id: 10,
      },
      success: function (res) {
        console.log('getmore-success-res');
        console.log(res);
        var manyou = res.data.data.manyou != '' ? app.globalData.domain+res.data.data.manyou : '../../images/upload.png';
        var txz = res.data.data.txz != '' ? app.globalData.domain+res.data.data.txz : '../../images/upload.png';
        var create_time = that.timestampToTime(res.data.data.create_time);
        that.setData({
          username: res.data.data.name,
          phone: res.data.data.mobile,
          curaddress: res.data.data.position,
          address1: res.data.data.first_address,
          address2: res.data.data.second_address,
          job: res.data.data.job,
          yiquIndex: res.data.data.yiqu,
          registerIndex: parseInt(res.data.data.register_type)-1,
          healthIndex: parseInt(res.data.data.health)-1,
          create_time: create_time,
          manyouimg: manyou,
          txzimg: txz
        });
      },
      fail: function (res) {
        wx.showToast({
          title: '网络故障，请稍后重试',
          icon: 'none',
          mask: true, // 防止触摸穿透
          duration: 2000
        });
      }
    });
  },
  timestampToTime: function (timestamp) {
    if (timestamp == undefined || timestamp==0){
      return '';
    }
    var date = new Date(timestamp * 1000);
    var Y = date.getFullYear() + '-';
    var m = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
    var d = date.getDate() < 10 ? '0'+date.getDate()+' ' : date.getDate()+' ';
    var H = date.getHours() < 10 ? '0'+date.getHours()+':' : date.getHours()+':';
    var i = date.getMinutes() < 10 ? '0'+date.getMinutes()+':' : date.getMinutes()+':';
    var s = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds();
    return Y+m+d+H+i+s;
  }
})