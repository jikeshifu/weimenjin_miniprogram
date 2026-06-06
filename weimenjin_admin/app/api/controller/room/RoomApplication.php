<?php
/**
 * 房间绑定申请管理（API端-供管理员APP使用）
 */

namespace app\api\controller\room;

use app\api\controller\Base;
use app\module\member\memberServer\MemberServer;
use app\module\code\Code;
use think\facade\Db;

class RoomApplication extends Base
{
    /**
     * 获取待审核申请列表（管理员）
     */
    public function getPendingList()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            // TODO: 实现管理员权限验证
            // 当前简化版本：允许所有用户查看申请列表
            $admin = [
                'user_id' => 0,  // 临时：0表示查看所有
                'role' => 1      // 临时：1表示超级管理员
            ];



            $page = input('page', 1, 'intval');
            $limit = input('limit', 20, 'intval');

            // 构建查询
            $query = Db::name('member_room_applications')
                ->alias('mra')
                ->leftJoin('member m', 'mra.member_id = m.member_id')
                ->leftJoin('areas a', 'mra.area_id = a.area_id')
                ->leftJoin('buildings b', 'mra.building_id = b.building_id')
                ->leftJoin('units u', 'mra.unit_id = u.unit_id')
                ->where('mra.status', 0)  // 只查待审核的
                ->whereNull('mra.deleted_at');

            // 非超级管理员只能看到自己管理的申请
            if ($admin['role'] != 1) {
                $query->where('mra.user_id', $admin['user_id']);
            }

            $total = $query->count();

            $list = $query->field('mra.*, a.area_name, b.building_name, u.unit_name')
                ->order('mra.create_time', 'desc')
                ->limit(($page - 1) * $limit, $limit)
                ->select()
                ->toArray();

