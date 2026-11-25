<?php
require_once __DIR__ . '/includes/config.php';
session_start();

$services = ['epc' => 'EPC Contracting', 'substation' => 'Substations', 'transmission' => 'Transmission Lines', 'solar' => 'Solar Power Plants', 'mechanical' => 'Mechanical Works', 'civil' => 'Civil Works', 'distribution' => 'EV & Distribution', 'om' => 'O&M Services', 'other' => 'Other'];
$errors = [];
$old = ['name' => '', 'email' => '', 'phone' => '', 'company' => '', 'service' => $_GET['service'] ?? '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $_) $old[$k] = trim((string)($_POST[$k] ?? ''));

    $errors = form_guard();
    if ($old['name'] === '' || mb_strlen($old['name']) > 100) $errors[] = 'Please enter your name.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL) || strlen($old['email']) > 150) $errors[] = 'Please enter a valid email.';
    if ($old['phone'] !== '' && !preg_match('/^[0-9 +\-()]{7,20}$/', $old['phone'])) $errors[] = 'Please enter a valid phone number.';
    if (mb_strlen($old['company']) > 150) $errors[] = 'Company name is too long.';
    if (!isset($services[$old['service']])) $old['service'] = 'other';
    if (mb_strlen($old['message']) < 10 || mb_strlen($old['message']) > 3000) $errors[] = 'Message should be 10–3000 characters.';

    if (!$errors) {
        if (csv_append(__DIR__ . '/data/messages.csv',
            ['Date', 'Name', 'Email', 'Phone', 'Company', 'Service', 'Message', 'IP'],
            [date('Y-m-d H:i:s'), $old['name'], $old['email'], $old['phone'], $old['company'], $services[$old['service']], $old['message'], $_SERVER['REMOTE_ADDR'] ?? ''])) {
            header('Location: /contact?sent=1#form', true, 303);
            exit;
        }
        $errors[] = 'Sorry, we could not save your message. Please email us at ' . EMAIL . '.';
    }
}
$_SESSION['csrf'] ??= bin2hex(random_bytes(16));

$title = 'Contact Us';
$desc  = 'Contact OctaPower for EPC, substation, transmission line and solar project enquiries. Get a quote within 48 hours.';
require __DIR__ . '/includes/header.php';
page_hero('Contact Us', 'Let\'s power your <span class="grad-text">next project.</span>', 'Share your requirement — our engineering team responds within 48 hours with next steps.', 'electrician');
?>

<section class="sec">
  <div class="wrap contact-grid">
    <div class="reveal">
      <p class="eyebrow">Reach us</p>
      <h2>Talk to an engineer, not a call centre.</h2>
      <div class="info-item"><div class="ibox"><?= icon('phone') ?></div><div><small>Call us</small><a href="tel:<?= preg_replace('/\s+/', '', PHONE) ?>"><?= PHONE ?></a></div></div>
      <div class="info-item"><div class="ibox"><?= icon('mail') ?></div><div><small>Email</small><a href="mailto:<?= EMAIL ?>"><?= EMAIL ?></a></div></div>
      <div class="info-item"><div class="ibox"><?= icon('pin') ?></div><div><small>Head office</small><span><?= ADDRESS ?></span></div></div>
      <div class="info-item"><div class="ibox"><?= icon('building') ?></div><div><small>Registered office</small><span><?= REG_ADDRESS ?></span></div></div>
      <div class="info-item"><div class="ibox"><?= icon('clock') ?></div><div><small>Office hours</small><span>Mon – Sat, 9:30 AM – 6:30 PM</span></div></div>
    </div>

    <form class="form reveal" id="form" method="post" action="/contact#form" novalidate style="--d:.12s">
      <?php if (isset($_GET['sent'])): ?>
        <div class="alert ok" role="status">Thank you! Your enquiry has been received — we'll get back to you within 48 hours.</div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert err" role="alert"><?= implode('<br>', array_map('e', $errors)) ?></div>
      <?php endif; ?>
      <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
      <div class="hp" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>
      <div class="fgrid">
        <div><label for="name">Full name *</label><input id="name" name="name" required maxlength="100" autocomplete="name" value="<?= e($old['name']) ?>"></div>
        <div><label for="email">Email *</label><input id="email" name="email" type="email" required maxlength="150" autocomplete="email" value="<?= e($old['email']) ?>"></div>
        <div><label for="phone">Phone</label><input id="phone" name="phone" type="tel" maxlength="20" autocomplete="tel" value="<?= e($old['phone']) ?>"></div>
        <div><label for="company">Company</label><input id="company" name="company" maxlength="150" autocomplete="organization" value="<?= e($old['company']) ?>"></div>
        <div class="full"><label for="service">Service required</label>
          <select id="service" name="service">
            <?php foreach ($services as $k => $v): ?><option value="<?= $k ?>"<?= $old['service'] === $k ? ' selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?>
          </select></div>
        <div class="full"><label for="message">Project details *</label><textarea id="message" name="message" required minlength="10" maxlength="3000" placeholder="Location, capacity / voltage level, timeline…"><?= e($old['message']) ?></textarea></div>
        <div class="full"><button class="btn" type="submit">Send Enquiry <?= icon('arrow') ?></button></div>
      </div>
    </form>
  </div>
  <div class="wrap reveal">
    <iframe class="map" title="Office location" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps?q=<?= rawurlencode(ADDRESS) ?>&output=embed"></iframe>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
