<?php

/**
 * This file is part of FPDI
 *
 * @package   setasign\Fpdi
 * @copyright Copyright (c) 2024 Setasign GmbH & Co. KG (https://www.setasign.com)
 * @license   http://opensource.org/licenses/mit-license The MIT License
 */
spl_autoload_register(static function ($class) {
    if (strpos($class, 'Mpdf\\') === 0) {
        $filename = str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 5)) . '.php';
        $fullpath = __DIR__ . DIRECTORY_SEPARATOR . 'mpdf' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $filename;

        if (is_file($fullpath)) {
            require_once $fullpath;
        } else {
            false && error_log('File not found: ' . $fullpath); // To help debug issues with paths
        }
    }
});


