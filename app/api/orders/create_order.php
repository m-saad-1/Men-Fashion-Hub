<?php
// create_order.php
require_once '../../config/config.php';

header("Content-Type: application/json");

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

// Get the input data
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required_fields = ['items', 'total_amount', 'payment_method', 'shipping_address'];
foreach ($required_fields as $field) {
    if (!isset($input[$field]) || empty($input[$field])) {
        echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
        exit();
    }
}

try {
    // Begin transaction
    $conn->begin_transaction();
    
    // Generate unique order number with consistent short format
    $random_part = strtoupper(substr(uniqid(), -7));
    $order_number = 'ORD-' . date('Ymd') . '-' . $random_part;
    
    // Create order
    $stmt = $conn->prepare("
        INSERT INTO orders (user_id, order_number, order_date, total_amount, payment_method, payment_status, shipping_address, billing_address, status)
        VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?)
    ");
    
    $shipping_address_json = json_encode($input['shipping_address']);
    $billing_address_json = isset($input['billing_address']) ? json_encode($input['billing_address']) : $shipping_address_json;
    $payment_status = $input['payment_status'] ?? 'pending';
    $status = $input['status'] ?? 'pending';
    
    $stmt->bind_param("isssssss",
        $_SESSION['user_id'],
        $order_number,
        $input['total_amount'],
        $input['payment_method'],
        $payment_status,
        $shipping_address_json,
        $billing_address_json,
        $status
    );
    $stmt->execute();
    
    $order_id = $conn->insert_id;
    
    // Add order items with product validation
    $stmt = $conn->prepare("
        INSERT INTO order_items (order_id, product_id, product_name, quantity, price, size, color, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $invalidProducts = [];
    $validItems = [];
    
    // Check if products exist
    $checkStmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    foreach ($input['items'] as $item) {
        $checkStmt->bind_param("i", $item['id']);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $product = $result->fetch_assoc();
        
        if ($product) {
            $validItems[] = $item;
        } else {
            $invalidProducts[] = $item['id'];
        }
    }
    
    // If any invalid products were found
    if (!empty($invalidProducts)) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid products in order: ' . implode(', ', $invalidProducts)
        ]);
        exit();
    }
    
    // Process valid items
    foreach ($validItems as $item) {
        $size = $item['size'] ?? null;
        $color = $item['color'] ?? null;
        $image = $item['image'] ?? null;
        $stmt->bind_param("iississs",
            $order_id,
            $item['id'],
            $item['title'],
            $item['quantity'],
            $item['price'],
            $size,
            $color,
            $image
        );
        $stmt->execute();
    }
    
    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'status' => 'success', 
        'message' => 'Order created successfully',
        'order_id' => $order_id,
        'order_number' => $order_number
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    error_log("Create order error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>