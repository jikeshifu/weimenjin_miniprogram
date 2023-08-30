<template>
	<view class="car-count">
		<view class="cart-box">
			<uni-swipe-action>
				<uni-swipe-action-item :options="item.options" @click="deleteList(index, item.id)" v-for="(item, index) in carts" :key="item.id">
					<view class="cartList clearfix">
						<view @click="selectList(index)" class="selBtn centerboth">
							<text class="iconfont" :class="item.selected == true ? 'icon-xuanzhong' : 'icon-weixuanzhong'"></text>
						</view>
						<view class="gmes">
							<view class="cartImg centerboth">
								<!-- <image :src="item.sku.thumb | imgPath" v-if="item.sku"></image> -->
								<image :src="item.product.images[0]"></image>
							</view>
							<view class="boxCount clearfix">
								<text class="gname line1">{{ item.product.name }}</text>

								<text class="sku" v-if="item.product_sku.sku_value">[{{ item.product_sku.sku_value }}]</text>
								<view class="flex-box">
									<view class="left-box">
										<view class="gprice">￥{{ item.product_sku.price }}</view>
									</view>


									<view class="countBox centerboth">
										<view class="carSub" @click="changeNum(index, item, 2)">
											<text :class="['iconfont icon-icon_reduc_goods', item.number > 1 ? 'bright-color' : '']"></text>
										</view>
										<view class="cartNum">{{ item.number }}</view>
										<view class="carAdd" @click="changeNum(index, item, 1)">
											<text
												:class="['iconfont icon-icon_add_goods', item.number >= (item.sku ? item.sku.stock : item.product.stock) ? 'prohibition' : '']"
											></text>
										</view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</uni-swipe-action-item>
				<uni-load-more :status="noMoreStatus" empty_text="快去加购商品吧～"></uni-load-more>
			</uni-swipe-action>
		</view>
	
		<view class="botomBtn" v-if="carts.length > 0">
			<view @click="allSelBtn" class="selBtn centerboth">
				<text class="iconfont" :class="selectAll ? 'icon-xuanzhong' : 'icon-weixuanzhong'"></text>
				<text style="margin-left: 16rpx; opacity: 0.6;">全选</text>
			</view>
			<view class="price">
				<view class="fh">
					<text style="font-size: 24rpx; font-weight: bold; color: #000000;">合计：</text>
					<text>￥{{ totalPrice }}</text>
				</view>
			</view>
			<view @click="jiesuan" class="yyBtn">去结算&nbsp;&nbsp;({{ totalNum }})</view>
		</view>
	</view>
</template>
<script>
import { imgPath } from '@/libs/filters.js';
export default {
	props: {
		carts: {
			//提示信息字体颜色
			type: Array,
			default() {
				return [];
			}
		},
		
		noMoreStatus: {
			type: String,
		}
	},
	data() {
		return {
			totalPrice: 0, // 总价，初始为0
			selectAll: false, // 全选状态，默认全选
			startX: 0, //开始坐标
			startY: 0,
			totalNum: 0,
			integral: 0
		};
	},
	filters: {
		imgPath
	},
	mounted() {
		this.allSelBtn();
	},
	watch: {
		carts(val) {
			this.getTotalPrice();
		},
	},
	methods: {
		jiesuan: function() {
			var that = this;
			var idArr = [];
			var carId = that.carts;
			for (var i = 0; i < carId.length; i++) {
				if (carId[i].selected == true) {
					// idArr.push(carId[i].id);
					idArr.push(carId[i]);
				}
			}

			if (idArr.length <= 0) {
				uni.showToast({
					title: '请选择要结算的商品',
					icon: 'none'
				});
				return false;
			}
			// var ids = idArr.toString(',');
			this.$emit('jsBtn', idArr);
		},
		/**
		 * 修改商品数量
		 */
		changeNum: function(index, item, type) {
			console.log(item)
			var that = this;
			var carts = that.carts;
			var number = parseInt(carts[index].number);
			if (type == 2) {
				number = number - 1;
				if (number <= 1) {
					number = 1;
				}
			} else {
				if (number >= item.product_sku.stock) {
					uni.showToast({
						title: '商品库存不足',
						icon: 'none'
					});
					return false;
				}
				number = number + 1;
			}
			carts[index].number = number;
			this.$emit('changeNum', item.id, item.number, carts);
		},
		/**
		 * 删除购物车当前商品
		 */
		deleteList(index, ids) {
			console.log(ids)
			var that = this;
			let carts = that.carts;

			this.$emit('delBtn', carts, ids, index);
		},
		/**
		 * 当前商品选中事件
		 */
		selectList: function(index) {
			var leng = 0;
			var that = this;
			var carts = that.carts;
			var selected = carts[index].selected;
			carts[index].selected = !selected;

			for (var i = 0; i < carts.length; i++) {
				if (carts[i].selected == false) {
					that.selectAll = false;
				}
				if (carts[i].selected == true) {
					leng = leng + 1;
				}
			}
			if (leng == carts.length) {
				that.selectAll = true;
			}
			this.$emit('selThis', carts);
		},
		allSelBtn: function(e) {
			var that = this;
			var selectAll = that.selectAll;
			selectAll = !selectAll;
			var carts = that.carts;

			for (var i = 0; i < carts.length; i++) {
				carts[i].selected = selectAll;
			}
			that.selectAll = selectAll;
			this.$emit('selAllBtn', carts);
		},
		/**
		 * 计算总价
		 */
		getTotalPrice: function() {
			var that = this;
			var carts = that.carts; // 获取购物车列表
			var total = 0;
			var totalnum = 0;
			var integral = 0;
			for (var i = 0; i < carts.length; i++) {
				// 循环列表得到每个数据
				if (carts[i].selected) {
					// 判断选中才会计算价格
					console.log(carts[i])
					if (carts[i].product_sku) {
						carts[i].product.price = carts[i].product_sku.price;
					}
					total += carts[i].number * carts[i].product_sku.price; // 所有价格加起来
					totalnum = totalnum + parseInt(carts[i].number);
				}
			}
			that.totalNum = totalnum;
			that.integral = integral;
			that.totalPrice = total.toFixed(2);

			if (!this.carts.length) {
				this.selectAll = false;
			}
		}
	}
};
</script>

<style scoped lang="scss">
@import './sideslip-car.scss';
</style>
