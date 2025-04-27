<template>
	<picker class='rui-picker rui-class' mode="multiSelector" :range="times" :value="timesIndex" :disabled="curDisabled" @change='changeDate' @cancel="cancelDate" @columnchange="columnchangeDate">
	  {{curValue}}
	</picker>
</template>

<script>
	import GetDate from './GetDate.js';
	export default {
		name: 'rattenking-dtpicker',
		props: {
			/**
			 * picker允许选中的最小值
			 */
			start: {
			  type: String,
			  default: '1900-00-00 00:00:00'
			},
			/**
			 * picker允许选中的最大值
			 */
			end: {
			  type: String,
			  default: '2500-12-30 23:59:59'
			},
			/**
			 * picker默认展示的值
			 */
			value: {
			  type: String,
			  default: ''
			},
			/**
			 * picker的时间粒度
			 */
			fields: {
			  type: String,
			  default: 'second'
			},
			/**
			 * picker是否禁止
			 */
			disabled: {
			  type: Boolean,
			  default: false
			}
		},
		data() {
			return {
				times:[['2019','2020'],['01','02']],
				timesIndex: [1,1],
				timesString: null,
				curValue: this.value,
				curDisabled: this.disabled,
				cancel: null
			}
		},
		watch: {
			value(val) {
				this.curValue = val;
			},
			disabled(val){
				this.curDisabled = val;
			},
			curDisabled(val){
				this.curDisabled = val;
			},
			curValue(val) {
				this.curValue = val;
				this.$emit('change', val);
			},
			times(val){
				this.times = val;
			},
			timesIndex(val){
				this.timesIndex = val;
			},
			cancel(val) {
				this.$emit('cancel', val);
			}
		},
		created() {
			if(this.value === ''){
				let time = GetDate.getCurrentTimes();
				let arr = [];
				for (let key in time.detail) {
					arr.push(time.detail[key]);
					if(key === this.fields){
						break;
					}
				}
				this.value = GetDate.format(arr);
				this.curValue = GetDate.format(arr);
			}
			switch (this.fields){
				case 'year':
				  if (this.value.length !== 4) {GetDate.error('时间粒度和时间格式不一致');this.curDisabled = true;return false;}
				  if (this.start.length !== 4) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 4) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				case 'month':
				  if (this.value.length !== 7) { GetDate.error('时间粒度和时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.start.length !== 7) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 7) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				case 'day':
				  if (this.value.length !== 10) { GetDate.error('时间粒度和时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.start.length !== 10) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 10) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				case 'hour':
				  if (this.value.length !== 13) { GetDate.error('时间粒度和时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.start.length !== 13) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 13) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				case 'minute':
				  if (this.value.length !== 16) { GetDate.error('时间粒度和时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.start.length !== 16) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 16) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				case 'second':
				  if (this.value.length !== 19) { GetDate.error('时间粒度和时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.start.length !== 19) { GetDate.error('时间粒度和开始时间格式不一致'); this.curDisabled = true; return false;}
				  if (this.end.length !== 19) { GetDate.error('时间粒度和结束时间格式不一致'); this.curDisabled = true; return false;}
				  break;
				default: 
				  GetDate.error('时间粒度不存在')
				  break;
			  }
			  let values = this.value.split(' ');
			  let targets = GetDate.getCurrentStringValue(this.value);

			  if (GetDate.getTimes(this.value) < GetDate.getTimes(this.start)){
				GetDate.error('默认时间不能小于开始时间')
				this.curDisabled = true
				return false;
			  }
			  if (GetDate.getTimes(this.value) > GetDate.getTimes(this.end)) {
				GetDate.error('默认时间不能大于开始时间')
				this.curDisabled = true
				return false;
			  }
			  let times = GetDate.getDateTimes({
					start: this.start.substring(0, 4),
					end: this.end.substring(0, 4),
					curyear: this.value.substring(0, 4),
					curmonth: this.value.substring(5, 7),
					fields: this.fields
			  })
			  let timesIndex = GetDate.getTimeIndex(times, targets);
			  let timesString = [];
			  timesIndex.forEach(o => timesString.push(o));

			  this.times = times;
			  this.timesIndex = timesIndex;
			  this.timesString = timesString;
		},
		methods: {
			changeDate(e){
			  let values = e.detail.value;
			  let times = this.times;
			  let curarr = [];
			  for (let i = 0, len = values.length; i < len; i++) {
				curarr.push(times[i][values[i]])
			  }
			  let str = GetDate.format(curarr);
			  this.curValue = str;
			},
			columnchangeDate(e){
				// 如果是年和月粒度，那么只需要改变时间格式的index，否则需要判断当月天数
			  if ((this.fields === 'year' || this.fields === 'month')){
					let timesIndex = GetDate.getNewArray(this.timesIndex);
					timesIndex[e.detail.column] = e.detail.value;
// 					let arr = GetDate.getCompare(GetDate.format(GetDate.getChooseArr(this.times,timesIndex)),this.start,this.end,this.times);
// 					console.log(arr)
					this.timesIndex = timesIndex;
					return false;
			  }else{
					// 如果改变的是年和月，重新获取天数，同时判断天数的index是否大于当前天数，大于就设置为当月最后一天，否则不变。
					if(e.detail.column === 0 || e.detail.column === 1){
						let times = GetDate.getNewArray(this.times);
						let timesIndex = GetDate.getNewArray(this.timesIndex);
						timesIndex[e.detail.column] = e.detail.value;
						let days = GetDate.getMonthDay(times[0][timesIndex[0]], times[1][timesIndex[1]]);
						times[2] = days;
						if(timesIndex[2] > days.length - 1){
							timesIndex[2] = days.length - 1;
						}
						this.times = times;
						// let arr = GetDate.getCompare(GetDate.format(GetDate.getChooseArr(this.times,timesIndex)),this.start,this.end,this.times);
						this.timesIndex = timesIndex;
					}else{
						let timesIndex = GetDate.getNewArray(this.timesIndex);
						timesIndex[e.detail.column] = e.detail.value;
// 						let arr = GetDate.getCompare(GetDate.format(GetDate.getChooseArr(this.times,timesIndex)),this.start,this.end,this.times);
// 						console.log(arr)
						this.timesIndex = timesIndex;
					}
				}
			},
			cancelDate(e){
				this.cancel = e
			}
		}
	}
</script>

<style>
	.rui-picker{
	  height: 10vw;
	  font-size: 4vw;
	  color: #000;
	  display: -webkit-flex;
	  display: flex;
	  align-items: center;
	  padding: 0 10px;
	  box-sizing: border-box;
	  border: 1px solid #aaa;
	  border-radius: 3px;
	}
</style>
