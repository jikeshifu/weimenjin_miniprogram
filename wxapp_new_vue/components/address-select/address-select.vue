<template>
	<div class="address-container">
		<div class="header border-1px--bottom">
			<span class="title">选择收货地址</span>
		</div>
		<view class="address-list">
			<radio-group>
			<view class="address-item" v-for="(item,index) in data" :key="item.id">
				<div class="checkbox-wrap">
					<label class="radio" ></label><radio :value="toString(item.isChecked)" :checked="item.isChecked" style="transform:scale(0.8)" color="#409E98" @click="change(item,index)"/>
				</div>

				<div class="content">
					<div class="user-row">
						<div class="user__name">{{ item.username }}</div>
						<div class="user__phone">{{ item.phone }}</div>
					</div>
					<div class="address">
						<span class="default-tag" v-if="item.is_default === 2">默认</span>
						{{ item.province + ' ' + item.city + ' ' + item.county + ' ' + item.address }}
					</div>
				</div>
				<div class="hr"></div>
				<i @click.stop="handleJump('edit',index)" class="iconfont icon-bianji"></i>
			</view>
			</radio-group>
		</view>
		<div @click="handleJump('add')" class="footer border-1px--top">
			<i class="iconfont icon-zengjia"></i>
			<span>新增收货地址</span>
		</div>
	</div>
</template>

<script>
export default {
	components: {
	},
	props: {
		data: {
			type: Array,
			default: () => []
		}
	},
	data() {
		return {
			num: 0
		}
	},
	methods: {
		// 跳转修改地址
		handleJump(type,index) {
			if (type === 'edit') {
				let item = JSON.stringify(this.data[index])
				uni.navigateTo({
					url:'../addressEdit/addressEdit?type=' + type + '&item=' + item
				})
			}else{
				uni.navigateTo({
					url:'../addressEdit/addressEdit?type=' + type
				})
			}
			
		},
		change(item,index){
			this.data[index].isChecked = true
			this.$emit('change', item)
		}
	}
};
</script>

<style scoped>
.address-container {
	width: 100%;
	height: 840rpx;
	display: flex;
	flex-direction: column;
	overflow: hidden;
}	
.header {
	height: 88rpx;
	border-bottom: 1px solid #E5E5E5;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 30rpx;
	flex-shrink: 0;
}
.address-list {
	flex: 1;
	overflow-y: scroll;
}
.address-item {
	border-bottom: 1px solid #E5E5E5;
	padding: 20rpx;
	display: flex;
	align-items: center;
	justify-content: space-between;
}	
.iconfont {
	flex-shrink: 0;
}
.hr {
	width: 2px;
	height: 50rpx;
	background: #E5E5E5;
	margin-left: 15rpx;
	margin-right: 40rpx;
	flex-shrink: 0;
}
.checkbox-wrap {
	flex-shrink: 0;
}
.user-row {
	display: flex;
	font-size: 32rpx;
}
.user__name {
	font-weight: bold;
	margin-right: 20rpx;
}
.address {
	font-size: 28rpx;
	color: #666666;
}
.content {
	margin-left: 10rpx;
	flex: 1;
}
.footer {
	height: 88rpx;
	border-top: 1px solid #E5E5E5;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 32rpx;
}
.footer .iconfont {
	margin-right: 10rpx;
	color: #409E98;
	font-size: 40rpx;
}
</style>
