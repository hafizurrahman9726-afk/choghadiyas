<?php
/**
 * Single Article Template
 * Choghadiya Muhurat Website - Premium Design
 */

require_once __DIR__ . '/../config/config.php';

// Performance and Security Headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

$slug = $_GET['slug'] ?? '';

// Get post by slug
$post = db_fetch_one("
    SELECT p.*, c.name as category_name, c.slug as category_slug, u.full_name as author_name, u.profile_image as author_image, u.bio as author_bio, u.role as author_role
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN users u ON p.author_id = u.id
    WHERE p.slug = ? AND p.status = 'published'
", [$slug]);

if (!$post) {
    header("HTTP/1.0 404 Not Found");
    require_once __DIR__ . '/404.php';
    exit;
}

// Verified Author Information
$verified_author_name = !empty($post['author_name']) ? $post['author_name'] : 'Shiv Kumar Pandit';
$verified_author_image = 'https://choghadiyas.in/uploads/profiles/6a0a995eb34a7.webp';
$author_profile_url = (defined('SITE_URL') ? SITE_URL : 'https://choghadiyas.in') . '/about';
$verified_author_role = !empty($post['author_role']) && $post['author_role'] !== 'admin' ? $post['author_role'] : 'संस्थापक एवं वरिष्ठ कंटेंट रिसर्चर';
$verified_author_bio = !empty($post['author_bio']) ? $post['author_bio'] : 'सनातन संस्कृति, पंचांग गणना, व्रत-त्योहारों के प्रामाणिक नियमों और पूजा सामग्री के विधिवत संकलन हेतु समर्पित शोधकर्ता। हमारे सभी लेख शास्त्रीय पंचांगों और प्रामाणिक धर्मग्रंथों के अध्ययन पर आधारित हैं।';

// Increment view count
db_execute("UPDATE posts SET views = views + 1 WHERE id = ?", [$post['id']]);

// Get post tags
$tags = [];
try {
    $tags = db_fetch_all("
        SELECT t.name, t.slug
        FROM tags t
        INNER JOIN post_tags pt ON t.id = pt.tag_id
        WHERE pt.post_id = ?
    ", [$post['id']]);
} catch (Exception $e) {
    // Tags table might not exist, continue without tags
    $tags = [];
}

// Get post FAQs
$post_faqs = [];
try {
    $post_faqs = db_fetch_all("
        SELECT * FROM faqs
        WHERE post_id = ? AND status = 'active'
        ORDER BY sort_order ASC
    ", [$post['id']]);
} catch (Exception $e) {
    // FAQs might not have post_id column, continue without FAQs
    $post_faqs = [];
}

// ============================================================
// Get related posts - ALWAYS return exactly 3 posts
// Priority: 1) Same category 2) Same tags 3) Latest published
// ============================================================
$related_posts = [];
$exclude_ids = [$post['id']];

// Priority 1: Same category
if (!empty($post['category_id'])) {
    $related_posts = db_fetch_all("
        SELECT p.*, c.name as category_name, c.slug as category_slug
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 'published' AND p.category_id = ? AND p.id != ?
        ORDER BY p.publish_date DESC
        LIMIT 3
    ", [$post['category_id'], $post['id']]) ?: [];
}

foreach ($related_posts as $rp) { $exclude_ids[] = $rp['id']; }

// Priority 2: Same tags (if we still need posts)
if (count($related_posts) < 3) {
    $needed = 3 - count($related_posts);
    try {
        $placeholders = implode(',', array_fill(0, count($exclude_ids), '?'));
        $tag_posts = db_fetch_all("
            SELECT DISTINCT p.*, c.name as category_name, c.slug as category_slug
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            INNER JOIN post_tags pt ON p.id = pt.post_id
            WHERE p.status = 'published'
              AND p.id NOT IN ($placeholders)
              AND pt.tag_id IN (SELECT tag_id FROM post_tags WHERE post_id = ?)
            ORDER BY p.publish_date DESC
            LIMIT $needed
        ", array_merge($exclude_ids, [$post['id']])) ?: [];
        foreach ($tag_posts as $tp) {
            $related_posts[] = $tp;
            $exclude_ids[] = $tp['id'];
        }
    } catch (Exception $e) {
        // post_tags table may not exist - silently skip
    }
}

// Priority 3: Latest published posts (fallback to always reach 3)
if (count($related_posts) < 3) {
    $needed = 3 - count($related_posts);
    $placeholders = implode(',', array_fill(0, count($exclude_ids), '?'));
    $fallback = db_fetch_all("
        SELECT p.*, c.name as category_name, c.slug as category_slug
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.status = 'published' AND p.id NOT IN ($placeholders)
        ORDER BY p.publish_date DESC
        LIMIT $needed
    ", $exclude_ids) ?: [];
    foreach ($fallback as $fp) { $related_posts[] = $fp; }
}

// Get recent posts
$recent_posts = db_fetch_all("
    SELECT p.*, c.name as category_name
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'published' AND p.id != ?
    ORDER BY p.publish_date DESC
    LIMIT 5
", [$post['id']]);

// Get popular posts
$popular_posts = db_fetch_all("
    SELECT p.*, c.name as category_name
    FROM posts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'published' AND p.id != ?
    ORDER BY p.views DESC
    LIMIT 5
", [$post['id']]);

// Get categories
$categories = db_fetch_all("
    SELECT * FROM categories
    WHERE status = 'active'
    ORDER BY sort_order ASC
    LIMIT 10
");

// Get post meta for SEO
$meta_title = db_fetch_one("SELECT meta_value FROM post_meta WHERE post_id = ? AND meta_key = 'meta_title'", [$post['id']]);
$meta_description = db_fetch_one("SELECT meta_value FROM post_meta WHERE post_id = ? AND meta_key = 'meta_description'", [$post['id']]);

// Set page meta
$page_title = $meta_title['meta_value'] ?? $post['title'] . ' - ' . $site_settings['name'];
$page_description = $meta_description['meta_value'] ?? truncate_text($post['content'], 160);
$page_keywords = $post['title'] . ', ' . ($post['category_name'] ?? '');
$canonical_url = SITE_URL . '/' . $post['slug'];
$og_image = $post['featured_image'] ?? SITE_URL . '/assets/images/og-default.jpg';

// Prepare schema data
$article_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post['title'],
    'description' => $page_description,
    'author' => [
        '@type' => 'Person',
        'name' => $verified_author_name,
        'url' => $author_profile_url,
        'image' => $verified_author_image,
        'jobTitle' => 'Vedic Author & Spiritual Content Researcher'
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => $site_settings['name'],
        'logo' => [
            '@type' => 'ImageObject',
            'url' => SITE_URL . '/assets/images/logo.png'
        ]
    ],
    'datePublished' => date('c', strtotime($post['publish_date'])),
    'dateModified' => date('c', strtotime($post['updated_at'] ?? $post['publish_date'])),
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => $canonical_url
    ],
    'image' => $og_image
];

// BreadcrumbList Schema
$breadcrumb_schema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => SITE_URL
        ]
    ]
];
if (!empty($post['category_slug'])) {
    $breadcrumb_schema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => $post['category_name'],
        'item' => SITE_URL . '/category/' . $post['category_slug']
    ];
    $breadcrumb_schema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => $post['title'],
        'item' => $canonical_url
    ];
} else {
    $breadcrumb_schema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => $post['title'],
        'item' => $canonical_url
    ];
}

// FAQ Schema
$faq_schema = null;
if (!empty($post_faqs)) {
    $faq_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => []
    ];
    
    foreach ($post_faqs as $faq) {
        $faq_schema['mainEntity'][] = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ];
    }
}


