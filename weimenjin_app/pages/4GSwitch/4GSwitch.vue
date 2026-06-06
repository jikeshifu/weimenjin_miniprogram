<template>
  <view v-if="tabValue === 'remote'" class="container" :class="layoutClass">
    <!-- 头部标题和错误提示 -->
    <view class="header">
      <view class="title">三路继电器控制面板</view>
      <view v-if="showMsgText" class="msg-text">
        <uni-icons type="info" size="40" color="red" />
        <view class="msg-content">{{ showMsgText }}</view>
      </view>
    </view>

    <!-- 继电器卡片 -->
    <view class="responsive-row">
      <view class="responsive-col" :class="columnClass" v-for="relay in relays" :key="relay.id">
        <view class="relay-card" :class="{ 'active-on': relay.type === 'on' && relay.active, 'active-off': relay.type === 'off' && relay.active, 'active-standby': relay.type === 'standby' && relay.active }">
          <view class="relay-body">
            <!-- 使用 RelayComponent 组件 -->
            <RelayControl
              :type="relay.type"
              :active="relay.active"
              :screen-size="responsive.isSmallScreen ? 'small' : (responsive.isMediumScreen ? 'medium' : 'large')"
            />
          </view>
        </view>
        <!-- 开关 -->
        <view class="relay-footer">
            <view class="switch-title">{{ relay.typeTitle }}</view>
            <switch
              :checked="relay.lockup === 1"
              :data-id="relay.id"
              @change="onRelaySwitchChange"
              class="relay-switch"
              :style="{ transform: responsive.isSmallScreen ? 'scale(0.8)' : 'scale(1)' }"
              :color="relay.color"
            />
        </view>
        <!-- 按钮 -->
        <view class="relay-footer">
          <view
            class="btns"
            :class="`${relay.action}-btn`"
            hover-class="btns-hover"
            :data-id="relay.id"
            @click="onRelayButtonClick"
            hover-stay-time="100"
          >
            <view class="btn-ch">{{ relay.buttonText }}</view>
            <view class="btn-en">{{ relay.action }}</view>
          </view>
        </view>
      </view>
    </view>
  </view>
</template>

<script>
import RelayControl from '@/components/RelayControl/RelayControl.vue';
import {
		commonUrl
	} from '../../api/request.js'
