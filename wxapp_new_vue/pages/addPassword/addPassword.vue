<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				<view class="cell-item">
					<view class="label">持有人：</view>
					<input placeholder="请输入持有人名称" placeholder-class="placeholder" v-model="pwd_name" :focus="focusLink === 'pwd_name'" @focus="focusClick('pwd_name')" />
				</view>
				<view class="cell-item">
					<view class="label">密码：</view>
					<input placeholder="请输入密码" password placeholder-class="placeholder" v-model="pwd" :focus="focusLink === 'pwd'" @focus="focusClick('pwd')"/>
				</view>

				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">{{ end_time ? formatDate(end_time) : '请选择过期时间' }}</view>
				</view>

			</view>
			<view class="bottom-btn" @click="submit">立即提交</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	import {
		addPwd_api,
		delPwd_api
	} from '@/api/index.js';
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				pwd: '',
				pwd_name: '',
				end_time: '',
				lock_id: '',
				focusLink: ''
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			this.lock_id = option.lock_id
			let now = new Date()
			// 一年后的时间
			let year = now.getFullYear() + 1;
			let month = (now.getMonth() + 1).toString().padStart(2, "0"); //得到月份
			let day = (now.getDate()).toString().padStart(2, "0"); //得到日期
			let hours = now.getHours().toString().padStart(2, "0") // 得到小时;
			let minutes = now.getMinutes().toString().padStart(2, "0") // 得到分钟;
			let seconds = now.getSeconds().toString().padStart(2, "0") // 得到秒;
			let endTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`
			this.end_time = Date.parse(endTime) / 1000
		},
		methods: {

			focusClick(key) {
				setTimeout(() => {
					this.focusLink = key;
				}, 500)
			},
			async submit() {
				if (!this.pwd_name) {
					this.showToast('请输入持有人名称')
					return
				}
				if (!this.pwd) {
					this.showToast('请输入密码')
					return
				}
				if (!this.end_time) {
					this.showToast('请选择过期时间')
					return
				}
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await addPwd_api({
					lock_id: this.lock_id,
					pwd_name: this.pwd_name,
					pwd: this.pwd,
					end_time: this.end_time
				})
				if (res.code === 0) {
					uni.hideLoading()
					this.showToast('添加成功!')
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
				this.end_time = Math.trunc(e.value / 1000)
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
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addPassword.scss';
</style>