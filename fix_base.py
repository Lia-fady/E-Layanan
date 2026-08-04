import os

app_dir = r"c:\Users\Ahmad Hisyam\Downloads\Projectmagang_elayananuhuy\app\Controllers"

for root, dirs, files in os.walk(app_dir):
    for f in files:
        if f.endswith(".php"):
            full_path = os.path.join(root, f)
            with open(full_path, "r", encoding="utf-8") as file:
                content = file.read()
            
            original = content
            
            # If it extends BaseController
            if "extends BaseController" in content:
                content = content.replace("extends BaseController", "extends C_Base")
                # Need to import C_Base if it's not in Shared namespace
                if "namespace App\\Controllers\\Shared;" not in content:
                    # insert after namespace definition
                    # use App\Controllers\Shared\C_Base;
                    if "use App\\Controllers\\Shared\\C_Base;" not in content:
                        content = content.replace("namespace ", "use App\\Controllers\\Shared\\C_Base;\nnamespace ", 1)
                        # Actually wait, `use` should come AFTER `namespace`.
                        
            if content != original:
                # Fix the namespace substitution above, it was wrong
                content = original
                content = content.replace("extends BaseController", "extends C_Base")
                if "namespace App\\Controllers\\Shared;" not in content:
                    # Find namespace line and append use statement after it
                    import re
                    content = re.sub(r'(namespace App\\[a-zA-Z0-9_\\]+;)', r'\1\n\nuse App\\Controllers\\Shared\\C_Base;', content)
                
                with open(full_path, "w", encoding="utf-8") as file:
                    file.write(content)

print("BaseController updated.")
