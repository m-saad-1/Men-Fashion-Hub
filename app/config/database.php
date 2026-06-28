<?php
// db_connection.php

$host = 'localhost';
$dbname = 'fashionhub-old';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Don't expose database details in production
    error_log("Database connection failed: " . $conn->connect_error);
    
    // Return JSON error for API requests
    if (php_sapi_name() !== 'cli') {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit();
    } else {
        die("Database connection failed: " . $conn->connect_error);
    }
}

// Set charset to utf8
$conn->set_charset("utf8");