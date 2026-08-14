import glob

html_files = glob.glob('*.html')
for file in html_files:
    try:
        with open(file, 'r', encoding='utf-8') as f:
            content = f.read()
            
        target = 'class="nav-link light-mode nav-list-property"'
        replacement = 'class="btn btn-alt nav-list-property"'
        
        new_content = content.replace(target, replacement)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f'Updated {file}')
    except Exception as e:
        print(f'Skipped {file} due to {e}')
