<template>
	<view class="content">
		<view class="icon" :style="{color: color, fontSize: fontSize}" @click="toclick">{{ iconText }}</view>
	</view>
</template>

<script>
	const iconMap = {
		'&#xe6f3;': '+',
		'&#xe6f9;': 'T',
		'&#xe6eb;': '-',
		'&#xe6e8;': '↶',
		'&#xe705;': '↷',
		'&#xeb8a;': '⚙',
		'&#xe6e7;': 'B',
		'&#xe6fe;': 'I',
		'&#xe6f8;': 'S',
		'&#xe6e3;': 'H',
		'&#xe6f1;': 'C',
		'&#xe6ed;': 'R'
	};

	export default {
		props: {
			type: {
				type: String,
				default: '&#xe644;'
			},
			color: {
				type: String,
				default: '#666666'
			},
			fontSize: {
				type: String,
				default: '34rpx'
			}
		},
		computed: {
			iconText() {
				return iconMap[this.type] || '';
			}
		},
		methods: {
			toclick() {
				this.$emit('click');
			}
		}
	}
</script>

<style scoped>
	.content{
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.icon {
		min-width: 44rpx;
		font-size: 34rpx;
		font-weight: 600;
		line-height: 1;
		text-align: center;
	}

</style>
