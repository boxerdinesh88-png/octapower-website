<?php
$title = 'About Us';
$desc  = 'OctaPower is an Indian power and infrastructure EPC company delivering substations, transmission lines and renewable energy projects since 2010.';
require __DIR__ . '/includes/header.php';
page_hero('About OctaPower', 'Eight sides of strength. <span class="grad-text">One promise.</span>', 'Our octagon stands for the eight disciplines we bring to every project — and the bolt for the energy we deliver to millions.', 'team');
?>

<section class="sec">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Who we are</p>
      <h2>An engineering-first infrastructure company.</h2>
      <p>Founded in 2010 by a team of power-sector engineers, OctaPower began with small distribution works and has grown into a full-scale EPC partner for utilities, developers and heavy industry.</p>
      <p>Today our team operates from regional offices and site camps across India, delivering electrical, mechanical and civil works on projects from 11 kV to 400 kV with the same discipline: plan precisely, build safely, hand over on time.</p>
      <div class="grid g2" style="margin-top:28px">
        <div class="card"><div class="ibox"><?= icon('bolt') ?></div><h3>Our Mission</h3><p>Build reliable, affordable energy infrastructure that accelerates India's growth.</p></div>
        <div class="card"><div class="ibox"><?= icon('leaf') ?></div><h3>Our Vision</h3><p>Be the most trusted name in clean, resilient power infrastructure by 2030.</p></div>
      </div>
    </div>
    <div class="reveal" style="--d:.15s">
      <div class="visual">
        <?= photo('crane', 'OctaPower construction site') ?>
      </div>
    </div>
  </div>
</section>

<section class="sec sec-alt">
  <div class="wrap">
    <div class="sec-head center reveal"><p class="eyebrow">The octagon</p><h2>Eight values we build on</h2></div>
    <div class="grid g4 stagger">
      <?php foreach ([
        ['shield','Safety First','No task is so urgent that it cannot be done safely.'],
        ['check','Quality','Every joint, bolt and relay tested and documented.'],
        ['clock','Punctuality','Schedules are commitments, not estimates.'],
        ['users','Teamwork','Clients, crews and vendors as one site team.'],
        ['gear','Engineering','Decisions grounded in data and design.'],
        ['leaf','Sustainability','Lower footprint on every site we touch.'],
        ['building','Integrity','Transparent pricing and honest reporting.'],
        ['bolt','Innovation','Drones, BIM and digital QA in the field.'],
      ] as [$ic,$t,$d]): ?>
      <div class="card"><div class="ibox"><?= icon($ic) ?></div><h3><?= $t ?></h3><p><?= $d ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap split" style="align-items:start">
    <div class="reveal">
      <p class="eyebrow">Our journey</p>
      <h2>15 years of energising progress</h2>
      <p class="lead">Milestones that shaped OctaPower into the company it is today.</p>
    </div>
    <div class="tl stagger">
      <div class="tl-item"><b>2010</b><h3>Founded in Ghaziabad</h3><p>Started with 11 kV distribution and street-lighting works.</p></div>
      <div class="tl-item"><b>2014</b><h3>First 132 kV substation</h3><p>Entered HV substations and transmission line EPC.</p></div>
      <div class="tl-item"><b>2018</b><h3>Renewables division</h3><p>Commissioned our first 50 MW solar park.</p></div>
      <div class="tl-item"><b>2022</b><h3>400 kV capability</h3><p>Qualified for EHV substations and lines with state utilities.</p></div>
      <div class="tl-item"><b>2025</b><h3>EV &amp; smart grid</h3><p>Launched EV charging hub and smart-metering projects.</p></div>
    </div>
  </div>
</section>


<?php require __DIR__ . '/includes/footer.php'; ?>
