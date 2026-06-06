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

    <!-- 定时播报列表 -->
    <view class="schedule-section">
      <view class="section-header">
        <text class="section-title">定时播报</text>
        <text class="section-tip">共{{ enabledCount}}/{{ totalCount }}个已启用</text>
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
              <view class="time-display">{{ formatTime(schedule.hour, schedule.minute) }}</view>
              <view class="tts-text" v-if="schedule.tts_text">{{ schedule.tts_text }}</view>
              <view class="tts-text empty" v-else>未设置播报内容</view>
              <view class="weekdays-text">{{ formatWeekdays(schedule.weekdays) }}</view>
            </view>
            <view class="enabled-badge" :class="schedule.enabled ? 'enabled' : 'disabled'">
              {{ schedule.enabled ? '已启用' : '未启用' }}
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

    <!-- 编辑定时播报弹窗 -->
    <uni-popup ref="schedulePopup" type="center" :mask-click="false">
      <view class="popup-content">
        <view class="popup-header">
          <text class="popup-title">{{ editingIndex >= 0 ? '编辑定时播报' + (editingIndex + 1) : '添加定时播报' }}</text>
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

          <!-- 播报时间 -->
          <view class="form-item">
            <text class="form-label">播报时间</text>
            <picker mode="time" :value="timeStr" @change="onTimeChange">
              <view class="time-picker">{{ timeStr }}</view>
            </picker>
          </view>

          <!-- 播报内容 -->
          <view class="form-item">
            <text class="form-label">播报内容</text>
            <textarea
              v-model="editingSchedule.tts_text"
              placeholder="请输入播报内容"
              maxlength="200"
              class="tts-textarea"
            />
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

          <!-- 重复播报次数 -->
          <view class="form-item">
            <text class="form-label">重复播报</text>
            <picker mode="selector" :range="repeatCountOptions" :value="repeatCountIndex" @change="onRepeatCountChange">
              <view class="picker-display">{{ repeatCountOptions[repeatCountIndex] }}</view>
            </picker>
          </view>

          <!-- 发音人选择（仅W70B和W70R显示） -->
          <view class="form-item" v-if="device_sn && (device_sn.startsWith('W70B') || device_sn.startsWith('W70R'))">
            <text class="form-label">发音人</text>
            <picker mode="selector" :range="speakerNames" :value="speakerIndex" @change="onSpeakerChange">
              <view class="picker-display">{{ speakerNames[speakerIndex] || '女声-高音' }}</view>
            </picker>
          </view>

          <!-- 数字播报模式选择（仅W70B和W70R显示） -->
          <view class="form-item" v-if="device_sn && (device_sn.startsWith('W70B') || device_sn.startsWith('W70R'))">
            <text class="form-label">数字播报</text>
            <picker mode="selector" :range="numberModeNames" :value="numberModeIndex" @change="onNumberModeChange">
              <view class="picker-display">{{ numberModeNames[numberModeIndex] || '逐位播报' }}</view>
            </picker>
          </view>

          <!-- 语速选择 -->
          <view class="form-item">
            <text class="form-label">语速</text>
            <picker mode="selector" :range="speedOptions" :value="speedIndex" @change="onSpeedChange">
              <view class="picker-display">{{ speedOptions[speedIndex] }}</view>
            </picker>
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
import UniIcons from '@/components/uni-icons/uni-icons.vue';
import UniPopup from '@/components/uni-popup/uni-popup.vue';
import {
  getTtsSchedules_api,
  setTtsSchedule_api,
  clearTtsSchedule_api,
  getTtsSpeakers_api
} from '../../api/index.js';

