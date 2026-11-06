<?php
/**
 * Choghadiyas.in
 * Dynamic XML Sitemap Generator
 *
 * Public URL:
 * https://choghadiyas.in/sitemap.xml
 */

header('Content-Type: application/xml; charset=utf-8');

require_once __DIR__ . '/config/config.php';


/**
 * Add URL to sitemap
 */
function add_sitemap_url(
    SimpleXMLElement $xml,
    string $loc,
    ?string $lastmod = null,
    string $changefreq = 'monthly',
    string $priority = '0.5'
): void {

    $url = $xml->addChild('url');

    $url->addChild(
        'loc',
        htmlspecialchars($loc, ENT_XML1, 'UTF-8')
    );

    if (!empty($lastmod)) {
        $url->addChild(
            'lastmod',
            htmlspecialchars($lastmod, ENT_XML1, 'UTF-8')
        );
    }

    $url->addChild('changefreq', $changefreq);
    $url->addChild('priority', $priority);
}


/**
 * Create XML document
 */
$xml = new SimpleXMLElement(
    '<?xml version="1.0" encoding="UTF-8"?>' .
    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>'
);


/* ============================================================
   1. HOMEPAGE
   ============================================================ */

add_sitemap_url(
    $xml,
    rtrim(SITE_URL, '/') . '/',
    null,
    'daily',
    '1.0'
);


/* ============================================================
   2. STATIC PAGES
   ============================================================ */

$static_pages = [

    'about' => [
        'changefreq' => 'monthly',
        'priority'   => '0.6'
    ],

    'contact' => [
        'changefreq' => 'monthly',
        'priority'   => '0.5'
    ],

    'privacy-policy' => [
        'changefreq' => 'yearly',
        'priority'   => '0.3'
    ],

    'terms' => [
        'changefreq' => 'yearly',
        'priority'   => '0.3'
    ],

    'disclaimer' => [
        'changefreq' => 'yearly',
        'priority'   => '0.3'
    ],

    'editorial-policy' => [
        'changefreq' => 'yearly',
        'priority'   => '0.3'
    ],

    'dmca' => [
        'changefreq' => 'yearly',
        'priority'   => '0.3'
    ],

];


foreach ($static_pages as $slug => $page) {

    add_sitemap_url(
        $xml,
        rtrim(SITE_URL, '/') . '/' . $slug,
        null,
        $page['changefreq'],
        $page['priority']
    );
}


/* ============================================================
   3. CATEGORIES
   ============================================================ */

try {

    $categories = db_fetch_all(
        "SELECT slug
         FROM categories
         WHERE status = 'active'
         ORDER BY slug ASC"
    );

    if (!empty($categories)) {

        foreach ($categories as $category) {

            if (empty($category['slug'])) {
                continue;
            }

            add_sitemap_url(
                $xml,
                rtrim(SITE_URL, '/') .
                '/category/' .
                rawurlencode($category['slug']),
                null,
                'weekly',
                '0.6'
            );
        }
    }

} catch (Exception $e) {

    // Continue sitemap generation if category query fails.

}


/* ============================================================
   4. ALL PUBLISHED POSTS
   ============================================================ */

try {

    $posts = db_fetch_all(
        "SELECT slug, publish_date
         FROM posts
         WHERE status = 'published'
         ORDER BY publish_date DESC"
    );

    if (!empty($posts)) {

        foreach ($posts as $post) {

            if (empty($post['slug'])) {
                continue;
            }

            $lastmod = null;

            if (!empty($post['publish_date'])) {

                $timestamp = strtotime($post['publish_date']);

                if ($timestamp !== false) {
                    $lastmod = date('Y-m-d', $timestamp);
                }
            }

            add_sitemap_url(
                $xml,
                rtrim(SITE_URL, '/') .
                '/' .
                rawurlencode($post['slug']),
                $lastmod,
                'monthly',
                '0.7'
            );
        }
    }

} catch (Exception $e) {

    // Continue sitemap generation if post query fails.

}


/* ============================================================
   5. OUTPUT XML
   ============================================================ */

echo $xml->asXML();

exit;