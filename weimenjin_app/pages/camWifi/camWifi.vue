<template>
	<view style="padding-top: 30rpx;font-size: 30rpx;">
		<uni-steps style="width: 80%;" active-color="#ff6f52" :options="stepsTitle" :active="stepsActive"></uni-steps>

		<view v-if="stepsActive === 0">
		    <view style="margin-top: 77rpx;margin-left: 27rpx; color: rgb(97, 97, 97);">1. 请将摄像机连接上电源，观察设备灯/网线灯是否亮起。</view>
		    <view style="display: flex; justify-content: center;margin-top: 77rpx;margin-left: 38rpx;">
		        <image :src="powerOnImg" alt="图标" mode="widthFix" />
		        <!-- <image alt="图标" style="width: 100%" mode="widthFix" /> -->
		    </view>
		    <view style="margin-top: 77rpx;margin-left: 27rpx;color: rgb(97, 97, 97);">2. 等待设备初始化，并语音提示："欢迎使用"。</view>
		    <!-- <view style="margin-top: 77rpx;margin-left: 27rpx;color: rgb(97, 97, 97);">3. 若设备未被激活</view> -->

		    <view class="confirm-btn" style="margin-top: 30rpx;">
				<view class="bottom-btn" @click="onStep1">我已听见语音播报</view>
		    </view>
		</view>


		<view v-if="stepsActive === 1">
		    <view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">设备序列号:</view>
						<text style="margin-left: 50rpx;color:#868686;">{{deviceSn}}</text>
					</view>
				</view>

					<view class="network-type">
						<radio-group @change="networkTypeChange">
							<label class="radio"><radio value="0" />网线</label>
							<label class="radio"><radio value="1" :checked="true"  />Wi-Fi</label>
						</radio-group>
					</view>

			</view>

				<view class="top-box" v-if="netType == 1">
					<view class="cell-item">
						<view class="label">Wi-Fi名称</view>
						<input placeholder="请输入Wi-Fi名称" placeholder-class="placeholder" v-model="wifiName"  />
					</view>
					<view class="cell-item">
						<view class="label">Wi-Fi密码</view>
						<input placeholder="请输入Wi-Fi密码" placeholder-class="placeholder" v-model="wifiPwd" />
					</view>
				</view>



			<view class="bottom-box">
				<view class="bottom-btn" @click="onStep2">确认</view>
			</view>
		    </view>
		</view>


		<view v-if="stepsActive == 2">
		    <view style="display: flex; justify-content: center;margin-top: 200rpx;">
		        <canvas canvas-id="qrcode" :style="{width: `${qrcodeSize}px`, height: `${qrcodeSize}px`}" />
		    </view>
		    <view style="margin-top: 200rpx;">
				<view class="bottom-btn" @click="onStep3" >我已听见扫描二维码成功</view>
				<view class="bottom-btn"  @click="onStep1" >无法进行扫描二维码配网</view>
		    </view>
		</view>


		<view v-if="stepsActive == 3">
		    <view class="loading-container-flex" style="height: 100vh;">
		        <view class="item" v-if="isDevOnline">
		            <t-icon name="check-circle" size="77rpx" color="green" />
		            <view style="margin-top: 47rpx;">服务器已连接</view>
		        </view>
		        <view class="item" v-if="!isDevOnline && !isCheckOnlineTimeout">
		            <text>检查设备中...{{checkCount}}/10</text>
		        </view>
		        <view class="item" v-if="isCheckOnlineTimeout">
		            <view style="margin-bottom: 200rpx;">未检测到设备上线，请检查设备网络连接情况</view>
					<view class="bottom-btn" @click="onStep1">返回</view>
		        </view>
		    </view>
		</view>

	</view>
</template>

