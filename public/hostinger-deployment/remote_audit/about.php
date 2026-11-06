<?php
/**
 * About Us Page
 * Choghadiyas.in
 */

require_once __DIR__ . '/../config/config.php';

/*
 * Page meta
 * Keep claims factual and easy to verify.
 */
$site_name = !empty($site_settings['name']) ? $site_settings['name'] : 'Choghadiyas.in';

$page_title = 'हमारे बारे में - Choghadiya, Panchang और शुभ मुहूर्त | ' . $site_name;

$page_description = 'Choghadiyas.in के बारे में जानें — यह वेबसाइट किसने और क्यों शुरू की, जानकारी किन स्रोतों पर आधारित है, और गलती होने पर हम उसे कैसे ठीक करते हैं।';

$page_keywords = 'about us, choghadiya, panchang, shubh muhurat, tithi, nakshatra, rahu kaal, vrat, tyohar, हमारे बारे में';

$canonical_url = SITE_URL . '/about';

/*
 * Get active founder.
 */
$founder = db_fetch_one(
    "SELECT * FROM users
     WHERE role = 'admin' AND status = 'active'
     ORDER BY id ASC
     LIMIT 1"
);

/*
 * Get active authors for the team section.
 */
$authors = db_fetch_all(
    "SELECT * FROM users
     WHERE status = 'active'
     AND role IN ('admin', 'author')
     ORDER BY role = 'admin' DESC, id ASC"
);

/*
 * Small helper for safe output.
 */
function about_e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

/*
 * Short teaser text for team-grid cards only.
 * The main founder bio is always shown in full (see founder section below).
 */
function about_short_text($value, int $limit = 220): string
{
    $value = trim((string)$value);

    if ($value === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        if (mb_strlen($value, 'UTF-8') <= $limit) {
            return $value;
        }
        // Cut at the last full sentence/space within the limit instead of
        // mid-word, so team cards don't show a broken half-sentence either.
        $cut = mb_substr($value, 0, $limit, 'UTF-8');
        $lastSpace = mb_strrpos($cut, ' ', 0, 'UTF-8');
        if ($lastSpace !== false) {
            $cut = mb_substr($cut, 0, $lastSpace, 'UTF-8');
        }
        return $cut . '…';
    }

    return strlen($value) > $limit
        ? substr($value, 0, $limit) . '…'
        : $value;
}

require_once __DIR__ . '/../includes/header_responsive.php';
?>

<!-- ============================================================
     ABOUT HERO
     ============================================================ -->
<section class="about-hero-section">
    <div class="container">
        <div class="about-hero-content">

            <div class="about-hero-badge">
                <i class="fas fa-info-circle" aria-hidden="true"></i>
                <span>हमारे बारे में</span>
            </div>

            <h1 class="about-hero-title">
                Choghadiyas.in — चौघड़िया और पंचांग की जानकारी, सरल हिंदी में
            </h1>

            <p class="about-hero-subtitle">
                यह पेज बताता है कि यह वेबसाइट किसने बनाई, जानकारी कहाँ से आती है,
                और अगर कोई गलती दिखे तो उसे कैसे रिपोर्ट करें।
            </p>

            <ul class="about-hero-facts">
                <li>
                    <i class="fas fa-user-pen" aria-hidden="true"></i>
                    लेखक/संस्थापक: <strong><?php echo about_e($founder['full_name'] ?? 'Choghadiyas.in टीम'); ?></strong>
                </li>
                <li>
                    <i class="fas fa-book" aria-hidden="true"></i>
                    जानकारी का आधार: पारंपरिक पंचांग गणना पद्धति और सार्वजनिक रूप से उपलब्ध
                    ज्योतिष संदर्भ — विस्तार से नीचे <a href="#sources">"स्रोत और गणना पद्धति"</a> सेक्शन में
                </li>
            </ul>

        </div>
    </div>
</section>


<!-- ============================================================
     OUR STORY
     ============================================================ -->
