<?php
/**
 * Mobile Responsive Header Template
 * Choghadiya Muhurat Website
 */

global $site_settings, $page_title, $page_description, $page_keywords, $canonical_url;

// Set default page meta
$page_title = $page_title ?? $site_settings['name'] . ' - ' . $site_settings['tagline'];
$page_description = $page_description ?? $site_settings['description'];
$page_keywords = $page_keywords ?? $site_settings['keywords'];
$canonical_url = $canonical_url ?? get_current_url();

// Get categories for dropdown
$categories = db_fetch_all("SELECT * FROM categories WHERE status = 'active' ORDER BY sort_order, name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta name="ezoic-site-verification" content="mpuRy2iHDTP1UqsMW2jNRxAfGCjAjP" />
    
    <!-- Google AdSense (Single consolidated async loader preserving all 3 authorized accounts) -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4187031433847125" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($page_keywords); ?>">
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">
    
    <?php 
    $is_staging_env = (strpos($_SERVER['REQUEST_URI'] ?? '', 'staging') !== false) || (strpos($_SERVER['SCRIPT_NAME'] ?? '', 'staging') !== false);
    if ($is_staging_env): ?>
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <?php else: ?>
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <?php endif; ?>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:image" content="<?php echo $site_settings['logo'] ? $site_settings['logo'] : SITE_URL . '/assets/images/og-image.jpg'; ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($site_settings['name']); ?>">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="twitter:image" content="<?php echo $site_settings['logo'] ? $site_settings['logo'] : SITE_URL . '/assets/images/og-image.jpg'; ?>">
    
    <!-- Favicon -->
    <?php if ($site_settings['favicon']): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $site_settings['favicon']; ?>">
    <?php endif; ?>
    
    <!-- Google Fonts (Optimized & Non-blocking) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Styles -->
    <link rel="stylesheet" href="<?php echo defined('SITE_URL') ? SITE_URL : ''; ?>/assets/css/style.css">
    <?php
    $theme_css_url = (defined('IS_STAGING_PREVIEW') && IS_STAGING_PREVIEW)
        ? '/staging-test/assets/css/choghadiya-theme.css?v=' . time()
        : (defined('SITE_URL') ? SITE_URL : '') . '/assets/css/choghadiya-theme.css?v=20261106_v5';
    ?>
    <link rel="stylesheet" href="<?php echo $theme_css_url; ?>">
    
    <!-- Google Analytics -->
    <?php if ($site_settings['analytics_code']): ?>
    <?php echo $site_settings['analytics_code']; ?>
    <?php endif; ?>
    
    <!-- Custom Header Scripts -->
    <?php if ($site_settings['custom_header_scripts']): ?>
    <?php echo $site_settings['custom_header_scripts']; ?>
    <?php endif; ?>

    <!-- ============================================================
         Organization + WebSite Schema (site-wide structured data)
         ============================================================ -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "@id": "<?php echo SITE_URL; ?>/#organization",
        "name": "<?php echo htmlspecialchars($site_settings['name']); ?>",
        "url": "<?php echo SITE_URL; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo $site_settings['logo'] ?: SITE_URL . '/assets/images/logo.png'; ?>"
        },
        "description": "<?php echo htmlspecialchars($site_settings['description']); ?>",
        "sameAs": [
            <?php
            $social_profiles = array_filter([
                $site_settings['whatsapp'] ?? '',
                $site_settings['instagram'] ?? '',
                $site_settings['youtube'] ?? '',
                $site_settings['facebook'] ?? '',
            ]);
            echo implode(",\n            ", array_map(fn($u) => json_encode($u), $social_profiles));
            ?>
        ],
        "founder": {
            "@type": "Person",
            "name": "<?php echo htmlspecialchars(AUTHOR_NAME); ?>",
            "email": "<?php echo htmlspecialchars(AUTHOR_EMAIL); ?>"
        },
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo htmlspecialchars(OFFICE_STREET); ?>",
            "addressLocality": "<?php echo htmlspecialchars(OFFICE_LOCALITY); ?>",
            "addressRegion": "<?php echo htmlspecialchars(OFFICE_REGION); ?>",
            "postalCode": "<?php echo htmlspecialchars(OFFICE_POSTAL_CODE); ?>",
            "addressCountry": "<?php echo htmlspecialchars(OFFICE_COUNTRY); ?>"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "Customer Support",
            "email": "<?php echo htmlspecialchars($site_settings['contact_email']); ?>"<?php if (!empty($site_settings['contact_phone'])): ?>,
            "telephone": "<?php echo htmlspecialchars($site_settings['contact_phone']); ?>"<?php endif; ?>,
            "availableLanguage": ["English", "Hindi"]
        }
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "@id": "<?php echo SITE_URL; ?>/#website",
        "url": "<?php echo SITE_URL; ?>",
        "name": "<?php echo htmlspecialchars($site_settings['name']); ?>",
        "description": "<?php echo htmlspecialchars($site_settings['description']); ?>",
        "inLanguage": "en-IN",
        "publisher": { "@id": "<?php echo SITE_URL; ?>/#organization" },
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo SITE_URL; ?>/search?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

