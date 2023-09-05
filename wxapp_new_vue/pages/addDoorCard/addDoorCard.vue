<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">持有人：</view>
					<input placeholder="请输入持有人名称" placeholder-class="placeholder" />
				</view>
				<view class="cell-item">
					<view class="label">卡号：</view>
					<input placeholder="请输入密码" type="number" placeholder-class="placeholder" />
				</view>

				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">{{ expirationTime ? expirationTime : '请选择过期时间' }}</view>
				</view>

			</view>
			<view class="bottom-btn">立即提交</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				expirationTime: ''
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad() {

		},
		methods: {
			openTime() {
				this.$refs.datetimePicker.open();
			},
			confirm(e) {
				console.log('confirm', e);
				this.expirationTime = this.formatDate(e.value)
			},
			formatDate(date, fmt = 'yyyy-MM-dd hh:mm:ss') {
				var crtTime;
				if (typeof date === 'number') {
					if ((date + '').length !== 13) {
						crtTime = new Date(date * 1000);
					} else {
						crtTime = new Date(date);
					}
				} else {
					crtTime = new Date(date);
				}
				var o = {
					'M+': crtTime.getMonth() + 1,
					'd+': crtTime.getDate(),
					'h+': crtTime.getHours(),
					'm+': crtTime.getMinutes(),
					's+': crtTime.getSeconds(),
					'q+': Math.floor((crtTime.getMonth() + 3) / 3),
					S: crtTime.getMilliseconds(),
				};
				if (/(y+)/.test(fmt)) {
					fmt = fmt.replace(
						RegExp.$1,
						(crtTime.getFullYear() + '').substr(4 - RegExp.$1.length),
					);
				}
				for (var k in o) {
					if (new RegExp('(' + k + ')').test(fmt)) {
						fmt = fmt.replace(
							RegExp.$1,
							RegExp.$1.length === 1 ?
							o[k] :
							('00' + o[k]).substr(('' + o[k]).length),
						);
					}
				}
				return fmt;
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addDoorCard.scss';
</style>