<?php
session_start();
include 'db_connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

// Check if address already exists for this type
$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ? AND type = ?");
$stmt->execute([$_SESSION['user_id'], $data['type']]);
$existing = $stmt->fetch();

if ($existing) {
    // Update existing address
    $stmt = $conn->prepare("UPDATE addresses SET name = ?, street = ?, city = ?, state = ?, zip = ?, country = ? WHERE user_id = ? AND type = ?");
    $stmt->execute([
        $data['name'],
        $data['street'],
        $data['city'],
        $data['state'],
        $data['zip'],
        $data['country'],
        $_SESSION['user_id'],
        $data['type']
    ]);
} else {
    // Insert new address
    $stmt = $conn->prepare("INSERT INTO addresses (user_id, type, name, street, city, state, zip, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'],
        $data['type'],
        $data['name'],
        $data['street'],
        $data['city'],
        $data['state'],
        $data['zip'],
        $data['country']
    ]);
}

echo json_encode(['status' => 'success']);
?>