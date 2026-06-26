const fs = require('fs');
const path = require('path');

const pagesDir = 'd:\\xampp\\htdocs\\fashionhub\\public\\pages';

const files = [
    'order-confirmation.php',
    'contact.php',
    'checkout.php',
    'account.php',
    'about.php'
];

for (const file of files) {
    const filePath = path.join(pagesDir, file);
    if (!fs.existsSync(filePath)) continue;
    
    let content = fs.readFileSync(filePath, 'utf8');
    
    // Simple regex to match: function updateCartCount() { ... }
    // Since it's a simple function without nested braces in most cases:
    content = content.replace(/\/\/ Update cart count in header[\s\S]*?function updateCartCount\(\) \{[\s\S]*?\}\n/g, '');
    content = content.replace(/function updateCartCount\(\) \{[\s\S]*?\}\n/g, '');
    
    content = content.replace(/\/\/ Update wishlist count in header[\s\S]*?function updateWishlistCount\(\) \{[\s\S]*?\}\n/g, '');
    content = content.replace(/function updateWishlistCount\(\) \{[\s\S]*?\}\n/g, '');

    fs.writeFileSync(filePath, content, 'utf8');
    console.log('Processed', file);
}