<section class="about-story-section">
    <div class="container">

        <div class="about-story-grid">

            <div class="about-story-content">

                <div class="section-badge">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                    <span>हमारी कहानी</span>
                </div>

                <h2>यह वेबसाइट क्यों शुरू की गई</h2>

                <p class="lead-paragraph">
                    अलग-अलग पंचांग वेबसाइटों और ऐप पर अक्सर एक ही दिन के चौघड़िया,
                    राहुकाल या मुहूर्त का समय थोड़ा-थोड़ा अलग दिखता है — क्योंकि हर
                    स्रोत अलग शहर या अलग गणना पद्धति का उपयोग करता है। Choghadiyas.in
                    मई 2026 में इसी उलझन को स्पष्ट करने के लिए शुरू की गई — ताकि
                    पाठक को न सिर्फ समय मिले, बल्कि यह भी समझ आए कि वह समय किस
                    आधार पर निकाला गया है।
                </p>

                <p>
                    चौघड़िया और पंचांग से जुड़ी जानकारी तारीख, स्थान और उपलब्ध डेटा
                    के अनुसार बदल सकती है। व्रत-त्योहार और शुभ मुहूर्त से जुड़े लेख
                    प्रकाशित किए जाते हैं और आवश्यक होने पर उनमें सुधार किया जा सकता है।
                    किसी खास दिन या शहर के समय का उपयोग करने से पहले उपलब्ध विवरण
                    और संबंधित परंपरा की जाँच करें।
                </p>

                <div class="story-highlights">
                    <div class="highlight-item">
                        <i class="fas fa-check-double" aria-hidden="true"></i>
                        <span>चौघड़िया — उपलब्ध स्थान और समय संबंधी डेटा के आधार पर</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-check-double" aria-hidden="true"></i>
                        <span>व्रत-त्योहार — तारीख, पूजा-विधि और क्षेत्रीय परंपराओं की जानकारी</span>
                    </div>
                    <div class="highlight-item">
                        <i class="fas fa-check-double" aria-hidden="true"></i>
                        <span>शुभ मुहूर्त — पारंपरिक पंचांग संबंधी सामान्य जानकारी</span>
                    </div>
                </div>

            </div>

            <div class="about-story-visual">
                <div class="visual-card spiritual-card">
                    <div class="spiritual-icon">
                        <i class="fas fa-om" aria-hidden="true"></i>
                    </div>
                    <h3>क्या नहीं है यह साइट</h3>
                    <p>यह कोई ज्योतिषीय परामर्श सेवा नहीं है और न ही व्यक्तिगत
                        भविष्यवाणी करती है — यह सिर्फ पारंपरिक पंचांग जानकारी
                        प्रकाशित करती है।</p>
                </div>

                <div class="visual-card trust-card">
                    <div class="trust-badge-icon">
                        <i class="fas fa-book-open" aria-hidden="true"></i>
                    </div>
                    <h3>गलती मिले तो?</h3>
                    <p>किसी भी तारीख/समय में गलती लगे तो
                        <a href="<?php echo about_e(SITE_URL); ?>/contact">संपर्क पेज</a>
                        से बताएं — हम जाँचकर सुधारते हैं।</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ============================================================
     WHAT WE PUBLISH
     ============================================================ -->
<section class="mission-vision-section">
    <div class="container">

        <div class="section-header-center">
            <div class="section-badge">
                <i class="fas fa-star" aria-hidden="true"></i>
                <span>इस साइट पर क्या मिलेगा</span>
            </div>
            <h2>चार तरह की जानकारी, एक जगह</h2>
        </div>

        <div class="mission-vision-grid">

            <div class="mission-card">
                <div class="card-icon-wrapper target-icon">
                    <i class="fas fa-clock" aria-hidden="true"></i>
                </div>
                <h3>दैनिक चौघड़िया और राहुकाल</h3>
                <p>चौघड़िया और राहुकाल से जुड़ी जानकारी उपलब्ध डेटा, चुने गए स्थान
                    और संबंधित पंचांग पद्धति के अनुसार अलग हो सकती है।</p>
            </div>

            <div class="vision-card">
                <div class="card-icon-wrapper eye-icon">
                    <i class="fas fa-calendar-days" aria-hidden="true"></i>
                </div>
                <h3>व्रत-त्योहार और शुभ मुहूर्त गाइड</h3>
                <p>व्रत-त्योहार की तारीख, पूजा-विधि, सामग्री और क्षेत्रीय परंपराओं
                    से संबंधित लेख, जहाँ उपलब्ध जानकारी के अनुसार विवरण दिया जाता है।</p>
            </div>

        </div>

    </div>
