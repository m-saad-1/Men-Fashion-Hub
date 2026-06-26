<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    $search = isset($_GET['search']) ? $conn->real_escape_string(trim($_GET['search'])) : '';
    $category = isset($_GET['category']) ? $conn->real_escape_string(trim($_GET['category'])) : '';
    $type = isset($_GET['type']) ? $conn->real_escape_string(trim($_GET['type'])) : '';
    $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 5000;
    $sort = isset($_GET['sort']) ? $conn->real_escape_string(trim($_GET['sort'])) : 'featured';
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? min(24, max(1, (int)$_GET['limit'])) : 12;
    $offset = ($page - 1) * $limit;

    $query = "SELECT * FROM products WHERE price >= $min_price AND price <= $max_price";
    
    if ($search !== '') {
        $query .= " AND (title LIKE '%$search%' OR category LIKE '%$search%' OR description LIKE '%$search%')";
    }
    
    if ($category !== '' && $category !== 'all') {
        if ($category === 'sale') {
            $query .= " AND old_price IS NOT NULL AND old_price > price";
        } elseif ($category === 'new-arrivals' || $category === 'trending') {
            $query .= " AND new_arrival = 1";
        } elseif ($category === 'best-sellers') {
            $query .= " AND reviews > 100";
        } elseif ($category === 'featured') {
            $query .= " AND featured = 1";
        } else {
            $query .= " AND category = '$category'";
        }
    }
    
    // Product type filter (division column)
    if ($type !== '' && $type !== 'all') {
        switch (strtolower($type)) {
            case 'tops':
                $query .= " AND division = 'top'";
                break;
            case 'bottoms':
                $query .= " AND division = 'bottom'";
                break;
            case 'footwear':
                $query .= " AND division = 'footwear'";
                break;
            case 'accessories':
                $query .= " AND division = 'accessory'";
                break;
        }
    }

    // First get total count
    $countQuery = preg_replace('/SELECT \*/', 'SELECT COUNT(*) as total', $query, 1);
    $countResult = $conn->query($countQuery);
    $totalCount = $countResult ? $countResult->fetch_assoc()['total'] : 0;

    // Add ordering and pagination
    $orderClause = "ORDER BY featured DESC, id DESC";
    if ($sort === 'newest') {
        $orderClause = "ORDER BY id DESC";
    } else if ($sort === 'price-low') {
        $orderClause = "ORDER BY price ASC";
    } else if ($sort === 'price-high') {
        $orderClause = "ORDER BY price DESC";
    } else if ($sort === 'rating') {
        $orderClause = "ORDER BY rating DESC, reviews DESC";
    }
    $query .= " $orderClause LIMIT $limit OFFSET $offset";
    
    $result = $conn->query($query);
    if (!$result) throw new Exception($conn->error);
    $products = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach ($products as &$product) {
        $product['colors'] = json_decode($product['colors'], true) ?: [];
        $product['sizes'] = json_decode($product['sizes'], true) ?: [];
        $product['features'] = json_decode($product['features'], true) ?: [];
        $product['color_codes'] = json_decode($product['color_codes'], true) ?: [];
        $product['oldPrice'] = $product['old_price'] ? (float)$product['old_price'] : null;
        unset($product['old_price']);
        $product['newArrival'] = (bool)$product['new_arrival'];
        unset($product['new_arrival']);
        $product['price'] = (float)$product['price'];
        $product['rating'] = (float)$product['rating'];
        $product['reviews'] = (int)$product['reviews'];
        $product['featured'] = (bool)$product['featured'];
    }
    
    echo json_encode([
        'status' => 'success', 
        'products' => $products, 
        'total' => (int)$totalCount, 
        'page' => $page,
        'hasMore' => ($offset + count($products)) < $totalCount
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>