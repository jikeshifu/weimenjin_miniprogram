<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content" :style="{ position:  showAuthorizationModal ? 'fixed' : 'relative', top: showAuthorizationModal ? scrollTop : ''  }">
			<view class="user-box">
				<image :src="userInfo.headimgurl | imgPath" class="user-img"></image>
				<view class="user-name">{{ userInfo.nickname }}</view>
			</view>
			<view class="renew" @click="showAuthorizationModal = true">更新</view>
			<view class="cell-box" @click="goPage('/pages/operateList/operateList')">
				<view class="label">我的操作记录</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="goDetail('/pages/member/account')">
				<view class="label">账号管理</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="goPage('/pages/addEquipment/addEquipment')">
				<view class="label">添加设备</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="bindPhone">
				<view class="label">绑定手机号</view>
				<view class="flex-box">
					<view class="phone" v-if="userInfo.mobile">
						{{ userInfo.mobile.replace(/^(.{3})(?:\d+)(.{4})$/,"$1****$2") }}</view>
					<image src="../../static/jiantouyou.png"></image>
				</view>

			</view>
			<view class="cell-box" @click="goDetail('/pages/bluetooth/bluetooth')">
				<view class="label">蓝牙配网工具（ 适用W7X ）</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="goDetail('/pages/wifi/wifi')">
				<view class="label">WiFi配网工具（ 适用W8X ）</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="goDetail('/pages/hotspot/hotspot')">
				<view class="label">批量配网（ 热点配网 ）</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>

			<view class="cell-box" @click="goDetail('/pages/test/test')" v-if="userInfo.level">
				<view class="label">测试人员</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>


			<view class="cell-box" @click="goDetail('/pages/sim/sim')">
				<view class="label">sim卡查询</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
			<view class="cell-box" @click="goDetail('/pages/open/open?user_id=1&lock_id=2317&isscan=1')">
				<view class="label">开门演示</view>
				<image src="../../static/jiantouyou.png"></image>
			</view>
		</view>

		<tuniaoui-wx-user-info v-model="showAuthorizationModal" @updated="updatedUserInfoEvent"></tuniaoui-wx-user-info>
	</view>
</template>

<script>
	import TnuiWxUserInfo from '@/components/uni-dateformat/components/uni-dateformat/uni-dateformat.vue';
	import {
		userInfo_api,
		editMember_api
	} from '../../api/index.js'
	import { imgPath } from '@/libs/filters.js'
	export default {
		components: {
			TnuiWxUserInfo,
		},
		data() {
			return {
				showAuthorizationModal: false,
				userInfo: {},
				scrollTop: ''
			}
		},
		filters: {
			imgPath
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onShow() {
			this.getUserInfo()
		},
		methods: {
			async getUserInfo() {
				let res = await userInfo_api()
				if (res.code === 0) {
					this.userInfo = res.data
				}
			},
			goPage(url) {
				uni.navigateTo({
					url: url
				})
			},
			async updatedUserInfoEvent(info) {
				console.log(info)
				// editMember_api
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await editMember_api({ nickname: info.nickname, headimgurl: info.avatar })
				if (res.code === 0) {
					this.showAuthorizationModal = false
					uni.showToast({
						title: '更新成功'
					})
					this.getUserInfo()
				} else {
					uni.showToast({
						title: res.msg
					})
				}
			},
			goDetail(url) {
				uni.navigateTo({
					url: url
				})
			},
			bindPhone() {
				if (!this.userInfo.mobile) {
					uni.navigateTo({
						url: '/pages/open/open?type=phone'
					})
				}
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './personal.scss';
</style>
