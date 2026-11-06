// Choghadiyas.in — Main Client-side Script
// Powers Marquee Slider, Live Choghadiya Tool, 30-Article Grid, Search, Mobile Drawer

(function () {
  'use strict';

  var articles = window.CHOGHADIYA_ARTICLES || [];
  var engine = window.ChoghadiyaEngine;

  var currentCity = 'delhi';
  var currentDate = new Date();
  var currentTab = 'day';
  var currentCategory = 'all';
  var currentPage = 1;
  var articlesPerPage = 30; // Exactly 30 articles per page

  // --- 1. MOBILE DRAWER ---
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

  window.handleMobileSearch = function (e) {
    e.preventDefault();
    var inp = document.getElementById('mobile-drawer-search-input');
    if (!inp) return;
    var q = inp.value.trim();
    if (!q) return;
    window.toggleMobileDrawer(false);
    var mainInp = document.getElementById('main-search-input');
    if (mainInp) {
      mainInp.value = q;
      window.handleSearchSubmit(e);
    }
  };

  // --- 2. RENDER CHOGHADIYA TOOL ---
  function renderChoghadiya() {
    if (!engine) return;

    var data = engine.getData(currentDate, currentCity);

    var sunriseEl = document.getElementById('sunrise-display');
    var sunsetEl = document.getElementById('sunset-display');
    var rahuEl = document.getElementById('rahu-display');
    var abhijitEl = document.getElementById('abhijit-display');

    if (sunriseEl) sunriseEl.textContent = data.sunrise;
    if (sunsetEl) sunsetEl.textContent = data.sunset;
    if (rahuEl) rahuEl.textContent = data.rahuKaal;
    if (abhijitEl) abhijitEl.textContent = data.abhijitMuhurat;

    var bannerEl = document.getElementById('active-slot-banner');
    if (bannerEl && data.currentSlot) {
      var slotNameEl = document.getElementById('current-slot-name');
      var slotTimeEl = document.getElementById('current-slot-time');
      if (slotNameEl) slotNameEl.textContent = data.currentSlot.name + ' (' + data.currentSlot.nature + ')';
      if (slotTimeEl) slotTimeEl.textContent = data.currentSlot.start + ' से ' + data.currentSlot.end;
    }

    var tbody = document.getElementById('choghadiya-tbody');
    if (!tbody) return;

    var list = currentTab === 'day' ? data.daySlots : data.nightSlots;
    var html = '';

    list.forEach(function (slot) {
      var isCurrent = data.currentSlot && data.currentSlot.start === slot.start && currentTab === (data.isDay ? 'day' : 'night');
      var rowStyle = isCurrent ? 'background:#FFF8F0; font-weight:700;' : '';

      html += '<tr style="' + rowStyle + '">';
      html += '  <td style="font-weight:700; color:#0A1629;">' + (isCurrent ? '⚡ ' : '') + slot.name + '</td>';
      html += '  <td>' + slot.start + '</td>';
      html += '  <td>' + slot.end + '</td>';
      html += '  <td><span class="nature-badge ' + slot.color + '">' + slot.nature + '</span></td>';
      html += '  <td style="color:#64748B;">' + slot.planet + '</td>';
      html += '  <td style="font-size:0.85rem; color:#475569;">' + slot.suitableFor + '</td>';
      html += '</tr>';
    });

    tbody.innerHTML = html;
  }

  window.switchTab = function (tab) {
    currentTab = tab;
    var dayBtn = document.getElementById('tab-day');
    var nightBtn = document.getElementById('tab-night');
    if (dayBtn && nightBtn) {
      if (tab === 'day') {
        dayBtn.classList.add('active');
        nightBtn.classList.remove('active');
      } else {
        nightBtn.classList.add('active');
        dayBtn.classList.remove('active');
      }
    }
    renderChoghadiya();
  };

  window.handleCityChange = function (cityId) {
    currentCity = cityId;
    renderChoghadiya();
  };

  window.handleDateChange = function (dateStr) {
    if (dateStr) {
      currentDate = new Date(dateStr);
      renderChoghadiya();
    }
  };

  // --- 3. 30 ARTICLES PER PAGE & FILTERING ---
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
      grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:3rem; color:#64748B;">कोई लेख उपलब्ध नहीं है।</div>';
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
    for (var i = 1; i <= totalPages; i++) {
      var activeClass = i === currentPage ? 'active' : '';
      html += '<button class="page-btn ' + activeClass + '" onclick="window.setPage(' + i + ')">' + i + '</button>';
    }

    if (currentPage < totalPages) {
      html += '<button class="page-btn next" onclick="window.setPage(' + (currentPage + 1) + ')">अगला →</button>';
    }

    wrap.innerHTML = html;
  }

  window.setCategory = function (catSlug, btnEl) {
    currentCategory = catSlug;
    currentPage = 1;

    var btns = document.querySelectorAll('.category-filter-btn');
    btns.forEach(function (b) { b.classList.remove('active'); });
    if (btnEl) btnEl.classList.add('active');

    renderArticlesGrid();

    var section = document.getElementById('articles-section');
    if (section) section.scrollIntoView({ behavior: 'smooth' });
  };

  window.setPage = function (pageNum) {
    currentPage = pageNum;
    renderArticlesGrid();
    var section = document.getElementById('articles-section');
    if (section) section.scrollIntoView({ behavior: 'smooth' });
  };

  window.handleSearchSubmit = function (e) {
    e.preventDefault();
    var input = document.getElementById('main-search-input');
    if (!input) return;
    var query = input.value.trim().toLowerCase();
    if (!query) return;

    var matched = articles.filter(function (a) {
      return a.title.toLowerCase().indexOf(query) !== -1 ||
             a.excerpt.toLowerCase().indexOf(query) !== -1 ||
             a.category.toLowerCase().indexOf(query) !== -1;
    });

    var grid = document.getElementById('articles-grid');
    if (!grid) return;

    if (matched.length === 0) {
      grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:3rem; color:#64748B;">"' + query + '" से संबंधित कोई लेख नहीं मिला।</div>';
    } else {
      var html = '';
      matched.forEach(function (a) {
        html += [
          '<article class="article-card">',
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
    }

    var wrap = document.getElementById('pagination-wrap');
    if (wrap) wrap.innerHTML = '';

    var section = document.getElementById('articles-section');
    if (section) section.scrollIntoView({ behavior: 'smooth' });
  };

  // --- INITIALIZE ---
  document.addEventListener('DOMContentLoaded', function () {
    var dateInput = document.getElementById('date-select');
    if (dateInput) {
      var now = new Date();
      var yyyy = now.getFullYear();
      var mm = String(now.getMonth() + 1).padStart(2, '0');
      var dd = String(now.getDate()).padStart(2, '0');
      dateInput.value = yyyy + '-' + mm + '-' + dd;
    }

    renderChoghadiya();
  });

})();
