<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<!-- 标签栏切换，用于在联动喇叭和联动空开之间切换 -->
			<view class="tab-bar">
				<view :class="['tab-item', currentTab === 'speaker' ? 'active' : '']" @click="changeTab('speaker')">联动喇叭
				</view>
				<view :class="['tab-item', currentTab === 'switch' ? 'active' : '']" @click="changeTab('switch')">联动空开
				</view>
			</view>

			<!-- 设备列表 -->
			<view class="list">
				<view class="item" v-for="item in dataList" :key="item.id">
					<view class="left-box">
						<view class="user-info">
							<view class="user-name">{{ item.linkspeaker_name || item.linkswitch_name }}</view>
							<view class="phone">序列号：{{ item.linkspeaker_sn || item.linkswitch_sn }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="edit-btn" @click="editItem(item)">编辑</view>
						<view class="delete-btn" @click="deleteItem(item.id)">删除</view>
					</view>
				</view>
				<!-- <uni-load-more :status="noMore" empty_text="无设备数据～" style="padding-top: 40rpx;"></uni-load-more> -->
			</view>
		</view>

		<!-- 添加按钮 -->
		<view class="bottom-btn" @click="addDevice">
			<view class="btn">添加设备</view>
		</view>
	</view>
</template>

<script>
import {
    getlinkSpeakers_api,
    getlinkSwitches_api,
    deletelinkSpeaker_api,  // 删除喇叭设备的API
    deletelinkSwitch_api    // 删除空开设备的API
} from '@/api/index.js'

export default {
    data() {
        return {
            currentTab: 'speaker', // 当前选中的标签
            dataList: [], // 设备列表
            noMore: 'loading', // 数据加载状态
            page: 1,
            lock_id: ''
        }
    },
    onLoad(option) {
        this.lock_id = option.lock_id;
        this.fetchData(); // 初始获取数据
    },
	onShow() {
	    // 检查刷新标记
	    if (uni.getStorageSync('shouldRefreshDeviceList')) {
	      this.page = 1;
	      this.dataList = [];
	      this.fetchData();
	      uni.removeStorageSync('shouldRefreshDeviceList'); // 清除标记
	    }
	  },
    methods: {
        // 切换标签
        changeTab(tab) {
            if (this.currentTab !== tab) {
                this.currentTab = tab;
                this.page = 1;
                this.dataList = [];
                this.fetchData();
            }
        },

        // 获取设备数据（联动喇叭或联动空开）
        async fetchData() {
            const api = this.currentTab === 'speaker' ? getlinkSpeakers_api : getlinkSwitches_api;
            const params = {
                page: this.page,
                limit: 10,
                lock_id: this.lock_id
            };
            try {
                const res = await api(params);
                if (res.code !== 0) throw new Error(res.msg || '请求失败');
                const list = res.data || [];

                if (this.page === 1 && list.length === 0) {
                    this.noMore = 'nodata';
                    return;
                } else if (list.length < 10) {
                    this.noMore = 'noMore';
                } else {
                    this.noMore = 'loading';
                }

                this.dataList = this.dataList.concat(list);
            } catch (error) {
                this.noMore = 'noMore';
                uni.showToast({
                    title: error.message || '加载失败',
                    icon: 'none'
                });
            }
        },

        // 编辑设备
        editItem(item) {
            const url = this.currentTab === 'speaker' ?
                '/pages/addlinkspeaker/addlinkspeaker' :
                '/pages/addlinkswitch/addlinkswitch';
            const sn = this.currentTab === 'speaker' ? item.linkspeaker_sn : item.linkswitch_sn;
            uni.navigateTo({
                url: `${url}?lock_id=${this.lock_id}&sn=${sn}` 
            });
        },

        // 删除设备（分开处理喇叭和空开）
        async deleteItem(id) {
            const api = this.currentTab === 'speaker' ? deletelinkSpeaker_api : deletelinkSwitch_api;
            console.log('Deleting item with ID:', id, 'Using API:', api);  // 添加调试信息
        
            uni.showModal({
                title: '提示',
                content: '确定删除该设备吗?',
                success: async (res) => {
                    if (res.confirm) {
                        try {
                            const result = await api({ id });
                            console.log('API Response:', result);  // 打印 API 响应
        
                            if (result.code === 0) {
                                uni.showToast({
                                    title: '删除成功！',
                                    icon: 'none'
                                });
                                this.page = 1;
                                this.dataList = [];
                                this.fetchData();
                            } else {
                                console.warn('Delete failed with message:', result.msg);
                                uni.showToast({
                                    title: result.msg,
                                    icon: 'none'
                                });
                            }
                        } catch (error) {
                            console.error('Delete request error:', error);  // 捕捉并打印错误
                            uni.showToast({
                                title: '删除失败',
                                icon: 'none'
                            });
                        }
                    }
                }
            });
        },

        // 添加设备
        addDevice() {
            const url = this.currentTab === 'speaker' ?
                '/pages/addlinkspeaker/addlinkspeaker' :
                '/pages/addlinkswitch/addlinkswitch';
            uni.navigateTo({
                url: `${url}?lock_id=${this.lock_id}`
            });
        }
    }
}
</script>

<style scoped lang="scss">
	.big-box {
		.background {
			width: 100%;
			height: 352rpx;
			background: rgb(33, 207, 62);
			opacity: 0.2;
			box-shadow: 0px 8rpx 374rpx rgb(58, 137, 254);
			filter: blur(120rpx);
			position: absolute;
			top: 0;
			left: 0;
		}

		.content {
			position: relative;
			z-index: 10;
			padding-bottom: 120rpx; // 确保列表不会被底部按钮遮挡
		}

		.tab-bar {
			display: flex;
			height: 90rpx;
			justify-content: space-around;
			background-color: #f0f0f0;
			border-bottom: 1px solid #e0e0e0;

			.tab-item {
				flex: 1;
				text-align: center;
				font-size: 30rpx;
				line-height: 90rpx;
				color: #666;

				&.active {
					color: #21CF3E;
					font-weight: bold;
					border-bottom: 4rpx solid #21CF3E;
				}
			}
		}

		.list {
			padding: 20rpx 30rpx;

			.item {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 20rpx;
				margin-bottom: 20rpx;
				background: #fff;
				border-radius: 10rpx;
				box-shadow: 0 2rpx 6rpx rgba(0, 0, 0, 0.1);

				.left-box {
					.user-info {
						.user-name {
							font-size: 28rpx;
							color: #333;
						}

						.phone {
							font-size: 24rpx;
							color: #666;
						}
					}
				}

				.right-box {
					display: flex;

					.edit-btn,
					.delete-btn {
						width: 80rpx;
						height: 40rpx;
						line-height: 40rpx;
						text-align: center;
						border-radius: 5rpx;
						font-size: 24rpx;
						color: #fff;
						margin-left: 10rpx;
					}

					.edit-btn {
						background-color: #21CF3E;
					}

					.delete-btn {
						background-color: #FF0000;
					}
				}
			}
		}
	}

	.bottom-btn {
		position: fixed;
		bottom: 0;
		left: 0;
		width: 100%;
		background: #f7f7fa;
		padding: 20rpx 0;
		z-index: 30;

		.btn {
			margin: 0 30rpx;
			height: 90rpx;
			background: #21CF3E;
			border-radius: 100rpx;
			font-size: 28rpx;
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 4rpx 10rpx rgba(33, 207, 62, 0.3);
		}
	}
</style>