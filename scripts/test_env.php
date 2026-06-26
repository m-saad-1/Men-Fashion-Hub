<?php
// test_env.php - Test if environment variables are loading correctly
require_once '../../app/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Environment Variables Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Environment Variables Test</h1>

    <h2>Stripe Configuration</h2>
    <pre>
STRIPE_PUBLISHABLE_KEY: <?php
$pub_key = $_ENV['STRIPE_PUBLISHABLE_KEY'] ?? 'NOT SET';
if ($pub_key === 'pk_test_your_actual_publishable_key_here') {
    echo '<span class="warning">PLACEHOLDER VALUE - Replace with actual key</span>';
} elseif (strpos($pub_key, 'pk_test_') === 0) {
    echo '<span class="success">VALID TEST KEY</span>';
} else {
    echo '<span class="error">INVALID KEY FORMAT</span>';
}
?>

STRIPE_SECRET_KEY: <?php
$sec_key = $_ENV['STRIPE_SECRET_KEY'] ?? 'NOT SET';
if ($sec_key === 'sk_test_your_actual_secret_key_here') {
    echo '<span class="warning">PLACEHOLDER VALUE - Replace with actual key</span>';
} elseif (strpos($sec_key, 'sk_test_') === 0) {
    echo '<span class="success">VALID TEST KEY</span>';
} else {
    echo '<span class="error">INVALID KEY FORMAT</span>';
}
?>
    </pre>

    <h2>Raw Environment Variables</h2>
    <pre><?php
    $stripe_vars = array_filter($_ENV, function($key) {
        return strpos($key, 'STRIPE') === 0;
    }, ARRAY_FILTER_USE_KEY);

    if (empty($stripe_vars)) {
        echo '<span class="error">No Stripe environment variables found!</span>';
    } else {
        foreach ($stripe_vars as $key => $value) {
            echo "$key = $value\n";
        }
    }
    ?></pre>

    <h2>Next Steps</h2>
    <ol>
        <li>If you see "PLACEHOLDER VALUE", update your <code>.env</code> file with actual Stripe keys</li>
        <li>If you see "NOT SET", check that your <code>.env</code> file exists and is in the project root</li>
        <li>If you see "VALID TEST KEY", your environment variables are working correctly</li>
        <li>Restart your web server after updating the <code>.env</code> file</li>
    </ol>

    <p><a href="checkout.php">← Back to Checkout</a></p>
</body>
</html>