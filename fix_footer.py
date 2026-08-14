import glob

html_files = glob.glob('*.html')
for file in html_files:
    try:
        with open(file, 'r', encoding='utf-8') as f:
            content = f.read()
            
        target = '<li><a href="#" class="btn btn-alt nav-list-property">List Property</a></li>\n        <li><a href="contact.html">Terms</a></li>'
        replacement = '<li><a href="contact.html">Terms</a></li>'
        content = content.replace(target, replacement)
        
        target2 = '<li><a href="#" class="btn btn-alt nav-list-property">List Property</a></li>\n        <li><a href="contact.html">Privacy</a></li>'
        replacement2 = '<li><a href="contact.html">Privacy</a></li>'
        content = content.replace(target2, replacement2)
        
        target3 = '<li><a href="#" class="btn btn-alt nav-list-property">List Property</a></li>\n        <li><a href="contact.html">Contact Us</a></li>'
        # Wait, the first one is under Our Services: <li><a href="contact.html">Contact Us</a></li>
        # The navbar one is: <li><a href="contact.html" class="btn btn-primary">Contact Us</a></li>
        replacement3 = '<li><a href="contact.html">Contact Us</a></li>'
        content = content.replace(target3, replacement3)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f'Updated {file}')
    except Exception as e:
        print(f'Skipped {file} due to {e}')