export default {
  components: {
    RelayControl
  },
  data() {
    return {
		device_sn:"",
      relays: [
        {
          id: 'on',
          name: '开启继电器',
          type: 'on',
          icon: 'plus',
          color: '#07c160',
          buttonText: '开',
          active: false,
          statusText: '开启状态',
          typeTitle: '开锁止',
          lockup: 0,
          action: 'open'
        },
        {
          id: 'standby',
          name: '暂停继电器',
          type: 'standby',
          icon: 'pause',
          color: '#ed7b2f',
          buttonText: '停',
          active: false,
          statusText: '停状态',
          typeTitle: '停锁止',
          lockup: 0,
          action: 'stop'
        },
        {
          id: 'off',
          name: '关闭继电器',
          type: 'off',
          icon: 'minus',
          color: '#e34d59',
          buttonText: '关',
          active: false,
          statusText: '关闭状态',
          typeTitle: '关锁止',
          lockup: 0,
          action: 'close'
        }
      ],
	responsive: {
		isSmallScreen: false,
		isMediumScreen: false
	},
    layoutClass: '',
    columnClass: '',
    tabValue: 'remote',
    showMsgText: '',
	deviceConfig:{//设备配置信息
		csq: 0,
		cur_sw_sta: "000",
		on_line: 0,
		set_cfg_ctrl_lock: 0,
		sta: 0,
	},
	//设置相关
	adminTransPopupVisible:false,
	phoneError: false,
	transNum: '',
	isOnline: false,
	showRebootConfirm:false,
	//设备信息
	deviceInfo:{},
	isBlocked: false,
	isExpired: false,
};
  },
  async onLoad(options) {

	this.device_sn = options.device_sn

    const windowInfo = uni.getWindowInfo();
    this.responsive = {
      isSmallScreen: windowInfo.windowWidth < 600,
      isMediumScreen: windowInfo.windowWidth >= 600 && windowInfo.windowWidth < 900
    };
	await this.GetSta();
  },
  methods: {

	//获取设备状态
	async GetSta(){

	    const response = await new Promise((resolve, reject) => {
	      wx.request({
	          url: `${commonUrl}/device.Switch4G/GetSta`,
	          header: {
	              'content-type': 'application/json',
	              'Authorization': uni.getStorageSync("token")
	          },
	          data: {
	              device_sn: this.device_sn,
	          },
	          method: 'POST',
	          success: resolve,
	          fail: reject
	    });
	    });

	    if(response.data.code > 0){
	        wx.showToast({
	          title: `${response.data.code}:${response.data.msg}`,
	          icon: 'none',
	          duration: 1700 // 提示持续时间，单位毫秒
	        });
	        return
	    }
	    if (response.data.data.info.code !== 0) {
	        const code = response.data.data.info.code
			wx.showToast({
				title: code,
				icon: 'none',
				duration: 1700 // 提示持续时间，单位毫秒
			});
			return
	    }

	      const info = (response.data && response.data.data && response.data.data.info) || {}
	      const onLine = (info.on_line !== undefined && info.on_line !== null) ? info.on_line : 1
	      // 补齐长度，防止缺位
	      const paddedCurSwSta = curSwSta.padEnd(3, '0')

	      const updatedRelays = this.relays.map((relay) => {
	        let lockupChar = '0'

	        switch (relay.id) {
	          case 'on':
	            lockupChar = paddedCurSwSta.charAt(0)
	            break
	          case 'standby':
	            lockupChar = paddedCurSwSta.charAt(1)
	            break
	          case 'off':
	            lockupChar = paddedCurSwSta.charAt(2)
	            break
	        }

	        return {
	          ...relay,
	          lockup: lockupChar === '1' ? 1 : 0, // 保证是数字
	          active: lockupChar === '1' ? true : false
	        }
	      })

		this.relays = updatedRelays;
		this.deviceConfig = {
			...this.deviceConfig,
			...info,
			on_line: onLine
		};

	    if(this.deviceConfig.on_line == 0){
	        wx.showToast({
	          title: `设备不在线`,
	          icon: 'error',
	          duration: 1700
	        });
	        return
	    }

	},

    onRelayButtonClick(e) {
      const relayId = e.currentTarget.dataset.id;
      this.triggerRelayPulse(relayId);
    },
    onRelaySwitchChange(e) {
      const relayId = e.currentTarget.dataset.id;
      this.toggleRelayLock(relayId);
    },


	async toggleRelayLock(relayId) {
	  const targetRelay = this.relays.find((relay) => relay.id === relayId);


	  try {
	    const response = await new Promise((resolve, reject) => {
	      uni.request({
	        url:`${commonUrl}/device.Switch4G/Lockup`,
	        header: {
	          'content-type': 'application/json',
	          'Authorization': uni.getStorageSync("token")
	        },
	        data: {
				device_sn: this.device_sn,
				enable: targetRelay.lockup === 0 ? 1 : 0,
				cmd_type: `${targetRelay.action}_lockup`
	        },
	        method: 'POST',
	        success: resolve,
	        fail: reject
	      });
	    });

	    console.info(`请求成功: ${targetRelay.action}`, response);
	    if (response.data.code > 0) {
	      uni.showToast({
	        title: `${response.data.code}:${response.data.msg}`,
	        icon: 'none',
	        duration: 1700
	      });
	      return;
	    }

	    if (response.data.data.info.code !== 0) {
	      let showMsg = '出错啦！请重试';
	      switch (response.data.data.info.code) {
	        case 1009:
	          showMsg = '正在关闭中，请先停止后再次尝试打开';
	          break;
	        case 1008:
	          showMsg = `设备故障，请联系管理员${this.deviceInfo.OutMember.member_mobile}`;
	          break;
	        case 1003:
	          showMsg = '设备未校准，请校准后重试';
	          break;
	        case 1004:
	          showMsg = '设备正忙，请稍后重试';
	          break;
	        case 1002:
	          showMsg = '设置错误，请检查设置参数';
	          break;
	        default:
	          break;
	      }
	      this.showMsgText = showMsg;
	      return;
	    } else {
	      this.showMsgText = '';
	    }

	    uni.vibrateShort({
	      type: 'medium'
	    });
	  } catch (err) {
	    console.error(`请求失败: ${targetRelay.action}`, err);
	    return;
	  }

	  this.relays = this.relays.map((relay) => {
	    if (relay.id === relayId) {
	      const newLockup = relay.lockup === 0 ? 1 : 0;
	      return { ...relay, lockup: newLockup, active: newLockup === 1 };
	    }
	    return relay;
	  });
	},


	async triggerRelayPulse(relayId) {
	  const targetRelay = this.relays.find((relay) => relay.id === relayId);

	  const actionMap = {
	    open: 'Open',
	    stop: 'Stop',
	    close: 'Close'
	  };

	  try {
	    const response = await new Promise((resolve, reject) => {
	      uni.request({
			url:`${commonUrl}/device.Switch4G/Operation`,
	        header: {
	          'content-type': 'application/json',
	          'Authorization': uni.getStorageSync("token")
	        },
	        data: {
	          device_sn: this.device_sn,
	          cmd_type: targetRelay.action,
	        },
	        method: 'POST',
	        success: resolve,
	        fail: reject
	      });
	    });

	    console.info(`请求成功: ${targetRelay.action}`, response);
	    if (response.data.code > 0) {
	      uni.showToast({
	        title: `${response.data.code}:${response.data.msg}`,
	        icon: 'none',
	        duration: 1700
	      });
	      return;
	    }

	    if (response.data.data.info.code > 0) {
	      let showMsg = '出错啦！请重试';
	      switch (response.data.data.info.code) {
	        case 1009:
	          showMsg = '正在关闭中，请先停止后再次尝试打开';
	          break;
	        case 1008:
	          showMsg = `设备故障，请联系管理员${this.deviceInfo.OutMember.member_mobile}`;
	          break;
	        case 1003:
	          showMsg = '设备未校准，请校准后重试';
	          break;
	        case 1004:
	          showMsg = '设备正忙，请稍后重试';
	          break;
	        case 1002:
	          showMsg = '设置错误，请检查设置参数';
	          break;
	        default:
	          break;
	      }

	      this.showMsgText = showMsg;
	      return;
	    } else {
	      this.showMsgText = '';
	    }
	  } catch (err) {
	    console.error(`请求失败: ${targetRelay.action}`, err);
	    return;
	  }

	  setTimeout(() => {
	    this.GetSta();
	  }, 1000);

	  // Trigger pulse animation
	  this.relays = this.relays.map((relay) => {
	    if (relay.id === relayId) {
	      return { ...relay, active: true };
	    }
	    return relay;
	  });

	  uni.vibrateShort({
	    type: 'medium'
	  });

	  // Reset after 1 second
	  setTimeout(() => {
	    this.relays = this.relays.map((relay) => {
	      if (relay.id === relayId) {
	        return { ...relay, active: false };
	      }
	      return relay;
	    });
	  }, 1000);
	}

  }
};
</script>

