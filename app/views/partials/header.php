<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="../assets/images/favicon.png" type="image/png">
    <script src="../../public/assets/js/auth.js"></script>
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
    border-color: var(--secondary-color);
    color: var(--secondary-color);
}

.btn-outline:hover {
    background-color: var(--secondary-color);
    color: var(--white);
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

.header-inner {
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

.main-nav {
    position: static !important;
}

.main-nav li {
    position: relative;
}

.main-nav li.mega-menu-trigger {
    position: static;
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
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    width: 100vw;
    margin-top: 0;
    background-color: var(--white);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 30px 0;
    display: none;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    border-top: 1px solid var(--border-color);
}

/* Show mega menu when explicitly opened (works on all viewports) */
.mega-menu.open {
    display: block;
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

/* Hover for desktop */
@media (min-width: 993px) {
    .mega-menu-trigger:hover .mega-menu,
    .mega-menu-link:hover + .mega-menu {
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
}

.mega-menu-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 30px;
}

.mega-menu-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px
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
        max-height: 90vh;     /* max height relative to viewport */
        overflow-y: auto;     /* vertical scrolling */
        -webkit-overflow-scrolling: touch; /* smooth scrolling on iOS */
    }

    .main-nav ul {
        flex-direction: column;
        padding: 15px;
    }
    
    .mega-menu {
        position: static;
        width: 100%;
        max-height: 400px;
        margin-left: 0;
        box-shadow: none;
        display: none;
        overflow-y: auto;
        padding: 15px 0 0 20px;
        -webkit-overflow-scrolling: touch;
    }

    .mega-menu.open {
        display: block;
        opacity: 1;
        visibility: visible;
    }
    
    /* Changed grid layout for categories in hamburger menu */
    .mega-menu-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

.mega-menu-col {
    padding: 8px 0;
    border-bottom: 1px solid var(--border-color);
}

.mega-menu-col:last-child {
    border-bottom: none;
}

.mega-menu-col h4 {
    margin-bottom: 6px;
}

.mega-menu-col ul {
    padding-left: 12px;
}

.mega-menu-col li {
    margin-bottom: 8px;
}

@media (max-width: 768px) {
    .search-box {
        display: none;
    }
}

/* Footer */
.main-footer {
    background-color: var(--primary-color);
    color: var(--white);
    padding: 60px 0 0;
}

.footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.footer-col.newsletter {
    max-width: 400px;
    margin: 40px auto 0;
    text-align: center;
}

.footer-col h3 {
    color: var(--white);
    margin-bottom: 20px;
    font-size: 1.2rem;
}

.footer-col ul {
    list-style: none;
}

.footer-col li {
    margin-bottom: 10px;
}

.footer-col a {
    color: #ccc;
    transition: var(--transition);
}

.footer-col a:hover {
    color: var(--secondary-color);
}

.newsletter-form {
    display: flex;
    margin-top: 15px;
}

.newsletter-form input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 4px 0 0 4px;
    outline: none;
}

.newsletter-form button {
    background-color: var(--secondary-color);
    color: var(--white);
    border: none;
    padding: 0 15px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    justify-content: center;
    margin-bottom: 20px;
}

.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: var(--white);
    transition: var(--transition);
}

