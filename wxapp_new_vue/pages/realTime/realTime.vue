<template>
	<view class="big-box">
		<!-- <view class="background"></view> -->
		<view class="content">
			<view class="cell-item">
				<view class="label">网络标识</view>
				<view class="value" v-if="info.iccid">{{ info.iccid }}</view>
			</view>
			<view class="cell-item">
				<view class="label">设备标识</view>
				<view class="value" v-if="info.imei">{{ info.imei }}</view>
			</view>
			<view class="cell-item">
				<view class="label">总用电量（单位：kw*h）</view>
				<view class="value" v-if="info.total_electricity">{{ info.total_electricity }}</view>
			</view>
			<view class="cell-item">
				<view class="label">当前电压（单位：V）</view>
				<view class="value" v-if="info.voltage">{{ info.voltage }}</view>
			</view>
			<view class="cell-item">
				<view class="label">当前电流（单位：A）</view>
				<view class="value" v-if="info.electric_current">{{ info.electric_current }}</view>
			</view>
			<view class="cell-item">
				<view class="label">通断状态</view>
				<view class="value" v-if="info.switch_state">{{ info.switch_state }}</view>
			</view>
			<view class="cell-item">
				<view class="label">当前功率（单位：W）</view>
				<view class="value" v-if="info.power">{{ info.power }}</view>
			</view>
			<view class="cell-item">
				<view class="label">网络信号</view>
				<view class="value" v-if="info.rssi">{{ info.rssi }}</view>
			</view>
			<view class="cell-item">
				<view class="label">剩余可用电量（0为不限制）</view>
				<view class="value" v-if="info.balance">{{ info.balance }}</view>
			</view>
			<view class="cell-item">
				<view class="label">固件版本</view>
				<view class="value" v-if="info.version">{{ info.version }}</view>
			</view>
		</view>
	</view>
</template>

<script>
import { realTime_api } from '@/api/index.js';
export default {
	data() {
		return {
			lock_id: '',
			info: {}
		}
	},
	onLoad(option) {
		this.lock_id = option.lock_id;
		this.getdata()
	},
	methods: {
		async getdata() {
			let res = await realTime_api({ lock_id: this.lock_id })
			if (res.code === 0) {
				this.info = res.data
			}
		}
	}
}	
</script>

<style scoped lang="scss">
@import './realTime.scss';	
</style>