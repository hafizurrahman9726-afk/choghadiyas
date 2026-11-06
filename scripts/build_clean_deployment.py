import json
import re

with open('perfect_real_articles.json', 'r', encoding='utf-8') as f:
    articles = json.load(f)

print(f'Building deployment files with {len(articles)} genuine articles...')

# 1. Generate articles-manifest.js
manifest_js = '''// Choghadiyas.in — Genuine Published Articles Catalog
// 100% Real Live Articles with /uploads/posts/ webp images

window.CHOGHADIYA_ARTICLES = ''' + json.dumps(articles, indent=2, ensure_ascii=False) + ''';
'''
with open('public/hostinger-deployment/assets/js/articles-manifest.js', 'w', encoding='utf-8') as f:
    f.write(manifest_js)
print('Wrote assets/js/articles-manifest.js')

# 2. Generate 30 pre-rendered cards
cards_html = []
for a in articles[:30]:
    card = f'''      <article class="article-card" data-category="{a['categorySlug']}">
        <a href="{a['url']}" class="article-thumb-link" aria-label="{a['title']}">
          <img src="{a['featuredImage']}" alt="{a['title']}" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">{a['category']}</span>
          <h3 class="article-title">
            <a href="{a['url']}">{a['title']}</a>
          </h3>
          <p class="article-excerpt">{a['excerpt']}</p>
          <div class="article-footer">
            <span class="article-meta">{a['author']} · {a['publishDate']}</span>
            <a href="{a['url']}" class="read-more-link" aria-label="{a['title']} पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>'''
    cards_html.append(card)
cards_block = '\n'.join(cards_html)

# 3. Generate slider HTML
slider_cards = []
for a in articles[:10]:
    sc = f'''        <div class="slider-card" onclick="window.location.href='{a['url']}';" role="button" tabindex="0" aria-label="{a['title']}">
          <img src="{a['featuredImage']}" alt="{a['title']}" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">{a['category']}</span>
            <h4 class="slider-title">{a['title']}</h4>
          </div>
        </div>'''
    slider_cards.append(sc)
slider_block = '\n'.join(slider_cards + slider_cards)

