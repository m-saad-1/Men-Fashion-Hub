import re

files = [
    "d:/xampp/htdocs/fashionhub/public/pages/shop.php",
    "d:/xampp/htdocs/fashionhub/public/pages/index.php"
]

for file_path in files:
    with open(file_path, "r", encoding="utf-8") as f:
        content = f.read()
    
    old_code = """        // Click on product card opens modal
        productCard.addEventListener('click', function(e) {
            if (e.target.closest('.product-actions')) return;
            window.location.href = `product-details.php?id=${product.id}`;
        });
        
        quickViewBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = `product-details.php?id=${product.id}`;
        });"""
        
    new_code = """        // Click on product card opens modal
        productCard.addEventListener('click', function(e) {
            if (e.target.closest('.product-actions')) return;
            showProductModal(product);
        });
        
        quickViewBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            showProductModal(product);
        });"""
        
    content = content.replace(old_code, new_code)
    
    with open(file_path, "w", encoding="utf-8") as f:
        f.write(content)

print("Updated modal opening logic!")
