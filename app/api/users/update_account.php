<?php
session_start();
require_once '../../config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    // Get current user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit();
    }

    // Validate current password only if changing password
    if (!empty($data['new_password'])) {
        if (empty($data['current_password']) || !password_verify($data['current_password'], $user['password'])) {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
            exit();
        }
        
        // Update password
        $hashedPassword = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashedPassword, $_SESSION['user_id']);
        $stmt->execute();
    }

    // Update other fields
    $fullName = $data['first_name'] . ' ' . $data['last_name'];
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $fullName, $data['email'], $_SESSION['user_id']);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>