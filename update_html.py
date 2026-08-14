import os
import glob

html_files = glob.glob('*.html')
for file in html_files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    if '>List Property<' in content:
        continue
    
    target = '<li><a href="contact.html"'
    replacement = '<li><a href="#" class="nav-link light-mode nav-list-property">List Property</a></li>\n        <li><a href="contact.html"'
    
    new_content = content.replace(target, replacement)
    
    with open(file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    print(f'Updated {file}')
