<?php
require_once '../../app/config/config.php';

// Get product ID from URL
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$productImage = isset($_GET['image']) ? urldecode($_GET['image']) : null;

// If product not found, redirect to shop
if ($productId === 0) {
    header("Location: shop.php");
    exit;
}

try {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        header("Location: shop.php");
        exit;
    }
    
    $product = $result->fetch_assoc();
    
    // Decode JSON fields
    $product['features'] = json_decode($product['features'], true) ?: [];
    $product['sizes'] = json_decode($product['sizes'], true) ?: [];
    $product['colors'] = json_decode($product['colors'], true) ?: [];
    $product['colorCodes'] = json_decode($product['color_codes'], true) ?: [];
    
    // If an image was passed from shop.php, use it instead of the default
    if ($productImage) {
        $product['image'] = $productImage;
    }
    
    $productReviews = []; // TODO: Fetch real reviews if they exist in DB
    
    // Get related products
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4");
    $stmt->bind_param("si", $product['category'], $productId);
    $stmt->execute();
    $relatedResult = $stmt->get_result();
    $relatedProducts = [];
    while ($row = $relatedResult->fetch_assoc()) {
        $row['features'] = json_decode($row['features'], true) ?: [];
        $row['sizes'] = json_decode($row['sizes'], true) ?: [];
        $row['colors'] = json_decode($row['colors'], true) ?: [];
        $row['colorCodes'] = json_decode($row['color_codes'], true) ?: [];
        $relatedProducts[] = $row;
    }
    
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - <?php echo htmlspecialchars($product['title']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
      <link rel="stylesheet" href="../assets/css/header-footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            border: 1px solid #eee;
            border-radius: 5px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .product-card a {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-image {
            width: 100%;
            padding-top: 100%; /* 1:1 Aspect Ratio */
            position: relative;
        }
        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .product-card .product-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .product-card .product-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .product-card .product-price {
            margin-top: auto;
        }
        .accordion-content {
            display: none;
            padding: 15px;
            border-top: 1px solid #eee;
        }
        .accordion-item.active .accordion-content {
            display: block;
        }
        .accordion-header i {
            transition: transform 0.3s ease;
        }
        .accordion-item.active .accordion-header i {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <!-- Header -->
<?php include '../../app/views/partials/header.php'; ?>


<main class="product-page">
    <div class="container">
        <div class="breadcrumbs">
            <a href="index.php">Home</a> /
            <a href="shop.php">Shop</a> /
            <a href="shop.php?category=<?php echo htmlspecialchars($product['category']); ?>"><?php echo htmlspecialchars(ucfirst($product['category'])); ?></a> /
            <span><?php echo htmlspecialchars($product['title']); ?></span>
        </div>
        
        <div class="product-details" style="margin-top: 40px;">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="gallery-main" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" id="mainProductImage" fetchpriority="high" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product['title']); ?></h1>
                <div class="product-meta">
                    <div class="rating">
                        <div class="stars">
                            <?php for ($i = 0; $i < 5; $i++):
                                // Determine the star icon based on the product rating
                                $starClass = 'far fa-star'; // Default to empty star
                                if ($i < floor($product['rating'])) {
                                    $starClass = 'fas fa-star'; // Full star
                                } elseif ($i < $product['rating']) {
                                    $starClass = 'fas fa-star-half-alt'; // Half star
                                }
                            ?>
                                <i class="<?php echo $starClass; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <a href="#reviews" class="review-count"><?php echo count($productReviews); ?> reviews</a>
                    </div>
                    <div class="sku">SKU: <?php echo htmlspecialchars($product['sku']); ?></div>
                </div>
                
                <div class="product-price">
                    <span class="current-price">$<?php echo htmlspecialchars($product['price']); ?></span>
                    <?php if (isset($product['old_price']) && $product['old_price'] > 0): 
                        // Display old price if it exists
                    ?>
                        <span class="old-price">$<?php echo htmlspecialchars($product['old_price']); ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="product-description">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    
                    <div class="details-accordion">
                        <div class="accordion-item active">
                            <button class="accordion-header">Fabric &amp; Care <i class="fas fa-chevron-down"></i></button>
                            <div class="accordion-content">
                                <ul>
                                    <?php foreach ($product['features'] as $feature):
                                        // Display each feature in a list item
                                    ?>
                                        <li><?php echo htmlspecialchars($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">Size &amp; Fit <i class="fas fa-chevron-down"></i></button>
                            <div class="accordion-content">
                                <p>Regular fit. Model is 6'2" wearing size Medium.</p>
                                <a href="#" class="size-guide-link">View Size Guide</a>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <button class="accordion-header">Shipping &amp; Returns <i class="fas fa-chevron-down"></i></button>
                            <div class="accordion-content">
                                <p>Free shipping on orders over $50. Easy 30-day returns.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="product-actions">
                    <div class="size-selector">
                        <label>Size:</label>
                        <div class="size-options">
                            <?php foreach ($product['sizes'] as $size):
                                // Display each available size
                            ?>
                                <button class="size-option"><?php echo htmlspecialchars($size); ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="color-selector">
                        <label>Color:</label>
                        <div class="color-options">
                            <?php foreach ($product['colors'] as $color):
                                // Display color swatch
                            ?>
                                <button class="color-option" style="background-color: <?php echo htmlspecialchars($product['colorCodes'][$color]); ?>;" data-color="<?php echo htmlspecialchars($color); ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="qty-input">
                            <button class="qty-btn minus"><i class="fas fa-minus"></i></button>
                            <input type="number" value="1" min="1">
                            <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="btn btn-primary add-to-cart">Add to Cart</button>
                        <button class="btn btn-outline add-to-wishlist"><i class="far fa-heart"></i></button>
                    </div>
                </div>
                
                <div class="product-share">
                    <span>Share:</span>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
        
        <!-- Product Tabs -->
        <div class="product-tabs">
            <ul class="tab-nav">
                <li class="active" data-tab="description">Description</li>
                <li data-tab="reviews">Reviews (<?php echo count($productReviews); ?>)</li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="description">
                    <h3>Product Description</h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <ul>
                        <?php foreach ($product['features'] as $feature):
                            // Display each feature in a list item
                        ?>
                            <li><?php echo htmlspecialchars($feature); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="tab-pane" id="reviews">
                    <div class="review-list">
                        <h3>Customer Reviews</h3>
                        <?php if (count($productReviews) > 0):
                            // Display reviews if available
                        ?>
                            <?php foreach ($productReviews as $review):
                                // Determine the star class for each review rating
                                $ratingStars = '';
                                for ($i = 0; $i < 5; $i++) {
                                    $ratingStars .= '<i class="' . ($i < $review['rating'] ? 'fas' : 'far') . ' fa-star"></i>';
                                }
                            ?>
                                <div class="review">
                                    <div class="review-header">
                                        <div class="review-author"><?php echo htmlspecialchars($review['author']); ?></div>
                                        <div class="review-rating">
                                            <?php echo $ratingStars; ?>
                                        </div>
                                        <div class="review-date"><?php echo htmlspecialchars($review['date']); ?></div>
                                    </div>
                                    <div class="review-title"><?php echo htmlspecialchars($review['title']); ?></div>
                                    <div class="review-content">
                                        <p><?php echo htmlspecialchars($review['content']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else:
                            // Message if no reviews are available
                        ?>
                            <p>No reviews yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Related Products -->
        <section class="related-products">
            <h2 class="section-title">You May Also Like</h2>
            <div class="product-grid">
                <?php foreach ($relatedProducts as $relatedProduct):
                    // Display each related product card
                ?>
                    <div class="product-card">
                        <a href="product-details.php?id=<?php echo $relatedProduct['id']; ?>&image=<?php echo urlencode($relatedProduct['image']); ?>">
                            <?php if (isset($relatedProduct['badge']) && $relatedProduct['badge']): ?>
                                <div class="product-badge badge <?php echo htmlspecialchars($relatedProduct['badge']); ?>">
                                    <?php echo ucfirst(htmlspecialchars($relatedProduct['badge'])); ?>
                                </div>
                            <?php endif; ?>
                            <div class="product-image" style="position: relative;">
                                <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                                <img src="<?php echo htmlspecialchars($relatedProduct['image']); ?>" alt="<?php echo htmlspecialchars($relatedProduct['title']); ?>" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:absolute; z-index:2;">
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo htmlspecialchars($relatedProduct['title']); ?></h3>
                                <div class="product-meta">
                                    <div class="rating">
                                        <div class="stars">
                                            <?php for ($i = 0; $i < 5; $i++):
                                                $starClass = 'far fa-star';
                                                if ($i < floor($relatedProduct['rating'])) {
                                                    $starClass = 'fas fa-star';
                                                } elseif ($i < $relatedProduct['rating']) {
                                                    $starClass = 'fas fa-star-half-alt';
                                                }
                                            ?>
                                                <i class="<?php echo $starClass; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <span class="current-price">$<?php echo htmlspecialchars($relatedProduct['price']); ?></span>
                                    <?php if (isset($relatedProduct['old_price']) && $relatedProduct['old_price'] > 0): ?>
                                        <span class="old-price">$<?php echo htmlspecialchars($relatedProduct['old_price']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>


    <!-- Footer -->
<?php include '../../app/views/partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabNavItems = document.querySelectorAll('.tab-nav li');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabNavItems.forEach(item => {
            item.addEventListener('click', function() {
                tabNavItems.forEach(i => i.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));

                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        // Accordion functionality
        const accordionHeaders = document.querySelectorAll('.accordion-header');
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                this.parentElement.classList.toggle('active');
            });
        });

        // Quantity selector
        const minusBtn = document.querySelector('.qty-btn.minus');
        const plusBtn = document.querySelector('.qty-btn.plus');
        const qtyInput = document.querySelector('.qty-input input');

        minusBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            if (value > 1) {
                qtyInput.value = value - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            let value = parseInt(qtyInput.value);
            qtyInput.value = value + 1;
        });

        // Add to cart functionality
        const addToCartBtn = document.querySelector('.add-to-cart');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', async function() {
                const quantity = parseInt(qtyInput.value) || 1;
                // Get selected size and color if available
                const activeSizeBtn = document.querySelector('.size-option.active');
                const activeColorBtn = document.querySelector('.color-option.active');
                const size = activeSizeBtn ? activeSizeBtn.textContent : null;
                const color = activeColorBtn ? activeColorBtn.dataset.color : null;
                
                const productId = <?php echo $product['id']; ?>;
                const product = {
                    id: productId,
                    title: "<?php echo addslashes($product['title']); ?>",
                    price: <?php echo $product['price']; ?>,
                    image: "<?php echo addslashes($product['image']); ?>"
                };

                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                this.disabled = true;

                if (auth.currentUser) {
                    try {
                        const response = await fetch(`${auth.apiBaseUrl}/cart/add_to_cart.php`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            credentials: 'include',
                            body: JSON.stringify({ product_id: product.id, quantity, size, color })
                        });
                        const data = await response.json();
                        if (data.status === 'success') {
                            // Fetch updated cart
                            const getResponse = await fetch(`${auth.apiBaseUrl}/cart/get_cart.php`);
                            const getData = await getResponse.json();
                            if (getData.status === 'success') {
                                const cartData = getData.cart.map(item => ({
                                    id: parseInt(item.product_id),
                                    title: item.title,
                                    price: parseFloat(item.price),
                                    image: item.image,
                                    quantity: parseInt(item.quantity),
                                    size: item.size,
                                    color: item.color
                                }));
                                localStorage.setItem('cart', JSON.stringify(cartData));
                                updateCartCount();
                                alert('Product added to cart successfully!');
                            }
                        } else {
                            alert('Failed to add to cart: ' + data.message);
                        }
                    } catch (err) {
                        console.error('Error:', err);
                    }
                } else {
                    let cart = JSON.parse(localStorage.getItem('cart')) || [];
                    const existingItemIndex = cart.findIndex(item => item.id === product.id && item.size === size && item.color === color);
                    if (existingItemIndex >= 0) {
                        cart[existingItemIndex].quantity += quantity;
                    } else {
                        cart.push({ ...product, quantity, size, color });
                    }
                    localStorage.setItem('cart', JSON.stringify(cart));
                    updateCartCount();
                    alert('Product added to cart successfully!');
                }

                this.innerHTML = '<i class="fas fa-check"></i> Added';
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 2000);
            });
        }

        // Add to wishlist functionality
        const addToWishlistBtn = document.querySelector('.add-to-wishlist');
        if (addToWishlistBtn) {
            addToWishlistBtn.addEventListener('click', async function() {
                if (!auth.currentUser) {
                    alert('Please login to add to wishlist');
                    return;
                }
                const productId = <?php echo $product['id']; ?>;
                const icon = this.querySelector('i');
                
                try {
                    const response = await fetch(`${auth.apiBaseUrl}/wishlist/toggle_wishlist.php`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        credentials: 'include',
                        body: JSON.stringify({ product_id: productId })
                    });
                    const data = await response.json();
                    if (data.status === 'success') {
                        if (data.action === 'added') {
                            icon.className = 'fas fa-heart';
                        } else {
                            icon.className = 'far fa-heart';
                        }
                        
                        const getResponse = await fetch(`${auth.apiBaseUrl}/wishlist/get_wishlist.php`);
                        const getData = await getResponse.json();
                        if (getData.status === 'success') {
                            auth.currentUser.wishlist = getData.wishlist.map(item => ({
                                id: parseInt(item.product_id),
                                title: item.title,
                                price: parseFloat(item.price),
                                image: item.image
                            }));
                            localStorage.setItem('currentUser', JSON.stringify(auth.currentUser));
                            updateWishlistCount();
                        }
                    }
                } catch (e) {
                    console.error('Error toggling wishlist', e);
                }
            });
            
            // Set initial wishlist state
            if (auth.currentUser && auth.currentUser.wishlist) {
                const isWishlisted = auth.currentUser.wishlist.some(item => item.id === <?php echo $product['id']; ?>);
                if (isWishlisted) {
                    addToWishlistBtn.querySelector('i').className = 'fas fa-heart';
                }
            }
        }

        // Handle size/color selection
        document.querySelectorAll('.size-option').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        document.querySelectorAll('.color-option').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.color-option').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>

</body>
</html>