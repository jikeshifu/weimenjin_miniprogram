<?php

namespace app\admin\controller;

class QrCodeLogin extends Admin
{
    public function index()
    {
        $this->view->assign('key', input('get.key', '', 'trim'));
        return $this->display('qrcode_login_tip');
    }
}
