with open('public/hostinger-deployment/templates/single.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
m = re.search(r'<nav class="breadcrumbs"[^>]*>.*?</nav>', text, re.DOTALL)
if m:
    print(m.group(0))
