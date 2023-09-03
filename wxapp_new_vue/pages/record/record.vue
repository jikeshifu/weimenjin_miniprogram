<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="left-box">
						<view class="text">iccid号：{{ item.sim_sn }}</view>
						<view class="time" v-if="item.pay_time">{{ item.pay_time }}</view>
					</view>
					<view class="right-box">
						<view class="status">{{ item.order_status === 0 ? '待续费' : '续费成功' }}</view>
						<view class="price" v-if="item.pay_price">+{{ item.pay_price }}</view>
					</view>
					
				</view>
			</view>
			<uni-load-more :status="noMore" empty_text="暂无续费记录～"></uni-load-more>
		</view>
	</view>
</template>

<script>
	import {
		orderList_api
	} from "@/api/index.js";
	export default {
		data() {
			return {
				noMore: 'loading',
				page: 1,
				dataList: [],
			}
		},
		onLoad(option) {
			this.getList()
		},
		methods: {
			async getList() {
				this.noMore = 'loading';
				let params = {
					page: this.page,
					limit: 10,
				};
				let res = await orderList_api(params);
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
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none'
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
	@import './record.scss';
</style>