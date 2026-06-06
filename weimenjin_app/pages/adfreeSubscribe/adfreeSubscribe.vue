<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<!-- 订阅状态卡片 -->
			<view class="status-card" v-if="subscriptionInfo.has_subscription">
				<view class="status-header">
					<view class="status-badge active">已订阅</view>
					<view class="status-title">免广告二维码服务</view>
				</view>
				<view class="status-info">
					<view class="info-row">
						<text class="info-label">到期时间：</text>
						<text class="info-value">{{ subscriptionInfo.expire_time }}</text>
					</view>
					<view class="info-row">
						<text class="info-label">剩余天数：</text>
						<text class="info-value highlight">{{ subscriptionInfo.remaining_days }}天</text>
					</view>
				</view>
				<view class="qrcode-preview" v-if="subscriptionInfo.adfree_qrcode">
					<image :src="subscriptionInfo.adfree_qrcode" mode="aspectFit" @longpress="saveQrcode"></image>
					<view class="qrcode-label">免广告开门二维码</view>
					<view class="qrcode-actions">
						<view class="action-btn" @click="saveQrcode">
							<text class="action-icon">📥</text>
							<text class="action-text">保存到相册</text>
						</view>
					</view>
					<view class="qrcode-tip">长按二维码也可保存</view>
				</view>
			</view>

			<!-- 未订阅提示 -->
			<view class="intro-card" v-if="!subscriptionInfo.has_subscription">
				<view class="intro-icon">🎁</view>
				<view class="intro-title">免广告二维码服务</view>
				<view class="intro-desc">订阅后，扫码开门将不再显示广告，给您和用户更流畅的开门体验。</view>
				<view class="intro-features">
					<view class="feature-item">✓ 无广告干扰，快速开门</view>
					<view class="feature-item">✓ 专属二维码，可打印张贴</view>
					<view class="feature-item">✓ 到期前提醒续费</view>
				</view>
				<view class="intro-notice">
					<text class="notice-icon">💡</text>
					<text class="notice-text">收取的费用用于抵扣腾讯收取的手机验证费用</text>
				</view>
			</view>

			<!-- 套餐选择 -->
			<view class="package-section">
				<view class="section-title">{{ subscriptionInfo.has_subscription ? '续订套餐' : '选择套餐' }}</view>
				<view class="package-list">
					<view
						class="package-item"
						:class="{ active: selectedPackage === item.id }"
						v-for="item in packages"
						:key="item.id"
						@click="selectPackage(item.id)"
					>
						<view class="package-left">
							<view class="package-header">
								<view class="package-name">{{ item.name }}</view>
								<view class="package-tag" v-if="item.duration_days >= 365">推荐</view>
							</view>
							<view class="package-duration">{{ item.description }}</view>
						</view>
						<view class="package-right">
							<view class="package-price">
								<text class="price-symbol">¥</text>
								<text class="price-value">{{ item.price_display }}</text>
							</view>
							<view class="package-original" v-if="item.original_price_display">
								原价 ¥{{ item.original_price_display }}
							</view>
						</view>
					</view>
				</view>
			</view>

			<!-- 支付按钮 -->
			<view class="pay-section">
				<view class="pay-btn" @click="handlePay">
					<text v-if="subscriptionInfo.has_subscription">立即续订</text>
					<text v-else>立即订阅</text>
				</view>
				<view class="pay-tip">支付即表示同意《免广告服务协议》</view>
			</view>

			<!-- 订阅记录 -->
			<view class="history-section" v-if="historyList.length > 0">
				<view class="section-title">订阅记录</view>
				<view class="history-list">
					<view class="history-item" v-for="item in historyList" :key="item.id">
						<view class="history-left">
							<view class="history-time">{{ item.created_at }}</view>
							<view class="history-duration">{{ item.duration_days }}天</view>
						</view>
						<view class="history-right">
							<view class="history-price">¥{{ item.price_display }}</view>
							<view class="history-status" :class="{ expired: item.status === 2 }">{{ item.status_text }}</view>
						</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import {
	getAdfreePackages_api,
	getAdfreeStatus_api,
	createAdfreeOrder_api,
	getAdfreeHistory_api
} from '@/api/index.js';

