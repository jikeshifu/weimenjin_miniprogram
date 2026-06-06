<template>
    <view class="big-box">
        <view class="background"></view>
        <view class="content">
            <view class="top-box">
                <!-- 基本设置组 -->
                <view class="group-title">基本设置</view>
                <view class="cell-item">
                    <view class="label">设备名称</view>
                    <input
                        placeholder="请输入锁名称"
                        placeholder-class="placeholder"
                        style="color: #21CF3E;"
                        v-model="formData.lock_name"
                        maxlength="20"
                        @blur="autoSubmitBasic"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">是否启用</view>
                    <switch
                        checked
                        color="#21CF3E"
                        :checked="formData.status ? true : false"
                        @change="changeUse"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">申请需手机号</view>
                    <switch
                        color="#21CF3E"
                        :checked="formData.mobile_check ? true : false"
                        @change="changePhone"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">获取授权先登记</view>
                    <switch
                        color="#21CF3E"
                        :checked="formData.applyauth ? true : false"
                        @change="changeApply"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">登记需要审核</view>
                    <switch
                        checked
                        color="#21CF3E"
                        :checked="formData.applyauth_check ? true : false"
                        @change="changeCheck"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">提示语音</view>
                    <switch
                        checked
                        color="#21CF3E"
                        :checked="formData.xcx_sound ? true : false"
                        @change="changeXcxSound"
                    />
                </view>
                <view class="cell-item">
                    <view class="label">成功通知</view>
                    <switch
                        checked
                        color="#21CF3E"
                        :checked="formData.opsucnt ? true : false"
                        @change="changeopsucnt"
                    />
                </view>
                <view class="cell-item" @tap="showPicker('distance')">
                    <view class="label">使用限距(米)</view>
                    <view class="value">{{ formData.location_check }}</view>
                </view>

                <!-- 语音设置组 -->
                <view class="group-title">语音设置</view>
                <view class="cell-item slider-item">
                    <view class="label">音量</view>
                    <slider
                        :value="voiceData.volume"
                        min="0"
                        max="9"
                        step="1"
                        activeColor="#21CF3E"
                        @change="changeVolume"
                        show-value
                    />
                </view>
                <view class="cell-item slider-item">
                    <view class="label">语速</view>
                    <slider
                        :value="voiceData.speed"
                        min="0"
                        max="9"
                        step="1"
                        activeColor="#21CF3E"
                        @change="changeSpeed"
                        show-value
                    />
                </view>
                <view class="cell-item slider-item">
                    <view class="label">声调</view>
                    <slider
                        :value="voiceData.tone"
                        min="0"
                        max="9"
                        step="1"
                        activeColor="#21CF3E"
                        @change="changeTone"
                        show-value
                    />
                </view>
            </view>
        </view>
        <picker
            v-if="showPickerFlag"
            mode="selector"
            :range="currentRange"
            :value="currentValue"
            @change="pickerChange"
            @cancel="hidePicker"
        >
            <view class="picker-overlay">
                <view class="picker-content">
                    <view class="picker-header">
                        <view class="cancel" @tap="hidePicker">取消</view>
                        <view class="title">使用限距(米)</view>
                        <view class="confirm" @tap="pickerConfirm">完成</view>
                    </view>
                </view>
            </view>
        </picker>
    </view>
</template>

