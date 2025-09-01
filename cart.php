<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Your Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
:root {
    --primary-color: #2a2a2a;
    --secondary-color: #d4a762;
    --accent-color: #e53935;
    --text-color: #333;
    --light-text: #777;
    --border-color: #e0e0e0;
    --bg-light: #f9f9f9;
    --white: #fff;
    --black: #000;
    --success-color: #4caf50;
    --warning-color: #ff9800;
    --error-color: #f44336;
    --selection-color: #2196F3;
    --font-main: 'Roboto', sans-serif;
    --font-heading: 'Playfair Display', serif;
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-main);
    color: var(--text-color);
    line-height: 1.6;
    background-color: var(--bg-light);
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading);
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

h1 {
    font-size: 2.5rem;
}

h2 {
    font-size: 2rem;
}

h3 {
    font-size: 1.75rem;
}

p {
    margin-bottom: 1rem;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 500;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid transparent;
}

.btn-primary {
    background-color: var(--secondary-color);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #c49555;
}

 .btn-outline {
            background-color: transparent;
            color: var(--secondary-color);
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            border: 1px solid var(--secondary-color);
            cursor: pointer;
            transition: var(--transition);
            flex: 1;
        }

        .btn-outline:hover {
            background-color: rgba(212, 167, 98, 0.1);
            color: var(--secondary-color);
        }

