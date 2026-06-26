<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Shop Our Collection</title>
        <link rel="stylesheet" href="../assets/css/header-footer.css">
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

        /* Shop Page Specific Styles */
        .shop-page {
            padding: 60px 0;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .breadcrumbs {
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .breadcrumbs a {
            color: var(--light-text);
        }

        .breadcrumbs a:hover {
            color: var(--secondary-color);
        }

        .shop-content {
            display: flex;
            gap: 30px;
        }

        /* Filters Sidebar */
        .shop-filters {
            width: 250px;
            flex-shrink: 0;
            position: sticky;
            top: 100px;
            align-self: flex-start;
            max-height: calc(100vh - 120px);
            overflow-y: auto;
        }
        
        .price-slider-container {
            padding: 10px 0;
        }
        .price-slider-container input[type=range] {
            width: 100%;
            cursor: pointer;
        }
        .price-values {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .filter-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-section h3 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .filter-list {
            list-style: none;
        }

        .filter-list li {
            margin-bottom: 8px;
        }

        .filter-list a {
            display: block;
            padding: 5px 0;
            color: var(--light-text);
            transition: var(--transition);
        }

        .filter-list a:hover,
        .filter-list a.active {
            color: var(--secondary-color);
            font-weight: 500;
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

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: #c49555;
        }

        .btn-text {
            background: none;
            border: none;
            color: var(--secondary-color);
            padding: 0;
        }

        /* Product Listing */
        .product-listing {
            flex: 1;
        }

        .listing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .sort-options {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-options select {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--white);
            outline: none;
            font-family: inherit;
        }

        .view-options {
            display: flex;
            gap: 10px;
        }

        .view-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            cursor: pointer;
            color: var(--light-text);
        }

        .view-btn.active {
            background-color: var(--secondary-color);
            color: var(--white);
            border-color: var(--secondary-color);
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .product-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
            position: relative;
            cursor: pointer;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: var(--accent-color);
            color: var(--white);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .product-image {
            position: relative;
            overflow: hidden;
            height: 250px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 15px;
        }

        .product-title {
            font-size: 1rem;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 4px;
            margin: 5px 0;
            flex-wrap: nowrap;
            white-space: nowrap;
        }

        .current-price { font-weight: 700; font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .old-price { text-decoration: line-through; color: var(--light-text); font-size: 0.7rem;
        }

        .discount { background-color: var(--accent-color); color: var(--white); font-size: 0.65rem; padding: 1px 3px;
            border-radius: 4px;
            margin-left: auto;
        }

        .product-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: var(--light-text);
        }

        .rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stars {
            color: var(--secondary-color);
        }

        .product-actions {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            background-color: var(--white);
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
            opacity: 0;
            transition: var(--transition);
        }

        .product-card:hover .product-actions {
            bottom: 0;
            opacity: 1;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--secondary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background-color: var(--primary-color);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            gap: 5px;
        }

        .page-nav, 
        .page-num {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            transition: var(--transition);
        }

        .page-num.active {
            background-color: var(--secondary-color);
            color: var(--white);
            border-color: var(--secondary-color);
        }

        .page-nav:hover, 
        .page-num:hover:not(.active) {
            background-color: var(--bg-light);
        }

        .page-nav.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Add to existing styles */
.auth-alert {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.7);
    z-index: 2000;
    display: flex;
    justify-content: center;
    align-items: center;
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
    padding: 30px;
    border-radius: 8px;
    max-width: 400px;
    text-align: center;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.auth-alert.show .auth-alert-content {
    transform: translateY(0);
}

.auth-alert h3 {
    margin-top: 0;
    color: var(--primary-color);
}

.auth-alert p {
    margin: 15px 0 25px;
    color: var(--text-color);
}

.auth-alert-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
}

        /* Cart Notification */
        .cart-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(100px);
            opacity: 0;
            transition: var(--transition);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .cart-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .cart-notification a {
            color: var(--white);
            text-decoration: underline;
            font-weight: 500;
        }

        /* Product Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .product-modal {
            background-color: var(--white);
            border-radius: 8px;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transform: translateY(50px);
            transition: var(--transition);
        }

        .modal-overlay.active .product-modal {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--light-text);
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--accent-color);
        }

        .modal-content {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        @media (min-width: 768px) {
            .modal-content {
                flex-direction: row;
                gap: 30px;
            }
        }

        .modal-image {
            flex: 1;
            min-height: 300px;
            border-radius: 8px;
            overflow: hidden;
        }

        .modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .modal-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .modal-old-price {
            text-decoration: line-through;
            color: var(--light-text);
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .modal-discount {
            background-color: var(--accent-color);
            color: var(--white);
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .modal-description {
            color: var(--light-text);
            line-height: 1.7;
        }

        .modal-features {
            margin-top: 10px;
        }

        .modal-features ul {
            list-style-position: inside;
            margin-top: 5px;
        }

        .modal-features li {
            margin-bottom: 5px;
            color: var(--light-text);
        }

        .size-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .size-btn {
            padding: 8px 15px;
            border: 1px solid var(--border-color);
            background: none;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
        }

        .size-btn:hover, 
        .size-btn.active {
            background-color: var(--secondary-color);
            color: var(--white);
            border-color: var(--secondary-color);
        }

        .color-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .color-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
        }

        .color-btn::after {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            opacity: 0;
            transition: var(--transition);
        }

        .color-btn:hover::after, 
        .color-btn.active::after {
            opacity: 1;
            border-color: var(--secondary-color);
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
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

        .modal-actions {
            display: flex;
            gap: 5px;
            margin-top: 20px;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            color: var(--white);
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            flex: 1;
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

        .modal-footer {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            border-top: 1px solid var(--border-color);
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .modal-sku {
            font-weight: 500;
        }

        .modal-category {
            text-transform: capitalize;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .shop-content {
                flex-direction: column;
            }
            
            .shop-filters {
                width: 100%;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .listing-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .modal-content {
                flex-direction: column;
            }

            .modal-image {
                min-height: 200px;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .modal-actions {
                flex-direction: column;
            }

            
        }



    </style>
</head>
<body>

<?php include '../../app/views/partials/header.php'; ?>


    <main class="shop-page" style="padding-top: 20px;">
        <div class="container">
            <div class="page-header" style="margin-top: 0; padding-top: 0;">
                <h1 style="margin-top: 0; margin-bottom: 10px;">Shop Our Collection</h1>
                <div class="breadcrumbs" style="margin-bottom: 20px;">
                    <a href="index.php">Home</a> / <span>Shop</span>
                </div>
            </div>
            
            <div class="shop-content">
                <!-- Filters Sidebar -->
                <aside class="shop-filters">
                    

                    <div class="filter-section">
                        <h3>Product Type</h3>
                        <ul class="filter-list type-list" id="typeList">
                            <li><a href="#" class="active" data-type="all">All Types</a></li>
                            <li><a href="#" data-type="tops">Tops</a></li>
                            <li><a href="#" data-type="bottoms">Bottoms</a></li>
                            <li><a href="#" data-type="footwear">Footwear</a></li>
                            <li><a href="#" data-type="accessories">Accessories</a></li>
                        </ul>
                    </div>
                    
                    
                    
                    <button class="btn btn-secondary apply-filters">Apply Filters</button>
                    <button class="btn btn-text reset-filters">Reset All</button>
                </aside>
                
                <!-- Product Grid -->
                <div class="product-listing">
                    <div class="listing-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 5px; margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                        <div class="top-filters" style="display: flex; gap: 5px; flex-wrap: wrap; flex: 1;">
                            <div class="filter-group" style="display: flex; align-items: center; gap: 10px;">
                                <label for="topCategoryFilter" style="font-weight: 500;">Category:</label>
                                <select id="topCategoryFilter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                    <option value="all">All</option>
                                    <option value="shirts">Shirts</option>
                                    <option value="t-shirts">T-Shirts</option>
                                    <option value="jeans">Jeans</option>
                                    <option value="pants">Pants</option>
                                    <option value="hoodies">Hoodies</option>
                                    <option value="jackets">Jackets</option>
                                    <option value="dresses">Dresses</option>
                                    <option value="skirts">Skirts</option>
                                    <option value="tops">Tops</option>
                                </select>
                            </div>
                            <div class="filter-group" style="display: flex; align-items: center; gap: 10px;">
                                <label for="topPriceFilter" style="font-weight: 500;">Price:</label>
                                <select id="topPriceFilter" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                    <option value="all">Any Price</option>
                                    <option value="0-3000">Under Rs 3,000</option>
                                    <option value="3000-5000">Rs 3,000 - Rs 5,000</option>
                                    <option value="5000-10000">Rs 5,000 - Rs 10,000</option>
                                    <option value="10000+">Over Rs 10,000</option>
                                </select>
                            </div>
                        </div>
                        <div class="sort-options" style="display: flex; align-items: center; gap: 10px;">
                            <label for="sortBy" style="font-weight: 500;">Sort by:</label>
                            <select id="sortBy" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                                <option value="featured">Featured</option>
                                <option value="newest">Newest</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="rating">Customer Rating</option>
                            </select>
                        </div>
                        <div class="view-options">
                            <span class="view-btn active" data-view="grid"><i class="fas fa-th"></i></span>
                            <span class="view-btn" data-view="list"><i class="fas fa-list"></i></span>
                        </div>
                    </div>
                    
                    <div class="product-grid grid-view" id="productGrid">
                        <!-- Products will be loaded via JavaScript -->
                    </div>
                    
                    <div id="infinite-scroll-trigger" style="text-align: center; padding: 20px;"><div class="hourglass" style="display:none; margin: 0 auto;"></div></div>
                </div>
            </div>
        </div>
    </main>


    <!-- Footer -->

  <?php include '../../app/views/partials/footer.php'; ?>

    <script src="../assets/js/wishlist.js"></script>

    <script>
// API Configuration - ADD THIS AT THE TOP
const API_BASE = '../../app/api/products';



// Product Data
let products = [];

// Fetch products from database
let isLoadingProducts = false;
let hasMoreProducts = true;

async function fetchProducts(append = false) {
    if (isLoadingProducts || (!append && !hasMoreProducts)) return;
    isLoadingProducts = true;
    
    if (!append) {
        currentPage = 1;
        products = [];
        const productGrid = document.getElementById('productGrid');
        if (productGrid) productGrid.innerHTML = '';
    }

    try {
        const urlParams = new URLSearchParams(window.location.search);
        const search = currentFilters.search || urlParams.get('search') || '';
        const category = currentFilters.category !== 'all' ? currentFilters.category : (urlParams.get('category') || '');
        
        // Render Search Indicator
        const searchContainer = document.getElementById('searchIndicatorContainer');
        if (searchContainer) {
            if (search) {
                searchContainer.innerHTML = `
                    <div style="background: var(--light-gray); padding: 10px 15px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                        <span>Showing results for: <strong>"${search}"</strong></span>
                        <a href="shop.php" style="color: var(--primary); text-decoration: none; cursor: pointer;" onclick="event.preventDefault(); window.location.href='shop.php';"><i class="fas fa-times"></i> Clear Search</a>
                    </div>
                `;
            } else {
                searchContainer.innerHTML = '';
            }
        }
        
        const type = currentFilters.type !== 'all' ? currentFilters.type : (urlParams.get('type') || '');
        const url = `${API_BASE}/get_products.php?page=${currentPage}&limit=12&category=${encodeURIComponent(category)}&search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}&min_price=${currentFilters.minPrice}&max_price=${currentFilters.maxPrice}&sort=${currentFilters.sort}`;
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.status === 'success') {
            const newProducts = data.products.map(p => ({
                id: parseInt(p.id),
                title: p.title,
                category: p.category,
                price: parseFloat(p.price),
                oldPrice: p.oldPrice ? parseFloat(p.oldPrice) : null,
                image: p.image,
                colors: p.colors || [],
                sizes: p.sizes || [],
                rating: parseFloat(p.rating),
                reviews: parseInt(p.reviews),
                badge: p.badge,
                featured: Boolean(p.featured),
                newArrival: Boolean(p.newArrival),
                sku: p.sku,
                description: p.description,
                features: p.features || [],
                colorCodes: p.color_codes || {}
            }));
            
            if (!append) {
                products = newProducts;
            } else {
                products = [...products, ...newProducts];
            }
            
            hasMoreProducts = newProducts.length === 12;
            

            
            renderProducts(newProducts, append);
            updatePagination();
        }
    } catch (error) {
        console.error('Error fetching products:', error);
    } finally {
        isLoadingProducts = false;
    }
}

// Dynamic category dropdown logic
let dbCategories = [];
async function fetchCategories() {
    try {
        const response = await fetch(`${API_BASE}/get_categories.php`);
        const data = await response.json();
        if (data.status === 'success') {
            const allCats = new Set();
            Object.values(data.categories).forEach(arr => {
                arr.forEach(cat => allCats.add(cat));
            });
            dbCategories = Array.from(allCats).sort();
        }
    } catch(e) {
        console.error('Error fetching categories:', e);
    }
}

function updateCategoryDropdown(selectedType) {
    const topCategoryFilter = document.getElementById('topCategoryFilter');
    if (!topCategoryFilter) return;
    
    let optionsHtml = '<option value="all">All Categories</option>';
    
    dbCategories.forEach(cat => {
        optionsHtml += `<option value="${cat.toLowerCase()}">${cat}</option>`;
    });
    
    topCategoryFilter.innerHTML = optionsHtml;
    // ensure current category is valid, else reset to 'all'
    let validCategory = Array.from(topCategoryFilter.options).some(opt => opt.value === currentFilters.category);
    if (!validCategory) {
        currentFilters.category = 'all';
    }
    topCategoryFilter.value = currentFilters.category;
}

function bindTypeEvents() {
    const typeLinks = document.querySelectorAll('#typeList a');
    typeLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            typeLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            currentFilters.type = this.dataset.type;
            updateCategoryDropdown(currentFilters.type);
            currentPage = 1;
            applyFilters();
        });
    });
}



// Shopping Cart - Now stored in MySQL database
let cart = [];
let cartCount = 0;

// Current filters
let currentFilters = {
    category: 'all',
    type: 'all',
    minPrice: 0,
    maxPrice: 5000,
    sort: 'featured'
};

// Current sort
let currentSort = 'featured';

// Currently selected product in modal
let currentModalProduct = null;
let selectedSize = null;
let selectedColor = null;

// Pagination variables
const productsPerPage = 9;
let currentPage = 1;
let totalPages = 1;
let filteredProducts = [];

// Auth check - Use the same auth object structure as account page
const auth = {
    currentUser: null,
    apiBaseUrl: '../../app/api'
};

// Custom event for authentication changes
const authEvent = new Event('authChange');

// ==============================================
// Initialize authentication (FIXED)
// ==============================================
async function initializeAuth() {
    try {
        const res = await fetch(`${auth.apiBaseUrl}/auth/validate_session.php?t=${Date.now()}`, {
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache'
            }
        });

        const data = await res.json();

        if (data.status === 'success') {
            auth.currentUser = {
                id: data.user.id,
                name: data.user.name,
                email: data.user.email,
                wishlist: [] // Will be populated from database
            };

            // Load wishlist items and cart
            await loadWishlistItems();
            await loadCartItems();
            
            // Update localStorage for consistency with account page
            localStorage.setItem('currentUser', JSON.stringify(auth.currentUser));
        } else {
            // User is not authenticated
            auth.currentUser = null;
            cart = [];
            cartCount = 0;
            localStorage.removeItem('cart');
            localStorage.removeItem('currentUser');
        }

        // Dispatch auth change event
        window.dispatchEvent(authEvent);

    } catch (error) {
        console.error('Auth initialization error:', error);
        
        // Fallback to localStorage if API call fails
        auth.currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartCount = cart.reduce((total, item) => total + item.quantity, 0);

        // Dispatch auth change event
        window.dispatchEvent(authEvent);
    }

    // Update UI based on auth status
    updateCartCount();
    updateWishlistCount();
}

// Load cart items from database (FIXED)
async function loadCartItems() {
    if (!auth.currentUser) {
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        updateCartCount();
        return;
    }
    try {
        const response = await fetch(`${auth.apiBaseUrl}/cart/get_cart.php?t=${Date.now()}`, {
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache'
            }
        });
        const data = await response.json();
        if (data.status === 'success') {
            cart = data.cart.map(item => ({
                id: parseInt(item.product_id),
                title: item.title,
                price: parseFloat(item.price),
                image: item.image,
                size: item.size,
                color: item.color,
                quantity: parseInt(item.quantity)
            }));
            localStorage.setItem('cart', JSON.stringify(cart));
            cartCount = cart.reduce((total, item) => total + item.quantity, 0);
            updateCartCount();
        }
    } catch (error) {
        console.error('Error loading cart:', error);
        cart = JSON.parse(localStorage.getItem('cart')) || [];
        cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        updateCartCount();
    }
}

// Load wishlist items from database (FIXED)
async function loadWishlistItems() {
    if (!auth.currentUser) return;
    
    try {
        const response = await fetch(`${auth.apiBaseUrl}/wishlist/get_wishlist.php?t=${Date.now()}`, {
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache'
            }
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            // Update user's wishlist with product details
            auth.currentUser.wishlist = data.wishlist.map(item => ({
                id: parseInt(item.product_id),
                title: item.title,
                price: item.price,
                image: item.image
            }));
            
            // Update localStorage for consistency
            localStorage.setItem('currentUser', JSON.stringify(auth.currentUser));
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
        // Fallback to localStorage if API call fails
        if (!auth.currentUser.wishlist) {
            auth.currentUser.wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        }
    }
}

// Listen for authentication changes
window.addEventListener('authChange', function() {
    updateCartCount();
    updateWishlistCount();
});

// Listen for logout events
window.addEventListener('userLogout', function() {
    auth.currentUser = null;
    cart = [];
    cartCount = 0;
    localStorage.removeItem('cart');
    localStorage.removeItem('currentUser');
    updateCartCount();
    updateWishlistCount();
});

// Listen for login events from the login page
window.addEventListener('userLogin', async function(e) {
    // Update auth state with the user data from the login event
    auth.currentUser = e.detail;
    
    // Update localStorage for consistency with account page
    localStorage.setItem('currentUser', JSON.stringify(auth.currentUser));
    
    // Load cart items for the newly logged in user
    await loadCartItems();
    await loadWishlistItems();
    
    // Update UI
    updateCartCount();
    updateWishlistCount();
    
    // Re-render products to update wishlist status
    applyFilters();
});

document.addEventListener('DOMContentLoaded', async function() {
    try {
        // Check URL params
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        const urlType = urlParams.get('type');
        const urlCategory = urlParams.get('category');
        
        if (searchQuery) currentFilters.search = searchQuery.toLowerCase();
        if (urlType) currentFilters.type = urlType;
        if (urlCategory) currentFilters.category = urlCategory;
        
        // Sync typeList sidebar
        if (currentFilters.type !== 'all') {
            const typeLinks = document.querySelectorAll('#typeList a');
            typeLinks.forEach(l => l.classList.remove('active'));
            const activeLink = document.querySelector(`#typeList a[data-type="${currentFilters.type}"]`);
            if (activeLink) activeLink.classList.add('active');
        }
        
        // Bind sidebar type links immediately
        bindTypeEvents();
        
        // Fetch categories and validate session in parallel for boosted performance
        await Promise.all([
            fetchCategories(),
            initializeAuth()
        ]);
        
        // Update category dropdown
        updateCategoryDropdown(currentFilters.type);
        
        // Fetch products once session validation and categories are done (ensures proper wishlist state on render)
        await fetchProducts();
        
        // Apply filters button
        const applyFiltersBtn = document.querySelector('.apply-filters');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                currentPage = 1;
                applyFilters();
            });
        }
        
        // Reset filters button
        const resetFiltersBtn = document.querySelector('.reset-filters');
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', function() {
                // Reset category dropdown
                const topCategoryFilter = document.getElementById('topCategoryFilter');
                if (topCategoryFilter) {
                    topCategoryFilter.value = 'all';
                }
                
                // Reset price dropdown
                const topPriceFilter = document.getElementById('topPriceFilter');
                if (topPriceFilter) {
                    topPriceFilter.value = 'all';
                }
                
                // Reset sort dropdown
                const sortByFilter = document.getElementById('sortBy');
                if (sortByFilter) {
                    sortByFilter.value = 'featured';
                }
                
                // Reset type sidebar links
                const typeLinks = document.querySelectorAll('#typeList a');
                typeLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.type === 'all') {
                        link.classList.add('active');
                    }
                });
                
                // Reset filters object
                currentFilters = {
                    category: 'all',
                    type: 'all',
                    minPrice: 0,
                    maxPrice: 1000000,
                    sort: 'featured'
                };
                
                currentPage = 1;
                applyFilters();
            });
        }
        
        // Top filter dropdown changes
        const topCategoryFilter = document.getElementById('topCategoryFilter');
        if (topCategoryFilter) {
            topCategoryFilter.addEventListener('change', function() {
                currentFilters.category = this.value;
                currentPage = 1;
                applyFilters();
            });
        }

        const topPriceFilter = document.getElementById('topPriceFilter');
        if (topPriceFilter) {
            topPriceFilter.addEventListener('change', function() {
                if (this.value === 'all') {
                    currentFilters.minPrice = 0;
                    currentFilters.maxPrice = 1000000;
                } else if (this.value === '10000+') {
                    currentFilters.minPrice = 10000;
                    currentFilters.maxPrice = 1000000;
                } else {
                    const parts = this.value.split('-');
                    currentFilters.minPrice = parseFloat(parts[0]);
                    currentFilters.maxPrice = parseFloat(parts[1]);
                }
                currentPage = 1;
                applyFilters();
            });
        }

        const sortByFilter = document.getElementById('sortBy');
        if (sortByFilter) {
            sortByFilter.addEventListener('change', function() {
                currentFilters.sort = this.value;
                currentPage = 1;
                applyFilters();
            });
        }
        
        // View options grid/list toggles
        const viewButtons = document.querySelectorAll('.view-btn');
        const productGrid = document.querySelector('.product-grid');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.dataset.view === 'grid') {
                    productGrid.classList.remove('list-view');
                    productGrid.classList.add('grid-view');
                } else {
                    productGrid.classList.remove('grid-view');
                    productGrid.classList.add('list-view');
                }
            });
        });

    } catch (error) {
        console.error('Initialization error:', error);
    } finally {
        // Hide loader overlay once initial loading and rendering is done
        if (typeof window.hideLoader === 'function') {
            window.hideLoader();
        }
    }
});

// Apply all current filters

function applyFilters(isInfiniteScrollLoad = false) {
    if (!isInfiniteScrollLoad) {
        hasMoreProducts = true;
    }
    fetchProducts(isInfiniteScrollLoad);
}

// Update pagination controls (Handles infinite scroll indicator)
function updatePagination() {
    let paginationContainer = document.querySelector('.pagination');
    if (!paginationContainer) {
        paginationContainer = document.createElement('div');
        paginationContainer.className = 'pagination';
        const productListing = document.querySelector('.product-listing');
        if(productListing) productListing.appendChild(paginationContainer);
    }
    paginationContainer.innerHTML = '';
    
    if (hasMoreProducts) {
        const loadingIndicator = document.createElement('div');
        loadingIndicator.className = 'infinite-scroll-loading';
        loadingIndicator.innerHTML = '<div id="infinite-scroll-trigger" style="text-align: center; padding: 20px;"><div class="hourglass" style="display:inline-block; margin: 0 auto; width: 40px; height: 40px;"></div></div>';
        loadingIndicator.style.width = '100%';
        paginationContainer.appendChild(loadingIndicator);
        
        // Setup observer on the trigger
        setTimeout(() => {
            const trigger = document.getElementById('infinite-scroll-trigger');
            if (trigger) {
                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting && !isLoadingProducts) {
                        currentPage++;
                        applyFilters(true);
                    }
                }, { rootMargin: '200px' });
                observer.observe(trigger);
            }
        }, 100);
    } else if (products.length > 0) {
        const endMessage = document.createElement('div');
        endMessage.className = 'infinite-scroll-end';
        endMessage.innerHTML = 'You have reached the end of the list.';
        endMessage.style.padding = '20px';
        endMessage.style.textAlign = 'center';
        endMessage.style.width = '100%';
        endMessage.style.color = 'var(--light-text)';
        paginationContainer.appendChild(endMessage);
    }
}

// Remove old window scroll event listener
window.addEventListener('scroll', () => {});

// Render products based on current filters and sort
// Render products based on current filters and sort
function renderProducts(productsToDisplay, append = false) {
    const productGrid = document.getElementById('productGrid');
    
    if (!append) {
        productGrid.innerHTML = '';
        if (productsToDisplay.length === 0) {
            productGrid.innerHTML = '<p class="no-products">No products found matching your criteria.</p>';
            return;
        }
    }
    
    // Render each product using the global createProductCard function
    productsToDisplay.forEach(product => {
        const productCard = createProductCard(product);
        productGrid.appendChild(productCard);
    });
}

// Listen for storage events to update counts when data changes in other tabs
window.addEventListener('storage', function(e) {
    if (e.key === 'cart') {
        cart = JSON.parse(e.newValue) || [];
        cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        updateCartCount();
    }
    if (e.key === 'currentUser') {
        auth.currentUser = JSON.parse(e.newValue);
        updateWishlistCount();
        updateCartCount();
    }
    if (e.key === 'wishlist') {
        if (auth.currentUser) {
            auth.currentUser.wishlist = JSON.parse(e.newValue) || [];
        }
        updateWishlistCount();
    }
});
</script>
</body>
</html>
