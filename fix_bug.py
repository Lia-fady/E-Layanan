import os
import re

base_dirs = ['app/Views/dashboard/superadmin', 'app/Views/layouts']

def fix_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original = content

    content = content.replace('file-persyaratan-persyaratan', 'file-persyaratan')
    content = content.replace("base_url('superadmin/file')", "base_url('superadmin/file-persyaratan')")
    content = content.replace("$active_menu == 'file'", "$active_menu == 'file_persyaratan'")
    
    content = content.replace("base_url('superadmin/odp')", "base_url('superadmin/opd')")
    content = content.replace("$active_menu == 'odp'", "$active_menu == 'opd'")

    if content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Fixed {filepath}")

for d in base_dirs:
    for root, dirs, files in os.walk(d):
        for file in files:
            if file.endswith('.php'):
                fix_file(os.path.join(root, file))
