<template name="orderList">
	<view class="list">
		<!-- 一个订单 -->
		<view class="item" v-for="(item, index) in order" :key="index">
			<view class="orderNum">
				<text>订单号: {{ item.order_num }}</text>
				<text>
					{{
						item.status === 1
							? '待付款'
							: item.status === 2
							? '待发货'
							: item.status === 3
							? '待收货'
							: item.status === 4
							? '已完成'
							: item.status === 5
							? '退款申请中'
							: item.status === 6
							? '已退款'
							: item.status === 7
							? '换货申请中'
							: item.status === 8
							? '已换货'
							: ''
					}}
				</text>
			</view>
			<view class="order_list">
				<!-- 1 -->
				<view class="order_item" data-value="normal" v-for="(order, indexOrder) in item.order" :key="indexOrder">
					<view class="order_info">
						<view style="display: flex; flex: 1;">
							<image :src="order.thumb | imgPath" @click="goDetails(item, order)"></image>
							<view class="info">
								<span class="name">{{ order.goods_name }}<span v-if="order.is_gift === 2">（{{ '赠品' }})</span></span>
								<span>数量x{{ order.number }}<span v-if="!order.stock && order.is_gift !== 2" style="font-size: 22rpx; margin: 10rpx 10rpx; color: rgb(223, 89, 89);">(库存不足)</span></span>
								
								<span>小计: ￥{{ order.total_price ? order.total_price : 0 }}</span>
							</view>
						</view>

						<navigator
							:url="
								'../../pages/order_comments/order_comments?goods_name=' +
									order.goods_name +
									'&number=' +
									order.number +
									'&sell_price=' +
									order.total_price +
									'&order_id=' +
									order.order_id +
									'&suborder_id=' +
									order.id +
									'&goods_id=' +
									order.goods_id +
									'&thumb=' +
									order.thumb
							"
							class="opt-btn"
							hover-class="none"
						>
						<view v-if="order.is_gift !== 2">
							<button
								type="default"
								v-if="order.status === 4 && !order.comment"
								style="background: rgba(64, 158, 152, 1);color: #FFFFFF; flex: 1; margin-left: 30rpx;"
							>
								{{ order.comment ? '已评价' : '去评价' }}
							</button>
						</view>
							
							
						</navigator>
						<view v-if="order.is_gift !== 2">
							<view style="display: flex;">
								<button type="default" v-if="order.status === 4 && order.comment" style="color: #CCCCCC; flex: 1; margin-left: 30rpx; border: 1px solid #CCCCCC;">
									{{ order.comment ? '已评价' : '去评价' }}
								</button>
							</view>
						</view>
						
					</view>
					<view style="display: flex; align-items: flex-end; flex-direction: column;">
						<view v-if="order.is_gift !== 2">
							<button class="changeP" v-if="item.status === 3 || item.status === 4" @click="logistics(order)">查看物流</button>
						</view>
					</view>
				</view>
				<view class="dealButton">
					<view class="_returned" style="width: 100%;display: flex;align-items: center;">
						
						<view class="price_shop" :style="item.status === 2 ? 'width:100%' : ''">
							总计：<text style="font-size: 32rpx;">￥{{ item.total_price }}</text>
						</view>
						
						<view class="btn" v-if="item.status === 1 || item.status === 202">
						
							<view @click="cancelOrder(item)" class="cell-btn close">取消</view>
							<view @click="openPop(item)" class="cell-btn">去付款</view>
							
						</view>
						<!-- 已发货 -->
						<!-- 已完成 -->
						<view style="display: flex; align-items: center;" v-if="item.status === 3">
							<button class="changeP after-sale" @click="afterSale">退款换货</button>
							<button class="returnP" @click="gather(item.id)">确认收货</button>
						</view>
						<!-- <view style="display: flex; align-items: center;" v-if="item.status === 4">
							<button class="changeP after-sale" @click="remove(item.id)">删除订单</button>
						</view> -->
					</view>
				</view>
				
				<!-- 换货和退款中的商家回复详情 -->
				<view class="returning_process">
					<view class="answer">
						<view :class="['answer_content', item.showDetail == showDetail ? 'answer_content' : 'folder']">
							<view style="padding: 0 1%;" v-if="!item.showDetail">收货人: {{ item.addr.username }}</view>
							<view class="orderDetail" v-else>
								<view style="padding: 0 1%;">收货人: {{ item.addr.username }}</view>
								<text>联系方式: {{ item.addr.phone }}</text>
								<text>配送地址: {{ item.addr.province + item.addr.city + item.addr.county + item.addr.address }}</text>
								<text>下单时间: {{ item.create_time }}</text>
								<text v-if="item.status === 3 && item.update_time">发货时间: {{ item.update_time}}</text>

								<text v-if="item.status === 4 && item.receipt_time">收货时间: {{ item.receipt_time }}</text>
							</view>
						</view>
						<view class="fold" @click="showDetailFun(index)" v-if="item.showDetail">
							收起
							<i class="iconfont icon-xiaojiantou"></i>
						</view>
					</view>
					<span class="detail" v-if="!item.showDetail" @click="showDetailFun(index)">
						详情
						<i class="iconfont icon-xiaojiantou"></i>
					</span>
				</view>
			</view>
		</view>
		<!-- <uni-load-more :status="noMore"></uni-load-more> -->
		<uni-popup ref="popup" type="bottom">
			<view class="coupon-box">
				<view class="text">您当前需要支付￥{{ goodsInfo.total_price }}</view>
				<view class="pay_type" v-for="(item, index) in pay_type" :key="index" @click="onPay(item)">{{ item.name }}</view>
			</view>
			<view class="cancel" @click="onCancel">取消</view>
		</uni-popup>
	</view>
