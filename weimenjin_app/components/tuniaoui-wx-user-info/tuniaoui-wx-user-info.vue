<template>
	<view v-if="openModal" class="wx-authorization-modal">
		<view class="wam__mask" @touchmove.prevent="" @tap.stop="closeModal"></view>

		<!-- 内容区域 -->
		<view class="wam__wrapper">
			<!-- 关闭按钮 -->
			<view class="wam__close-btn" @tap.stop="closeModal">
				<text class="tn-icon-close"></text>
			</view>

			<!-- 标题 -->
			<view class="wam__title">获取您的昵称、头像</view>

			<!-- 提示 -->
			<view class="wam__sub-title">
				获取用户头像、昵称，主要用于向用户提供具有辨识度的用户中心界面
			</view>

			<!-- 头像选择 -->
			<view class="wam__avatar">
				<view class="button-shadow">
					<!-- 微信使用 open-type 方式 -->
					<!-- #ifdef MP-WEIXIN -->
					<button class="button" open-type="chooseAvatar" @chooseavatar="chooseAvatarEvent">
					<!-- #endif -->

						<!-- 其他平台使用 tap 方式 -->
						<!-- #ifndef MP-WEIXIN -->
						<button class="button" @tap="chooseAvatarEvent">
						<!-- #endif -->

							<view v-if="paths" class="avatar__image">
								<image class="image" :src="paths" mode="aspectFill"></image>
							</view>
							<view v-else class="avatar__empty">
								<image class="image" src="../../static/picture.png" mode="aspectFill"></image>
							</view>
							<view class="avatar--icon">
								<view class="tn-icon-camera-fill"></view>
							</view>
						</button>
				</view>
			</view>

			<!-- 获取昵称按钮 -->
			<view class="nickname__data">

				<input class="input" type="nickname" id="nickname-input" @focus="getNickname" @input="handleInput"
					v-model="userInfo.nickname" placeholder="请输入昵称" placeholder-style="color: #AAAAAA;">
			</view>

			<!-- 保存按钮 -->
			<view class="wam__submit-btn" :class="{ 'disabled': !userInfo.avatar || !userInfo.nickname }"
				hover-class="tn-btn-hover-class" :hover-stay-time="150" @click.stop="submitUserInfo">
				保 存
			</view>
		</view>
	</view>
</template>


<script>
	import {
		ref,
		watch
	} from 'vue';
	import {
		images_api
	} from '@/api/index.js';

	export default {
		props: {
			modelValue: {
				type: Boolean,
				default: false
			}
		},
		setup(props, {
			emit
		}) {
			const openModal = ref(false);
			const userInfo = ref({
				avatar: '',
				nickname: ''
			});
			const paths = ref('');

			// 监听 modelValue 变化，控制 openModal
			watch(() => props.modelValue, (newValue) => {
				openModal.value = newValue;
			}, {
				immediate: true
			});
			// 处理用户输入
			const handleInput = (e) => {
				userInfo.value.nickname = e.target.value;
				console.log('User input:', userInfo.value.nickname); // 实时显示用户输入的昵称
			};
			const getNickname = (e) => {
				console.log(e);
				uni.createSelectorQuery().in(this)
					.select("#nickname-input")
					.fields({
						properties: ["value"],
					})
					.exec((res) => {
						const nickName = res?.[0]?.value;
						userInfo.value.nickname = nickName;
						console.log(userInfo.value);
					});

			};
			// // 头像选择
			// const chooseAvatarEvent = async (e) => {
			// 	paths.value = e.detail.avatarUrl;
			// 	let res = await images_api({
			// 		image: paths.value
			// 	});
			// 	userInfo.value.avatar = res.data;
			// 	console.log(userInfo.value);
			// };
			// 微信小程序处理头像选择
			const chooseAvatarEvent = async (e) => {
				// #ifdef MP-WEIXIN
				paths.value = e.detail.avatarUrl; // 微信小程序获取头像URL
				console.log('微信头像: ', paths.value);
				let res = await images_api({
					image: paths.value
				});
				userInfo.value.avatar = res.data;
				console.log(userInfo.value);
				// #endif

				// 其他平台处理头像选择
				// #ifndef MP-WEIXIN
				uni.chooseImage({
					count: 1, // 允许选择的图片数量
					success: async (res) => {
						console.log('选择的图片: ', res.tempFilePaths[0]);
						paths.value = res.tempFilePaths[0];
						let uploadRes = await images_api({
							image: paths.value
						});
						userInfo.value.avatar = uploadRes.data;
					},
					fail: (err) => {
						console.error('选择图片失败: ', err);
					}
				});
				// #endif
			};
			// 更新用户信息
			const submitUserInfo = () => {
				if (!userInfo.value.avatar || !userInfo.value.nickname) {
					return uni.showToast({
						icon: 'none',
						title: '请选择头像和输入用户信息'
					});
				}
				console.log(userInfo.value);
				emit('updated', userInfo.value);
			};

			// 关闭弹窗
			const closeModal = () => {
				emit('update:modelValue', false);
			};

			return {
				openModal,
				userInfo,
				paths,
				chooseAvatarEvent,
				submitUserInfo,
				closeModal
			};
		}
	};
