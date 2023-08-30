<?php
$result1="cd /www/wwwroot/wxapp.wmj.com.cn/app/api&&apidoc -i ./ -o /www/wwwroot/wxapp.wmj.com.cn/public/doc";
exec($result1,$res,$ret);
if($ret == "0")
{
  echo "生成文档成功";
}
else
{
  echo "生成文档失败";
  echo $ret;
}
