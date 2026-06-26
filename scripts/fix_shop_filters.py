import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Update currentFilters definition
filters_match = re.search(r'let currentFilters = \{.*?\};', content, re.DOTALL)
if filters_match:
    new_filters = """let currentFilters = {
    category: 'all',
    type: 'all',
    minPrice: 0,
    maxPrice: 5000,
    sort: 'featured'
};"""
    content = content[:filters_match.start()] + new_filters + content[filters_match.end():]
    print("Updated currentFilters")

# 2. Update fetchProducts URL
fetch_url_old = "const url = `${API_BASE}/get_products.php?page=${currentPage}&limit=12&category=${encodeURIComponent(category)}&search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}`;"
fetch_url_new = "const url = `${API_BASE}/get_products.php?page=${currentPage}&limit=12&category=${encodeURIComponent(category)}&search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}&min_price=${currentFilters.minPrice}&max_price=${currentFilters.maxPrice}&sort=${currentFilters.sort}`;"
if fetch_url_old in content:
    content = content.replace(fetch_url_old, fetch_url_new)
    print("Updated fetchProducts URL")

# 3. Update top filter event listeners in DOMContentLoaded
# Find where the applyFiltersBtn is attached, and add logic for the new dropdowns
apply_filters_btn = "const applyFiltersBtn = document.querySelector('.apply-filters');"
if apply_filters_btn in content:
    top_filters_js = """
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

        const topTypeFilter = document.getElementById('topTypeFilter');
        if (topTypeFilter) {
            topTypeFilter.addEventListener('change', function() {
                currentFilters.type = this.value;
                // Sync sidebar
                document.querySelectorAll('#typeList a').forEach(a => {
                    a.classList.toggle('active', a.dataset.type === this.value);
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
                    currentFilters.maxPrice = 5000;
                } else if (this.value === '200+') {
                    currentFilters.minPrice = 200;
                    currentFilters.maxPrice = 5000;
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

        const applyFiltersBtn = document.querySelector('.apply-filters');"""
    
    content = content.replace(apply_filters_btn, top_filters_js)
    print("Added top filter JS")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("shop.php modified successfully.")
