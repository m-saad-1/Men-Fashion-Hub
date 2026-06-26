<?php
// admin_orders.php
require_once '../../config/config.php';

header("Content-Type: application/json");

// Check admin authentication
if (!isset($_SESSION['admin_authenticated']) || $_SESSION['admin_authenticated'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Admin authentication required']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // Get orders with optional filtering
            $status = $_GET['status'] ?? null;
            $search = $_GET['search'] ?? null;
            $limit = (int)($_GET['limit'] ?? 50);
            $offset = (int)($_GET['offset'] ?? 0);

            $query = "
                SELECT
                    o.id,
                    o.order_number,
                    o.order_date,
                    o.status,
                    o.total_amount,
                    o.payment_method,
                    o.payment_status,
                    u.name as customer_name,
                    u.email as customer_email,
                    COUNT(oi.id) as item_count
                FROM orders o
                JOIN users u ON o.user_id = u.id
                LEFT JOIN order_items oi ON o.id = oi.order_id
            ";

            $params = [];
            $types = "";
            $where = [];

            if ($status && $status !== 'all') {
                $where[] = "o.status = ?";
                $params[] = $status;
                $types .= "s";
            }

            if ($search) {
                $where[] = "(o.order_number LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $types .= "sss";
            }

            if (!empty($where)) {
                $query .= " WHERE " . implode(" AND ", $where);
            }

            $query .= " GROUP BY o.id ORDER BY o.order_date DESC LIMIT ? OFFSET ?";
            
            // For count query parameters
            $countParams = $params;
            $countTypes = $types;

            $params[] = $limit;
            $params[] = $offset;
            $types .= "ii";

            $stmt = $conn->prepare($query);
            if (!empty($types)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }

            // Get total count for pagination
            $countQuery = "SELECT COUNT(DISTINCT o.id) as total FROM orders o JOIN users u ON o.user_id = u.id";
            if (!empty($where)) {
                $countQuery .= " WHERE " . implode(" AND ", $where);
            }

            $countStmt = $conn->prepare($countQuery);
            if (!empty($countTypes)) {
                $countStmt->bind_param($countTypes, ...$countParams);
            }
            $countStmt->execute();
            $countResult = $countStmt->get_result();
            $total = $countResult->fetch_assoc()['total'];

            echo json_encode([
                'status' => 'success',
                'orders' => $orders,
                'total' => $total,
                'limit' => $limit,
                'offset' => $offset
            ]);
            break;

        case 'PUT':
            // Update order status
            $input = json_decode(file_get_contents('php://input'), true);
            $orderId = $input['order_id'] ?? null;
            $newStatus = $input['status'] ?? null;

            if (!$orderId || !$newStatus) {
                throw new Exception("Order ID and status are required");
            }

            $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            if (!in_array($newStatus, $validStatuses)) {
                throw new Exception("Invalid status");
            }

            $stmt = $conn->prepare("UPDATE orders SET status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bind_param("si", $newStatus, $orderId);
            $stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'Order status updated']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    }

} catch (Exception $e) {
    error_log("Admin orders error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>