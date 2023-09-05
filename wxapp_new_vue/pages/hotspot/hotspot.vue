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
			<view class="bottom-box">
				<view class="bottom-btn" @click="hotspotSet()">生成热点名称</view>
			</view>

			<view class="explain">
				<view class="text">热点名称:{{hotspot}}</view>
				<view class="text">1.填入路由器的信号名称和密码</view>
				<view class="text">2.请将生成的内容设置为热点名称并开启热点</view>
				<view class="text">3.设备进入配网模式</view>
				<view class="text">4.重启设备即可配置成功</view>
				<view class="text">注：iPhone的热点名称在设置-通用-关于本机-名称</view>
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

		}
	}
</script>

<style scoped lang="scss">
	@import './hotspot.scss';
</style>