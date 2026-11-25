<?php
require_once __DIR__ . '/includes/config.php';
session_start();

$positions = [
    'Project Manager — Substations', 'Site Engineer — Transmission Lines', 'Design Engineer — Electrical',
    'Mechanical Engineer — Piping & Fabrication', 'Civil Engineer — Foundations & Site Works', 'Testing & Commissioning Engineer',
    'HSE Officer', 'Site Supervisor / Foreman', 'Graduate Engineer Trainee', 'Other / General Application',
];
$experience = ['Fresher', '1–3 years', '3–5 years', '5–10 years', '10+ years'];
$cvTypes = ['pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
const CV_MAX = 2 * 1024 * 1024;

$errors = [];
$old = ['name' => '', 'email' => '', 'phone' => '', 'position' => '', 'experience' => '', 'city' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $_) $old[$k] = trim((string)($_POST[$k] ?? ''));

    $errors = form_guard();
    if ($old['name'] === '' || mb_strlen($old['name']) > 100) $errors[] = 'Please enter your name.';
    if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL) || strlen($old['email']) > 150) $errors[] = 'Please enter a valid email.';
    if (!preg_match('/^[0-9 +\-()]{7,20}$/', $old['phone'])) $errors[] = 'Please enter a valid phone number.';
    if (!in_array($old['position'], $positions, true)) $errors[] = 'Please choose a position.';
    if (!in_array($old['experience'], $experience, true)) $errors[] = 'Please choose your experience.';
    if ($old['city'] === '' || mb_strlen($old['city']) > 80) $errors[] = 'Please enter your current city.';
    if (mb_strlen($old['message']) > 2000) $errors[] = 'Cover note should be under 2000 characters.';

    // CV: required, PDF/DOC/DOCX, max 2 MB, content type checked, saved under a random name.
    $cv = $_FILES['cv'] ?? null;
    $ext = strtolower(pathinfo($cv['name'] ?? '', PATHINFO_EXTENSION));
    if (!$cv || $cv['error'] === UPLOAD_ERR_NO_FILE) $errors[] = 'Please attach your CV.';
    elseif ($cv['error'] !== UPLOAD_ERR_OK || $cv['size'] > CV_MAX) $errors[] = 'CV must be under 2 MB.';
    elseif (!isset($cvTypes[$ext])) $errors[] = 'CV must be a PDF, DOC or DOCX file.';
    elseif (class_exists('finfo')) {
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($cv['tmp_name']);
        // DOCX is a zip; some servers report it as application/zip.
        if ($mime !== $cvTypes[$ext] && !($ext === 'docx' && $mime === 'application/zip')) $errors[] = 'CV file looks invalid. Please upload a real PDF or Word file.';
    }

    if (!$errors) {
        $dir = __DIR__ . '/data/cv';
        if (!is_dir($dir)) @mkdir($dir, 0755, true);
        $saved = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
        if (move_uploaded_file($cv['tmp_name'], "$dir/$saved") && csv_append(__DIR__ . '/data/applications.csv',
            ['Date', 'Name', 'Email', 'Phone', 'Position', 'Experience', 'City', 'Cover note', 'CV file', 'IP'],
            [date('Y-m-d H:i:s'), $old['name'], $old['email'], $old['phone'], $old['position'], $old['experience'], $old['city'], $old['message'], "data/cv/$saved", $_SERVER['REMOTE_ADDR'] ?? ''])) {
            header('Location: /careers?sent=1#apply', true, 303);
            exit;
        }
        $errors[] = 'Sorry, we could not save your application. Please email your CV to ' . EMAIL . '.';
    } elseif ($cv && $cv['error'] === UPLOAD_ERR_OK) {
        $errors[] = 'Please attach your CV again.'; // browsers don't keep file inputs after a failed submit
    }
}
$_SESSION['csrf'] ??= bin2hex(random_bytes(16));

$title = 'Careers';
$desc  = 'Join OctaPower — careers for electrical, mechanical and civil engineers, site supervisors, HSE officers and project managers in power infrastructure.';
require __DIR__ . '/includes/header.php';
page_hero('Careers', 'Build the grid. <span class="grad-text">Build your career.</span>', 'Work on landmark energy projects with a team that invests in your growth and goes home safe every day.', 'lineman');
?>

