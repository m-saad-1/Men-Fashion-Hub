import re

with open("d:/xampp/htdocs/fashionhub/public/pages/index.php", "r", encoding="utf-8") as f:
    content = f.read()

# 1. Remove the orphaned HTML
# It starts from `<div class="product-card" data-id="1">` (around line 1466)
# to `<!-- Products injected by JS -->` (around line 1593)
html_start = content.find('<div class="product-card" data-id="1">')
html_end = content.find('<!-- Products injected by JS -->')

if html_start != -1 and html_end != -1:
    content = content[:html_start] + content[html_end + len('<!-- Products injected by JS -->'):]
    print("Orphaned HTML removed.")

# 2. Add fetchFeaturedProducts JS logic
# We need to replace the `const products = [...]` array with the fetch logic and render function.
js_start = content.find('const products = [')
js_end = content.find('let currentModalProduct = null;')

if js_start != -1 and js_end != -1:
    fetch_js = """let products = [];
    
    async function fetchFeaturedProducts() {
        try {
            const response = await fetch('../../app/api/products/get_products.php?limit=8&category=featured');
            const data = await response.json();
            
            if (data.status === 'success') {
                products = data.products.map(p => ({
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
                    description: p.description,
                    features: p.features || [],
                    colorCodes: p.color_codes || {}
                }));
                renderFeaturedProducts();
            }
        } catch (error) {
            console.error('Error fetching featured products:', error);
        }
    }

    function renderFeaturedProducts() {
        const grid = document.getElementById('featuredProductGrid');
        if (!grid) return;
        
        let html = '';
        products.forEach(product => {
            const discountBadge = product.badge === 'sale' && product.oldPrice ? 
                `<span class="product-badge sale">Sale</span>` : 
                (product.badge === 'new' ? `<span class="product-badge new">New</span>` : '');
                
            const oldPriceHtml = product.oldPrice ? 
                `<span class="old-price">$${product.oldPrice.toFixed(2)}</span>
                 <span class="discount">Save ${Math.round((1 - product.price / product.oldPrice) * 100)}%</span>` : '';

            html += `
                <div class="product-card" data-id="${product.id}">
                    <div class="product-image">
                        ${discountBadge}
                        <img src="${product.image}" alt="${product.title}">
                        <div class="product-actions">
                            <button class="action-btn quick-view"><i class="far fa-eye"></i></button>
                            <button class="action-btn add-to-wishlist" data-id="${product.id}"><i class="far fa-heart"></i></button>
                            <button class="action-btn add-to-cart" data-id="${product.id}"><i class="fas fa-shopping-bag"></i></button>
                        </div>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">${product.title}</h3>
                        <div class="product-price">
                            <span class="current-price">$${product.price.toFixed(2)}</span>
                            ${oldPriceHtml}
                        </div>
                        <div class="product-meta">
                            <div class="rating">
                                <div class="stars">${generateStars(product.rating)}</div>
                                <span class="review-count">(${product.reviews})</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        grid.innerHTML = html;
        bindProductEvents();
    }
    
    function bindProductEvents() {
        document.querySelectorAll('.product-card').forEach(card => {
            // Click on product card opens details
            card.addEventListener('click', function(e) {
                if (e.target.closest('.product-actions')) return;
                const productId = parseInt(card.dataset.id);
                window.location.href = `product-details.php?id=${productId}`;
            });

            // Quick view button
            card.querySelector('.quick-view').addEventListener('click', function(e) {
                e.stopPropagation();
                const productId = parseInt(card.dataset.id);
                const product = products.find(p => p.id === productId);
                if (product) showProductModal(product);
            });

            // Wishlist button
            card.querySelector('.add-to-wishlist').addEventListener('click', function(e) {
                e.stopPropagation();
                const productId = parseInt(card.dataset.id);
                const product = products.find(p => p.id === productId);
                if (product) toggleWishlist(card, product);
            });

            // Add to cart button
            card.querySelector('.add-to-cart').addEventListener('click', function(e) {
                e.stopPropagation();
                const productId = parseInt(card.dataset.id);
                const product = products.find(p => p.id === productId);
                if (product) addToCart(product);
            });
        });
    }

    """
    
    content = content[:js_start] + fetch_js + content[js_end:]
    print("JS updated.")

# 3. Add call to fetchFeaturedProducts in DOMContentLoaded
dom_loaded = content.find("document.addEventListener('DOMContentLoaded', function() {")
if dom_loaded != -1:
    insert_pos = dom_loaded + len("document.addEventListener('DOMContentLoaded', function() {")
    content = content[:insert_pos] + "\n        fetchFeaturedProducts();" + content[insert_pos:]
    print("DOMContentLoaded updated.")

# 4. Remove the old event listeners binding at DOMContentLoaded since we now do it dynamically
old_bind_start = content.find("// Add event listeners to all product cards")
old_bind_end = content.find("// Add to cart from modal")
if old_bind_start != -1 and old_bind_end != -1:
    content = content[:old_bind_start] + content[old_bind_end:]
    print("Old event bindings removed.")

with open("d:/xampp/htdocs/fashionhub/public/pages/index.php", "w", encoding="utf-8") as f:
    f.write(content)
print("index.php modification complete.")
