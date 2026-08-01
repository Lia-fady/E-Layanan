import os
import re

base_dir = 'app/Views/dashboard/superadmin'

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    original = content

    # Find all <input ... type="checkbox" ...>
    # We want to replace it with <input type="hidden" name="MATCHED_NAME" value="0">\n <input ... value="1">
    
    # regex to match checkbox inputs that have role="switch"
    pattern = r'<input(.*?)type="checkbox"(.*?)role="switch"(.*?)>'

    def replacer(match):
        full_match = match.group(0)
        
        # skip if disabled (it means it's for display only, not form submission)
        if 'disabled' in full_match:
            return full_match

        # extract name attribute
        name_match = re.search(r'name="([^"]+)"', full_match)
        if not name_match:
            return full_match
        
        name = name_match.group(1)

        # if it already has value attribute, we can modify it or keep it
        if 'value="' in full_match:
            full_match = re.sub(r'value="[^"]*"', 'value="1"', full_match)
        else:
            # append value="1" before the closing bracket
            full_match = full_match.replace('>', ' value="1">')
            
        hidden_input = f'<input type="hidden" name="{name}" value="0">'
        
        # Don't add hidden input if it's already there (to avoid duplicates)
        # But we only match single line here. We'll just replace it.
        return f'{hidden_input}\n' + (' ' * 32) + full_match

    new_content = re.sub(pattern, replacer, content)

    # Clean up multiple hidden inputs if they got duplicated from running multiple times
    new_content = re.sub(r'(<input type="hidden" name="[^"]+" value="0">\s*)+<input type="hidden"', '<input type="hidden"', new_content)

    if new_content != original:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Fixed {filepath}")

for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))