export default {
  components: {
    UniIcons,
    UniPopup
  },
  data() {
    return {
      device_sn: '',
      deviceName: '云喇叭',
      isOnline: false,
      timeSynced: false,
      currentTime: '',
      totalCount: 20,
      schedules: [],
      editingIndex: -1,
      editingSchedule: {
        enabled: true,
        hour: 8,
        minute: 0,
        weekdays: 127,
        tts_text: '',
        speaker: 'prompt_female_high',
        speed: 1.0,
        repeat_count: 3,
        number_mode: 'digit'
      },
      weekdayOptions: ['日', '一', '二', '三', '四', '五', '六'],
      repeatCountOptions: ['1次', '2次', '3次', '4次', '5次', '6次', '7次', '8次', '9次', '10次'],
      speedOptions: ['0.5倍速', '0.75倍速', '1.0倍速', '1.25倍速', '1.5倍速', '2.0倍速'],
      speedValues: [0.5, 0.75, 1.0, 1.25, 1.5, 2.0],
      speakers: [
        { id: 'prompt_female_high', name: '女声-高音', description: '系统', default: true },
        { id: 'prompt_duoduo', name: '女声-多多', description: '默认女声发音人' },
        { id: 'prompt_wenroutaotao', name: '桃桃-温柔', description: '默认女声发音人，音调温柔' },
        { id: 'prompt_kunkun', name: '男声-坤坤', description: '系统' },
        { id: 'prompt_bobo', name: '男声-优雅', description: '默认男声发音人，音调优雅' },
        { id: 'prompt_ref_audio_02', name: '男声-搞怪', description: '默认男声发音人，音调搞怪' }
      ],
      numberModes: [
        { id: 'digit', name: '逐位播报' },
        { id: 'value', name: '数值播报' }
      ],
      loading: false
    };
  },

  computed: {
    enabledCount() {
      return this.schedules.filter(s => s.enabled).length;
    },
    timeStr() {
      return this.formatTime(this.editingSchedule.hour, this.editingSchedule.minute);
    },
    repeatCountIndex() {
      const count = this.normalizeRepeatCount(this.editingSchedule.repeat_count);
      return Math.max(0, Math.min(9, count - 1));
    },
    speedIndex() {
      const speed = this.editingSchedule.speed || 1.0;
      const idx = this.speedValues.findIndex(v => Math.abs(v - speed) < 0.01);
      return idx >= 0 ? idx : 2; // 默认1.0倍速（索引2）
    },
    speakerNames() {
      return this.speakers.map(s => s.name);
    },
    speakerIndex() {
      const speakerId = this.editingSchedule.speaker || 'prompt_female_high';
      const idx = this.speakers.findIndex(s => s.id === speakerId);
      return idx >= 0 ? idx : 0;
    },
    numberModeNames() {
      return this.numberModes.map(m => m.name);
    },
    numberModeIndex() {
      const modeId = this.editingSchedule.number_mode || 'digit';
      const idx = this.numberModes.findIndex(m => m.id === modeId);
      return idx >= 0 ? idx : 0;
    }
  },

  async onLoad(options) {
    this.device_sn = options.device_sn;
    if (options.device_name) {
      this.deviceName = decodeURIComponent(options.device_name);
    }
    if (options.online !== undefined) {
      this.isOnline = options.online == 1;
    }

    uni.showLoading({ title: '加载中...' });
    try {
      await Promise.all([
        this.getSchedules(),
        this.getSpeakers()
      ]);
    } finally {
      uni.hideLoading();
    }
  },

  onPullDownRefresh() {
    this.getSchedules().finally(() => {
      uni.stopPullDownRefresh();
    });
  },

  methods: {
    // 获取定时播报列表
    async getSchedules() {
      try {
        const res = await getTtsSchedules_api({ device_sn: this.device_sn });
        if (res.code === 0 && res.data && res.data.info) {
          const info = res.data.info;
          this.schedules = info.schedules || [];
          this.timeSynced = info.time_synced === true || info.time_synced === 1;
          this.currentTime = info.current_time || '';
          this.isOnline = true;
          this.totalCount = this.schedules.length;

          // 确保有20组定时任务
          while (this.schedules.length < 20) {
            this.schedules.push({
              enabled: false,
              hour: 8,
              minute: 0,
              weekdays: 127,
              tts_text: '',
              speaker: 'prompt_female_high',
              speed: 1.0,
              repeat_count: 3
            });
          }

          this.schedules = this.schedules.map(schedule => ({
            ...schedule,
            repeat_count: this.normalizeRepeatCount(schedule.repeat_count)
          }));
        }
      } catch (err) {
        console.error('获取定时播报失败:', err);
        uni.showToast({ title: '获取定时播报失败', icon: 'none' });
      }
    },

    // 编辑定时播报
    editSchedule(index) {
      this.editingIndex = index;
      const schedule = this.schedules[index];
      this.editingSchedule = {
        enabled: schedule.enabled,
        hour: schedule.hour,
        minute: schedule.minute,
        weekdays: schedule.weekdays,
        tts_text: schedule.tts_text || '',
        speaker: schedule.speaker || 'prompt_female_high',
        speed: schedule.speed || 1.0,
        repeat_count: this.normalizeRepeatCount(schedule.repeat_count),
        number_mode: schedule.number_mode || 'digit'
      };
      this.$refs.schedulePopup.open();
    },

    normalizeRepeatCount(value) {
      const count = parseInt(value, 10);
      if (Number.isNaN(count)) {
        return 3;
      }
      return Math.max(1, Math.min(10, count));
    },

    // 关闭弹窗
    closePopup() {
      this.$refs.schedulePopup.close();
      this.editingIndex = -1;
    },

    // 时间选择
    onTimeChange(e) {
      const time = e.detail.value.split(':');
      this.editingSchedule.hour = parseInt(time[0]);
      this.editingSchedule.minute = parseInt(time[1]);
    },

    // 星期选择
    isWeekdaySelected(weekday) {
      return (this.editingSchedule.weekdays & (1 << weekday)) !== 0;
    },

    toggleWeekday(weekday) {
      this.editingSchedule.weekdays ^= (1 << weekday);
    },

    selectAllWeekdays() {
      this.editingSchedule.weekdays = 127; // 0x7F
    },

    selectWorkdays() {
      this.editingSchedule.weekdays = 62; // 0x3E (周一到周五)
    },

    selectWeekend() {
      this.editingSchedule.weekdays = 65; // 0x41 (周六周日)
    },

    // 重复次数选择
    onRepeatCountChange(e) {
      this.editingSchedule.repeat_count = parseInt(e.detail.value, 10) + 1;
    },

    // 语速选择
    onSpeedChange(e) {
      this.editingSchedule.speed = this.speedValues[e.detail.value];
    },

    // 发音人选择
    onSpeakerChange(e) {
      const index = e.detail.value;
      if (this.speakers[index]) {
        this.editingSchedule.speaker = this.speakers[index].id;
      }
    },

    // 数字播报模式选择
    onNumberModeChange(e) {
      const index = e.detail.value;
      if (this.numberModes[index]) {
        this.editingSchedule.number_mode = this.numberModes[index].id;
      }
    },

    // 获取发音人列表
    async getSpeakers() {
      try {
        const res = await getTtsSpeakers_api({ device_sn: this.device_sn });
        // 接口返回格式: {speakers: [...], code: 0, msg: "操作成功"}
        if (res.code === 0 && res.speakers && res.speakers.length > 0) {
          this.speakers = res.speakers;
        } else if (res.code === 0 && res.data && res.data.speakers && res.data.speakers.length > 0) {
          // 兼容另一种格式: {data: {speakers: [...]}, code: 0}
          this.speakers = res.data.speakers;
        }
        // 如果没有获取到，保持默认列表
      } catch (err) {
        console.error('获取发音人列表失败:', err);
        // 保持默认发音人列表
      }
    },

    // 切换启用状态
    async toggleScheduleEnabled(index, e) {
      const enabled = e.detail.value;
      this.loading = true;

      try {
        const schedule = { ...this.schedules[index], enabled };
        const res = await setTtsSchedule_api({
          device_sn: this.device_sn,
          index,
          ...schedule
        });

        if (res.code === 0) {
          this.schedules[index].enabled = enabled;
          uni.showToast({ title: enabled ? '已启用' : '已禁用', icon: 'success' });
        } else {
          uni.showToast({ title: res.msg || '操作失败', icon: 'none' });
        }
      } catch (err) {
        console.error('切换状态失败:', err);
        uni.showToast({ title: '操作失败', icon: 'none' });
      } finally {
        this.loading = false;
      }
    },

    // 保存定时播报
    async saveSchedule() {
      if (!this.editingSchedule.tts_text) {
        uni.showToast({ title: '请输入播报内容', icon: 'none' });
        return;
      }

      if (this.editingSchedule.weekdays === 0) {
        uni.showToast({ title: '请选择至少一天', icon: 'none' });
        return;
      }

      this.loading = true;
      uni.showLoading({ title: '保存中...' });

      try {
        const res = await setTtsSchedule_api({
          device_sn: this.device_sn,
          index: this.editingIndex,
          ...this.editingSchedule
        });

        if (res.code === 0) {
          this.schedules[this.editingIndex] = {
            ...this.editingSchedule,
            repeat_count: this.normalizeRepeatCount(this.editingSchedule.repeat_count)
          };
          uni.showToast({ title: '保存成功', icon: 'success' });
          uni.vibrateShort();
          this.closePopup();
        } else {
          uni.showToast({ title: res.msg || '保存失败', icon: 'none' });
        }
      } catch (err) {
        console.error('保存失败:', err);
        uni.showToast({ title: '保存失败', icon: 'none' });
      } finally {
        this.loading = false;
        uni.hideLoading();
      }
    },

    // 清除定时播报
    async clearCurrentSchedule() {
      uni.showModal({
        title: '确认清除',
        content: '确定要清除此定时播报吗？',
        success: async (res) => {
          if (res.confirm) {
            await this.doClearSchedule();
          }
        }
      });
    },

    async doClearSchedule() {
      this.loading = true;
      uni.showLoading({ title: '清除中...' });

      try {
        const res = await clearTtsSchedule_api({
          device_sn: this.device_sn,
          index: this.editingIndex
        });

        if (res.code === 0) {
          this.schedules[this.editingIndex] = {
            enabled: false,
            hour: 8,
            minute: 0,
            weekdays: 127,
            tts_text: '',
            speaker: 'prompt_female_high',
            speed: 1.0,
            repeat_count: 3,
            number_mode: 'digit'
          };
          uni.showToast({ title: '清除成功', icon: 'success' });
          this.closePopup();
        } else {
          uni.showToast({ title: res.msg || '清除失败', icon: 'none' });
        }
      } catch (err) {
        console.error('清除失败:', err);
        uni.showToast({ title: '清除失败', icon: 'none' });
      } finally {
        this.loading = false;
        uni.hideLoading();
      }
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
      for (let i = 0; i < 7; i++) {
        if (weekdays & (1 << i)) {
          days.push(this.weekdayOptions[i]);
        }
      }
      return days.length > 0 ? '周' + days.join('、') : '未设置';
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  min-height: 100vh;
  background: #f5f5f5;
  padding: 20rpx;
}

.header-section {
  background: #fff;
  border-radius: 16rpx;
  padding: 30rpx;
  margin-bottom: 20rpx;
}

.device-info {
  margin-bottom: 20rpx;
}

.device-name {
  font-size: 36rpx;
  font-weight: bold;
  color: #333;
  margin-bottom: 10rpx;
}

.device-sn {
  font-size: 24rpx;
  color: #999;
}

.status-row {
  display: flex;
  gap: 20rpx;
}

.status-item {
  display: flex;
  align-items: center;
  gap: 8rpx;
  font-size: 24rpx;

  &.online {
    color: #07c160;
  }

  &.offline {
    color: #999;
  }
}

.status-dot {
  width: 12rpx;
  height: 12rpx;
  border-radius: 50%;
  background: currentColor;
}

.current-time {
  margin-top: 20rpx;
  font-size: 24rpx;
  color: #666;
}

.schedule-section {
  background: #fff;
  border-radius: 16rpx;
  padding: 30rpx;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20rpx;
}

.section-title {
  font-size: 32rpx;
  font-weight: bold;
  color: #333;
}

.section-tip {
  font-size: 24rpx;
  color: #999;
}

.schedule-list {
  display: flex;
  flex-direction: column;
  gap: 20rpx;
}

.schedule-item {
  border: 1px solid #eee;
  border-radius: 12rpx;
  padding: 20rpx;
  background: #fafafa;
}

.schedule-header {
  display: flex;
  align-items: flex-start;
  gap: 20rpx;
  margin-bottom: 15rpx;
}

.schedule-index {
  width: 48rpx;
  height: 48rpx;
  border-radius: 50%;
  background: #07c160;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24rpx;
  font-weight: bold;
  flex-shrink: 0;
}

.schedule-info {
  flex: 1;
}

.time-display {
  font-size: 32rpx;
  font-weight: bold;
  color: #333;
  margin-bottom: 8rpx;
}

.tts-text {
  font-size: 26rpx;
  color: #666;
  margin-bottom: 8rpx;
  line-height: 1.5;

  &.empty {
    color: #999;
    font-style: italic;
  }
}

.weekdays-text {
  font-size: 24rpx;
  color: #999;
}

.enabled-badge {
  padding: 8rpx 20rpx;
  border-radius: 20rpx;
  font-size: 22rpx;
  flex-shrink: 0;

  &.enabled {
    background: #e7f7ef;
    color: #07c160;
  }

  &.disabled {
    background: #f5f5f5;
    color: #999;
  }
}

.schedule-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 15rpx;
  border-top: 1px solid #eee;
}

.edit-tip {
  font-size: 24rpx;
  color: #07c160;
}

.popup-content {
  width: 650rpx;
  max-height: 80vh;
  background: #fff;
  border-radius: 16rpx;
  overflow: hidden;
}

.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 30rpx;
  border-bottom: 1px solid #eee;
}

