<?php
// api/login.php - FIXED VERSION
header("Content-Type: application/json");
error_reporting(0);

require_once '../../config/database.php';

// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    // Set secure session parameters BEFORE starting session
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    
    session_start();
}

// Add cache prevention headers
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON input");
    }

    $email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $input['password'] ?? '';
    $rememberMe = $input['rememberMe'] ?? false;

    if (empty($email)) {
        throw new Exception("Email is required");
    }

    if (empty($password)) {
        throw new Exception("Password is required");
    }

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        throw new Exception("Invalid email or password");
    }

    if (!password_verify($password, $user['password'])) {
        throw new Exception("Invalid email or password");
    }

    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

    // Clear any existing session data
    $_SESSION = [];

    // Set new session data
    $_SESSION = [
        'user_id' => $user['id'],
        'user_email' => $user['email'],
        'user_name' => $user['name'],
        'user_role' => $user['role'] ?? 'user',
        'user_authenticated' => true,
        'last_activity' => time(),
        'login_time' => time() // Add login time for validation
    ];

    if ($rememberMe) {
        $token = bin2hex(random_bytes(32));
        $expiry = time() + (30 * 24 * 60 * 60);
        
        // Delete any existing tokens for this user
        $stmt = $conn->prepare("DELETE FROM remember_tokens WHERE user_id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        
        // Insert new token
        $stmt = $conn->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user['id'], hash('sha256', $token), date('Y-m-d H:i:s', $expiry));
        $stmt->execute();

        setcookie(
            'remember_token',
            json_encode(['user_id' => $user['id'], 'token' => $token, 'login_time' => time()]),
            [
                'expires' => $expiry,
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
    }

    echo json_encode([
        'status' => 'success',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]
    ]);

} catch (Exception $e) {
    // Clear session on error
    session_unset();
    session_destroy();
    
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
    error_log("Login error: " . $e->getMessage());
}
?>