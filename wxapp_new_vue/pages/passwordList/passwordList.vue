<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="left-box">
						<view class="user-info">
							<view class="user-name">{{ item.pwd_name }}</view>
							<view class="phone" v-if="item.isPwd">密码：******</view>
							<view class="phone" @click="copyVal(item.pwd)" v-else>密码：{{ item.pwd }}<br>时效：{{formatDate(item.end_time)}}</view>
							<i class="iconfont icon-bukejian" v-if="item.isPwd" @click="changePaw(item)"></i>
							<i class="iconfont icon-kejian" v-else @click="changePaw(item)"></i>
						</view>
					</view>
					<view class="right-box">
						<view class="delete-btn" @click="onDel(item)">删除</view>
					</view>
				</view>

				<uni-load-more :status="noMore" empty_text="暂无数据～"></uni-load-more>
			</view>

			<view class="bottom-btn" @click="operation">
				<view class="btn">操作</view>
			</view>

		</view>
	</view>
</template>

<script>
import { pwdList_api, delPwd_api, temporaryPassword_api } from '@/api/index.js';
export default {
	data() {
		return {
			lock_id: '',
			noMore: 'loading',
			page: 1,
			dataList: []
		}
	},
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
		changePaw(item) {
			item.isPwd = !item.isPwd
			this.$forceUpdate()
		},
		// 复制操作
		copyVal(context) {
			uni.setClipboardData({
				data: context,
				success(res) {
					console.log('success', res);
					uni.showToast({
						title: "复制成功",
			
					});
				}
			})
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
		async onDel(item) {
			uni.showModal({
				title: '提示',
				content: '确定删除该密码吗?',
				success: async (msg) => {
					if (msg.confirm) {
						uni.showLoading({
							title: '删除中...',
							mask: true
						})
						let res = await delPwd_api({ lock_id: item.lock_id, pwd_id: item.pwd_id })
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
		async getList() {
			this.noMore = 'loading';
			let params = {
				page: this.page,
				limit: 10,
				lock_id: this.lock_id,
			};
			let res = await pwdList_api(params);
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
			// console.log("this.pwddataList", this.dataList);
			if (this.dataList.length>0) {
				this.dataList.forEach((item) => {
					item.isPwd = true
				})
			}

			if (this.dataList.length < 10) {
				this.noMore = 'noMore';
			}
		},
		operation() {
			uni.showActionSheet({
				itemList: ['添加密码', '离线密码'],
				success: async (res) => {
					if (res.tapIndex === 0) {
						uni.navigateTo({
							url: '/pages/addPassword/addPassword?lock_id=' + this.lock_id
						})
					} else {
						let res = await temporaryPassword_api({ lock_id: this.lock_id })
						if (res.code === 0) {
							uni.showModal({
								title: '提示',
								content: '临时密码：' + res.data.pwd,
								showCancel: false,
								confirmText: '复制密码',
								confirmColor: '#6a7692',
								success: function (msg) {
									if (msg.confirm) {
										uni.setClipboardData({
											data: res.data.pwd,
											success: function () {
												uni.showToast({
													title: '临时密码复制成功'
												})
											}
										});
									}
								}
							});
						}
					}
				},
			});
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
@import './passwordList.scss';
</style>
