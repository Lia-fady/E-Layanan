import os
import re

base_dir = 'app/Views/dashboard/superadmin'

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original_content = content

    # 1. Remove mockup pagination
    content = re.sub(r'<div class="row align-items-center mt-3">\s*<div class="col-md-6">\s*<p class="mb-0 text-muted small">.*?</nav>\s*</div>\s*</div>', '', content, flags=re.DOTALL)
    
    # 2. Remove Delete Modal HTML
    content = re.sub(r'<!-- Delete Modal -->\s*<div class="modal fade" id="deleteModal".*?</form>\s*</div>\s*</div>\s*</div>', '', content, flags=re.DOTALL)
    content = re.sub(r'<div class="modal fade" id="deleteModal".*?</form>\s*</div>\s*</div>\s*</div>', '', content, flags=re.DOTALL)

    # 3. Remove btnHapus inline script logic (Vanilla JS)
    content = re.sub(r'// Delete Modal Logic\s*const btnHapus = document\.querySelectorAll\(\'\.btn-hapus\'\);\s*const formDelete = document\.getElementById\(\'formDelete\'\);\s*btnHapus\.forEach\(btn => \{.*?\n\s*\}\);', '', content, flags=re.DOTALL)

    # 4. Remove btnHapus logic in jQuery
    content = re.sub(r'\$\(\'\.btn-hapus\'\)\.on\(\'click\', function\(\) \{.*?\$\(\'#formDelete\'\)\.attr\(\'action\', .*?\);\s*\}\);', '', content, flags=re.DOTALL)

    if content != original_content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Cleaned {filepath}")
    else:
        print(f"No changes in {filepath}")

for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file == 'v_index.php' or file.startswith('v_manajemen_'):
            process_file(os.path.join(root, file))