</section>


<!-- ============================================================
     SOURCES & METHOD
     ============================================================ -->
<section class="trust-reasons-section" id="sources">
    <div class="container">

        <div class="section-header-center">
            <div class="section-badge">
                <i class="fas fa-shield-halved" aria-hidden="true"></i>
                <span>स्रोत और सत्यापन</span>
            </div>
            <h2>जानकारी कहाँ से आती है</h2>
            <p>पारदर्शिता के लिए — हम किन स्रोतों और तरीकों का उपयोग करते हैं।</p>
        </div>

        <div class="trust-reasons-grid">

            <div class="trust-reason-card">
                <div class="reason-icon verified-icon">
                    <i class="fas fa-book-open" aria-hidden="true"></i>
                </div>
                <h3>पंचांग गणना पद्धति</h3>
                <p>तिथि, वार, नक्षत्र, योग और करण — पंचांग के पाँच अंगों की
                    पारंपरिक गणना पद्धति पर आधारित। सूर्योदय/सूर्यास्त गणना
                    स्थान (latitude-longitude) के अनुसार बदलती है।</p>
            </div>

            <div class="trust-reason-card">
                <div class="reason-icon precision-icon">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i>
                </div>
                <h3>क्रॉस-चेक</h3>
                <p>लेखों में जहाँ संभव हो, संबंधित पंचांग या सार्वजनिक संदर्भ स्रोतों
                    का उल्लेख किया जाता है। अलग स्रोतों, स्थानों और गणना-पद्धतियों में
                    अंतर हो सकता है; किसी विशिष्ट लेख में दिए गए स्रोत उसी लेख में देखें।</p>
            </div>

            <div class="trust-reason-card">
                <div class="reason-icon calendar-icon">
                    <i class="fas fa-rotate" aria-hidden="true"></i>
                </div>
                <h3>सुधार नीति</h3>
                <p>यदि किसी पेज में गलती दिखे, तो कृपया हमें बताएं। सुधार की समीक्षा
                    और प्रकाशन सामग्री तथा उपलब्ध प्रमाण के आधार पर किया जाता है।
                    अधिक जानकारी के लिए
                    <a href="<?php echo about_e(SITE_URL); ?>/editorial-policy">संपादकीय नीति</a>
                    देखें।</p>
            </div>

            <div class="trust-reason-card">
                <div class="reason-icon method-icon">
                    <i class="fas fa-location-dot" aria-hidden="true"></i>
                </div>
                <h3>स्थान-आधारित सीमा</h3>
                <p>डिफ़ॉल्ट समय एक संदर्भ शहर के लिए दिखाया जाता है। महत्वपूर्ण
                    कार्य से पहले अपने शहर के लिए समय ज़रूर जांच लें — साइट पर
                    शहर बदलने का विकल्प ऊपर मौजूद है।</p>
            </div>

            <div class="trust-reason-card">
                <div class="reason-icon transparent-icon">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </div>
                <h3>यह क्या नहीं है</h3>
                <p>यह जानकारी धार्मिक/सांस्कृतिक परंपरा पर आधारित है, वैज्ञानिक
                    दावा नहीं। व्यक्तिगत जीवन-निर्णयों के लिए किसी योग्य
                    ज्योतिषी/पंडित से परामर्श लें।</p>
            </div>

            <div class="trust-reason-card">
                <div class="reason-icon users-icon">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                </div>
                <h3>सीधे संपर्क करें</h3>
                <p>कोई सवाल या सुधार साझा करना चाहते हैं? हमें
                    <a href="mailto:<?php echo about_e(AUTHOR_EMAIL); ?>"><?php echo about_e(AUTHOR_EMAIL); ?></a>
                    पर लिख सकते हैं। जवाब मिलने में समय लग सकता है।</p>
            </div>

        </div>

    </div>
