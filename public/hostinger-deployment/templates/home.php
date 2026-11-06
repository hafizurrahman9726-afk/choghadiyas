<?php
/**
 * Choghadiyas.in — Ultra-Premium Editorial Production Homepage
 * Clean White Background, Deep Navy Typography, Saffron Highlights
 * Fully Responsive (Desktop 1920/1440px, Tablet 768px, Mobile 375/390px)
 */

$page_title = "चौघड़िया, पंचांग, व्रत-त्योहार और पूजा विधि की जानकारी - Choghadiyas.in";
$page_description = "Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री।";
$canonical_url = "https://choghadiyas.in/";
$base_url = defined('SITE_URL') ? rtrim(SITE_URL, '/') : '';

// Include Unified Site Header
require_once __DIR__ . '/../includes/header_responsive.php';

// Fetch the latest 30 published articles directly from MySQL database
$latest_articles = [];
try {
    $latest_articles = db_fetch_all("
        SELECT p.id, p.title, p.slug, p.excerpt, p.featured_image, p.publish_date,
               c.name as category_name, c.slug as category_slug,
               COALESCE(u.full_name, 'Shiv Kumar Pandit') as author_name
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN users u ON p.author_id = u.id
        WHERE p.status = 'published'
        ORDER BY p.publish_date DESC
        LIMIT 30
    ") ?: [];
} catch (Exception $e) {
    $latest_articles = [];
}
?>

<main id="main-content" class="homepage-main">

  <!-- ============================================================
       1. HERO SECTION (Spacious, Centered, Clean White Background)
       ============================================================ -->
  <section class="hero-section" aria-label="मुख्य विवरण">
    <div class="container hero-content">
      <div class="hero-badge">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="5"></circle>
          <line x1="12" y1="1" x2="12" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="23"></line>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
          <line x1="1" y1="12" x2="3" y2="12"></line>
          <line x1="21" y1="12" x2="23" y2="12"></line>
        </svg>
        <span>धार्मिक एवं वैदिक पंचांग मार्गदर्शिका</span>
      </div>

      <h1 class="hero-title">
        चौघड़िया, पंचांग, व्रत-त्योहार
        <span class="hero-title-accent">और पूजा विधि की जानकारी</span>
      </h1>

      <p class="hero-subtitle">
        Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री। हमारे लेख धार्मिक परंपराओं और उपयोगी जानकारियों को सरल हिंदी में समझाते हैं।
      </p>

      <!-- Prominent Search Bar (Matching Screenshot 1 & 3) -->
      <div class="search-bar-wrap">
        <form action="<?php echo $base_url; ?>/search" method="GET" class="search-bar-form" role="search" aria-label="लेख खोजें" onsubmit="window.handleSearchSubmit(event);">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF7000" stroke-width="2.5" style="margin-right:0.6rem; flex-shrink:0;" aria-hidden="true">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
          <label for="main-search-input" class="sr-only" style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">लेख, व्रत या पूजा विधि खोजें</label>
          <input 
            type="text" 
            name="q" 
            id="main-search-input" 
            class="search-bar-input" 
            placeholder="लेख, व्रत या पूजा विधि खोजें (उदा. छठ पूजा, कलश स्थापना)..."
            aria-label="लेख, व्रत या पूजा विधि खोजें"
            autocomplete="off"
            oninput="document.getElementById('searchClearBtn').style.display = this.value ? 'block' : 'none';"
          >
          <button type="button" id="searchClearBtn" class="search-clear-btn" onclick="document.getElementById('main-search-input').value=''; this.style.display='none'; document.getElementById('main-search-input').focus();" aria-label="सर्च साफ़ करें" style="display:none;">×</button>
          <button type="submit" class="search-submit-btn" aria-label="खोजें">
            Search →
          </button>
        </form>
      </div>

      <!-- ============================================================
           2. FOUR CATEGORY DISCOVERY CARDS (Requirement 8)
           ============================================================ -->
      <div class="category-discovery-grid">
        <a href="<?php echo $base_url; ?>/category/vrat-tyohar" class="category-discovery-card">
          <div class="category-card-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
              <line x1="16" y1="2" x2="16" y2="6"></line>
              <line x1="8" y1="2" x2="8" y2="6"></line>
              <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
          </div>
          <div>
            <h3 class="category-card-title">व्रत और त्योहार</h3>
            <p class="category-card-desc">एकादशी, प्रदोष, चतुर्थी व प्रमुख हिंदू पर्वों की प्रामाणिक तिथियां व व्रत नियम।</p>
          </div>
          <span class="category-card-action">श्रेणी देखें →</span>
        </a>

        <a href="<?php echo $base_url; ?>/category/shubh-muhurat-guide" class="category-discovery-card">
          <div class="category-card-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="10"></circle>
              <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
          </div>
          <div>
            <h3 class="category-card-title">शुभ मुहूर्त</h3>
            <p class="category-card-desc">विवाह, गृह प्रवेश, मुंडन व नवीन कार्य आरंभ हेतु सर्वश्रेष्ठ काल-गणना।</p>
          </div>
          <span class="category-card-action">श्रेणी देखें →</span>
        </a>

        <a href="<?php echo $base_url; ?>/category/puja-vidhi-samagri" class="category-discovery-card">
          <div class="category-card-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
          </div>
          <div>
            <h3 class="category-card-title">पूजा विधि और सामग्री</h3>
            <p class="category-card-desc">सत्यनारायण कथा, रुद्राभिषेक, दैनिक पूजन व सम्पूर्ण सामग्री सूची।</p>
          </div>
          <span class="category-card-action">श्रेणी देखें →</span>
        </a>

        <a href="<?php echo $base_url; ?>/category/vedic-panchang" class="category-discovery-card">
          <div class="category-card-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2"></path><path d="M12 20v2"></path>
              <path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path>
              <path d="M2 12h2"></path><path d="M20 12h2"></path>
            </svg>
          </div>
          <div>
            <h3 class="category-card-title">वैदिक पंचांग</h3>
            <p class="category-card-desc">तिथि, वार, नक्षत्र, योग, करण एवं राहुकाल-अभिजित मुहूर्त की सरल व्याख्या।</p>
          </div>
          <span class="category-card-action">श्रेणी देखें →</span>
        </a>
      </div>

    </div>
  </section>

  <!-- ============================================================
       3. AUTOMATIC ARTICLE SLIDER (Smooth Continuous Marquee)
       ============================================================ -->
  <section class="slider-section" aria-label="लोकप्रिय एवं उपयोगी लेख">
    <div class="container">
      <div class="section-header-wrap">
        <div>
          <span class="section-eyebrow">महत्वपूर्ण धार्मिक लेख</span>
          <h2 class="section-heading">लोकप्रिय एवं उपयोगी मार्गदर्शन</h2>
        </div>
        <div style="font-size:0.84rem; color:var(--text-muted);">
          स्वाइप या कर्सर ले जाकर रोकें
        </div>
      </div>
    </div>

    <!-- Infinite Continuous Marquee (10 Real Articles Duplicated Once for 0-jump Loop) -->
    <div class="slider-outer-wrap">
      <div id="slider-track" class="slider-track">
        <?php
        $slider_articles = array_slice($latest_articles, 0, 10);
        // If DB has fewer than 10, pad with sample real articles
        if (empty($slider_articles)) {
            $slider_articles = [
                ['slug' => 'chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri', 'title' => 'Chhath Puja Samagri List छठ पूजा सामग्री सूची', 'category_name' => 'पूजा विधि और सामग्री', 'featured_image' => '/uploads/posts/6ad5a0d5c188a.webp'],
                ['slug' => 'kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi', 'title' => 'कलश स्थापना के नियम, सामग्री व दिशा', 'category_name' => 'पूजा विधि और सामग्री', 'featured_image' => '/uploads/posts/6ad5a0288b12e.webp'],
                ['slug' => 'panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam', 'title' => 'पंचोपचार पूजा विधि एवं दैनिक नियम', 'category_name' => 'पूजा विधि और सामग्री', 'featured_image' => '/uploads/posts/6ad59c1acd917.webp']
            ];
        }
        // Repeat loop twice for smooth CSS marquee
        for ($loop = 0; $loop < 2; $loop++):
          foreach ($slider_articles as $art):
            $art_slug = htmlspecialchars($art['slug'] ?? 'chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri');
            $art_title = htmlspecialchars(html_entity_decode((string)($art['title'] ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8');
            $art_cat = htmlspecialchars($art['category_name'] ?? 'धार्मिक लेख');
            $art_img = htmlspecialchars($art['featured_image'] ?? '/uploads/posts/6ad5a0d5c188a.webp');
        ?>
        <a href="<?php echo $base_url . '/' . $art_slug; ?>" class="slider-card" aria-label="<?php echo $art_title; ?>" <?php echo ($loop === 1) ? 'aria-hidden="true"' : ''; ?>>
          <div class="slider-card-thumb-wrap">
            <img src="<?php echo $art_img; ?>" alt="<?php echo $art_title; ?>" class="slider-card-thumb" loading="lazy" decoding="async" width="270" height="190">
          </div>
          <div class="slider-card-body">
            <span class="slider-tag"><?php echo $art_cat; ?></span>
            <h4 class="slider-title"><?php echo $art_title; ?></h4>
          </div>
        </a>
        <?php endforeach; endfor; ?>
      </div>
    </div>
  </section>

  <!-- ============================================================
       4. LATEST 30 ARTICLES GRID (Requirement 6)
       ============================================================ -->
  <section id="articles-section" class="articles-section">
    <div class="container">
      <div class="section-header-wrap">
        <div>
          <span class="section-eyebrow">प्रमाणित अध्ययन</span>
          <h2 class="section-heading">नवीनतम प्रकाशित लेख</h2>
        </div>
        <div style="font-size:0.88rem; color:var(--text-muted);">
          कुल <strong><?php echo count($latest_articles); ?></strong> प्रामाणिक धार्मिक लेख
        </div>
      </div>

      <!-- Category Filter Bar (Matching Screenshot 2) -->
      <div class="category-filter-bar" role="tablist" aria-label="श्रेणी फिल्टर">
        <button class="category-filter-btn active" onclick="window.setCategory('all', this)" role="tab" aria-selected="true">सभी (All)</button>
        <button class="category-filter-btn" onclick="window.setCategory('vrat-tyohar', this)" role="tab" aria-selected="false">व्रत और त्योहार</button>
        <button class="category-filter-btn" onclick="window.setCategory('shubh-muhurat-guide', this)" role="tab" aria-selected="false">शुभ मुहूर्त</button>
        <button class="category-filter-btn" onclick="window.setCategory('puja-vidhi-samagri', this)" role="tab" aria-selected="false">पूजा विधि और सामग्री</button>
        <button class="category-filter-btn" onclick="window.setCategory('vedic-panchang', this)" role="tab" aria-selected="false">वैदिक पंचांग</button>
      </div>

      <!-- 30 Articles Grid (Desktop: 3 cols, Tablet: 2 cols, Mobile: 1 col) -->
      <div id="articles-grid" class="articles-grid">
        <?php if (!empty($latest_articles)): ?>
          <?php foreach ($latest_articles as $art): 
            $art_slug = htmlspecialchars($art['slug'] ?? 'post');
            $art_raw_title = html_entity_decode((string)($art['title'] ?? ''), ENT_QUOTES, 'UTF-8');
            $art_title = htmlspecialchars($art_raw_title, ENT_QUOTES, 'UTF-8');
            $art_excerpt = strip_tags(html_entity_decode((string)($art['excerpt'] ?? ''), ENT_QUOTES, 'UTF-8'));
            $art_excerpt = mb_strlen($art_excerpt, 'UTF-8') > 130 ? mb_substr($art_excerpt, 0, 127, 'UTF-8') . '...' : $art_excerpt;
            $art_cat = htmlspecialchars($art['category_name'] ?? 'शुभ मुहूर्त');
            $art_cat_slug = htmlspecialchars($art['category_slug'] ?? 'shubh-muhurat-guide');
            $art_author = htmlspecialchars($art['author_name'] ?? 'Shiv Kumar Pandit');
            $art_date = !empty($art['publish_date']) ? date('M j, Y', strtotime($art['publish_date'])) : 'Nov 5, 2026';
            $art_img = htmlspecialchars($art['featured_image'] ?? '/uploads/posts/6ad5a0d5c188a.webp');
          ?>
          <article class="article-card" data-category="<?php echo $art_cat_slug; ?>">
            <a href="<?php echo $base_url . '/' . $art_slug; ?>" class="article-thumb-link" aria-label="<?php echo $art_title; ?>">
              <img src="<?php echo $art_img; ?>" alt="<?php echo $art_title; ?>" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
            </a>
            <div class="article-body">
              <span class="category-badge"><?php echo $art_cat; ?></span>
              <h3 class="article-title">
                <a href="<?php echo $base_url . '/' . $art_slug; ?>"><?php echo $art_title; ?></a>
              </h3>
              <p class="article-excerpt"><?php echo htmlspecialchars($art_excerpt, ENT_QUOTES, 'UTF-8'); ?></p>
              <div class="article-footer">
                <span class="article-meta"><?php echo $art_author; ?> · <?php echo $art_date; ?></span>
                <a href="<?php echo $base_url . '/' . $art_slug; ?>" class="read-more-link" aria-label="<?php echo $art_title; ?> पूरा पढ़ें">पूरा पढ़ें →</a>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Numbered Pagination Controls -->
      <div id="pagination-wrap" class="pagination-wrap"></div>
    </div>
  </section>

  <!-- ============================================================
       5. EDITORIAL INTEGRITY & VEDIC INFO SECTION (Requirement 8)
       ============================================================ -->
  <section class="info-section">
    <div class="container">
      <div class="info-box">
        <div style="max-width:860px; margin:0 auto; text-align:center;">
          <span style="display:inline-block; font-size:0.75rem; font-weight:800; color:var(--accent-saffron); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.75rem;">
            सनातन धर्म एवं काल-गणना
          </span>
          <h2 style="font-size:1.65rem; font-weight:800; color:var(--primary-navy); margin-bottom:1rem; line-height:1.35;">
            वैदिक पंचांग एवं चौघड़िया मुहूर्त का शास्त्रीय महत्व
          </h2>
          <p style="font-size:0.95rem; color:var(--text-muted); line-height:1.8; margin-bottom:2rem;">
            वैदिक ज्योतिष में काल को ऊर्जा का स्वरूप माना गया है। किसी भी शुभ कार्य, पूजा-अनुष्ठान, यात्रा या व्यापार का आरंभ उपयुक्त मुहूर्त में करने से सफलता और सकारात्मकता की संभावना बढ़ जाती है। Choghadiyas.in पर हम पारंपरिक पंचांगों के गणितीय नियमों को आधुनिक पाठकों के लिए स्पष्ट रूप में प्रस्तुत करते हैं।
          </p>
          <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:1.25rem; text-align:left;">
            <div style="background:var(--bg-soft); border:1px solid var(--border-card); padding:1.25rem; border-radius:14px;">
              <h4 style="font-size:1rem; font-weight:700; color:var(--primary-navy); margin-bottom:0.35rem;">पंचांग के ५ अंग</h4>
              <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.6;">तिथि, वार, नक्षत्र, योग और करण — इन पांच घटकों से दैनिक पंचांग का निर्माण होता है।</p>
            </div>
            <div style="background:var(--bg-soft); border:1px solid var(--border-card); padding:1.25rem; border-radius:14px;">
              <h4 style="font-size:1rem; font-weight:700; color:var(--primary-navy); margin-bottom:0.35rem;">चौघड़िया के ७ प्रकार</h4>
              <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.6;">अमृत, शुभ, लाभ (उत्तम); चर (सामान्य); रोग, काल, उद्वेग (वर्जित कालखंड)।</p>
            </div>
            <div style="background:var(--bg-soft); border:1px solid var(--border-card); padding:1.25rem; border-radius:14px;">
              <h4 style="font-size:1rem; font-weight:700; color:var(--primary-navy); margin-bottom:0.35rem;">राहुकाल व अभिजित</h4>
              <p style="font-size:0.85rem; color:var(--text-muted); line-height:1.6;">राहुकाल में शुभ कार्य वर्जित होते हैं, जबकि दोपहर का अभिजित मुहूर्त सर्वकार्य सिद्धिदायक माना जाता है।</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       6. FAQ ACCORDION SECTION (Requirement 8)
       ============================================================ -->
  <section class="faq-section" aria-label="अक्सर पूछे जाने वाले प्रश्न">
    <div class="container">
      <div style="text-align:center; max-width:700px; margin:0 auto 2.5rem;">
        <span class="section-eyebrow">सहायक मार्गदर्शन</span>
        <h2 class="section-heading">चौघड़िया एवं पंचांग से जुड़े मुख्य प्रश्न</h2>
        <p style="font-size:0.95rem; color:var(--text-muted); margin-top:0.5rem;">
          मुहूर्त गणना, पंचांग देखने के नियम और दैनिक उपयोग से जुड़े सामान्य प्रश्नों के प्रामाणिक उत्तर।
        </p>
      </div>

      <div class="faq-grid">
        <div class="faq-item">
          <button class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false">
            <span>चौघड़िया क्या है और इसका क्या महत्व है?</span>
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer">
            चौघड़िया वैदिक काल-गणना की एक प्राचीन और प्रामाणिक पद्धति है, जिसके अंतर्गत दिन और रात को लगभग 1.5-1.5 घंटे के 8-8 बराबर खंडों में बांटा जाता है। किसी भी शुभ कार्य, व्यापार आरंभ या यात्रा के लिए अमृत, शुभ और लाभ चौघड़िया सर्वश्रेष्ठ माना जाता है।
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false">
            <span>दिन और रात के चौघड़िया में क्या अंतर होता है?</span>
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer">
            दिन का चौघड़िया स्थानीय सूर्योदय से प्रारंभ होकर सूर्यास्त तक चलता है, जबकि रात का चौघड़िया सूर्यास्त से अगले दिन के सूर्योदय तक मान्य होता है। दोनों का स्वामी ग्रह और मुहूर्त क्रम सप्ताह के प्रत्येक वार के अनुसार भिन्न होता है।
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false">
            <span>राहुकाल में कौन से कार्य नहीं करने चाहिए?</span>
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer">
            वैदिक ज्योतिष के अनुसार राहुकाल प्रतिदिन लगभग 90 मिनट का होता है। इस कालखंड में कोई भी नया कार्य, गृह प्रवेश, महत्वपूर्ण अनुबंध पर हस्ताक्षर, खरीदारी अथवा मांगलिक कार्य प्रारंभ नहीं करना चाहिए।
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false">
            <span>अभिजित मुहूर्त का क्या महत्व है?</span>
            <span class="faq-icon">+</span>
          </button>
          <div class="faq-answer">
            अभिजित मुहूर्त प्रतिदिन दोपहर के समय लगभग 48 से 50 मिनट का होता है। यह भगवान विष्णु को समर्पित अत्यंत शुभ मुहूर्त है जिसमें अधिकांश मांगलिक कार्य बिना किसी बाधा के संपन्न किए जा सकते हैं (बुधवार को छोड़कर)।
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       7. VERIFIED AUTHOR SECTION (Requirement 8)
       ============================================================ -->
  <section class="author-section" aria-label="लेखक परिचय">
    <div class="container">
      <div class="author-card">
        <img src="/assets/images/shiv-kumar-pandit.jpg" onerror="this.src='/uploads/settings/6a096c91668a7.png';" alt="Shiv Kumar Pandit" class="author-avatar" width="90" height="90">
        <div class="author-info">
          <h3>Shiv Kumar Pandit</h3>
          <span class="author-role">Vedic Author &amp; Spiritual Content Researcher</span>
          <p class="author-bio">
            सनातन संस्कृति, पंचांग गणना, व्रत-त्योहारों के प्रामाणिक नियमों और पूजा सामग्री के विधिवत संकलन हेतु समर्पित शोधकर्ता। हमारे सभी लेख शास्त्रीय पंचांगों और प्रामाणिक धर्मग्रंथों के अध्ययन पर आधारित हैं।
          </p>
          <div class="author-socials">
            <a href="https://www.whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r" target="_blank" rel="noopener noreferrer" class="author-social-link" title="WhatsApp Channel" aria-label="WhatsApp Channel">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://www.youtube.com/@SKPANDITJIOFFICIAL" target="_blank" rel="noopener noreferrer" class="author-social-link" title="YouTube" aria-label="YouTube">
              <i class="fab fa-youtube"></i>
            </a>
            <a href="https://www.instagram.com/shivkumarpandit8053/" target="_blank" rel="noopener noreferrer" class="author-social-link" title="Instagram" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/" target="_blank" rel="noopener noreferrer" class="author-social-link" title="Facebook" aria-label="Facebook">
              <i class="fab fa-facebook"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Shared Site Footer -->
<?php require_once __DIR__ . '/../includes/footer_responsive.php'; ?>

<!-- Client-side Application Scripts -->
<?php $js_base_url = (defined('IS_STAGING_PREVIEW') && IS_STAGING_PREVIEW) ? '/staging-test' : ''; ?>
<script src="<?php echo $js_base_url; ?>/assets/js/articles-manifest.js?v=20261106_v3"></script>
<script src="<?php echo $js_base_url; ?>/assets/js/main.js?v=20261106_v3"></script>
