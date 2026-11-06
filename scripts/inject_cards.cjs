const fs = require('fs');
const vm = require('vm');

const manifestCode = fs.readFileSync('public/hostinger-deployment/assets/js/articles-manifest.js', 'utf8');
const sandbox = { window: {} };
vm.createContext(sandbox);
vm.runInContext(manifestCode, sandbox);

const articles = sandbox.window.CHOGHADIYA_ARTICLES;
console.log('Loaded articles count:', articles.length);

const cards = articles.slice(0, 30).map(a => `      <article class="article-card" data-category="${a.categorySlug || 'choghadiya'}">
        <a href="${a.url || '/' + a.slug}" class="article-thumb-link">
          <img src="${a.featuredImage}" alt="${a.title}" class="article-thumb" loading="lazy">
        </a>
        <div class="article-body">
          <span class="category-badge">${a.category || 'शुभ मुहूर्त'}</span>
          <h3 class="article-title">
            <a href="${a.url || '/' + a.slug}">${a.title}</a>
          </h3>
          <p class="article-excerpt">${a.excerpt}</p>
          <div class="article-footer">
            <span class="article-meta">${a.author || 'Shiv Kumar Pandit'} · ${a.formattedDate || 'Nov 5, 2026'}</span>
            <a href="${a.url || '/' + a.slug}" class="read-more-link">पूरा पढ़ें →</a>
          </div>
        </div>
      </article>`).join('\n');

// 1. Update index.html
let idx = fs.readFileSync('public/hostinger-deployment/index.html', 'utf8');
const targetIdx = '<div id="articles-grid" class="articles-grid">\n      <!-- Injected dynamically by main.js from CHOGHADIYA_ARTICLES -->\n    </div>';
if (idx.includes(targetIdx)) {
  idx = idx.replace(targetIdx, `<div id="articles-grid" class="articles-grid">\n${cards}\n    </div>`);
  fs.writeFileSync('public/hostinger-deployment/index.html', idx, 'utf8');
  console.log('Successfully updated index.html with 30 pre-rendered cards!');
} else {
  console.log('Note: targetIdx not found or already replaced in index.html');
}

// 2. Update templates/home.php
let hp = fs.readFileSync('public/hostinger-deployment/templates/home.php', 'utf8');
const targetPhp = '<div id="articles-grid" class="articles-grid"></div>';
const phpBlock = `<div id="articles-grid" class="articles-grid">
      <?php if (!empty($latest_articles)): ?>
        <?php foreach (array_slice($latest_articles, 0, 30) as $art): 
          $art_slug = !empty($art['slug']) ? $art['slug'] : (!empty($art['post_slug']) ? $art['post_slug'] : ('post-' . ($art['id'] ?? '1')));
          $art_title = !empty($art['title']) ? $art['title'] : (!empty($art['post_title']) ? $art['post_title'] : 'वैदिक ज्योतिष एवं पंचांग');
          $art_excerpt = !empty($art['excerpt']) ? $art['excerpt'] : (!empty($art['summary']) ? $art['summary'] : (!empty($art['description']) ? $art['description'] : ''));
          $art_excerpt = mb_substr(strip_tags($art_excerpt), 0, 140) . '...';
          $art_cat = !empty($art['category_name']) ? $art['category_name'] : 'शुभ मुहूर्त';
          $art_author = !empty($art['author_name']) ? $art['author_name'] : 'Shiv Kumar Pandit';
          $art_date = !empty($art['publish_date']) ? date('M j, Y', strtotime($art['publish_date'])) : 'Nov 5, 2026';
          $art_img = !empty($art['featured_image']) ? $art['featured_image'] : (!empty($art['image']) ? $art['image'] : '/assets/images/og-image.jpg');
        ?>
        <article class="article-card">
          <a href="/<?php echo htmlspecialchars($art_slug); ?>" class="article-thumb-link">
            <img src="<?php echo htmlspecialchars($art_img); ?>" alt="<?php echo htmlspecialchars($art_title); ?>" class="article-thumb" loading="lazy">
          </a>
          <div class="article-body">
            <span class="category-badge"><?php echo htmlspecialchars($art_cat); ?></span>
            <h3 class="article-title">
              <a href="/<?php echo htmlspecialchars($art_slug); ?>"><?php echo htmlspecialchars($art_title); ?></a>
            </h3>
            <p class="article-excerpt"><?php echo htmlspecialchars($art_excerpt); ?></p>
            <div class="article-footer">
              <span class="article-meta"><?php echo htmlspecialchars($art_author); ?> · <?php echo htmlspecialchars($art_date); ?></span>
              <a href="/<?php echo htmlspecialchars($art_slug); ?>" class="read-more-link">पूरा पढ़ें →</a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      <?php else: ?>
${cards}
      <?php endif; ?>
    </div>`;

if (hp.includes(targetPhp)) {
  hp = hp.replace(targetPhp, phpBlock);
  fs.writeFileSync('public/hostinger-deployment/templates/home.php', hp, 'utf8');
  console.log('Successfully updated templates/home.php with PHP loop + fallback!');
} else {
  console.log('Note: targetPhp not found or already replaced in templates/home.php');
}
