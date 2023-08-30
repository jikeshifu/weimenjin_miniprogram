<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">

				<view class="cell-item" @click="openTime('startTime')">
					<view class="label">开始时间：</view>
					<view class="flex-box">
						<view class="text">{{ formData.startTime ? formatDate(formData.startTime) : ''  }}</view>
						<image src="../../static/jiantouyou.png"></image>
					</view>
				</view>

				<view class="cell-item" @click="openTime('endTime')">
					<view class="label">结束时间：</view>
					<view class="flex-box">
						<view class="text">{{ formData.endTime ? formatDate(formData.endTime) : '' }}</view>
						<image src="../../static/jiantouyou.png"></image>
					</view>
				</view>

				<view class="cell-item">
					<view class="label">可分享数</view>
					<input placeholder="请输入可分享数" type="number" placeholder-class="placeholder"
						v-model="formData.auth_sharelimit" />
				</view>

				<view class="cell-item">
					<view class="label">可开次数</view>
					<input placeholder="请输入可开次数" type="number" placeholder-class="placeholder"
						v-model="formData.auth_openlimit" />
				</view>

				<view class="cell-item">
					<view class="label">分享权限：</view>
					<switch color="#21CF3E" style="transform:scale(0.7)" @change="changeAllow" />
				</view>

				<view class="cell-item">
					<view class="label">审核状态：</view>
					<switch checked color="#21CF3E" style="transform:scale(0.7)" @change="changeStatus" />
				</view>

				<view class="cell-item">
					<view class="label">备注</view>
					<input placeholder="请输入备注" placeholder-class="placeholder" v-model="formData.remark" />
				</view>

			</view>
			<view class="bottom">
				<view class="btn" v-if="!share_lockauth_id" @click="create">生成钥匙</view>
				<button class="share-btn" hover-class="none" open-type="share" v-else>
					<view class="btn">立即分享</view>
				</button>
			</view>
		</view>

		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	import { shareAuth_api } from '../../api/index.js'
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				timeType: '',
				share_lockauth_id: '',
				formData: {
					startTime: '',
					endTime: '',
					lockauth_id: '',
					auth_sharelimit: '0',
					auth_openlimit: '0',
					auth_shareability: '0',
					auth_status: '1',
					remark: ''
				},
				verifyData: {
					// startTime: '请选择开始时间',
					// endTime: '请选择结束时间',
					lockauth_id: '缺少钥匙ID',
					auth_sharelimit: '请输入可分享数',
					auth_openlimit: '请输入开门次数',
				}
			}
		},
		onLoad(option) {
			// let now = new Date()
			// this.formData.startTime = Date.parse(now) / 1000 //当前时间
			
			// // 一年后的时间
			// let year = now.getFullYear() + 1;
			// let month = (now.getMonth() + 1).toString().padStart(2, "0"); //得到月份
			// let day = (now.getDate()).toString().padStart(2, "0"); //得到日期
			// let hours = now.getHours().toString().padStart(2, "0") // 得到小时;
			// let minutes = now.getMinutes().toString().padStart(2, "0") // 得到分钟;
			// let seconds = now.getSeconds().toString().padStart(2, "0") // 得到秒;
			// let endTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`
			// this.formData.endTime = Date.parse(endTime) / 1000

			this.formData.lockauth_id = option.lockauth_id ? option.lockauth_id : ''
			
		},
		onShareAppMessage(res) {
			return {
				title: '点击领取钥匙',
				path: '/pages/getLock/getLock?share_lockauth_id=' + this.share_lockauth_id,
			}
		},
		methods: {
			async create() {
				for (let key in this.formData) {
					if (!this.formData[key]) {
						if (this.verifyData[key]) {
							this.showToast(this.verifyData[key]);
							return false;
						}
					}
				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await shareAuth_api(this.formData) 
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('生成钥匙成功!')
					this.share_lockauth_id = res.data.share_lockauth_id
				} else {
					uni.hideLoading()
					this.showToast(res.msg)
				}
			},
			changeAllow(e) {
				if (e.detail.value) {
					this.formData.auth_shareability = '1'
				} else {
					this.formData.auth_shareability = '0'
				}
			},
			changeStatus(e) {
				if (e.detail.value) {
					this.formData.auth_status = '1'
				} else {
					this.formData.auth_status = '0'
				}
			},
			openTime(type) {
				this.$refs.datetimePicker.open();
				this.timeType = type
			},
			confirm(e) {
				if (this.timeType === 'startTime') {
					this.formData.startTime = Math.trunc(e.value / 1000)
				} else {
					this.formData.endTime = Math.trunc(e.value / 1000)
				}
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
					icon: 'none'
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './share.scss';
</style>