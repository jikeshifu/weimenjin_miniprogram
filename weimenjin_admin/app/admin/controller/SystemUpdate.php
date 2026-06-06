<?php

namespace app\admin\controller;

use app\admin\service\SystemUpdateService;

class SystemUpdate extends Admin
{
    public function index()
    {
        $this->view->assign('currentVersion', SystemUpdateService::currentVersion());
        $this->view->assign('manifestUrl', config('my.update.manifest_url', SystemUpdateService::defaultManifestUrl()) ?: SystemUpdateService::defaultManifestUrl());
        return $this->display('index');
    }

    public function check()
    {
        try {
            $this->assertFounder();
            $manifestUrl = input('post.manifest_url', '', 'trim');
            $packageUrl = input('post.package_url', '', 'trim');
            $info = SystemUpdateService::check($manifestUrl, $packageUrl);
            return json(['status' => '00', 'msg' => '检测成功', 'data' => $info]);
        } catch (\Throwable $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    public function install()
    {
        try {
            $this->assertFounder();
            $manifestUrl = input('post.manifest_url', '', 'trim');
            $packageUrl = input('post.package_url', '', 'trim');
            $sha256 = input('post.sha256', '', 'trim');
            $result = SystemUpdateService::install($manifestUrl, $packageUrl, $sha256);
            return json(['status' => '00', 'msg' => '更新完成', 'data' => $result]);
        } catch (\Throwable $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    public function logs()
    {
        try {
            $this->assertFounder();
            return json(['status' => '00', 'data' => SystemUpdateService::logs()]);
        } catch (\Throwable $e) {
            return json(['status' => '01', 'msg' => $e->getMessage()]);
        }
    }

    private function assertFounder()
    {
        if (session('admin.role') != 1) {
            throw new \RuntimeException('仅超级管理员可以执行系统更新');
        }
    }
}
