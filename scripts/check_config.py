with open('public/hostinger-deployment/config/config.php', 'r', encoding='utf-8') as f:
    text = f.read()

import re
m = re.search(r'function\s+truncate_text.*?\n\}', text, re.DOTALL)
if m:
    print('Found truncate_text:')
    print(m.group(0))
else:
    print('truncate_text not found!')