// ============================================================
// Auto-generate Table of Contents from H2/H3 headings
// Inject id attributes into headings and build $toc_headings list
// ============================================================
$toc_headings = [];
$processed_content = $post['content'] ?? '';

if (!empty($processed_content)) {
    $used_ids = [];
    $heading_counter = 0;

    $processed_content = preg_replace_callback(
        '/<h([23])([^>]*)>(.*?)<\/h\1>/is',
        function ($matches) use (&$toc_headings, &$used_ids, &$heading_counter) {
            $level = (int)$matches[1];
            $existing_attrs = $matches[2];
            $inner_html = $matches[3];
            $text = trim(strip_tags($inner_html));

            if ($text === '') {
                return $matches[0];
            }

            // Reuse an existing id if author already added one
            if (preg_match('/\bid\s*=\s*"([^"]+)"/i', $existing_attrs, $idm)) {
                $id = $idm[1];
                $new_attrs = $existing_attrs;
            } else {
                $heading_counter++;
                // Build slug-style id (supports unicode like Devanagari)
                $id = strtolower($text);
                $id = preg_replace('/[\s\.\,\!\?\:\;\'\"\(\)\[\]\{\}\/\\\\]+/u', '-', $id);
                $id = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $id);
                $id = trim($id, '-');
                if ($id === '') { $id = 'section-' . $heading_counter; }
                // Ensure uniqueness
                $base = $id; $i = 2;
                while (in_array($id, $used_ids, true)) {
                    $id = $base . '-' . $i; $i++;
                }
                $new_attrs = $existing_attrs . ' id="' . $id . '"';
            }
            $used_ids[] = $id;

            $toc_headings[] = [
                'id'    => $id,
                'level' => $level,
                'text'  => $text,
            ];

            return '<h' . $level . $new_attrs . '>' . $inner_html . '</h' . $level . '>';
        },
        $processed_content
    );
}

// Include header
require_once __DIR__ . '/../includes/header_responsive.php';
?>

