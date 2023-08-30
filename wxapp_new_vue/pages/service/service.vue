<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<navigator url="/pages/webview/webview"class="cell-box">
				<i class="iconfont icon-bangzhu"></i>
				<view class="text">使用帮助</view>
			</navigator>
		</view>
	
	</view>
</template>

<script>
	import device from '../../module/device/index.js'
		import ble from '../../module/ble/index.js'
export default {
	data() {
		return {
		}
	},
	onShow(){
	
	}
	,
	methods: {

		}
}	
</script>

<style lang="scss" scoped>
@import './service.scss';	
</style>