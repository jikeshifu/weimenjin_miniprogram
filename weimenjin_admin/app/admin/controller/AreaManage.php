<?php
/*
 * module:		区域管理
 * create_time:	2025-10-14
 * author:		System
 * contact:
 */

namespace app\admin\controller;

use think\facade\Db;

class AreaManage extends Admin
{
    function initialize()
    {
        parent::initialize();
    }

    // ==================== 区域管理 ====================

    /**
     * 区域列表页面
     */
    public function index()
    {
        if (!$this->request->isAjax()) {
            return $this->display('index');
        } else {
            $limit = $this->request->post('limit', 20, 'intval');
            $offset = $this->request->post('offset', 0, 'intval');
            $page = floor($offset / $limit) + 1;

            $keyword = $this->request->param('keyword', '');

            $where = [];

            // 权限控制：非超级管理员只能看自己创建的
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }

            if ($keyword) {
                $where['area_name|area_code'] = ['like', "%{$keyword}%"];
            }

            // 只查询未删除的数据
            $list = Db::name('areas')
                ->where($where)
                ->where('deleted_at', 'exp', 'is null')
                ->order('create_time', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();

            // 添加统计信息
            foreach ($list as &$item) {
                $item['building_count'] = Db::name('buildings')
                    ->where('area_id', $item['area_id'])
                    ->where('deleted_at', 'exp', 'is null')
                    ->count();

                $item['device_count'] = Db::name('lock')
                    ->where('area_id', $item['area_id'])
                    ->where('deleted_at', 'exp', 'is null')
                    ->count();
            }

            $total = Db::name('areas')
                ->where($where)
                ->where('deleted_at', 'exp', 'is null')
                ->count();

            $data['rows'] = $list;
            $data['total'] = $total;
            return json($data);
        }
    }

