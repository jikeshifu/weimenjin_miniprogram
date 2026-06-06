<template>
    <view>
        <!-- 固定在顶部的导航栏 -->
        <view class="custom-nav-bar">
            <view class="left-icon" @click="onTopPlusClick">
                <i class="iconfont icon-jiahao1"></i>
            </view>
            <view class="title">{{ title }}</view>
            <view class="right-icon" @click="onScanClick">
                <i class="iconfont icon-saoyisao1"></i>
            </view>
        </view>

        <!-- 页面内容，添加顶部间距避免被遮住 -->
        <view class="page-content">
            <!-- 页面内容区域 -->
        </view>
    </view>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            default: '页面标题'
        }
    },
    methods: {
        onTopPlusClick() {
            this.$emit('plus-click');
        },
        onScanClick() {
            // 直接调用 uni.scanCode 打开扫一扫
            uni.scanCode({
                onlyFromCamera: true, // 只允许从相机扫码
                success: (res) => {
                    console.log("扫描结果: ", res);

                    // 手动解析URL，提取 user_id 和 lock_id 参数
                    const url = res.result;
                    if (url.includes("minicabinet?")) {
                        const params = {};
                        const queryString = url.split('?')[1];
                        if (queryString) {
                            const queryArray = queryString.split('&');
                            queryArray.forEach(item => {
                                const [key, value] = item.split('=');
                                if (key && value) {
                                    params[key] = decodeURIComponent(value);
                                }
                            });
                        }

                        const lockId = params['lock_id'];
                        if (lockId) {
                            const queryParts = [
                                `lock_id=${encodeURIComponent(lockId)}`,
                                params['device_sn'] ? `device_sn=${encodeURIComponent(params['device_sn'])}` : '',
                                params['global_lock'] ? `global_lock=${encodeURIComponent(params['global_lock'])}` : ''
                            ].filter(Boolean);
                            uni.navigateTo({
                                url: `/pages/W75Scan/W75Scan?${queryParts.join('&')}`
                            });
                        } else {
                            uni.showToast({
                                title: "无法获取柜门参数",
                                icon: "none",
                                duration: 2000
                            });
                        }
                    } else if (url.includes("minilock?")) {
                        const params = {};
                        const queryString = url.split('?')[1];
                        if (queryString) {
                            const queryArray = queryString.split('&');
                            queryArray.forEach(item => {
                                const [key, value] = item.split('=');
                                if (key && value) {
                                    params[key] = decodeURIComponent(value);
                                }
                            });

                            // 获取 user_id 和 lock_id 参数
                            const userId = params['user_id'];
                            const lockId = params['lock_id'];
                            const globalLock = params['global_lock'];

                            if (userId && lockId) {
                                const extra = globalLock ? `&global_lock=${globalLock}` : '';
                                uni.navigateTo({
                                    url: `/pages/open/open?user_id=${userId}&lock_id=${lockId}${extra}`
                                });
                            } else {
                                console.error("扫描的URL中缺少必要的参数");
                                uni.showToast({
                                    title: "无法获取必要的参数",
                                    icon: "none",
                                    duration: 2000
                                });
                            }
                        }
                    } else {
                        console.error("扫描结果不包含预期的URL结构");
                        uni.showToast({
                            title: "无效的二维码",
                            icon: "none",
                            duration: 2000
                        });
                    }
                },
                fail: (err) => {
                    console.error("扫描失败: ", err);
                    uni.showToast({
                        title: "扫码取消",
                        icon: "none",
                        duration: 2000
                    });
                }
            });
        }
    }
}
</script>

<style>
.custom-nav-bar {
    position: fixed; /* 固定在页面顶部 */
    top: 0; /* 距离页面顶部 0 */
    left: 0; /* 距离页面左侧 0 */
    width: 100%; /* 让导航栏占满宽度 */
    height: 148rpx; /* 高度调到158rpx，适应动态岛 */
    background-color: #21CF3E;
    display: flex;
    align-items: flex-end; /* 让内部内容垂直靠下对齐 */
    justify-content: space-between; /* 左中右均匀分布 */
    padding: 0 30rpx 10rpx; /* 上部没有内边距，左右为30rpx，底部20rpx */
    z-index: 1000; /* 确保导航栏在最上层 */
    box-sizing: border-box; /* 包括 padding 在内，确保元素不溢出 */
}

.left-icon {
    width: 50rpx;
    height: 50rpx;
    display: flex;
    color: #ffffff;
    align-items: center;
    justify-content: center;
}

.right-icon {
    width: 60rpx;
    height: 60rpx;
    display: flex;
    color: #ffffff;
    align-items: center;
    justify-content: center;
}

.title {
    color: #ffffff;
    font-size: 32rpx;
    text-align: center;
    flex: 1; /* 让标题占据剩余的宽度 */
    margin-left: 50rpx; /* 确保标题不被左侧图标覆盖 */
    margin-right: 50rpx; /* 确保标题不被右侧图标覆盖 */
}

/* 页面内容区域，添加顶部间距，避免内容被导航栏遮住 */
.page-content {
    margin-top: 108rpx; /* 给页面内容添加与导航栏等高的上间距，防止被导航栏遮盖 */
    padding: 10rpx; /* 可选：为内容添加一些内边距 */
}
</style>
