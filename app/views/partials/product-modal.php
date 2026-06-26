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
          <span class="modal-price" id="modalProductPrice">$59.99</span>
          <span class="modal-old-price" id="modalProductOldPrice"></span>
          <span class="modal-discount" id="modalProductDiscount"></span>
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
      <span class="modal-sku">SKU: <span id="modalProductSKU">FH-001</span></span>
      <a href="#" id="viewDetailsLink" class="btn btn-text" style="margin-left: auto; margin-right: 20px;">View Full Details</a>
      <span class="modal-category">Category: <span id="modalProductCategory">Shirts</span></span>
    </div>
  </div>
</div>