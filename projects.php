<?php
$title = 'Projects';
$desc  = 'Explore OctaPower projects: substations, transmission lines, solar parks and distribution networks delivered across India.';
require __DIR__ . '/includes/header.php';
page_hero('Our Projects', 'Proof in the <span class="grad-text">field.</span>', 'Recent electrical and mechanical work we have engineered, built and commissioned.', 'solar-aerial');

// [category key, label, icon, title, summary, photo]
$projects = [
  ['substation','Substation','grid','220/33 kV GIS Substation','Turnkey GIS substation with 6 bays and SCADA integration for a state utility.','substation2'],
  ['mechanical','Mechanical','wrench','Process Piping &amp; Equipment Erection','4,200 inch-dia of alloy piping, pumps and heat exchangers for a process plant.','pipes'],
];
?>

<section class="sec">
  <div class="wrap">
    <div class="grid g2 stagger">
      <?php foreach ($projects as [$cat,$lab,$ic,$t,$s,$img]): ?>
      <article class="proj">
        <div class="proj-img"><?= photo($img, html_entity_decode($t), '(max-width:640px) 100vw, 600px') ?><span class="badge"><?= icon($ic) ?></span></div>
        <div class="proj-body">
          <small><?= $lab ?></small><h3><?= $t ?></h3><p><?= $s ?></p>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
