<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="title">续费金额</view>
				<view class="list">
					<view class="item item-on">
						<view class="price">{{ renewData.price }}</view>
					</view>
				</view>
			</view>
			<view class="btn" @click="onsubmit">充值</view>
			<view class="explain">
				<view class="text">温馨提示：</view>
				<view class="text">充值如发生任何异常，请联系商家</view>
			</view>
		</view>
	</view>
</template>

<script>
import { simRenew_api, simOrder_api } from "@/api/index.js";	
export default {
	data() {
		return {
			sim_sn: '',
			renewData: {}
		}
	},
	onLoad(option) {
		this.sim_sn = option.sim_sn
		this.getData()
	},
	methods: {
		async getData() {
			let res = await simRenew_api({ sim_sn: this.sim_sn})
			if (res.code === 0) {
				this.renewData = res.data
			} else {
				this.showToast(res.msg)
			}
		},
		async onsubmit() {
			let res = await simOrder_api({ sim_sn: this.sim_sn });
			if (res.code === 0) {
				uni.showLoading({
					title: '加载中',
					mask:true
				})
				this.onPay(res.data.payData)
			} else {
				this.showToast(res.msg)
			}
		},
		onPay(payData) {
			uni.requestPayment({
				provider: 'wxpay',
				appId: payData.appId,
				timeStamp: payData.timeStamp,
				nonceStr: payData.nonceStr,
				package: payData.package,
				signType: payData.signType,
				paySign: payData.paySign,
				success: (res) => {
					this.showToast('支付成功')					
					uni.hideLoading();
					uni.navigateBack({
						delta: 1
					})
				},
				fail: (err) => {
					console.log(err)
					uni.hideLoading();
				}
			});
		},
		showToast(msg) {
			uni.showToast({
				title: msg,
				icon: 'none'
			})
		}
	}
}	
</script>

<style scoped lang="scss">
@import './renew.scss';
</style>