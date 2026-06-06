<?php
/**
 * 房间绑定申请管理
 */

namespace app\admin\controller;

use think\facade\Db;

class RoomApplication extends Base
{
    /**
     * 申请列表页面
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $page = input('page', 1, 'intval');
            $limit = input('limit', 20, 'intval');
            $status = input('status', '');
            $areaId = input('area_id', 0, 'intval');
            $buildingId = input('building_id', 0, 'intval');
            $unitId = input('unit_id', 0, 'intval');
            $roomId = input('room_id', 0, 'intval');
            $hasKeys = input('has_keys', '');
            $keyword = input('keyword', '');

            $userId = session('admin.userid');
            $role = session('admin.role');

            mlog("====== 房间申请列表查询开始 ======");
            mlog("查询参数: page={$page}, limit={$limit}, status={$status}, area_id={$areaId}, building_id={$buildingId}, unit_id={$unitId}, room_id={$roomId}, has_keys={$hasKeys}, keyword={$keyword}");
            mlog("当前管理员: user_id={$userId}, role={$role}");

            // 构建查询
            $query = Db::name('member_room_applications')
                ->alias('mra')
                ->leftJoin('member m', 'mra.member_id = m.member_id')
                ->leftJoin('areas a', 'mra.area_id = a.area_id')
                ->leftJoin('buildings b', 'mra.building_id = b.building_id')
                ->leftJoin('units u', 'mra.unit_id = u.unit_id')
                ->whereNull('mra.deleted_at');

            // 非超级管理员只能看到自己管理的申请
            if ($role != 1) {
                mlog("非超级管理员，只查询user_id={$userId}的数据");
                $query->where('mra.user_id', $userId);
            } else {
                mlog("超级管理员，查询所有数据");
            }

            // 状态筛选
            if ($status !== '') {
                mlog("添加状态筛选: status={$status}");
                $query->where('mra.status', $status);
            }

            // 区域筛选
            if ($areaId > 0) {
                mlog("添加区域筛选: area_id={$areaId}");
                $query->where('mra.area_id', $areaId);
            }

            // 楼栋筛选
            if ($buildingId > 0) {
                mlog("添加楼栋筛选: building_id={$buildingId}");
                $query->where('mra.building_id', $buildingId);
            }

            // 单元筛选
            if ($unitId > 0) {
                mlog("添加单元筛选: unit_id={$unitId}");
                $query->where('mra.unit_id', $unitId);
            }

            // 房间筛选
            if ($roomId > 0) {
                mlog("添加房间筛选: room_id={$roomId}");
                $query->where('mra.room_id', $roomId);
            }

            // 用户钥匙状态筛选
            if ($hasKeys !== '') {
                mlog("添加用户钥匙筛选: has_keys={$hasKeys}");
                if ($hasKeys == '1') {
                    // 已有钥匙的用户
                    $query->where('m.member_id', 'in', function($subQuery){
                        $subQuery->name('lockauth')
                            ->where('auth_status', 1)
                            ->whereNull('deleted_at')
                            ->field('DISTINCT member_id');
                    });
                } else if ($hasKeys == '0') {
                    // 未激活用户（status=0）
                    $query->where('m.status', 0);
                }
            }

            // 关键词搜索
            if ($keyword) {
                mlog("添加关键词搜索: keyword={$keyword}");
                $query->where(function($q) use ($keyword) {
                    $q->whereOr('mra.applicant_name', 'like', "%{$keyword}%")
                      ->whereOr('mra.applicant_phone', 'like', "%{$keyword}%")
                      ->whereOr('mra.room_number', 'like', "%{$keyword}%");
                });
            }

            // 记录SQL语句
            $sql = $query->fetchSql(true)->field('mra.*, a.area_name, b.building_name, u.unit_name')
                ->order('mra.create_time', 'desc')
                ->limit(($page - 1) * $limit, $limit)
                ->select();
            mlog("查询SQL: " . $sql);

            // 分页数据（先查询数据）
            $list = $query->fetchSql(false)->field('mra.*, a.area_name, b.building_name, u.unit_name')
                ->order('mra.create_time', 'desc')
                ->limit(($page - 1) * $limit, $limit)
                ->select()
                ->toArray();

            mlog("查询到的数据条数: " . count($list));
            if (count($list) > 0) {
                mlog("第一条数据: " . json_encode($list[0], JSON_UNESCAPED_UNICODE));
            }

            // 总数（重新构建查询）
            $countQuery = Db::name('member_room_applications')
                ->alias('mra')
                ->leftJoin('member m', 'mra.member_id = m.member_id')
                ->leftJoin('areas a', 'mra.area_id = a.area_id')
                ->leftJoin('buildings b', 'mra.building_id = b.building_id')
                ->leftJoin('units u', 'mra.unit_id = u.unit_id')
                ->whereNull('mra.deleted_at');

            // 非超级管理员只能看到自己管理的申请
            if ($role != 1) {
                $countQuery->where('mra.user_id', $userId);
            }

            // 状态筛选
            if ($status !== '') {
                $countQuery->where('mra.status', $status);
            }

            // 区域筛选
            if ($areaId > 0) {
                $countQuery->where('mra.area_id', $areaId);
            }

            // 用户钥匙状态筛选
            if ($hasKeys !== '') {
                if ($hasKeys == '1') {
                    $countQuery->where('m.member_id', 'in', function($subQuery){
                        $subQuery->name('lockauth')
                            ->where('auth_status', 1)
                            ->whereNull('deleted_at')
                            ->field('DISTINCT member_id');
                    });
                } else if ($hasKeys == '0') {
                    $countQuery->where('m.status', 0);
                }
            }

            // 关键词搜索
            if ($keyword) {
                $countQuery->where(function($q) use ($keyword) {
                    $q->whereOr('mra.applicant_name', 'like', "%{$keyword}%")
                      ->whereOr('mra.applicant_phone', 'like', "%{$keyword}%")
                      ->whereOr('mra.room_number', 'like', "%{$keyword}%");
                });
            }

            $total = $countQuery->count();
            mlog("总数: {$total}");

            // 直接查询数据库验证数据是否存在
            $dbCheck = Db::name('member_room_applications')->count();
            mlog("数据库member_room_applications表总记录数: {$dbCheck}");

            $result = ['code' => 0, 'msg' => '', 'count' => $total, 'data' => $list];
            mlog("返回结果: code=0, count={$total}, data_count=" . count($list));
            mlog("====== 房间申请列表查询结束 ======\n");

            return json($result);
        }

        mlog("显示房间申请列表页面");
        return $this->display('index');
    }

    /**
     * 审核详情页面
     */
    public function detail()
    {
        $applicationId = input('application_id', 0, 'intval');

        mlog("====== 查看申请详情 ======");
        mlog("申请ID: {$applicationId}");

        if (!$applicationId) {
            mlog("错误: 缺少application_id参数");
            $this->error('参数错误');
        }

        $userId = session('admin.userid');
        $role = session('admin.role');

        mlog("当前管理员: user_id={$userId}, role={$role}");

        try {
            $query = Db::name('member_room_applications')
                ->alias('mra')
                ->leftJoin('areas a', 'mra.area_id = a.area_id')
                ->leftJoin('buildings b', 'mra.building_id = b.building_id')
                ->leftJoin('units u', 'mra.unit_id = u.unit_id')
                ->where('mra.application_id', $applicationId)
                ->whereNull('mra.deleted_at');

            // 非超级管理员只能查看自己管理的申请
            if ($role != 1) {
                $query->where('mra.user_id', $userId);
            }

            $info = $query->field('mra.*, a.area_name, b.building_name, u.unit_name')
                ->find();

            if (!$info) {
                mlog("错误: 申请不存在或无权限查看");
                $this->error('申请不存在');
            }

            mlog("查询到的申请信息: " . json_encode($info, JSON_UNESCAPED_UNICODE));

            $this->view->assign('info', $info);
            mlog("====== 查看申请详情结束 ======\n");
            return $this->display('detail');

        } catch (\Exception $e) {
            mlog("查询申请详情异常: " . $e->getMessage());
            mlog("异常堆栈: " . $e->getTraceAsString());
            $this->error('系统错误: ' . $e->getMessage());
        }
    }

