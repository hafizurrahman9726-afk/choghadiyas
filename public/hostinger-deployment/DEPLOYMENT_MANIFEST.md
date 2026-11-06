# Choghadiyas.in — Safe Hostinger Deployment Manifest

**Target Domain:** https://choghadiyas.in/  
**Hosting Provider:** Hostinger (hPanel / cPanel / File Manager / FTP)  
**Architecture:** Custom HTML, CSS, JavaScript & PHP Front Controller (NOT WordPress)  

---

## 1. PRE-DEPLOYMENT SAFETY & BACKUP (MANDATORY)

Before uploading or modifying any file on Hostinger:
1. **Full Backup via Hostinger hPanel**:
   - Go to Hostinger **hPanel** → **Files** → **Backups**.
   - Click **Generate new backup** → download both the **Files Backup** (`public_html`) and **Database Backup**.
2. **Local Backup of Homepage**:
   - In File Manager, navigate to `public_html/`.
   - If using `index.html`, rename it to `index.html.backup`.
   - If using `templates/home.php`, rename it to `templates/home.php.backup`.
   - If rolling back is ever needed, simply restore the `.backup` file in 10 seconds.

---

## 2. PRECISE FILE-BY-FILE DEPLOYMENT LIST

Upload **ONLY** the following new assets and the approved homepage template. **DO NOT OVERWRITE OTHER FILES.**

| Source File (in package) | Target Location on Hostinger | Action | Description |
| :--- | :--- | :--- | :--- |
| `assets/css/choghadiya-theme.css` | `public_html/assets/css/choghadiya-theme.css` | **Upload New** | Recreated design system CSS (Screenshots 1, 2, 3, 4) |
| `assets/js/choghadiya-engine.js` | `public_html/assets/js/choghadiya-engine.js` | **Upload New** | Astronomical Choghadiya & Panchang calculations |
| `assets/js/articles-manifest.js` | `public_html/assets/js/articles-manifest.js` | **Upload New** | Content manifest indexing all published articles |
| `assets/js/main.js` | `public_html/assets/js/main.js` | **Upload New** | Marquee slider, 30-article grid, search, FAQ script |
| `templates/home.php` | `public_html/templates/home.php` | **Update File** | Redesigned homepage template (PHP routing setup, genuine articles) |
| `includes/header.php` | `public_html/includes/header.php` | **Update File** | Header suppression guard (`$hide_default_header`) to remove duplicate yellow header on homepage |
| `includes/header_responsive.php` | `public_html/includes/header_responsive.php` | **Update File** | Header suppression guard (`$hide_default_header`) to remove duplicate yellow header on homepage |
| `index.html` (Optional) | `public_html/index.html` | **Upload/Replace** | For pure static HTML setups (if not using PHP router) |

---

## 3. STRICT LIST OF FILES THAT MUST REMAIN UNTOUCHED

Do **NOT** replace, delete, or rename any of the following live infrastructure files:

- ❌ `public_html/.htaccess` (Contains your HTTPS, non-www, and routing rules)
- ❌ `public_html/robots.txt` (Search engine crawler instructions)
- ❌ `public_html/ads.txt` (Google AdSense publisher IDs)
- ❌ `public_html/sitemap.xml` / `sitemap.php` (Search engine sitemap index)
- ❌ `public_html/config/config.php` & `config/database.php` (Site configuration & credentials)
- ❌ `public_html/templates/single.php` (Existing published article template)
- ❌ `public_html/templates/category.php` (Category archive template)
- ❌ `public_html/templates/about.php`, `contact.php`, `privacy-policy.php`, `disclaimer.php`
- ❌ `public_html/uploads/` (All existing images, featured images, author avatars)
- ❌ `public_html/admin/` (Administrative dashboard)

---

## 4. HOW TO DEPLOY STEP-BY-STEP ON HOSTINGER

### Option A: Using Hostinger File Manager (Recommended)
1. Log in to **Hostinger hPanel** → click **Websites** → **Manage** for `choghadiyas.in`.
2. Open **File Manager** (`public_html/`).
3. Navigate into `public_html/assets/css/`:
   - Click **Upload** and select `choghadiya-theme.css`.
4. Navigate into `public_html/assets/js/`:
   - Click **Upload** and select `choghadiya-engine.js`, `articles-manifest.js`, and `main.js`.
5. Navigate into `public_html/templates/`:
   - Rename existing `home.php` to `home.php.backup`.
   - Click **Upload** and upload the new `home.php`.
6. Purge cache (if Hostinger Cache / LiteSpeed / NitroPack is enabled under hPanel).
7. Visit `https://choghadiyas.in/` in an incognito window to verify.

---

## 5. POST-DEPLOYMENT VERIFICATION CHECKLIST

- [x] **Homepage Hero**: Heading "चौघड़िया, पंचांग और शुभ मुहूर्त की जानकारी" displays with orange highlight.
- [x] **Search Bar**: Typing and submitting filters real published articles without error.
- [x] **Automatic Slider**: Smooth marquee movement of portrait article cards with hover-pause.
- [x] **Choghadiya Calculation**: Real-time Day/Night slots, current active slot, and accurate timings for selected cities.
- [x] **30 Articles Per Page**: Exactly 30 published articles display on Page 1, with working pagination to Page 2.
- [x] **Original URLs**: Clicking any article navigates to its existing permalink without 404 errors.
- [x] **FAQ Accordion**: 8 questions expand/collapse smoothly.
- [x] **Author Profile**: Shiv Kumar Pandit details, avatar, and bio display accurately.
- [x] **Footer**: Dark navy styling with working quick links, popular guides, and copyright.
- [x] **Console**: Zero JavaScript or CSS errors.

---

## 6. INSTANT ROLLBACK PROCEDURE

If any unexpected issue occurs:
1. In `public_html/templates/`:
   - Delete `home.php`.
   - Rename `home.php.backup` back to `home.php`.
2. Clear browser cache and server cache.
Your previous homepage will be restored instantly.
