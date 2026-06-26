<?php
// api/validate_session.php
require_once '../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json");
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$response = ['status' => 'error', 'message' => 'Invalid session'];

// Validate session
if (isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true) {
    // Check if session is not too old (optional security measure)
    $maxSessionAge = 3600; // 1 hour
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $maxSessionAge) {
        // Session is too old, require re-login
        session_unset();
        session_destroy();
        $response['message'] = 'Session expired';
    } else {
        // Session is valid
        $response['status'] = 'success';
        $response['message'] = 'Session valid';
        $response['user'] = [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];
    }
}

echo json_encode($response);
exit();
?>