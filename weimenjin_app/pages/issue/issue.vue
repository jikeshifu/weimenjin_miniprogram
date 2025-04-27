<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">卡号（IC卡UID）</view>
					<view class="text">{{ info.lockcard_sn }}</view>
				</view>
				<view class="cell-item">
					<view class="label">持有人：</view>
					<view class="text">{{ info.lockcard_username }}</view>
				</view>

				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">{{ formatDate(info.lockcard_endtime) }}</view>
				</view>
				
				<view class="cell-item">
					<view class="label">备注：</view>
					<view class="text" v-if="info.lockcard_remark"> {{ info.lockcard_remark }} </view>
				</view>
				
				<view class="list">
					<checkbox-group @change="checkboxItem">
						<view class="item" v-for="(item, index) in dataList" :key="index">
							<view class="text">{{ item.lock_name }}</view>
							
							<label>
								<checkbox :value="item.lock_id.toString()" color="#21CF3E" style="transform:scale(0.8)" />
							</label>
						</view>
					</checkbox-group>
				</view>

			</view>
		</view>
		<view class="bottom-btn" @click="onSubmit">立即提交</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	import { listCard_api, sendCard_api } from '@/api/index.js';
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				dataList: [],
				info: {},
				lock_ids: []
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.info = JSON.parse(decodeURIComponent(option.item));
			this.getList()
		},
		methods: {
			async getList() {
				let res = await listCard_api()
				this.dataList = res.data
			},
			async onSubmit() {
				if (!this.lock_ids.length) {
					this.showToast('请选择至少一个设备')
					return
				}
				uni.showLoading({
					title: "发卡中",
			icon: 'loading'
				})
				let res = await sendCard_api({ lock_ids: this.lock_ids, lockcard_id: this.info.lockcard_id })
				uni.hideLoading()
				if (res.code === 0) {
					this.showToast(res.msg)
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta: 1
						})
						clearTimeout(timer)
					}, 1500)
				} else {
					this.showToast(res.msg)
				}
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'none'
				})
			},
			checkboxItem(e) {
				this.lock_ids = e.detail.value
			},
			openTime() {
				this.$refs.datetimePicker.open();
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
	@import './issue.scss';
</style>