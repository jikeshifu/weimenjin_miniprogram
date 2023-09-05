<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view class="search-box">
					<image src="../../static/sousuo.png"></image>
					<input placeholder="请输入操作记录" placeholder-class="placeholder" class="search-input" confirm-type="search" @confirm="confirm"/>
				</view>
			</view>
			
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index" @click="showMobile(item)">
					<view class="left-box">
						<image :src="item.headimgurl | imgPath" class="user-img" v-if="item.headimgurl"></image>
						<image src="../../static/moren.png" class="user-img" v-else></image>
						<view class="user-info">
							<view class="flex-box">
								<view class="user-name" v-if="item.user_name">{{ item.user_name }}</view>
								<view class="user-name tourist" v-else>游客</view>
								
							</view>
							<view class="phone">{{ item.mobile }}</view>
							<view class="time">{{ item.create_time }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="equipment-name">
							<view class="text" v-if="item.lock">{{ item.lock.lock_name }}</view>
						</view>
						<view class="status" >{{ item.type_name ? item.type_name : '操作' }}{{ item.status === 1 ? '成功' : '失败' }}</view>
						<!-- <view class="status" style="background: #165DFF;" v-else>点击开门成功</view> -->
					</view>
				</view>
				<uni-load-more :status="noMore" empty_text="暂无操作记录～"></uni-load-more>
			</view>
		</view>
	</view>
</template>

<script>
import { record_api } from '@/api/index.js';	
import { formatDate, imgPath } from '@/libs/filters.js'
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
	filters: {
		formatDate,
		imgPath
	},
	onPageScroll(e) {
		this.scrollTop = e.scrollTop
	},
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
		showMobile(data){
			console.log("data",data)
			
			uni.showActionSheet({
				itemList: [data.mobileShow],
				success: function (res) {
					
					uni.makePhoneCall({
					  phoneNumber:  data.mobileShow, //此号码并非真实电话号码，仅用于测试
					  success: function () {
					    //console.log("拨打电话成功！")
					  },
					  fail: function () {
					    //console.log("拨打电话失败！")
					  }
					})
			
				},
				fail: function (res) {
					console.log(res.errMsg);
				}
			});
		},
		async getList() {
			this.noMore = 'loading';
			let params = {
				page: this.page,
				limit: 10,
				lock_id: this.lock_id,
				search_key: this.search_key
			};
			let res = await record_api(params);
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
		confirm(e) {
			this.search_key = e.detail.value
			this.dataList = [];
			this.page = 1;
			this.getList()
		},
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
@import './operateList.scss';	
</style>