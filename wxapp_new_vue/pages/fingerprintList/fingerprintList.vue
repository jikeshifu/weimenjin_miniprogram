<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view class="search-box">
					<image src="../../static/sousuo.png"></image>
					<input placeholder="请输入关键词" placeholder-class="placeholder" class="search-input"
						confirm-type="search" @confirm="confirm" v-model="search_key" />
				</view>
			</view>
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="left-box">
						<image src="../../static/moren.png" class="user-img"></image>
						<view class="user-info">
							<view class="user-name">{{ item.finger_name }}</view>
							<view class="phone">指纹ID：{{ item.fp_id }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="add-btn"
							@click="goPage('/pages/addFingerprint/addFingerprint?lock_id=' + lock_id + '&finger_id=' + item.finger_id + '&finger_name=' + item.finger_name + '&end_time=' + item.end_time)">
							编辑</view>
						<view class="delete-btn" @click="onDelete(item.finger_id)">删除</view>
					</view>
				</view>
				<uni-load-more :status="noMore" empty_text="无指纹数据～"></uni-load-more>

			</view>

			<view class="bottom-btn" @click="goPage('/pages/addFingerprint/addFingerprint?lock_id=' + lock_id)">
				<view class="btn">添加指纹</view>
			</view>

		</view>
	</view>
</template>

<script>
	import {
		fingerList_api,
		delFinger_api
	} from '../../api/index.js';
	export default {
		data() {
			return {
				scrollTop: 0,
				lock_id: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				search_key: ''
			}
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.lock_id = option.lock_id ? option.lock_id : ''
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
					lock_id: this.lock_id,
					search_key: this.search_key
				};
				let res = await fingerList_api(params);
				this.groupInfo = res.data.info

				if (this.page !== 1 && !res.data.length) {
					this.noMore = 'noMore';
					return;
				} else if (this.page === 1 && !res.data.length) {
					this.dataList = [];
					this.dataList = res.data;
					this.noMore = 'nodata';
					return;
				}
				this.dataList = this.dataList.concat(res.data); //将数据拼接在一起

				if (this.dataList.length < 10) {
					this.noMore = 'noMore';
				}
			},
			clickTab(index) {
				this.tabIndex = index
			},
			confirm(e) {
				this.search_key = e.detail.value
				this.dataList = [];
				this.page = 1;
				this.getList()
			},
			goPage(url) {
				uni.navigateTo({
					url: url
				})
			},
			onDelete(finger_id) {
				uni.showModal({
					title: '提示',
					content: '确定删除该指纹吗?',
					success: async (msg) => {
						if (msg.confirm) {
							uni.showLoading({
								title: '删除中...',
								mask: true
							})
							let res = await delFinger_api({
								lock_id: this.lock_id,
								finger_id: finger_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功！',
									icon: 'none',
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
	@import './fingerprintList.scss';
</style>