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
      <p class="eyebrow">How we work</p>
      <h2>Done right, the first time.</h2>
      <p class="lead">We follow the standards your sector demands and keep the paperwork as clean as the workmanship.</p>
      <ul class="ticks">
        <li><?= icon('check') ?><span>Design and testing as per CEA, IS and IEC standards</span></li>
        <li><?= icon('check') ?><span>Safety-first site practices with daily toolbox talks</span></li>
        <li><?= icon('check') ?><span>Clear documentation and progress reports</span></li>
      </ul>
    </div>
    <div class="visual reveal" style="--d:.12s"><?= photo('testing', 'Electrical panel testing') ?></div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
