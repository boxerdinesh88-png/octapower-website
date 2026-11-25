<?php
$title = 'Projects';
$desc  = 'Explore OctaPower projects: substations, transmission lines, solar parks and distribution networks delivered across India.';
require __DIR__ . '/includes/header.php';
page_hero('Our Projects', 'Proof in the <span class="grad-text">field.</span>', 'A selection of substations, lines, solar parks, plants and networks we have engineered and energised.', 'solar-aerial');

// [category key, label, icon, title, summary, location, year, capacity, photo]
$projects = [
  ['substation','Substation','grid','220/33 kV GIS Substation','Turnkey GIS substation with 6 bays and SCADA integration for a state utility.','Uttar Pradesh','2025','2×100 MVA','substation2'],
  ['solar','Solar','sun','150 MW Ground-Mount Solar Park','Single-axis tracker plant with 33/220 kV pooling substation.','Rajasthan','2024','150 MWp','solar-aerial'],
  ['transmission','Transmission','tower','132 kV D/C Transmission Line','86 km line across agricultural and forest terrain with 3 river crossings.','Madhya Pradesh','2024','86 km','towers-sunset'],
  ['mechanical','Mechanical','wrench','Process Piping &amp; Equipment Erection','4,200 inch-dia of alloy piping, pumps and heat exchangers for a process plant.','Gujarat','2025','650 MT','pipes'],
  ['substation','Substation','grid','400 kV Bay Extension','Two line bays added to a live 400 kV substation under shutdown windows.','Haryana','2023','2 bays','substation'],
  ['mechanical','Mechanical','wrench','Structural Fabrication — Steel Plant','Fabrication and erection of conveyor galleries and pipe racks with certified welding.','Odisha','2024','1,200 MT','welding'],
  ['distribution','Distribution','plug','EV Fast-Charging Hub','40-charger DC fast-charging hub with dedicated 11 kV substation.','Karnataka','2025','3.2 MW','ev'],
  ['mechanical','Civil','building','Switchyard Civil &amp; Foundations','Site grading, equipment foundations, cable trenches and control building.','Rajasthan','2023','18 acres','excavator'],
  ['transmission','Transmission','tower','220 kV Line Strengthening','Re-conductoring and live-line maintenance on a critical 220 kV corridor.','Delhi NCR','2022','48 km','hero-pylon'],
  ['solar','Solar','sun','25 MW Rooftop Portfolio','Rooftop solar across 60 factory sheds for an industrial park.','Maharashtra','2023','25 MWp','solar'],
  ['distribution','Distribution','plug','Smart City Network Upgrade','Overhead 11 kV network converted to underground cabling with RMUs.','Gujarat','2023','140 km','lineman'],
  ['substation','O&amp;M','gear','Substation O&amp;M Contract','Five-year maintenance of 12 substations with relay testing and thermography.','Uttar Pradesh','Ongoing','12 sites','testing'],
];
?>

<section class="sec">
  <div class="wrap">
    <div class="filters reveal" role="group" aria-label="Filter projects">
      <button data-filter="all" aria-pressed="true">All</button>
      <button data-filter="substation" aria-pressed="false">Substations</button>
      <button data-filter="transmission" aria-pressed="false">Transmission</button>
      <button data-filter="solar" aria-pressed="false">Solar</button>
      <button data-filter="mechanical" aria-pressed="false">Mechanical &amp; Civil</button>
      <button data-filter="distribution" aria-pressed="false">Distribution &amp; EV</button>
    </div>
    <div class="grid g3 stagger">
      <?php foreach ($projects as [$cat,$lab,$ic,$t,$s,$loc,$yr,$cap,$img]): ?>
      <article class="proj" data-cat="<?= $cat ?>">
        <div class="proj-img"><?= photo($img, html_entity_decode($t), '(max-width:640px) 100vw, (max-width:960px) 50vw, 400px') ?><span class="badge"><?= icon($ic) ?></span></div>
        <div class="proj-body">
          <small><?= $lab ?></small><h3><?= $t ?></h3><p><?= $s ?></p>
          <div class="meta"><span><?= icon('pin') ?><?= $loc ?></span><span><?= icon('clock') ?><?= $yr ?></span><span><?= icon('bolt') ?><?= $cap ?></span></div>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec sec-dark">
  <div class="wrap">
    <div class="stats stagger" style="margin-top:0">
      <div class="stat"><b><span data-count="320">320</span>+</b><small>Projects delivered</small></div>
      <div class="stat"><b><span data-count="14">14</span></b><small>States covered</small></div>
      <div class="stat"><b><span data-count="65">65</span>+</b><small>Substations built</small></div>
      <div class="stat"><b><span data-count="98">98</span>%</b><small>On-time completion</small></div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