<!-- Breadcrumbs -->
<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Breadcrumb" style="background: #FFFFFF; padding: 14px 0; border-bottom: 1px solid #E2E8F0;">
    <div class="container" style="max-width:1200px; margin:0 auto; padding:0 1.25rem; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; font-size: 13.5px; color: #64748B;">
        <a href="<?php echo SITE_URL; ?>/" style="color: #64748B; text-decoration: none;">Home</a>
        <span style="color: #CBD5E1;">›</span>
        <?php if (!empty($post['category_slug'])): ?>
        <a href="<?php echo SITE_URL; ?>/category/<?php echo htmlspecialchars($post['category_slug'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" style="color: #64748B; text-decoration: none;"><?php echo htmlspecialchars(html_entity_decode((string)($post['category_name'] ?? 'धर्म एवं पंचांग'), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?></a>
        <span style="color: #CBD5E1;">›</span>
        <?php endif; ?>
        <span style="color: #0A1629; font-weight: 600;" aria-current="page"><?php 
            $b_raw = html_entity_decode((string)($post['title'] ?? ''), ENT_QUOTES, 'UTF-8');
            $b_trimmed = mb_strlen($b_raw, 'UTF-8') > 65 ? mb_substr($b_raw, 0, 62, 'UTF-8') . '...' : $b_raw;
            echo htmlspecialchars($b_trimmed, ENT_QUOTES, 'UTF-8'); 
        ?></span>
    </div>
</nav>

<!-- Resource Hints for Performance -->
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="dns-prefetch" href="//www.googletagmanager.com">
<link rel="dns-prefetch" href="//www.google-analytics.com">

<!-- Preload Critical Resources -->
<link rel="preload" href="<?php echo SITE_URL; ?>/assets/css/style.css" as="style">
<link rel="preload" href="<?php echo $og_image; ?>" as="image">

<!-- CSS Styles -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="<?php echo htmlspecialchars($page_title); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta property="og:type" content="article">
<meta property="og:url" content="<?php echo $canonical_url; ?>">
<meta property="og:image" content="<?php echo $og_image; ?>">
<meta property="og:site_name" content="<?php echo htmlspecialchars($site_settings['name']); ?>">
<meta property="og:locale" content="en_IN">
<meta property="article:published_time" content="<?php echo date('c', strtotime($post['publish_date'])); ?>">
<meta property="article:modified_time" content="<?php echo date('c', strtotime($post['updated_at'] ?? $post['publish_date'])); ?>">
<?php if ($post['category_name']): ?>
<meta property="article:section" content="<?php echo htmlspecialchars($post['category_name']); ?>">
<?php endif; ?>

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo htmlspecialchars($page_title); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($page_description); ?>">
<meta name="twitter:image" content="<?php echo $og_image; ?>">
<meta name="twitter:creator" content="@choghadiya">

<!-- Article Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($article_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>

<!-- BreadcrumbList Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($breadcrumb_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>
</script>

<?php if ($faq_schema): ?>
<!-- FAQ Schema Markup -->
<script type="application/ld+json">
<?php echo json_encode($faq_schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
</script>
<?php endif; ?>

<!-- Reading Progress Bar -->
<div class="reading-progress-container">
    <div class="reading-progress-bar" id="readingProgress"></div>
</div>


<!-- Premium Article Section -->
<section class="section article-section-premium">
    <div class="container">
        <div class="article-layout-premium">
            
                        <!-- Main Content -->
            <div class="article-main-premium">
                <!-- Article Header -->
                <article class="article-premium">
                    <header class="article-header-premium">
                        <?php if ($post['category_name']): ?>
                        <a href="<?php echo SITE_URL; ?>/category/<?php echo $post['category_slug']; ?>" class="article-category-badge">
                            <i class="icon-folder"></i>
                            <?php echo htmlspecialchars($post['category_name']); ?>
                        </a>
                        <?php endif; ?>
                        
                        <h1 class="article-title-premium"><?php echo htmlspecialchars($post['title']); ?></h1>
                        
                        <!-- Compact Author Bio & Publication Meta Component (Article Top) -->
                        <div class="article-author-bio-compact" role="region" aria-label="लेखक और प्रकाशन विवरण">
                            <div class="author-bio-compact-left">
                                <a href="<?php echo $author_profile_url; ?>" class="author-compact-avatar-link" title="<?php echo htmlspecialchars($verified_author_name); ?> का परिचय देखें" aria-label="<?php echo htmlspecialchars($verified_author_name); ?>">
                                    <img src="<?php echo htmlspecialchars($verified_author_image); ?>" alt="<?php echo htmlspecialchars($verified_author_name); ?>" class="author-compact-avatar" width="52" height="52" loading="eager" decoding="async">
                                </a>
                                <div class="author-compact-meta">
                                    <div class="author-compact-name-row">
                                        <span class="author-compact-badge">लेखक</span>
                                        <a href="<?php echo $author_profile_url; ?>" class="author-compact-name" title="लेखक प्रोफाइल">
                                            <?php echo htmlspecialchars($verified_author_name); ?>
                                        </a>
                                        <span class="author-verified-indicator" title="सत्यापित लेखक">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#0D9488" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                                            <span class="verified-label">सत्यापित</span>
                                        </span>
                                    </div>
                                    <div class="author-compact-title">
                                        <?php echo htmlspecialchars($verified_author_role); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="author-bio-compact-right">
                                <div class="meta-date-row">
                                    <span class="meta-date-item">
                                        <i class="icon-calendar" aria-hidden="true"></i>
                                        <span class="date-label">प्रकाशित:</span>
                                        <time datetime="<?php echo date('Y-m-d', strtotime($post['publish_date'])); ?>" class="date-value"><?php echo format_date($post['publish_date']); ?></time>
                                    </span>
                                    <?php if (!empty($post['updated_at']) && date('Y-m-d', strtotime($post['updated_at'])) !== date('Y-m-d', strtotime($post['publish_date']))): ?>
                                    <span class="meta-date-divider">•</span>
                                    <span class="meta-date-item meta-date-updated" title="अंतिम संशोधन तिथि">
                                        <i class="fas fa-sync-alt" aria-hidden="true"></i>
                                        <span class="date-label">अपडेट:</span>
                                        <time datetime="<?php echo date('Y-m-d', strtotime($post['updated_at'])); ?>" class="date-value"><?php echo format_date($post['updated_at']); ?></time>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Featured Image -->
                    <?php if ($post['featured_image']): ?>
                    <div class="article-featured-image-premium">
                        <img src="<?php echo $post['featured_image']; ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" loading="lazy" decoding="async">
                    </div>
                    <?php endif; ?>

                    <!-- Auto-generated Table of Contents (after featured image, before content) -->
                    <?php if (!empty($toc_headings)): ?>
                    <div class="article-toc" id="articleToc">
                        <div class="toc-header" id="tocHeader">
                            <div class="toc-title">
                                <i class="fas fa-list-ul toc-icon"></i>
                                <span>Table of Contents / विषय सूची</span>
                            </div>
                            <button class="toc-toggle" id="tocToggle" aria-label="Toggle TOC">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="toc-content" id="tocContent">
                            <nav class="toc-nav" aria-label="Article sections">
                                <ol class="toc-list">
                                    <?php foreach ($toc_headings as $heading): ?>
                                    <li class="toc-item toc-level-<?php echo $heading['level']; ?>">
                                        <a href="#<?php echo $heading['id']; ?>" class="toc-link" data-target="<?php echo $heading['id']; ?>">
                                            <span class="toc-text"><?php echo htmlspecialchars($heading['text']); ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Sticky Share Buttons -->
                    <div class="share-buttons-sticky">
                        <button class="share-btn-sticky facebook" onclick="shareArticle('facebook')" title="Share on Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </button>
                        <button class="share-btn-sticky twitter" onclick="shareArticle('twitter')" title="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        <button class="share-btn-sticky whatsapp" onclick="shareArticle('whatsapp')" title="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                        <button class="share-btn-sticky linkedin" onclick="shareArticle('linkedin')" title="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </button>
                        <button class="share-btn-sticky copy" onclick="copyArticleLink()" title="Copy Link">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>

                    <!-- Article Content (with auto-injected heading IDs) -->
                    <div class="article-content-premium" id="articleContent">
                        <?php echo $processed_content; ?>
                    </div>

                    <!-- Tags -->
                    <?php if ($tags): ?>
                    <div class="article-tags-premium">
                        <h4><i class="icon-tag"></i> Tags</h4>
                        <div class="tags-list-premium">
                            <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo SITE_URL; ?>/tag/<?php echo $tag['slug']; ?>" class="tag-premium"><?php echo htmlspecialchars($tag['name']); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Social Share -->
                    <div class="article-share-premium">
                        <h4><i class="icon-share"></i> यह लेख साझें</h4>
                        <div class="share-buttons-premium">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/' . $post['slug']); ?>&t=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener" class="share-button-premium facebook" aria-label="Share on Facebook">
                                <i class="icon-facebook"></i>
                                <span>फेसबुक</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/' . $post['slug']); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener" class="share-button-premium twitter" aria-label="Share on Twitter">
                                <i class="icon-twitter"></i>
                                <span>ट्विटर</span>
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode($post['title'] . ' - ' . SITE_URL . '/' . $post['slug']); ?>" target="_blank" rel="noopener" class="share-button-premium whatsapp" aria-label="Share on WhatsApp">
                                <i class="icon-whatsapp"></i>
                                <span>व्हाट्सऐप</span>
                            </a>
                            <a href="https://t.me/share/url?url=<?php echo urlencode(SITE_URL . '/' . $post['slug']); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener" class="share-button-premium telegram" aria-label="Share on Telegram">
                                <i class="icon-send"></i>
                                <span>टेलीग्राम</span>
                            </a>
                            <button onclick="copyToClipboard('<?php echo SITE_URL . '/' . $post['slug']; ?>')" class="share-button-premium copy" aria-label="Copy Link">
                                <i class="icon-external"></i>
                                <span>लिंक कॉपी करें</span>
                            </button>
                        </div>
                    </div>
                </article>
                
                <!-- लेखक जानकारी (Bottom Author Bio Card) -->
                <div class="author-bio-premium" id="authorBio">
                    <div class="author-header-premium">
                        <div class="author-avatar-premium">
                            <a href="<?php echo $author_profile_url; ?>" title="<?php echo htmlspecialchars($verified_author_name); ?> का परिचय देखें">
                                <img src="<?php echo htmlspecialchars($verified_author_image); ?>" alt="<?php echo htmlspecialchars($verified_author_name); ?>" width="76" height="76" loading="lazy" decoding="async">
                            </a>
                        </div>
                        <div class="author-details-premium">
                            <div class="author-name-verified">
                                <h4><a href="<?php echo $author_profile_url; ?>" style="color: inherit; text-decoration: none;"><?php echo htmlspecialchars($verified_author_name); ?></a></h4>
                                <span class="verification-badge" title="सत्यापित लेखक">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="badge-text">सत्यापित लेखक</span>
                                </span>
                            </div>
                            <span class="author-role-premium"><?php echo htmlspecialchars($verified_author_role); ?></span>
                            <p><?php echo htmlspecialchars($verified_author_bio); ?></p>
                            <div class="author-meta-links">
                                <a href="<?php echo $author_profile_url; ?>" class="author-meta-link" title="लेखक प्रोफाइल देखें">
                                    <i class="fas fa-user-circle"></i> लेखक का संपूर्ण परिचय
                                </a>
                                <a href="mailto:<?php echo htmlspecialchars(AUTHOR_EMAIL); ?>" class="author-meta-link" title="Email the author">
                                    <i class="fas fa-envelope"></i> <?php echo htmlspecialchars(AUTHOR_EMAIL); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ Section with Accordion -->
                <?php if ($post_faqs): ?>
                <div class="faq-accordion-premium">
                    <h3><i class="fas fa-question-circle"></i> अक्सर पूछे जाने वाले प्रश्न</h3>
                    <div class="faq-list-accordion">
                        <?php foreach ($post_faqs as $index => $faq): ?>
                        <div class="faq-item-accordion <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="faq-question-accordion" onclick="toggleFAQ(this)">
                                <h4><?php echo htmlspecialchars($faq['question']); ?></h4>
                                <span class="faq-toggle-icon">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </div>
                            <div class="faq-answer-accordion">
                                <p><?php echo $faq['answer']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Related / Recommended Posts (always exactly 3) -->
                <?php if (!empty($related_posts)): ?>
                <div class="related-posts-premium" id="relatedPosts">
                    <h3><i class="fas fa-bookmark"></i> You May Also Like / आपके लिए सुझाव</h3>
                    <div class="related-posts-grid">
                        <?php foreach ($related_posts as $related): ?>
                        <article class="related-post-card">
                            <a href="<?php echo SITE_URL; ?>/<?php echo $related['slug']; ?>" class="related-post-image-link" aria-label="<?php echo htmlspecialchars($related['title']); ?>">
                                <div class="related-post-image">
                                    <?php if (!empty($related['featured_image'])): ?>
                                    <img src="<?php echo $related['featured_image']; ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" loading="lazy">
                                    <?php else: ?>
                                    <div class="related-post-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="related-post-content">
                                <?php if (!empty($related['category_name'])): ?>
                                <a href="<?php echo SITE_URL; ?>/category/<?php echo $related['category_slug']; ?>" class="related-post-category">
                                    <?php echo htmlspecialchars($related['category_name']); ?>
                                </a>
                                <?php endif; ?>
                                <h4 class="related-post-title">
                                    <a href="<?php echo SITE_URL; ?>/<?php echo $related['slug']; ?>">
                                        <?php echo htmlspecialchars($related['title']); ?>
                                    </a>
                                </h4>
                                <p class="related-post-excerpt">
                                    <?php
                                    $excerpt_text = !empty($related['excerpt'])
                                        ? $related['excerpt']
                                        : strip_tags($related['content']);
                                    echo htmlspecialchars(truncate_text($excerpt_text, 110));
                                    ?>
                                </p>
                                <div class="related-post-footer">
                                    <span class="related-post-date">
                                        <i class="far fa-calendar"></i>
                                        <?php echo format_date($related['publish_date']); ?>
                                    </span>
                                    <a href="<?php echo SITE_URL; ?>/<?php echo $related['slug']; ?>" class="related-post-readmore">
                                        Read More <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Comments Section -->
                <div class="comments-section-premium">
                    <h3><i class="icon-chat"></i> टिप्पणी छोड़ें</h3>
                    
                    <!-- Comment Form -->
                    <form class="comment-form-premium" action="<?php echo SITE_URL; ?>/includes/comment.php" method="POST">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <div class="form-row-premium">
                            <div class="form-group-premium">
                                <label for="author_name">आपका नाम *</label>
                                <input type="text" id="author_name" name="author_name" placeholder="अपना नाम दर्ज करें" required>
                            </div>
                            <div class="form-group-premium">
                                <label for="email">आपका ईमेल *</label>
                                <input type="email" id="email" name="email" placeholder="अपना ईमेल दर्ज करें" required>
                            </div>
                        </div>
                        <div class="form-group-premium">
                            <label for="comment">आपकी टिप्पणी *</label>
                            <textarea id="comment" name="comment" placeholder="अपनी टिप्पणी यहाँ लिखें..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-premium-primary">
                            <i class="icon-send"></i> टिप्पणी पोस्ट करें
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar -->
            <aside class="article-sidebar-premium">
                <!-- AdSense Sidebar -->
                <?php if ($site_settings['adsense_sidebar']): ?>
                <div class="sidebar-widget-premium adsense-widget-premium">
                    <?php echo $site_settings['adsense_sidebar']; ?>
                </div>
                <?php endif; ?>
                
                <!-- Recent Posts Widget -->
                <?php if ($recent_posts): ?>
                <div class="sidebar-widget-premium">
                    <h3 class="widget-title-premium"><i class="icon-clock"></i> Recent Posts</h3>
                    <div class="widget-posts-premium">
                        <?php foreach ($recent_posts as $recent): ?>
                        <a href="<?php echo SITE_URL; ?>/<?php echo $recent['slug']; ?>" class="widget-post-premium">
                            <div class="widget-post-image">
                                <?php if ($recent['featured_image']): ?>
                                <img src="<?php echo $recent['featured_image']; ?>" alt="<?php echo htmlspecialchars($recent['title']); ?>" loading="lazy">
                                <?php else: ?>
                                <div class="widget-post-placeholder">
                                    <i class="icon-document"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="widget-post-content">
                                <h5><?php echo htmlspecialchars($recent['title']); ?></h5>
                                <span class="widget-post-date">
                                    <i class="icon-calendar"></i> <?php echo format_date($recent['publish_date']); ?>
                                </span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Categories Widget -->
                <?php if ($categories): ?>
                <div class="sidebar-widget-premium">
                    <h3 class="widget-title-premium"><i class="icon-folder"></i> Categories</h3>
                    <div class="widget-categories-premium">
                        <?php foreach ($categories as $category): ?>
                        <a href="<?php echo SITE_URL; ?>/category/<?php echo $category['slug']; ?>" class="widget-category-premium">
                            <span><?php echo htmlspecialchars($category['name']); ?></span>
                            <i class="icon-arrow-right"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </aside>
        </div>
    </div>
</section>

<style>
/* ============================================================
   PROFESSIONAL HINDI FONT SETUP — SINGLE POST PAGE ONLY
   ------------------------------------------------------------
   Fonts (Poppins 300–700 + Noto Sans Devanagari 400–700) are
   already preloaded site-wide via header_responsive.php with
   <link rel="preconnect"> + <link rel="stylesheet"> for best
   Core Web Vitals. No @import here (avoids render-blocking
   duplicate fetch).

   Scoped to .article-content-premium so it ONLY affects single
   post body content, never the homepage / navbar / header.
   ============================================================ */

/* Headings: Poppins Bold */
.article-content-premium h1,
.article-content-premium h2,
.article-content-premium h3,
.article-content-premium h4,
.article-content-premium h5,
.article-content-premium h6 {
    font-family: 'Poppins', 'Noto Sans Devanagari', sans-serif;
    font-weight: 700;
    letter-spacing: -0.01em;
}

/* Body text (paragraphs, lists, quotes, table cells): Noto Sans Devanagari */
.article-content-premium p,
.article-content-premium li,
.article-content-premium blockquote,
.article-content-premium td,
.article-content-premium th {
    font-family: 'Noto Sans Devanagari', 'Poppins', sans-serif;
    font-size: 19px;
    line-height: 1.9;
    font-weight: 400;
}

/* ============================================================
   INLINE INTERNAL LINKS — SEO-Friendly Styling
   ============================================================ */
.article-content-premium a.internal-link {
    color: #EA580C;
    text-decoration: none;
    border-bottom: 2px solid rgba(234, 88, 12, 0.35);
    transition: all 0.2s ease;
    font-weight: 600;
}

.article-content-premium a.internal-link:hover {
    color: #C2410C;
    border-bottom-color: #EA580C;
    background: #FFF7ED;
}

/* ============================================================
   RESPONSIVE FONT SIZES (mobile readability)
   ============================================================ */
@media (max-width: 768px) {
    .article-content-premium p,
    .article-content-premium li,
    .article-content-premium blockquote,
    .article-content-premium td,
    .article-content-premium th {
        font-size: 17px;
        line-height: 1.8;
    }
}

@media (max-width: 480px) {
    .article-content-premium p,
    .article-content-premium li,
    .article-content-premium blockquote,
    .article-content-premium td,
    .article-content-premium th {
        font-size: 16px;
        line-height: 1.7;
    }
}

/* Article Layout Styles (Pure White Background) */
.article-section-premium {
    background: #FFFFFF !important;
}

.article-layout-premium {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    align-items: start;
    background: #FFFFFF !important;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .article-layout-premium {
        grid-template-columns: 1fr 300px;
    }
}

@media (max-width: 768px) {
    .article-layout-premium {
        grid-template-columns: 1fr;
        gap: 30px;
    }
}

/* Smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

/* Highlight target heading when scrolled to */
:target {
    scroll-margin-top: 100px;
    animation: highlightHeading 1.5s ease;
}

@keyframes highlightHeading {
    0% {
        background: rgba(255, 112, 0, 0.12);
        border-radius: 8px;
        padding: 6px 12px;
        margin: -6px -12px;
    }
    100% {
        background: transparent;
    }
}
</style>

<script>
// Premium TOC Functionality
document.addEventListener('DOMContentLoaded', function() {
    const tocHeader = document.getElementById('tocHeader');
    const tocToggle = document.getElementById('tocToggle');
    const tocContent = document.getElementById('tocContent');
    const articleToc = document.getElementById('articleToc');
    
    // Mobile Accordion Toggle
    if (tocHeader && tocToggle && tocContent) {
        tocHeader.addEventListener('click', function() {
            const isMobile = window.innerWidth <= 768;
            
            if (isMobile) {
                tocToggle.classList.toggle('active');
                tocContent.classList.toggle('show');
            }
        });
    }
    
    // Sticky Sidebar TOC for Desktop
    function setupStickyTOC() {
        if (window.innerWidth > 1024 && articleToc) {
            // Add sticky class to TOC
            articleToc.classList.add('sticky');
        } else if (articleToc) {
            // Remove sticky class on mobile
            articleToc.classList.remove('sticky');
        }
    }
    
    setupStickyTOC();
    window.addEventListener('resize', setupStickyTOC);
    
    // Smooth scrolling for TOC links
    const tocLinks = document.querySelectorAll('.toc-link');
    
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offset = 80; // Header height
                const targetPosition = targetElement.offsetTop - offset;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Update active state
                updateActiveTOC(targetId);
                
                // Close mobile TOC after click
                if (tocContent && tocContent.classList.contains('show')) {
                    tocToggle.classList.remove('active');
                    tocContent.classList.remove('show');
                }
            }
        });
    });
    
    // Update active TOC on scroll
    function updateActiveTOC(activeId) {
        // Remove active class from all links
        tocLinks.forEach(link => {
            link.classList.remove('active');
        });
        
        // Add active class to current links
        const activeLinks = document.querySelectorAll(`.toc-link[data-target="${activeId}"]`);
        activeLinks.forEach(link => {
            link.classList.add('active');
        });
    }
    
    // Intersection Observer for active TOC
    const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    
    if (headings.length > 0) {
        const headingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateActiveTOC(entry.target.id);
                }
            });
        }, {
            rootMargin: '-20% 0px -70% 0px'
        });
        
        headings.forEach(heading => {
            if (heading.id) {
                headingObserver.observe(heading);
            }
        });
    }
    
    // Fallback: Update active TOC on scroll
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        
        scrollTimeout = setTimeout(() => {
            const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
            let currentHeading = null;
            
            headings.forEach(heading => {
                const rect = heading.getBoundingClientRect();
                if (rect.top <= 100 && rect.bottom > 100) {
                    currentHeading = heading;
                }
            });
            
            if (currentHeading) {
                updateActiveTOC(currentHeading.id);
            }
        }, 100);
    });
    
    // Initialize mobile state
    if (window.innerWidth <= 768 && tocContent) {
        tocContent.classList.remove('show');
    }
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        console.error('Failed to copy: ', err);
    });
}

