<?php

namespace app\admin\service;

use app\BaseController;
use think\facade\Cache;
use think\facade\Db;

class SystemUpdateService
{
    private const WORK_DIR = 'runtime/update';
    private const LOG_FILE = 'runtime/update/update.log';
    private const DEFAULT_MANIFEST_URL = 'https://demo.wmj.com.cn/updates/manifest.json';
    private const DEFAULT_VERSION = '2026.06.06.15';

    private static array $preserveFiles = [
        '.env',
        'env',
        'weimenjin_admin/.env',
        'weimenjin_admin/env',
        'config/database.php',
        'weimenjin_admin/config/database.php',
    ];

    private static array $preserveDirs = [
        '.git',
        'runtime',
        'backup',
        'public/upload',
        'public/uploads',
        'public/qrdata',
        'extend/utils/wechart/zcerts',
        'weimenjin_admin/runtime',
        'weimenjin_admin/public/upload',
        'weimenjin_admin/public/uploads',
        'weimenjin_admin/public/updates',
        'weimenjin_admin/public/qrdata',
        'weimenjin_admin/extend/utils/wechart/zcerts',
        'public/updates',
        'weimenjin_app/node_modules',
        'weimenjin_app/unpackage',
    ];

    public static function defaultManifestUrl(): string
    {
        return self::DEFAULT_MANIFEST_URL;
    }

    public static function currentVersion(): string
    {
        return (string) config('my.update.current_version', self::DEFAULT_VERSION ?: BaseController::VERSION);
    }

    public static function check(string $manifestUrl = '', string $packageUrl = ''): array
    {
        $manifest = self::resolveManifest($manifestUrl, $packageUrl);
        $currentVersion = self::currentVersion();
        $latestVersion = (string) ($manifest['version'] ?? '');
        return [
            'current_version' => $currentVersion,
            'latest_version' => $latestVersion,
            'has_update' => $latestVersion !== '' && version_compare($latestVersion, $currentVersion, '>'),
            'package_url' => (string) ($manifest['package_url'] ?? ''),
            'sha256' => (string) ($manifest['sha256'] ?? ''),
            'notes' => (string) ($manifest['notes'] ?? ''),
            'force' => !empty($manifest['force']),
            'manifest_url' => (string) ($manifest['_manifest_url'] ?? ''),
        ];
    }

    public static function install(string $manifestUrl = '', string $packageUrl = '', string $sha256 = ''): array
    {
        self::prepareWorkDir();
        self::lock();
        try {
            $manifest = self::resolveManifest($manifestUrl, $packageUrl);
            if ($sha256 !== '') {
                $manifest['sha256'] = $sha256;
            }

            $archive = self::downloadPackage($manifest);
            $extractDir = self::extractPackage($archive);
            $packageRoot = self::locatePackageRoot($extractDir);
            $layout = self::installLayout();

            $backup = [
                'code' => self::backupCode(),
                'database' => self::backupDatabase(),
            ];

            self::applyPackage($packageRoot, $layout['target'], $layout['strip_admin_prefix']);
            $sqlResult = self::runDatabaseUpgrade($packageRoot, $manifest);
            self::applyDeletePaths($manifest, $layout);
            self::markInstalled((string) ($manifest['version'] ?? ''), (string) ($manifest['_manifest_url'] ?? ''));
            self::clearRuntime();

            $result = [
                'version' => (string) ($manifest['version'] ?? ''),
                'backup' => $backup,
                'sql' => $sqlResult,
                'time' => date('Y-m-d H:i:s'),
            ];
            self::writeLog('更新完成: ' . json_encode($result, JSON_UNESCAPED_UNICODE));
            return $result;
        } finally {
            self::unlock();
        }
    }

    public static function logs(): string
    {
        $file = root_path() . self::LOG_FILE;
        if (!is_file($file)) {
            return '';
        }
        return (string) file_get_contents($file);
    }