</script>

<style lang="scss" scoped>
	@import './iconfont.css';

	.wx-authorization-modal {
		position: fixed;
		left: 0;
		top: 0;
		width: 100vw;
		height: 100vh;
		z-index: 99998;

		view {
			box-sizing: border-box;
		}

		.get-nickname-button {
			background-color: #05c160;
			color: white;
			border-radius: 5px;
			padding: 10px;
			margin-bottom: 20px;
			font-size: 16px;
		}

		.image {
			width: 100%;
			height: 100%;
			border-radius: inherit;
		}

		.wam {

			/* mask */
			&__mask {
				position: absolute;
				left: 0;
				top: 0;
				width: 100%;
				height: 100%;
				background-color: rgba(0, 0, 0, 0.5);
				opacity: 0;
				animation: showMask 0.25s ease 0.1s forwards;
			}

			/* close-btn */
			&__close-btn {
				position: absolute;
				top: 30rpx;
				right: 30rpx;
				z-index: 99999;
			}

			/* wrapper */
			&__wrapper {
				position: absolute;
				left: 0;
				bottom: 0;
				width: 100%;
				background-color: #FFFFFF;
				border-radius: 20rpx 20rpx 0rpx 0rpx;
				padding: 40rpx;
				padding-top: 60rpx;
				padding-bottom: 40rpx;
				padding-bottom: calc(constant(safe-area-inset-bottom) + 40rpx);
				padding-bottom: calc(env(safe-area-inset-bottom) + 40rpx);
				transform-origin: center bottom;
				transform: scaleY(0);
				animation: showWrapper 0.25s ease 0.1s forwards;
				z-index: 99999;
			}

			/* title */
			&__title {
				font-size: 34rpx;
			}

			/* sub-title */
			&__sub-title {
				font-size: 26rpx;
				color: #AAAAAA;
				margin-top: 16rpx;
				padding-bottom: 30rpx;
			}

			/* 头像选择 */
			&__avatar {
				width: 100%;
				margin-top: 30rpx;
				display: flex;
				align-items: center;
				justify-content: center;

				.button-shadow {
					border: 8rpx solid rgba(255, 255, 255, 0.05);
					box-shadow: 0rpx 0rpx 80rpx 0rpx rgba(0, 0, 0, 0.15);
					border-radius: 50%;
				}

				.button {
					position: relative;
					width: 160rpx;
					height: 160rpx;
					border-radius: 50%;
					overflow: visible;
					background-image: repeating-linear-gradient(45deg, #E4E9EC, #F8F7F8);
					color: #FFFFFF;
					background-color: transparent;
					padding: 0;
					margin: 0;
					font-size: inherit;
					line-height: inherit;
					border: none;

					&::after {
						border: none;
					}
				}

				.avatar {

					&__empty,
					&__image {
						width: 100%;
						height: 100%;
						border-radius: inherit;
					}

					&--icon {
						position: absolute;
						right: -10rpx;
						bottom: -6rpx;
						width: 60rpx;
						height: 60rpx;
						// transform: translate(50%, 50%);
						background-color: #1D2541;
						color: #FFFFFF;
						border-radius: 50%;
						border: 6rpx solid #FFFFFF;
						line-height: 1;
						font-size: 36rpx;
						display: flex;
						align-items: center;
						justify-content: center;
					}
				}
			}

			/* 昵称 */
			&__nickname {
				margin-top: 40rpx;

				.nickname {

					&__data {
						margin-top: 16rpx;
						width: 100%;
						padding: 26rpx 20rpx;
						border-radius: 10rpx;
						background-color: #F8F7F8;

						.input {
							color: #080808;
						}
					}
				}
			}

			/* 保存按钮 */
			&__submit-btn {
				width: 100%;
				background-color: #05C160;
				color: #FFFFFF;
				margin-top: 60rpx;
				border-radius: 10rpx;
				padding: 25rpx;
				font-size: 32rpx;
				display: flex;
				align-items: center;
				justify-content: center;

				&.disabled {
					background-color: #E6E6E6;
				}
			}


		}
	}

	.tn-btn-hover-class {
		box-shadow: inset 10rpx 2rpx 40rpx 0rpx rgba(0, 0, 0, 0.05);
	}

	@keyframes showMask {
		0% {
			opacity: 0;
		}

		100% {
			opacity: 1;
		}
	}

	@keyframes showWrapper {
		0% {
			transform: scaleY(0);
		}

		100% {
			transform: scaleY(1);
		}
	}
</style>