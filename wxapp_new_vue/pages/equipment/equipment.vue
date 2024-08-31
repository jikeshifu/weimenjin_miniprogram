<template>
	<view class="big-box" style="padding-bottom: 40upx;">
		<view class="background"></view>
		<view class="info-box">
			<view class="top-text">设备二维码，可打印张贴给用户使用</view>
			<view class="qrcode">
				<image :src="info.lock_qrcode">
				</image>
			</view>
			<!-- <view class="name">{{ info.lock_name }}</view> -->
			<view class="cell-box">
				<view class="cell-item">
					<view class="label">网络标识：</view>
					<view class="value" v-if="info.iccid">{{ info.iccid }} </view>
					<view class="bottom-btn" v-if="info.iccid_status" @click="iccidInfo">查续</view>
				</view>
			</view>
			<view class="flex-box">
				<view class="cell-box">
					<view class="cell-item" @click="copySn">
						<view class="label">序列号：</view>
						<view class="value" style="color: #444444;" v-if="info.lock_sn">{{ info.lock_sn }}</view>
					</view>
					<view class="cell-item">
						<view class="label">信号强度：</view>
						<view class="value" :style="signalStyle">{{ signalDesc }} ({{ info.rssi }})</view>
					</view>
				</view>
				<view class="cell-box">
					<view class="cell-item" v-if="info.lock_sn && info.lock_sn.startsWith('W89') && info.batterypower">
					        <view class="label">电池电量：</view>
					        <view class="value" style="color: #21CF3E;" @click="powerInfo">
					            {{ info.batterypower }}
					        </view>
					</view>
					<view class="cell-item">
						<view class="label">固件版本：</view>
						<view class="value" v-if="info.version">{{ info.version }}</view>
					</view>
				</view>
			</view>
			<view class="cell-box">
				<view class="cell-item" v-if="info.on_line_time">
					<view class="label">上线时间：</view>
					<view class="value" style="color: #21CF3E;" v-if="info.on_line_time" @click="onofflineInfo">
						{{ formatDate(info.on_line_time) }} 详情
					</view>
				</view>
			</view>

		</view>
		<view class="save" @click="saveImg">保存二维码图片</view>
		<view class="save" v-if="info.qrServer_status" @click="saveQr">设置二维码到显示屏</view>
		<view class="save" v-if="info.addcardmode_status && info.addcardmode==2" @click="devAddCard(1,'进入中')">进入发卡模式
		</view>
		<view class="save" v-if="info.addcardmode_status && info.addcardmode!=2" @click="devAddCard(2,'退出中')">退出发卡模式
		</view>
		<view class="save" v-if="info.nonc_status && info.noncmode==1" @click="devNoNc(0,'进入中')">进入常开模式
		</view>
		<view class="save" v-if="info.nonc_status && info.noncmode!=1" @click="devNoNc(1,'退出中')">退出常开模式
		</view>
		<view class="save" @click="restartDevice">重启设备</view>
	</view>
</template>

