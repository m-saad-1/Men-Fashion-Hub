<?php
// remove_purchased_items.php
require_once '../../config/config.php';

header("Content-Type: application/json");

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$product_ids = $input['product_ids'] ?? [];

// Validate input
if (empty($product_ids)) {
    echo json_encode(['status' => 'error', 'message' => 'No product IDs provided']);
    exit();
}

try {
    // Prepare placeholders for the IN clause
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
    
    // Delete purchased items from the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id IN ($placeholders)");
    
    // Combine user_id with product_ids for bind_param
    $types = "i" . str_repeat("i", count($product_ids));
    $params = array_merge([$_SESSION['user_id']], $product_ids);
    
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    
    echo json_encode(['status' => 'success', 'message' => 'Purchased items removed from cart']);
} catch (Exception $e) {
    error_log("Remove purchased items error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?>
