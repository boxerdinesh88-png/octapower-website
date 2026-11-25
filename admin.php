<?php
// Private admin: login, then view enquiries and job applications, download CVs.
require_once __DIR__ . '/includes/db.php';

session_set_cookie_params(['httponly' => true, 'samesite' => 'Strict', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
header('X-Frame-Options: DENY');

$configured = defined('ADMIN_PASS') && strlen(ADMIN_PASS) >= 10;
$_SESSION['csrf'] ??= bin2hex(random_bytes(16));
$csrfOk = fn() => hash_equals($_SESSION['csrf'], (string)($_POST['csrf'] ?? ''));
$error = '';

// Brute-force guard: 5 wrong logins per IP locks the form for 15 minutes.
$lockFile = __DIR__ . '/data/admin_logins.json';
$ip = $_SERVER['REMOTE_ADDR'] ?? '?';
$fails = is_file($lockFile) ? (json_decode((string)file_get_contents($lockFile), true) ?: []) : [];
$fails = array_filter($fails, fn($f) => $f['t'] > time() - 900);
$locked = ($fails[$ip]['n'] ?? 0) >= 5;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && $configured) {
    $u = (string)($_POST['user'] ?? '');
    $p = (string)($_POST['pass'] ?? '');
    $passOk = str_starts_with(ADMIN_PASS, '$2y$') ? password_verify($p, ADMIN_PASS) : hash_equals(ADMIN_PASS, $p);
    if ($locked) {
        $error = 'Too many wrong attempts. Try again in 15 minutes.';
    } elseif ($csrfOk() && hash_equals(ADMIN_USER, $u) && $passOk) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        unset($fails[$ip]);
        @file_put_contents($lockFile, json_encode($fails), LOCK_EX);
        header('Location: /admin', true, 303);
        exit;
    } else {
        $fails[$ip] = ['n' => ($fails[$ip]['n'] ?? 0) + 1, 't' => time()];
        @file_put_contents($lockFile, json_encode($fails), LOCK_EX);
        sleep(1);
        $error = 'Wrong username or password.';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout']) && $csrfOk()) {
    $_SESSION = [];
    session_destroy();
    header('Location: /admin', true, 303);
    exit;
}
$isAdmin = !empty($_SESSION['admin']);

// CV download (admin only, file name must match what careers.php saves).
if ($isAdmin && isset($_GET['cv'])) {
    $f = basename((string)$_GET['cv']);
    $path = __DIR__ . "/data/cv/$f";
    if (!preg_match('/^\d{8}-\d{6}-[0-9a-f]{8}\.(pdf|docx?)$/', $f) || !is_file($path)) { http_response_code(404); exit('Not found'); }
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $f . '"');
    header('Content-Length: ' . filesize($path));
    header('X-Content-Type-Options: nosniff');
    readfile($path);
    exit;
}

$tab = ($_GET['tab'] ?? '') === 'applications' ? 'applications' : 'enquiries';
$rows = $isAdmin ? load_entries($tab) : [];
$cols = $tab === 'enquiries'
    ? ['created_at' => 'Date', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'company' => 'Company', 'service' => 'Service', 'message' => 'Message']
    : ['created_at' => 'Date', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'position' => 'Position', 'experience' => 'Experience', 'city' => 'City', 'message' => 'Cover note', 'cv_file' => 'CV'];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Admin | <?= SITE_NAME ?></title>
