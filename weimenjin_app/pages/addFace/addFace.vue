<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view class="top-box">
        <view class="cell-item">
          <view class="label">持有人：</view>
          <input placeholder="请输入持有人名称" placeholder-class="placeholder" v-model="formData.face_name" />
        </view>

        <view class="cell-item" @click="openTime">
          <view class="label">过期时间：</view>
          <view class="text">{{ formData.end_time ? formatDate(formData.end_time) : '请选择过期时间' }}</view>
        </view>

        <view class="updata-img">
          <view class="img" @click="updataImg">
            <image src="../../static/picture.png" class="btn-icon" v-if="!formData.face_images"></image>
            <image :src="getImgPath(formData.face_images)" class="btn-icon" v-else></image>
          </view>
        </view>
        <view class="cell-item">
          <view class="label">请勿美颜</view>
        </view>

        <!-- 同步到其他设备 -->
        <view class="sync-section" v-if="faceDevices.length > 0">
          <view class="sync-header" @click="toggleSyncPanel">
            <view class="sync-title">{{ isEdit ? '同步到其他设备' : '同时添加到其他设备' }}</view>
            <view class="sync-arrow" :class="{ 'arrow-up': showSyncPanel }">▼</view>
          </view>
          <view class="sync-panel" v-if="showSyncPanel">
            <view class="sync-tip">选择需要同步人脸的设备：</view>
            <view class="device-list">
              <view
                class="device-item"
                v-for="device in faceDevices"
                :key="device.lock_id"
                @click="toggleDevice(device.lock_id)"
              >
                <view class="device-checkbox" :class="{ checked: selectedDevices.includes(device.lock_id) }">
                  <text v-if="selectedDevices.includes(device.lock_id)">✓</text>
                </view>
                <view class="device-info">
                  <view class="device-name">{{ device.lock_name }}</view>
                  <view class="device-sn">{{ device.lock_sn }}</view>
                </view>
              </view>
            </view>
            <view class="sync-actions" v-if="selectedDevices.length > 0">
              <view class="sync-count">已选择 {{ selectedDevices.length }} 台设备</view>
            </view>
          </view>
        </view>
      </view>
      <view class="bottom-btn" @click="onSubmit">立即提交</view>
    </view>
    <uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm"></uv-datetime-picker>
    <!-- 固定初始尺寸，足够大以容纳大多数图片 -->
    <canvas canvas-id="resizeCanvas" style="position: fixed; top: -1000px; left: -1000px; width: 2000px; height: 2000px;"></canvas>

    <!-- 自定义结果弹窗 -->
    <view class="result-modal" v-if="showResultModal" @click.self="closeResultModal">
      <view class="result-modal-content">
        <view class="result-header" :class="resultData.headerClass">
          <view class="result-icon">{{ resultData.icon }}</view>
          <view class="result-title">{{ resultData.title }}</view>
        </view>
        <view class="result-body">
          <!-- 当前设备 -->
          <view class="result-section current-device">
            <view class="section-label">当前设备</view>
            <view class="device-result success">
              <view class="device-result-icon">✓</view>
              <view class="device-result-info">
                <view class="device-result-name">{{ resultData.currentDevice }}</view>
                <view class="device-result-status">{{ isEdit ? '编辑' : '添加' }}成功</view>
              </view>
            </view>
          </view>
          <!-- 同步设备 -->
          <view class="result-section sync-devices" v-if="resultData.syncResults && resultData.syncResults.length > 0">
            <view class="section-label">同步到其他设备</view>
            <view
              class="device-result"
              :class="item.status"
              v-for="(item, index) in resultData.syncResults"
              :key="index"
            >
              <view class="device-result-icon">{{ item.status === 'success' ? '✓' : (item.status === 'offline' ? '⚠' : '✗') }}</view>
              <view class="device-result-info">
                <view class="device-result-name">{{ item.lock_name }}</view>
                <view class="device-result-status">{{ item.status === 'success' ? '同步成功' : (item.status === 'offline' ? '设备离线' : item.error) }}</view>
              </view>
            </view>
          </view>
        </view>
        <view class="result-footer">
          <view class="result-btn" @click="closeResultModal">确定</view>
        </view>
      </view>
    </view>
  </view>
