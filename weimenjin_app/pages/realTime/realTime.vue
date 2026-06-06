<template>
  <view class="content">
    <view class="background"></view>
    <view class="big-box">
      <view class="list-box">
        <view class="grid-container">
          <view class="grid-item" v-for="(item, index) in infoList" :key="index">
            <view class="flex-box">
              <i :class="['iconfont', item.icon]" :style="{ color: item.color, fontSize: item.size + 'px' }"></i>
              <view class="text-wrapper">
                <view class="label">{{ item.label }}</view>
                <view class="value" :style="{ color: item.signalColor || '#333' }">
                  {{ item.data === '无数据' && item.label === '剩余电量' ? '无限制' : item.data }}
                </view>
              </view>
            </view>
          </view>
        </view>
      </view>
    </view>

    <!-- Canvas 画布，支持滑动手势 -->
    <view class="chart-container" @touchstart="touchStart" @touchend="touchEnd">
      <canvas canvas-id="dailyUsageChart" :style="{ width: chartWidth + 'px', height: chartHeight + 'px' }"></canvas>
    </view>

    <!-- 注释文本 -->
    <view class="footer-text">注: 此处数据有1分钟左右延迟</view>
  </view>
</template>

<script>
import { realTime_api, getLastUsage_api } from "@/api/index.js";

