<?php
namespace app\admin\controller;
use think\Request;

use app\module\model\AgentApplication;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf as PdfWriter; // 使用Mpdf来生成PDF
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
class AgentApp extends Admin
{
    // 代理商申请页面
    public function index()
    {
        $admin = session('admin');  // 获取当前登录用户信息
        $userId = $admin['user_id'];

        // 查询该用户的代理商申请记录
        $application = AgentApplication::where('user_id', $userId)->find();

        // 如果有申请数据，传递数据到视图进行回显
        $this->view->assign('application', $application);
        $this->view->assign('user_id', $userId);

        return $this->display('index');
    }
    public function generateContract1(Request $request)
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
        $sheet->setCellValue('C3', $customer->company_name);  // 公司名称
        $sheet->setCellValue('B24', $customer->company_name);  // 公司名称
        $sheet->setCellValue('B27', $customer->credit_code);   // 统一社会信用代码
        $sheet->setCellValue('B26', $customer->office_address);  // 办公地址
        $sheet->setCellValue('B25', $customer->contact_name);  // 联系人姓名
        $sheet->setCellValue('B29', $customer->contact_phone);  // 联系人电话
        $sheet->setCellValue('P4', date('Y-m-d'));  // 合同生成日期

        // 设置 G2 为字符串并靠左对齐
        $sheet->setCellValueExplicit('G2', $customer->user_id . time(), DataType::TYPE_STRING);
        $sheet->getStyle('G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // 左对齐其他单元格
        $leftAlignedCells = ['B2', 'B24', 'B27', 'B26', 'B25', 'B29', 'G3'];
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

        // 将Excel合同转换为PDF
        $pdfFileName = 'contract_' . $customer->user_id . '_' . date('Ymd') . '_' . substr(str_shuffle('0123456789'), 0, 6) . '.pdf';
        $pdfFilePath = $savePath . $pdfFileName;

        // 生成PDF并保存
        $pdfWriter = new PdfWriter($spreadsheet);
        $pdfWriter->save($pdfFilePath);

        // 返回生成的PDF下载链接
        return json(['status' => 'success', 'message' => '合同已生成', 'download_url' => '/contracts/generated/' . $pdfFileName]);
    }
    public function generateContract(Request $request)
    {
        $customerId = $request->post('id');
        $customer = AgentApplication::find($customerId);
        if (!$customer) {
            return json(['status' => 'fail', 'message' => '填写资料提交后即可查看']);
        }

        $templatePath = app()->getRootPath() . 'public/contracts/templates/contract_template.xlsx';
        if (!file_exists($templatePath)) {
            return json(['status' => 'fail', 'message' => '合同模板不存在']);
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // 将客户信息插入到指定单元格中，并设置为左对齐
        $sheet->setCellValue('C3', $customer->company_name);
        $sheet->setCellValue('C31', $customer->company_name);
        $sheet->setCellValue('C34', $customer->credit_code);
        $sheet->setCellValue('C33', $customer->office_address);
        $sheet->setCellValue('C32', $customer->contact_name);
        $sheet->setCellValue('C37', $customer->contact_phone);
        $sheet->setCellValue('P4', date('Y-m-d'));

        // 设置 P3 为字符串并左对齐
        $sheet->setCellValueExplicit('P3', $customer->user_id . time(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->getStyle('P3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // 设置其他单元格左对齐
        $leftAlignedCells = ['C3', 'C31', 'C32', 'C33', 'C34', 'C37', 'P4'];
        foreach ($leftAlignedCells as $cell) {
            $sheet->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }

        $savePath = app()->getRootPath() . 'public/contracts/generated/';
        if (!is_dir($savePath)) {
            mkdir($savePath, 0755, true);
        }

        // 生成 Excel 文件
        $fileName = 'contract_' . $customer->user_id . '_' . date('Ymd') . '_' . substr(str_shuffle('0123456789'), 0, 6) . '.xlsx';
        $filePath = $savePath . $fileName;

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // 生成 PDF 文件
        $pdfFileName = 'contract_' . $customer->user_id . '_' . date('Ymd') . '_' . substr(str_shuffle('0123456789'), 0, 6) . '.pdf';
        $pdfFilePath = $savePath . $pdfFileName;

        // 使用 Mpdf 转换 Excel 到 PDF，并强制左对齐
        $pdfWriter = new PdfWriter($spreadsheet);
        $pdf = new \Mpdf\Mpdf([
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'useSubstitutions' => true,
            'tempDir' => sys_get_temp_dir() . '/mpdf',
        ]);

        // 生成 HTML 并预览内容是否正确对齐
        $html = $pdfWriter->generateHTMLAll();
        $html1 = str_replace(
            '</head>',
            '<style>td, th { text-align: left !important; }</style></head>',
            $html
        );
        file_put_contents($savePath . 'preview.html', $html1);  // 先保存生成的HTML文件用于调试
        // 强制表格左对齐

        // 写入内容到 PDF
        $pdf->WriteHTML($html1);
        $pdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

        // 返回生成的PDF下载链接和HTML预览链接
        return json([
            'status' => 'success',
            'message' => '合同已生成',
            'download_url' => '/contracts/generated/' . $pdfFileName,
            'html_preview_url' => '/contracts/generated/preview.html'
        ]);
    }


    public function submitApplication(Request $request)
    {
        $admin = session('admin');  // 获取当前登录用户信息
        $userId = $admin['user_id'];

        $data = $request->post();
        $file = $request->file('business_license');  // 获取上传的营业执照文件

        // 检查是否有文件上传
        if (!$file || !$file->isValid()) {
            return json(['status' => 'fail', 'message' => '必须上传有效的营业执照']);
        }

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
            // 保存文件路径到 data
            $data['business_license'] = '/uploads/licenses/' . $fileName;
        } else {
            return json(['status' => 'fail', 'message' => '营业执照上传失败']);
        }

        // 保存基础信息和营业执照路径，并设置状态为“待审核”
        $data['user_id'] = $userId;
        $data['status'] = 0;  // 设置申请状态为待审核

        try {
            AgentApplication::create($data);
            return json(['status' => 'success', 'message' => '申请已成功提交，我们将尽快和您联系']);
        } catch (\Exception $e) {
            return json(['status' => 'fail', 'message' => '提交失败: ' . $e->getMessage()]);
        }
    }


    public function updateBasicInfo(Request $request)
    {
        $admin = session('admin');  // 获取当前登录用户信息
        $userId = $admin['user_id'];

        $data = $request->post();
        $application = AgentApplication::where('user_id', $userId)->find();

        if (!$application) {
            return json(['status' => 'fail', 'message' => '申请记录不存在']);
        }

        try {
            $application->save($data);
            return json(['status' => 'success', 'message' => '基础信息已更新']);
        } catch (\Exception $e) {
            return json(['status' => 'fail', 'message' => '更新失败: ' . $e->getMessage()]);
        }
    }
    public function updateBusinessLicense(Request $request)
    {
        // 从 POST 数据中获取 ID
        $Id = $request->post('id');

        $file = $request->file('business_license');
        $application = AgentApplication::where('id', $Id)->find();

        if (!$application) {
            return json(['status' => 'fail', 'message' => '申请记录不存在']);
        }

        if ($file && $file->isValid()) {
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

            // 移动上传的文件并更新数据库记录
            if (move_uploaded_file($file->getPathname(), $finalFilePath)) {
                // 删除旧文件（如果存在）
                if (!empty($application->business_license)) {
                    $oldFilePath = app()->getRootPath() . 'public' . $application->business_license;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath); // 删除旧文件
                    }
                }

                // 保存新文件路径
                $application->business_license = '/uploads/licenses/' . $fileName;
                $application->save();
                return json(['status' => 'success', 'message' => '营业执照已更新']);
            } else {
                return json(['status' => 'fail', 'message' => '营业执照上传失败']);
            }
        } else {
            return json(['status' => 'fail', 'message' => '未选择有效文件或文件上传失败']);
        }
    }


    // 更新申请
    public function updateApplication(Request $request)
    {
        $admin = session('admin');  // 获取当前登录用户信息
        $userId = $admin['user_id'];

        $data = $request->post();
        $file = $request->file('business_license');  // 获取上传的文件

        // 查找该用户的申请
        $application = AgentApplication::where('user_id', $userId)->find();

        if (!$application) {
            return json(['status' => 'fail', 'message' => '申请记录不存在']);
        }

        // 如果有上传新营业执照文件，处理文件上传
        if ($file) {
            $extension = $file->extension();
            $savePath = app()->getRootPath() . 'public/uploads/licenses/';
            if (!is_dir($savePath)) {
                mkdir($savePath, 0755, true);
            }
            $fileName = $userId . '.' . $extension;
            $finalFilePath = $savePath . $fileName;

            if (move_uploaded_file($file->getPathname(), $finalFilePath)) {
                // 如果上传成功，更新营业执照路径
                $data['business_license'] = '/uploads/licenses/' . $fileName;
            } else {
                return json(['status' => 'fail', 'message' => '营业执照上传失败']);
            }
        } else {
            // 如果没有新文件上传，保留原营业执照路径
            $data['business_license'] = $application->business_license;
        }

        // 更新申请数据
        try {
            $application->save($data);
            return json(['status' => 'success', 'message' => '申请已更新']);
        } catch (\Exception $e) {
            return json(['status' => 'fail', 'message' => '更新失败: ' . $e->getMessage()]);
        }
    }




    // 更新申请状态
    public function updateStatus(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');

        $application = AgentApplication::find($id);
        if (!$application) {
            return json(['status' => 'fail', 'message' => '申请不存在']);
        }

        $application->status = $status;
        $application->save();

        return json(['status' => 'success', 'message' => '状态已更新']);
    }

    // 上传电子合同
    public function uploadContract(Request $request)
    {
        $id = $request->post('id');
        $file = $request->file('contract');

        $application = AgentApplication::find($id);
        if (!$application) {
            return json(['status' => 'fail', 'message' => '申请不存在']);
        }

        if (!$file) {
            return json(['status' => 'fail', 'message' => '合同文件必须上传']);
        }

        // 保存电子合同文件
        $savePath = app()->getRootPath() . 'public/uploads/contracts/';
        $info = $file->move($savePath);
        if ($info) {
            $application->contract_url = '/uploads/contracts/' . $info->getSaveName();
            $application->save();
            return json(['status' => 'success', 'message' => '电子合同已上传']);
        } else {
            return json(['status' => 'fail', 'message' => '合同上传失败']);
        }
    }
}
