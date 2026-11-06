import zipfile, os

zip_path = 'public/choghadiyas-hostinger-deployment.zip'
source_dir = 'public/hostinger-deployment'

files_to_pack = [
    'config/config.php',
    'includes/header.php',
    'includes/header_responsive.php',
    'includes/footer.php',
    'includes/footer_responsive.php',
    'templates/home.php',
    'templates/single.php',
    'templates/category.php',
    'assets/css/choghadiya-theme.css',
    'assets/js/articles-manifest.js',
    'assets/js/main.js'
]

with zipfile.ZipFile(zip_path, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for rel_path in files_to_pack:
        full_path = os.path.join(source_dir, rel_path)
        if os.path.exists(full_path):
            zipf.write(full_path, rel_path)
            print(f'Packed: {rel_path} ({os.path.getsize(full_path)} bytes)')
        else:
            print(f'WARNING: Not found: {full_path}')

print('Deployment zip successfully updated!')
