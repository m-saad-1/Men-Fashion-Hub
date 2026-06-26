<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['product_id']) || !isset($data['quantity']) || $data['quantity'] < 1) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid product ID or quantity']);
        exit;
    }

    $product_id = intval($data['product_id']);
    $quantity = intval($data['quantity']);
    $size = isset($data['size']) ? trim($data['size']) : null;
    $color = isset($data['color']) ? trim($data['color']) : null;
    
    // Check if product exists
    $stmt = $conn->prepare("SELECT id, price FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if (!$result->num_rows) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit;
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        exit;
    }

    // Check if item already exists in cart with same size/color
    $stmt = $conn->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND (size = ? OR (size IS NULL AND ? IS NULL)) AND (color = ? OR (color IS NULL AND ? IS NULL))");
    $stmt->bind_param('iissss', $user_id, $product_id, $size, $size, $color, $color);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res->num_rows > 0) {
        // Update quantity
        $row = $res->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        $stmt_update = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt_update->bind_param('ii', $new_quantity, $row['id']);
        $stmt_update->execute();
    } else {
        // Insert new item
        $stmt_insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, size, color) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param('iiiss', $user_id, $product_id, $quantity, $size, $color);
        $stmt_insert->execute();
    }

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Item added to cart',
        'product_id' => $product_id,
        'quantity' => $quantity
    ]);
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
?>