    /**
     * 添加区域
     */
    public function add()
    {
        if (!$this->request->isPost()) {
            return $this->display('add');
        } else {
            $area_code = trim($this->request->post('area_code', ''));

            // 如果没有填写区域编码，自动生成：AREA + 时间戳后6位 + 随机2位
            if (empty($area_code)) {
                $area_code = 'AREA' . substr(time(), -6) . rand(10, 99);
            }

            $data = [
                'user_id' => session('admin.user_id'), // 自动设置当前管理员ID
                'area_name' => trim($this->request->post('area_name')),
                'area_code' => $area_code,
                'address' => $this->request->post('address', ''),
                'province' => $this->request->post('province', ''),
                'city' => $this->request->post('city', ''),
                'district' => $this->request->post('district', ''),
                'contact_name' => $this->request->post('contact_name', ''),
                'contact_phone' => $this->request->post('contact_phone', ''),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'create_time' => time()
            ];

            if (empty($data['area_name'])) {
                return json(['status' => '01', 'msg' => '区域名称不能为空']);
            }

            try {
                Db::name('areas')->insert($data);
                return json(['status' => '00', 'msg' => '添加成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '添加失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 编辑区域
     */
    public function update()
    {
        if (!$this->request->isPost()) {
            $area_id = $this->request->get('area_id', 0, 'intval');
            if (!$area_id) $this->error('参数错误');

            try {
                $where = ['area_id' => $area_id];
                // 权限检查
                if (session('admin.role') != 1) {
                    $where['user_id'] = session('admin.user_id');
                }

                $info = Db::name('areas')->where($where)->find();
                if (!$info) $this->error('数据不存在或无权限操作');

                $this->view->assign('info', checkData($info));
                return $this->display('update');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        } else {
            $area_id = $this->request->post('area_id', 0, 'intval');

            // 权限检查
            $where = ['area_id' => $area_id];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }

            $exists = Db::name('areas')->where($where)->find();
            if (!$exists) {
                return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
            }

            $area_code = trim($this->request->post('area_code', ''));

            $data = [
                'area_name' => trim($this->request->post('area_name')),
                'area_code' => empty($area_code) ? null : $area_code, // 空值转为NULL避免唯一索引冲突
                'address' => $this->request->post('address', ''),
                'province' => $this->request->post('province', ''),
                'city' => $this->request->post('city', ''),
                'district' => $this->request->post('district', ''),
                'contact_name' => $this->request->post('contact_name', ''),
                'contact_phone' => $this->request->post('contact_phone', ''),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'update_time' => time()
            ];

            try {
                Db::name('areas')->where('area_id', $area_id)->update($data);
                return json(['status' => '00', 'msg' => '更新成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '更新失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 删除区域
     */
    public function delete()
    {
        $area_id = $this->request->post('area_id', 0, 'intval');
        if (!$area_id) {
            return json(['status' => '01', 'msg' => '参数错误']);
        }

        // 权限检查
        $where = ['area_id' => $area_id];
        if (session('admin.role') != 1) {
            $where['user_id'] = session('admin.user_id');
        }

        $exists = Db::name('areas')->where($where)->find();
        if (!$exists) {
            return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
        }

        // 检查是否有关联的楼栋
        $buildingCount = Db::name('buildings')
            ->where('area_id', $area_id)
            ->where('deleted_at', 'exp', 'is null')
            ->count();

        if ($buildingCount > 0) {
            return json(['status' => '01', 'msg' => '该区域下还有楼栋，无法删除']);
        }

        try {
            Db::name('areas')->where('area_id', $area_id)->update(['deleted_at' => time()]);
            return json(['status' => '00', 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => '删除失败: ' . $e->getMessage()]);
        }
    }

    // ==================== 楼栋管理 ====================

    /**
     * 楼栋列表
     */
    public function buildingIndex()
    {
        if (!$this->request->isAjax()) {
            // 获取当前管理员的区域列表
            $where = [];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }
            $areas = Db::name('areas')
                ->where($where)
                ->where('deleted_at', 'exp', 'is null')
                ->select()
                ->toArray();
            $this->view->assign('areas', $areas);
            return $this->display('building_index');
        } else {
            $limit = $this->request->post('limit', 20, 'intval');
            $offset = $this->request->post('offset', 0, 'intval');
            $page = floor($offset / $limit) + 1;

            $area_id = $this->request->param('area_id', '');
            $keyword = $this->request->param('keyword', '');

            $query = Db::name('buildings')
                ->alias('b')
                ->join('areas a', 'b.area_id = a.area_id');

            // 权限控制
            if (session('admin.role') != 1) {
                $query->where('b.user_id', session('admin.user_id'));
            }

            if ($area_id) {
                $query->where('b.area_id', $area_id);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->whereOr('b.building_name', 'like', "%{$keyword}%")
                      ->whereOr('b.building_code', 'like', "%{$keyword}%");
                });
            }
            $query->where('b.deleted_at', 'exp', 'is null');

            // 先获取SQL语句用于调试
            $debugSql = $query->field('b.*, a.area_name')
                ->order('b.create_time', 'desc')
                ->page($page, $limit)
                ->fetchSql(true)
                ->select();

            $list = $query->field('b.*, a.area_name')
                ->order('b.create_time', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();

            foreach ($list as &$item) {
                $item['unit_count'] = Db::name('units')
                    ->where('building_id', $item['building_id'])
                    ->where('deleted_at', 'exp', 'is null')
                    ->count();
            }

            // 重新构建查询获取总数
            $totalQuery = Db::name('buildings')
                ->alias('b')
                ->join('areas a', 'b.area_id = a.area_id');

            if (session('admin.role') != 1) {
                $totalQuery->where('b.user_id', session('admin.user_id'));
            }
            if ($area_id) {
                $totalQuery->where('b.area_id', $area_id);
            }
            if ($keyword) {
                $totalQuery->where(function($q) use ($keyword) {
                    $q->whereOr('b.building_name', 'like', "%{$keyword}%")
                      ->whereOr('b.building_code', 'like', "%{$keyword}%");
                });
            }
            $totalQuery->where('b.deleted_at', 'exp', 'is null');

            $total = $totalQuery->count();

            $data['rows'] = $list;
            $data['total'] = $total;
            $data['debug'] = [
                'sql' => $debugSql,
                'admin_role' => session('admin.role'),
                'admin_user_id' => session('admin.user_id')
            ];
            return json($data);
        }
    }

    /**
     * 添加楼栋
     */
    public function buildingAdd()
    {
        if (!$this->request->isPost()) {
            // 获取当前管理员的区域列表
            $where = [];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }
            $areas = Db::name('areas')
                ->where($where)
                ->where('deleted_at', 'exp', 'is null')
                ->select()
                ->toArray();
            $this->view->assign('areas', $areas);
            return $this->display('building_add');
        } else {
            $area_id = $this->request->post('area_id', 0, 'intval');

            // 验证区域是否属于当前管理员
            $areaWhere = ['area_id' => $area_id];
            if (session('admin.role') != 1) {
                $areaWhere['user_id'] = session('admin.user_id');
            }
            $area = Db::name('areas')->where($areaWhere)->find();
            if (!$area) {
                return json(['status' => '01', 'msg' => '区域不存在或无权限操作']);
            }

            $building_code = trim($this->request->post('building_code', ''));

            // 如果没有填写楼栋编码，自动生成
            if (empty($building_code)) {
                $building_code = 'BD' . substr(time(), -6) . rand(10, 99);
            }

            $data = [
                'user_id' => session('admin.user_id'), // 自动设置当前管理员ID
                'area_id' => $area_id,
                'building_name' => trim($this->request->post('building_name')),
                'building_code' => $building_code,
                'floors' => $this->request->post('floors', 0, 'intval'),
                'unit_count' => $this->request->post('unit_count', 0, 'intval'),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'create_time' => time()
            ];

            if (empty($data['building_name'])) {
                return json(['status' => '01', 'msg' => '楼栋名称不能为空']);
            }

            try {
                Db::name('buildings')->insert($data);
                return json(['status' => '00', 'msg' => '添加成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '添加失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 编辑楼栋
     */
    public function buildingUpdate()
    {
        if (!$this->request->isPost()) {
            $building_id = $this->request->get('building_id', 0, 'intval');
            if (!$building_id) $this->error('参数错误');

            try {
                $where = ['b.building_id' => $building_id];
                if (session('admin.role') != 1) {
                    $where['b.user_id'] = session('admin.user_id');
                }

                $info = Db::name('buildings')
                    ->alias('b')
                    ->join('areas a', 'b.area_id = a.area_id')
                    ->where($where)
                    ->field('b.*, a.area_name')
                    ->find();

                if (!$info) $this->error('数据不存在或无权限操作');

                // 获取当前管理员的区域列表
                $areaWhere = [];
                if (session('admin.role') != 1) {
                    $areaWhere['user_id'] = session('admin.user_id');
                }
                $areas = Db::name('areas')
                    ->where($areaWhere)
                    ->where('deleted_at', 'exp', 'is null')
                    ->select()
                    ->toArray();

                $this->view->assign('info', checkData($info));
                $this->view->assign('areas', $areas);
                return $this->display('building_update');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        } else {
            $building_id = $this->request->post('building_id', 0, 'intval');

            // 权限检查
            $where = ['building_id' => $building_id];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }
            $exists = Db::name('buildings')->where($where)->find();
            if (!$exists) {
                return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
            }

            $building_code = trim($this->request->post('building_code', ''));

            $data = [
                'area_id' => $this->request->post('area_id', 0, 'intval'),
                'building_name' => trim($this->request->post('building_name')),
                'building_code' => empty($building_code) ? null : $building_code,
                'floors' => $this->request->post('floors', 0, 'intval'),
                'unit_count' => $this->request->post('unit_count', 0, 'intval'),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'update_time' => time()
            ];

            try {
                Db::name('buildings')->where('building_id', $building_id)->update($data);
                return json(['status' => '00', 'msg' => '更新成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '更新失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 删除楼栋
     */
    public function buildingDelete()
    {
        $building_id = $this->request->post('building_id', 0, 'intval');
        if (!$building_id) {
            return json(['status' => '01', 'msg' => '参数错误']);
        }

        // 权限检查
        $where = ['building_id' => $building_id];
        if (session('admin.role') != 1) {
            $where['user_id'] = session('admin.user_id');
        }
        $exists = Db::name('buildings')->where($where)->find();
        if (!$exists) {
            return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
        }

        $unitCount = Db::name('units')
            ->where('building_id', $building_id)
            ->where('deleted_at', 'exp', 'is null')
            ->count();

        if ($unitCount > 0) {
            return json(['status' => '01', 'msg' => '该楼栋下还有单元，无法删除']);
        }

        try {
            Db::name('buildings')->where('building_id', $building_id)->update(['deleted_at' => time()]);
            return json(['status' => '00', 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => '删除失败: ' . $e->getMessage()]);
        }
    }

    // ==================== 单元管理 ====================

    /**
     * 单元列表
     */
    public function unitIndex()
    {
        if (!$this->request->isAjax()) {
            // 获取当前管理员的楼栋列表
            $buildingWhere = [];
            if (session('admin.role') != 1) {
                $buildingWhere['b.user_id'] = session('admin.user_id');
            }
            $buildings = Db::name('buildings')
                ->alias('b')
                ->join('areas a', 'b.area_id = a.area_id')
                ->where($buildingWhere)
                ->where('b.deleted_at', 'exp', 'is null')
                ->field('b.building_id, b.building_name, a.area_name')
                ->select()
                ->toArray();
            $this->view->assign('buildings', $buildings);
            return $this->display('unit_index');
        } else {
            $limit = $this->request->post('limit', 20, 'intval');
            $offset = $this->request->post('offset', 0, 'intval');
            $page = floor($offset / $limit) + 1;

            $building_id = $this->request->param('building_id', '');
            $keyword = $this->request->param('keyword', '');

            $query = Db::name('units')
                ->alias('u')
                ->join('buildings b', 'u.building_id = b.building_id')
                ->join('areas a', 'u.area_id = a.area_id');

            // 权限控制
            if (session('admin.role') != 1) {
                $query->where('u.user_id', session('admin.user_id'));
            }

            if ($building_id) {
                $query->where('u.building_id', $building_id);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->whereOr('u.unit_name', 'like', "%{$keyword}%")
                      ->whereOr('u.unit_code', 'like', "%{$keyword}%");
                });
            }
            $query->where('u.deleted_at', 'exp', 'is null');

            // 先获取SQL语句用于调试
            $debugSql = $query->field('u.*, b.building_name, a.area_name')
                ->order('u.create_time', 'desc')
                ->page($page, $limit)
                ->fetchSql(true)
                ->select();

            $list = $query->field('u.*, b.building_name, a.area_name')
                ->order('u.create_time', 'desc')
                ->page($page, $limit)
                ->select()
                ->toArray();

            foreach ($list as &$item) {
                $item['room_count'] = Db::name('rooms')
                    ->where('unit_id', $item['unit_id'])
                    ->where('deleted_at', 'exp', 'is null')
                    ->count();
            }

            // 重新构建查询获取总数
            $totalQuery = Db::name('units')
                ->alias('u')
                ->join('buildings b', 'u.building_id = b.building_id')
                ->join('areas a', 'u.area_id = a.area_id');

            if (session('admin.role') != 1) {
                $totalQuery->where('u.user_id', session('admin.user_id'));
            }
            if ($building_id) {
                $totalQuery->where('u.building_id', $building_id);
            }
            if ($keyword) {
                $totalQuery->where(function($q) use ($keyword) {
                    $q->whereOr('u.unit_name', 'like', "%{$keyword}%")
                      ->whereOr('u.unit_code', 'like', "%{$keyword}%");
                });
            }
            $totalQuery->where('u.deleted_at', 'exp', 'is null');

            $total = $totalQuery->count();

            $data['rows'] = $list;
            $data['total'] = $total;
            $data['debug'] = [
                'sql' => $debugSql,
                'admin_role' => session('admin.role'),
                'admin_user_id' => session('admin.user_id')
            ];
            return json($data);
        }
    }

    /**
     * 添加单元
     */
    public function unitAdd()
    {
        if (!$this->request->isPost()) {
            // 获取当前管理员的楼栋列表
            $buildingWhere = [];
            if (session('admin.role') != 1) {
                $buildingWhere['b.user_id'] = session('admin.user_id');
            }
            $buildings = Db::name('buildings')
                ->alias('b')
                ->join('areas a', 'b.area_id = a.area_id')
                ->where($buildingWhere)
                ->where('b.deleted_at', 'exp', 'is null')
                ->field('b.*, a.area_name')
                ->select()
                ->toArray();
            $this->view->assign('buildings', $buildings);
            return $this->display('unit_add');
        } else {
            $building_id = $this->request->post('building_id', 0, 'intval');
            if (!$building_id) {
                return json(['status' => '01', 'msg' => '请选择楼栋']);
            }

            // 验证楼栋是否属于当前管理员
            $buildingWhere = ['building_id' => $building_id];
            if (session('admin.role') != 1) {
                $buildingWhere['user_id'] = session('admin.user_id');
            }
            $building = Db::name('buildings')->where($buildingWhere)->find();
            if (!$building) {
                return json(['status' => '01', 'msg' => '楼栋不存在或无权限操作']);
            }

            $unit_code = trim($this->request->post('unit_code', ''));

            // 如果没有填写单元编码，自动生成
            if (empty($unit_code)) {
                $unit_code = 'UNIT' . substr(time(), -6) . rand(10, 99);
            }

            $data = [
                'user_id' => session('admin.user_id'), // 自动设置当前管理员ID
                'building_id' => $building_id,
                'area_id' => $building['area_id'],
                'unit_name' => trim($this->request->post('unit_name')),
                'unit_code' => $unit_code,
                'floors' => $this->request->post('floors', 0, 'intval'),
                'room_count' => $this->request->post('room_count', 0, 'intval'),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'create_time' => time()
            ];

            if (empty($data['unit_name'])) {
                return json(['status' => '01', 'msg' => '单元名称不能为空']);
            }

            try {
                Db::name('units')->insert($data);
                return json(['status' => '00', 'msg' => '添加成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '添加失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 编辑单元
     */
    public function unitUpdate()
    {
        if (!$this->request->isPost()) {
            $unit_id = $this->request->get('unit_id', 0, 'intval');
            if (!$unit_id) $this->error('参数错误');

            try {
                $where = ['u.unit_id' => $unit_id];
                if (session('admin.role') != 1) {
                    $where['u.user_id'] = session('admin.user_id');
                }

                $info = Db::name('units')
                    ->alias('u')
                    ->join('buildings b', 'u.building_id = b.building_id')
                    ->join('areas a', 'u.area_id = a.area_id')
                    ->where($where)
                    ->field('u.*, b.building_name, a.area_name')
                    ->find();

                if (!$info) $this->error('数据不存在或无权限操作');

                // 获取当前管理员的楼栋列表
                $buildingWhere = [];
                if (session('admin.role') != 1) {
                    $buildingWhere['b.user_id'] = session('admin.user_id');
                }
                $buildings = Db::name('buildings')
                    ->alias('b')
                    ->join('areas a', 'b.area_id = a.area_id')
                    ->where($buildingWhere)
                    ->where('b.deleted_at', 'exp', 'is null')
                    ->field('b.*, a.area_name')
                    ->select()
                    ->toArray();

                $this->view->assign('info', checkData($info));
                $this->view->assign('buildings', $buildings);
                return $this->display('unit_update');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        } else {
            $unit_id = $this->request->post('unit_id', 0, 'intval');

            // 权限检查
            $where = ['unit_id' => $unit_id];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }
            $exists = Db::name('units')->where($where)->find();
            if (!$exists) {
                return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
            }

            $building_id = $this->request->post('building_id', 0, 'intval');

            // 验证楼栋权限
            $buildingWhere = ['building_id' => $building_id];
            if (session('admin.role') != 1) {
                $buildingWhere['user_id'] = session('admin.user_id');
            }
            $building = Db::name('buildings')->where($buildingWhere)->find();
            if (!$building) {
                return json(['status' => '01', 'msg' => '楼栋不存在或无权限操作']);
            }

            $unit_code = trim($this->request->post('unit_code', ''));

            $data = [
                'building_id' => $building_id,
                'area_id' => $building['area_id'],
                'unit_name' => trim($this->request->post('unit_name')),
                'unit_code' => empty($unit_code) ? null : $unit_code,
                'floors' => $this->request->post('floors', 0, 'intval'),
                'room_count' => $this->request->post('room_count', 0, 'intval'),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'update_time' => time()
            ];

            try {
                Db::name('units')->where('unit_id', $unit_id)->update($data);
                return json(['status' => '00', 'msg' => '更新成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '更新失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 删除单元
     */
    public function unitDelete()
    {
        $unit_id = $this->request->post('unit_id', 0, 'intval');
        if (!$unit_id) {
            return json(['status' => '01', 'msg' => '参数错误']);
        }

        // 权限检查
        $where = ['unit_id' => $unit_id];
        if (session('admin.role') != 1) {
            $where['user_id'] = session('admin.user_id');
        }
        $exists = Db::name('units')->where($where)->find();
        if (!$exists) {
            return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
        }

        $roomCount = Db::name('rooms')
            ->where('unit_id', $unit_id)
            ->where('deleted_at', 'exp', 'is null')
            ->count();

        if ($roomCount > 0) {
            return json(['status' => '01', 'msg' => '该单元下还有房号，无法删除']);
        }

        try {
            Db::name('units')->where('unit_id', $unit_id)->update(['deleted_at' => time()]);
            return json(['status' => '00', 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => '删除失败: ' . $e->getMessage()]);
        }
    }

    // ==================== 房号管理 ====================

    /**
     * 房号列表
     */
    public function roomIndex()
    {
        if (!$this->request->isAjax()) {
            // 获取当前管理员的单元列表
            $unitWhere = [];
            if (session('admin.role') != 1) {
                $unitWhere['u.user_id'] = session('admin.user_id');
            }
            $units = Db::name('units')
                ->alias('u')
                ->join('buildings b', 'u.building_id = b.building_id')
                ->join('areas a', 'u.area_id = a.area_id')
                ->where($unitWhere)
                ->where('u.deleted_at', 'exp', 'is null')
                ->field('u.unit_id, u.unit_name, b.building_name, a.area_name')
                ->select()
                ->toArray();
            $this->view->assign('units', $units);
            return $this->display('room_index');
        } else {
            $limit = $this->request->post('limit', 20, 'intval');
            $offset = $this->request->post('offset', 0, 'intval');
            $page = floor($offset / $limit) + 1;

            $unit_id = $this->request->param('unit_id', '');
            $keyword = $this->request->param('keyword', '');

            $query = Db::name('rooms')
                ->alias('r')
                ->join('units u', 'r.unit_id = u.unit_id')
                ->join('buildings b', 'r.building_id = b.building_id')
                ->join('areas a', 'r.area_id = a.area_id');

            // 权限控制
            if (session('admin.role') != 1) {
                $query->where('r.user_id', session('admin.user_id'));
            }

            if ($unit_id) {
                $query->where('r.unit_id', $unit_id);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->whereOr('r.room_number', 'like', "%{$keyword}%")
                      ->whereOr('r.owner_name', 'like', "%{$keyword}%");
                });
            }
            $query->where('r.deleted_at', 'exp', 'is null');

            // 先获取SQL语句用于调试
            $debugSql = $query->field('r.*, u.unit_name, b.building_name, a.area_name')
                ->order('r.floor', 'asc')
                ->order('r.room_number', 'asc')
                ->page($page, $limit)
                ->fetchSql(true)
                ->select();

            $list = $query->field('r.*, u.unit_name, b.building_name, a.area_name')
                ->order('r.floor', 'asc')
                ->order('r.room_number', 'asc')
                ->page($page, $limit)
                ->select()
                ->toArray();

            foreach ($list as &$item) {
                $item['member_count'] = Db::name('member_rooms')
                    ->where('room_id', $item['room_id'])
                    ->where('deleted_at', 'exp', 'is null')
                    ->count();
            }

            // 重新构建查询获取总数
            $totalQuery = Db::name('rooms')
                ->alias('r')
                ->join('units u', 'r.unit_id = u.unit_id')
                ->join('buildings b', 'r.building_id = b.building_id')
                ->join('areas a', 'r.area_id = a.area_id');

            if (session('admin.role') != 1) {
                $totalQuery->where('r.user_id', session('admin.user_id'));
            }
            if ($unit_id) {
                $totalQuery->where('r.unit_id', $unit_id);
            }
            if ($keyword) {
                $totalQuery->where(function($q) use ($keyword) {
                    $q->whereOr('r.room_number', 'like', "%{$keyword}%")
                      ->whereOr('r.owner_name', 'like', "%{$keyword}%");
                });
            }
            $totalQuery->where('r.deleted_at', 'exp', 'is null');

            $total = $totalQuery->count();

            $data['rows'] = $list;
            $data['total'] = $total;
            $data['debug'] = [
                'sql' => $debugSql,
                'admin_role' => session('admin.role'),
                'admin_user_id' => session('admin.user_id')
            ];
            return json($data);
        }
    }

    /**
     * 添加房号
     */
    public function roomAdd()
    {
        if (!$this->request->isPost()) {
            // 获取当前管理员的单元列表
            $unitWhere = [];
            if (session('admin.role') != 1) {
                $unitWhere['u.user_id'] = session('admin.user_id');
            }
            $units = Db::name('units')
                ->alias('u')
                ->join('buildings b', 'u.building_id = b.building_id')
                ->join('areas a', 'u.area_id = a.area_id')
                ->where($unitWhere)
                ->where('u.deleted_at', 'exp', 'is null')
                ->field('u.*, b.building_name, a.area_name')
                ->select()
                ->toArray();
            $this->view->assign('units', $units);
            return $this->display('room_add');
        } else {
            $unit_id = $this->request->post('unit_id', 0, 'intval');
            if (!$unit_id) {
                return json(['status' => '01', 'msg' => '请选择单元']);
            }

            // 验证单元是否属于当前管理员
            $unitWhere = ['unit_id' => $unit_id];
            if (session('admin.role') != 1) {
                $unitWhere['user_id'] = session('admin.user_id');
            }
            $unit = Db::name('units')->where($unitWhere)->find();
            if (!$unit) {
                return json(['status' => '01', 'msg' => '单元不存在或无权限操作']);
            }

            $room_code = trim($this->request->post('room_code', ''));

            // 如果没有填写房号编码，自动生成
            if (empty($room_code)) {
                $room_code = 'ROOM' . substr(time(), -6) . rand(10, 99);
            }

            $data = [
                'user_id' => session('admin.user_id'), // 自动设置当前管理员ID
                'unit_id' => $unit_id,
                'building_id' => $unit['building_id'],
                'area_id' => $unit['area_id'],
                'room_number' => trim($this->request->post('room_number')),
                'room_code' => $room_code,
                'floor' => $this->request->post('floor', 0, 'intval'),
                'room_type' => $this->request->post('room_type', 'residential'),
                'area_size' => $this->request->post('area_size', 0),
                'owner_name' => $this->request->post('owner_name', ''),
                'owner_phone' => $this->request->post('owner_phone', ''),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'create_time' => time()
            ];

            if (empty($data['room_number'])) {
                return json(['status' => '01', 'msg' => '房号不能为空']);
            }

            try {
                Db::name('rooms')->insert($data);
                return json(['status' => '00', 'msg' => '添加成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '添加失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 编辑房号
     */
    public function roomUpdate()
    {
        if (!$this->request->isPost()) {
            $room_id = $this->request->get('room_id', 0, 'intval');
            if (!$room_id) $this->error('参数错误');

            try {
                $where = ['r.room_id' => $room_id];
                if (session('admin.role') != 1) {
                    $where['r.user_id'] = session('admin.user_id');
                }

                $info = Db::name('rooms')
                    ->alias('r')
                    ->join('units u', 'r.unit_id = u.unit_id')
                    ->join('buildings b', 'r.building_id = b.building_id')
                    ->join('areas a', 'r.area_id = a.area_id')
                    ->where($where)
                    ->field('r.*, u.unit_name, b.building_name, a.area_name')
                    ->find();

                if (!$info) $this->error('数据不存在或无权限操作');

                // 获取当前管理员的单元列表
                $unitWhere = [];
                if (session('admin.role') != 1) {
                    $unitWhere['u.user_id'] = session('admin.user_id');
                }
                $units = Db::name('units')
                    ->alias('u')
                    ->join('buildings b', 'u.building_id = b.building_id')
                    ->join('areas a', 'u.area_id = a.area_id')
                    ->where($unitWhere)
                    ->where('u.deleted_at', 'exp', 'is null')
                    ->field('u.*, b.building_name, a.area_name')
                    ->select()
                    ->toArray();

                $this->view->assign('info', checkData($info));
                $this->view->assign('units', $units);
                return $this->display('room_update');
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        } else {
            $room_id = $this->request->post('room_id', 0, 'intval');

            // 权限检查
            $where = ['room_id' => $room_id];
            if (session('admin.role') != 1) {
                $where['user_id'] = session('admin.user_id');
            }
            $exists = Db::name('rooms')->where($where)->find();
            if (!$exists) {
                return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
            }

            $unit_id = $this->request->post('unit_id', 0, 'intval');

            // 验证单元权限
            $unitWhere = ['unit_id' => $unit_id];
            if (session('admin.role') != 1) {
                $unitWhere['user_id'] = session('admin.user_id');
            }
            $unit = Db::name('units')->where($unitWhere)->find();
            if (!$unit) {
                return json(['status' => '01', 'msg' => '单元不存在或无权限操作']);
            }

            $room_code = trim($this->request->post('room_code', ''));

            $data = [
                'unit_id' => $unit_id,
                'building_id' => $unit['building_id'],
                'area_id' => $unit['area_id'],
                'room_number' => trim($this->request->post('room_number')),
                'room_code' => empty($room_code) ? null : $room_code,
                'floor' => $this->request->post('floor', 0, 'intval'),
                'room_type' => $this->request->post('room_type', 'residential'),
                'area_size' => $this->request->post('area_size', 0),
                'owner_name' => $this->request->post('owner_name', ''),
                'owner_phone' => $this->request->post('owner_phone', ''),
                'description' => $this->request->post('description', ''),
                'status' => $this->request->post('status', 1),
                'update_time' => time()
            ];

            try {
                Db::name('rooms')->where('room_id', $room_id)->update($data);
                return json(['status' => '00', 'msg' => '更新成功']);
            } catch (\Exception $e) {
                return json(['status' => '01', 'msg' => '更新失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 删除房号
     */
    public function roomDelete()
    {
        $room_id = $this->request->post('room_id', 0, 'intval');
        if (!$room_id) {
            return json(['status' => '01', 'msg' => '参数错误']);
        }

        // 权限检查
        $where = ['room_id' => $room_id];
        if (session('admin.role') != 1) {
            $where['user_id'] = session('admin.user_id');
        }
        $exists = Db::name('rooms')->where($where)->find();
        if (!$exists) {
            return json(['status' => '01', 'msg' => '数据不存在或无权限操作']);
        }

        $memberCount = Db::name('member_rooms')
            ->where('room_id', $room_id)
            ->where('deleted_at', 'exp', 'is null')
            ->count();

        if ($memberCount > 0) {
            return json(['status' => '01', 'msg' => '该房号下还有绑定的用户，请先解绑']);
        }

        try {
            Db::name('rooms')->where('room_id', $room_id)->update(['deleted_at' => time()]);
            return json(['status' => '00', 'msg' => '删除成功']);
        } catch (\Exception $e) {
            return json(['status' => '01', 'msg' => '删除失败: ' . $e->getMessage()]);
        }
    }

    /**
     * 批量生成房号页面
     */
    public function roomBatchGenerate()
    {
        if (!$this->request->isPost()) {
            // 获取当前管理员的单元列表
            $unitWhere = [];
            if (session('admin.role') != 1) {
                $unitWhere['u.user_id'] = session('admin.user_id');
            }
            $units = Db::name('units')
                ->alias('u')
                ->join('buildings b', 'u.building_id = b.building_id')
                ->join('areas a', 'u.area_id = a.area_id')
                ->where($unitWhere)
                ->where('u.deleted_at', 'exp', 'is null')
                ->field('u.*, b.building_name, a.area_name')
                ->select()
                ->toArray();
            $this->view->assign('units', $units);
            return $this->display('room_batch_generate');
        } else {
            $unit_id = $this->request->post('unit_id', 0, 'intval');
            $start_floor = $this->request->post('start_floor', 1, 'intval');
            $end_floor = $this->request->post('end_floor', 1, 'intval');
            $rooms_per_floor = $this->request->post('rooms_per_floor', 1, 'intval');
            $number_format = $this->request->post('number_format', 'standard'); // standard, prefix, custom
            $prefix = $this->request->post('prefix', '');
            $separator = $this->request->post('separator', ''); // 分隔符，如 '-'

            if (!$unit_id) {
                return json(['status' => '01', 'msg' => '请选择单元']);
            }

            if ($start_floor > $end_floor) {
                return json(['status' => '01', 'msg' => '起始楼层不能大于结束楼层']);
            }

            if ($rooms_per_floor < 1) {
                return json(['status' => '01', 'msg' => '每层房间数至少为1']);
            }

            // 验证单元是否属于当前管理员
            $unitWhere = ['unit_id' => $unit_id];
            if (session('admin.role') != 1) {
                $unitWhere['user_id'] = session('admin.user_id');
            }
            $unit = Db::name('units')->where($unitWhere)->find();
            if (!$unit) {
                return json(['status' => '01', 'msg' => '单元不存在或无权限操作']);
            }

            try {
                Db::startTrans();

                $created_count = 0;
                $skipped_count = 0;

                for ($floor = $start_floor; $floor <= $end_floor; $floor++) {
                    for ($room_num = 1; $room_num <= $rooms_per_floor; $room_num++) {
                        // 生成房号
                        $room_number = $this->generateRoomNumber($floor, $room_num, $number_format, $prefix, $separator);

                        // 检查房号是否已存在
                        $exists = Db::name('rooms')
                            ->where('unit_id', $unit_id)
                            ->where('room_number', $room_number)
                            ->where('deleted_at', 'exp', 'is null')
                            ->find();

                        if ($exists) {
                            $skipped_count++;
                            continue;
                        }

                        // 插入房号，自动生成编码
                        $data = [
                            'user_id' => session('admin.user_id'),
                            'unit_id' => $unit_id,
                            'building_id' => $unit['building_id'],
                            'area_id' => $unit['area_id'],
                            'room_number' => $room_number,
                            'room_code' => 'ROOM' . substr(time(), -6) . rand(10, 99),
                            'floor' => $floor,
                            'room_type' => 'residential',
                            'area_size' => 0,
                            'owner_name' => '',
                            'owner_phone' => '',
                            'description' => '批量生成',
                            'status' => 1,
                            'create_time' => time()
                        ];

                        Db::name('rooms')->insert($data);
                        $created_count++;
                    }
                }

                Db::commit();

                $msg = "成功生成 {$created_count} 个房号";
                if ($skipped_count > 0) {
                    $msg .= "，跳过 {$skipped_count} 个已存在的房号";
                }

                return json(['status' => '00', 'msg' => $msg]);
            } catch (\Exception $e) {
                Db::rollback();
                return json(['status' => '01', 'msg' => '生成失败: ' . $e->getMessage()]);
            }
        }
    }

    /**
     * 生成房号
     * @param int $floor 楼层
     * @param int $room_num 房间号
     * @param string $format 格式 standard|prefix|custom
     * @param string $prefix 前缀
     * @param string $separator 分隔符
     * @return string
     */
    private function generateRoomNumber($floor, $room_num, $format, $prefix = '', $separator = '')
    {
        switch ($format) {
            case 'prefix':
                // 前缀模式: A101, B201
                return $prefix . $floor . str_pad($room_num, 2, '0', STR_PAD_LEFT);

            case 'separator':
                // 分隔符模式: 1-01, 2-02
                return $floor . $separator . str_pad($room_num, 2, '0', STR_PAD_LEFT);

            case 'custom':
                // 自定义模式: 前缀 + 楼层 + 分隔符 + 房号
                $result = '';
                if ($prefix) {
                    $result .= $prefix;
                }
                $result .= $floor;
                if ($separator) {
                    $result .= $separator;
                }
                $result .= str_pad($room_num, 2, '0', STR_PAD_LEFT);
                return $result;

            case 'standard':
            default:
                // 标准模式: 101, 102, 201, 202
                return $floor . str_pad($room_num, 2, '0', STR_PAD_LEFT);
        }
    }

    // ==================== 数据迁移功能 ====================

    /**
     * 数据迁移页面
     */
    public function migration()
    {
        if (!$this->request->isPost()) {
            return $this->display('migration');
        } else {
            $action = $this->request->post('action');

            if ($action == 'check') {
                // 检查迁移状态
                $status = \app\module\areaMigration\AreaMigration::checkMigrationStatus();
                return json(['status' => '00', 'data' => $status]);
            }

            if ($action == 'batch') {
                // 批量迁移
                $batchSize = $this->request->post('batch_size', 50, 'intval');
                $offset = $this->request->post('offset', 0, 'intval');

                $result = \app\module\areaMigration\AreaMigration::migrateBatch($batchSize, $offset);

                if ($result['success']) {
                    return json(['status' => '00', 'data' => $result]);
                } else {
                    return json(['status' => '01', 'msg' => $result['msg']]);
                }
            }

            if ($action == 'all') {
                // 一键迁移（小数据量）
                $result = \app\module\areaMigration\AreaMigration::migrateAll();

                if ($result['success']) {
                    return json(['status' => '00', 'data' => $result['data']]);
                } else {
                    return json(['status' => '01', 'msg' => $result['msg']]);
                }
            }
        }
    }
}
