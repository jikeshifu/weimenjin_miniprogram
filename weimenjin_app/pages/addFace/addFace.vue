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

        <view class="updata-img" v-if="!isEdit">
          <view class="img" @click="updataImg">
            <image src="../../static/picture.png" class="btn-icon" v-if="!formData.face_images"></image>
            <image :src="getImgPath(formData.face_images)" class="btn-icon" v-else></image>
          </view>
        </view>
        <view class="cell-item">
          <view class="label">请勿美颜</view>
        </view>
      </view>
      <view class="bottom-btn" @click="onSubmit">立即提交</view>
    </view>
    <uv-datetime-picker ref="datetimePicker" v-model="dateTimeValue" mode="datetime" @confirm="confirm"></uv-datetime-picker>
    <!-- 固定初始尺寸，足够大以容纳大多数图片 -->
    <canvas canvas-id="resizeCanvas" style="position: fixed; top: -1000px; left: -1000px; width: 2000px; height: 2000px;"></canvas>
  </view>
</template>

<script>
import { images_api, addFace_api, editFace_api } from '@/api/index.js';
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
      isEdit: false
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
        face_id: item.face_id,
        face_name: item.face_name,
        end_time: item.end_time
      };
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
    }
  },
  methods: {
    openTime() {
      this.$refs.datetimePicker.open();
    },
    confirm(e) {
      this.formData.end_time = Math.trunc(e.value / 1000);
    },
    async onSubmit() {
      for (let key in this.formData) {
        if (!this.formData[key] && this.verifyData[key]) {
          this.showToast(this.verifyData[key]);
          return false;
        }
      }
      uni.showLoading({ title: '提交中...', mask: true });
      let res = this.isEdit ? await editFace_api(this.formData) : await addFace_api(this.formData);
      uni.hideLoading();
      if (res.code === 0) {
        this.showToast('操作成功!');
        setTimeout(() => uni.navigateBack({ delta: 1 }), 1000);
      } else {
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