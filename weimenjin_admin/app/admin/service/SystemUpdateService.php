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
    private const DEFAULT_VERSION = '2026.06.09.21';
    private const SCHEMA_REPAIR_SQL = 'database/updates/20260606_19_sync_schema.sql';
    private const BACKUP_KEEP_SETS = 3;

    private static array $preserveFiles = [
        '.env',
        'env',
        'weimenjin_admin/.env',
        'weimenjin_admin/env',
        'config/database.php',
        'config/my.php',
        'weimenjin_admin/config/database.php',
        'weimenjin_admin/config/my.php',
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
            'package_type' => (string) ($manifest['package_type'] ?? ''),
            'strategy' => (string) ($manifest['strategy'] ?? ''),
            'baseline_url' => self::resolveUrl((string) ($manifest['baseline_url'] ?? ''), (string) ($manifest['_manifest_url'] ?? '')),
            'baseline_sha256' => (string) ($manifest['baseline_sha256'] ?? ''),
            'package_size' => (int) ($manifest['package_size'] ?? 0),
            'file_count' => (int) ($manifest['file_count'] ?? 0),
            'sql_files' => array_values((array) ($manifest['sql_files'] ?? [])),
            'from_version' => (string) ($manifest['from_version'] ?? ''),
            'upgrade_path' => (string) ($manifest['upgrade_path'] ?? ''),
            'selected_package' => (string) ($manifest['selected_package'] ?? ''),
        ];
    }

    public static function install(string $manifestUrl = '', string $packageUrl = '', string $sha256 = ''): array
    {
        self::prepareWorkDir();
        self::lock();
        $archive = '';
        $extractDir = '';
        try {
            self::updateProgress('resolve_manifest', '正在读取更新清单');
            $manifest = self::resolveManifest($manifestUrl, $packageUrl);
            if ($sha256 !== '') {
                $manifest['sha256'] = $sha256;
            }
            self::updateProgress('download_package', '正在下载更新包', $manifest);

            $archive = self::downloadPackage($manifest);
            self::updateProgress('extract_package', '正在解压更新包', $manifest);
            $extractDir = self::extractPackage($archive);
            $packageRoot = self::locatePackageRoot($extractDir);
            $layout = self::installLayout();
            self::updateProgress('snapshot_config', '正在读取运行配置', $manifest);
            $runtimeConfig = self::loadRuntimeConfigSnapshot();

            self::updateProgress('backup', '正在备份代码、数据库和运行配置', $manifest);
            $backup = [
                'code' => self::backupCode(),
                'database' => self::backupDatabase(),
                'runtime_config' => self::backupRuntimeConfig(),
            ];

            self::updateProgress('apply_files', '正在覆盖更新文件', $manifest);
            self::applyPackage($packageRoot, $layout['target'], $layout['strip_admin_prefix']);
            self::updateProgress('run_sql', '正在执行数据库升级脚本', $manifest);
            $sqlResult = self::runDatabaseUpgrade($packageRoot, $manifest);
            self::updateProgress('migrate_config', '正在迁移运行配置', $manifest);
            $configMigration = self::migrateRuntimeConfigToDatabase($runtimeConfig);
            self::updateProgress('delete_paths', '正在处理清理项', $manifest);
            self::applyDeletePaths($manifest, $layout);
            self::updateProgress('mark_installed', '正在写入新版本号', $manifest);
            self::markInstalled((string) ($manifest['version'] ?? ''), (string) ($manifest['_manifest_url'] ?? ''));
            self::updateProgress('clear_runtime', '正在清理缓存', $manifest);
            self::clearRuntime();

            $result = [
                'version' => (string) ($manifest['version'] ?? ''),
                'backup' => $backup,
                'sql' => $sqlResult,
                'config_migration' => $configMigration,
                'time' => date('Y-m-d H:i:s'),
            ];
            self::writeLog('更新完成: ' . json_encode($result, JSON_UNESCAPED_UNICODE));
            self::updateProgress('completed', '更新完成', $manifest);
            self::cleanupUpdateArtifacts($archive, $extractDir);
            self::cleanupOldUpdateBackups();
            return $result;
        } catch (\Throwable $e) {
            self::updateProgress('failed', '更新失败: ' . $e->getMessage());
            throw $e;
        } finally {
            self::unlock();
        }
    }

    public static function status(): array
    {
        self::prepareWorkDir();
        $file = self::workPath('update.lock');
        $now = time();
        $data = [];
        if (is_file($file)) {
            $raw = (string) file_get_contents($file);
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                $data = $decoded;
            } elseif (trim($raw) !== '' && ctype_digit(trim($raw))) {
                $data = [
                    'started_at_ts' => (int) trim($raw),
                    'stage' => 'running',
                    'message' => '已有更新任务正在执行',
                ];
            }
        }
        $startedAt = (int) ($data['started_at_ts'] ?? (is_file($file) ? filemtime($file) : 0));
        $updatedAt = (int) ($data['updated_at_ts'] ?? (is_file($file) ? filemtime($file) : 0));
        $age = $startedAt > 0 ? max(0, $now - $startedAt) : 0;
        $idle = $updatedAt > 0 ? max(0, $now - $updatedAt) : 0;
        $locked = is_file($file);
        $stale = $locked && $age >= 600;
        return [
            'locked' => $locked,
            'stale' => $stale,
            'can_retry' => !$locked || $stale,
            'stage' => (string) ($data['stage'] ?? ($locked ? 'running' : 'idle')),
            'message' => (string) ($data['message'] ?? ($locked ? '已有更新任务正在执行' : '当前没有正在执行的更新任务')),
            'started_at' => $startedAt > 0 ? date('Y-m-d H:i:s', $startedAt) : '',
            'updated_at' => $updatedAt > 0 ? date('Y-m-d H:i:s', $updatedAt) : '',
            'age_seconds' => $age,
            'idle_seconds' => $idle,
            'version' => (string) ($data['version'] ?? ''),
            'package_url' => (string) ($data['package_url'] ?? ''),
            'manifest_url' => (string) ($data['manifest_url'] ?? ''),
            'selected_package' => (string) ($data['selected_package'] ?? ''),
            'pid' => (int) ($data['pid'] ?? 0),
        ];
    }

    public static function logs(): string
    {
        $file = root_path() . self::LOG_FILE;
        if (!is_file($file)) {
            return '';
        }
        return (string) file_get_contents($file);
    }

    public static function databaseStatus(): array
    {
        self::useUtf8mb4Connection();
        $required = self::requiredDatabaseTables();
        $tables = array_keys($required);
        $existing = self::existingTables($tables);
        $items = [];
        foreach ($required as $table => $label) {
            $exists = in_array($table, $existing, true);
            $items[] = [
                'table' => $table,
                'label' => $label,
                'exists' => $exists,
                'status' => $exists ? '正常' : '缺失',
            ];
        }
        $columns = self::existingColumnDefinitions(self::requiredDatabaseColumns());
        foreach (self::requiredDatabaseColumns() as $column) {
            $key = $column['table'] . '.' . $column['column'];
            $definition = $columns[$key] ?? null;
            $ok = $definition && in_array(strtolower((string) ($definition['DATA_TYPE'] ?? '')), $column['allowed_types'], true);
            $items[] = [
                'table' => $column['table'],
                'column' => $column['column'],
                'label' => $column['label'],
                'exists' => $ok,
                'status' => $ok ? '正常' : '需修复',
            ];
        }
        $missing = array_values(array_filter($items, static fn($item) => !$item['exists']));
        return [
            'total' => count($items),
            'ok_count' => count($items) - count($missing),
            'missing_count' => count($missing),
            'items' => $items,
            'missing' => $missing,
            'checked_at' => date('Y-m-d H:i:s'),
        ];
    }

    public static function ensureApplicationConfigReady(bool $refreshRuntimeConfig = false): void
    {
        self::useUtf8mb4Connection();
        self::ensureCloudAppConfigs();
        self::ensureRuntimeAppConfigs();
        if ($refreshRuntimeConfig) {
            self::refreshRuntimeConfigFromDatabase();
        } else {
            Cache::delete('db_configs');
        }
    }

    public static function repairDatabase(): array
    {
        self::useUtf8mb4Connection();
        $before = self::databaseStatus();
        $file = root_path() . self::SCHEMA_REPAIR_SQL;
        if (!is_file($file)) {
            throw new \RuntimeException('数据库结构修复脚本不存在: ' . self::SCHEMA_REPAIR_SQL);
        }
        $statements = self::executeSqlFile($file);
        self::ensureCloudAppConfigs();
        self::ensureRuntimeAppConfigs();
        self::refreshRuntimeConfigFromDatabase();
        $after = self::databaseStatus();
        self::writeLog('数据库结构检测修复完成: ' . json_encode([
            'before_missing' => $before['missing_count'],
            'after_missing' => $after['missing_count'],
            'statements' => $statements,
            'time' => date('Y-m-d H:i:s'),
        ], JSON_UNESCAPED_UNICODE));
        return [
            'before' => $before,
            'after' => $after,
            'statements' => $statements,
            'time' => date('Y-m-d H:i:s'),
        ];
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

        if ($packageUrl === '') {
            $manifest = self::selectPackageForCurrentVersion($manifest, self::currentVersion(), $manifestUrl);
        } else {
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

    private static function selectPackageForCurrentVersion(array $manifest, string $currentVersion, string $manifestUrl): array
    {
        $packages = (array) ($manifest['packages'] ?? []);
        if (!$packages) {
            return $manifest;
        }

        $latestVersion = (string) ($manifest['version'] ?? '');
        $matched = null;
        foreach ($packages as $package) {
            if (!is_array($package)) {
                continue;
            }
            if (self::packageMatchesVersion($package, $currentVersion)) {
                $matched = $package;
                break;
            }
        }

        if ($matched === null) {
            foreach ($packages as $package) {
                if (!is_array($package)) {
                    continue;
                }
                $type = (string) ($package['package_type'] ?? '');
                $strategy = (string) ($package['strategy'] ?? '');
                if ($type === 'full_admin' || $strategy === 'full_admin_preserve_runtime') {
                    $matched = $package;
                    break;
                }
            }
        }

        if ($matched === null) {
            throw new \RuntimeException('未找到适合当前版本的更新包，请先升级到可用基线版本');
        }

        $selected = array_merge($manifest, $matched);
        $selected['version'] = (string) ($matched['version'] ?? $matched['to_version'] ?? $latestVersion);
        $selected['package_url'] = self::resolveUrl((string) ($matched['package_url'] ?? ''), $manifestUrl);
        $selected['baseline_url'] = self::resolveUrl((string) ($matched['baseline_url'] ?? $manifest['baseline_url'] ?? ''), $manifestUrl);
        $selected['selected_package'] = (string) ($matched['name'] ?? $matched['package_url'] ?? '');
        $selected['upgrade_path'] = $currentVersion . ' -> ' . $selected['version'];
        $selected['packages'] = $packages;
        return $selected;
    }

    private static function packageMatchesVersion(array $package, string $currentVersion): bool
    {
        $fromVersion = (string) ($package['from_version'] ?? '');
        if ($fromVersion !== '' && version_compare($currentVersion, $fromVersion, '==')) {
            return true;
        }

        foreach ((array) ($package['from_versions'] ?? []) as $version) {
            if (version_compare($currentVersion, (string) $version, '==')) {
                return true;
            }
        }

        $min = (string) ($package['min_version'] ?? '');
        $max = (string) ($package['max_version'] ?? '');
        if ($min !== '' && version_compare($currentVersion, $min, '<')) {
            return false;
        }
        if ($max !== '' && version_compare($currentVersion, $max, '>')) {
            return false;
        }
        return $min !== '' || $max !== '';
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
                self::writeLog('更新包 sha256 校验失败: ' . json_encode([
                    'expected' => (string) $manifest['sha256'],
                    'actual' => $actual,
                    'url' => $url,
                    'time' => date('Y-m-d H:i:s'),
                ], JSON_UNESCAPED_UNICODE));
                throw new \RuntimeException('更新包 sha256 校验失败，请重新检测更新后再升级');
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

    private static function backupRuntimeConfig(): string
    {
        $source = root_path() . 'config/my.php';
        if (!is_file($source)) {
            return '';
        }
        $backupDir = root_path() . 'backup/update';
        self::ensureWritableDir($backupDir, '运行配置备份目录');
        $file = $backupDir . '/my_' . date('YmdHis') . '.php';
        if (!copy($source, $file)) {
            throw new \RuntimeException('运行配置备份失败: config/my.php');
        }
        self::writeLog('运行配置备份完成: ' . $file);
        return $file;
    }

    private static function loadRuntimeConfigSnapshot(): array
    {
        $file = root_path() . 'config/my.php';
        if (!is_file($file)) {
            return [];
        }
        try {
            $config = include $file;
            return is_array($config) ? $config : [];
        } catch (\Throwable $e) {
            self::writeLog('旧运行配置读取失败，跳过配置迁移: ' . $e->getMessage());
            return [];
        }
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
        self::useUtf8mb4Connection();
        $candidates = self::databaseUpgradeCandidates($packageRoot, $manifest);
        $result = [
            'files' => [],
            'statements' => 0,
        ];
        foreach ($candidates as $file) {
            if (is_file($file)) {
                $count = self::executeSqlFile($file);
                self::writeLog('数据库脚本执行完成: ' . $file);
                $result['files'][] = [
                    'file' => $file,
                    'statements' => $count,
                ];
                $result['statements'] += $count;
            }
        }
        if (!$result['files']) {
            $result['file'] = '';
        }
        return $result;
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
        self::useUtf8mb4Connection();
        $sql = file_get_contents($file);
        $sql = self::applyConfiguredTablePrefix($sql);
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
        $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;
        $buffer = '';
        $statements = [];
        foreach (preg_split('/\r\n|\r|\n/', $sql) as $line) {
            $trim = trim($line);
            if ($trim === '' || str_starts_with($trim, '--') || str_starts_with($trim, '#') || stripos($trim, 'DELIMITER ') === 0) {
                continue;
            }
            $buffer .= $line . "\n";
        }

        $current = '';
        $quote = null;
        $length = strlen($buffer);
        for ($i = 0; $i < $length; $i++) {
            $char = $buffer[$i];
            $current .= $char;
            if ($quote !== null) {
                if ($char === '\\') {
                    if ($i + 1 < $length) {
                        $current .= $buffer[++$i];
                    }
                    continue;
                }
                if ($char === $quote) {
                    $quote = null;
                }
                continue;
            }

            if ($char === "'" || $char === '"' || $char === '`') {
                $quote = $char;
                continue;
            }

            if ($char === ';') {
                $statement = trim(substr($current, 0, -1));
                if ($statement !== '') {
                    $statements[] = $statement;
                }
                $current = '';
            }
        }

        if (trim($current) !== '') {
            $statements[] = $current;
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
                || str_starts_with($relative, 'weimenjin_admin/backup/update/')
                || str_starts_with($relative, self::WORK_DIR . '/')
                || str_starts_with($relative, 'weimenjin_admin/' . self::WORK_DIR . '/')
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
        self::ensureAppConfigTable();
        self::saveAppConfig('update', 'current_version', $version);
        $manifestUrl = self::stableManifestUrlForStorage($manifestUrl);
        if ($manifestUrl !== '') {
            self::saveAppConfig('update', 'manifest_url', $manifestUrl);
        }
        self::useUtf8mb4Connection();
        self::ensureCloudAppConfigs();
        self::ensureRuntimeAppConfigs();
        self::refreshRuntimeConfigFromDatabase();
    }

    private static function stableManifestUrlForStorage(string $manifestUrl): string
    {
        $manifestUrl = trim($manifestUrl);
        if ($manifestUrl === '') {
            return '';
        }

        $path = (string) (parse_url($manifestUrl, PHP_URL_PATH) ?: '');
        if (basename($path) !== 'manifest.json') {
            return self::DEFAULT_MANIFEST_URL;
        }

        return $manifestUrl;
    }

    private static function migrateRuntimeConfigToDatabase(array $runtimeConfig): array
    {
        $result = [
            'checked' => 0,
            'inserted' => 0,
            'updated' => 0,
            'skipped' => 0,
        ];
        if (!$runtimeConfig) {
            return $result;
        }

        self::useUtf8mb4Connection();
        try {
            self::ensureCloudAppConfigs();
            self::ensureRuntimeAppConfigs();
        } catch (\Throwable $e) {
            self::writeLog('旧运行配置迁移跳过，应用配置表暂不可用: ' . $e->getMessage());
            return $result;
        }

        foreach (self::runtimeConfigMappings() as $mapping) {
            $result['checked']++;
            $value = self::runtimeConfigValue($runtimeConfig, $mapping['path']);
            if (!self::isMigratableConfigValue($value)) {
                $result['skipped']++;
                continue;
            }

            $saved = self::saveAppConfigFromRuntime(
                $mapping['module'],
                $mapping['module_name'],
                $mapping['name'],
                self::serializeAppConfigValue($value, $mapping['type']),
                $mapping['type'],
                $mapping['description'],
                (int) $mapping['is_grouped'],
                (int) $mapping['sort_order'],
                (int) $mapping['group_sort_order'],
                array_key_exists('default', $mapping) ? self::serializeAppConfigValue($mapping['default'], $mapping['type']) : null,
                !empty($mapping['runtime_wins'])
            );
            $result[$saved]++;
        }

        self::writeLog('旧运行配置已迁移到数据库: ' . json_encode($result, JSON_UNESCAPED_UNICODE));
        return $result;
    }

    private static function runtimeConfigMappings(): array
    {
        return [
            ['path' => ['wmjsms', 'wmjsms_appid'], 'module' => 'wmjsms', 'module_name' => '短信接口', 'name' => 'wmjsms_appid', 'type' => 'string', 'description' => '微门禁短信AppID', 'is_grouped' => 1, 'sort_order' => 93, 'group_sort_order' => 1, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjsms', 'wmjsms_appsecret'], 'module' => 'wmjsms', 'module_name' => '短信接口', 'name' => 'wmjsms_appsecret', 'type' => 'string', 'description' => '微门禁短信AppSecret', 'is_grouped' => 1, 'sort_order' => 93, 'group_sort_order' => 2, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjsms', 'wmjsms_lable'], 'module' => 'wmjsms', 'module_name' => '短信接口', 'name' => 'wmjsms_lable', 'type' => 'string', 'description' => '短信签名', 'is_grouped' => 1, 'sort_order' => 93, 'group_sort_order' => 3, 'default' => '【微门禁】', 'runtime_wins' => true],
            ['path' => ['wxmp', 'wxmp_appid'], 'module' => 'wxmp', 'module_name' => '微信小程序配置', 'name' => 'wxmp_appid', 'type' => 'string', 'description' => 'AppID(小程序ID)', 'is_grouped' => 1, 'sort_order' => 100, 'group_sort_order' => 1, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wxmp', 'wxmp_appsecret'], 'module' => 'wxmp', 'module_name' => '微信小程序配置', 'name' => 'wxmp_appsecret', 'type' => 'string', 'description' => 'AppSecret(小程序密钥)', 'is_grouped' => 1, 'sort_order' => 100, 'group_sort_order' => 2, 'default' => '', 'runtime_wins' => true],
            ['path' => ['siteconfig', 'siteurl'], 'module' => 'siteconfig', 'module_name' => '站点链接', 'name' => 'siteurl', 'type' => 'string', 'description' => '站点链接', 'is_grouped' => 1, 'sort_order' => 0, 'group_sort_order' => 0, 'default' => 'https://demo.wmj.com.cn', 'runtime_wins' => true],
            ['path' => ['siteconfig', 'icp_enabled'], 'module' => 'siteconfig', 'module_name' => '备案信息', 'name' => 'icp_enabled', 'type' => 'boolean', 'description' => '是否显示工信部备案', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 2, 'default' => true, 'runtime_wins' => true],
            ['path' => ['siteconfig', 'icp_no'], 'module' => 'siteconfig', 'module_name' => '备案信息', 'name' => 'icp_no', 'type' => 'string', 'description' => '工信部备案号', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 3, 'default' => '', 'runtime_wins' => true],
            ['path' => ['siteconfig', 'icp_url'], 'module' => 'siteconfig', 'module_name' => '备案信息', 'name' => 'icp_url', 'type' => 'string', 'description' => '工信部备案链接', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 4, 'default' => 'https://beian.miit.gov.cn/', 'runtime_wins' => true],
            ['path' => ['wmjv1', 'wmjv1_url'], 'module' => 'wmjv1', 'module_name' => '微门禁V1接口', 'name' => 'wmjv1_url', 'type' => 'string', 'description' => '微门禁V1硬件云地址', 'is_grouped' => 1, 'sort_order' => 96, 'group_sort_order' => 1, 'default' => 'https://www.wmj.com.cn', 'runtime_wins' => true],
            ['path' => ['wmjv1', 'wmjv1_appid'], 'module' => 'wmjv1', 'module_name' => '微门禁V1接口', 'name' => 'wmjv1_appid', 'type' => 'string', 'description' => '微门禁V1硬件appid', 'is_grouped' => 1, 'sort_order' => 96, 'group_sort_order' => 2, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjv1', 'wmjv1_appsecret'], 'module' => 'wmjv1', 'module_name' => '微门禁V1接口', 'name' => 'wmjv1_appsecret', 'type' => 'string', 'description' => '微门禁V1硬件appsecret', 'is_grouped' => 1, 'sort_order' => 96, 'group_sort_order' => 3, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjv2', 'wmjv2_url'], 'module' => 'wmjv2', 'module_name' => '微门禁V2接口', 'name' => 'wmjv2_url', 'type' => 'string', 'description' => '微门禁V2硬件云地址', 'is_grouped' => 1, 'sort_order' => 95, 'group_sort_order' => 1, 'default' => 'https://wdev.wmj.com.cn/deviceApi/', 'runtime_wins' => true],
            ['path' => ['wmjv2', 'wmjv2_appid'], 'module' => 'wmjv2', 'module_name' => '微门禁V2接口', 'name' => 'wmjv2_appid', 'type' => 'string', 'description' => '微门禁V2硬件appid', 'is_grouped' => 1, 'sort_order' => 95, 'group_sort_order' => 2, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjv2', 'wmjv2_appsecret'], 'module' => 'wmjv2', 'module_name' => '微门禁V2接口', 'name' => 'wmjv2_appsecret', 'type' => 'string', 'description' => '微门禁V2硬件appsecret', 'is_grouped' => 1, 'sort_order' => 95, 'group_sort_order' => 3, 'default' => '', 'runtime_wins' => true],
            ['path' => ['wmjv2', 'video_sdk_appid'], 'module' => 'wmjv2', 'module_name' => '微门禁V2接口', 'name' => 'video_sdk_appid', 'type' => 'string', 'description' => '视频SDK AppID', 'is_grouped' => 1, 'sort_order' => 95, 'group_sort_order' => 4, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_enabled'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_enabled', 'type' => 'boolean', 'description' => '路由1启用', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 1, 'default' => true, 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_name'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_name', 'type' => 'string', 'description' => '路由1名称', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 2, 'default' => '摄像头官方硬件云', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_prefixes'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_prefixes', 'type' => 'string', 'description' => '路由1设备前缀', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 3, 'default' => 'W33,W34', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_url'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_url', 'type' => 'string', 'description' => '路由1硬件云地址', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 4, 'default' => 'https://wdev.wmj.com.cn/deviceApi/', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_appid', 'type' => 'string', 'description' => '路由1硬件云appid', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 5, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_appsecret'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_appsecret', 'type' => 'string', 'description' => '路由1硬件云appsecret', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 6, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route1_video_sdk_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route1_video_sdk_appid', 'type' => 'string', 'description' => '路由1视频SDK AppID', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 7, 'default' => 'f268a2e5eff745cdba45ea00ec806f6c', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_enabled'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_enabled', 'type' => 'boolean', 'description' => '路由2启用', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 7, 'default' => false, 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_name'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_name', 'type' => 'string', 'description' => '路由2名称', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 8, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_prefixes'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_prefixes', 'type' => 'string', 'description' => '路由2设备前缀', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 9, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_url'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_url', 'type' => 'string', 'description' => '路由2硬件云地址', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 10, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_appid', 'type' => 'string', 'description' => '路由2硬件云appid', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 11, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_appsecret'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_appsecret', 'type' => 'string', 'description' => '路由2硬件云appsecret', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 12, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route2_video_sdk_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route2_video_sdk_appid', 'type' => 'string', 'description' => '路由2视频SDK AppID', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 13, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_enabled'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_enabled', 'type' => 'boolean', 'description' => '路由3启用', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 13, 'default' => false, 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_name'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_name', 'type' => 'string', 'description' => '路由3名称', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 14, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_prefixes'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_prefixes', 'type' => 'string', 'description' => '路由3设备前缀', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 15, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_url'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_url', 'type' => 'string', 'description' => '路由3硬件云地址', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 16, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_appid', 'type' => 'string', 'description' => '路由3硬件云appid', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 17, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_appsecret'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_appsecret', 'type' => 'string', 'description' => '路由3硬件云appsecret', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 18, 'default' => '', 'runtime_wins' => true],
            ['path' => ['hardware_cloud_routes', 'route3_video_sdk_appid'], 'module' => 'hardware_cloud_routes', 'module_name' => '硬件云路由配置', 'name' => 'route3_video_sdk_appid', 'type' => 'string', 'description' => '路由3视频SDK AppID', 'is_grouped' => 1, 'sort_order' => 97, 'group_sort_order' => 19, 'default' => '', 'runtime_wins' => true],
            ['path' => ['miniapp', 'site_url'], 'module' => 'miniapp', 'module_name' => '小程序运行配置', 'name' => 'site_url', 'type' => 'string', 'description' => '小程序站点地址', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 1, 'default' => 'https://demo.wmj.com.cn', 'runtime_wins' => true],
            ['path' => ['miniapp', 'api_url'], 'module' => 'miniapp', 'module_name' => '小程序运行配置', 'name' => 'api_url', 'type' => 'string', 'description' => '小程序接口地址', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 2, 'default' => 'https://demo.wmj.com.cn/api', 'runtime_wins' => true],
            ['path' => ['miniapp', 'asset_url'], 'module' => 'miniapp', 'module_name' => '小程序运行配置', 'name' => 'asset_url', 'type' => 'string', 'description' => '小程序资源地址', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 3, 'default' => 'https://demo.wmj.com.cn', 'runtime_wins' => true],
            ['path' => ['miniapp', 'camweb_url'], 'module' => 'miniapp', 'module_name' => '小程序运行配置', 'name' => 'camweb_url', 'type' => 'string', 'description' => '摄像头 Web 地址', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 4, 'default' => 'https://demo.wmj.com.cn/camweb/', 'runtime_wins' => true],
            ['path' => ['live_talk', 'enabled'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'enabled', 'type' => 'boolean', 'description' => '是否启用实时对讲', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 1, 'default' => false],
            ['path' => ['live_talk', 'public_wss_base'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'public_wss_base', 'type' => 'string', 'description' => '公开 WebSocket 基础地址', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 2, 'default' => ''],
            ['path' => ['live_talk', 'app_ws_protocol'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'app_ws_protocol', 'type' => 'string', 'description' => 'WebSocket 协议', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 3, 'default' => 'wss'],
            ['path' => ['live_talk', 'app_ws_host'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'app_ws_host', 'type' => 'string', 'description' => 'WebSocket 主机', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 4, 'default' => ''],
            ['path' => ['live_talk', 'app_ws_port'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'app_ws_port', 'type' => 'string', 'description' => 'WebSocket 端口', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 5, 'default' => ''],
            ['path' => ['live_talk', 'app_ws_path_prefix'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'app_ws_path_prefix', 'type' => 'string', 'description' => 'WebSocket 路径前缀', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 6, 'default' => '/ws/horn/live/app'],
            ['path' => ['live_talk', 'sample_rate'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'sample_rate', 'type' => 'integer', 'description' => '采样率', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 7, 'default' => 16000],
            ['path' => ['live_talk', 'channels'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'channels', 'type' => 'integer', 'description' => '声道数', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 8, 'default' => 1],
            ['path' => ['live_talk', 'encode_bitrate'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'encode_bitrate', 'type' => 'integer', 'description' => '编码码率', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 9, 'default' => 64000],
            ['path' => ['live_talk', 'frame_size_kb'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'frame_size_kb', 'type' => 'integer', 'description' => '录音分片大小 KB', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 10, 'default' => 1],
            ['path' => ['live_talk', 'chunk_delay_ms'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'chunk_delay_ms', 'type' => 'integer', 'description' => '音频分片发送间隔毫秒', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 11, 'default' => 40],
            ['path' => ['live_talk', 'max_duration_sec'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'max_duration_sec', 'type' => 'integer', 'description' => '单次对讲最长秒数', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 12, 'default' => 90],
            ['path' => ['live_talk', 'app_upload_codec'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'app_upload_codec', 'type' => 'string', 'description' => '小程序上传音频编码', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 13, 'default' => 'mp3'],
            ['path' => ['live_talk', 'default_audio_url'], 'module' => 'live_talk', 'module_name' => '实时对讲配置', 'name' => 'default_audio_url', 'type' => 'string', 'description' => '默认测试音频地址', 'is_grouped' => 1, 'sort_order' => 89, 'group_sort_order' => 14, 'default' => '/audio/wmj.mp3'],
            ['path' => ['login', 'disclaimer_content'], 'module' => 'login', 'module_name' => '登录设置', 'name' => 'disclaimer_content', 'type' => 'string', 'description' => '登录页免责声明', 'is_grouped' => 1, 'sort_order' => 90, 'group_sort_order' => 1, 'default' => ''],
        ];
    }

    private static function runtimeConfigValue(array $config, array $path): mixed
    {
        $value = $config;
        foreach ($path as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return null;
            }
            $value = $value[$segment];
        }
        return $value;
    }

    private static function isMigratableConfigValue(mixed $value): bool
    {
        if ($value === null || is_array($value) || is_object($value)) {
            return false;
        }
        return trim((string) self::serializeAppConfigValue($value, 'string')) !== '';
    }

    private static function serializeAppConfigValue(mixed $value, string $type): string
    {
        if ($type === 'boolean') {
            return ($value === true || $value === 1 || $value === '1' || strtolower((string) $value) === 'true') ? '1' : '0';
        }
        if ($type === 'integer') {
            return (string) (int) $value;
        }
        if ($type === 'array') {
            return json_encode((array) $value, JSON_UNESCAPED_UNICODE);
        }
        return (string) $value;
    }

    private static function saveAppConfigFromRuntime(string $module, string $moduleTitle, string $name, string $value, string $type, string $description, int $isGrouped, int $sortOrder, int $groupSortOrder, ?string $defaultValue, bool $runtimeWins = false): string
    {
        $exists = Db::name('appconfig')->where(['module' => $module, 'name' => $name])->find();
        if ($exists) {
            self::updateAppConfigMeta((int) $exists['id'], $moduleTitle, $description, $sortOrder, $groupSortOrder, $type);
            $current = (string) ($exists['value'] ?? '');
            $shouldUpdate = $current === '' || ($defaultValue !== null && $current === $defaultValue && $value !== $defaultValue);
            if ($runtimeWins && $value !== '' && $current !== $value) {
                $shouldUpdate = true;
            }
            if ($shouldUpdate) {
                self::saveAppConfig($module, $name, $value);
                return 'updated';
            }
            return 'skipped';
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
            $data['is_grouped'] = $isGrouped;
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
        return 'inserted';
    }

    public static function refreshRuntimeConfigFromDatabase(): bool
    {
        static $migratingRuntimeConfig = false;
        self::useUtf8mb4Connection();
        if (!$migratingRuntimeConfig) {
            $migratingRuntimeConfig = true;
            try {
                self::migrateRuntimeConfigToDatabase(self::loadRuntimeConfigSnapshot());
            } finally {
                $migratingRuntimeConfig = false;
            }
        }
        $configs = Db::name('appconfig')->select()->toArray();
        $structuredConfig = [];
        foreach ($configs as $config) {
            $value = self::parseAppConfigValue((string) ($config['value'] ?? ''), (string) ($config['type'] ?? 'string'));
            if (!empty($config['is_grouped'])) {
                $structuredConfig[(string) $config['module']][(string) $config['name']] = $value;
            } else {
                $structuredConfig[(string) $config['name']] = $value;
            }
        }

        $file = root_path() . 'config/my.php';
        $dir = dirname($file);
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \RuntimeException('配置目录不可写，无法自动生成 config/my.php');
        }

        $content = "<?php\n\nreturn " . self::exportConfigArray($structuredConfig) . ";\n";
        $tmp = $file . '.tmp.' . getmypid();
        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new \RuntimeException('写入运行配置文件失败: config/my.php');
        }
        if (!rename($tmp, $file)) {
            @unlink($tmp);
            throw new \RuntimeException('替换运行配置文件失败: config/my.php');
        }

        Cache::delete('db_configs');
        self::writeLog('运行配置已从数据库自动刷新: config/my.php');
        return true;
    }

    private static function ensureCloudAppConfigs(): void
    {
        self::ensureAppConfigTable();
        self::insertAppConfigIfMissing('wmjv1', '微门禁V1接口', 'wmjv1_url', 'https://www.wmj.com.cn', '微门禁V1硬件云地址', 96, 1);
        self::insertAppConfigIfMissing('wmjv2', '微门禁V2接口', 'wmjv2_url', 'https://wdev.wmj.com.cn/deviceApi/', '微门禁V2硬件云地址', 95, 1);
        self::updateAppConfigSort('wmjv1', 'wmjv1_appid', 2);
        self::updateAppConfigSort('wmjv1', 'wmjv1_appsecret', 3);
        self::updateAppConfigSort('wmjv2', 'wmjv2_appid', 2);
        self::updateAppConfigSort('wmjv2', 'wmjv2_appsecret', 3);
        self::insertAppConfigIfMissing('wmjv2', '微门禁V2接口', 'video_sdk_appid', '', '视频SDK AppID', 95, 4);
        Db::name('appconfig')->where(['module' => 'hardware_cloud_routes', 'name' => 'routes'])->delete();
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_enabled', '1', '路由1启用', 97, 1, 'boolean');
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_name', '摄像头官方硬件云', '路由1名称', 97, 2);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_prefixes', 'W33,W34', '路由1设备前缀', 97, 3);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_url', 'https://wdev.wmj.com.cn/deviceApi/', '路由1硬件云地址', 97, 4);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_appid', '', '路由1硬件云appid', 97, 5);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_appsecret', '', '路由1硬件云appsecret', 97, 6);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route1_video_sdk_appid', 'f268a2e5eff745cdba45ea00ec806f6c', '路由1视频SDK AppID', 97, 7);
        Db::name('appconfig')->where(['module' => 'hardware_cloud_routes', 'name' => 'route1_video_sdk_appid'])->where('value', '')->update(['value' => 'f268a2e5eff745cdba45ea00ec806f6c']);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_enabled', '0', '路由2启用', 97, 7, 'boolean');
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_name', '', '路由2名称', 97, 8);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_prefixes', '', '路由2设备前缀', 97, 9);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_url', '', '路由2硬件云地址', 97, 10);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_appid', '', '路由2硬件云appid', 97, 11);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_appsecret', '', '路由2硬件云appsecret', 97, 12);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route2_video_sdk_appid', '', '路由2视频SDK AppID', 97, 13);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_enabled', '0', '路由3启用', 97, 13, 'boolean');
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_name', '', '路由3名称', 97, 14);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_prefixes', '', '路由3设备前缀', 97, 15);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_url', '', '路由3硬件云地址', 97, 16);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_appid', '', '路由3硬件云appid', 97, 17);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_appsecret', '', '路由3硬件云appsecret', 97, 18);
        self::insertAppConfigIfMissing('hardware_cloud_routes', '硬件云路由配置', 'route3_video_sdk_appid', '', '路由3视频SDK AppID', 97, 19);
    }

    private static function ensureRuntimeAppConfigs(): void
    {
        self::ensureAppConfigTable();
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'site_url', 'https://demo.wmj.com.cn', '小程序站点地址', 90, 1);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'api_url', 'https://demo.wmj.com.cn/api', '小程序接口地址', 90, 2);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'asset_url', 'https://demo.wmj.com.cn', '小程序资源地址', 90, 3);
        self::insertAppConfigIfMissing('miniapp', '小程序运行配置', 'camweb_url', 'https://demo.wmj.com.cn/camweb/', '摄像头 Web 地址', 90, 4);
        self::insertAppConfigIfMissing('siteconfig', '备案信息', 'icp_enabled', '1', '是否显示工信部备案', 90, 2, 'boolean');
        self::insertAppConfigIfMissing('siteconfig', '备案信息', 'icp_no', '', '工信部备案号', 90, 3);
        self::insertAppConfigIfMissing('siteconfig', '备案信息', 'icp_url', 'https://beian.miit.gov.cn/', '工信部备案链接', 90, 4);

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
        self::insertAppConfigIfMissing('login', '登录设置', 'disclaimer_content', '', '登录页免责声明', 90, 1);
    }

    private static function insertAppConfigIfMissing(string $module, string $moduleTitle, string $name, string $value, string $description, int $sortOrder, int $groupSortOrder, string $type = 'string'): void
    {
        $exists = Db::name('appconfig')->where(['module' => $module, 'name' => $name])->find();
        if ($exists) {
            self::updateAppConfigMeta((int) $exists['id'], $moduleTitle, $description, $sortOrder, $groupSortOrder, $type);
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

    private static function updateAppConfigMeta(int $id, string $moduleTitle, string $description, int $sortOrder, int $groupSortOrder, string $type): void
    {
        $columns = self::appConfigColumns();
        $data = [];
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
        if (in_array('type', $columns, true)) {
            $data['type'] = $type;
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
        if (in_array('updated_at', $columns, true)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }
        if (in_array('update_time', $columns, true)) {
            $data['update_time'] = time();
        }
        if ($data) {
            Db::name('appconfig')->where('id', $id)->update($data);
        }
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

    private static function parseAppConfigValue(string $value, string $type): mixed
    {
        switch ($type) {
            case 'boolean':
                return $value === '1' || strtolower($value) === 'true';
            case 'integer':
                return (int) $value;
            case 'array':
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            case 'string':
            default:
                return $value;
        }
    }

    private static function exportConfigArray(array $array, int $indent = 1, ?string $parentKey = null): string
    {
        $indentation = str_repeat('    ', $indent);
        $code = "[\n";
        foreach ($array as $key => $value) {
            if ($parentKey === 'nocheck') {
                $code .= $indentation . self::formatConfigValue($value, $indent + 1) . ",\n";
                continue;
            }
            $formattedKey = is_int($key) ? (string) $key : var_export((string) $key, true);
            $code .= $indentation . $formattedKey . ' => ' . self::formatConfigValue($value, $indent + 1, (string) $key) . ",\n";
        }
        $code .= str_repeat('    ', $indent - 1) . "]";
        return $code;
    }

    private static function formatConfigValue(mixed $value, int $indent, ?string $parentKey = null): string
    {
        if (is_array($value)) {
            return self::exportConfigArray($value, $indent, $parentKey);
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_int($value)) {
            return (string) $value;
        }
        return var_export((string) $value, true);
    }

    private static function appConfigColumns(): array
    {
        static $columns = null;
        if ($columns !== null) {
            return $columns;
        }
        self::ensureAppConfigTable();
        $prefix = (string) config('database.connections.mysql.prefix', '');
        $table = $prefix . 'appconfig';
        $rows = Db::query('SHOW COLUMNS FROM `' . str_replace('`', '``', $table) . '`');
        $columns = array_map(static fn($row) => (string) ($row['Field'] ?? ''), $rows);
        return $columns;
    }

    private static function ensureAppConfigTable(): void
    {
        static $checked = false;
        if ($checked) {
            return;
        }
        $prefix = (string) config('database.connections.mysql.prefix', 'cd_');
        $table = str_replace('`', '``', $prefix . 'appconfig');
        Db::execute("CREATE TABLE IF NOT EXISTS `{$table}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `module` varchar(50) NOT NULL DEFAULT '',
            `module_name` varchar(100) NOT NULL DEFAULT '',
            `name` varchar(100) NOT NULL DEFAULT '',
            `value` text,
            `type` varchar(20) NOT NULL DEFAULT 'string',
            `description` varchar(255) NOT NULL DEFAULT '',
            `created_at` datetime DEFAULT NULL,
            `is_grouped` tinyint(1) NOT NULL DEFAULT 0,
            `is_readonly` tinyint(1) NOT NULL DEFAULT 0,
            `sort_order` int(11) NOT NULL DEFAULT 0,
            `group_sort_order` int(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uk_module_name` (`module`,`name`),
            KEY `idx_module` (`module`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        $checked = true;
    }

    private static function useUtf8mb4Connection(): void
    {
        try {
            Db::execute('SET NAMES utf8mb4');
        } catch (\Throwable $e) {
            self::writeLog('数据库字符集设置跳过: ' . $e->getMessage());
        }
    }

    private static function requiredDatabaseTables(): array
    {
        $prefix = (string) config('database.connections.mysql.prefix', 'cd_');
        return [
            $prefix . 'cam_remote_control' => '摄像头遥控器配置表',
            $prefix . 'horn_broadcast_history' => '云喇叭播报历史表',
            $prefix . 'areas' => '区域表',
            $prefix . 'buildings' => '楼栋表',
            $prefix . 'units' => '单元表',
            $prefix . 'rooms' => '房号表',
            $prefix . 'member_rooms' => '用户房号绑定表',
            $prefix . 'member_room_applications' => '房号授权申请表',
            $prefix . 'member_push_tokens' => '用户推送 Token 表',
        ];
    }

    private static function existingTables(array $tables): array
    {
        if (!$tables) {
            return [];
        }
        $quotedTables = implode(',', array_map([self::class, 'quoteSqlValue'], array_values($tables)));
        $rows = Db::query(
            'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME IN (' . $quotedTables . ')'
        );
        return array_map(static fn($row) => (string) ($row['TABLE_NAME'] ?? ''), $rows);
    }

    private static function requiredDatabaseColumns(): array
    {
        $prefix = (string) config('database.connections.mysql.prefix', 'cd_');
        return [
            [
                'table' => $prefix . 'lock',
                'column' => 'openttscontent',
                'label' => '云喇叭播报内容字段',
                'allowed_types' => ['text', 'mediumtext', 'longtext'],
            ],
        ];
    }

    private static function existingColumnDefinitions(array $columns): array
    {
        if (!$columns) {
            return [];
        }
        $conditions = [];
        foreach ($columns as $column) {
            $conditions[] = '(TABLE_NAME = ' . self::quoteSqlValue($column['table']) . ' AND COLUMN_NAME = ' . self::quoteSqlValue($column['column']) . ')';
        }
        $rows = Db::query(
            'SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND (' . implode(' OR ', $conditions) . ')'
        );
        $result = [];
        foreach ($rows as $row) {
            $result[(string) $row['TABLE_NAME'] . '.' . (string) $row['COLUMN_NAME']] = $row;
        }
        return $result;
    }

    private static function applyConfiguredTablePrefix(string $sql): string
    {
        $prefix = (string) config('database.connections.mysql.prefix', 'cd_');
        if ($prefix === '' || $prefix === 'cd_') {
            return $sql;
        }
        $backtickPrefix = str_replace('`', '``', $prefix);
        $quotedPrefix = str_replace(["\\", "'"], ["\\\\", "\\'"], $prefix);
        return str_replace(['`cd_', "'cd_"], ['`' . $backtickPrefix, "'" . $quotedPrefix], $sql);
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
        self::assertSafeHttpUrl($url);
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
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
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

    private static function assertSafeHttpUrl(string $url): void
    {
        $parts = parse_url($url);
        $scheme = strtolower((string) ($parts['scheme'] ?? ''));
        $host = (string) ($parts['host'] ?? '');
        if (!in_array($scheme, ['http', 'https'], true) || $host === '') {
            throw new \RuntimeException('Only HTTP/HTTPS update URLs are allowed');
        }

        $ips = self::resolveHostIps($host);
        if (!$ips) {
            throw new \RuntimeException('Update URL host cannot be resolved');
        }
        foreach ($ips as $ip) {
            if (self::isPrivateOrReservedIp($ip)) {
                throw new \RuntimeException('Update URL cannot point to local, private, or reserved IP ranges');
            }
        }
    }

    private static function resolveHostIps(string $host): array
    {
        $host = trim($host, '[]');
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return [$host];
        }

        $records = @dns_get_record($host, DNS_A + DNS_AAAA);
        if (!is_array($records)) {
            return [];
        }

        $ips = [];
        foreach ($records as $record) {
            foreach (['ip', 'ipv6'] as $key) {
                if (!empty($record[$key]) && filter_var($record[$key], FILTER_VALIDATE_IP)) {
                    $ips[] = (string) $record[$key];
                }
            }
        }
        return array_values(array_unique($ips));
    }

    private static function isPrivateOrReservedIp(string $ip): bool
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $long = ip2long($ip);
            $ranges = [
                ['0.0.0.0', '0.255.255.255'],
                ['10.0.0.0', '10.255.255.255'],
                ['100.64.0.0', '100.127.255.255'],
                ['127.0.0.0', '127.255.255.255'],
                ['169.254.0.0', '169.254.255.255'],
                ['172.16.0.0', '172.31.255.255'],
                ['192.0.0.0', '192.0.0.255'],
                ['192.0.2.0', '192.0.2.255'],
                ['192.168.0.0', '192.168.255.255'],
                ['198.18.0.0', '198.19.255.255'],
                ['198.51.100.0', '198.51.100.255'],
                ['203.0.113.0', '203.0.113.255'],
                ['224.0.0.0', '255.255.255.255'],
            ];
            foreach ($ranges as [$start, $end]) {
                if ($long >= ip2long($start) && $long <= ip2long($end)) {
                    return true;
                }
            }
            return false;
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
            && !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
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
        static $prepared = false;
        $dir = root_path() . self::WORK_DIR;
        self::ensureWritableDir($dir, '更新临时目录');
        if (!$prepared) {
            $prepared = true;
            self::cleanupStaleUpdateArtifacts($dir);
        }
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

    private static function updateProgress(string $stage, string $message, array $manifest = []): void
    {
        $file = self::workPath('update.lock');
        if (!is_file($file)) {
            return;
        }
        $raw = (string) file_get_contents($file);
        $data = json_decode($raw, true);
        if (!is_array($data)) {
            $startedAt = trim($raw) !== '' && ctype_digit(trim($raw)) ? (int) trim($raw) : (filemtime($file) ?: time());
            $data = [
                'started_at_ts' => $startedAt,
                'pid' => function_exists('getmypid') ? (int) getmypid() : 0,
            ];
        }
        $data['stage'] = $stage;
        $data['message'] = $message;
        $data['updated_at_ts'] = time();
        if (isset($manifest['version'])) {
            $data['version'] = (string) $manifest['version'];
        }
        if (isset($manifest['_manifest_url'])) {
            $data['manifest_url'] = (string) $manifest['_manifest_url'];
        }
        if (isset($manifest['package_url'])) {
            $data['package_url'] = (string) $manifest['package_url'];
        }
        if (isset($manifest['selected_package'])) {
            $data['selected_package'] = (string) $manifest['selected_package'];
        }
        file_put_contents($file, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX);
    }

    private static function unlock(): void
    {
        @unlink(self::workPath('update.lock'));
    }

    private static function cleanupUpdateArtifacts(string $archive, string $extractDir): void
    {
        if ($archive !== '' && is_file($archive)) {
            @unlink($archive);
        }
        if ($extractDir !== '' && is_dir($extractDir)) {
            self::removeDir($extractDir);
        }
        self::cleanupStaleUpdateArtifacts(root_path() . self::WORK_DIR);
        self::writeLog('更新临时文件清理完成');
    }

    private static function cleanupStaleUpdateArtifacts(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $keepSeconds = 86400;
        foreach (glob(rtrim($dir, '/\\') . '/*') ?: [] as $path) {
            $name = basename($path);
            if ($name === 'update.log' || $name === 'update.lock') {
                continue;
            }
            $isUpdateTemp = preg_match('/^(extract_|package_|manifest_)/', $name) === 1;
            if (!$isUpdateTemp) {
                continue;
            }
            if (time() - (int) @filemtime($path) < $keepSeconds) {
                continue;
            }
            is_dir($path) ? self::removeDir($path) : @unlink($path);
        }
    }

    private static function cleanupOldUpdateBackups(): void
    {
        $backupDir = root_path() . 'backup/update';
        if (!is_dir($backupDir)) {
            return;
        }
        foreach (['code_*.zip', 'database_*.sql', 'my_*.php'] as $pattern) {
            $files = glob($backupDir . '/' . $pattern) ?: [];
            usort($files, static fn($a, $b) => filemtime($b) <=> filemtime($a));
            foreach (array_slice($files, self::BACKUP_KEEP_SETS) as $file) {
                @unlink($file);
            }
        }
        self::writeLog('历史更新备份清理完成，保留最近 ' . self::BACKUP_KEEP_SETS . ' 组');
    }

    private static function writeLog(string $message): void
    {
        return;
    }
}
