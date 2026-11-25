<?php
// Edit these once — every page reads from here.
date_default_timezone_set('Asia/Kolkata');
ini_set('display_errors', '0'); // never show PHP errors (paths, DB details) to visitors
// Database + admin login live in secrets.php (server only, never in git). See secrets.example.php.
if (is_file(__DIR__ . '/secrets.php')) require_once __DIR__ . '/secrets.php';
const SITE_NAME    = 'OctaPower';
const SITE_URL     = 'https://octapower.in'; // no trailing slash
const SITE_TAGLINE = 'Power & Infrastructure, Engineered to Last';
const PHONE        = '+91 97733 10501';
const EMAIL        = 'info@octapower.in';
const ADDRESS      = '2nd Floor, S-12, Aditya City Center, Vaibhav Khand, Indirapuram, Ghaziabad, Uttar Pradesh 201014';
const REG_ADDRESS  = 'F-4048, Gaur Green City, Vaibhav Khand, Indirapuram, PO: Shipra Sun City, Ghaziabad, Uttar Pradesh 201014';
const WHATSAPP     = '919773310501'; // digits only, with country code

const NAV = [
    '/'          => 'Home',
    '/about'     => 'About',
    '/services'  => 'Services',
    '/projects'  => 'Projects',
    '/industries'=> 'Industries',
    '/careers'   => 'Careers',
    '/contact'   => 'Contact',
];

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// Current path without .php, for active nav state.
function current_path(): string {
    $p = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $p = preg_replace('/\.php$/', '', rtrim($p, '/')) ?: '/';
    return $p === '/index' ? '/' : $p;
}

// Shared checks for public forms: CSRF token, honeypot field, 30s per-session rate limit.
function form_guard(): array {
    $err = [];
    if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) $err[] = 'Your session expired. Please submit again.';
    if (($_POST['website'] ?? '') !== '') $err[] = 'Spam detected.';
    if (time() - ($_SESSION['last_post'] ?? 0) < 30) $err[] = 'Please wait a few seconds before sending again.';
    return $err;
}

// Append one row to a CSV in data/ (locked), writing the header on first use.
function csv_append(string $file, array $header, array $row): bool {
    // Neutralise spreadsheet formulas so the CSV is safe to open in Excel.
    $row = array_map(fn($v) => preg_match('/^[=+\-@\t\r]/', (string)$v) ? "'$v" : $v, $row);
    $isNew = !is_file($file);
    $fh = @fopen($file, 'a');
    if (!$fh || !flock($fh, LOCK_EX)) return false;
    if ($isNew) fputcsv($fh, $header);
    fputcsv($fh, $row);
    flock($fh, LOCK_UN);
    fclose($fh);
    return true;
}

// Responsive photo from assets/img/photos/<name>.webp (1400w) + <name>-sm.webp (720w).
function photo(string $name, string $alt, string $sizes = '(max-width:700px) 100vw, 50vw', bool $lazy = true): string {
    $b = '/assets/img/photos/' . $name;
    return "<img src=\"$b-sm.webp\" srcset=\"$b-sm.webp 720w, $b.webp 1400w\" sizes=\"$sizes\" alt=\"" . e($alt) . '"'
        . ($lazy ? ' loading="lazy" decoding="async"' : ' fetchpriority="high"') . '>';
}

// Inline SVG icons (stroke style), kept here so pages stay readable.
function icon(string $name): string {
    $paths = [
        'bolt'     => '<path d="M13 2 4 14h7l-1 8 9-12h-7z"/>',
        'tower'    => '<path d="M12 2 7 22M12 2l5 20M8.5 15h7M9.5 10h5M5 6h14M7 22h10"/>',
        'sun'      => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
        'grid'     => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
        'plug'     => '<path d="M9 2v6M15 2v6M6 8h12v4a6 6 0 0 1-12 0zM12 18v4"/>',
        'building' => '<path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1M14 9h1M9 13h1M14 13h1M9 17h1M14 17h1"/>',
        'road'     => '<path d="M4 22 8 2M20 22 16 2M12 4v3M12 11v3M12 18v3"/>',
        'shield'   => '<path d="M12 2 4 5v6c0 5 3.4 9.5 8 11 4.6-1.5 8-6 8-11V5z"/><path d="m9 12 2 2 4-4"/>',
        'gear'     => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>',
        'clock'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'users'    => '<circle cx="9" cy="8" r="4"/><path d="M2 21a7 7 0 0 1 14 0M16 4a4 4 0 0 1 0 8M22 21a7 7 0 0 0-4-6.3"/>',
        'leaf'     => '<path d="M11 20A7 7 0 0 1 4 13c0-6 6-10 16-10 0 10-4 16-10 16M4 21l8-8"/>',
        'factory'  => '<path d="M2 21h20M4 21V10l5 3V10l5 3V6h4v15"/>',
        'phone'    => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
        'mail'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 6-10 7L2 6"/>',
        'pin'      => '<path d="M12 22s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/>',
        'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'check'    => '<path d="m5 12 5 5L20 7"/>',
        'train'    => '<rect x="5" y="3" width="14" height="14" rx="3"/><path d="M5 11h14M9 21l-2-3M15 21l2-3M9 14h.01M15 14h.01"/>',
        'wrench'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.8-3.8a6 6 0 0 1-7.9 7.9l-6.9 6.9a2.1 2.1 0 0 1-3-3l6.9-6.9a6 6 0 0 1 7.9-7.9z"/>',
        'drop'     => '<path d="M12 2s7 7.6 7 13a7 7 0 0 1-14 0c0-5.4 7-13 7-13z"/>',
    ];
    return '<svg class="ic" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? '') . '</svg>';
}
