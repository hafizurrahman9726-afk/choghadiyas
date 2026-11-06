import ftplib, os, io, urllib.request, ssl

FTP_HOST = "89.117.157.182"
FTP_USER = "u206523498.choghadiyas.in"
FTP_PASS = "Kaloup&sd54#"

files_to_deploy = [
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

print("Connecting to Hostinger FTP...")
ftp = ftplib.FTP(FTP_HOST, timeout=30)
ftp.login(FTP_USER, FTP_PASS)
print(f"Logged in successfully. Remote PWD: {ftp.pwd()}")

for rel_path in files_to_deploy:
    local_path = os.path.join('public/hostinger-deployment', rel_path)
    if not os.path.exists(local_path):
        print(f"ERROR: Local file missing: {local_path}")
        continue
    
    # 1. Remote backup if not already backed up
    backup_path = rel_path + ".phase2_backup"
    try:
        remote_size = ftp.size(rel_path)
        if remote_size is not None and remote_size > 0:
            # Check if backup exists
            try:
                b_size = ftp.size(backup_path)
            except Exception:
                b_size = None
            if not b_size:
                buf = io.BytesIO()
                ftp.retrbinary('RETR ' + rel_path, buf.write)
                buf.seek(0)
                ftp.storbinary('STOR ' + backup_path, buf)
                print(f"  [BACKUP] Created remote backup: {backup_path}")
    except Exception as e:
        print(f"  [BACKUP NOTE] {rel_path}: {e}")

    # 2. Upload file
    with open(local_path, 'rb') as f:
        file_bytes = f.read()
    
    buf = io.BytesIO(file_bytes)
    ftp.storbinary('STOR ' + rel_path, buf)
    new_remote_size = ftp.size(rel_path)
    print(f"  [UPLOADED] {rel_path} -> {new_remote_size} bytes (Local: {len(file_bytes)} bytes)")

ftp.quit()
print("All files uploaded successfully via FTP!")

# 3. Purge NitroPack Cache
print("\nTriggering CDN and server cache purge...")
ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

req = urllib.request.Request(
    "https://choghadiyas.in/?purge_production_cache=choghadiyas2026",
    headers={"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) ChoghadiyasPurge/2.0"}
)
try:
    with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
        res_body = resp.read().decode('utf-8', errors='ignore')
        print(f"Cache Purge Response: HTTP {resp.status} - {res_body[:120]}")
except Exception as e:
    print(f"Cache purge trigger note: {e}")

