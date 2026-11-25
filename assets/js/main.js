(() => {
  const nav = document.getElementById('nav');
  const bar = document.querySelector('.progress');
  const onScroll = () => {
    const h = document.documentElement;
    const max = h.scrollHeight - h.clientHeight;
    bar.style.transform = `scaleX(${max > 0 ? h.scrollTop / max : 0})`;
    nav.classList.toggle('scrolled', h.scrollTop > 10);
  };
  addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // mobile menu
  const burger = document.querySelector('.burger');
  const menu = document.getElementById('menu');
  burger.addEventListener('click', () => {
    const open = menu.classList.toggle('open');
    burger.setAttribute('aria-expanded', open);
  });
  addEventListener('keydown', e => {
    if (e.key === 'Escape' && menu.classList.contains('open')) { menu.classList.remove('open'); burger.setAttribute('aria-expanded', false); burger.focus(); }
  });

  // count-up numbers: <span data-count="250">0</span>
  const count = el => {
    if (el.dataset.done) return; // parent and child may both be observed
    el.dataset.done = 1;
    const end = +el.dataset.count, t0 = performance.now(), dur = 1600;
    const step = t => {
      const p = Math.min((t - t0) / dur, 1);
      el.textContent = Math.round(end * (1 - Math.pow(1 - p, 3))).toLocaleString('en-IN');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  // stagger siblings inside a .stagger parent
  document.querySelectorAll('.stagger').forEach(p =>
    [...p.children].forEach((c, i) => { c.classList.add('reveal'); c.style.setProperty('--d', (i % 6) * 0.08 + 's'); }));

  const io = new IntersectionObserver(entries => entries.forEach(en => {
    if (!en.isIntersecting) return;
    en.target.classList.add('in');
    en.target.querySelectorAll('[data-count]').forEach(count);
    io.unobserve(en.target);
  }), { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal, .steps, .stats').forEach(el => io.observe(el));

})();
