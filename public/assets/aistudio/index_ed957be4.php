<?php

define("NITROPACK_HOME_URL", "https://choghadiyas.in");
define("NITROPACK_SITE_ID", "AuAuPlrAuxFFFcCsnzoeDqoYhKYfiZRt");
define("NITROPACK_SITE_SECRET", "0bSFGJIycpBAtrBmofMvf3LoYD3dFPtoT2WvF26urFQwK5NU0qAZcVowW2b8iWUI");

include_once __DIR__ . "/nitropack-sdk/bootstrap.php";
/**
 * Main Router
 * Choghadiya Muhurat Website
 * SEO-friendly routing system
 */

// Load configuration
require_once __DIR__ . '/config/config.php';

// Check if tables exist (graceful fallback)
try {
    $test = db_fetch_one("SELECT 1 FROM categories LIMIT 1");
} catch (Exception $e) {
    // Database not set up - return 503 Service Unavailable (NOT 200 OK with 404 template)
    header("HTTP/1.1 503 Service Unavailable");
    header("Retry-After: 3600");
    require_once __DIR__ . '/templates/404.php';
    exit;
}

// Get the requested URI
$request_uri = $_SERVER['REQUEST_URI'];

// Handle sitemap.xml
if (strpos($request_uri, '/sitemap.xml') !== false) {
    require_once __DIR__ . '/sitemap.xml.php';
    exit;
}

// Redirect /articles to /search
if ($request_uri === '/articles' || strpos($request_uri, '/articles?') === 0) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: " . SITE_URL . "/search");
    exit;
}

// Get the base path
$base_path = dirname($_SERVER['SCRIPT_NAME']);
if ($base_path == '/' || $base_path == '\\') {
    $base_path = '';
}

// Remove base path from URI
$request_uri = str_replace($base_path, '', $request_uri);
$request_uri = parse_url($request_uri, PHP_URL_PATH);
$request_uri = trim($request_uri, '/');

// Split URI into segments
$segments = !empty($request_uri) ? explode('/', $request_uri) : [];

// Route handling
$route = !empty($segments[0]) ? $segments[0] : 'home';
$id = $segments[1] ?? null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// Check for /article/slug pattern
if ($route === 'article' && !empty($segments[1])) {
    $post_slug = $segments[1];
    $post = db_fetch_one("SELECT id, slug FROM posts WHERE slug = ? AND status = 'published'", [$post_slug]);
    if ($post) {
        $_GET['slug'] = $post_slug;
        require_once __DIR__ . '/templates/single.php';
        exit;
    }
}

// Define routes
$routes = [
    'home' => 'home.php',
    'category' => 'category.php',
    'tag' => 'tag.php',
    'author' => 'author.php',
    'search' => 'search.php',
    'about' => 'about.php',
    'contact' => 'contact.php',
    'privacy-policy' => 'privacy-policy.php',
    'disclaimer' => 'disclaimer.php',
    'terms' => 'terms.php',
    'editorial-policy' => 'editorial-policy.php',
    'dmca' => 'dmca.php',
];

// If route is empty, go to home
if ($route === '' || $route === 'home') {
    $route = 'home';
    require_once __DIR__ . '/templates/home.php';
    exit;
}

// Check if it's in routes array
if (isset($routes[$route])) {
    // Pass the second URL segment as slug for routes that need it
    if (in_array($route, ['category', 'tag', 'author'], true) && !empty($segments[1])) {
        $_GET['slug'] = $segments[1];
    }
    $template_file = __DIR__ . '/templates/' . $routes[$route];
    if (file_exists($template_file)) {
        require_once $template_file;
        exit;
    }
}

// Check if it's a post slug
$post = db_fetch_one("SELECT id, slug FROM posts WHERE slug = ? AND status = 'published'", [$route]);
if ($post) {
    $_GET['slug'] = $route;
    require_once __DIR__ . '/templates/single.php';
    exit;
}

// Check if it's a category slug
$category = db_fetch_one("SELECT id, slug FROM categories WHERE slug = ? AND status = 'active'", [$route]);
if ($category) {
    $_GET['slug'] = $route;
    require_once __DIR__ . '/templates/category.php';
    exit;
}

// Check if it's a tag slug
$tag = db_fetch_one("SELECT id, slug FROM tags WHERE slug = ?", [$route]);
if ($tag) {
    $_GET['slug'] = $route;
    require_once __DIR__ . '/templates/tag.php';
    exit;
}

http_response_code(404);
require_once __DIR__ . '/templates/404.php';
exit;