</section>


<!-- ============================================================
     HOW CHOGHADIYA/PANCHANG TIMES ARE CALCULATED
     (kept — this section was already specific and fine)
     ============================================================ -->
<section class="calculation-section">
    <div class="container">

        <div class="calculation-wrapper">

            <div class="calculation-content">

                <div class="section-badge">
                    <i class="fas fa-calculator" aria-hidden="true"></i>
                    <span>हमारी गणना विधि</span>
                </div>

                <h2>समय की गणना कैसे होती है</h2>

                <p class="lead-paragraph">
                    चौघड़िया और पंचांग से जुड़ी समय आधारित जानकारी स्थानीय
                    तारीख, स्थान, सूर्योदय, सूर्यास्त और संबंधित पंचांग
                    गणनाओं पर निर्भर करती है। अलग-अलग शहरों में समय में अंतर
                    होना सामान्य है।
                </p>

                <div class="calculation-steps">

                    <div class="calc-step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>स्थान और समय</h4>
                            <p>चुने गए शहर के सूर्योदय और सूर्यास्त के समय को
                                आधार बनाया जाता है।</p>
                        </div>
                    </div>

                    <div class="calc-step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>पंचांग विवरण</h4>
                            <p>तिथि, वार, नक्षत्र, योग और करण — इन पाँचों की
                                उस दिन की स्थिति के आधार पर विवरण तैयार होता है।</p>
                        </div>
                    </div>

                    <div class="calc-step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>चौघड़िया विभाजन</h4>
                            <p>सूर्योदय से सूर्यास्त और सूर्यास्त से अगले सूर्योदय
                                तक के समय को 8-8 भागों में बाँटकर शुभ/अशुभ काल
                                तय किया जाता है।</p>
                        </div>
                    </div>

                    <div class="calc-step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>दैनिक अपडेट</h4>
                            <p>जानकारी का अपडेट उपलब्ध डेटा और वेबसाइट की तकनीकी प्रक्रिया पर निर्भर करता है।
                                पेज पर दिखाई गई तारीख और स्थान की जाँच करें।</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="calculation-visual">
                <div class="zodiac-wheel">
                    <div class="wheel-center">
                        <i class="fas fa-sun" aria-hidden="true"></i>
                    </div>
                    <div class="wheel-ring"></div>
                </div>
                <div class="calc-info-cards">
                    <div class="calc-info-card">
                        <i class="fas fa-location-dot" aria-hidden="true"></i>
                        <span>स्थान आधारित</span>
                    </div>
                    <div class="calc-info-card">
                        <i class="fas fa-calendar-day" aria-hidden="true"></i>
                        <span>दैनिक जानकारी</span>
                    </div>
                    <div class="calc-info-card">
                        <i class="fas fa-list-check" aria-hidden="true"></i>
                        <span>सरल प्रस्तुति</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- ============================================================
     FOUNDER
     ============================================================ -->
<?php if ($founder): ?>

