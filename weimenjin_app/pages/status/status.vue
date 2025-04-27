<template>
    <view class="big-box">
        <view class="background"></view>
        <view class="content">
            <view class="top-box">
                <view class="cell-item">
                    <view class="flex-box">
                        <view class="label">序列号:</view>
                        <input placeholder="输入设备序列号" placeholder-class="placeholder" v-model="devicesn" />
                    </view>
                    <image src="../../static/saomiao.png" @click="scanCode"></image>
                </view>
                <view class="btn-box">
                    <view class="bottom-btn" @click="onSubmit">查询</view>
                    <view class="bottom-btn" @click="toggleHistoryModal">查过的序列号</view>
                </view>
            </view>

            <view v-if="data && data.lock_sn" class="explain">
                <view class="text">
                    <view class="status-label">在线状态:</view>
                    <view :class="data.online == '1' ? 'online' : 'offline'">
                        <text>{{ data.online == '1' ? '在线' : '离线' }}</text>
                    </view>
                </view>
                <view class="text" v-if="data.rssi !== undefined">信号情况:{{ data.rssi }}</view>
                <view class="text" v-if="data.iccid !== undefined">网络标识:{{ data.iccid }}</view>
                <view class="text" v-if="data.version !== undefined">固件版本:{{ data.version }}</view>
                <view class="text" v-if="data.on_line_time !== undefined">最近上线:{{ formatTime(data.on_line_time) }}</view>
                <view class="text" v-if="data.off_line_time !== undefined">上次离线:{{ formatTime(data.off_line_time) }}</view>
                <view class="text" v-if="data.reason !== undefined">离线原因:{{ data.reason }}</view>
            </view>
        </view>

        <!-- 自定义弹窗层 -->
        <view v-if="showHistory" class="history-modal">
            <view class="history-content">
                <!-- 按钮放在列表外面，固定位置 -->
                <view class="history-controls">
                    <view class="clear-btn" @click="clearHistory">清空</view>
                    <view class="close-btn" @click="toggleHistoryModal">关闭</view>
                </view>
                <!-- 只有列表内容是滚动的 -->
                <view class="history-list">
                    <view v-for="(item, index) in deviceList" :key="index" @click="selectDevice(item.sn)">
                        {{ item.sn }} - {{ item.time }}
                    </view>
                </view>
            </view>
        </view>
    </view>
</template>




<script>
import { deviceStatus_api } from '../../api/index.js'

export default {
    data() {
        return {
            devicesn: '',
            deviceList: [],
            showHistory: false,
            data: {
                lock_sn: "",
                online: "",
                rssi: "",
                version: "",
                iccid: "",
                on_line_time: "",
                off_line_time: "",
                reason: ""
            }
        }
    },
	// 小程序显示分享
	onShareAppMessage() {},
	onShareTimeline() {},
    onLoad() {
        this.deviceList = uni.getStorageSync('deviceList') || [];
    },
    methods: {
        scanCode() {
            uni.scanCode({
                success: (res) => {
                    this.devicesn = res.result;
                }
            });
        },
        async onSubmit() {
            if (!this.devicesn) {
                this.showToast('请输入序列号');
                return;
            }
            const data = {
                deviceSn: this.devicesn,
            };
            uni.showLoading({
                title: '加载中...',
                mask: true
            });
            const res = await deviceStatus_api(data);
            if (res.code === 0) {
                uni.hideLoading();
                this.data = res.lockinfo;
                const timestamp = new Date();
                const datetime = `${timestamp.getFullYear()}-${timestamp.getMonth()+1}-${timestamp.getDate()} ${timestamp.getHours()}:${timestamp.getMinutes()}:${timestamp.getSeconds()}`;
                // 查找是否已存在该序列号
                const index = this.deviceList.findIndex(item => item.sn === this.devicesn);
                if (index > -1) {
                    // 如果存在，先删除
                    this.deviceList.splice(index, 1);
                }
                // 无论新旧，都添加到数组开头
                this.deviceList.unshift({
                    sn: this.devicesn,
                    time: datetime
                });
                uni.setStorageSync('deviceList', this.deviceList);
            } else {
                this.data = {
                    lock_sn: "",
                    online: 0,
                };
                uni.hideLoading();
                this.showToast(res.msg);
            }
        },
        toggleHistoryModal() {
            this.showHistory = !this.showHistory;
        },
        selectDevice(devicesn) {
                // 生成新的时间戳
                const timestamp = new Date();
                const datetime = `${timestamp.getFullYear()}-${timestamp.getMonth()+1}-${timestamp.getDate()} ${timestamp.getHours()}:${timestamp.getMinutes()}:${timestamp.getSeconds()}`;
                // 找到选择的设备并更新时间
                const index = this.deviceList.findIndex(item => item.sn === devicesn);
                if (index > -1) {
                    // 删除旧记录
                    this.deviceList.splice(index, 1);
                }
                // 将更新后的记录加入到数组开头
                this.deviceList.unshift({
                    sn: devicesn,
                    time: datetime
                });
                // 保存到本地存储
                uni.setStorageSync('deviceList', this.deviceList);
                // 设置设备序列号
                this.devicesn = devicesn;
                // 进行查询
                this.onSubmit();
                // 关闭历史记录弹窗
                this.showHistory = false;
            },
		clearHistory() {
		        this.deviceList = [];
		        uni.setStorageSync('deviceList', []);  // 清空本地存储的历史记录
		        this.showHistory = false;
		    },
        showToast(msg) {
            uni.showToast({
                title: msg,
                icon: 'none',
                mask: true
            });
        },
        formatTime(timestamp) {
            const date = new Date(timestamp * 1000);
            const year = date.getFullYear();
            const month = date.getMonth() + 1;
            const  day = date.getDate();
            const hour = date.getHours();
            const  minute = date.getMinutes();
            const  second = date.getSeconds();
            return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
        }
    }
}
</script>






<style scoped lang="scss">
    @import './status.scss';
</style>
