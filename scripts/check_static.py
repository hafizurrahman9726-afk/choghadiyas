for name in ['about.php', 'contact.php']:
    path = f'public/hostinger-deployment/remote_audit/{name}'
    with open(path, 'r', encoding='utf-8', errors='ignore') as f:
        text = f.read()
    print(name, 'includes header:', 'header' in text)
    print(name, 'includes footer:', 'footer' in text)
