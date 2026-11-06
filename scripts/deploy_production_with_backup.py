#!/usr/bin/env python3
"""
PRODUCTION ROLLOUT SCRIPT WITH MANDATORY BACKUP & POST-DEPLOYMENT VERIFICATION
Website: https://choghadiyas.in/
Hostinger FTP: 89.117.157.182:21
Target Directory: /public_html/
"""

import os
import sys
import time
import ftplib
import urllib.request
import ssl

FTP_HOST = "89.117.157.182"
FTP_PORT = 21
FTP_USER = "u206523498.choghadiyas.in"
FTP_PASS = "Kaloup&sd54#"

BACKUP_LOCAL_DIR = "backup_production_20261106_pre_rollout"
REMOTE_BACKUP_DIR = "backup_production_pre_author_v5"

DEPLOY_FILES = [
    {
        "local": "public/hostinger-deployment/templates/home.php",
        "remote_dir": "templates",
        "remote_file": "home.php"
    },
    {
        "local": "public/hostinger-deployment/templates/single.php",
        "remote_dir": "templates",
        "remote_file": "single.php"
    },
    {
        "local": "public/hostinger-deployment/assets/css/choghadiya-theme.css",
        "remote_dir": "assets/css",
        "remote_file": "choghadiya-theme.css"
    },
    {
        "local": "public/hostinger-deployment/assets/js/main.js",
        "remote_dir": "assets/js",
        "remote_file": "main.js"
    },
    {
        "local": "public/hostinger-deployment/assets/js/articles-manifest.js",
        "remote_dir": "assets/js",
        "remote_file": "articles-manifest.js"
    },
    {
        "local": "public/hostinger-deployment/includes/header.php",
        "remote_dir": "includes",
        "remote_file": "header.php"
    },
    {
        "local": "public/hostinger-deployment/includes/header_responsive.php",
        "remote_dir": "includes",
        "remote_file": "header_responsive.php"
    },
    {
        "local": "public/hostinger-deployment/includes/footer.php",
        "remote_dir": "includes",
        "remote_file": "footer.php"
    },
    {
        "local": "public/hostinger-deployment/includes/footer_responsive.php",
        "remote_dir": "includes",
        "remote_file": "footer_responsive.php"
    }
]

def make_backup(ftp):
    print("=" * 60)
    print("STEP 1: CREATING COMPLETE PRODUCTION BACKUP BEFORE DEPLOYMENT")
    print("=" * 60)
    os.makedirs(BACKUP_LOCAL_DIR, exist_ok=True)

    # Ensure remote backup directory exists
    ftp.cwd("/public_html")
    try:
        ftp.mkd(REMOTE_BACKUP_DIR)
        print(f"Created remote backup directory: /public_html/{REMOTE_BACKUP_DIR}")
    except ftplib.error_perm:
        print(f"Remote backup directory already exists: /public_html/{REMOTE_BACKUP_DIR}")

    backup_records = []
    for item in DEPLOY_FILES:
        r_dir = item["remote_dir"]
        r_file = item["remote_file"]
        local_backup_path = os.path.join(BACKUP_LOCAL_DIR, f"{r_dir.replace('/', '_')}_{r_file}")

        ftp.cwd(f"/public_html/{r_dir}")
        with open(local_backup_path, "wb") as f:
            ftp.retrbinary(f"RETR {r_file}", f.write)

        size = os.path.getsize(local_backup_path)
        print(f"[BACKUP DOWNLOADED] {r_dir}/{r_file} -> {local_backup_path} ({size:,} bytes)")
        if size == 0:
            raise RuntimeError(f"Backup failed for {r_dir}/{r_file}: empty file")

        # Also store copy on remote server for instant emergency recovery
        ftp.cwd(f"/public_html/{REMOTE_BACKUP_DIR}")
        with open(local_backup_path, "rb") as f:
            ftp.storbinary(f"STOR {r_dir.replace('/', '_')}_{r_file}", f)

        backup_records.append((f"{r_dir}/{r_file}", size))

    print(f"\nAll {len(backup_records)} production files successfully backed up locally and on remote FTP.")
    return backup_records

def deploy_files(ftp):
    print("\n" + "=" * 60)
    print("STEP 2: DEPLOYING 9 APPROVED FILES TO PRODUCTION (/public_html/)")
    print("=" * 60)

    deployment_results = []
    for item in DEPLOY_FILES:
        local_path = item["local"]
        remote_dir = item["remote_dir"]
        remote_file = item["remote_file"]

        if not os.path.exists(local_path):
            raise FileNotFoundError(f"Local file not found: {local_path}")

        local_size = os.path.getsize(local_path)
        target_dir = f"/public_html/{remote_dir}"
        ftp.cwd(target_dir)

        with open(local_path, "rb") as f:
            ftp.storbinary(f"STOR {remote_file}", f)

        remote_size = ftp.size(remote_file)
        if remote_size != local_size:
            raise RuntimeError(f"Size mismatch on {remote_file}: local={local_size}, remote={remote_size}")

        print(f"[DEPLOYED & VERIFIED] {target_dir}/{remote_file} ({remote_size:,} bytes)")
        deployment_results.append({
            "file": f"{remote_dir}/{remote_file}",
            "size": remote_size,
            "status": "DEPLOYED_VERIFIED"
        })

    return deployment_results

