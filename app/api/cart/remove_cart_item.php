<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/database.php';

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Get parameter either from JSON body or query param
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = $data['product_id'] ?? $_GET['product_id'] ?? null;
    $cart_id = $data['id'] ?? $_GET['id'] ?? null;

    if (!$product_id && !$cart_id) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Product ID or Cart ID is required']);
        exit;
    }

    if ($cart_id) {
        // Delete specific cart row by id
        $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->bind_param('ii', $cart_id, $user_id);
    } else {
        // Delete all matching products for this user
        $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param('ii', $product_id, $user_id);
    }

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete item']);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>