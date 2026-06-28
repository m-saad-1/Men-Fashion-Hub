// public/assets/js/product-card.js

const API_BASE_URL = '../../app/api';

// Generate stars HTML based on rating
function generateStars(rating) {
    let stars = '';
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    // Full stars
    for (let i = 0; i < fullStars; i++) {
        stars += '<i class="fas fa-star"></i>';
    }
    
    // Half star
    if (hasHalfStar) {
        stars += '<i class="fas fa-star-half-alt"></i>';
    }
    
    // Empty stars
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star"></i>';
    }
    
    return stars;
}

// Generate universal product card element
function createProductCard(product) {
    const productCard = document.createElement('div');
    productCard.className = 'product-card';
    productCard.dataset.id = product.id;
    productCard.dataset.category = product.category || '';
    
    // Check if product is in wishlist
    const isInWishlist = typeof auth !== 'undefined' && auth.currentUser ? 
        auth.currentUser.wishlist && auth.currentUser.wishlist.some(item => parseInt(item.id) === parseInt(product.id)) : false;
    
    // Generate stars HTML
    const stars = generateStars(product.rating || 0);
    
    // Generate badge if exists
    const badge = product.badge ? `<span class="product-badge ${product.badge}">${product.badge === 'sale' ? 'Sale' : product.badge === 'new' ? 'New' : 'Best Seller'}</span>` : '';
    
    // Generate old price if exists
    const oldPrice = product.oldPrice ? `<span class="old-price">Rs ${parseFloat(product.oldPrice).toFixed(2)}</span>` : '';
    
    // Generate discount if exists
    let discount = '';
    if (product.oldPrice) {
        const discountPercent = Math.round((1 - product.price / product.oldPrice) * 100);
        discount = `<span class="discount">Save ${discountPercent}%</span>`;
    }
    
    productCard.innerHTML = `
        <div class="product-image">
            ${badge}
            <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
            <img src="${product.image}" alt="${product.title}" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
            <div class="product-actions">
                <button class="action-btn quick-view"><i class="far fa-eye"></i></button>
                <button class="action-btn add-to-wishlist"><i class="${isInWishlist ? 'fas' : 'far'} fa-heart"></i></button>
                <button class="action-btn add-to-cart"><i class="fas fa-shopping-bag"></i></button>
            </div>
        </div>
        <div class="product-info">
            <h3 class="product-title">${product.title}</h3>
            <div class="product-price">
                <span class="current-price">Rs ${parseFloat(product.price).toFixed(2)}</span>
                ${oldPrice}
                ${discount}
            </div>
            <div class="product-meta">
                <div class="rating">
                    <div class="stars">${stars}</div>
                    <span class="review-count">(${product.reviews || 0})</span>
                </div>
            </div>
        </div>
    `;
    
    // Add event listeners
    const quickViewBtn = productCard.querySelector('.quick-view');
    const wishlistBtn = productCard.querySelector('.add-to-wishlist');
    const cartBtn = productCard.querySelector('.add-to-cart');
    
    // Click on product card opens modal
    productCard.addEventListener('click', function(e) {
        if (e.target.closest('.product-actions')) return;
        if (typeof showProductModal === 'function') showProductModal(product);
    });
    
    quickViewBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (typeof showProductModal === 'function') showProductModal(product);
    });
    
    wishlistBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleWishlist(product.id, productCard);
    });
    
    cartBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        addToCart(product);
    });
    
    return productCard;
}

