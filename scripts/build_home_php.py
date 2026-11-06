import json, html

with open('public/hostinger-deployment/assets/js/articles-manifest.js', 'r', encoding='utf-8') as f:
    text = f.read()

import re
m = re.search(r'window\.CHOGHADIYA_ARTICLES\s*=\s*(\[.*?\]);', text, re.DOTALL)
articles = json.loads(m.group(1))

# Select top 10 articles for slider
slider_articles = articles[:10]

slider_cards_html = []
# Card 1 (LCP prioritized): fetchpriority="high", decoding="async", NO loading="lazy"
card1 = slider_articles[0]
slider_cards_html.append(f'''        <div class="slider-card" onclick="window.location.href='{card1['url']}';" role="button" tabindex="0" aria-label="{html.escape(card1['title'])}">
          <img src="{card1['featuredImage']}" alt="{html.escape(card1['title'])}" fetchpriority="high" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">{html.escape(card1['category'])}</span>
            <h4 class="slider-title">{html.escape(card1['title'])}</h4>
          </div>
        </div>''')

# Cards 2 to 10
for a in slider_articles[1:]:
    slider_cards_html.append(f'''        <div class="slider-card" onclick="window.location.href='{a['url']}';" role="button" tabindex="0" aria-label="{html.escape(a['title'])}">
          <img src="{a['featuredImage']}" alt="{html.escape(a['title'])}" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">{html.escape(a['category'])}</span>
            <h4 class="slider-title">{html.escape(a['title'])}</h4>
          </div>
        </div>''')

# Duplicate loop (Cards 11 to 20 for infinite marquee seamlessness)
for a in slider_articles:
    slider_cards_html.append(f'''        <div class="slider-card" onclick="window.location.href='{a['url']}';" role="button" tabindex="0" aria-label="{html.escape(a['title'])}" aria-hidden="true">
          <img src="{a['featuredImage']}" alt="{html.escape(a['title'])}" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">{html.escape(a['category'])}</span>
            <h4 class="slider-title">{html.escape(a['title'])}</h4>
          </div>
        </div>''')

slider_block = "\n".join(slider_cards_html)

# Generate Initial 12 articles for the grid in HTML
initial_grid_cards = []
for a in articles[:12]:
    initial_grid_cards.append(f'''      <article class="article-card" data-category="{a['categorySlug']}">
        <a href="{a['url']}" class="article-thumb-link" aria-label="{html.escape(a['title'])}">
          <img src="{a['featuredImage']}" alt="{html.escape(a['title'])}" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">{html.escape(a['category'])}</span>
          <h3 class="article-title">
            <a href="{a['url']}">{html.escape(a['title'])}</a>
          </h3>
          <p class="article-excerpt">{html.escape(a['excerpt'])}</p>
          <div class="article-footer">
            <span class="article-meta">{html.escape(a['author'])} · {html.escape(a['publishDate'])}</span>
            <a href="{a['url']}" class="read-more-link" aria-label="{html.escape(a['title'])} पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>''')

grid_block = "\n".join(initial_grid_cards)

