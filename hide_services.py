import glob

html_files = glob.glob('*.html')
for file in html_files:
    try:
        with open(file, 'r', encoding='utf-8') as f:
            lines = f.readlines()
            
        new_lines = []
        changed = False
        for line in lines:
            if 'href="services.html"' in line and 'nav-link' in line:
                changed = True
                continue
            new_lines.append(line)
            
        if changed:
            with open(file, 'w', encoding='utf-8') as f:
                f.writelines(new_lines)
            print(f'Updated {file}')
    except Exception as e:
        print(f'Skipped {file} due to {e}')
