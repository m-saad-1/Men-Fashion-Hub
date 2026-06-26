// public/assets/js/header.js

document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    updateWishlistCount();
    
    // Elements
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    const megaMenuTrigger = document.querySelector('.mega-menu-trigger');
    const megaMenuLink = document.querySelector('.mega-menu-link');
    const megaMenu = document.querySelector('.mega-menu');

    // Mobile menu toggle
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');

            // Change icon based on state
            const icon = this.querySelector('i');
            if (mainNav.classList.contains('active')) {
                icon.className = 'fas fa-times';
            } else {
                icon.className = 'fas fa-bars';
            }
        });
    }

    // Mega menu toggle for mobile
    if (megaMenuLink && megaMenu) {
        megaMenuLink.addEventListener('click', function(e) {
            if (window.innerWidth > 992) return; // Prevent click on desktop, use hover
            e.preventDefault();
            const willOpen = !megaMenu.classList.contains('open');
            megaMenu.classList.toggle('open');
            megaMenuLink.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            if (!willOpen) {
                megaMenuLink.blur();
            }
        });
    }

    if (megaMenu) {
        megaMenu.addEventListener('wheel', function(event) {
            // Prevent the scroll from bubbling up and closing the dropdown
            event.stopPropagation();
        });
    }

    // Close mega menu when clicking on category links
    const megaMenuLinks = document.querySelectorAll('.mega-menu a');
    megaMenuLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (megaMenu) megaMenu.classList.remove('open');
            if (mainNav) mainNav.classList.remove('active');
            if (megaMenuLink) megaMenuLink.blur();
        });
    });

    // Close mega menu when clicking outside of it
    document.addEventListener('click', function(e) {
        if (megaMenu && megaMenuTrigger && !megaMenuTrigger.contains(e.target)) {
            megaMenu.classList.remove('open');
            if (megaMenuLink) megaMenuLink.blur();
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (megaMenu) megaMenu.classList.remove('open');
            if (mainNav) mainNav.classList.remove('active');
            if (megaMenuLink) megaMenuLink.blur();
        }
    });

    // Reset state on resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            if (megaMenu) megaMenu.classList.remove('open');
            if (megaMenuLink) megaMenuLink.blur();
        }
    });

    // Mega menu hover logic for detached menu
    const menu = document.getElementById('global-mega-menu');
    
    if (megaMenuTrigger && menu) {
        megaMenuTrigger.addEventListener('mouseenter', () => menu.classList.add('open'));
        megaMenuTrigger.addEventListener('mouseleave', () => menu.classList.remove('open'));
        menu.addEventListener('mouseenter', () => menu.classList.add('open'));
        menu.addEventListener('mouseleave', () => menu.classList.remove('open'));
    }
});

// Update cart count in header
function updateCartCount() {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        let count = 0;
        
        // First try to use global cartCount if it exists
        if (typeof cartCount !== 'undefined') {
            count = cartCount;
        } else {
            // Fallback to localStorage 'cart'
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            count = cart.reduce((total, item) => total + item.quantity, 0);
        }
        
        cartCountElement.textContent = count;
        cartCountElement.style.display = 'flex';
    }
}

// Update wishlist count in header
function updateWishlistCount() {
    let count = 0;

    // Check if auth object exists (from main page) and has currentUser
    if (typeof auth !== 'undefined' && auth.currentUser && auth.currentUser.wishlist) {
        count = auth.currentUser.wishlist.length;
    } else {
        // Fallback to localStorage if auth object not available
        const currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;
        if (currentUser && currentUser.wishlist) {
            count = currentUser.wishlist.length;
        }
    }

    const wishlistCountElement = document.querySelector('.wishlist-count');
    if (wishlistCountElement) {
        wishlistCountElement.textContent = count;
        wishlistCountElement.style.display = 'flex';
    }
}

// Listen for storage events to update count when cart changes in other tabs
window.addEventListener('storage', function(e) {
    if (e.key === 'cart') {
        // Update cart variables if they exist, otherwise just update the display
        if (typeof cart !== 'undefined' && typeof cartCount !== 'undefined') {
            cart = JSON.parse(e.newValue) || [];
            cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        }
        updateCartCount();
    }
    if (e.key === 'currentUser') {
        // Update auth object if it exists, otherwise just update local functions
        if (typeof auth !== 'undefined') {
            auth.currentUser = JSON.parse(e.newValue);
        }
        updateWishlistCount();
    }
});

// Listen for wishlist updates from other pages
window.addEventListener('wishlistUpdated', function(e) {
    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
    wishlistCountElements.forEach(element => {
        element.textContent = e.detail.count;
        element.classList.add('pulse');
        setTimeout(() => {
            element.classList.remove('pulse');
        }, 500);
    });
});

// Listen for auth changes to update counters
window.addEventListener('authChange', function() {
    if (typeof updateCartCount === 'function') updateCartCount();
    if (typeof updateWishlistCount === 'function') updateWishlistCount();
});
