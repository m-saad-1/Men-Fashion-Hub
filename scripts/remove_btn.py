import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/index.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.readlines()

# Remove line 1469
# Be careful: lines are 0-indexed in python, so 1468
# Let's just find the second occurrence and remove it
new_content = ""
count = 0
for line in content:
    if 'View All Products' in line and 'btn-primary' in line:
        count += 1
        if count == 2:
            continue # Skip adding the second one
    new_content += line

with open(file_path, "w", encoding="utf-8") as f:
    f.write(new_content)

print("Removed second View Products button!")
