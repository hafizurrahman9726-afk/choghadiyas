<?php
/**
 * Category Page
 * Choghadiya Muhurat Website
 */

require_once __DIR__ . '/../config/config.php';

$base_url = rtrim(SITE_URL, '/');

/** Escape text before printing it in HTML. */
if (!function_exists('category_html')) {
    function category_html($value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// Read and normalize the requested category slug.
$slug_input = $_GET['slug'] ?? '';
$slug = is_string($slug_input) ? strtolower(trim($slug_input)) : '';

// Tool slugs should resolve to their corresponding tool pages, not categories.
$tool_slugs = ['choghadiya', 'panchang', 'horoscope', 'festivals', 'vastu', 'astrology', 'calendar'];

if (in_array($slug, $tool_slugs, true)) {
    header('Location: ' . $base_url . '/' . rawurlencode($slug), true, 301);
    exit;
}

// Find the active category using a parameterized query.
$category = db_fetch_one(
    "SELECT * FROM categories WHERE slug = ? AND status = 'active' LIMIT 1",
    [$slug]
);

if (!$category) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

// Validate pagination values before using them in SQL.
$page_input = $_GET['page'] ?? 1;
$page = filter_var($page_input, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$page = ($page === false || $page === null) ? 1 : (int) $page;

$per_page = defined('POSTS_PER_PAGE') ? max(1, (int) POSTS_PER_PAGE) : 12;
$offset = ($page - 1) * $per_page;

// Count published posts in this category.
$total_row = db_fetch_one(
    "SELECT COUNT(*) AS count FROM posts WHERE category_id = ? AND status = 'published'",
    [(int) $category['id']]
);
$total = (int) ($total_row['count'] ?? 0);
$total_pages = max(1, (int) ceil($total / $per_page));

// A page number beyond the available range should not display a misleading empty category.
if ($page > $total_pages) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

// Fetch only published posts for this category.
$posts = db_fetch_all(
    "SELECT p.*, u.full_name AS author_name
     FROM posts p
     LEFT JOIN users u ON p.author_id = u.id
     WHERE p.category_id = ? AND p.status = 'published'
     ORDER BY p.publish_date DESC
     LIMIT " . (int) $per_page . " OFFSET " . (int) $offset,
    [(int) $category['id']]
);
$posts = is_array($posts) ? $posts : [];

// SEO metadata.
$page_suffix = ($page > 1) ? ' - Page ' . $page : '';
$category_name = (string) ($category['name'] ?? 'Category');
$category_slug = (string) ($category['slug'] ?? $slug);
$category_description = trim((string) ($category['description'] ?? ''));

$page_title = $category_name . $page_suffix . ' - ' . ($site_settings['name'] ?? 'Choghadiya Muhurat');
$page_description = $category_description !== ''
    ? $category_description . $page_suffix
    : 'Browse articles in the ' . $category_name . ' category on ' . ($site_settings['name'] ?? 'our website') . '.' . $page_suffix;
$page_keywords = $category_name . ', choghadiya, muhurat, panchang';

$canonical_url = $base_url . '/category/' . rawurlencode($category_slug);
if ($page > 1) {
    $canonical_url .= '?page=' . $page;
}

// Keep pagination helper output compatible with the existing site.
$pagination = paginate($total, $per_page, $page);
$total_pages = max(1, (int) ($pagination['total_pages'] ?? $total_pages));

require_once __DIR__ . '/../includes/header_responsive.php';
?>

<!-- Category Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h1><?php echo category_html($category_name); ?></h1>
            <?php if ($category_description !== ''): ?>
                <p><?php echo category_html($category_description); ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($posts)): ?>
            <div class="articles-grid">
                <?php foreach ($posts as $post): ?>
                    <?php
                    $post_title = (string) ($post['title'] ?? 'Untitled article');
                    $post_slug = trim((string) ($post['slug'] ?? ''));
                    $post_url = $base_url . '/' . rawurlencode($post_slug);
                    $featured_image = trim((string) ($post['featured_image'] ?? ''));
                    if ($featured_image === '') {
                        $featured_image = $base_url . '/assets/images/placeholder.jpg';
                    }
                    $raw_excerpt = (string) ($post['excerpt'] ?? '');
                    if (trim($raw_excerpt) === '') {
                        $raw_excerpt = (string) ($post['content'] ?? '');
                    }
                    $plain_excerpt = trim(strip_tags($raw_excerpt));
                    $excerpt = truncate_text($plain_excerpt, 120);
                    $author_name = trim((string) ($post['author_name'] ?? ''));
                    ?>
                    <article class="card">
                        <div class="card-image">
                            <img
                                src="<?php echo category_html($featured_image); ?>"
                                alt="<?php echo category_html($post_title); ?>"
                                loading="lazy"
                                decoding="async"
                            >
                            <?php if (!empty($post['is_featured'])): ?>
                                <span class="card-category">Featured</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-content">
                            <h2 class="card-title">
                                <a href="<?php echo category_html($post_url); ?>">
                                    <?php echo category_html($post_title); ?>
                                </a>
                            </h2>
                            <?php if ($excerpt !== ''): ?>
                                <p class="card-excerpt"><?php echo category_html($excerpt); ?></p>
                            <?php endif; ?>
                            <div class="card-meta">
                                <?php if (!empty($post['publish_date'])): ?>
                                    <span><i class="icon-calendar" aria-hidden="true"></i> <?php echo category_html(format_date($post['publish_date'])); ?></span>
                                <?php endif; ?>
                                <?php if ($author_name !== ''): ?>
                                    <span><i class="icon-user" aria-hidden="true"></i> <?php echo category_html($author_name); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <nav class="pagination" aria-label="Category pagination">
                    <?php if (!empty($pagination['has_prev'])): ?>
                        <a href="<?php echo category_html($base_url . '/category/' . rawurlencode($category_slug) . ($page > 2 ? '?page=' . ($page - 1) : '')); ?>" class="btn btn-secondary" rel="prev">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php if ($i === $page): ?>
                            <span class="pagination-current" aria-current="page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo category_html($base_url . '/category/' . rawurlencode($category_slug) . ($i > 1 ? '?page=' . $i : '')); ?>" class="btn btn-outline" aria-label="Page <?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if (!empty($pagination['has_next'])): ?>
                        <a href="<?php echo category_html($base_url . '/category/' . rawurlencode($category_slug) . '?page=' . ($page + 1)); ?>" class="btn btn-secondary" rel="next">Next</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>

        <?php else: ?>
            <div class="no-posts">
                <p>No posts found in this category yet.</p>
                <a href="<?php echo category_html($base_url . '/'); ?>" class="btn btn-primary">Back to Home</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>