# 4. Generate CSS with suppression of old yellow header
theme_css = '''/* ============================================================
   Choghadiyas.in — Premium Design Theme CSS
   Pure Custom CSS (No Build Tools Required for Hostinger)
   ============================================================ */

/* ------------------------------------------------------------
   CRITICAL: SUPPRESS OLD YELLOW HEADER ON HOMEPAGE
   ------------------------------------------------------------ */
#responsiveHeader,
.responsive-header,
.mobile-menu-overlay,
.mobile-menu,
.header-spacer,
.mobile-header,
header.responsive-header {
  display: none !important;
  visibility: hidden !important;
  height: 0 !important;
  min-height: 0 !important;
  max-height: 0 !important;
  overflow: hidden !important;
  pointer-events: none !important;
  margin: 0 !important;
  padding: 0 !important;
  border: none !important;
}

:root {
  --primary-navy: #0A1629;
  --accent-orange: #FF7000;
  --accent-orange-hover: #E65100;
  --accent-orange-text: #D95D00;
  --bg-light: #F7F9FC;
  --card-white: #FFFFFF;
  --border-soft: #DFE6EF;
  --text-muted: #64748B;
  --footer-dark: #0B101B;
  --font-family: 'Plus Jakarta Sans', 'Noto Sans Devanagari', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: var(--font-family);
  background-color: var(--bg-light);
  color: var(--primary-navy);
  line-height: 1.6;
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}

a {
  color: inherit;
  text-decoration: none;
  transition: color 0.15s ease;
}

a:hover {
  color: var(--accent-orange);
}

button {
  font-family: inherit;
  border: none;
  background: none;
  cursor: pointer;
}

button:focus-visible, a:focus-visible {
  outline: 2px solid var(--accent-orange);
  outline-offset: 2px;
}

.container {
  max-width: 1320px;
  margin: 0 auto;
  padding: 0 1.25rem;
}

/* ============================================================
   1. SINGLE PREMIUM WHITE HEADER (Screenshots 1 & 4)
   ============================================================ */
.site-header {
  position: sticky;
  top: 0;
  z-index: 1000;
  background: var(--card-white);
  border-bottom: 1px solid var(--border-soft);
  box-shadow: 0 2px 8px rgba(10, 22, 41, 0.04);
}

.header-inner {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 72px;
}

.brand-logo {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  text-decoration: none;
}

.brand-icon {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: linear-gradient(135deg, #FF8A00, #FF5000);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  box-shadow: 0 4px 12px rgba(255, 112, 0, 0.25);
  flex-shrink: 0;
}

.brand-title {
  font-size: 1.35rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  color: var(--primary-navy);
  line-height: 1.1;
}

.brand-title span {
  color: var(--accent-orange);
}

.brand-subtitle {
  font-size: 0.72rem;
  font-weight: 600;
  color: var(--text-muted);
  letter-spacing: 0.02em;
}

/* Nav Pills (Center - Screenshot 1) */
.nav-pills {
  display: flex;
  align-items: center;
  gap: 0.35rem;
}

.nav-pill {
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  font-size: 0.88rem;
  font-weight: 600;
  color: #334155;
  background: transparent;
  transition: all 0.15s ease;
  white-space: nowrap;
}

.nav-pill:hover {
  background: #EEF2F6;
  color: var(--primary-navy);
}

.nav-pill.active {
  background: var(--primary-navy);
  color: #FFFFFF;
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.search-toggle-btn {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border: 1px solid var(--border-soft);
  background: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--primary-navy);
  transition: all 0.15s ease;
}

.search-toggle-btn:hover {
  background: #F1F5F9;
  border-color: #CBD5E1;
}

.mobile-menu-btn {
  display: none;
  width: 42px;
  height: 42px;
  border-radius: 10px;
  border: 1px solid var(--border-soft);
  background: #fff;
  align-items: center;
  justify-content: center;
  color: var(--primary-navy);
}

/* Mobile Drawer */
.mobile-drawer-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(10, 22, 41, 0.6);
  z-index: 2000;
  backdrop-filter: blur(2px);
}

.mobile-drawer-overlay.active {
  display: block;
}

.mobile-drawer {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  width: 82%;
  max-width: 320px;
  background: #fff;
  z-index: 2001;
  transform: translateX(100%);
  transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  display: flex;
  flex-direction: column;
  padding: 1.25rem;
  box-shadow: -4px 0 24px rgba(10, 22, 41, 0.15);
  overflow-y: auto;
}

.mobile-drawer.active {
  transform: translateX(0);
}

.mobile-drawer-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-bottom: 1rem;
  border-bottom: 1px solid var(--border-soft);
}

.drawer-close-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #F1F5F9;
  font-size: 1.1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #475569;
}

.mobile-drawer-search {
  margin: 1rem 0;
}

.mobile-drawer-search form {
  display: flex;
  align-items: center;
  background: #F8FAFC;
  border: 1px solid var(--border-soft);
  border-radius: 9999px;
  padding: 0.25rem 0.5rem 0.25rem 1rem;
}

.mobile-drawer-search input {
  width: 100%;
  border: none;
  background: transparent;
  font-size: 0.88rem;
  outline: none;
}

.mobile-drawer-search button {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--accent-orange);
  color: #fff;
  font-weight: 700;
}

.mobile-drawer-nav {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
  margin-top: 0.5rem;
}

.mobile-nav-link {
  padding: 0.75rem 1rem;
  border-radius: 12px;
  font-size: 0.95rem;
  font-weight: 600;
  color: #334155;
  transition: background 0.15s ease;
}

.mobile-nav-link:hover, .mobile-nav-link.active {
  background: #FFF3EB;
  color: var(--accent-orange);
}

/* ============================================================
   2. HERO & SEARCH (Screenshot 3 & 4)
   ============================================================ */
.hero-section {
  padding: 3.5rem 0 2rem;
  text-align: center;
}

.hero-title {
  font-size: 2.75rem;
  font-weight: 900;
  color: var(--primary-navy);
  line-height: 1.15;
  letter-spacing: -0.03em;
}

.hero-title span {
  color: var(--accent-orange);
}

.hero-subtitle {
  font-size: 1.05rem;
  color: var(--text-muted);
  max-width: 680px;
  margin: 0.85rem auto 0;
  line-height: 1.6;
}

.search-bar-wrap {
  max-width: 620px;
  margin: 2rem auto 0;
}

.search-bar-form {
  display: flex;
  align-items: center;
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  border-radius: 9999px;
  padding: 0.35rem 0.4rem 0.35rem 1.25rem;
  box-shadow: 0 4px 20px rgba(10, 22, 41, 0.06);
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.search-bar-form:focus-within {
  border-color: var(--accent-orange);
  box-shadow: 0 4px 24px rgba(255, 112, 0, 0.15);
}

.search-bar-input {
  flex: 1;
  border: none;
  background: transparent;
  font-size: 0.95rem;
  color: var(--primary-navy);
  outline: none;
  min-width: 0;
}

.search-submit-btn {
  background: linear-gradient(135deg, #FF8A00, #FF5000);
  color: #FFFFFF;
  padding: 0.75rem 1.75rem;
  border-radius: 9999px;
  font-size: 0.92rem;
  font-weight: 700;
  box-shadow: 0 4px 14px rgba(255, 112, 0, 0.3);
  transition: transform 0.15s ease, box-shadow 0.15s ease;
  white-space: nowrap;
}

.search-submit-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(255, 112, 0, 0.4);
}

/* ============================================================
   3. AUTOMATIC IMAGE SLIDER (Screenshots 1 & 4)
   ============================================================ */
.slider-section {
  padding: 2.25rem 0 1.5rem;
  overflow: hidden;
  position: relative;
}

.slider-track {
  display: flex;
  gap: 1.25rem;
  width: max-content;
  animation: marquee 45s linear infinite;
  will-change: transform;
}

.slider-track:hover {
  animation-play-state: paused;
}

@keyframes marquee {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

@media (prefers-reduced-motion: reduce) {
  .slider-track {
    animation: none;
    overflow-x: auto;
    width: 100%;
    padding-bottom: 0.5rem;
  }
}

.slider-card {
  position: relative;
  width: 200px;
  height: 270px;
  border-radius: 18px;
  overflow: hidden;
  flex-shrink: 0;
  cursor: pointer;
  box-shadow: 0 6px 16px rgba(10, 22, 41, 0.08);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.slider-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 28px rgba(10, 22, 41, 0.15);
}

.slider-card img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.slider-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(10, 22, 41, 0) 35%, rgba(10, 22, 41, 0.88) 100%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 1rem;
  color: #fff;
}

.slider-tag {
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
  color: var(--accent-orange);
  background: rgba(255, 255, 255, 0.95);
  padding: 2px 7px;
  border-radius: 9999px;
  display: inline-block;
  align-self: flex-start;
  margin-bottom: 0.35rem;
}

.slider-title {
  font-size: 0.85rem;
  font-weight: 700;
  line-height: 1.35;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* ============================================================
   4. CHOGHADIYA & PANCHANG TOOL (Section 6)
   ============================================================ */
.tool-card {
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  border-radius: 22px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(10, 22, 41, 0.04);
}

.tool-header {
  background: var(--primary-navy);
  color: #fff;
  padding: 1.5rem 1.75rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
}

.tool-controls {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.tool-select {
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff;
  padding: 0.45rem 0.85rem;
  border-radius: 10px;
  font-size: 0.85rem;
  outline: none;
}

.tool-select option {
  background: #0A1629;
  color: #fff;
}

.tool-tabs {
  display: flex;
  border-bottom: 1px solid var(--border-soft);
  background: #F8FAFC;
}

.tool-tab-btn {
  flex: 1;
  padding: 0.95rem;
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--text-muted);
  text-align: center;
  transition: all 0.15s ease;
  border-bottom: 2px solid transparent;
}

.tool-tab-btn.active {
  color: var(--accent-orange);
  background: #fff;
  border-bottom-color: var(--accent-orange);
}

.choghadiya-table {
  width: 100%;
  border-collapse: collapse;
}

.choghadiya-table th {
  background: #F8FAFC;
  padding: 0.75rem 1.25rem;
  text-align: left;
  font-size: 0.78rem;
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  border-bottom: 1px solid var(--border-soft);
}

.choghadiya-table td {
  padding: 0.85rem 1.25rem;
  border-bottom: 1px solid #F1F5F9;
  font-size: 0.9rem;
}

.choghadiya-table tr:hover td {
  background: #F8FAFC;
}

.nature-badge {
  display: inline-block;
  padding: 3px 10px;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 700;
}

.nature-badge.emerald { background: #ECFDF5; color: #047857; }
.nature-badge.blue { background: #EFF6FF; color: #1D4ED8; }
.nature-badge.amber { background: #FFFBEB; color: #B45309; }
.nature-badge.rose { background: #FFF1F2; color: #BE123C; }

/* ============================================================
   5. 30 ARTICLES GRID (Screenshot 2)
   ============================================================ */
.category-filter-bar {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  overflow-x: auto;
  padding-bottom: 0.75rem;
  margin-bottom: 1.75rem;
  scrollbar-width: none;
}

.category-filter-bar::-webkit-scrollbar {
  display: none;
}

.category-filter-btn {
  padding: 0.55rem 1.25rem;
  border-radius: 9999px;
  font-size: 0.88rem;
  font-weight: 600;
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  color: #475569;
  white-space: nowrap;
  transition: all 0.15s ease;
}

.category-filter-btn:hover {
  background: #F1F5F9;
  color: var(--primary-navy);
}

.category-filter-btn.active {
  background: var(--primary-navy);
  color: #FFFFFF;
  border-color: var(--primary-navy);
}

.articles-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.75rem;
}

.article-card {
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  border-radius: 18px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-shadow: 0 4px 16px rgba(10, 22, 41, 0.03);
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.article-card:hover {
  transform: translateY(-4px);
  border-color: #CBD5E1;
  box-shadow: 0 12px 28px rgba(10, 22, 41, 0.08);
}

.article-thumb-link {
  display: block;
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
  background: #E2E8F0;
}

.article-thumb {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.35s ease;
  display: block;
}

.article-card:hover .article-thumb {
  transform: scale(1.04);
}

.article-body {
  padding: 1.35rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.category-badge {
  display: inline-block;
  align-self: flex-start;
  font-size: 11px;
  font-weight: 800;
  color: var(--accent-orange-text);
  background: #FFF3EB;
  padding: 3px 10px;
  border-radius: 9999px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
  margin-bottom: 0.75rem;
}

.article-title {
  font-size: 1.15rem;
  font-weight: 800;
  color: var(--primary-navy);
  line-height: 1.35;
  margin-bottom: 0.6rem;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.article-excerpt {
  font-size: 0.88rem;
  color: var(--text-muted);
  line-height: 1.6;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  margin-bottom: 1.25rem;
  flex: 1;
}

.article-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-top: 0.85rem;
  border-top: 1px solid #F1F5F9;
  font-size: 0.8rem;
}

.article-meta {
  color: #94A3B8;
  font-weight: 500;
}

.read-more-link {
  font-weight: 700;
  color: var(--accent-orange-text);
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}

.read-more-link:hover {
  text-decoration: underline;
}

/* Pagination (Screenshot 3) */
.pagination-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 2.75rem;
}

.page-btn {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  font-size: 0.92rem;
  font-weight: 700;
  color: var(--primary-navy);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.15s ease;
}

.page-btn:hover {
  background: #F1F5F9;
}

.page-btn.active {
  background: var(--primary-navy);
  color: #fff;
  border-color: var(--primary-navy);
}

.page-btn.next {
  width: auto;
  padding: 0 1.25rem;
}

/* ============================================================
   6. SECTIONS: INFO, FAQ, COMMUNITY & AUTHOR
   ============================================================ */
.section-card {
  background: #FFFFFF;
  border: 1px solid var(--border-soft);
  border-radius: 22px;
  padding: 2.5rem;
  margin-top: 3.5rem;
  box-shadow: 0 6px 24px rgba(10, 22, 41, 0.03);
}

.feature-cards-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-top: 2rem;
  text-align: left;
}

.feature-item-card {
  background: #F8FAFC;
  border: 1px solid var(--border-soft);
  border-radius: 16px;
  padding: 1.5rem;
}

.feature-icon-box {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: #FFF3EB;
  color: var(--accent-orange);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1rem;
}

.faq-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  max-width: 860px;
  margin: 2rem auto 0;
}

.faq-item {
  background: #F8FAFC;
  border: 1px solid var(--border-soft);
  border-radius: 14px;
  overflow: hidden;
  transition: border-color 0.15s ease;
}

.faq-question {
  width: 100%;
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  text-align: left;
  font-size: 1rem;
  font-weight: 700;
  color: var(--primary-navy);
}

.faq-icon {
  font-size: 1.1rem;
  color: var(--text-muted);
  transition: transform 0.2s ease;
}

.faq-item.active .faq-icon {
  transform: rotate(45deg);
  color: var(--accent-orange);
}

.faq-answer {
  display: none;
  padding: 0 1.5rem 1.25rem;
  color: var(--text-muted);
  font-size: 0.92rem;
  line-height: 1.6;
}

.faq-item.active .faq-answer {
  display: block;
}

.community-banner {
  background: linear-gradient(135deg, #0A1629 0%, #152542 100%);
  color: #fff;
  border-radius: 22px;
  padding: 3rem 2rem;
  text-align: center;
  margin-top: 3.5rem;
}

.author-profile-card {
  text-align: center;
  max-width: 780px;
  margin: 3.5rem auto 0;
}

.author-avatar-img {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #fff;
  box-shadow: 0 4px 16px rgba(10, 22, 41, 0.12);
  margin-bottom: 1rem;
}

/* ============================================================
   7. FOOTER
   ============================================================ */
.site-footer {
  background: var(--footer-dark);
  color: #94A3B8;
  margin-top: 4.5rem;
  padding: 4rem 0 2rem;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.footer-bottom {
  margin-top: 3.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 1rem;
  font-size: 0.85rem;
}

/* ============================================================
   8. RESPONSIVE MEDIA QUERIES (320px - 1024px)
   ============================================================ */
@media (max-width: 1024px) {
  .nav-pills {
    display: none;
  }
  .mobile-menu-btn {
    display: flex;
  }
  .articles-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .feature-cards-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.15rem;
  }
  .articles-grid {
    grid-template-columns: 1fr;
  }
  .feature-cards-grid {
    grid-template-columns: 1fr;
  }
  .tool-header {
    flex-direction: column;
    align-items: flex-start;
  }
  .tool-controls {
    width: 100%;
    flex-direction: column;
  }
  .tool-select {
    width: 100%;
  }
  .section-card {
    padding: 1.5rem;
  }
  .slider-card {
    width: 170px;
    height: 230px;
  }
}

@media (max-width: 480px) {
  .hero-title {
    font-size: 1.75rem;
  }
  .header-inner {
    height: 64px;
  }
  .brand-title {
    font-size: 1.15rem;
  }
  .search-bar-form {
    padding: 0.25rem 0.35rem 0.25rem 1rem;
  }
  .search-submit-btn {
    padding: 0.65rem 1.25rem;
    font-size: 0.85rem;
  }
}
'''
with open('public/hostinger-deployment/assets/css/choghadiya-theme.css', 'w', encoding='utf-8') as f:
    f.write(theme_css)
