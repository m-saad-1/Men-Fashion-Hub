import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# 1. Replace populateSidebarCategories block
old_populate_block = """// Dynamically populate sidebar categories based on fetched products
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
}"""

new_populate_block = """const categoryMap = {
    'tops': ['Shirts', 'T-Shirts', 'Polos', 'Hoodies', 'Jackets', 'Dresses', 'Tops'],
    'bottoms': ['Jeans', 'Pants', 'Shorts', 'Skirts', 'Joggers', 'Trousers'],
    'footwear': ['Shoes', 'Sneakers', 'Boots', 'Footwear', 'Sandals'],
    'accessories': ['Accessories', 'Bags', 'Wallets', 'Belts', 'Caps', 'Watches', 'Sunglasses'],
    'all': []
};

function updateCategoryDropdown(selectedType) {
    const topCategoryFilter = document.getElementById('topCategoryFilter');
    if (!topCategoryFilter) return;
    
    let optionsHtml = '<option value="all">All Categories</option>';
    
    if (selectedType === 'all') {
        // Collect all unique
        let allCats = [];
        Object.values(categoryMap).forEach(arr => allCats.push(...arr));
        allCats = [...new Set(allCats)].sort();
        allCats.forEach(cat => {
            optionsHtml += `<option value="${cat.toLowerCase()}">${cat}</option>`;
        });
    } else {
        const cats = categoryMap[selectedType.toLowerCase()] || [];
        cats.forEach(cat => {
            optionsHtml += `<option value="${cat.toLowerCase()}">${cat}</option>`;
        });
    }
    
    topCategoryFilter.innerHTML = optionsHtml;
    // ensure current category is selected if it's still valid, else reset to all
    let validCategory = Array.from(topCategoryFilter.options).some(opt => opt.value === currentFilters.category);
    if (!validCategory) {
        currentFilters.category = 'all';
    }
    topCategoryFilter.value = currentFilters.category;
}"""

content = content.replace(old_populate_block, new_populate_block)

# 2. Remove populateSidebarCategories() call inside fetchProducts
content = content.replace("""            // Re-populate category sidebar dynamically based on loaded products
            if (!append) {
                populateSidebarCategories();
            }""", "")

# 3. Add updateCategoryDropdown call in topTypeFilter/typeList change
# Wait, typeList is the sidebar! Let's update typeList click handler.
old_type_click = """        const typeLinks = document.querySelectorAll('#typeList a');
        typeLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                typeLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                currentFilters.type = this.dataset.type;
                currentPage = 1;
                applyFilters();
            });
        });"""

new_type_click = """        const typeLinks = document.querySelectorAll('#typeList a');
        typeLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                typeLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                currentFilters.type = this.dataset.type;
                updateCategoryDropdown(currentFilters.type);
                currentPage = 1;
                applyFilters();
            });
        });
        // Initial setup
        updateCategoryDropdown(currentFilters.type);"""

content = content.replace(old_type_click, new_type_click)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated category filters!")
