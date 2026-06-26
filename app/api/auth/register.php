<?php
header("Content-Type: application/json");
error_reporting(0); // Turn off error reporting to prevent HTML output

require_once '../../config/database.php';

// Get input data
$input = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    exit();
}

$name = htmlspecialchars(trim($input['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($input['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = $input['password'] ?? '';

$errors = [];

// Validation
if (empty($name)) $errors['name'] = 'Name is required';
if (empty($email)) $errors['email'] = 'Email is required';
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Invalid email format';
if (empty($password)) $errors['password'] = 'Password is required';
elseif (strlen($password) < 6) $errors['password'] = 'Password must be at least 6 characters';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit();
}

try {
    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        http_response_code(409);
        echo json_encode([
            'status' => 'error',
            'errors' => ['email' => 'Email already registered']
        ]);
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        $insertId = $conn->insert_id;
        
        // Start session for the new user
        if (session_status() === PHP_SESSION_NONE) {
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
        session_regenerate_id(true);
        
        $_SESSION = [
            'user_id' => $insertId,
            'user_email' => $email,
            'user_name' => $name,
            'user_role' => 'user',
            'user_authenticated' => true,
            'last_activity' => time(),
            'login_time' => time()
        ];
        
        http_response_code(201);
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful',
            'user' => [
                'id' => $insertId,
                'name' => $name,
                'email' => $email
            ]
        ]);
    } else {
        throw new Exception("Execute failed");
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error']);
    error_log("Registration error: " . $e->getMessage());
}
?>