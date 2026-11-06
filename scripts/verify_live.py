import urllib.request, ssl, re

ctx = ssl.create_default_context()
ctx.check_hostname = False
ctx.verify_mode = ssl.CERT_NONE

def fetch(url):
    req = urllib.request.Request(
        url,
        headers={"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) ChoghadiyasAudit/2.0"}
    )
    with urllib.request.urlopen(req, context=ctx, timeout=20) as resp:
        return resp.status, resp.read().decode('utf-8', errors='ignore')

print("="*60)
print("1. VERIFYING LIVE HOMEPAGE: https://choghadiyas.in/")
print("="*60)
status, html = fetch("https://choghadiyas.in/")
print(f"HTTP Status: {status}")
headers = re.findall(r'<header[^>]*>', html)
print(f"Header tags found: {len(headers)}")
for h in headers:
    print(f"  Header tag: {h}")

h1_match = re.search(r'<h1[^>]*>(.*?)</h1>', html, re.DOTALL)
if h1_match:
    print(f"H1 Title: {h1_match.group(1).strip()}")

print(f"Has choghadiya-section: {'choghadiya-section' in html}")
print(f"Has undefined: {'undefined' in html}")
print(f"Has yellow #FFC800 header: {'#FFC800' in html}")

# Check slider card 1
card1_match = re.search(r'<div class="slider-card"[^>]*>.*?<img([^>]*)>', html, re.DOTALL)
if card1_match:
    img_attrs = card1_match.group(1)
    has_fetch_priority = 'fetchpriority="high"' in img_attrs or "fetchpriority='high'" in img_attrs
    has_lazy = 'loading="lazy"' in img_attrs or "loading='lazy'" in img_attrs
    print(f"Slider Card 1 img attributes: {img_attrs.strip()}")
    print(f"  Card 1 has fetchpriority='high': {has_fetch_priority}")
    print(f"  Card 1 has loading='lazy': {has_lazy}")

# Check categories in nav
for cat in ['vrat-tyohar', 'shubh-muhurat-guide', 'puja-vidhi-samagri', 'vedic-panchang']:
    print(f"Nav contains category /{cat}: {f'category/{cat}' in html}")

# Check shared footer
print(f"Has shared footer: {'site-footer' in html}")
print(f"Has contact@choghadiyas.in: {'contact@choghadiyas.in' in html}")

print("\n" + "="*60)
print("2. VERIFYING SINGLE ARTICLE PAGE (Breadcrumbs & UTF-8 Check)")
print("="*60)
article_url = "https://choghadiyas.in/kalash-sthapana-ke-niyam-samagri-nariyal-ki-disha-mantra-vidhi"
status, a_html = fetch(article_url)
print(f"HTTP Status: {status}")
a_headers = re.findall(r'<header[^>]*>', a_html)
print(f"Header tags found: {len(a_headers)}")

bc_match = re.search(r'<nav class="breadcrumbs"[^>]*>(.*?)</nav>', a_html, re.DOTALL)
if bc_match:
    bc_clean = re.sub(r'<[^>]+>', ' ', bc_match.group(1))
    bc_clean = ' '.join(bc_clean.split())
    print(f"Breadcrumb text: {bc_clean}")
    has_glyph = '\ufffd' in bc_match.group(1) or '&#65533;' in bc_match.group(1)
    print(f"Contains replacement char : {has_glyph}")
else:
    print("Breadcrumb nav not found in article!")

print(f"Single page has shared footer: {'site-footer' in a_html}")

print("\n" + "="*60)
print("3. VERIFYING CATEGORY PAGES")
print("="*60)
categories = ['vrat-tyohar', 'shubh-muhurat-guide', 'puja-vidhi-samagri', 'vedic-panchang']
for cat in categories:
    cat_url = f"https://choghadiyas.in/category/{cat}"
    c_status, c_html = fetch(cat_url)
    c_h1 = re.search(r'<h1[^>]*>(.*?)</h1>', c_html, re.DOTALL)
    h1_text = c_h1.group(1).strip() if c_h1 else 'None'
    c_cards = len(re.findall(r'<article class="card"', c_html))
    print(f"Category /{cat} -> HTTP {c_status} | H1: {h1_text} | Articles: {c_cards} | Shared Footer: {'site-footer' in c_html}")

print("\n" + "="*60)
print("4. VERIFYING STATIC PAGES")
print("="*60)
for p in ['about', 'contact', 'privacy-policy', 'disclaimer', 'terms', 'editorial-policy']:
    p_status, p_html = fetch(f"https://choghadiyas.in/{p}")
    p_headers = len(re.findall(r'<header[^>]*>', p_html))
    print(f"Page /{p} -> HTTP {p_status} | Headers: {p_headers} | Shared Footer: {'site-footer' in p_html}")
