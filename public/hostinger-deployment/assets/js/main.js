// Choghadiyas.in — Main Client-side Script
// Powers Smooth Marquee Slider, 30-Article Grid with Live Category Filtering & Pagination, Search & Mobile Drawer
(function () {
  'use strict';

  var articles = window.CHOGHADIYA_ARTICLES || [];
  var currentCategory = 'all';
  var currentPage = 1;
  var articlesPerPage = 12; // 12 articles per page for clean pagination

  // --- 1. MOBILE DRAWER NAVIGATION ---
  window.toggleMobileDrawer = function (forceState) {
    var drawer = document.getElementById('mobileDrawer');
    var overlay = document.getElementById('mobileDrawerOverlay');
    var btn = document.getElementById('mobileMenuToggle');
    if (!drawer || !overlay) return;

    var isActive = drawer.classList.contains('active');
    var newState = typeof forceState === 'boolean' ? forceState : !isActive;

    if (newState) {
      drawer.classList.add('active');
      overlay.classList.add('active');
      if (btn) btn.setAttribute('aria-expanded', 'true');
      document.body.style.overflow = 'hidden';
    } else {
      drawer.classList.remove('active');
      overlay.classList.remove('active');
      if (btn) btn.setAttribute('aria-expanded', 'false');
      document.body.style.overflow = '';
    }
  };

  // --- 2. CONTINUOUS MARQUEE SLIDER TOUCH & HOVER PAUSE ---
  function initSliderControls() {
    var track = document.getElementById('slider-track');
    if (!track) return;

    // Mobile touch pause
    track.addEventListener('touchstart', function () {
      track.classList.add('is-paused');
    }, { passive: true });

    track.addEventListener('touchend', function () {
      track.classList.remove('is-paused');
    }, { passive: true });

    track.addEventListener('touchcancel', function () {
      track.classList.remove('is-paused');
    }, { passive: true });
  }

  // --- 3. ARTICLES FILTERING & NUMBERED PAGINATION ---
  function getFilteredArticles() {
    if (currentCategory === 'all') return articles;
    return articles.filter(function (a) {
      return a.categorySlug === currentCategory;
    });
  }

  function renderArticlesGrid() {
    var grid = document.getElementById('articles-grid');
    if (!grid) return;

    var filtered = getFilteredArticles();
    var startIndex = (currentPage - 1) * articlesPerPage;
    var pageArticles = filtered.slice(startIndex, startIndex + articlesPerPage);

    if (pageArticles.length === 0) {
      grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:3rem; color:#64748B; font-size:1.05rem;">इस श्रेणी में वर्तमान में कोई लेख उपलब्ध नहीं है।</div>';
      renderPagination(0);
      return;
    }

    var html = '';
    pageArticles.forEach(function (a) {
      html += [
        '<article class="article-card" data-category="' + a.categorySlug + '">',
        '  <a href="' + a.url + '" class="article-thumb-link" aria-label="' + a.title + '">',
        '    <img src="' + a.featuredImage + '" alt="' + a.title + '" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">',
        '  </a>',
        '  <div class="article-body">',
        '    <span class="category-badge">' + a.category + '</span>',
        '    <h3 class="article-title"><a href="' + a.url + '">' + a.title + '</a></h3>',
        '    <p class="article-excerpt">' + a.excerpt + '</p>',
        '    <div class="article-footer">',
        '      <span class="article-meta">' + a.author + ' · ' + a.publishDate + '</span>',
        '      <a href="' + a.url + '" class="read-more-link" aria-label="' + a.title + ' पढ़ें">पूरा पढ़ें →</a>',
        '    </div>',
        '  </div>',
        '</article>'
      ].join('');
    });

    grid.innerHTML = html;
    renderPagination(filtered.length);
  }

  function renderPagination(totalCount) {
    var wrap = document.getElementById('pagination-wrap');
    if (!wrap) return;

    var totalPages = Math.ceil(totalCount / articlesPerPage);
    if (totalPages <= 1) {
      wrap.innerHTML = '';
      return;
    }

    var html = '';

    // Previous Button
    if (currentPage > 1) {
      html += '<button class="page-btn prev" onclick="window.setPage(' + (currentPage - 1) + ')" aria-label="पिछला पृष्ठ">← पिछला</button>';
    }

    // Numbered Buttons
    for (var i = 1; i <= totalPages; i++) {
      var activeClass = i === currentPage ? 'active' : '';
      var ariaSelected = i === currentPage ? 'aria-current="page"' : '';
      html += '<button class="page-btn ' + activeClass + '" onclick="window.setPage(' + i + ')" ' + ariaSelected + ' aria-label="पृष्ठ ' + i + '">' + i + '</button>';
    }

    // Next Button
    if (currentPage < totalPages) {
      html += '<button class="page-btn next" onclick="window.setPage(' + (currentPage + 1) + ')" aria-label="अगला पृष्ठ">अगला →</button>';
    }

    wrap.innerHTML = html;
  }

  window.setCategory = function (catSlug, btnEl) {
    currentCategory = catSlug;
    currentPage = 1;

    var btns = document.querySelectorAll('.category-filter-btn');
    btns.forEach(function (btn) {
      btn.classList.remove('active');
      btn.setAttribute('aria-selected', 'false');
    });

    if (btnEl) {
      btnEl.classList.add('active');
      btnEl.setAttribute('aria-selected', 'true');
    }

    renderArticlesGrid();
  };

  window.setPage = function (pageNum) {
    currentPage = pageNum;
    renderArticlesGrid();
    var sec = document.getElementById('articles-section');
    if (sec) {
      sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  // --- 4. ACCESSIBLE SEARCH MODAL & FORM ---
  window.openSearchModal = function () {
    var m = document.getElementById('searchModal');
    if (!m) return;
    m.classList.add('active');
    var inp = document.getElementById('modalSearchInput');
    if (inp) {
      inp.focus();
      renderSearchResults(inp.value.trim());
    }
    document.body.style.overflow = 'hidden';
  };

  window.closeSearchModal = function () {
    var m = document.getElementById('searchModal');
    if (!m) return;
    m.classList.remove('active');
    document.body.style.overflow = '';
  };

  window.handleSearchSubmit = function (e) {
    if (e && e.preventDefault) e.preventDefault();
    var inp = document.getElementById('main-search-input');
    var q = inp ? inp.value.trim() : '';
    window.openSearchModal();
    var modalInp = document.getElementById('modalSearchInput');
    if (modalInp) {
      modalInp.value = q;
      renderSearchResults(q);
    }
  };

  window.handleModalSearchInput = function (q) {
    renderSearchResults(q.trim());
  };

  function renderSearchResults(query) {
    var container = document.getElementById('modalSearchResults');
    if (!container) return;

    if (!query) {
      container.innerHTML = '<div style="text-align:center; padding:2rem; color:#94A3B8;">खोजने के लिए शब्द टाइप करें... (उदा. पूजा, व्रत, मुहूर्त)</div>';
      return;
    }

    query = query.toLowerCase();
    var matched = articles.filter(function (a) {
      return (
        a.title.toLowerCase().indexOf(query) !== -1 ||
        a.excerpt.toLowerCase().indexOf(query) !== -1 ||
        a.category.toLowerCase().indexOf(query) !== -1
      );
    });

    if (matched.length === 0) {
      container.innerHTML = '<div style="text-align:center; padding:2rem; color:#64748B;">"' + query + '" के लिए कोई लेख नहीं मिला।</div>';
      return;
    }

    var html = '';
    matched.slice(0, 10).forEach(function (a) {
      html += [
        '<a href="' + a.url + '" class="search-result-item" style="display:flex; gap:1rem; padding:0.85rem; border-bottom:1px solid #E2E8F0; text-decoration:none; color:inherit; align-items:center;">',
        '  <img src="' + a.featuredImage + '" alt="' + a.title + '" style="width:64px; height:64px; object-fit:cover; border-radius:8px; flex-shrink:0;">',
        '  <div>',
        '    <span style="font-size:10px; font-weight:700; color:#FF7000; text-transform:uppercase;">' + a.category + '</span>',
        '    <h4 style="font-size:0.95rem; font-weight:700; color:#0A1629; margin:2px 0 4px; line-height:1.35;">' + a.title + '</h4>',
        '    <span style="font-size:0.8rem; color:#64748B;">' + a.publishDate + '</span>',
        '  </div>',
        '</a>'
      ].join('');
    });

    container.innerHTML = html;
  }

  // --- 5. INITIALIZATION ---
  document.addEventListener('DOMContentLoaded', function () {
    initSliderControls();
    renderArticlesGrid();
  });

  // Global escape key to close search modal
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      window.closeSearchModal();
      window.toggleMobileDrawer(false);
    }
  });

})();
