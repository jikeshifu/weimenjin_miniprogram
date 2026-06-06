<?php

namespace app\module\areaMigration;

use think\facade\Db;

/**
 * 区域数据迁移模块
 * 为现有设备和用户创建默认区域结构
 */
class AreaMigration
{
    /**
     * 执行完整迁移
     *
     * @return array 迁移结果
     */
    public static function migrateAll(): array
    {
        try {
            Db::startTrans();

            $result = [
                'areas' => 0,
                'buildings' => 0,
                'units' => 0,
                'rooms' => 0,
                'member_bindings' => 0,
                'device_updates' => 0,
                'errors' => []
            ];

            // 1. 创建或获取默认区域
            $defaultArea = self::createDefaultArea();
            $result['areas'] = 1;

            // 2. 为所有未配置区域的设备创建默认结构
            $devices = Db::name('lock')
                ->whereNull('area_id')
                ->whereNull('deleted_at')
                ->where('status', 1)
                ->select()
                ->toArray();

            mlog("📊 找到 " . count($devices) . " 个未配置区域的设备", "migration.txt");

            foreach ($devices as $device) {
                try {
                    // 为每个设备创建默认结构
                    $structResult = self::createDefaultStructureForDevice($device, $defaultArea);

                    if ($structResult['success']) {
                        $result['buildings'] += $structResult['buildings'];
                        $result['units'] += $structResult['units'];
                        $result['rooms'] += $structResult['rooms'];
                        $result['member_bindings'] += $structResult['member_bindings'];
                        $result['device_updates']++;
                    }
                } catch (\Exception $e) {
                    $result['errors'][] = "设备 {$device['lock_sn']}: " . $e->getMessage();
                    mlog("❌ 迁移设备失败: {$device['lock_sn']} - " . $e->getMessage(), "migration.txt");
                }
            }

            Db::commit();

            mlog("✅ 迁移完成: " . json_encode($result), "migration.txt");

            return ['success' => true, 'data' => $result];

        } catch (\Exception $e) {
            Db::rollback();
            mlog("❌ 迁移失败: " . $e->getMessage(), "migration.txt");
            return ['success' => false, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 创建或获取默认区域
     */
    private static function createDefaultArea(): array
    {
        // 检查是否已存在默认区域
        $area = Db::name('areas')
            ->where('area_code', 'DEFAULT_AREA')
            ->whereNull('deleted_at')
            ->find();

        if ($area) {
            mlog("📍 使用现有默认区域: {$area['area_name']}", "migration.txt");
            return $area;
        }

        // 创建默认区域
        // 对于默认区域，暂不设置user_id，因为它是系统级别的
        $areaId = Db::name('areas')->insertGetId([
            'area_name' => '默认区域',
            'area_code' => 'DEFAULT_AREA',
            'address' => '系统自动创建的默认区域',
            'description' => '为现有设备自动创建的默认区域，可后续修改',
            'status' => 1,
            'create_time' => time()
        ]);

        mlog("✅ 创建默认区域成功: ID={$areaId}", "migration.txt");

        return [
            'area_id' => $areaId,
            'area_name' => '默认区域',
            'area_code' => 'DEFAULT_AREA'
        ];
    }

    /**
     * 为设备创建默认结构
     */
    private static function createDefaultStructureForDevice($device, $defaultArea): array
    {
        $result = [
            'success' => false,
            'buildings' => 0,
            'units' => 0,
            'rooms' => 0,
            'member_bindings' => 0
        ];

        $lockId = $device['lock_id'];
        $lockName = $device['lock_name'] ?? '设备' . $device['lock_sn'];
        $areaId = $defaultArea['area_id'];
        $userId = $device['user_id'];  // 获取设备所有者的user_id

        // 1. 获取该设备的所有授权用户
        $authUsers = Db::name('lockauth')
            ->where('lock_id', $lockId)
            ->whereNull('deleted_at')
            ->column('member_id');

        if (empty($authUsers)) {
            // 没有授权用户，设置为公区设备
            Db::name('lock')->where('lock_id', $lockId)->update([
                'device_type' => 'public',
                'area_id' => $areaId,
                'update_time' => time()
            ]);

            $result['success'] = true;
            return $result;
        }

        // 2. 创建默认楼栋（以设备名称命名）
        $buildingName = "默认楼栋-{$lockName}";
        $buildingCode = "BUILD_" . $device['lock_sn'];

        // 检查是否已存在
        $building = Db::name('buildings')
            ->where('area_id', $areaId)
            ->where('building_code', $buildingCode)
            ->whereNull('deleted_at')
            ->find();

        if (!$building) {
            $buildingId = Db::name('buildings')->insertGetId([
                'user_id' => $userId,  // 设置user_id为设备所有者
                'area_id' => $areaId,
                'building_name' => $buildingName,
                'building_code' => $buildingCode,
                'floors' => 1,
                'unit_count' => 1,
                'description' => "为设备 {$device['lock_sn']} 自动创建",
                'status' => 1,
                'create_time' => time()
            ]);
            $result['buildings'] = 1;
        } else {
            $buildingId = $building['building_id'];
        }

        // 3. 创建默认单元
        $unitName = "默认单元";
        $unitCode = "UNIT_" . $device['lock_sn'];

        $unit = Db::name('units')
            ->where('building_id', $buildingId)
            ->where('unit_code', $unitCode)
            ->whereNull('deleted_at')
            ->find();

        if (!$unit) {
            $unitId = Db::name('units')->insertGetId([
                'user_id' => $userId,  // 设置user_id为设备所有者
                'building_id' => $buildingId,
                'area_id' => $areaId,
                'unit_name' => $unitName,
                'unit_code' => $unitCode,
                'floors' => 1,
                'description' => "为设备 {$device['lock_sn']} 自动创建",
                'status' => 1,
                'create_time' => time()
            ]);
            $result['units'] = 1;
        } else {
            $unitId = $unit['unit_id'];
        }

        // 4. 为每个授权用户创建默认房号并绑定
        foreach ($authUsers as $index => $memberId) {
            $roomNumber = "R" . str_pad($index + 1, 3, '0', STR_PAD_LEFT); // R001, R002...
            $roomCode = "ROOM_" . $device['lock_sn'] . "_" . $memberId;

            // 检查是否已存在
            $room = Db::name('rooms')
                ->where('unit_id', $unitId)
                ->where('room_code', $roomCode)
                ->whereNull('deleted_at')
                ->find();

            if (!$room) {
                // 获取用户信息
                $member = Db::name('member')
                    ->where('member_id', $memberId)
                    ->field('nickname, mobile')
                    ->find();

                $roomId = Db::name('rooms')->insertGetId([
                    'user_id' => $userId,  // 设置user_id为设备所有者
                    'unit_id' => $unitId,
                    'building_id' => $buildingId,
                    'area_id' => $areaId,
                    'room_number' => $roomNumber,
                    'room_code' => $roomCode,
                    'floor' => 1,
                    'room_type' => 'residential',
                    'owner_name' => $member['nickname'] ?? '',
                    'owner_phone' => $member['mobile'] ?? '',
                    'description' => "为用户 {$memberId} 自动创建",
                    'status' => 1,
                    'create_time' => time()
                ]);
                $result['rooms']++;
            } else {
                $roomId = $room['room_id'];
            }

            // 绑定用户到房号
            $binding = Db::name('member_rooms')
                ->where('member_id', $memberId)
                ->where('room_id', $roomId)
                ->whereNull('deleted_at')
                ->find();

            if (!$binding) {
                Db::name('member_rooms')->insert([
                    'member_id' => $memberId,
                    'user_id' => $userId,  // 设置user_id为设备所有者
                    'area_id' => $areaId,  // 添加area_id
                    'building_id' => $buildingId,  // 添加building_id
                    'unit_id' => $unitId,  // 添加unit_id
                    'room_id' => $roomId,
                    'relation_type' => 'owner',
                    'is_primary' => 1,
                    'status' => 1,
                    'create_time' => time()
                ]);
                $result['member_bindings']++;
            }
        }

        // 5. 更新设备配置为单元设备
        Db::name('lock')->where('lock_id', $lockId)->update([
            'device_type' => 'unit',
            'area_id' => $areaId,
            'building_id' => $buildingId,
            'unit_id' => $unitId,
            'update_time' => time()
        ]);

        $result['success'] = true;

        mlog("✅ 设备迁移成功: {$device['lock_sn']} - 用户数: " . count($authUsers), "migration.txt");

        return $result;
    }

    /**
     * 迁移单个设备
     */
    public static function migrateDevice($lockId): array
    {
        try {
            $device = Db::name('lock')
                ->where('lock_id', $lockId)
                ->whereNull('deleted_at')
                ->find();

            if (!$device) {
                return ['success' => false, 'msg' => '设备不存在'];
            }

            if ($device['area_id']) {
                return ['success' => false, 'msg' => '设备已配置区域'];
            }

            // 确保设备有user_id
            if (!$device['user_id']) {
                return ['success' => false, 'msg' => '设备未设置管理员ID，无法迁移'];
            }

            Db::startTrans();

            $defaultArea = self::createDefaultArea();
            $result = self::createDefaultStructureForDevice($device, $defaultArea);

            Db::commit();

            return ['success' => true, 'data' => $result];

        } catch (\Exception $e) {
            Db::rollback();
            return ['success' => false, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 检查迁移状态
     */
    public static function checkMigrationStatus(): array
    {
        $total = Db::name('lock')
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->count();

        $migrated = Db::name('lock')
            ->whereNotNull('area_id')
            ->whereNull('deleted_at')
            ->where('status', 1)
            ->count();

        $notMigrated = $total - $migrated;

        return [
            'total' => $total,
            'migrated' => $migrated,
            'not_migrated' => $notMigrated,
            'progress' => $total > 0 ? round($migrated / $total * 100, 2) : 0
        ];
    }

    /**
     * 修复旧房间的user_id
     * 根据房间所在的单元，从单元的user_id推导出房间的user_id
     */
    public static function fixRoomsUserId(): array
    {
        try {
            // 找出所有user_id为空或0的房间
            $rooms = Db::name('rooms')
                ->where(function($q) {
                    $q->whereNull('user_id')
                      ->whereOr('user_id', 0);
                })
                ->whereNull('deleted_at')
                ->select()
                ->toArray();

            mlog("🔧 找到 " . count($rooms) . " 个需要修复user_id的房间", "migration.txt");

            $fixedCount = 0;
            foreach ($rooms as $room) {
                // 从单元获取user_id
                $unit = Db::name('units')
                    ->where('unit_id', $room['unit_id'])
                    ->whereNull('deleted_at')
                    ->find();

                if ($unit && $unit['user_id']) {
                    Db::name('rooms')
                        ->where('room_id', $room['room_id'])
                        ->update(['user_id' => $unit['user_id'], 'update_time' => time()]);
                    $fixedCount++;
                    mlog("修复房间 {$room['room_id']}: user_id={$unit['user_id']}", "migration.txt");
                } else {
                    mlog("⚠️ 房间 {$room['room_id']} 的单元未找到或无user_id", "migration.txt");
                }
            }

            mlog("✅ 修复完成: 共修复 {$fixedCount} 个房间", "migration.txt");

            return ['success' => true, 'fixed_count' => $fixedCount];
        } catch (\Exception $e) {
            mlog("❌ 修复失败: " . $e->getMessage(), "migration.txt");
            return ['success' => false, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 批量迁移（分批处理，避免超时）
     */
    public static function migrateBatch($batchSize = 50, $offset = 0): array
    {
        try {
            $devices = Db::name('lock')
                ->whereNull('area_id')
                ->whereNull('deleted_at')
                ->where('status', 1)
                ->limit($offset, $batchSize)
                ->select()
                ->toArray();

            if (empty($devices)) {
                return ['success' => true, 'msg' => '没有待迁移的设备', 'has_more' => false];
            }

            $defaultArea = self::createDefaultArea();

            $successCount = 0;
            $errors = [];

            foreach ($devices as $device) {
                try {
                    Db::startTrans();
                    self::createDefaultStructureForDevice($device, $defaultArea);
                    Db::commit();
                    $successCount++;
                } catch (\Exception $e) {
                    Db::rollback();
                    $errors[] = "设备 {$device['lock_sn']}: " . $e->getMessage();
                }
            }

            $hasMore = count($devices) == $batchSize;

            return [
                'success' => true,
                'processed' => count($devices),
                'success_count' => $successCount,
                'errors' => $errors,
                'has_more' => $hasMore,
                'next_offset' => $offset + $batchSize
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'msg' => $e->getMessage()];
        }
    }
}
