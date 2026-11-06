import json, re

with open('public/hostinger-deployment/assets/js/articles-manifest.js', 'r', encoding='utf-8') as f:
    text = f.read()

# Extract JSON array
m = re.search(r'window\.CHOGHADIYA_ARTICLES\s*=\s*(\[.*?\]);', text, re.DOTALL)
if m:
    data = json.loads(m.group(1))
    print('Total articles in manifest:', len(data))
    for i, a in enumerate(data[:10]):
        print(f"{i+1}: {a['title'][:40]} | slug: {a['slug']} | cat: {a['categorySlug']} ({a['category']}) | img: {a['image']}")
