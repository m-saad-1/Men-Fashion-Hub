<?php
// update_cart.php
require_once '../../config/config.php';

header("Content-Type: application/json");

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);
$cartItems = $input['cart'] ?? [];

// Validate input
if (empty($cartItems)) {
    echo json_encode(['status' => 'error', 'message' => 'Cart data is required']);
    exit();
}

try {
    // Begin transaction
    $conn->begin_transaction();
    
    // First, remove all existing cart items for this user
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    
    // Then, insert the updated cart items
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($cartItems as $item) {
        $size = $item['size'] ?? null;
        $color = $item['color'] ?? null;
        $stmt->bind_param("iiiss",
            $_SESSION['user_id'],
            $item['id'],
            $item['quantity'],
            $size,
            $color
        );
        $stmt->execute();
    }
    
    // Commit transaction
    $conn->commit();
    
    echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    error_log("Update cart error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
}
?>