<section class="expert-bio-section">
    <div class="container">

        <div class="expert-bio-header">
            <span class="expert-badge-top">हमारे संस्थापक</span>
            <h2>हमारे संस्थापक के बारे में</h2>
            <div class="expert-header-line"></div>
        </div>

        <div class="expert-bio-content">

            <div class="expert-bio-left">

                <div class="expert-photo-wrapper">
                    <div class="expert-photo">
                        <?php if (!empty($founder['profile_image'])): ?>
                            <img
                                src="<?php echo about_e($founder['profile_image']); ?>"
                                alt="<?php echo about_e($founder['full_name']); ?>"
                                class="expert-photo-img"
                                loading="lazy"
                                decoding="async"
                            >
                        <?php else: ?>
                            <div class="expert-avatar-img" aria-hidden="true">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="expert-name-card">
                    <h3><?php echo about_e($founder['full_name']); ?></h3>
                    <span class="expert-title">संस्थापक, Choghadiyas.in</span>

                    <?php if (!empty($founder['bio'])): ?>
                        <p class="expert-full-bio">
                            <?php echo nl2br(about_e($founder['bio'])); ?>
                        </p>
                    <?php else: ?>
                        <p class="expert-full-bio">
                            Choghadiyas.in के संस्थापक।
                        </p>
                    <?php endif; ?>
                </div>

            </div>

            <div class="expert-bio-right">

                <h3 class="why-trust-heading">अनुभव और योगदान</h3>

                <div class="trust-point">
                    <h4><span class="point-number">1.</span> अनुभव</h4>
                    <ul>
                        <li>
                            प्रोफ़ाइल में दर्ज परिचय के अनुसार, संस्थापक वेबसाइट की
                            सामग्री और उससे संबंधित कार्यों में योगदान देते हैं। यह
                            वेबसाइट व्यक्तिगत ज्योतिषीय परामर्श या भविष्यवाणी सेवा
                            के रूप में प्रस्तुत नहीं की जाती।
                        </li>
                    </ul>
                </div>

                <div class="trust-point">
                    <h4><span class="point-number">2.</span> इस साइट पर भूमिका</h4>
                    <ul>
                        <li>
                            वेबसाइट की सामग्री और जानकारी से जुड़े कार्यों में योगदान।
                            संपादकीय प्रक्रिया के बारे में
                            <a href="<?php echo about_e(SITE_URL); ?>/editorial-policy">संपादकीय नीति</a>
                            देखें।
                        </li>
                    </ul>
                </div>

                <div class="trust-point">
                    <h4><span class="point-number">3.</span> सार्वजनिक उपस्थिति</h4>
                    <ul>
                        <li>
                            नीचे दिए गए सोशल प्रोफाइल तभी देखें जब वे संबंधित व्यक्ति
                            के आधिकारिक और सक्रिय खाते हों। सोशल प्रोफाइल की मौजूदगी
                            अपने-आप में किसी जानकारी की शुद्धता का प्रमाण नहीं है।
                        </li>
                    </ul>
                </div>

                <!-- Founder Social Profiles -->
                <div class="founder-social">
                    <a href="https://whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r" target="_blank" rel="noopener noreferrer" class="social-btn" title="WhatsApp Channel" aria-label="WhatsApp Channel">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/shivkumarpandit8053/" target="_blank" rel="noopener noreferrer" class="social-btn" title="Instagram" aria-label="Instagram">
                        <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/" target="_blank" rel="noopener noreferrer" class="social-btn" title="Facebook" aria-label="Facebook">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.youtube.com/@SKPANDITJIOFFICIAL" target="_blank" rel="noopener noreferrer" class="social-btn" title="YouTube" aria-label="YouTube">
                        <i class="fab fa-youtube" aria-hidden="true"></i>
                    </a>
                    <a href="mailto:<?php echo about_e(AUTHOR_EMAIL); ?>" class="social-btn" title="Email" aria-label="Email">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </a>
                </div>

                <!-- Official Contact Information -->
                <div class="founder-contact-block">
                    <div class="contact-line">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <a href="mailto:<?php echo about_e(AUTHOR_EMAIL); ?>"><?php echo about_e(AUTHOR_EMAIL); ?></a>
                    </div>
                    <?php if (defined('AUTHOR_PHONE') && trim((string) AUTHOR_PHONE) !== ''): ?>
                    <div class="contact-line">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <a href="tel:<?php echo about_e(preg_replace('/[^0-9+]/', '', (string) AUTHOR_PHONE)); ?>"><?php echo about_e(AUTHOR_PHONE); ?></a>
                    </div>
                    <?php endif; ?>
                    <div class="contact-line">
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        <address>
                            <?php echo about_e(OFFICE_STREET); ?>,
                            <?php echo about_e(OFFICE_LOCALITY); ?>,
                            <?php echo about_e(OFFICE_REGION); ?>
                            <?php echo about_e(OFFICE_POSTAL_CODE); ?>,
                            India
                        </address>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<?php endif; ?>


