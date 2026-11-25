<?php require __DIR__ . '/includes/header.php'; ?>

<section class="hero">
  <div class="bgphoto" aria-hidden="true"><?= photo('hero-cranes', '', '100vw', false) ?></div>
  <div class="hero-grid" aria-hidden="true"></div>
  <div class="wrap hero-in">
    <div>
      <p class="eyebrow reveal">Infrastructure &amp; EPC Contractors</p>
      <h1 class="reveal" style="--d:.08s">Building the infrastructure<br>that builds <span class="grad-text">India.</span></h1>
      <p class="lead reveal" style="--d:.16s">Civil, mechanical and electrical works under one roof. OctaPower plans, builds and maintains the plants, substations and structures that keep industries and cities running.</p>
      <div class="hero-cta reveal" style="--d:.24s">
        <a href="/contact" class="btn">Get a Project Quote <?= icon('arrow') ?></a>
        <a href="/projects" class="btn btn-ghost">View Our Work</a>
      </div>
      <div class="hero-badges reveal" style="--d:.32s">
        <span><?= icon('bolt') ?> Electrical · Mechanical · Civil</span>
        <span><?= icon('shield') ?> Safety first</span>
      </div>
    </div>
    <div class="hero-art" aria-hidden="true">
      <div class="ring"></div><div class="ring r2"></div><div class="glow"></div>
      <img src="/assets/img/mark.webp" width="590" height="520" alt="" fetchpriority="high">
    </div>
  </div>
  <svg class="wire" viewBox="0 0 1440 120" preserveAspectRatio="none" aria-hidden="true">
    <defs><linearGradient id="wg" x1="0" x2="1"><stop offset="0" stop-color="#ffc400"/><stop offset="1" stop-color="#e3300b"/></linearGradient></defs>
    <path class="base" d="M0 60 Q 180 110 360 60 T 720 60 T 1080 60 T 1440 60"/>
    <path class="flow" d="M0 60 Q 180 110 360 60 T 720 60 T 1080 60 T 1440 60"/>
  </svg>
</section>

<div class="wrap">
  <div class="stats stats-text stagger">
    <div class="stat"><b><span>Turnkey</span></b><small>EPC from design to handover</small></div>
    <div class="stat"><b><span>Up to 400 kV</span></b><small>Substations &amp; lines</small></div>
    <div class="stat"><b><span>In-house</span></b><small>Mechanical &amp; civil teams</small></div>
    <div class="stat"><b><span>24×7</span></b><small>Site support</small></div>
  </div>
</div>

<section class="sec">
  <div class="wrap">
    <div class="sec-head reveal">
      <p class="eyebrow">What we do</p>
      <h2>End-to-end infrastructure, under one roof.</h2>
      <p class="lead">Design, procurement, construction, testing and commissioning — one accountable partner from survey to switch-on.</p>
    </div>
    <div class="grid g4 stagger">
      <?php foreach ([
        ['bolt','EPC Contracting','Turnkey engineering, procurement and construction.','epc','team'],
        ['wrench','Mechanical Works','Piping, fabrication, welding and equipment erection.','mechanical','welding'],
        ['building','Civil Works','Foundations, earthwork, control rooms and roads.','civil','excavator'],
        ['gear','O&amp;M Services','Preventive maintenance and 24×7 breakdown support.','om','testing'],
        ['grid','Substations','AIS &amp; GIS substations up to 400 kV.','substation','substation'],
        ['tower','Transmission Lines','Tower erection and stringing for HV/EHV lines.','transmission','towers'],
        ['sun','Solar Power Plants','Ground-mount, rooftop and floating solar.','solar','solar'],
        ['plug','EV &amp; Distribution','EV charging hubs, RMUs and HT/LT networks.','distribution','ev'],
      ] as [$ic,$t,$d,$id,$img]): ?>
      <a href="/services#<?= $id ?>" class="card card-img">
        <div class="proj-img"><?= photo($img, '', '(max-width:640px) 100vw, (max-width:960px) 50vw, 300px') ?><span class="badge"><?= icon($ic) ?></span></div>
        <div class="card-body"><h3><?= $t ?></h3><p><?= $d ?></p>
        <span class="more">Learn more <?= icon('arrow') ?></span></div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="marquee" aria-label="Sectors we serve">
  <div class="marquee-track">
    <?php $s = [['bolt','Power Utilities'],['sun','Renewables'],['train','Railways & Metro'],['factory','Heavy Industry'],['building','Smart Cities'],['drop','Water & Utilities'],['road','Highways'],['plug','EV Infrastructure']];
    foreach ([1,2] as $_) foreach ($s as [$ic,$t]) echo "<span>" . icon($ic) . "$t</span>"; ?>
  </div>
</div>

