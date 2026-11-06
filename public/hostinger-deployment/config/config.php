<?php
/**
 * Site Configuration
 * Choghadiya Muhurat Website
 */

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Site Configuration
define('SITE_NAME', 'Choghadiya Muhurat');
define('SITE_TAGLINE', 'भारत का सबसे विश्वसनीय शुभ समय प्लेटफॉर्म');
define('SITE_URL', 'https://choghadiyas.in');
define('SITE_DESCRIPTION', 'आपके सभी महत्वपूर्ण अवसरों के लिए सटीक चौघड़िया समय, मुहूर्त, पंचांग और त्योहार जानकारी प्राप्त करें।');
define('SITE_KEYWORDS', 'चौघड़िया, choghadiya, muhurat, panchang, auspicious time, festival, hindu calendar');

// Admin Configuration
define('ADMIN_URL', SITE_URL . '/admin');
define('ADMIN_EMAIL', 'contact@choghadiyas.in');

// Author Configuration
define('AUTHOR_NAME', 'Shiv Kumar Pandit');
define('AUTHOR_EMAIL', 'contact@choghadiyas.in');
define('AUTHOR_BIO', 'Vedic Author & Spiritual Content Researcher. Dedicated to sharing authentic Choghadiya, Panchang, Muhurat, and Vedic knowledge in a simple and reader-friendly way to help people understand traditional Hindu timing and spiritual guidance better.');

// Official Contact / Business Address (used in schema, footer, contact, policy pages)
define('OFFICE_STREET',     '5th Floor, Opposite Lane, Abhijeet Court, Office 402-403, 13, Bhandarkar Road');
define('OFFICE_LOCALITY',   'Pune');
define('OFFICE_REGION',     'Maharashtra');
define('OFFICE_POSTAL_CODE','411004');
define('OFFICE_COUNTRY',    'IN');
define('OFFICE_ADDRESS_FULL', '5th Floor, Opposite Lane, Abhijeet Court, Office 402-403, 13, Bhandarkar Road, Pune, Maharashtra 411004, India');

// File Upload Configuration
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif']);

// Pagination
define('POSTS_PER_PAGE', 10);
define('ADMIN_POSTS_PER_PAGE', 20);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Navamsha API configuration. Keep this key server-side; do not print it in HTML.
if (!defined('NAVAMSHA_API_KEY')) {
    define('NAVAMSHA_API_KEY', 'vda_live_98cf5c40_r-llRAtb2b_7KDYyPGhEAOzl1K4H35Kz_E3CYzbufWw');
}

// Include Database Configuration
require_once __DIR__ . '/database.php';

// Load Settings from Database
function get_setting($key, $default = '') {
    $setting = db_fetch_one("SELECT setting_value FROM site_settings WHERE setting_key = ?", [$key]);
    return $setting ? $setting['setting_value'] : $default;
}

// Clear Settings Cache
function clear_settings_cache() {
    // This function can be expanded to use actual caching mechanisms like Redis or file-based cache
    // For now, it's a placeholder for future implementation
    if (isset($_SESSION['settings_cache'])) {
        unset($_SESSION['settings_cache']);
    }
}

// Get all settings with cache-busting
function get_all_settings() {
    if (isset($_SESSION['settings_cache']) && $_SESSION['settings_cache_time'] > time() - 300) {
        return $_SESSION['settings_cache'];
    }
    
    $settings = db_fetch_all("SELECT setting_key, setting_value FROM site_settings");
    $settings_array = [];
    foreach ($settings as $setting) {
        $settings_array[$setting['setting_key']] = $setting['setting_value'];
    }
    
    $_SESSION['settings_cache'] = $settings_array;
    $_SESSION['settings_cache_time'] = time();
    
    return $settings_array;
}

