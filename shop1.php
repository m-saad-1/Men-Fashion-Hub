<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Shop Our Collection</title>
    <link rel="icon" href="/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header-footer.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
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

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--white);
        }

        .btn-secondary:hover {
            background-color: #c49555;
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
            gap: 10px;
            margin: 10px 0;
        }

        .current-price {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--secondary-color);
        }

        .old-price {
            text-decoration: line-through;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .discount {
            background-color: var(--accent-color);
            color: var(--white);
            font-size: 0.8rem;
            padding: 2px 8px;
            border-radius: 4px;
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
                gap: 15px;
            }
        }

        @media (max-width: 576px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php include 'header.html'; ?>

    <main class="shop-page">
        <div class="container">
            <div class="page-header">
                <h1>Shop Our Collection</h1>
                <div class="breadcrumbs">
                    <a href="index.php">Home</a> / <span>Shop</span>
                </div>
            </div>
            
            <div class="shop-content">
                <!-- Filters Sidebar -->
                <aside class="shop-filters">
                    <div class="filter-section">
                        <h3>Categories</h3>
                        <ul class="filter-list">
                            <li><a href="#" class="active" data-category="all">All Products</a></li>
                            <li><a href="#" data-category="shirts">Shirts</a></li>
                            <li><a href="#" data-category="jeans">Jeans</a></li>
                            <li><a href="#" data-category="jackets">Jackets</a></li>
                            <li><a href="#" data-category="accessories">Accessories</a></li>
                        </ul>
                    </div>
                    
                    <button class="btn btn-secondary apply-filters">Apply Filters</button>
                    <button class="btn btn-text reset-filters">Reset All</button>
                </aside>
                
                <!-- Product Grid -->
                <div class="product-listing">
                    <div class="listing-header">
                        <div class="sort-options">
                            <label for="sortBy">Sort by:</label>
                            <select id="sortBy">
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
                </div>
            </div>
        </div>
    </main>

<?php include 'footer.html'; ?>

    <script>
        // Basic shop functionality - simplified for now
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mainNav = document.querySelector('.main-nav');
            
            if (mobileMenuToggle && mainNav) {
                mobileMenuToggle.addEventListener('click', function() {
                    mainNav.classList.toggle('active');
                });
            }

            // Load sample products
            loadSampleProducts();
        });

        function loadSampleProducts() {
            const productGrid = document.getElementById('productGrid');
            const sampleProducts = [
                {
                    id: 1,
                    title: "Premium Cotton Shirt",
                    price: 59.99,
                    oldPrice: 74.99,
                    image: "https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    rating: 4.5,
                    reviews: 24,
                    badge: "sale"
                },
                {
                    id: 2,
                    title: "Slim Fit Jeans",
                    price: 79.99,
                    oldPrice: 89.99,
                    image: "https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    rating: 4.0,
                    reviews: 18,
                    badge: "new"
                },
                {
                    id: 3,
                    title: "Classic Denim Jacket",
                    price: 99.99,
                    image: "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    rating: 5.0,
                    reviews: 32
                }
            ];

            productGrid.innerHTML = '';
            sampleProducts.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                
                const badge = product.badge ? `<span class="product-badge ${product.badge}">${product.badge === 'sale' ? 'Sale' : 'New'}</span>` : '';
                const oldPrice = product.oldPrice ? `<span class="old-price">$${product.oldPrice.toFixed(2)}</span>` : '';
                const discount = product.oldPrice ? `<span class="discount">Save ${Math.round((1 - product.price / product.oldPrice) * 100)}%</span>` : '';
                const stars = generateStars(product.rating);
                
                productCard.innerHTML = `
                    <div class="product-image">
                        ${badge}
                        <img src="${product.image}" alt="${product.title}">
                        <div class="product-actions">
                            <button class="action-btn quick-view"><i class="far fa-eye"></i></button>
                            <button class="action-btn add-to-wishlist"><i class="far fa-heart"></i></button>
                            <button class="action-btn add-to-cart"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">${product.title}</h3>
                        <div class="product-price">
                            <span class="current-price">$${product.price.toFixed(2)}</span>
                            ${oldPrice}
                            ${discount}
                        </div>
                        <div class="product-meta">
                            <div class="rating">
                                <div class="stars">
                                    ${stars}
                                </div>
                                <span class="review-count">(${product.reviews})</span>
                            </div>
                        </div>
                    </div>
                `;
                
                productGrid.appendChild(productCard);
            });
        }

        function generateStars(rating) {
            let stars = '';
            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            
            for (let i = 0; i < fullStars; i++) {
                stars += '<i class="fas fa-star"></i>';
            }
            
            if (hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            }
            
            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                stars += '<i class="far fa-star"></i>';
            }
            
            return stars;
        }
    </script>
</body>
</html>