<!-- ============================================================
     OUR TEAM / AUTHORS
     ============================================================ -->
<?php if (!empty($authors)): ?>

<section class="authors-section">
    <div class="container">

        <div class="authors-header">
            <span class="authors-badge">हमारी टीम</span>
            <h2>हमारी टीम के सदस्य</h2>
            <p>Choghadiyas.in से जुड़े लोगों के बारे में जानें</p>
            <div class="authors-header-line"></div>
        </div>

        <div class="authors-grid">

            <?php foreach ($authors as $author): ?>

                <div class="author-card">

                    <div class="author-photo-wrapper">
                        <?php if (!empty($author['profile_image'])): ?>
                            <img
                                src="<?php echo about_e($author['profile_image']); ?>"
                                alt="<?php echo about_e($author['full_name']); ?>"
                                class="author-photo"
                                loading="lazy"
                                decoding="async"
                            >
                        <?php else: ?>
                            <div class="author-photo-placeholder" aria-hidden="true">
                                <span>
                                    <?php
                                    $name = trim((string)$author['full_name']);
                                    echo about_e($name !== '' ? mb_substr($name, 0, 1, 'UTF-8') : '?');
                                    ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if (($author['role'] ?? '') === 'admin'): ?>
                            <div class="author-badge-icon" title="संस्थापक">
                                <i class="fas fa-crown" aria-hidden="true"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="author-info">
                        <h3 class="author-name"><?php echo about_e($author['full_name']); ?></h3>
                        <span class="author-role">
                            <?php echo (($author['role'] ?? '') === 'admin') ? 'संस्थापक' : 'लेखक'; ?>
                        </span>

                        <?php if (!empty($author['bio'])): ?>
                            <p class="author-bio">
                                <?php echo about_e(about_short_text($author['bio'], 220)); ?>
                            </p>
                        <?php else: ?>
                            <p class="author-bio">
                                Choghadiyas.in की सामग्री और जानकारी से जुड़े योगदानकर्ता।
                            </p>
                        <?php endif; ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
</section>

<?php endif; ?>


<!-- ============================================================
     CONTACT CTA
     ============================================================ -->
<section class="about-cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-icon">
                <i class="fas fa-comments" aria-hidden="true"></i>
            </div>
            <h2>कोई प्रश्न है? हमसे संपर्क करें</h2>
            <p>Choghadiya, Panchang, Muhurat या वेबसाइट से संबंधित किसी
                प्रश्न या सुधार के लिए हमसे संपर्क करें।</p>
            <div class="cta-buttons">
                <a href="<?php echo about_e(SITE_URL); ?>/contact" class="btn btn-primary btn-lg">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    संपर्क करें
                </a>
                <a href="<?php echo about_e(SITE_URL); ?>/editorial-policy" class="btn btn-outline btn-lg">
                    <i class="fas fa-file-shield" aria-hidden="true"></i>
                    Editorial Policy देखें
                </a>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     ABOUT PAGE LOCAL STYLES
     ============================================================ -->
<style>
.about-hero-facts {
    list-style: none;
    margin: 20px 0 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.about-hero-facts li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    color: #374151;
}
.about-hero-facts i {
    color: #667eea;
    width: 18px;
    text-align: center;
}

.expert-full-bio {
    margin-top: 10px;
    line-height: 1.7;
    color: #374151;
}

.founder-contact-block {
    margin-top: 20px;
    padding: 16px 18px;
    background: rgba(102,126,234,0.06);
    border-left: 4px solid #667eea;
    border-radius: 8px;
}
.founder-contact-block .contact-line {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14.5px;
    color: #374151;
    line-height: 1.55;
}
.founder-contact-block .contact-line + .contact-line {
    margin-top: 8px;
}
.founder-contact-block .contact-line i {
    color: #667eea;
    margin-top: 4px;
    flex: 0 0 auto;
}
.founder-contact-block a {
    color: #667eea;
    text-decoration: none;
}
.founder-contact-block a:hover {
    text-decoration: underline;
}
.founder-contact-block address {
    font-style: normal;
    line-height: 1.5;
}

