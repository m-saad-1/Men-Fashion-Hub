<?php
session_start();
require_once '../../config/database.php';

header("Content-Type: application/json");

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user's wishlist items with product details
$stmt = $conn->prepare("
    SELECT p.*, w.added_at 
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id = ?
    ORDER BY w.added_at DESC
");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$wishlistItems = [];
while ($row = $result->fetch_assoc()) {
    $row['product_id'] = $row['id']; // Map id to product_id for backward compatibility
    $row['colors'] = json_decode($row['colors'], true) ?: [];
    $row['sizes'] = json_decode($row['sizes'], true) ?: [];
    $row['features'] = json_decode($row['features'], true) ?: [];
    $row['color_codes'] = json_decode($row['color_codes'], true) ?: [];
    $row['oldPrice'] = $row['old_price'] ? (float)$row['old_price'] : null;
    unset($row['old_price']);
    $row['newArrival'] = (bool)$row['new_arrival'];
    unset($row['new_arrival']);
    $row['price'] = (float)$row['price'];
    $row['rating'] = (float)$row['rating'];
    $row['reviews'] = (int)$row['reviews'];
    $row['featured'] = (bool)$row['featured'];
    $wishlistItems[] = $row;
}

echo json_encode([
    'status' => 'success',
    'wishlist' => $wishlistItems
]);
?>