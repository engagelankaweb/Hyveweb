import re

with open('css/style.css', 'r', encoding='utf-8') as f:
    content = f.read()

# Pattern for the main button definition
pattern1 = r'(\.navbar-currency-btn\s*\{[^\}]+?)background:\s*var\(--color-bg-secondary,\s*rgba\(255,\s*255,\s*255,\s*0\.9\)\);([^\}]+?)border:\s*1px\s*solid\s*var\(--color-border,\s*#e2e8f0\);([^\}]+?)color:\s*var\(--color-text-main\);'

# Replacement: replace those specific lines within the block
def repl1(m):
    return m.group(1) + 'background: #000;' + m.group(2) + 'border: 1px solid #333;' + m.group(3) + 'color: #fff;'

content = re.sub(pattern1, repl1, content)

# Pattern for the scrolled background
pattern2 = r'(\.navbar:not\(\.scrolled\)\s*\.navbar-currency-btn\s*\{[^\}]+?)background:\s*rgba\(255,\s*255,\s*255,\s*0\.15\);'

def repl2(m):
    return m.group(1) + 'background: #000;'

content = re.sub(pattern2, repl2, content)

with open('css/style.css', 'w', encoding='utf-8') as f:
    f.write(content)
