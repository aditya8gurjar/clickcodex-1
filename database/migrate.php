<?php
/**
 * ClickCodex Technologies - Database Migration & Seeding Runner
 * Can be run via CLI: php database/migrate.php
 * Or accessed via browser for initial provisioning.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

$isCli = (php_sapi_name() === 'cli');

function output(string $msg, string $type = 'info'): void {
    global $isCli;
    if ($isCli) {
        $colors = [
            'info' => "\033[36m",
            'success' => "\033[32m",
            'warn' => "\033[33m",
            'error' => "\033[31m",
            'bold' => "\033[1m",
            'reset' => "\033[0m"
        ];
        $color = $colors[$type] ?? $colors['info'];
        echo $color . $msg . $colors['reset'] . PHP_EOL;
    } else {
        $style = match($type) {
            'success' => 'color: #10b981; font-weight: bold;',
            'error' => 'color: #ef4444; font-weight: bold;',
            'warn' => 'color: #f59e0b;',
            default => 'color: #3b82f6;'
        };
        echo "<div style=\"font-family: monospace; line-height: 1.6; {$style}\">" . htmlspecialchars($msg) . "</div>";
    }
}

if (!$isCli) {
    echo "<!DOCTYPE html><html><head><title>ClickCodex Database Setup</title><style>body{background:#0a0e1a;color:#f8fafc;padding:40px;font-family:sans-serif;}h1{color:#00a2ff;}</style></head><body><h1>ClickCodex Database Migration</h1>";
}

output("=================================================================", 'bold');
output("ClickCodex Technologies - Advanced Database Provisioning Engine", 'bold');
output("=================================================================", 'bold');

$host = getenv('DB_HOST') ?: ($_ENV['DB_HOST'] ?? 'localhost');
$user = getenv('DB_USER') ?: ($_ENV['DB_USER'] ?? 'root');
$pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($_ENV['DB_PASS'] ?? '');
$name = getenv('DB_NAME') ?: ($_ENV['DB_NAME'] ?? 'clickcodex_db');

output("Connecting to MySQL host '{$host}' with user '{$user}'...", 'info');

// 1. Initial connection without database to ensure database exists
$rootConn = @new mysqli($host, $user, $pass);
if ($rootConn->connect_errno) {
    output("FATAL: Failed to connect to MySQL server: " . $rootConn->connect_error, 'error');
    exit(1);
}

// 2. Ensure Database exists with utf8mb4
$createDbSql = "CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
if (!$rootConn->query($createDbSql)) {
    output("FATAL: Could not create database '{$name}': " . $rootConn->error, 'error');
    exit(1);
}
output("Database '{$name}' is ready with utf8mb4_unicode_ci charset.", 'success');
$rootConn->close();

// 3. Connect to the target database
$conn = @new mysqli($host, $user, $pass, $name);
if ($conn->connect_errno) {
    output("FATAL: Failed to connect to database '{$name}': " . $conn->connect_error, 'error');
    exit(1);
}
$conn->set_charset("utf8mb4");

// 4. Run Schema DDL
$schemaFile = __DIR__ . '/schema.sql';
if (!file_exists($schemaFile)) {
    output("FATAL: schema.sql file not found at: {$schemaFile}", 'error');
    exit(1);
}

output("\n--> Executing schema DDL (schema.sql)...", 'info');
$schemaSql = file_get_contents($schemaFile);

// Execute multi-query
if (!$conn->multi_query($schemaSql)) {
    output("FATAL: Error executing schema.sql: " . $conn->error, 'error');
    exit(1);
}

// Flush all results from multi_query
do {
    if ($res = $conn->store_result()) {
        $res->free();
    }
} while ($conn->more_results() && $conn->next_result());

if ($conn->errno) {
    output("FATAL: Schema execution error: " . $conn->error, 'error');
    exit(1);
}
output("✓ Schema successfully applied. All tables created.", 'success');

// 5. Run Seed DML
$seedFile = __DIR__ . '/seed.sql';
if (!file_exists($seedFile)) {
    output("FATAL: seed.sql file not found at: {$seedFile}", 'error');
    exit(1);
}

output("\n--> Executing seed data (seed.sql)...", 'info');
$seedSql = file_get_contents($seedFile);

if (!$conn->multi_query($seedSql)) {
    output("FATAL: Error executing seed.sql: " . $conn->error, 'error');
    exit(1);
}

// Flush all results
do {
    if ($res = $conn->store_result()) {
        $res->free();
    }
} while ($conn->more_results() && $conn->next_result());

if ($conn->errno) {
    output("FATAL: Seed execution error: " . $conn->error, 'error');
    exit(1);
}
output("✓ Production seed data successfully populated.", 'success');

// 6. Audit & Table Verification
output("\n--> Running Database Table Audit...", 'info');
$tablesRes = $conn->query("SHOW TABLES FROM `{$name}`;");
$totalTables = 0;
$totalRows = 0;

$auditResults = [];
while ($row = $tablesRes->fetch_array()) {
    $tableName = $row[0];
    $countRes = $conn->query("SELECT COUNT(*) AS total FROM `{$tableName}`;");
    $rowCount = ($countRes) ? (int)$countRes->fetch_assoc()['total'] : 0;
    $totalTables++;
    $totalRows += $rowCount;
    $auditResults[] = ['table' => $tableName, 'rows' => $rowCount];
}

foreach ($auditResults as $item) {
    output(sprintf("  [%02d] %-32s : %4d records", $totalTables, $item['table'], $item['rows']), 'info');
}

output("\n=================================================================", 'bold');
output(sprintf("MIGRATION COMPLETE! %d Tables Created | %d Records Seeded", $totalTables, $totalRows), 'success');
output("=================================================================", 'bold');

$conn->close();

if (!$isCli) {
    echo "<p style='color:#10b981;font-weight:bold;margin-top:20px;'>Database is ready for production.</p></body></html>";
}
