import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Add #searchIndicatorContainer before #productGrid
old_grid = '<div class="product-grid" id="productGrid">'
new_grid = '<div id="searchIndicatorContainer"></div>\n                    <div class="product-grid" id="productGrid">'
if old_grid in content:
    content = content.replace(old_grid, new_grid)

# 2. Add logic in fetchProducts to show/hide the indicator
old_fetch = """        const search = currentFilters.search || urlParams.get('search') || '';
        const category = currentFilters.category !== 'all' ? currentFilters.category : (urlParams.get('category') || '');"""
        
new_fetch = """        const search = currentFilters.search || urlParams.get('search') || '';
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
        }"""
if old_fetch in content:
    content = content.replace(old_fetch, new_fetch)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated shop search indicator!")