<script>
import { configSet_api, config_api, voiceConfigSet_api } from '@/api/index.js'
export default {
    data() {
        return {
            lockauth_id: '',
            formData: {
                lock_name: '',
                status: 1,
                mobile_check: 0,
                applyauth: 0,
                applyauth_check: 1,
                xcx_sound: 1,
                opsucnt: 1,
                location_check: 0,
                advertising_enabled: 0
            },
            voiceData: {
                volume: 3,
                speed: 4,
                tone: 5
            },
            showPickerFlag: false,
            currentPickerType: '',
            currentRange: [],
            currentValue: 0
        }
    },
    onLoad(option) {
        this.lockauth_id = option.lockauth_id
        this.getInfo()
    },
    methods: {
        async autoSubmitBasic() {
            if (!this.formData.lock_name.trim()) {
                this.showToast('请输入锁名称')
                return
            }

            uni.showLoading({
                title: '保存中...',
                mask: true
            })
            try {
                let res = await configSet_api(this.formData)
                if (res.code === 0) {
                    this.showToast('保存成功', 'success')
                } else {
                    this.showToast(res.msg)
                }
            } catch (error) {
                this.showToast('保存失败，请重试')
            } finally {
                uni.hideLoading()
            }
        },
        async autoSubmitVoice() {
            uni.showLoading({
                title: '保存中...',
                mask: true
            })
            try {
                let res = await voiceConfigSet_api({
                    lockauth_id: this.lockauth_id,
                    volume: this.voiceData.volume,
                    speed: this.voiceData.speed,
                    tone: this.voiceData.tone
                })
                if (res.code === 0) {
                    this.showToast('保存成功', 'success')
                } else {
                    this.showToast(res.msg,'error')
                }
            } catch (error) {
                this.showToast('保存失败，请重试')
            } finally {
                uni.hideLoading()
            }
        },
        async getInfo() {
            try {
                let res = await config_api({ lockauth_id: this.lockauth_id })
                if (res.code === 0) {
                    let item = res.data
                    this.formData = {
                        lockauth_id: this.lockauth_id,
                        lock_name: item.lock_name || '',
                        mobile_check: item.mobile_check || 0,
                        applyauth: item.applyauth || 0,
                        xcx_sound: item.xcx_sound || 1,
                        opsucnt: item.opsucnt || 1,
                        applyauth_check: item.applyauth_check || 1,
                        location_check: item.location_check || 0,
                        status: item.status || 1,
                        advertising_enabled: item.qrshowminiad || 0
                    }
                    this.voiceData = {
                        volume: item.volume !== undefined ? item.volume : 3,
                        speed: item.speed !== undefined ? item.speed : 4,
                        tone: item.tone !== undefined ? item.tone : 5
                    }
                } else {
                    this.showToast(res.msg)
                }
            } catch (error) {
                this.showToast('获取配置失败')
            }
        },
        showPicker(type) {
            this.showPickerFlag = true
            this.currentPickerType = type
            if (type === 'distance') {
                this.currentRange = Array.from({ length: 101 }, (_, i) => i)
                this.currentValue = this.formData.location_check
            }
        },
        hidePicker() {
            this.showPickerFlag = false
        },
        pickerChange(e) {
            this.currentValue = e.detail.value
        },
        pickerConfirm() {
            const value = this.currentRange[this.currentValue]
            if (this.currentPickerType === 'distance') {
                this.formData.location_check = value
            }
            this.hidePicker()
            this.autoSubmitBasic()
        },
        changePhone(e) {
            this.formData.mobile_check = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
        },
        changeApply(e) {
            this.formData.applyauth = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
        },
        changeCheck(e) {
            this.formData.applyauth_check = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
        },
        changeXcxSound(e) {
            this.formData.xcx_sound = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
        },
        changeopsucnt(e) {
            this.formData.opsucnt = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
        },
        changeUse(e) {
            this.formData.status = e.detail.value ? 1 : 0
            this.autoSubmitBasic()
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
        showToast(msg, icon = 'none') {
            uni.showToast({
                title: msg,
                icon: icon,
                mask: true,
                duration: 1500
            })
        }
    }
}
</script>

<style scoped lang="scss">
.background {
    width: 100%;
    height: 352rpx;
    background: #f2f2f2;
    opacity: 0.5;
    position: absolute;
    top: 0;
    left: 0;
}
.big-box {
    height: 100vh;
    background: #f5f5f5;
}
.content {
    position: relative;
    z-index: 10;
    height: 100%;
    display: flex;
    flex-direction: column;
    .top-box {
        flex: 1;
        overflow-y: auto;
        padding: 20rpx 0;
        .group-title {
            padding: 20rpx 30rpx;
            font-size: 28rpx;
            color: #666666;
            background: #f5f5f5;
        }
        .cell-item {
            height: 100rpx;
            background: #ffffff;
            border-bottom: 1rpx solid #e5e5e5;
            margin: 0 30rpx;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30rpx;
            &:first-child {
                border-radius: 20rpx 20rpx 0 0;
            }
            &:last-child {
                border-bottom: none;
                border-radius: 0 0 20rpx 20rpx;
            }
            .label {
                font-size: 32rpx;
                color: #000000;
            }
            .value {
                font-size: 32rpx;
                color: #666666;
            }
            input {
                height: 100%;
                text-align: right;
                font-size: 32rpx;
                color: #21CF3E;
                width: 50%;
            }
        }
        .slider-item {
            padding: 20rpx 30rpx;
            height: 120rpx;
            slider {
                width: 60%;
            }
            ::v-deep .uni-slider-value {
                font-size: 28rpx;
                color: #666666;
                margin-left: 20rpx;
            }
        }
    }
}
.picker-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    justify-content: center;
    align-items: flex-end;
}
.picker-content {
    width: 100%;
    background: #ffffff;
    border-radius: 20rpx 20rpx 0 0;
    padding-bottom: env(safe-area-inset-bottom);
}
.picker-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20rpx 30rpx;
    border-bottom: 1rpx solid #e5e5e5;
    .cancel, .confirm {
        font-size: 32rpx;
        color: #007aff;
    }
    .title {
        font-size: 34rpx;
        color: #000000;
        font-weight: 500;
    }
}
::v-deep .uni-picker-container {
    background: transparent !important;
}
::v-deep .placeholder {
    color: #999999;
    font-size: 30rpx;
}
</style>