</template>

<script>
import couponList from '@/components/coupon-list/index.vue';
import { imgPath } from '@/libs/filters.js';
export default {
	components: {},
	props: {
		order: Array,
		status: 0,
		noMore: {
			type: String,
			default: 'loading'
		}
	},
	data() {
		return {
			toast: false,
			toastType: '',
			orderInfo: {},
			inputNumber: 0,
			pay_type: [
				{
					name: '微信支付',
					type: 3
				},
			],
			showDetail: false,
			idx: '',
			goodsInfo: {}
		};
	},
	filters: {
		imgPath
	},
	created() {},
	watch: {
		noMore(val) {
		}
	},
	methods: {
		//订单类型  1 待付款 2待发货 3 待收货  4已完成 5退款中 6已退款 7换货中 8已换货
		showDetailFun(index, orderIndex) {
			var showDetail = this.order[index].showDetail;
			this.order[index].showDetail = !showDetail;
			this.showDetail = !showDetail;
		},
		openPop(item) {
			this.goodsInfo = item;
			this.$refs.popup.open();
		},
		logistics(data) {
			uni.navigateTo({
				url: '/pages/logistics/logistics?order_sn=' + data.order_sn + '&goods_name=' + data.goods_name
			});
		},
		gather(id) {
			this.$emit('gather', id);
		},
		onCancel() {
			this.$refs.popup.close();
		},
		onPay(item) {
			let lag = true;
			this.goodsInfo.order.forEach(v => {
				if (!v.stock) {
					uni.showToast({
						title: '商品库存不足~',
						icon: 'none'
					})
					lag = false;
					return false;
				}
				return false;
			})
			if (!lag) return false;
			let params = {
				order_id: this.goodsInfo.id,
				pay_type: item.type
			};
			let temp = {
				yu_status: this.goodsInfo.yu_status,
				tip: this.goodsInfo.tip
			}
			this.$emit('handlePayment', params, temp);
		},
		cancelOrder(item) {
			this.$emit('cancelOrder', item.id);
		},
		goDetails(item, order) {
			uni.navigateTo({
				url: '/pages/goods-details/index?id=' + order.goods.id + '&tip=' + 1
			})
			
		},
		afterSale(){
			uni.navigateTo({
				url: '/pages/after-sale/after-sale'
			})
		},
		remove(id) {
			this.$emit('remove', id)
		}
	}
};
</script>

<style>
@import url('orderList.css');
</style>
