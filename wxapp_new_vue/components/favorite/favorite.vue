<template>
	<view class="big-box">
		<view class="header-box">
			<view class="header-cent">
				<view class="title">{{ type === '1' ? '我的收藏' : '我的足迹' }}</view>
				<view class="operation" @click="operationBtn">{{ operation ? '完成' : '管理' }}</view>
			</view>
		</view>

		<view class="goods-list">
			<uni-swipe-action>
				<block v-for="(item, index) in list" :key="index">
					<uni-swipe-action-item :options="item.options" @click="remove(item.options[0])" class="item-box">
						<view class="item">
							<view class="circleBox" @click.stop="inp(item.options[0].id)" style="padding-left: 30rpx;" v-if="operation">
								<text class="circle iconfont icon-weixuanzhong" v-if="!item.options[0].check"></text>
								<text class="circle iconfont icon-xuanzhong" v-if="item.options[0].check"></text>
							</view>
							<view class="goods-info" @click="onclick(item.options[0])">
								<image class="goods-img" :src="item.options[0].goods.thumb | imgPath"></image>
								<view class="right-box">
									<view class="goods-name">{{ item.options[0].goods.goods_name }}</view>
									<view class="price-time">
										<view class="price">
											¥
											<text style="font-size: 30rpx;">{{ item.options[0].goods.sell_price }}</text>
										</view>
										<view class="time" v-if="item.options[0].type === 2">{{ item.options[0].create_time }}</view>
									</view>
								</view>
							</view>
						</view>
					</uni-swipe-action-item>
				</block>
				<uni-load-more :status="noMore"></uni-load-more>
			</uni-swipe-action>
		</view>

		<!-- 底部结算模块 -->
		<view class="summary" v-if="operation">
			<view class="allBox">
				<view class="">
					<view @click="all()" style="font-size: 32rpx; display: flex; align-items: center;">
						<text class="iconfont icon-xuanzhong" v-if="flag"></text>
						<text class="iconfont icon-weixuanzhong" v-if="!flag"></text>
						<text style="opacity: 0.6;margin-left: 20rpx;">全选</text>
					</view>
				</view>

				<block><view class="remove" @click="removeAll">删除</view></block>
			</view>
		</view>
	</view>
</template>
<script>
import MescrollUni from '@/components/mescroll-uni/mescroll-uni';
import { delShoppingCar_api } from '../../api/goods.js';
import { imgPath } from '@/libs/filters.js';
// hbuilderX新版本不需要引入组件uni-swipe-action，很方便
export default {
	components: {
		MescrollUni
	},
	props: {
		list: Array,
		toast: Boolean,
		noMore: String,
		type: {
			type: String,
			default: '1'
		},
		newflag: false
	},
	filters: {
		imgPath
	},
	watch: {
		newflag(val) {
			this.num = 0
			this.flag = false
		}
	},
	data() {
		return {
			flag: false, //判断是否全选
			money: 0, //总金额
			num: 0, //删除数据后，用来判断是否全选
			upOption: {
				textNoMore: '我是有底线的 >_<'
			},
			goodsList: [],
			page: 1,
			isCheck: false,
			postage_money: 0,
			operation: false
		};
	},
	methods: {
		swipeClick(e, index) {
			this.removeM(e.content.id);
		},
		all(index) {
			//全选
			this.flag = !this.flag;
			if (this.flag) {
				for (var i = 0; i < this.list.length; i++) {
					this.list[i].options[0].check = true;
				}
				this.num = this.list.length;
			} else {
				for (var i = 0; i < this.list.length; i++) {
					this.list[i].options[0].check = false;
				}
				this.num = 0;
				this.money = 0;
			}
			this.$emit('refreshShopCar', this.list);
		},
		inp(index) {
			//商品选择
			this.isCheck = !this.isCheck;
			for (var i = 0; i < this.list.length; i++) {
				var obj = this.list[i].options[0];
				if (obj.id == index) {
					obj.check = !obj.check;
					console.log(this.num)
					if (obj.check == false) {
						//如果有条数据没选择，就取消全选
						this.flag = false;
						this.num -= 1;
					} else {
						this.num += 1;
						if (this.num == this.list.length) {
							//如果全部选中了
							this.flag = true;
						}
					}
				}
			}
			this.$emit('refreshShopCar', this.list);
		},

		async _delShop(id) {
			let params = {
				id: id
			};
			let res = await delShoppingCar_api(params);
		},

		operationBtn() {
			this.operation = !this.operation;
		},

		remove(item) {
			this.num = 0;
			this.flag = false;
			this.$emit('remove', item);
		},

		// 多选删除
		async removeAll() {
			let _this = this;
			uni.showModal({
				title: '',
				content: '确定全部删除吗？',
				confirmText: '确定',
				success: async function(v) {
					if (v.confirm) {
						let idArr = [];
						_this.list.filter(function(item) {
							//结算过虐选中的数据，idArr这个数组就是最后你要提交的数据
							if (item.options[0].check === true) {
								idArr.push(item.options[0].id);
							}
						});
						_this.$emit('removeAll', idArr);
						_this.flag = false;
						_this.num = 0
					}
				}
			});
		},
		onclick(item) {
			uni.navigateTo({
				url: '/pages/goods-details/index?id=' + item.goods.id + '&tip=' + item.goods.tip
			});
		}
	}
};
</script>
<style scoped>
.goods-list {
	margin-top: 100rpx;
	padding-bottom: 80rpx;
}
.list-box {
	width: 100%;
	height: 100%;
	display: flex;
	flex-direction: column;
	overflow: hidden;
}
.item-box {
	margin-top: 16rpx;
	width: 100%;
}
.item {
	width: 100%;
	display: flex !important;
	align-items: center !important;
}
.goods-info {
	display: flex;
	margin: 20rpx 30rpx;
	flex: 1;
}
.goods-img {
	width: 160rpx;
	height: 160rpx;
	flex-shrink: 0;
}
.right-box {
	margin-left: 20rpx;
	display: flex;
	flex-direction: column;
	justify-content: space-between;
	flex: 1;
}
.goods-name {
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	font-size: 28rpx;
}
.price-time {
	display: flex;
	align-items: center;
	justify-content: space-between;
}
.price {
	font-size: 24rpx;
	font-weight: bold;
}
.time {
	font-size: 20rpx;
}
.iconfont {
	font-size: 48rpx;
}
.icon-weixuanzhong {
	color: #cccccc;
}
.icon-xuanzhong {
	color: #df5959;
}
.summary {
	position: fixed;
	bottom: 0;
	left: 0;
	width: 100%;
	background: #ffffff;
}
.allBox {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 30rpx;
	height: 80rpx;
}

.remove {
	font-size: 32rpx;
	color: #df5959;
	border: 1px solid #df5959;
	padding: 0 30rpx;
	border-radius: 30rpx;
}
.header-cent {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 30rpx;
	height: 80rpx;
	background: #ffffff;
}
.title {
	font-weight: bold;
}
.operation {
	font-size: 30rpx;
	color: #df5959;
}
.header-cent {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 30rpx;
	height: 80rpx;
	background: #ffffff;
}
.header-box {
	position: fixed;
	top: 0;
	left: 0;
	z-index: 99;
	width: 100%;
}
.title {
	font-weight: bold;
}
.operation {
	font-size: 30rpx;
}
.remove {
	font-size: 32rpx;
	color: #df5959;
	border: 1px solid #df5959;
	border-radius: 30rpx;
	padding: 0 30rpx;
}
</style>