export default {
  data() {
    return {
      lock_id: "",
      info: {},
      currentPage: 0, // 当前显示的页，0表示最近7天，-1表示14天前的7天
      touchStartX: 0, // 记录滑动开始的X坐标
      dailyUsageData: [], // 动态用电数据
      categories: [], // 动态日期
      chartWidth: 0, // 动态设置图表宽度
      chartHeight: 500, // 固定图表高度
      barWidth: 30, // 柱状图默认宽度
      spacing: 20, // 柱状图之间的间距
      infoList: [
        { label: "总用量（kw*h）", data: "", icon: "icon-a-iconyongdianliang", size: 40, color: "green" },
        { label: "当前电压（V）", data: "", icon: "icon-dianya1", size: 40, color: "blue" },
        { label: "当前电流（A）", data: "", icon: "icon-dianya", size: 40, color: "red" },
        { label: "通断状态", data: "", icon: "icon-tongduandianzhuangtai", size: 40, color: "purple" },
        { label: "当前功率（W）", data: "", icon: "icon-yougonggongshuai1", size: 40, color: "orange" },
        { label: "网络信号", data: "", icon: "icon-xinhao", size: 40, color: "teal", signalColor: "" },
        { label: "剩余电量", data: "", icon: "icon-jiadianshengyudianliang", size: 40, color: "black" },
        { label: "固件版本", data: "", icon: "icon-icon-gujianbanben", size: 40, color: "gray" },
      ],
      refreshInterval: null, // 用于存储定时器ID
    };
  },
  onLoad(option) {
    this.lock_id = option.lock_id;
    this.getdata();
    this.getChartData(); // 加载初始图表数据
    this.calculateChartSize(); // 计算图表尺寸
  },
  mounted() {
    this.startAutoRefresh();
  },
  methods: {
    // 动态计算图表尺寸
    calculateChartSize() {
      const systemInfo = uni.getSystemInfoSync();
      this.chartWidth = systemInfo.windowWidth; // 获取设备的宽度
      this.barWidth = this.chartWidth / 10; // 动态计算柱子宽度，根据设备屏幕调整
      this.spacing = this.barWidth / 3; // 动态计算间距
    },

    // 获取设备信息
    async getdata() {
      try {
        let res = await realTime_api({ lock_id: this.lock_id });
        if (res.code == 0 && res.data) {
          this.info = res.data;
          this.updateInfoList();
        } else {
          console.error('API 返回错误: ', res);
        }
      } catch (error) {
        console.error('获取数据失败: ', error);
      }
    },

    // 获取图表数据
    async getChartData() {
      try {
        const res = await getLastUsage_api({ lock_id: this.lock_id, page: this.currentPage });
        if (res.code === 0 && res.data) {
          // 修正 created_at 数据为前一天的日期
          this.dailyUsageData = res.data.map(item => ({
            date: this.formatDate(new Date(item.created_at)), // 将 created_at 显示为前一天
            usage: item.daily_electricity_usage || 0
          }));
          // 将数据反转，这样过去的数据在左边，最近的数据在右边
          this.dailyUsageData.reverse();

          this.categories = this.dailyUsageData.map(item => item.date);
          this.initChart();
        } else {
          console.error("获取图表数据失败: ", res);
        }
      } catch (error) {
        console.error("获取图表数据失败: ", error);
      }
    },

    // 将 created_at 转换为前一天的日期
    formatDate(date) {
      const adjustedDate = new Date(date);
      adjustedDate.setDate(adjustedDate.getDate() - 1); // 减去1天
      return `${adjustedDate.getMonth() + 1}-${adjustedDate.getDate()}`;
    },

    // 更新展示信息
    updateInfoList() {
      this.infoList[0].data = this.info.total_electricity !== undefined ? this.info.total_electricity : "无数据";
      this.infoList[1].data = this.info.voltage !== undefined ? this.info.voltage : "无数据";
      this.infoList[2].data = this.info.electric_current !== undefined ? this.info.electric_current : "无数据";
      if (this.info.switch_state === "接通") {
        this.infoList[3].data = "接通";
        this.infoList[3].color = "green";
      } else {
        this.infoList[3].data = "断开";
        this.infoList[3].color = "red";
      }
      this.infoList[4].data = this.info.power !== undefined ? this.info.power : "无数据";
      this.infoList[5].data =
        this.calculateSignalStrength(this.info.rssi, this.info.version) + "(" + this.info.rssi + ")";
      this.infoList[6].data = this.info.balance && this.info.balance != 0 ? this.info.balance : "无限制";
      this.infoList[7].data = this.info.version !== undefined ? this.info.version : "无数据";
    },

    // 信号强度计算
    calculateSignalStrength(rssi, version) {
      let signalStrength = '';
      let signalColor = '';
      // 添加空值检查，防止 version 未定义时报错
      if (!version) {
        signalStrength = '未知';
        signalColor = '#999999';
        this.infoList[5].signalColor = signalColor;
        return signalStrength;
      }
      if (version.startsWith('71')) {
        if (rssi >= -40) {
          signalStrength = '优';
          signalColor = '#21CF3E';
        } else if (rssi >= -50) {
          signalStrength = '良';
          signalColor = '#7ED321';
        } else if (rssi >= -65) {
          signalStrength = '中';
          signalColor = '#FFA500';
        } else {
          signalStrength = '差';
          signalColor = '#FF0000';
        }
      } else if (version.startsWith('72')) {
        if (rssi >= -60) {
          signalStrength = '优';
          signalColor = '#21CF3E';
        } else if (rssi >= -80) {
          signalStrength = '良';
          signalColor = '#7ED321';
        } else if (rssi >= -90) {
          signalStrength = '中';
          signalColor = '#FFA500';
        } else {
          signalStrength = '差';
          signalColor = '#FF0000';
        }
      }
      this.infoList[5].signalColor = signalColor;
      return signalStrength;
    },

    // 根据用电量计算颜色
    calculateBarColor(value) {
      if (value < 10) {
        return '#21CF3E'; // 绿色
      } else if (value < 20) {
        return '#7ED321'; // 浅绿色
      } else if (value < 30) {
        return '#FFA500'; // 橙色
      } else if (value < 40) {
        return '#FF8C00'; // 深橙色
      } else {
        return '#FF0000'; // 红色
      }
    },

    initChart() {
      const ctx = uni.createCanvasContext('dailyUsageChart');
      const windowWidth = uni.getSystemInfoSync().windowWidth; // 获取设备宽度
      const chartPaddingTop = 40;  // 增加顶部留白，避免数值被截断
      const chartPaddingBottom = 60; // 增加底部留白，确保X轴标签显示完整
      const chartPaddingLeft = 50;  // 左侧留白，确保Y轴显示
      const chartPaddingRight = 30;  // 右侧留白，确保刻度显示

      const data = this.dailyUsageData.map(item => item.usage); // 获取用电数据
      const categories = this.categories;
      const maxVal = Math.max(...data);  // 找到最大值，用来计算刻度
      const barWidth = 20;  // 调整柱子的宽度，使其稍微变窄
      const spacing = 15;   // 调整柱子之间的间隔，使其更紧凑
      const chartHeight = 200; // 图表的高度

      const totalWidth = chartPaddingLeft + chartPaddingRight + (data.length * (barWidth + spacing)); // 计算总宽度

      // 动态调整画布的宽度，确保在小屏幕下不会超出显示范围
      const canvasWidth = Math.max(totalWidth, windowWidth - 20);

      // 绘制X轴
      ctx.beginPath();
      ctx.moveTo(chartPaddingLeft, chartHeight + chartPaddingTop); // 从左侧留白开始绘制X轴
      ctx.lineTo(canvasWidth - chartPaddingRight, chartHeight + chartPaddingTop); // 到右侧留白结束
      ctx.stroke();

      // 绘制Y轴
      ctx.beginPath();
      ctx.moveTo(chartPaddingLeft - 5, chartPaddingTop); // 左侧留白5个像素，确保柱子不紧贴Y轴
      ctx.lineTo(chartPaddingLeft - 5, chartHeight + chartPaddingTop); // Y轴到底部结束
      ctx.stroke();

      // 绘制Y轴刻度
      for (let i = 0; i <= 5; i++) {
        const yLabel = (i * maxVal) / 5;
        const yPos = chartHeight + chartPaddingTop - (i * chartHeight) / 5;
        ctx.fillText(yLabel.toFixed(0), chartPaddingLeft - 20, yPos); // Y轴刻度显示在Y轴左侧
      }

      // 绘制柱状图
      data.forEach((value, index) => {
        const barHeight = (value / maxVal) * chartHeight; // 根据最大值计算柱子的高度
        const x = chartPaddingLeft + index * (barWidth + spacing) + 5; // 确保柱子与Y轴有5个像素的距离
        const y = chartHeight + chartPaddingTop - barHeight;

        ctx.setFillStyle(this.calculateBarColor(value)); // 根据用电量计算颜色
        ctx.fillRect(x, y, barWidth, barHeight);

        // 调整数据标签的位置，确保始终在柱子顶部显示
        ctx.setFillStyle('#000');
        ctx.setFontSize(12);

        // 仅显示数值，不带 "kWh"
        ctx.fillText(value, x + (barWidth / 2) - 10, y - 5); // 标签放在柱子顶部上方
      });

      // 绘制X轴标签（日期）
      categories.forEach((label, index) => {
        const x = chartPaddingLeft + index * (barWidth + spacing) + (barWidth / 2) - 10;
        ctx.setFillStyle('#000');
        ctx.fillText(label, x, chartHeight + chartPaddingTop + chartPaddingBottom / 2); // X轴标签放在底部中间
      });

      // 在顶部绘制图例，显示 kWh 单位
      ctx.setFontSize(14);
      ctx.setFillStyle('#000');
      ctx.fillText('单位: kWh', windowWidth - 100, 20); // 在画布顶部右侧绘制“单位: kWh”

      // 绘制完成
      ctx.draw();
    },


    // 手势滑动开始记录初始位置
    touchStart(event) {
      this.touchStartX = event.touches[0].pageX;
    },

    // 手势滑动结束加载数据
    touchEnd(event) {
      const touchEndX = event.changedTouches[0].pageX;
      const deltaX = touchEndX - this.touchStartX;

      if (deltaX > 50) {
        // 向右滑动手指，加载过去的7天数据
        this.currentPage++; // 向过去切换
        this.getChartData();
      } else if (deltaX < -50) {
        // 向左滑动手指，加载最近的7天数据
        if (this.currentPage > 0) { // 确保 currentPage 不会小于0
          this.currentPage--; // 向最近的日期切换
          this.getChartData();
        }
      }
    },


    startAutoRefresh() {
      this.refreshInterval = setInterval(() => {
        this.getdata();
      }, 10000);
    },
    stopAutoRefresh() {
      clearInterval(this.refreshInterval);
    },
  },
  beforeDestroy() {
    this.stopAutoRefresh();
  },
};
</script>

