<?php
/**
 * 房间绑定控制器
 */

namespace app\api\controller\room;

use app\api\controller\Base;
use app\module\member\memberServer\MemberServer;
use app\module\areaMigration\AreaMigration;
use app\module\code\Code;
use think\facade\Db;

class RoomBind extends Base
{
    /**
     * 获取用户已绑定的房间列表
     */
    public function getMyRooms()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $rooms = Db::name('member_rooms')
                ->alias('mr')
                ->leftJoin('rooms r', 'mr.room_id = r.room_id')
                ->leftJoin('units u', 'mr.unit_id = u.unit_id')
                ->leftJoin('buildings b', 'mr.building_id = b.building_id')
                ->leftJoin('areas a', 'mr.area_id = a.area_id')
                ->where('mr.member_id', $memberId)
                ->where('mr.status', 1)
                ->whereNull('mr.deleted_at')
                ->field('mr.*, r.room_number as room_name, u.unit_name, b.building_name, a.area_name')
                ->order('mr.is_primary', 'desc')
                ->order('mr.create_time', 'desc')
                ->select()
                ->toArray();

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $rooms]));
        } catch (\Exception $e) {
            mlog("获取已绑定房间异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 提交房间绑定申请
     */
    public function applyBind()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $areaId = input('area_id', 0, 'intval');
            $buildingId = input('building_id', 0, 'intval');
            $unitId = input('unit_id', 0, 'intval');
            $roomId = input('room_id', 0, 'intval');
            $lockId = input('lock_id', 0, 'intval');
            $relationType = input('relation_type', 'owner');
            $applicantName = input('applicant_name', '');
            $applicantPhone = input('applicant_phone', '');

            // 验证必填项
            if (!$unitId || !$roomId || !$lockId) {
                return json(Code::CodeErr(1000, '位置信息不完整'));
            }
            if (!$applicantName) {
                return json(Code::CodeErr(1000, '申请人姓名不能为空'));
            }
            if (!$applicantPhone) {
                return json(Code::CodeErr(1000, '联系电话不能为空'));
            }

            // 获取用户基本信息
            $member = Db::name('member')->where('member_id', $memberId)->find();

            // 通过设备查找user_id（用lock_id精确查询）
            $lock = Db::name('lock')
                ->where('lock_id', $lockId)
                ->whereNull('deleted_at')
                ->find();

            mlog("设备查询：lock_id=$lockId, found=" . ($lock ? 'yes' : 'no') . ", user_id={$lock['user_id']}");

            if (!$lock) {
                return json(Code::CodeErr(1000, '未找到对应设备'));
            }

            $userId = $lock['user_id'];  // user_id 已为整数类型

            // 检查房间是否存在（必须属于同一个管理员）
            $room = Db::name('rooms')
                ->where('room_id', $roomId)
                ->where('user_id', $userId)
                ->where('unit_id', $unitId)
                ->whereNull('deleted_at')
                ->find();

            mlog("房间验证：room_id=$roomId, user_id=$userId, unit_id=$unitId, found=" . ($room ? 'yes' : 'no'));
            if (!$room) {
                // 调试：查询房间看是否存在其他user_id的情况
                $allRooms = Db::name('rooms')
                    ->where('room_id', $roomId)
                    ->whereNull('deleted_at')
                    ->select()
                    ->toArray();
                mlog("房间 $roomId 的所有记录: " . json_encode($allRooms, JSON_UNESCAPED_UNICODE));
                return json(Code::CodeErr(1000, '房间不存在或不属于该管理员'));
            }

            // 如果前端传来的 area_id 或 building_id 为 0，从房间数据或设备数据中获取
            if (!$areaId || $areaId == 0) {
                $areaId = $room['area_id'] ?? $lock['area_id'] ?? 0;
                mlog("area_id 从前端为 0，从房间/设备获取: $areaId");
            }
            if (!$buildingId || $buildingId == 0) {
                $buildingId = $room['building_id'] ?? $lock['building_id'] ?? 0;
                mlog("building_id 从前端为 0，从房间/设备获取: $buildingId");
            }

            mlog("最终使用的位置信息: area=$areaId, building=$buildingId, unit=$unitId, room=$roomId");

            // 检查是否已经绑定
            $existBind = Db::name('member_rooms')
                ->where('member_id', $memberId)
                ->where('user_id', $userId)
                ->where('unit_id', $unitId)
                ->where('room_id', $roomId)
                ->whereNull('deleted_at')
                ->find();

            if ($existBind) {
                return json(Code::CodeErr(1000, '该房间已绑定'));
            }

            // 检查是否已有待审核的申请
            $existApplication = Db::name('member_room_applications')
                ->where('member_id', $memberId)
                ->where('user_id', $userId)
                ->where('unit_id', $unitId)
                ->where('room_id', $roomId)
                ->where('status', 0)
                ->whereNull('deleted_at')
                ->find();

            if ($existApplication) {
                return json(Code::CodeErr(1000, '该房间已有待审核的申请'));
            }

            // 检查申请人是否是管理员（通过检查是否有该设备的授权且user_id匹配）
            $isAdmin = Db::name('lock')
                ->where('user_id', $userId)
                ->where('member_id', $memberId)
                ->whereNull('deleted_at')
                ->find();

            Db::startTrans();
            try {
                if ($isAdmin) {
                    // 管理员申请，直接通过
                    mlog("管理员 $memberId 申请房间绑定，直接通过: area=$areaId, building=$buildingId, unit=$unitId, room=$roomId");

                    // 检查是否已绑定
                    $existBind = Db::name('member_rooms')
                        ->where('member_id', $memberId)
                        ->where('user_id', $userId)
                        ->where('area_id', $areaId)
                        ->where('building_id', $buildingId)
                        ->where('unit_id', $unitId)
                        ->where('room_id', $roomId)
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$existBind) {
                        // 直接创建绑定关系
                        Db::name('member_rooms')->insert([
                            'member_id' => $memberId,
                            'user_id' => $userId,
                            'area_id' => $areaId,
                            'building_id' => $buildingId,
                            'unit_id' => $unitId,
                            'room_id' => $roomId,
                            'relation_type' => $relationType,
                            'is_primary' => 0,
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);

                        // 授予公区和单元设备钥匙
                        $this->grantKeysForRoom($memberId, $userId, $areaId, $buildingId, $unitId);
                    }

                    // 创建申请记录（状态为已通过）
                    $applicationId = Db::name('member_room_applications')->insertGetId([
                        'member_id' => $memberId,
                        'user_id' => $userId,
                        'area_id' => $areaId,
                        'building_id' => $buildingId,
                        'unit_id' => $unitId,
                        'room_id' => $roomId,
                        'room_number' => $room['room_number'],
                        'relation_type' => $relationType,
                        'applicant_name' => $applicantName,
                        'applicant_phone' => $applicantPhone,
                        'status' => 1,  // 直接通过
                        'audit_time' => time(),
                        'audit_user_id' => 0,  // 系统自动审核
                        'audit_remark' => '管理员申请，自动通过',
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);

                    Db::commit();

                    return json(Code::CodeOk([
                        'msg' => '申请已自动通过',
                        'data' => ['application_id' => $applicationId, 'auto_approved' => true]
                    ]));

                } else {
                    // 普通用户申请，需要审核
                    $applicationId = Db::name('member_room_applications')->insertGetId([
                        'member_id' => $memberId,
                        'user_id' => $userId,
                        'area_id' => $areaId,
                        'building_id' => $buildingId,
                        'unit_id' => $unitId,
                        'room_id' => $roomId,
                        'room_number' => $room['room_number'],
                        'relation_type' => $relationType,
                        'applicant_name' => $applicantName,
                        'applicant_phone' => $applicantPhone,
                        'status' => 0,
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);

                    mlog("用户 $memberId 提交房间绑定申请: application_id=$applicationId");

                    // 推送通知给管理员
                    $this->notifyAdmin($userId, $applicationId, $memberName, $room['room_number']);

                    Db::commit();

                    return json(Code::CodeOk([
                        'msg' => '申请提交成功，请等待管理员审核',
                        'data' => ['application_id' => $applicationId, 'auto_approved' => false]
                    ]));
                }
            } catch (\Exception $e) {
                Db::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            mlog("提交房间绑定申请异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '提交失败'));
        }
    }

    /**
     * 授予房间相关的设备钥匙
     */
    private function grantKeysForRoom($memberId, $userId, $areaId, $buildingId, $unitId)
    {
        try {
            // 授予公区设备钥匙
            $publicLocks = Db::name('lock')
                ->where('user_id', $userId)
                ->where('area_id', $areaId)
                ->where('device_type', 'public')
                ->whereNull('deleted_at')
                ->select()
                ->toArray();

            foreach ($publicLocks as $lock) {
                $existAuth = Db::name('lockauth')
                    ->where('member_id', $memberId)
                    ->where('lock_id', $lock['lock_id'])
                    ->whereNull('deleted_at')
                    ->find();

                if (!$existAuth) {
                    Db::name('lockauth')->insert([
                        'member_id' => $memberId,
                        'lock_id' => $lock['lock_id'],
                        'auth_status' => 1,
                        'create_time' => time(),
                    ]);
                    mlog("授予公区设备钥匙: member_id=$memberId, lock_id={$lock['lock_id']}");
                }
            }

            // 授予单元设备钥匙
            $unitLocks = Db::name('lock')
                ->where('user_id', $userId)
                ->where('area_id', $areaId)
                ->where('building_id', $buildingId)
                ->where('unit_id', $unitId)
                ->where('device_type', 'unit')
                ->whereNull('deleted_at')
                ->select()
                ->toArray();

            foreach ($unitLocks as $lock) {
                $existAuth = Db::name('lockauth')
                    ->where('member_id', $memberId)
                    ->where('lock_id', $lock['lock_id'])
                    ->whereNull('deleted_at')
                    ->find();

                if (!$existAuth) {
                    Db::name('lockauth')->insert([
                        'member_id' => $memberId,
                        'lock_id' => $lock['lock_id'],
                        'auth_status' => 1,
                        'create_time' => time(),
                    ]);
                    mlog("授予单元设备钥匙: member_id=$memberId, lock_id={$lock['lock_id']}");
                }
            }
        } catch (\Exception $e) {
            mlog("授予设备钥匙异常: " . $e->getMessage());
        }
    }

    /**
     * 推送通知给管理员
     */
    private function notifyAdmin($userId, $applicationId, $memberName, $roomNumber)
    {
        try {
            // TODO: 实现管理员推送通知
            // 当前简化版本：仅记录日志
            mlog("新房间绑定申请: user_id=$userId, application_id=$applicationId, member_name=$memberName, room=$roomNumber");

            // 未来可以通过以下方式推送：
            // 1. 查询该 user_id 对应的管理员member_id
            // 2. 查询该 member_id 的推送token
            // 3. 发送推送通知

        } catch (\Exception $e) {
            mlog("推送给管理员异常: " . $e->getMessage());
        }
    }

    /**
     * 获取我的钥匙列表（包含区域/楼栋/单元信息）
     */
    public function getMyKeys()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            mlog("查询用户钥匙: member_id=$memberId");

            // 先查询基础钥匙数量（使用auth_status字段，与首页保持一致）
            $totalAuth = Db::name('lockauth')
                ->where('member_id', $memberId)
                ->where('auth_status', 1)
                ->whereNull('deleted_at')
                ->count();

            mlog("用户总钥匙数量: $totalAuth");

            // 构建查询（使用auth_status字段，与首页保持一致）
            $query = Db::name('lockauth')
                ->alias('la')
                ->leftJoin('lock l', 'la.lock_id = l.lock_id')
                ->leftJoin('areas a', 'l.area_id = a.area_id')
                ->leftJoin('buildings b', 'l.building_id = b.building_id')
                ->leftJoin('units u', 'l.unit_id = u.unit_id')
                ->where('la.member_id', $memberId)
                ->where('la.auth_status', 1)
                ->whereNull('la.deleted_at')
                ->whereNull('l.deleted_at');

            // 获取SQL用于调试
            $sql = $query->fetchSql(true)
                ->field('l.lock_id, l.lock_name as device_name, l.lock_sn, l.user_id, l.area_id, l.building_id, l.unit_id,
                         a.area_name, b.building_name, u.unit_name')
                ->select();

            mlog("查询SQL: " . $sql);

            // 实际查询
            $keys = Db::name('lockauth')
                ->alias('la')
                ->leftJoin('lock l', 'la.lock_id = l.lock_id')
                ->leftJoin('areas a', 'l.area_id = a.area_id')
                ->leftJoin('buildings b', 'l.building_id = b.building_id')
                ->leftJoin('units u', 'l.unit_id = u.unit_id')
                ->where('la.member_id', $memberId)
                ->where('la.auth_status', 1)
                ->whereNull('la.deleted_at')
                ->whereNull('l.deleted_at')
                ->field('l.lock_id, l.lock_name as device_name, l.lock_sn, l.user_id, l.area_id, l.building_id, l.unit_id,
                         a.area_name, b.building_name, u.unit_name')
                ->group('l.lock_id')
                ->order('l.area_id', 'desc')
                ->select()
                ->toArray();

            mlog("查询到钥匙数量: " . count($keys));
            if (count($keys) > 0) {
                mlog("第一个钥匙示例: " . json_encode($keys[0], JSON_UNESCAPED_UNICODE));
            }

            // 分类：有完整区域信息的和没有的
            $keysWithArea = [];
            $keysWithoutArea = [];

            foreach ($keys as $key) {
                if (!empty($key['area_id']) && !empty($key['building_id']) && !empty($key['unit_id'])) {
                    $keysWithArea[] = $key;
                } else {
                    $keysWithoutArea[] = $key;
                }
            }

            mlog("有区域信息的钥匙: " . count($keysWithArea) . ", 无区域信息的钥匙: " . count($keysWithoutArea));

            return json(Code::CodeOk([
                'msg' => '获取成功',
                'data' => [
                    'keys_with_area' => $keysWithArea,
                    'keys_without_area' => $keysWithoutArea,
                    'all_keys' => $keys,
                    'total_auth' => $totalAuth,
                ]
            ]));

        } catch (\Exception $e) {
            mlog("获取钥匙列表异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败: ' . $e->getMessage()));
        }
    }

    /**
     * 获取区域列表
     */
    public function getAreas()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $areas = Db::name('areas')
                ->alias('a')
                ->leftJoin('lock l', 'a.area_id = l.area_id')
                ->leftJoin('lockauth la', 'l.lock_id = la.lock_id')
                ->where('la.member_id', $memberId)
                ->whereNull('a.deleted_at')
                ->field('a.area_id as id, a.area_name as name')
                ->group('a.area_id')
                ->select()
                ->toArray();

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $areas]));

        } catch (\Exception $e) {
            mlog("获取区域列表异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 获取楼栋列表
     * 支持两种模式：
     * 1. 传 lock_id：返回该设备管理员在该区域下的楼栋
     * 2. 不传 lock_id：返回该区域下所有楼栋
     */
    public function getBuildings()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $areaId = $this->_data['area_id'] ?? 0;
            if (!$areaId) {
                return json(Code::CodeErr(1000, '参数错误'));
            }

            $lockId = $this->_data['lock_id'] ?? 0;
            mlog("getBuildings: 接收参数 area_id=$areaId, lock_id=$lockId");

            $query = Db::name('buildings')
                ->where('area_id', $areaId)
                ->whereNull('deleted_at');

            // 如果传了 lock_id，则限定为该设备管理员的楼栋
            if ($lockId > 0) {
                $lock = Db::name('lock')
                    ->where('lock_id', $lockId)
                    ->whereNull('deleted_at')
                    ->find();

                if (!$lock) {
                    return json(Code::CodeErr(1000, '未找到对应设备'));
                }

                $userId = $lock['user_id'];
                mlog("getBuildings: lock_id=$lockId, user_id=$userId, area_id=$areaId");

                // 查询该管理员在该区域下有哪些楼栋（通过rooms表关联）
                $query = Db::name('buildings')
                    ->alias('b')
                    ->leftJoin('rooms r', 'b.building_id = r.building_id')
                    ->where('b.area_id', $areaId)
                    ->where('r.user_id', $userId)
                    ->whereNull('b.deleted_at')
                    ->whereNull('r.deleted_at')
                    ->group('b.building_id');
            }

            $buildings = $query
                ->field('building_id as id, building_name as name')
                ->select()
                ->toArray();

            mlog("getBuildings: 查询到 " . count($buildings) . " 个楼栋");

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $buildings]));

        } catch (\Exception $e) {
            mlog("获取楼栋列表异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 获取单元列表
     * 支持两种模式：
     * 1. 传 lock_id：返回该设备管理员在该楼栋下的单元
     * 2. 不传 lock_id：返回该楼栋下所有单元
     */
    public function getUnits()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $buildingId = $this->_data['building_id'] ?? 0;
            if (!$buildingId) {
                return json(Code::CodeErr(1000, '参数错误'));
            }

            $lockId = $this->_data['lock_id'] ?? 0;
            mlog("getUnits: 接收参数 building_id=$buildingId, lock_id=$lockId");

            $query = Db::name('units')
                ->where('building_id', $buildingId)
                ->whereNull('deleted_at');

            // 如果传了 lock_id，则限定为该设备管理员的单元
            if ($lockId > 0) {
                $lock = Db::name('lock')
                    ->where('lock_id', $lockId)
                    ->whereNull('deleted_at')
                    ->find();

                if (!$lock) {
                    return json(Code::CodeErr(1000, '未找到对应设备'));
                }

                $userId = $lock['user_id'];
                mlog("getUnits: lock_id=$lockId, user_id=$userId, building_id=$buildingId");

                // 查询该管理员在该楼栋下有哪些单元（通过rooms表关联）
                $query = Db::name('units')
                    ->alias('u')
                    ->leftJoin('rooms r', 'u.unit_id = r.unit_id')
                    ->where('u.building_id', $buildingId)
                    ->where('r.user_id', $userId)
                    ->whereNull('u.deleted_at')
                    ->whereNull('r.deleted_at')
                    ->group('u.unit_id');
            }

            $units = $query
                ->field('unit_id as id, unit_name as name')
                ->select()
                ->toArray();

            mlog("getUnits: 查询到 " . count($units) . " 个单元");

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $units]));

        } catch (\Exception $e) {
            mlog("获取单元列表异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 获取房间列表
     * 参数：lock_id（必须）, unit_id（公共门时必须）
     * 逻辑：
     * 1. 通过 lock_id 查询设备，获取 user_id 和设备类型
     * 2. 单元门（lock.unit_id > 0）：直接返回该单元下该管理员的房间
     * 3. 公共门（lock.unit_id = 0）：返回前端选择的 unit_id 下该管理员的房间
     */
    public function getRooms()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $lockId = $this->_data['lock_id'] ?? 0;
            $unitId = $this->_data['unit_id'] ?? 0;

            mlog("getRooms: 接收参数 lock_id=$lockId, unit_id=$unitId");

            if (!$lockId) {
                return json(Code::CodeErr(1000, '缺少设备标识'));
            }

            // 查询设备信息
            $lock = Db::name('lock')
                ->where('lock_id', $lockId)
                ->whereNull('deleted_at')
                ->find();

            if (!$lock) {
                mlog("getRooms: 未找到对应设备");
                return json(Code::CodeErr(1000, '未找到对应设备'));
            }

            $userId = $lock['user_id'];
            $lockUnitId = $lock['unit_id'] ?? 0;
            mlog("getRooms: 设备信息 lock_id=$lockId, user_id=$userId, lock.unit_id=$lockUnitId");

            // 确定要查询的 unit_id
            $queryUnitId = 0;
            if ($lockUnitId > 0) {
                // 单元门：使用设备的 unit_id
                $queryUnitId = $lockUnitId;
                mlog("getRooms: 单元门，使用设备的unit_id=$queryUnitId");
            } else {
                // 公共门：使用前端传入的 unit_id
                if (!$unitId) {
                    return json(Code::CodeErr(1000, '请选择单元'));
                }
                $queryUnitId = $unitId;
                mlog("getRooms: 公共门，使用前端传入unit_id=$queryUnitId");
            }

            // 检查设备是否绑定了完整的区域信息
            $lockAreaId = $lock['area_id'] ?? 0;
            $lockBuildingId = $lock['building_id'] ?? 0;
            if (!$lockAreaId || !$lockBuildingId) {
                mlog("getRooms: 设备未绑定完整区域信息 area_id=$lockAreaId, building_id=$lockBuildingId");
                return json(Code::CodeErr(1000, '该设备未绑定区域信息，无法进行房间绑定申请'));
            }

            // 查询该管理员在该单元下的房间（严格限制user_id）
            $rooms = Db::name('rooms')
                ->alias('r')
                ->leftJoin('units u', 'r.unit_id = u.unit_id')
                ->leftJoin('buildings b', 'r.building_id = b.building_id')
                ->leftJoin('areas a', 'r.area_id = a.area_id')
                ->where('r.unit_id', $queryUnitId)
                ->where('r.user_id', $userId)
                ->whereNull('r.deleted_at')
                ->field('r.room_id, r.room_number, r.area_id, r.building_id, r.unit_id, a.area_name, b.building_name, u.unit_name')
                ->order('r.room_number', 'asc')
                ->select()
                ->toArray();

            // 调试信息：查询该单元所有房间
            $allRooms = Db::name('rooms')
                ->where('unit_id', $queryUnitId)
                ->whereNull('deleted_at')
                ->field('room_id, room_number, user_id')
                ->select()
                ->toArray();
            mlog("getRooms: unit_id=$queryUnitId 的所有房间: " . json_encode($allRooms, JSON_UNESCAPED_UNICODE));
            mlog("getRooms: 查询到 " . count($rooms) . " 个属于user_id=$userId的房间");

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $rooms]));

        } catch (\Exception $e) {
            mlog("获取房间列表异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 通过门锁二维码获取区域信息
     */
    public function getAreaInfoByLockQr()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $qrCode = input('qr_code', '');
            if (!$qrCode) {
                return json(Code::CodeErr(1000, '参数错误'));
            }

            // 解码各种编码方式（URL编码、HTML实体编码等）
            $qrCode = urldecode($qrCode);
            $qrCode = htmlspecialchars_decode($qrCode);
            $qrCode = html_entity_decode($qrCode, ENT_QUOTES, 'UTF-8');
            mlog("二维码原始: " . $qrCode);

            // 二维码格式可能是: URL 或 JSON 或 lock_num 或 lock_id
            $lockId = null;
            $lockSn = null;

            // 方案 1: 解析 URL 格式 - 包含 http/https 或参数标记
            if (preg_match('/(?:https?:\/\/|\?|&)lock_id\s*=\s*(\d+)/i', $qrCode, $matches)) {
                // URL 格式: https://your-domain.example/minilock?user_id=1&lock_id=7815
                // 或: ?lock_id=7815&user_id=1
                $lockId = (int)$matches[1];
                mlog("URL格式解析: lock_id=" . $lockId);
            }

            // 方案 2: 解析 JSON 格式
            if (!$lockId && !$lockSn) {
                $qrData = json_decode($qrCode, true);
                if (is_array($qrData)) {
                    if (isset($qrData['lock_id'])) {
                        $lockId = (int)$qrData['lock_id'];
                        mlog("JSON格式解析: lock_id=" . $lockId);
                    } elseif (isset($qrData['lock_num'])) {
                        $lockSn = $qrData['lock_num'];
                        mlog("JSON格式解析: lock_sn=" . $lockSn);
                    } elseif (isset($qrData['sn'])) {
                        $lockSn = $qrData['sn'];
                        mlog("JSON格式解析: sn=" . $lockSn);
                    }
                }
            }

            // 方案 3: 用正则匹配 lock_num 或 lock_sn 的值
            if (!$lockId && !$lockSn) {
                if (preg_match('/lock_num[:"]?\s*[:"]?([\w\-]+)/i', $qrCode, $matches)) {
                    $lockSn = $matches[1];
                    mlog("正则匹配 lock_num: " . $lockSn);
                }
            }

            // 方案 4: 直接是纯数字（lock_id）或字符串（lock_sn）
            if (!$lockId && !$lockSn) {
                if (is_numeric($qrCode) && (int)$qrCode > 0) {
                    $lockId = (int)$qrCode;
                    mlog("纯数字解析: lock_id=" . $lockId);
                } else if (!empty($qrCode) && strlen($qrCode) > 0) {
                    // 移除可能的空格和特殊字符，并转为大写（W70等设备序列号统一用大写）
                    $lockSn = strtoupper(trim($qrCode));
                    mlog("字符串解析: lock_sn=" . $lockSn);
                }
            }

            // 如果解析到的是lock_sn，也统一转大写
            if ($lockSn) {
                $lockSn = strtoupper(trim($lockSn));
                mlog("lock_sn标准化: " . $lockSn);
            }

            // 查询设备，并联表获取区域、楼栋、单元名称
            $lockQuery = Db::name('lock')
                ->alias('l')
                ->leftJoin('areas a', 'l.area_id = a.area_id')
                ->leftJoin('buildings b', 'l.building_id = b.building_id')
                ->leftJoin('units u', 'l.unit_id = u.unit_id')
                ->whereNull('l.deleted_at');

            if ($lockId) {
                $lockQuery->where('l.lock_id', $lockId);
            } elseif ($lockSn) {
                $lockQuery->where('l.lock_sn', $lockSn);
            } else {
                mlog("错误: 无法解析二维码");
                return json(Code::CodeErr(1000, '二维码格式不正常'));
            }

            $lock = $lockQuery->field('l.*, a.area_name, b.building_name, u.unit_name')->find();

            if (!$lock) {
                return json(Code::CodeErr(1000, '未找到设备'));
            }

            mlog("设备信息: lock_id={$lock['lock_id']}, area={$lock['area_id']}/{$lock['area_name']}, building={$lock['building_id']}/{$lock['building_name']}, unit={$lock['unit_id']}/{$lock['unit_name']}");

            // 检查设备是否绑定了完整的区域信息（至少要有区域和楼栋）
            $lockAreaId = $lock['area_id'] ?? 0;
            $lockBuildingId = $lock['building_id'] ?? 0;
            if (!$lockAreaId || !$lockBuildingId) {
                mlog("扫码失败: 设备未绑定完整区域信息 area_id=$lockAreaId, building_id=$lockBuildingId");
                return json(Code::CodeErr(1000, '该设备未绑定区域信息，无法进行房间绑定申请。请联系管理员配置设备区域信息。'));
            }

            return json(Code::CodeOk([
                'msg' => '获取成功',
                'data' => [
                    'area_id' => $lock['area_id'] ?? 0,
                    'area_name' => $lock['area_name'] ?? '',
                    'building_id' => $lock['building_id'] ?? 0,
                    'building_name' => $lock['building_name'] ?? '',
                    'unit_id' => $lock['unit_id'] ?? 0,
                    'unit_name' => $lock['unit_name'] ?? '',
                    'lock_id' => $lock['lock_id'],
                    'lock_name' => $lock['lock_name'],
                ]
            ]));

        } catch (\Exception $e) {
            mlog("二维码解析异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '解析失败'));
        }
    }

    /**
     * 获取我的申请记录
     */
    public function getMyApplications()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $applications = Db::name('member_room_applications')
                ->alias('mra')
                ->leftJoin('areas a', 'mra.area_id = a.area_id')
                ->leftJoin('buildings b', 'mra.building_id = b.building_id')
                ->leftJoin('units u', 'mra.unit_id = u.unit_id')
                ->leftJoin('rooms r', 'mra.room_id = r.room_id')
                ->where('mra.member_id', $memberId)
                ->whereNull('mra.deleted_at')
                ->field('mra.*, a.area_name, b.building_name, u.unit_name, r.room_number as room_name')
                ->order('mra.create_time', 'desc')
                ->select()
                ->toArray();

            return json(Code::CodeOk(['msg' => '获取成功', 'data' => $applications]));
        } catch (\Exception $e) {
            mlog("获取申请记录异常: " . $e->getMessage());
            return json(Code::CodeErr(1000, '获取失败'));
        }
    }
}
