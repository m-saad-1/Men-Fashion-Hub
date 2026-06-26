// public/assets/js/modal.js

document.addEventListener('DOMContentLoaded', function() {
    // Inject Modal HTML if it doesn't exist
    if (!document.getElementById('productModal')) {
        const modalHtml = `
            <div class="modal-overlay" id="productModal">
                <div class="product-modal">
                    <div class="modal-header">
                        <h2 class="modal-title" id="modalProductTitle">Product Name</h2>
                        <button class="close-modal" id="closeModal">&times;</button>
                    </div>
                    <div class="modal-content">
                        <div class="modal-image">
                            <img src="" alt="" id="modalProductImage">
                        </div>
                        <div class="modal-details">
                            <div class="modal-price-container">
                                <span class="modal-price" id="modalProductPrice"></span>
                                <span class="modal-old-price" id="modalProductOldPrice" style="display:none;"></span>
                                <span class="modal-discount" id="modalProductDiscount" style="display:none;"></span>
                            </div>
                            <div class="rating">
                                <div class="stars" id="modalProductRating"></div>
                                <span class="review-count" id="modalProductReviews"></span>
                            </div>
                            <p class="modal-description" id="modalProductDescription"></p>
                            <div class="modal-features">
                                <h4>Features:</h4>
                                <ul id="modalProductFeatures"></ul>
                            </div>
                            <div class="size-selection">
                                <h4>Size:</h4>
                                <div class="size-options" id="modalSizeOptions"></div>
                            </div>
                            <div class="color-selection">
                                <h4>Color:</h4>
                                <div class="color-options" id="modalColorOptions"></div>
                            </div>
                            <div class="quantity-selector">
                                <h4>Quantity:</h4>
                                <button class="quantity-btn" id="decreaseQty">-</button>
                                <input type="number" min="1" value="1" class="quantity-input" id="productQuantity">
                                <button class="quantity-btn" id="increaseQty">+</button>
                            </div>
                            <div class="modal-actions">
                                <button class="btn-primary" id="addToCartModal">Add to Cart</button>
                                <button class="btn-outline" id="addToWishlistModal">Add to Wishlist</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="modal-sku">SKU: <span id="modalProductSKU"></span></span>
                        <a href="#" id="viewDetailsLink" class="btn btn-text" style="margin-left: auto; margin-right: 20px;">View Full Details</a>
                        <span class="modal-category">Category: <span id="modalProductCategory"></span></span>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }

    // Modal Event Listeners
    const modal = document.getElementById('productModal');
    const closeModalBtn = document.getElementById('closeModal');
    const quantityInput = document.getElementById('productQuantity');
    const decreaseQty = document.getElementById('decreaseQty');
    const increaseQty = document.getElementById('increaseQty');
    const addToCartModal = document.getElementById('addToCartModal');
    const addToWishlistModal = document.getElementById('addToWishlistModal');

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => modal.classList.remove('active'));
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.remove('active');
        });
    }

    if (decreaseQty) {
        decreaseQty.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > 1) quantityInput.value = value - 1;
        });
    }

    if (increaseQty) {
        increaseQty.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });
    }

    if (addToCartModal) {
        addToCartModal.addEventListener('click', () => {
            if (typeof window.currentModalProduct !== 'undefined' && window.currentModalProduct) {
                const quantity = parseInt(quantityInput.value);
                if (typeof addToCart === 'function') {
                    addToCart(window.currentModalProduct, quantity, window.selectedSize, window.selectedColor);
                    modal.classList.remove('active');
                }
            }
        });
    }

    if (addToWishlistModal) {
        addToWishlistModal.addEventListener('click', () => {
            if (typeof window.currentModalProduct !== 'undefined' && window.currentModalProduct) {
                if (typeof toggleWishlist === 'function') {
                    toggleWishlist(window.currentModalProduct.id);
                }
            }
        });
    }
});

// Global state variables for modal
window.currentModalProduct = null;
window.selectedSize = null;
window.selectedColor = null;

// Show product modal with details
function showProductModal(product) {
    const modal = document.getElementById('productModal');
    if (!modal) return;
    
    window.currentModalProduct = product;
    window.selectedSize = null;
    window.selectedColor = null;
    
    // Check if product is in wishlist
    const isInWishlist = typeof auth !== 'undefined' && auth.currentUser ? 
        auth.currentUser.wishlist && auth.currentUser.wishlist.some(item => parseInt(item.id) === parseInt(product.id)) : false;
    
    // Set basic product info
    document.getElementById('modalProductTitle').textContent = product.title || '';
    document.getElementById('modalProductImage').src = product.image || '';
    document.getElementById('modalProductPrice').textContent = `Rs ${parseFloat(product.price || 0).toFixed(2)}`;
    document.getElementById('modalProductDescription').textContent = product.description || '';
    document.getElementById('modalProductSKU').textContent = product.sku || '';
    document.getElementById('modalProductCategory').textContent = product.category || '';
    
    // Set rating
    const ratingContainer = document.getElementById('modalProductRating');
    if (ratingContainer && typeof generateStars === 'function') {
        ratingContainer.innerHTML = generateStars(product.rating || 0);
    }
    document.getElementById('modalProductReviews').textContent = `(${product.reviews || 0})`;
    
    // Set price details
    const oldPriceEl = document.getElementById('modalProductOldPrice');
    const discountEl = document.getElementById('modalProductDiscount');
    
    if (product.oldPrice) {
        oldPriceEl.textContent = `Rs ${parseFloat(product.oldPrice).toFixed(2)}`;
        const discountPercent = Math.round((1 - product.price / product.oldPrice) * 100);
        discountEl.textContent = `Save ${discountPercent}%`;
        oldPriceEl.style.display = 'inline';
        discountEl.style.display = 'inline';
    } else {
        oldPriceEl.style.display = 'none';
        discountEl.style.display = 'none';
    }
    
    // Set features
    const featuresList = document.getElementById('modalProductFeatures');
    featuresList.innerHTML = '';
    if (product.features && Array.isArray(product.features)) {
        product.features.forEach(feature => {
            const li = document.createElement('li');
            li.textContent = feature;
            featuresList.appendChild(li);
        });
    }
    
    // Set size options
    const sizeOptions = document.getElementById('modalSizeOptions');
    sizeOptions.innerHTML = '';
    if (product.sizes && Array.isArray(product.sizes)) {
        product.sizes.forEach(size => {
            const btn = document.createElement('button');
            btn.className = 'size-btn';
            btn.textContent = size;
            btn.dataset.size = size;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                window.selectedSize = size;
            });
            sizeOptions.appendChild(btn);
        });
    }
    
    // Set color options
    const colorOptions = document.getElementById('modalColorOptions');
    colorOptions.innerHTML = '';
    if (product.colors && Array.isArray(product.colors)) {
        product.colors.forEach(color => {
            const btn = document.createElement('button');
            btn.className = 'color-btn';
            btn.dataset.color = color;
            btn.style.backgroundColor = (product.colorCodes && product.colorCodes[color]) ? product.colorCodes[color] : color;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                window.selectedColor = color;
            });
            colorOptions.appendChild(btn);
        });
    }
    
    // Update wishlist button in modal
    const wishlistBtn = document.getElementById('addToWishlistModal');
    if (wishlistBtn) {
        wishlistBtn.innerHTML = isInWishlist ? 
            '<i class="fas fa-heart"></i> Remove from Wishlist' : 
            '<i class="far fa-heart"></i> Add to Wishlist';
    }
    
    // Reset quantity
    const qtyInput = document.getElementById('productQuantity');
    if (qtyInput) qtyInput.value = 1;
    
    // Update view details link to pass product image
    const viewDetailsLink = document.getElementById('viewDetailsLink');
    if (viewDetailsLink) {
        const encodedImage = encodeURIComponent(product.image || '');
        viewDetailsLink.href = `product-details.php?id=${product.id}&image=${encodedImage}`;
    }

    // Show modal
    modal.classList.add('active');
}
