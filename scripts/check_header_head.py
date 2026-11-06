with open('public/hostinger-deployment/includes/header_responsive.php', 'r', encoding='utf-8') as f:
    text = f.read()

print('has pub-4187031433847125:', 'pub-4187031433847125' in text)
print('has pub-9169061246761906:', 'pub-9169061246761906' in text)
print('has pub-4755467601695915:', 'pub-4755467601695915' in text)
print('has display=swap:', 'display=swap' in text)
print('has preconnect:', 'preconnect' in text)
