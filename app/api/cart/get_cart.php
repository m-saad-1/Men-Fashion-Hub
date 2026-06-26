<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/database.php';

// Get user ID from session
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$stmt = $conn->prepare("SELECT c.*, p.title, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart = [];
while ($row = $result->fetch_assoc()) {
    $cart[] = [
        'id' => $row['id'],
        'product_id' => $row['product_id'],
        'quantity' => $row['quantity'],
        'title' => $row['title'],
        'price' => $row['price'],
        'image' => $row['image'],
        'size' => $row['size'],
        'color' => $row['color']
    ];
}

http_response_code(200);
echo json_encode([
    'status' => 'success',
    'cart' => $cart
]);
?>