    private static function resolveManifest(string $manifestUrl, string $packageUrl): array
    {
        $manifestUrl = $manifestUrl ?: (string) config('my.update.manifest_url', '');
        $manifestUrl = $manifestUrl ?: self::DEFAULT_MANIFEST_URL;
        if ($manifestUrl !== '') {
            $json = self::httpGet($manifestUrl);
            $manifest = json_decode($json, true);
            if (!is_array($manifest)) {
                throw new \RuntimeException('版本清单不是有效 JSON');
            }
            $manifest['_manifest_url'] = $manifestUrl;
        } else {
            $manifest = [];
        }

        if ($packageUrl !== '') {
            $manifest['package_url'] = $packageUrl;
        }
        if (empty($manifest['package_url'])) {
            throw new \RuntimeException('请填写更新包地址或配置版本清单地址');
        }
        if (empty($manifest['version'])) {
            $manifest['version'] = date('YmdHis');
        }
        $manifest['package_url'] = self::resolveUrl((string) $manifest['package_url'], $manifestUrl);
        return $manifest;
    }

    private static function resolveUrl(string $url, string $baseUrl = ''): string
    {
        if ($url === '' || preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }
        if ($baseUrl === '' || !preg_match('/^https?:\/\//i', $baseUrl)) {
            return $url;
        }
        if (str_starts_with($url, '/')) {
            $parts = parse_url($baseUrl);
            return ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '') . $url;
        }
        return rtrim(dirname($baseUrl), '/\\') . '/' . ltrim($url, '/');
    }

    private static function downloadPackage(array $manifest): string
    {
        $url = (string) $manifest['package_url'];
        if (!preg_match('/^https?:\/\//i', $url)) {
            throw new \RuntimeException('更新包地址必须是 http 或 https');
        }

        $file = self::workPath('package_' . date('YmdHis') . '.zip');
        self::httpDownload($url, $file);

        if (!empty($manifest['sha256'])) {
            $actual = hash_file('sha256', $file);
            if (!hash_equals(strtolower((string) $manifest['sha256']), strtolower($actual))) {
                throw new \RuntimeException('更新包 sha256 校验失败');
            }
        }
        self::writeLog('更新包下载完成: ' . $url);
        return $file;
    }

    private static function extractPackage(string $archive): string
    {
        if (!class_exists('\ZipArchive')) {
            throw new \RuntimeException('服务器未安装 ZipArchive，无法解压更新包');
        }
        $zip = new \ZipArchive();
        if ($zip->open($archive) !== true) {
            throw new \RuntimeException('更新包打开失败');
        }

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            if (self::isUnsafeArchivePath($name)) {
                $zip->close();
                throw new \RuntimeException('更新包包含非法路径: ' . $name);
            }
        }

        $dir = self::workPath('extract_' . date('YmdHis'));
        mkdir($dir, 0777, true);
        $zip->extractTo($dir);
        $zip->close();
        return $dir;
    }

    private static function locatePackageRoot(string $extractDir): string
    {
        if (self::isPackageRoot($extractDir)) {
            return $extractDir;
        }
        $items = array_values(array_filter(glob($extractDir . '/*'), 'is_dir'));
        if (count($items) === 1 && self::isPackageRoot($items[0])) {
            return $items[0];
        }
        throw new \RuntimeException('更新包目录结构不正确，根目录需包含 weimenjin_admin、weimenjin_app 或后台 app/config/public 目录');
    }

    private static function isPackageRoot(string $dir): bool
    {
        return is_dir($dir . '/weimenjin_admin')
            || is_dir($dir . '/weimenjin_app')
            || self::isBackendRoot($dir);
    }

    private static function backupCode(): string
    {
        if (!class_exists('\ZipArchive')) {
            throw new \RuntimeException('服务器未安装 ZipArchive，无法创建代码备份');
        }
        $backupDir = root_path() . 'backup/update';
        self::ensureWritableDir($backupDir, '代码备份目录');
        $file = $backupDir . '/code_' . date('YmdHis') . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open($file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('代码备份创建失败');
        }
        $projectRoot = self::projectRoot();
        self::zipDir($projectRoot, $zip, strlen($projectRoot));
        $zip->close();
        self::writeLog('代码备份完成: ' . $file);
        return $file;
    }

    private static function backupDatabase(): string
    {
        $backupDir = root_path() . 'backup/update';
        self::ensureWritableDir($backupDir, '数据库备份目录');
        $file = $backupDir . '/database_' . date('YmdHis') . '.sql';
        $tables = Db::query('SHOW TABLES');
        $dbName = (string) config('database.connections.mysql.database');
        $key = 'Tables_in_' . $dbName;
        $handle = fopen($file, 'wb');
        if (!$handle) {
            throw new \RuntimeException('数据库备份文件创建失败');
        }
        fwrite($handle, "-- Weimenjin database backup " . date('Y-m-d H:i:s') . "\nSET FOREIGN_KEY_CHECKS=0;\n\n");
        foreach ($tables as $row) {
            $table = $row[$key] ?? reset($row);
            $create = Db::query('SHOW CREATE TABLE `' . str_replace('`', '``', $table) . '`');
            fwrite($handle, "DROP TABLE IF EXISTS `{$table}`;\n" . $create[0]['Create Table'] . ";\n\n");
            self::dumpTableRows($handle, $table);
        }
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle);
        self::writeLog('数据库备份完成: ' . $file);
        return $file;
    }

    private static function dumpTableRows($handle, string $table): void
    {
        $offset = 0;
        $limit = 500;
        do {
            $rows = Db::table($table)->limit($offset, $limit)->select()->toArray();
            foreach ($rows as $row) {
                $columns = array_map(fn($k) => '`' . str_replace('`', '``', $k) . '`', array_keys($row));
                $values = array_map([self::class, 'quoteSqlValue'], array_values($row));
                fwrite($handle, 'INSERT INTO `' . $table . '` (' . implode(',', $columns) . ') VALUES (' . implode(',', $values) . ");\n");
            }
            $offset += $limit;
        } while (count($rows) === $limit);
        fwrite($handle, "\n");
    }

    private static function quoteSqlValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        return "'" . str_replace(["\\", "'", "\0", "\n", "\r", "\x1a"], ["\\\\", "\\'", "\\0", "\\n", "\\r", "\\Z"], (string) $value) . "'";
    }

    private static function applyPackage(string $source, string $target, bool $stripAdminPrefix = false): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            $relative = self::normalizeRelative(substr($item->getPathname(), strlen($source) + 1));
            $relative = self::mapPackageRelative($relative, $stripAdminPrefix);
            if ($relative === '') {
                continue;
            }
            if (self::shouldPreserve($relative)) {
                continue;
            }
            $dest = rtrim($target, '/\\') . DIRECTORY_SEPARATOR . $relative;
            if ($item->isDir()) {
                if (!is_dir($dest)) {
                    mkdir($dest, 0777, true);
                }
                continue;
            }
            $dir = dirname($dest);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            if (!copy($item->getPathname(), $dest)) {
                throw new \RuntimeException('文件覆盖失败: ' . $relative);
            }
        }
        self::writeLog('代码覆盖完成');
    }

    private static function runDatabaseUpgrade(string $packageRoot, array $manifest): array
    {
        $candidates = self::databaseUpgradeCandidates($packageRoot, $manifest);
        foreach ($candidates as $file) {
            if (is_file($file)) {
                $count = self::executeSqlFile($file);
                self::writeLog('数据库脚本执行完成: ' . $file);
                return ['file' => $file, 'statements' => $count];
            }
        }
        return ['file' => '', 'statements' => 0];
    }

    private static function databaseUpgradeCandidates(string $packageRoot, array $manifest): array
    {
        $files = [];
        foreach ((array) ($manifest['sql_files'] ?? []) as $file) {
            $relative = self::normalizeRelative((string) $file);
            if ($relative === '' || self::isUnsafeArchivePath($relative)) {
                continue;
            }
            $files[] = $packageRoot . '/' . $relative;
        }

        return array_merge($files, [
            $packageRoot . '/weimenjin_admin/update.sql',
            $packageRoot . '/weimenjin_admin/database/update.sql',
            $packageRoot . '/database/update.sql',
            $packageRoot . '/update.sql',
        ]);
    }

    private static function executeSqlFile(string $file): int
    {
        $sql = file_get_contents($file);
        $statements = self::splitSql($sql);
        $count = 0;
        foreach ($statements as $statement) {
            $statement = trim($statement);
            if ($statement === '') {
                continue;
            }
            Db::execute($statement);
            $count++;
        }
        return $count;
    }

    private static function splitSql(string $sql): array
    {
        $delimiter = ';';
        $buffer = '';
        $statements = [];
        foreach (preg_split('/\R/', $sql) as $line) {
            $trim = trim($line);
            if ($trim === '' || str_starts_with($trim, '--') || str_starts_with($trim, '#')) {
                continue;
            }
            if (stripos($trim, 'DELIMITER ') === 0) {
                $delimiter = trim(substr($trim, 10));
                continue;
            }
            if ($delimiter !== ';') {
                if (str_ends_with($trim, $delimiter)) {
                    $buffer .= "\n" . substr($line, 0, -strlen($delimiter));
                    $statements[] = $buffer;
                    $buffer = '';
                } else {
                    $buffer .= "\n" . $line;
                }
                continue;
            }
            $buffer .= "\n" . $line;
            if (str_ends_with($trim, ';')) {
                $statements[] = substr($buffer, 0, -1);
                $buffer = '';
            }
        }
        if (trim($buffer) !== '') {
            $statements[] = $buffer;
        }
        return $statements;
    }

    private static function applyDeletePaths(array $manifest, ?array $layout = null): void
    {
        $layout = $layout ?: self::installLayout();
        foreach (($manifest['delete_paths'] ?? []) as $path) {
            $relative = self::normalizeRelative((string) $path);
            $relative = self::mapPackageRelative($relative, $layout['strip_admin_prefix']);
            if ($relative === '' || self::shouldPreserve($relative)) {
                continue;
            }
            $target = $layout['target'] . $relative;
            if (is_dir($target)) {
                self::removeDir($target);
            } elseif (is_file($target)) {
                unlink($target);
            }
        }
    }

    private static function clearRuntime(): void
    {
        foreach ([root_path() . 'runtime/admin', root_path() . 'runtime/cache'] as $dir) {
            if (is_dir($dir)) {
                self::removeDir($dir);
            }
        }
    }

    private static function zipDir(string $dir, \ZipArchive $zip, int $baseLength): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $item) {
            $relative = self::normalizeRelative(substr($item->getPathname(), $baseLength));
            if (
                $relative === ''
                || str_starts_with($relative, 'backup/update/')
                || str_starts_with($relative, self::WORK_DIR . '/')
                || str_starts_with($relative, 'weimenjin_admin/public/updates/')
                || str_starts_with($relative, 'public/updates/')
            ) {
                continue;
            }
            if ($item->isDir()) {
                $zip->addEmptyDir($relative);
            } else {
                $zip->addFile($item->getPathname(), $relative);
            }
        }
    }

    private static function projectRoot(): string
    {
        return self::installLayout()['target'];
    }

    private static function installLayout(): array
    {
        $root = rtrim(root_path(), '/\\') . DIRECTORY_SEPARATOR;
        $rootNoSlash = rtrim($root, '/\\');
        $parent = dirname($rootNoSlash) . DIRECTORY_SEPARATOR;

        if (basename($rootNoSlash) === 'weimenjin_admin') {
            if (is_dir($parent . 'weimenjin_admin') || is_dir($parent . 'weimenjin_app')) {
                return ['target' => $parent, 'strip_admin_prefix' => false];
            }
        }

        if (self::isBackendRoot($rootNoSlash)) {
            return ['target' => $root, 'strip_admin_prefix' => true];
        }

        return ['target' => $root, 'strip_admin_prefix' => false];
    }

    private static function isBackendRoot(string $dir): bool
    {
        return is_dir($dir . '/app')
            && is_dir($dir . '/config')
            && is_dir($dir . '/public');
    }

    private static function mapPackageRelative(string $relative, bool $stripAdminPrefix): string
    {
        $relative = self::normalizeRelative($relative);
        if (!$stripAdminPrefix) {
            return $relative;
        }
        if ($relative === 'weimenjin_admin') {
            return '';
        }
        if (str_starts_with($relative, 'weimenjin_admin/')) {
            return substr($relative, strlen('weimenjin_admin/'));
        }
        return $relative;
    }

    private static function markInstalled(string $version, string $manifestUrl): void
    {
        if ($version === '') {
            return;
        }
        self::saveAppConfig('update', 'current_version', $version);
        if ($manifestUrl !== '') {
            self::saveAppConfig('update', 'manifest_url', $manifestUrl);
        }
        self::ensureCloudAppConfigs();
        self::ensureRuntimeAppConfigs();
        Cache::delete('db_configs');
    }

    private static function ensureCloudAppConfigs(): void
    {
        self::insertAppConfigIfMissing('wmjv1', '微门禁V1接口', 'wmjv1_url', 'https://www.wmj.com.cn', '微门禁V1硬件云地址', 96, 1);
        self::insertAppConfigIfMissing('wmjv2', '微门禁V2接口', 'wmjv2_url', 'https://wdev.wmj.com.cn/deviceApi/', '微门禁V2硬件云地址', 95, 1);
        self::updateAppConfigSort('wmjv1', 'wmjv1_appid', 2);
        self::updateAppConfigSort('wmjv1', 'wmjv1_appsecret', 3);
        self::updateAppConfigSort('wmjv2', 'wmjv2_appid', 2);
        self::updateAppConfigSort('wmjv2', 'wmjv2_appsecret', 3);
    }

    private static function ensureRuntimeAppConfigs(): void
    {
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'site_url', 'https://demo.wmj.com.cn', '小程序站点地址', 90, 1);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'api_url', 'https://demo.wmj.com.cn/api', '小程序接口地址', 90, 2);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'asset_url', 'https://demo.wmj.com.cn', '小程序资源地址', 90, 3);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'camweb_url', 'https://demo.wmj.com.cn/camweb/', '摄像头 Web 地址', 90, 4);

        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'enabled', '0', '是否启用实时对讲', 89, 1, 'boolean');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'public_wss_base', '', '公开 WebSocket 基础地址', 89, 2);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'app_ws_protocol', 'wss', 'WebSocket 协议', 89, 3);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'app_ws_host', '', 'WebSocket 主机', 89, 4);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'app_ws_port', '', 'WebSocket 端口', 89, 5);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'app_ws_path_prefix', '/ws/horn/live/app', 'WebSocket 路径前缀', 89, 6);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'sample_rate', '16000', '采样率', 89, 7, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'channels', '1', '声道数', 89, 8, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'encode_bitrate', '64000', '编码码率', 89, 9, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'frame_size_kb', '1', '录音分片大小 KB', 89, 10, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'chunk_delay_ms', '40', '音频分片发送间隔毫秒', 89, 11, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'max_duration_sec', '90', '单次对讲最长秒数', 89, 12, 'integer');
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'app_upload_codec', 'mp3', '小程序上传音频编码', 89, 13);
        self::insertAppConfigIfMissing('live_talk', '实时对讲配置', 'default_audio_url', '/audio/wmj.mp3', '默认测试音频地址', 89, 14);
    }

    private static function insertAppConfigIfMissing(string $module, string $moduleTitle, string $name, string $value, string $description, int $sortOrder, int $groupSortOrder, string $type = 'string'): void
    {
        if (Db::name('appconfig')->where(['module' => $module, 'name' => $name])->find()) {
            return;
        }

        $columns = self::appConfigColumns();
        $data = [
            'module' => $module,
            'name' => $name,
            'value' => $value,
            'type' => $type,
        ];
        if (in_array('module_name', $columns, true)) {
            $data['module_name'] = $moduleTitle;
        } elseif (in_array('title', $columns, true)) {
            $data['title'] = $moduleTitle;
        }
        if (in_array('description', $columns, true)) {
            $data['description'] = $description;
        } elseif (in_array('remark', $columns, true)) {
            $data['remark'] = $description;
        }
        if (in_array('created_at', $columns, true)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        } elseif (in_array('create_time', $columns, true)) {
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        if (in_array('is_grouped', $columns, true)) {
            $data['is_grouped'] = 1;
        }
        if (in_array('is_readonly', $columns, true)) {
            $data['is_readonly'] = 0;
        }
        if (in_array('sort_order', $columns, true)) {
            $data['sort_order'] = $sortOrder;
        }
        if (in_array('group_sort_order', $columns, true)) {
            $data['group_sort_order'] = $groupSortOrder;
        }

        Db::name('appconfig')->insert($data);
    }

    private static function updateAppConfigSort(string $module, string $name, int $groupSortOrder): void
    {
        $columns = self::appConfigColumns();
        if (!in_array('group_sort_order', $columns, true)) {
            return;
        }
        Db::name('appconfig')->where(['module' => $module, 'name' => $name])->update(['group_sort_order' => $groupSortOrder]);
    }

    private static function saveAppConfig(string $module, string $name, string $value): void
    {
        $exists = Db::name('appconfig')->where(['module' => $module, 'name' => $name])->find();
        if ($exists) {
            $data = ['value' => $value];
            if (in_array('updated_at', self::appConfigColumns(), true)) {
                $data['updated_at'] = date('Y-m-d H:i:s');
            }
            if (in_array('update_time', self::appConfigColumns(), true)) {
                $data['update_time'] = time();
            }
            Db::name('appconfig')->where('id', $exists['id'])->update($data);
            return;
        }
        $columns = self::appConfigColumns();
        $moduleTitle = "\u{7cfb}\u{7edf}\u{66f4}\u{65b0}";
        $description = $name === 'current_version'
            ? "\u{5f53}\u{524d}\u{7248}\u{672c}\u{53f7}"
            : "\u{66f4}\u{65b0}\u{6e05}\u{5355}\u{5730}\u{5740}";
        $data = [
            'module' => $module,
            'name' => $name,
            'value' => $value,
            'type' => 'string',
        ];
        if (in_array('module_name', $columns, true)) {
            $data['module_name'] = $moduleTitle;
        } elseif (in_array('title', $columns, true)) {
            $data['title'] = $moduleTitle;
        }
        if (in_array('description', $columns, true)) {
            $data['description'] = $description;
        } elseif (in_array('remark', $columns, true)) {
            $data['remark'] = $description;
        }
        if (in_array('created_at', $columns, true)) {
            $data['created_at'] = date('Y-m-d H:i:s');
        } elseif (in_array('create_time', $columns, true)) {
            $data['create_time'] = date('Y-m-d H:i:s');
        }
        if (in_array('is_grouped', $columns, true)) {
            $data['is_grouped'] = 1;
        }
        if (in_array('is_readonly', $columns, true)) {
            $data['is_readonly'] = 0;
        }
        if (in_array('sort_order', $columns, true)) {
            $data['sort_order'] = 0;
        }
        if (in_array('group_sort_order', $columns, true)) {
            $data['group_sort_order'] = 0;
        }
        if (in_array('sort', $columns, true)) {
            $data['sort'] = 1;
        }
        if (in_array('status', $columns, true)) {
            $data['status'] = 0;
        }
        if (in_array('group_id', $columns, true)) {
            $data['group_id'] = 0;
        }
        if (in_array('config_type', $columns, true)) {
            $data['config_type'] = 0;
        }
        Db::name('appconfig')->insert($data);
    }

    private static function appConfigColumns(): array
    {
        static $columns = null;
        if ($columns !== null) {
            return $columns;
        }
        $prefix = (string) config('database.connections.mysql.prefix', '');
        $table = $prefix . 'appconfig';
        $rows = Db::query('SHOW COLUMNS FROM `' . str_replace('`', '``', $table) . '`');
        $columns = array_map(static fn($row) => (string) ($row['Field'] ?? ''), $rows);
        return $columns;
    }

    private static function shouldPreserve(string $relative): bool
    {
        $relative = self::normalizeRelative($relative);
        if (in_array($relative, self::$preserveFiles, true)) {
            return true;
        }
        foreach (self::$preserveDirs as $dir) {
            $dir = trim($dir, '/');
            if ($relative === $dir || str_starts_with($relative, $dir . '/')) {
                return true;
            }
        }
        return false;
    }

    private static function httpGet(string $url): string
    {
        $tmp = self::workPath('manifest_' . date('YmdHis') . '.json');
        self::httpDownload($url, $tmp);
        return (string) file_get_contents($tmp);
    }

    private static function httpDownload(string $url, string $file): void
    {
        if (!function_exists('curl_init')) {
            throw new \RuntimeException('服务器未安装 cURL 扩展，无法下载更新包');
        }
        $fp = fopen($file, 'wb');
        if (!$fp) {
            throw new \RuntimeException('无法创建下载文件：' . $file);
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_USERAGENT => 'WeimenjinUpdater/1.0',
        ]);
        curl_exec($ch);
        $error = curl_error($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        fclose($fp);
        if ($error || $status < 200 || $status >= 300) {
            @unlink($file);
            throw new \RuntimeException('下载失败: ' . ($error ?: 'HTTP ' . $status));
        }
    }

    private static function isUnsafeArchivePath(string $path): bool
    {
        $path = str_replace('\\', '/', $path);
        $segments = array_filter(explode('/', $path), fn($segment) => $segment !== '');
        return in_array('..', $segments, true) || str_starts_with($path, '/') || preg_match('/^[A-Za-z]:\//', $path);
    }

    private static function normalizeRelative(string $path): string
    {
        return trim(str_replace('\\', '/', $path), '/');
    }

    private static function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($dir);
    }

    private static function prepareWorkDir(): void
    {
        $dir = root_path() . self::WORK_DIR;
        self::ensureWritableDir($dir, '更新临时目录');
    }

    private static function ensureWritableDir(string $dir, string $label): void
    {
        if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException($label . '创建失败：' . $dir);
        }
        @chmod($dir, 0775);
        if (!is_writable($dir)) {
            throw new \RuntimeException($label . '不可写，请检查目录权限：' . $dir);
        }
    }

    private static function workPath(string $name): string
    {
        self::prepareWorkDir();
        return root_path() . self::WORK_DIR . '/' . $name;
    }

    private static function lock(): void
    {
        $file = self::workPath('update.lock');
        if (is_file($file) && time() - filemtime($file) < 600) {
            throw new \RuntimeException('已有更新任务正在执行，请稍后再试');
        }
        file_put_contents($file, (string) time());
    }

    private static function unlock(): void
    {
        @unlink(self::workPath('update.lock'));
    }

    private static function writeLog(string $message): void
    {
        self::prepareWorkDir();
        file_put_contents(root_path() . self::LOG_FILE, '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL, FILE_APPEND);
    }
}
