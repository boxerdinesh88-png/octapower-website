<?php
$title = 'Services';
$desc  = 'EPC contracting, substations up to 400 kV, transmission lines, solar power plants, EV & distribution networks and O&M services by OctaPower.';
require __DIR__ . '/includes/header.php';
page_hero('Our Services', 'Every link in the <span class="grad-text">power chain.</span>', 'Eight specialised divisions — electrical, mechanical and civil — one integrated team and a single point of accountability from design to decades of operation.', 'substation2');

// [anchor, icon, title, summary, points, photo]
$services = [
  ['epc','bolt','EPC Contracting','Turnkey delivery for power, industrial and infrastructure projects — fixed scope, fixed schedule, single responsibility.',
    ['Feasibility, basic & detailed engineering','Procurement with factory inspections','Civil, mechanical & electrical works','Testing, commissioning & handover'],'team'],
  ['substation','grid','Substations','Air-insulated and gas-insulated substations from 33 kV to 400 kV, new builds and brownfield bay extensions.',
    ['AIS & GIS up to 400 kV','Control & relay panels, SCADA integration','Earthing, lightning protection & cabling','Retrofit, augmentation & bay extensions'],'substation'],
  ['transmission','tower','Transmission Lines','Overhead and underground HV/EHV lines across plains, hills and river crossings.',
    ['Route survey with drones & DGPS','Tower foundation & erection','Conventional and drone-assisted stringing','Underground EHV cabling & HDD'],'towers'],
  ['solar','sun','Solar Power Plants','Utility, C&I and rooftop solar — designed for maximum yield and lowest LCOE.',
    ['Ground-mount, rooftop & floating PV','Pooling substations & evacuation lines','Tracker and fixed-tilt structures','Performance monitoring & cleaning'],'solar'],
  ['mechanical','wrench','Mechanical Works','Fabrication, piping and heavy equipment erection for power plants, refineries and process industries.',
    ['Process & utility piping (CS, SS, alloy)','Structural steel fabrication & erection','Certified welding (IBR / ASME) with NDT','Pumps, compressors, HVAC & equipment alignment'],'pipes'],
  ['civil','building','Civil Works','The foundations everything else stands on — designed and built by our own civil teams.',
    ['Tower & equipment foundations, piling','Earthwork, grading & site development','Control rooms, switchyards & cable trenches','Internal roads, drainage & boundary walls'],'excavator'],
  ['distribution','plug','EV & Distribution','Modern urban distribution and EV charging networks built for tomorrow\'s load.',
    ['EV fast-charging hubs (DC & AC)','RMUs, CSS & HT/LT panels','Smart metering & feeder automation','Street lighting & cable networks'],'ev'],
  ['om','gear','Operations & Maintenance','Keep assets available and efficient with planned and predictive maintenance.',
    ['Annual maintenance contracts','Thermography & partial discharge tests','Relay testing & protection audits','24×7 breakdown response teams'],'testing'],
];
?>

<section class="sec">
  <div class="wrap" style="display:grid;gap:96px">
    <?php foreach ($services as $i => [$id,$ic,$t,$d,$pts,$img]): ?>
    <div class="split" id="<?= $id ?>" style="scroll-margin-top:100px">
      <div class="reveal" style="<?= $i % 2 ? 'order:2' : '' ?>">
        <p class="eyebrow">0<?= $i + 1 ?> / Service</p>
        <h2><?= e($t) ?></h2>
        <p class="lead"><?= e($d) ?></p>
        <ul class="ticks"><?php foreach ($pts as $p): ?><li><?= icon('check') ?><span><?= e($p) ?></span></li><?php endforeach; ?></ul>
        <p style="margin-top:26px"><a href="/contact?service=<?= $id ?>" class="btn btn-sm">Enquire about this <?= icon('arrow') ?></a></p>
      </div>
      <div class="reveal" style="--d:.12s">
        <div class="proj-img card-img" style="border-radius:24px;aspect-ratio:4/3;box-shadow:var(--sh)"><?= photo($img, $t) ?><span class="badge"><?= icon($ic) ?></span></div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<section class="sec sec-alt">
  <div class="wrap">
    <div class="sec-head center reveal"><p class="eyebrow">Capabilities</p><h2>Backed by our own fleet &amp; labs</h2></div>
    <div class="stats stagger" style="margin-top:0">
      <div class="stat"><b><span data-count="120">120</span>+</b><small>Heavy equipment units</small></div>
      <div class="stat"><b><span data-count="18">18</span></b><small>Stringing machine sets</small></div>
      <div class="stat"><b><span data-count="40">40</span>+</b><small>Testing kits (Omicron, Megger)</small></div>
      <div class="stat"><b><span data-count="24">24</span>×7</b><small>Emergency response</small></div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