// Universal Wishlist Toggle
async function toggleWishlist(productId, productElement = null) {
    try {
        if (typeof auth === 'undefined' || !auth.currentUser) {
            if (typeof showAuthAlert === 'function') showAuthAlert();
            return false;
        }
        
        const response = await fetch(`${API_BASE_URL}/wishlist/toggle_wishlist.php?t=${Date.now()}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Cache-Control': 'no-cache'
            },
            credentials: 'include',
            body: JSON.stringify({
                product_id: productId
            })
        });
        
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        const data = await response.json();
        
        if (data.status === 'success') {
            // Update auth currentUser wishlist array locally
            if (data.action === 'added') {
                if (!auth.currentUser.wishlist) auth.currentUser.wishlist = [];
                // Push a minimal product stub, we will reload if needed or just let it be
                auth.currentUser.wishlist.push({ id: productId });
                if (typeof showWishlistNotification === 'function') showWishlistNotification('Added to wishlist!');
            } else {
                if (auth.currentUser.wishlist) {
                    auth.currentUser.wishlist = auth.currentUser.wishlist.filter(item => parseInt(item.id) !== parseInt(productId));
                }
                if (typeof showWishlistNotification === 'function') showWishlistNotification('Removed from wishlist!');
            }
            localStorage.setItem('currentUser', JSON.stringify(auth.currentUser));
            
            // Update heart icon on specific card
            if (productElement) {
                const heartIcon = productElement.querySelector('.add-to-wishlist i');
                if (heartIcon) {
                    heartIcon.className = data.action === 'added' ? 'fas fa-heart' : 'far fa-heart';
                }
            }
            
            // Update modal button if open
            const modalWishlistBtn = document.getElementById('addToWishlistModal');
            if (modalWishlistBtn) {
                modalWishlistBtn.innerHTML = data.action === 'added' ?
                    '<i class="fas fa-heart"></i> Remove from Wishlist' :
                    '<i class="far fa-heart"></i> Add to Wishlist';
            }
            
            // Trigger global counter update
            window.dispatchEvent(new Event('authChange'));
            
            return true;
        }
    } catch (error) {
        console.error('Error toggling wishlist:', error);
        return false;
    }
}

// Universal Add to Cart
async function addToCart(product, quantity = 1, size = null, color = null) {
    if (typeof auth !== 'undefined' && auth.currentUser) {
        try {
            const response = await fetch(`${API_BASE_URL}/cart/add_to_cart.php?t=${Date.now()}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Cache-Control': 'no-cache'
                },
                credentials: 'include',
                body: JSON.stringify({
                    product_id: product.id,
                    quantity: quantity,
                    size: size,
                    color: color
                })
            });
            const data = await response.json();
            if (data.status === 'success') {
                if (typeof loadCartItems === 'function') {
                    await loadCartItems();
                }
                if (typeof showCartNotification === 'function') showCartNotification(product);
            } else {
                console.error('Error adding to cart:', data.message);
                alert('Failed to add to cart: ' + data.message);
            }
        } catch (error) {
            console.error('Cart add error:', error);
            addToCartLocal(product, quantity, size, color);
        }
    } else {
        addToCartLocal(product, quantity, size, color);
    }
}

function addToCartLocal(product, quantity = 1, size = null, color = null) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItemIndex = cart.findIndex(item => 
        item.id === product.id && 
        item.size === size && 
        item.color === color
    );
    
    if (existingItemIndex >= 0) {
        cart[existingItemIndex].quantity += quantity;
    } else {
        cart.push({
            id: product.id,
            title: product.title,
            price: product.price,
            image: product.image,
            size: size,
            color: color,
            quantity: quantity
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Trigger global counter update
    window.dispatchEvent(new StorageEvent('storage', {
        key: 'cart',
        newValue: JSON.stringify(cart)
    }));
    
    if (typeof showCartNotification === 'function') showCartNotification(product);
}

// Show authentication required alert
window.showAuthAlert = function() {
    const alert = document.createElement('div');
    alert.className = 'auth-alert';
    alert.innerHTML = `
        <div class="auth-alert-content">
            <h3>Account Required</h3>
            <p>Please create an account or login to add items to your wishlist or cart.</p>
            <div class="auth-alert-buttons">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="login.php" class="btn btn-outline">Create Account</a>
            </div>
        </div>
    `;
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.classList.add('show');
    }, 10);
    
    // Click anywhere to close
    alert.addEventListener('click', function() {
        alert.classList.remove('show');
        setTimeout(() => {
            alert.remove();
        }, 300);
    });
}

// Show cart notification
window.showCartNotification = function(product, appliedDefaults = {}) {
    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    
    let defaultsText = '';
    if (appliedDefaults.size || appliedDefaults.color) {
        const parts = [];
        if (appliedDefaults.size) parts.push(`Size: ${appliedDefaults.size}`);
        if (appliedDefaults.color) parts.push(`Color: ${appliedDefaults.color}`);
        defaultsText = `<br><small>Default options applied: ${parts.join(', ')}</small>`;
    }
    
    notification.innerHTML = `
        <p>${product.title} added to cart!${defaultsText}</p>
        <a href="cart.php">View Cart</a>
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

// Show wishlist notification
window.showWishlistNotification = function(message) {
    const notification = document.createElement('div');
    notification.className = 'cart-notification';
    notification.innerHTML = `<p>${message}</p>`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 2000);
}
