<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
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
			<view class="bottom" @click="onsubmit">提交</view>
		</view>
	</view>
</template>

<script>
	import {
		listCard_api,
		syncCard_api,
		listFace_api,
		syncFace_api
	} from '@/api/index.js'
	export default {
		data() {
			return {
				type: '',
				p_lock_id: '',
				dataList: [],
				lock_ids: []
			}
		},
		onLoad(option) {
			this.type = option.type
			this.p_lock_id = option.lock_id
			this.getList()
		},
		methods: {
			async getList() {
				if (this.type === 'card') {
					let res = await listCard_api()
					this.dataList = res.data
				} else {
					let res = await listFace_api()
					this.dataList = res.data
				}
				
			},
			checkboxItem(e) {
				this.lock_ids = e.detail.value
			},
			async onsubmit() {
				if (!this.lock_ids.length) {
					this.showToast('请选择设备')
					return
				}
				
				let res;
				if (this.type === 'card') {
					res = await syncCard_api({
						p_lock_id: this.p_lock_id,
						lock_ids: this.lock_ids
					})
				} else {
					res = await syncFace_api({
						p_lock_id: this.p_lock_id,
						lock_ids: this.lock_ids
					})
				}
				uni.showLoading({
					title: '提交中...',
					mask: true
				})
				this.showToast(res.msg)
				if (res.code === 0) {
					let timer = setTimeout(() => {
						uni.navigateBack({
							delta: 1
						})
					}, 1500)
				}
				uni.hideLoading()
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
	@import './synchroData.scss';
</style>