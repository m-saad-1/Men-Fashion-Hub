<?php
session_start();
require_once '../../config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['new_password'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'New password is required']);
    exit();
}

$user_id = $_SESSION['user_id'];
$new_password = $data['new_password'];

try {
    // Update password
    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashedPassword, $user_id);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Password changed successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>