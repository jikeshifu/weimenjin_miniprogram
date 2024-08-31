<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">排序(越大越靠前):</view>
					<input placeholder="请输入序号" type="number" @input="validateNumber" placeholder-class="placeholder" v-model="formData.auth_sort" />
				</view>
			</view>
			<view class="bottom" @click="onsubmit">
				<view class="btn">提交</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { authconfigSet_api, authconfig_api } from '@/api/index.js'
	export default {
		data() {
			return {
				lockauth_id: '',
				formData: {}
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
			async onsubmit() {
				uni.showLoading({
					title: '修改中...',
					mask: true
				})
				let res = await authconfigSet_api(this.formData)
				if (res.code === 0) {
					this.showToast('修改成功')
					uni.reLaunch({
						url: '/pages/index/index'
					});
				} else {
					this.showToast(res.msg)
				}
			},
			async getInfo() {
				let res = await authconfig_api({ lockauth_id: this.lockauth_id })
				if (res.code === 0) {
					let item = res.data
					this.formData = {
						lockauth_id: this.lockauth_id,
						auth_sort: item.auth_sort,
					}
				} else {
					this.showToast(res.msg)
				}
			},
			validateNumber(event) {
							let value = event.target.value
							// 使用正则表达式移除非数字字符
							value = value.replace(/[^\d]/g, '')
							// 更新到formData中
							this.formData.auth_sort = value
						},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './authinfo.scss';
</style>
