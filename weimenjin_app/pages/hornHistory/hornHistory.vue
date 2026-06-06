<template>
	<view class="horn-history-page">
		<view class="header">
			<text class="title">{{ deviceName }}</text>
			<text class="serial" v-if="deviceSerial">序列号: {{ deviceSerial }}</text>
		</view>

		<view class="history-list" v-if="historyList.length > 0">
			<view
				class="history-item"
				:class="{ 'editing': editingIndex === index }"
				v-for="(item, index) in historyList"
				:key="item.id || index"
			>
			<view class="item-content" @click="startEdit(item, index)">
				<textarea
					v-if="editingIndex === index"
					v-model="editContent"
					class="content-text-edit"
					:maxlength="500"
					:focus="true"
					:show-confirm-bar="false"
					:adjust-position="true"
					:cursor-spacing="100"
				/>
				<view v-else class="content-text">{{ item.content }}</view>
					<view class="item-info">
						<text class="time">{{ formatTime(item.created_at) }}</text>
						<text class="params">音量:{{ item.volume }} | 语速:{{ item.speed }} | 声调:{{ item.tone }}</text>
					</view>
				</view>
				<view class="item-action">
					<view
						v-if="editingIndex === index"
						class="confirm-btn"
						@click.stop="playEditedContent"
					>
						<i class="iconfont icon-bofangjilu1"></i>
						<text>播放</text>
					</view>
					<template v-else>
						<view
							class="edit-btn"
							@click.stop="startEdit(item, index)"
						>
							<i class="iconfont icon-bofangjilu"></i>
						</view>
						<view
							class="play-btn"
							:class="{ 'playing': playingIndex === index }"
							@click.stop="playHistory(item, index)"
						>
							<i class="iconfont icon-bofangjilu1"></i>
							<text>{{ playingIndex === index ? '播放中' : '播放' }}</text>
						</view>
					</template>
				</view>
			</view>
		</view>

		<view class="empty-state" v-else>
			<i class="iconfont icon-zanwushuju empty-icon"></i>
			<text class="empty-text">暂无播放历史</text>
		</view>

		<uni-load-more :status="loadMoreStatus" :content-text="loadMoreText"></uni-load-more>
	</view>
</template>

<script>
import { playHorn_api } from "../../api/index.js";

