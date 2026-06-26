import re

with open("d:/xampp/htdocs/fashionhub/public/pages/index.php", "r", encoding="utf-8") as f:
    content = f.read()

# We want to remove everything from '<!-- End Featured Products Placeholder -->' 
# up to '<!-- Promo Banner -->'
start_idx = content.find("<!-- End Featured Products Placeholder -->")
end_idx = content.find("<!-- Promo Banner -->")

if start_idx != -1 and end_idx != -1:
    new_content = content[:start_idx] + "\n    " + content[end_idx:]
    with open("d:/xampp/htdocs/fashionhub/public/pages/index.php", "w", encoding="utf-8") as f:
        f.write(new_content)
    print("Cleaned index.php successfully.")
else:
    print("Could not find the markers.")
