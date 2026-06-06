<template>
  <view class="container">
    <!-- 头部信息 -->
    <view class="header-section">
      <view class="device-info">
        <view class="device-name">{{ deviceName }}</view>
        <view class="device-sn">SN: {{ device_sn }}</view>
      </view>
      <view class="status-row">
        <view class="status-item" :class="isOnline ? 'online' : 'offline'">
          <text class="status-dot"></text>
          <text>{{ isOnline ? '在线' : '离线' }}</text>
        </view>
        <view class="status-item" v-if="timeSynced">
          <uni-icons type="checkmarkempty" size="14" color="#07c160" />
          <text style="color:#07c160">时间已同步</text>
        </view>
        <view class="status-item" v-else>
          <uni-icons type="info" size="14" color="#ff9800" />
          <text style="color:#ff9800">时间未同步</text>
        </view>
      </view>
      <view class="current-time" v-if="currentTime">
        设备时间: {{ currentTime }}
      </view>
    </view>

    <!-- 开关控制区 -->
    <view class="control-section">
      <view class="switch-card" :class="{ 'switch-on': switchStatus === 1 }">
        <view class="switch-status">
          <text class="switch-text">{{ switchStatus === 1 ? '已开启' : '已关闭' }}</text>
          <view class="schedule-tip" v-if="controlledBySchedule >= 0">
            <uni-icons type="info" size="14" color="#ff9800" />
            <text>计划任务{{ controlledBySchedule + 1 }}控制中</text>
          </view>
        </view>
        <view class="switch-control">
          <switch
            :checked="switchStatus === 1"
            @change="onSwitchChange"
            :disabled="!isOnline"
            color="#07c160"
            style="transform: scale(1.5);"
          />
        </view>
      </view>
    </view>

    <!-- 计划任务列表 -->
    <view class="schedule-section">
      <view class="section-header">
        <text class="section-title">计划任务</text>
        <text class="section-tip">共{{ enabledCount }}/{{ schedules.length }}个已启用</text>
      </view>

      <view class="schedule-list">
        <view
          class="schedule-item"
          v-for="(schedule, index) in schedules"
          :key="index"
        >
          <view class="schedule-header" @click="editSchedule(index)">
            <view class="schedule-index">{{ index + 1 }}</view>
            <view class="schedule-info">
              <view class="time-range">
                {{ formatTime(schedule.start_hour, schedule.start_minute) }} - {{ formatTime(schedule.end_hour, schedule.end_minute) }}
              </view>
              <view class="weekdays-text">{{ formatWeekdays(schedule.weekdays) }}</view>
            </view>
            <view class="action-badge" :class="schedule.enabled ? (Number(schedule.action) === 1 ? 'action-on' : 'action-off') : 'action-disabled'">
              {{ schedule.enabled ? (Number(schedule.action) === 1 ? '开启' : '关闭') : '未启用' }}
            </view>
          </view>
          <view class="schedule-footer">
            <view class="switch-wrapper" @click.stop>
              <switch
                :checked="schedule.enabled"
                @change="toggleScheduleEnabled(index, $event)"
                color="#07c160"
                style="transform: scale(0.8);"
              />
            </view>
            <view class="edit-tip" @click="editSchedule(index)">点击编辑</view>
          </view>
        </view>
      </view>
    </view>

    <!-- 编辑计划任务弹窗 -->
    <uni-popup ref="schedulePopup" type="center" :mask-click="false">
      <view class="popup-content">
        <view class="popup-header">
          <text class="popup-title">{{ editingIndex >= 0 ? '编辑计划任务' + (editingIndex + 1) : '添加计划任务' }}</text>
          <view class="popup-close" @click="closePopup">
            <uni-icons type="closeempty" size="20" color="#999" />
          </view>
        </view>

        <view class="form-section">
          <!-- 启用开关 -->
          <view class="form-item">
            <text class="form-label">启用</text>
            <switch
              :checked="editingSchedule.enabled"
              @change="editingSchedule.enabled = $event.detail.value"
              color="#07c160"
            />
          </view>

          <!-- 开始时间 -->
          <view class="form-item">
            <text class="form-label">开始时间</text>
            <picker mode="time" :value="startTimeStr" @change="onStartTimeChange">
              <view class="time-picker">{{ startTimeStr }}</view>
            </picker>
          </view>

          <!-- 结束时间 -->
          <view class="form-item">
            <text class="form-label">结束时间</text>
            <picker mode="time" :value="endTimeStr" @change="onEndTimeChange">
              <view class="time-picker">{{ endTimeStr }}</view>
            </picker>
          </view>

          <!-- 星期选择 -->
          <view class="form-item weekdays-item">
            <text class="form-label">重复</text>
            <view class="weekdays-selector">
              <view
                class="weekday-btn"
                v-for="(day, idx) in weekdayOptions"
                :key="idx"
                :class="{ 'weekday-active': isWeekdaySelected(idx) }"
                @click="toggleWeekday(idx)"
              >
                {{ day }}
              </view>
            </view>
            <view class="quick-select">
              <text class="quick-btn" @click="selectAllWeekdays">每天</text>
              <text class="quick-btn" @click="selectWorkdays">工作日</text>
              <text class="quick-btn" @click="selectWeekend">周末</text>
            </view>
          </view>

          <!-- 动作选择 -->
          <view class="form-item">
            <text class="form-label">动作</text>
            <radio-group @change="editingSchedule.action = Number($event.detail.value)">
              <label class="radio-label">
                <radio value="1" :checked="editingSchedule.action === 1" color="#07c160" />
                <text>时间段内开启</text>
              </label>
              <label class="radio-label">
                <radio value="0" :checked="editingSchedule.action === 0" color="#07c160" />
                <text>时间段内关闭</text>
              </label>
            </radio-group>
          </view>
        </view>

        <view class="popup-footer">
          <button class="btn-cancel" @click="closePopup">取消</button>
          <button class="btn-clear" @click="clearCurrentSchedule" v-if="editingIndex >= 0">清除</button>
          <button class="btn-save" @click="saveSchedule">保存</button>
        </view>
      </view>
    </uni-popup>
  </view>