<script>
	import {
		equipmentInfo_api,
		restartDevice_api,
		SaveQr,
		DevAddCard,
		DevNoNc
	} from '@/api/index.js'
	export default {
		data() {
			return {
				lockauth_id: '',
				info: {
					rssi: 0
				},
				signalDesc: '', // 信号描述
				signalStyle: '' // 信号颜色样式
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.lockauth_id = option.lockauth_id
			this.getInfo()
		},
		methods: {
			iccidInfo() {
				uni.navigateTo({
					url: '/pages/sim/sim?iccid=' + this.info.iccid
				})
			},
			powerInfo() {
				uni.navigateTo({
					url: '/pages/power/power?lock_sn=' + this.info.lock_sn
				})
			},
			onofflineInfo() {
				uni.navigateTo({
					url: '/pages/onoffline/onoffline?lock_sn=' + this.info.lock_sn
				})
			},
			async getInfo() {
				let res = await equipmentInfo_api({
					lockauth_id: this.lockauth_id
				});
				if (res.code === 0) {
					this.info = res.data;
					this.updateSignalStrength(this.info.rssi); // 更新信号强度描述和样式
					this.info.batterypower = this.convertVoltageToPercentage(this.info.batterypower); // 更新电池电量显示值
				}
			},
			updateSignalStrength: function(rssi) {
				if (this.info.lock_sn.startsWith('W894')) {
					// 4G设备
					this.signalDesc = this.get4GSignalDescription(rssi);
					this.signalStyle = `color: ${this.get4GSignalStyle(rssi)}`;
				} else {
					// Wi-Fi设备
					this.signalDesc = this.getWifiSignalDescription(rssi);
					this.signalStyle = `color: ${this.getWifiSignalStyle(rssi)}`;
				}
			},
			// 将电池电压转换为百分比的函数
			convertVoltageToPercentage(voltage) {
				const minVoltage = 6400; // 电量用尽时的电压（6400毫伏）
				const maxVoltage = 8400; // 电池充满时的电压（8400毫伏）
				const batteryPercentage = ((voltage - minVoltage) / (maxVoltage - minVoltage)) * 100;
				// 使用 Math.min 和 Math.max 来确保百分比在 0 到 100 之间，并且将其转换为带一位小数的百分比字符串
				return `${parseFloat(Math.min(Math.max(batteryPercentage, 0), 100)).toFixed(0)}%`;
			},
			get4GSignalDescription: function(rssi) {
				if (rssi > 0) {
					if (rssi <= 9) return '非常差';
					if (rssi <= 15) return '差';
					if (rssi <= 21) return '一般';
					if (rssi <= 25) return '好';
					return '非常好';
				} else {
					if (rssi >= -50) return '非常好';
					if (rssi >= -70 && rssi < -50) return '好';
					if (rssi >= -90 && rssi < -70) return '一般';
					if (rssi >= -100 && rssi < -90) return '差';
					if (rssi >= -110 && rssi < -100) return '非常差';
					return '无信号';
				}
			},
		
			getWifiSignalDescription: function(rssi) {
				if (rssi > 0) {
					if (rssi <= 9) return '非常差';
					if (rssi <= 15) return '差';
					if (rssi <= 21) return '一般';
					if (rssi <= 25) return '好';
					return '非常好';
				} else {
					if (rssi >= -50) return '非常好';
					if (rssi >= -60) return '好';
					if (rssi >= -70) return '一般';
					if (rssi >= -80) return '差';
					if (rssi >= -90) return '非常差';
					return '无信号';
				}
			},
		
			get4GSignalStyle: function(rssi) {
				if (rssi > 0) {
					if (rssi <= 9) return '#FF0000'; // 红色
					if (rssi <= 15) return '#FF6700'; // 深黄色
					if (rssi <= 21) return '#FF8F00'; // 黄色
					if (rssi <= 25) return '#008000'; // 绿色
					return '#006400'; // 深绿色
				} else {
					if (rssi >= -50) return '#006400';
					if (rssi >= -70 && rssi < -50) return '#008000';
					if (rssi >= -90 && rssi < -70) return '#FF8F00';
					if (rssi >= -100 && rssi < -90) return '#FF6700';
					if (rssi >= -110 && rssi < -100) return '#FF0000';
					return '#FF0000'; // 无信号时默认为红色
				}
			},
			getWifiSignalStyle: function(rssi) {
				if (rssi > 0) {
					if (rssi <= 9) return '#FF0000'; // 红色
					if (rssi <= 15) return '#FF6700'; // 深黄色
					if (rssi <= 21) return '#FF8F00'; // 黄色
					if (rssi <= 25) return '#008000'; // 绿色
					return '#006400'; // 深绿色
				} else {
					if (rssi >= -50) return '#006400';
					if (rssi >= -60) return '#008000';
					if (rssi >= -70) return '#FF8F00';
					if (rssi >= -80) return '#FF6700';
					if (rssi >= -90) return '#FF0000';
					return '#FF0000'; // 无信号时默认为红色
				}
			},
			formatDate(date, fmt = 'yyyy-MM-dd hh:mm:ss') {
				var crtTime;
				if (typeof date === 'number') {
					if ((date + '').length !== 13) {
						crtTime = new Date(date * 1000);
					} else {
						crtTime = new Date(date);
					}
				} else {
					crtTime = new Date(date);
				}
				var o = {
					'M+': crtTime.getMonth() + 1,
					'd+': crtTime.getDate(),
					'h+': crtTime.getHours(),
					'm+': crtTime.getMinutes(),
					's+': crtTime.getSeconds(),
					'q+': Math.floor((crtTime.getMonth() + 3) / 3),
					S: crtTime.getMilliseconds(),
				};
				if (/(y+)/.test(fmt)) {
					fmt = fmt.replace(
						RegExp.$1,
						(crtTime.getFullYear() + '').substr(4 - RegExp.$1.length),
					);
				}
				for (var k in o) {
					if (new RegExp('(' + k + ')').test(fmt)) {
						fmt = fmt.replace(
							RegExp.$1,
							RegExp.$1.length === 1 ?
							o[k] :
							('00' + o[k]).substr(('' + o[k]).length),
						);
					}
				}
				return fmt;
			},
			copySn() {
				uni.setClipboardData({
					data: this.info.lock_sn,
					success(res) {
						console.log('success', res);
						uni.showToast({
							title: "复制序列号成功",

						});
					}
				})
			},
			saveImg() {
				uni.showLoading({
					title: '保存中...'
				})
				uni.downloadFile({
					url: this.info.lock_qrcode, //仅为示例，并非真实的资源
					success: (res) => {
						if (res.statusCode === 200) {
							uni.saveImageToPhotosAlbum({
								filePath: res.tempFilePath,
								success: function() {
									uni.showToast({
										title: '保存成功！',
										icon: 'none'
									})
								},
								fail: res => {
									uni.showToast({
										title: '保存失败！',
										icon: 'none'
									})
								}
							});
						}
					}
				});

			},


			qrActionSheet() {
				return new Promise((resolve, reject) => {
					let Res = {
						err: null
					}
					uni.showActionSheet({
						itemList: ['主动扫描', '反扫码', '兼容模式'],
						success: function(res) {
							console.log('选中了第' + (res.tapIndex + 1) + '个按钮');
							Res.data = res.tapIndex + 1
							resolve(Res)
						},
						fail: function(res) {
							console.log(res.errMsg);
							Res.err = res.errMsg
							resolve(Res)

						}
					});
				})
			},
			async saveQr() {
				uni.showLoading({
					mask: true,
					title: '设置中...'
				})
				console.log("this", this.info)

				let type = 0
				if (this.info.qrServer_type == 1) {
					console.log("this", this.info)
					let Res = await this.qrActionSheet()
					if (Res.err != null) {
						uni.hideLoading()
						return
					}
					type = Res.data

				}
				let res = await SaveQr({
					lockauth_id: this.lockauth_id,
					type: type,

				})
				console.log("this", res)
				uni.hideLoading()
				uni.showToast({
					title: res.msg,
					icon: 'none'
				})

			},
			async devAddCard(addCardmode, addCardmodeMsg) {
				uni.showLoading({
					mask: true,
					title: addCardmodeMsg
				})
				console.log("this", this.info)
				let res = await DevAddCard({
					lockauth_id: this.lockauth_id,
					addcardmode: addCardmode
				})

				if (res.code === 0) {
					this.info.addcardmode = addCardmode
				}
				console.log("this", res)
				uni.hideLoading()
				uni.showToast({
					title: res.msg,
					icon: 'none'
				})

			},
			async devNoNc(NoNcmode,NoNcmodeMsg){
				uni.showLoading({
					mask: true,
					title: NoNcmodeMsg
				})
				console.log("this", this.info)
				let res = await DevNoNc({
					lockauth_id: this.lockauth_id,
					noncmode: NoNcmode
				})

				if (res.code === 0) {
					this.info.noncmode = NoNcmode
				}
				console.log("this", res)
				uni.hideLoading()
				uni.showToast({
					title: res.msg,
					icon: 'none'
				})

			},
			async restartDevice() {
				if (!this.lockauth_id) {
					uni.showToast({
						title: '设备ID缺失，无法重启',
						icon: 'none'
					});
					return;
				}

				uni.showModal({
					title: '提示',
					content: '确定要重启设备吗？',
					success: async (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: '正在重启...'
							});
							try {
								const res = await restartDevice_api({
									lock_sn: this.info.lock_sn
								});
								// 根据实际API响应结构进行调整
								if (res.code === 0) {
									uni.showToast({
										title: '设备重启成功',
										icon: 'success'
									});
								} else {
									uni.showToast({
										title: `重启失败: ${res.msg}`,
										icon: 'none'
									});
								}
							} catch (error) {
								uni.showToast({
									title: '重启请求失败',
									icon: 'none'
								});
							} finally {
								uni.hideLoading();
							}
						}
					}
				});
			},
		}
	}
</script>

<style scoped lang="scss">
	@import './equipment.scss';
</style>