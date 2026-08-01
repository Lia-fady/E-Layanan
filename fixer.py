import os
import re

base_dir = 'app/Views/dashboard/superadmin'

def fix_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original = content
    # Look for two `});` followed by `</script>`
    content = re.sub(r'\}\);\s*\}\);\s*</script>', r'});\n</script>', content, flags=re.DOTALL)

    if content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Fixed {filepath}")

for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file == 'v_index.php' or file.startswith('v_manajemen_'):
            fix_file(os.path.join(root, file))
