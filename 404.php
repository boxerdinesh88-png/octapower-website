<?php
http_response_code(404);
$title = 'Page Not Found';
require __DIR__ . '/includes/header.php';
?>
<section class="nf">
  <div>
    <b class="grad-text">404</b>
    <h1 style="font-size:2rem">Looks like this line is de-energised.</h1>
    <p class="lead" style="margin-inline:auto">The page you're looking for doesn't exist or has moved.</p>
    <p style="margin-top:24px"><a href="/" class="btn">Back to Home <?= icon('arrow') ?></a></p>
  </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
