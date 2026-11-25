<?php
// Form storage: MySQL when includes/secrets.php is filled in, otherwise CSV files in data/.
require_once __DIR__ . '/config.php';

const TABLES = [
    'enquiries'    => ['name', 'email', 'phone', 'company', 'service', 'message', 'ip'],
    'applications' => ['name', 'email', 'phone', 'position', 'experience', 'city', 'message', 'cv_file', 'ip'],
];

function db(): ?PDO {
    static $pdo = false;
    if ($pdo !== false) return $pdo;
    $pdo = null;
    if (!defined('DB_HOST') || DB_HOST === '') return null;
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        // Tables create themselves on first use, so nothing has to be run in phpMyAdmin.
        foreach (TABLES as $t => $cols) {
            $defs = array_map(fn($c) => in_array($c, ['message'], true) ? "`$c` TEXT" : "`$c` VARCHAR(255) NOT NULL DEFAULT ''", $cols);
            $pdo->exec("CREATE TABLE IF NOT EXISTS `$t` (id INT AUTO_INCREMENT PRIMARY KEY, created_at DATETIME NOT NULL, " . implode(', ', $defs) . ") CHARACTER SET utf8mb4");
        }
    } catch (PDOException $e) {
        error_log('OctaPower DB: ' . $e->getMessage());
        $pdo = null;
    }
    return $pdo;
}

// Save one form entry. Falls back to CSV if the database is down, so no enquiry is lost.
function save_entry(string $table, array $row): bool {
    $row = ['created_at' => date('Y-m-d H:i:s')] + array_intersect_key($row, array_flip(TABLES[$table]));
    $ok = false;
    if ($pdo = db()) {
        try {
            $cols = array_keys($row);
            $pdo->prepare("INSERT INTO `$table` (`" . implode('`,`', $cols) . '`) VALUES (' . rtrim(str_repeat('?,', count($cols)), ',') . ')')
                ->execute(array_values($row));
            $ok = true;
        } catch (PDOException $e) {
            error_log('OctaPower DB insert: ' . $e->getMessage());
        }
    }
    if (!$ok) $ok = csv_append(__DIR__ . "/../data/$table.csv", array_keys($row), array_values($row));
    if ($ok) $_SESSION['last_post'] = time();
    return $ok;
}

// Newest first: database rows plus any CSV fallback rows.
function load_entries(string $table, int $limit = 500): array {
    $rows = [];
    if ($pdo = db()) {
        $rows = $pdo->query("SELECT * FROM `$table` ORDER BY id DESC LIMIT " . (int)$limit)->fetchAll();
    }
    $file = __DIR__ . "/../data/$table.csv";
    if (is_file($file) && ($fh = fopen($file, 'r'))) {
        $head = fgetcsv($fh);
        while ($head && ($r = fgetcsv($fh)) !== false) {
            if (count($r) === count($head)) $rows[] = array_combine($head, $r) + ['id' => 'file'];
        }
        fclose($fh);
    }
    usort($rows, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
    return array_slice($rows, 0, $limit);
}
