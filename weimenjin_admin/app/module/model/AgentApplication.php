<?php
namespace app\module\model;

use think\Model;

class AgentApplication extends Model
{
    protected $table = 'cd_agent_applications';
    protected $autoWriteTimestamp = true;  // 自动写入时间戳
}
