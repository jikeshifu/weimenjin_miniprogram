<template>
  <view class="container">
    <!-- 头部标题和错误提示 -->
    <view class="header">
      <view class="title-row">
        <view class="title">{{ deviceName }} <text class="device-sn">SN: {{ device_sn }}</text></view>
        <view class="action-btns">
          <view class="action-btn qrcode-btn" @click="showDeviceQRCode">
            <uni-icons type="scan" size="22" color="#333" />
          </view>
          <view class="action-btn" @click="openAllLocks">
            <uni-icons type="locked" size="22" color="#07c160" />
            <text class="btn-text">{{ workMode === 2 ? '补货' : '全开' }}</text>
          </view>
          <view class="action-btn" @click="refreshStatus">
            <uni-icons type="refresh" size="22" color="#666" />
          </view>
          <view class="action-btn" @click="showConfigPopup">
            <uni-icons type="gear" size="22" color="#666" />
          </view>
        </view>
      </view>

      <!-- 工作模式切换 -->
      <view class="mode-switch">
        <view class="mode-item" :class="{ active: workMode === 1 }" @click="switchWorkMode(1)">
          <uni-icons type="loop" size="16" :color="workMode === 1 ? '#07c160' : '#999'" />
          <text>存取模式</text>
        </view>
        <view class="mode-item" :class="{ active: workMode === 2 }" @click="switchWorkMode(2)">
          <uni-icons type="cart" size="16" :color="workMode === 2 ? '#ff9800' : '#999'" />
          <text>售卖模式</text>
        </view>
      </view>

      <view v-if="showMsgText" class="msg-text">
        <uni-icons type="info" size="40" color="red" />
        <view class="msg-content">{{ showMsgText }}</view>
      </view>
    </view>

    <!-- 柜门列表 - 存取模式 -->
    <view class="lock-list" v-if="locks.length > 0 && workMode === 1">
      <view class="lock-item" v-for="lock in locks" :key="lock.global_lock">
        <view class="lock-card" :class="getCardClass(lock)">
          <view class="card-header">
            <view class="lock-name">{{ lock.lock_name }}</view>
            <view class="lock-id">#{{ lock.global_lock }}</view>
          </view>

          <view class="lock-info">
            <view class="info-item">板{{ lock.addr }} / 门{{ lock.lock }}</view>
            <view class="info-item">延时: {{ lock.duration }}秒</view>
            <view class="info-item">状态: {{ lock.status === 1 ? '关闭' : '打开' }}</view>
          </view>

          <view class="control-area">
            <view class="key-button" @click="openLock(lock)">
              <view class="key-circle" :class="{ 'key-rotating': lock.isRotating }">
                <i class="iconfont icon-yuechi"></i>
              </view>
            </view>
          </view>

          <view class="action-buttons">
            <view class="action-item" hover-class="action-item-hover" @click="editLockConfig(lock)">
              <uni-icons type="compose" size="16" color="#07c160" />
              <text>编辑</text>
            </view>
            <view class="action-item" hover-class="action-item-hover" @click="showLockQRCode(lock)">
              <uni-icons type="qrcode" size="20" color="#ff9800" />
              <text>二维码</text>
            </view>
            <view class="action-item" hover-class="action-item-hover" @click="openLock(lock)">
              <uni-icons type="locked" size="16" color="#666" />
              <text>开门</text>
            </view>
          </view>
        </view>
      </view>
    </view>

    <!-- 柜门列表 - 售卖模式 -->
    <view class="lock-list sell-mode" v-if="locks.length > 0 && workMode === 2">
      <view class="lock-item" v-for="lock in locks" :key="lock.global_lock">
        <view class="lock-card sell-card" :class="{ 'has-sku': lock.sku }">
          <view class="card-header">
            <view class="lock-name">{{ lock.lock_name }}</view>
            <view class="lock-id">#{{ lock.global_lock }}</view>
          </view>

          <!-- SKU信息展示 -->
          <view class="sku-info" v-if="lock.sku">
            <image class="sku-image" :src="getImgPath(lock.sku.sku_image)" mode="aspectFill"></image>
            <view class="sku-detail">
              <view class="sku-name">{{ lock.sku.sku_name }}</view>
              <view class="sku-price">
                <text class="price">¥{{ lock.sku.price.toFixed(2) }}</text>
                <text class="original-price" v-if="lock.sku.original_price > lock.sku.price">¥{{ lock.sku.original_price.toFixed(2) }}</text>
              </view>
              <view class="sku-stock">
                <text :class="{ 'out-of-stock': lock.sku.stock <= 0 }">
                  {{ lock.sku.stock > 0 ? '库存: ' + lock.sku.stock : '已售罄' }}
                </text>
                <text class="sold-count">已售: {{ lock.sku.sold_count }}</text>
              </view>
            </view>
          </view>
          <view class="no-sku" v-else>
            <text>暂未设置商品</text>
          </view>

          <view class="action-buttons">
            <view class="action-item" hover-class="action-item-hover" @click="editSkuConfig(lock)">
              <uni-icons type="compose" size="16" color="#07c160" />
              <text>设置商品</text>
            </view>
            <view class="action-item" hover-class="action-item-hover" @click="showLockQRCode(lock)">
              <uni-icons type="qrcode" size="20" color="#ff9800" />
              <text>二维码</text>
            </view>
            <view class="action-item" hover-class="action-item-hover" @click="openLock(lock)">
              <uni-icons type="locked" size="16" color="#666" />
              <text>开门</text>
            </view>
          </view>
        </view>
      </view>
    </view>

    <!-- 编辑弹窗 -->
    <uni-popup ref="editPopup" type="center">
      <view class="popup-content edit-popup">
        <view class="popup-title">柜门配置</view>

        <view class="form-item">
          <view class="form-label">名称</view>
          <input
            class="form-input"
            v-model="editingName"
            placeholder="请输入名称"
            maxlength="20"
          />
        </view>

        <view class="form-item">
          <view class="form-label">开锁时长</view>
          <view class="delay-input-group">
            <input
              class="form-input"
              v-model.number="editingDuration"
              type="number"
              placeholder="开锁时长"
            />
            <text class="unit">秒</text>
          </view>
          <view class="form-tips">范围: 1-60秒</view>
        </view>

        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="cancelEdit">取消</button>
          <button class="popup-btn confirm-btn" @click="confirmEdit">确定</button>
        </view>
      </view>
    </uni-popup>

    <!-- 二维码弹窗（设备总/单柜门） -->
    <uni-popup ref="qrcodePopup" type="center">
      <view class="qrcode-content">
        <view class="qrcode-title" v-if="qrcodeType === 'device'">{{ deviceName }} - {{ workMode === 2 ? '售卖柜' : '存取柜' }}</view>
        <view class="qrcode-title" v-else>{{ currentLock.lock_name }} - 专属二维码</view>
        <view class="qrcode-image">
          <image :src="qrcodeUrl" mode="aspectFit" v-if="qrcodeUrl"></image>
          <view class="loading" v-else>生成中...</view>
        </view>
        <view class="qrcode-tips" v-if="qrcodeType === 'device'">扫描此二维码{{ workMode === 2 ? '查看商品并购买' : '选择柜门存取物品' }}</view>
        <view class="qrcode-tips" v-else>扫描此二维码{{ workMode === 2 ? '直接购买该柜门商品' : '直接存取该柜门' }}</view>
        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="closeQRCode">关闭</button>
          <button class="popup-btn confirm-btn" @click="saveQRCodeToAlbum">保存</button>
        </view>
      </view>
    </uni-popup>

    <!-- 设备参数配置弹窗 -->
    <uni-popup ref="configPopup" type="center">
      <view class="popup-content config-popup">
        <view class="popup-title">设备参数配置</view>

        <view class="form-item">
          <view class="form-label">柜门总数</view>
          <view class="delay-input-group">
            <input
              class="form-input"
              v-model.number="configLockCount"
              type="number"
              placeholder="柜门数量"
              :maxlength="3"
            />
            <text class="unit">个</text>
          </view>
          <view class="form-tips">范围: 1-288，每块板最多36个门</view>
        </view>

        <view class="form-item">
          <view class="form-label">下位机板数</view>
          <view class="delay-input-group">
            <input
              class="form-input"
              v-model.number="configBoardCount"
              type="number"
              placeholder="板子数量"
              :maxlength="1"
            />
            <text class="unit">块</text>
          </view>
          <view class="form-tips">范围: 1-8，根据柜门数量自动计算</view>
        </view>

        <view class="form-item">
          <view class="form-label">默认开锁时长</view>
          <view class="delay-input-group">
            <input
              class="form-input"
              v-model.number="configDefaultDuration"
              type="number"
              placeholder="开锁时长"
            />
            <text class="unit">秒</text>
          </view>
          <view class="form-tips">范围: 1-60秒，新增柜门的默认值</view>
        </view>

        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="cancelConfig">取消</button>
          <button class="popup-btn confirm-btn" @click="confirmConfig">确定</button>
        </view>
      </view>
    </uni-popup>

    <!-- SKU编辑弹窗 -->
    <uni-popup ref="skuPopup" type="center">
      <view class="popup-content sku-popup">
        <view class="popup-title">商品设置 - {{ editingSku ? editingSku.lock_name : '' }}</view>

        <view class="form-item">
          <view class="form-label">商品名称</view>
          <input
            class="form-input"
            v-model="skuForm.sku_name"
            placeholder="请输入商品名称"
            maxlength="50"
          />
        </view>

        <view class="form-item">
          <view class="form-label">商品描述</view>
          <textarea
            class="form-textarea"
            v-model="skuForm.sku_desc"
            placeholder="请输入商品描述"
            maxlength="200"
          />
        </view>

        <view class="form-item">
          <view class="form-label">商品图片 <text class="form-tips-inline">(建议800x800，小于200KB)</text></view>
          <view class="image-upload-wrapper">
            <view class="image-upload" @click="editSkuImageAction">
              <image
                v-if="skuForm.sku_image"
                :src="getImgPath(skuForm.sku_image)"
                mode="aspectFill"
                class="preview-image"
              />
              <view v-else class="upload-placeholder">
                <uni-icons type="plusempty" size="40" color="#ccc" />
                <text>点击上传</text>
              </view>
            </view>
            <view class="image-actions" v-if="skuForm.sku_image">
              <text class="action-link" @click="chooseSkuImage">重选</text>
              <text class="action-link delete" @click="skuForm.sku_image = ''">删除</text>
            </view>
          </view>
        </view>

        <view class="form-item">
          <view class="form-label">售价（元）</view>
          <input
            class="form-input"
            v-model="skuForm.price"
            type="digit"
            placeholder="请输入售价"
          />
        </view>

        <view class="form-item">
          <view class="form-label">原价（元）</view>
          <input
            class="form-input"
            v-model="skuForm.original_price"
            type="digit"
            placeholder="选填，用于显示划线价"
          />
        </view>

        <view class="form-item">
          <view class="form-label">库存</view>
          <input
            class="form-input"
            v-model.number="skuForm.stock"
            type="number"
            placeholder="请输入库存数量"
          />
        </view>

        <view class="form-item">
          <view class="form-label">上架状态</view>
          <switch
            :checked="skuForm.status === 1"
            @change="skuForm.status = $event.detail.value ? 1 : 0"
            color="#07c160"
          />
          <text class="switch-label">{{ skuForm.status === 1 ? '已上架' : '已下架' }}</text>
        </view>

        <view class="popup-buttons">
          <button class="popup-btn cancel-btn" @click="cancelSkuEdit">取消</button>
          <button class="popup-btn confirm-btn" @click="saveSkuConfig">保存</button>
        </view>
      </view>
    </uni-popup>
  </view>
