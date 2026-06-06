<template>
	<view>
		<!-- #ifdef APP-PLUS -->
		<custom-nav-bar title="微门禁" @plus-click="onTopPlusClick"></custom-nav-bar>
		<!-- #endif -->
		<view class="content">
			<view class="background"></view>
			<view class="big-box">
				<view class="cell-box">
					<view class="equipment">
						<view class="flex-box" @click="clickGrouping">
							<view class="name">{{ device_group_name }}</view>
							<i class="iconfont icon-xiala"></i>
						</view>
						<view class="position" v-if="grouping_show">
							<view class="icon">
								<image src="../../static/sanjiao.png"></image>
							</view>
						</view>
					</view>
					<!-- 搜索框 -->
					<view class="search-box">
						<view class="search-input-wrap">
							<text class="search-icon-text">🔍</text>
							<input
								class="search-input"
								type="text"
								v-model="searchKeyword"
								placeholder="序列号/名称/分组"
								placeholder-class="search-placeholder"
								@input="onSearchInput"
								@confirm="onSearchConfirm"
							/>
							<i class="iconfont icon-guanbi clear-icon" v-if="searchKeyword" @click="clearSearch"></i>
							<i class="iconfont icon-saoyisao scan-icon" @click="onScanSearch"></i>
						</view>
					</view>
					<view class="list-box" v-if="grouping_show">
						<view class="scroll-box">
							<view :class="['item', item.device_group_id == grouping_index ? 'active' : '']"
								v-for="(item, index) in groupingList" :key="index" @click="changeGrouping(item)">
								<view class="name">{{ item.device_group_name }}</view>
								<image src="../../static/queding.png" class="pitch-on"
									v-if="item.device_group_id == grouping_index"></image>
							</view>
						</view>
						<view class="manage" @click="goGrouping">
							<view class="text">分组管理</view>
							<image src="../../static/shezhi-on.png"></image>
						</view>

					</view>
				</view>
				<view class="list">
					<view v-for="(item, index) in dataList" :key="index"
						:class="['item', item.loading ? 'loading' : '', item.status !== 1 || item.lock.switch_state ? 'item-on' : '']">
						<!-- 超级管理员标识 -->
						<view v-if="item.auth_isadmin === 1 && item.auth_member_id === 0" class="super-admin-badge">
							<span class="super-admin-text">超管</span>
						</view>
						<view v-if="item.auth_isadmin === 1 && item.auth_member_id !== 0" class="admin-badge">
							<span class="admin-text">管理员</span>
						</view>
						<view class="flex-box">
							<view class="share" style="display: flex; align-items: center;" @click="onShare(item)">
							  <image src="../../static/fenxiang.png" v-if="item.status !== 1 || item.lock.switch_state"></image>
							  <block v-else>
							    <image src="../../static/fenxiang-on.png" v-if="item.lock.online == 1"></image>
							    <image src="../../static/fenxiang-hui.png" v-else></image>
							  </block>
							  <text style="font-size: 28rpx; margin-left: 10rpx;">分享</text>
							</view>
							<view class="site" @click="changeSite(index,item)">
								<image src="../../static/shezhi.png" v-if="item.status !== 1 ||item.lock.switch_state">
								</image>
								<block v-else>
									<image src="../../static/shezhi-on.png" v-if="item.lock.online == 1"></image>
									<image src="../../static/shezhi-hui.png" v-else></image>
								</block>
								<image src="../../static/sanjiao.png" class="position-icon" v-if="set_index == index">
								</image>
							</view>
						</view>

						<view class="name">
							<view class="text" v-if="item.lock">{{ item.lock.lock_name }}</view>
						</view>
						<view class="indate" v-if="item.lock">{{ item.auth_starttime1 }}</view>
						<view class="indate" v-if="item.lock">{{ item.auth_endtime1 }}</view>

						<view class="key">
							<!-- W75/W76F/4GSwitch 始终使用绿色按钮，独立于其他设备状态 -->
							<view class="btn" @click="on4GSwitch(item)" v-if="item.device_type === '4GSwitch'">
								<image src="../../static/4GSwitch.png" style="width: 24px; height: 24px;"></image>
							</view>
							<view class="btn" @click="onW76FSwitch(item)" v-if="item.device_type === 'W76F'">
								<i class="iconfont icon-ruanjianshezhi icon-default"></i>
							</view>
							<view class="btn" @click="onW75Cabinet(item)" v-if="(item.device_type === 'cabinet' || item.device_type === 'W75') && item.auth_isadmin == 1">
								<i class="iconfont icon-menjin icon-default"></i>
							</view>
							<!-- 其他设备类型：根据状态显示 btn-on -->
							<view class="btn btn-on" v-if="(item.lock.status !== 1 || item.lock.switch_state) && item.device_type !== '4GSwitch' && item.device_type !== 'W76F' && item.device_type !== 'W75' && item.device_type !== 'cabinet'">
								<i class="iconfont icon-yuechi icon-default icon-on" :class="{'key-rotating': item.isRotating}" @click="unlocking(item,index)"
									v-if="item.device_type === 'lock'"></i>
								<i class="iconfont icon-yuechi icon-default icon-on" :class="{'key-rotating': item.isRotating}"
									v-if="item.device_type === 'switchLock'"></i>
								<i class="iconfont icon-shandian icon-default icon-on" @click="onSwitch(item)"
									v-if="item.device_type === 'switch'"></i>
								<i class="iconfont icon-laba icon-default icon-on"
									v-if="item.device_type === 'horn'"></i>
								<i class="iconfont icon-laba icon-default icon-on"
										v-if="item?.lock?.lock_sn && checkCamerString(item.lock.lock_sn)"></i>
								<i class="iconfont icon-shandian icon-default icon-on" @click="onW71SwitchToggle(item)"
								   v-if="item.device_type === 'W71Switch'"></i>
							</view>
							<!-- 其他设备类型：正常状态显示绿色按钮 -->
							<block v-if="!(item.lock.status !== 1 || item.lock.switch_state) && item.device_type !== '4GSwitch' && item.device_type !== 'W76F' && item.device_type !== 'W75' && item.device_type !== 'cabinet'">
								<view class="btn" @click="unlocking(item,index)" v-if="item.device_type === 'lock'">
									<i class="iconfont icon-yuechi icon-default" :class="{'key-rotating': item.isRotating}"></i>
								</view>
								<view class="btn" @click="onSwitch(item)" v-if="item.device_type === 'switch'">
									<i class="iconfont icon-shandian icon-default"></i>
								</view>
								<view class="btn" @click="onSwitchLock(item)" v-if="item.device_type === 'switchLock'">
									<i class="iconfont icon-yuechi  icon-default" :class="{'key-rotating': item.isRotating}"></i>
								</view>
								<view class="btn" @click="onPlay(item)" v-if="item.device_type === 'horn'">
									<i class="iconfont icon-laba icon-default"></i>
								</view>
								<view class="btn" @click="onCamer(item)" v-if="item.device_type === 'camera'">
									<image src="../../static/camera.png" style="width: 38px; height: 38px;"></image>
								</view>
								<view class="btn" @click="onW71SwitchToggle(item)" v-if="item.device_type === 'W71Switch'">
									<i class="iconfont icon-shandian icon-default"></i>
								</view>
							</block>
						</view>
						<view class="indate" v-if="item.lock">{{ item.auth_limit }}</view>
						<view class="status-badge" :class="item.lock.online === 1 ? 'online' : 'offline'">
							<view class="status-dot"></view>
							<view class="status-text">{{ item.lock.online === 1 ? '在线' : '离线' }}</view>
						</view>
						<view class="pop-up-box" v-if="set_index === index"
							:style="{ left: set_index % 2 == 0 ? '20rpx' : 'initial', right: set_index % 2 == 0 ? 'initial' : '20rpx'}">
							<view class="cell-list">
								<block v-if="item.auth_isadmin === 1">
									<view class="cell-item"
										@click="goDetail('/pages/equipment/equipment?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-shebei"></i>
										<view class="text">设备信息</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/operateList/operateList?lock_id=' + item.lock_id)">
										<i class="iconfont icon-yewucaozuo"></i>
										<view class="text">操作记录</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/keyList/keyList?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-yuechi"></i>
										<view class="text">权限管理</view>
									</view>
									<!-- 原参数设置 -->
									  <view class="cell-item"
											v-if="!item.lock.lock_sn.startsWith('W70')"
											@click="goDetail('/pages/arguments/arguments?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-canshu"></i>
										<view class="text">参数设置</view>
									  </view>
									  <!-- 云喇叭的喇叭设置 -->
									  <view class="cell-item"
											v-if="item.lock.lock_sn.startsWith('W70')"
											@click="goDetail('/pages/hornSettings/hornSettings?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-canshu"></i>
										<view class="text">喇叭设置</view>
									  </view>
									<view class="cell-item"
										@click="goDetail('/pages/realTime/realTime?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.realTime_status === 1">
										<i class="iconfont icon-shebei"></i>
										<view class="text">用电情况</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/passwordList/passwordList?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.pwd_status === 1">
										<i class="iconfont icon-mima"></i>
										<view class="text">密码管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/fingerprintList/fingerprintList?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.finger_status === 1">
										<i class="iconfont icon-zhiwen"></i>
										<view class="text">指纹列表</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/doorCardList/doorCardList?lock_id=' + item.lock_id+ '&auth_isadmin=' + item.auth_isadmin)"
										v-if="item.lock_ability.card_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">门卡管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/linkresponse/linkresponse?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.linkresponse_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">联动管理</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/W71Switch/W71Switch?device_sn=' + item.lock.lock_sn + '&lockauth_id=' + item.lockauth_id + '&device_name=' + encodeURIComponent(item.lock.lock_name) + '&online=' + item.lock.online)"
										v-if="item.lock && item.lock.lock_sn && (item.lock.lock_sn.startsWith('W71M') || item.lock.lock_sn.startsWith('W72M'))">
										<i class="iconfont icon-shandian"></i>
										<view class="text">定时开关</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/TtsSchedule/TtsSchedule?device_sn=' + item.lock.lock_sn + '&device_name=' + encodeURIComponent(item.lock.lock_name) + '&online=' + item.lock.online)"
										v-if="item.lock && item.lock.lock_sn && item.lock.lock_sn.startsWith('W70')">
										<i class="iconfont icon-bofang"></i>
										<view class="text">定时播放</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/audioConfig/audioConfig?lock_id=' + item.lock_id)"
										v-if="item.lock_ability.audioConfig_status === 1">
										<i class="iconfont icon-menjin"></i>
										<view class="text">语音设置</view>
									</view>
									<view class="cell-item"
										@click="goDetail('/pages/transfer/transfer?lockauth_id=' + item.lockauth_id)">
										<i class="iconfont icon-a-zhuanyi4"></i>
										<view class="text">转移权限</view>
									</view>
								</block>
								<view
									class="cell-item"
									@click="goDetail('/pages/faceList/faceList?lock_id=' + item.lock_id + '&auth_isadmin=' + item.auth_isadmin+ '&face_text=' + item.lock_ability.face_text)"
									v-if="item.lock_ability.face_status === 1">
									<i class="iconfont icon-renlianshibie"></i>
									<view class="text">
										{{ item.lock_ability.face_text ? item.lock_ability.face_text + '管理' : '图片管理' }}
									</view>
								</view>
								<view class="cell-item" @click="pinToTop(item)">
									<i class="iconfont icon-zhiding"></i>
									<view class="text">置顶靠前</view>
								</view>
								<view class="cell-item" @click="onDelete(item)">
									<i class="iconfont icon-shanchu"></i>
									<view class="text" style="color: #FF0000;">
										删&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;除
									</view>
								</view>
							</view>
						</view>
					</view>
				</view>
				<view class="site-mask" v-if="showMask" @click="clickMask"></view>
				<uni-load-more
					:status="noMore"
					:empty_text="searchKeyword ? '未找到匹配的设备' : '没发现钥匙卡片,请在服务添加设备～'"
					:contentText="searchKeyword && dataList.length === 0 ? {contentdown: '', contentrefresh: '正在搜索...', contentnomore: '未找到匹配的设备'} : {contentdown: '上拉显示更多', contentrefresh: '正在加载...', contentnomore: '---没有更多数据啦---'}"
					style="margin-top: 40rpx;">
					<view v-if="status === 'nodata'" class="retry-container">
						<button class="retry-button" @click="retry">重新加载</button>
					</view>
				</uni-load-more>
			</view>
			<view class="horn-popup" @touchmove.stop.prevent v-if="showHornBox" @click="closeHornPopup">
				<view class="cell-box">
					<view class="content-box" @click.stop @touchmove.stop>
						<!-- 关闭按钮 -->
						<view class="close-btn" @click.stop="closeHornPopup">
							<i class="iconfont icon-amc_circle_close close-icon"></i>
						</view>
						<view class="horn-tabs">
							<view class="horn-tab" :class="{ 'horn-tab--active': hornActiveTab === 'history' }" @click.stop="setHornActiveTab('history')">
								播放历史
							</view>
							<view class="horn-tab" :class="{ 'horn-tab--active': hornActiveTab === 'text' }" @click.stop="setHornActiveTab('text')">
								文字播报
							</view>
							<view class="horn-tab" v-if="isHornLiveTalkCapable(hornItem)" :class="{ 'horn-tab--active': hornActiveTab === 'talk' }" @click.stop="setHornActiveTab('talk')">
								实时喊话
							</view>
						</view>
						<scroll-view class="horn-scroll" scroll-y="true" enable-flex="true"
							:refresher-enabled="hornActiveTab === 'history'"
							:refresher-triggered="hornHistoryRefreshing"
							lower-threshold="80"
							@refresherrefresh="refreshHornHistoryList"
							@scrolltolower="handleHornScrollToLower">
							<view v-if="hornActiveTab === 'history'" class="horn-tab-panel horn-tab-panel--history">
								<view class="horn-history-header">
									<view class="horn-history-header__top">
										<view class="horn-history-header__title">{{ hornHistoryDeviceName }}</view>
										<view class="horn-history-header__summary">已加载 {{ hornHistoryList.length }} / {{ hornHistoryTotal || hornHistoryList.length }}</view>
									</view>
									<view class="horn-history-header__desc">下拉刷新，上拉继续加载</view>
								</view>
								<view v-if="hornHistoryLoading && hornHistoryList.length === 0" class="horn-history-state">加载中...</view>
								<view v-else-if="hornHistoryList.length > 0" class="horn-history-list">
									<view class="horn-history-item" v-for="(item, index) in hornHistoryList" :key="item.id || index">
										<view class="horn-history-item__body" @click.stop="startHornHistoryEdit(item, index)">
											<textarea
												v-if="hornHistoryEditingIndex === index"
												v-model="hornHistoryEditContent"
												class="horn-history-item__editor"
												:maxlength="500"
												:focus="true"
												:show-confirm-bar="false"
												:adjust-position="true"
												:cursor-spacing="80"
											/>
											<view v-else class="horn-history-item__content">{{ item.content }}</view>
											<view class="horn-history-item__meta">
												<text>{{ formatHornHistoryTime(item.created_at) }}</text>
												<text>音量:{{ item.volume || 3 }} 语速:{{ item.speed || 4 }} 声调:{{ item.tone || 5 }}</text>
											</view>
										</view>
										<view class="horn-history-item__actions">
											<view v-if="hornHistoryEditingIndex === index" class="horn-history-item__btn horn-history-item__btn--playing" @click.stop="playEditedHornHistory()">播放</view>
											<template v-else>
												<view class="horn-history-item__btn horn-history-item__btn--use" @click.stop="useHornHistoryItem(item)">使用</view>
												<view class="horn-history-item__btn horn-history-item__btn--edit" @click.stop="startHornHistoryEdit(item, index)">编辑</view>
												<view class="horn-history-item__btn" :class="{ 'horn-history-item__btn--playing': hornHistoryPlayingIndex === index }" @click.stop="playHornHistoryItem(item, index)">
													{{ hornHistoryPlayingIndex === index ? '播放中' : '播放' }}
												</view>
											</template>
										</view>
									</view>
									<uni-load-more :status="hornHistoryLoadMoreStatus" :content-text="hornHistoryLoadMoreText"></uni-load-more>
								</view>
								<view v-else class="horn-history-state">暂无播放历史</view>
							</view>
							<view v-else-if="hornActiveTab === 'text'" class="horn-tab-panel">
								<view class="cell-item content-input">
									<view class="label">内容：</view>
									<scroll-view class="tts-scroll" scroll-y="true">
										<textarea placeholder="我是一个灵动声甜的云喇叭,请输入您想播放的内容,I am a lively and sweet voiced cloud speaker. Please enter the content you like to play."
											placeholder-class="placeholder" v-model="tts" />
									</scroll-view>
								</view>
								<view class="voice-settings">
									<view class="settings-title">语音设置</view>
									<view class="cell-item slider-item">
										<view class="label">音量</view>
										<slider :value="voiceData.volume" min="0" max="9" step="1" activeColor="#21CF3E" @change="changeVolume" show-value />
									</view>
									<view class="cell-item slider-item">
										<view class="label">语速</view>
										<slider :value="voiceData.speed" min="0" max="9" step="1" activeColor="#21CF3E" @change="changeSpeed" show-value />
									</view>
									<view class="cell-item slider-item">
										<view class="label">声调</view>
										<slider :value="voiceData.tone" min="0" max="9" step="1" activeColor="#21CF3E" @change="changeTone" show-value />
									</view>
								</view>

								<view class="cell-item" v-if="hornItem && hornItem.lock && hornItem.lock.lock_sn && (hornItem.lock.lock_sn.startsWith('W70B') || hornItem.lock.lock_sn.startsWith('W70R'))">
									<picker mode="selector" :range="speakerNames" :value="speakerIndex" @change="onSpeakerChange">
										<view class="picker-value">{{ speakerNames[speakerIndex] || '女声-高音' }}</view>
									</picker>
								</view>

								<view class="cell-item" v-if="hornItem && hornItem.lock && hornItem.lock.lock_sn && (hornItem.lock.lock_sn.startsWith('W70B') || hornItem.lock.lock_sn.startsWith('W70R'))">
									<view class="label">数字播报：</view>
									<picker mode="selector" :range="numberModeNames" :value="numberModeIndex" @change="onNumberModeChange">
										<view class="picker-value">{{ numberModeNames[numberModeIndex] || '逐位播报' }}</view>
									</picker>
								</view>

								<view class="cell-item">
									<view class="label">循环播放：</view>
									<switch :checked="isLoopEnabled" @change="toggleLoop"></switch>
								</view>
								<view class="cell-item interval-input" v-if="isLoopEnabled">
									<view class="label">间隔时长（秒）：</view>
									<input class="input-box" type="number" placeholder="请输入间隔时长" placeholder-class="placeholder"
										v-model="loopInterval" @blur="onIntervalChange" />
								</view>
							</view>
							<view v-else-if="isHornLiveTalkCapable(hornItem)" class="horn-tab-panel horn-tab-panel--talk">
								<view class="live-talk-box live-talk-box--standalone">
									<view class="settings-title">实时喊话</view>
									<view class="live-talk-status">{{ getLiveTalkHintText() }}</view>
									<view class="live-talk-btn" :class="getLiveTalkButtonClass()"
										@click.stop="handleLiveTalkToggle">
										{{ getLiveTalkButtonText() }}
									</view>
									<view class="live-talk-mp3">
										<view class="live-talk-mp3__label">音频地址（MP3/WAV）</view>
										<input class="live-talk-mp3__input" v-model="liveTalkMp3Url" type="text" maxlength="300"
											placeholder="请输入 MP3 或 WAV 文件链接" />
										<view class="live-talk-mp3__actions">
											<view class="live-talk-mp3__action live-talk-mp3__action--ghost" @click.stop="previewLiveTalkMp3">
												{{ liveTalkMp3Previewing ? '停止试听' : '本机试听' }}
											</view>
											<view class="live-talk-mp3__action" :class="{ 'live-talk-mp3__action--busy': liveTalkMp3Testing }"
												@click.stop="startLiveTalkMp3Test">
												{{ liveTalkMp3Testing ? '正在发送...' : '播放到设备' }}
											</view>
										</view>
									</view>
									<view class="live-talk-history">
										<view class="live-talk-history__header">
											<view class="live-talk-history__title">最近喊话</view>
											<view class="live-talk-history__desc">自动同步到后端，最近 {{ liveTalkHistoryLimit }} 条优先展示</view>
										</view>
										<view v-if="liveTalkHistoryList.length > 0" class="live-talk-history__list">
											<view class="live-talk-history__item" v-for="(record, index) in liveTalkHistoryList" :key="record.id || index">
												<view class="live-talk-history__bubble">
													<view class="live-talk-history__time">{{ formatLiveTalkRecordTime(record.created_at) }}</view>
													<view class="live-talk-history__meta">{{ formatLiveTalkRecordDuration(record.duration_ms) }}</view>
												</view>
												<view class="live-talk-history__actions">
													<view class="live-talk-history__action"
														:class="{
															'live-talk-history__action--playing': liveTalkPlayingIndex === index,
															'live-talk-history__action--disabled': !canLocalPlayLiveTalkRecord(record)
														}"
														@click.stop="playLiveTalkHistory(record, index)">
														{{ canLocalPlayLiveTalkRecord(record) ? (liveTalkPlayingIndex === index ? '停止播放' : '本地播放') : '不可本播' }}
													</view>
													<view class="live-talk-history__action live-talk-history__action--resend"
														@click.stop="resendLiveTalkHistory(record)">
														再次推送
													</view>
												</view>
											</view>
										</view>
										<view v-else class="live-talk-history__empty">暂无喊话记录，结束一次喊话后会自动上传到后端并展示在这里，可本地播放也可再次推送到设备。</view>
									</view>
								</view>
							</view>
						</scroll-view>
						<view class="horn-actions" :class="{ 'horn-actions--placeholder': hornActiveTab !== 'text' && hornActiveTab !== 'history' }">
							<template v-if="hornActiveTab === 'history'">
								<view class="born-btn born-btn--secondary" @click.stop="loadMoreHornHistory">
									{{ hornHistoryLoadMoreStatus === 'loading' ? '加载中...' : (hornHistoryList.length < hornHistoryTotal ? '加载更多历史' : '已加载全部历史') }}
								</view>
								<view class="born-btn born-btn--ghost" @click.stop="goToHornHistory">打开完整历史页</view>
							</template>
							<template v-if="hornActiveTab === 'text'">
								<view class="born-btn" @click.stop="playhorn">立即播放</view>
								<view class="born-btn" @click.stop="stophorn">停止播放</view>
							</template>
						</view>
					</view>
				</view>
			</view>
			<!-- 隐私协议 -->
			<!-- #ifdef MP-WEIXIN -->
			<privacy-popup ref="privacyComponent"></privacy-popup>
			<!-- #endif -->
			<block v-if="pageType === 'phone'">
				<view class="bindPhoneModal">
					<view class="bindPhone">
						<button type="primary" class="btn" open-type="getPhoneNumber" @getphonenumber="getphonenumber"
							hover-class="none">绑定手机号</button>
						<view class="btn cancel-btn" @click="cbindbutton">取消</view>
					</view>
				</view>
			</block>
		</view>
		<popup v-if="showPopup">
			<view class="popup-content">
				<view class="button-container">
					<view v-for="i in deviceLine" :key="i">
						<button @click="openDoor(i)">
							<i class="iconfont icon-yuechi icon-default"></i> 开门 {{ i }}
						</button>
					</view>
				</view>
				<button class="close-button" @click="closePopup">关闭</button>
			</view>
		</popup>
	</view>
