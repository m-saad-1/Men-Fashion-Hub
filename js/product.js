// Product data with complete details for modal
const products = [
  {
    id: 1,
    title: "Premium Denim Jacket",
    brand: "UNITED",
    price: 99.99,
    originalPrice: 129.99,
    image: "https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1065&q=80",
    badge: "new",
    rating: 4.5,
    reviews: 24,
    description: "This premium denim jacket features a classic fit with modern details. Made from 100% cotton denim with a medium wash for a timeless look.",
    features: [
      "100% Cotton denim",
      "Medium wash",
      "Classic fit",
      "Metal buttons",
      "Machine washable"
    ],
    sizes: ["S", "M", "L", "XL"],
    colors: ["Blue", "Black"],
    sku: "DJ-001",
    category: "Jackets"
  },
  // ... other products
];

// Global variables
let currentModalProduct = null;
let selectedSize = null;
let selectedColor = null;
let cart = [];
let wishlist = [];

// Load products into the grid
export function loadProducts(containerId = 'featured-products-grid') {
  const productsGrid = document.getElementById(containerId);
  if (!productsGrid) return;
  
  productsGrid.innerHTML = '';
  
  products.forEach(product => {
    const discount = product.originalPrice ? 
      Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100) : 0;
    
    const stars = Array(Math.floor(product.rating)).fill('<i class="fas fa-star"></i>').join('') + 
      (product.rating % 1 >= 0.5 ? '<i class="fas fa-star-half-alt"></i>' : '');
    
    const productCard = document.createElement('div');
    productCard.className = 'product-card';
    productCard.innerHTML = `
      ${product.badge ? `<span class="product-badge">${product.badge}</span>` : ''}
      <div class="product-image">
        <img src="${product.image}" alt="${product.title}">
      </div>
      <div class="product-info">
        <h3 class="product-title">${product.title}</h3>
        <div class="product-price">
          <span class="current-price">$${product.price.toFixed(2)}</span>
          ${product.originalPrice ? `<span class="old-price">$${product.originalPrice.toFixed(2)}</span>` : ''}
          ${discount > 0 ? `<span class="discount">${discount}% OFF</span>` : ''}
        </div>
        <div class="product-meta">
          <div class="rating">
            <div class="stars">${stars}</div>
            <span>(${product.reviews})</span>
          </div>
        </div>
      </div>
      <div class="product-actions">
        <button class="action-btn quick-view" title="Quick View">
          <i class="far fa-eye"></i>
        </button>
        <button class="action-btn add-to-wishlist" title="Add to Wishlist">
          <i class="far fa-heart"></i>
        </button>
        <button class="action-btn add-to-cart" title="Add to Cart">
          <i class="fas fa-shopping-cart"></i>
        </button>
      </div>
    `;
    
    productsGrid.appendChild(productCard);
    
    // Add event listeners
    const quickViewBtn = productCard.querySelector('.quick-view');
    const wishlistBtn = productCard.querySelector('.add-to-wishlist');
    const cartBtn = productCard.querySelector('.add-to-cart');
    
    // Click on product card opens modal
    productCard.addEventListener('click', function(e) {
      if (e.target.closest('.product-actions')) return;
      showProductModal(product);
    });
    
    quickViewBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      showProductModal(product);
    });
    
    wishlistBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleWishlist(product.id);
    });
    
    cartBtn.addEventListener('click', function(e) {
      e.stopPropagation();
      addToCart(product.id);
    });
  });
}

