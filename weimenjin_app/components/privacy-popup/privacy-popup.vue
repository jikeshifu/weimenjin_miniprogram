<template>
	<view v-if="showPrivacy" class="privacy">
		<view class="content">
			<view class="title">隐私保护指引</view>
			<view class="des">
				在使用当前小程序服务之前，请仔细阅读
				<text class="link" @tap="openPrivacyContract">{{privacyContractName}}</text>
				。如你同意{{privacyContractName}}，请点击“同意”开始使用。
			</view>
			<view class="checkbox-container" @tap="toggleCheckbox">
				<checkbox-group>
					<checkbox value="agree" :checked="isAgreed" color="#07c160" style="transform: scale(1.0);" />
				</checkbox-group>
				<text class="checkbox-text">我已阅读并同意{{privacyContractName}}</text>
			</view>
			<view class="btns">
				<button class="item reject" @tap="exitMiniProgram">拒绝</button>
				<button id="agree-btn" class="item agree" open-type="agreePrivacyAuthorization"
					:disabled="!isAgreed"
					@agreeprivacyauthorization="handleAgreePrivacyAuthorization">同意</button>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: 'PrivacyPopup',
		data() {
			return {
				privacyContractName: '',
				showPrivacy: false,
				isRead: false,
				isAgreed: false,
				resolvePrivacyAuthorization: null,
			};
		},
		mounted() {
			if (wx.onNeedPrivacyAuthorization) {
				wx.onNeedPrivacyAuthorization((resolve) => {
					this.resolvePrivacyAuthorization = resolve;
				});
			}

			if (wx.getPrivacySetting) {
				wx.getPrivacySetting({
					success: (res) => {
						console.log(res, 'getPrivacySetting');
						if (res.needAuthorization) {
							this.privacyContractName = res.privacyContractName;
							this.showPrivacy = true;
						}
					},
				});
			}
		},

		methods: {
			onCheckboxChange(e) {
				this.isAgreed = e.detail.value.includes('agree');
			},
			toggleCheckbox() {
				this.isAgreed = !this.isAgreed;
			},
			openPrivacyContract() {
				wx.openPrivacyContract({
					success: () => {
						this.isRead = true;
					},
					fail: () => {
						uni.showToast({
							title: '遇到错误',
							icon: 'error',
						});
					},
				});
			},
			exitMiniProgram() {

				wx.exitMiniProgram();

			},
			handleAgreePrivacyAuthorization() {
				if (!this.isAgreed) {
					uni.showToast({
						title: '请先勾选同意隐私协议',
						icon: 'none',
					});
					return;
				}
				this.showPrivacy = false;
				if (typeof this.resolvePrivacyAuthorization === 'function') {
					this.resolvePrivacyAuthorization({
						buttonId: 'agree-btn',
						event: 'agree',
					});
				}
				this.$emit('agree');
			},
		},
	};
</script>

<style>
	.privacy {
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: rgba(0, 0, 0, .5);
		z-index: 9999999;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.content {
		width: 632rpx;
		padding: 48rpx;
		box-sizing: border-box;
		background: #fff;
		border-radius: 16rpx;
	}

	.content .title {
		text-align: center;
		color: #333;
		font-weight: bold;
		font-size: 32rpx;
	}

	.content .des {
		font-size: 26rpx;
		color: #666;
		margin-top: 40rpx;
		text-align: justify;
		line-height: 1.6;
	}

	.content .des .link {
		color: #07c160;
		text-decoration: underline;
	}

	.btns {
		margin-top: 48rpx;
		display: flex;
	}

	.btns .item {
		width: 244rpx;
		height: 80rpx;
		overflow: visible;
		display: flex;
		align-items: center;
		margin: 0 12px;
		justify-content: center;
		/* border-radius: 16rpx; */
		box-sizing: border-box;
		border: none !important;
	}

	.btns .reject {
		background: #f4f4f5;
		color: #909399;
	}

	.btns .agree {
		background: #07c160;
		color: #fff;
	}
	.checkbox-container {
		margin-top: 32rpx;
		display: flex;
		align-items: center;
		padding: 16rpx 0;
	}
	.checkbox-text {
		font-size: 26rpx;
		color: #333;
		margin-left: 16rpx;
		line-height: 1.4;
	}
</style>
