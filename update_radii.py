import re

file_path = '/Users/ravindu/Desktop/Work/Web Projects/Hyveweb/css/style.css'
with open(file_path, 'r', encoding='utf-8') as f:
    css = f.read()

# Update root variables
css = css.replace('--radius-sm: 0;', '--radius-sm: 4px;')
css = css.replace('--radius-md: 0;', '--radius-md: 8px;')
css = css.replace('--radius-lg: 0;', '--radius-lg: 12px;')
css = css.replace('--radius-xl: 0;', '--radius-xl: 16px;')

# We want to change border-radius: 0; to border-radius: 50px; for any block whose selector contains 'btn'
# We also do it for 'input' to keep them matching, except maybe we just change all `border-radius: 0;` to `50px`
# except for cards which get `var(--radius-md);`.

def replace_radius(match):
    selector = match.group(1)
    body = match.group(2)
    
    if 'card' in selector.lower():
        body = re.sub(r'border-radius:\s*0\s*;', 'border-radius: var(--radius-md);', body)
    elif 'btn' in selector.lower() or 'button' in selector.lower() or 'input' in selector.lower():
        body = re.sub(r'border-radius:\s*0\s*;', 'border-radius: 50px;', body)
    
    return f"{selector}{{{body}}}"

# Regex to match CSS blocks
new_css = re.sub(r'([^{]+)\{([^}]+)\}', replace_radius, css)

# Fix specifically .btn if it wasn't caught (it should be)
# And let's catch any leftover `border-radius: 0;` that might be badges or something and round them to 50px just in case,
# or maybe leave them. The prompt says "I want all the buttons to be rounded off, and the cards to have a small radius".

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(new_css)
print("Updated style.css")
