import re

file_path = "d:/xampp/htdocs/fashionhub/scripts/reimport_products.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Update getDivision to include $title
old_getDivision = """function getDivision($category, $division) {
    $cat = strtolower($category ?? '');
    $div = strtolower($division ?? '');
    
    $tops = ['shirt', 'tshirt', 't-shirt', 'tee', 'polo', 'hoodie', 'sweatshirt', 'jacket', 'coat', 'blazer', 'knitwear', 'sweater', 'top', 'blouse'];
    $bottoms = ['jeans', 'trouser', 'pant', 'shorts', 'joggers', 'chinos', 'bottom'];
    $footwear = ['shoes', 'sneaker', 'trainer', 'boot', 'sandal', 'loafer', 'footwear'];
    $accessories = ['bag', 'wallet', 'belt', 'cap', 'hat', 'watch', 'sunglass', 'accessory', 'scarf', 'jewelry'];
    
    foreach ($tops as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false) return 'top'; }
    foreach ($bottoms as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false) return 'bottom'; }
    foreach ($footwear as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false) return 'footwear'; }
    foreach ($accessories as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false) return 'accessory'; }
    
    return $division ?: 'top';
}"""

new_getDivision = """function getDivision($category, $division, $title) {
    $cat = strtolower($category ?? '');
    $div = strtolower($division ?? '');
    $tit = strtolower($title ?? '');
    
    $tops = ['shirt', 'tshirt', 't-shirt', 'tee', 'polo', 'hoodie', 'sweatshirt', 'jacket', 'coat', 'blazer', 'knitwear', 'sweater', 'top', 'blouse'];
    $bottoms = ['jeans', 'trouser', 'pant', 'short', 'joggers', 'chinos', 'bottom'];
    $footwear = ['shoes', 'sneaker', 'trainer', 'boot', 'sandal', 'loafer', 'footwear'];
    // Avoid 'bag' matching 'baggy'
    $accessories = [' bag', 'bag ', 'wallet', 'belt', 'cap', 'hat', 'watch', 'sunglass', 'accessory', 'scarf', 'jewelry'];
    
    foreach ($bottoms as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false || strpos($tit, $kw) !== false) return 'bottom'; }
    foreach ($tops as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false || strpos($tit, $kw) !== false) return 'top'; }
    foreach ($footwear as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false || strpos($tit, $kw) !== false) return 'footwear'; }
    foreach ($accessories as $kw) { if (strpos($cat, $kw) !== false || strpos($div, $kw) !== false || strpos($tit, $kw) !== false) return 'accessory'; }
    
    return $division ?: 'top';
}"""

content = content.replace(old_getDivision, new_getDivision)

# Also need to update the call: $division = getDivision($category, $product['division'] ?? '');
content = content.replace(
    "$division = getDivision($category, $product['division'] ?? '');",
    "$division = getDivision($category, $product['division'] ?? '', $title);"
)

# 2. Update Pricing to raw JSON values
old_price_handling = """            // Price handling - convert PKR to USD
            $actualPrice = (float)($product['actual_price'] ?? 0);
            $salePrice = isset($product['sale_price']) && $product['sale_price'] !== null ? (float)$product['sale_price'] : null;
            
            if ($salePrice && $salePrice < $actualPrice) {
                $price = round($salePrice / 280, 2);
                $old_price = round($actualPrice / 280, 2);
            } else {
                $price = round($actualPrice / 280, 2);
                $old_price = null;
            }"""

new_price_handling = """            // Price handling - keep raw JSON values (PKR)
            $actualPrice = (float)($product['actual_price'] ?? 0);
            $salePrice = isset($product['sale_price']) && $product['sale_price'] !== null ? (float)$product['sale_price'] : null;
            
            if ($salePrice && $salePrice < $actualPrice) {
                $price = $salePrice;
                $old_price = $actualPrice;
            } else {
                $price = $actualPrice;
                $old_price = null;
            }"""

content = content.replace(old_price_handling, new_price_handling)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated reimport script!")