<section class="sec sec-alt">
  <div class="wrap">
    <div class="sec-head center reveal"><p class="eyebrow">Life at OctaPower</p><h2>Why engineers choose us</h2></div>
    <div class="grid g4 stagger">
      <div class="card"><div class="ibox"><?= icon('tower') ?></div><h3>Real Projects</h3><p>Hands-on exposure to 400 kV substations and GW-scale solar from year one.</p></div>
      <div class="card"><div class="ibox"><?= icon('gear') ?></div><h3>Learning</h3><p>Sponsored certifications, software training and mentorship by senior engineers.</p></div>
      <div class="card"><div class="ibox"><?= icon('shield') ?></div><h3>Safety &amp; Care</h3><p>Medical insurance, site allowances and a genuine zero-harm culture.</p></div>
      <div class="card"><div class="ibox"><?= icon('users') ?></div><h3>Fast Growth</h3><p>Performance-driven promotions and leadership roles on new divisions.</p></div>
    </div>
  </div>
</section>

<section class="sec" id="apply" style="scroll-margin-top:80px">
  <div class="wrap contact-grid">
    <div class="reveal">
      <p class="eyebrow">Apply now</p>
      <h2>Send us your application</h2>
      <p class="lead">Electrical, mechanical, civil or HSE — if you love building infrastructure, we want to hear from you.</p>
      <ul class="ticks">
        <li><?= icon('check') ?><span><strong>Apply</strong> — fill the form and attach your CV (PDF/DOC, max 2 MB).</span></li>
        <li><?= icon('check') ?><span><strong>HR call</strong> — shortlisted candidates hear from us within 7 days.</span></li>
        <li><?= icon('check') ?><span><strong>Interview</strong> — technical round with the project head, then offer.</span></li>
      </ul>
      <p style="margin-top:24px;color:var(--muted)">Questions? Call <a href="tel:<?= preg_replace('/\s+/', '', PHONE) ?>" style="color:var(--orange);font-weight:700"><?= PHONE ?></a></p>
    </div>

    <form class="form reveal" method="post" action="/careers#apply" enctype="multipart/form-data" novalidate style="--d:.12s">
      <?php if (isset($_GET['sent'])): ?>
        <div class="alert ok" role="status">Thank you! Your application has been received. Our HR team will contact you if your profile matches.</div>
      <?php endif; ?>
      <?php if ($errors): ?>
        <div class="alert err" role="alert"><?= implode('<br>', array_map('e', $errors)) ?></div>
      <?php endif; ?>
      <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?= CV_MAX ?>">
      <div class="hp" aria-hidden="true"><label for="website">Website</label><input id="website" name="website" tabindex="-1" autocomplete="off"></div>
      <div class="fgrid">
        <div><label for="name">Full name *</label><input id="name" name="name" required maxlength="100" autocomplete="name" value="<?= e($old['name']) ?>"></div>
        <div><label for="email">Email *</label><input id="email" name="email" type="email" required maxlength="150" autocomplete="email" value="<?= e($old['email']) ?>"></div>
        <div><label for="phone">Phone *</label><input id="phone" name="phone" type="tel" required maxlength="20" autocomplete="tel" value="<?= e($old['phone']) ?>"></div>
        <div><label for="city">Current city *</label><input id="city" name="city" required maxlength="80" autocomplete="address-level2" value="<?= e($old['city']) ?>"></div>
        <div><label for="position">Position *</label>
          <select id="position" name="position" required>
            <option value="">Select a position</option>
            <?php foreach ($positions as $p): ?><option<?= $old['position'] === $p ? ' selected' : '' ?>><?= e($p) ?></option><?php endforeach; ?>
          </select></div>
        <div><label for="experience">Experience *</label>
          <select id="experience" name="experience" required>
            <option value="">Select</option>
            <?php foreach ($experience as $x): ?><option<?= $old['experience'] === $x ? ' selected' : '' ?>><?= e($x) ?></option><?php endforeach; ?>
          </select></div>
        <div class="full"><label for="cv">Upload CV * <small style="font-weight:500;color:var(--muted)">(PDF, DOC, DOCX — max 2 MB)</small></label>
          <input id="cv" name="cv" type="file" required accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"></div>
        <div class="full"><label for="message">Cover note</label><textarea id="message" name="message" maxlength="2000" placeholder="Key projects, certifications, notice period…"><?= e($old['message']) ?></textarea></div>
        <div class="full"><button class="btn" type="submit">Submit Application <?= icon('arrow') ?></button></div>
      </div>
    </form>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