    /**
     * 审核操作
     */
    public function audit()
    {
        if (!$this->request->isPost()) {
            $this->error('请求方式错误');
        }

        $applicationId = input('application_id', 0, 'intval');
        $status = input('status', 0, 'intval'); // 1=通过，2=拒绝
        $auditRemark = input('audit_remark', '');

        if (!$applicationId || !in_array($status, [1, 2])) {
            return json(['status' => '01', 'msg' => '参数错误']);
        }

        $userId = session('admin.userid');
        $role = session('admin.role');

        Db::startTrans();
        try {
            // 查询申请信息
            $query = Db::name('member_room_applications')
                ->where('application_id', $applicationId)
                ->whereNull('deleted_at');

            // 非超级管理员只能审核自己管理的申请
            if ($role != 1) {
                $query->where('user_id', $userId);
            }

            $application = $query->find();

            if (!$application) {
                throw new \Exception('申请不存在');
            }

            if ($application['status'] != 0) {
                throw new \Exception('该申请已处理');
            }

            // 更新申请状态
            Db::name('member_room_applications')->where('application_id', $applicationId)->update([
                'status' => $status,
                'audit_time' => time(),
                'audit_user_id' => $userId,
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
                        'is_primary' => 0, // 默认不是主房号
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

            mlog("管理员 {$userId} 审核房间绑定申请: application_id={$applicationId}, status={$status}");

            // 推送审核结果给用户
            $this->notifyUser($application, $status, $auditRemark);

            return json(['status' => '00', 'msg' => '审核完成']);

        } catch (\Exception $e) {
            Db::rollback();
            mlog("审核房间绑定申请异常: " . $e->getMessage());
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 推送审核结果给用户
     */
    private function notifyUser($application, $status, $auditRemark)
    {
        try {
            // 查询用户的推送Token
            $userTokens = Db::name('member_push_tokens')
                ->where('member_id', $application['member_id'])
                ->where('status', 1)
                ->select()
                ->toArray();

            if (empty($userTokens)) {
                mlog("用户 member_id={$application['member_id']} 没有推送Token");
                return;
            }

            $statusText = $status == 1 ? '已通过' : '已拒绝';
            $title = '房间绑定审核通知';
            $content = "您的房间绑定申请{$statusText}";
            if ($auditRemark) {
                $content .= "，备注：{$auditRemark}";
            }

            $pushPayload = [
                'type' => 'room_application_result',
                'title' => $title,
                'content' => $content,
                'data' => [
                    'route' => '/room/bind',  // 跳转到房间绑定页面
                    'arguments' => [
                        'applicationId' => $application['application_id'],
                        'status' => $status,
                    ],
                ],
            ];

            foreach ($userTokens as $token) {
                // 这里调用推送服务
                mlog("推送审核结果给用户: member_id={$token['member_id']}, status={$statusText}");
                // TODO: 实际调用推送API
            }
        } catch (\Exception $e) {
            mlog("推送审核结果给用户异常: " . $e->getMessage());
        }
    }

    /**
     * 授予公区设备钥匙
     */
    private function grantAreaKeys($application)
    {
        // 查找该区域的所有公区设备
        $publicLocks = Db::name('lock')
            ->where('user_id', $application['user_id'])
            ->where('area_id', $application['area_id'])
            ->where('device_type', 'public')
            ->whereNull('deleted_at')
            ->select()
            ->toArray();

        foreach ($publicLocks as $lock) {
            // 检查是否已有钥匙
            $existAuth = Db::name('lockauth')
                ->where('member_id', $application['member_id'])
                ->where('lock_id', $lock['lock_id'])
                ->whereNull('deleted_at')
                ->find();

            if (!$existAuth) {
                // 创建钥匙授权
                Db::name('lockauth')->insert([
                    'member_id' => $application['member_id'],
                    'lock_id' => $lock['lock_id'],
                    'auth_status' => 1,
                    'create_time' => time(),
                ]);

                mlog("授予公区设备钥匙: member_id={$application['member_id']}, lock_id={$lock['lock_id']}");
            }
        }
    }

    /**
     * 授予单元设备钥匙
     */
    private function grantUnitKeys($application)
    {
        // 查找该单元的所有单元设备
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
            // 检查是否已有钥匙
            $existAuth = Db::name('lockauth')
                ->where('member_id', $application['member_id'])
                ->where('lock_id', $lock['lock_id'])
                ->whereNull('deleted_at')
                ->find();

            if (!$existAuth) {
                // 创建钥匙授权
                Db::name('lockauth')->insert([
                    'member_id' => $application['member_id'],
                    'lock_id' => $lock['lock_id'],
                    'auth_status' => 1,
                    'create_time' => time(),
                ]);

                mlog("授予单元设备钥匙: member_id={$application['member_id']}, lock_id={$lock['lock_id']}");
            }
        }
    }

    /**
     * 获取区域列表（用于筛选）
     */
    public function getAreaList()
    {
        try {
            $userId = session('admin.userid');
            $role = session('admin.role');

            $query = Db::name('areas')->whereNull('deleted_at');

            // 非超级管理员只能看到自己管理的区域
            if ($role != 1) {
                $query->where('user_id', $userId);
            }

            $areas = $query->field('area_id, area_name')
                ->order('area_id', 'asc')
                ->select()
                ->toArray();

            return json(['status' => '00', 'data' => $areas]);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 获取楼栋列表（用于筛选）
     */
    public function getBuildingList()
    {
        try {
            $areaId = input('area_id', 0, 'intval');
            if (!$areaId) {
                return json(['status' => '01', 'msg' => '参数错误']);
            }

            $userId = session('admin.userid');
            $role = session('admin.role');

            $query = Db::name('buildings')
                ->where('area_id', $areaId)
                ->whereNull('deleted_at');

            // 非超级管理员只能看到自己管理的楼栋
            if ($role != 1) {
                $query->where('user_id', $userId);
            }

            $buildings = $query->field('building_id, building_name')
                ->order('building_id', 'asc')
                ->select()
                ->toArray();

            return json(['status' => '00', 'data' => $buildings]);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 获取单元列表（用于筛选）
     */
    public function getUnitList()
    {
        try {
            $buildingId = input('building_id', 0, 'intval');
            if (!$buildingId) {
                return json(['status' => '01', 'msg' => '参数错误']);
            }

            $userId = session('admin.userid');
            $role = session('admin.role');

            $query = Db::name('units')
                ->where('building_id', $buildingId)
                ->whereNull('deleted_at');

            // 非超级管理员只能看到自己管理的单元
            if ($role != 1) {
                $query->where('user_id', $userId);
            }

            $units = $query->field('unit_id, unit_name')
                ->order('unit_id', 'asc')
                ->select()
                ->toArray();

            return json(['status' => '00', 'data' => $units]);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 获取房间列表（用于筛选）
     */
    public function getRoomList()
    {
        try {
            $unitId = input('unit_id', 0, 'intval');
            if (!$unitId) {
                return json(['status' => '01', 'msg' => '参数错误']);
            }

            $userId = session('admin.userid');
            $role = session('admin.role');

            $query = Db::name('rooms')
                ->where('unit_id', $unitId)
                ->whereNull('deleted_at');

            // 非超级管理员只能看到自己管理的房间
            if ($role != 1) {
                $query->where('user_id', $userId);
            }

            $rooms = $query->field('room_id, room_number')
                ->order('room_number', 'asc')
                ->select()
                ->toArray();

            return json(['status' => '00', 'data' => $rooms]);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 下载导入模板
     */
    public function downloadTemplate()
    {
        // 创建简单的CSV模板
        $filename = '房间绑定导入模板_' . date('YmdHis') . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // 添加BOM头，让Excel正确识别UTF-8编码
        echo "\xEF\xBB\xBF";

        // 输出表头
        echo "姓名,手机号,区域名称,楼栋名称,单元名称,房号\n";

        // 输出示例数据
        echo "张三,13800138000,默认小区,A栋,1单元,101\n";
        echo "李四,13900139000,默认小区,A栋,1单元,102\n";

        exit;
    }

    /**
     * 批量导入Excel
     */
    public function importExcel()
    {
        if (!$this->request->isPost()) {
            return json(['status' => '01', 'msg' => '请求方式错误']);
        }

        $userId = session('admin.userid');
        $role = session('admin.role');

        if (!$userId) {
            return json(['status' => '01', 'msg' => '请先登录']);
        }

        mlog("开始导入，user_id={$userId}, role={$role}");

        // 获取上传的文件
        $file = request()->file('file');
        if (!$file) {
            mlog("导入失败：未获取到文件");
            return json(['status' => '01', 'msg' => '请选择文件']);
        }

        mlog("接收到文件：" . $file->getOriginalName() . ", 大小：" . $file->getSize());

        try {
            // 保存文件目录
            $savePath = root_path() . 'runtime' . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR;
            if (!is_dir($savePath)) {
                if (!mkdir($savePath, 0755, true)) {
                    mlog("创建目录失败：{$savePath}");
                    throw new \Exception('创建上传目录失败');
                }
            }

            mlog("保存目录：{$savePath}");

            // 生成唯一文件名
            $fileName = date('YmdHis') . '_' . uniqid() . '.csv';
            $filePath = $savePath . $fileName;

            mlog("目标文件路径：{$filePath}");

            // 使用原生PHP方式移动文件
            $tmpFile = $file->getPathname();
            mlog("临时文件路径：{$tmpFile}");

            if (!file_exists($tmpFile)) {
                mlog("临时文件不存在");
                throw new \Exception('临时文件不存在');
            }

            if (!move_uploaded_file($tmpFile, $filePath)) {
                // 如果move_uploaded_file失败，尝试copy
                if (!copy($tmpFile, $filePath)) {
                    mlog("文件移动和复制都失败");
                    throw new \Exception('文件保存失败');
                }
                @unlink($tmpFile);
            }

            mlog("文件保存成功：{$filePath}");

            // 读取CSV文件（简单处理，支持CSV和Excel转CSV）
            $data = $this->readCsvFile($filePath);

            if (empty($data)) {
                throw new \Exception('文件内容为空或格式错误');
            }

            mlog("读取到 " . count($data) . " 行数据");

            // 处理导入
            $result = $this->processImportData($data, $userId, $role);

            // 删除临时文件
            @unlink($filePath);

            // 构建提示消息
            $msg = "导入完成！成功: {$result['success']}条";
            if ($result['skipped'] > 0) {
                $msg .= "，跳过: {$result['skipped']}条";
            }
            if ($result['failed'] > 0) {
                $msg .= "，失败: {$result['failed']}条";
            }

            return json([
                'status' => '00',
                'msg' => $msg,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            mlog("导入异常: " . $e->getMessage());
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    /**
     * 读取CSV文件
     */
    private function readCsvFile($filePath)
    {
        $data = [];

        if (!file_exists($filePath)) {
            mlog("文件不存在: {$filePath}");
            return $data;
        }

        mlog("开始读取CSV文件: {$filePath}");

        // 尝试读取为CSV，支持UTF-8 BOM编码
        if (($handle = fopen($filePath, 'r')) !== false) {
            // 检测并跳过BOM
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }

            $lineNum = 0;
            $isFirstRow = true;

            while (($row = fgetcsv($handle, 10000, ',')) !== false) {
                $lineNum++;

                // 跳过表头
                if ($isFirstRow) {
                    $isFirstRow = false;
                    mlog("跳过表头: " . json_encode($row, JSON_UNESCAPED_UNICODE));
                    continue;
                }

                // 跳过空行
                if (empty(array_filter($row))) {
                    continue;
                }

                $data[] = $row;
            }
            fclose($handle);

            mlog("CSV读取完成，共{$lineNum}行，有效数据" . count($data) . "行");
        } else {
            mlog("无法打开文件: {$filePath}");
        }

        return $data;
    }

    /**
     * 处理导入数据
     * 支持：自动创建区域/楼栋/单元、智能去重、完整性校验
     */
    private function processImportData($data, $userId, $role)
    {
        $successCount = 0;
        $failedCount = 0;
        $skippedCount = 0;
        $errors = [];

        // 缓存已查询的区域/楼栋/单元，减少数据库查询
        $areaCache = [];
        $buildingCache = [];
        $unitCache = [];
        $roomCache = [];

        foreach ($data as $index => $row) {
            $lineNum = $index + 2; // 从第2行开始（第1行是表头）

            try {
                // ========== 1. 数据解析和验证 ==========
                if (count($row) < 6) {
                    throw new \Exception("数据列数不足，需要6列");
                }

                $name = trim($row[0]);
                $phone = trim($row[1]);
                $areaName = trim($row[2]);
                $buildingName = trim($row[3]);
                $unitName = trim($row[4]);
                $roomNumber = trim($row[5]);

                // 验证必填项
                if (empty($name)) {
                    throw new \Exception("姓名不能为空");
                }
                if (empty($phone)) {
                    throw new \Exception("手机号不能为空");
                }
                if (empty($areaName) || empty($buildingName) || empty($unitName) || empty($roomNumber)) {
                    throw new \Exception("位置信息不完整");
                }

                // 验证手机号格式
                if (!preg_match('/^1[3-9]\d{9}$/', $phone)) {
                    throw new \Exception("手机号格式不正确");
                }

                // ========== 2. 查找或创建区域 ==========
                $cacheKey = "area_{$areaName}";
                if (isset($areaCache[$cacheKey])) {
                    $area = $areaCache[$cacheKey];
                } else {
                    $area = Db::name('areas')
                        ->where('area_name', $areaName)
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$area) {
                        // 自动创建区域，分配给当前管理员
                        $areaId = Db::name('areas')->insertGetId([
                            'area_name' => $areaName,
                            'user_id' => $userId,
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);

                        $area = [
                            'area_id' => $areaId,
                            'area_name' => $areaName,
                            'user_id' => $userId,
                        ];

                        mlog("自动创建区域: area_id={$areaId}, area_name={$areaName}, user_id={$userId}");
                    }

                    $areaCache[$cacheKey] = $area;
                }

                // 权限检查：非超级管理员只能导入自己管理的区域
                if ($role != 1 && $area['user_id'] != $userId) {
                    throw new \Exception("无权限操作区域「{$areaName}」");
                }

                // ========== 3. 查找或创建楼栋 ==========
                $cacheKey = "building_{$area['area_id']}_{$buildingName}";
                if (isset($buildingCache[$cacheKey])) {
                    $building = $buildingCache[$cacheKey];
                } else {
                    $building = Db::name('buildings')
                        ->where('area_id', $area['area_id'])
                        ->where('building_name', $buildingName)
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$building) {
                        // 自动创建楼栋
                        $buildingId = Db::name('buildings')->insertGetId([
                            'area_id' => $area['area_id'],
                            'building_name' => $buildingName,
                            'user_id' => $area['user_id'], // 继承区域的管理员
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);

                        $building = [
                            'building_id' => $buildingId,
                            'building_name' => $buildingName,
                            'area_id' => $area['area_id'],
                            'user_id' => $area['user_id'],
                        ];

                        mlog("自动创建楼栋: building_id={$buildingId}, building_name={$buildingName}, area_id={$area['area_id']}");
                    }

                    $buildingCache[$cacheKey] = $building;
                }

                // ========== 4. 查找或创建单元 ==========
                $cacheKey = "unit_{$building['building_id']}_{$unitName}";
                if (isset($unitCache[$cacheKey])) {
                    $unit = $unitCache[$cacheKey];
                } else {
                    $unit = Db::name('units')
                        ->where('building_id', $building['building_id'])
                        ->where('unit_name', $unitName)
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$unit) {
                        // 自动创建单元
                        $unitId = Db::name('units')->insertGetId([
                            'building_id' => $building['building_id'],
                            'unit_name' => $unitName,
                            'user_id' => $building['user_id'], // 继承楼栋的管理员
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);

                        $unit = [
                            'unit_id' => $unitId,
                            'unit_name' => $unitName,
                            'building_id' => $building['building_id'],
                            'user_id' => $building['user_id'],
                        ];

                        mlog("自动创建单元: unit_id={$unitId}, unit_name={$unitName}, building_id={$building['building_id']}");
                    }

                    $unitCache[$cacheKey] = $unit;
                }

                // ========== 5. 查找或创建房间 ==========
                $cacheKey = "room_{$unit['unit_id']}_{$roomNumber}";
                if (isset($roomCache[$cacheKey])) {
                    $room = $roomCache[$cacheKey];
                } else {
                    $room = Db::name('rooms')
                        ->where('unit_id', $unit['unit_id'])
                        ->where('room_number', $roomNumber)
                        ->whereNull('deleted_at')
                        ->find();

                    if (!$room) {
                        // 自动创建房间
                        $roomId = Db::name('rooms')->insertGetId([
                            'unit_id' => $unit['unit_id'],
                            'room_number' => $roomNumber,
                            'user_id' => $unit['user_id'], // 继承单元的管理员
                            'room_type' => 'residential', // 默认住宅
                            'room_status' => 'available',
                            'status' => 1,
                            'create_time' => time(),
                            'update_time' => time(),
                        ]);

                        $room = [
                            'room_id' => $roomId,
                            'room_number' => $roomNumber,
                            'unit_id' => $unit['unit_id'],
                            'user_id' => $unit['user_id'],
                        ];

                        mlog("自动创建房间: room_id={$roomId}, room_number={$roomNumber}, unit_id={$unit['unit_id']}");
                    }

                    $roomCache[$cacheKey] = $room;
                }

                // ========== 6. 查找或创建用户（手机号去重） ==========
                $member = Db::name('member')
                    ->where('mobile', $phone)
                    ->find();

                $memberId = 0;
                if (!$member) {
                    // 创建新用户（占位用户，等待激活）
                    $memberId = Db::name('member')->insertGetId([
                        'member_name' => $name,
                        'mobile' => $phone,
                        'openid' => 'import_' . time() . '_' . uniqid(), // 使用唯一标识避免openid冲突
                        'status' => 0, // 未激活状态
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);
                    mlog("创建新用户: member_id={$memberId}, phone={$phone}, name={$name}");
                } else {
                    $memberId = $member['member_id'];
                    // 如果用户已存在但姓名不同，更新姓名（以最新导入为准）
                    if ($member['member_name'] != $name) {
                        Db::name('member')
                            ->where('member_id', $memberId)
                            ->update([
                                'member_name' => $name,
                                'update_time' => time(),
                            ]);
                        mlog("更新用户姓名: member_id={$memberId}, old_name={$member['member_name']}, new_name={$name}");
                    }
                }

                // ========== 7. 检查重复绑定（跳过已存在的绑定） ==========
                $existBind = Db::name('member_rooms')
                    ->where('member_id', $memberId)
                    ->where('room_id', $room['room_id'])
                    ->whereNull('deleted_at')
                    ->find();

                if ($existBind) {
                    $skippedCount++;
                    mlog("跳过已绑定: 第{$lineNum}行，member_id={$memberId}, room_id={$room['room_id']}");
                    continue; // 跳过本条，不算失败
                }

                // ========== 8. 开启事务创建绑定和授权 ==========
                Db::startTrans();
                try {
                    // 创建绑定关系
                    Db::name('member_rooms')->insert([
                        'member_id' => $memberId,
                        'user_id' => $room['user_id'],
                        'area_id' => $area['area_id'],
                        'building_id' => $building['building_id'],
                        'unit_id' => $unit['unit_id'],
                        'room_id' => $room['room_id'],
                        'relation_type' => 'owner', // 默认业主
                        'is_primary' => 0,
                        'status' => 1, // 直接通过
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);

                    // 创建申请记录（已通过）
                    Db::name('member_room_applications')->insert([
                        'member_id' => $memberId,
                        'user_id' => $room['user_id'],
                        'area_id' => $area['area_id'],
                        'building_id' => $building['building_id'],
                        'unit_id' => $unit['unit_id'],
                        'room_id' => $room['room_id'],
                        'room_number' => $roomNumber,
                        'relation_type' => 'owner',
                        'applicant_name' => $name,
                        'applicant_phone' => $phone,
                        'status' => 1, // 已通过
                        'audit_time' => time(),
                        'audit_user_id' => $userId,
                        'audit_remark' => '批量导入自动通过',
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);

                    // 授予设备钥匙
                    $application = [
                        'member_id' => $memberId,
                        'user_id' => $room['user_id'],
                        'area_id' => $area['area_id'],
                        'building_id' => $building['building_id'],
                        'unit_id' => $unit['unit_id'],
                    ];

                    $this->grantAreaKeys($application);
                    $this->grantUnitKeys($application);

                    Db::commit();
                    $successCount++;

                    mlog("导入成功: 第{$lineNum}行，{$name}({$phone}) -> {$areaName}/{$buildingName}/{$unitName}/{$roomNumber}");

                } catch (\Exception $e) {
                    Db::rollback();
                    throw $e;
                }

            } catch (\Exception $e) {
                $failedCount++;
                $errorMsg = "第{$lineNum}行: " . $e->getMessage();
                $errors[] = $errorMsg;
                mlog("导入失败: {$errorMsg}");
            }
        }

        return [
            'success' => $successCount,
            'failed' => $failedCount,
            'skipped' => $skippedCount,
            'errors' => array_slice($errors, 0, 20) // 返回前20条错误
        ];
    }

    /**
     * 删除房间绑定
     */
    public function deleteBinding()
    {
        try {
            if (!$this->request->isPost()) {
                return json(['status' => '01', 'msg' => '非法请求：仅支持POST方法']);
            }

            $applicationId = input('application_id', 0, 'intval');
            if (!$applicationId) {
                return json(['status' => '01', 'msg' => '参数错误：application_id不能为空']);
            }

            $userId = session('admin.userid');
            $role = session('admin.role');

            if (!$userId) {
                return json(['status' => '01', 'msg' => '未登录或登录已过期，请重新登录']);
            }

            mlog("删除绑定请求: application_id={$applicationId}, user_id={$userId}, role={$role}");

            // 查询申请信息
            $application = Db::name('member_room_applications')
                ->where('application_id', $applicationId)
                ->whereNull('deleted_at')
                ->find();

            if (!$application) {
                return json(['status' => '01', 'msg' => '记录不存在或已被删除']);
            }

            mlog("找到申请记录: " . json_encode($application, JSON_UNESCAPED_UNICODE));

            // 权限检查：非超级管理员只能删除自己管理的绑定
            if ($role != 1 && $application['user_id'] != $userId) {
                mlog("权限不足: 当前管理员user_id={$userId}，申请归属user_id={$application['user_id']}");
                return json(['status' => '01', 'msg' => '权限不足：您只能删除自己管理的记录']);
            }

        // 检查是否是管理员自己的绑定
        $member = Db::name('member')->where('member_id', $application['member_id'])->find();
        if (!$member) {
            return json(['status' => '01', 'msg' => '用户信息不存在']);
        }

        mlog("找到用户信息: member_id={$member['member_id']}, mobile={$member['mobile']}");

        // 检查该用户是否是管理员账号（通过user表的member_id关联检查）
        $isAdmin = Db::name('user')
            ->where('member_id', $member['member_id'])
            ->find();

        if ($isAdmin) {
            mlog("禁止删除: 该用户是管理员账号，member_id={$member['member_id']}, user_id={$isAdmin['user_id']}");
            return json(['status' => '01', 'msg' => '安全限制：不能删除管理员账号的绑定']);
        }            mlog("开始删除流程: application_id={$applicationId}, member_id={$application['member_id']}, status={$application['status']}");

            Db::startTrans();
            try {
            // 软删除申请记录
            $updateResult = Db::name('member_room_applications')
                ->where('application_id', $applicationId)
                ->update(['deleted_at' => time()]);

            mlog("申请记录删除结果: affected_rows={$updateResult}");

            // 如果是已通过的申请，还需要删除对应的房间绑定
            if ($application['status'] == 1) {
                // 查找对应的房间绑定（使用room_id而不是room_number）
                $roomBinding = Db::name('member_rooms')
                    ->where('member_id', $application['member_id'])
                    ->where('area_id', $application['area_id'])
                    ->where('building_id', $application['building_id'])
                    ->where('unit_id', $application['unit_id'])
                    ->where('room_id', $application['room_id'])
                    ->whereNull('deleted_at')
                    ->find();

                if ($roomBinding) {
                    // 软删除房间绑定
                    Db::name('member_rooms')
                        ->where('id', $roomBinding['id'])
                        ->update(['deleted_at' => time()]);

                    mlog("已删除房间绑定: id={$roomBinding['id']}, room_id={$application['room_id']}");
                }

                // 删除设备授权（区域和单元的钥匙）
                // 先查找该区域下的所有门禁设备
                $areaLocks = Db::name('lock')
                    ->where('area_id', $application['area_id'])
                    ->where('building_id', 0)
                    ->where('unit_id', 0)
                    ->whereNull('deleted_at')
                    ->column('lock_id');

                // 查找该单元下的所有门禁设备
                $unitLocks = Db::name('lock')
                    ->where('unit_id', $application['unit_id'])
                    ->whereNull('deleted_at')
                    ->column('lock_id');

                // 合并设备ID
                $lockIds = array_merge($areaLocks, $unitLocks);

                $deletedAuthCount = 0;
                if (!empty($lockIds)) {
                    // 删除该用户在这些设备上的授权
                    $deletedAuthCount = Db::name('lockauth')
                        ->where('member_id', $application['member_id'])
                        ->whereIn('lock_id', $lockIds)
                        ->whereNull('deleted_at')
                        ->update(['deleted_at' => time()]);
                }

                mlog("已删除设备授权: member_id={$application['member_id']}, lock_count=" . count($lockIds) . ", auth_count={$deletedAuthCount}");
            }

            Db::commit();

            mlog("删除成功: application_id={$applicationId}");
            return json(['status' => '00', 'msg' => '删除成功']);

        } catch (\Exception $e) {
            Db::rollback();
            $errorMsg = $e->getMessage();
            $errorFile = $e->getFile();
            $errorLine = $e->getLine();
            mlog("删除失败 - 异常信息: {$errorMsg}");
            mlog("删除失败 - 异常位置: {$errorFile}:{$errorLine}");
            mlog("删除失败 - 异常追踪: " . $e->getTraceAsString());
            return json([
                'status' => '01',
                'msg' => '删除失败：' . $errorMsg . ' (位置: ' . basename($errorFile) . ':' . $errorLine . ')'
            ]);
        }

        } catch (\Exception $e) {
            // 外层捕获所有异常
            $errorMsg = $e->getMessage();
            mlog("deleteBinding外层异常: " . $errorMsg);
            mlog("异常追踪: " . $e->getTraceAsString());
            return json([
                'status' => '01',
                'msg' => '系统错误：' . $errorMsg
            ]);
        }
    }
}
