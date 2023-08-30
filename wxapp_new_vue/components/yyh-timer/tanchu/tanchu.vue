<template>
	<view>
		<view class="count">
			<view class="list">{{hour}}</view>
			<view class="list">{{minute}}</view>
			<view class="list">{{second}}</view>
		</view>


	</view>
</template>

<script>
	export default {
		name: "countdown",
		props: {
			start: {
				type: Number,
				default: 0
			},
			finish: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				hour: '',
				minute:'',
				second:''
			}
		},
		created(){
			var a =this;
			var start = a.start.toString().substring(0,10);
			var finish = a.finish.toString().substring(0,10);
			var timer = parseInt(finish)-parseInt(start)
			var hours = parseInt((timer % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = parseInt((timer % (1000 * 60 * 60)) / (1000 * 60));
			var seconds =  parseInt((timer % (1000 * 60)) / 1000);
			a.hour = (hours < 10 ? ('0' + hours) : hours);
			a.minute = (minutes < 10 ? ('0' + minutes) : minutes);
			a.second = (seconds < 10 ? ('0' + seconds) : seconds);
			var interval = setInterval(() => {
				a.second = (Array(2).join(0) + parseInt(--a.second)).slice(-2)
				if (a.second == 0) {
					if (a.minute != 0) {
							a.minute = (Array(2).join(0) + parseInt(--a.minute)).slice(-2)
						a.second = 59
					} else {
						if (a.hour != 0) {
							a.hour = (Array(2).join(0) + parseInt(--a.hour)).slice(-2)
							a.minute = 59
							a.second = 59
						} else {
							clearInterval(interval)
							a.finality()
						}
					}
				}
			}, 1000)
		},
		methods: {
			finality(){
				
				this.$emit('finish');
			},
		}
	}
</script>

<style lang="scss">
	.count {
		width: 100%;
		height: 100%;
		display: flex;

		.list {
			height: 80%;
			align-self: center;
			background: red;
			padding: 10rpx 20rpx;
			font-size: 24rpx;
			color: #fff;
			margin-left: 10rpx;
			letter-spacing: 2rpx;
		}
	}
</style>