</template>

<script>
import { images_api, addFace_api, editFace_api, getFaceDevices_api, syncFaceToDevices_api } from '@/api/index.js';
import { imgPath } from "@/libs/filters.js";
import UvDatetimePicker from '@/components/uv-datetime-picker/components/uv-datetime-picker/uv-datetime-picker.vue';

export default {
  components: {
    UvDatetimePicker
  },
  data() {
    return {
      dateTimeValue: Number(new Date()),
      formData: {
        lock_id: '',
        face_name: '',
        end_time: '',
        face_images: '',
      },
      verifyData: {
        lock_id: '缺少设备ID',
        face_name: '请输入持有人名称',
        end_time: '请选择过期时间',
        face_images: '请上传人脸图片',
      },
      isEdit: false,
      currentDevice: null, // 当前设备信息
      faceDevices: [], // 可同步的人脸设备列表
      selectedDevices: [], // 已选择的设备
      showSyncPanel: false, // 是否展开同步面板
      showResultModal: false, // 是否显示结果弹窗
      resultData: {
        title: '',
        icon: '',
        headerClass: '',
        currentDevice: '',
        syncResults: []
      }
    };
  },
  filters: {
    imgPath
  },
  onShareAppMessage() {},
  onShareTimeline() {},
  onLoad(option) {
    this.formData.lock_id = option.lock_id;
    if (option.item) {
      this.isEdit = true;
      let item = JSON.parse(decodeURIComponent(option.item));
      this.formData = {
        lock_id: option.lock_id,
        face_id: item.face_id,
        face_name: item.face_name,
        end_time: item.end_time,
        face_images: item.face_images || ''
      };
      // 编辑模式下获取可同步的设备列表
      this.loadFaceDevices();
    } else {
      let now = new Date();
      let year = now.getFullYear() + 1;
      let month = (now.getMonth() + 1).toString().padStart(2, "0");
      let day = now.getDate().toString().padStart(2, "0");
      let hours = now.getHours().toString().padStart(2, "0");
      let minutes = now.getMinutes().toString().padStart(2, "0");
      let seconds = now.getSeconds().toString().padStart(2, "0");
      let endTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
      this.formData.end_time = Date.parse(endTime) / 1000;
      // 首次添加时也加载可同步的设备列表
      this.loadFaceDevices();
    }
  },
  methods: {
    async loadFaceDevices() {
      try {
        const res = await getFaceDevices_api({});
        if (res.code === 0 && res.data) {
          // 找到当前设备信息
          this.currentDevice = res.data.find(d => d.lock_id == this.formData.lock_id);
          // 过滤掉当前设备
          this.faceDevices = res.data.filter(d => d.lock_id != this.formData.lock_id);
        }
      } catch (e) {
        console.error('获取设备列表失败', e);
      }
    },
    toggleSyncPanel() {
      this.showSyncPanel = !this.showSyncPanel;
    },
    toggleDevice(lockId) {
      const index = this.selectedDevices.indexOf(lockId);
      if (index > -1) {
        this.selectedDevices.splice(index, 1);
      } else {
        this.selectedDevices.push(lockId);
      }
    },
    closeResultModal() {
      this.showResultModal = false;
      uni.redirectTo({ url: '/pages/faceList/faceList?lock_id=' + this.formData.lock_id });
    },
    openTime() {
      this.$refs.datetimePicker.open();
    },
    confirm(e) {
      this.formData.end_time = Math.trunc(e.value / 1000);
    },
    async onSubmit() {
      const keys = Object.keys(this.formData);
      for (let i = 0; i < keys.length; i++) {
        const key = keys[i];
        // 编辑模式下跳过face_images验证（允许只修改时间不重新上传图片）
        if (this.isEdit && key === 'face_images') {
          continue;
        }
        if (!this.formData[key] && this.verifyData[key]) {
          this.showToast(this.verifyData[key]);
          return false;
        }
      }
      uni.showLoading({ title: '提交中...', mask: true });
      let res = this.isEdit ? await editFace_api(this.formData) : await addFace_api(this.formData);

      if (res.code === 0) {
        // 如果选择了同步到其他设备
        if (this.selectedDevices.length > 0) {
          uni.showLoading({ title: '同步到其他设备...', mask: true });
          try {
            // 首次添加时使用返回的face_id（直接在根级别），编辑时使用原有的
            const faceId = this.isEdit ? this.formData.face_id : (res.face_id || res.data?.face_id);

            console.log('同步参数:', {
              source_lock_id: this.formData.lock_id,
              face_id: faceId,
              target_lock_ids: this.selectedDevices,
              face_name: this.formData.face_name,
              end_time: this.formData.end_time
            });

            if (!faceId) {
              uni.hideLoading();
              uni.showModal({
                title: '同步失败',
                content: '未获取到人脸ID，请稍后在人脸列表中重试同步',
                showCancel: false,
                success: () => uni.redirectTo({ url: '/pages/faceList/faceList?lock_id=' + this.formData.lock_id })
              });
              return;
            }

            const syncRes = await syncFaceToDevices_api({
              source_lock_id: this.formData.lock_id,
              face_id: faceId,
              target_lock_ids: this.selectedDevices,
              face_name: this.formData.face_name,
              end_time: this.formData.end_time,
              face_images: this.formData.face_images
            });
            uni.hideLoading();

            if (syncRes.code === 0) {
              // 注意：CodeOk 返回的数据直接在根级别，不在 data 字段下
              const successCount = syncRes.success_count || 0;
              const failCount = syncRes.fail_count || 0;
              const offlineCount = syncRes.offline_count || 0;
              const results = syncRes.results || [];
              const syncDeviceCount = this.selectedDevices.length;

              // 计算整体成功率（当前设备算1台成功）
              const totalDevices = 1 + syncDeviceCount;
              const totalSuccess = 1 + successCount;
              const allSuccess = totalSuccess === totalDevices;
              const allFailed = successCount === 0 && syncDeviceCount > 0;

              // 设置结果弹窗数据
              this.resultData = {
                title: allSuccess ? '全部成功' : (allFailed ? '同步失败' : '部分成功'),
                icon: allSuccess ? '✓' : (allFailed ? '✗' : '!'),
                headerClass: allSuccess ? 'success' : (allFailed ? 'fail' : 'partial'),
                currentDevice: this.currentDevice?.lock_name || '当前设备',
                syncResults: results
              };
              this.showResultModal = true;
              return;
            } else {
              // 接口调用失败，也使用自定义弹窗显示
              this.resultData = {
                title: '同步失败',
                icon: '✗',
                headerClass: 'fail',
                currentDevice: this.currentDevice?.lock_name || '当前设备',
                syncResults: [{
                  lock_name: '同步接口',
                  status: 'fail',
                  error: syncRes.msg || '接口调用失败'
                }]
              };
              this.showResultModal = true;
              return;
            }
          } catch (e) {
            uni.hideLoading();
            console.error('同步出错', e);
            this.showToast((this.isEdit ? '编辑' : '添加') + '成功，但同步出错');
          }
        } else {
          // 没有选择同步设备，直接成功
          uni.hideLoading();
          this.showToast('操作成功!');
          setTimeout(() => uni.redirectTo({ url: '/pages/faceList/faceList?lock_id=' + this.formData.lock_id }), 1500);
        }
      } else {
        uni.hideLoading();
        this.showToast(res.msg);
      }
    },
    updataImg() {
      uni.chooseImage({
        success: async chooseImageRes => {
          uni.showLoading({ title: '处理图片中...', mask: true });
          const tempFilePath = chooseImageRes.tempFilePaths[0];

          // 获取图片信息
          const getImageInfo = () =>
            new Promise((resolve, reject) =>
              uni.getImageInfo({ src: tempFilePath, success: resolve, fail: reject })
            );

          // 使用 canvas 调整宽高
          const resizeImage = (src, scaleFactor = 0.5) =>
            new Promise((resolve, reject) => {
              uni.getImageInfo({
                src: src,
                success: imgInfo => {
                  const canvasId = 'resizeCanvas';
                  const ctx = uni.createCanvasContext(canvasId, this);
                  const { width, height } = imgInfo;

                  // 计算目标尺寸，保持比例
                  const targetWidth = Math.floor(width * scaleFactor);
                  const targetHeight = Math.floor(height * scaleFactor);

                  // 清空画布
                  ctx.clearRect(0, 0, 2000, 2000); // 确保清空整个画布

                  // 绘制图片，确保完整显示
                  ctx.drawImage(src, 0, 0, targetWidth, targetHeight);

                  ctx.draw(false, () =>
                    uni.canvasToTempFilePath({
                      canvasId: canvasId,
                      x: 0,
                      y: 0,
                      width: targetWidth,
                      height: targetHeight,
                      destWidth: targetWidth,
                      destHeight: targetHeight,
                      quality: 1,
                      success: res => {
                        // 调试：预览调整后的图片
                        // uni.previewImage({ urls: [res.tempFilePath] });
                        resolve(res.tempFilePath);
                      },
                      fail: err => reject(err)
                    }, this)
                  );
                },
                fail: reject
              });
            });

          // 压缩图片到指定大小
          const compressImageToSize = (filePath, quality = 80, maxSize = 100 * 1024) =>
            new Promise((resolve, reject) => {
              uni.compressImage({
                src: filePath,
                quality: quality,
                success: res => {
                  uni.getFileInfo({
                    filePath: res.tempFilePath,
                    success: fileInfo => {
                      if (fileInfo.size <= maxSize || quality <= 10) {
                        // 调试：预览压缩后的图片
                        // uni.previewImage({ urls: [res.tempFilePath] });
                        resolve(res.tempFilePath);
                      } else {
                        compressImageToSize(filePath, quality - 10, maxSize)
                          .then(resolve)
                          .catch(reject);
                      }
                    },
                    fail: () => reject('获取文件信息失败')
                  });
                },
                fail: () => reject('图片压缩失败')
              });
            });

          try {
            const imgInfo = await getImageInfo();
            const resizedFilePath = await resizeImage(tempFilePath, 0.5); // 缩放到50%，可调整
            const compressedFilePath = await compressImageToSize(resizedFilePath, 80);

            uni.showLoading({ title: '上传中...', mask: true });
            let res = await images_api({ image: compressedFilePath });

            if (res.code === 0) {
              this.formData.face_images = res.data;
              uni.hideLoading();
              this.showToast('图片上传成功');
            } else {
              uni.hideLoading();
              this.showToast(res.msg);
            }
          } catch (error) {
            uni.hideLoading();
            this.showToast(error.errMsg || '图片处理失败');
          }
        },
        fail: () => {
          uni.hideLoading();
          this.showToast('选择图片失败');
        }
      });
    },
    getImgPath(url) {
      return imgPath(url);
    },
    formatDate(date, fmt = 'yyyy-MM-dd hh:mm:ss') {
      var crtTime = typeof date === 'number' && (date + '').length !== 13 ? new Date(date * 1000) : new Date(date);
      var o = {
        'M+': crtTime.getMonth() + 1,
        'd+': crtTime.getDate(),
        'h+': crtTime.getHours(),
        'm+': crtTime.getMinutes(),
        's+': crtTime.getSeconds(),
        'q+': Math.floor((crtTime.getMonth() + 3) / 3),
        'S': crtTime.getMilliseconds(),
      };
      if (/(y+)/.test(fmt)) {
        fmt = fmt.replace(RegExp.$1, (crtTime.getFullYear() + '').substr(4 - RegExp.$1.length));
      }
      for (var k in o) {
        if (new RegExp('(' + k + ')').test(fmt)) {
          fmt = fmt.replace(RegExp.$1, RegExp.$1.length === 1 ? o[k] : ('00' + o[k]).substr(('' + o[k]).length));
        }
      }
      return fmt;
    },
    showToast(msg) {
      uni.showToast({ title: msg, icon: 'none', mask: true });
    }
  }
};
</script>

<style scoped lang="scss">
@import './addFace.scss';
</style>
