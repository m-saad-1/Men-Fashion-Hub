
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
        
        const type = currentFilters.type !== 'all' ? currentFilters.type : (urlParams.get('type') || '');
        const url = `${API_BASE}/get_products.php?page=${currentPage}&limit=12&category=${encodeURIComponent(category)}&search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}&min_price=${currentFilters.minPrice}&max_price=${currentFilters.maxPrice}&sort=${currentFilters.sort}`;
        
        const response = await fetch(url);
        const data = await response.json();
        
        if (data.status === 'success') {
            const newProducts = data.products.map(p => ({
                id: p.id,
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
            
            // Re-populate category sidebar dynamically based on loaded products
            if (!append) {
                populateSidebarCategories();
            }
            
            renderProducts(newProducts, append);
            updatePagination();
        }
    } catch (error) {
        console.error('Error fetching products:', error);
    } finally {
        isLoadingProducts = false;
    }
}

// Dynamically populate sidebar categories based on fetched products
function populateSidebarCategories() {
    const filterSection = document.getElementById('categoryList');
    if (!filterSection) return;
    
    // Get unique categories from products
    const categories = [...new Set(products.map(p => p.category))].filter(Boolean).sort();
    
    // Check url params for category
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get('category');
    
    let html = `<li><a href="#" class="${!selectedCategory ? 'active' : ''}" data-category="all">All Products</a></li>`;
    
    categories.forEach(cat => {
        const isActive = selectedCategory && selectedCategory.toLowerCase() === cat.toLowerCase() ? 'active' : '';
        html += `<li><a href="#" class="${isActive}" data-category="${cat}">${cat.charAt(0).toUpperCase() + cat.slice(1)}</a></li>`;
        
        if (isActive) {
            currentFilters.category = cat;
        }
    });
    
    filterSection.innerHTML = html;
    
    // Re-bind click events
    bindCategoryEvents();
}

function bindCategoryEvents() {
    const categoryLinks = document.querySelectorAll('#categoryList a');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            categoryLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            currentFilters.category = this.dataset.category;
            currentPage = 1;
            applyFilters();
        });
    });

    const typeLinks = document.querySelectorAll('#typeList a');
    typeLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            typeLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            currentFilters.type = this.dataset.type;
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
        const res = await fetch(`${auth.apiBaseUrl}/check_auth.php?t=${Date.now()}`, {
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
    cart = JSON.parse(localStorage.getItem('cart')) || [];
    cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    updateCartCount();
}

// Load wishlist items from database (FIXED)
async function loadWishlistItems() {
    if (!auth.currentUser) return;
    
    try {
        const response = await fetch(`${auth.apiBaseUrl}/get_wishlist.php?t=${Date.now()}`, {
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache'
            }
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            // Update user's wishlist with product details
            auth.currentUser.wishlist = data.wishlist.map(item => ({
                id: item.product_id,
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
    // First fetch products
    await fetchProducts();
    
    // Check URL for search parameter
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search');
    
    // Initialize authentication and wishlist
    initializeAuth().then(() => {
        // Apply search filter if present
        if (searchQuery) {
            // we will handle search in applyFilters by adding search to currentFilters
            currentFilters.search = searchQuery.toLowerCase();
        }
        
        // Initialize the page after auth is loaded
        applyFilters();
        
        // The category links are now dynamically bound in populateSidebarCategories()
        // but we can leave this here as a fallback for any hardcoded ones.
        const categoryLinks = document.querySelectorAll('.filter-list a');
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                categoryLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                currentFilters.category = this.dataset.category;
                currentPage = 1;
                applyFilters();
            });
        });
        
        // Apply filters button
        
        // Top filter dropdowns
        const topCategoryFilter = document.getElementById('topCategoryFilter');
        if (topCategoryFilter) {
            topCategoryFilter.addEventListener('change', function() {
                currentFilters.category = this.value;
                // Sync sidebar
                document.querySelectorAll('#categoryList a').forEach(a => {
                    a.classList.toggle('active', a.dataset.category === this.value);
                });
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
                
                // Sync sidebar slider if exists
                const priceRange = document.getElementById('priceRange');
                const maxPriceDisplay = document.getElementById('maxPriceDisplay');
                if (priceRange) {
                    priceRange.value = currentFilters.maxPrice;
                    maxPriceDisplay.textContent = '$' + currentFilters.maxPrice;
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
                // Reset category filter
                categoryLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.dataset.category === 'all') {
                        link.classList.add('active');
                    }
                });
                
                // Reset filters
                currentFilters = {
                    category: 'all',
                    maxPrice: 5000
                };
                
                // Reset price slider
                const priceRange = document.getElementById('priceRange');
                const maxPriceDisplay = document.getElementById('maxPriceDisplay');
                if (priceRange) {
                    priceRange.value = 5000;
                    maxPriceDisplay.textContent = '$5000';
                }
                
                // Reset to first page
                currentPage = 1;
                
                // Apply reset filters
                applyFilters();
            });
        }
        
        
        const typeSelect = document.getElementById('productType');
        if (typeSelect) {
            typeSelect.addEventListener('change', function() {
                currentFilters.type = this.value;
                currentPage = 1;
                applyFilters();
            });
        }
        
        // Sort by selection
        const sortBySelect = document.getElementById('sortBy');
        if (sortBySelect) {
            sortBySelect.addEventListener('change', function() {
                currentSort = this.value;
                applyFilters();
            });
        }
        
        // View options
        const viewButtons = document.querySelectorAll('.view-btn');
        const productGrid = document.querySelector('.product-grid');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all view buttons
                viewButtons.forEach(btn => btn.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Change view mode
                if (this.dataset.view === 'grid') {
                    productGrid.classList.remove('list-view');
                    productGrid.classList.add('grid-view');
                } else {
                    productGrid.classList.remove('grid-view');
                    productGrid.classList.add('list-view');
                }
            });
        });
        
        // Price Filter functionality
        const priceRange = document.getElementById('priceRange');
        const maxPriceDisplay = document.getElementById('maxPriceDisplay');
        if (priceRange) {
            priceRange.addEventListener('input', function() {
                maxPriceDisplay.textContent = '$' + this.value;
                currentFilters.maxPrice = parseFloat(this.value);
                currentPage = 1;
                applyFilters();
            });
        }
        
        // Modal functionality
        const modal = document.getElementById('productModal');
        const closeModal = document.getElementById('closeModal');

        // Close modal when clicking X
        closeModal.addEventListener('click', function() {
            modal.classList.remove('active');
        });

        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });

        // Quantity selector
        const decreaseQty = document.getElementById('decreaseQty');
        const increaseQty = document.getElementById('increaseQty');
        const quantityInput = document.getElementById('productQuantity');

        decreaseQty.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });

        increaseQty.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            quantityInput.value = value + 1;
        });

        // Add to cart from modal
        const addToCartModal = document.getElementById('addToCartModal');
        addToCartModal.addEventListener('click', function() {
            if (!currentModalProduct) return;
            
            if (!auth.currentUser) {
                showAuthAlert();
                return;
            }
            
            const quantity = parseInt(quantityInput.value);
            addToCart(currentModalProduct, quantity, selectedSize, selectedColor);
            modal.classList.remove('active');
        });

        // Add to wishlist from modal
        const addToWishlistModal = document.getElementById('addToWishlistModal');
        addToWishlistModal.addEventListener('click', function() {
            if (!currentModalProduct) return;
            
            if (!auth.currentUser) {
                showAuthAlert();
                return;
            }
            
            toggleWishlist(currentModalProduct.id);
        });
    });
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
function renderProducts(productsToDisplay, append = false) {
    const productGrid = document.getElementById('productGrid');
    
    if (!append) {
        productGrid.innerHTML = '';
        if (productsToDisplay.length === 0) {
            productGrid.innerHTML = '<p class="no-products">No products found matching your criteria.</p>';
            return;
        }
    }
    
    // Render each product
    productsToDisplay.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        productCard.dataset.id = product.id;
        productCard.dataset.category = product.category;
        
        // Check if product is in wishlist
        const isInWishlist = auth.currentUser ? 
            auth.currentUser.wishlist && auth.currentUser.wishlist.some(item => item.id === product.id) : false;
        
        // Generate stars HTML
        const stars = generateStars(product.rating);
        
        // Generate badge if exists
        const badge = product.badge ? `<span class="product-badge ${product.badge}">${product.badge === 'sale' ? 'Sale' : product.badge === 'new' ? 'New' : 'Best Seller'}</span>` : '';
        
        // Generate old price if exists
        const oldPrice = product.oldPrice ? `<span class="old-price">Rs ${product.oldPrice.toFixed(2)}</span>` : '';
        
        // Generate discount if exists
        let discount = '';
        if (product.oldPrice) {
            const discountPercent = Math.round((1 - product.price / product.oldPrice) * 100);
            discount = `<span class="discount">Save ${discountPercent}%</span>`;
        }
        
        productCard.innerHTML = `
            <div class="product-image">
                ${badge}
                <img src="${product.image}" alt="${product.title}">
                <div class="product-actions">
                    <button class="action-btn quick-view"><i class="far fa-eye"></i></button>
                    <button class="action-btn add-to-wishlist"><i class="${isInWishlist ? 'fas' : 'far'} fa-heart"></i></button>
                    <button class="action-btn add-to-cart"><i class="fas fa-shopping-bag"></i></button>
                </div>
            </div>
            <div class="product-info">
                <h3 class="product-title">${product.title}</h3>
                <div class="product-price">
                    <span class="current-price">Rs ${product.price.toFixed(2)}</span>
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
        
        // Add event listeners to the newly created product card
        const quickViewBtn = productCard.querySelector('.quick-view');
        const wishlistBtn = productCard.querySelector('.add-to-wishlist');
        const cartBtn = productCard.querySelector('.add-to-cart');
        
        // Click on product card opens modal
        productCard.addEventListener('click', function(e) {
            if (e.target.closest('.product-actions')) return;
            window.location.href = `product-details.php?id=${product.id}`;
        });
        
        quickViewBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = `product-details.php?id=${product.id}`;
        });
        
        wishlistBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleWishlist(product.id, productCard);
        });
        
        cartBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            addToCart(product);
        });
    });
}

// Show product modal with details
function showProductModal(product) {
    const modal = document.getElementById('productModal');
    currentModalProduct = product;
    selectedSize = null;
    selectedColor = null;
    
    // Check if product is in wishlist
    const isInWishlist = auth.currentUser ? 
        auth.currentUser.wishlist && auth.currentUser.wishlist.some(item => item.id === product.id) : false;
    
    // Set basic product info
    document.getElementById('modalProductTitle').textContent = product.title;
    document.getElementById('modalProductImage').src = product.image;
    document.getElementById('modalProductPrice').textContent = `Rs ${product.price.toFixed(2)}`;
    document.getElementById('modalProductDescription').textContent = product.description;
    document.getElementById('modalProductSKU').textContent = product.sku;
    document.getElementById('modalProductCategory').textContent = product.category;
    
    // Set rating
    document.getElementById('modalProductRating').innerHTML = generateStars(product.rating);
    document.getElementById('modalProductReviews').textContent = `(${product.reviews})`;
    
    // Set price details
    const oldPriceEl = document.getElementById('modalProductOldPrice');
    const discountEl = document.getElementById('modalProductDiscount');
    
    if (product.oldPrice) {
        oldPriceEl.textContent = `Rs ${product.oldPrice.toFixed(2)}`;
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
    product.features.forEach(feature => {
        const li = document.createElement('li');
        li.textContent = feature;
        featuresList.appendChild(li);
    });
    
    // Set size options
    const sizeOptions = document.getElementById('modalSizeOptions');
    sizeOptions.innerHTML = '';
    product.sizes.forEach(size => {
        const btn = document.createElement('button');
        btn.className = 'size-btn';
        btn.textContent = size;
        btn.dataset.size = size;
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.size-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedSize = size;
        });
        sizeOptions.appendChild(btn);
    });
    
    // Set color options
    const colorOptions = document.getElementById('modalColorOptions');
    colorOptions.innerHTML = '';
    product.colors.forEach(color => {
        const btn = document.createElement('button');
        btn.className = 'color-btn';
        btn.dataset.color = color;
        btn.style.backgroundColor = product.colorCodes[color];
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedColor = color;
        });
        colorOptions.appendChild(btn);
    });
    
    // Update wishlist button in modal
    const wishlistBtn = document.getElementById('addToWishlistModal');
    wishlistBtn.innerHTML = isInWishlist ? 
        '<i class="fas fa-heart"></i> Remove from Wishlist' : 
        '<i class="far fa-heart"></i> Add to Wishlist';
    
    // Reset quantity
    document.getElementById('productQuantity').value = 1;
    
    // Update view details link to pass product image
    const viewDetailsLink = document.getElementById('viewDetailsLink');
    if (viewDetailsLink) {
        // Encode the image URL to safely pass it as a parameter
        const encodedImage = encodeURIComponent(product.image);
        viewDetailsLink.href = `product-details.php?id=${product.id}&image=${encodedImage}`;
    }

    // Show modal
    modal.classList.add('active');
}

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

// Wishlist functions for shop page
// Wishlist functions for shop page (FIXED)
async function toggleWishlist(productId, productElement = null) {
    try {
        // Check if user is logged in
        if (!auth.currentUser) {
            showAuthAlert();
            return false;
        }
        
        const response = await fetch(`${auth.apiBaseUrl}/toggle_wishlist.php?t=${Date.now()}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            credentials: 'include',
            headers: {
                'Cache-Control': 'no-cache'
            },
            body: JSON.stringify({
                product_id: productId
            })
        });
        
        // Check if response is OK
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.status === 'success') {
            // Reload wishlist from server to ensure consistency
            await loadWishlistItems();
            
            if (data.action === 'added') {
                showWishlistNotification('Added to wishlist!');
            } else {
                showWishlistNotification('Removed from wishlist!');
            }
            
            // Update heart icon
            if (productElement) {
                const heartIcon = productElement.querySelector('.add-to-wishlist i');
                if (heartIcon) {
                    heartIcon.className = data.action === 'added' ? 'fas fa-heart' : 'far fa-heart';
                }
            }
            
            // Update wishlist button in modal
            const modalWishlistBtn = document.getElementById('addToWishlistModal');
            if (modalWishlistBtn) {
                modalWishlistBtn.innerHTML = data.action === 'added' ?
                    '<i class="fas fa-heart"></i> Remove from Wishlist' :
                    '<i class="far fa-heart"></i> Add to Wishlist';
            }
            
            // Update header wishlist count using our new method
            updateWishlistCount();
            updateHeaderWishlistCount();
            
            return true;
        } else {
            console.error('Error toggling wishlist:', data.message);
            return false;
        }
    } catch (error) {
        console.error('Error toggling wishlist:', error);
        return false;
    }
}