// Site Settings
$site_settings = [
    'name' => get_setting('site_name', SITE_NAME),
    'tagline' => get_setting('site_tagline', SITE_TAGLINE),
    'description' => get_setting('site_description', SITE_DESCRIPTION),
    'keywords' => get_setting('site_keywords', SITE_KEYWORDS),
    'url' => get_setting('site_url', SITE_URL),
    'logo' => get_setting('site_logo', ''),
    'mobile_logo' => get_setting('mobile_logo', ''),
    'footer_logo' => get_setting('footer_logo', ''),
    'favicon' => get_setting('site_favicon', ''),
    'contact_email' => get_setting('contact_email', ADMIN_EMAIL),
    'contact_phone' => get_setting('contact_phone', ''),
    'contact_address' => get_setting('contact_address', ''),
    'facebook' => get_setting('facebook_url', ''),
    'twitter' => get_setting('twitter_url', ''),
    'instagram' => get_setting('instagram_url', ''),
    'youtube' => get_setting('youtube_url', ''),
    'linkedin' => get_setting('linkedin_url', ''),
    'whatsapp' => get_setting('whatsapp_url', ''),
    'footer_text' => get_setting('footer_text', ''),
    'copyright_text' => get_setting('copyright_text', ''),
    'analytics_code' => get_setting('google_analytics_code', ''),
    'adsense_code' => get_setting('adsense_code', ''),
    'adsense_sidebar' => get_setting('adsense_sidebar_code', ''),
    'adsense_header' => get_setting('adsense_header_code', ''),
    'adsense_footer' => get_setting('adsense_footer_code', ''),
    'custom_header_scripts' => get_setting('custom_header_scripts', ''),
    'custom_footer_scripts' => get_setting('custom_footer_scripts', ''),
    'author_name' => get_setting('author_name', AUTHOR_NAME),
    'author_email' => get_setting('author_email', AUTHOR_EMAIL),
    'author_bio' => get_setting('author_bio', AUTHOR_BIO),
    'disclaimer_text' => get_setting('disclaimer_text', ''),
];

// ============================================================
// Official Social Media Links - Single Source of Truth
// These overrides ensure the entire site uses the correct
// official social profiles regardless of admin DB settings.
// Last updated: May 2026
// ============================================================
$site_settings['whatsapp']  = 'https://www.whatsapp.com/channel/0029Vb7TUHHEquiNzOin5P0r';
$site_settings['instagram'] = 'https://www.instagram.com/shivkumarpandit8053/';
$site_settings['youtube']   = 'https://www.youtube.com/@SKPANDITJIOFFICIAL';
$site_settings['facebook']  = 'https://www.facebook.com/people/Shiv-Kumar-Pandit/61589328703704/';
// Twitter / LinkedIn are not active social profiles — keep empty so UI hides them
$site_settings['twitter']   = '';
$site_settings['linkedin']  = '';

// Official author / contact identity (single source of truth)
$site_settings['author_name']     = AUTHOR_NAME;
$site_settings['author_email']    = AUTHOR_EMAIL;
$site_settings['author_bio']      = AUTHOR_BIO;
$site_settings['contact_email']   = AUTHOR_EMAIL;
$site_settings['contact_address'] = OFFICE_ADDRESS_FULL;
$site_settings['admin_email']     = ADMIN_EMAIL;

// Helper Functions

// Generate slug from string
function generate_slug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Check if slug exists and generate unique slug
function get_unique_slug($table, $slug, $id = null) {
    $original_slug = $slug;
    $counter = 1;
    
    while (true) {
        if ($id) {
            $exists = db_fetch_one("SELECT id FROM $table WHERE slug = ? AND id != ?", [$slug, $id]);
        } else {
            $exists = db_fetch_one("SELECT id FROM $table WHERE slug = ?", [$slug]);
        }
        
        if (!$exists) {
            return $slug;
        }
        
        $slug = $original_slug . '-' . $counter;
        $counter++;
    }
}