print('Wrote updated assets/css/choghadiya-theme.css')

# 5. Build templates/home.php
# Use string concatenation to avoid any bash variable interpolation
php_start = '''<?php
/**
 * Choghadiyas.in — Premium Redesigned Homepage Template
 * 100% Genuine Published Articles with Real /uploads/posts/ webp images
 * Suppresses Duplicate Header
 */

require_once __DIR__ . '/../config/config.php';

if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set('Asia/Kolkata');
}

// CRITICAL: Suppress duplicate old yellow header
$GLOBALS['hide_default_header'] = true;
$hide_default_header = true;

// Include standard header (preserves SEO meta, AdSense scripts, Analytics, OpenGraph, Canonical)
if (file_exists(__DIR__ . '/../includes/header_responsive.php')) {
    require_once __DIR__ . '/../includes/header_responsive.php';
} elseif (file_exists(__DIR__ . '/../includes/header.php')) {
    require_once __DIR__ . '/../includes/header.php';
}
?>

<!-- Theme Stylesheet (Suppresses Old Yellow Header & Injects New Design) -->
<link rel="stylesheet" href="/assets/css/choghadiya-theme.css">

<!-- Single Premium White Header (Screenshots 1 & 4) -->
<header class="site-header" id="premiumHeader">
  <div class="container">
    <div class="header-inner">
      <a href="/" class="brand-logo" aria-label="Choghadiyas.in Homepage">
        <div class="brand-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2"/><path d="M12 20v2"/>
            <path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/>
            <path d="M2 12h2"/><path d="M20 12h2"/>
            <path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
          </svg>
        </div>
        <div>
          <div class="brand-title">Choghadiya<span>s.in</span></div>
          <div class="brand-subtitle">वैदिक चौघड़िया एवं पंचांग</div>
        </div>
      </a>

      <!-- Desktop Nav Pills -->
      <nav class="nav-pills" aria-label="मुख्य नेविगेशन">
        <a href="/" class="nav-pill active">Home</a>
        <a href="#choghadiya-section" class="nav-pill">आज का चौघड़िया</a>
        <a href="#choghadiya-section" class="nav-pill">पंचांग</a>
        <a href="#articles-section" class="nav-pill" onclick="window.setCategory('vrat', this); return false;">व्रत और त्योहार</a>
        <a href="#articles-section" class="nav-pill" onclick="window.setCategory('muhurat', this); return false;">शुभ मुहूर्त</a>
        <a href="#articles-section" class="nav-pill" onclick="window.setCategory('puja', this); return false;">पूजा विधि</a>
        <a href="/about" class="nav-pill">About Us</a>
        <a href="/contact" class="nav-pill">Contact Us</a>
      </nav>

      <!-- Search & Mobile Menu Toggle -->
      <div class="header-actions">
        <button class="search-toggle-btn" onclick="document.getElementById('main-search-input').focus();" aria-label="खोजें">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
          </svg>
        </button>
        <button class="mobile-menu-btn" id="mobileMenuToggle" onclick="window.toggleMobileDrawer();" aria-label="मेनू खोलें" aria-expanded="false">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>

<!-- Mobile Navigation Drawer -->
<div class="mobile-drawer-overlay" id="mobileDrawerOverlay" onclick="window.toggleMobileDrawer(false);"></div>
<aside class="mobile-drawer" id="mobileDrawer" aria-label="मोबाइल नेविगेशन">
  <div class="mobile-drawer-header">
    <div class="brand-title" style="font-size:1.15rem;">Choghadiya<span style="color:var(--accent-orange);">s.in</span></div>
    <button class="drawer-close-btn" onclick="window.toggleMobileDrawer(false);" aria-label="मेनू बंद करें">✕</button>
  </div>
  <div class="mobile-drawer-search">
    <form onsubmit="window.handleMobileSearch(event);">
      <input type="text" id="mobile-drawer-search-input" placeholder="खोजें (e.g. चौघड़िया, मुहूर्त)..." aria-label="मोबाइल खोज">
      <button type="submit" aria-label="खोजें">→</button>
    </form>
  </div>
  <nav class="mobile-drawer-nav">
    <a href="/" class="mobile-nav-link active">Home</a>
    <a href="#choghadiya-section" class="mobile-nav-link" onclick="window.toggleMobileDrawer(false);">आज का चौघड़िया</a>
    <a href="#choghadiya-section" class="mobile-nav-link" onclick="window.toggleMobileDrawer(false);">दैनिक पंचांग</a>
    <a href="#articles-section" class="mobile-nav-link" onclick="window.setCategory('vrat'); window.toggleMobileDrawer(false);">व्रत और त्योहार</a>
    <a href="#articles-section" class="mobile-nav-link" onclick="window.setCategory('muhurat'); window.toggleMobileDrawer(false);">शुभ मुहूर्त 2026</a>
    <a href="#articles-section" class="mobile-nav-link" onclick="window.setCategory('puja'); window.toggleMobileDrawer(false);">पूजा विधि व सामग्री</a>
    <a href="/about" class="mobile-nav-link">About Us (हमारे बारे में)</a>
    <a href="/contact" class="mobile-nav-link">Contact Us (संपर्क करें)</a>
    <a href="/editorial-policy" class="mobile-nav-link">Editorial Policy</a>
    <a href="/privacy-policy" class="mobile-nav-link">Privacy Policy</a>
  </nav>
</aside>

<div class="main-content-wrap">
  <!-- Hero Section -->
  <section class="hero-section">
    <div class="container">
      <h1 class="hero-title">
        Choghadiyas.in — आज का चौघड़िया एवं <span>शुभ मुहूर्त</span>
      </h1>
      <p class="hero-subtitle">
        भारत का सबसे विश्वसनीय वैदिक पंचांग और काल-गणना पोर्टल। जानिए दिन व रात का चौघड़िया, राहुकाल, अभिजित मुहूर्त और दैनिक पंचांग।
      </p>

      <div class="search-bar-wrap">
        <form class="search-bar-form" onsubmit="window.handleSearchSubmit(event);">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2" style="margin-right:0.5rem;" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
          </svg>
          <input 
            type="text" 
            id="main-search-input" 
            class="search-bar-input" 
            placeholder="Search Vedic articles (e.g. चौघड़िया, मुहूर्त, पंचांग, छठ पूजा)..."
            aria-label="Search articles"
          >
          <button type="submit" class="search-submit-btn">Search →</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Automatic Image Slider (10 Genuine Articles Looped) -->
  <section class="slider-section" aria-label="ट्रेंडिंग लेख स्लाइडर">
    <div id="slider-track" class="slider-track">
''' + slider_block + '''
    </div>
  </section>

  <!-- Choghadiya & Panchang Tool -->
  <section id="choghadiya-section" class="container" style="margin-top:2rem;">
    <div class="tool-card">
      <div class="tool-header">
        <div>
          <span style="background:var(--accent-orange); color:#fff; font-size:10px; font-weight:800; text-transform:uppercase; padding:2px 8px; border-radius:9999px;">
            दैनिक पंचांग व चौघड़िया
          </span>
          <h2 style="margin-top:0.35rem; font-size:1.5rem; font-weight:800;">आज का चौघड़िया मुहूर्त</h2>
          <p style="color:#CBD5E1; font-size:0.85rem; margin-top:0.25rem;">
            स्थानीय सूर्योदय-सूर्यास्त आधारित वास्तविक गणना। अमृत, शुभ व लाभ मुहूर्त में किए गए कार्य फलदायी होते हैं।
          </p>
        </div>
        <div class="tool-controls">
          <select id="city-select" class="tool-select" onchange="window.handleCityChange(this.value);" aria-label="स्थान चुनें">
            <option value="delhi">नई दिल्ली (New Delhi)</option>
            <option value="mumbai">मुंबई (Mumbai)</option>
            <option value="varanasi">वाराणसी (Varanasi)</option>
            <option value="jaipur">जयपुर (Jaipur)</option>
            <option value="kolkata">कोलकाता (Kolkata)</option>
            <option value="bengaluru">बेंगलुरु (Bengaluru)</option>
            <option value="ahmedabad">अहमदाबाद (Ahmedabad)</option>
            <option value="patna">पटना (Patna)</option>
            <option value="lucknow">लखनऊ (Lucknow)</option>
            <option value="pune">पुणे (Pune)</option>
            <option value="ayodhya">अयोध्या (Ayodhya)</option>
            <option value="ujjain">उज्जैन (Ujjain)</option>
            <option value="haridwar">हरिद्वार (Haridwar)</option>
          </select>
          <input type="date" id="date-select" class="tool-select" onchange="window.handleDateChange(this.value);" aria-label="तारीख चुनें">
        </div>
      </div>

      <!-- Day / Night Tabs -->
      <div class="tool-tabs">
        <button id="tab-day" class="tool-tab-btn active" onclick="window.switchTab('day');">☀️ दिन का चौघड़िया (Day Choghadiya)</button>
        <button id="tab-night" class="tool-tab-btn" onclick="window.switchTab('night');">🌙 रात का चौघड़िया (Night Choghadiya)</button>
      </div>

      <!-- Active Period Summary Banner -->
      <div id="active-slot-banner" style="background:#FFF3EB; border-bottom:1px solid #FED7AA; padding:0.85rem 1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.5rem;">
        <div style="display:flex; align-items:center; gap:0.5rem;">
          <span style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#10B981;"></span>
          <span style="font-size:0.85rem; font-weight:700; color:#0A1629;">वर्तमान चौघड़िया मुहूर्त:</span>
          <strong id="current-slot-name" style="font-size:0.95rem; color:#D95D00;">शुभ</strong>
          <span id="current-slot-time" style="font-size:0.82rem; color:#64748B;">(चालू समय)</span>
        </div>
        <div style="font-size:0.82rem; color:#475569;">
          सूर्योदय: <strong id="sunrise-display" style="color:#0A1629;">06:38 AM</strong> | सूर्यास्त: <strong id="sunset-display" style="color:#0A1629;">05:32 PM</strong>
        </div>
      </div>

      <!-- Choghadiya Timings Table -->
      <div style="overflow-x:auto;">
        <table class="choghadiya-table">
          <thead>
            <tr>
              <th>मुहूर्त नाम</th>
              <th>प्रारंभ समय</th>
              <th>समाप्ति समय</th>
              <th>प्रकृति</th>
              <th>स्वामी ग्रह</th>
              <th>उपयुक्त कार्य</th>
            </tr>
          </thead>
          <tbody id="choghadiya-tbody">
            <!-- Populated by choghadiya-engine.js -->
          </tbody>
        </table>
      </div>

      <!-- Important Timings Strip -->
      <div style="background:#F8FAFC; border-top:1px solid var(--border-soft); padding:1.25rem 1.5rem;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem;">
          <div style="background:#fff; border:1px solid #FECDD3; padding:0.85rem; border-radius:14px;">
            <span style="font-size:10px; font-weight:800; color:#BE123C; text-transform:uppercase;">राहुकाल (अशुभ)</span>
            <div id="rahu-display" style="font-size:0.95rem; font-weight:800; color:#0A1629; margin-top:2px;">10:30 AM से 12:00 PM</div>
            <span style="font-size:10px; color:#64748B;">शुभ कार्य न करें</span>
          </div>
          <div style="background:#fff; border:1px solid #A7F3D0; padding:0.85rem; border-radius:14px;">
            <span style="font-size:10px; font-weight:800; color:#047857; text-transform:uppercase;">अभिजित मुहूर्त</span>
            <div id="abhijit-display" style="font-size:0.95rem; font-weight:800; color:#0A1629; margin-top:2px;">11:42 AM से 12:35 PM</div>
            <span style="font-size:10px; color:#047857;">सर्वकार्य सिद्धि</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 30 Genuine Published Articles Grid -->
  <section id="articles-section" class="container" style="margin-top:3.5rem;">
    <div class="category-filter-bar">
      <button class="category-filter-btn active" onclick="window.setCategory('all', this)">सभी लेख (All)</button>
      <button class="category-filter-btn" onclick="window.setCategory('choghadiya', this)">आज का चौघड़िया</button>
      <button class="category-filter-btn" onclick="window.setCategory('muhurat', this)">शुभ मुहूर्त 2026</button>
      <button class="category-filter-btn" onclick="window.setCategory('vrat', this)">व्रत और त्योहार</button>
      <button class="category-filter-btn" onclick="window.setCategory('puja', this)">पूजा विधि व सामग्री</button>
      <button class="category-filter-btn" onclick="window.setCategory('panchang', this)">दैनिक पंचांग</button>
    </div>

    <div id="articles-grid" class="articles-grid">
''' + cards_block + '''
    </div>

    <!-- Pagination -->
    <div id="pagination-wrap" class="pagination-wrap">
      <button class="page-btn active">1</button>
      <button class="page-btn" onclick="window.setPage(2);">2</button>
      <button class="page-btn next" onclick="window.setPage(2);">अगला →</button>
    </div>
  </section>

  <!-- Information Section -->
  <section class="container">
    <div class="section-card" style="text-align:center;">
      <span style="font-size: 11px; font-weight: 800; color: var(--accent-orange); background: #FFF3EB; padding: 3px 10px; border-radius: 9999px;">
        सनातन काल गणना व मार्गदर्शन
      </span>
      <h2 style="font-size:1.85rem; font-weight:800; margin-top:0.5rem; color:var(--primary-navy);">
        Choghadiyas.in — चौघड़िया, पंचांग और शुभ मुहूर्त की प्रामाणिक जानकारी
      </h2>
      <p style="color:var(--text-muted); font-size:0.95rem; max-width:780px; margin:0.75rem auto 0; line-height:1.6;">
        Choghadiyas.in भारत का अग्रणी सनातन पंचांग और मुहूर्त पोर्टल है। हमारा उद्देश्य प्राचीन वैदिक ज्योतिष की काल-गणना पद्धतियों को आधुनिक, सरल और सटीक रूप में जन-जन तक निःशुल्क पहुंचाना है।
      </p>
      <div class="feature-cards-grid">
        <div class="feature-item-card">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M20 12v10H4V12"/><path d="M2 7h20v5H2z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
          </div>
          <h3 style="font-size:1.1rem; font-weight:800; color:var(--primary-navy); margin-bottom:0.4rem;">100% Free Information</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.5;">सभी चौघड़िया मुहूर्त व पंचांग बिना किसी शुल्क के पूर्णतः निःशुल्क उपलब्ध हैं।</p>
        </div>
        <div class="feature-item-card">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
          </div>
          <h3 style="font-size:1.1rem; font-weight:800; color:var(--primary-navy); margin-bottom:0.4rem;">Daily Panchang & Choghadiya</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.5;">दिन व रात के 8-8 पहर, वास्तविक सूर्योदय-सूर्यास्त आधारित गणना।</p>
        </div>
        <div class="feature-item-card">
          <div class="feature-icon-box">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          </div>
          <h3 style="font-size:1.1rem; font-weight:800; color:var(--primary-navy); margin-bottom:0.4rem;">Auspicious Muhurat 2026</h3>
          <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.5;">विवाह, गृह प्रवेश, वाहन खरीद और व्यापार आरंभ के सर्वश्रेष्ठ मुहूर्त।</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="container">
    <div class="section-card">
      <div style="text-align:center;">
        <span style="font-size: 11px; font-weight: 800; color: var(--accent-orange); background: #FFF3EB; padding: 3px 10px; border-radius: 9999px;">
          सामान्य प्रश्नोत्तरी
        </span>
        <h2 style="font-size:1.85rem; font-weight:800; margin-top:0.5rem; color:var(--primary-navy);">
          चौघड़िया व पंचांग से जुड़े महत्वपूर्ण प्रश्न (FAQ)
        </h2>
      </div>
      <div class="faq-list">
        <div class="faq-item active">
          <button class="faq-question" onclick="this.parentElement.classList.toggle('active');" aria-expanded="true">
            <span>चौघड़िया क्या है और इसका क्या महत्व है?</span>
            <span class="faq-icon" aria-hidden="true">+</span>
          </button>
          <div class="faq-answer">
            चौघड़िया एक प्राचीन वैदिक समय-विभाजन प्रणाली है जिसके अनुसार दिन और रात को 8-8 बराबर भागों में विभाजित किया जाता है। प्रत्येक भाग लगभग 1.5 घंटे (3 घटी या चार घड़ी) का होता है। इसमें अमृत, शुभ और लाभ अत्यंत फलदायी माने जाते हैं।
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" onclick="this.parentElement.classList.toggle('active');" aria-expanded="false">
            <span>दिन और रात के चौघड़िया में कौन-से मुहूर्त सर्वश्रेष्ठ हैं?</span>
            <span class="faq-icon" aria-hidden="true">+</span>
          </button>
          <div class="faq-answer">
            अमृत, शुभ और लाभ चौघड़िया किसी भी नए और मांगलिक कार्य को शुरू करने के लिए सर्वश्रेष्ठ माने जाते हैं। चर चौघड़िया यात्रा और स्थानांतरण के लिए शुभ है।
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" onclick="this.parentElement.classList.toggle('active');" aria-expanded="false">
            <span>राहुकाल में क्या कार्य वर्जित हैं?</span>
            <span class="faq-icon" aria-hidden="true">+</span>
          </button>
          <div class="faq-answer">
            राहुकाल प्रत्येक दिन लगभग 90 मिनट का होता है। इस काल में नया व्यापार शुरू करना, विवाह वार्ता, गृह प्रवेश, स्वर्ण या वाहन क्रय जैसे मांगलिक कार्य वर्जित माने गए हैं।
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Community Section -->
  <section class="container">
    <div class="community-banner">
      <span style="font-size:11px; font-weight:800; text-transform:uppercase; color:var(--accent-orange); background:rgba(255,255,255,0.1); padding:3px 12px; border-radius:9999px;">
        सनातन समुदाय से जुड़ें
      </span>
      <h2 style="font-size:2rem; font-weight:800; margin-top:0.75rem; color:#fff;">
        Join Choghadiyas.in WhatsApp Channel & Community
      </h2>
      <p style="color:#CBD5E1; max-width:600px; margin:0.75rem auto 1.75rem; font-size:0.95rem;">
        दैनिक चौघड़िया, पंचांग, एकादशी, पूर्णिमा और प्रमुख त्योहारों के शुभ मुहूर्त की सीधी सूचना अपने मोबाइल पर निःशुल्क पाएं।
      </p>
      <a href="https://whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r" target="_blank" rel="noopener noreferrer" style="display:inline-block; padding:0.85rem 2.25rem; border-radius:9999px; background:linear-gradient(135deg, #25D366, #128C7E); color:#fff; font-weight:700; font-size:0.95rem; box-shadow:0 6px 20px rgba(37,211,102,0.35);">
        WhatsApp चैनल से जुड़ें →
      </a>
    </div>
  </section>

  <!-- Author Profile -->
  <section class="container">
    <div class="section-card author-profile-card">
      <img src="https://choghadiyas.in/uploads/profiles/6a0a995eb34a7.webp" alt="Shiv Kumar Pandit" class="author-avatar-img" width="100" height="100" loading="lazy">
      <div style="margin-bottom:0.5rem;">
        <span style="font-size:10px; font-weight:800; text-transform:uppercase; color:var(--accent-orange); background:#FFF3EB; padding:2px 8px; border-radius:9999px;">
          संस्थापक एवं ज्योतिषाचार्य
        </span>
      </div>
      <h3 style="font-size:1.5rem; font-weight:800; color:var(--primary-navy);">Shiv Kumar Pandit</h3>
      <p style="font-size:0.85rem; font-weight:600; color:var(--accent-orange); margin-top:2px;">संस्थापक एवं मुख्य ज्योतिषाचार्य</p>
      <p style="font-size:0.88rem; color:var(--text-muted); line-height:1.6; margin-top:0.75rem;">
        शिव कुमार पंडित Choghadiyas.in के संस्थापक, वैदिक पंचांग विशेषज्ञ और अनुभवी ज्योतिषाचार्य हैं। वे विगत 18 वर्षों से सनातन धर्म, काल गणना, शुभ मुहूर्त और वैदिक ज्योतिषीय परंपराओं पर प्रामाणिक शोध प्रस्तुत कर रहे हैं।
      </p>
      <div style="margin-top:1.5rem;">
        <a href="/about" style="display:inline-block; padding:0.65rem 1.6rem; border-radius:9999px; background:var(--primary-navy); color:#fff; font-size:0.85rem; font-weight:700;">
          View Author Profile →
        </a>
      </div>
    </div>
  </section>
</div>

<!-- Scripts -->
<script src="/assets/js/choghadiya-engine.js" defer></script>
<script src="/assets/js/articles-manifest.js" defer></script>
<script src="/assets/js/main.js" defer></script>

<!-- Global Footer -->
<?php 
if (file_exists(__DIR__ . '/../includes/footer.php')) {
    require_once __DIR__ . '/../includes/footer.php';
} elseif (file_exists(__DIR__ . '/../includes/footer_responsive.php')) {
    require_once __DIR__ . '/../includes/footer_responsive.php';
}
?>
'''

