<?php
// get_addresses.php
require_once '../../config/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $addresses = [];
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }
    
    // Map country codes to full names for display
    $countryNameMap = [
        'US' => 'United States',
        'UK' => 'United Kingdom',
        'PK' => 'Pakistan',
        'CA' => 'Canada',
        'AU' => 'Australia',
        'DE' => 'Germany',
        'FR' => 'France',
        'IT' => 'Italy',
        'JP' => 'Japan',
        'CN' => 'China',
        'BR' => 'Brazil',
        'IN' => 'India',
        'RU' => 'Russia',
        'other' => 'Other'
    ];
    
    // Format addresses by type
    $formattedAddresses = [];
    foreach ($addresses as $address) {
        $formattedAddresses[] = [
            'type' => $address['type'],
            'name' => $address['name'],
            'street' => $address['street'],
            'city' => $address['city'],
            'state' => $address['state'],
            'zip' => $address['zip'],
            'country' => $countryNameMap[$address['country']] ?? $address['country'],
            'country_code' => $address['country'] // Also return the code for forms
        ];
    }
    
    echo json_encode(['status' => 'success', 'addresses' => $formattedAddresses]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
