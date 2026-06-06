<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">


			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view style="margin-left: 20rpx;height: 100rpx;">
					<view class="cell-item" @click="openTime">

						<view class="text">
							{{ formData.startTime ? formatDate(formData.startTime) : '请选择开始时间' }}</view>
					</view>
					<view class="cell-item" @click="openTime2">

						<view class="text">
							{{ formData.endTime ? formatDate(formData.endTime) : '请选择结束时间' }}</view>
					</view>
						<uni-section :title="'日期时间用法：' + datetimesingle" type="line"></uni-section>

				</view>

			</view>

			<view class="list" v-if="listStatus">
				<view class="item" v-for="(item, index) in dataList" :key="index" @click="showMobile(item)">
					<view class="left-box">
						<image src="../../static/online.png" class="user-img" v-if="item.cmd=='OnLine'"></image>
						<image src="../../static/offline.png" class="user-img" v-else></image>
						<view class="user-info">
							<view class="flex-box">
								<view class="user-name tourist">{{ item.cmd }}</view>
							</view>
							<view class="time">{{ formatDate(parseInt(item.on_line_time, 10)) }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="equipment-name">
							<view class="text" v-if="item.cmd=='OnLine'" style="color: green;">设备上线</view>
							<view class="text" v-if="item.cmd=='OffLine'">设备离线</view>
						</view>
					</view>
				</view>
				<uni-load-more :status="noMore" empty_text="暂无操作记录～"></uni-load-more>
			</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" :minDate="1640966400000"  v-model="formData.startTime" mode="datetime" @confirm="searchTime()" @close="listStatus=!listStatus">
		</uv-datetime-picker>
		<uv-datetime-picker ref="datetimePicker2" v-model="formData.endTime" mode="datetime" @confirm="searchTime()" @close="listStatus=!listStatus">
		</uv-datetime-picker>
	</view>
</template>

<script>
import { onoffline_api } from '@/api/index.js';
import { formatDate, imgPath } from '@/libs/filters.js'
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
export default {
	components: {
		UvDatetimePicker
	},
	data() {
		return {
			listStatus:true,
			formData: {

				startTime: '',
				endTime: '',
			},
			scrollTop: 0,
			lock_sn: '',
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
		this.lock_sn = option.lock_sn ? option.lock_sn : ''
	},
	onShow() {
		this.dataList = []
		this.page = 1
		this.getList()
	},
	methods: {
		showMobile(data){
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
				}
			});
		},
		openTime() {
			this.listStatus =false
			this.$refs.datetimePicker.open();
		},
		openTime2() {
			this.listStatus =false
			this.$refs.datetimePicker2.open();
		},


		searchTime(e) {

		this.dataList = [];
		this.page = 1;
		setTimeout(()=>{
			this.getList()
		},100)
		},
		formatDate(date, fmt = 'yyyy-MM-dd hh:mm:ss') {
			var crtTime;
			if (typeof date === 'number') {
				if ((date + '').length !== 13) {
					crtTime = new Date(date * 1000);
				} else {
					crtTime = new Date(date);
				}
			} else {
				crtTime = new Date(date);
			}
			var o = {
				'M+': crtTime.getMonth() + 1,
				'd+': crtTime.getDate(),
				'h+': crtTime.getHours(),
				'm+': crtTime.getMinutes(),
				's+': crtTime.getSeconds(),
				'q+': Math.floor((crtTime.getMonth() + 3) / 3),
				S: crtTime.getMilliseconds(),
			};
			if (/(y+)/.test(fmt)) {
				fmt = fmt.replace(
					RegExp.$1,
					(crtTime.getFullYear() + '').substr(4 - RegExp.$1.length),
				);
			}
			for (var k in o) {
				if (new RegExp('(' + k + ')').test(fmt)) {
					fmt = fmt.replace(
						RegExp.$1,
						RegExp.$1.length === 1 ?
						o[k] :
						('00' + o[k]).substr(('' + o[k]).length),
					);
				}
			}
			return fmt;
		},
		async getList() {
			this.noMore = 'loading';
			let params = {
				page: this.page,
				limit: 10,

					startTime: this.formData.startTime/1000,
					endTime: this.formData.endTime/1000,
				lock_sn: this.lock_sn,
				search_key: this.search_key
			};
			let res = await onoffline_api(params);
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
@import './onoffline.scss';
</style>
