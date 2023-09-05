<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">持有人：</view>
					<input placeholder="请输入持有人名称" placeholder-class="placeholder" v-model="finger_name" />
				</view>

				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">{{ end_time ? end_time : '请选择过期时间' }}</view>
				</view>

			</view>
			<view class="bottom-btn" @click="submit" v-if="!finger_id">立即提交</view>
			<view class="bottom-btn" @click="change" v-else>立即修改</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import { addFinger_api, editFinger_api } from '../../api/index.js'
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				end_time: '',
				lock_id: '',
				finger_name: '',
				finger_id: ''
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.lock_id = option.lock_id ? option.lock_id : ''
			this.finger_id = option.finger_id ? option.finger_id : ''
			this.finger_name = option.finger_name ? option.finger_name : ''
			this.end_time = option.end_time ? this.formatDate(Number(option.end_time)) : ''
		},
		methods: {
			async submit() {
				if (!this.finger_name) {
					this.showToast('请输入持有人名称')
					return
				}
				if (!this.end_time) {
					this.showToast('请选择过期时间')
					return
				}
				uni.showLoading({
					title: '加载中...',
					mask:true
				})
				let res = await addFinger_api({ lock_id: this.lock_id, finger_name: this.finger_name, end_time: this.end_time })
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('添加成功!')
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta:1
						})
						clearTimeout(timer)
					}, 1000)
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			async change() {
				if (!this.finger_name) {
					this.showToast('请输入持有人名称')
					return
				}
				if (!this.end_time) {
					this.showToast('请选择过期时间')
					return
				}
				let res = await editFinger_api({ lock_id: this.lock_id, finger_id: this.finger_id, finger_name: this.finger_name, end_time: this.end_time })
				if (res.code === 0) {
					this.showToast('修改成功!')
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta:1
						})
						clearTimeout(timer)
					}, 1000)
				} else {
					this.showToast(res.msg)
				}
			},
			openTime() {
				this.$refs.datetimePicker.open();
			},
			confirm(e) {
				this.end_time = this.formatDate(e.value)
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
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon:'none',
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addFingerprint.scss';
</style>