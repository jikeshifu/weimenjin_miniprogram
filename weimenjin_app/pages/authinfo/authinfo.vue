<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<!-- 置顶说明卡片 -->
			<view class="info-card">
				<view class="info-header">
					<i class="iconfont icon-a-zhuanyi4" style="color: #21CF3E; font-size: 28rpx;"></i>
					<view class="info-title">置顶功能</view>
				</view>
				<view class="info-desc">
					<view class="desc-text">点击"确认置顶"后，此钥匙将自动移至列表最顶部。</view>
					<view class="desc-text">系统会自动计算排序值，无需手动输入。</view>
				</view>
			</view>

			<!-- 当前排序信息 -->
			<view class="current-sort-card">
				<view class="sort-info-item">
					<view class="sort-label">当前排序值:</view>
					<view class="sort-value">{{ currentSort }}</view>
				</view>
				<view class="sort-info-item">
					<view class="sort-label">置顶后排序值:</view>
					<view class="sort-value" style="color: #21CF3E;">{{ newSort }}</view>
				</view>
			</view>

			<!-- 确认置顶按钮 -->
			<view class="button-area">
				<view class="bottom" @click="onsubmit">
					<view class="btn">{{ isSubmitting ? '置顶中...' : '确认置顶' }}</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { authconfigSet_api, authconfig_api, deviceList_api } from '@/api/index.js'
	export default {
		data() {
			return {
				lockauth_id: '',
				formData: {},
				currentSort: 0,
				newSort: 0,
				maxSort: 0,
				isSubmitting: false
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
			async getInfo() {
				try {
					// 获取当前钥匙的排序值
					let res = await authconfig_api({ lockauth_id: this.lockauth_id })
					if (res.code === 0) {
						let item = res.data
						this.currentSort = item.auth_sort || 0
						this.formData = {
							lockauth_id: this.lockauth_id,
							auth_sort: item.auth_sort,
						}
					} else {
						this.showToast(res.msg)
					}

					// 加载所有设备列表，计算最大排序值
					let deviceRes = await deviceList_api({ page: 1, limit: 1000 })
					if (deviceRes.code === 0 && deviceRes.data && deviceRes.data.list) {
						let maxSort = 0
						for (let device of deviceRes.data.list) {
							let sort = parseInt(device.auth_sort) || 0
							if (sort > maxSort) {
								maxSort = sort
							}
						}
						this.maxSort = maxSort
						this.newSort = maxSort + 1
					}
				} catch (e) {
					console.error('加载数据失败:', e)
					this.showToast('加载数据失败')
				}
			},
			async onsubmit() {
				if (this.isSubmitting) return

				this.isSubmitting = true
				uni.showLoading({
					title: '置顶中...',
					mask: true
				})

				try {
					let res = await authconfigSet_api({
						lockauth_id: this.lockauth_id,
						auth_sort: this.newSort
					})
					uni.hideLoading()
					if (res.code === 0) {
						this.showToast('置顶成功')
						setTimeout(() => {
							uni.reLaunch({
								url: '/pages/index/index'
							})
						}, 800)
					} else {
						this.showToast(res.msg)
						this.isSubmitting = false
					}
				} catch (e) {
					console.error('置顶失败:', e)
					uni.hideLoading()
					this.showToast('置顶失败')
					this.isSubmitting = false
				}
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
