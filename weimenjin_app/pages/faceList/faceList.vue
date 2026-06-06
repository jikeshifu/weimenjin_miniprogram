<template>
	<view class="big-box">
		<view class="background"></view>
		<view class="content">
			<view :class="['top-box', scrollTop > 10 ? 'top-box-active' : '']">
				<view class="search-box">
					<image src="../../static/sousuo.png"></image>
					<input placeholder="请输入关键词" placeholder-class="placeholder" class="search-input"
						confirm-type="search" @confirm="confirm" @input="onSearchInput" v-model="search_key" />
				</view>
			</view>
			<view class="list">
				<view class="item" :class="getExpireClass(item)" v-for="(item, index) in sortedDataList" :key="index">
					<view class="left-box">
						<image :src="getImgPath(item.face_images)" class="user-img"></image>
						<view class="user-info">
							<view class="user-name">{{ item.face_name }}</view>
							<view class="phone">{{ dynamicText }}ID: {{ item.sCertificateNumber }}</view>
							<view class="expire-time" :class="getExpireTextClass(item)">
								<text class="expire-icon">{{ getExpireIcon(item) }}</text>
								{{ formatEndTime(item.end_time) }}
							</view>
						</view>
					</view>
					<view class="right-box">
					<view class="delete-btn" style="background: #3A89FE; margin-bottom: 12rpx;" @click.stop="showDetail(item)">详情</view>
					<view class="delete-btn" style="background: #21CF3E; margin-bottom: 12rpx;" @click.stop="edit(item)">编辑</view>
					<view class="delete-btn" @click.stop="onDelete(item)">删除</view>
					</view>
				</view>
				<uni-load-more :status="noMore" :empty_text="`暂无${dynamicText}～`"></uni-load-more>
			</view>

			<view class="bottom-btn" @click="operation">
				<view class="btn">操作</view>
			</view>
		</view>

		<!-- 人脸详情弹窗 -->
		<view class="detail-modal" v-if="showDetailModal" @click="closeDetailModal">
			<view class="modal-content" @click.stop>
				<view class="modal-header">
					<text class="modal-title">设备上的{{ dynamicText }}信息</text>
					<view class="close-btn" @click="closeDetailModal">×</view>
				</view>
				<view class="modal-body">
					<view class="detail-avatar">
						<image :src="getImgPath(detailInfo.face_images)" mode="aspectFill"></image>
					</view>
					<view class="detail-name">{{ detailInfo.sName }}</view>
					<view class="detail-status" :class="detailInfo.isExpired ? 'status-expired' : (detailInfo.isNormal ? 'status-normal' : 'status-error')">
						{{ detailInfo.isExpired ? '已过期' : (detailInfo.isNormal ? '正常' : '异常') }}
					</view>
					<view class="detail-list">
						<view class="detail-item">
							<view class="detail-icon">🆔</view>
							<view class="detail-label">{{ dynamicText }}ID</view>
							<view class="detail-value">{{ detailInfo.sCertificateNumber }}</view>
						</view>
						<view class="detail-item">
							<view class="detail-icon">⏰</view>
							<view class="detail-label">生效时间</view>
							<view class="detail-value">{{ detailInfo.startTime }}</view>
						</view>
						<view class="detail-item">
							<view class="detail-icon">📅</view>
							<view class="detail-label">过期时间</view>
							<view class="detail-value" :class="detailInfo.isExpired ? 'expired' : ''">{{ detailInfo.endTime }}</view>
						</view>
						<view class="detail-item">
							<view class="detail-icon">📝</view>
							<view class="detail-label">更新时间</view>
							<view class="detail-value">{{ detailInfo.updateTime }}</view>
						</view>
					</view>
				</view>
				<view class="modal-footer">
					<view class="footer-btns">
						<view class="edit-btn" @click="editFromDetail">编辑</view>
						<view class="confirm-btn" @click="closeDetailModal">确定</view>
					</view>
				</view>
			</view>
		</view>

		<!-- 人脸校对结果弹窗 -->
		<view class="detail-modal" v-if="showCompareModal" @click="closeCompareModal">
			<view class="modal-content compare-modal" @click.stop>
				<view class="modal-header">
					<text class="modal-title">{{ dynamicText }}校对结果</text>
					<view class="close-btn" @click="closeCompareModal">×</view>
				</view>
				<view class="modal-body" v-if="compareResult">
					<!-- 统计信息 -->
					<view class="compare-stats">
						<view class="stat-item">
							<text class="stat-label">云端数量</text>
							<text class="stat-value">{{ compareResult.cloud_count }}</text>
						</view>
						<view class="stat-item">
							<text class="stat-label">设备数量</text>
							<text class="stat-value">{{ compareResult.device_count }}</text>
						</view>
						<view class="stat-item" :class="compareResult.diff_count > 0 ? 'stat-warn' : 'stat-ok'">
							<text class="stat-label">差异数量</text>
							<text class="stat-value">{{ compareResult.diff_count }}</text>
						</view>
						<view class="stat-item">
							<text class="stat-label">耗时</text>
							<text class="stat-value">{{ compareResult.duration_ms }}ms</text>
						</view>
					</view>

					<!-- 无差异提示 -->
					<view class="no-diff" v-if="compareResult.diff_count === 0">
						<text class="no-diff-icon">✅</text>
						<text class="no-diff-text">云端与设备数据一致</text>
					</view>

					<!-- 差异列表 -->
					<scroll-view scroll-y class="diff-list" v-if="compareResult.diff_count > 0">
						<!-- 缺失的人脸 -->
						<view v-if="compareResult.differences.missing && compareResult.differences.missing.length > 0">
							<view class="diff-section-title">
								<text class="diff-icon">⚠️</text>
								<text>设备缺失 ({{ compareResult.differences.missing.length }})</text>
							</view>
							<view class="diff-item" v-for="(item, index) in compareResult.differences.missing" :key="'m'+index">
								<view class="diff-info">
									<text class="diff-name">{{ item.face_name }}</text>
									<text class="diff-id">ID: {{ item.sCertificateNumber }}</text>
									<text class="diff-time">过期: {{ item.cloud_end_time_str }}</text>
								</view>
								<view class="sync-btn" @click.stop="syncSingleDiff(item)">同步</view>
							</view>
						</view>

						<!-- 过期时间不一致 -->
						<view v-if="compareResult.differences.expired_mismatch && compareResult.differences.expired_mismatch.length > 0">
							<view class="diff-section-title">
								<text class="diff-icon">🕐</text>
								<text>过期时间不一致 ({{ compareResult.differences.expired_mismatch.length }})</text>
							</view>
							<view class="diff-item" v-for="(item, index) in compareResult.differences.expired_mismatch" :key="'e'+index">
								<view class="diff-info">
									<text class="diff-name">{{ item.face_name }}</text>
									<text class="diff-id">ID: {{ item.sCertificateNumber }}</text>
									<text class="diff-time">云端: {{ item.cloud_end_time_str }}</text>
									<text class="diff-time diff-device">设备: {{ item.device_end_time_str }}</text>
								</view>
								<view class="sync-btn" @click.stop="syncSingleDiff(item)">同步</view>
							</view>
						</view>

						<!-- 设备多余的人脸 -->
						<view v-if="compareResult.differences.extra && compareResult.differences.extra.length > 0">
							<view class="diff-section-title">
								<text class="diff-icon">❓</text>
								<text>设备多余 ({{ compareResult.differences.extra.length }})</text>
							</view>
							<view class="diff-item extra-item" v-for="(item, index) in compareResult.differences.extra" :key="'x'+index">
								<view class="diff-info">
									<text class="diff-name">{{ item.device_name || '未知' }}</text>
									<text class="diff-id">ID: {{ item.sCertificateNumber }}</text>
									<text class="diff-time">过期: {{ item.device_end_time_str }}</text>
								</view>
								<view class="sync-btn del-btn" @click.stop="syncSingleDiff(item)">删除</view>
							</view>
						</view>

						<!-- 设备重复记录 -->
						<view v-if="compareResult.differences.device_duplicate && compareResult.differences.device_duplicate.length > 0">
							<view class="diff-section-title">
								<text class="diff-icon">🔄</text>
								<text>设备重复记录 ({{ compareResult.differences.device_duplicate.length }})</text>
							</view>
							<view class="diff-item dup-item" v-for="(item, index) in compareResult.differences.device_duplicate" :key="'d'+index">
								<view class="diff-info">
									<text class="diff-name">{{ item.name || '未知' }}</text>
									<text class="diff-id">ID: {{ item.sCertificateNumber || item.face_id }}</text>
									<text class="diff-time">重复过期: {{ formatDupTime(item.end_time) }}</text>
									<text class="diff-time diff-keep">保留过期: {{ formatDupTime(item.keep_end_time) }}</text>
								</view>
								<view class="sync-btn del-btn" @click.stop="syncSingleDiff(item)">清理</view>
							</view>
						</view>
					</scroll-view>
				</view>
				<view class="modal-footer" v-if="compareResult && compareResult.diff_count > 0">
					<view class="footer-btns">
						<view class="cancel-btn" @click="closeCompareModal">关闭</view>
						<view class="confirm-btn" :class="{ 'btn-disabled': syncingDiff || isSyncing }" @click="syncAllDiff">
							{{ (syncingDiff || isSyncing) ? '同步中...' : '同步所有差异' }}
						</view>
					</view>
				</view>
				<view class="modal-footer" v-else>
					<view class="footer-btns">
						<view class="confirm-btn" @click="closeCompareModal">确定</view>
					</view>
				</view>
			</view>
		</view>

		<!-- 删除人脸弹窗 -->
		<view class="delete-modal" v-if="showDeleteModal" @click="closeDeleteModal">
			<view class="modal-content" @click.stop>
				<view class="modal-header delete-header">
					<text class="modal-title">删除{{ dynamicText }}</text>
					<view class="close-btn" @click="closeDeleteModal">×</view>
				</view>
				<view class="modal-body">
					<view class="delete-face-info">
						<image :src="getImgPath(deleteItem?.face_images)" class="delete-face-img"></image>
						<view class="delete-face-name">{{ deleteItem?.face_name }}</view>
					</view>
					<view class="delete-tip">确定删除当前设备上的该{{ dynamicText }}吗？</view>

					<!-- 同步删除其他设备 -->
					<view class="sync-delete-section" v-if="faceDevices.length > 0">
						<view class="sync-delete-header">
							<text class="sync-delete-title">同时删除其他设备上的此{{ dynamicText }}</text>
						</view>
						<view class="device-list">
							<view
								class="device-item"
								v-for="device in faceDevices"
								:key="device.lock_id"
								@click="toggleDeleteDevice(device.lock_id)"
							>
								<view class="device-checkbox" :class="{ checked: selectedDeleteDevices.includes(device.lock_id) }">
									<text v-if="selectedDeleteDevices.includes(device.lock_id)">✓</text>
								</view>
								<view class="device-info">
									<view class="device-name">{{ device.lock_name }}</view>
									<view class="device-sn">{{ device.lock_sn }}</view>
								</view>
							</view>
						</view>
						<view class="sync-count" v-if="selectedDeleteDevices.length > 0">
							已选择 {{ selectedDeleteDevices.length }} 台设备
						</view>
					</view>
				</view>
				<view class="modal-footer delete-footer">
					<view class="cancel-btn" @click="closeDeleteModal">取消</view>
					<view class="delete-confirm-btn" @click="confirmDelete" :class="{ loading: deleteLoading }">
						{{ deleteLoading ? '删除中...' : '确定删除' }}
					</view>
				</view>
			</view>
		</view>

		<!-- 删除结果弹窗 -->
		<view class="result-modal" v-if="showDeleteResultModal" @click.self="closeDeleteResultModal">
			<view class="result-modal-content">
				<view class="result-header" :class="deleteResultData.headerClass">
					<view class="result-icon">{{ deleteResultData.icon }}</view>
					<view class="result-title">{{ deleteResultData.title }}</view>
				</view>
				<view class="result-body">
					<!-- 当前设备 -->
					<view class="result-section current-device">
						<view class="section-label">当前设备</view>
						<view class="device-result success">
							<view class="device-result-icon">✓</view>
							<view class="device-result-info">
								<view class="device-result-name">{{ deleteResultData.currentDevice }}</view>
								<view class="device-result-status">删除成功</view>
							</view>
						</view>
					</view>
					<!-- 同步删除设备 -->
					<view class="result-section sync-devices" v-if="deleteResultData.syncResults && deleteResultData.syncResults.length > 0">
						<view class="section-label">同步删除其他设备</view>
						<view
							class="device-result"
							:class="item.status"
							v-for="(item, index) in deleteResultData.syncResults"
							:key="index"
						>
							<view class="device-result-icon">{{ item.status === 'success' ? '✓' : (item.status === 'offline' ? '⚠' : (item.status === 'skip' ? '○' : '✗')) }}</view>
							<view class="device-result-info">
								<view class="device-result-name">{{ item.lock_name }}</view>
								<view class="device-result-status">{{ item.msg || (item.status === 'success' ? '删除成功' : (item.status === 'offline' ? '设备离线' : (item.status === 'skip' ? '云端无此记录' : item.error))) }}</view>
							</view>
						</view>
					</view>
				</view>
				<view class="result-footer">
					<view class="result-btn" @click="closeDeleteResultModal">确定</view>
				</view>
			</view>
		</view>

		<!-- 异步同步进度弹窗 -->
		<view class="sync-modal-overlay" v-if="showSyncProgressModal">
			<view class="sync-modal-box" @click.stop>
				<view class="sync-modal-header" :class="asyncSyncTask?.status === 'finished' ? 'header-success' : (asyncSyncTask?.status === 'failed' ? 'header-fail' : 'header-processing')">
					<text class="sync-modal-title">{{ asyncSyncTask?.status === 'finished' ? '同步完成' : (asyncSyncTask?.status === 'failed' ? '同步失败' : '正在同步...') }}</text>
					<text class="sync-modal-subtitle" v-if="asyncSyncTask?.is_existing && asyncSyncTask?.status !== 'finished'">（已恢复未完成任务）</text>
				</view>
				<view class="sync-modal-body" v-if="asyncSyncTask">
					<!-- 进度条 -->
					<view class="sync-progress-bar-wrap">
						<view class="sync-progress-bar-bg">
							<view class="sync-progress-bar-fill" :style="{ width: asyncSyncTask.progress + '%' }"></view>
						</view>
						<view class="sync-progress-percent">{{ asyncSyncTask.progress }}%</view>
					</view>

					<!-- 统计信息 -->
					<view class="sync-stats-row">
						<view class="sync-stats-col">
							<view class="sync-stats-num">{{ asyncSyncTask.processed_count }}</view>
							<view class="sync-stats-label">已处理</view>
						</view>
						<view class="sync-stats-col">
							<view class="sync-stats-num num-total">{{ asyncSyncTask.total_count }}</view>
							<view class="sync-stats-label">总数</view>
						</view>
						<view class="sync-stats-col">
							<view class="sync-stats-num num-success">{{ asyncSyncTask.success_count }}</view>
							<view class="sync-stats-label">成功</view>
						</view>
						<view class="sync-stats-col">
							<view class="sync-stats-num num-fail">{{ asyncSyncTask.failed_count }}</view>
							<view class="sync-stats-label">失败</view>
						</view>
					</view>

					<!-- 处理中提示 -->
					<view class="sync-tip-box" v-if="asyncSyncTask.status !== 'finished' && asyncSyncTask.status !== 'failed'">
						<text>请勿关闭页面，正在同步第 {{ asyncSyncTask.processed_count + 1 }} / {{ asyncSyncTask.total_count }} 条...</text>
					</view>

					<!-- 错误信息 -->
					<view class="sync-error-box" v-if="asyncSyncTask.error_msg">
						<text>{{ asyncSyncTask.error_msg }}</text>
					</view>
				</view>
				<view class="sync-modal-footer">
					<view class="sync-modal-btn" :class="{ 'btn-processing': asyncSyncTask?.status !== 'finished' && asyncSyncTask?.status !== 'failed' }" @click="closeSyncProgressModal">
						{{ asyncSyncTask?.status === 'finished' || asyncSyncTask?.status === 'failed' ? '确定' : '后台运行' }}
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	import { faceList_api, delFace_api, clearFaces_api, findFace_api, compareFace_api, syncDiffFace_api, getFaceDevices_api, delFaceFromDevices_api, createSyncTask_api, getSyncTaskProgress_api, processSyncTask_api, cleanDuplicateFace_api } from '@/api/index.js'
	import { imgPath } from '@/libs/filters.js'
	export default {
		data() {
			return {
				scrollTop: 0,
				search_key: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				lock_id: '',
				isAdmin: false, // 是否为管理员
				face_text: '图片', // 默认值为 "图片"
				showDetailModal: false, // 详情弹窗显示状态
				detailInfo: {}, // 详情信息
				currentDetailItem: null, // 当前查看详情的item
				searchTimer: null, // 搜索防抖定时器
				showCompareModal: false, // 校对结果弹窗
				compareResult: null, // 校对结果数据
				syncingDiff: false, // 是否正在同步差异
				// 异步同步相关
				asyncSyncTask: null, // 异步同步任务信息
				asyncSyncProgress: 0, // 异步同步进度
				showSyncProgressModal: false, // 同步进度弹窗
				isSyncing: false, // 全局同步状态锁，防止重复操作
				// 删除相关
				showDeleteModal: false, // 删除弹窗
				deleteItem: null, // 待删除的人脸
				faceDevices: [], // 可删除的设备列表
				selectedDeleteDevices: [], // 选中要删除的设备
				deleteLoading: false, // 删除中
				// 删除结果弹窗
				showDeleteResultModal: false,
				deleteResultData: {
					title: '',
					icon: '',
					headerClass: '',
					currentDevice: '',
					syncResults: []
				}
			}
		},
		computed: {
			// 动态替换 "人脸" 为 face_text
			dynamicText() {
				return this.face_text;
			},
			// 按过期时间排序的列表：已过期 > 即将过期(7天内) > 正常
			sortedDataList() {
				const now = Math.floor(Date.now() / 1000);
				const sevenDays = 7 * 24 * 60 * 60;
				const PERMANENT = 2147483647; // 永久有效

				return [...this.dataList].sort((a, b) => {
					const aEnd = a.end_time || PERMANENT;
					const bEnd = b.end_time || PERMANENT;

					// 计算状态优先级：已过期=0，即将过期=1，正常=2，永久=3
					const getPriority = (endTime) => {
						if (endTime === PERMANENT || endTime === 0) return 3; // 永久有效排最后
						if (endTime < now) return 0; // 已过期最优先
						if (endTime - now <= sevenDays) return 1; // 即将过期次之
						return 2; // 正常
					};

					const aPriority = getPriority(aEnd);
					const bPriority = getPriority(bEnd);

					// 优先级不同按优先级排序
					if (aPriority !== bPriority) {
						return aPriority - bPriority;
					}

					// 同优先级按过期时间升序（更早过期的在前）
					return aEnd - bEnd;
				});
			}
		},
		onPageScroll(e) {
			this.scrollTop = e.scrollTop
		},
		onLoad(option) {
			this.lock_id = option.lock_id;
			this.isAdmin = option.auth_isadmin === '1'; // 从参数中判断是否为管理员
			this.face_text = option.face_text || '图片'; // 动态替换 "人脸" 为传入的 face_text 或默认值
			this.page = 1; // 确保从第一页开始加载
			this.dataList = []; // 清空数据列表
			this.getList(); // 调用数据加载方法
		},
		onShow() {
		    this.page = 1;
		    this.dataList = [];
		    this.getList();
		},
		methods: {
			async showDetail(item) {
				uni.showLoading({ title: '查询中...', mask: true });
				try {
					const res = await findFace_api({
						lock_id: item.lock_id || this.lock_id,
						face_id: item.sCertificateNumber
					});
					uni.hideLoading();

					if (res.code === 0 && res.data && res.data.info) {
						const info = res.data.info;
						const now = Math.floor(Date.now() / 1000);
						const isExpired = info.iEndTime !== 2147483647 && info.iEndTime < now;

						this.detailInfo = {
							face_images: item.face_images,
							sName: info.sName || info.name || item.face_name,
							sCertificateNumber: info.sCertificateNumber || info.face_id,
							startTime: info.iBeginTime === 0 ? '立即生效' : this.formatTimestamp(info.iBeginTime),
							endTime: info.iEndTime === 2147483647 ? '永久有效' : this.formatTimestamp(info.iEndTime),
							updateTime: info.sRegistrationTime || '-',
							isNormal: info.stateCode === 200,
							isExpired: isExpired
						};
						this.currentDetailItem = item; // 保存当前item用于编辑
						this.showDetailModal = true;
					} else {
						uni.showToast({
							title: res.msg || `${this.dynamicText}不存在或已删除`,
							icon: 'none'
						});
					}
				} catch (error) {
					uni.hideLoading();
					uni.showToast({
						title: '查询失败，请重试',
						icon: 'none'
					});
				}
			},
			closeDetailModal() {
				this.showDetailModal = false;
				this.detailInfo = {};
				this.currentDetailItem = null;
			},
			editFromDetail() {
				if (this.currentDetailItem) {
					const item = this.currentDetailItem; // 先保存引用
					this.closeDetailModal();
					this.edit(item); // 使用保存的引用
				}
			},
			formatTimestamp(timestamp) {
				if (!timestamp) return '未设置';
				const date = new Date(timestamp * 1000);
				const year = date.getFullYear();
				const month = (date.getMonth() + 1).toString().padStart(2, '0');
				const day = date.getDate().toString().padStart(2, '0');
				const hours = date.getHours().toString().padStart(2, '0');
				const minutes = date.getMinutes().toString().padStart(2, '0');
				return `${year}-${month}-${day} ${hours}:${minutes}`;
			},
			// 格式化过期时间显示
			formatEndTime(endTime) {
				const PERMANENT = 2147483647;
				if (!endTime || endTime === 0 || endTime === PERMANENT) {
					return '永久有效';
				}
				const now = Math.floor(Date.now() / 1000);
				const diff = endTime - now;

				if (diff < 0) {
					// 已过期
					const expiredDays = Math.abs(Math.floor(diff / (24 * 60 * 60)));
					if (expiredDays === 0) {
						return '今天已过期';
					} else if (expiredDays === 1) {
						return '昨天已过期';
					} else {
						return `已过期${expiredDays}天`;
					}
				} else if (diff <= 7 * 24 * 60 * 60) {
					// 7天内即将过期
					const days = Math.floor(diff / (24 * 60 * 60));
					if (days === 0) {
						const hours = Math.floor(diff / (60 * 60));
						if (hours === 0) {
							return '即将过期';
						}
						return `${hours}小时后过期`;
					} else if (days === 1) {
						return '明天过期';
					} else {
						return `${days}天后过期`;
					}
				} else {
					// 正常显示日期
					return this.formatTimestamp(endTime);
				}
			},
			// 获取过期状态的 CSS class（用于整行样式）
			getExpireClass(item) {
				const PERMANENT = 2147483647;
				const endTime = item.end_time;
				if (!endTime || endTime === 0 || endTime === PERMANENT) {
					return '';
				}
				const now = Math.floor(Date.now() / 1000);
				if (endTime < now) {
					return 'item-expired';
				} else if (endTime - now <= 7 * 24 * 60 * 60) {
					return 'item-expiring';
				}
				return '';
			},
			// 获取过期时间文字的 CSS class
			getExpireTextClass(item) {
				const PERMANENT = 2147483647;
				const endTime = item.end_time;
				if (!endTime || endTime === 0 || endTime === PERMANENT) {
					return 'expire-permanent';
				}
				const now = Math.floor(Date.now() / 1000);
				if (endTime < now) {
					return 'expire-text-expired';
				} else if (endTime - now <= 7 * 24 * 60 * 60) {
					return 'expire-text-warning';
				}
				return 'expire-text-normal';
			},
			// 获取过期状态图标
			getExpireIcon(item) {
				const PERMANENT = 2147483647;
				const endTime = item.end_time;
				if (!endTime || endTime === 0 || endTime === PERMANENT) {
					return '♾️';
				}
				const now = Math.floor(Date.now() / 1000);
				if (endTime < now) {
					return '⚠️';
				} else if (endTime - now <= 7 * 24 * 60 * 60) {
					return '⏰';
				}
				return '📅';
			},
			// 格式化重复记录的时间
			formatDupTime(timestamp) {
				if (!timestamp || timestamp === 0) return '未知';
				if (timestamp === 2147483647) return '永久有效';
				const date = new Date(timestamp * 1000);
				const year = date.getFullYear();
				const month = (date.getMonth() + 1).toString().padStart(2, '0');
				const day = date.getDate().toString().padStart(2, '0');
				const hours = date.getHours().toString().padStart(2, '0');
				const minutes = date.getMinutes().toString().padStart(2, '0');
				return `${year}-${month}-${day} ${hours}:${minutes}`;
			},
			edit(item) {
				// 优先使用item中的lock_id，如果没有则使用页面的lock_id
				const lockId = item.lock_id || this.lock_id;
				uni.navigateTo({
					url: '/pages/addFace/addFace?lock_id=' + lockId + '&item=' + encodeURIComponent(JSON.stringify(item))
				})
			},
			getImgPath(url) {
			    return imgPath(url);
			  },
			async onDelete(item) {
				// 显示删除弹窗
				this.deleteItem = item;
				this.selectedDeleteDevices = [];
				this.showDeleteModal = true;

				// 获取用户有权限的其他人脸设备（后端已过滤当前设备）
				try {
					const res = await getFaceDevices_api({ exclude_lock_id: this.lock_id });
					console.log('getFaceDevices_api 返回:', res);
					if (res.code == 0 && res.data) {
						// 双重过滤确保不显示当前设备
						this.faceDevices = res.data.filter(d => d.lock_id != this.lock_id);
					}
				} catch (e) {
					console.log('获取设备列表失败', e);
				}
			},
			closeDeleteModal() {
				this.showDeleteModal = false;
				this.deleteItem = null;
				this.faceDevices = [];
				this.selectedDeleteDevices = [];
			},
			toggleDeleteDevice(lockId) {
				const index = this.selectedDeleteDevices.indexOf(lockId);
				if (index > -1) {
					this.selectedDeleteDevices.splice(index, 1);
				} else {
					this.selectedDeleteDevices.push(lockId);
				}
			},
			async confirmDelete() {
				if (this.deleteLoading) return;
				this.deleteLoading = true;

				// 获取当前设备名称
				const currentDeviceName = this.faceDevices.find(d => d.lock_id == this.lock_id)?.lock_name || '当前设备';

				try {
					// 1. 先删除当前设备的人脸
					let res = await delFace_api({
						face_id: this.deleteItem.face_id,
						lock_id: this.deleteItem.lock_id || this.lock_id
					});
					console.log('delFace_api 返回:', res);

					// 兼容 code 为数字或字符串
					if (res.code != 0) {
						uni.showToast({ title: res.msg || '删除失败', icon: 'none' });
						this.deleteLoading = false;
						return;
					}

					// 2. 如果选择了同步删除其他设备
					if (this.selectedDeleteDevices.length > 0) {
						const syncRes = await delFaceFromDevices_api({
							source_lock_id: this.lock_id,
							face_id: this.deleteItem.face_id,
							target_lock_ids: this.selectedDeleteDevices,
							face_images: this.deleteItem.face_images
						});
						console.log('delFaceFromDevices_api 返回:', syncRes);

						// 解析结果并显示结果弹窗
						const successCount = syncRes.success_count || 0;
						const failCount = syncRes.fail_count || 0;
						const offlineCount = syncRes.offline_count || 0;
						const results = syncRes.results || [];
						const syncDeviceCount = this.selectedDeleteDevices.length;

						// 计算整体成功率（当前设备算1台成功）
						const totalDevices = 1 + syncDeviceCount;
						const totalSuccess = 1 + successCount;
						const allSuccess = totalSuccess === totalDevices;
						const allFailed = successCount === 0 && syncDeviceCount > 0;

						// 设置结果弹窗数据
						this.deleteResultData = {
							title: allSuccess ? '全部成功' : (allFailed ? '删除失败' : '部分成功'),
							icon: allSuccess ? '✓' : (allFailed ? '✗' : '!'),
							headerClass: allSuccess ? 'success' : (allFailed ? 'fail' : 'partial'),
							currentDevice: currentDeviceName,
							syncResults: results
						};

						this.closeDeleteModal();
						this.showDeleteResultModal = true;
					} else {
						uni.showToast({ title: `${this.dynamicText}删除成功！`, icon: 'none' });
						this.closeDeleteModal();
					}

					this.dataList = [];
					this.page = 1;
					this.getList();
				} catch (e) {
					console.error('删除失败:', e);
					uni.showToast({ title: '删除失败: ' + (e.message || e), icon: 'none' });
				} finally {
					this.deleteLoading = false;
				}
			},
			closeDeleteResultModal() {
				this.showDeleteResultModal = false;
				this.deleteResultData = {
					title: '',
					icon: '',
					headerClass: '',
					currentDevice: '',
					syncResults: []
				};
			},
			async getList() {
				this.noMore = 'loading';
				let params = {
					page: this.page,
					limit: 10,
					lock_id: this.lock_id,
					search_key: this.search_key
				};
				let res = await faceList_api(params);
				if (res.data && res.data.length > 0) {
					this.dataList = this.page === 1 ? res.data : this.dataList.concat(res.data);
					this.noMore = res.data.length < 10 ? 'noMore' : 'loading';
				} else {
					this.noMore = this.page === 1 ? 'nodata' : 'noMore';
				}
			},
			confirm(e) {
				this.search_key = e.detail.value
				this.dataList = [];
				this.page = 1;
				this.getList()
			},
			onSearchInput(e) {
				// 防抖处理，300ms后触发搜索
				if (this.searchTimer) {
					clearTimeout(this.searchTimer);
				}
				this.searchTimer = setTimeout(() => {
					this.dataList = [];
					this.page = 1;
					this.getList();
				}, 300);
			},
			operation() {
				const itemList = [`添加自拍${this.dynamicText}`];
				if (this.isAdmin) {
					itemList.push(`复制${this.dynamicText}到其它设备`, `${this.dynamicText}校对同步`, `清空设备${this.dynamicText}`, `清空云端及设备${this.dynamicText}`);
				}
				uni.showActionSheet({
					itemList,
					success: (res) => {
						if (res.tapIndex === 0) {
							uni.navigateTo({
								url: '/pages/addFace/addFace?lock_id=' + this.lock_id
							})
						} else if (res.tapIndex === 1 && this.isAdmin) {
							uni.navigateTo({
								url: '/pages/synchroData/synchroData?lock_id=' + this.lock_id + '&type=face'
							})
						} else if (res.tapIndex === 2 && this.isAdmin) {
							this.compareFaces();
						} else if (res.tapIndex === 3 && this.isAdmin) {
							this.clearFaces('local');
						} else if (res.tapIndex === 4 && this.isAdmin) {
							this.clearFaces('cloud');
						}
					},
				});
			},
			async clearFaces(type) {
				const content = type === 'local'
					? `确定清空设备${this.dynamicText}数据吗？此操作不可恢复！`
					: `确定清空云端及设备所有${this.dynamicText}数据吗？此操作不可恢复！`;

				uni.showModal({
					title: '警告',
					content,
					success: async (res) => {
						if (res.confirm) {
							uni.showLoading({
								title: '清空中...',
								mask: true
							});
							let response = await clearFaces_api({ lock_id: this.lock_id, type });
							uni.hideLoading();
							if (response.code === 0) {
								const message = type === 'local'
									? `设备${this.dynamicText}清空成功！`
									: `云端及设备${this.dynamicText}清空成功！`;
								uni.showToast({
									title: message,
									icon: 'none'
								});
								this.dataList = [];
								this.page = 1;
								this.getList();
							} else {
								uni.showToast({
									title: response.msg,
									icon: 'none'
								});
							}
						}
					}
				});
			},
			// 人脸校对
			async compareFaces() {
				uni.showLoading({ title: '正在校对...', mask: true });
				try {
					const res = await compareFace_api({ lock_id: this.lock_id });
					uni.hideLoading();

					if (res.code === 0) {
						// 接口直接返回数据在根对象中，如果有data则用data，否则用整个res
						this.compareResult = res.data || res;
						this.showCompareModal = true;
					} else {
						uni.showToast({
							title: res.msg || '校对失败',
							icon: 'none'
						});
					}
				} catch (error) {
					uni.hideLoading();
					uni.showToast({
						title: '校对失败，请重试',
						icon: 'none'
					});
				}
			},
			// 关闭校对弹窗
			closeCompareModal() {
				this.showCompareModal = false;
				this.compareResult = null;
			},
			// 同步所有差异到设备
			async syncAllDiff() {
				// 防止重复点击
				if (!this.compareResult || this.syncingDiff || this.isSyncing) {
					if (this.isSyncing) {
						uni.showToast({ title: '正在同步中，请稍候...', icon: 'none' });
					}
					return;
				}

				const diff = this.compareResult.differences;
				const allDiff = [
					...(diff.missing || []),
					...(diff.expired_mismatch || []),
					...(diff.extra || []),
					...(diff.device_duplicate || [])
				];

				if (allDiff.length === 0) {
					uni.showToast({
						title: '没有需要同步的数据',
						icon: 'none'
					});
					return;
				}

				const extraCount = (diff.extra || []).length;
				const dupCount = (diff.device_duplicate || []).length;
				const mismatchCount = (diff.expired_mismatch || []).length;
				const missingCount = (diff.missing || []).length;
				let contentText = `确定同步 ${allDiff.length} 个差异${this.dynamicText}吗？`;

				// 构建详细提示
				const details = [];
				if (missingCount > 0) details.push(`添加${missingCount}个`);
				if (mismatchCount > 0) details.push(`更新${mismatchCount}个时间`);
				if (extraCount > 0) details.push(`删除${extraCount}个多余`);
				if (dupCount > 0) details.push(`清理${dupCount}个重复`);

				if (details.length > 0) {
					contentText = `将${details.join('、')}${this.dynamicText}，确定执行吗？`;
				}

				uni.showModal({
					title: '确认同步',
					content: contentText,
					success: async (modalRes) => {
						if (modalRes.confirm) {
							// 差异数量超过5个使用异步同步
							if (allDiff.length > 5) {
								this.startAsyncSync(allDiff);
							} else {
								// 少量数据使用同步方式
								this.syncingDiff = true;
								this.isSyncing = true;
								uni.showLoading({ title: '同步中...', mask: true });

								try {
									const res = await syncDiffFace_api({
										lock_id: this.lock_id,
										faces: allDiff
									});
									uni.hideLoading();
									this.syncingDiff = false;
									this.isSyncing = false;

									if (res.code === 0) {
										uni.showToast({
											title: res.msg || res.data?.msg || '同步完成',
											icon: 'none',
											duration: 2000
										});
										// 重新校对查看结果
										setTimeout(() => {
											this.compareFaces();
										}, 1500);
									} else {
										uni.showToast({
											title: res.msg || '同步失败',
											icon: 'none'
										});
									}
								} catch (error) {
									uni.hideLoading();
									this.syncingDiff = false;
									this.isSyncing = false;
									uni.showToast({
										title: '同步失败，请重试',
										icon: 'none'
									});
								}
							}
						}
					}
				});
			},
			// 开始异步同步
			async startAsyncSync(faces) {
				// 双重检查防止重复
				if (this.isSyncing) {
					uni.showToast({ title: '同步进行中，请勿重复操作', icon: 'none' });
					return;
				}

				this.syncingDiff = true;
				this.isSyncing = true;
				uni.showLoading({ title: '创建同步任务...', mask: true });

				try {
					// 1. 创建异步任务（后端会检查是否已存在未完成任务）
					const createRes = await createSyncTask_api({
						lock_id: this.lock_id,
						faces: faces
					});

					if (createRes.code != 0) {
						uni.hideLoading();
						this.syncingDiff = false;
						this.isSyncing = false;
						uni.showToast({ title: createRes.msg || '创建任务失败', icon: 'none' });
						return;
					}

					const data = createRes.data || createRes;
					const taskId = data.task_id;
					const isExisting = data.is_existing || false;

					// 初始化任务信息
					this.asyncSyncTask = {
						task_id: taskId,
						total_count: data.total_count || faces.length,
						processed_count: data.processed_count || 0,
						success_count: data.success_count || 0,
						failed_count: data.failed_count || 0,
						progress: data.progress || 0,
						status: data.status || 'processing',
						is_existing: isExisting
					};

					uni.hideLoading();

					// 如果是恢复已有任务，给用户提示
					if (isExisting) {
						uni.showToast({
							title: '检测到未完成任务，已恢复',
							icon: 'none',
							duration: 1500
						});
					}

					this.showSyncProgressModal = true;
					this.closeCompareModal();

					// 2. 循环处理任务
					await this.processAsyncSyncLoop(taskId);

				} catch (error) {
					uni.hideLoading();
					this.syncingDiff = false;
					this.isSyncing = false;
					uni.showToast({ title: '创建任务失败，请重试', icon: 'none' });
				}
			},
			// 循环处理异步同步任务
			async processAsyncSyncLoop(taskId) {
				let hasMore = true;

				while (hasMore) {
					try {
						const res = await processSyncTask_api({
							task_id: taskId,
							batch_size: 5
						});

						if (res.code != 0) {
							this.asyncSyncTask.status = 'failed';
							this.asyncSyncTask.error_msg = res.msg || '处理失败';
							break;
						}

						// 更新进度
						const data = res.data || res;
						this.asyncSyncTask.processed_count = data.processed_count || 0;
						this.asyncSyncTask.success_count = data.success_count || 0;
						this.asyncSyncTask.failed_count = data.failed_count || 0;
						this.asyncSyncTask.progress = data.progress || 0;
						this.asyncSyncTask.status = data.status;

						hasMore = data.has_more;

						if (!hasMore) {
							this.asyncSyncTask.status = 'finished';
						}

						// 间隔300ms继续处理
						if (hasMore) {
							await this.sleep(300);
						}
					} catch (error) {
						this.asyncSyncTask.status = 'failed';
						this.asyncSyncTask.error_msg = '网络错误';
						break;
					}
				}

				this.syncingDiff = false;
				this.isSyncing = false;
			},
			// 关闭同步进度弹窗
			closeSyncProgressModal() {
				// 如果任务还在进行中，询问是否确认关闭
				if (this.asyncSyncTask && (this.asyncSyncTask.status === 'processing' || this.isSyncing)) {
					uni.showModal({
						title: '提示',
						content: '同步任务正在进行中，关闭后任务将在后台继续执行。确定关闭吗？',
						success: (res) => {
							if (res.confirm) {
								this.doCloseSyncProgressModal();
							}
						}
					});
				} else {
					this.doCloseSyncProgressModal();
				}
			},
			// 实际关闭弹窗逻辑
			doCloseSyncProgressModal() {
				this.showSyncProgressModal = false;
				this.asyncSyncTask = null;
				this.syncingDiff = false;
				this.isSyncing = false;
				// 重新加载列表
				this.page = 1;
				this.dataList = [];
				this.getList();
			},
			// 延时函数
			sleep(ms) {
				return new Promise(resolve => setTimeout(resolve, ms));
			},
			// 同步单个差异
			async syncSingleDiff(item) {
				if (this.syncingDiff) return;

				this.syncingDiff = true;
				uni.showLoading({ title: '同步中...', mask: true });

				try {
					const res = await syncDiffFace_api({
						lock_id: this.lock_id,
						faces: [item]
					});
					uni.hideLoading();
					this.syncingDiff = false;

					if (res.code === 0) {
						uni.showToast({
							title: '同步成功',
							icon: 'success'
						});
						// 重新校对
						setTimeout(() => {
							this.compareFaces();
						}, 1000);
					} else {
						uni.showToast({
							title: res.msg || '同步失败',
							icon: 'none'
						});
					}
				} catch (error) {
					uni.hideLoading();
					this.syncingDiff = false;
					uni.showToast({
						title: '同步失败',
						icon: 'none'
					});
				}
			}
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++;
			this.getList();
		},
		async onPullDownRefresh() {
			this.page = 1;
			this.dataList = [];
			await this.getList();
			uni.stopPullDownRefresh();
		}
	}
</script>

<style scoped lang="scss">
	@import './faceList.scss';
</style>
