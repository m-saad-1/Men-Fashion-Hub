<?php
/**
 * Re-import products from breakout_expanded.json with full data mapping
 * Run via: http://localhost/fashionhub/scripts/reimport_products.php
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(120);

require_once __DIR__ . '/../app/config/database.php';

// Add columns if missing
$alterColumns = [
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS gender VARCHAR(50) DEFAULT 'unisex' AFTER title",
    "ALTER TABLE products ADD COLUMN IF NOT EXISTS division VARCHAR(50) DEFAULT 'top' AFTER gender",
];
foreach ($alterColumns as $sql) {
    @$conn->query($sql);
}

// Seed random ratings/reviews per product based on product ID for consistency
function getSeededRating($id) {
    $ratings = [4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8, 4.9, 3.8, 3.9, 4.0];
    return $ratings[$id % count($ratings)];
}

function getSeededReviews($id) {
    $values = [24, 87, 132, 45, 201, 67, 15, 93, 178, 56, 245, 31, 112, 78, 189, 42, 155, 63, 98, 220];
    return $values[$id % count($values)];
}

// Clear existing products (disable FK checks to allow delete)
$conn->query("SET FOREIGN_KEY_CHECKS=0");
$conn->query("TRUNCATE TABLE products");
$conn->query("SET FOREIGN_KEY_CHECKS=1");
echo "Cleared existing products.<br>\n";

// Load JSON
$jsonPath = __DIR__ . '/../breakout_expanded.json';
if (!file_exists($jsonPath)) {
    $jsonPath = __DIR__ . '/breakout_expanded.json';
}
if (!file_exists($jsonPath)) {
    die("JSON file not found at: $jsonPath");
}

$json_data = file_get_contents($jsonPath);
$segments = json_decode($json_data, true);

if (!$segments) {
    die("JSON decode failed: " . json_last_error_msg());
}

// Color name to hex mapping
$colorHexMap = [
    'Navy' => '#1a2a4a', 'White' => '#f5f5f5', 'Black' => '#1a1a1a',
    'Brown' => '#6b4226', 'Mustard' => '#c9951a', 'Grey' => '#808080',
    'Gray' => '#808080', 'Sky Blue' => '#87ceeb', 'Blue' => '#2b5797',
    'Red' => '#c0392b', 'Green' => '#27ae60', 'Olive' => '#808000',
    'Beige' => '#f5f0e8', 'Camel' => '#c19a6b', 'Burgundy' => '#800020',
    'Maroon' => '#800000', 'Pink' => '#ff69b4', 'Purple' => '#6a0dad',
    'Orange' => '#e67e22', 'Yellow' => '#f1c40f', 'Khaki' => '#c3b091',
    'Teal' => '#008080', 'Cream' => '#fffdd0', 'Off White' => '#faf9f6',
    'Charcoal' => '#36454f', 'Light Blue' => '#add8e6', 'Dark Blue' => '#00008b',
    'Tan' => '#d2b48c', 'Stone' => '#b0a090', 'Rust' => '#b7410e',
    'Mint' => '#98ff98', 'Coral' => '#ff6b6b', 'Denim' => '#1560bd',
];

function getColorHex($color) {
    global $colorHexMap;
    if (isset($colorHexMap[$color])) return $colorHexMap[$color];
    foreach ($colorHexMap as $k => $v) {
        if (strtolower($k) === strtolower($color)) return $v;
    }
    return '#888888';
}

// Division mapping  
function getDivision($category, $division, $title) {
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
}

// Prepare insert
$stmt = $conn->prepare("INSERT INTO products 
    (title, gender, division, category, price, old_price, image, colors, sizes, rating, reviews, badge, featured, new_arrival, sku, description, features, color_codes)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$count = 0;
$skipped = 0;
$seenSkus = [];

foreach ($segments as $segmentData) {
    if (empty($segmentData['products'])) continue;
    
    foreach ($segmentData['products'] as $product) {
        try {
            $sku = strtoupper($product['external_product_id'] ?? uniqid());
            
            // Skip duplicates
            if (in_array($sku, $seenSkus)) {
                $skipped++;
                continue;
            }
            $seenSkus[] = $sku;
            
            // Price handling - keep raw JSON values (PKR)
            $actualPrice = (float)($product['actual_price'] ?? 0);
            $salePrice = isset($product['sale_price']) && $product['sale_price'] !== null ? (float)$product['sale_price'] : null;
            
            if ($salePrice && $salePrice < $actualPrice) {
                $price = $salePrice;
                $old_price = $actualPrice;
            } else {
                $price = $actualPrice;
                $old_price = null;
            }
            
            if ($price <= 0) $price = 9.99;
            
            $title = $product['title'] ?? 'Unknown Product';
            $gender = strtolower($product['gender'] ?? 'unisex');
            $category = strtolower($product['category'] ?? 'clothing');
            $division = getDivision($category, $product['division'] ?? '', $title);
            
            // Get primary image
            $image = '';
            if (!empty($product['images'])) {
                foreach ($product['images'] as $img) {
                    if ($img['isPrimary'] ?? false) {
                        $image = $img['url'] ?? '';
                        break;
                    }
                }
                if (!$image) {
                    $image = $product['images'][0]['url'] ?? '';
                }
            }
            
            // Colors
            $colors = $product['colors'] ?? [];
            if (empty($colors) && !empty($product['variants'])) {
                $seen = [];
                foreach ($product['variants'] as $v) {
                    $c = $v['color_name'] ?? $v['color'] ?? '';
                    if ($c && !in_array($c, $seen)) { $seen[] = $c; }
                }
                $colors = $seen;
            }
            
            // Color codes
            $colorCodes = [];
            foreach ($colors as $color) {
                $colorCodes[$color] = getColorHex($color);
            }
            
            $sizes = $product['sizes'] ?? [];
            if (empty($sizes) && !empty($product['variants'])) {
                $seen = [];
                foreach ($product['variants'] as $v) {
                    $s = $v['size'] ?? '';
                    if ($s && !in_array($s, $seen)) { $seen[] = $s; }
                }
                $sizes = $seen;
            }
            
            $productId = $count + 1;
            $rating = getSeededRating($productId);
            $reviews = getSeededReviews($productId);
            
            // Badge logic
            $badge = null;
            if ($old_price && $old_price > $price) {
                $badge = 'sale';
            } elseif ($count < 20) {
                $badge = 'new';
            }
            
            $featured = ($count < 8) ? 1 : 0;
            $new_arrival = ($count < 40) ? 1 : 0;
            
            // Build realistic description
            $fit = $product['variants'][0]['fit'] ?? '';
            $gender_label = ucfirst($gender);
            $category_label = ucfirst($category);
            $colorsText = implode(', ', $colors);
            $sizesText = implode(', ', $sizes);
            
            $desc = "{$title}. " .
                ($fit ? "{$fit} {$category_label} for {$gender_label}. " : "{$category_label} for {$gender_label}. ") .
                ($colorsText ? "Available in: {$colorsText}. " : '') .
                ($sizesText ? "Sizes: {$sizesText}. " : '') .
                "A premium quality garment crafted with care, designed for modern fashion-forward individuals seeking comfort and style.";
            
            // Features based on product type
            $features = [];
            if (in_array($category, ['shirt', 'tshirt', 't-shirt', 'tee'])) {
                $features = [
                    "Premium quality fabric",
                    ($fit ?: "Regular") . " fit",
                    "Chest pocket design",
                    "Ribbed collar",
                    "Machine washable at 30°C"
                ];
            } elseif (in_array($category, ['jeans', 'trouser', 'pant', 'jogger', 'short'])) {
                $features = [
                    "Durable premium denim/fabric",
                    ($fit ?: "Classic") . " fit",
                    "Five-pocket styling",
                    "Zip/button fly closure",
                    "Machine wash cold"
                ];
            } elseif (in_array($category, ['jacket', 'coat', 'hoodie', 'sweatshirt'])) {
                $features = [
                    "Quality outer fabric",
                    ($fit ?: "Regular") . " fit",
                    "Full-length zipper/button closure",
                    "Two side pockets",
                    "Machine washable"
                ];
            } elseif (in_array($division, ['accessory'])) {
                $features = [
                    "Premium quality materials",
                    "Durable construction",
                    "Stylish design",
                    "Versatile use",
                    "Easy care"
                ];
            } else {
                $features = [
                    "Premium quality materials",
                    ($fit ?: "Standard") . " fit",
                    "Carefully crafted details",
                    "Comfortable all-day wear",
                    "Follow care label instructions"
                ];
            }
            
            $colorsJson = json_encode($colors, JSON_UNESCAPED_UNICODE);
            $sizesJson = json_encode($sizes, JSON_UNESCAPED_UNICODE);
            $featuresJson = json_encode($features, JSON_UNESCAPED_UNICODE);
            $colorCodesJson = json_encode($colorCodes, JSON_UNESCAPED_UNICODE);
            
            $stmt->bind_param("ssssddsssdisiissss", 
                $title, $gender, $division, $category, $price, $old_price, $image,
                $colorsJson, $sizesJson, $rating, $reviews, $badge, $featured,
                $new_arrival, $sku, $desc, $featuresJson, $colorCodesJson
            );
            
            if (!$stmt->execute()) {
                echo "Error inserting $sku: " . $stmt->error . "<br>\n";
            } else {
                $count++;
                if ($count % 50 === 0) {
                    echo "Imported $count products so far...<br>\n";
                    flush();
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br>\n";
        }
    }
}

echo "<strong>✅ Successfully imported $count products. Skipped $skipped duplicates.</strong><br>\n";
echo "<a href='../public/pages/shop.php'>Go to Shop</a> | ";
echo "<a href='../public/pages/index.php'>Go to Homepage</a><br>\n";
?>
