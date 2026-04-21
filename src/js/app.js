// Mobile navigation toggle
(function () {
  const toggle = document.getElementById('nav-toggle');
  const menu = document.getElementById('nav-menu');
  const iconOpen = document.getElementById('nav-icon-open');
  const iconClose = document.getElementById('nav-icon-close');

  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const isOpen = menu.classList.toggle('hidden');
      toggle.setAttribute('aria-expanded', String(!isOpen));
      if (iconOpen) iconOpen.classList.toggle('hidden', !isOpen);
      if (iconClose) iconClose.classList.toggle('hidden', isOpen);
    });
  }
})();

// Case Study front-end filters
(function () {
  const filterBtns = document.querySelectorAll('[data-filter]');
  const cards = document.querySelectorAll('[data-industries][data-technologies]');
  const noResults = document.getElementById('no-results');

  if (!filterBtns.length || !cards.length) return;

  const activeFilters = { industry: 'all', technology: 'all' };

  function applyFilters() {
    let visibleCount = 0;

    cards.forEach((card) => {
      const industries   = card.dataset.industries   ? card.dataset.industries.split(',')   : [];
      const technologies = card.dataset.technologies ? card.dataset.technologies.split(',') : [];

      const industryMatch   = activeFilters.industry   === 'all' || industries.includes(activeFilters.industry);
      const technologyMatch = activeFilters.technology === 'all' || technologies.includes(activeFilters.technology);

      const visible = industryMatch && technologyMatch;
      card.classList.toggle('hidden', !visible);
      if (visible) visibleCount++;
    });

    if (noResults) noResults.classList.toggle('hidden', visibleCount > 0);
  }

  filterBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const filterType  = btn.dataset.filterType;
      const filterValue = btn.dataset.filter;

      document
        .querySelectorAll(`[data-filter-type="${filterType}"]`)
        .forEach((b) => {
          b.classList.remove('active');
          b.setAttribute('aria-pressed', 'false');
        });

      btn.classList.add('active');
      btn.setAttribute('aria-pressed', 'true');

      activeFilters[filterType] = filterValue;
      applyFilters();
    });
  });
})();
