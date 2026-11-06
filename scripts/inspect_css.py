with open('public/hostinger-deployment/assets/css/choghadiya-theme.css', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

import re
matches = re.findall(r'(\.[^{]*slider[^{]*\{[^}]*\})', text, re.IGNORECASE)
for m in matches[:10]:
    print(m)
    print('-'*40)