<style scoped lang="scss">
.background {
  width: 100%;
  height: 352rpx;
  background: rgb(33, 207, 62);
  opacity: 0.2;
  box-shadow: 0px 8rpx 374rpx rgba(58, 137, 254, 0.3);
  filter: blur(120rpx);
  position: absolute;
  top: 0;
  left: 0;
}

.content {
  position: relative;
  z-index: 20;
  padding-bottom: 100rpx;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 20rpx;
  padding: 40rpx 20rpx 20rpx 20rpx;
}

.grid-item {
  background: linear-gradient(180deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0) 100%);
  border-radius: 24rpx;
  padding: 20rpx;
  display: flex;
  align-items: center;
  box-shadow: 16rpx 16rpx 66rpx rgba(117, 160, 232, 0.3);
  transition: all 0.3s ease;
}

.flex-box {
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.text-wrapper {
  display: flex;
  flex-direction: column;
  margin-left: 20rpx;
}

.label {
  font-size: 28rpx;
  font-weight: bold;
  color: #444;
}

.value {
  font-size: 36rpx;
  color: #333;
  font-weight: bold;
}

.chart-container {
  margin-top: 30rpx;
}

.footer-text {
  position: fixed;
  bottom: 40rpx;
  left: 50%;
  transform: translateX(-50%);
  font-size: 28rpx;
  color: #999999;
  text-align: center;
}
</style>