<section class="sec sec-alt">
  <div class="wrap split">
    <div class="visual reveal" aria-hidden="true">
      <svg viewBox="0 0 400 340">
        <defs><linearGradient id="sky" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#16181d"/><stop offset="1" stop-color="#3a2618"/></linearGradient></defs>
        <rect width="400" height="340" fill="url(#sky)"/>
        <circle cx="320" cy="80" r="38" fill="#ff9500" opacity=".25"/><circle cx="320" cy="80" r="22" fill="#ffc400" opacity=".6"/>
        <?php foreach ([60, 200, 340] as $x): ?>
          <g stroke="#6b717a" stroke-width="2" fill="none">
            <path d="M<?= $x-22 ?> 300 L<?= $x ?> 90 L<?= $x+22 ?> 300 M<?= $x-14 ?> 230 h28 M<?= $x-8 ?> 170 h16 M<?= $x-34 ?> 120 h68 M<?= $x-26 ?> 150 h52 M<?= $x-16 ?> 230 L<?= $x+10 ?> 170 M<?= $x+16 ?> 230 L<?= $x-10 ?> 170"/>
          </g>
        <?php endforeach; ?>
        <path id="w1" class="tower-line" d="M26 120 Q130 160 234 120 T 374 120"/>
        <path id="w2" class="tower-line" d="M34 150 Q130 185 226 150 T 366 150" opacity=".6"/>
        <circle r="5" class="pulse-dot"><animateMotion dur="3s" repeatCount="indefinite"><mpath href="#w1"/></animateMotion></circle>
        <circle r="4" class="pulse-dot"><animateMotion dur="3s" begin="1.5s" repeatCount="indefinite"><mpath href="#w2"/></animateMotion></circle>
        <rect y="300" width="400" height="40" fill="#0f1114"/>
      </svg>
      <div class="tag"><?= icon('shield') ?><div><b>Safety first</b><br><small>on every site</small></div></div>
    </div>
    <div class="reveal">
      <p class="eyebrow">Why OctaPower</p>
      <h2>Built safe. Built on time. Built to last.</h2>
      <p class="lead">We combine in-house design, a self-owned equipment fleet and certified site teams — so schedules hold and quality never depends on a sub-contractor.</p>
      <ul class="ticks">
        <li><?= icon('check') ?><span><strong>In-house engineering</strong> — design, PLS-CADD, ETAP and protection studies.</span></li>
        <li><?= icon('check') ?><span><strong>Own fleet</strong> — cranes, stringing machines and testing kits ready to deploy.</span></li>
        <li><?= icon('check') ?><span><strong>Zero-harm safety culture</strong> — daily toolbox talks, permit-to-work, audited HSE.</span></li>
        <li><?= icon('check') ?><span><strong>Transparent reporting</strong> — weekly progress with photos, S-curves and risk logs.</span></li>
      </ul>
      <p style="margin-top:28px"><a href="/about" class="btn">About the Company <?= icon('arrow') ?></a></p>
    </div>
  </div>
</section>

<section class="sec sec-dark">
  <div class="wrap">
    <div class="sec-head center reveal">
      <p class="eyebrow">How we work</p>
      <h2 style="color:#fff">From survey to switch-on</h2>
      <p class="lead">A proven four-stage delivery model that keeps every stakeholder in the loop.</p>
    </div>
    <div class="steps">
      <div class="step reveal"><h3 style="color:#fff">Survey &amp; Design</h3><p>Site survey, soil tests, load flow and detailed engineering.</p></div>
      <div class="step reveal" style="--d:.1s"><h3 style="color:#fff">Procurement</h3><p>Vendor-approved equipment, inspected at factory and on arrival.</p></div>
      <div class="step reveal" style="--d:.2s"><h3 style="color:#fff">Construction</h3><p>Civil, erection and electrical works with daily QA/QC checks.</p></div>
      <div class="step reveal" style="--d:.3s"><h3 style="color:#fff">Commission</h3><p>Pre-commissioning tests, energisation and handover documentation.</p></div>
    </div>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <div class="sec-head reveal" style="display:flex;justify-content:space-between;align-items:end;gap:20px;flex-wrap:wrap;max-width:none">
      <div><p class="eyebrow">Featured projects</p><h2 style="margin:0">Recent work in the field</h2></div>
      <a href="/projects" class="btn btn-sm">All Projects <?= icon('arrow') ?></a>
    </div>
    <div class="grid g2 stagger">
      <?php foreach ([
        ['substation2','grid','Substation','220/33 kV GIS Substation'],
        ['pipes','wrench','Mechanical','Process Piping &amp; Equipment Erection'],
      ] as [$img,$ic,$cat,$t]): ?>
      <article class="proj">
        <div class="proj-img"><?= photo($img, html_entity_decode($t), '(max-width:640px) 100vw, 600px') ?><span class="badge"><?= icon($ic) ?></span></div>
        <div class="proj-body"><small><?= $cat ?></small><h3><?= $t ?></h3></div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
