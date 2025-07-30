// Load products from mock data
function loadProducts() {
    // Mock products data
    const mockProducts = [
        {
            id: 1,
            name: "Premium Cotton Shirt",
            price: 59.99,
            oldPrice: 74.99,
            image: "images/products/shirt-1.jpg",
            category: "shirts",
            rating: 4.5,
            reviewCount: 24,
            isNew: true,
            onSale: true,
            colors: ["#3a3a3a", "#5a8ac1", "#e6e6e6"],
            sizes: ["XS", "S", "M", "L", "XL"]
        },
        {
            id: 2,
            name: "Slim Fit Jeans",
            price: 79.99,
            oldPrice: 89.99,
            image: "images/products/jeans-1.jpg",
            category: "jeans",
            rating: 4.2,
            reviewCount: 18,
            isNew: false,
            onSale: true,
            colors: ["#3a3a3a", "#5a3a22"],
            sizes: ["28", "30", "32", "34", "36"]
        },
        {
            id: 3,
            name: "Classic Denim Jacket",
            price: 99.99,
            image: "images/products/jacket-1.jpg",
            category: "jackets",
            rating: 4.7,
            reviewCount: 32,
            isNew: true,
            onSale: false,
            colors: ["#5a8ac1", "#3a3a3a"],
            sizes: ["S", "M", "L", "XL"]
        },
        {
            id: 4,
            name: "Basic White T-Shirt",
            price: 29.99,
            image: "images/products/tshirt-1.jpg",
            category: "t-shirts",
            rating: 4.0,
            reviewCount: 15,
            isNew: false,
            onSale: false,
            colors: ["#e6e6e6", "#3a3a3a"],
            sizes: ["XS", "S", "M", "L", "XL"]
        },
        {
            id: 5,
            name: "Casual Summer Dress",
            price: 69.99,
            oldPrice: 79.99,
            image: "images/products/dress-1.jpg",
            category: "dresses",
            rating: 4.3,
            reviewCount: 21,
            isNew: false,
            onSale: true,
            colors: ["#ff69b4", "#ffffff", "#87ceeb"],
            sizes: ["S", "M", "L"]
        },
        {
            id: 6,
            name: "Leather Crossbody Bag",
            price: 89.99,
            image: "images/products/bag-1.jpg",
            category: "bags",
            rating: 4.8,
            reviewCount: 27,
            isNew: true,
            onSale: false,
            colors: ["#3a3a3a", "#8b4513"],
            sizes: ["One Size"]
        }
    ];

    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const category = urlParams.get('category');
    
    // Filter products by category if specified
    let productsToShow = mockProducts;
    if (category) {
        productsToShow = mockProducts.filter(product => {
            return product.category === category || 
                   (category === 'new-arrivals' && product.isNew) ||
                   (category === 'best-sellers' && product.rating >= 4.5) ||
                   (category === 'sale' && product.onSale);
        });
    }
    
    // Get the product grid element
    const productGrids = document.querySelectorAll('.product-grid:not(.grid-view)');
    
    productGrids.forEach(grid => {
        // Clear existing content
        grid.innerHTML = '';
        
        // Check if there are products to show
        if (productsToShow.length === 0) {
            grid.innerHTML = '<p class="no-products">No products found in this category.</p>';
            return;
        }
        
        // Add products to the grid
        productsToShow.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.innerHTML = `
                <div class="product-image">
                    ${product.onSale ? '<span class="product-badge sale">Sale</span>' : ''}
                    ${product.isNew ? '<span class="product-badge new">New</span>' : ''}
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-actions">
                        <button class="action-btn quick-view" data-id="${product.id}"><i class="far fa-eye"></i></button>
                        <button class="action-btn add-to-wishlist" data-id="${product.id}"><i class="far fa-heart"></i></button>
                        <button class="action-btn add-to-cart" data-id="${product.id}"><i class="fas fa-shopping-bag"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-title">${product.name}</h3>
                    <div class="product-price">
                        <span class="current-price">$${product.price.toFixed(2)}</span>
                        ${product.oldPrice ? `<span class="old-price">$${product.oldPrice.toFixed(2)}</span>` : ''}
                        ${product.onSale ? `<span class="discount">Save ${Math.round((1 - product.price / product.oldPrice) * 100)}%</span>` : ''}
                    </div>
                    <div class="product-meta">
                        <div class="rating">
                            <div class="stars">
                                ${generateStars(product.rating)}
                            </div>
                            <span class="review-count">(${product.reviewCount})</span>
                        </div>
                    </div>
                </div>
            `;
            
            grid.appendChild(productCard);
        });
        
        // Add event listeners to product actions
        addProductEventListeners();
    });
}

// Add event listeners to product actions
function addProductEventListeners() {
    // Quick view buttons
    document.querySelectorAll('.quick-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            // In a real implementation, this would show a quick view modal with product details
            alert(`Quick view for product ID: ${productId}. This would show product details in a modal.`);
        });
    });
    
    // Add to wishlist buttons
    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            const productCard = this.closest('.product-card');
            
            // Get current wishlist from localStorage
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            
            // Check if product is already in wishlist
            const existingIndex = wishlist.findIndex(item => item.id === productId);
            
            if (existingIndex >= 0) {
                // Remove from wishlist
                wishlist.splice(existingIndex, 1);
                productCard.classList.remove('in-wishlist');
                this.innerHTML = '<i class="far fa-heart"></i>';
            } else {
                // Add to wishlist
                wishlist.push({ id: productId });
                productCard.classList.add('in-wishlist');
                this.innerHTML = '<i class="fas fa-heart"></i>';
            }
            
            // Save to localStorage
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            
            // Update wishlist count
            updateWishlistCount();
        });
    });
    
    // Add to cart buttons
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = parseInt(this.getAttribute('data-id'));
            
            // Get current cart from localStorage
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Check if product is already in cart
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                // Increase quantity
                existingItem.quantity += 1;
            } else {
                // Add new item to cart
                cart.push({
                    id: productId,
                    quantity: 1,
                    size: 'M', // Default size
                    color: '#3a3a3a' // Default color
                });
            }
            
            // Save to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Update cart count
            updateCartCount();
            
            // Show added to cart message
            showAddedToCartMessage();
        });
    });
}