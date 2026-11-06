with open('public/hostinger-deployment/templates/home.php', 'r', encoding='utf-8', errors='ignore') as f:
    lines = f.readlines()

print('home.php total lines:', len(lines))
# print lines 1 to 280
for i in range(130, 280):
    if i < len(lines):
        print(f'{i+1}: {lines[i]}', end='')
