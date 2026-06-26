import re

file_path = "d:/xampp/htdocs/fashionhub/scripts/reimport_products.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace bind_param
old_bind = '$stmt->bind_param("ssssddsssddiissss",'
new_bind = '$stmt->bind_param("ssssddsssdisiissss",'

content = content.replace(old_bind, new_bind)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Fixed bind_param")
