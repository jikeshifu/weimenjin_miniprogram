<?php
/*
 module:		区域管理数据库模型
 create_time:	2025-10-14
 author:		System
*/

namespace xhadmin\db;

use think\facade\Db;

class AreaManage
{
    /**
     * 获取区域列表
     */
    public function getAreas($where = [], $page = 1, $limit = 20)
    {
        $query = Db::name('areas')->whereNull('deleted_at');

        if (isset($where['keyword']) && !empty($where['keyword'])) {
            $query->whereLike('area_name|area_code', "%{$where['keyword']}%");
        }

        return $query->order('create_time', 'desc')
            ->page($page, $limit)
            ->select();
    }

    /**
     * 获取区域总数
     */
    public function getAreasCount($where = [])
    {
        $query = Db::name('areas')->whereNull('deleted_at');

        if (isset($where['keyword']) && !empty($where['keyword'])) {
            $query->whereLike('area_name|area_code', "%{$where['keyword']}%");
        }

        return $query->count();
    }

    /**
     * 获取楼栋列表
     */
    public function getBuildings($where = [], $page = 1, $limit = 20)
    {
        $query = Db::name('buildings')
            ->alias('b')
            ->join('areas a', 'b.area_id = a.area_id')
            ->whereNull('b.deleted_at');

        if (isset($where['area_id']) && !empty($where['area_id'])) {
            $query->where('b.area_id', $where['area_id']);
        }

        if (isset($where['keyword']) && !empty($where['keyword'])) {
            $query->whereLike('b.building_name|b.building_code', "%{$where['keyword']}%");
        }

        return $query->field('b.*, a.area_name')
            ->order('b.create_time', 'desc')
            ->page($page, $limit)
            ->select();
    }

    /**
     * 获取单元列表
     */
    public function getUnits($where = [], $page = 1, $limit = 20)
    {
        $query = Db::name('units')
            ->alias('u')
            ->join('buildings b', 'u.building_id = b.building_id')
            ->join('areas a', 'u.area_id = a.area_id')
            ->whereNull('u.deleted_at');

        if (isset($where['building_id']) && !empty($where['building_id'])) {
            $query->where('u.building_id', $where['building_id']);
        }

        if (isset($where['keyword']) && !empty($where['keyword'])) {
            $query->whereLike('u.unit_name|u.unit_code', "%{$where['keyword']}%");
        }

        return $query->field('u.*, b.building_name, a.area_name')
            ->order('u.create_time', 'desc')
            ->page($page, $limit)
            ->select();
    }

    /**
     * 获取房号列表
     */
    public function getRooms($where = [], $page = 1, $limit = 20)
    {
        $query = Db::name('rooms')
            ->alias('r')
            ->join('units u', 'r.unit_id = u.unit_id')
            ->join('buildings b', 'r.building_id = b.building_id')
            ->join('areas a', 'r.area_id = a.area_id')
            ->whereNull('r.deleted_at');

        if (isset($where['unit_id']) && !empty($where['unit_id'])) {
            $query->where('r.unit_id', $where['unit_id']);
        }

        if (isset($where['keyword']) && !empty($where['keyword'])) {
            $query->whereLike('r.room_number|r.owner_name', "%{$where['keyword']}%");
        }

        return $query->field('r.*, u.unit_name, b.building_name, a.area_name')
            ->order('r.floor', 'asc')
            ->order('r.room_number', 'asc')
            ->page($page, $limit)
            ->select();
    }
}
