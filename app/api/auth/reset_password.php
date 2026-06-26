<?php
require_once '../../config/database.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'), true);
$email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    exit();
}

try {
    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'Email not found']);
        exit();
    }

    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Delete any existing tokens for this user
    $stmt = $conn->prepare("DELETE FROM password_reset_tokens WHERE user_id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();

    // Insert new token
    $stmt = $conn->prepare("INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user['id'], $token, $expiresAt);
    $stmt->execute();

    echo json_encode([
        'status' => 'success',
        'message' => 'Password reset link has been sent to your email'
    ]);
} catch(Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Password reset failed']);
}
?>