// Reading Progress Bar
document.addEventListener('DOMContentLoaded', function() {
    const progressBar = document.getElementById('readingProgress');
    const article = document.querySelector('.article-content-premium');
    
    if (progressBar && article) {
        window.addEventListener('scroll', function() {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const scrollTop = window.pageYOffset;
            const windowHeight = window.innerHeight;
            
            if (scrollTop > articleTop) {
                const scrollPercent = Math.min(
                    ((scrollTop - articleTop) / (articleHeight - windowHeight)) * 100,
                    100
                );
                progressBar.style.width = scrollPercent + '%';
            } else {
                progressBar.style.width = '0%';
            }
        });
    }
});

// Article Sharing Functions
function shareArticle(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    let shareUrl = '';
    
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
            break;
        case 'whatsapp':
            shareUrl = `https://wa.me/?text=${title}%20-%20${url}`;
            break;
        case 'linkedin':
            shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

function copyArticleLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(function() {
        // Show success message
        const btn = document.querySelector('.share-btn-sticky.copy');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.background = '#28a745';
        
        setTimeout(function() {
            btn.innerHTML = originalHTML;
            btn.style.background = '#6c757d';
        }, 2000);
    }, function(err) {
        console.error('Failed to copy: ', err);
    });
}

// FAQ Accordion Toggle
function toggleFAQ(element) {
    const faqItem = element.parentElement;
    const isActive = faqItem.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item-accordion').forEach(item => {
        item.classList.remove('active');
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
        faqItem.classList.add('active');
    }
}


