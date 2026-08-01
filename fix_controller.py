import os
import re

filepath = 'app/Controllers/SuperAdmin/C_Management.php'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

# 1. Rename prodi to programStudi in method names
content = re.sub(r'public function prodi\(', r'public function programStudi(', content)
content = re.sub(r'public function prodiCreate\(', r'public function programStudiCreate(', content)
content = re.sub(r'public function prodiStore\(', r'public function programStudiStore(', content)
content = re.sub(r'public function prodiEdit\(', r'public function programStudiEdit(', content)
content = re.sub(r'public function prodiUpdate\(', r'public function programStudiUpdate(', content)
content = re.sub(r'public function prodiDelete\(', r'public function programStudiDelete(', content)
content = re.sub(r'public function prodiDetail\(', r'public function programStudiDetail(', content)

# 2. Rename file to filePersyaratan in method names
content = re.sub(r'public function file\(', r'public function filePersyaratan(', content)
content = re.sub(r'public function fileCreate\(', r'public function filePersyaratanCreate(', content)
content = re.sub(r'public function fileStore\(', r'public function filePersyaratanStore(', content)
content = re.sub(r'public function fileEdit\(', r'public function filePersyaratanEdit(', content)
content = re.sub(r'public function fileUpdate\(', r'public function filePersyaratanUpdate(', content)
content = re.sub(r'public function fileDelete\(', r'public function filePersyaratanDelete(', content)
content = re.sub(r'public function fileDetail\(', r'public function filePersyaratanDetail(', content)

# 3. Rename odp to opd in method names
content = re.sub(r'public function odp\(', r'public function opd(', content)
content = re.sub(r'public function odpCreate\(', r'public function opdCreate(', content)
content = re.sub(r'public function odpStore\(', r'public function opdStore(', content)
content = re.sub(r'public function odpEdit\(', r'public function opdEdit(', content)
content = re.sub(r'public function odpUpdate\(', r'public function opdUpdate(', content)
content = re.sub(r'public function odpDelete\(', r'public function opdDelete(', content)
content = re.sub(r'public function odpDetail\(', r'public function opdDetail(', content)

# 4. Rename active_menu parameters
content = re.sub(r"'prodi', \$data\);", r"'program_studi', $data);", content)
content = re.sub(r"'file', \$data\);", r"'file_persyaratan', $data);", content)
content = re.sub(r"'odp', \$data\);", r"'opd', $data);", content)
# Check for single/double quotes just in case
content = re.sub(r'"prodi", \$data\);', r'"program_studi", $data);', content)
content = re.sub(r'"file", \$data\);', r'"file_persyaratan", $data);', content)
content = re.sub(r'"odp", \$data\);', r'"opd", $data);', content)

# 5. Fix redirect paths if there are any inside C_Management
content = re.sub(r"redirect\(\)->to\(base_url\('superadmin/prodi'\)\)", r"redirect()->to(base_url('superadmin/program-studi'))", content)
content = re.sub(r"redirect\(\)->to\('superadmin/prodi'\)", r"redirect()->to('superadmin/program-studi')", content)

content = re.sub(r"redirect\(\)->to\(base_url\('superadmin/file'\)\)", r"redirect()->to(base_url('superadmin/file-persyaratan'))", content)
content = re.sub(r"redirect\(\)->to\(base_url\('superadmin/file_persyaratan'\)\)", r"redirect()->to(base_url('superadmin/file-persyaratan'))", content)
content = re.sub(r"redirect\(\)->to\('superadmin/file'\)", r"redirect()->to('superadmin/file-persyaratan')", content)

content = re.sub(r"redirect\(\)->to\(base_url\('superadmin/odp'\)\)", r"redirect()->to(base_url('superadmin/opd'))", content)
content = re.sub(r"redirect\(\)->to\('superadmin/odp'\)", r"redirect()->to('superadmin/opd')", content)


with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)

print("Controller updated successfully.")
