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
        $this->setName('weikaimenfaceAdd')
            ->setDescription('the weikaimenfaceAdd command');
    }

    protected function execute(Input $input, Output $output)
    {
    	// 指令输出
    	$output->writeln('weikaimenfaceAdd');
        while (true) {
            $lockface = Db::name("face")->where(["sync_status" => 0])->whereNull("deleted_at ")->select()->toArray();
            sleep(10);
            mlog("开始处理1：","exeaddface.txt");
            if (!$lockface) {
                sleep(10);
            }
            foreach ($lockface as $vo) {
                $lockdata = Lock::Info($vo["lock_id"]);
                if(!$lockdata){
                    Db::name("face")->where(["face_id"=>$vo["face_id"]])->update(["sync_status"=>1]);
                    continue ;
                }
                if(HardwareCloud::App()->OnLineGet($lockdata["lock_sn"]))
                {
                    if($vo["face_feature"])
                    {
                        $addres = HardwareCloud::Face()->AddFeature($lockdata["lock_sn"], $vo["sCertificateNumber"], $vo["face_feature"], $vo["end_time"], $vo["face_name"]);
                    }
                    else
                    {
                        $addres = HardwareCloud::Face()->Add($lockdata["lock_sn"], $vo["sCertificateNumber"], config("my.siteconfig.siteurl"). $vo["face_images"], $vo["end_time"], $vo["face_name"]);
                    }
                    //mlog(json_encode($addres,JSON_UNESCAPED_UNICODE),"exeaddface.txt");
                    $updata = [];
                    $updata["sync_time"] = time()+600;

                    if ($addres["err"]) {
                        //处理错误情况
                        mlog("处理错误2：","exeaddface.txt");
                        mlog(json_encode($addres,JSON_UNESCAPED_UNICODE),"exeaddface.txt");
                        $updata["remark"] = $addres["err"];
                    }
                    else
                    {
                        mlog("通信正常3：","exeaddface.txt");
                        //处理已注册情况
                        if (isset($addres["res"]["data"]["info"]) && $addres["res"]["data"]["info"]["stateCode"]==203)
                        {
                            mlog("处理已注册4：".$addres["res"]["data"]["info"]["repeat_face_id"],"exeaddface.txt");
                            $delres = HardwareCloud::Face()->Del($lockdata["lock_sn"],$addres["res"]["data"]["info"]["repeat_face_id"]);
                            mlog(json_encode($delres,JSON_UNESCAPED_UNICODE),"exeaddface.txt");
                            if (isset($delres["res"]["data"]["info"]["code"])&&$delres["res"]["data"]["info"]["code"]==0)
                            {
                                Db::name("face")->where(["sCertificateNumber" => $addres["res"]["data"]["info"]["repeat_face_id"]])->delete();

                                if($vo["face_feature"])
                                {
                                    $addres = HardwareCloud::Face()->AddFeature($lockdata["lock_sn"], $vo["sCertificateNumber"], $vo["face_feature"], $vo["end_time"], $vo["face_name"]);
                                }
                                else
                                {
                                    $addres = HardwareCloud::Face()->Add($lockdata["lock_sn"], $vo["sCertificateNumber"], config("my.siteconfig.siteurl"). $vo["face_images"], $vo["end_time"], $vo["face_name"]);
                                }
                                if(isset($addres["res"]["data"]["info"]["code"])&&$addres["res"]["data"]["info"]["code"]==0)
                                {
                                    $updata["sync_status"] = 1;
                                    if (isset($addres["res"]["data"]["info"]["feature"])) {
                                        $updata["face_feature"]= $addres["res"]["data"]["info"]["feature"];
                                    }
                                }
                            }
                        }
                        else
                        {

                            $updata["sync_status"] = 1;
                            if (isset($addres["res"]["data"]["info"]["feature"])) {
                                $updata["face_feature"]= $addres["res"]["data"]["info"]["feature"];
                            }
                        }

                    }
                    if ($updata) {
                        Db::name("face")->where(["face_id"=>$vo["face_id"]])->update($updata);
                    }
                }
                else
                {
                    mlog("设备不在线5","exeaddface.txt");
                }


            }


        }
    }
}
