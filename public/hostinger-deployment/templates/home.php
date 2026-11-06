<?php
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
        <div class="slider-card" onclick="window.location.href='/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri';" role="button" tabindex="0" aria-label="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची">
          <img src="/uploads/posts/6ad5a0d5c188a.webp" alt="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची" fetchpriority="high" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi';" role="button" tabindex="0" aria-label="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि">
          <img src="/uploads/posts/6ad5a0288b12e.webp" alt="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam';" role="button" tabindex="0" aria-label="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम">
          <img src="/uploads/posts/6ad59c1acd917.webp" alt="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/rudrabhishek-puja-vidhi-at-home';" role="button" tabindex="0" aria-label="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम">
          <img src="/uploads/posts/6ab88baf91bf1.webp" alt="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/sutak-kaal-niyam-aur-samay';" role="button" tabindex="0" aria-label="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण">
          <img src="/uploads/posts/6ab88e257077e.webp" alt="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">वैदिक पंचांग</span>
            <h4 class="slider-title">सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/panchang-ke-five-ang-kya-hain';" role="button" tabindex="0" aria-label="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड">
          <img src="/uploads/posts/6ab890d671730.webp" alt="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">वैदिक पंचांग</span>
            <h4 class="slider-title">Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/sankashti-chaturthi-vrat-vidhi';" role="button" tabindex="0" aria-label="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका">
          <img src="/uploads/posts/6ab893bf1b861.webp" alt="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/satyanarayan-katha-puja-samagri-list';" role="button" tabindex="0" aria-label="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि">
          <img src="/uploads/posts/6ab887d42e8c0.webp" alt="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/kalashtami-vrat-vidhi-bhairav-puja-samay';" role="button" tabindex="0" aria-label="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां">
          <img src="/uploads/posts/6ab3e76f4793f.webp" alt="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/punwasi-hai-kya-purnima-ka-matlab-mahatva';" role="button" tabindex="0" aria-label="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व">
          <img src="/uploads/posts/6a9cdc9cbbcbb.webp" alt="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri';" role="button" tabindex="0" aria-label="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची" aria-hidden="true">
          <img src="/uploads/posts/6ad5a0d5c188a.webp" alt="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi';" role="button" tabindex="0" aria-label="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि" aria-hidden="true">
          <img src="/uploads/posts/6ad5a0288b12e.webp" alt="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam';" role="button" tabindex="0" aria-label="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम" aria-hidden="true">
          <img src="/uploads/posts/6ad59c1acd917.webp" alt="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/rudrabhishek-puja-vidhi-at-home';" role="button" tabindex="0" aria-label="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम" aria-hidden="true">
          <img src="/uploads/posts/6ab88baf91bf1.webp" alt="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/sutak-kaal-niyam-aur-samay';" role="button" tabindex="0" aria-label="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण" aria-hidden="true">
          <img src="/uploads/posts/6ab88e257077e.webp" alt="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">वैदिक पंचांग</span>
            <h4 class="slider-title">सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/panchang-ke-five-ang-kya-hain';" role="button" tabindex="0" aria-label="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड" aria-hidden="true">
          <img src="/uploads/posts/6ab890d671730.webp" alt="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">वैदिक पंचांग</span>
            <h4 class="slider-title">Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/sankashti-chaturthi-vrat-vidhi';" role="button" tabindex="0" aria-label="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका" aria-hidden="true">
          <img src="/uploads/posts/6ab893bf1b861.webp" alt="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/satyanarayan-katha-puja-samagri-list';" role="button" tabindex="0" aria-label="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि" aria-hidden="true">
          <img src="/uploads/posts/6ab887d42e8c0.webp" alt="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">पूजा विधि और सामग्री</span>
            <h4 class="slider-title">Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/kalashtami-vrat-vidhi-bhairav-puja-samay';" role="button" tabindex="0" aria-label="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां" aria-hidden="true">
          <img src="/uploads/posts/6ab3e76f4793f.webp" alt="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां</h4>
          </div>
        </div>
        <div class="slider-card" onclick="window.location.href='/punwasi-hai-kya-purnima-ka-matlab-mahatva';" role="button" tabindex="0" aria-label="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व" aria-hidden="true">
          <img src="/uploads/posts/6a9cdc9cbbcbb.webp" alt="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व" loading="lazy" decoding="async" width="280" height="360">
          <div class="slider-overlay">
            <span class="slider-tag">व्रत और त्योहार</span>
            <h4 class="slider-title">Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व</h4>
          </div>
        </div>
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
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri" class="article-thumb-link" aria-label="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची">
          <img src="/uploads/posts/6ad5a0d5c188a.webp" alt="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri">Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची</a>
          </h3>
          <p class="article-excerpt">छठ पूजा सामग्री की पूरी सूची जानें। छठी मैया के प्रसाद, सूप, फल, ठेकुआ, पूजा सामग्री और सूर्य देव को अर्घ्य देने के लिए जरूरी सामान की जानका...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri" class="read-more-link" aria-label="Chhath Puja Samagri List छठ पूजा के प्रसाद, सूप और जरूरी सामग्री की सूची पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi" class="article-thumb-link" aria-label="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि">
          <img src="/uploads/posts/6ad5a0288b12e.webp" alt="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi">कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि</a>
          </h3>
          <p class="article-excerpt">पूजा में कलश स्थापना के पारंपरिक नियम, तांबे या मिट्टी के कलश का चयन, आवश्यक सामग्री, नारियल रखने की सही दिशा, वरुण आवाहन मंत्र और विसर्जन क...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi" class="read-more-link" aria-label="कलश स्थापना के नियम (Kalash Sthapana Ke Niyam) सामग्री, नारियल की दिशा, मंत्र और विधि पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam" class="article-thumb-link" aria-label="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम">
          <img src="/uploads/posts/6ad59c1acd917.webp" alt="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam">पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम</a>
          </h3>
          <p class="article-excerpt">घर पर दैनिक पूजा के लिए पंचोपचार पूजा विधि (गंध, पुष्प, धूप, दीप, नैवेद्य) का क्रम, सरल नाम-मंत्र, बीज-मंत्र, पंचमहाभूत संबंध और देव-अनुसार ...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/panchopachar-puja-vidhi-5-upchar-mantra-dainik-pujan-niyam" class="read-more-link" aria-label="पंचोपचार पूजा विधि (Panchopachar Puja Vidhi) 5 उपचार, मंत्र और दैनिक पूजन नियम पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/rudrabhishek-puja-vidhi-at-home" class="article-thumb-link" aria-label="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम">
          <img src="/uploads/posts/6ab88baf91bf1.webp" alt="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/rudrabhishek-puja-vidhi-at-home">Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम</a>
          </h3>
          <p class="article-excerpt">घर पर रुद्राभिषेक विधि व नियम की सरल गाइड। सामग्री, शुभ समय, मंत्र, सावधानियां और अक्सर पूछे जाने वाले सवालों के साथ पूरी और भरोसेमंद जानकार...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/rudrabhishek-puja-vidhi-at-home" class="read-more-link" aria-label="Rudrabhishek Puja Vidhi at Home घर पर रुद्राभिषेक विधि व नियम पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vedic-panchang">
        <a href="/sutak-kaal-niyam-aur-samay" class="article-thumb-link" aria-label="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण">
          <img src="/uploads/posts/6ab88e257077e.webp" alt="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">वैदिक पंचांग</span>
          <h3 class="article-title">
            <a href="/sutak-kaal-niyam-aur-samay">सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण</a>
          </h3>
          <p class="article-excerpt">सूर्य और चंद्र ग्रहण में सूतक कितने घंटे पहले लगता है, ग्रहण न दिखे तो क्या होता है, जन्म-मृत्यु के अशौच की अवधि और विज्ञान क्या कहता है? सर...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/sutak-kaal-niyam-aur-samay" class="read-more-link" aria-label="सूतक काल क्या है? ग्रहण और जन्म-मृत्यु में नियम, समय और वैज्ञानिक दृष्टिकोण पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vedic-panchang">
        <a href="/panchang-ke-five-ang-kya-hain" class="article-thumb-link" aria-label="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड">
          <img src="/uploads/posts/6ab890d671730.webp" alt="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">वैदिक पंचांग</span>
          <h3 class="article-title">
            <a href="/panchang-ke-five-ang-kya-hain">Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड</a>
          </h3>
          <p class="article-excerpt">पंचांग के 5 अंग—तिथि, वार, नक्षत्र, योग और करण—कैसे तय होते हैं और पूजा-मुहूर्त में इनका क्या महत्व है, यह सरल हिंदी गाइड उदाहरण व तालिका सह...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/panchang-ke-five-ang-kya-hain" class="read-more-link" aria-label="Panchang Ke 5 Ang Kya Hain? तिथि, वार, नक्षत्र, योग और करण को समझने की सरल गाइड पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vrat-tyohar">
        <a href="/sankashti-chaturthi-vrat-vidhi" class="article-thumb-link" aria-label="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका">
          <img src="/uploads/posts/6ab893bf1b861.webp" alt="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">व्रत और त्योहार</span>
          <h3 class="article-title">
            <a href="/sankashti-chaturthi-vrat-vidhi">Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका</a>
          </h3>
          <p class="article-excerpt">संकष्टी चतुर्थी व्रत विधि, चंद्रोदय समय, कथा और पारण का सही तरीका आसान हिंदी में जानें। स्टेप-बाय-स्टेप गाइड पढ़ें, सही समय चुनें और व्रत सह...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/sankashti-chaturthi-vrat-vidhi" class="read-more-link" aria-label="Sankashti Chaturthi Vrat Vidhi संकष्टी चतुर्थी व्रत कैसे रखें? चंद्रोदय समय, कथा और पारण का सही तरीका पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/satyanarayan-katha-puja-samagri-list" class="article-thumb-link" aria-label="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि">
          <img src="/uploads/posts/6ab887d42e8c0.webp" alt="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/satyanarayan-katha-puja-samagri-list">Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि</a>
          </h3>
          <p class="article-excerpt">सत्यनारायण कथा पूजा की सम्पूर्ण सामग्री सूची, सही मात्रा, घर पर सरल विधि और प्रसाद बनाने का तरीका एक ही जगह। पूजा शुरू करने से पहले पूरी लिस...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/satyanarayan-katha-puja-samagri-list" class="read-more-link" aria-label="Satyanarayan Katha Puja Samagri List सत्यनारायण पूजा की सम्पूर्ण सामग्री सूची और घर पर सरल विधि पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vrat-tyohar">
        <a href="/kalashtami-vrat-vidhi-bhairav-puja-samay" class="article-thumb-link" aria-label="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां">
          <img src="/uploads/posts/6ab3e76f4793f.webp" alt="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">व्रत और त्योहार</span>
          <h3 class="article-title">
            <a href="/kalashtami-vrat-vidhi-bhairav-puja-samay">Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां</a>
          </h3>
          <p class="article-excerpt">कालाष्टमी व्रत की सही विधि, भैरव पूजा का शुभ समय, जरूरी सामग्री और सावधानियां जानें। तारीख, पारण विधि और FAQ के साथ पूरी व्यावहारिक गाइड पढ़...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/kalashtami-vrat-vidhi-bhairav-puja-samay" class="read-more-link" aria-label="Kalashtami Vrat Ka Mahatva Aur Vidhi कालाष्टमी व्रत के नियम, भैरव पूजा समय और ध्यान रखने योग्य सावधानियां पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vrat-tyohar">
        <a href="/punwasi-hai-kya-purnima-ka-matlab-mahatva" class="article-thumb-link" aria-label="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व">
          <img src="/uploads/posts/6a9cdc9cbbcbb.webp" alt="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">व्रत और त्योहार</span>
          <h3 class="article-title">
            <a href="/punwasi-hai-kya-purnima-ka-matlab-mahatva">Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व</a>
          </h3>
          <p class="article-excerpt">पूनवासी या पूर्णिमा क्या है, तिथि कैसे तय होती है और व्रत की तारीख़ दो दिन क्यों दिखती है? 2026 की पूर्णिमा तिथियाँ और परंपराएँ सरल हिंदी मे...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/punwasi-hai-kya-purnima-ka-matlab-mahatva" class="read-more-link" aria-label="Punwasi Hai Kya? पूर्णिमा का मतलब और महत्व पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="vrat-tyohar">
        <a href="/ahoi-ashtami-kab-hai" class="article-thumb-link" aria-label="Ahoi Ashtami Kab Hai? तिथि, मुहूर्त और विधि">
          <img src="/uploads/posts/6a9eb0a05c162.webp" alt="Ahoi Ashtami Kab Hai? तिथि, मुहूर्त और विधि" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">व्रत और त्योहार</span>
          <h3 class="article-title">
            <a href="/ahoi-ashtami-kab-hai">Ahoi Ashtami Kab Hai? तिथि, मुहूर्त और विधि</a>
          </h3>
          <p class="article-excerpt">Ahoi Ashtami कब है 2026 में? सही तिथि, पूजा मुहूर्त, व्रत विधि, सामग्री लिस्ट और तारे-चांद वाली उलझन का सीधा जवाब — पूरी और भरोसेमंद जानकारी...</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/ahoi-ashtami-kab-hai" class="read-more-link" aria-label="Ahoi Ashtami Kab Hai? तिथि, मुहूर्त और विधि पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
      <article class="article-card" data-category="puja-vidhi-samagri">
        <a href="/ganesh-visarjan-kab-hai" class="article-thumb-link" aria-label="Ganesh Visarjan Kab Hai? 2026 की तारीख़ें, विधि और शुभ समय">
          <img src="/uploads/posts/6a9eaad70fd6a.webp" alt="Ganesh Visarjan Kab Hai? 2026 की तारीख़ें, विधि और शुभ समय" class="article-thumb" loading="lazy" decoding="async" width="400" height="225">
        </a>
        <div class="article-body">
          <span class="category-badge">पूजा विधि और सामग्री</span>
          <h3 class="article-title">
            <a href="/ganesh-visarjan-kab-hai">Ganesh Visarjan Kab Hai? 2026 की तारीख़ें, विधि और शुभ समय</a>
          </h3>
          <p class="article-excerpt">गणेश विसर्जन कब किया जाता है, अनंत चतुर्दशी की तिथि क्या थी और चौघड़िया से समय कैसे चुनें? 2026 की तारीख़ों के साथ सरल विसर्जन विधि।</p>
          <div class="article-footer">
            <span class="article-meta">Shiv Kumar Pandit · Nov 5, 2026</span>
            <a href="/ganesh-visarjan-kab-hai" class="read-more-link" aria-label="Ganesh Visarjan Kab Hai? 2026 की तारीख़ें, विधि और शुभ समय पढ़ें">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>
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
