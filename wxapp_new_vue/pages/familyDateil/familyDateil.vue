<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="cell-item"
				@click="goPage('/pages/addFamily/addFamily?device_group_id=' + device_group_id + '&device_group_name=' + groupInfo.device_group_name)">
				<view class="label">分组名称</view>
				<view class="flex-box">
					<view class="value">{{ groupInfo.device_group_name }}</view>
					<image src="../../static/jiantouyou.png" class="right-icon-img"></image>
				</view>

			</view>

			<view class="cell-item">
				<view class="label">添加设备</view>
				<view class="flex-box"
					@click="goPage('/pages/addEquipment/addEquipment?device_group_id=' + device_group_id)">
					<view class="value" style="color: #EDAB00;">添加</view>
					<image src="../../static/tianjiarenyuan.png" class="icon-img"></image>
				</view>

			</view>
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="flex-box">
						<image src="../../static/moren.png"></image>
						<view class="user-name" v-if="item.lock">{{ item.lock.lock_name }}</view>
					</view>
					<view class="right-box">
						<view class="delete-btn" @click="delDevice(item.lockauth_id)">删除</view>
					</view>
				</view>

				<uni-load-more :status="noMore" empty_text="暂无数据～" style="margin-top: 40rpx;"></uni-load-more>
			</view>
			<view class="bottom">
				<view class="btn" @click="onDelete">删除分组</view>
			</view>
		</view>
	</view>
</template>

<script>
	import {
		DeviceGroupDetail_api,
		delDeviceGroup_api,
		delDevice_api
	} from '../../api/index.js';
	export default {
		data() {
			return {
				device_group_id: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				groupInfo: {}
			}
		},
		onLoad(option) {
			this.device_group_id = option.device_group_id
		},
		onShow() {
			this.dataList = []
			this.page = 1
			this.getList()
		},
		methods: {
			async getList() {
				this.noMore = 'loading';
				let params = {
					page: this.page,
					limit: 10,
					device_group_id: this.device_group_id
				};
				let res = await DeviceGroupDetail_api(params);
				this.groupInfo = res.data.info

				if (this.page !== 1 && !res.data.all.length) {
					this.noMore = 'noMore';
					return;
				} else if (this.page === 1 && !res.data.all.length) {
					this.dataList = [];
					this.dataList = res.data.all;
					this.noMore = 'nodata';
					return;
				}
				this.dataList = this.dataList.concat(res.data.all); //将数据拼接在一起

				if (this.dataList.length < 10) {
					this.noMore = 'noMore';
				}

			},
			onDelete() {
				uni.showModal({
					title: '提示',
					content: '确定要删除该分组?',
					success: async (msg) => {
						if (msg.confirm) {
							let res = await delDeviceGroup_api({
								device_group_id: this.device_group_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功！',
									icon: 'none',
									mask: true
								})
								let timer = setTimeout(() => {
									uni.navigateBack({
										delta: 1
									})
									clearTimeout(timer)
								}, 1000)
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none',
									mask: true
								})
							}
						}
					}
				})
			},
			goPage(url) {
				uni.navigateTo({
					url: url
				})
			},
			delDevice(lockauth_id) {
				uni.showModal({
					title: '提示',
					content: '确定删除？',
					success: async (msg) => {
						if (msg.confirm) {
							let res = await delDevice_api({
								lockauth_id: lockauth_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功！',
									icon: 'none',
									mask: true
								})
								this.dataList = []
								this.page = 1
								this.getList()
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none',
									mask: true
								})
							}
						}
					}
				})
			}
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++; //每触底一次 page +1
			this.getList();
		},
		async onPullDownRefresh() {
			let that = this;
			this.page = 1;

			that.dataList = [];
			await that.getList();
			uni.stopPullDownRefresh();
		}
	}
</script>

<style scoped lang="scss">
	@import './familyDateil.scss';
</style>