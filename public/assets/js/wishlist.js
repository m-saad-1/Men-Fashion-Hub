
// Listen for the custom event
window.addEventListener('wishlistUpdated', function() {
    updateWishlistCount();
});

// Function to fetch wishlist count and update the UI
async function updateWishlistCount() {
    try {
        const response = await fetch('../../app/api/wishlist/get_wishlist_count.php');
        if (!response.ok) {
            throw new Error('Failed to fetch wishlist count');
        }
        const data = await response.json();
        if (data.status === 'success') {
            const wishlistCountElement = document.querySelector('.wishlist-count');
            if (wishlistCountElement) {
                wishlistCountElement.textContent = data.count;
            }
        }
    } catch (error) {
        console.error('Error updating wishlist count:', error);
    }
}

// Initial update on page load
document.addEventListener('DOMContentLoaded', function() {
    updateWishlistCount();
});
