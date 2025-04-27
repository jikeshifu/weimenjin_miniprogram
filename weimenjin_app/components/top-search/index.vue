<template>
	<view class="top-search">
		<view style="display: flex;">
			<view class="search-input" @click="skip">
				<view class="placeholder">搜索你想要的商品</view>
				<view class="iconfont icon-suosou1-copy"></view>
			</view>
			<view class="message" @click="skipMes">
				<view class="icon">
					<image src=""></image>
					<view type="error" class="hint" v-if="msgNum">{{ msgNum }}</view>
				</view>
			</view>
		</view>
		
	</view>
</template>
<script>
import uniBadge from "@/components/uni-badge/uni-badge.vue"	
	export default {
		name: 'TopSearch',
		props: {
			msgNum: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				
			}
		},
		methods: {
			skip() {
				uni.navigateTo({
					url: '/pages/search/search'
				})
			},
			skipMes() {
				uni.navigateTo({
					url: '/pages/message/message'
				})
			}
		}
	}
</script>
<style scoped>
.top-search {
	display: flex;
	align-items: center;
	justify-content: center;
	background: #FFFFFF;
	height: 100rpx;
}	
.search-input {
	width: 570rpx;
	height: 68rpx;
	border:1px solid rgba(64,158,152,1);
	border-radius:34px;
	margin: 0 30rpx;
	display: flex;
	align-items: center;
	justify-content: center;
}
.placeholder {
	font-size: 28rpx;
	color: #CCCCCC;
}
.icon-suosou1-copy {
	color: #999999;
	font-size: 35rpx;
	margin-left: 10rpx;
}
.icon image{
	width: 68rpx;
	height: 68rpx;
}
.message {
	margin-right: 52rpx;
	
}
.icon {
	width: 68rpx;
	height: 68rpx;
	position: relative;
}
.icon image {
	width: 100%;
	height: 100%;
}
.hint {
	position: absolute;
	bottom: 0;
	right: -20rpx;
	width: 32rpx !important;
	height: 32rpx !important;
	line-height: 32rpx !important;
	font-size: 20rpx;
	background-color: #DF5959;
	border-radius:50%;
	color: #FFFFFF;
	display: flex;
	align-items: center;
	justify-content: center;
}
</style>
