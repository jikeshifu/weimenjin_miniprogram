<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">账号</view>
					<input placeholder="账号" v-model="formData.user" placeholder-class="placeholder" />
				</view>

				<view class="cell-item">
					<view class="label">密码</view>
					<input placeholder="修改密码时输入" v-model="formData.pwd" placeholder-class="placeholder" />
				</view>

			</view>
			<view class="bottom-box">
				<view class="bottom-btn" @click="hotspotSet()">更改密码</view>
			</view>

			<view class="explain">
				<view class="text"></view>

			</view>
		</view>

	</view>
</template>

<script>
	import { myRequest } from '../../api/request.js';
	export default {
		data() {
			return {
				formData: {
					user: "",
					pwd: "",
				},

			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {},
		async onShow() {
			let accountRes = await myRequest('/member.Member/account', {}, 'POST');
				this.formData.user =accountRes.data.user
		},
		methods: {
			async hotspotSet() {

				if(this.formData.pwd.length<6){
					wx.showToast({
						title:"密码不能小于6位",
						icon: "none",
						mask: true, // 是否显示透明蒙层，防止触摸穿透
						duration: 2000
					});
					return
				}

					let accountRes = await myRequest('/member.Member/accountSet', this.formData, 'POST');
					if(accountRes.code!=0){
						wx.showToast({
							title:accountRes.msg,
							icon: "none",
							mask: true, // 是否显示透明蒙层，防止触摸穿透
							duration: 2000
						});
						return
					}
					wx.showToast({
						title:"修改成功",

						mask: true, // 是否显示透明蒙层，防止触摸穿透
						duration: 2000
					});



			},

		}
	}
</script>

<style scoped lang="scss">
	@import './hotspot.scss';
</style>