.popup-title {
  font-size: 32rpx;
  font-weight: bold;
  color: #333;
}

.form-section {
  padding: 30rpx;
  max-height: 60vh;
  overflow-y: auto;
}

.form-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30rpx;

  &.weekdays-item {
    flex-direction: column;
    align-items: flex-start;
  }
}

.form-label {
  font-size: 28rpx;
  color: #333;
  margin-bottom: 10rpx;
}

.time-picker {
  padding: 15rpx 30rpx;
  background: #f5f5f5;
  border-radius: 8rpx;
  font-size: 28rpx;
  color: #333;
}

.picker-display {
  padding: 15rpx 30rpx;
  background: #f5f5f5;
  border-radius: 8rpx;
  font-size: 28rpx;
  color: #333;
}

.tts-textarea {
  width: 100%;
  min-height: 150rpx;
  padding: 20rpx;
  background: #f5f5f5;
  border-radius: 8rpx;
  font-size: 28rpx;
  line-height: 1.5;
}

.weekdays-selector {
  display: flex;
  gap: 15rpx;
  margin-bottom: 20rpx;
  width: 100%;
}

.weekday-btn {
  width: 70rpx;
  height: 70rpx;
  border: 1px solid #ddd;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24rpx;
  color: #666;

  &.weekday-active {
    background: #07c160;
    color: #fff;
    border-color: #07c160;
  }
}

.quick-select {
  display: flex;
  gap: 20rpx;
}

.quick-btn {
  padding: 10rpx 25rpx;
  background: #f5f5f5;
  border-radius: 20rpx;
  font-size: 24rpx;
  color: #666;
}

.popup-footer {
  display: flex;
  gap: 20rpx;
  padding: 30rpx;
  border-top: 1px solid #eee;

  button {
    flex: 1;
    height: 80rpx;
    line-height: 80rpx;
    border-radius: 40rpx;
    font-size: 28rpx;
    border: none;

    &.btn-cancel {
      background: #f5f5f5;
      color: #666;
    }

    &.btn-clear {
      background: #ff5252;
      color: #fff;
    }

    &.btn-save {
      background: #07c160;
      color: #fff;
    }
  }
}
</style>
