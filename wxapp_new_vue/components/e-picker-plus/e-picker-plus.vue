<template>
	<view>
		<view v-if="hasSlot" class="e-picker--text" @tap="pickerVisible=true">
			<slot />
		</view>
		<view class="e-picker" :style="{'visibility':pickerVisible?'visible':'hidden'}">
			<view class="e-picker-mask" :class="{'e-picker-animation':animation}" :style="{'opacity':pickerVisible?0.6:0}" @tap="_cancel"></view>
			<view class="e-picker-container" :class="{'e-picker-container--show':pickerVisible,'e-picker-animation':animation}">
				<view class="e-picker-action">
					<view class="e-picker-action--cancel" @tap="_cancel">取消</view>
					<view class="e-picker-action--confirm" @tap="_confirm">确定</view>
				</view>
				<picker-view :style="{'height':height+'vh'}" indicator-style="height:40px" :value="value" @change="_change">
					<picker-view-column v-if="mode.includes('Y')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['Y']" :key="index">
							{{item+'年'}}
						</view>
					</picker-view-column>
					<picker-view-column v-if="mode.includes('M')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['M']" :key="index">
							{{item+'月'}}
						</view>
					</picker-view-column>
					<picker-view-column v-if="mode.includes('D')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['D']" :key="index">
							{{item+'日'}}
						</view>
					</picker-view-column>
					<picker-view-column v-if="mode.includes('h')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['h']" :key="index">
							{{item+'时'}}
						</view>
					</picker-view-column>
					<picker-view-column v-if="mode.includes('m')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['m']" :key="index">
							{{item+'分'}}
						</view>
					</picker-view-column>
					<picker-view-column v-if="mode.includes('s')" class="e-picker-column">
						<view class="e-picker-list-item" v-for="(item,index) in container['s']" :key="index">
							{{item+'秒'}}
						</view>
					</picker-view-column>
				</picker-view>
			</view>
		</view>
	</view>
</template>

<script>
	import utils from './utils.min.js'
	export default {
		name: 'ePickerPlus',
		data() {
			return {
				pickerVisible: false,
				container: {},
				value: [],
				showDateTime: ''
			}
		},
		props: {
			mode: {
				type: String,
				default: 'YMD'
			},
			height: {
				type: Number,
				default: 35
			},
			animation: {
				type: Boolean,
				default: true
			},
			start: {
				type: String,
				default: ''
			},
			end: {
				type: String,
				default: ''
			},
			defaultValue: {
				type: String,
				default: ''
			},
			verify: {
				type: Boolean,
				default: false
			},
			errorMsg: {
				type: String,
				default: '选择的时间超过当前时间'
			},
			initOnOpen: {
				type: Boolean,
				default: false
			}
		},
		computed: {
			hasSlot() {
				return !!this.$slots['default']
			},
			columns() {
				return this.mode.split('')
			},
			endRange() {
				return this.end || utils.getRange(this.mode, 'end')
			},
			startRange() {
				return this.start || utils.getRange(this.mode, 'start')
			}
		},
		created() {
			try {
				if (!utils.hasMode(this.mode)) throw new Error(`mode='${this.mode}' doesn't exist`)
				this._initPicker()
			} catch (e) {
				console.error(e)
			}
		},
		methods: {
			show() {
				this.pickerVisible = true
				if (this.initOnOpen) this._setValue()
			},
			_initPicker() {
				const startObj = utils.dateTime2Obj(this.startRange)
				const endObj = utils.dateTime2Obj(this.endRange)
				this._setValue()
				for (const v of this.columns) {
					let maxNum = Number(endObj[v]),
						minNum = Number(startObj[v])
					if (v === 'D') {
						const currentObj = utils.dateTime2Obj(this.showDateTime)
						maxNum = this.end ? Number(endObj['D']) : utils.getDays(currentObj['Y'], currentObj['M'])
					}
					this.$set(this.container, v, utils.getColumn(maxNum, minNum))
				}
			},
			_confirm() {
				this.$emit('confirm', this._getResult())
				this.pickerVisible = false
			},
			_cancel() {
				this.$emit('cancel')
				this.pickerVisible = false
			},
			_getResult() {
				const obj = utils.value2Obj(this.value, this.columns, this.container)
				const r = {
					resultArr: utils.obj2Arr(obj),
					result: utils.obj2DateTime(obj, this.mode)
				}
				const timestamp = utils.time2Timestamp(r.result)
				if (!isNaN(timestamp)) {
					r.timestamp = timestamp
					const current = utils.getLocalTime(this.mode)
					if (utils.time2Timestamp(current) < timestamp) r.errorMsg = this.errorMsg
				}
				return r
			},
			_setValue() {
				this.showDateTime = utils.getLocalTime(this.mode)
				if (this.defaultValue.trim() != '') this.showDateTime = this.defaultValue
				this.value = utils.obj2Value(utils.dateTime2Obj(this.startRange), utils.dateTime2Obj(this.showDateTime))
			},
			_change(e) {
				const value = e.detail.value
				const obj = utils.value2Obj(value, this.columns, this.container)
				if (this._hasModeStr('D') && (value[1] != this.value[1] || value[0] != this.value[0])) {
					let maxNum = utils.getDays(obj['Y'], obj['M']),
						minNum = 1
					if (this.end) maxNum = Number(utils.dateTime2Obj(this.endRange)['D'])
					if (this.start) minNum = Number(utils.dateTime2Obj(this.startRange)['D'])
					this.$set(this.container, 'D', utils.getColumn(maxNum, minNum))
				}
				this.value = value
			},
			_hasModeStr(str) {
				return this.mode.includes(str)
			}
		}
	}
</script>

<style scoped lang="scss">
	.e-picker--text {}

	.e-picker {
		position: fixed;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 999;
		font-size: 30rpx;
	}

	.e-picker-container {
		position: fixed;
		bottom: 0;
		transform: translateY(100%);
		z-index: 999;
		width: 100%;
		background-color: #fff;
		visibility: hidden;

	}

	.e-picker-container--show {
		transform: translateY(0);
		visibility: visible;
	}

	.e-picker-mask {
		z-index: 998;
		width: 100%;
		height: 100%;
		background-color: rgb(0, 0, 0);
	}

	.e-picker-animation {
		transition: all 0.3s;
	}

	.e-picker-action {
		width: 100%;
		display: flex;
		justify-content: space-between;
		padding: 20rpx;
		box-sizing: border-box;
		position: relative;
		font-size: 32rpx;
		border-bottom: 0.5px solid #e5e5e5
	}

	.e-picker-action--cancel {
		opacity: .7;
	}

	.e-picker-action--confirm {
		color: #007aff;
	}

	.e-picker-column {
		text-align: center;
		border: none
	}

	.e-picker-list-item {
		display: flex;
		justify-content: center;
		align-items: center;
		height: 40px;
	}
</style>