export default {
	data() {
		return {
			lockauth_id: '',
			packages: [],
			selectedPackage: null,
			subscriptionInfo: {
				has_subscription: false,
				expire_time: null,
				adfree_qrcode: null,
				remaining_days: 0
			},
			historyList: []
		};
	},
	onLoad(option) {
		this.lockauth_id = option.lockauth_id;
		this.loadData();
	},
	onShow() {
		// 返回页面时刷新数据
		if (this.lockauth_id) {
			this.getSubscriptionStatus();
		}
	},
	methods: {
		async loadData() {
			await Promise.all([
				this.getPackages(),
				this.getSubscriptionStatus(),
				this.getHistory()
			]);
		},

		async getPackages() {
			try {
				const res = await getAdfreePackages_api({});
				if (res.code === 0 && res.data) {
					this.packages = res.data;
					// 默认选择年度套餐
					const yearPackage = this.packages.find(p => p.duration_days === 365);
					if (yearPackage) {
						this.selectedPackage = yearPackage.id;
					} else if (this.packages.length > 0) {
						this.selectedPackage = this.packages[0].id;
					}
				}
			} catch (error) {
				console.error('获取套餐失败:', error);
			}
		},

		async getSubscriptionStatus() {
			try {
				const res = await getAdfreeStatus_api({
					lockauth_id: this.lockauth_id
				});
				if (res.code === 0 && res.data) {
					this.subscriptionInfo = res.data;
				}
			} catch (error) {
				console.error('获取订阅状态失败:', error);
			}
		},

		async getHistory() {
			try {
				const res = await getAdfreeHistory_api({
					lockauth_id: this.lockauth_id,
					page: 1,
					limit: 10
				});
				if (res.code === 0 && res.data && res.data.list) {
					this.historyList = res.data.list;
				}
			} catch (error) {
				console.error('获取订阅历史失败:', error);
			}
		},

		selectPackage(id) {
			this.selectedPackage = id;
		},

		async handlePay() {
			if (!this.selectedPackage) {
				uni.showToast({
					title: '请选择套餐',
					icon: 'none'
				});
				return;
			}

			uni.showLoading({
				title: '创建订单中...',
				mask: true
			});

			try {
				const res = await createAdfreeOrder_api({
					lockauth_id: this.lockauth_id,
					package_id: this.selectedPackage
				});

				if (res.code !== 0) {
					uni.hideLoading();
					uni.showToast({
						title: res.msg || '创建订单失败',
						icon: 'none'
					});
					return;
				}

				// 调用微信支付
				this.onPay(res.data.payData);

			} catch (error) {
				uni.hideLoading();
				uni.showToast({
					title: '订单创建失败',
					icon: 'none'
				});
				console.error('创建订单失败:', error);
			}
		},

		onPay(payData) {
			uni.requestPayment({
				provider: 'wxpay',
				appId: payData.appId,
				timeStamp: payData.timeStamp,
				nonceStr: payData.nonceStr,
				package: payData.package,
				signType: payData.signType,
				paySign: payData.paySign,
				success: (res) => {
					uni.hideLoading();
					uni.showToast({
						title: '支付成功',
						icon: 'success'
					});
					// 刷新订阅状态
					setTimeout(() => {
						this.getSubscriptionStatus();
						this.getHistory();
					}, 1500);
				},
				fail: (err) => {
					uni.hideLoading();
					if (err.errMsg !== 'requestPayment:fail cancel') {
						uni.showToast({
							title: '支付失败',
							icon: 'none'
						});
					}
				}
			});
		},

		// 保存二维码到相册
		saveQrcode() {
			if (!this.subscriptionInfo.adfree_qrcode) {
				uni.showToast({
					title: '二维码不存在',
					icon: 'none'
				});
				return;
			}

			uni.showLoading({
				title: '保存中...',
				mask: true
			});

			// 下载图片到本地
			uni.downloadFile({
				url: this.subscriptionInfo.adfree_qrcode,
				success: (downloadRes) => {
					if (downloadRes.statusCode === 200) {
						// 保存到相册
						uni.saveImageToPhotosAlbum({
							filePath: downloadRes.tempFilePath,
							success: () => {
								uni.hideLoading();
								uni.showToast({
									title: '已保存到相册',
									icon: 'success'
								});
							},
							fail: (err) => {
								uni.hideLoading();
								if (err.errMsg.indexOf('auth deny') !== -1 || err.errMsg.indexOf('authorize') !== -1) {
									// 用户拒绝授权
									uni.showModal({
										title: '提示',
										content: '需要您授权保存到相册，请在设置中打开相册权限',
										confirmText: '去设置',
										success: (modalRes) => {
											if (modalRes.confirm) {
												uni.openSetting();
											}
										}
									});
								} else {
									uni.showToast({
										title: '保存失败',
										icon: 'none'
									});
								}
							}
						});
					} else {
						uni.hideLoading();
						uni.showToast({
							title: '下载失败',
							icon: 'none'
						});
					}
				},
				fail: () => {
					uni.hideLoading();
					uni.showToast({
						title: '下载失败',
						icon: 'none'
					});
				}
			});
		}
	}
};
</script>

<style scoped lang="scss">
@import './adfreeSubscribe.scss';
</style>
