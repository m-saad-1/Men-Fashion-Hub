<?php
require_once '../../config/config.php';

try {
    $result = $conn->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != '' ORDER BY category");
    if (!$result) throw new Exception($conn->error);
    
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $categories = [
        'all' => []
    ];
    
    foreach ($rows as $row) {
        $cat = ucfirst($row['category']);
        $categories['all'][] = $cat;
    }
    
    echo json_encode(['status' => 'success', 'categories' => $categories]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
