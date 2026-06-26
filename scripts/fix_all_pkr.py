import re

file_paths = [
    "d:/xampp/htdocs/fashionhub/public/pages/index.php",
    "d:/xampp/htdocs/fashionhub/public/pages/product-details.php",
    "d:/xampp/htdocs/fashionhub/public/pages/cart.php",
    "d:/xampp/htdocs/fashionhub/public/pages/checkout.php"
]

for file_path in file_paths:
    try:
        with open(file_path, "r", encoding="utf-8") as f:
            content = f.read()

        # Update JS template literals
        content = content.replace("span class=\"current-price\">$${product.price", "span class=\"current-price\">Rs ${product.price")
        content = content.replace("span class=\"old-price\">$${product.oldPrice", "span class=\"old-price\">Rs ${product.oldPrice")
        content = content.replace("$${product.price.toFixed(2)}", "Rs ${product.price.toFixed(2)}")
        content = content.replace("$${product.oldPrice.toFixed(2)}", "Rs ${product.oldPrice.toFixed(2)}")
        
        # Update hardcoded HTML occurrences (just a simple replace for common patterns)
        content = re.sub(r'\$(\d+\.\d{2})', r'Rs \1', content)

        with open(file_path, "w", encoding="utf-8") as f:
            f.write(content)
        print(f"Modified {file_path}")
    except Exception as e:
        print(f"Error modifying {file_path}: {e}")
