<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">拥有人</view>
					<view class="value">{{ formData.nickname }}</view>
				</view>

				<view class="cell-item">
					<view class="label">联系电话</view>
					<view class="value">{{ formData.mobile }}</view>
				</view>

				<view class="cell-item" @click="openTime('startTime')">
					<view class="label">开始时间：</view>
					<view class="flex-box">
						<view class="text">{{ formData.auth_starttime ? formatDate(formData.auth_starttime) : '' }}
						</view>
						<image src="../../static/jiantouyou.png"></image>
					</view>
				</view>

				<view class="cell-item" @click="openTime('endTime')">
					<view class="label">过期时间：</view>
					<view class="flex-box">
						<view class="text">{{ formData.auth_endtime ? formatDate(formData.auth_endtime) : '' }}</view>
						<image src="../../static/jiantouyou.png"></image>
					</view>
				</view>

				<view class="cell-item">
					<view class="label">分享权限：</view>
					<switch color="#21CF3E" :checked="formData.auth_shareability ? true : false"
						style="transform:scale(0.7)" @change="changeShareability" />
				</view>
				<view class="cell-item">
					<view class="label">管理人员：</view>
					<switch color="#21CF3E" :checked="formData.auth_isadmin ? true : false" style="transform:scale(0.7)" @change="changeAdmin" />
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
					<view class="label">通过审核：</view>
					<switch color="#21CF3E" :checked="formData.auth_status ? true : false" style="transform:scale(0.7)"
						@change="changeStatus" />
				</view>

				<view class="cell-item">
					<view class="label">备注</view>
					<input placeholder="请输入备注" placeholder-class="placeholder" v-model="formData.aremark" />
				</view>

			</view>
			<view class="bottom">
				<view class="btn" @click="onEdit">提交</view>
				<view class="btn delete" @click="onDelete">删除</view>
			</view>
		</view>

		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	import {
		lockAuthInfo_api,
		editLockAuth_api,
		delDevice_api
	} from '@/api/index.js';
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				startTime: '',
				endTime: '',
				timeType: '',
				lockauth_id: '',
				formData: {},
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.lockauth_id = option.lockauth_id
			this.getInfo()
		},
		methods: {
			async getInfo() {
				let res = await lockAuthInfo_api({
					lockauth_id: this.lockauth_id
				})
				if (res.code === 0) {
					this.formData = res.data
					this.formData.auth_sharelimit = this.formData.auth_sharelimit ? this.formData.auth_sharelimit : 0
					// this.formData.auth_openlimit = this.formData.auth_openlimit ? this.formData.auth_openlimit : 100
				} else {
					this.showToast(res.msg)
				}
			},
			async onEdit() {
				uni.showLoading({
					title: '提交中...',
					mask: true
				})
				let res = await editLockAuth_api(this.formData)
				if (res.code === 0) {
					this.showToast('操作成功')
					
					
						setTimeout(function(){
							uni.navigateBack({
								delta: 1
							});
						},1500)
					// this.getInfo()
				} else {
					this.showToast(res.msg)
				}
			},
			onDelete() {
				uni.showModal({
					title: '提示',
					content: '确定删除？',
					success: async (msg) => {
						if (msg.confirm) {
							let res = await delDevice_api({
								lockauth_id: this.lockauth_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功',
									icon: 'none',
									mask: true
								})
								let timer = setTimeout(() => {
									uni.navigateBack({
										delta:1
									})
								}, 1000)
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none',
								})
							}
				
						}
					}
				})
			},
			changeShareability(e) {
				if (e.detail.value) {
					this.formData.auth_shareability = 1
				} else {
					this.formData.auth_shareability = 0
				}
			},
			changeStatus(e) {
				if (e.detail.value) {
					this.formData.auth_status = 1
				} else {
					this.formData.auth_status = 0
				}
			},
			changeAdmin(e) {
				if (e.detail.value) {
					this.formData.auth_isadmin = 1
				} else {
					this.formData.auth_isadmin = 0
				}
			},
			openTime(type) {
				this.$refs.datetimePicker.open();
				this.timeType = type
			},
			confirm(e) {
				if (this.timeType === 'startTime') {
					this.formData.auth_starttime = Math.trunc(e.value / 1000)
				} else {
					this.formData.auth_endtime = Math.trunc(e.value / 1000)
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
					icon: 'none',
					mask:true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './keyDetail.scss';
</style>