home_php_template = f'''<?php
/**
 * Choghadiyas.in — High-Performance Clean White Production Homepage
 * Optimized for Core Web Vitals, Google AdSense Readiness & Mobile Responsiveness
 */
$page_title = "चौघड़िया, पंचांग, व्रत-त्योहार और पूजा विधि की जानकारी - Choghadiyas.in";
$page_description = "Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री।";
$canonical_url = "https://choghadiyas.in/";

// Include Unified Site Header
require_once __DIR__ . '/../includes/header_responsive.php';
?>

<main id="main-content" class="homepage-main">

  <!-- Hero Section -->
  <section class="hero-section" aria-label="मुख्य विवरण">
    <div class="container hero-content">
      <div class="hero-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
        </svg>
        <span>धार्मिक एवं पंचांग मार्गदर्शिका</span>
      </div>

      <h1 class="hero-title">
        चौघड़िया, पंचांग, व्रत-त्योहार और पूजा विधि की जानकारी
      </h1>

      <p class="hero-subtitle">
        Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री। हमारे लेखों में धार्मिक परंपराओं, मान्यताओं और उपयोगी जानकारियों को सरल हिंदी में समझाया गया है।
      </p>

      <p class="hero-supporting-text">
        व्रत की तैयारी से लेकर पूजा सामग्री और शुभ अवसरों तक, अपनी जरूरत के अनुसार विषय चुनें और संबंधित लेख पढ़ें। तिथि और मुहूर्त से जुड़ी जानकारी के लिए स्थान, समय और स्थानीय पंचांग का ध्यान रखें।
      </p>

      <!-- Accessible Real Search Bar -->
      <div class="search-bar-wrap">
        <form class="search-bar-form" onsubmit="window.handleSearchSubmit(event);" role="search" aria-label="लेख खोजें">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2" style="margin-right:0.5rem;" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
          </svg>
          <label for="main-search-input" class="sr-only" style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">लेख, व्रत या पूजा विधि खोजें</label>
          <input 
            type="text" 
            id="main-search-input" 
            class="search-bar-input" 
            placeholder="लेख, व्रत या पूजा विधि खोजें..."
            aria-label="लेख, व्रत या पूजा विधि खोजें"
          >
          <button type="submit" class="search-submit-btn" aria-label="खोजें">Search →</button>
        </form>
      </div>

      <!-- Quick Action Category Pills -->
      <div class="hero-quick-pills" style="display:flex; flex-wrap:wrap; justify-content:center; gap:0.6rem; margin-top:1.5rem;">
        <a href="<?php echo $base_url; ?>/category/vrat-tyohar" class="quick-pill">व्रत और त्योहार</a>
        <a href="<?php echo $base_url; ?>/category/shubh-muhurat-guide" class="quick-pill">शुभ मुहूर्त</a>
        <a href="<?php echo $base_url; ?>/category/puja-vidhi-samagri" class="quick-pill">पूजा विधि और सामग्री</a>
        <a href="<?php echo $base_url; ?>/category/vedic-panchang" class="quick-pill">वैदिक पंचांग</a>
      </div>
    </div>
  </section>

  <!-- Automatic Image Slider (10 Genuine Published Articles Looped) -->
  <section class="slider-section" aria-label="लोकप्रिय एवं उपयोगी लेख">
    <div class="container" style="margin-bottom:1rem; display:flex; justify-content:space-between; align-items:flex-end;">
      <div>
        <span style="font-size:0.8rem; font-weight:700; color:#FF7000; text-transform:uppercase; letter-spacing:0.05em;">महत्वपूर्ण धार्मिक लेख</span>
        <h2 style="font-size:1.45rem; font-weight:800; color:#0A1629; margin-top:0.25rem;">लोकप्रिय एवं उपयोगी मार्गदर्शन</h2>
      </div>
      <span style="font-size:0.82rem; color:#64748B; display:none;" class="slider-hint">रोकने के लिए कर्सर ले जाएं</span>
    </div>

    <div id="slider-track" class="slider-track">
{slider_block}
    </div>
  </section>

  <!-- 30 Genuine Published Articles Grid with Category Filtering & Pagination -->
  <section id="articles-section" class="container" style="margin-top:3.5rem;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:1rem; margin-bottom:1.5rem;">
      <div>
        <span style="font-size:0.8rem; font-weight:700; color:#FF7000; text-transform:uppercase; letter-spacing:0.05em;">प्रमाणित अध्ययन</span>
        <h2 style="font-size:1.65rem; font-weight:800; color:#0A1629; margin-top:0.25rem;">नवीनतम प्रकाशित लेख</h2>
      </div>
      <div style="font-size:0.88rem; color:#64748B;">
        कुल <strong style="color:#0A1629;">30</strong> प्रामाणिक धार्मिक लेख
      </div>
    </div>

    <!-- Category Filter Bar (Real Categories) -->
    <div class="category-filter-bar" role="tablist" aria-label="श्रेणी फिल्टर">
      <button class="category-filter-btn active" onclick="window.setCategory('all', this)" role="tab" aria-selected="true">सभी (All)</button>
      <button class="category-filter-btn" onclick="window.setCategory('vrat-tyohar', this)" role="tab" aria-selected="false">व्रत और त्योहार</button>
      <button class="category-filter-btn" onclick="window.setCategory('shubh-muhurat-guide', this)" role="tab" aria-selected="false">शुभ मुहूर्त</button>
      <button class="category-filter-btn" onclick="window.setCategory('puja-vidhi-samagri', this)" role="tab" aria-selected="false">पूजा विधि और सामग्री</button>
      <button class="category-filter-btn" onclick="window.setCategory('vedic-panchang', this)" role="tab" aria-selected="false">वैदिक पंचांग</button>
    </div>

    <!-- Dynamic 30 Articles Grid -->
    <div id="articles-grid" class="articles-grid">
{grid_block}
    </div>

    <!-- Numbered Pagination -->
    <div id="pagination-wrap" class="pagination-wrap" style="margin-top:2.5rem; display:flex; justify-content:center; align-items:center; gap:0.5rem;">
      <!-- Populated by main.js with 1, 2, 3... Prev, Next -->
    </div>
  </section>

  <!-- Editorial Integrity & Educational Value Section -->
  <section class="container" style="margin-top:4.5rem; margin-bottom:2rem;">
    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:20px; padding:2.5rem 2rem;">
      <div style="max-width:850px; margin:0 auto; text-align:center;">
        <span style="background:#FFF; border:1px solid #CBD5E1; color:#0A1629; font-size:11px; font-weight:700; text-transform:uppercase; padding:4px 12px; border-radius:9999px;">
          संपादकीय प्रामाणिकता एवं उद्देश्य
        </span>
        <h3 style="font-size:1.45rem; font-weight:800; color:#0A1629; margin-top:1rem; margin-bottom:0.75rem;">
          सनातन संस्कृति, पंचांग एवं धार्मिक परंपराओं का सरल मार्गदर्शन
        </h3>
        <p style="font-size:0.95rem; color:#475569; line-height:1.75; margin-bottom:1.5rem;">
          Choghadiyas.in का मुख्य ध्येय सनातन धर्म के दैनिक नियमों, पंचांग के 5 अंगों (तिथि, वार, नक्षत्र, योग, करण), शुभ-अशुभ मुहूर्त और पूजा-पाठ की शास्त्रीय पद्धतियों को आधुनिक संदर्भ में सरलता से समझाना है। हमारे सभी लेख धर्मग्रंथों, प्रामाणिक पंचांगों और पारंपरिक गणनाओं के अध्ययन पर आधारित हैं।
        </p>
        <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:1.5rem; font-size:0.88rem; color:#64748B;">
          <div style="display:flex; align-items:center; gap:0.4rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>मूल एवं प्रामाणिक सामग्री</span>
          </div>
          <div style="display:flex; align-items:center; gap:0.4rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>पारदर्शी संपादकीय नीति</span>
          </div>
          <div style="display:flex; align-items:center; gap:0.4rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>नियमित तथ्य-सत्यापन</span>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Shared Site Footer -->
<?php require_once __DIR__ . '/../includes/footer_responsive.php'; ?>

<!-- Client-side Application Scripts -->
<script src="/assets/js/articles-manifest.js"></script>
<script src="/assets/js/main.js"></script>
'''

with open('public/hostinger-deployment/templates/home.php', 'w', encoding='utf-8') as f:
    f.write(home_php_template)

print('Built pristine templates/home.php successfully!')