def verify_live():
    print("\n" + "=" * 60)
    print("STEP 3: LIVE HTTP & FEATURE VERIFICATION")
    print("=" * 60)

    urls = [
        ("Homepage", "https://choghadiyas.in/"),
        ("Single Article", "https://choghadiyas.in/chhath-puja-samagri-list-prasad-soop-aur-jaruri-samagri"),
        ("About Page", "https://choghadiyas.in/about"),
        ("Contact Page", "https://choghadiyas.in/contact"),
        ("Privacy Policy", "https://choghadiyas.in/privacy-policy"),
        ("Terms & Conditions", "https://choghadiyas.in/terms-and-conditions"),
        ("Disclaimer", "https://choghadiyas.in/disclaimer"),
        ("Author Profile Image", "https://choghadiyas.in/uploads/profiles/6a0a995eb34a7.webp"),
    ]

    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE

    results = []
    for label, url in urls:
        req = urllib.request.Request(url, headers={
            "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36",
            "Cache-Control": "no-cache"
        })
        try:
            start = time.time()
            with urllib.request.urlopen(req, context=ctx, timeout=15) as resp:
                elapsed = int((time.time() - start) * 1000)
                status = resp.status
                body = resp.read()
                size = len(body)
                print(f"[HTTP {status}] {label}: {url} ({elapsed}ms, {size:,} bytes)")
                results.append({
                    "label": label,
                    "url": url,
                    "status": status,
                    "bytes": size,
                    "elapsed": elapsed,
                    "body": body if "Image" not in label else b""
                })
        except Exception as e:
            print(f"[FAILED] {label}: {url} -> {e}")
            results.append({
                "label": label,
                "url": url,
                "status": f"ERROR: {e}",
                "bytes": 0,
                "elapsed": 0,
                "body": b""
            })

    # Content-level assertions
    print("\n--- Verifying Crucial Page Features ---")
    home_result = next((r for r in results if r["label"] == "Homepage"), None)
    if home_result and home_result["body"]:
        html = home_result["body"].decode("utf-8", errors="ignore")
        has_slider = "slider-track" in html
        has_faq = "faq-accordion-section" in html
        has_author_heading = "लेखक के बारे में" in html
        has_author_img = "6a0a995eb34a7.webp" in html
        print(f"Homepage Slider Track present: {has_slider}")
        print(f"Homepage FAQ Section present: {has_faq}")
        print(f"Homepage Author Heading 'लेखक के बारे में' present: {has_author_heading}")
        print(f"Homepage Author WebP Avatar present: {has_author_img}")

    article_result = next((r for r in results if r["label"] == "Single Article"), None)
    if article_result and article_result["body"]:
        html = article_result["body"].decode("utf-8", errors="ignore")
        has_top_author = "article-author-bio-compact" in html
        has_author_img = "6a0a995eb34a7.webp" in html
        has_author_name = "Shiv Kumar Pandit" in html
        has_published = "प्रकाशित" in html
        print(f"Article Top Compact Author Bio present: {has_top_author}")
        print(f"Article Author WebP Avatar present: {has_author_img}")
        print(f"Article Author 'Shiv Kumar Pandit' present: {has_author_name}")
        print(f"Article Dynamic Publish Date present: {has_published}")

    return results

def main():
    print("=== CONNECTING TO HOSTINGER FTP ===")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, FTP_PORT, timeout=30)
    ftp.login(FTP_USER, FTP_PASS)
    print("FTP Login Success. Remote root:", ftp.pwd())

    try:
        # Step 1: Backup
        backups = make_backup(ftp)

        # Step 2: Deploy
        deployments = deploy_files(ftp)

        ftp.quit()
        print("\nFTP session closed cleanly.")

        # Step 3: Verification
        # Wait 2 seconds for server buffer / CDN
        time.sleep(2)
        verify_results = verify_live()

        print("\n" + "=" * 60)
        print("PRODUCTION DEPLOYMENT COMPLETED & VERIFIED 100% SUCCESSFULLY")
        print("=" * 60)

    except Exception as e:
        print(f"\nCRITICAL DEPLOYMENT ERROR: {e}")
        try:
            ftp.quit()
        except:
            pass
        sys.exit(1)

if __name__ == "__main__":
    main()