</template>

<script>
import {
  getW71Status_api,
  turnOnW71_api,
  turnOffW71_api,
  getW71Schedules_api,
  setW71Schedule_api,
  clearW71Schedule_api
} from '../../api/index.js';

export default {
  data() {
    return {
      device_sn: '',
      lockauth_id: '',
      deviceName: '空开断路器',
      isOnline: false,
      switchStatus: 0,
      timeSynced: false,
      currentTime: '',
      controlledBySchedule: -1,
      scheduledState: 0,
      schedules: [],
      editingIndex: -1,
      editingSchedule: {
        enabled: true,
        start_hour: 8,
        start_minute: 0,
        end_hour: 18,
        end_minute: 0,
        weekdays: 127,
        action: 1
      },
      weekdayOptions: ['日', '一', '二', '三', '四', '五', '六'],
      loading: false
    };
  },

  computed: {
    enabledCount() {
      return this.schedules.filter(s => s.enabled).length;
    },
    startTimeStr() {
      return this.formatTime(this.editingSchedule.start_hour, this.editingSchedule.start_minute);
    },
    endTimeStr() {
      return this.formatTime(this.editingSchedule.end_hour, this.editingSchedule.end_minute);
    }
  },

  async onLoad(options) {
    this.device_sn = options.device_sn;
    this.lockauth_id = options.lockauth_id;
    // 接收设备名称，如果未传递则使用默认值
    if (options.device_name) {
      this.deviceName = decodeURIComponent(options.device_name);
    }
    // 接收在线状态
    if (options.online !== undefined) {
      this.isOnline = options.online == 1;
    }

    uni.showLoading({ title: '加载中...' });
    try {
      await this.getDeviceStatus();
      await this.getSchedules();
    } finally {
      uni.hideLoading();
    }
  },

  onPullDownRefresh() {
    Promise.all([
      this.getDeviceStatus(),
      this.getSchedules()
    ]).finally(() => {
      uni.stopPullDownRefresh();
    });
  },

  methods: {
    // 获取设备状态
    async getDeviceStatus() {
      try {
        const res = await getW71Status_api({ device_sn: this.device_sn });
        if (res.code === 0 && res.data && res.data.info) {
          const info = res.data.info;
          // 设备能响应说明在线
          this.isOnline = true;
          // 设备返回的是 switch_state 字段
          this.switchStatus = (info.switch_state !== undefined && info.switch_state !== null) ? info.switch_state : ((info.status !== undefined && info.status !== null) ? info.status : 0);
          this.controlledBySchedule = (info.controlled_by_schedule !== undefined && info.controlled_by_schedule !== null) ? info.controlled_by_schedule : -1;
          this.scheduledState = (info.scheduled_state !== undefined && info.scheduled_state !== null) ? info.scheduled_state : 0;
        } else if (res.code !== 0) {
          // 请求失败可能是设备离线
          // 保持从参数传入的在线状态
        }
      } catch (err) {
        console.error('获取设备状态失败:', err);
        // 请求异常可能是设备离线
      }
    },

    // 获取计划任务列表
    async getSchedules() {
      try {
        const res = await getW71Schedules_api({ device_sn: this.device_sn });
        if (res.code === 0 && res.data && res.data.info) {
          const info = res.data.info;
          this.schedules = info.schedules || [];
          // 时间同步状态：设备返回time_synced字段，或者有current_time说明已同步
          this.timeSynced = info.time_synced === true || info.time_synced === 1 || (info.current_time && info.current_time.length > 0);
          this.currentTime = info.current_time || '';
          this.controlledBySchedule = (info.controlled_by_schedule !== undefined && info.controlled_by_schedule !== null) ? info.controlled_by_schedule : -1;
          this.scheduledState = (info.scheduled_state !== undefined && info.scheduled_state !== null) ? info.scheduled_state : 0;
          // 设备能响应说明在线
          this.isOnline = true;

          // 确保有10组计划任务
          while (this.schedules.length < 10) {
            this.schedules.push({
              enabled: false,
              start_hour: 8,
              start_minute: 0,
              end_hour: 18,
              end_minute: 0,
              weekdays: 127,
              action: 1
            });
          }
        }
      } catch (err) {
        console.error('获取计划任务失败:', err);
        uni.showToast({ title: '获取计划任务失败', icon: 'none' });
      }
    },

    // 开关切换
    async onSwitchChange(e) {
      const turnOn = e.detail.value;

      if (this.controlledBySchedule >= 0) {
        uni.showModal({
          title: '提示',
          content: `当前处于计划任务${this.controlledBySchedule + 1}控制中，确定要手动操作吗？`,
          success: async (res) => {
            if (res.confirm) {
              await this.doSwitch(turnOn);
            } else {
              // 恢复开关状态
              this.switchStatus = this.switchStatus;
            }
          }
        });
        return;
      }

      await this.doSwitch(turnOn);
    },

    async doSwitch(turnOn) {
      // 保存操作前的状态，用于恢复
      const previousStatus = this.switchStatus;
      this.loading = true;
      uni.showLoading({ title: turnOn ? '开启中...' : '关闭中...' });

      try {
        const api = turnOn ? turnOnW71_api : turnOffW71_api;
        const res = await api({ device_sn: this.device_sn });

        if (res.code === 0) {
          // info 可能是数组格式或对象格式
          const rawInfo = (res.data && res.data.info) ? res.data.info : null;
          let info = {};

          if (Array.isArray(rawInfo)) {
            // 数组格式: 查找 code 值
            // 格式可能是 [code, status, msg] 或包含更多字段
            // 检查数组中是否有 code=2 (被计划任务控制)
            const hasCode2 = rawInfo.includes(2);
            const msgIndex = rawInfo.findIndex(item => typeof item === 'string' && item.includes('schedule'));

            if (hasCode2 || msgIndex >= 0) {
              // 被计划任务控制
              info = {
                code: 2,
                msg: msgIndex >= 0 ? rawInfo[msgIndex] : '被计划任务控制'
              };
            } else {
              // 操作成功
              info = {
                code: (rawInfo[0] !== undefined && rawInfo[0] !== null) ? rawInfo[0] : 0,
                msg: ''
              };
            }
          } else if (rawInfo && typeof rawInfo === 'object') {
            info = rawInfo;
          }

          if (info.code === 2) {
            // 被计划任务控制，恢复开关状态
            this.switchStatus = previousStatus;
            // 强制触发视图更新
            this.$nextTick(() => {
              this.switchStatus = previousStatus;
            });
            uni.showToast({
              title: '被计划任务控制，操作被拒绝',
              icon: 'none',
              duration: 2000
            });
          } else if (info.code === 0 || info.code === undefined) {
            this.switchStatus = turnOn ? 1 : 0;
            uni.showToast({ title: turnOn ? '已开启' : '已关闭', icon: 'success' });
            uni.vibrateShort();
          } else {
            // 操作失败，恢复状态
            this.switchStatus = previousStatus;
            uni.showToast({ title: info.msg || '操作失败', icon: 'none' });
          }
        } else {
          // 请求失败，恢复状态
          this.switchStatus = previousStatus;
          uni.showToast({ title: res.msg || '操作失败', icon: 'none' });
        }
      } catch (err) {
        console.error('操作失败:', err);
        // 异常时恢复状态
        this.switchStatus = previousStatus;
        uni.showToast({ title: '操作失败', icon: 'none' });
      } finally {
        this.loading = false;
        uni.hideLoading();
      }
    },

    // 编辑计划任务
    editSchedule(index) {
      this.editingIndex = index;
      this.editingSchedule = { ...this.schedules[index] };
      this.$refs.schedulePopup.open();
    },

    // 关闭弹窗
    closePopup() {
      this.$refs.schedulePopup.close();
      this.editingIndex = -1;
    },

    // 切换计划任务启用状态
    async toggleScheduleEnabled(index, e) {
      const enabled = e.detail.value;
      const schedule = { ...this.schedules[index], enabled };

      uni.showLoading({ title: '保存中...' });
      try {
        const res = await setW71Schedule_api({
          device_sn: this.device_sn,
          index: index,
          ...schedule
        });

        if (res.code === 0 && res.data && res.data.info && res.data.info.code === 0) {
          this.schedules[index].enabled = enabled;
          uni.showToast({ title: '保存成功', icon: 'success' });
        } else {
          uni.showToast({ title: res.msg || '保存失败', icon: 'none' });
          // 恢复状态
          await this.getSchedules();
        }
      } catch (err) {
        console.error('保存失败:', err);
        uni.showToast({ title: '保存失败', icon: 'none' });
      } finally {
        uni.hideLoading();
      }
    },

    // 保存计划任务
    async saveSchedule() {
      // 验证
      if (this.editingSchedule.weekdays === 0) {
        uni.showToast({ title: '请至少选择一天', icon: 'none' });
        return;
      }

      uni.showLoading({ title: '保存中...' });
      try {
        const res = await setW71Schedule_api({
          device_sn: this.device_sn,
          index: this.editingIndex,
          ...this.editingSchedule
        });

        if (res.code === 0 && res.data && res.data.info && res.data.info.code === 0) {
          this.schedules[this.editingIndex] = { ...this.editingSchedule };
          this.closePopup();
          uni.showToast({ title: '保存成功', icon: 'success' });
        } else {
          uni.showToast({ title: (res.data && res.data.info && res.data.info.msg) || res.msg || '保存失败', icon: 'none' });
        }
      } catch (err) {
        console.error('保存失败:', err);
        uni.showToast({ title: '保存失败', icon: 'none' });
      } finally {
        uni.hideLoading();
      }
    },

    // 清除当前计划任务
    async clearCurrentSchedule() {
      uni.showModal({
        title: '确认清除',
        content: `确定要清除计划任务${this.editingIndex + 1}吗？`,
        success: async (res) => {
          if (res.confirm) {
            uni.showLoading({ title: '清除中...' });
            try {
              const res = await clearW71Schedule_api({
                device_sn: this.device_sn,
                index: this.editingIndex
              });

              if (res.code === 0 && res.data && res.data.info && res.data.info.code === 0) {
                this.schedules[this.editingIndex] = {
                  enabled: false,
                  start_hour: 8,
                  start_minute: 0,
                  end_hour: 18,
                  end_minute: 0,
                  weekdays: 127,
                  action: 1
                };
                this.closePopup();
                uni.showToast({ title: '已清除', icon: 'success' });
              } else {
                uni.showToast({ title: res.msg || '清除失败', icon: 'none' });
              }
            } catch (err) {
              console.error('清除失败:', err);
              uni.showToast({ title: '清除失败', icon: 'none' });
            } finally {
              uni.hideLoading();
            }
          }
        }
      });
    },

    // 时间选择
    onStartTimeChange(e) {
      const [hour, minute] = e.detail.value.split(':').map(Number);
      this.editingSchedule.start_hour = hour;
      this.editingSchedule.start_minute = minute;
    },

    onEndTimeChange(e) {
      const [hour, minute] = e.detail.value.split(':').map(Number);
      this.editingSchedule.end_hour = hour;
      this.editingSchedule.end_minute = minute;
    },

    // 星期选择
    isWeekdaySelected(dayIndex) {
      return (this.editingSchedule.weekdays & (1 << dayIndex)) !== 0;
    },

    toggleWeekday(dayIndex) {
      this.editingSchedule.weekdays ^= (1 << dayIndex);
    },

    selectAllWeekdays() {
      this.editingSchedule.weekdays = 127; // 0x7F
    },

    selectWorkdays() {
      this.editingSchedule.weekdays = 62; // 0x3E = 周一至周五
    },

    selectWeekend() {
      this.editingSchedule.weekdays = 65; // 0x41 = 周六周日
    },

    // 格式化时间
    formatTime(hour, minute) {
      return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
    },

    // 格式化星期
    formatWeekdays(weekdays) {
      if (weekdays === 127) return '每天';
      if (weekdays === 62) return '工作日';
      if (weekdays === 65) return '周末';

      const days = [];
      const names = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
      for (let i = 0; i < 7; i++) {
        if (weekdays & (1 << i)) {
          days.push(names[i]);
        }
      }
      return days.join(' ') || '未选择';
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
  background: #f5f5f5;
  padding-bottom: 40rpx;
}

.header-section {
  background: linear-gradient(135deg, #07c160 0%, #10a37f 100%);
  padding: 40rpx 30rpx;
  color: #fff;

  .device-info {
    margin-bottom: 20rpx;

    .device-name {
      font-size: 36rpx;
      font-weight: bold;
    }

    .device-sn {
      font-size: 24rpx;
      opacity: 0.8;
      margin-top: 8rpx;
    }
  }

  .status-row {
    display: flex;
    align-items: center;
    gap: 30rpx;

    .status-item {
      display: flex;
      align-items: center;
      gap: 8rpx;
      font-size: 24rpx;

      &.online .status-dot {
        background: #00ff00;
      }

      &.offline .status-dot {
        background: #ff4444;
      }

      .status-dot {
        width: 16rpx;
        height: 16rpx;
        border-radius: 50%;
      }
    }
  }

  .current-time {
    margin-top: 16rpx;
    font-size: 22rpx;
    opacity: 0.8;
  }
}

.control-section {
  padding: 30rpx;

  .switch-card {
    background: #fff;
    border-radius: 20rpx;
    padding: 40rpx;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4rpx 20rpx rgba(0, 0, 0, 0.08);

    &.switch-on {
      background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    }

    .switch-status {
      .switch-text {
        font-size: 36rpx;
        font-weight: bold;
        color: #333;
      }

      .schedule-tip {
        display: flex;
        align-items: center;
        gap: 8rpx;
        margin-top: 10rpx;
        font-size: 24rpx;
        color: #ff9800;
      }
    }
  }
}

.schedule-section {
  padding: 0 30rpx;

  .section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20rpx;

    .section-title {
      font-size: 32rpx;
      font-weight: bold;
      color: #333;
    }

    .section-tip {
      font-size: 24rpx;
      color: #999;
    }
  }

  .schedule-list {
    .schedule-item {
      background: #fff;
      border-radius: 16rpx;
      padding: 24rpx;
      margin-bottom: 20rpx;
      box-shadow: 0 2rpx 12rpx rgba(0, 0, 0, 0.05);

      .schedule-header {
        display: flex;
        align-items: center;
        gap: 20rpx;

        .schedule-index {
          width: 48rpx;
          height: 48rpx;
          background: #f0f0f0;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24rpx;
          color: #666;
          flex-shrink: 0;
        }

        .schedule-info {
          flex: 1;

          .time-range {
            font-size: 32rpx;
            font-weight: bold;
            color: #333;
          }

          .weekdays-text {
            font-size: 24rpx;
            color: #999;
            margin-top: 6rpx;
          }
        }

        .action-badge {
          padding: 8rpx 20rpx;
          border-radius: 20rpx;
          font-size: 24rpx;

          &.action-on {
            background: #e8f5e9;
            color: #07c160;
          }

          &.action-off {
            background: #ffebee;
            color: #e34d59;
          }

          &.action-disabled {
            background: #f5f5f5;
            color: #999;
          }
        }
      }

      .schedule-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16rpx;
        padding-top: 16rpx;
        border-top: 1rpx solid #f0f0f0;

        .edit-tip {
          font-size: 22rpx;
          color: #999;
        }
      }
    }
  }
}

// 弹窗样式
.popup-content {
  width: 650rpx;
  background: #fff;
  border-radius: 20rpx;
  overflow: hidden;

  .popup-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 30rpx;
    border-bottom: 1rpx solid #f0f0f0;

    .popup-title {
      font-size: 32rpx;
      font-weight: bold;
      color: #333;
    }

    .popup-close {
      padding: 10rpx;
    }
  }

  .form-section {
    padding: 30rpx;
    max-height: 800rpx;
    overflow-y: auto;

    .form-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20rpx 0;
      border-bottom: 1rpx solid #f5f5f5;

      &.weekdays-item {
        flex-direction: column;
        align-items: flex-start;

        .form-label {
          margin-bottom: 20rpx;
        }
      }

      .form-label {
        font-size: 28rpx;
        color: #333;
      }

      .time-picker {
        font-size: 32rpx;
        color: #07c160;
        padding: 10rpx 20rpx;
        background: #f5f5f5;
        border-radius: 8rpx;
      }

      .weekdays-selector {
        display: flex;
        gap: 16rpx;
        flex-wrap: wrap;

        .weekday-btn {
          width: 64rpx;
          height: 64rpx;
          border-radius: 50%;
          background: #f5f5f5;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24rpx;
          color: #666;

          &.weekday-active {
            background: #07c160;
            color: #fff;
          }
        }
      }

      .quick-select {
        display: flex;
        gap: 20rpx;
        margin-top: 20rpx;

        .quick-btn {
          font-size: 24rpx;
          color: #07c160;
          padding: 8rpx 16rpx;
          border: 1rpx solid #07c160;
          border-radius: 20rpx;
        }
      }

      .radio-label {
        display: flex;
        align-items: center;
        margin-right: 30rpx;
        font-size: 28rpx;
        color: #333;
      }
    }
  }

  .popup-footer {
    display: flex;
    padding: 30rpx;
    gap: 20rpx;
    border-top: 1rpx solid #f0f0f0;

    button {
      flex: 1;
      height: 80rpx;
      line-height: 80rpx;
      border-radius: 40rpx;
      font-size: 28rpx;
      margin: 0;

      &.btn-cancel {
        background: #f5f5f5;
        color: #666;
      }

      &.btn-clear {
        background: #ffebee;
        color: #e34d59;
      }

      &.btn-save {
        background: #07c160;
        color: #fff;
      }
    }
  }
}
</style>
