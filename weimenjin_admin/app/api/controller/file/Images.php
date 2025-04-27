<?php


namespace app\api\controller\file;
use think\Image;

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
        } catch (\think\exception\ValidateException $e)
        {
            return json([
                "msg" => $e->getMessage(),
                "code" => 1000,
            ]);
        }

        $url = "/uploads/" . $savename[0];
//        $filePath = public_path() . $url; // 获取文件真实路径
//        $imageInfo = getimagesize($filePath);
//        if ($imageInfo === false) {
//            return json([
//                "data" => "图片无效",
//                "code" => 1,
//            ]);
//        }
//        $image = Image::open($filePath);
//        $image->save($filePath, null, 75);
        return json([
            "data" => $url,
            "code" => 0,
        ]);
    }
}