</template>

<script>
import {
  getW75Config_api,
  setW75LockConfig_api,
  openW75Lock_api,
  openW75Locks_api,
  getW75DoorStatus_api,
  createW75Qrcode_api,
  createW75LockQrcode_api,
  setW75LockCount_api,
  setW75WorkMode_api,
  setW75Sku_api
} from '../../api/index.js';
import { uploadImg } from '../../api/request.js';
import { imgPath } from '@/libs/filters.js';

export default {
  data() {
    return {
      device_sn: '',
      lockauth_id: '',
      deviceName: '柜门锁',
      locks: [],
      totalLocks: 0,
      boardCount: 0,
      showMsgText: '',
      editingLock: null,
      editingName: '',
      editingDuration: 1,
      currentLock: {},
      qrcodeUrl: '',
      qrcodeType: 'device', // 'device' 或 'lock'
      configLockCount: 36,
      configBoardCount: 1,
      configDefaultDuration: 1,
      isOpeningAll: false,
      // 工作模式: 1-存取模式 2-售卖模式
      workMode: 1,
      // SKU编辑相关
      editingSku: null,
      skuForm: {
        sku_name: '',
        sku_desc: '',
        sku_image: '',
        price: '',
        original_price: '',
        stock: '',
        status: 1
      }
    };
  },
  watch: {
    // 根据柜门数量自动计算板子数量
    configLockCount(val) {
      if (val && val > 0) {
        this.configBoardCount = Math.ceil(val / 36);
      }
    }
  },
  async onLoad(options) {
    this.device_sn = options.device_sn || '';
    this.lockauth_id = options.lockauth_id || '';
    if (!this.lockauth_id && options.lock_id) {
      const query = [
        `lock_id=${encodeURIComponent(options.lock_id)}`,
        options.device_sn ? `device_sn=${encodeURIComponent(options.device_sn)}` : '',
        options.global_lock ? `global_lock=${encodeURIComponent(options.global_lock)}` : ''
      ].filter(Boolean).join('&');
      uni.redirectTo({
        url: `/pages/W75Scan/W75Scan?${query}`
      });
      return;
    }

    await this.loadLockConfig();

    if (this.locks.length === 0) {
      setTimeout(() => {
        this.$refs.configPopup.open();
      }, 300);
    } else {
      await this.refreshStatus();
    }
  },
  methods: {
    // 图片路径处理
    getImgPath(url) {
      return imgPath(url);
    },
    async loadLockConfig() {
      try {
        const res = await getW75Config_api({
          lockauth_id: this.lockauth_id
        });

        if (res.code === 0 && res.data) {
          // 设置工作模式
          this.workMode = res.data.work_mode || 1;

          if (res.data.locks && res.data.locks.length > 0) {
            this.totalLocks = res.data.total_locks || 0;
            this.boardCount = res.data.board_count || 0;
            this.configLockCount = this.totalLocks;

            this.locks = res.data.locks.map(lock => ({
              ...lock,
              isRotating: false
            }));
          } else {
            this.locks = [];
            this.configLockCount = 36;
          }

          this.device_sn = res.data.device_sn;
          if (res.data.lock_name) {
            this.deviceName = res.data.lock_name;
          }
        }
      } catch (err) {
        console.error('加载配置失败:', err);
        uni.showToast({
          title: '加载配置失败',
          icon: 'none'
        });
      }
    },

    async refreshStatus() {
      if (!this.device_sn || !this.boardCount) {
        return;
      }
      try {
        for (let addr = 0; addr < this.boardCount; addr++) {
          const res = await getW75DoorStatus_api({
            device_sn: this.device_sn,
            addr: addr
          });

          if (res.code === 0 && res.data && res.data.info && Array.isArray(res.data.info.doors)) {
            const doors = res.data.info.doors;
            this.locks = this.locks.map(lock => {
              if (lock.addr === addr) {
                const index = lock.lock - 1;
                if (doors[index] !== undefined) {
                  return { ...lock, status: doors[index] };
                }
              }
              return lock;
            });
          }
        }
      } catch (err) {
        console.error('获取状态失败:', err);
        uni.showToast({
          title: '获取状态失败',
          icon: 'none'
        });
      }
    },

    getCardClass(lock) {
      return {
        'active': lock.status === 1,
        'used': lock.is_used === 1
      };
    },

    async openLock(lock) {
      this.$set(lock, 'isRotating', true);

      try {
        const res = await openW75Lock_api({
          device_sn: this.device_sn,
          global_lock: lock.global_lock
        });

        if (res.code === 0) {
          uni.vibrateShort();
          uni.showToast({
            title: '已开门',
            icon: 'success'
          });
        } else {
          uni.showToast({
            title: res.msg || '操作失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('操作失败:', err);
        uni.showToast({
          title: '操作失败',
          icon: 'none'
        });
      } finally {
        setTimeout(() => {
          this.$set(lock, 'isRotating', false);
        }, 1000);
      }
    },

    // 全开功能：按板子分批开锁
    async openAllLocks() {
      if (this.isOpeningAll) {
        return;
      }

      if (!this.locks.length || !this.boardCount) {
        uni.showToast({
          title: '请先设置柜门数量',
          icon: 'none'
        });
        return;
      }

      uni.showModal({
        title: '确认全开',
        content: `确定要打开全部 ${this.totalLocks} 个柜门吗？`,
        success: async (res) => {
          if (res.confirm) {
            await this.doOpenAllLocks();
          }
        }
      });
    },

    async doOpenAllLocks() {
      this.isOpeningAll = true;
      uni.showLoading({ title: '正在开门...', mask: true });

      try {
        let successCount = 0;
        let failCount = 0;

        // 按板子分批开锁
        for (let addr = 0; addr < this.boardCount; addr++) {
          // 获取这块板上的所有锁号
          const boardLocks = this.locks.filter(lock => lock.addr === addr);
          if (boardLocks.length === 0) continue;

          const lockNums = boardLocks.map(lock => lock.lock);

          try {
            const res = await openW75Locks_api({
              device_sn: this.device_sn,
              addr: addr,
              locks: lockNums,
              duration: 1 // 默认1秒
            });

            if (res.code === 0) {
              successCount += lockNums.length;
              // 设置旋转动画
              boardLocks.forEach(lock => {
                this.$set(lock, 'isRotating', true);
                setTimeout(() => {
                  this.$set(lock, 'isRotating', false);
                }, 1000);
              });
            } else {
              failCount += lockNums.length;
            }
          } catch (err) {
            console.error(`板${addr}开锁失败:`, err);
            failCount += lockNums.length;
          }
        }

        uni.hideLoading();
        uni.vibrateShort();

        if (failCount === 0) {
          uni.showToast({
            title: `已全部打开 ${successCount} 个门`,
            icon: 'success'
          });
        } else {
          uni.showToast({
            title: `成功${successCount}个，失败${failCount}个`,
            icon: 'none'
          });
        }
      } catch (err) {
        uni.hideLoading();
        console.error('全开失败:', err);
        uni.showToast({
          title: '操作失败',
          icon: 'none'
        });
      } finally {
        this.isOpeningAll = false;
      }
    },

    editLockConfig(lock) {
      this.editingLock = lock;
      this.editingName = lock.lock_name;
      this.editingDuration = lock.duration || 1;
      this.$refs.editPopup.open();
    },

    cancelEdit() {
      this.$refs.editPopup.close();
      this.editingLock = null;
      this.editingName = '';
      this.editingDuration = 1;
    },

    async confirmEdit() {
      if (!this.editingName.trim()) {
        uni.showToast({
          title: '名称不能为空',
          icon: 'none'
        });
        return;
      }

      const duration = parseInt(this.editingDuration);
      if (duration < 1 || duration > 60) {
        uni.showToast({
          title: '开锁时长范围: 1-60秒',
          icon: 'none'
        });
        return;
      }

      try {
        const res = await setW75LockConfig_api({
          lockauth_id: this.lockauth_id,
          global_lock: this.editingLock.global_lock,
          lock_name: this.editingName,
          duration: duration
        });

        if (res.code === 0) {
          this.editingLock.lock_name = this.editingName;
          this.editingLock.duration = duration;
          this.$refs.editPopup.close();
          uni.showToast({
            title: '保存成功',
            icon: 'success'
          });
        } else {
          uni.showToast({
            title: res.msg || '保存失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('保存失败:', err);
        uni.showToast({
          title: '保存失败',
          icon: 'none'
        });
      }
    },

    async showDeviceQRCode() {
      this.qrcodeUrl = '';
      this.qrcodeType = 'device';
      this.$refs.qrcodePopup.open();

      try {
        const res = await createW75Qrcode_api({
          lockauth_id: this.lockauth_id
        });

        if (res.code === 0 && res.data) {
          this.qrcodeUrl = res.data.qrcode_url;
        } else {
          uni.showToast({
            title: res.msg || '生成失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('生成二维码失败:', err);
        uni.showToast({
          title: '生成失败',
          icon: 'none'
        });
      }
    },

    async showLockQRCode(lock) {
      console.log('showLockQRCode lock:', lock);
      console.log('global_lock:', lock.global_lock);
      this.currentLock = lock;
      this.qrcodeUrl = '';
      this.qrcodeType = 'lock';
      this.$refs.qrcodePopup.open();

      try {
        const params = {
          lockauth_id: this.lockauth_id,
          global_lock: lock.global_lock
        };
        console.log('API params:', params);
        const res = await createW75LockQrcode_api(params);

        if (res.code === 0 && res.data) {
          this.qrcodeUrl = res.data.qrcode_url;
        } else {
          uni.showToast({
            title: res.msg || '生成失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('生成二维码失败:', err);
        uni.showToast({
          title: '生成失败',
          icon: 'none'
        });
      }
    },

    async saveQRCodeToAlbum() {
      if (!this.qrcodeUrl) {
        uni.showToast({
          title: '二维码未生成',
          icon: 'none'
        });
        return;
      }

      try {
        uni.showLoading({ title: '保存中...' });

        const downloadRes = await new Promise((resolve, reject) => {
          uni.downloadFile({
            url: this.qrcodeUrl,
            success: (res) => {
              if (res.statusCode === 200) {
                resolve(res.tempFilePath);
              } else {
                reject(new Error('下载失败'));
              }
            },
            fail: reject
          });
        });

        await new Promise((resolve, reject) => {
          uni.saveImageToPhotosAlbum({
            filePath: downloadRes,
            success: resolve,
            fail: reject
          });
        });

        uni.hideLoading();
        uni.showToast({
          title: '保存成功',
          icon: 'success'
        });
      } catch (err) {
        uni.hideLoading();
        console.error('保存失败:', err);

        if (err.errMsg && err.errMsg.includes('auth')) {
          uni.showModal({
            title: '提示',
            content: '需要您授权保存图片到相册',
            success: (res) => {
              if (res.confirm) {
                uni.openSetting();
              }
            }
          });
        } else {
          uni.showToast({
            title: '保存失败',
            icon: 'none'
          });
        }
      }
    },

    closeQRCode() {
      this.$refs.qrcodePopup.close();
    },

    showConfigPopup() {
      // 初始化配置弹窗的数据
      this.configLockCount = this.totalLocks || 36;
      this.configBoardCount = this.boardCount || Math.ceil((this.totalLocks || 36) / 36);
      this.configDefaultDuration = 1;
      this.$refs.configPopup.open();
    },

    cancelConfig() {
      this.configLockCount = this.totalLocks || 36;
      this.configBoardCount = this.boardCount || 1;
      this.$refs.configPopup.close();
    },

    async confirmConfig() {
      const count = parseInt(this.configLockCount);
      const boardCount = parseInt(this.configBoardCount);
      const duration = parseInt(this.configDefaultDuration);

      if (!count || count < 1 || count > 288) {
        uni.showToast({
          title: '柜门数量范围: 1-288',
          icon: 'none'
        });
        return;
      }

      if (!boardCount || boardCount < 1 || boardCount > 8) {
        uni.showToast({
          title: '板子数量范围: 1-8',
          icon: 'none'
        });
        return;
      }

      if (!duration || duration < 1 || duration > 60) {
        uni.showToast({
          title: '开锁时长范围: 1-60秒',
          icon: 'none'
        });
        return;
      }

      try {
        const res = await setW75LockCount_api({
          lockauth_id: this.lockauth_id,
          total_locks: count,
          board_count: boardCount,
          default_duration: duration
        });

        if (res.code === 0) {
          uni.showToast({
            title: '设置成功',
            icon: 'success'
          });

          this.$refs.configPopup.close();

          await this.loadLockConfig();
          await this.refreshStatus();
        } else {
          uni.showToast({
            title: res.msg || '设置失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('设置柜门数量失败:', err);
        uni.showToast({
          title: '设置失败',
          icon: 'none'
        });
      }
    },

    // 切换工作模式
    async switchWorkMode(mode) {
      if (this.workMode === mode) return;

      try {
        uni.showLoading({ title: '切换中...' });

        const res = await setW75WorkMode_api({
          lockauth_id: this.lockauth_id,
          work_mode: mode
        });

        if (res.code === 0) {
          this.workMode = mode;
          uni.showToast({
            title: mode === 1 ? '已切换存取模式' : '已切换售卖模式',
            icon: 'success'
          });
          // 重新加载配置以获取SKU信息
          await this.loadLockConfig();
        } else {
          uni.showToast({
            title: res.msg || '切换失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('切换模式失败:', err);
        uni.showToast({
          title: '切换失败',
          icon: 'none'
        });
      } finally {
        uni.hideLoading();
      }
    },

    // 编辑SKU配置
    editSkuConfig(lock) {
      this.editingSku = lock;

      if (lock.sku) {
        this.skuForm = {
          sku_name: lock.sku.sku_name || '',
          sku_desc: lock.sku.sku_desc || '',
          sku_image: lock.sku.sku_image || '',
          price: lock.sku.price ? String(lock.sku.price) : '',
          original_price: lock.sku.original_price ? String(lock.sku.original_price) : '',
          stock: lock.sku.stock || 0,
          status: lock.sku.status !== undefined ? lock.sku.status : 1
        };
      } else {
        this.skuForm = {
          sku_name: '',
          sku_desc: '',
          sku_image: '',
          price: '',
          original_price: '',
          stock: 1,
          status: 1
        };
      }

      this.$refs.skuPopup.open();
    },

    cancelSkuEdit() {
      this.$refs.skuPopup.close();
      this.editingSku = null;
    },

    // 选择商品图片
    chooseSkuImage() {
      uni.showActionSheet({
        itemList: ['拍照', '从相册选择'],
        success: (res) => {
          const sourceType = res.tapIndex === 0 ? ['camera'] : ['album'];
          uni.chooseImage({
            count: 1,
            sizeType: ['compressed'], // 使用系统压缩
            sourceType: sourceType,
            success: (imgRes) => {
              const tempFilePath = imgRes.tempFilePaths[0];
              // 再次压缩确保足够小
              this.compressAndUploadImage(tempFilePath);
            }
          });
        }
      });
    },

    // 压缩图片并上传
    compressAndUploadImage(filePath) {
      uni.showLoading({ title: '处理中...' });

      // 使用 uni.compressImage 压缩
      uni.compressImage({
        src: filePath,
        quality: 50, // 50% 质量确保足够小
        success: (compressRes) => {
          console.log('压缩成功:', compressRes.tempFilePath);
          this.uploadSkuImage(compressRes.tempFilePath);
        },
        fail: (err) => {
          console.error('压缩失败，尝试直接上传:', err);
          // 压缩失败直接上传原图（已经是系统压缩过的）
          this.uploadSkuImage(filePath);
        }
      });
    },

    // 编辑图片操作
    editSkuImageAction() {
      if (!this.skuForm.sku_image) {
        this.chooseSkuImage();
        return;
      }

      uni.showActionSheet({
        itemList: ['重新选择', '删除图片'],
        success: (res) => {
          if (res.tapIndex === 0) {
            this.chooseSkuImage();
          } else if (res.tapIndex === 1) {
            this.skuForm.sku_image = '';
          }
        }
      });
    },

    async uploadSkuImage(filePath) {
      try {
        uni.showLoading({ title: '上传中...' });

        // 使用 file.Images/upload 接口
        const res = await uploadImg('/file.Images/upload', { image: filePath });
        console.log('上传结果:', res);

        // 接口返回 code: 0 表示成功，data 直接是 url 字符串
        if (res.code === 0 && res.data) {
          this.skuForm.sku_image = res.data;
          uni.hideLoading();
        } else {
          uni.hideLoading();
          uni.showToast({
            title: res.msg || '上传失败',
            icon: 'none'
          });
        }
      } catch (err) {
        uni.hideLoading();
        console.error('上传图片失败:', err);
        uni.showToast({
          title: '上传失败',
          icon: 'none'
        });
      }
    },

    // 保存SKU配置
    async saveSkuConfig() {
      if (!this.skuForm.sku_name) {
        uni.showToast({
          title: '请输入商品名称',
          icon: 'none'
        });
        return;
      }

      const price = parseFloat(this.skuForm.price);
      if (isNaN(price) || price <= 0) {
        uni.showToast({
          title: '请输入有效的售价',
          icon: 'none'
        });
        return;
      }

      if (this.skuForm.stock < 0) {
        uni.showToast({
          title: '库存不能为负数',
          icon: 'none'
        });
        return;
      }

      try {
        uni.showLoading({ title: '保存中...' });

        const res = await setW75Sku_api({
          lockauth_id: this.lockauth_id,
          global_lock: this.editingSku.global_lock,
          sku_name: this.skuForm.sku_name,
          sku_desc: this.skuForm.sku_desc,
          sku_image: this.skuForm.sku_image,
          price: price,
          original_price: parseFloat(this.skuForm.original_price) || 0,
          stock: parseInt(this.skuForm.stock) || 0,
          status: this.skuForm.status
        });

        if (res.code === 0) {
          uni.showToast({
            title: '保存成功',
            icon: 'success'
          });

          this.$refs.skuPopup.close();
          this.editingSku = null;

          // 重新加载配置
          await this.loadLockConfig();
        } else {
          uni.showToast({
            title: res.msg || '保存失败',
            icon: 'none'
          });
        }
      } catch (err) {
        console.error('保存SKU失败:', err);
        uni.showToast({
          title: '保存失败',
          icon: 'none'
        });
      } finally {
        uni.hideLoading();
      }
    }
  }
};
</script>

<style scoped lang="scss">
.container {
  padding: 30rpx;
  background: #f5f5f5;
  min-height: 100vh;
}

.header {
  margin-bottom: 30rpx;
}

.title-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20rpx;
}

.action-btns {
  display: flex;
  align-items: center;
  gap: 12rpx;
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 4rpx;
  padding: 8rpx 12rpx;
  border-radius: 8rpx;

  .btn-text {
    font-size: 24rpx;
    color: #07c160;
  }
}

.title {
  font-size: 36rpx;
  font-weight: bold;
  color: #333;
  flex: 1;

  .device-sn {
    font-size: 24rpx;
    color: #999;
    margin-left: 10rpx;
  }
}

.action-btn {
  padding: 10rpx;
}

.qrcode-btn {
  background: #fff8e6;
  border: 1rpx solid #ff9800;
}

.msg-text {
  display: flex;
  align-items: center;
  background: #fff3cd;
  padding: 20rpx;
  border-radius: 12rpx;
  margin-top: 20rpx;
}

.msg-content {
  margin-left: 20rpx;
  font-size: 28rpx;
  color: #856404;
}

.lock-list {
  display: flex;
  flex-direction: column;
  gap: 20rpx;
}

.lock-card {
  background: #fff;
  border-radius: 16rpx;
  padding: 24rpx;
  box-shadow: 0 4rpx 12rpx rgba(0,0,0,0.06);
}

.lock-card.active {
  border: 2rpx solid #07c160;
}

.lock-card.used {
  border: 2rpx solid #ff9800;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16rpx;
}

.lock-name {
  font-size: 32rpx;
  font-weight: bold;
  color: #333;
}

.lock-id {
  font-size: 24rpx;
  color: #666;
  background: #f0f0f0;
  padding: 4rpx 12rpx;
  border-radius: 8rpx;
}

.lock-info {
  display: flex;
  justify-content: space-between;
  font-size: 26rpx;
  color: #666;
  margin-bottom: 20rpx;
}

.control-area {
  display: flex;
  justify-content: center;
  margin-bottom: 16rpx;
}

.key-button {
  width: 120rpx;
  height: 120rpx;
  background: #07c160;
  border-radius: 60rpx;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;

  &:active {
    transform: scale(0.9);
    opacity: 0.8;
  }
}

.key-circle {
  font-size: 48rpx;
  color: #fff;
}

.key-rotating {
  animation: rotate 1s linear infinite;
}

.action-buttons {
  display: flex;
  justify-content: space-around;
  padding-top: 16rpx;
  border-top: 1px solid #f0f0f0;
}

.action-item {
  display: flex;
  align-items: center;
  gap: 8rpx;
  font-size: 24rpx;
  color: #666;
  padding: 16rpx 20rpx;
  border-radius: 8rpx;
  transition: all 0.15s;
}

.action-item-hover {
  background: rgba(0, 0, 0, 0.08);
  transform: scale(0.95);
}

.popup-content {
  background: #fff;
  border-radius: 16rpx;
  padding: 40rpx;
  width: 600rpx;

  &.config-popup {
    width: 650rpx;
  }
}

.popup-title {
  font-size: 32rpx;
  font-weight: bold;
  text-align: center;
  margin-bottom: 30rpx;
}

.form-item {
  margin-bottom: 24rpx;
}

.form-label {
  font-size: 28rpx;
  color: #333;
  margin-bottom: 12rpx;
}

.form-input {
  width: 100%;
  border: 1px solid #ddd;
  border-radius: 8rpx;
  padding: 16rpx;
  font-size: 28rpx;
}

.delay-input-group {
  display: flex;
  align-items: center;
  gap: 12rpx;
}

.unit {
  font-size: 28rpx;
  color: #666;
}

.form-tips {
  font-size: 24rpx;
  color: #999;
  margin-top: 8rpx;
}

.popup-buttons {
  display: flex;
  justify-content: space-between;
  gap: 20rpx;
  margin-top: 30rpx;
}

.popup-btn {
  flex: 1;
  height: 80rpx;
  border-radius: 8rpx;
  font-size: 28rpx;
  border: none;
}

.cancel-btn {
  background: #f5f5f5;
  color: #666;
}

.confirm-btn {
  background: #07c160;
  color: #fff;
}

.qrcode-content {
  background: #fff;
  border-radius: 16rpx;
  padding: 40rpx;
  width: 600rpx;
  text-align: center;
}

.qrcode-title {
  font-size: 30rpx;
  margin-bottom: 20rpx;
}

.qrcode-image {
  width: 320rpx;
  height: 320rpx;
  margin: 0 auto 20rpx;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
}

.qrcode-tips {
  font-size: 24rpx;
  color: #999;
  margin-bottom: 20rpx;
}

// 工作模式切换
.mode-switch {
  display: flex;
  background: #fff;
  border-radius: 12rpx;
  padding: 8rpx;
  margin-bottom: 20rpx;

  .mode-item {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8rpx;
    padding: 16rpx 0;
    border-radius: 8rpx;
    font-size: 26rpx;
    color: #999;
    transition: all 0.3s;

    &.active {
      background: #f0f9f4;
      color: #07c160;
      font-weight: bold;

      &:last-child {
        background: #fff8f0;
        color: #ff9800;
      }
    }
  }
}

// 售卖模式卡片样式
.sell-mode {
  .sell-card {
    .sku-info {
      display: flex;
      padding: 16rpx 0;
      gap: 16rpx;

      .sku-image {
        width: 140rpx;
        height: 140rpx;
        border-radius: 8rpx;
        background: #f5f5f5;
        flex-shrink: 0;
      }

      .sku-detail {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

        .sku-name {
          font-size: 28rpx;
          font-weight: bold;
          color: #333;
          overflow: hidden;
          text-overflow: ellipsis;
          white-space: nowrap;
        }

        .sku-price {
          display: flex;
          align-items: baseline;
          gap: 8rpx;

          .price {
            font-size: 32rpx;
            font-weight: bold;
            color: #ff4d4f;
          }

          .original-price {
            font-size: 24rpx;
            color: #999;
            text-decoration: line-through;
          }
        }

        .sku-stock {
          display: flex;
          gap: 16rpx;
          font-size: 24rpx;
          color: #999;

          .out-of-stock {
            color: #ff4d4f;
          }

          .sold-count {
            color: #ccc;
          }
        }
      }
    }

    .no-sku {
      padding: 40rpx 0;
      text-align: center;
      color: #999;
      font-size: 26rpx;
      background: #fafafa;
      border-radius: 8rpx;
    }

    &.has-sku {
      border-left: 4rpx solid #ff9800;
    }
  }
}

// SKU编辑弹窗
.sku-popup {
  max-height: 80vh;
  overflow-y: auto;

  .form-textarea {
    width: 100%;
    height: 160rpx;
    border: 1px solid #ddd;
    border-radius: 8rpx;
    padding: 16rpx;
    font-size: 28rpx;
  }

  .form-tips-inline {
    font-size: 22rpx;
    color: #999;
    font-weight: normal;
  }

  .image-upload-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 20rpx;
  }

  .image-upload {
    width: 200rpx;
    height: 200rpx;
    border: 2rpx dashed #ddd;
    border-radius: 8rpx;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;

    .preview-image {
      width: 100%;
      height: 100%;
    }

    .upload-placeholder {
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #ccc;
      font-size: 24rpx;
    }
  }

  .image-actions {
    display: flex;
    flex-direction: column;
    gap: 16rpx;

    .action-link {
      font-size: 26rpx;
      color: #07c160;
      padding: 8rpx 16rpx;
      background: #f0f9f4;
      border-radius: 6rpx;

      &.delete {
        color: #ff4d4f;
        background: #fff1f0;
      }
    }
  }

  .switch-label {
    margin-left: 16rpx;
    font-size: 26rpx;
    color: #666;
  }
}

@keyframes rotate {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>
