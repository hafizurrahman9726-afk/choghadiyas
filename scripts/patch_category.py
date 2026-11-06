with open('public/hostinger-deployment/remote_audit/category.php', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

# Add clean breadcrumbs right before <!-- Category Section -->
bc_markup = """<!-- Breadcrumbs -->
<nav class="breadcrumbs" aria-label="Breadcrumb" style="background: #FFFFFF; padding: 14px 0; border-bottom: 1px solid #E2E8F0;">
    <div class="container" style="max-width:1200px; margin:0 auto; padding:0 1.25rem; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; font-size: 13.5px; color: #64748B;">
        <a href="<?php echo $base_url; ?>/" style="color: #64748B; text-decoration: none;">Home</a>
        <span style="color: #CBD5E1;">›</span>
        <span style="color: #0A1629; font-weight: 600;" aria-current="page"><?php echo category_html($category_name); ?></span>
    </div>
</nav>
"""

if '<!-- Category Section -->' in text and '<!-- Breadcrumbs -->' not in text:
    text = text.replace('<!-- Category Section -->', bc_markup + '\n<!-- Category Section -->')

# Make sure footer is footer_responsive.php or footer.php (both are our shared footer now)
with open('public/hostinger-deployment/templates/category.php', 'w', encoding='utf-8') as f:
    f.write(text)

print('Wrote templates/category.php successfully!')