<script>
import uQRCode from '../../libs/uqrcode.js';
import { getDeviceCfg_api } from '../../api/index.js'
import { assetUrl } from '@/config/domain.js';
export default {
	data() {
		return {
			powerOnImg: assetUrl('/uploads/img/poweron.png'),
			stepsActive:0,
			stepsTitle: [
				{time:"设备上电"},
				{time:"配置网络"},
				{time:"扫描二维码"},
				{time:"等待上线"},
			],
			deviceSn:"",
			netType:1,
			wifiName: "",
			wifiPwd: "",
			userInfo:{},
			oldBrightness:0,
			qrText:"",
			qrcodeSize:260,
			isCheckOnlineTimeout:false,
			isDevOnline: false,
			checkCount: 0,
			onlineCheckInterval:null,
		}
	},

	onLoad(option) {
		this.deviceSn = option.device_sn
		this.userInfo = uni.getStorageSync("USERINFO");
		wx.getScreenBrightness({
			success: (res) => {
				this.oldBrightness = res.value
			}
		})
	},
	methods: {
		onStep0() {
			this.stepsActive = 0
		},
		onStep1() {
			this.netType = 1
			if(this.checkString34(this.deviceSn)){
				this.onStep3()
			}else{
				this.stepsActive = 1
			}
		},
		onStep2() {
			if (this.netType == 0) {
			    this.onStep3()
			}else{

				if (this.wifiName == "" || this.wifiPwd == "") {
					uni.showToast({
						title: "用户名和密码不能为空",
						icon: 'none',
					});
					return;
				}

				if (this.wifiPwd.length < 8) {
					uni.showToast({
						title: '密码必须大于8位',
						icon: 'none'
					});
					return;
				}

				// 拼接 Wi-Fi 名称和密码，格式为 $$密码@名称$$^mb/4^
				const qrText = `$$${this.wifiPwd}@${this.wifiName}$$^mb/${this.userInfo.member_id}^`;
				this.qrText = qrText

				wx.setScreenBrightness({
					value: 1,
				})

				uQRCode.make({
					canvasId: 'qrcode',
					text: this.qrText,
				size: this.qrcodeSize,
				margin: 10,
				success: (res) => {
					this.qrcodeSrc = res.tempFilePath;
				},
				complete: () => {
					uni.hideLoading();
				}
			});				this.stepsActive = 2

			}
		},
		onStep3(){
			this.stepsActive = 3
			this.isCheckOnlineTimeout = false
			wx.setScreenBrightness({
				value: this.oldBrightness,
			})

			let checkCount = 0; // 计数器

			this.checkCount = checkCount
			this.deviceOnlineCheck();
			// 每 7 秒执行一次检查
			this.onlineCheckInterval = setInterval(() => {
				if (this.isDevOnline) {
					clearInterval(this.onlineCheckInterval);
					this.onlineCheckInterval = null;
					return;
				}
				checkCount++;
				this.deviceOnlineCheck();
				this.checkCount = checkCount

				// 如果达到 10 次还未成功，停止检查
				if (checkCount >= 10) {
					clearInterval(this.onlineCheckInterval);
					this.onlineCheckInterval = null;

					this.isCheckOnlineTimeout = true

					console.error('设备上线检查超时');
				}
			}, 7000);

		},
		async deviceOnlineCheck(){
			if (this.isDevOnline) {
				return;
			}

			let res = await getDeviceCfg_api({device_sn: this.deviceSn,cfg: "blc_setting"})

			if (res.code === 0) {
				this.isDevOnline = true
				uni.showToast({
					title: "设备上线成功",
					icon:'none',
					mask: true
				})
				if (this.onlineCheckInterval) {
					clearInterval(this.onlineCheckInterval);
					this.onlineCheckInterval = null;
				}
				let timer = setTimeout(() => {
					uni.reLaunch({
						url: '/pages/index/index'
					});
					clearTimeout(timer)
				}, 1000)
			}else{
				this.isDevOnline = false
			}
		},

		checkString34(str) {
		  const target = str.slice(-10, -8);
		  return target === '34';
		},

		networkTypeChange: function(evt) {
			this.netType = evt.detail.value
		}
	}
}
</script>

<style scoped lang="scss">
	@import './camWifi.css';
</style>
