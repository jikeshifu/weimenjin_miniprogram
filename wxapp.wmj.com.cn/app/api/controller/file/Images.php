<?php


namespace app\api\controller\file;


class Images
{
    public function upload()
    {


        // 获取表单上传文件
        $files = request()->file();
        try {
            validate(['image' => 'fileExt:jpg,png,jpeg'])
                ->check($files);
            $savename = [];
            foreach ($files as $file) {
                $savename[] = \think\facade\Filesystem::disk('public')->putFile('topic', $file);
            }
        } catch (\think\exception\ValidateException $e) {


            return json([
                "msg" => $e->getMessage(),
                "code" => 1000,
            ]);
        }

        $url = "/uploads/" . $savename[0];
        return json([
            "data" => $url,

            "code" => 0,
        ]);
    }
}