            return json(Code::CodeOk([
                'msg' => '获取成功',
                'data' => [
                    'list' => $list,
                    'total' => $total,
                    'page' => $page,
                    'limit' => $limit,
                ]
            ]));

        } catch (\Exception $e) {

            return json(Code::CodeErr(1000, '获取失败'));
        }
    }

    /**
     * 审核申请（管理员）
     */
    public function audit()
    {
        try {
            $res = MemberServer::Uid();
            $memberId = $res['uid'] ?? 0;
            if (!$memberId) {
                return json(Code::CodeErr(1000, '请先登录'));
            }

            $applicationId = input('application_id', 0, 'intval');
            $status = input('status', 0, 'intval'); // 1=通过，2=拒绝
            $auditRemark = input('audit_remark', '');

            if (!$applicationId || !in_array($status, [1, 2])) {
                return json(Code::CodeErr(1000, '参数错误'));
            }

            // TODO: 实现管理员权限验证
            // 当前简化版本：允许所有用户审核申请
            $admin = [
                'user_id' => 0,  // 临时：0表示系统自动审核
                'role' => 1      // 临时：1表示超级管理员
            ];



            Db::startTrans();
            try {
                // 查询申请信息
                $query = Db::name('member_room_applications')
                    ->where('application_id', $applicationId)
                    ->whereNull('deleted_at');

                // 非超级管理员只能审核自己管理的申请
                if ($admin['role'] != 1) {
                    $query->where('user_id', $admin['user_id']);
                }

                $application = $query->find();

                if (!$application) {
                    throw new \Exception('申请不存在或无权限');
                }

                if ($application['status'] != 0) {
                    throw new \Exception('该申请已处理');
                }

                // 更新申请状态
                Db::name('member_room_applications')->where('application_id', $applicationId)->update([
                    'status' => $status,
                    'audit_time' => time(),
                    'audit_user_id' => $admin['user_id'],
                    'audit_remark' => $auditRemark,
                    'update_time' => time(),
                ]);

                // 如果审核通过，创建绑定关系和授权
                if ($status == 1) {
                    // 检查是否已绑定
                    $existBind = Db::name('member_rooms')
                        ->where('member_id', $application['member_id'])
                        ->where('user_id', $application['user_id'])
                        ->where('area_id', $application['area_id'])
                        ->where('building_id', $application['building_id'])
                        ->where('unit_id', $application['unit_id'])
                        ->where('room_id', $application['room_id'])
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$existBind) {
                        // 创建房间绑定记录
                        Db::name('member_rooms')->insert([
                            'member_id' => $application['member_id'],
                            'user_id' => $application['user_id'],
                            'area_id' => $application['area_id'],
                            'building_id' => $application['building_id'],
                            'unit_id' => $application['unit_id'],
                            'room_id' => $application['room_id'],
                            'relation_type' => $application['relation_type'],
                            'is_primary' => 0,
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);
                    }

                    // 授予公区设备钥匙
                    $this->grantAreaKeys($application);

                    // 授予单元设备钥匙
                    $this->grantUnitKeys($application);
                }

                Db::commit();



                // 推送审核结果给用户
                $this->notifyUser($application, $status, $auditRemark);

                return json(Code::CodeOk(['msg' => '审核完成']));

            } catch (\Exception $e) {
                Db::rollback();
                throw $e;
            }

        } catch (\Exception $e) {

            return json(Code::CodeErr(1000, $e->getMessage()));
        }
    }

    /**
     * 授予公区设备钥匙
     */
    private function grantAreaKeys($application)
    {
        $publicLocks = Db::name('lock')
            ->where('user_id', $application['user_id'])
            ->where('area_id', $application['area_id'])
            ->where('device_type', 'public')
            ->whereNull('deleted_at')
            ->select()
            ->toArray();

        foreach ($publicLocks as $lock) {
            $existAuth = Db::name('lockauth')
                ->where('member_id', $application['member_id'])
                ->where('lock_id', $lock['lock_id'])
                ->whereNull('deleted_at')
                ->find();

            if (!$existAuth) {
                Db::name('lockauth')->insert([
                    'member_id' => $application['member_id'],
                    'lock_id' => $lock['lock_id'],
                    'auth_status' => 1,
                    'create_time' => time(),
                ]);

            }
        }
    }

    /**
     * 授予单元设备钥匙
     */
    private function grantUnitKeys($application)
    {
        $unitLocks = Db::name('lock')
            ->where('user_id', $application['user_id'])
            ->where('area_id', $application['area_id'])
            ->where('building_id', $application['building_id'])
            ->where('unit_id', $application['unit_id'])
            ->where('device_type', 'unit')
            ->whereNull('deleted_at')
            ->select()
            ->toArray();

        foreach ($unitLocks as $lock) {
            $existAuth = Db::name('lockauth')
                ->where('member_id', $application['member_id'])
                ->where('lock_id', $lock['lock_id'])
                ->whereNull('deleted_at')
                ->find();

            if (!$existAuth) {
                Db::name('lockauth')->insert([
                    'member_id' => $application['member_id'],
                    'lock_id' => $lock['lock_id'],
                    'auth_status' => 1,
                    'create_time' => time(),
                ]);

            }
        }
    }

    /**
     * 推送审核结果给用户
     */
    private function notifyUser($application, $status, $auditRemark)
    {
        try {
            $userTokens = Db::name('member_push_tokens')
                ->where('member_id', $application['member_id'])
                ->where('status', 1)
                ->select()
                ->toArray();

            if (empty($userTokens)) {
                return;
            }

            $statusText = $status == 1 ? '已通过' : '已拒绝';
            $content = "您的房间绑定申请{$statusText}";
            if ($auditRemark) {
                $content .= "，备注：{$auditRemark}";
            }

            $pushPayload = [
                'type' => 'room_application_result',
                'title' => '房间绑定审核通知',
                'content' => $content,
                'data' => [
                    'route' => '/room/bind',
                    'arguments' => [
                        'applicationId' => $application['application_id'],
                        'status' => $status,
                    ],
                ],
            ];

            foreach ($userTokens as $token) {

                // TODO: 实际调用推送API
            }
        } catch (\Exception $e) {

        }
    }
}
