import json, re

with open('public/hostinger-deployment/assets/js/articles-manifest.js', 'r', encoding='utf-8') as f:
    text = f.read()

m = re.search(r'window\.CHOGHADIYA_ARTICLES\s*=\s*(\[.*?\]);', text, re.DOTALL)
if m:
    data = json.loads(m.group(1))
    print('Keys:', list(data[0].keys()))
    print('Sample 1:', data[0])