</template>

<script>
	import CustomNavBar from '@/components/CustomNavBar/CustomNavBar.vue';
	import {
		OpenLockBle
	} from '../../module/device/index.js'
	import ble from '../../module/ble/index.js'
	import lockServer from '../../module/device/lock.js'
	import PrivacyPopup from '@/components/privacy-popup/privacy-popup.vue';
	import UniLoadMore from '@/components/uni-load-more/uni-load-more.vue';
	import {
		getDeviceGroup_api,
		deviceList_api,
		openLock_api,
		openDoor_api,
		turnOn_api,
		turnOff_api,
		delDevice_api,
		loginQrCode_api,
		playHorn_api,
		getHornHistory_api,
		openApi,
		adlog_api,
		closeApi,
		wxXcxMobile_api,
		zfbXcxMobile_api,
		toutiaoXcxMobile_api,
		zfb_edit_info,
		tt_edit_info,
		deviceStatusBySerial_api,
		pauseAapi,
		adUnitId_api,
		authconfigSet_api,
		audioConfig,
		audioConfigSet,
		voiceConfigSet_api,
		config_api,
		getW71Status_api,
		turnOnW71_api,
		turnOffW71_api,
		hornTalkCreate_api,
		hornTalkStop_api,
		hornTalkStatus_api,
		hornTalkPrepareAudio_api,
		hornTalkHistory_api,
		hornTalkUploadRecord_api
	} from "../../api/index.js";
	import {
		wechatoauth_api,

	} from '../../api/user.js';
	import {
		setToken,
		getToken
	} from "../../libs/auth.js"
	import {
		getQueryString
	} from '../../libs/utils.js'
	import LiveTalkClient from '../../module/liveTalk/liveTalkClient.js'
	import { assetUrl } from '@/config/domain.js'
	const LIVE_TALK_REMOTE_AUDIO_MAX_BYTES = 10 * 1024 * 1024
	export default {
		components: {
			PrivacyPopup,
			UniLoadMore,
			// #ifdef APP-PLUS
			CustomNavBar
			// #endif

		},
		data() {
			return {
				grouping_index: 0,
				grouping_show: false,
				set_index: -1,
				set_pop_show: false,
				groupingList: [],
				device_group_name: '',
				noMore: 'loading',
				page: 1,
				dataList: [],
				allDataList: [], // 保存原始完整列表用于搜索
				searchKeyword: '', // 搜索关键词
				searchTimer: null,
				showMask: false,
				lockItem: {},
				showHornBox: false,
				hornActiveTab: 'text',
				hornHistoryList: [],
				hornHistoryLoading: false,
				hornHistoryRefreshing: false,
				hornHistoryPlayingIndex: -1,
				hornHistoryPage: 1,
				hornHistoryLimit: 20,
				hornHistoryTotal: 0,
				hornHistoryLoadMoreStatus: 'more',
				hornHistoryLoadMoreText: {
					contentdown: '上拉加载更多',
					contentrefresh: '加载中...',
					contentnomore: '没有更多了'
				},
				hornHistoryEditingIndex: -1,
				hornHistoryEditContent: '',
				hornHistoryEditVoice: {
					volume: 3,
					speed: 5,
					tone: 5
				},
				voiceData: {
					volume: 3,
					speed: 4,
					tone: 5
				},
				tts: '', //播放内容
				hornItem: {},
				liveTalkState: 'idle',
				liveTalkMessage: '',
				liveTalkSession: null,
				liveTalkPressing: false,
				liveTalkPendingStop: false,
				liveTalkClient: null,
				liveTalkLastRecord: null,
				liveTalkStartedAt: 0,
				liveTalkHistoryList: [],
				liveTalkHistoryLimit: 8,
				liveTalkPlayingIndex: -1,
				liveTalkAudioContext: null,
				liveTalkMp3Url: assetUrl('/audio/wmj.mp3'),
				liveTalkMp3Testing: false,
				liveTalkMp3Previewing: false,
				longitude: '',
				latitude: '',
				pageType: '',
				isLoopEnabled: false, // 循环播放开关
				loopInterval: 30, // 循环间隔时长，默认5秒
				showPrivacyPopup: false,
				isLogin: false,
				videoAd: null,
				adShowCount: 0, // 初始化广告显示计数器
				adUnitId: '', // 用于存储从后台获取的 adUnitId
				defaultAdUnitId: 'adunit-b43dfa956b9afbff', // 本地默认插屏广告ID
				maxDailyAds: 10, // 每日最大广告显示次数，提升曝光率
				adRetryCount: 0, // 广告重试次数
				maxRetryCount: 3, // 最大重试次数
				showPopup: false,
				deviceLine: 1,
				device_authid: 0,
				status: "",
				speakers: [], // 发音人列表
				selectedSpeaker: 'prompt_female_high', // 当前选择的发音人ID
				numberModes: [
					{ id: 'digit', name: '逐位播报' },
					{ id: 'value', name: '数值播报' }
				],
				selectedNumberMode: 'digit' // 默认逐位播报
			}
		},
		// 小程序显示分享
		onShareAppMessage() {},
		onShareTimeline() {},
		onLoad(option) {
			// 初始化页面数据
			this.dataList = [];
			this.page = 1;
			this.getDeviceGroup();

			// 检查是否是通过二维码登录
			if (option.q) {
				let scene = decodeURIComponent(option.q); // 解析二维码场景参数
				let paramobj = getQueryString(scene).key;
				this.loginQrCode(paramobj); // 调用扫码登录逻辑
			}

			// 微信小程序平台登录逻辑
			// #ifdef MP-WEIXIN
			if (option.q) {
				let scene = decodeURIComponent(option.q);
				let paramobj = getQueryString(scene).key;
				this.loginQrCode(paramobj); // 扫码登录
			}
			// #endif

			// 抖音小程序平台登录逻辑
			// #ifdef MP-TOUTIAO
			if (typeof tt !== 'undefined' && tt.checkSession) {
				tt.checkSession({
					success: () => {
						this.isLogin = true; // 检查抖音小程序的登录状态
					},
				});
			}
			// #endif

			// 处理手机号绑定类型页面
			if (option.type) {
				this.pageType = option.type;
				this.isQropen = false;
			}
			if (this.pageType === 'phone') {
				uni.setNavigationBarTitle({
					title: '绑定手机号',
				});
				return;
			}
		},
		onShow() {
			// #ifdef MP-WEIXIN
			if (wx.getPrivacySetting) {
				wx.getPrivacySetting({
					success: (res) => {
						if (res.needAuthorization) {
							this.showPrivacyPopup = true;
							this.$nextTick(() => {
								if (this.$refs.privacyComponent) {
									this.$refs.privacyComponent.showPrivacy = true;
								}
							});
						}
					},
				});
			}
			let lastDate = wx.getStorageSync('lastUseDate');
			let today = new Date().toLocaleDateString('zh-CN', {
				timeZone: 'Asia/Shanghai',
				year: 'numeric',
				month: '2-digit',
				day: '2-digit'
			}).replace(/\//g, '-'); // 获取当前日期，格式为 YYYY-MM-DD
			//console.log("today", today)
			if (lastDate !== today) {
				this.adShowCount = 0; // 如果不是同一天，则重置广告显示计数器
				wx.setStorageSync('adShowCount', this.adShowCount); // 更新本地存储中的计数
			} else {
				this.adShowCount = wx.getStorageSync('adShowCount') || 0; // 如果是同一天，从本地存储恢复计数
			}
			wx.setStorageSync('lastUseDate', today); // 更新存储的日期
			// #endif

			// 已移除页面显示时广告展示逻辑
		},
		onHide() {
			if (this.liveTalkState !== 'idle' || this.liveTalkSession) {
				this.stopLiveTalk('page_hide');
			}
			this.stopLiveTalkPlayback();

			this.latitude = ""
			this.longitude = ""

			// #ifdef MP-WEIXIN
			ble.CloseBluetoothAdapter()
			// #endif
		},
		mounted() {
			// 如果本地存储中有值，则使用该值，否则使用默认值
			this.tts = wx.getStorageSync('tts') !== '' ? wx.getStorageSync('tts') : '我是一个灵动声甜的云喇叭,请输入您想播放的内容,I am a lively and sweet voiced cloud speaker. Please enter the content you like to play.';

			// 对于布尔值需要特别处理
			this.isLoopEnabled = (wx.getStorageSync('isLoopEnabled') !== '') ? wx.getStorageSync('isLoopEnabled') :
				false; // 默认为 false
			this.loopInterval = wx.getStorageSync('loopInterval') !== '' ? wx.getStorageSync('loopInterval') : 30;

			// 初始化发音人列表
			this.initSpeakers();
		},
		computed: {
			hornHistoryDeviceName() {
				return this.hornItem?.lock?.lock_name || this.hornItem?.device_name || '云喇叭';
			},
			speakerNames() {
				return this.speakers.map(s => s.name);
			},
			speakerIndex() {
				const idx = this.speakers.findIndex(s => s.id === this.selectedSpeaker);
				return idx >= 0 ? idx : 0;
			},
			numberModeNames() {
				return this.numberModes.map(m => m.name);
			},
			numberModeIndex() {
				const idx = this.numberModes.findIndex(m => m.id === this.selectedNumberMode);
				return idx >= 0 ? idx : 0;
			}
		},
		watch: {
			tts(newVal) {
				wx.setStorageSync('tts', newVal);
			},

			isLoopEnabled(newVal) {
				wx.setStorageSync('isLoopEnabled', newVal);
			},
			loopInterval(newVal) {
				wx.setStorageSync('loopInterval', newVal);
			},
			dataList(newVal) {
				if (newVal && newVal.length > 0) {
					this.fetchDeviceStatusBySerial();
				}
			}
			// 其他监听...
		},
		methods: {
			// 初始化发音人列表
			async initSpeakers() {
				// 使用默认发音人列表
				this.speakers = [
					{ id: 'prompt_female_high', name: '女声-高音', description: '系统', default: true },
					{ id: 'prompt_duoduo', name: '女声-多多', description: '默认女声发音人' },
					{ id: 'prompt_wenroutaotao', name: '桃桃-温柔', description: '默认女声发音人，音调温柔' },
					{ id: 'prompt_kunkun', name: '男声-坤坤', description: '系统' },
					{ id: 'prompt_bobo', name: '男声-优雅', description: '默认男声发音人，音调优雅' },
					{ id: 'prompt_ref_audio_02', name: '男声-搞怪', description: '默认男声发音人，音调搞怪' }
				];
			},

			// 发音人选择改变
			onSpeakerChange(e) {
				const index = e.detail.value;
				if (this.speakers[index]) {
					this.selectedSpeaker = this.speakers[index].id;
				}
			},

			// 数字播报模式改变
			onNumberModeChange(e) {
				const index = e.detail.value;
				if (this.numberModes[index]) {
					this.selectedNumberMode = this.numberModes[index].id;
				}
			},
			closeHornPopup() {
				this.showHornBox = false;
				this.hornActiveTab = 'text';
				this.hornHistoryPlayingIndex = -1;
				this.hornHistoryEditingIndex = -1;
				this.hornHistoryEditContent = '';
				this.hornHistoryRefreshing = false;
				this.stopLiveTalkPlayback();
				if (this.liveTalkState !== 'idle' || this.liveTalkSession) {
					this.stopLiveTalk('popup_close');
				}
			},
			setHornActiveTab(tab) {
				if (tab === 'talk' && !this.isHornLiveTalkCapable(this.hornItem)) {
					return;
				}
				this.hornActiveTab = tab;
				if (tab === 'history') {
					this.stopLiveTalkPlayback();
					this.refreshHornHistoryList();
					return;
				}
				if (tab === 'talk') {
					this.loadLiveTalkHistory(this.hornItem && this.hornItem.lockauth_id);
					this.syncLiveTalkStatus();
					return;
				}
				this.stopLiveTalkPlayback();
			},
			formatHornHistoryTime(timestamp) {
				if (!timestamp) {
					return '刚刚';
				}
				const date = new Date(Number(timestamp) * (String(timestamp).length === 10 ? 1000 : 1));
				const now = new Date();
				const diff = now - date;
				const hour = `${date.getHours()}`.padStart(2, '0');
				const minute = `${date.getMinutes()}`.padStart(2, '0');
				if (diff < 86400000 && date.getDate() === now.getDate()) {
					return `今天 ${hour}:${minute}`;
				}
				if (diff < 172800000 && date.getDate() === now.getDate() - 1) {
					return `昨天 ${hour}:${minute}`;
				}
				return `${date.getMonth() + 1}-${date.getDate()} ${hour}:${minute}`;
			},
			async loadHornHistoryList(reset = false) {
				const requestPage = this.hornHistoryPage;
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					this.hornHistoryList = [];
					this.hornHistoryLoading = false;
					this.hornHistoryRefreshing = false;
					this.hornHistoryLoadMoreStatus = 'more';
					return;
				}
				if (reset) {
					this.hornHistoryPage = 1;
					this.hornHistoryTotal = 0;
					this.hornHistoryList = [];
					this.hornHistoryLoadMoreStatus = 'more';
				}
				if (this.hornHistoryLoadMoreStatus === 'loading') {
					return;
				}
				this.hornHistoryLoading = true;
				this.hornHistoryLoadMoreStatus = 'loading';
				try {
					const res = await this.getHornHistory(this.hornItem.lockauth_id, this.hornHistoryPage, this.hornHistoryLimit);
					if (res.code === 0 && res.data) {
						const list = Array.isArray(res.data.list) ? res.data.list : [];
						this.hornHistoryTotal = Number(res.data.total || 0);
						this.hornHistoryList = this.hornHistoryPage === 1 ? list : this.hornHistoryList.concat(list);
						this.hornHistoryLoadMoreStatus = this.hornHistoryList.length >= this.hornHistoryTotal ? 'noMore' : 'more';
						return;
					}
					if (this.hornHistoryPage === 1) {
						this.hornHistoryList = [];
					}
					this.hornHistoryPage = reset || requestPage <= 1 ? 1 : requestPage - 1;
					this.hornHistoryLoadMoreStatus = 'more';
				} catch (error) {
					console.error('加载播放历史失败:', error);
					if (this.hornHistoryPage === 1) {
						this.hornHistoryList = [];
					}
					this.hornHistoryPage = reset || requestPage <= 1 ? 1 : requestPage - 1;
					this.hornHistoryLoadMoreStatus = 'more';
				} finally {
					this.hornHistoryLoading = false;
					this.hornHistoryRefreshing = false;
				}
			},
			refreshHornHistoryList() {
				this.hornHistoryRefreshing = true;
				this.hornHistoryEditingIndex = -1;
				this.hornHistoryEditContent = '';
				this.loadHornHistoryList(true);
			},
			loadMoreHornHistory() {
				if (this.hornHistoryLoadMoreStatus === 'loading') {
					return;
				}
				if (this.hornHistoryList.length >= this.hornHistoryTotal && this.hornHistoryTotal > 0) {
					uni.showToast({
						title: '已经到底了',
						icon: 'none'
					});
					return;
				}
				this.handleHornScrollToLower();
			},
			handleHornScrollToLower() {
				if (this.hornActiveTab !== 'history') {
					return;
				}
				if (this.hornHistoryLoadMoreStatus !== 'more' || this.hornHistoryList.length >= this.hornHistoryTotal) {
					return;
				}
				this.hornHistoryPage += 1;
				this.loadHornHistoryList();
			},
			startHornHistoryEdit(item, index) {
				this.hornHistoryEditingIndex = index;
				this.hornHistoryEditContent = item.content || '';
				this.hornHistoryEditVoice = {
					volume: item.volume || 3,
					speed: item.speed || 5,
					tone: item.tone || 5
				};
			},
			async playEditedHornHistory() {
				if (!this.hornHistoryEditContent.trim()) {
					uni.showToast({
						title: '请输入播报内容',
						icon: 'none'
					});
					return;
				}
				const payload = {
					content: this.hornHistoryEditContent,
					volume: this.hornHistoryEditVoice.volume,
					speed: this.hornHistoryEditVoice.speed,
					tone: this.hornHistoryEditVoice.tone,
				};
				this.hornHistoryEditingIndex = -1;
				await this.playHornHistoryItem(payload, -1, true);
				this.refreshHornHistoryList();
			},
			useHornHistoryItem(item) {
				if (!item) {
					return;
				}
				this.tts = item.content || this.tts;
				this.voiceData = {
					volume: item.volume !== undefined ? item.volume : this.voiceData.volume,
					speed: item.speed !== undefined ? item.speed : this.voiceData.speed,
					tone: item.tone !== undefined ? item.tone : this.voiceData.tone,
				};
				this.hornActiveTab = 'text';
			},
			async playHornHistoryItem(item, index, keepState = false) {
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					return;
				}
				if (index >= 0 && this.hornHistoryPlayingIndex === index) {
					uni.showToast({
						title: '正在播放中',
						icon: 'none'
					});
					return;
				}
				this.hornHistoryPlayingIndex = index;
				try {
					uni.showLoading({
						title: '播放中...',
						mask: true
					});
					const res = await playHorn_api({
						lockauth_id: this.hornItem.lockauth_id,
						volume: item.volume || 3,
						speed: item.speed || 4,
						tone: item.tone || 5,
						tts: item.content,
						stopplay: false
					});
					uni.hideLoading();
					if (res.code === 0) {
						uni.showToast({
							title: '播放成功',
							icon: 'none'
						});
						setTimeout(() => {
							this.hornHistoryPlayingIndex = -1;
						}, 2000);
						return;
					}
					this.hornHistoryPlayingIndex = -1;
					uni.showToast({
						title: res.msg || '播放失败',
						icon: 'none'
					});
				} catch (error) {
					console.error('播放历史播放失败:', error);
					this.hornHistoryPlayingIndex = -1;
					uni.hideLoading();
					uni.showToast({
						title: '播放失败',
						icon: 'none'
					});
				}
			},
			isHornLiveTalkCapable(item) {
				// 开源版暂未提供实时喊话调度服务，避免展示不可用入口。
				return false;
			},
			getLiveTalkButtonText() {
				if (this.liveTalkState === 'talking') {
					return '点击结束喊话';
				}
				if (this.liveTalkState === 'connecting') {
					return '连接中...';
				}
				if (this.liveTalkState === 'starting') {
					return '麦克风启动中...';
				}
				if (this.liveTalkState === 'stopping') {
					return '结束中...';
				}
				return '点击开始喊话';
			},
			getLiveTalkHintText() {
				if (this.liveTalkMessage) {
					return this.liveTalkMessage;
				}
				if (this.liveTalkState === 'talking') {
					return '正在实时分块传输语音到设备，再次点击即可结束本次喊话。';
				}
				if (this.liveTalkState === 'connecting' || this.liveTalkState === 'starting') {
					return '正在建立喊话连接，请稍候。';
				}
				return '点击按钮开始说话，语音会实时分块推送到设备播放，再次点击结束，并保留最近喊话记录。';
			},
			getLiveTalkButtonClass() {
				return {
					'live-talk-btn--busy': ['connecting', 'starting', 'stopping'].includes(this.liveTalkState),
					'live-talk-btn--active': this.liveTalkState === 'talking',
				};
			},
			ensureLiveTalkClient() {
				if (this.liveTalkClient) {
					return this.liveTalkClient;
				}

				this.liveTalkClient = new LiveTalkClient({
					onStateChange: ({ state, mode }) => {
						this.liveTalkState = state;
						if (state === 'connecting') {
							this.liveTalkMessage = mode === 'mp3' ? '正在连接调度平台，准备推送 MP3...' : '正在连接调度平台...';
						} else if (state === 'starting') {
							this.liveTalkMessage = '正在打开麦克风...';
						} else if (state === 'talking') {
							this.liveTalkStartedAt = Date.now();
							this.liveTalkMessage = mode === 'mp3' ? '正在将 MP3 推送到设备...' : '正在喊话，再次点击即可结束';
						} else if (state === 'stopping') {
							this.liveTalkMessage = '正在结束喊话...';
						} else if (!this.liveTalkMessage) {
							this.liveTalkMessage = '点击开始喊话';
						}
					},
					onRecordReady: (record) => {
						this.liveTalkLastRecord = record;
					},
					onError: async (error) => {
						const msg = (error && error.message) || '实时喊话失败';
						await this.notifyLiveTalkStop('client_error');
						this.resetLiveTalkState(msg);
						uni.showToast({
							title: msg,
							icon: 'none',
						});
					},
					onClose: () => {
						if (this.liveTalkState === 'stopping') {
							return;
						}
						this.resetLiveTalkState('喊话连接已关闭');
					},
				});

				return this.liveTalkClient;
			},
				normalizeHornTalkResponse(res) {
					if (res && res.data && res.data.data && typeof res.data.data === 'object') {
						return res.data.data;
					}
					if (res && res.data && typeof res.data === 'object') {
						return res.data;
					}
					return {};
				},
				normalizeLiveTalkStatusData(statusData = {}) {
					const session = (statusData && typeof statusData.session === 'object' && statusData.session) ? statusData.session : statusData;
					const status = String(statusData.status || session.status || '').trim().toLowerCase();
					const active = statusData.active === true ||
						statusData.live_talk_active === true ||
						statusData.is_live_talk === true ||
						statusData.device_ws_connected === true ||
						statusData.app_ws_connected === true ||
						['talking', 'active', 'starting', 'connecting'].includes(status);
					return {
						active,
						status,
						session,
						device_ws_connected: statusData.device_ws_connected === true,
						app_ws_connected: statusData.app_ws_connected === true,
					};
				},
				isLiveTalkBusyMessage(message = '') {
					return /正在喊话|喊话中|会话正在进行|稍后再试/.test(String(message || ''));
				},
				async tryRecoverBusyLiveTalk() {
					if (!this.hornItem || !this.hornItem.lockauth_id) {
						return false;
					}

					try {
						const statusRes = await hornTalkStatus_api({
							lockauth_id: this.hornItem.lockauth_id,
						});
						if (statusRes.code === 0) {
							const normalized = this.normalizeLiveTalkStatusData(this.normalizeHornTalkResponse(statusRes));
							if (normalized.active) {
								this.liveTalkSession = normalized.session || null;
								this.liveTalkState = 'talking';
								this.liveTalkMessage = '已有喊话会话正在进行';
								return false;
							}
						}
					} catch (error) {
					}

					try {
						await hornTalkStop_api({
							lockauth_id: this.hornItem.lockauth_id,
							reason: 'recover_busy',
						});
						await new Promise((resolve) => setTimeout(resolve, 300));
						return true;
					} catch (error) {
						return false;
					}
				},
				resetLiveTalkState(message = '') {
					this.liveTalkState = 'idle';
					this.liveTalkMessage = message;
				this.liveTalkSession = null;
				this.liveTalkPressing = false;
				this.liveTalkPendingStop = false;
				this.liveTalkStartedAt = 0;
			},
			getLiveTalkHistoryStorageKey(lockauthId) {
				return `wmj_live_talk_history_${lockauthId || 'default'}`;
			},
			normalizeLiveTalkTimestamp(timestamp) {
				const value = Number(timestamp || 0);
				if (!value) {
					return Date.now();
				}
				return String(Math.trunc(value)).length <= 10 ? value * 1000 : value;
			},
			isRemoteLiveTalkUrl(path) {
				return /^https?:\/\//i.test(String(path || '').trim());
			},
			getLiveTalkDeviceName(item = this.hornItem) {
				return item?.lock?.lock_name || item?.device_name || '云喇叭';
			},
			normalizeLiveTalkHistoryList(list = []) {
				if (!Array.isArray(list)) {
					return [];
				}
				return list
					.filter(item => item && item.created_at)
					.map(item => {
						const createdAt = this.normalizeLiveTalkTimestamp(item.created_at || item.createdAt || Date.now());
						const filePath = item.file_path || '';
						const localFilePath = item.local_file_path || (!this.isRemoteLiveTalkUrl(filePath) ? filePath : '');
						const fileUrl = item.file_url || item.remote_url || (this.isRemoteLiveTalkUrl(filePath) ? filePath : '');
						return {
							id: item.id || `${createdAt}_${Math.random().toString(36).slice(2, 8)}`,
							created_at: createdAt,
							duration_ms: Number(item.duration_ms || 0),
							file_path: filePath,
							local_file_path: localFilePath,
							file_url: fileUrl,
							playback_url: item.playback_url || fileUrl || '',
							file_size: Number(item.file_size || 0),
							device_name: item.device_name || '',
							lockauth_id: item.lockauth_id || '',
							talk_id: item.talk_id || '',
							audio_format: item.audio_format || 'mp3',
							codec: item.codec || item.audio_format || 'mp3',
							playback_supported: item.playback_supported !== false,
							server_saved: item.server_saved !== false,
						};
					})
					.sort((a, b) => b.created_at - a.created_at)
					.slice(0, this.liveTalkHistoryLimit);
			},
			readLiveTalkHistoryCache(lockauthId) {
				if (!lockauthId) {
					return [];
				}
				const cache = uni.getStorageSync(this.getLiveTalkHistoryStorageKey(lockauthId));
				return this.normalizeLiveTalkHistoryList(cache);
			},
			saveLiveTalkHistoryCache(lockauthId, list) {
				if (!lockauthId) {
					return;
				}
				const normalizedList = this.normalizeLiveTalkHistoryList(list);
				uni.setStorageSync(this.getLiveTalkHistoryStorageKey(lockauthId), normalizedList);
				if (this.hornItem && Number(this.hornItem.lockauth_id) === Number(lockauthId)) {
					this.liveTalkHistoryList = normalizedList;
				}
			},
			getLiveTalkHistoryMatchKeys(record = {}) {
				return [
					record.id ? `id:${record.id}` : '',
					record.talk_id ? `talk:${record.talk_id}` : '',
					record.file_url ? `url:${record.file_url}` : '',
				].filter(Boolean);
			},
			mergeLiveTalkHistoryWithCache(remoteList = [], cachedList = []) {
				const normalizedRemoteList = this.normalizeLiveTalkHistoryList(remoteList);
				const normalizedCacheList = this.normalizeLiveTalkHistoryList(cachedList);
				const cacheMap = new Map();
				const remoteKeySet = new Set();

				normalizedCacheList.forEach((item) => {
					this.getLiveTalkHistoryMatchKeys(item).forEach((key) => {
						if (!cacheMap.has(key)) {
							cacheMap.set(key, item);
						}
					});
				});

				normalizedRemoteList.forEach((item) => {
					this.getLiveTalkHistoryMatchKeys(item).forEach((key) => {
						remoteKeySet.add(key);
					});
				});

				const mergedRemoteList = normalizedRemoteList.map((item) => {
					const matchedCache = this.getLiveTalkHistoryMatchKeys(item)
						.map((key) => cacheMap.get(key))
						.find(Boolean);
					if (!matchedCache) {
						return item;
					}
					const localFilePath = matchedCache.local_file_path || (!this.isRemoteLiveTalkUrl(matchedCache.file_path) ? matchedCache.file_path : '');
					return {
						...item,
						local_file_path: localFilePath,
						file_path: localFilePath || item.file_path,
					};
				});

				const pendingCacheList = normalizedCacheList.filter((item) => {
					if (item.server_saved !== false && item.id) {
						return false;
					}
					const keys = this.getLiveTalkHistoryMatchKeys(item);
					return !keys.some((key) => remoteKeySet.has(key));
				});

				return this.normalizeLiveTalkHistoryList(mergedRemoteList.concat(pendingCacheList));
			},
			async loadLiveTalkHistory(lockauthId) {
				if (!lockauthId) {
					this.liveTalkHistoryList = [];
					return [];
				}
				const cachedList = this.readLiveTalkHistoryCache(lockauthId);
				if (this.hornItem && Number(this.hornItem.lockauth_id) === Number(lockauthId)) {
					this.liveTalkHistoryList = cachedList;
				}
				try {
					const res = await hornTalkHistory_api({
						lockauth_id: lockauthId,
						page: 1,
						limit: this.liveTalkHistoryLimit,
					});
					if (Number(res.code) === 0 && res.data) {
						const serverList = this.normalizeLiveTalkHistoryList(res.data.list || []);
						const mergedList = this.mergeLiveTalkHistoryWithCache(serverList, cachedList);
						this.saveLiveTalkHistoryCache(lockauthId, mergedList);
						return mergedList;
					}
				} catch (error) {
					console.error('加载实时喊话历史失败:', error);
				}
				return cachedList;
			},
			async persistLiveTalkFile(tempFilePath) {
				if (!tempFilePath) {
					return '';
				}
				if (typeof uni.saveFile !== 'function') {
					return tempFilePath;
				}
				return await new Promise((resolve) => {
					uni.saveFile({
						tempFilePath,
						success: (res) => {
							resolve(res.savedFilePath || tempFilePath);
						},
						fail: () => {
							resolve(tempFilePath);
						},
					});
				});
			},
			async removeLiveTalkFile(filePath) {
				if (!filePath || this.isRemoteLiveTalkUrl(filePath) || typeof uni.removeSavedFile !== 'function') {
					return;
				}
				await new Promise((resolve) => {
					uni.removeSavedFile({
						filePath,
						complete: () => resolve(),
					});
				});
			},
			async appendLiveTalkHistoryRecord(record) {
				if (!this.hornItem || !this.hornItem.lockauth_id || !record) {
					return false;
				}
				const lockauthId = this.hornItem.lockauth_id;
				const existingList = this.readLiveTalkHistoryCache(lockauthId);
				const savedFilePath = await this.persistLiveTalkFile(record.tempFilePath || record.file_path || '');
				const fileSize = Number(record.fileSize || record.file_size || 0);
				if (!savedFilePath || fileSize <= 0) {
					return false;
				}
				let historyRecord = null;
				let uploadedToServer = false;
				try {
					const res = await hornTalkUploadRecord_api(savedFilePath, {
						lockauth_id: lockauthId,
						talk_id: record.talk_id || '',
						duration_ms: Number(record.duration_ms || record.duration || 0),
						audio_format: record.audioFormat || 'mp3',
						codec: record.codec || record.audioFormat || 'mp3',
						playback_supported: record.playbackSupported !== false ? 1 : 0,
						file_size: fileSize,
					});
					if (Number(res.code) !== 0 || !res.data || !res.data.record) {
						throw new Error((res && res.msg) || '喊话录音上传后端失败');
					}
					historyRecord = this.normalizeLiveTalkHistoryList([{
						...res.data.record,
						file_path: savedFilePath,
						local_file_path: savedFilePath,
						server_saved: true,
					}])[0];
					uploadedToServer = true;
				} catch (error) {
					console.error('实时喊话录音上传失败:', error);
					historyRecord = this.normalizeLiveTalkHistoryList([{
						id: `${Date.now()}_${Math.random().toString(36).slice(2, 8)}`,
						created_at: Date.now(),
						duration_ms: Number(record.duration_ms || record.duration || 0),
						file_path: savedFilePath,
						local_file_path: savedFilePath,
						file_size: fileSize,
						device_name: this.getLiveTalkDeviceName(),
						lockauth_id: lockauthId,
						talk_id: record.talk_id || '',
						audio_format: record.audioFormat || 'mp3',
						codec: record.codec || record.audioFormat || 'mp3',
						playback_supported: record.playbackSupported !== false,
						server_saved: false,
					}])[0];
					uni.showToast({
						title: '录音已保存在本机，上传后端失败',
						icon: 'none',
					});
				}
				const nextList = this.mergeLiveTalkHistoryWithCache([historyRecord], existingList)
					.slice(0, this.liveTalkHistoryLimit);
				const removedList = existingList.filter((item) => {
					const localPath = item.local_file_path || (!this.isRemoteLiveTalkUrl(item.file_path) ? item.file_path : '');
					if (!localPath) {
						return false;
					}
					return !nextList.some((current) => {
						const currentLocalPath = current.local_file_path || (!this.isRemoteLiveTalkUrl(current.file_path) ? current.file_path : '');
						return currentLocalPath === localPath;
					});
				});
				this.saveLiveTalkHistoryCache(lockauthId, nextList);
				for (const item of removedList) {
					const localPath = item.local_file_path || item.file_path;
					if (localPath) {
						await this.removeLiveTalkFile(localPath);
					}
				}
				if (uploadedToServer) {
					this.loadLiveTalkHistory(lockauthId);
				}
				return true;
			},
			createLiveTalkAudioContext() {
				if (this.liveTalkAudioContext) {
					return this.liveTalkAudioContext;
				}
				if (typeof uni.createInnerAudioContext === 'function') {
					this.liveTalkAudioContext = uni.createInnerAudioContext();
				} else if (typeof wx !== 'undefined' && typeof wx.createInnerAudioContext === 'function') {
					this.liveTalkAudioContext = wx.createInnerAudioContext({
						useWebAudioImplement: true,
					});
				}
				if (this.liveTalkAudioContext) {
					this.liveTalkAudioContext.onEnded(() => {
						this.liveTalkPlayingIndex = -1;
						this.liveTalkMp3Previewing = false;
					});
					this.liveTalkAudioContext.onStop(() => {
						this.liveTalkPlayingIndex = -1;
						this.liveTalkMp3Previewing = false;
					});
					this.liveTalkAudioContext.onError(() => {
						this.liveTalkPlayingIndex = -1;
						this.liveTalkMp3Previewing = false;
						uni.showToast({
							title: '喊话记录播放失败',
							icon: 'none',
						});
					});
				}
				return this.liveTalkAudioContext;
			},
			stopLiveTalkPlayback() {
				if (this.liveTalkAudioContext) {
					try {
						this.liveTalkAudioContext.stop();
					} catch (error) {
					}
				}
				this.liveTalkPlayingIndex = -1;
				this.liveTalkMp3Previewing = false;
			},
			getLiveTalkRecordPlaybackSrc(record) {
				if (!record) {
					return '';
				}
				const localFilePath = record.local_file_path || (!this.isRemoteLiveTalkUrl(record.file_path) ? record.file_path : '');
				return localFilePath || record.playback_url || record.file_url || (this.isRemoteLiveTalkUrl(record.file_path) ? record.file_path : '');
			},
			getLiveTalkRecordReplaySource(record) {
				if (!record) {
					return null;
				}
				const localFilePath = record.local_file_path || (!this.isRemoteLiveTalkUrl(record.file_path) ? record.file_path : '');
				if (localFilePath) {
					return {
						type: 'file',
						value: localFilePath,
					};
				}
				const remoteUrl = record.file_url || record.playback_url || (this.isRemoteLiveTalkUrl(record.file_path) ? record.file_path : '');
				if (remoteUrl) {
					return {
						type: 'url',
						value: remoteUrl,
					};
				}
				return null;
			},
			canLocalPlayLiveTalkRecord(record) {
				return !!(this.getLiveTalkRecordPlaybackSrc(record) && record && record.playback_supported !== false);
			},
			async playLiveTalkHistory(record, index) {
				const playbackSrc = this.getLiveTalkRecordPlaybackSrc(record);
				if (!playbackSrc) {
					uni.showToast({
						title: '该记录没有可回放音频',
						icon: 'none',
					});
					return;
				}
				if (record.playback_supported === false) {
					uni.showToast({
						title: '当前录音格式仅用于实时发送，暂不支持本地回放',
						icon: 'none',
					});
					return;
				}
				const audioContext = this.createLiveTalkAudioContext();
				if (!audioContext) {
					uni.showToast({
						title: '当前环境不支持回放',
						icon: 'none',
					});
					return;
				}
				if (this.liveTalkPlayingIndex === index) {
					this.stopLiveTalkPlayback();
					return;
				}
				this.stopLiveTalkPlayback();
				this.liveTalkPlayingIndex = index;
				audioContext.src = playbackSrc;
				audioContext.play();
			},
			async resendLiveTalkHistory(record) {
				const replaySource = this.getLiveTalkRecordReplaySource(record);
				if (!replaySource) {
					uni.showToast({
						title: '该记录没有可重新推送的音频',
						icon: 'none',
					});
					return;
				}
				const client = this.ensureLiveTalkClient();
				const replaySupported = replaySource.type === 'file'
					? typeof client.streamFile === 'function'
					: typeof client.streamMp3 === 'function';
				if (!replaySupported || !client.isSocketSupported()) {
					uni.showToast({
						title: '当前环境不支持再次推送',
						icon: 'none',
					});
					return;
				}
				if (['connecting', 'starting', 'talking', 'stopping'].includes(this.liveTalkState) || this.liveTalkMp3Testing) {
					return;
				}

				this.stopLiveTalkPlayback();
				this.liveTalkMp3Testing = true;
				this.liveTalkMessage = '正在重新推送历史喊话...';
				let session = null;
				try {
					let preparedReplay = null;
					if (replaySource.type !== 'file') {
						this.liveTalkMessage = '正在识别并处理历史音频...';
						preparedReplay = await this.prepareLiveTalkAudioUrl(replaySource.value);
					}
					session = await this.createLiveTalkSession('miniapp_history');
					const resendRecord = replaySource.type === 'file'
						? await client.streamFile(session, {
							filePath: replaySource.value,
							duration: Number(record.duration_ms || 0),
							chunkSize: 4096,
							chunkDelayMs: 40,
						})
						: await client.streamMp3(session, {
							url: preparedReplay && preparedReplay.url ? preparedReplay.url : replaySource.value,
							chunkSize: 4096,
							chunkDelayMs: 40,
						});
					const waitMs = this.estimateLiveTalkMp3PlaybackWaitMs(resendRecord);
					this.liveTalkSession = session;
					this.liveTalkMessage = '历史喊话已发送，等待设备播完...';
					await new Promise((resolve) => setTimeout(resolve, waitMs));
					await client.stop('history_resend_completed');
					this.liveTalkSession = session;
					await this.notifyLiveTalkStop('history_resend_completed');
					if (typeof client.consumeLastRecord === 'function') {
						client.consumeLastRecord();
					}
					this.liveTalkLastRecord = null;
					this.resetLiveTalkState('历史喊话已重新推送');
					uni.showToast({
						title: '已再次推送到设备',
						icon: 'none',
					});
				} catch (error) {
					const msg = (error && error.message) || '历史喊话重新推送失败';
					if (session) {
						this.liveTalkSession = session;
					}
					await this.notifyLiveTalkStop('history_resend_failed');
					this.resetLiveTalkState(msg);
					uni.showToast({
						title: msg,
						icon: 'none',
					});
				} finally {
					this.liveTalkMp3Testing = false;
				}
			},
			formatLiveTalkRecordTime(timestamp) {
				if (!timestamp) {
					return '刚刚';
				}
				const date = new Date(Number(timestamp));
				const now = new Date();
				const isToday = date.toDateString() === now.toDateString();
				const month = `${date.getMonth() + 1}`.padStart(2, '0');
				const day = `${date.getDate()}`.padStart(2, '0');
				const hour = `${date.getHours()}`.padStart(2, '0');
				const minute = `${date.getMinutes()}`.padStart(2, '0');
				return isToday ? `今天 ${hour}:${minute}` : `${month}-${day} ${hour}:${minute}`;
			},
			formatLiveTalkRecordDuration(durationMs) {
				const totalSeconds = Math.max(1, Math.round(Number(durationMs || 0) / 1000));
				const minute = Math.floor(totalSeconds / 60);
				const second = totalSeconds % 60;
				if (minute > 0) {
					return `${minute}分${`${second}`.padStart(2, '0')}秒`;
				}
				return `${second}秒`;
			},
			async notifyLiveTalkStop(reason = 'user_stop') {
				const payload = {
					reason,
				};
				if (this.liveTalkSession && this.liveTalkSession.talk_id) {
					payload.talk_id = this.liveTalkSession.talk_id;
				}
				if (this.hornItem && this.hornItem.lockauth_id) {
					payload.lockauth_id = this.hornItem.lockauth_id;
				}
				if (!payload.talk_id && !payload.lockauth_id) {
					return;
				}
				try {
					await hornTalkStop_api(payload);
				} catch (error) {
				}
			},
			async syncLiveTalkStatus() {
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					this.resetLiveTalkState('');
					return;
				}
				try {
					const res = await hornTalkStatus_api({
						lockauth_id: this.hornItem.lockauth_id,
					});
					if (res.code !== 0) {
						return;
					}
					const statusData = this.normalizeLiveTalkStatusData(this.normalizeHornTalkResponse(res));
					if (statusData && statusData.active) {
						this.liveTalkSession = statusData.session || null;
						this.liveTalkState = 'talking';
						this.liveTalkMessage = '已有喊话会话正在进行';
						return;
					}
					this.resetLiveTalkState('点击开始喊话');
				} catch (error) {
					this.liveTalkMessage = '喊话状态同步失败';
				}
			},
			normalizeLiveTalkMp3Url() {
				return String(this.liveTalkMp3Url || '').trim();
			},
			probeLiveTalkAudioSize(sourceUrl) {
				return new Promise((resolve) => {
					if (typeof uni.request !== 'function') {
						resolve(0);
						return;
					}
					uni.request({
						url: sourceUrl,
						method: 'HEAD',
						success: (res) => {
							const headers = res.header || res.headers || {};
							const length = Number(headers['Content-Length'] || headers['content-length'] || 0);
							resolve(length > 0 ? length : 0);
						},
						fail: () => {
							resolve(0);
						},
					});
				});
			},
			async prepareLiveTalkAudioUrl(sourceUrl) {
				const normalizedUrl = String(sourceUrl || '').trim();
				if (!normalizedUrl) {
					throw new Error('音频地址不能为空');
				}
				if (/\/uploads\/live-talk\/normalized\//.test(normalizedUrl)) {
					return {
						url: normalizedUrl,
						prepared: null,
					};
				}
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					throw new Error('未找到设备授权信息');
				}
				const remoteFileSize = await this.probeLiveTalkAudioSize(normalizedUrl);
				if (remoteFileSize > LIVE_TALK_REMOTE_AUDIO_MAX_BYTES) {
					throw new Error('音频文件过大，请控制在10MB以内');
				}
				const skipTranscode = /_16k_mono_64k(\.mp3)?$/i.test(normalizedUrl);
				const res = await hornTalkPrepareAudio_api({
					lockauth_id: this.hornItem.lockauth_id,
					audio_url: normalizedUrl,
					skip_transcode: skipTranscode ? 1 : 0,
				});
				if (res.code !== 0) {
					throw new Error(res.msg || '音频预处理失败');
				}
				const prepared = (res.data && (res.data.prepared || res.data)) || {};
				const preparedUrl = String(prepared.playback_url || prepared.file_url || '').trim();
				if (!preparedUrl) {
					throw new Error('音频预处理后未返回可播放地址');
				}
				return {
					url: preparedUrl,
					prepared,
				};
			},
			async createLiveTalkSession(clientPlatform = 'miniapp') {
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					throw new Error('未找到设备授权信息');
				}
				const createPayload = {
					lockauth_id: this.hornItem.lockauth_id,
					client_platform: clientPlatform,
				};
				let res = await hornTalkCreate_api(createPayload);
				if (res.code !== 0 && this.isLiveTalkBusyMessage(res.msg)) {
					const recovered = await this.tryRecoverBusyLiveTalk();
					if (recovered) {
						res = await hornTalkCreate_api(createPayload);
					}
				}
				if (res.code !== 0) {
					throw new Error(res.msg || '创建喊话会话失败');
				}
				const session = this.normalizeHornTalkResponse(res);
				if (!session || !session.app_ws_url) {
					throw new Error('调度平台未返回小程序连接地址');
				}
				this.liveTalkSession = session;
				return session;
			},
			async previewLiveTalkMp3() {
				const url = this.normalizeLiveTalkMp3Url();
				if (!url) {
					uni.showToast({
						title: '请先输入音频地址',
						icon: 'none',
					});
					return;
				}
				const audioContext = this.createLiveTalkAudioContext();
				if (!audioContext) {
					uni.showToast({
						title: '当前环境不支持试听',
						icon: 'none',
					});
					return;
				}
				if (this.liveTalkMp3Previewing) {
					this.stopLiveTalkPlayback();
					return;
				}
				this.stopLiveTalkPlayback();
				this.liveTalkMp3Previewing = true;
				this.liveTalkPlayingIndex = -1;
				audioContext.src = url;
				audioContext.play();
			},
			estimateLiveTalkMp3PlaybackWaitMs(record = {}) {
				const durationMs = Number(record.duration || record.duration_ms || 0);
				if (durationMs > 0) {
					return Math.max(4000, Math.min(30000, durationMs + 2500));
				}
				const fileSize = Number(record.fileSize || record.file_size || 0);
				if (fileSize <= 0) {
					return 3500;
				}
				const estimatedMs = Math.ceil((fileSize * 8 * 1000) / 32000) + 2500;
				return Math.max(4000, Math.min(30000, estimatedMs));
			},
			async startLiveTalkMp3Test() {
				if (!this.isHornLiveTalkCapable(this.hornItem)) {
					return;
				}
				const url = this.normalizeLiveTalkMp3Url();
				if (!url) {
					uni.showToast({
						title: '请先输入音频地址',
						icon: 'none',
					});
					return;
				}
				const client = this.ensureLiveTalkClient();
				if (typeof client.streamMp3 !== 'function' || !client.isSocketSupported()) {
					const msg = '当前环境不支持音频推送测试';
					this.liveTalkMessage = msg;
					uni.showToast({
						title: msg,
						icon: 'none',
					});
					return;
				}
				if (['connecting', 'starting', 'talking', 'stopping'].includes(this.liveTalkState) || this.liveTalkMp3Testing) {
					return;
				}

				this.stopLiveTalkPlayback();
				this.liveTalkMp3Testing = true;
				this.liveTalkMessage = '正在识别并处理音频...';
				let session = null;
				try {
					const preparedAudio = await this.prepareLiveTalkAudioUrl(url);
					this.liveTalkMessage = '正在创建音频播放会话...';
					session = await this.createLiveTalkSession('miniapp_mp3');
					const record = await client.streamMp3(session, {
						url: preparedAudio.url,
						chunkSize: 4096,
						chunkDelayMs: 40,
					});
					const waitMs = this.estimateLiveTalkMp3PlaybackWaitMs(record);
					this.liveTalkSession = session;
					this.liveTalkMessage = `音频已发送，等待设备播完...`;
					await new Promise((resolve) => setTimeout(resolve, waitMs));
					await client.stop('mp3_test_completed');
					this.liveTalkSession = session;
					await this.notifyLiveTalkStop('mp3_test_completed');
					if (typeof client.consumeLastRecord === 'function') {
						client.consumeLastRecord();
					}
					this.liveTalkLastRecord = null;
					this.resetLiveTalkState('音频已播放完成');
					uni.showToast({
						title: '播放到设备已完成',
						icon: 'none',
					});
				} catch (error) {
					const msg = (error && error.message) || '音频播放到设备失败';
					if (session) {
						this.liveTalkSession = session;
					}
					await this.notifyLiveTalkStop('mp3_test_failed');
					this.resetLiveTalkState(msg);
					uni.showToast({
						title: msg,
						icon: 'none',
					});
				} finally {
					this.liveTalkMp3Testing = false;
				}
			},
			async startLiveTalk() {
				if (!this.isHornLiveTalkCapable(this.hornItem)) {
					return;
				}
				const client = this.ensureLiveTalkClient();
				if (!client.isSupported()) {
					const msg = '当前环境不支持实时喊话';
					this.liveTalkMessage = msg;
					uni.showToast({
						title: msg,
						icon: 'none',
					});
					return;
				}
				if (['connecting', 'starting', 'talking', 'stopping'].includes(this.liveTalkState)) {
					return;
				}

				this.liveTalkMessage = '正在创建喊话会话...';
				try {
					const session = await this.createLiveTalkSession('miniapp');
					this.liveTalkSession = session;
					await client.start(session);

					if (this.liveTalkPendingStop || !this.liveTalkPressing) {
						await this.stopLiveTalk('tap_stop');
					}
				} catch (error) {
					const msg = (error && error.message) || '实时喊话启动失败';
					await this.notifyLiveTalkStop('start_failed');
					this.resetLiveTalkState(msg);
					uni.showToast({
						title: msg,
						icon: 'none',
					});
				}
			},
			async stopLiveTalk(reason = 'user_stop') {
				const session = this.liveTalkSession;
				const shouldPersistHistory = ['touch_release', 'tap_stop'].includes(reason) && !!session;
				this.liveTalkPendingStop = false;
				this.liveTalkPressing = false;

				try {
					if (this.liveTalkClient) {
						await this.liveTalkClient.stop(reason);
					}
				} catch (error) {
				}

				if (session) {
					this.liveTalkSession = session;
				}
				await this.notifyLiveTalkStop(reason);
				let nextMessage = ['touch_release', 'tap_stop'].includes(reason) ? '点击开始喊话' : '';
				if (shouldPersistHistory) {
					const lastRecord = (this.liveTalkClient && typeof this.liveTalkClient.consumeLastRecord === 'function') ? this.liveTalkClient.consumeLastRecord() : this.liveTalkLastRecord;
					const durationMs = Math.max(
						Number(lastRecord && lastRecord.duration ? lastRecord.duration : 0),
						this.liveTalkStartedAt ? (Date.now() - this.liveTalkStartedAt) : 0
					);
					const saved = await this.appendLiveTalkHistoryRecord({
						...(lastRecord || {}),
						duration_ms: durationMs,
						talk_id: session && session.talk_id ? session.talk_id : '',
					});
					if (saved) {
						nextMessage = '喊话完成，已保存到最近记录';
					}
				}
				this.liveTalkLastRecord = null;
				this.resetLiveTalkState(nextMessage);
			},
			handleLiveTalkToggle() {
				if (this.liveTalkState === 'stopping') {
					return;
				}
				if (this.liveTalkState === 'talking') {
					this.liveTalkPressing = false;
					this.stopLiveTalk('tap_stop');
					return;
				}
				if (['connecting', 'starting'].includes(this.liveTalkState)) {
					this.liveTalkPendingStop = true;
					return;
				}
				this.liveTalkPressing = true;
				this.liveTalkPendingStop = false;
				this.startLiveTalk();
			},

			checkCamerString(str) {
			  const target = str.slice(-10, -8);
			  return target === '33' || target === '34';
			},
			// 搜索输入事件
			onSearchInput(e) {
				this.filterDeviceList();
			},
			// 搜索确认事件
			onSearchConfirm() {
				this.filterDeviceList(true);
			},
			// 清空搜索
			clearSearch() {
				this.searchKeyword = '';
				this.filterDeviceList(true);
			},
			// 扫码搜索
			onScanSearch() {
				uni.scanCode({
					scanType: ['qrCode', 'barCode'],
					success: (res) => {
						console.log('扫码结果:', res.result);
						// 尝试从扫码结果中提取序列号
						let sn = res.result;
						// 如果是URL格式，尝试提取sn参数
						if (sn.includes('sn=')) {
							const match = sn.match(/sn=([^&]+)/);
							if (match) {
								sn = match[1];
							}
						}
						// 如果是URL格式但没有sn参数，尝试提取最后一段
						else if (sn.includes('/')) {
							const parts = sn.split('/');
							sn = parts[parts.length - 1].split('?')[0];
						}
						this.searchKeyword = sn;
						this.filterDeviceList(true);
					},
					fail: (err) => {
						console.log('扫码失败:', err);
					}
				});
			},
			// 设备列表搜索：改为服务端分页搜索，避免只能搜当前已加载页
			filterDeviceList(immediate = false) {
				if (this.searchTimer) {
					clearTimeout(this.searchTimer);
					this.searchTimer = null;
				}

				if (immediate) {
					this.resetDeviceListAndSearch();
					return;
				}

				this.searchTimer = setTimeout(() => {
					this.resetDeviceListAndSearch();
					this.searchTimer = null;
				}, 300);
			},
			resetDeviceListAndSearch() {
				this.page = 1;
				this.dataList = [];
				this.allDataList = [];
				this.noMore = 'loading';
				this.status = '';
				this.getList();
			},
			// 小程序扫码登录
			async loginQrCode(key) {
				let res = await loginQrCode_api({
					key: key
				})
			},
			onTopPlusClick() {
				// 点击 "+" 号后的逻辑，例如显示扫一扫功能
				uni.showActionSheet({
					itemList: ['扫一扫'],
					success: (res) => {
						if (res.tapIndex === 0) {
							this.scanCode();
						}
					},
					fail: (err) => {
						// 用户取消操作
					}
				});
			},
			async retry() {
				// 重新加载数据，不清空缓存
				this.page = 1;
				this.dataList = [];
				this.noMore = 'loading';
				this.status = '';
				uni.showLoading({
					title: '加载中...',
					mask: true
				});
				try {
					// 先重新获取分组数据
					await this.getDeviceGroup();
				} catch (error) {
					console.error('重试加载失败:', error);
					uni.showToast({
						title: '加载失败，请检查网络',
						icon: 'none'
					});
				} finally {
					uni.hideLoading();
				}
			},
			scanCode() {
				uni.scanCode({
					success: (res) => {
						// 扫码成功
					},
					fail: (err) => {
						console.error('扫码失败: ', err);
					}
				});
			},
			showToast(msg) {
				uni.showToast({
					title: msg,
					icon: 'error',
					duration: 4000,
					mask: true
				})
			},
			showPhoneLoginPage() {
				uni.navigateTo({
					url: '/pages/login/login', // 跳转到手机号登录页面
				});
			},
			cbindbutton() {
				this.pageType = ''
			},
			itemClass(item) {
				return 'fixed-class-name';
			},
			async fetchDeviceStatusBySerial() {
				for (let item of this.dataList) {
					if (item.lock.lock_sn.startsWith('W71') || item.lock.lock_sn.startsWith('W72')) {
						let params = {
							deviceSn: item.lock.lock_sn
						};
						let response = await deviceStatusBySerial_api(params);
						// 确保response存在且包含switch_state属性，避免可能的错误
						if (response && response.switch_state !== undefined) {
							item.lock.switch_state = response.switch_state;
							item.statusInfo = response;
						} else {
							console.warn(`No switch_state found in the response for deviceSn: ${item.lock.lock_sn}`);
							// 容错：没有switch_state时赋默认值
							item.lock.switch_state = null;
							item.statusInfo = response || {};
						}
					}
				}
			},

			async unlocking(item, index) {
				// #ifdef MP-WEIXIN
				if (item.lock.location_check === 1) {
					await this.getLocation()
				}
				// #endif
				if (item.lock_ability.line > 1) {
					this.deviceLine = item.lock_ability.line;
					this.device_authid = item.lockauth_id;
					this.showPopup = true;
				} else {
					// 启动旋转动画
					this.$set(item, 'isRotating', true);
					item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
					uni.showLoading({
						title: '响应中...',
						mask: true
					})
					this.openLock(item, index)
					this.$forceUpdate()
					item.status = 1
				}
			},
			async openDoor(doorIndex) {
				// 准备请求参数
				const payload = {
					lockauth_id: this.device_authid, // 设备 ID
					line: doorIndex, // 路数
					longitude: this.longitude, // 如果有地理位置
					latitude: this.latitude // 如果有地理位置
				};
				// 显示加载状态
				uni.showLoading({
					title: '开门中...'
				});
				try {
					// 调用后端接口
					let res = await openDoor_api(payload); // 假设 openDoor_api 是你定义的接口调用函数

					// 更新状态
					if (res.code === 0) {
						uni.showToast({
							title: res.msg,
							duration: 2000
						});
					} else if (res.code === 1001) {
						this.pageType = 'phone';
					} else {
						uni.showToast({
							title: res.msg,
							duration: 2000
						});
					}
				} catch (error) {
					console.error("开门请求失败", error);
					uni.showToast({
						title: '请求失败',
						duration: 2000
					});
				} finally {
					uni.hideLoading();
				}
			},
			closePopup() {
				this.showPopup = false;
			},
			// 开锁
			async openLock(item, index) {
				// 记录开始时间
				const startTime = Date.now();
				// #ifdef MP-WEIXIN
				if (item.lock.location_check === 1) {
					await this.getLocation()
				}
				// #endif
				let res = await openLock_api({
					lockauth_id: item.lockauth_id,
					longitude: this.longitude,
					latitude: this.latitude
				})
				// 确保动画至少播放3秒后再停止
				const elapsed = Date.now() - startTime;
				const remainingTime = Math.max(0, 3000 - elapsed);
				setTimeout(() => {
					item.status = 1
					this.$set(item, 'isRotating', false);
					uni.hideLoading()
				}, remainingTime);
				if (res.code === 0) {
					await this.refreshDeviceList(index);
					if (res.data.xcx_sound == 1) {
						await lockServer.OpenLockMp3()
					}
					uni.showToast({
						title: res.msg,
						duration: 5000
					})
				} else if (res.code === 1001) {
					this.pageType = 'phone'
					uni.hideLoading()
				} else if (res.code === 1003) {
					// 设备离线,尝试蓝牙开门
					await this.offline(item)
				} else {
					// 其他错误,使用模态框醒目提示
					uni.showModal({
						title: '无法开门',
						content: res.msg || '开门失败',
						showCancel: false,
						confirmText: '我知道了',
						confirmColor: '#ff0000'
					})
				}
				this.$forceUpdate()
			},
			async toggleLoop(event) {
				const newValue = event.detail.value;

				uni.showLoading({
					title: '设置中...',
					mask: true
				})

			let res = await playHorn_api({
				lockauth_id: this.hornItem.lockauth_id,
				volume: this.voiceData.volume,
				tts: this.tts,
				stopplay: !newValue, // 开启循环时stopplay为false，关闭循环时stopplay为true
				isLoopEnabled: newValue,
				loopInterval: this.loopInterval
			})

			uni.hideLoading()

				if (res.code === 0) {
					this.isLoopEnabled = newValue;
					wx.setStorageSync('isLoopEnabled', this.isLoopEnabled);
					uni.showToast({
						title: newValue ? '已开启循环播放' : '已关闭循环播放',
						icon: 'none',
					})
				} else {
					// 操作失败，恢复原状态
					this.isLoopEnabled = !newValue;
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			async autoSubmitVoice() {
				uni.showLoading({
					title: '保存中...',
					mask: true
				})
				try {
					let res = await voiceConfigSet_api({
						lockauth_id: this.hornItem.lockauth_id,
						volume: this.voiceData.volume,
						speed: this.voiceData.speed,
						tone: this.voiceData.tone
					})
					if (res.code === 0) {
						uni.showToast({
							title: '保存成功',
							icon: 'success'
						})
					} else {
						uni.showToast({
							title: res.msg,
							icon: 'none'
						})
					}
				} catch (error) {
					uni.showToast({
						title: '保存失败，请重试',
						icon: 'none'
					})
				} finally {
					uni.hideLoading()
				}
			},
			changeVolume(e) {
				this.voiceData.volume = e.detail.value
				this.autoSubmitVoice()
			},
			changeSpeed(e) {
				this.voiceData.speed = e.detail.value
				this.autoSubmitVoice()
			},
			changeTone(e) {
				this.voiceData.tone = e.detail.value
				this.autoSubmitVoice()
			},
			async onIntervalChange() {
				// 如果循环播放已开启，修改间隔时长后需要重新设置
				if (!this.isLoopEnabled || !this.loopInterval) {
					return;
				}

				uni.showLoading({
					title: '设置中...',
					mask: true
				})

			let res = await playHorn_api({
				lockauth_id: this.hornItem.lockauth_id,
				volume: this.voiceData.volume,
				tts: this.tts,
				stopplay: false,
				isLoopEnabled: true,
				loopInterval: this.loopInterval
			})

			uni.hideLoading()

				if (res.code === 0) {
					uni.showToast({
						title: '间隔时长已更新',
						icon: 'none',
					})
				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			// 开/关动作
			onSwitch(item) {
				uni.showActionSheet({
					itemList: ['开', '关'],
					success: async (msg) => {
						item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
						uni.showLoading({
							title: '加载中...',
							mask: true
						})

						this.$forceUpdate()
						if (msg.tapIndex === 0) {
							let res = await turnOn_api({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							uni.hideLoading()

							// 检查是否被计划任务控制
							const rawInfo = (res.data && res.data.info) ? res.data.info : null;
							let isControlledBySchedule = false;
							if (Array.isArray(rawInfo)) {
								isControlledBySchedule = rawInfo.includes(2) || rawInfo.some(i => typeof i === 'string' && i.includes('schedule'));
							} else if (rawInfo && rawInfo.code === 2) {
								isControlledBySchedule = true;
							}

							if (isControlledBySchedule) {
								uni.showToast({
									title: '被计划任务控制，操作被拒绝',
									icon: 'none',
									duration: 2000
								})
							} else if (res.code === 0) {
								item.lock.switch_state = 1;
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}
							this.$forceUpdate()
						} else {

							let res = await turnOff_api({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							uni.hideLoading()

							// 检查是否被计划任务控制
							const rawInfo = (res.data && res.data.info) ? res.data.info : null;
							let isControlledBySchedule = false;
							if (Array.isArray(rawInfo)) {
								isControlledBySchedule = rawInfo.includes(2) || rawInfo.some(i => typeof i === 'string' && i.includes('schedule'));
							} else if (rawInfo && rawInfo.code === 2) {
								isControlledBySchedule = true;
							}

							if (isControlledBySchedule) {
								uni.showToast({
									title: '被计划任务控制，操作被拒绝',
									icon: 'none',
									duration: 2000
								})
							} else if (res.code === 0) {
								item.lock.switch_state = 0;
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}
							this.$forceUpdate()
						}
					},
				});
			},
			onSwitchLock(item) {
				// 启动旋转动画
				this.$set(item, 'isRotating', true);
				item.status = 2 // 2是开锁中的状态，改变钥匙按钮为灰色
				this.$forceUpdate()

				uni.showActionSheet({
					itemList: ['开', '关', '停'],
					success: async (msg) => {

						uni.showLoading({
							title: '加载中...',
							mask: true
						})


						if (msg.tapIndex === 0) {
							let res = await openApi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})
							item.status = 1
							item.lock.switch_state = 1;
							// 停止旋转动画
							this.$set(item, 'isRotating', false);
							uni.hideLoading()
							if (res.code === 0) {
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}

						} else if (msg.tapIndex === 1) {

							let res = await closeApi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})


							if (res.code === 0) {
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}

						} else {

							let res = await pauseAapi({
								lockauth_id: item.lockauth_id,
								longitude: this.longitude,
								latitude: this.latitude
							})


							if (res.code === 0) {
								uni.showToast({
									title: res.msg,
								})
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none'
								})
							}

						}

						item.status = 1
						item.lock.switch_state = 0
						// 停止旋转动画
						this.$set(item, 'isRotating', false);
						uni.hideLoading()
						//console.log(123)
						this.$forceUpdate()
					},
					fail: () => {
						// 用户取消选择时，停止旋转并恢复状态
						item.status = 1;
						this.$set(item, 'isRotating', false);
						this.$forceUpdate();
					}
				});

			},
			//摄像头相关
			onCamer(item){
				const deviceName = item.lock?.lock_name || item.device_name || item.lock?.lock_sn || '摄像头'
				const memberId = item.member_id || item.lock?.member_id || uni.getStorageSync("USERINFO")?.member_id || ''
				if (!memberId) {
					uni.showToast({
						title: '缺少用户授权信息，请重新登录后再试',
						icon: 'none'
					})
					return
				}
				uni.navigateTo({
					url:`/pages/camera/camera?device_sn=${item.lock.lock_sn}&member_id=${memberId}&device_name=${encodeURIComponent(deviceName)}`
				})
			},
			//4G开关
			on4GSwitch(item){
				uni.navigateTo({
					url:`/pages/4GSwitch/4GSwitch?device_sn=${item.lock.lock_sn}&member_id=${item.member_id}`
				})
			},
			//W76F 5路继电器
			onW76FSwitch(item){
				uni.navigateTo({
					url:`/pages/W76FSwitch/W76FSwitch?device_sn=${item.lock.lock_sn}&lockauth_id=${item.lockauth_id}`
				})
			},
			//W75 柜门锁系列管理 (W751=WiFi, W752=4G, W753=网线)
			onW75Cabinet(item){
				uni.navigateTo({
					url:`/pages/W75Cabinet/W75Cabinet?device_sn=${item.lock.lock_sn}&lockauth_id=${item.lockauth_id}`
				})
			},
			//W71 WiFi空开 - 开关控制
			async onW71SwitchToggle(item){
				uni.showLoading({ title: '操作中...' });
				try {
					// 先获取当前状态
					const statusRes = await getW71Status_api({ device_sn: item.lock.lock_sn });
					if (statusRes.code !== 0) {
						uni.showToast({ title: statusRes.msg || '获取状态失败', icon: 'none' });
						return;
					}

					const currentStatus = (statusRes.data && statusRes.data.info && statusRes.data.info.status) || 0;
					// 切换状态：当前开则关，当前关则开
					const api = currentStatus === 1 ? turnOffW71_api : turnOnW71_api;
					const res = await api({ device_sn: item.lock.lock_sn });

					if (res.code === 0) {
						const info = (res.data && res.data.info) ? res.data.info : {};
						if (info.code === 2) {
							// 被计划任务控制
							uni.showToast({ title: '被计划任务控制', icon: 'none' });
						} else if (info.code === 0 || info.err_code === 0) {
							uni.showToast({ title: currentStatus === 1 ? '已关闭' : '已开启', icon: 'success' });
							uni.vibrateShort();
						} else {
							uni.showToast({ title: info.msg || '操作失败', icon: 'none' });
						}
					} else {
						uni.showToast({ title: res.msg || '操作失败', icon: 'none' });
					}
				} catch (err) {
					console.error('W71操作失败:', err);
					uni.showToast({ title: '操作失败', icon: 'none' });
				} finally {
					uni.hideLoading();
				}
			},
			// 播放
			async onPlay(item) {
				this.hornItem = item
				this.showHornBox = true
				this.hornActiveTab = 'text'
				this.hornHistoryPlayingIndex = -1
				this.hornHistoryEditingIndex = -1
				this.hornHistoryEditContent = ''
				this.hornHistoryPage = 1
				this.hornHistoryTotal = 0
				this.hornHistoryLoadMoreStatus = 'more'
					this.stopLiveTalkPlayback()
					this.loadLiveTalkHistory(item.lockauth_id)
					this.syncLiveTalkStatus()
					this.loadHornHistoryList(true)

				try {
					// 获取最近播放的内容（从后端获取）
					let historyRes = await this.getHornHistory(item.lockauth_id, 1, 1)
					if (historyRes.code === 0 && historyRes.data && historyRes.data.list && historyRes.data.list.length > 0) {
						// 使用最近一次播放的内容
						let lastPlay = historyRes.data.list[0]
						this.tts = lastPlay.content || "我是一个灵动声甜的云喇叭,请输入您想播放的内容,I am a lively and sweet voiced cloud speaker. Please enter the content you like to play.";
					} else {
						// 没有历史记录，使用默认内容
						this.tts = "我是一个灵动声甜的云喇叭,请输入您想播放的内容,I am a lively and sweet voiced cloud speaker. Please enter the content you like to play.";
					}
				} catch (error) {
					console.error('获取播放历史失败:', error)
					this.tts = "我是一个灵动声甜的云喇叭,请输入您想播放的内容,I am a lively and sweet voiced cloud speaker. Please enter the content you like to play.";
				}

				// 获取语音配置
				let configRes = await config_api({
					lockauth_id: item.lockauth_id
				})
				if (configRes.code === 0) {
					let data = configRes.data
					// 获取语音设置参数
					this.voiceData = {
						volume: data.volume !== undefined ? data.volume : 3,
						speed: data.speed !== undefined ? data.speed : 4,
						tone: data.tone !== undefined ? data.tone : 5
					};
				} else {
					this.voiceData = {
						volume: 3,
						speed: 4,
						tone: 5
					};
				}

				this.isLoopEnabled = wx.getStorageSync('isLoopEnabled')

				// 如果发音人列表为空，初始化发音人列表
				if (this.speakers.length === 0) {
					await this.initSpeakers();
				}

				this.$forceUpdate() // 强制更新视图
			},
			// 立即播放
			async playhorn() {
				this.hornItem.status = 2
				this.$forceUpdate()
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await playHorn_api({
					lockauth_id: this.hornItem.lockauth_id,
					volume: this.voiceData.volume,
					speed: this.voiceData.speed,
					tone: this.voiceData.tone,
					tts: this.tts,
					stopplay: false,
					longitude: this.longitude,
					latitude: this.latitude,
					isLoopEnabled: this.isLoopEnabled,
					loopInterval: this.loopInterval,
					speaker: this.selectedSpeaker, // 发音人参数
					number_mode: this.selectedNumberMode // 数字播报模式参数
				})
			if (res.code === 0) {
				this.hornItem.status = 1
				this.$forceUpdate();

				uni.showToast({
					title: '播放成功',
					icon: 'none',
				})				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			// 停止播放
			async stophorn() {
				this.hornItem.status = 2
				this.$forceUpdate()
				uni.showLoading({
					title: '加载中...',
					mask: true
				})
				let res = await playHorn_api({
					lockauth_id: this.hornItem.lockauth_id,
					volume: this.voiceData.volume,
					tts: this.tts,
					stopplay: true,
					isLoopEnabled: this.isLoopEnabled,
					loopInterval: this.loopInterval
				})
				if (res.code === 0) {
					this.hornItem.status = 1
					this.$forceUpdate();
					uni.showToast({
						title: '操作成功',
						icon: 'none',
					})

				} else {
					uni.showToast({
						title: res.msg,
						icon: 'none',
					})
				}
			},
			clickMask() {
				this.showMask = false;
				this.set_index = -1
				this.grouping_show = false
			},
			clickGrouping() {
				this.showMask = true
				this.grouping_show = !this.grouping_show
				this.set_index = -1
			},
			login() {
				// 微信小程序登录
				// #ifdef MP-WEIXIN
				uni.login({
					provider: 'weixin',
					success: async (loginRes) => {
						let res = await wechatoauth_api({
							code: loginRes.code
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif

				// 支付宝小程序登录
				// #ifdef MP-ALIPAY
				uni.login({
					scopes: 'auth_base',
					success: async (loginRes) => {
						let res = await alipayoauth_api({
							code: loginRes.authCode
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif

				// 抖音小程序登录
				// #ifdef MP-TOUTIAO
				uni.login({
					success: async (loginRes) => {
						let res = await toutiaoauth_api({
							code: loginRes.code
						});
						if (res.code === 0) {
							setToken(res.data.token);
						}
					}
				});
				// #endif
			},
			async getDeviceGroup() {
				let res = await getDeviceGroup_api()
				this.groupingList = res.data
				this.grouping_index = (res.data && Array.isArray(res.data) && res.data.length) ? res.data[0].device_group_id : 0
				this.device_group_name = (res.data && Array.isArray(res.data) && res.data.length) ? res.data[0].device_group_name : ''
				this.getList()

			},
			async getList() {
				this.noMore = 'loading';
				const keyword = this.searchKeyword.trim();
				let params = {
					page: this.page,
					limit: 10,
					device_group_id: this.grouping_index
				};

				if (keyword) {
					params.search_key = keyword;
				}

				try {
					let res = await deviceList_api(params);

					// 检查返回结果是否有效
					if (!res || res.code !== 0) {
						// 请求失败，保持loading状态，不设置nodata
						console.error('获取设备列表失败:', res);
						this.status = 'nodata';
						this.noMore = 'loading'; // 保持loading状态，允许重试
						return;
					}

					this.groupInfo = res.data && res.data.info ? res.data.info : {};

					if (this.page !== 1 && !(res.data && Array.isArray(res.data) && res.data.length)) {
						this.noMore = 'noMore';
						return;
					} else if (this.page === 1 && !(res.data && Array.isArray(res.data) && res.data.length)) {
						this.dataList = [];
						this.allDataList = [];
						this.dataList = res.data || [];
						this.noMore = 'nodata';
						this.status = '';
						return;
					}

					this.dataList = this.dataList.concat(res.data); //将数据拼接在一起
					this.allDataList = [...this.dataList];
					this.status = ''; // 清除错误状态

					if (res.data.length < params.limit) {
						this.noMore = 'noMore';
					}

					if (this.dataList.length > 0) {
						this.dataList.forEach((item) => {
							item.status = 1
						})
					}
				} catch (error) {
					console.error('获取设备列表异常:', error);
					this.status = 'nodata';
					this.noMore = 'loading'; // 保持loading状态，允许重试
				}
			},
			async refreshDeviceList(index) {
				let lparams = {
					page: this.page,
					limit: 10,
					device_group_id: this.grouping_index
				};
				let res = await deviceList_api(lparams);

				if (res.code === 0 && res.data && Array.isArray(res.data) && res.data[index] && res.data[index].auth_openlimit) {
					this.dataList[index].auth_limit = res.data[index].auth_limit
				} else {
					uni.showToast({
						title: '刷新数据失败',
						icon: 'none',
					});
				}

			},
			changeGrouping(item) {
				this.grouping_index = item.device_group_id;
				this.device_group_name = item.device_group_name;
				this.grouping_show = false;
				this.showMask = false
				this.dataList = []
				this.allDataList = [] // 清空搜索缓存
				this.searchKeyword = '' // 清空搜索关键词
				this.page = 1
				this.noMore = 'loading'; // 重置加载状态
				this.status = ''; // 清除错误状态
				this.getList()
			},
			changeSite(index, item) {
				this.lockItem = item
				this.grouping_show = false
				if (index === this.set_index) {
					this.set_index = -1
					this.showMask = false
					return
				}
				this.set_index = index
				this.showMask = true
			},
			async offline(DeviceInfo) {
				if (DeviceInfo.lock.lock_sn.indexOf('WMJ62') > -1 || DeviceInfo.lock.lock_sn.indexOf('W76') > -1) {
					let OpenBluetoothAdapterRes = await ble.OpenBluetoothAdapter()
					if (OpenBluetoothAdapterRes.err) {
						uni.showToast({
							title: OpenBluetoothAdapterRes.err,
							icon: 'none',
						})
						return
					}
					await OpenLockBle(DeviceInfo.lock.lock_sn, DeviceInfo.lock.lock_id)
					return
				} else {
					uni.showToast({
						title: '设备不在线!',
						icon: 'none',
					})
				}
			},
			goDetail(url) {
				if (url.indexOf('transfer') !== -1) {
					if (this.lockItem.auth_isadmin !== 1 || this.lockItem.auth_member_id !== 0) {
						uni.showToast({
							title: '抱歉，无转移权限',
							icon: 'none',
							mask: true
						})
						return
					}
				}

				uni.navigateTo({
					url: url
				})
				this.showMask = false
				this.set_index = -1
			},
			goGrouping() {
				this.showMask = false
				this.set_index = -1
				this.grouping_show = false
				uni.navigateTo({
					url: '/pages/familyList/familyList'
				})
			},
			onShare(item) {
				if (item.auth_shareability !== 1) {
					uni.showToast({
						title: '抱歉，您没有分享权限',
						icon: 'none',
						mask: true
					})
					return
				}
				const lockName = item.lock?.lock_name || item.device_name || ''
				uni.navigateTo({
					url: '/pages/share/share?lockauth_id=' + item.lockauth_id + '&lock_name=' + encodeURIComponent(lockName)
				})
			},
			async getphonenumber(e) {
				// #ifdef MP-TOUTIAO
				if (this.isLogin) {
					if (e.detail.errMsg.slice(-2) === "ok") {
						// 处理加密手机号数据

						// 提取加密数据和iv
						const encryptedData = e.detail.encryptedData;
						const iv = e.detail.iv;

						// 显示加载中
						uni.showLoading({
							title: '处理中...'
						});

						// 调用 toutiaoXcxMobile_api 发送加密数据到后端
						toutiaoXcxMobile_api({
							encryptedData,
							iv
						}).then(res1 => {
							if (res1.code === 10000) {
								uni.hideLoading();

								// 更新手机号信息
								tt_edit_info({
									mobile: res1.data.phoneNumber
								}).then(info => {
									// 可在此处处理成功后的操作
								});

								// 判断是否扫码开锁
								if (this.isQropen) {
									this.qrOpenLock();
								} else {
									this.showToast('绑定成功');
									let timer = setTimeout(() => {
										this.pageType = ''; // 手机号绑定成功，关闭弹层
										uni.navigateBack({
											delta: 1
										});
										clearTimeout(timer);
									}, 1000);
								}
							} else {
								this.showToast(res1.msg);
								uni.hideLoading();
							}
						}).catch(err => {
							// 错误处理
							console.error("API 请求失败: ", err);
							this.showToast('请求失败，请重试');
							uni.hideLoading();
						});

					} else {
						if (typeof tt !== 'undefined' && tt.showToast) {
							tt.showToast({
								title: "获取手机号失败",
								icon: "none",
							});
						}
					}
				} else {
					if (typeof tt !== 'undefined' && tt.showToast) {
						tt.showToast({
							title: "请先登录",
							icon: "none",
						});
					}
				}
				// #endif
				// #ifdef MP-ALIPAY
				my.getPhoneNumber({
					success: (res) => {
						zfbXcxMobile_api(res.response).then(res1 => {
							if (res1.code == 10000) {
								uni.hideLoading()
								zfb_edit_info({
									mobile: res1.mobile
								}).then(info => {

								})
								if (this.isQropen) {
									this.qrOpenLock()
								} else {
									this.showToast('绑定成功')
									let timer = setTimeout(() => {
										uni.navigateBack({
											delta: 1,
										})
										this.pageType = ''
										clearTimeout(timer)
									}, 1000)

								}
							} else {
								this.showToast(res1.msg)
								uni.hideLoading()
							}
						})

					}
				})
				// #endif
				// #ifdef MP-WEIXIN
				uni.login({
					provider: 'weixin',
					success: async loginRes => {
						if (e.detail.iv && e.detail.encryptedData) {
							uni.showLoading({
								title: '加载中...',
								mask: true
							})
							let res = await wxXcxMobile_api({
								code: e.detail.code
							});
							if (res.code === 0) {
								uni.hideLoading()
								if (this.isQropen) {
									this.qrOpenLock()
								} else {
									this.showToast('绑定成功')
									let timer = setTimeout(() => {
										uni.navigateBack({
											delta: 1,

										})
										this.pageType = ''
										clearTimeout(timer)
									}, 1000)

								}
							} else {
								this.showToast(res.msg)
								uni.hideLoading()
							}
						}
					},
					fail: err => {
						uni.showToast({
							title: '错误信息：' + err,
							icon: 'none'
						});
					}
				});

				// #endif

			},
			// 获取播放历史记录
			async getHornHistory(lockauth_id, page = 1, limit = 100) {
				try {
					const res = await getHornHistory_api({
						lockauth_id: lockauth_id,
						page: page,
						limit: limit
					})
					return res
				} catch (error) {
					console.error('获取播放历史失败:', error)
					return {
						code: -1,
						msg: '获取失败'
					}
				}
			},
			// 跳转到播放历史页面
			goToHornHistory() {
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					uni.showToast({
						title: '设备信息错误',
						icon: 'none'
					})
					return
				}
				uni.navigateTo({
					url: `/pages/hornHistory/hornHistory?lockauth_id=${this.hornItem.lockauth_id}&device_name=${encodeURIComponent(this.hornItem.device_name || '云喇叭')}`
				})
			},
			// 跳转到播放历史页面
			goHornHistory() {
				if (!this.hornItem || !this.hornItem.lockauth_id) {
					uni.showToast({
						title: '设备信息错误',
						icon: 'none'
					})
					return
				}
				const deviceName = this.hornItem.lock?.lock_name || this.hornItem.device_name || '云喇叭'
				const deviceSerial = this.hornItem.lock?.lock_sn || this.hornItem.device?.serial || ''
				uni.navigateTo({
					url: `/pages/hornHistory/hornHistory?lockauth_id=${this.hornItem.lockauth_id}&device_name=${encodeURIComponent(deviceName)}&device_serial=${encodeURIComponent(deviceSerial)}`
				})
			},
			getLocation() {

				if (this.latitude) {
					return
				}
				let that = this;
				uni.authorize({
					scope: 'scope.userLocation',
					success() {
						that.getAddress()
					},
					fail() {
						uni.showModal({
							content: '设备需要获取您的位置，是否去打开？',
							confirmText: '确认',
							cancelText: '取消',
							success: msg => {
								if (msg.confirm) {
									uni.openSetting({
										success: v => {
											that.getAddress()
										}
									});
								} else {
									return false;
								}
							},
							fail: err => {}
						});
						return false;
					}
				});
			},

			// 获取位置信息
			getAddress() {
				uni.getLocation({
					type: 'gcj02',
					success: res => {
						this.latitude = res.latitude
						this.longitude = res.longitude
						uni.setStorageSync('location', {
							latitude: this.latitude,
							longitude: this.longitude
						})
					},
					fail: function(err) {
					}
				});
			},
			async pinToTop(item) {
				uni.showLoading({
					title: '置顶中...',
					mask: true
				})
				try {
					// 计算最大排序值
					let maxSort = 0
					for (let device of this.dataList) {
						let sort = parseInt(device.auth_sort) || 0
						if (sort > maxSort) {
							maxSort = sort
						}
					}

					// 新的排序值 = 最大值 + 1
					const newSort = maxSort + 1

					// 调用API更新排序值
					let res = await authconfigSet_api({
						lockauth_id: item.lockauth_id,
						auth_sort: newSort
					})

					uni.hideLoading()

					if (res.code === 0) {
						uni.showToast({
							title: '置顶成功',
							icon: 'success',
						})
						// 刷新列表
						this.dataList = []
						this.page = 1
						this.showMask = false
						this.set_index = -1
						this.getList()
					} else {
						uni.showToast({
							title: res.msg,
							icon: 'none'
						})
					}
				} catch (e) {
					console.error('置顶失败:', e)
					uni.hideLoading()
					uni.showToast({
						title: '置顶失败',
						icon: 'none'
					})
				}
			},
			async onDelete(item) {
				uni.showModal({
					title: '提示',
					content: '确定删除？',
					success: async (msg) => {
						if (msg.confirm) {
							let res = await delDevice_api({
								lockauth_id: item.lockauth_id
							})
							if (res.code === 0) {
								uni.showToast({
									title: '删除成功',
									icon: 'none',
								})
								this.dataList = []
								this.page = 1
								this.showMask = false
								this.set_index = -1
								this.getList()
							} else {
								uni.showToast({
									title: res.msg,
									icon: 'none',
								})
							}

						}
					}
				})

			},
			// #ifdef MP-WEIXIN
			adLog(adlog_page, adlog_type, adlog_adtime, adlog_result, adlog_msg, adlog_points) {
				// 异步静默记录广告日志，不影响主流程
				try {
					adlog_api({
						adlog_page: adlog_page,
						adlog_type: adlog_type,
						adlog_adtime: adlog_adtime,
						adlog_result: adlog_result,
						adlog_msg: adlog_msg,
						adlog_points: adlog_points,
					}).catch(() => {
						// 静默处理失败，不输出日志
					});
				} catch (e) {
					// 静默处理异常，确保不影响主功能
				}
			},
			// #endif
		},
		onReachBottom() {
			if (this.noMore === 'noMore' || this.noMore === 'nodata') {
				return;
			}
			this.page++; //每触底一次 page +1
			this.getList();
		},
		async onPullDownRefresh() {
			try {
				this.page = 1; // 初始化分页
				this.dataList = []; // 清空数据列表
				this.noMore = 'loading'; // 重置加载状态
				this.status = ''; // 清除错误状态
				// 先重新获取分组数据，确保分组信息是最新的
				await this.getDeviceGroup();
			} catch (error) {
				console.error("Error in onPullDownRefresh:", error);
				uni.showToast({
					title: '刷新失败，请稍后再试',
					icon: 'none'
				});
			} finally {
				uni.stopPullDownRefresh(); // 确保下拉刷新状态被停止
			}
		},
	}
</script>

<style scoped lang="scss">
	@import './index.scss';
</style>
