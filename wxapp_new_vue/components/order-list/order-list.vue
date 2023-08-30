<template name="orderList">
		<view class="list">
			<!-- 一个订单 -->
			<view class="item" v-for="(item, index) in order" :key="item.order_id" >
				<view class="orderNum">订单号: {{ item.order_num }}</view>
				<view class="order_list">
					<!-- 1 -->
					<view class="order_item" data-value="normal" v-for="(order, indexOrder) in item.ordersh">
						<view class="order_info">
							<image :src="order.thumb | imgPath"></image>
							<view class="info">
								<span class="name">{{ order.goods_name }}<span v-if="order.is_gift === 2">（{{ '赠品' }})</span></span>
								<span>数量x{{ order.number }}</span>
								<span>价格:￥{{ order.total_price ? order.total_price : 0 }}</span>
							</view>
						</view>
						<!-- <view class="total-prices">总价：¥{{ Number(order.total_price) - Number(item.postage_money) }}</view> -->
						<view class="dealButton">
							<!-- 付款后即可申请-->
							<view v-if="order.is_gift !== 2">
								<view v-if="order.status === 2 || order.status === 3" style="width: 100%;" class="applyBtn">
									<button class="changeP" @click="applyFunc('exchange',index,indexOrder)">申请换货</button>
									<button class="returnP" @click="applyFunc('refound',index,indexOrder)">申请退款</button>
								</view>
							</view>
							
							<!-- 已完成订单 -->
							<!-- <view class="returning_process" v-if="order.refund">
								<view class="answer" v-if="order.showDetail">
									<view :class="['answer_content',order.showDetail ? 'answer_content':'folder' ]" >
										<view>商家回复：正在处理的哟~~请耐心等待~~ 正在处理的哟~~请耐心等待~~</view>
										<view>商家回复：正在处理的哟~~请耐心等待~~ 正在处理的哟~~请耐心等待~~</view>
										<view>商家回复：正在处理的哟~~请耐心等待~~ 正在处理的哟~~请耐心等待~~</view>
										
									</view>
									<view class="fold" @click="showDetailFun(index,indexOrder)">
										收起
										<i class="iconfont icon-xiaojiantou"></i>
									</view>
								</view>
								<view class="answer" v-else>
									<view :class="['answer_content',order.showDetail ? 'answer_content' : 'detail-folder' ]" >
										<text>商家回复：正在处理的哟~~请耐心等待~~ 正在处理的哟~~请耐心等待~~</text>										
									</view>
									<span class="detail" @click="showDetailFun(index,indexOrder)" >
										详情
										<i class="iconfont icon-xiaojiantou"></i>
									</span>
								</view>
								
							</view> -->
							<!-- 已经退款的详情 -->
							<view class="_returned" v-if="order.status === 6 || order.status === 8">
								<view class="" style="width: 100%;display: flex;justify-content: flex-end;align-items: center;">
									<button class="returned" v-if="order.status === 6">已退款</button>
									<button class="returned" v-if="order.status === 8">已换货</button>
									<!-- <span class="detail"  v-if="order.showDetail" @click="showDetailFun(index,indexOrder)">
										收起
										<i class="iconfont icon-xiaojiantou" style="transform: rotate(-90deg);"></i>
									</span>
									<span class="detail" v-else @click="showDetailFun(index,indexOrder)">
										详情
										<i class="iconfont icon-xiaojiantou"></i>
									</span> -->
									
								</view>
							</view>
							<view class="apply-box">
								<button class="returning apply" v-if="order.status === 5" >正在申请退款</button>
								<button class="returning apply" v-if="order.status === 7" >正在申请换货</button>
							</view>
						</view>
						<!-- 换货和退款中的商家回复详情 -->
						<view class="returning_process" v-if="order.status === 5 || order.status === 7" :key="order.showDetail">
							<view class="answer">
								<block v-if="order.change">
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.change.desc && !order.showDetail">申请理由：{{ order.change.desc }}</view>
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.change.desc  && order.showDetail">申请理由：{{ order.change.desc }}</view>
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.change.reply && order.showDetail">商家回复：{{ order.change.reply }}</view>
								</block>
								
								<block v-if="order.refund">
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.refund.desc && !order.showDetail">申请理由：{{ order.refund.desc }}</view>
					
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.refund.desc && order.showDetail">申请理由：{{ order.refund.desc }}</view>
									<view :class="['answer_content',order.showDetail?'answer_content':'folder' ]" v-if="order.refund.reply && order.showDetail">商家回复：{{ order.refund.reply }}</view>
									
								</block>
								
								<view class="fold" @click="showDetailFun(index,indexOrder)" v-if="order.showDetail">
									收起
									<i class="iconfont icon-xiaojiantou-copy"></i>
								</view>
							</view>
							<span class="detail"  v-if="!order.showDetail" @click="showDetailFun(index,indexOrder)" >
								详情
								<i class="iconfont icon-xiaojiantou"></i>
							</span>
						</view>
					</view>
				</view>
			</view>
			
			<view class="toast" v-if="toast">
				<view class="toast_content">
					<view class="title">
						<span class="title_name">申请{{toastType}}</span>
						<span class="title_cancel" @click="cancel">取消</span>
					</view>
					<view class="productInfo">
						<image :src="orderInfo.thumb | imgPath"></image>
						<view class="info_txt">
							<span class="name_number">{{orderInfo.goods_name}}x{{orderInfo.number}}</span>
							<span class="price">价值:￥{{orderInfo.total_price}}</span>
						</view>
					</view>
					<view class="inputReason">
						<textarea class="input" :placeholder=" '请输入'+ toastType +'理由'" maxlength=200 @input="limitInput"></textarea>
						<span class="limit">{{inputNumber}}/200</span>
					</view>
					<view class="submit" @click="apply">申请</view>
				</view>
			</view>
		</view>
