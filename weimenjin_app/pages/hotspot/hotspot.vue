<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">WiFi名称</view>
					<input placeholder="请输入WiFi名称" v-model="formData.wifiName" placeholder-class="placeholder" />
				</view>

				<view class="cell-item">
					<view class="label">WiFi密码</view>
					<input placeholder="请输入WiFi密码" v-model="formData.wifiPwd" placeholder-class="placeholder" />
				</view>

			</view>
			<view class="explain">
				<view class="text">热点名称:{{hotspot}}</view>
			</view>
			<view class="bottom-box">
				<view class="bottom-btn" @click="hotspotSet()">生成热点名称</view>
				<view class="bottom-btn" v-if="hotspot" @click="copyHotspot()">复制热点名称</view>
			</view>
			<view class="explain">
				<view class="text">1.复制生成的热点名称设置为手机热点并开启</view>
				<view class="text">2.重启设备即可配置成功</view>
				<view class="text">注：iPhone的热点名称在设置-通用-关于本机-名称,</view>
				<view class="text">W89型号的WiFi锁需进入配网模式。</view>
			</view>
		</view>

	</view>
</template>

<script>
	export default {
		data() {
			return {
				formData: {
					wifiName: "",
					wifiPwd: "",
				},
				hotspot: ""
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {},
		onShow() {
			let hotspotData = uni.getStorageSync("hotspotData")
			if (hotspotData) {
				this.formData = hotspotData
			}

		},
		methods: {
			hotspotSet() {
				uni.setStorageSync("hotspotData", this.formData)
				if (!this.formData.wifiName || this.formData.wifiName.length < 1) {
					uni.showToast({
						title: "请输入wifi名称",
						icon: 'none',
						mask: true, // 防止触摸穿透
						duration: 2000
					});
					return
				}
				//^wmj^0KGIoT*^_^*9638527410
				let rd = "^wmj^0" + this.formData.wifiName + "*^_^*" + this.formData.wifiPwd
				console.log('rd.lenght：', rd.length)
				if (rd.length > 63) {
					uni.showToast({
						title: "wifi名称密码过长",
						icon: 'none',
						mask: true, // 防止触摸穿透
						duration: 2000
					});
					return
				}
				console.log('this.data.wifi_pwd', rd)
				this.hotspot = rd

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
			// 新增复制热点名称到剪贴板的方法
			copyHotspot() {
				if (this.hotspot) {
					wx.setClipboardData({
						data: this.hotspot,
						success(res) {
							wx.showToast({
								title: "复制成功",
								icon: 'none',
								mask: true, // 防止触摸穿透
								duration: 2000
							});
						},
						fail() {
							wx.showToast({
								title: "复制失败",
								icon: 'none',
								mask: true,
								duration: 2000
							});
						}
					});
				}
			},
		}
	}
</script>

<style scoped lang="scss">
	@import './hotspot.scss';
</style>