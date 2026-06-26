<?php
// Test script to verify Stripe keys are loaded correctly
echo "<h1>Stripe Configuration Test</h1>";

// Load .env file
if (file_exists('.env')) {
    $envLines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
    echo "<p style='color: green;'>✅ .env file loaded successfully</p>";
} else {
    echo "<p style='color: red;'>❌ .env file not found</p>";
}

// Test environment variables
$publishableKey = getenv('STRIPE_PUBLISHABLE_KEY');
$secretKey = getenv('STRIPE_SECRET_KEY');

echo "<h2>Environment Variables:</h2>";
echo "<p><strong>STRIPE_PUBLISHABLE_KEY:</strong> " . (empty($publishableKey) ? "<span style='color: red;'>Not set</span>" : "<span style='color: green;'>Set (" . substr($publishableKey, 0, 20) . "...)</span>") . "</p>";
echo "<p><strong>STRIPE_SECRET_KEY:</strong> " . (empty($secretKey) ? "<span style='color: red;'>Not set</span>" : "<span style='color: green;'>Set (" . substr($secretKey, 0, 20) . "...)</span>") . "</p>";

// Test Stripe key format
echo "<h2>Key Format Validation:</h2>";
if (strpos($publishableKey, 'pk_test_') === 0) {
    echo "<p style='color: green;'>✅ Publishable key format is correct (starts with pk_test_)</p>";
} else {
    echo "<p style='color: red;'>❌ Publishable key format is incorrect (should start with pk_test_)</p>";
}

if (strpos($secretKey, 'sk_test_') === 0) {
    echo "<p style='color: green;'>✅ Secret key format is correct (starts with sk_test_)</p>";
} else {
    echo "<p style='color: red;'>❌ Secret key format is incorrect (should start with sk_test_)</p>";
}

// Test Stripe connection (basic)
echo "<h2>Stripe Connection Test:</h2>";
if (!empty($secretKey) && $secretKey !== 'sk_test_your_secret_key_here') {
    require_once 'server/config/stripe.js'; // This won't work in PHP, just for reference
    echo "<p style='color: blue;'>ℹ️  To test Stripe connection, you would need to use the Node.js server</p>";
} else {
    echo "<p style='color: red;'>❌ Please set your actual Stripe secret key in the .env file</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<ol>";
echo "<li>Get your Stripe keys from <a href='https://dashboard.stripe.com/apikeys' target='_blank'>Stripe Dashboard</a></li>";
echo "<li>Update the .env file with your actual keys</li>";
echo "<li>Restart your web server</li>";
echo "<li>Test the checkout page again</li>";
echo "</ol>";
?>