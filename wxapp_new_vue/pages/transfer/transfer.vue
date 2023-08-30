<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="flex-box">
				<view class="label">手机号</view>
				<input placeholder="请输入对方手机号" placeholder-class="placeholder" type="number" v-model="mobile" />
			</view>
			<view class="inquire" @click="inquire">查询用户</view>
			<!-- 查询有用户后展示 -->
			<view class="cell-box" v-if="userInfo.member_id">
				<image :src="userInfo.headimgurl | imgPath" class="user-img"></image>
				<view class="user-name">{{ userInfo.nickname }}</view>
				<view class="phone">{{ userInfo.mobile }}</view>
				<view class="btn" @click="onsubmit">转移给对方</view>
			</view>
		</view>
	</view>
</template>

<script>
	import {
		transfer_api,
		memberInfo_api
	} from '@/api/index.js';
	import {
		imgPath
	} from '@/libs/filters.js'
	export default {
		data() {
			return {
				userInfo: {},
				mobile: '',
				lockauth_id: ''
			}
		},
		filters: {
			imgPath
		},
		onLoad(option) {
			this.lockauth_id = option.lockauth_id
		},
		methods: {
			async inquire() {
				if (!this.mobile) {
					this.showToast('请输入对方手机号！')
					return false
				}
				uni.showLoading({
					title: '查询中...',
					mask: true
				})
				let res = await memberInfo_api({
					mobile: this.mobile
				})
				if (res.code === 0) {
					uni.hideLoading()
					this.userInfo = res.data
				} else {
					this.userInfo = {}
					this.showToast(res.msg)
				}
			},
			onsubmit() {
				uni.showModal({
					title: '提示',
					content: '确定要转移权限给' + this.userInfo.nickname + '吗？',
					success: async (msg) => {
						if (msg.confirm) {
							uni.showLoading({
								title: '转移中...',
								mask:true
							})
							let res = await transfer_api({ lockauth_id: this.lockauth_id, member_id: this.userInfo.member_id })
							if (res.code === 0) {
								this.showToast('权限转移成功!')
								let timer = setTimeout(() => {
									uni.navigateBack({
										delta:1
									})
								}, 1000)
							} else {
								this.showToast(res.msg)
							}
						}
					}
				})
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
	@import './transfer.scss';
</style>