// Performance Monitoring
document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset-src) {
                        img.src = img.dataset.src;
                        img.classList.add('loaded');
                        observer.unobserve(img);
                    }
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Core Web Vitals monitoring
    if ('PerformanceObserver' in window) {
        // Largest Contentful Paint
        new PerformanceObserver((entryList) => {
            for (const entry of entryList.getEntries()) {
                console.log('LCP:', entry.startTime);
            }
        }).observe({ entryTypes: ['largest-contentful-paint'] });
        
        // First Input Delay
        new PerformanceObserver((entryList) => {
            for (const entry of entryList.getEntries()) {
                console.log('FID:', entry.processingStart - entry.startTime);
            }
        }).observe({ entryTypes: ['first-input'] });
        
        // Cumulative Layout Shift
        let clsValue = 0;
        new PerformanceObserver((entryList) => {
            for (const entry of entryList.getEntries()) {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                }
            }
            console.log('CLS:', clsValue);
        }).observe({ entryTypes: ['layout-shift'] });
    }
});
</script>

<style>
/* Reading Progress Bar */
.reading-progress-container {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: rgba(255, 112, 0, 0.15);
    z-index: 1001;
}

.reading-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #FF7000, #EA580C);
    width: 0%;
    transition: width 0.1s ease;
}

