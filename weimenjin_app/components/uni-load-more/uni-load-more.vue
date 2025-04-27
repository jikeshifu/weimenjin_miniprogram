<template>
	<view class="uni-load-more" v-if="status !== 'nodata'">
		<view class="uni-load-more__img" v-show="status === 'loading' && showIcon">
			<view class="load1">
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
			</view>
			<view class="load2">
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
			</view>
			<view class="load3">
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
				<view :style="{ background: color }"></view>
			</view>
		</view>
		<text class="uni-load-more__text" :style="{ color: color }">
			{{ status === 'more' ? contentText.contentdown : (status === 'loading' ? contentText.contentrefresh : contentText.contentnomore) }}
		</text>
	</view>
	<view v-else class="empty">
		<image :src="empty_icon" class="empty-image"></image>
		<view class="empty-text">{{ empty_text }}</view>
		<button class="retry-button" @click="retry">重试</button>
	</view>
</template>

<script>
	export default {
		name: "uni-load-more",
		props: {
			status: {
				// 上拉的状态：more-loading前；loading-loading中；noMore-没有更多了
				type: String,
				default: 'more'
			},
			showIcon: {
				type: Boolean,
				default: true
			},
			color: {
				type: String,
				default: "#777777"
			},
			empty_text: {
				type: String,
				default: "～ 空空如也 ～"
			},
			empty_icon: {
				type: String,
				default: "../../static/kong.png"
			},
			contentText: {
				type: Object,
				default() {
					return {
						contentdown: "上拉显示更多",
						contentrefresh: "正在加载...",
						contentnomore: "---没有更多数据啦---"
					};
				}
			}
		},
		methods: {
			retry() {
				uni.clearStorageSync(); // 清理缓存
				uni.showToast({
					title: '缓存已清理，重新加载',
					icon: 'success',
					duration: 2000,
					complete: () => {
						setTimeout(() => {
							uni.reLaunch({
								url: '/pages/index/index' // 修改为你的页面路径
							});
						}, 2000);
					}
				});
			}
		}
	};
</script>

<style scoped>
	.uni-load-more {
		display: flex;
		flex-direction: row;
		height: 80rpx;
		align-items: center;
		justify-content: center;
		margin-top: 40rpx;
	}
	.empty {
		display: flex;
		align-items: center;
		flex-direction: column;
		width: 100%;
		height: 100%;
		padding-top: 50rpx;
	}
	.empty-image {
		width: 200rpx;
		height: 200rpx;
		margin-bottom: 20rpx;
	}
	.empty-text {
		color: #999;
		font-size: 28rpx;
		margin-bottom: 20rpx;
	}
	.retry-button {
		background-color: #007aff;
		color: white;
		font-size: 28rpx;
		padding: 10rpx 30rpx;
		border-radius: 8rpx;
		border: none;
		cursor: pointer;
	}
	.retry-button:hover {
		background-color: #0051aa;
	}
</style>