.expert-avatar-img,
.author-photo-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
}
.expert-avatar-img {
    width: 100%;
    height: 100%;
    min-height: 180px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}
.author-photo-placeholder {
    width: 100%;
    height: 100%;
    min-height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
}
.expert-photo-img,
.author-photo {
    display: block;
    width: 100%;
    height: auto;
    object-fit: cover;
}
.expert-photo-img {
    max-height: 420px;
}
.author-photo {
    aspect-ratio: 1 / 1;
}

@media (max-width: 768px) {
    .founder-contact-block .contact-line {
        font-size: 14px;
    }
}

/* About page responsive refinements */
.about-hero-section .container,
.about-story-section .container,
.mission-vision-section .container,
.trust-reasons-section .container,
.calculation-section .container,
.expert-bio-section .container,
.authors-section .container,
.about-cta-section .container {
    width: min(100% - 32px, 1180px);
    max-width: 1180px;
    margin-inline: auto;
}
.about-hero-content { max-width: 900px; }
.about-story-grid { display:grid; grid-template-columns:minmax(0,1.25fr) minmax(280px,.75fr); gap:clamp(22px,4vw,48px); align-items:start; }
.mission-vision-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:22px; }
.trust-reasons-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:20px; }
.calculation-wrapper { display:grid; grid-template-columns:minmax(0,1.2fr) minmax(260px,.8fr); gap:clamp(24px,4vw,48px); align-items:center; }
.expert-bio-content { display:grid; grid-template-columns:minmax(240px,.8fr) minmax(0,1.2fr); gap:clamp(22px,4vw,44px); }
.authors-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:20px; }
.about-hero-facts li,.founder-contact-block .contact-line { min-width:0; overflow-wrap:anywhere; }
.about-hero-facts a,.founder-contact-block a { overflow-wrap:anywhere; }
.expert-photo-img,.author-photo { max-width:100%; }
.about-hero-section h1,.about-story-section h2,.mission-vision-section h2,.trust-reasons-section h2,.calculation-section h2,.expert-bio-section h2,.authors-section h2,.about-cta-section h2 { line-height:1.35; }
.about-story-section p,.mission-vision-section p,.trust-reasons-section p,.calculation-section p,.expert-bio-section p,.authors-section p { line-height:1.75; }
.about-hero-section a:focus-visible,.about-story-section a:focus-visible,.trust-reasons-section a:focus-visible,.expert-bio-section a:focus-visible,.about-cta-section a:focus-visible { outline:3px solid #f97316; outline-offset:3px; border-radius:4px; }
@media (max-width:900px) {
 .trust-reasons-grid,.authors-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }
 .about-story-grid,.calculation-wrapper,.expert-bio-content { grid-template-columns:minmax(0,1fr); }
 .calculation-visual { max-width:520px; margin-inline:auto; width:100%; }
}
@media (max-width:600px) {
 .about-hero-section .container,.about-story-section .container,.mission-vision-section .container,.trust-reasons-section .container,.calculation-section .container,.expert-bio-section .container,.authors-section .container,.about-cta-section .container { width:min(100% - 24px,1180px); }
 .mission-vision-grid,.trust-reasons-grid,.authors-grid { grid-template-columns:minmax(0,1fr); }
 .about-hero-facts li { align-items:flex-start; font-size:14px; line-height:1.65; }
 .founder-contact-block { padding:14px; }
 .founder-contact-block .contact-line { font-size:14px; }
 .cta-buttons { display:flex; flex-direction:column; align-items:stretch; gap:12px; }
 .cta-buttons .btn { width:100%; justify-content:center; }
}
@media (prefers-reduced-motion:reduce) {
 .about-hero-section *,.about-story-section *,.mission-vision-section *,.trust-reasons-section *,.calculation-section *,.expert-bio-section *,.authors-section *,.about-cta-section * { animation-duration:.01ms!important; animation-iteration-count:1!important; transition-duration:.01ms!important; }
}

</style>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>