<?php
namespace app\admin\controller;

use app\module\model\AgentApplication;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use think\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Customer extends Admin
{
    function initialize()
    {
        // 权限检查，确保只有超级管理员可以访问
        if (session('admin.role') <> 1) {
            $this->error('你没有操作权限');
        }
    }

    // 显示客户资料列表并支持查询
    // 搜索客户
    public function index(Request $request) {
        if (!$request->isAjax()) {
            // 渲染模板时获取所有客户数据
            $customers = AgentApplication::order('created_at', 'desc')->select();
            $this->assign('customers', $customers);  // 将客户数据传递给视图
            return $this->display('index');  // 渲染 index 模板
        } else {
            // AJAX 请求时，执行查询和分页
            $limit = $request->post('limit', 10, 'intval');
            $offset = $request->post('offset', 0, 'intval');

            $company_name = $request->param('company_name', '', 'trim');
            $contact_phone = $request->param('contact_phone', '', 'trim');

            // 构建查询条件
            $where = [];
            if (!empty($company_name)) {
                $where[] = ['company_name', 'like', "%$company_name%"];  // 使用like构建模糊搜索条件
            }
            if (!empty($contact_phone)) {
                $where[] = ['contact_phone', 'like', "%$contact_phone%"];  // 使用like构建模糊搜索条件
            }

            $customers = AgentApplication::where($where)
                ->limit($offset, $limit)
                ->order('created_at', 'desc')
                ->select()
                ->toArray();

            $total = AgentApplication::where($where)->count();  // 计算总条目数

            return json(['rows' => $customers, 'total' => $total]);
        }
    }


    // 更新客户状态
    public function updateStatus(Request $request) {
        $id = $request->post('id');
        $status = $request->post('status');
        $customer = AgentApplication::find($id);
        if ($customer) {
            $customer->status = $status;
            $customer->save();
            return json(['status' => 'success', 'message' => '状态更新成功']);
        } else {
            return json(['status' => 'error', 'message' => '客户未找到']);
        }
    }

    // 提交合同
    public function submitContract(Request $request) {
        $id = $request->post('id');
        $file = $request->file('contract');

        // 检查是否有文件上传
        if (!$file || !$file->isValid()) {
            return json(['status' => 'error', 'message' => '必须上传有效的合同文件']);
        }

        // 获取客户信息
        $customer = AgentApplication::find($id);
        if (!$customer) {
            return json(['status' => 'error', 'message' => '客户未找到']);
        }

        // 旧的合同路径
        $oldFilePath = app()->getRootPath() . 'public' . $customer->contract_url;

        // 生成新的文件名：年月日 + 6位随机数
        $date = date('Ymd');
        $randomNumber = substr(str_shuffle('0123456789'), 0, 6);
        $extension = $file->extension();  // 使用 extension() 方法获取扩展名
        $newFileName = $date . $randomNumber . '.' . $extension;
        $saveDir = app()->getRootPath() . 'public/uploads/contracts/';
        $finalFilePath = $saveDir . $newFileName;

        // 如果目录不存在，则创建目录
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0755, true);
        }

        // 移动上传的文件
        if (move_uploaded_file($file->getPathname(), $finalFilePath)) {
            // 删除旧的合同文件
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // 删除旧文件
            }

            // 更新数据库记录
            $customer->contract_url = '/uploads/contracts/' . $newFileName;
            $customer->save();

            return json(['status' => 'success', 'message' => '合同更新成功']);
        } else {
            return json(['status' => 'error', 'message' => '合同上传失败']);
        }
    }
    // 更新营业执照
    public function updateLicense(Request $request)
    {
        $id = $request->post('id');
        $file = $request->file('business_license');

        // 检查是否有文件上传
        if (!$file || !$file->isValid()) {
            return json(['status' => 'fail', 'message' => '必须上传有效的营业执照']);
        }

        // 获取客户信息
        $customer = AgentApplication::find($id);
        if (!$customer) {
            return json(['status' => 'error', 'message' => '客户未找到']);
        }

        // 旧的营业执照路径
        $oldFilePath = app()->getRootPath() . 'public' . $customer->business_license;

        // 文件上传处理
        $extension = $file->extension();
        $savePath = app()->getRootPath() . 'public/uploads/licenses/';

        // 如果目录不存在，则创建目录
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }

        // 生成文件名：年月日 + 6位随机数
        $date = date('Ymd');
        $randomNumber = substr(str_shuffle('0123456789'), 0, 6);
        $fileName = $date . $randomNumber . '.' . $extension;
        $finalFilePath = $savePath . $fileName;

        // 移动上传的文件
        if (move_uploaded_file($file->getPathname(), $finalFilePath)) {
            // 删除旧的营业执照文件
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath); // 删除旧文件
            }

            // 保存新文件路径到数据库
            $customer->business_license = '/uploads/licenses/' . $fileName;
            $customer->save();

            return json(['status' => 'success', 'message' => '营业执照更新成功']);
        } else {
            return json(['status' => 'fail', 'message' => '营业执照上传失败']);
        }
    }


    // 获取单个客户信息，便于在编辑时回显
    public function getCustomerInfo(Request $request) {
        $id = $request->get('id');
        $customer = AgentApplication::find($id);

        if ($customer) {
            return json($customer);
        } else {
            return json(['status' => 'error', 'message' => '客户未找到']);
        }
    }

    // 更新客户信息
    public function updateCustomer(Request $request) {
        $id = $request->post('id');
        $customer = AgentApplication::find($id);
        if ($customer) {
            $customer->company_name = $request->post('company_name');
            $customer->credit_code = $request->post('credit_code');
            $customer->office_address = $request->post('office_address');
            $customer->contact_name = $request->post('contact_name');
            $customer->contact_phone = $request->post('contact_phone');
            $customer->contact_email = $request->post('contact_email');
            $customer->business_industry = $request->post('business_industry');
            $customer->save();
            return json(['status' => 'success', 'message' => '客户信息更新成功']);
        } else {
            return json(['status' => 'error', 'message' => '客户未找到']);
        }
    }
    public function generateContract(Request $request)
    {
        $customerId = $request->post('id');

        // 查询客户信息
        $customer = AgentApplication::find($customerId);
        if (!$customer) {
            return json(['status' => 'fail', 'message' => '客户信息不存在']);
        }

        // 模板文件路径
        $templatePath = app()->getRootPath() . 'public/contracts/templates/contract_template.xlsx';
        if (!file_exists($templatePath)) {
            return json(['status' => 'fail', 'message' => '合同模板不存在']);
        }

        // 读取 Excel 模板
        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 将客户信息插入到指定单元格中
        // 设置公司名称、统一社会信用代码、办公地址、联系人姓名、电话等信息
        $sheet->setCellValue('C3', $customer->company_name);
        $sheet->setCellValue('C31', $customer->company_name);
        $sheet->setCellValue('C34', $customer->credit_code);
        $sheet->setCellValue('C33', $customer->office_address);
        $sheet->setCellValue('C32', $customer->contact_name);
        $sheet->setCellValue('C37', $customer->contact_phone);
        $sheet->setCellValue('P4', date('Y-m-d'));

// 设置 G2 为字符串并靠左对齐
        $sheet->setCellValueExplicit('P3', $customer->user_id . time(), DataType::TYPE_STRING);
        $sheet->getStyle('P3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// 使其他单元格内容靠左对齐
        $leftAlignedCells = ['C3', 'C31', 'C32', 'C33', 'C34', 'C37', 'P4'];
        foreach ($leftAlignedCells as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }
        // 合同保存路径
        $savePath = app()->getRootPath() . 'public/contracts/generated/';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }

        // 生成文件名：客户ID + 当前日期 + 随机数
        $fileName = 'contract_' . $customer->user_id . '_' . date('Ymd') . '_' . substr(str_shuffle('0123456789'), 0, 6) . '.xlsx';
        $filePath = $savePath . $fileName;

        // 保存生成的合同
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // 返回生成的合同下载链接
        return json(['status' => 'success', 'message' => '合同已生成', 'download_url' => '/contracts/generated/' . $fileName]);
    }
}
