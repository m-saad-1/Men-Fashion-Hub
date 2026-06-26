<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '../../app/config/config.php';

try {
    $conn->query("ALTER TABLE products ADD COLUMN gender VARCHAR(50) DEFAULT 'unisex' AFTER title");
    echo "Added gender column.<br>";
} catch (Exception $e) {
    echo "Column add note: " . $e->getMessage() . "<br>";
}

$json_data = file_get_contents(__DIR__ . '/breakout_expanded.json');
$segments = json_decode($json_data, true);

if (!$segments) {
    die("JSON decode failed.");
}

$count = 0;
$stmt = $conn->prepare("INSERT INTO products 
    (title, gender, category, price, old_price, image, colors, sizes, rating, reviews, badge, featured, new_arrival, sku, description, features, color_codes)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

foreach ($segments as $segmentData) {
    if (empty($segmentData['products'])) continue;
    
    foreach ($segmentData['products'] as $product) {
        try {
            $price = $product['actual_price'] ?? 0;
            $old_price = null;
            if (isset($product['sale_price']) && $product['sale_price'] < $price) {
                $old_price = $price;
                $price = $product['sale_price'];
            }
            
            $title = $product['title'] ?? 'Unknown';
            $gender = $product['gender'] ?? 'unisex';
            $category = strtolower($product['category'] ?? 'uncategorized');
            $image = $product['images'][0]['url'] ?? '';
            $colors = json_encode($product['colors'] ?? []);
            $sizes = json_encode($product['sizes'] ?? []);
            $rating = 4.5;
            $reviews = rand(10, 50);
            $badge = null;
            $featured = 0;
            $new_arrival = 1;
            $sku = $product['external_product_id'] ?? uniqid();
            $description = 'Imported product';
            $features = json_encode([]);
            $color_codes = json_encode([]);

            $stmt->bind_param("sssddsssddiiissss", 
                $title, $gender, $category, $price, $old_price, $image, $colors, $sizes, 
                $rating, $reviews, $badge, $featured, $new_arrival, $sku, $description, $features, $color_codes
            );
            $stmt->execute();
            $count++;
        } catch (Exception $e) {
            echo "Error inserting $sku: " . $e->getMessage() . "<br>";
        }
    }
}
echo "Imported $count products.<br>";
?>
