<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view class="tab-list">
					<view :class="['tab-item', tabIndex === index ? 'tab-item-on' : '']" v-for="(item, index) in tabList" :key="index" @click="clickTab(index)">{{ item }}</view>
				</view>
				<view class="search-box">
					<image src="../../static/sousuo.png"></image>
					<input placeholder="请输入关键词" placeholder-class="placeholder" class="search-input" confirm-type="search" @confirm="confirm"/>
				</view>
			</view>
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="left-box">
						<image :src="item.headimgurl | imgPath" class="user-img" v-if="item.headimgurl"></image>
						<image src="../../static/moren.png" class="user-img" v-else></image>
						<view class="user-info">
							<view class="user-name">{{ item.nickname }}({{item.aremark}})</view>
							<view class="phone" v-if="item.mobile">{{ item.mobile.replace(/^(.{3})(?:\d+)(.{4})$/,"$1****$2") }}</view>
						</view>
					</view>
					<view class="right-box">
						<!-- <view class="add-btn" @click="goPage('/pages/addCard/addCard')">添加卡</view> -->
						<view class="detail-btn" @click="goPage('/pages/keyDetail/keyDetail?lockauth_id=' + item.lockauth_id )">详情</view>
					</view>
				</view>
				<uni-load-more :status="noMore" empty_text="暂无数据～"></uni-load-more>
			</view>
			
		</view>
	</view>
</template>

<script>
import { LockAuthList_api } from '@/api/index.js';	
import { imgPath } from '@/libs/filters.js'
export default {
	data() {
		return {
			tabList: ['待审核', '已通过'],
			tabIndex: 0,
			scrollTop: 0,
			lockauth_id: '',
			noMore: 'loading',
			page: 1,
			dataList: [],
			search_key: ''
		}
	},
	filters: {
		imgPath
	},
	onPageScroll(e) {
		this.scrollTop = e.scrollTop
	},
	onLoad(option) {
		this.lockauth_id = option.lockauth_id
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
				lockauth_id: this.lockauth_id,
				search_key: this.search_key,
				auth_status: this.tabIndex
			};
			let res = await LockAuthList_api(params);
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
			this.dataList = [];
			this.page = 1;
			this.getList()
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

<style  scoped lang="scss">
@import './keyList.scss';
</style>