.btn-text {
    background: none;
    border: none;
    color: var(--secondary-color);
    padding: 0;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-small {
    padding: 5px 10px;
    font-size: 0.9rem;
}

               /* Header Styles */
        .main-header {
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo a {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .mobile-menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            display: flex;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .search-box input {
            border: none;
            padding: 8px 12px;
            min-width: 200px;
            outline: none;
        }

        .search-box button {
            background: none;
            border: none;
            padding: 0 10px;
            cursor: pointer;
            background-color: var(--bg-light);
        }

        .user-actions {
            display: flex;
            gap: 15px;
        }

        .user-actions a {
            font-size: 1.2rem;
            color: var(--primary-color);
            position: relative;
            display: flex;
            align-items: center;
        }

        .cart-count,
        .wishlist-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--secondary-color);
            color: var(--white);
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Navigation */
.main-nav {
    border-top: 1px solid var(--border-color);
}

.main-nav ul {
    display: flex;
    list-style: none;
}

.main-nav li {
    position: relative;
}

.main-nav > ul > li > a {
    display: block;
    padding: 15px 20px;
    font-weight: 500;
    transition: var(--transition);
}

.main-nav > ul > li > a:hover {
    color: var(--secondary-color);
}

        /* Mega Menu Styles */
        .mega-menu {
            position: absolute;
            left: 0;
            width: 100vw;
            margin-left: calc(-23vw + 50%);
            background-color: var(--white);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            padding: 30px 0;
            display: none;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            border-top: 1px solid var(--border-color);
        }

        .mega-menu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .mega-menu-trigger:hover .mega-menu,
        .mega-menu-trigger:focus-within .mega-menu {
            display: block;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .mega-menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .mega-menu-col {
            min-width: 200px;
        }

        .mega-menu-col h4 {
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            color: var(--primary-color);
            white-space: nowrap;
        }

        .mega-menu-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mega-menu-col li {
            margin-bottom: 10px;
            white-space: nowrap;
        }

        .mega-menu-col a {
            display: block;
            padding: 6px 0;
            color: var(--light-text);
            transition: var(--transition);
            margin-right: 1rem;
        }

        .mega-menu-col a:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .mobile-menu-toggle {
                display: block;
            }
            
            .main-nav {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background-color: var(--white);
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            
            .main-nav.active {
                max-height: 500px;
            }
            
            .main-nav ul {
                flex-direction: column;
                padding: 15px;
            }
            
            .mega-menu {
                position: static;
                width: 100%;
                margin-left: 0;
                box-shadow: none;
                display: none;
                padding: 15px 0 0 20px;
            }
            
            .mega-menu-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        /* Cart Page Styles */
        .cart-page {
            padding: 60px 0;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-family: var(--font-heading);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .breadcrumbs {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .breadcrumbs a {
            color: var(--light-text);
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            color: var(--secondary-color);
        }

        .cart-content {
            display: flex;
            gap: 30px;
        }

        .cart-items {
            flex: 1;
        }

        .cart-header {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            font-weight: 500;
        }

        .cart-row {
            display: flex;
            padding: 20px 0;
            border-bottom: 1px solid var(--border-color);
            align-items: center;
        }

        .header-item,
        .cart-item {
            padding: 0 10px;
        }

        .header-item.product,
        .cart-item.product {
            width: 40%;
            display: flex;
            align-items: center;
        }

        .header-item.price,
        .cart-item.price {
            width: 15%;
            text-align: center;
        }

        .header-item.quantity,
        .cart-item.quantity {
            width: 20%;
            text-align: center;
        }

        .header-item.subtotal,
        .cart-item.subtotal {
            width: 15%;
            text-align: center;
            font-weight: 500;
        }

        .header-item.remove,
        .cart-item.remove {
            width: 10%;
            text-align: center;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-details {
            padding-left: 15px;
        }

        .product-title {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .product-variant {
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .remove-btn {
            background: none;
            border: none;
            color: var(--light-text);
            cursor: pointer;
            font-size: 1.1rem;
        }

        .remove-btn:hover {
            color: var(--accent-color);
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-light);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            padding: 5px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-outline {
            background-color: transparent;
            color: var(--secondary-color);
            border: 1px solid var(--secondary-color);
        }

        .btn-outline:hover {
            background-color: rgba(212, 167, 98, 0.1);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: #c49555;
        }

        .coupon-box {
            display: flex;
            width: 400px;
        }

        .coupon-box input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .coupon-box button {
            border-radius: 0 4px 4px 0;
        }

        .update-cart {
            margin-left: auto;
        }

        .cart-summary {
            width: 350px;
            background-color: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            align-self: flex-start;
            position: sticky;
            top: 100px;
        }

        .cart-summary h3 {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .summary-table {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .summary-label {
            color: var(--light-text);
        }

        .summary-value {
            font-weight: 500;
        }

        .shipping-options {
            margin-top: 10px;
            padding-left: 5px;
        }

        .shipping-option {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .shipping-option input {
            margin-right: 10px;
        }

        .total {
            font-size: 1.2rem;
            color: var(--secondary-color);
        }

        .proceed-checkout {
            margin-bottom: 20px;
            width: 100%;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .payment-methods img {
            height: 25px;
            width: auto;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 0;
        }

        .empty-cart i {
            font-size: 5rem;
            color: var(--border-color);
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            margin-bottom: 15px;
            font-family: var(--font-heading);
        }

        .empty-cart p {
            margin-bottom: 30px;
            color: var(--light-text);
        }

        .payment-methods {
            display: flex;
            align-items: center;
            gap: 15px;
            size: 1.2rem;
            font-size: 1.8rem;
        }

        /* Selection Controls */
        .selection-controls {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px; 
        }

        .select-all-toggle {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .select-all-toggle input {
            margin-right: 10px;
        }

        .item-select {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        .item-select input {
            margin-right: 10px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .cart-content {
                flex-direction: column;
            }
            
            .cart-summary {
                width: 100%;
                position: static;
            }
        }

        @media (max-width: 768px) {
            .cart-header {
                display: none;
            }
            
            .cart-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                position: relative;
                padding: 20px 0;
            }
            
            .cart-item {
                width: 100% !important;
                text-align: left !important;
                padding: 0;
            }
            
            .cart-item.remove {
                position: absolute;
                top: 20px;
                right: 0;
            }
            
            .cart-actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .coupon-box {
                width: 100%;
            }
            
            .update-cart {
                margin-left: 0;
                width: 100%;
            }

            .selection-controls {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        @media (max-width: 576px) {
            .header-top {
                flex-direction: column;
                gap: 15px;
            }
            
            .header-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .search-box input {
                width: 150px;
            }
            
            .main-nav ul {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
        }
        /* Pulse animation for cart and wishlist counts */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .cart-count.pulse,
        .wishlist-count.pulse {
            animation: pulse 0.5s ease;
        }

        /* Auth Alert */
        .auth-alert {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .auth-alert.show {
            opacity: 1;
            visibility: visible;
        }

        .auth-alert-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .auth-alert-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        /* Cart Notification */
        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .cart-notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .cart-notification a {
            color: white;
            text-decoration: underline;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
<?php include 'header.html'; ?>

    <main class="cart-page">
        <div class="container">
            <div class="page-header">
                <h1>Your Shopping Cart</h1>
                <div class="breadcrumbs">
                    <a href="index.html">Home</a> / <span>Cart</span>
                </div>
            </div>
            
            <div class="cart-content">
                <div class="cart-items">
                    <!-- Selection Controls -->
                    <div class="selection-controls">
                        <div class="select-all-toggle">
                            <input type="checkbox" id="selectAll" checked>
                            <label for="selectAll">Select all items</label>
                        </div>
                    </div>
                    
                    <div id="cartItemsContainer">
                        <!-- Cart items will be loaded via JavaScript -->
                    </div>
                </div>
                
                <div class="cart-summary">
                    <h3>Cart Totals</h3>
                    <div class="summary-table">
                        <div class="summary-row">
                            <div class="summary-label">Subtotal</div>
                            <div class="summary-value" id="cartSubtotal">$0.00</div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Shipping</div>
                            <div class="summary-value">
                                <div class="shipping-options">
                                    <div class="shipping-option">
                                        <input type="radio" id="free-shipping" name="shipping" checked>
                                        <label for="free-shipping">Free Shipping</label>
                                    </div>
                                    <div class="shipping-option">
                                        <input type="radio" id="express-shipping" name="shipping">
                                        <label for="express-shipping">Express Shipping: $9.99</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="summary-row">
                            <div class="summary-label">Total</div>
                            <div class="summary-value total" id="cartTotal">$0.00</div>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary btn-block proceed-checkout" id="proceedCheckout">Proceed to Checkout</button>
                    
                 <div class="payment-methods">
    <i class="fab fa-cc-visa" title="Visa"></i>
    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
    <i class="fab fa-cc-paypal" title="PayPal"></i>
    <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
<?php include 'footer.html'; ?>

  <script>
document.addEventListener('DOMContentLoaded', function() {
    // API Configuration
    const API_BASE = window.location.origin + '/fashionhub-old/api';
    
    // Auth check
    const auth = {
        currentUser: JSON.parse(localStorage.getItem('currentUser')) || null
    };
    
    // Load cart from database if user is logged in, otherwise from localStorage
    let cart = [];
    let selectedItems = [];

    // Initialize cart
    initializeCart().then(() => {
        updateCartDisplay();
        updateWishlistCount();
    });
    
    // Initialize cart from database or localStorage
    async function initializeCart() {
        if (auth.currentUser) {
            // Try to load from database first
            try {
                const response = await fetch(`${API_BASE}/get_cart.php`, {
                    credentials: 'include'
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    // Convert database cart items to match localStorage format
                    cart = data.cart.map(item => ({
                        id: item.product_id,
                        title: item.title,
                        price: parseFloat(item.price), // Convert string to number
                        image: item.image,
                        size: item.size,
                        color: item.color,
                        quantity: parseInt(item.quantity) // Ensure quantity is a number
                    }));
                    // Update localStorage for consistency
                    localStorage.setItem('cart', JSON.stringify(cart));
                } else {
                    // Fallback to localStorage if database fails
                    cart = JSON.parse(localStorage.getItem('cart')) || [];
                }
            } catch (error) {
                console.error('Error loading cart from database:', error);
                // Fallback to localStorage if API call fails
                cart = JSON.parse(localStorage.getItem('cart')) || [];
            }
        } else {
            // User not logged in, use localStorage only
            cart = JSON.parse(localStorage.getItem('cart')) || [];
        }
        
        // Initialize selected items (all selected by default)
        selectedItems = cart.map(item => item.id);
    }
    
    // Update wishlist count in header
    function updateWishlistCount() {
        let wishlistCount = 0;
        
        if (auth.currentUser && auth.currentUser.wishlist) {
            wishlistCount = auth.currentUser.wishlist.length;
        }
        
        const wishlistCountElement = document.querySelector('.wishlist-count');
        if (wishlistCountElement) {
            wishlistCountElement.textContent = wishlistCount;
        }
    }
    
    // Update cart count in header
    function updateCartCount() {
        const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = cartCount;
        }
    }
    
    // Update cart display
    function updateCartDisplay() {
        const cartItemsContainer = document.getElementById('cartItemsContainer');
        const cartSubtotal = document.getElementById('cartSubtotal');
        const cartTotal = document.getElementById('cartTotal');
        const selectAllCheckbox = document.getElementById('selectAll');
        
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added anything to your cart yet</p>
                    <a href="shop.html" class="btn btn-primary">Continue Shopping</a>
                </div>
            `;
            cartSubtotal.textContent = '$0.00';
            cartTotal.textContent = '$0.00';
            document.getElementById('proceedCheckout').style.display = 'none';
            document.querySelector('.selection-controls').style.display = 'none';
        } else {
            document.querySelector('.selection-controls').style.display = 'flex';
            
            // Calculate subtotal for selected items only
            const subtotal = cart.reduce((sum, item) => {
                if (selectedItems.includes(item.id)) {
                    const price = typeof item.price === 'number' ? item.price : parseFloat(item.price);
                    const quantity = typeof item.quantity === 'number' ? item.quantity : parseInt(item.quantity);
                    return sum + (price * quantity);
                }
                return sum;
            }, 0);
            
            // Calculate shipping
            const shippingOption = document.querySelector('input[name="shipping"]:checked');
            const shippingCost = shippingOption ? (shippingOption.id === 'express-shipping' ? 9.99 : 0) : 0;
            
            // Calculate total
            const total = subtotal + shippingCost;
            
            // Update totals display
            cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
            cartTotal.textContent = `$${total.toFixed(2)}`;
            
            // Update select all checkbox
            selectAllCheckbox.checked = selectedItems.length === cart.length && cart.length > 0;
            
            // Render cart items
            cartItemsContainer.innerHTML = `
                <div class="cart-header">
                    <div class="header-item product">Product</div>
                    <div class="header-item price">Price</div>
                    <div class="header-item quantity">Quantity</div>
                    <div class="header-item subtotal">Subtotal</div>
                    <div class="header-item remove">Remove</div>
                </div>
            `;
            
            cart.forEach((item, index) => {
                // Ensure price and quantity are numbers
                const price = typeof item.price === 'number' ? item.price : parseFloat(item.price);
                const quantity = typeof item.quantity === 'number' ? item.quantity : parseInt(item.quantity);
                const subtotal = price * quantity;
                const isSelected = selectedItems.includes(item.id);
                
                const cartRow = document.createElement('div');
                cartRow.className = 'cart-row';
                cartRow.dataset.id = item.id;
                cartRow.innerHTML = `
                    <div class="cart-item product">
                        <div class="item-select">
                            <input type="checkbox" id="item-${index}" ${isSelected ? 'checked' : ''} data-index="${index}">
                        </div>
                        <div class="product-image">
                            <img src="${item.image}" alt="${item.title}">
                        </div>
                        <div class="product-details">
                            <a href="shop.html?product=${item.id}" class="product-title">${item.title}</a>
                            ${item.size ? `<div class="product-variant">Size: ${item.size}</div>` : ''}
                            ${item.color ? `<div class="product-variant">Color: <span class="color-display" style="display: inline-block; width: 15px; height: 15px; background-color: ${getColorCode(item.color)}; border-radius: 50%; margin-left: 5px; vertical-align: middle;"></span> ${item.color}</div>` : ''}
                        </div>
                    </div>
                    <div class="cart-item price">$${price.toFixed(2)}</div>
                    <div class="cart-item quantity">
                        <div class="quantity-selector">
                            <button class="quantity-btn decrease" data-index="${index}">-</button>
                            <input type="number" min="1" value="${quantity}" class="quantity-input" data-index="${index}">
                            <button class="quantity-btn increase" data-index="${index}">+</button>
                        </div>
                    </div>
                    <div class="cart-item subtotal">$${subtotal.toFixed(2)}</div>
                    <div class="cart-item remove">
                        <button class="remove-btn" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(cartRow);
            });

            // Add cart actions
            const cartActions = document.createElement('div');
            cartActions.className = 'cart-actions';
            cartActions.innerHTML = `
                <div class="coupon-box">
                    <input type="text" placeholder="Coupon code">
                    <button class="btn btn-outline">Apply Coupon</button>
                </div>
                <button class="btn btn-primary update-cart" id="updateCart">Update Cart</button>
            `;
            cartItemsContainer.appendChild(cartActions);
            
            // Show checkout button
            document.getElementById('proceedCheckout').style.display = 'block';
        }
        
        updateCartCount();
    }
    
    // Helper function to get color codes
    function getColorCode(colorName) {
        const colorMap = {
            'red': '#ff0000',
            'blue': '#0000ff',
            'green': '#008000',
            'black': '#000000',
            'white': '#ffffff',
            'beige': '#d4a762',
            'navy': '#001f3f',
            'gray': '#aaaaaa',
            'burgundy': '#800020',
            'ivory': '#fffff0',
            'sage': '#b2ac88',
            'brown': '#964B00'
        };
        return colorMap[colorName.toLowerCase()] || '#cccccc';
    }
    
    // Handle quantity changes
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('decrease')) {
            const index = e.target.dataset.index;
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                updateCartInStorage();
                updateCartDisplay();
            }
        }
        
        if (e.target.classList.contains('increase')) {
            const index = e.target.dataset.index;
            cart[index].quantity++;
            updateCartInStorage();
            updateCartDisplay();
        }
        
        if (e.target.classList.contains('remove-btn') || e.target.closest('.remove-btn')) {
            const index = e.target.closest('.remove-btn') ? e.target.closest('.remove-btn').dataset.index : e.target.dataset.index;
            const itemId = cart[index].id;
            
            // Remove from selected items if present
            selectedItems = selectedItems.filter(id => id !== itemId);
            
            cart.splice(index, 1);
            updateCartInStorage();
            updateCartDisplay();
        }
    });

    // Handle quantity input changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const index = e.target.dataset.index;
            const newQuantity = parseInt(e.target.value);
            if (newQuantity > 0) {
                cart[index].quantity = newQuantity;
                updateCartInStorage();
                updateCartDisplay();
            } else {
                e.target.value = cart[index].quantity;
            }
        }
    });
    
    // Handle item selection
    document.addEventListener('change', function(e) {
        if (e.target.matches('.item-select input[type="checkbox"]')) {
            const index = e.target.dataset.index;
            const itemId = cart[index].id;
            
            if (e.target.checked) {
                // Add to selected items if not already present
                if (!selectedItems.includes(itemId)) {
                    selectedItems.push(itemId);
                }
            } else {
                // Remove from selected items
                selectedItems = selectedItems.filter(id => id !== itemId);
            }
            
            updateCartDisplay();
        }
        
        // Handle select all toggle
        if (e.target.id === 'selectAll') {
            if (e.target.checked) {
                // Select all items
                selectedItems = cart.map(item => item.id);
            } else {
                // Deselect all items
                selectedItems = [];
            }
            
            updateCartDisplay();
        }
    });
    
    // Update cart in database or localStorage
    async function updateCartInStorage() {
        // Always update localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
        
        // If user is logged in, update database too
        if (auth.currentUser) {
            try {
                const response = await fetch(`${API_BASE}/update_cart.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        cart: cart
                    })
                });
                
                const data = await response.json();
                
                if (data.status !== 'success') {
                    console.error('Error updating cart in database:', data.message);
                }
            } catch (error) {
                console.error('Error updating cart in database:', error);
            }
        }
    }
    
    // Update cart button
    document.addEventListener('click', function(e) {
        if (e.target.id === 'updateCart') {
            updateCartInStorage();
            updateCartDisplay();
            showCartNotification({ title: 'Cart updated successfully!' });
        }
    });
    
    // Shipping option changes
    document.querySelectorAll('input[name="shipping"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateCartDisplay();
        });
    });
    
   // Proceed to checkout
    const proceedCheckout = document.getElementById('proceedCheckout');
    if (proceedCheckout) {
        proceedCheckout.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (cart.length === 0) {
                showCartNotification({ title: 'Your cart is empty!' });
                return;
            }
            
            // Calculate total including shipping for selected items only
            const subtotal = cart.reduce((sum, item) => {
                if (selectedItems.includes(item.id)) {
                    const price = typeof item.price === 'number' ? item.price : parseFloat(item.price);
                    const quantity = typeof item.quantity === 'number' ? item.quantity : parseInt(item.quantity);
                    return sum + (price * quantity);
                }
                return sum;
            }, 0);
            
            const shippingOption = document.querySelector('input[name="shipping"]:checked');
            const shippingCost = shippingOption && shippingOption.id === 'express-shipping' ? 9.99 : 0;
            const total = subtotal + shippingCost;
            
            // Save the total to localStorage
            localStorage.setItem('cartTotal', total.toFixed(2));
            
            // Save selected items to localStorage for checkout page
            localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
            
            // Redirect to checkout page
            window.location.href = 'checkout.php';
        });
    }
    
    // Show cart notification
    function showCartNotification(product) {
        const notification = document.createElement('div');
        notification.className = 'cart-notification';
        notification.innerHTML = `
            <p>${product.title}</p>
            ${product.title === 'Cart updated successfully!' || product.title === 'Your cart is empty!' ? '' : '<a href="cart.html">View Cart</a>'}
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Listen for login events from the login page
    window.addEventListener('userLogin', async function(e) {
        // Update auth state with the user data from the login event
        auth.currentUser = e.detail;
        
        // Load cart items for the newly logged in user
        await initializeCart();
        
        // Update UI
        updateCartDisplay();
        updateWishlistCount();
    });
    
    // Listen for logout events
    window.addEventListener('userLogout', function() {
        auth.currentUser = null;
        cart = [];
        selectedItems = [];
        localStorage.removeItem('cart');
        localStorage.removeItem('currentUser');
        localStorage.removeItem('selectedItems');
        updateCartDisplay();
        updateWishlistCount();
    });
    
    // Listen for storage events to update counts when data changes in other tabs
    window.addEventListener('storage', function(e) {
        if (e.key === 'cart') {
            cart = JSON.parse(e.newValue) || [];
            updateCartDisplay();
        }
        if (e.key === 'currentUser') {
            auth.currentUser = JSON.parse(e.newValue);
            updateWishlistCount();
        }
    });
});
</script>
</body>
</html>