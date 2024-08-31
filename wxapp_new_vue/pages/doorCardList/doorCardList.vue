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
						<view class="user-info">
							<view class="user-name">
							  <template v-if="item.lockcard_username || item.lockcard_remark">
							    {{ item.lockcard_username }}<template v-if="item.lockcard_remark"> ({{ item.lockcard_remark }})</template>
							  </template>
							  <template v-else>未实名</template>
							</view>
							<view class="phone">卡号：{{ item.lockcard_sn }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="delete-btn" style="background: #21CF3E;" @click="goDetail(item)">发卡</view>
						<view class="delete-btn" style="background: orange;" @click="edit(item)">编辑</view>
						<view class="delete-btn" @click="onDelete(item.lockcard_id)">删除</view>
					</view>
				</view>
				<uni-load-more :status="noMore" empty_text="无门卡数据～" style="padding-top: 40rpx;"></uni-load-more>
			</view>
			
			<view class="bottom-btn" @click="operation">
				<view class="btn">操作</view>
			</view>
			
		</view>
	</view>
</template>

<script>
import { cardList_api, delCard_api } from '../../api/index.js'	
export default {
	data() {
		return {
			scrollTop: 0,
			noMore: 'loading',
			page: 1,
			dataList: [],
			lock_id: '',
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
		this.lock_id = option.lock_id
	},
	onShow() {
		this.dataList = []
		this.page = 1
		this.getList()
	},
	methods: {
		edit(item) {
			console.log(item)
			uni.navigateTo({
				url: '/pages/addCard/addCard?item=' + encodeURIComponent(JSON.stringify(item))
			})
		},
		async onDelete(lockcard_id) {
			uni.showModal({
				title: '提示',
				content: '确定删除该门卡吗?',
				success: async (msg) => {
					if (msg.confirm) {
						uni.showLoading({
							title: '删除中...',
							mask: true
						})
						let res = await delCard_api({
							lockcard_id: lockcard_id,
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
		},
		confirm(e) {
			this.search_key = e.detail.value
			this.dataList = [];
			this.page = 1;
			this.getList()
		},
		goDetail(item) {
			uni.navigateTo({
				url: '/pages/issue/issue?item=' + encodeURIComponent(JSON.stringify(item))
			})
		},
		async getList() {
			this.noMore = 'loading';
			let params = {
				page: this.page,
				limit: 10,
				lock_id: this.lock_id,
				search_key: this.search_key
			};
			let res = await cardList_api(params);
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
		operation() {
			uni.showActionSheet({
				itemList: ['添加门卡','同步数据'],
				success: (res) => {
					if (res.tapIndex === 0) {
						uni.navigateTo({
							url: '/pages/addCard/addCard?lock_id=' + this.lock_id
						})
					} else {
						uni.navigateTo({
							url: '/pages/synchroData/synchroData?lock_id=' + this.lock_id + '&type=card'
						})
					}
				},
			});
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
	
}	
</script>

<style  scoped lang="scss">
@import './doorCardList.scss';
</style>