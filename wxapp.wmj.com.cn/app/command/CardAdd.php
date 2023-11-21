<?php
declare (strict_types=1);

namespace app\command;

use app\module\code\Code;
use app\module\lockServer\Lock;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Db;

class CardAdd extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('cardAdd')
            ->setDescription('the cardAdd command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('cardAdd');

        while (true) {

            $lockcard = Db::name("lockcard")->where(["sync_status" => 0])->whereNull("deleted_at ")->where("sync_time", "<", time())->limit(10)->select()->toArray();
            if (!$lockcard) {
                sleep(10);
            }
            foreach ($lockcard as $vo) {

                $lockdata = Lock::Info($vo["lock_id"]);
                if (!$lockdata) {
                    Db::name("lockcard")->where(["lockcard_id" => $vo["lockcard_id"]])->update(["sync_status" => 1]);
                    continue;
                }
                $updata = [];
                $updata["sync_time"] = time() + 600;
                Db::name("lockcard")->where(["lockcard_id" => $vo["lockcard_id"]])->update($updata);
                $result = Lock::CardAdd($lockdata, $vo['lockcard_sn'], $vo['lockcard_endtime']);

                if ($result["state"] == 1) {
                    $updata["sync_status"] = 1;


                } else {
                    $updata["remark"] = $result['state_msg'];
                }

                if ($updata) {
                    Db::name("lockcard")->where(["lockcard_id" => $vo["lockcard_id"]])->update($updata);
                }

            }


        }


    }
}
