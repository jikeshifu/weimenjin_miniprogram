<template>
	<view class="big-box" style="padding-bottom: 40upx;">
		<view class="background"></view>
		<view class="info-box">
			<view class="top-text">设备二维码，可打印张贴给用户使用</view>
			<view class="qrcode">
				<image :src="info.lock_qrcode">
				</image>
			</view>
			<view class="name">{{ info.lock_name }}</view>
			<view class="cell-box" @click="iccidInfo">
				<view class="cell-item">
					<view class="label">网络标识：</view>
					<view class="value" v-if="info.iccid">{{ info.iccid }} </view>
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
						<view class="value" style="color: #FF0000;" v-if="info.rssi">{{ info.rssi }}</view>
					</view>
				</view>
				<view class="cell-box">
					<view class="cell-item" v-if="info.batterypower">
						<view class="label">电池电量：</view>
						<view class="value" style="color: #21CF3E;" v-if="info.batterypower">{{ info.batterypower }}
						</view>
					</view>
					<view class="cell-item">
						<view class="label">固件版本：</view>
						<view class="value" v-if="info.version">{{ info.version }}</view>
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
	</view>
</template>

<script>
	import {
		equipmentInfo_api,
		SaveQr,
		DevAddCard
	} from '@/api/index.js'
	export default {
		data() {
			return {
				lockauth_id: '',
				info: {}
			}
		},
		onLoad(option) {
			this.lockauth_id = option.lockauth_id
			this.getInfo()
		},
		methods: {
			async getInfo() {
				let res = await equipmentInfo_api({
					lockauth_id: this.lockauth_id
				})
				if (res.code === 0) {
					this.info = res.data
				}
			},
			iccidInfo(){
				uni.navigateTo({
					url: '/pages/sim/sim?iccid='+this.info.iccid
				})
			},
			copySn(){
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

			}
		}
	}
</script>

<style scoped lang="scss">
	@import './equipment.scss';
</style>