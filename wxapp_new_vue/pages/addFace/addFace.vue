<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="top-box">
				
				<view class="cell-item">
					<view class="label">持有人：</view>
					<input placeholder="请输入持有人名称" placeholder-class="placeholder" v-model="formData.face_name" />
				</view>
				
				<view class="cell-item" @click="openTime">
					<view class="label">过期时间：</view>
					<view class="text">{{ formData.end_time ? formatDate(formData.end_time) : '请选择过期时间' }}</view>
				</view>
				
				<view class="updata-img" v-if="!isEdit">
					<view class="img" @click="updataImg">
						<image src="../../static/picture.png" class="btn-icon" v-if="!formData.face_images"></image>
						<image :src="formData.face_images | imgPath" class="btn-icon" v-else></image>
					</view>
				</view>
				<view class="cell-item">
					<view class="label">请勿美颜</view>
				</view>

			</view>
			<view class="bottom-btn" @click="onSubmit">立即提交</view>
		</view>
		<uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm">
		</uv-datetime-picker>
	</view>
</template>

<script>
	import {
		images_api,
		addFace_api,
		editFace_api
	} from '@/api/index.js';
	import { imgPath } from "@/libs/filters.js"
	import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue'
	export default {
		components: {
			UvDatetimePicker
		},
		data() {
			return {
				dateTimeValue: Number(new Date()),
				formData: {
					lock_id: '',
					face_name: '',
					end_time: '',
					face_images: '',
				},
				verifyData: {
					lock_id: '缺少设备ID',
					face_name: '请输入持有人名称',
					end_time: '请选择过期时间',
					face_images: '请上传人脸图片',
				},
				isEdit: false
			}
		},
		filters: {
			imgPath
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
					face_id: item.face_id,
					face_name: item.face_name,
					end_time: item.end_time
				}
			} else {
				let now = new Date()
				// 一年后的时间
				let year = now.getFullYear() + 1;
				let month = (now.getMonth() + 1).toString().padStart(2, "0"); //得到月份
				let day = (now.getDate()).toString().padStart(2, "0"); //得到日期
				let hours = now.getHours().toString().padStart(2, "0") // 得到小时;
				let minutes = now.getMinutes().toString().padStart(2, "0") // 得到分钟;
				let seconds = now.getSeconds().toString().padStart(2, "0") // 得到秒;
				let endTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`
				this.formData.end_time = Date.parse(endTime) / 1000
			}
		},
		methods: {
			openTime() {
				this.$refs.datetimePicker.open();
			},
			confirm(e) {
				this.formData.end_time = Math.trunc(e.value / 1000)
			},
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
					res = await addFace_api(this.formData)
				} else {
					res = await editFace_api(this.formData)
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
			updataImg() {
				uni.chooseImage({
					success: async chooseImageRes => {
						uni.showLoading({
							title: '上传中',
							mask: true
						});
						const tempFilePaths = chooseImageRes.tempFilePaths;
						let res = await images_api({
							image: tempFilePaths[0]
						});
						if (res.code === 0) {
							uni.hideLoading();
							this.formData.face_images = res.data
						} else {
							uni.hideLoading();
							this.showToast(res.msg);
						}
					}
				});
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
					mask: true
				})
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './addFace.scss';
</style>