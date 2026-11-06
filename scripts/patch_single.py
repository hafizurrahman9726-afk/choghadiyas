import re

with open('public/hostinger-deployment/remote_audit/single.php', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

new_bc = """<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Breadcrumb" style="background: #FFFFFF; padding: 14px 0; border-bottom: 1px solid #E2E8F0;">
    <div class="container" style="max-width:1200px; margin:0 auto; padding:0 1.25rem; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; font-size: 13.5px; color: #64748B;">
        <a href="<?php echo SITE_URL; ?>/" style="color: #64748B; text-decoration: none;">Home</a>
        <span style="color: #CBD5E1;">›</span>
        <?php if (!empty($post['category_slug'])): ?>
        <a href="<?php echo SITE_URL; ?>/category/<?php echo htmlspecialchars($post['category_slug']); ?>" style="color: #64748B; text-decoration: none;"><?php echo htmlspecialchars($post['category_name'] ?? 'धर्म एवं पंचांग'); ?></a>
        <span style="color: #CBD5E1;">›</span>
        <?php endif; ?>
        <span style="color: #0A1629; font-weight: 600;" aria-current="page"><?php 
            $b_title = (string)($post['title'] ?? '');
            echo htmlspecialchars(mb_strlen($b_title, 'UTF-8') > 65 ? mb_substr($b_title, 0, 62, 'UTF-8') . '...' : $b_title); 
        ?></span>
    </div>
</nav>"""

text = re.sub(
    r'<nav class="breadcrumbs"[^>]*>.*?</nav>',
    new_bc,
    text,
    flags=re.DOTALL
)

# Ensure background is white #FFFFFF
text = text.replace('background: #f8fafc;', 'background: #FFFFFF;')
text = text.replace('background-color: #f8fafc;', 'background-color: #FFFFFF;')

with open('public/hostinger-deployment/templates/single.php', 'w', encoding='utf-8') as f:
    f.write(text)

print('Patched single.php with correct PHP variables!')
