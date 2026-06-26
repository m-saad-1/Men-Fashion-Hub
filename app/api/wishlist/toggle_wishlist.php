<?php
// toggle_wishlist.php
require_once '../../config/config.php';

header("Content-Type: application/json");

// Check if user is authenticated
if (!isset($_SESSION['user_authenticated']) || $_SESSION['user_authenticated'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$productId = isset($input['product_id']) ? intval($input['product_id']) : 0;

error_log("Received product ID: " . $productId);

if ($productId <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID']);
    exit();
}

try {
    // Check if the product exists in the database
    $stmt = $conn->prepare("SELECT id, title, price, image FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if (!$product) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit();
    }
    
    // Check if the product is already in the user's wishlist
    $stmt = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $existingWishlistItem = $result->fetch_assoc();
    
    if ($existingWishlistItem) {
        // Remove from wishlist
        $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $_SESSION['user_id'], $productId);
        $stmt->execute();
        
        echo json_encode(['status' => 'success', 'action' => 'removed']);
    } else {
        // Add to wishlist
        $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, added_at) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $_SESSION['user_id'], $productId);
        $stmt->execute();
        
        echo json_encode([
            'status' => 'success', 
            'action' => 'added',
            'product' => [
                'id' => $product['id'],
                'title' => $product['title'],
                'price' => $product['price'],
                'image' => $product['image']
            ]
        ]);
    }
} catch (Exception $e) {
    error_log("Wishlist error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?>