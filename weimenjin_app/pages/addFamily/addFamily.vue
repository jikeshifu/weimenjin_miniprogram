<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<input placeholder="请输入分组名称" placeholder-class="placeholder" v-model="device_group_name"/>
				</view>				
			</view>
			<view class="bottom-btn" @click="submit" v-if="!device_group_id">保存</view>
			<view class="bottom-btn" @click="change" v-else>修改</view>
		</view>
		
	</view>
</template>

<script>
	import { addDeviceGroup_api, editDeviceGroup_api } from "../../api/index.js";
	export default {
		data() {
			return {
				device_group_name: '',
				device_group_id: ''
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.device_group_id = option.device_group_id ? option.device_group_id : ''
			this.device_group_name = option.device_group_name ? option.device_group_name : ''
		},
		methods: {
			async submit() {
				if (!this.device_group_name) {
					this.showToast('请输入分组名称')
					return
				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await addDeviceGroup_api({ device_group_name: this.device_group_name })
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('添加成功');
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta: 1
						})
						clearTimeout(timer)
					}, 1000)
				} else {
					uni.hideLoading()
					this.showToast(res.msg);
				}
			},
			async change() {
				if (!this.device_group_name) {
					this.showToast('请输入分组名称')
					return
				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await editDeviceGroup_api({ device_group_name: this.device_group_name, device_group_id: this.device_group_id })
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('修改成功');
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta: 1
						})
						clearTimeout(timer)
					}, 1000)
				} else {
					uni.hideLoading()
					this.showToast(res.msg);
				}
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					mask: true,
					icon: 'none'
				})
			}
		}
	}
</script>

<style scoped lang="scss">
@import './addFamily.scss';	
</style>