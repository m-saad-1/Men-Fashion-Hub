import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Remove sidebar Categories
cat_sidebar_start = content.find('<div class="filter-section">\n                        <h3>Categories</h3>')
if cat_sidebar_start != -1:
    cat_sidebar_end = content.find('</div>', cat_sidebar_start) + 6
    content = content[:cat_sidebar_start] + content[cat_sidebar_end:]
    print("Removed sidebar categories")

# 2. Remove sidebar Price Range
price_sidebar_start = content.find('<div class="filter-section">\n                        <h3>Price Range</h3>')
if price_sidebar_start != -1:
    price_sidebar_end = content.find('</div>\n                    </div>', price_sidebar_start) + 33
    content = content[:price_sidebar_start] + content[price_sidebar_end:]
    print("Removed sidebar price range")

# 3. Update top price filter
old_price_filter = """<select id="topPriceFilter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                    <option value="all">Any Price</option>
                                    <option value="0-50">Under $50</option>
                                    <option value="50-100">$50 - $100</option>
                                    <option value="100-200">$100 - $200</option>
                                    <option value="200+">Over $200</option>
                                </select>"""
new_price_filter = """<select id="topPriceFilter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                    <option value="all">Any Price</option>
                                    <option value="0-3000">Under Rs 3,000</option>
                                    <option value="3000-5000">Rs 3,000 - Rs 5,000</option>
                                    <option value="5000-10000">Rs 5,000 - Rs 10,000</option>
                                    <option value="10000+">Over Rs 10,000</option>
                                </select>"""
content = content.replace(old_price_filter, new_price_filter)

# 4. Update JS logic for price string
content = content.replace("} else if (this.value === '200+') {", "} else if (this.value === '10000+') {")
content = content.replace("currentFilters.minPrice = 200;", "currentFilters.minPrice = 10000;")
content = content.replace("currentFilters.maxPrice = 5000;", "currentFilters.maxPrice = 1000000;")
content = content.replace("currentFilters.maxPrice = 5000;", "currentFilters.maxPrice = 1000000;") # replace any other instances

# 5. Fix render function Rs instead of $
content = content.replace("span class=\"current-price\">$${product.price", "span class=\"current-price\">Rs ${product.price")
content = content.replace("span class=\"old-price\">$${product.oldPrice", "span class=\"old-price\">Rs ${product.oldPrice")
content = content.replace("$${product.price.toFixed(2)}", "Rs ${product.price.toFixed(2)}")
content = content.replace("$${product.oldPrice.toFixed(2)}", "Rs ${product.oldPrice.toFixed(2)}")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)
print("shop.php modified.")