</template>

<script>
	import { imgPath } from "@/libs/filters.js"
	import { saleApply_api } from '@/api/goods.js'
	export default {
		props: {
			order: Array,
			isShowToast: Boolean,
		},
		data() {
			return {
				toast: false,
				toastType: '',
				orderInfo: {},
				inputNumber: 0,
				appltType: 0,
			}
		},
		filters: {
			imgPath
		},
		watch: {
			isShowToast(val) {
				this.toast = val
			}
		},
		onLoad() {
		},
		methods: {
			//订单类型  1 待付款 2待发货 3 待收货  4已完成 5退款中 6已退款 7换货中 8已换货 
			showDetailFun(index, orderIndex) {
				var showDetail = this.order[index].ordersh[orderIndex].showDetail;
				this.order[index].ordersh[orderIndex].showDetail = !showDetail;
			},
			applyFunc(val, index, orderIndex) {
				if (val === 'exchange') {
					this.toastType = '换货';
					this.appltType = 2
				} else {
					this.toastType = '退款';
					this.appltType = 1
				}
				this.toast = true;
				this.isShowToast = true
				this.orderInfo = this.order[index].ordersh[orderIndex];
			},
			cancel() {
				this.toast = false;
				this.isShowToast = false
			},
			//限制输入字数
			limitInput(e) {
				this.orderInfo.reason = e.detail.value;
				this.inputNumber = e.detail.cursor;
			},
			apply() {
				if(!this.orderInfo.reason) {
					uni.showToast({
						title: '申请理由不能为空',
						icon: 'none'
					})
					return false;
				}
				let params = {
					type: this.appltType,
					suborder_id: this.orderInfo.id,
					order_id: this.orderInfo.order_id,
					desc: this.orderInfo.reason
				}
				this.$emit('onapply', params)		
			}
		}
	}
</script>

<style>
@import url("order-list.css");
</style>