// Show product modal with details
export function showProductModal(product) {
  currentModalProduct = product;
  selectedSize = null;
  selectedColor = null;
  
  // Update modal content
  document.getElementById('modalProductTitle').textContent = product.title;
  document.getElementById('modalProductImage').src = product.image;
  document.getElementById('modalProductImage').alt = product.title;
  document.getElementById('modalProductPrice').textContent = `$${product.price.toFixed(2)}`;
  
  const oldPriceEl = document.getElementById('modalProductOldPrice');
  const discountEl = document.getElementById('modalProductDiscount');
  
  if (product.originalPrice) {
    const discount = Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100);
    oldPriceEl.textContent = `$${product.originalPrice.toFixed(2)}`;
    discountEl.textContent = `${discount}% OFF`;
  } else {
    oldPriceEl.textContent = '';
    discountEl.textContent = '';
  }
  
  const stars = Array(Math.floor(product.rating)).fill('<i class="fas fa-star"></i>').join('') + 
    (product.rating % 1 >= 0.5 ? '<i class="fas fa-star-half-alt"></i>' : '');
  document.getElementById('modalProductRating').innerHTML = stars;
  document.getElementById('modalProductReviews').textContent = `(${product.reviews} reviews)`;
  document.getElementById('modalProductDescription').textContent = product.description;
  
  // Update features list
  const featuresList = document.getElementById('modalProductFeatures');
  featuresList.innerHTML = '';
  product.features.forEach(feature => {
    const li = document.createElement('li');
    li.textContent = feature;
    featuresList.appendChild(li);
  });
  
  // Update size options
  const sizeOptions = document.getElementById('modalSizeOptions');
  sizeOptions.innerHTML = '';
  product.sizes.forEach(size => {
    const sizeBtn = document.createElement('button');
    sizeBtn.className = 'size-btn';
    sizeBtn.textContent = size;
    sizeBtn.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
      this.classList.add('selected');
      selectedSize = size;
    });
    sizeOptions.appendChild(sizeBtn);
  });
  
  // Update color options
  const colorOptions = document.getElementById('modalColorOptions');
  colorOptions.innerHTML = '';
  product.colors.forEach(color => {
    const colorBtn = document.createElement('button');
    colorBtn.className = 'color-btn';
    colorBtn.style.backgroundColor = getColorValue(color);
    colorBtn.title = color;
    colorBtn.addEventListener('click', function(e) {
      e.preventDefault();
      document.querySelectorAll('.color-btn').forEach(btn => btn.classList.remove('selected'));
      this.classList.add('selected');
      selectedColor = color;
    });
    colorOptions.appendChild(colorBtn);
  });
  
  // Update SKU and category
  document.getElementById('modalProductSKU').textContent = product.sku;
  document.getElementById('modalProductCategory').textContent = product.category;
  
  // Update wishlist button state
  updateWishlistButton();
  
  // Reset quantity
  document.getElementById('productQuantity').value = 1;
  
  // Show modal
  document.getElementById('productModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

// Helper function to get color values
function getColorValue(color) {
  const colors = {
    'Blue': '#3498db',
    'Black': '#2c3e50',
    'White': '#ecf0f1',
    'Ivory': '#fffff0',
    'Dark Blue': '#1a237e',
    'Brown': '#795548',
    'Red': '#e53935',
    'Green': '#43a047',
    'Yellow': '#fdd835'
  };
  return colors[color] || color;
}

// Update wishlist button state
function updateWishlistButton() {
  if (!currentModalProduct) return;
  
  const isInWishlist = wishlist.includes(currentModalProduct.id);
  const icon = isInWishlist ? 'fas' : 'far';
  
  document.getElementById('addToWishlistModal').innerHTML = `
    <i class="${icon} fa-heart"></i> ${isInWishlist ? 'Remove from' : 'Add to'} Wishlist
  `;
}

// Toggle wishlist status
function toggleWishlist(productId) {
  const index = wishlist.indexOf(productId);
  
  if (index >= 0) {
    wishlist.splice(index, 1);
  } else {
    wishlist.push(productId);
  }
  
  updateWishlistButton();
  
  document.querySelectorAll(`.add-to-wishlist[data-id="${productId}"] i`).forEach(icon => {
    icon.classList.toggle('far');
    icon.classList.toggle('fas');
  });
}

// Add product to cart
function addToCart(productId, quantity = 1) {
  const product = products.find(p => p.id === productId);
  if (!product) return;
  
  const existingItemIndex = cart.findIndex(item => 
    item.id === product.id && 
    item.size === selectedSize && 
    item.color === selectedColor
  );
  
  if (existingItemIndex >= 0) {
    cart[existingItemIndex].quantity += quantity;
  } else {
    cart.push({
      id: product.id,
      title: product.title,
      price: product.price,
      image: product.image,
      size: selectedSize,
      color: selectedColor,
      quantity: quantity
    });
  }
  
  showCartNotification(product);
}

// Show cart notification
function showCartNotification(product) {
  const notification = document.createElement('div');
  notification.className = 'cart-notification';
  notification.innerHTML = `
    <p>${product.title} added to cart!</p>
    <a href="cart.html">View Cart</a>
  `;
  document.body.appendChild(notification);
  
  setTimeout(() => notification.classList.add('show'), 10);
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// Initialize product system
export function initProductSystem() {
  const modal = document.getElementById('productModal');
  if (!modal) return;
  
  // Modal functionality
  document.getElementById('closeModal').addEventListener('click', function() {
    modal.classList.remove('active');
    document.body.style.overflow = '';
  });
  
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
  
  // Quantity selector
  document.getElementById('decreaseQty').addEventListener('click', function() {
    const quantityInput = document.getElementById('productQuantity');
    let value = parseInt(quantityInput.value);
    if (value > 1) quantityInput.value = value - 1;
  });
  
  document.getElementById('increaseQty').addEventListener('click', function() {
    const quantityInput = document.getElementById('productQuantity');
    let value = parseInt(quantityInput.value);
    quantityInput.value = value + 1;
  });
  
  // Add to cart from modal
  document.getElementById('addToCartModal').addEventListener('click', function() {
    if (!currentModalProduct) return;
    const quantity = parseInt(document.getElementById('productQuantity').value);
    addToCart(currentModalProduct.id, quantity);
    modal.classList.remove('active');
    document.body.style.overflow = '';
  });
  
  // Add to wishlist from modal
  document.getElementById('addToWishlistModal').addEventListener('click', function() {
    if (!currentModalProduct) return;
    toggleWishlist(currentModalProduct.id);
  });
}