.social-links a:hover {
    background-color: var(--secondary-color);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.payment-methods {
    display: flex;
    gap: 10px;
}

.payment-methods i {
    font-size: 1.8rem;
}
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../components/hourglass_loader.php'; ?>
    <header class="main-header">
        <div class="container">
            <div class="header-inner" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
                

                <div class="logo">
                    <a href="index.php" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <img src="../assets/images/favicon.png" alt="FashionHub Logo" style="width: 28px; height: 28px; object-fit: contain;">
                        FashionHub
                    </a>
                </div>
                <div class="nav-container" style="flex: 1; display: flex; justify-content: center;">
                    
                    <div class="mobile-menu-toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                    <nav class="main-nav" style="border: none;">
                        <ul style="margin: 0; padding: 0; display: flex; list-style: none;">
                            <li><a href="index.php" style="font-weight: 400; font-size: 14px;">Home</a></li>
                            <li><a href="shop.php" style="font-weight: 400; font-size: 14px;">Shop</a></li>
                            <li class="mega-menu-trigger">
                                <a href="#" class="mega-menu-link" style="font-weight: 400; font-size: 14px;">Categories <i class="fas fa-chevron-down"></i></a>
                                <div class="mega-menu" id="global-mega-menu">
                                    <div class="mega-menu-container" style="max-width: 1200px; margin: 0 auto; padding: 0 30px;">
                                        <div class="mega-menu-grid" id="dynamic-categories-container" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; width: 100%;">
                                            <div class="mega-menu-col">
                                                <h4 style="margin-bottom: 10px; font-size: 1.2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 5px; text-align: center;">Men</h4>
                                                <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.95rem; justify-content: center;">
                                                    <a href="shop.php?category=shirts">Shirts</a>
                                                    <a href="shop.php?category=t-shirts">T-Shirts</a>
                                                    <a href="shop.php?category=jeans">Jeans</a>
                                                    <a href="shop.php?category=pants">Pants</a>
                                                    <a href="shop.php?category=hoodies">Hoodies</a>
                                                    <a href="shop.php?category=jackets">Jackets</a>
                                                    <a href="shop.php?category=footwear">Footwear</a>
                                                </div>
                                            </div>
                                            <div class="mega-menu-col">
                                                <h4 style="margin-bottom: 10px; font-size: 1.2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 5px; text-align: center;">Women</h4>
                                                <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.95rem; justify-content: center;">
                                                    <a href="shop.php?category=dresses">Dresses</a>
                                                    <a href="shop.php?category=skirts">Skirts</a>
                                                    <a href="shop.php?category=tops">Tops</a>
                                                    <a href="shop.php?category=jeans">Jeans</a>
                                                    <a href="shop.php?category=pants">Pants</a>
                                                    <a href="shop.php?category=jackets">Jackets</a>
                                                    <a href="shop.php?category=footwear">Footwear</a>
                                                </div>
                                            </div>
                                            <div class="mega-menu-col">
                                                <h4 style="margin-bottom: 10px; font-size: 1.2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 5px; text-align: center;">Accessories</h4>
                                                <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.95rem; justify-content: center;">
                                                    <a href="shop.php?category=bags">Bags</a>
                                                    <a href="shop.php?category=watches">Watches</a>
                                                    <a href="shop.php?category=belts">Belts</a>
                                                    <a href="shop.php?category=sunglasses">Sunglasses</a>
                                                </div>
                                            </div>
                                            <div class="mega-menu-col">
                                                <h4 style="margin-bottom: 10px; font-size: 1.2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 5px; text-align: center;">Featured</h4>
                                                <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.95rem; justify-content: center;">
                                                    <a href="shop.php?category=new-arrivals">New Arrivals</a>
                                                    <a href="shop.php?category=trending">Trending</a>
                                                    <a href="shop.php?category=sale">Sale</a>
                                                    <a href="shop.php?category=best-sellers">Best Sellers</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li><a href="about.php" style="font-weight: 400; font-size: 14px;">About</a></li>
                            <li><a href="contact.php" style="font-weight: 400; font-size: 14px;">Contact</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="header-actions">
                    <form class="search-box" action="shop.php" method="GET">
                        <input type="text" name="search" placeholder="Search products...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="user-actions">
                        <a href="account.php"><i class="far fa-user"></i></a>
                        <a href="account.php#wishlist" class="wishlist-icon auth-required-counter">
                            <i class="far fa-heart"></i>
                            <span class="wishlist-count">0</span>
                        </a>
                        <a href="cart.php" class="cart-icon auth-required-counter">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

                            
    </header>

    <script src="../../public/assets/js/header.js"></script>
</body>
</html>