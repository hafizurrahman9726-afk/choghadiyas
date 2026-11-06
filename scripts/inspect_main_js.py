with open('public/hostinger-deployment/assets/js/main.js', 'r', encoding='utf-8', errors='ignore') as f:
    text = f.read()

print('main.js size:', len(text))
print('first 500 chars:\n', text[:500])
print('has setCategory:', 'setCategory' in text)
print('has renderPagination:', 'Pagination' in text or 'paginate' in text)
