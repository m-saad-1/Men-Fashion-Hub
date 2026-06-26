import re

file_path = "d:/xampp/htdocs/fashionhub/public/pages/shop.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace the DOMContentLoaded block to properly sync URL params with UI and filters
old_dom_block = """document.addEventListener('DOMContentLoaded', async function() {
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
        applyFilters();"""

new_dom_block = """document.addEventListener('DOMContentLoaded', async function() {
    // Check URL params
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('search');
    const urlType = urlParams.get('type');
    const urlCategory = urlParams.get('category');
    
    if (searchQuery) currentFilters.search = searchQuery.toLowerCase();
    if (urlType) currentFilters.type = urlType;
    if (urlCategory) currentFilters.category = urlCategory;
    
    // Sync typeList sidebar
    if (currentFilters.type !== 'all') {
        const typeLinks = document.querySelectorAll('#typeList a');
        typeLinks.forEach(l => l.classList.remove('active'));
        const activeLink = document.querySelector(`#typeList a[data-type="${currentFilters.type}"]`);
        if (activeLink) activeLink.classList.add('active');
    }
    
    // Setup category dropdown based on type
    updateCategoryDropdown(currentFilters.type);
    
    // First fetch products
    await fetchProducts();
    
    // Initialize authentication and wishlist
    initializeAuth().then(() => {
        // Initialize the page after auth is loaded
        applyFilters();"""

if old_dom_block in content:
    content = content.replace(old_dom_block, new_dom_block)
else:
    print("Could not find the block to replace!")

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated URL param sync!")
