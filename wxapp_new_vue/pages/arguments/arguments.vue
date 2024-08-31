<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">名称:</view>
					<input placeholder="请输入锁名称" placeholder-class="placeholder" style="color: #21CF3E;" v-model="formData.lock_name" />
				</view>
				<view class="cell-item">
					<view class="label">是否启用：</view>
					<switch checked color="#21CF3E" :checked="formData.status ? true : false" style="transform:scale(0.7)" @change="changeUse" />
				</view>
				<view class="cell-item">
					<view class="label">登记手机号:</view>
					<switch color="#21CF3E" :checked="formData.mobile_check ? true : false" style="transform:scale(0.7)" @change="changePhone" />
				</view>
				<view class="cell-item">
					<view class="label">扫码先登记:</view>
					<switch color="#21CF3E" :checked="formData.applyauth ? true : false" style="transform:scale(0.7)" @change="changeApply" />
				</view>
				<view class="cell-item">
					<view class="label">登记需要审核:</view>
					<switch checked color="#21CF3E" :checked="formData.applyauth_check ? true : false" style="transform:scale(0.7)" @change="changeCheck" />
				</view>
				<view class="cell-item">
					<view class="label">小程序开门成功语音:</view>
					<switch checked color="#21CF3E" :checked="formData.xcx_sound ? true : false" style="transform:scale(0.7)" @change="changeXcxSound" />
				</view>
				<view class="cell-item">
					<view class="label">开门通知管理员(公众号模板消息):</view>
					<switch checked color="#21CF3E" :checked="formData.opsucnt ? true : false" style="transform:scale(0.7)" @change="changeopsucnt" />
				</view>
				<view class="cell-item">
					<view class="label">限距(米):</view>
					<input placeholder="请输入开门距离" type="number" placeholder-class="placeholder" v-model="formData.location_check" />
				</view>
				<view class="cell-item">
					<view class="label">激励广告开关:</view>
					<switch color="#21CF3E" :checked="formData.advertising_enabled ? true : false" style="transform:scale(0.7)" @change="changeAd" />
				</view>
			</view>
			<view class="bottom" @click="onsubmit">
				<view class="btn">提交</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { configSet_api, config_api } from '@/api/index.js'
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
				if (!this.formData.lock_name) {
					this.showToast('请输入锁名称!')
					return
				}
				uni.showLoading({
					title: '修改中...',
					mask: true
				})
				let res = await configSet_api(this.formData)
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
				let res = await config_api({ lockauth_id: this.lockauth_id })
				if (res.code === 0) {
					let item = res.data
					this.formData = {
						lockauth_id: this.lockauth_id,
						lock_name: item.lock_name,
						mobile_check: item.mobile_check,
						applyauth: item.applyauth,
						xcx_sound: item.xcx_sound,
						opsucnt: item.opsucnt,
						applyauth_check: item.applyauth_check,
						location_check: item.location_check ? item.location_check : 0,
						status: item.status,
						advertising_enabled: item.qrshowminiad // 新增字段
					}
				} else {
					this.showToast(res.msg)
				}
			},
			changePhone(e) {
				this.formData.mobile_check = e.detail.value ? 1 : 0;
			},
			changeApply(e) {
				this.formData.applyauth = e.detail.value ? 1 : 0;
			},
			changeCheck(e) {
				this.formData.applyauth_check = e.detail.value ? 1 : 0;
			},
			changeXcxSound(e) {
				this.formData.xcx_sound = e.detail.value ? 1 : 0;
			},
			changeopsucnt(e) {
				this.formData.opsucnt = e.detail.value ? 1 : 0;
			},
			changeUse(e) {
				this.formData.status = e.detail.value ? 1 : 0;
			},
			changeAd(e) {
				this.formData.advertising_enabled = e.detail.value ? 1 : 0;
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
	@import './arguments.scss';
</style>
