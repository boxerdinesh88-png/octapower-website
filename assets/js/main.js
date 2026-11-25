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

  // stagger siblings inside a .stagger parent
  document.querySelectorAll('.stagger').forEach(p =>
    [...p.children].forEach((c, i) => { c.classList.add('reveal'); c.style.setProperty('--d', (i % 6) * 0.08 + 's'); }));

  const io = new IntersectionObserver(entries => entries.forEach(en => {
    if (!en.isIntersecting) return;
    en.target.classList.add('in');
    io.unobserve(en.target);
  }), { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
  document.querySelectorAll('.reveal, .steps').forEach(el => io.observe(el));

})();