/* Breadcrumb Navigation */
.breadcrumb-premium {
    background: #FFFFFF;
    padding: 15px 0;
    border-bottom: 1px solid #E2E8F0;
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
    gap: 8px;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    font-size: 14px;
}

.breadcrumb-item:not(:last-child)::after {
    content: '/';
    margin-left: 8px;
    color: #CBD5E1;
}

.breadcrumb-item a {
    color: #64748B;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: color 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #FF7000;
}

.breadcrumb-item.active {
    color: #0A1629;
    font-weight: 600;
}

/* Sticky Share Buttons */
.share-buttons-sticky {
    position: fixed;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 100;
}

.share-btn-sticky {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.share-btn-sticky:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.share-btn-sticky.facebook { background: #3b5998; }
.share-btn-sticky.twitter { background: #1da1f2; }
.share-btn-sticky.whatsapp { background: #25d366; }
.share-btn-sticky.linkedin { background: #0077b5; }
.share-btn-sticky.copy { background: #6c757d; }

@media (max-width: 1200px) {
    .share-buttons-sticky {
        position: static;
        transform: none;
        flex-direction: row;
        justify-content: center;
        margin: 20px 0;
        padding: 15px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
}

/* ============================================================
   COMPACT AUTHOR BIO & PUBLICATION METADATA (ARTICLE TOP)
   ============================================================ */
.article-author-bio-compact {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    padding: 0.85rem 1.25rem;
    margin: 1.25rem 0 1.75rem 0;
    box-shadow: 0 2px 10px rgba(10, 22, 41, 0.04);
}

.author-bio-compact-left {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    min-width: 0;
}

.author-compact-avatar-link {
    display: block;
    flex-shrink: 0;
    border-radius: 50%;
    transition: transform 0.2s ease;
}

.author-compact-avatar-link:hover {
    transform: scale(1.05);
}

.author-compact-avatar {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid #FED7AA;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.15);
    display: block;
}

.author-compact-meta {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    min-width: 0;
}

.author-compact-name-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.author-compact-badge {
    background: #FFF7ED;
    color: #EA580C;
    border: 1px solid #FED7AA;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 9999px;
    letter-spacing: 0.02em;
    line-height: 1.3;
}

.author-compact-name {
    font-size: 1.02rem;
    font-weight: 800;
    color: #0A1629;
    text-decoration: none;
    line-height: 1.3;
    transition: color 0.2s ease;
}

.author-compact-name:hover {
    color: #FF7000;
    text-decoration: underline;
}

.author-verified-indicator {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: #F0FDF4;
    color: #0D9488;
    border: 1px solid #BBF7D0;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 9999px;
}

.author-compact-title {
    font-size: 0.8rem;
    color: #64748B;
    font-weight: 500;
    line-height: 1.3;
}

.author-bio-compact-right {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.meta-date-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.65rem;
    font-size: 0.82rem;
    color: #64748B;
}

.meta-date-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

.meta-date-item i {
    color: #FF7000;
    font-size: 0.85rem;
}

.meta-date-item .date-label {
    color: #64748B;
    font-weight: 500;
}

.meta-date-item .date-value {
    color: #0A1629;
    font-weight: 700;
}

.meta-date-divider {
    color: #CBD5E1;
}

@media (max-width: 640px) {
    .article-author-bio-compact {
        flex-direction: column;
        align-items: flex-start;
        padding: 0.85rem 1rem;
        gap: 0.75rem;
    }
    .author-bio-compact-right {
        width: 100%;
        padding-top: 0.65rem;
        border-top: 1px solid #F1F5F9;
    }
}

/* Bottom Author Bio Card Enhancements */
.author-bio-premium {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 18px;
    padding: 1.75rem;
    margin: 2rem 0;
    box-shadow: 0 4px 16px rgba(10, 22, 41, 0.04);
}

.author-header-premium {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.author-avatar-premium img {
    width: 76px;
    height: 76px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #FED7AA;
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15);
}

.author-details-premium h4 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 800;
    color: #0A1629;
}

.author-role-premium {
    display: inline-block;
    color: #EA580C;
    font-weight: 700;
    font-size: 0.82rem;
    text-transform: uppercase;
    margin: 0.25rem 0 0.5rem 0;
}

.author-details-premium p {
    font-size: 0.92rem;
    line-height: 1.65;
    color: #475569;
    margin: 0.5rem 0 1rem 0;
}

.author-meta-links {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.author-meta-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: #0A1629;
    text-decoration: none;
    transition: color 0.2s;
}

.author-meta-link:hover {
    color: #FF7000;
}

@media (max-width: 640px) {
    .author-header-premium {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .author-name-verified {
        justify-content: center;
    }
    .author-meta-links {
        justify-content: center;
    }
}

/* Author Verification Badge */
.author-name-verified {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 5px;
}

.author-name-verified h4 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
}

.verification-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #FFF7ED;
    border: 1px solid #FED7AA;
    color: #EA580C;
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.verification-badge i {
    font-size: 12px;
}

.badge-text {
    font-size: 10px;
}

/* FAQ Accordion Enhancement */
.faq-accordion-premium {
    margin: 30px 0;
}

.faq-item-accordion {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    margin-bottom: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.faq-item-accordion.active {
    border-color: #FF7000;
    box-shadow: 0 4px 15px rgba(255, 112, 0, 0.08);
}

.faq-question-accordion {
    padding: 20px 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.2s ease;
    background: #FFFFFF;
}

.faq-question-accordion:hover {
    background: #FFF7ED;
}

.faq-question-accordion h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #0A1629;
}

.faq-toggle-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #FFF7ED;
    border: 1px solid #FED7AA;
    color: #EA580C;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
}

.faq-item-accordion.active .faq-toggle-icon {
    transform: rotate(180deg);
}

.faq-answer-accordion {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease, padding 0.3s ease;
    background: #FFFFFF;
}

.faq-item-accordion.active .faq-answer-accordion {
    max-height: 500px;
    padding: 0 25px 20px;
}

.faq-answer-accordion p {
    margin: 0;
    color: #475569;
    line-height: 1.7;
}

/* Related Posts Enhancement */
.related-posts-premium {
    margin: 40px 0;
    padding: 30px;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
}

.related-posts-premium h3 {
    margin: 0 0 25px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0A1629;
    display: flex;
    align-items: center;
    gap: 10px;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.related-post-card {
    background: #FFFFFF;
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid #E2E8F0;
}

.related-post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(10, 22, 41, 0.08);
    border-color: #FED7AA;
}

.related-post-image {
    height: 150px;
    background: #F8FAFC;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748B;
    font-size: 24px;
}

.related-post-content {
    padding: 20px;
    background: #FFFFFF;
}

.related-post-content h4 {
    margin: 0 0 10px 0;
    font-size: 15px;
    font-weight: 700;
    color: #0A1629;
    line-height: 1.4;
}

.related-post-content span {
    font-size: 13px;
    color: #64748B;
}

/* ============================================================
   ENHANCED TOC + RELATED POSTS - Professional Upgrade
   ============================================================ */

/* Article TOC - Professional styling */
.article-toc {
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-left: 4px solid #FF7000;
    border-radius: 14px;
    margin: 24px 0 32px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(10, 22, 41, 0.04);
}
.article-toc .toc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    cursor: pointer;
    user-select: none;
    background: #FFFFFF;
    border-bottom: 1px solid #F8FAFC;
}
.article-toc .toc-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #0A1629;
    letter-spacing: 0.2px;
}
.article-toc .toc-icon { color: #FF7000; font-size: 16px; }
.article-toc .toc-toggle {
    background: transparent;
    border: none;
    color: #64748B;
    font-size: 14px;
    width: 32px; height: 32px;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s ease;
}
.article-toc .toc-toggle:hover { background: #FFF7ED; color: #EA580C; }
.article-toc .toc-toggle.active i { transform: rotate(180deg); }
.article-toc .toc-toggle i { transition: transform 0.25s ease; }
.article-toc .toc-content { padding: 6px 18px 16px; background: #FFFFFF; }
.article-toc .toc-list {
    list-style: none;
    margin: 0;
    padding: 0;
    counter-reset: toc-counter;
}
.article-toc .toc-item {
    counter-increment: toc-counter;
    margin: 0;
    padding: 0;
}
.article-toc .toc-link {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 8px 10px 8px 0;
    color: #334155;
    text-decoration: none;
    font-size: 14.5px;
    line-height: 1.5;
    border-radius: 6px;
    transition: all 0.2s ease;
    border-left: 3px solid transparent;
    padding-left: 12px;
}
.article-toc .toc-link::before {
    content: counter(toc-counter) ".";
    color: #94A3B8;
    font-weight: 600;
    min-width: 22px;
}
.article-toc .toc-link:hover {
    color: #EA580C;
    background: #FFF7ED;
    border-left-color: #FED7AA;
}
.article-toc .toc-link.active {
    color: #EA580C;
    background: #FFF7ED;
    border-left-color: #FF7000;
    font-weight: 600;
}
.article-toc .toc-level-3 { padding-left: 18px; }
.article-toc .toc-level-3 .toc-link { font-size: 13.5px; color: #475569; }

/* Smooth-scroll target offset for sticky header */
.article-content-premium h2,
.article-content-premium h3 {
    scroll-margin-top: 90px;
}

/* Related posts - excerpt + read more */
.related-post-card {
    display: flex;
    flex-direction: column;
    background: #FFFFFF;
    border: 1px solid #E2E8F0;
    border-radius: 14px;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.related-post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(10, 22, 41, 0.08);
    border-color: #FED7AA;
}
.related-post-image-link { display: block; }
.related-post-image {
    height: 170px;
    background: #F8FAFC;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748B;
    overflow: hidden;
}
.related-post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.related-post-card:hover .related-post-image img { transform: scale(1.05); }
.related-post-placeholder { font-size: 28px; opacity: 0.85; }
.related-post-content {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 16px 18px 18px;
    flex: 1;
    background: #FFFFFF;
}
.related-post-category {
    display: inline-block;
    align-self: flex-start;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    color: #EA580C;
    background: #FFF7ED;
    border: 1px solid #FED7AA;
    padding: 3px 10px;
    border-radius: 999px;
    text-decoration: none;
}
.related-post-title { margin: 4px 0 0; font-size: 16px; font-weight: 700; line-height: 1.4; }
.related-post-title a { color: #0A1629; text-decoration: none; }
.related-post-title a:hover { color: #FF7000; }
.related-post-excerpt {
    margin: 0;
    color: #64748B;
    font-size: 13.5px;
    line-height: 1.55;
}
.related-post-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 8px;
    border-top: 1px dashed #E2E8F0;
}
.related-post-date {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: #94A3B8;
}
.related-post-readmore {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #FF7000;
    text-decoration: none;
    transition: gap 0.2s ease;
}
.related-post-readmore:hover { gap: 10px; color: #EA580C; }

/* Mobile collapse for TOC */
@media (max-width: 768px) {
    .article-toc .toc-content { display: none; }
    .article-toc .toc-content.show { display: block; }
    .article-toc .toc-toggle { display: inline-flex; align-items: center; justify-content: center; }
    .related-posts-grid { grid-template-columns: 1fr; }
}

/* Desktop sticky note: only highlight, don't actually fix-position to keep layout intact */
@media (min-width: 1025px) {
    .article-toc { position: relative; }
}
</style>

<!-- Include footer -->
<?php require_once __DIR__ . '/../includes/footer.php'; ?>