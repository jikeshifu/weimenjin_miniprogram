<template>
	<div class="number-control">
		<div class="reduce" :class="{ active: count > 1 }" @click.stop="handleClickMinus"><i class="iconfont icon-jianshao"></i></div>
		<div class="num"><input v-model="num" @input="input" type="number" :focus="true"></div>

		<div class="add" :class="{ active: count < max }" @click.stop="handleClickPlus"><i class="iconfont icon-zengjia"></i></div>
		<view style="font-size: 30rpx; opacity: 0.6;">可手动输入数量</view>
	</div>
</template>

<script>
export default {
	props: {
		count: {
			type: Number,
			default: 1
		},
		max: {
			type: Number,
			default: 9999
		},
		xgNum: {
			type: Object,
			default: () => {}
		}
	},
	data() {
		return {
			num: 1
		}
	},
	watch:{
		count(val) {
			this.num = val
		}
	},
	methods: {
		handleClickMinus() {
			if (this.count > 1) {
				this.$emit('minus');
			}
		},
		handleClickPlus() {
			if (this.xgNum.assemble) {
				if (this.count >= this.xgNum.assemble.xg_num) {
					uni.showToast({
						title: '超过限购数量',
						icon: 'none'
					})
					return false;
				}
			}
			if (this.count < this.max) {
				this.$emit('plus');
			}
		},
		input(e) {
			this.$emit('onInput', e.detail.value)
		}
	}
};
</script>

<style lang="stylus" scoped>
.number-control
	display flex
	align-items center
	.num
		font-size 32rpx
		font-weight bold
		min-width 60rpx
		text-align center
	.num input
		width 100rpx
		text-align center
	.reduce, .add
		padding 10rpx
	.iconfont
		font-size 48rpx
		color #ccc
	.active .iconfont
		color #409E98
</style>
