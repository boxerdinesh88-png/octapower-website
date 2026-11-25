<?php
// Minimal SMTP sender (SSL, AUTH LOGIN) using the info@ mailbox at Hostinger, so mail passes SPF/DKIM.
// Settings come from secrets.php: SMTP_HOST, SMTP_PORT, SMTP_USER, SMTP_PASS. Not configured = mail is skipped.
require_once __DIR__ . '/config.php';

function send_mail(string $to, string $subject, string $body, string $replyTo = ''): bool {
    if (!defined('SMTP_PASS') || SMTP_PASS === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) return false;
    $fp = @stream_socket_client('ssl://' . SMTP_HOST . ':' . SMTP_PORT, $errno, $errstr, 10);
    if (!$fp) { error_log("SMTP connect failed: $errstr"); return false; }
    stream_set_timeout($fp, 10);
    $read = function () use ($fp) {
        $out = '';
        while (($line = fgets($fp, 515)) !== false) { $out .= $line; if (($line[3] ?? '') === ' ') break; }
        return $out;
    };
    $cmd = function (string $c, int $want) use ($fp, $read) {
        if ($c !== '') fwrite($fp, $c . "\r\n");
        $r = $read();
        if ((int)substr($r, 0, 3) !== $want) throw new RuntimeException(trim($r));
    };
    // Header values are built only from validated addresses and fixed text; strip newlines anyway.
    $clean = fn($s) => str_replace(["\r", "\n"], '', $s);
    $headers = [
        'From: ' . SITE_NAME . ' <' . SMTP_USER . '>',
        'To: <' . $clean($to) . '>',
        'Subject: =?UTF-8?B?' . base64_encode($clean($subject)) . '?=',
        'Date: ' . date('r'),
        'Message-ID: <' . bin2hex(random_bytes(8)) . '@' . explode('@', SMTP_USER)[1] . '>',
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: base64',
    ];
    if (filter_var($replyTo, FILTER_VALIDATE_EMAIL)) $headers[] = 'Reply-To: <' . $clean($replyTo) . '>';
    try {
        $cmd('', 220);
        $cmd('EHLO ' . parse_url(SITE_URL, PHP_URL_HOST), 250);
        $cmd('AUTH LOGIN', 334);
        $cmd(base64_encode(SMTP_USER), 334);
        $cmd(base64_encode(SMTP_PASS), 235);
        $cmd('MAIL FROM:<' . SMTP_USER . '>', 250);
        $cmd('RCPT TO:<' . $clean($to) . '>', 250);
        $cmd('DATA', 354);
        $cmd(implode("\r\n", $headers) . "\r\n\r\n" . chunk_split(base64_encode($body)) . "\r\n.", 250);
        $cmd('QUIT', 221);
        return true;
    } catch (Throwable $e) {
        error_log('SMTP error: ' . $e->getMessage());
        return false;
    } finally {
        fclose($fp);
    }
}

// After a form is saved: thank the sender, and tell the office. Failures never block the form.
function notify_submission(string $kind, array $f): void {
    $name = trim(str_replace(["\r", "\n"], ' ', $f['name'] ?? ''));
    if ($kind === 'enquiry') {
        send_mail($f['email'], 'We received your enquiry — ' . SITE_NAME,
            "Dear $name,\n\nThank you for contacting " . SITE_NAME . ". We have received your enquiry about \"" . ($f['service'] ?? '') . "\" and our team will get back to you within 48 hours.\n\nFor anything urgent, call us at " . PHONE . ".\n\nRegards,\nTeam " . SITE_NAME . "\n" . SITE_URL);
        $summary = "New enquiry\n\nName: $name\nEmail: {$f['email']}\nPhone: " . ($f['phone'] ?? '') . "\nCompany: " . ($f['company'] ?? '') . "\nService: " . ($f['service'] ?? '') . "\n\n" . ($f['message'] ?? '');
    } else {
        send_mail($f['email'], 'Application received — ' . SITE_NAME,
            "Dear $name,\n\nThank you for applying for \"" . ($f['position'] ?? '') . "\" at " . SITE_NAME . ". We have received your application and CV. If your profile matches, our HR team will contact you within 7 days.\n\nRegards,\nHR Team, " . SITE_NAME . "\n" . SITE_URL);
        $summary = "New job application\n\nName: $name\nEmail: {$f['email']}\nPhone: " . ($f['phone'] ?? '') . "\nPosition: " . ($f['position'] ?? '') . "\nExperience: " . ($f['experience'] ?? '') . "\nCity: " . ($f['city'] ?? '') . "\n\nCV: see " . SITE_URL . "/admin?tab=applications\n\n" . ($f['message'] ?? '');
    }
    send_mail(EMAIL, ($kind === 'enquiry' ? 'New enquiry: ' : 'New application: ') . $name, $summary, $f['email']);
}