// Format date
function format_date($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

// Calculate reading time
function calculate_reading_time($content) {
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return max(1, $reading_time);
}

// Automatic Internal Linking Function with Robust Fallback System
function add_internal_links($content, $current_post_id, $current_category_id, $min_links = 3, $max_links = 5) {
    // Get current post tags for fallback matching
    $current_tags = db_fetch_all("
        SELECT t.name, t.slug
        FROM tags t
        INNER JOIN post_tags pt ON t.id = pt.tag_id
        WHERE pt.post_id = ?
    ", [$current_post_id]);

    $tag_ids = array_column($current_tags, 'slug');

    // Fallback system: Get posts from multiple sources
    $fallback_posts = [];

    // Priority 1: Same category posts (excluding current)
    $category_posts = db_fetch_all("
        SELECT id, title, slug, 'category' as source
        FROM posts
        WHERE status = 'published' AND category_id = ? AND id != ?
        ORDER BY publish_date DESC
        LIMIT 10
    ", [$current_category_id, $current_post_id]);

    foreach ($category_posts as $post) {
        $fallback_posts[$post['id']] = $post;
    }

    // Priority 2: Posts with similar tags
    if (!empty($tag_ids)) {
        $tag_posts = db_fetch_all("
            SELECT DISTINCT p.id, p.title, p.slug, 'tags' as source
            FROM posts p
            INNER JOIN post_tags pt ON p.id = pt.post_id
            INNER JOIN tags t ON pt.tag_id = t.id
            WHERE p.status = 'published' AND p.id != ? AND t.slug IN ('" . implode("','", array_map(function($t) { return addslashes($t); }, $tag_ids)) . "')
            ORDER BY p.publish_date DESC
            LIMIT 10
        ", [$current_post_id]);

        foreach ($tag_posts as $post) {
            $fallback_posts[$post['id']] = $post;
        }
    }

    // Priority 3: Latest articles (if still need more)
    if (count($fallback_posts) < $max_links) {
        $latest_posts = db_fetch_all("
            SELECT id, title, slug, 'latest' as source
            FROM posts
            WHERE status = 'published' AND id != ?
            ORDER BY publish_date DESC
            LIMIT 10
        ", [$current_post_id]);

        foreach ($latest_posts as $post) {
            $fallback_posts[$post['id']] = $post;
        }
    }

    // Priority 4: Trending articles (if still need more)
    if (count($fallback_posts) < $max_links) {
        $trending_posts = db_fetch_all("
            SELECT id, title, slug, 'trending' as source
            FROM posts
            WHERE status = 'published' AND id != ? AND is_trending = 1
            ORDER BY views DESC
            LIMIT 10
        ", [$current_post_id]);

        foreach ($trending_posts as $post) {
            $fallback_posts[$post['id']] = $post;
        }
    }

    // Priority 5: Random relevant posts (if still need more)
    if (count($fallback_posts) < $max_links) {
        $random_posts = db_fetch_all("
            SELECT id, title, slug, 'random' as source
            FROM posts
            WHERE status = 'published' AND id != ?
            ORDER BY RAND()
            LIMIT 10
        ", [$current_post_id]);

        foreach ($random_posts as $post) {
            $fallback_posts[$post['id']] = $post;
        }
    }

    // Convert to indexed array
    $fallback_posts = array_values($fallback_posts);

    if (count($fallback_posts) == 0) {
        return $content;
    }

    // Extract keywords from post titles for exact matching
    $keywords_map = [];
    foreach ($fallback_posts as $post) {
        // Extract meaningful keywords from title (2-3 word phrases)
        $title_words = preg_split('/[\s,]+/', $post['title']);
        $title_words = array_filter($title_words, function($word) {
            return strlen($word) > 3 && !in_array(strtolower($word), ['the', 'and', 'for', 'with', 'from', 'this', 'that', 'your', 'will', 'have', 'been', 'are', 'was', 'were', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'shall', 'will', 'should', 'would', 'may', 'might', 'must', 'can', 'could']);
        });

        // Create 2-word and 3-word phrases
        for ($i = 0; $i < min(count($title_words) - 1, 2); $i++) {
            $phrase = $title_words[$i] . ' ' . $title_words[$i + 1];
            if (strlen($phrase) > 5) {
                $keywords_map[$phrase] = $post;
            }
        }
    }

    // Split content into paragraphs and process each
    $paragraphs = preg_split('/(<p[^>]*>.*?<\/p>)/s', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    $linked_content = '';
    $links_added = 0;
    $used_post_ids = [];
    $used_keywords = [];

    // Get text-only paragraphs for fallback insertion
    $text_paragraphs = [];
    foreach ($paragraphs as $paragraph) {
        if (preg_match('/^<p[^>]*>/', $paragraph) && !preg_match('/<h[1-6]/i', $paragraph)) {
            $text_paragraphs[] = $paragraph;
        }
    }

    foreach ($paragraphs as $paragraph) {
        // Skip if it's not a paragraph tag or if it contains heading tags
        if (!preg_match('/^<p[^>]*>/', $paragraph) || preg_match('/<h[1-6]/i', $paragraph)) {
            $linked_content .= $paragraph;
            continue;
        }

        // Stop if we've reached max links
        if ($links_added >= $max_links) {
            $linked_content .= $paragraph;
            continue;
        }

        // Process paragraph to add links
        $processed_paragraph = $paragraph;
        $paragraph_links_added = 0;

        // First try exact keyword matching
        foreach ($keywords_map as $keyword => $post) {
            // Skip if post already used or keyword already used or we've added enough links
            if (in_array($post['id'], $used_post_ids) || in_array($keyword, $used_keywords) || $links_added >= $max_links || $paragraph_links_added >= 1) {
                continue;
            }

            // Check if keyword exists in paragraph (case-insensitive)
            if (stripos($processed_paragraph, $keyword) !== false) {
                // Create the link
                $link_url = SITE_URL . '/' . $post['slug'];
                $link_html = '<a href="' . $link_url . '" class="internal-link" title="' . htmlspecialchars($post['title']) . '">' . $keyword . '</a>';

                // Replace first occurrence only
                $processed_paragraph = preg_replace('/\b' . preg_quote($keyword, '/') . '\b/i', $link_html, $processed_paragraph, 1);

                $links_added++;
                $paragraph_links_added++;
                $used_post_ids[] = $post['id'];
                $used_keywords[] = $keyword;
            }
        }

        // If no exact match and we still need links, use fallback insertion
        if ($paragraph_links_added == 0 && $links_added < $max_links) {
            foreach ($fallback_posts as $post) {
                // Skip if post already used
                if (in_array($post['id'], $used_post_ids) || $links_added >= $max_links || $paragraph_links_added >= 1) {
                    continue;
                }

                // Generate contextual anchor text from post title
                $anchor_text = generate_contextual_anchor($post['title'], $processed_paragraph);

                if ($anchor_text) {
                    // Create the link
                    $link_url = SITE_URL . '/' . $post['slug'];
                    $link_html = '<a href="' . $link_url . '" class="internal-link" title="' . htmlspecialchars($post['title']) . '">' . $anchor_text . '</a>';

                    // Insert link naturally at the end of a sentence
                    $processed_paragraph = insert_link_naturally($processed_paragraph, $link_html);

                    $links_added++;
                    $paragraph_links_added++;
                    $used_post_ids[] = $post['id'];
                }
            }
        }

        $linked_content .= $processed_paragraph;
    }

    // Fallback: If we still don't have minimum links, force insert into remaining paragraphs
    if ($links_added < $min_links) {
        $needed_links = $min_links - $links_added;
        $inserted_count = 0;

        foreach ($text_paragraphs as $para) {
            if ($inserted_count >= $needed_links) {
                break;
            }

            // Find this paragraph in linked_content
            $para_pos = strpos($linked_content, $para);
            if ($para_pos !== false) {
                // Get next unused post
                foreach ($fallback_posts as $post) {
                    if (in_array($post['id'], $used_post_ids)) {
                        continue;
                    }

                    // Generate anchor text
                    $anchor_text = generate_contextual_anchor($post['title'], $para);
                    if (!$anchor_text) {
                        $anchor_text = $post['title'];
                    }

                    // Create link
                    $link_url = SITE_URL . '/' . $post['slug'];
                    $link_html = '<a href="' . $link_url . '" class="internal-link" title="' . htmlspecialchars($post['title']) . '">' . $anchor_text . '</a>';

                    // Insert at end of paragraph
                    $modified_para = insert_link_naturally($para, $link_html);

                    // Replace in content
                    $linked_content = str_replace($para, $modified_para, $linked_content);

                    $used_post_ids[] = $post['id'];
                    $inserted_count++;
                    break;
                }
            }
        }
    }

    return $linked_content;
}

// Generate contextual anchor text based on post title and content
function generate_contextual_anchor($title, $content) {
    // Extract key phrase from title (2-3 words)
    $title_words = preg_split('/[\s,]+/', $title);
    $title_words = array_filter($title_words, function($word) {
        return strlen($word) > 3 && !in_array(strtolower($word), ['the', 'and', 'for', 'with', 'from', 'this', 'that', 'your', 'will', 'have', 'been', 'are', 'was', 'were', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'shall', 'will', 'should', 'would', 'may', 'might', 'must', 'can', 'could']);
    });

    if (count($title_words) >= 2) {
        return $title_words[0] . ' ' . $title_words[1];
    } elseif (count($title_words) == 1) {
        return $title_words[0];
    }

    return substr($title, 0, 20);
}

// Insert link naturally into paragraph
function insert_link_naturally($paragraph, $link_html) {
    // Try to insert before a period or comma
    if (preg_match('/([,.!?])\s/', $paragraph, $matches, PREG_OFFSET_CAPTURE)) {
        $insert_pos = $matches[0][1];
        $before = substr($paragraph, 0, $insert_pos);
        $after = substr($paragraph, $insert_pos);
        return $before . ' ' . $link_html . $after;
    }

    // Fallback: insert at the end
    return rtrim($paragraph) . ' ' . $link_html . ' ';
}

// Truncate text
// Truncate text (multibyte UTF-8 safe to prevent corrupted Hindi characters)
function truncate_text($text, $length = 150, $ellipsis = "...") {
    $text = strip_tags($text);
    if (function_exists("mb_strlen") && function_exists("mb_substr")) {
        if (mb_strlen($text, "UTF-8") <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length, "UTF-8") . $ellipsis;
    }
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . $ellipsis;
}

// Sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Redirect function
function redirect($url) {
    header("Location: $url");
    exit();
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Get current URL
function get_current_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

// Upload image
function upload_image($file, $directory) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'File upload error'];
    }
    
    if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    if ($file['size'] > MAX_FILE_SIZE) {
        return ['success' => false, 'message' => 'File size exceeds limit'];
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = UPLOAD_DIR . $directory . '/' . $filename;
    
    if (!is_dir(UPLOAD_DIR . $directory)) {
        mkdir(UPLOAD_DIR . $directory, 0755, true);
    }
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Get image dimensions
        $image_info = getimagesize($filepath);
        $width = $image_info[0] ?? 0;
        $height = $image_info[1] ?? 0;
        
        // Basic image optimization for JPEG and PNG
        if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
            try {
                // For JPEG - compress at 85% quality
                if (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
                    $image = imagecreatefromjpeg($filepath);
                    if ($image) {
                        imagejpeg($image, $filepath, 85);
                        imagedestroy($image);
                    }
                }
                // For PNG - compress at 9 level
                elseif (strtolower($extension) === 'png') {
                    $image = imagecreatefrompng($filepath);
                    if ($image) {
                        imagealphablending($image, false);
                        imagesavealpha($image, true);
                        imagepng($image, $filepath, 9);
                        imagedestroy($image);
                    }
                }
            } catch (Exception $e) {
                // If optimization fails, continue with original file
            }
        }
        
        // Get optimized file size
        $optimized_size = filesize($filepath);
        
        return [
            'success' => true,
            'filename' => $filename,
            'path' => $filepath,
            'url' => UPLOAD_URL . $directory . '/' . $filename,
            'size' => $optimized_size,
            'width' => $width,
            'height' => $height
        ];
    }
    
    return ['success' => false, 'message' => 'Failed to move uploaded file'];
}

// Delete image
function delete_image($filepath) {
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

// Pagination helper
function paginate($total, $per_page, $current_page) {
    $total_pages = ceil($total / $per_page);
    $offset = ($current_page - 1) * $per_page;
    
    return [
        'total' => $total,
        'per_page' => $per_page,
        'current_page' => $current_page,
        'total_pages' => $total_pages,
        'offset' => $offset,
        'has_next' => $current_page < $total_pages,
        'has_prev' => $current_page > 1
    ];
}