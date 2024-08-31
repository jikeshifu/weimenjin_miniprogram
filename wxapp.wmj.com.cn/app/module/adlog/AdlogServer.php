<?php
namespace app\module\adlog;
class AdlogServer
{
    static function Add($member_id,$adlog_page,$adlog_type,$adlog_adtime,$adlog_result,$adlog_msg,$adlog_points)
    {
        $data['member_id'] = $member_id;
        $data['adlog_page'] = $adlog_page;
        $data['adlog_type'] = $adlog_type;
        $data['adlog_adtime'] = $adlog_adtime;
        $data['adlog_result'] = $adlog_result;
        $data['adlog_msg'] = $adlog_msg;
        $data['adlog_points'] = $adlog_points;
        $data['adlog_createtime'] = time();
        db()->name('adlog')->insert($data);
    }

    static function GetPoints($member_id){
       return db()->name('adlog')->where('member_id', $member_id)->sum('adlog_points');
    }
    static function GetCountShow(){
        // 确定当天开始的时间戳（00:00:00）
        $todayStart = strtotime(date('Y-m-d 00:00:00'));
        // 确定当天结束的时间戳（23:59:59）
        $todayEnd = strtotime(date('Y-m-d 23:59:59'));
        // 统计当天adlog_msg为“激励视频广告展示成功”且在当天内的记录数
        $countshow = db()->name('adlog')
            ->where('adlog_msg', '激励视频广告展示成功')
            // 在当天开始和结束的时间戳范围内筛选记录
            ->where('adlog_createtime', '>=', $todayStart)
            ->where('adlog_createtime', '<=', $todayEnd)
            ->count();
        return $countshow;
    }
    static function GetComplete(){
       // 确定当天开始的时间戳（00:00:00）
        $todayStart = strtotime(date('Y-m-d 00:00:00'));
        // 确定当天结束的时间戳（23:59:59）
        $todayEnd = strtotime(date('Y-m-d 23:59:59'));
        // 统计当天adlog_msg为“激励视频广告展示成功”且在当天内的记录数
        $countcomplete = db()->name('adlog')
            ->where('adlog_msg', '用户完整观看广告')
            // 在当天开始和结束的时间戳范围内筛选记录
            ->where('adlog_createtime', '>=', $todayStart)
            ->where('adlog_createtime', '<=', $todayEnd)
            ->count();
        return $countcomplete;
    }
}
