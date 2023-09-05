<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">ICCID号:</view>
						<input placeholder="输入iccid号" placeholder-class="placeholder" v-model="sim_sn" />
					</view>
					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>
				<view class="btn-box">
					<view class="bottom-btn" @click="onSubmit">查询</view>
					<view class="bottom-btn" style="margin-left: 30rpx; background: #EDAB00;" @click="goRecord('/pages/record/record')">续费记录</view>
					<view class="bottom-btn" style="margin-left: 30rpx;" @click="goRenew('/pages/renew/renew?sim_sn=' + sim_sn)">续费</view>
				</view>

			</view>
			<view class="explain">
				<view class="text">业务卡号:{{data.msisdn}}</view>
				<view class="text">使用状态:{{data.status}}</view>
				<view class="text">运营商:{{data.operator}}</view>
				<view class="text">资费过期时间:{{data.expirationTime}}</view>
				<view class="text">总流量(MB):{{data.totaldata}}</view>
				<view class="text">已使用流量(MB):{{data.outdata}}</view>
			</view>
		</view>

	</view>
</template>

<script>
	import {
		simInfo
	} from '../../api/index.js'
	export default {
		data() {
			return {
				sim_sn: '',
				data: {
					msisdn: "",
					iccid: "",
					imsi: "",
					status: "",
					sp_code: "",
					data_plan: "",
					carrier: "",
					operator: "",
					data_usage: "",
					account_status: "",
					expiry_date: "",
					expirationTime: "",
					totaldata: "",
					outdata: "",
					active: "",
					test_valid_date: "",
					silent_valid_date: "",
					test_used_data_usage: "",
					active_date: "",
					data_balance: "",
					outbound_date: "",
					support_sms: "",
				}

			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			console.log("onShow", option)
			if (option && option.iccid) {
				this.sim_sn = option.iccid
			}
		},
		onShow() {

		},
		methods: {

			scanCode() {
				uni.scanCode({
					success: (res) => {
						this.sim_sn = res.result
					}
				});
			},

			async onSubmit() {
				if (!this.sim_sn) {
					this.showToast('请输入iccid号')
					return;
				}

				let data = {
					sim_sn: this.sim_sn,

				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await simInfo(data)
				if (res.code === 0) {
					uni.hideLoading()
					this.data = res.data


				} else {

					this.data = {
						msisdn: "",
						iccid: "",
						imsi: "",
						status: "",
						sp_code: "",
						data_plan: "",
						carrier: "",
						operator: "",
						data_usage: "",
						account_status: "",
						expiry_date: "",
						expirationTime: "",
						totaldata: "",
						outdata: "",
						active: "",
						test_valid_date: "",
						silent_valid_date: "",
						test_used_data_usage: "",
						active_date: "",
						data_balance: "",
						outbound_date: "",
						support_sms: "",
					}

					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask: true
				})
			},
			goRenew(url) {
				if (!this.sim_sn) {
					this.showToast('请输入iccid号')
					return;
				}
				uni.navigateTo({
					url: url
				})
			},
			goRecord(url) {
				uni.navigateTo({
					url: url
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './sim.scss';
</style>