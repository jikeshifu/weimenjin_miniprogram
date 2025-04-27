<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view class="search-box">
					<image src="../../static/sousuo.png"></image>
					<input placeholder="请输入关键词" placeholder-class="placeholder" class="search-input"
						confirm-type="search" @confirm="confirm" v-model="search_key" />
				</view>
			</view>
			<view class="list">
				<view class="item" v-for="(item, index) in dataList" :key="index">
					<view class="left-box">
						<image :src="getImgPath(item.face_images)" class="user-img"></image>
						<view class="user-info">
							<view class="user-name">{{ item.face_name }}</view>
							<view class="phone">{{ dynamicText }}ID: {{ item.sCertificateNumber }}</view>
						</view>
					</view>
					<view class="right-box">
						<view class="delete-btn" style="background: #21CF3E;" @click="edit(item)">编辑</view>
						<view class="delete-btn" style="margin-top: 8rpx;" @click="onDelete(item)">删除</view>
					</view>
				</view>
				<uni-load-more :status="noMore" :empty_text="`暂无${dynamicText}～`"></uni-load-more>
			</view>

			<view class="bottom-btn" @click="operation">
				<view class="btn">操作</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { faceList_api, delFace_api, clearFaces_api } from '@/api/index.js'
	import { imgPath } from '@/libs/filters.js'
	export default {
		data() {
			return {
				scrollTop: 0,
				search_key: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				lock_id: '',
				isAdmin: false, // 是否为管理员
				face_text: '图片' // 默认值为 "图片"
			}
		},
		computed: {
			// 动态替换 "人脸" 为 face_text
			dynamicText() {
				return this.face_text;
			}
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop
		},
		onLoad(option) {
			this.lock_id = option.lock_id;
			this.isAdmin = option.auth_isadmin === '1'; // 从参数中判断是否为管理员
			this.face_text = option.face_text || '图片'; // 动态替换 "人脸" 为传入的 face_text 或默认值
			this.page = 1; // 确保从第一页开始加载
			this.dataList = []; // 清空数据列表
			this.getList(); // 调用数据加载方法
		},
		onShow() {
		    this.page = 1;
		    this.dataList = [];
		    this.getList();
		},
		methods: {
			edit(item) {
				uni.navigateTo({
					url: '/pages/addFace/addFace?item=' + encodeURIComponent(JSON.stringify(item))
				})
			},
			getImgPath(url) {
			    return imgPath(url);
			  },
			async onDelete(item) {
				uni.showModal({
					title: '提示',
					content: `确定删除该${this.dynamicText}吗?`,
					success: async (msg) => {
						if (msg.confirm) {
							uni.showLoading({
								title: '删除中...',
								mask: true
							})
							let res = await delFace_api({
								face_id: item.face_id,
								lock_id: item.lock_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: `${this.dynamicText}删除成功！`,
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
					search_key: this.search_key
				};
				let res = await faceList_api(params);
				if (res.data && res.data.length > 0) {
					this.dataList = this.page === 1 ? res.data : this.dataList.concat(res.data);
					this.noMore = res.data.length < 10 ? 'noMore' : 'loading';
				} else {
					this.noMore = this.page === 1 ? 'nodata' : 'noMore';
				}
			},
			confirm(e) {
				this.search_key = e.detail.value
				this.dataList = [];
				this.page = 1;
				this.getList()
			},
			operation() {
				const itemList = [`添加自拍${this.dynamicText}`];
				if (this.isAdmin) {
					itemList.push(`同步${this.dynamicText}`, `清空设备${this.dynamicText}`, `清空云端及设备${this.dynamicText}`);
				}
				uni.showActionSheet({
					itemList,
					success: (res) => {
						if (res.tapIndex === 0) {
							uni.navigateTo({
								url: '/pages/addFace/addFace?lock_id=' + this.lock_id
							})
						} else if (res.tapIndex === 1 && this.isAdmin) {
							uni.navigateTo({
								url: '/pages/synchroData/synchroData?lock_id=' + this.lock_id + '&type=face'
							})
						} else if (res.tapIndex === 2 && this.isAdmin) {
							this.clearFaces('local');
						} else if (res.tapIndex === 3 && this.isAdmin) {
							this.clearFaces('cloud');
						}
					},
				});
			},
			async clearFaces(type) {
				const content = type === 'local'
					? `确定清空设备${this.dynamicText}数据吗？此操作不可恢复！`
					: `确定清空云端及设备所有${this.dynamicText}数据吗？此操作不可恢复！`;

				uni.showModal({
					title: '警告',
					content,
					success: async (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: '清空中...',
								mask: true
							});
							let response = await clearFaces_api({ lock_id: this.lock_id, type });
							uni.hideLoading();
							if (response.code === 0) {
								const message = type === 'local'
									? `设备${this.dynamicText}清空成功！`
									: `云端及设备${this.dynamicText}清空成功！`;
								uni.showToast({
									title: message,
									icon: 'none'
								});
								this.dataList = [];
								this.page = 1;
								this.getList();
							} else {
								uni.showToast({
									title: response.msg,
									icon: 'none'
								});
							}
						}
					}
				});
			}
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++; 
			this.getList();
		},
		async onPullDownRefresh() {
			this.page = 1;
			this.dataList = [];
			await this.getList();
			uni.stopPullDownRefresh();
		}
	}
</script>

<style scoped lang="scss">
	@import './faceList.scss';
</style>
