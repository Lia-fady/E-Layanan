import os
import re

base_dir = 'app/Views/dashboard/superadmin'

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original = content

    # Fix prodi -> program-studi
    content = re.sub(r"base_url\('superadmin/prodi(/?.*?)'\)", r"base_url('superadmin/program-studi\1')", content)
    
    # Fix file / file_persyaratan -> file-persyaratan
    content = re.sub(r"base_url\('superadmin/file_persyaratan(/?.*?)'\)", r"base_url('superadmin/file-persyaratan\1')", content)
    content = re.sub(r"base_url\('superadmin/file(/?.*?)'\)", r"base_url('superadmin/file-persyaratan\1')", content)

    # Fix odp -> opd
    content = re.sub(r"base_url\('superadmin/odp(/?.*?)'\)", r"base_url('superadmin/opd\1')", content)

    # Ensure action/href without base_url are also covered if any
    content = re.sub(r'action="/superadmin/prodi(/?.*?)"', r'action="/superadmin/program-studi\1"', content)
    content = re.sub(r'href="/superadmin/prodi(/?.*?)"', r'href="/superadmin/program-studi\1"', content)

    content = re.sub(r'action="/superadmin/file(/?.*?)"', r'action="/superadmin/file-persyaratan\1"', content)
    content = re.sub(r'href="/superadmin/file(/?.*?)"', r'href="/superadmin/file-persyaratan\1"', content)

    content = re.sub(r'action="/superadmin/file_persyaratan(/?.*?)"', r'action="/superadmin/file-persyaratan\1"', content)
    content = re.sub(r'href="/superadmin/file_persyaratan(/?.*?)"', r'href="/superadmin/file-persyaratan\1"', content)

    content = re.sub(r'action="/superadmin/odp(/?.*?)"', r'action="/superadmin/opd\1"', content)
    content = re.sub(r'href="/superadmin/odp(/?.*?)"', r'href="/superadmin/opd\1"', content)

    if content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(content)
        print(f"Fixed {filepath}")

for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))

