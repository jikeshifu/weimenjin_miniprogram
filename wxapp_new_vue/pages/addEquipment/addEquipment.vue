<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">序列号：</view>
						<input placeholder="手动输入序列号" placeholder-class="placeholder" v-model="lock_sn" />
					</view>

					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>
				<view class="cell-item">
					<view class="label">设备名称：</view>
					<input placeholder="请输入设备名称" placeholder-class="placeholder" v-model="lock_name" />
				</view>


				<picker @change="bindPickerChange" :range="dataList" range-key="device_group_name" v-if="isShow">
					<view class="cell-item">
						<view class="label">选择分组：</view>
						<view class="right-box">
							<view class="text">{{ device_group_name }}</view>
							<image src="../../static/jiantouyou.png"></image>
						</view>
					</view>
				</picker>
				

			</view>
			<view class="bottom-btn" @click="onSubmit">立即提交</view>
		</view>

	</view>
</template>

<script>
	import { getDeviceGroup_api, addDevice_api } from '../../api/index.js'
	export default {
		data() {
			return {
				device_group_id: '',
				dataList: [],
				device_group_name: '',
				lock_sn: '',
				lock_name: '',
				isShow: false
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.device_group_id = option.device_group_id ? option.device_group_id : ''
			this.isShow = option.device_group_id ? false : true
			this.getList()
		},
		methods: {
			async getList() {
				let res = await getDeviceGroup_api()
				this.dataList = res.data
				if (!this.device_group_id) {
					this.device_group_name = this.dataList && this.dataList.length ? this.dataList[0].device_group_name : ''
					this.device_group_id = this.dataList && this.dataList.length ? this.dataList[0].device_group_id : ''
				}
			},
			scanCode() {
				uni.scanCode({
					success: (res) => {
						this.lock_sn = res.result
					}
				});
			},
			bindPickerChange(e) {
				this.device_group_name = this.dataList[e.detail.value].device_group_name
				this.device_group_id = this.dataList[e.detail.value].device_group_id
			},
			async onSubmit() {
				if (!this.lock_sn) {
					this.showToast('序列号不能是空！')
					return
				}
				if (!this.lock_name) {
					this.showToast('请输入设备名称！')
					return
				}
				if (!this.device_group_id) {
					this.showToast('请选择分组！')
					return
				}
				
				let data = {
					lock_sn: this.lock_sn,
					lock_name: this.lock_name,
					device_group_id: this.device_group_id
				}
				uni.showLoading({
					title: '加载中...',
					mask:true
				})
				let res = await addDevice_api(data)
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('添加成功')
					let timer = setTimeout(() => {
					uni.reLaunch({
						url: '/pages/index/index'
					});
						clearTimeout(timer)
					}, 1000)
					
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon:'none',
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addEquipment.scss';
</style>