// Main JavaScript File
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    const searchButton = document.querySelector('.search-box button');
    const searchBox = document.querySelector('.search-box');
    
    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            searchBox.classList.remove('active');
        });
    }
    
    if (searchButton) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            searchBox.classList.toggle('active');
            if (mainNav) mainNav.classList.remove('active');
        });
    }
    
    // Mega menu functionality
    const megaMenuTriggers = document.querySelectorAll('.mega-menu-trigger');
    megaMenuTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const megaMenu = this.querySelector('.mega-menu');
                megaMenu.style.display = megaMenu.style.display === 'block' ? 'none' : 'block';
            }
        });
        
        if (window.innerWidth > 768) {
            trigger.addEventListener('mouseenter', function() {
                this.querySelector('.mega-menu').style.display = 'block';
            });
            
            trigger.addEventListener('mouseleave', function() {
                this.querySelector('.mega-menu').style.display = 'none';
            });
        }
    });
    
    // Product gallery thumbnail click
    const thumbnails = document.querySelectorAll('.gallery-thumbnails .thumb');
    const mainImage = document.getElementById('mainProductImage');
    
    if (thumbnails && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                // Add active class to clicked thumbnail
                this.classList.add('active');
                // Update main image
                const newSrc = this.querySelector('img').src;
                mainImage.src = newSrc;
            });
        });
    }
    
    // Accordion functionality
    const accordionHeaders = document.querySelectorAll('.accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const accordionItem = this.parentElement;
            accordionItem.classList.toggle('active');
            
            // Close other accordion items in the same group
            const accordionGroup = accordionItem.parentElement;
            if (accordionGroup) {
                Array.from(accordionGroup.children).forEach(item => {
                    if (item !== accordionItem) {
                        item.classList.remove('active');
                    }
                });
            }
        });
    });
    
    // Product tabs
    const tabNavItems = document.querySelectorAll('.tab-nav li');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    if (tabNavItems.length && tabPanes.length) {
        tabNavItems.forEach((item, index) => {
            item.addEventListener('click', function() {
                // Remove active class from all nav items and panes
                tabNavItems.forEach(navItem => navItem.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                // Add active class to clicked nav item and corresponding pane
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    }
    
    // Quantity selector
    const quantityInputs = document.querySelectorAll('.qty-input input');
    quantityInputs.forEach(input => {
        const minusBtn = input.previousElementSibling;
        const plusBtn = input.nextElementSibling;
        
        minusBtn.addEventListener('click', function() {
            let value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
        
        plusBtn.addEventListener('click', function() {
            let value = parseInt(input.value);
            input.value = value + 1;
        });
    });
    
    // Size selector
    const sizeOptions = document.querySelectorAll('.size-option');
    sizeOptions.forEach(option => {
        option.addEventListener('click', function() {
            if (!this.classList.contains('disabled')) {
                const sizeSelector = this.closest('.size-options');
                if (sizeSelector) {
                    sizeSelector.querySelectorAll('.size-option').forEach(opt => {
                        opt.classList.remove('active');
                    });
                }
                this.classList.add('active');
            }
        });
    });
    
    // Color selector
    const colorOptions = document.querySelectorAll('.color-option');
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const colorSelector = this.closest('.color-options');
            if (colorSelector) {
                colorSelector.querySelectorAll('.color-option').forEach(opt => {
                    opt.classList.remove('active');
                });
            }
            this.classList.add('active');
        });
    });
    
    // View options in shop page
    const viewButtons = document.querySelectorAll('.view-btn');
    const productGrid = document.querySelector('.product-grid');
    
    if (viewButtons.length && productGrid) {
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.dataset.view === 'grid') {
                    productGrid.classList.remove('list-view');
                    productGrid.classList.add('grid-view');
                } else {
                    productGrid.classList.remove('grid-view');
                    productGrid.classList.add('list-view');
                }
            });
        });
    }
    
    // Account tabs
    const accountMenuItems = document.querySelectorAll('.account-menu a');
    const accountTabs = document.querySelectorAll('.account-tab');
    
    if (accountMenuItems.length && accountTabs.length) {
        accountMenuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                
                accountMenuItems.forEach(menuItem => {
                    menuItem.parentElement.classList.remove('active');
                });
                
                accountTabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                
                this.parentElement.classList.add('active');
                document.getElementById(targetId).classList.add('active');
            });
        });
    }
    
    // Login/register tabs
    const authTabs = document.querySelectorAll('.auth-tab');
    const authForms = document.querySelectorAll('.auth-form');
    const switchTabLinks = document.querySelectorAll('.switch-tab');
    
    if (authTabs.length && authForms.length) {
        authTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                authTabs.forEach(t => t.classList.remove('active'));
                authForms.forEach(form => form.classList.remove('active'));
                
                this.classList.add('active');
                document.getElementById(targetTab + '-form').classList.add('active');
            });
        });
        
        switchTabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-tab');
                
                authTabs.forEach(tab => {
                    if (tab.getAttribute('data-tab') === targetTab) {
                        tab.click();
                    }
                });
            });
        });
    }
    
    // Forgot password
    const forgotPassword = document.querySelector('.forgot-password');
    const loginForm = document.getElementById('login-form');
    const resetForm = document.getElementById('reset-form');
    
    if (forgotPassword && loginForm && resetForm) {
        forgotPassword.addEventListener('click', function(e) {
            e.preventDefault();
            loginForm.classList.remove('active');
            resetForm.classList.add('active');
        });
    }
    
    // Initialize product sliders
    initSliders();
    
    // Load products dynamically
    if (typeof loadProducts === 'function') {
        loadProducts();
    }
    
    // Update cart count from localStorage
    updateCartCount();
});

