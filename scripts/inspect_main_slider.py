with open('public/hostinger-deployment/assets/js/main.js', 'r', encoding='utf-8', errors='ignore') as f:
    lines = f.readlines()

for i in range(15, 60):
    if i < len(lines):
        print(f'{i+1}: {lines[i]}', end='')
