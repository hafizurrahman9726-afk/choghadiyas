<?php
/**
 * Choghadiyas.in — Premium Editorial Homepage
 * Clean White Background, Top Image Slider, 30 Articles Grid & 7 FAQ Accordion
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
       1. HERO SECTION (Immediately Below Header - Prompt Adda Style)
       Centered Composition, White Background, Single Homepage H1
       ============================================================ -->
  <section class="hero-section" aria-label="मुख्य परिचय एवं खोज">
    <div class="container">
      <div class="hero-content">
        <!-- Small label badge -->
        <div class="hero-badge">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/>
          </svg>
          <span>धार्मिक एवं वैदिक पंचांग मार्गदर्शिका</span>
        </div>

        <!-- Main H1 (Single H1 on Homepage) -->
        <h1 class="hero-title">
          चौघड़िया, पंचांग, व्रत-त्योहार और <span class="hero-title-accent">पूजा विधि</span> की जानकारी
        </h1>

        <!-- Description -->
        <p class="hero-subtitle">
          Choghadiyas.in पर जानें चौघड़िया और पंचांग से जुड़ी जानकारी, व्रत-त्योहारों की तिथियाँ, शुभ मुहूर्त, पूजा विधियाँ और आवश्यक सामग्री। हमारे लेख धार्मिक परंपराओं और उपयोगी जानकारियों को सरल हिंदी में समझाते हैं।
        </p>

        <!-- Prominent Rounded Search Bar with real search functionality -->
        <div class="search-bar-wrap">
          <form action="<?php echo $base_url; ?>/search" method="GET" class="search-bar-form" role="search" aria-label="वेबसाइट पर खोजें">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:0.6rem; flex-shrink:0;" aria-hidden="true">
              <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
            </svg>
            <input 
              type="text" 
              name="q" 
              class="search-bar-input" 
              placeholder="लेख, व्रत या पूजा विधि खोजें..." 
              required
              aria-label="खोजें"
              autocomplete="off"
            >
            <button type="submit" class="search-submit-btn" aria-label="खोज शुरू करें">
              Search →
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       2. TOP AUTOMATIC IMAGE SLIDER (Placed Immediately Below Hero)
       Continuous Smooth Horizontal Marquee (Matching Prompt Adda Reference)
       ============================================================ -->
  <section class="top-slider-section" aria-label="प्रमुख एवं उपयोगी लेख">
    <div class="slider-outer-container">
      <div id="slider-track" class="slider-track">
        <?php
        $slider_articles = array_slice($latest_articles, 0, 12);
        // Fallback to real published articles if database query is empty
        if (empty($slider_articles)) {
            $slider_articles = [
                ['slug' => 'chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri', 'title' => 'Chhath Puja Samagri List छठ पूजा सामग्री सूची', 'category_name' => 'पूजा विधि', 'featured_image' => '/uploads/posts/6ad5a0d5c188a.webp'],
                ['slug' => 'kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi', 'title' => 'कलश स्थापना के नियम, सामग्री व दिशा', 'category_name' => 'पूजा विधि', 'featured_image' => '/uploads/posts/6ad5a0288b12e.webp'],
                ['slug' => 'panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam', 'title' => 'पंचोपचार पूजा विधि एवं दैनिक नियम', 'category_name' => 'पूजा विधि', 'featured_image' => '/uploads/posts/6ad59c1acd917.webp'],
                ['slug' => 'rudrabhishek-puja-vidhi-at-home', 'title' => 'घर पर रुद्राभिषेक विधि व नियम', 'category_name' => 'पूजा विधि', 'featured_image' => '/uploads/posts/6ab88baf91bf1.webp'],
                ['slug' => 'sutak-kaal-niyam-aur-samay', 'title' => 'सूतक काल क्या है? ग्रहण व नियम', 'category_name' => 'वैदिक पंचांग', 'featured_image' => '/uploads/posts/6ab88e257077e.webp'],
                ['slug' => 'panchang-ke-five-ang-kya-hain', 'title' => 'पंचांग के 5 अंग क्या हैं? सरल गाइड', 'category_name' => 'वैदिक पंचांग', 'featured_image' => '/uploads/posts/6ab890d671730.webp'],
                ['slug' => 'sankashti-chaturthi-vrat-vidhi', 'title' => 'संकष्टी चतुर्थी व्रत कैसे रखें? कथा व पारण', 'category_name' => 'व्रत-त्योहार', 'featured_image' => '/uploads/posts/6ab893bf1b861.webp'],
                ['slug' => 'satyanarayan-katha-puja-samagri-list', 'title' => 'सत्यनारायण पूजा सामग्री सूची व विधि', 'category_name' => 'पूजा विधि', 'featured_image' => '/uploads/posts/6ab887d42e8c0.webp']
            ];
        }

        // Loop twice to create an infinite, seamless, 0-jump CSS loop
        $item_index = 0;
        for ($loop = 0; $loop < 2; $loop++):
          foreach ($slider_articles as $art):
            $item_index++;
            $art_slug = htmlspecialchars($art['slug'] ?? 'post');
            $art_raw_title = html_entity_decode((string)($art['title'] ?? ''), ENT_QUOTES, 'UTF-8');
            $art_title = htmlspecialchars($art_raw_title, ENT_QUOTES, 'UTF-8');
            $art_cat = htmlspecialchars($art['category_name'] ?? 'धार्मिक लेख');
            $art_img = htmlspecialchars($art['featured_image'] ?? '/uploads/posts/6ad5a0d5c188a.webp');
            $is_lcp_candidate = ($loop === 0 && $item_index <= 3);
        ?>
        <a href="<?php echo $base_url . '/' . $art_slug; ?>" class="slider-portrait-card" aria-label="<?php echo $art_title; ?>" <?php echo ($loop === 1) ? 'aria-hidden="true"' : ''; ?>>
          <div class="slider-portrait-media">
            <img 
              src="<?php echo $art_img; ?>" 
              alt="<?php echo $art_title; ?>" 
              class="slider-portrait-img" 
              width="185" 
              height="265"
              <?php if ($is_lcp_candidate): ?>
              fetchpriority="high"
              <?php else: ?>
              loading="lazy" 
              decoding="async"
              <?php endif; ?>
            >
            <div class="slider-portrait-overlay">
              <span class="slider-portrait-tag"><?php echo $art_cat; ?></span>
              <h3 class="slider-portrait-title"><?php echo $art_title; ?></h3>
            </div>
          </div>
        </a>
        <?php endforeach; endfor; ?>
      </div>
    </div>
  </section>

  <!-- ============================================================
       2. LATEST 30 ARTICLES GRID
       ============================================================ -->
  <section id="articles-section" class="articles-section">
    <div class="container">
      <div class="section-header-wrap">
        <div>
          <span class="section-eyebrow">प्रामाणिक अध्ययन</span>
          <h2 class="section-heading">नवीनतम प्रकाशित लेख</h2>
        </div>
        <div style="font-size:0.88rem; color:var(--text-muted);">
          कुल <strong><?php echo count($latest_articles); ?></strong> प्रामाणिक धार्मिक लेख
        </div>
      </div>

      <!-- Category Filter Bar -->
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
       3. EDITORIAL INTEGRITY & VEDIC INFO SECTION
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
       4. PREMIUM 7-QUESTION FAQ ACCORDION SECTION
       Completely Redesigned with 7 Full Answers, No Grey Highlight & Smooth Toggle
       ============================================================ -->
  <section class="faq-section" aria-label="अक्सर पूछे जाने वाले प्रश्न">
    <div class="container">
      <div style="text-align:center; max-width:720px; margin:0 auto 2.25rem;">
        <span class="section-eyebrow">सहायक मार्गदर्शन</span>
        <h2 class="section-heading">चौघड़िया एवं पंचांग से जुड़े मुख्य प्रश्न</h2>
        <p style="font-size:0.95rem; color:var(--text-muted); margin-top:0.4rem;">
          मुहूर्त गणना, पंचांग देखने के नियम और दैनिक उपयोग से जुड़े महत्वपूर्ण प्रश्नों के प्रामाणिक उत्तर।
        </p>
      </div>

      <div class="faq-accordion-wrap">
        <!-- FAQ 1 -->
        <div class="faq-item active">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="true" aria-controls="faq-ans-1" id="faq-btn-1">
            <span class="faq-q-text">चौघड़िया क्या है और इसका क्या महत्व है?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-1" role="region" aria-labelledby="faq-btn-1" aria-hidden="false">
            <p>चौघड़िया हिंदू पंचांग में समय के विभाजन की एक पारंपरिक पद्धति है। इसमें दिन और रात को अलग-अलग आठ भागों में बाँटा जाता है। प्रत्येक भाग का संबंध शुभ, लाभ, अमृत, चर, रोग, काल या उद्वेग जैसे चौघड़िया से होता है। लोग परंपरागत मान्यताओं के अनुसार नए कार्यों की शुरुआत के लिए अनुकूल समय देखने में इसका उपयोग करते हैं।</p>
          </div>
        </div>

        <!-- FAQ 2 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-2" id="faq-btn-2">
            <span class="faq-q-text">दिन और रात के चौघड़िया में क्या अंतर होता है?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-2" role="region" aria-labelledby="faq-btn-2" aria-hidden="true">
            <p>दिन का चौघड़िया सामान्यतः सूर्योदय से सूर्यास्त तक और रात का चौघड़िया सूर्यास्त से अगले सूर्योदय तक निर्धारित किया जाता है। दोनों की गणना स्थानीय सूर्योदय और सूर्यास्त के समय पर निर्भर करती है। इसलिए अलग-अलग शहरों और मौसमों में चौघड़िया की अवधि बदल सकती है।</p>
          </div>
        </div>

        <!-- FAQ 3 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-3" id="faq-btn-3">
            <span class="faq-q-text">राहुकाल में कौन से कार्य नहीं करने चाहिए?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-3" role="region" aria-labelledby="faq-btn-3" aria-hidden="true">
            <p>पारंपरिक ज्योतिषीय मान्यताओं के अनुसार राहुकाल में विवाह, गृह प्रवेश, नया व्यवसाय शुरू करना और कुछ अन्य मांगलिक कार्य आरंभ करने से बचने की सलाह दी जाती है। हालांकि पहले से चल रहे आवश्यक या दैनिक कार्यों के संबंध में परंपराएँ अलग हो सकती हैं।</p>
          </div>
        </div>

        <!-- FAQ 4 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-4" id="faq-btn-4">
            <span class="faq-q-text">अभिजीत मुहूर्त का क्या महत्व है?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-4" role="region" aria-labelledby="faq-btn-4" aria-hidden="true">
            <p>अभिजीत मुहूर्त दिन के मध्य भाग के आसपास आने वाला एक पारंपरिक शुभ समय माना जाता है। कुछ धार्मिक परंपराओं में इसे महत्वपूर्ण कार्यों की शुरुआत के लिए अनुकूल माना जाता है। इसका सटीक समय स्थानीय सूर्योदय और सूर्यास्त तथा पंचांग गणना के अनुसार निर्धारित किया जाता है।</p>
          </div>
        </div>

        <!-- FAQ 5 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-5" id="faq-btn-5">
            <span class="faq-q-text">पंचांग के पाँच अंग कौन-कौन से हैं?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-5" role="region" aria-labelledby="faq-btn-5" aria-hidden="true">
            <p>हिंदू पंचांग के पाँच प्रमुख अंग तिथि, वार, नक्षत्र, योग और करण हैं। इनका उपयोग धार्मिक पर्वों, व्रतों और पारंपरिक मुहूर्त गणना में किया जाता है। पंचांग की जानकारी स्थान और गणना-पद्धति के अनुसार भिन्न हो सकती है।</p>
          </div>
        </div>

        <!-- FAQ 6 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-6" id="faq-btn-6">
            <span class="faq-q-text">व्रत और त्योहारों की सही तिथि कैसे पता करें?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-6" role="region" aria-labelledby="faq-btn-6" aria-hidden="true">
            <p>व्रत और त्योहारों की तिथि जानने के लिए संबंधित तिथि का आरंभ और समाप्ति समय, सूर्योदय, स्थानीय पंचांग तथा उस पर्व के विशेष नियम देखे जाते हैं। कुछ पर्वों में प्रदोषकाल, चंद्रोदय या अन्य निर्धारित समय का विशेष महत्व होता है।</p>
          </div>
        </div>

        <!-- FAQ 7 -->
        <div class="faq-item">
          <button type="button" class="faq-question" onclick="window.toggleFaq(this);" aria-expanded="false" aria-controls="faq-ans-7" id="faq-btn-7">
            <span class="faq-q-text">पूजा विधि और सामग्री की जानकारी कहाँ मिलेगी?</span>
            <span class="faq-icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" class="faq-icon-v"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
              </svg>
            </span>
          </button>
          <div class="faq-answer" id="faq-ans-7" role="region" aria-labelledby="faq-btn-7" aria-hidden="true">
            <p>Choghadiyas.in की पूजा विधि और सामग्री श्रेणी में विभिन्न धार्मिक अनुष्ठानों से संबंधित पूजा की सामान्य प्रक्रिया, आवश्यक सामग्री और पारंपरिक जानकारी पढ़ी जा सकती है। स्थानीय रीति-रिवाज और पारिवारिक परंपराएँ अलग हो सकती हैं।</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============================================================
       5. VERIFIED AUTHOR SECTION — लेखक के बारे में
       ============================================================ -->
  <section class="author-section" aria-label="लेखक के बारे में" id="author">
    <div class="container">
      <div class="section-header" style="text-align: center; margin-bottom: 2rem;">
        <span class="section-badge"><i class="fas fa-feather-alt"></i> प्रामाणिक मार्गदर्शन</span>
        <h2 class="section-title">लेखक के बारे में</h2>
        <div class="section-divider" style="margin: 0.5rem auto 0 auto;"></div>
      </div>
      <div class="author-card">
        <a href="/about" class="author-avatar-link" title="Shiv Kumar Pandit — लेखक परिचय" aria-label="Shiv Kumar Pandit का परिचय पढ़ें">
          <img src="https://choghadiyas.in/uploads/profiles/6a0a995eb34a7.webp" alt="Shiv Kumar Pandit" class="author-avatar" width="90" height="90" loading="lazy" decoding="async">
        </a>
        <div class="author-info">
          <div class="author-name-header">
            <h3><a href="/about" class="author-profile-link" title="लेखक प्रोफाइल देखें">Shiv Kumar Pandit</a></h3>
            <span class="author-verified-badge" title="सत्यापित लेखक">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="#0D9488" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
              <span>सत्यापित लेखक</span>
            </span>
          </div>
          <span class="author-role">संस्थापक एवं वरिष्ठ कंटेंट रिसर्चर (Co-Founder &amp; Senior Researcher)</span>
          <p class="author-bio">
            मैं, शिव कुमार पंडित, इस प्लेटफ़ॉर्म का Co-Founder और वरिष्ठ कंटेंट रिसर्चर हूं। मुझे भारतीय संस्कृति, शुभ मुहूर्त, चोघड़िया, पंचांग और पारंपरिक ज्ञान से जुड़े विषयों पर रिसर्च करना और सरल भाषा में जानकारी साझा करना पसंद है, ताकि हर पाठक आसानी से सही जानकारी समझ सके। हमारे सभी लेख शास्त्रीय पंचांगों और प्रामाणिक धर्मग्रंथों के अध्ययन पर आधारित हैं।
          </p>
          <div class="author-footer-actions">
            <a href="/about" class="author-read-more" title="लेखक का संपूर्ण परिचय पढ़ें">
              <span>लेखक का संपूर्ण परिचय पढ़ें</span>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
            <div class="author-socials">
              <a href="https://www.whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r" target="_blank" rel="noopener noreferrer" class="author-social-link" title="WhatsApp Channel" aria-label="WhatsApp Channel">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
              </a>
              <a href="https://www.youtube.com/@SKPANDITJIOFFICIAL" target="_blank" rel="noopener noreferrer" class="author-social-link" title="YouTube" aria-label="YouTube">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
              </a>
              <a href="https://www.instagram.com/shivkumarpandit8053/" target="_blank" rel="noopener noreferrer" class="author-social-link" title="Instagram" aria-label="Instagram">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
              </a>
              <a href="https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/" target="_blank" rel="noopener noreferrer" class="author-social-link" title="Facebook" aria-label="Facebook">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
              </a>
            </div>
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
<script defer src="<?php echo $js_base_url; ?>/assets/js/articles-manifest.js?v=20261106_v5"></script>
<script defer src="<?php echo $js_base_url; ?>/assets/js/main.js?v=20261106_v5"></script>
