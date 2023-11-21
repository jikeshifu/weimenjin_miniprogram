<?php
declare (strict_types = 1);

namespace app\command;

use app\module\code\Code;
use app\module\hardwareCloud\HardwareCloud;
use app\module\lockServer\Lock;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Db;

class FaceAdd extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('faceAdd')
            ->setDescription('the faceAdd command');
    }

    protected function execute(Input $input, Output $output)
    {
    	// 指令输出
    	$output->writeln('faceAdd');


        while (true) {

            $lockcard = Db::name("face")->where(["sync_status" => 0])->whereNull("deleted_at ")->where("sync_time","<",time())->limit(10)->select()->toArray();

            if (!$lockcard) {
                print_r("任务结束休眠10秒");
                sleep(10);
            }
            foreach ($lockcard as $vo) {

                $lockdata = Lock::Info($vo["lock_id"]);
                if(!$lockdata){
                    Db::name("face")->where(["face_id"=>$vo["face_id"]])->update(["sync_status"=>1]);


                    continue ;

                }

                $addres = HardwareCloud::Face()->Add($lockdata["lock_sn"], $vo["sCertificateNumber"], "https://wxapp.wmj.com.cn" . $vo["face_images"], $vo["end_time"], $vo["face_name"]);

                $updata = [];
                $updata["sync_time"] = time()+600;
                if ($addres["err"]) {
                    print_r($addres);
                    $updata["remark"] = $addres["err"];

                }else{
                    $updata["sync_status"] = 1;
                    if ($addres["res"]["data"]["info"]["stateCode"] == 203) {
                        $updata["existCertificateNumber"]= $addres["res"]["data"]["info"]["existCertificateNumber"];
                    }

                }




                if ($updata) {
                    Db::name("face")->where(["face_id"=>$vo["face_id"]])->update($updata);
                }

            }


        }
    }
}
