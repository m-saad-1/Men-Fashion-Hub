<?php
/**
 * Test Admin Login Setup
 *
 * This script tests if the admin user exists and can be authenticated.
 */

require_once 'api/db_connection.php';

// Remove the JSON header that was set in db_connection.php for CLI usage
if (php_sapi_name() === 'cli') {
    header_remove('Content-Type');
}

echo "Testing Admin Login Setup\n";
echo "=========================\n\n";

try {
    // Test 1: Check if role column exists
    echo "Test 1: Checking if role column exists...\n";
    $stmt = $conn->prepare("DESCRIBE users");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $roleColumnExists = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'role') {
            $roleColumnExists = true;
            break;
        }
    }

    if ($roleColumnExists) {
        echo "✓ Role column exists in users table\n";
    } else {
        echo "✗ Role column does not exist in users table\n";
    }

    // Test 2: Check if admin user exists
    echo "\nTest 2: Checking if admin user exists...\n";
    $stmt = $conn->prepare("SELECT id, name, email, role FROM users WHERE email = ?");
    $stmt->execute(['admin@fashionhub.com']);
    $adminUser = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($adminUser) {
        echo "✓ Admin user found:\n";
        echo "  - ID: " . $adminUser['id'] . "\n";
        echo "  - Name: " . $adminUser['name'] . "\n";
        echo "  - Email: " . $adminUser['email'] . "\n";
        echo "  - Role: " . $adminUser['role'] . "\n";
    } else {
        echo "✗ Admin user not found\n";
    }

    // Test 3: Test password verification
    if ($adminUser) {
        echo "\nTest 3: Testing password verification...\n";
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->execute(['admin@fashionhub.com']);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify('admin123', $user['password'])) {
            echo "✓ Password verification successful\n";
        } else {
            echo "✗ Password verification failed\n";
        }
    }

    echo "\nTest completed!\n";
    echo "===============\n";

    if ($roleColumnExists && $adminUser && password_verify('admin123', $user['password'])) {
        echo "✓ All tests passed! Admin login should work.\n";
        echo "\nAdmin Credentials:\n";
        echo "- Email: admin@fashionhub.com\n";
        echo "- Password: admin123\n";
    } else {
        echo "✗ Some tests failed. Please check the setup.\n";
    }

} catch (Exception $e) {
    echo "Test failed: " . $e->getMessage() . "\n";
    exit(1);
}
?>