// Add product to cart (FIXED)
function addToCart(product, quantity = 1, size = null, color = null) {
    const cartItem = {
        id: product.id,
        title: product.title,
        price: product.price,
        image: product.image,
        quantity: quantity,
        size: size,
        color: color
    };

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItemIndex = cart.findIndex(item => item.id === cartItem.id && item.size === cartItem.size && item.color === cartItem.color);

    if (existingItemIndex > -1) {
        cart[existingItemIndex].quantity += quantity;
    } else {
        cart.push(cartItem);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showCartNotification(product);
}

// Fallback function for adding to cart in localStorage
function addToCartLocal(product, quantity = 1, size = null, color = null) {
    // Check if product is already in cart with same size and color
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
    
    // Save to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));
    
    // Update cart count
    cartCount = cart.reduce((total, item) => total + item.quantity, 0);
    updateCartCount();
    
    // Show notification
    showCartNotification(product);
}

// Show authentication required alert
function showAuthAlert() {
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

// Update cart count in header
function updateCartCount() {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = cartCount;
        // Add animation to highlight the change
        cartCountElement.classList.add('pulse');
        setTimeout(() => {
            cartCountElement.classList.remove('pulse');
        }, 500);
    }
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
        // Add animation to highlight the change
        wishlistCountElement.classList.add('pulse');
        setTimeout(() => {
            wishlistCountElement.classList.remove('pulse');
        }, 500);
    }
}



// Show cart notification
function showCartNotification(product, appliedDefaults = {}) {
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
function showWishlistNotification(message) {
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
