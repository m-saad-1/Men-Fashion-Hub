<?php
require_once '../../config/database.php';

header("Content-Type: application/json");

$response = ['status' => 'error', 'message' => 'User not found'];

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("SELECT id, name, email, role, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $response = [
                'status' => 'success',
                'user' => $user
            ];
        }
    } catch (Exception $e) {
        $response['message'] = 'Database error';
        error_log("Get user error: " . $e->getMessage());
    }
}

echo json_encode($response);
?>