// Initialize sliders
function initSliders() {
    // Testimonial slider
    const testimonialSlider = document.querySelector('.testimonial-slider');
    if (testimonialSlider) {
        let currentSlide = 0;
        const slides = testimonialSlider.querySelectorAll('.testimonial-slide');
        const prevBtn = document.createElement('button');
        const nextBtn = document.createElement('button');
        
        prevBtn.className = 'slider-arrow prev';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        nextBtn.className = 'slider-arrow next';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        
        testimonialSlider.parentElement.insertBefore(prevBtn, testimonialSlider);
        testimonialSlider.parentElement.appendChild(nextBtn);
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }
        
        prevBtn.addEventListener('click', function() {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });
        
        nextBtn.addEventListener('click', function() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });
        
        if (slides.length) showSlide(0);
    }
}

// Update cart count
function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let totalItems = 0;
        
        cart.forEach(item => {
            totalItems += item.quantity;
        });
        
        cartCount.textContent = totalItems;
        cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

// Update wishlist count
function updateWishlistCount() {
    const wishlistCount = document.querySelector('.wishlist-count');
    if (wishlistCount) {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        wishlistCount.textContent = wishlist.length;
        wishlistCount.style.display = wishlist.length > 0 ? 'flex' : 'none';
    }
}

// Show added to cart message
function showAddedToCartMessage() {
    const message = document.createElement('div');
    message.className = 'added-to-cart-message';
    message.innerHTML = 'Product added to cart! <a href="cart.html">View Cart</a>';
    document.body.appendChild(message);
    
    setTimeout(() => {
        message.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        message.classList.remove('show');
        setTimeout(() => {
            message.remove();
        }, 300);
    }, 3000);
}

// Generate star rating HTML
function generateStars(rating) {
    let stars = '';
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 >= 0.5;
    
    for (let i = 1; i <= 5; i++) {
        if (i <= fullStars) {
            stars += '<i class="fas fa-star"></i>';
        } else if (i === fullStars + 1 && hasHalfStar) {
            stars += '<i class="fas fa-star-half-alt"></i>';
        } else {
            stars += '<i class="far fa-star"></i>';
        }
    }
    
    return stars;
}