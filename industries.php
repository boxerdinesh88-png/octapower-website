<?php
$title = 'Industries';
$desc  = 'OctaPower serves power utilities, renewable developers, railways, heavy industry, smart cities and EV infrastructure across India.';
require __DIR__ . '/includes/header.php';
page_hero('Industries We Serve', 'Wherever power matters, <span class="grad-text">we deliver.</span>', 'Sector-specific know-how means we understand your standards, approvals and shutdown constraints before we arrive on site.', 'pipes');
?>

<section class="sec">
  <div class="wrap">
    <div class="grid g3 stagger">
      <?php foreach ([
        ['bolt','Power Utilities','Substations, lines and network strengthening for state and central utilities (TBCB & EPC).'],
        ['sun','Renewable Developers','Solar and hybrid parks with pooling substations and evacuation infrastructure.'],
        ['train','Railways &amp; Metro','Traction substations, OHE power supply and station electrification.'],
        ['factory','Heavy Industry','Captive substations and plant electrification for steel, cement and chemicals.'],
        ['building','Smart Cities &amp; Real Estate','Underground networks, CSS, street lighting and building electrification.'],
        ['plug','EV &amp; Mobility','Public and fleet charging hubs with grid connection and load management.'],
        ['drop','Water &amp; Utilities','Power systems for pumping stations, STPs and water treatment plants.'],
        ['road','Highways &amp; Airports','Lighting, power distribution and utility shifting for transport projects.'],
        ['wrench','Oil, Gas &amp; Process Plants','Mechanical piping, equipment erection and plant electrical works.'],
      ] as [$ic,$t,$d]): ?>
      <div class="card"><div class="ibox"><?= icon($ic) ?></div><h3><?= $t ?></h3><p><?= $d ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec sec-alt">
  <div class="wrap split">
    <div class="reveal">
      <p class="eyebrow">Compliance built in</p>
      <h2>Approved, certified, audit-ready.</h2>
      <p class="lead">We work to the standards your sector demands and keep the paperwork as clean as the workmanship.</p>
      <ul class="ticks">
        <li><?= icon('check') ?><span>ISO 9001, ISO 14001 &amp; ISO 45001 certified management systems</span></li>
        <li><?= icon('check') ?><span>Electrical contractor licences across multiple states</span></li>
        <li><?= icon('check') ?><span>Vendor-registered with leading utilities and PSUs</span></li>
        <li><?= icon('check') ?><span>CEA, IS and IEC compliant design and testing</span></li>
      </ul>
    </div>
    <div class="grid g2 stagger">
      <div class="stat"><b><span data-count="14">14</span></b><small>States of operation</small></div>
      <div class="stat"><b><span data-count="9">9</span></b><small>Sectors served</small></div>
      <div class="stat"><b><span data-count="45">45</span>+</b><small>Repeat clients</small></div>
      <div class="stat"><b><span data-count="3">3</span></b><small>ISO certifications</small></div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
