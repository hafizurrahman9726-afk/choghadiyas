with open('public/hostinger-deployment/assets/js/main.js', 'r', encoding='utf-8', errors='ignore') as f:
    lines = f.readlines()

for i, l in enumerate(lines):
    if any(k in l.lower() for k in ['slider', 'filter', 'page', 'category', 'hover', 'touch']):
        print(f'{i+1}: {l.strip()[:90]}')
