<?php

namespace PhpOffice\PhpSpreadsheet\Writer\Pdf;

use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

class Mpdf extends Pdf
{
    /** @var bool */
    protected $isMPdf = true;

    /**
     * Gets the implementation of external PDF library that should be used.
     *
     * @param array $config Configuration array
     *
     * @return \Mpdf\Mpdf implementation
     */
    protected function createExternalWriterInstance($config)
    {
        // 默认的配置，确保支持中文字体
        $defaultConfig = [
            'autoScriptToLang' => true, // 自动检测脚本语言
            'autoLangToFont' => true, // 自动检测语言并自动选择字体
            'useSubstitutions' => true, // 使用字体替换以支持缺失字符
        ];

        // 合并传入的配置与默认配置
        $finalConfig = array_merge($defaultConfig, $config);

        // 返回新的 Mpdf 实例
        return new \Mpdf\Mpdf($finalConfig);
    }

    /**
     * Save Spreadsheet to file.
     *
     * @param string $filename Name of the file to save as
     */
    public function save($filename, int $flags = 0): void
    {
        $fileHandle = parent::prepareForSave($filename);

        //  Check for paper size and page orientation
        $setup = $this->spreadsheet->getSheet($this->getSheetIndex() ?? 0)->getPageSetup();
        $orientation = $this->getOrientation() ?? $setup->getOrientation();
        $orientation = ($orientation === PageSetup::ORIENTATION_LANDSCAPE) ? 'L' : 'P';
        $printPaperSize = $this->getPaperSize() ?? $setup->getPaperSize();
        $paperSize = self::$paperSizes[$printPaperSize] ?? PageSetup::getPaperSizeDefault();

        //  Create PDF
        $config = ['tempDir' => $this->tempDir . '/mpdf'];
        $pdf = $this->createExternalWriterInstance($config);
        $ortmp = $orientation;
        $pdf->_setPageSize($paperSize, $ortmp);
        $pdf->DefOrientation = $orientation;
        $pdf->AddPageByArray([
            'orientation' => $orientation,
            'margin-left' => $this->inchesToMm($this->spreadsheet->getActiveSheet()->getPageMargins()->getLeft()),
            'margin-right' => $this->inchesToMm($this->spreadsheet->getActiveSheet()->getPageMargins()->getRight()),
            'margin-top' => $this->inchesToMm($this->spreadsheet->getActiveSheet()->getPageMargins()->getTop()),
            'margin-bottom' => $this->inchesToMm($this->spreadsheet->getActiveSheet()->getPageMargins()->getBottom()),
        ]);

        //  Document info
        $pdf->SetTitle($this->spreadsheet->getProperties()->getTitle());
        $pdf->SetAuthor($this->spreadsheet->getProperties()->getCreator());
        $pdf->SetSubject($this->spreadsheet->getProperties()->getSubject());
        $pdf->SetKeywords($this->spreadsheet->getProperties()->getKeywords());
        $pdf->SetCreator($this->spreadsheet->getProperties()->getCreator());

        $html = $this->generateHTMLAll();
        $bodyLocation = strpos($html, Html::BODY_LINE);
        // Make sure first data presented to Mpdf includes body tag
        //   so that Mpdf doesn't parse it as content. Issue 2432.
        if ($bodyLocation !== false) {
            $bodyLocation += strlen(Html::BODY_LINE);
            $pdf->WriteHTML(substr($html, 0, $bodyLocation));
            $html = substr($html, $bodyLocation);
        }
        foreach (\array_chunk(\explode(PHP_EOL, $html), 1000) as $lines) {
            $pdf->WriteHTML(\implode(PHP_EOL, $lines));
        }

        //  Write to file
        fwrite($fileHandle, $pdf->Output('', 'S'));

        parent::restoreStateAfterSave();
    }

    /**
     * Convert inches to mm.
     *
     * @param float $inches
     *
     * @return float
     */
    private function inchesToMm($inches)
    {
        return $inches * 25.4;
    }
}
