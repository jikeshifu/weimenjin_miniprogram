<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="list">
				<view class="item" v-for="(item, index) in groupingList" :key="index" @click="clickItem(item.device_group_id)">
					<view class="family-name">{{ item.device_group_name }}</view>
					<view class="right-box">
						<view class="flex-box">
							<view class="number">{{ item.device_count }}</view>
							<view class="text">个设备</view>
						</view>
						<image src="../../static/jiantouyou.png" class="icon-img"></image>
					</view>
				</view>
			</view>
			<view class="bottom">
				<view class="btn" @click="goPage('/pages/addFamily/addFamily')">新建分组</view>
			</view>
		</view>
	</view>
</template>

<script>
import { getDeviceGroup_api } from '../../api/index.js'
export default {
	data() {
		return {
			groupingList: []
		}
	},
	// 小程序显示分享
	onShareAppMessage() {},
	onShareTimeline() {},
	onShow() {
		this.getDeviceGroup()
	},
	methods: {
		async getDeviceGroup() {
			let res = await getDeviceGroup_api()
			this.groupingList = res.data
		},
		goPage(url) {
			uni.navigateTo({
				url: url
			})
		},
		clickItem(id) {
			uni.navigateTo({
				url: '/pages/familyDateil/familyDateil?device_group_id=' + id
			})
		}
	}
}	
</script>

<style scoped lang="scss">
@import './familyList.scss';
</style>