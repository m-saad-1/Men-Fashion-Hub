<?php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['id']) || !isset($data['quantity']) || $data['quantity'] < 1) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid cart item ID or quantity']);
        exit;
    }

    $cart_id = $data['id'];
    $quantity = $data['quantity'];

    // Get user ID from session
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    // Update cart item
    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param('isi', $quantity, $cart_id, $user_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Cart item not found']);
        exit;
    }

    http_response_code(200);
    echo json_encode([
        'message' => 'Cart item updated',
        'cart_id' => $cart_id,
        'quantity' => $quantity
    ]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>