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
					<view class="label">采集手机号:</view>
					<switch color="#21CF3E" :checked="formData.mobile_check ? true : false" style="transform:scale(0.7)" @change="changePhone" />
				</view>
				<view class="cell-item">
					<view class="label">扫码先登记:</view>
					<switch color="#21CF3E" :checked="formData.applyauth ? true : false" style="transform:scale(0.7)" @change="changeApply" />
				</view>
				<view class="cell-item">
					<view class="label">审核登记:</view>
					<switch checked color="#21CF3E" :checked="formData.applyauth_check ? true : false" style="transform:scale(0.7)" @change="changeCheck" />
				</view>
				<view class="cell-item">
					<view class="label">小程序声音:</view>
					<switch checked color="#21CF3E" :checked="formData.xcx_sound ? true : false" style="transform:scale(0.7)" @change="changeXcxSound" />
				</view>
				<view class="cell-item">
					<view class="label">限距(米):</view>
					<input placeholder="请输入开门距离" type="number" placeholder-class="placeholder" v-model="formData.location_check" />
				</view>



			</view>
			<view class="bottom" @click="onsubmit">
				<view class="btn" >提交</view>
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
						xcx_sound:item.xcx_sound,
						applyauth_check: item.applyauth_check,
						location_check: item.location_check ? item.location_check : 0,
						status: item.status
					}
				} else {
					this.showToast(res.msg)
				}
			},
			changePhone(e) {
				if(e.detail.value) {
					this.formData.mobile_check = 1
				} else {
					this.formData.mobile_check = 0
				}
			},
			changeApply(e) {
				if(e.detail.value) {
					this.formData.applyauth = 1
				} else {
					this.formData.applyauth = 0
				}
			},
			changeCheck(e) {
				if(e.detail.value) {
					this.formData.applyauth_check = 1
				} else {
					this.formData.applyauth_check = 0
				}
			},
			
			
			
			changeXcxSound(e){
				if(e.detail.value) {
					this.formData.xcx_sound = 1
				} else {
					this.formData.xcx_sound = 0
				}
			},
			changeUse(e) {
				if(e.detail.value) {
					this.formData.status = 1
				} else {
					this.formData.status = 0
				}
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask:true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './arguments.scss';
</style>