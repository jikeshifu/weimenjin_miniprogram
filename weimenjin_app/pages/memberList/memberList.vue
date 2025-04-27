<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view class="list">
				<checkbox-group @change="checkboxItem">
					<view class="item" v-for="(item, index) in dataList" :key="index">

						<label>
							<checkbox :value="item.value" :checked="checkedArr.includes(String(item.value))" color="#21CF3E" style="transform:scale(0.8)" />
						</label>
						<view class="left-box">
							<image
								src="https://img1.baidu.com/it/u=666927474,3753237121&fm=253&fmt=auto&app=138&f=GIF?w=504&h=500"
								class="user-img"></image>
							<view class="user-info">
								<view class="flex-box">
									<view class="user-name">杜瑞</view>
									<view class="phone">159***9999</view>
								</view>
							</view>
						</view>
					</view>
				</checkbox-group>

			</view>
			<view class="bottom">
				<checkbox-group @change="allChoose">
					<label>
						<checkbox :checked="allChecked" value="all" color="#21CF3E" style="transform:scale(0.8)" />全选
					</label>
				</checkbox-group>

				<view class="add-btn" @click="onAdd">添加</view>

			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				allChecked: false,
				checkedArr: [],
				dataList: [{
						value: '0',
						checked: false
					},
					{
						value: '1',
						checked: false
					},
					{
						value: '2',
						checked: false
					},
					{
						value: '3',
						checked: false
					}
				]
			}
		},
		onShareAppMessage() {},
		onShareTimeline() {},
		methods: {
			confirm(e) {
				console.log(e)
			},
			checkboxItem(e) {
				this.checkedArr = e.detail.value
				if (this.checkedArr.length === this.dataList.length) {
					this.allChecked = true
				} else {
					this.allChecked = false
				}
			},
			allChoose(e) {
				let chooseItem = e.detail.value;
				// 全选
				if (chooseItem[0] == 'all') {
					this.allChecked = true;
					for (let item of this.dataList) {
						let itemVal = String(item.value);
						if (!this.checkedArr.includes(itemVal)) {
							this.checkedArr.push(itemVal);
						}
					}
				} else {
					// 取消全选
					this.allChecked = false;
					this.checkedArr = [];
				}
			},
			onAdd() {
				console.log(this.checkedArr)
			}
		}
	}
</script>

<style scoped lang="scss">
	@import './memberList.scss';
</style>