export default {
	data() {
		return {
			lockauth_id: '',
			deviceName: '',
			deviceSerial: '',
			historyList: [],
			page: 1,
			limit: 20,
			total: 0,
			loadMoreStatus: 'more',
			loadMoreText: {
				contentdown: '上拉加载更多',
				contentrefresh: '加载中...',
				contentnomore: '没有更多了'
			},
			playingIndex: -1,
			editingIndex: -1,
			editContent: '',
			editVoice: {
				volume: 3,
				speed: 5,
				tone: 5
			}
		}
	},
	onLoad(options) {
		if (options.lockauth_id) {
			this.lockauth_id = options.lockauth_id
		}
		if (options.device_name) {
			this.deviceName = decodeURIComponent(options.device_name)
		}
		if (options.device_serial) {
			this.deviceSerial = decodeURIComponent(options.device_serial)
		}
		this.loadHistory()
	},
	onReachBottom() {
		if (this.loadMoreStatus === 'more' && this.historyList.length < this.total) {
			this.page++
			this.loadHistory()
		}
	},
	onPullDownRefresh() {
		this.page = 1
		this.historyList = []
		this.loadHistory()
		setTimeout(() => {
			uni.stopPullDownRefresh()
		}, 1000)
	},
	methods: {
		async loadHistory() {
			if (!this.lockauth_id) {
				uni.showToast({
					title: '设备信息错误',
					icon: 'none'
				})
				return
			}

			this.loadMoreStatus = 'loading'

			try {
				// 调用父页面的获取历史记录方法
				// 这里需要替换为实际的API调用
				let res = await this.getHornHistory(this.lockauth_id, this.page, this.limit)

				if (res.code === 0) {
					if (this.page === 1) {
						this.historyList = res.data.list || []
					} else {
						this.historyList = this.historyList.concat(res.data.list || [])
					}
					this.total = res.data.total || 0

					if (this.historyList.length >= this.total) {
						this.loadMoreStatus = 'noMore'
					} else {
						this.loadMoreStatus = 'more'
					}
				} else {
					uni.showToast({
						title: res.msg || '加载失败',
						icon: 'none'
					})
					this.loadMoreStatus = 'more'
				}
			} catch (error) {
				console.error('加载播放历史失败:', error)
				uni.showToast({
					title: '加载失败',
					icon: 'none'
				})
				this.loadMoreStatus = 'more'
			}
		},
		async getHornHistory(lockauth_id, page, limit) {
			try {
				const { getHornHistory_api } = require("../../api/index.js")
				const res = await getHornHistory_api({
					lockauth_id: lockauth_id,
					page: page,
					limit: limit
				})
				return res
			} catch (error) {
				console.error('获取播放历史失败:', error)
				return {
					code: -1,
					msg: '获取失败'
				}
			}
		},
		async playHistory(item, index) {
			if (this.playingIndex === index) {
				uni.showToast({
					title: '正在播放中',
					icon: 'none'
				})
				return
			}

			this.playingIndex = index

			try {
				uni.showLoading({
					title: '播放中...',
					mask: true
				})

				let res = await playHorn_api({
					lockauth_id: this.lockauth_id,
					volume: item.volume || 3,
					speed: item.speed || 4,
					tone: item.tone || 5,
					tts: item.content,
					stopplay: false
				})

				uni.hideLoading()

				if (res.code === 0) {
					uni.showToast({
						title: '播放成功',
						icon: 'none'
					})

					// 2秒后重置播放状态
					setTimeout(() => {
						this.playingIndex = -1
					}, 2000)
				} else {
					this.playingIndex = -1
					uni.showToast({
						title: res.msg || '播放失败',
						icon: 'none'
					})
				}
			} catch (error) {
				console.error('播放失败:', error)
				this.playingIndex = -1
				uni.hideLoading()
				uni.showToast({
					title: '播放失败',
					icon: 'none'
				})
			}
		},
		startEdit(item, index) {
			this.editingIndex = index
			this.editContent = item.content
			this.editVoice = {
				volume: item.volume || 3,
				speed: item.speed || 5,
				tone: item.tone || 5
			}
		},
		cancelEdit() {
			this.editingIndex = -1
			this.editContent = ''
		},
		async playEditedContent() {
			if (!this.editContent.trim()) {
				uni.showToast({
					title: '请输入播报内容',
					icon: 'none'
				})
				return
			}

			this.editingIndex = -1

			try {
				uni.showLoading({
					title: '播放中...',
					mask: true
				})

				let res = await playHorn_api({
					lockauth_id: this.lockauth_id,
					volume: this.editVoice.volume,
					speed: this.editVoice.speed,
					tone: this.editVoice.tone,
					tts: this.editContent,
					stopplay: false
				})

				uni.hideLoading()

				if (res.code === 0) {
					uni.showToast({
						title: '播放成功',
						icon: 'none'
					})

					// 刷新列表
					this.page = 1
					this.historyList = []
					this.loadHistory()
				} else {
					uni.showToast({
						title: res.msg || '播放失败',
						icon: 'none'
					})
				}
			} catch (error) {
				console.error('播放失败:', error)
				uni.hideLoading()
				uni.showToast({
					title: '播放失败',
					icon: 'none'
				})
			}
		},
		formatTime(timestamp) {
			if (!timestamp) return ''

			const date = new Date(timestamp * 1000)
			const now = new Date()
			const diff = now - date

			// 今天
			if (diff < 86400000 && date.getDate() === now.getDate()) {
				return `今天 ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
			}
			// 昨天
			else if (diff < 172800000 && date.getDate() === now.getDate() - 1) {
				return `昨天 ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
			}
			// 其他
			else {
				return `${date.getMonth() + 1}-${date.getDate()} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
			}
		}
	}
}
</script>

<style scoped lang="scss">
.horn-history-page {
	min-height: 100vh;
	background: #f5f5f5;
	padding-bottom: 40rpx;
}

.header {
	background: #fff;
	padding: 40rpx 30rpx 30rpx;
	box-shadow: 0 2rpx 8rpx rgba(0, 0, 0, 0.05);

	.title {
		display: block;
		font-size: 36rpx;
		font-weight: bold;
		color: #333;
		margin-bottom: 12rpx;
	}

	.serial {
		display: block;
		font-size: 24rpx;
		color: #999;
	}
}

.history-list {
	padding: 20rpx 30rpx;
}

.history-item {
	background: #fff;
	border-radius: 16rpx;
	padding: 30rpx;
	margin-bottom: 20rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
	box-shadow: 0 2rpx 8rpx rgba(0, 0, 0, 0.05);

	.item-content {
		flex: 1;
		margin-right: 20rpx;

		.content-text {
			font-size: 28rpx;
			color: #333;
			line-height: 1.6;
			margin-bottom: 15rpx;
			word-break: break-all;
		}

	.content-text-edit {
		width: 100%;
		font-size: 28rpx;
		color: #333;
		line-height: 1.6;
		margin-bottom: 15rpx;
		word-break: break-all;
		background: transparent;
		border: none;
		padding: 0;
		box-sizing: border-box;
	}		.item-info {
			display: flex;
			flex-direction: column;
			gap: 8rpx;

			.time {
				font-size: 22rpx;
				color: #999;
			}

			.params {
				font-size: 22rpx;
				color: #999;
			}
		}
	}

	.item-action {
		flex-shrink: 0;
		display: flex;
		gap: 15rpx;

		.edit-btn {
			width: 64rpx;
			height: 64rpx;
			background: #f5f5f5;
			border-radius: 32rpx;
			display: flex;
			align-items: center;
			justify-content: center;

			.iconfont {
				font-size: 28rpx;
				color: #666;
			}

			&:active {
				background: #e5e5e5;
			}
		}

		.play-btn {
			width: 130rpx;
			height: 64rpx;
			background: linear-gradient(135deg, #21cf3e 0%, #1ab032 100%);
			border-radius: 32rpx;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 26rpx;
			box-shadow: 0 4rpx 12rpx rgba(33, 207, 62, 0.3);
			transition: all 0.3s ease;

			.iconfont {
				font-size: 32rpx;
				margin-right: 8rpx;
			}

			&:active {
				transform: scale(0.95);
				opacity: 0.9;
			}

			&.playing {
				background: linear-gradient(135deg, #999 0%, #888 100%);
				box-shadow: 0 4rpx 12rpx rgba(153, 153, 153, 0.3);
			}
		}

		.confirm-btn {
			width: 130rpx;
			height: 64rpx;
			background: linear-gradient(135deg, #21cf3e 0%, #1ab032 100%);
			border-radius: 32rpx;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 26rpx;
			box-shadow: 0 4rpx 12rpx rgba(33, 207, 62, 0.3);

			.iconfont {
				font-size: 32rpx;
				margin-right: 8rpx;
			}

			&:active {
				transform: scale(0.95);
				opacity: 0.9;
			}
		}
	}

	&.editing {
		background: #f0f9ff;
		border: 1rpx solid #21cf3e;
	}
}

.empty-state {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 200rpx 0;

	.empty-icon {
		font-size: 200rpx;
		color: #ddd;
		margin-bottom: 30rpx;
	}

	.empty-text {
		font-size: 28rpx;
		color: #999;
	}
}
</style>