<link rel="icon" type="image/png" href="/assets/img/favicon.png">
<link rel="stylesheet" href="/assets/css/style.css?v=4">
<style>
  body{background:#f3f4f6}
  .adm-top{background:var(--ink);color:#fff;padding:14px 0}
  .adm-top .wrap{display:flex;justify-content:space-between;align-items:center;gap:16px}
  .adm-top b{font-size:1.1rem}
  .adm-top button{background:none;border:1px solid rgba(255,255,255,.35);color:#fff;border-radius:999px;padding:8px 16px;cursor:pointer;font:inherit}
  .login{max-width:420px;margin:80px auto}
  .tabs{display:flex;gap:8px;margin:28px 0 18px;flex-wrap:wrap}
  .tabs a{padding:10px 18px;border-radius:999px;background:#fff;border:1px solid var(--line);font-weight:650}
  .tabs a[aria-current]{background:var(--ink);color:#fff;border-color:var(--ink)}
  .tbl{overflow:auto;background:#fff;border:1px solid var(--line);border-radius:14px;margin-bottom:40px}
  table{border-collapse:collapse;width:100%;font-size:.9rem}
  th,td{padding:12px 14px;text-align:left;border-bottom:1px solid var(--line);vertical-align:top}
  th{background:#fafafa;font-weight:700;white-space:nowrap;position:sticky;top:0}
  td.msg{min-width:260px;white-space:pre-wrap}
  td a{color:var(--orange);font-weight:650}
  .empty{padding:40px;text-align:center;color:var(--muted)}
</style>
</head>
<body>
<?php if (!$isAdmin): ?>
  <div class="login">
    <form class="form" method="post" action="/admin">
      <img src="/assets/img/mark-sm.webp" width="47" height="42" alt="" style="margin-bottom:12px">
      <h1 style="font-size:1.5rem">Admin login</h1>
      <?php if (!$configured): ?>
        <div class="alert err">Admin is not set up yet. Add ADMIN_PASS (10+ characters) in includes/secrets.php on the server.</div>
      <?php else: ?>
        <?php if ($error): ?><div class="alert err" role="alert"><?= e($error) ?></div><?php endif; ?>
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <div style="margin-bottom:16px"><label for="user">Username</label><input id="user" name="user" autocomplete="username" required></div>
        <div style="margin-bottom:20px"><label for="pass">Password</label><input id="pass" name="pass" type="password" autocomplete="current-password" required></div>
        <button class="btn" name="login" value="1" type="submit">Log in</button>
      <?php endif; ?>
    </form>
  </div>
<?php else: ?>
  <div class="adm-top"><div class="wrap">
    <b><?= SITE_NAME ?> Admin</b>
    <form method="post" action="/admin"><input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>"><button name="logout" value="1">Log out</button></form>
  </div></div>
  <div class="wrap">
    <nav class="tabs" aria-label="Sections">
      <a href="/admin?tab=enquiries"<?= $tab === 'enquiries' ? ' aria-current="page"' : '' ?>>Enquiries</a>
      <a href="/admin?tab=applications"<?= $tab === 'applications' ? ' aria-current="page"' : '' ?>>Job applications</a>
    </nav>
    <p style="color:var(--muted)"><?= count($rows) ?> entries · newest first<?= db() ? '' : ' · <b>database not connected, showing saved files</b>' ?></p>
    <div class="tbl">
      <?php if (!$rows): ?><div class="empty">No entries yet.</div><?php else: ?>
      <table>
        <thead><tr><?php foreach ($cols as $label): ?><th><?= $label ?></th><?php endforeach; ?></tr></thead>
        <tbody>
        <?php foreach ($rows as $r): ?><tr>
          <?php foreach ($cols as $k => $_): $v = (string)($r[$k] ?? ''); ?>
            <?php if ($k === 'email'): ?><td><a href="mailto:<?= e($v) ?>"><?= e($v) ?></a></td>
            <?php elseif ($k === 'phone'): ?><td><a href="tel:<?= e(ltrim($v, "'")) ?>"><?= e(ltrim($v, "'")) ?></a></td>
            <?php elseif ($k === 'cv_file'): ?><td><?php if ($v !== ''): ?><a href="/admin?cv=<?= rawurlencode(basename($v)) ?>">Download</a><?php endif; ?></td>
            <?php else: ?><td<?= $k === 'message' ? ' class="msg"' : '' ?>><?= e($v) ?></td><?php endif; ?>
          <?php endforeach; ?>
        </tr><?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
</body>
</html>