</head>
<body>
    <!-- Site-wide Unified Premium White Header (Clean White Background, 4 Real Categories) -->
    <header class="site-header" id="premiumHeader">
        <div class="header-container">
            <a href="/" class="brand-logo" aria-label="Choghadiyas.in होमपेज">
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
                    <div class="brand-title">Choghadiyas<span>.in</span></div>
                    <div class="brand-subtitle">वैदिक चौघड़िया एवं पंचांग</div>
                </div>
            </a>

            <!-- Desktop Nav Pills (4 Real Category Destinations) -->
            <nav class="nav-pills" aria-label="मुख्य नेविगेशन">
                <a href="/" class="nav-pill <?php echo (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') ? 'active' : ''; ?>">Home</a>
                <a href="/category/vrat-tyohar" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/category/vrat-tyohar') !== false) ? 'active' : ''; ?>">व्रत और त्योहार</a>
                <a href="/category/shubh-muhurat-guide" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/category/shubh-muhurat-guide') !== false) ? 'active' : ''; ?>">शुभ मुहूर्त</a>
                <a href="/category/puja-vidhi-samagri" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/category/puja-vidhi-samagri') !== false) ? 'active' : ''; ?>">पूजा विधि और सामग्री</a>
                <a href="/category/vedic-panchang" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/category/vedic-panchang') !== false) ? 'active' : ''; ?>">वैदिक पंचांग</a>
                <a href="/about" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/about') !== false) ? 'active' : ''; ?>">About Us</a>
                <a href="/contact" class="nav-pill <?php echo (strpos($_SERVER['REQUEST_URI'] ?? '', '/contact') !== false) ? 'active' : ''; ?>">Contact Us</a>
            </nav>

            <!-- Search & Mobile Menu Button -->
            <div class="header-actions">
                <button type="button" class="search-toggle-btn" onclick="if(window.openSearchModal){window.openSearchModal();}else{window.location.href='/search';}" aria-label="सर्च करें" title="खोजें">
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
    </header>

    <!-- Instant Search Modal -->
    <div class="search-modal-overlay" id="searchModal" onclick="if(event.target===this)window.closeSearchModal();" role="dialog" aria-modal="true" aria-label="सर्च मोडल">
        <div class="search-modal-container">
            <div class="search-modal-header">
                <div class="search-modal-input-wrap">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF7000" stroke-width="2.5" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input type="text" id="modalSearchInput" placeholder="लेख, व्रत या पूजा विधि खोजें (उदा. छठ पूजा, कलश स्थापना)..." oninput="if(window.handleModalSearchInput)window.handleModalSearchInput(this.value);" autocomplete="off" aria-label="सर्च इनपुट">
                </div>
                <button type="button" class="search-modal-close" onclick="window.closeSearchModal();" aria-label="सर्च बंद करें">✕</button>
            </div>
            <div class="search-modal-results" id="modalSearchResults">
                <div style="text-align:center; padding:2rem; color:#94A3B8; font-size:0.95rem;">खोजने के लिए शब्द टाइप करें... (उदा. छठ पूजा, कलश, मुहूर्त)</div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div class="mobile-drawer-overlay" id="mobileDrawerOverlay" onclick="window.toggleMobileDrawer(false);"></div>
    <aside class="mobile-drawer" id="mobileDrawer" aria-label="मोबाइल नेविगेशन">
        <div class="mobile-drawer-header">
            <div class="brand-title" style="font-size:1.15rem;">Choghadiyas<span style="color:#FF7000;">.in</span></div>
            <button class="drawer-close-btn" onclick="window.toggleMobileDrawer(false);" aria-label="मेनू बंद करें">✕</button>
        </div>
        <div class="mobile-drawer-search">
            <form action="/search" method="GET" onsubmit="window.handleSearchSubmit(event);">
                <input type="text" name="q" placeholder="खोजें (e.g. व्रत, मुहूर्त, पूजा)..." aria-label="मोबाइल खोज">
                <button type="submit" aria-label="खोजें">→</button>
            </form>
        </div>
        <nav class="mobile-drawer-nav">
            <a href="/" class="mobile-nav-link <?php echo (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === '/') ? 'active' : ''; ?>">Home</a>
            <a href="/category/vrat-tyohar" class="mobile-nav-link">व्रत और त्योहार</a>
            <a href="/category/shubh-muhurat-guide" class="mobile-nav-link">शुभ मुहूर्त</a>
            <a href="/category/puja-vidhi-samagri" class="mobile-nav-link">पूजा विधि और सामग्री</a>
            <a href="/category/vedic-panchang" class="mobile-nav-link">वैदिक पंचांग</a>
            <a href="/about" class="mobile-nav-link">About Us (हमारे बारे में)</a>
            <a href="/contact" class="mobile-nav-link">Contact Us (संपर्क करें)</a>
            <a href="/editorial-policy" class="mobile-nav-link">Editorial Policy</a>
            <a href="/privacy-policy" class="mobile-nav-link">Privacy Policy</a>
            <a href="/terms" class="mobile-nav-link">Terms &amp; Conditions</a>
            <a href="/disclaimer" class="mobile-nav-link">Disclaimer</a>
        </nav>
    </aside>

    <!-- Unified Header Styles & Drawer Scripts -->
    <style>
    body {
        background-color: #FFFFFF !important;
        color: #0A1629;
        font-family: "Plus Jakarta Sans", "Noto Sans Devanagari", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    .site-header {
        position: sticky;
        top: 0;
        z-index: 9999;
        background: #FFFFFF;
        border-bottom: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(10, 22, 41, 0.04);
        padding: 0.6rem 0;
    }
    .header-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .brand-logo {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        text-decoration: none;
        color: #0A1629;
        flex-shrink: 0;
    }
    .brand-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, #FF7000, #EA580C);
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(255, 112, 0, 0.25);
    }
    .brand-title {
        font-size: 1.25rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.1;
        color: #0A1629;
    }
    .brand-title span {
        color: #FF7000;
    }
    .brand-subtitle {
        font-size: 0.68rem;
        color: #64748B;
        font-weight: 600;
        margin-top: 2px;
    }
    .nav-pills {
        display: none;
        align-items: center;
        gap: 0.35rem;
        flex-wrap: wrap;
    }
    @media (min-width: 992px) {
        .nav-pills {
            display: flex;
        }
    }
    .nav-pill {
        padding: 0.45rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .nav-pill:hover {
        background: #F1F5F9;
        color: #0A1629;
    }
    .nav-pill.active {
        background: #0A1629;
        color: #FFFFFF;
    }
    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .search-toggle-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .search-toggle-btn:hover {
        background: #F8FAFC;
        color: #FF7000;
        border-color: #CBD5E1;
    }
    .mobile-menu-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        color: #0A1629;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    @media (min-width: 992px) {
        .mobile-menu-btn {
            display: none;
        }
    }
    .mobile-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(10, 22, 41, 0.45);
        backdrop-filter: blur(2px);
        z-index: 99998;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .mobile-drawer-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }
    .mobile-drawer {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: 300px;
        max-width: 85vw;
        background: #FFFFFF;
        z-index: 99999;
        box-shadow: -4px 0 24px rgba(10, 22, 41, 0.15);
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        padding: 1.25rem;
    }
    .mobile-drawer.active {
        transform: translateX(0);
    }
    .mobile-drawer-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid #E2E8F0;
    }
    .drawer-close-btn {
        background: none;
        border: none;
        font-size: 1.25rem;
        color: #64748B;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
    }
    .mobile-drawer-search {
        margin: 1rem 0;
    }
    .mobile-drawer-search form {
        display: flex;
        border: 1px solid #E2E8F0;
        border-radius: 9999px;
        overflow: hidden;
        background: #F8FAFC;
    }
    .mobile-drawer-search input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
        outline: none;
    }
    .mobile-drawer-search button {
        background: #FF7000;
        color: #FFFFFF;
        border: none;
        padding: 0 1rem;
        font-weight: 700;
        cursor: pointer;
    }
    .mobile-drawer-nav {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
    }
    .mobile-nav-link {
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        font-size: 0.92rem;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        transition: all 0.2s;
    }
    .mobile-nav-link:hover, .mobile-nav-link.active {
        background: #FFF7ED;
        color: #FF7000;
    }
    </style>

    <script>
    window.toggleMobileDrawer = function(state) {
        var d = document.getElementById("mobileDrawer");
        var o = document.getElementById("mobileDrawerOverlay");
        var b = document.getElementById("mobileMenuToggle");
        if (!d || !o) return;
        var open = (typeof state === "boolean") ? state : !d.classList.contains("active");
        if (open) {
            d.classList.add("active");
            o.classList.add("active");
            if (b) b.setAttribute("aria-expanded", "true");
            document.body.style.overflow = "hidden";
        } else {
            d.classList.remove("active");
            o.classList.remove("active");
            if (b) b.setAttribute("aria-expanded", "false");
            document.body.style.overflow = "";
        }
    };
    </script>
