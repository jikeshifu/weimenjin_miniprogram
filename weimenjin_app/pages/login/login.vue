<template>
  <view class="login-container">
    <view v-if="!isOnline" class="network-status">
      <text>网络不可用，请检查网络连接</text>
    </view>
    <view class="login-box" v-else>
      <!-- 手机号输入框和发送验证码按钮在同一行 -->
      <view class="input-row">
        <input
          class="phone-input"
          type="number"
          placeholder="请输入手机号码"
          v-model="phoneNumber"
        />
        <button class="send-code-btn" @click="sendSmsCode">
          {{ sendCodeText }}
        </button>
      </view>

      <!-- 验证码输入框稍短一些 -->
      <input
        class="code-input"
        type="number"
        placeholder="请输入验证码"
        v-model="smsCode"
      />

      <!-- 登录按钮 -->
      <button class="login-btn" @click="applogin">
        登录
      </button>
    </view>
  </view>
</template>

<script>
// 引入封装的接口
import { sendSms_api, smsLogin_api } from '../../api/user.js';

export default {
  data() {
    return {
      phoneNumber: '', // 用户输入的手机号
      smsCode: '', // 用户输入的验证码
      sendCodeText: '验证码',
      countdown: 60, // 倒计时
      isSendingCode: false, // 控制是否可以发送验证码
      isOnline: true, // 控制网络状态
    };
  },
  methods: {
    // 发送短信验证码
    async sendSmsCode() {
      if (!this.isSendingCode && this.phoneNumber) {
        if (!this.isOnline) {
          uni.showToast({ title: '网络不可用，请检查网络连接', icon: 'none' });
          return;
        }

        // 检查手机号是否格式正确（可选）
        const phoneRegex = /^1[3-9]\d{9}$/;
        if (!phoneRegex.test(this.phoneNumber)) {
          uni.showToast({ title: '请输入正确的手机号', icon: 'none' });
          return;
        }

        // 开始倒计时
        this.isSendingCode = true;
        this.sendCodeText = `${this.countdown}秒后重新获取`;
        let timer = setInterval(() => {
          this.countdown--;
          this.sendCodeText = `${this.countdown}秒后重新获取`;
          if (this.countdown === 0) {
            clearInterval(timer);
            this.sendCodeText = '发送验证码';
            this.isSendingCode = false;
            this.countdown = 60;
          }
        }, 1000);
        // 调用封装好的发送验证码接口
		//let res = await sendSms_api({ phoneNumber: this.phoneNumber });
		//console.log("res:",res)
        try {
          let res = await sendSms_api({ phoneNumber: this.phoneNumber });
          // 如果接口返回 code 为 0，则表示成功
          if (res.code === 0) {
            uni.showToast({ title: '验证码发送成功', icon: 'success' });
          } else {
            // 如果发送失败，提示用户
            uni.showToast({ title: res.msg || '发送失败', icon: 'error' });

            // 重置倒计时（允许用户重新获取验证码）
            clearInterval(timer);
            this.sendCodeText = '验证码';
            this.isSendingCode = false;
            this.countdown = 60;
          }
        } catch (error) {
          // 捕获错误并展示给用户
          uni.showToast({ title: `请求失败: ${JSON.stringify(error)}`, icon: 'none' });
          // 重置倒计时（允许用户重新获取验证码）
          clearInterval(timer);
          this.sendCodeText = '验证码';
          this.isSendingCode = false;
          this.countdown = 60;
        }
      } else {
        uni.showToast({ title: '请输入有效的手机号', icon: 'none' });
      }
    },

    // 登录
    async applogin() {
      if (!this.isOnline) {
        uni.showToast({ title: '网络不可用，请检查网络连接', icon: 'none' });
        return;
      }

      if (this.phoneNumber && this.smsCode) {
        // 调用封装好的验证码登录接口
        try {
          const res = await smsLogin_api({ phoneNumber: this.phoneNumber, code: this.smsCode });
          if (res.code === 0) {
            uni.setStorageSync('token', res.data.token); // 存储登录token
            uni.reLaunch({ url: '/pages/index/index' }); // 登录成功，跳转到首页
          } else {
            uni.showToast({ title: '登录失败', icon: 'error' });
          }
        } catch (error) {
          uni.showToast({ title: '登录失败', icon: 'error' });
        }
      } else {
        uni.showToast({ title: '请输入手机号和验证码', icon: 'none' });
      }
    },

    // 检查网络状态
    checkNetworkStatus() {
      // 获取当前网络状态
      uni.getNetworkType({
        success: (res) => {
          this.isOnline = res.networkType !== 'none'; // 如果网络类型为 'none'，表示没有网络
        },
        fail: () => {
          this.isOnline = false; // 失败时也认为没有网络
        }
      });

      // 监听网络状态变化
      uni.onNetworkStatusChange((res) => {
        this.isOnline = res.isConnected; // 实时更新网络连接状态
      });
    }
  },
  mounted() {
    this.checkNetworkStatus(); // 页面加载时检查网络状态
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f7f7f7;
}

.network-status {
  padding: 20px;
  background-color: #ffdddd;
  color: #ff0000;
  border: 1px solid #ff0000;
  border-radius: 5px;
}

.login-box {
  width: 80%;
  padding: 20px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* 手机号输入框和发送验证码按钮在同一行 */
.input-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

.phone-input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
}

.send-code-btn {
  margin-left: 10px;
  padding: 3px 10px 0px 10px;
  background-color: #4caf50;
  color: white;
  text-align: center;
  border-radius: 5px;
  font-size: 16px;
  white-space: nowrap;
}

/* 验证码输入框稍短一些 */
.code-input {
  width: 60%;
  padding: 8px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
}

.login-btn {
  width: 100%;
  /* padding: 10px; */
  background-color: #4caf50;
  color: white;
  text-align: center;
  border-radius: 5px;
  font-size: 18px;
}
</style>