<style scoped>
.container {
  padding: var(--page-padding, 16px);
  box-sizing: border-box;
}

.header {
  margin-bottom: 40rpx;
}

.title {
  font-size: var(--title-font-size, 16px);
  font-weight: bold;
  text-align: center;
  color: #333;
}

.responsive-row {
  display: flex;
  justify-content: center;
  gap: 30rpx;
}

.responsive-col {
  width: 200rpx;
}

.relay-card {
  margin-bottom: var(--card-gap, 16px);
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.relay-card-title {
  font-size: 28rpx;
  font-weight: bold;
  padding: 16rpx;
  text-align: center;
}

.relay-card.active-on .relay-card-title {
  background-color: #07c160;
  color: #fff;
}

.relay-card.active-off .relay-card-title {
  background-color: #e34d59;
  color: #fff;
}

.relay-card.active-standby .relay-card-title {
  background-color: #ed7b2f;
  color: #fff;
}

.relay-body {
  padding: 16rpx 0;
  text-align: center;
}

.relay-footer {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 8rpx 0;
}

.switch-title {
  font-size: 26rpx;
  text-align: center;
  color: #888;
  line-height: 50rpx;
  margin-right: 15rpx;
}

.relay-switch {
  transform: scale(1);
}

.btns {
  color: #fff;
  font-size: 28rpx;
  line-height: 96rpx;
  margin-bottom: 32rpx;
  text-align: center;
  width: 200rpx;
  height: 307rpx;
  border-radius: 37rpx;
  transition: opacity 0.1s ease;
  opacity: 1;
}

.btns-hover {
  opacity: 0.5;
}

.open-btn {
  background-color: #c0f3e3;
}

.stop-btn {
  background-color: #e5ada3;
}

.close-btn {
  background-color: #f8cb88;
}

.btn-ch {
  color: black;
  font-size: 37rpx;
  font-weight: 700;
  margin-top: 97rpx;
  margin-bottom: -40rpx;
}

.btn-en {
  color: rgba(0, 0, 0, 0.486);
  font-size: 27rpx;
}

.btn-icon {
  position: relative;
  top: 43rpx;
}
</style>
