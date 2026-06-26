import re

file_path = "d:/xampp/htdocs/fashionhub/app/views/partials/header.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace font-weight: 600 with font-weight: 400; font-size: 14px;
content = content.replace('style="font-weight: 600;"', 'style="font-weight: 400; font-size: 14px;"')
content = content.replace('style="font-weight:600;"', 'style="font-weight: 400; font-size: 14px;"')

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated header link fonts!")
