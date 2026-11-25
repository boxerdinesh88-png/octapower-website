</main>
<section class="cta-band">
  <div class="wrap cta-in reveal">
    <div>
      <h2>Have a project that needs power?</h2>
      <p>Tell us the scope — we'll reply with a feasibility view and budget estimate within 48 hours.</p>
    </div>
    <a href="/contact" class="btn btn-light">Start a Conversation <?= icon('arrow') ?></a>
  </div>
</section>
<footer class="foot">
  <div class="wrap foot-grid">
    <div>
      <a href="/" class="foot-brand"><img src="/assets/img/mark-sm.webp" width="47" height="42" alt="" loading="lazy"><span>OCTA<b>POWER</b></span></a>
      <p><?= SITE_TAGLINE ?>. EPC, transmission, substations and renewable energy projects delivered across India.</p>
    </div>
    <div>
      <h3>Company</h3>
      <?php foreach (NAV as $href => $label): ?><a href="<?= $href ?>"><?= $label ?></a><?php endforeach; ?>
    </div>
    <div>
      <h3>Services</h3>
      <a href="/services#epc">EPC Contracting</a>
      <a href="/services#substation">Substations</a>
      <a href="/services#transmission">Transmission Lines</a>
      <a href="/services#solar">Solar Power Plants</a>
      <a href="/services#mechanical">Mechanical Works</a>
      <a href="/services#civil">Civil Works</a>
      <a href="/services#om">Operations &amp; Maintenance</a>
    </div>
    <div>
      <h3>Contact</h3>
      <a href="tel:<?= preg_replace('/\s+/', '', PHONE) ?>"><?= icon('phone') ?> <?= PHONE ?></a>
      <a href="mailto:<?= EMAIL ?>"><?= icon('mail') ?> <?= EMAIL ?></a>
      <p><?= icon('pin') ?> <span><b>Office:</b> <?= ADDRESS ?></span></p>
      <p><?= icon('building') ?> <span><b>Registered:</b> <?= REG_ADDRESS ?></span></p>
    </div>
  </div>
  <div class="wrap foot-bot">
    <span>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. All rights reserved.</span>
    <a href="#main" class="totop">Back to top ↑</a>
  </div>
</footer>
<a class="wa" href="https://wa.me/<?= WHATSAPP ?>" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M17.5 14.4c-.3-.1-1.8-.9-2-1-.3-.1-.5-.1-.7.1-.2.3-.8 1-.9 1.2-.2.2-.3.2-.6.1-.3-.1-1.3-.5-2.4-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.6l.4-.5c.2-.2.2-.3.3-.5.1-.2 0-.4 0-.5l-.9-2.2c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.5s1.1 2.9 1.2 3.1c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.4zM12 21.8a9.8 9.8 0 0 1-5-1.4l-.4-.2-3.7 1 1-3.6-.2-.4A9.8 9.8 0 1 1 12 21.8zm8.4-18.2A11.8 11.8 0 0 0 1.7 17.8L0 24l6.3-1.7A11.8 11.8 0 0 0 24 12a11.7 11.7 0 0 0-3.6-8.4z"/></svg>
</a>
</body>
</html>
