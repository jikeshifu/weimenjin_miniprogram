<template>
	<view class="container">
		<!-- 空白页 -->
		<view class="empty">
			<image src="../../static/empty.png" mode="aspectFit" class="enpty-img"></image>
			<view  class="empty-tips">
				空空如也
				<navigator class="navigator"  url="../index/index" open-type="switchTab">随便逛逛></navigator>
			</view>
		</view>
		
	</view>
</template>

<script>
	export default {
		data() {
			return {
				
			};
		},
		onLoad(){
		},
		computed:{
		},
		methods: {
			
		}
	}
</script>

<style>
.container {
	width: 100%;
	height: 100%;
	background: #FFFFFF;
}	
.empty{
	display: flex;
	align-items: center;
	/* justify-content: center; */
	flex-direction: column;
	padding-top: 80rpx;
}
.enpty-img {
	width: 400rpx;
}
.empty-tips {
	display: flex;
	align-items: center;
	font-size:32rpx;
}
.navigator {
	color: #DF5959;
	margin-left: 20rpx;
}
</style>
