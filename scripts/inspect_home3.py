with open('public/hostinger-deployment/templates/home.php', 'r', encoding='utf-8', errors='ignore') as f:
    lines = f.readlines()

for i in range(368, 440):
    if i < len(lines):
        print(f'{i+1}: {lines[i]}', end='')