with open('public/hostinger-deployment/templates/home.php', 'w', encoding='utf-8') as f:
    f.write(php_start)
print('Wrote updated templates/home.php!')

# 6. Build index.html
with open('public/hostinger-deployment/index.html', 'r', encoding='utf-8') as f:
    idx = f.read()

# Replace slider
idx = re.sub(
    r'<div id="slider-track" class="slider-track">.*?</div>',
    f'<div id="slider-track" class="slider-track">\\n{slider_block}\\n    </div>',
    idx,
    flags=re.DOTALL
)

# Replace articles
idx = re.sub(
    r'<div id="articles-grid" class="articles-grid">.*?</div>',
    f'<div id="articles-grid" class="articles-grid">\\n{cards_block}\\n    </div>',
    idx,
    flags=re.DOTALL
)

with open('public/hostinger-deployment/index.html', 'w', encoding='utf-8') as f:
    f.write(idx)
print('Wrote updated index.html!')

# 7. Update main.js
main_js = '''// Choghadiyas.in — Main Client-side Script
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
      grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:3rem; color:#64748B;">\"' + query + '\" से संबंधित कोई लेख नहीं मिला।</div>';
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
'''
with open('public/hostinger-deployment/assets/js/main.js', 'w', encoding='utf-8') as f:
    f.write(main_js)
print('Wrote updated assets/js/main.js')

print('All deployment files updated successfully with ZERO demo content and duplicate header suppression!')
