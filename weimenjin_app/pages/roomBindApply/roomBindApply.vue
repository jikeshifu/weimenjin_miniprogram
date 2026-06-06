<template>
  <view class="big-box">
    <view class="background"></view>
    <view class="content">
      <view class="header">
        <text class="title">申请绑定房间</text>
      </view>

      <!-- 钥匙选择模式 -->
      <view v-if="method === 'key'" class="form-section">
        <view class="form-label">第一步：选择钥匙</view>
        <view class="key-selector">
          <!-- 有区域信息的钥匙 -->
          <view v-if="keysWithArea.length > 0" class="keys-group">
            <view class="group-title">✓ 可直接使用（已绑定区域）</view>
            <view
              v-for="(key, index) in keysWithArea"
              :key="'area-' + index"
              class="key-item"
              :class="{ active: selectedKey?.lock_id === key.lock_id }"
              @click="selectKey(key)"
            >
              <view class="key-icon">🔑</view>
              <view class="key-info">
                <view class="key-name">{{ key.device_name || key.lock_name }}</view>
                <view class="key-sn">{{ key.lock_sn }}</view>
                <view class="key-location">{{ key.area_name }}-{{ key.building_name }}-{{ key.unit_name }}</view>
              </view>
              <view v-if="selectedKey?.lock_id === key.lock_id" class="check-icon">✓</view>
            </view>
          </view>

          <!-- 无区域信息的钥匙 -->
          <view v-if="keysWithoutArea.length > 0" class="keys-group">
            <view class="group-title">✗ 暂不可用（设备未配置区域）</view>
            <view class="group-hint">请联系管理员为设备配置区域信息</view>
            <view
              v-for="(key, index) in keysWithoutArea"
              :key="'noarea-' + index"
              class="key-item disabled"
            >
              <view class="key-icon">🔑</view>
              <view class="key-info">
                <view class="key-name">{{ key.device_name || key.lock_name }}</view>
                <view class="key-sn">{{ key.lock_sn }}</view>
              </view>
            </view>
          </view>

          <view v-if="myKeys.length === 0" class="empty-keys">
            您还没有任何钥匙
          </view>
        </view>

        <!-- 已选择的钥匙显示及房间选择 -->
        <view v-if="selectedKey" class="selected-key-info">
          <view class="form-label">第二步：选择房间</view>
          <view class="selected-key">
            <view class="key-name">{{ selectedKey.device_name || selectedKey.lock_name }}</view>
            <view class="key-location">{{ selectedKey.area_name }}-{{ selectedKey.building_name }}-{{ selectedKey.unit_name }}</view>
          </view>

          <view class="selector-item">
            <text class="label">房间：</text>
            <picker :value="selectedRoomIndex" :range="rooms" range-key="room_number" @change="onRoomChange">
              <view class="picker-value">{{ selectedRoom?.room_number || '请选择房间' }}</view>
            </picker>
          </view>
        </view>
      </view>

      <!-- 二维码模式 -->
      <view v-if="method === 'qrcode'" class="form-section">
        <view class="form-label">第一步：确认位置</view>

        <!-- 专属设备（有单元信息）：unit_id > 0 才是专属设备 -->
        <view v-if="selectedUnit?.unit_id" class="qrcode-section">
          <!-- 区域信息显示 -->
          <view class="selector-item">
            <text class="label">区域：</text>
            <view class="value-text">{{ selectedArea?.area_name || '未配置' }}</view>
          </view>

          <!-- 楼栋信息显示 -->
          <view class="selector-item">
            <text class="label">楼栋：</text>
            <view class="value-text">{{ selectedBuilding?.building_name || '未配置' }}</view>
          </view>

          <!-- 单元信息显示 -->
          <view class="selector-item">
            <text class="label">单元：</text>
            <view class="value-text">{{ selectedUnit?.unit_name || '未配置' }}</view>
          </view>
        </view>

        <!-- 公共设备（没有单元信息，需要用户手动选择）-->
        <view v-else class="qrcode-section">
          <!-- 区域未配置提示 -->
          <view v-if="!selectedArea || !selectedArea.area_id" class="error-tip">
            <text class="error-icon">⚠️</text>
            <text class="error-text">该设备未配置区域信息，无法绑定房间。请联系管理员为设备配置区域、楼栋、单元信息后再试。</text>
          </view>

          <!-- 区域显示（不可选） -->
          <view v-if="selectedArea && selectedArea.area_id" class="selector-item">
            <text class="label">区域：</text>
            <view class="value-text">{{ selectedArea.area_name }}</view>
          </view>

          <!-- 楼栋选择（后端返回 {id, name}） -->
          <view v-if="buildings.length > 0" class="selector-item">
            <text class="label">楼栋：</text>
            <picker :value="selectedBuildingIndex" :range="buildings" range-key="name" @change="onBuildingChangeForQRCode">
              <view class="picker-value">{{ selectedBuilding?.name || '请选择楼栋' }}</view>
            </picker>
          </view>
          <view v-else-if="selectedArea?.area_id" class="loading-message">
            加载楼栋中...
          </view>

          <!-- 单元选择（后端返回 {id, name}） -->
          <view v-if="units.length > 0" class="selector-item">
            <text class="label">单元：</text>
            <picker :value="selectedUnitIndex" :range="units" range-key="name" @change="onUnitChangeForQRCode">
              <view class="picker-value">{{ selectedUnit?.name || '请选择单元' }}</view>
            </picker>
          </view>
          <view v-else-if="selectedBuilding?.id" class="loading-message">
            加载单元中...
          </view>
        </view>

        <!-- 房间选择（第二步） -->
        <view v-if="rooms.length > 0" class="selector-item">
          <view class="form-label">第二步：选择房间</view>
          <picker :value="selectedRoomIndex" :range="rooms" range-key="room_number" @change="onRoomChange">
            <view class="picker-value">{{ selectedRoom?.room_number || '请选择房间' }}</view>
          </picker>
        </view>
        <view v-else-if="selectedUnit?.id" class="loading-rooms">
          加载房间中...
        </view>
      </view>

      <!-- 申请信息 -->
      <view v-if="selectedRoom" class="form-section">
        <view class="form-label">申请信息</view>

        <view class="form-item">
          <text class="label">关系类型：</text>
          <picker :value="relationType" :range="relationTypes" range-key="name" @change="onRelationTypeChange">
            <view class="picker-value">{{ relationTypes[relationType]?.name }}</view>
          </picker>
        </view>

        <view class="form-item">
          <text class="label">姓名：</text>
          <input
            type="text"
            class="input-field"
            v-model="applicantName"
            placeholder="请输入申请人姓名"
            maxlength="50"
          />
        </view>

        <view class="form-item">
          <text class="label">电话：</text>
          <input
            type="tel"
            class="input-field"
            v-model="applicantPhone"
            placeholder="请输入联系电话"
            maxlength="20"
          />
        </view>
      </view>

      <!-- 按钮 -->
      <view v-if="selectedRoom" class="button-group">
        <button class="btn-submit" @click="submitApplication" :disabled="isLoading">
          {{ isLoading ? '提交中...' : '提交申请' }}
        </button>
      </view>

      <view v-else-if="method === 'qrcode'" class="button-group">
        <button class="btn-scan" @click="scanQRCode">
          📱 重新扫描
        </button>
      </view>
    </view>
  </view>
