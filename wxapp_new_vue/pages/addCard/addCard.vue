<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">持有人：</view>
					<input placeholder="请输入持有人名称" placeholder-class="placeholder"
						v-model="formData.lockcard_username" />
				</view>
			
				<view class="cell-item">
					<view class="flex-box">
						<view class="label">卡号：</view>
						<input placeholder="请输入卡号" placeholder-class="placeholder" v-model="formData.lockcard_sn" />
					</view>
					<image src="../../static/saomiao.png" @click="scanCode"></image>
				</view>

				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">
						{{ formData.lockcard_endtime ? formatDate(formData.lockcard_endtime) : '请选择过期时间' }}</view>
				</view>

				<view class="cell-item">
					<view class="label">备注：</view>
					<input placeholder="请输入备注" placeholder-class="placeholder" v-model="formData.lockcard_remark" />
				</view>

			</view>
			<view class="bottom-btn" @click="onSubmit">立即提交</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	import {
		addCard_api,
		editCard_api
	} from '@/api/index.js'
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				formData: {
					lock_id: '',
					lockcard_username: '',
					lockcard_sn: '',
					lockcard_endtime: '',
					lockcard_remark: ''
				},
				verifyData: {
					lock_id: '缺少锁ID',
					lockcard_username: '请输入持有人名称',
					lockcard_sn: '请输入卡号',
					// lockcard_endtime: '请选择过期时间',

				},
				isEdit: false
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.formData.lock_id = option.lock_id
			if (option.item) {
				this.isEdit = true
				let item = JSON.parse(decodeURIComponent(option.item));
				this.formData = {
					lock_id: item.lock_id,
					lockcard_username: item.lockcard_username,
					lockcard_sn: item.lockcard_sn,
					lockcard_endtime: item.lockcard_endtime,
					lockcard_remark: item.lockcard_remark,
					lockcard_id: item.lockcard_id
				}
			}
		},
		methods: {
			async onSubmit() {
				for (let key in this.formData) {
					if (!this.formData[key]) {
						if (this.verifyData[key]) {
							this.showToast(this.verifyData[key]);
							return false;
						}
					}
				}
				uni.showLoading({
					title: '提交中...',
					mask: true
				})
				let res;
				if (!this.isEdit) {
					res = await addCard_api(this.formData)
				} else {
					res = await editCard_api(this.formData)
				}
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('操作成功!')
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta: 1
						})
						clearTimeout(timer)
					}, 1000)
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			openTime() {
				this.$refs.datetimePicker.open();
			},
			confirm(e) {
				this.formData.lockcard_endtime = Math.trunc(e.value / 1000)
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
			scanCode() {
				uni.scanCode({
					success: (res) => {
						this.formData.lockcard_sn = res.result
					}
				});
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none',
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addCard.scss';
</style>