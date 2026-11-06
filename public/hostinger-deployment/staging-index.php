<?php
/**
 * Choghadiyas.in — Staging Test Controller
 * Isolated staging environment for testing template fixes safely without touching production.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure Staging Mode is flagged
define('IS_STAGING_PREVIEW', true);

// Load base configuration and database
require_once __DIR__ . '/../config/config.php';

// Route selection via query parameter or clean URL
$route = $_GET['route'] ?? 'home';
$slug = $_GET['slug'] ?? '';

// Support clean URLs within staging-test: /staging-test/category/vrat-tyohar or /staging-test/my-article-slug
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
$staging_uri = preg_replace('#^/staging-test/?#', '', $uri);
if (!empty($staging_uri) && !preg_match('#\.(php|css|js|png|jpg|webp|ico|svg)$#i', $staging_uri)) {
    if (preg_match('#^category/([^/]+)/?$#', $staging_uri, $m)) {
        $route = 'category';
        $slug = $m[1];
    } elseif ($staging_uri !== 'index.php' && $staging_uri !== '') {
        $route = 'single';
        $slug = trim($staging_uri, '/');
    }
}

// 1. PHP Syntax Check Diagnostic Route (Pure Token Parser, zero shell dependencies)
if ($route === 'syntax') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "=== HOSTINGER PHP SYNTAX CHECK REPORT ===\n";
    echo "PHP Version: " . PHP_VERSION . "\n";
    echo "Date: " . date('Y-m-d H:i:s T') . "\n\n";

    $test_files = [
        'includes/header.php',
        'includes/header_responsive.php',
        'includes/footer.php',
        'includes/footer_responsive.php',
        'templates/home.php',
        'templates/single.php',
        'templates/category.php'
    ];

    $all_passed = true;
    foreach ($test_files as $rel) {
        $file_path = __DIR__ . '/' . $rel;
        if (!file_exists($file_path)) {
            echo "[FAIL] File missing: $rel\n";
            $all_passed = false;
            continue;
        }

        $code = file_get_contents($file_path);
        try {
            token_get_all($code, TOKEN_PARSE);
            echo "[PASS] $rel: No syntax errors detected.\n";
        } catch (\ParseError $e) {
            echo "[FAIL] $rel: Parse error on line " . $e->getLine() . ": " . $e->getMessage() . "\n";
            $all_passed = false;
        } catch (\Throwable $t) {
            echo "[FAIL] $rel: " . $t->getMessage() . "\n";
            $all_passed = false;
        }
    }

    echo "\nOverall Syntax Result: " . ($all_passed ? "ALL TESTS PASSED (100% CLEAN)" : "FAILURES DETECTED") . "\n";
    exit;
}

// 2. Single Article Preview
if ($route === 'single') {
    if (empty($slug)) {
        // Pick first published post
        $first_post = db_fetch_one("SELECT slug FROM posts WHERE status = 'published' ORDER BY publish_date DESC LIMIT 1");
        $slug = $first_post['slug'] ?? 'chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri';
    }
    $_GET['slug'] = $slug;
    require_once __DIR__ . '/templates/single.php';
    exit;
}

// 3. Category Archive Preview
if ($route === 'category') {
    if (empty($slug)) {
        $slug = 'vrat-tyohar';
    }
    $_GET['slug'] = $slug;
    require_once __DIR__ . '/templates/category.php';
    exit;
}

// 4. Default: Staging Homepage
require_once __DIR__ . '/templates/home.php';