</template>

<script>
import { roomBindGetAreas, roomBindGetBuildings, roomBindGetUnits, roomBindGetRooms, roomBindParseQRCode, roomBindApply, roomBindGetApplications, userGetMyKeys } from '@/api/index.js'

export default {
  data() {
    return {
      method: 'key', // 'key' 或 'qrcode'
      lockIdForQRCode: 0, // 公共设备扩堁日秎保存的lock_id
      myKeys: [],
      keysWithArea: [],
      keysWithoutArea: [],
      selectedKey: null,
      areas: [],
      buildings: [],
      units: [],
      rooms: [],
      selectedAreaIndex: 0,
      selectedBuildingIndex: 0,
      selectedUnitIndex: 0,
      selectedRoomIndex: 0,
      selectedArea: null,
      selectedBuilding: null,
      selectedUnit: null,
      selectedRoom: null,
      relationTypes: [
        { name: '业主' },
        { name: '租户' },
        { name: '家人' },
        { name: '员工' },
        { name: '其他' }
      ],
      relationType: 0,
      applicantName: '',
      applicantPhone: '',
      isLoading: false,
      myApplications: [], // 已申请的成扩卡二维码接口列表
    }
  },
  onLoad(options) {
    this.method = options.method || 'key'

    // 加载已申请的成扩卡二维码接口列表
    this.loadMyApplications()

    // 如果是扫码模式
    // 如果是扫码模式
    if (this.method === 'qrcode' && options.lock_id) {
      const lockId = parseInt(options.lock_id)
      this.lockIdForQRCode = lockId // 保存下lock_id供后续使用

      // 从 URL 参数中提取区域、楼栋信息（如果有）
      if (options.area_id && parseInt(options.area_id) > 0) {
        this.selectedArea = {
          area_id: parseInt(options.area_id),
          area_name: decodeURIComponent(options.area_name || '')
        }
      }
      if (options.building_id && parseInt(options.building_id) > 0) {
        this.selectedBuilding = {
          building_id: parseInt(options.building_id),
          building_name: decodeURIComponent(options.building_name || '')
        }
      }
      if (options.unit_id && parseInt(options.unit_id) > 0) {
        // 如果 URL 参数中已经有单元信息
        this.selectedUnit = {
          unit_id: parseInt(options.unit_id),
          unit_name: decodeURIComponent(options.unit_name || '')
        }
      }

      // 判断是否是有单元的设备（专属设备）还是没有单元的（公共设备）
      if (options.unit_id && parseInt(options.unit_id) > 0) {
        // 专属设备：有单元信息，直接加载房间列表
        this.loadRoomsByQRCode(lockId, parseInt(options.unit_id))
      } else {
        // 公共设备：没有单元信息，需要用户手动选择楼栋、单元、房间
        // 但区域已经从扫码获取，直接加载该区域下的楼栋
        if (this.selectedArea && this.selectedArea.area_id > 0) {
          this.loadBuildingsForQRCode(this.selectedArea.area_id)
        } else {
          this.loadAreasForQRCode(lockId)
        }
      }
    }

    if (this.method === 'key') {
      this.loadMyKeys()
    }
  },
  methods: {
    async loadAreasForQRCode(lockId) {
      // 公共设备（没有单元信息）：加载区域列表
      try {
        const res = await roomBindGetAreas({})
        if (res.code === 0) {
          this.areas = res.data || []
          // 如果有区域数据，自动选中第一个
          if (this.areas.length > 0) {
            this.selectedAreaIndex = 0
            this.selectedArea = this.areas[0]
          }
        } else {
          uni.showToast({ title: res.msg || '加载区域列表失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载区域列表失败: ' + error.message, icon: 'error' })
      }
    },
    async loadBuildingsForQRCode(areaId) {
      // 公共设备（没有单元信息）：加载楼栋列表
      try {
        const res = await roomBindGetBuildings({ area_id: areaId, lock_id: this.lockIdForQRCode })
        if (res.code === 0) {
          this.buildings = res.data || []
          this.units = []
          this.rooms = []
          this.selectedBuilding = null
          this.selectedUnit = null
          this.selectedRoom = null
          this.selectedBuildingIndex = 0
          this.selectedUnitIndex = 0
          this.selectedRoomIndex = 0
          // 如果有楼栋数据，自动选中第一个并加载单元
          if (this.buildings.length > 0) {
            this.selectedBuilding = this.buildings[0]
            // 自动加载该楼栋下的单元（后端返回的是 id 字段）
            this.loadUnitsForQRCode(this.selectedBuilding.id)
          }
        } else {
          uni.showToast({ title: res.msg || '加载楼栋列表失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载楼栋列表失败: ' + error.message, icon: 'error' })
      }
    },
    async loadUnitsForQRCode(buildingId) {
      // 公共设备（没有单元信息）：加载单元列表
      try {
        const res = await roomBindGetUnits({ building_id: buildingId, lock_id: this.lockIdForQRCode })
        if (res.code === 0) {
          this.units = res.data || []
          this.rooms = []
          this.selectedUnit = null
          this.selectedRoom = null
          this.selectedUnitIndex = 0
          this.selectedRoomIndex = 0
          // 如果有单元数据，自动选中第一个并加载房间
          if (this.units.length > 0) {
            this.selectedUnit = this.units[0]
            // 自动加载该单元下的房间（后端返回的是 id 字段）
            if (this.lockIdForQRCode > 0) {
              this.loadRoomsForQRCode(this.selectedUnit.id, this.lockIdForQRCode)
            }
          }
        } else {
          uni.showToast({ title: res.msg || '加载单元列表失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载单元列表失败: ' + error.message, icon: 'error' })
      }
    },
    async loadRoomsForQRCode(unitId, lockId) {
      // 公共设备（没有单元信息）：加载房间列表
      try {
        const res = await roomBindGetRooms({ unit_id: unitId, lock_id: lockId })
        if (res.code === 0) {
          this.rooms = res.data || []
          this.selectedRoomIndex = 0
          if (this.rooms.length > 0) {
            this.selectedRoom = this.rooms[0]
            // 检查是否已经申请过
            if (this.isRoomAlreadyApplied(this.selectedRoom.room_id)) {
              uni.showToast({ title: '你已经申请过该房间，不能再应用', icon: 'none' })
            }
          }
        } else {
          uni.showToast({ title: res.msg || '加载房间列表失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载房间列表失败: ' + error.message, icon: 'error' })
      }
    },
    async loadMyKeys() {
      try {
        const res = await userGetMyKeys({ page: 1, limit: 1000 })
        if (res.code === 0) {
          // 设置两个分类数组
          this.keysWithArea = res.data.keys_with_area || []
          this.keysWithoutArea = res.data.keys_without_area || []
          this.myKeys = res.data.all_keys || []
        } else {
          uni.showToast({ title: '获取钥匙失败: ' + (res.msg || '未知错误'), icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载钥匙失败: ' + error.message, icon: 'error' })
      }
    },
    async loadAreas() {
      // 取消，钥匙模式不需要手动选择区域
    },
    async loadBuildings() {
      // 取消，钥匙模式不需要手动选择楼栋
    },
    async loadUnits() {
      // 取消，钥匙模式不需要手动选择单元
    },
    async loadRoomsByQRCode(lockId, unitId) {
      // 二维码扫码模式加载房间
      try {
        const res = await roomBindGetRooms({
          lock_id: lockId,
          unit_id: unitId
        })
        if (res.code === 0) {
          this.rooms = res.data || []
          this.selectedRoomIndex = 0
          // 自动选中第一个房间
          if (this.rooms.length > 0) {
            this.selectedRoom = this.rooms[0]
            // 检查是否已经申请过
            if (this.isRoomAlreadyApplied(this.selectedRoom.room_id)) {
              uni.showToast({ title: '你已经申请过该房间，不能再应用', icon: 'none' })
            }
            // 从房间数据中提取区域、楼栋、单元信息
            // 优先使用 URL 参数中的区域和楼栋信息，如果没有则使用房间数据中的
            if (!this.selectedArea || !this.selectedArea.area_id) {
              this.selectedArea = {
                area_id: this.selectedRoom.area_id || 0,
                area_name: this.selectedRoom.area_name || ''
              }
            }
            if (!this.selectedBuilding || !this.selectedBuilding.building_id) {
              this.selectedBuilding = {
                building_id: this.selectedRoom.building_id || 0,
                building_name: this.selectedRoom.building_name || ''
              }
            }
            // 单元信息总是从房间数据中获取
            this.selectedUnit = {
              unit_id: this.selectedRoom.unit_id,
              unit_name: this.selectedRoom.unit_name || ''
            }
          }
        } else {
          uni.showToast({ title: res.msg || '加载房间列表失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '加载房间列表失败: ' + error.message, icon: 'error' })
      }
    },
    async loadMyApplications() {
      // 加载已申请的房间列表
      try {
        const res = await roomBindGetApplications({})
        if (res.code === 0) {
          this.myApplications = res.data || []
        }
      } catch (error) {
      }
    },
    isRoomAlreadyApplied(roomId) {
      // 检查是否已经申请过该房间
      return this.myApplications.some(app => app.room_id === roomId)
    },
    async loadRooms() {
      // 钗匙模式加载房间
      if (!this.selectedKey || !this.selectedKey.lock_id) return
      this.loadRoomsByQRCode(this.selectedKey.lock_id, this.selectedKey.unit_id)
    },
    selectKey(key) {
      this.selectedKey = key
      // 需要根据钗匙的unit_id来加载房间，不需要再输入区域/民栋/单元
      this.loadRooms()
    },
    onAreaChange(e) {
      // 用不到，钥匙模式不需要手动选择
    },
    onBuildingChange(e) {
      // 用不到，钥匙模式不需要手动选择
    },
    onUnitChange(e) {
      // 用不到，钥匙模式不需要手动选择
    },
    onRoomChange(e) {
      this.selectedRoomIndex = e.detail.value
      this.selectedRoom = this.rooms[this.selectedRoomIndex]
      // 检查是否已经申请过
      if (this.selectedRoom && this.isRoomAlreadyApplied(this.selectedRoom.room_id)) {
        uni.showToast({ title: '你已经申请过该房间，不能再应用', icon: 'none' })
      }
    },
    onAreaChangeForQRCode(e) {
      this.selectedAreaIndex = e.detail.value
      if (this.areas.length > this.selectedAreaIndex) {
        this.selectedArea = this.areas[this.selectedAreaIndex]
        this.loadBuildingsForQRCode(this.selectedArea.area_id)
      }
    },
    onBuildingChangeForQRCode(e) {
      this.selectedBuildingIndex = e.detail.value
      if (this.buildings.length > this.selectedBuildingIndex) {
        this.selectedBuilding = this.buildings[this.selectedBuildingIndex]
        // 后端返回的是 {id: xxx, name: xxx}
        this.loadUnitsForQRCode(this.selectedBuilding.id)
      }
    },
    onUnitChangeForQRCode(e) {
      this.selectedUnitIndex = e.detail.value
      if (this.units.length > this.selectedUnitIndex) {
        this.selectedUnit = this.units[this.selectedUnitIndex]
        // 根据保存的lockId，加载房间（后端返回的是 {id: xxx, name: xxx}）
        if (this.lockIdForQRCode > 0) {
          this.loadRoomsForQRCode(this.selectedUnit.id, this.lockIdForQRCode)
        }
      }
    },
    onRelationTypeChange(e) {
      this.relationType = e.detail.value
    },
    async scanQRCode() {
      try {
        uni.scanCode({
          success: async (res) => {
            await this.parseQRCode(res.result)
          },
          fail: () => {
            uni.showToast({ title: '扫描失败', icon: 'error' })
          }
        })
      } catch (error) {
        uni.showToast({ title: '扫描出错', icon: 'error' })
      }
    },
    async parseQRCode(qrCode) {
      uni.showLoading({ title: '识别中...', mask: true })
      try {
        const res = await roomBindParseQRCode({ qr_code: qrCode })
        uni.hideLoading()
        if (res.code === 0) {
          // 扫码成功，获取到区域信息
          const lockId = res.data.lock_id
          const unitId = res.data.unit_id

          // 保存 lock_id
          this.lockIdForQRCode = lockId

          // 更新区域、楼栋、单元信息
          this.selectedArea = {
            area_id: res.data.area_id || 0,
            area_name: res.data.area_name || ''
          }
          this.selectedBuilding = {
            building_id: res.data.building_id || 0,
            building_name: res.data.building_name || ''
          }
          this.selectedUnit = {
            unit_id: res.data.unit_id || 0,
            unit_name: res.data.unit_name || ''
          }

          // 清空之前的房间数据
          this.rooms = []
          this.selectedRoom = null
          this.selectedRoomIndex = 0

          // 判断是单元门还是公共门，加载对应的数据
          if (unitId && unitId > 0) {
            // 单元门，直接加载房间列表
            this.loadRoomsByQRCode(lockId, unitId)
          } else {
            // 公共门，需要用户选择楼栋、单元
            if (this.selectedArea && this.selectedArea.area_id > 0) {
              this.loadBuildingsForQRCode(this.selectedArea.area_id)
            }
          }

          uni.showToast({ title: '识别成功', icon: 'success' })
        } else {
          // 扫码失败（如：设备未绑定区域），清空所有数据
          this.selectedArea = null
          this.selectedBuilding = null
          this.selectedUnit = null
          this.selectedRoom = null
          this.rooms = []
          this.buildings = []
          this.units = []
          this.lockIdForQRCode = 0

          uni.showModal({
            title: '提示',
            content: res.msg || '识别失败',
            showCancel: false
          })
        }
      } catch (error) {
        uni.hideLoading()
        // 出错也要清空数据
        this.selectedArea = null
        this.selectedBuilding = null
        this.selectedUnit = null
        this.selectedRoom = null
        this.rooms = []
        this.buildings = []
        this.units = []
        this.lockIdForQRCode = 0

        uni.showToast({ title: '识别出错', icon: 'error' })
      }
    },
    async submitApplication() {
      // 先检查是否已经申请过
      if (this.selectedRoom && this.isRoomAlreadyApplied(this.selectedRoom.room_id)) {
        uni.showToast({ title: '你已经申请过该房间，无法再次应用', icon: 'error' })
        return
      }

      if (!this.selectedRoom) {
        uni.showToast({ title: '请选择房间', icon: 'error' })
        return
      }
      if (!this.applicantName) {
        uni.showToast({ title: '请输入申请人姓名', icon: 'error' })
        return
      }
      if (!this.applicantPhone) {
        uni.showToast({ title: '请输入联系电话', icon: 'error' })
        return
      }

      this.isLoading = true
      try {
        // 对于公共门扫码，selectedUnit 是 {id, name} 结构，需要使用 id
        // 对于钥匙模式，selectedKey 直接有 unit_id
        const unitId = this.method === 'qrcode'
          ? ((this.selectedUnit && this.selectedUnit.id) || (this.selectedRoom && this.selectedRoom.unit_id))
          : (this.selectedKey && this.selectedKey.unit_id)

        const params = {
          lock_id: this.lockIdForQRCode || (this.selectedKey && this.selectedKey.lock_id),
          unit_id: unitId,
          room_id: this.selectedRoom.room_id,
          relation_type: this.relationType,
          applicant_name: this.applicantName,
          applicant_phone: this.applicantPhone
        }
        const res = await roomBindApply(params)
        if (res.code === 0) {
          uni.showToast({ title: '申请提交成功，请等待管理员审核', icon: 'success' })
          setTimeout(() => {
            uni.navigateBack()
          }, 1500)
        } else {
          uni.showToast({ title: res.msg || '申请失败', icon: 'error' })
        }
      } catch (error) {
        uni.showToast({ title: '提交失败，请重试: ' + error.message, icon: 'error' })
      } finally {
        this.isLoading = false
      }
    }
  }
}
</script>

<style scoped lang="scss">
.big-box {
  .background {
    width: 100%;
    height: 352rpx;
    background: rgb(33, 207, 62);
    opacity: 0.2;
    box-shadow: 0px 8rpx 374rpx rgb(58, 137, 254);
    filter: blur(120rpx);
    position: absolute;
    top: 0;
    left: 0;
  }
  .content {
    position: relative;
    z-index: 10;
    padding: 120rpx 30rpx 100rpx;
    .header {
      text-align: center;
      margin-bottom: 30rpx;
      .title {
        font-size: 32rpx;
        font-weight: bold;
        color: #333333;
      }
    }
    .form-section {
      margin-bottom: 30rpx;
      background: white;
      border-radius: 24rpx;
      padding: 24rpx;
      box-shadow: 16rpx 16rpx 66rpx rgba(117, 160, 232, 0.2);
      .form-label {
        font-size: 28rpx;
        font-weight: 500;
        color: #333333;
        margin-bottom: 20rpx;
      }
      .selected-key-info {
        margin-top: 30rpx;
        padding-top: 30rpx;
        border-top: 1px solid #f0f0f0;
      }
      .selected-key {
        background: #f5f5f5;
        border-radius: 12rpx;
        padding: 16rpx;
        margin-bottom: 20rpx;
        .key-name {
          font-size: 26rpx;
          color: #21CF3E;
          font-weight: 500;
        }
        .key-location {
          font-size: 22rpx;
          color: #999999;
          margin-top: 4rpx;
        }
      }
      .key-selector {
        .keys-group {
          margin-bottom: 24rpx;
          .group-title {
            font-size: 24rpx;
            font-weight: 500;
            color: #333333;
            margin-bottom: 12rpx;
          }
          .group-hint {
            font-size: 22rpx;
            color: #FF9500;
            margin-bottom: 12rpx;
            padding: 12rpx 16rpx;
            background: #FFF8E6;
            border-radius: 8rpx;
          }
        }
        .key-item {
          background: #f9f9f9;
          border: 2px solid #e5e5e5;
          border-radius: 16rpx;
          padding: 16rpx;
          margin-bottom: 12rpx;
          display: flex;
          align-items: center;
          gap: 16rpx;
          position: relative;
          &.active {
            border-color: #21CF3E;
            background: rgba(33, 207, 62, 0.05);
          }
          &.disabled {
            background: #f5f5f5;
            opacity: 0.6;
          }
          .key-icon {
            font-size: 32rpx;
            flex-shrink: 0;
          }
          .key-info {
            flex: 1;
            .key-name {
              font-size: 26rpx;
              color: #333333;
              font-weight: 500;
            }
            .key-sn {
              font-size: 22rpx;
              color: #999999;
              margin-top: 4rpx;
            }
            .key-location {
              font-size: 20rpx;
              color: #21CF3E;
              margin-top: 4rpx;
            }
          }
          .check-icon {
            font-size: 28rpx;
            color: #21CF3E;
            flex-shrink: 0;
          }
        }
        .empty-keys {
          text-align: center;
          padding: 30rpx;
          color: #999999;
          font-size: 26rpx;
        }
      }
      .form-group {
        margin-top: 20rpx;
      }
      .selector-item, .form-item {
        display: flex;
        align-items: center;
        margin-bottom: 16rpx;
        padding: 12rpx 0;
        border-bottom: 1px solid #f0f0f0;
        .label {
          min-width: 80rpx;
          font-size: 26rpx;
          color: #666666;
        }
        picker {
          flex: 1;
          .picker-value {
            font-size: 26rpx;
            color: #333333;
            padding: 8rpx 12rpx;
            background: #f5f5f5;
            border-radius: 8rpx;
          }
        }
        .input-field {
          flex: 1;
          font-size: 26rpx;
          color: #333333;
          padding: 8rpx 12rpx;
          background: #f5f5f5;
          border-radius: 8rpx;
          border: none;
        }
      }
      .scan-tip {
        text-align: center;
        padding: 30rpx 20rpx;
        color: #666666;
        font-size: 26rpx;
        background: #f9f9f9;
        border-radius: 12rpx;
      }
      .error-tip {
        display: flex;
        align-items: flex-start;
        padding: 20rpx;
        background: #FFF3F3;
        border: 2rpx solid #FFD4D4;
        border-radius: 12rpx;
        margin-bottom: 20rpx;
        .error-icon {
          font-size: 32rpx;
          margin-right: 12rpx;
          flex-shrink: 0;
        }
        .error-text {
          flex: 1;
          font-size: 24rpx;
          color: #E02020;
          line-height: 1.5;
        }
      }
      .qrcode-result {
        background: #f5f5f5;
        border-radius: 12rpx;
        padding: 20rpx;
        .result-title {
          font-size: 28rpx;
          font-weight: 500;
          color: #21CF3E;
          margin-bottom: 16rpx;
        }
        .result-info {
          .info-row {
            display: flex;
            padding: 8rpx 0;
            .label {
              color: #666666;
              font-size: 24rpx;
              min-width: 80rpx;
            }
            .value {
              color: #333333;
              font-size: 24rpx;
              flex: 1;
            }
          }
        }
      }
      .textarea {
        width: 100%;
        border: 1px solid #e5e5e5;
        border-radius: 8rpx;
        padding: 12rpx;
        font-size: 24rpx;
        min-height: 120rpx;
      }
      .char-count {
        text-align: right;
        font-size: 20rpx;
        color: #999999;
        margin-top: 4rpx;
      }
    }
    .button-group {
      margin-bottom: 30rpx;
      .btn-submit, .btn-scan {
        width: 100%;
        padding: 16rpx;
        background: linear-gradient(90deg, #1aad19, #2ecc71);
        color: white;
        border: none;
        border-radius: 12rpx;
        font-size: 28rpx;
        font-weight: 500;
        &:active {
          opacity: 0.8;
        }
        &:disabled {
          background: #cccccc;
          opacity: 0.7;
        }
      }
    }
  }
}
</style>
