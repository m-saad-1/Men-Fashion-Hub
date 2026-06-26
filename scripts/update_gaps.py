import re

# 1. Update shop.php
shop_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"
with open(shop_path, "r", encoding="utf-8") as f:
    content = f.read()

content = content.replace("gap: 15px;", "gap: 5px;")
# That might replace other gaps. Let's be specific for .modal-details
old_modal = """.modal-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }"""
new_modal = """.modal-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }"""
if old_modal in content:
    content = content.replace(old_modal, new_modal)

with open(shop_path, "w", encoding="utf-8") as f:
    f.write(content)

# 2. Update style.css
css_path = "d:/xampp/htdocs/fashionhub/public/assets/css/style.css"
with open(css_path, "r", encoding="utf-8") as f:
    css = f.read()

old_title = """.product-title {
    font-size: 1rem;
    margin-bottom: 5px;
    color: var(--primary-color);
}"""
new_title = """.product-title {
    font-size: 1rem;
    margin-bottom: 2px;
    color: var(--primary-color);
}"""
if old_title in css:
    css = css.replace(old_title, new_title)

old_price = """.product-price {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 10px 0;
}"""
new_price = """.product-price {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 2px 0;
}"""
if old_price in css:
    css = css.replace(old_price, new_price)

with open(css_path, "w", encoding="utf-8") as f:
    f.write(css)

print("Updated gaps!")
