<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionHub - Premium Clothing</title>
    <link rel="icon" href="../assets/images/favicon.png" type="image/png">
    <link rel="preload" as="image" href="https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
          :root {
    --primary-color: #2a2a2a;
    --secondary-color: #d4a762;
    --accent-color: #e53935;
    --text-color: #333;
    --light-text: #777;
    --border-color: #e0e0e0;
    --bg-light: #f9f9f9;
    --white: #fff;
    --black: #000;
    --success-color: #4caf50;
    --warning-color: #ff9800;
    --error-color: #f44336;
    --font-main: 'Roboto', sans-serif;
    --font-heading: 'Playfair Display', serif;
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: var(--font-main);
    color: var(--text-color);
    line-height: 1.6;
    background-color: var(--bg-light);
}

a {
    text-decoration: none;
    color: inherit;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    font-family: var(--font-heading);
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

h1 {
    font-size: 2.5rem;
}

h2 {
    font-size: 2rem;
}

h3 {
    font-size: 1.75rem;
}

p {
    margin-bottom: 1rem;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 4px;
    font-weight: 500;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    border: 1px solid transparent;
}

.btn-primary {
    background-color: var(--secondary-color);
    color: var(--white);
}

.btn-primary:hover {
    background-color: #c49555;
}

.btn-outline {
    background-color: transparent;
    border-color: var(--secondary-color);
    color: var(--secondary-color);
}

.btn-outline:hover {
    background-color: var(--secondary-color);
    color: var(--white);
}

.btn-text {
    background: none;
    border: none;
    color: var(--secondary-color);
    padding: 0;
}

.btn-block {
    display: block;
    width: 100%;
}

.btn-small {
    padding: 5px 10px;
    font-size: 0.9rem;
}



/* Enhanced Hero Section */
.hero {
    height: 100vh;
    position: relative;
    overflow: hidden;
    color: white;
    display: flex;
    align-items: center;
    margin-bottom: 80px;
}

.hero-slideshow {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.hero-slide {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
    background-size: cover;
    background-position: center;
}

.hero-slide.active {
    opacity: 1;
}

.hero-slide:nth-child(1) {
    background-image: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%),
                    url('https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
}

.hero-slide:nth-child(2) {
    background-image: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%),
                    url('https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
}

.hero-slide:nth-child(3) {
    background-image: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%),
                    url('https://images.unsplash.com/photo-1525507119028-ed4c629a60a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1935&q=80');
}

.hero-content {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 2;
    animation: fadeInUp 1s ease-out;
}

.hero h1 {
    font-size: 5rem;
    margin-bottom: 20px;
    font-weight: 700;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    line-height: 1.1;
    position: relative;
    display: inline-block;
    color: var(--white); /* Changed to white */
}

.hero h1::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 100px;
    height: 4px;
    background: var(--secondary-color);
}

.hero p {
    font-size: 1.5rem;
    margin-bottom: 30px;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.3);
    max-width: 600px;
    color: rgba(255,255,255,0.9); /* Slightly transparent white */
}

.hero-buttons {
    display: flex;
    gap: 20px;
    margin-top: 40px;
}

.hero-buttons .btn {
    padding: 12px 24px; /* Slightly smaller buttons */
    font-size: 1rem; /* Smaller font size */
    border-radius: 30px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.hero-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.hero-buttons .btn-primary {
    background-color: var(--secondary-color);
    color: var(--white);
    border: 2px solid var(--secondary-color);
}

.hero-buttons .btn-outline {
    background-color: transparent;
    color: var(--white);
    border: 2px solid var(--white);
}

.hero-buttons .btn-outline:hover {
    background-color: rgba(255,255,255,0.1);
}

/* Fashion Icons Overlay - Enhanced */
.fashion-icons {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
    opacity: 0.15; /* More subtle */
}

.fashion-icon {
    position: absolute;
    font-size: 2.5rem; /* Slightly larger */
    color: var(--white);
    animation: float 8s infinite ease-in-out; /* Slower animation */
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2)); /* Subtle shadow */
}

.fashion-icon:nth-child(1) {
    top: 15%;
    left: 8%;
    animation-delay: 0s;
}

.fashion-icon:nth-child(2) {
    top: 65%;
    left: 12%;
    animation-delay: 1.5s;
}

.fashion-icon:nth-child(3) {
    top: 25%;
    right: 8%;
    animation-delay: 3s;
}

.fashion-icon:nth-child(4) {
    bottom: 15%;
    right: 12%;
    animation-delay: 4.5s;
}

.fashion-icon:nth-child(5) {
    top: 8%;
    right: 25%;
    animation-delay: 6s;
}

/* Hero Bottom Wave - Enhanced */
.hero::after {
    content: '';
    position: absolute;
    bottom: -50px;
    left: 0;
    width: 100%;
    height: 100px;
    background: white;
    transform: skewY(-3deg);
    z-index: 1;
    box-shadow: 0 -5px 15px rgba(0,0,0,0.05); /* Subtle shadow */
}

/* Hero Slider Controls - Enhanced */
.hero-controls {
    position: absolute;
    bottom: 60px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 12px;
    z-index: 3;
}

.hero-control {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.4);
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    border: 1px solid rgba(255,255,255,0.2);
}

.hero-control:hover {
    background-color: rgba(255,255,255,0.6);
}

.hero-control.active {
    background-color: var(--white);
    transform: scale(1.3);
    box-shadow: 0 0 10px rgba(255,255,255,0.5);
}

/* Seasonal Tag - Enhanced */
.season-tag {
    position: absolute;
    top: 100px;
    right: 50px;
    background-color: var(--secondary-color);
    color: var(--white);
    padding: 12px 24px;
    border-radius: 30px;
    font-weight: 600;
    transform: rotate(15deg);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 2;
    animation: pulse 3s infinite ease-in-out;
    font-size: 0.9rem;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* Featured Categories - Card Hover Effects */
.featured-categories {
    padding: 80px 0;
    background: white;
    position: relative;
    z-index: 2;
}

.section-title {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 60px;
    position: relative;
    color: #333;
}

.section-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: linear-gradient(to right, #ff4e50, #f9d423);
    margin: 15px auto 0;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.category-card {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 300px;
}

.category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.category-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.category-card:hover img {
    transform: scale(1.05);
}

.category-card h3 {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    padding: 20px;
    margin: 0;
    color: white;
    font-size: 1.8rem;
    font-weight: 600;
    background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
    transform: translateY(0);
    transition: all 0.3s ease;
}

.category-card:hover h3 {
    transform: translateY(-10px);
}

/* Featured Products Section */
.featured-products {
    padding: 80px 0;
    background-color: var(--bg-light);
}

.featured-products .product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-card {
    background-color: var(--white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    position: relative;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: var(--accent-color);
    color: var(--white);
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
    z-index: 2;
}

.product-badge.new {
    background-color: var(--success-color);
}

.product-badge.best-seller {
    background-color: var(--secondary-color);
}

.product-image {
    position: relative;
    overflow: hidden;
    height: 220px;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-info {
    padding: 12px 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-title {
    font-size: 0.9rem;
    margin-bottom: 0px;
    color: var(--primary-color);
    line-height: 1.2;
    min-height: 22px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 4px;
    margin: 2px 0;
    flex-wrap: nowrap;
    white-space: nowrap;
}

.current-price { font-weight: 700; font-size: 0.85rem;
    color: var(--secondary-color);
}

.old-price { text-decoration: line-through; color: var(--light-text); font-size: 0.7rem;
}

.discount { background-color: var(--accent-color); color: var(--white); font-size: 0.65rem; padding: 1px 3px;
    border-radius: 4px;
    margin-left: auto;
}

.product-meta {
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9rem;
    color: var(--light-text);
}

.rating {
    display: flex;
    align-items: center;
    gap: 5px;
}

.stars {
    color: var(--secondary-color);
}

.product-actions {
    position: absolute;
    bottom: -50px;
    left: 0;
    right: 0;
    background-color: var(--white);
    padding: 15px;
    display: flex;
    justify-content: center;
    gap: 10px;
    opacity: 0;
    transition: var(--transition);
    z-index: 2;
}

.product-card:hover .product-actions {
    bottom: 0;
    opacity: 1;
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--secondary-color);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.action-btn:hover {
    background-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

/* Promo Banner - Enhanced Design */
.promo-banner {
    padding: 120px 0;
    background: linear-gradient(135deg, #ff4e50 0%, #f9d423 100%);
    color: white;
    text-align: center;
    margin: 80px 0;
    position: relative;
    overflow: hidden;
}

.promo-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center;
    background-size: cover;
    opacity: 0.1;
    z-index: 1;
}

.promo-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 20px;
}

.promo-banner h2 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    font-weight: 700;
}

.promo-banner p {
    font-size: 1.5rem;
    margin-bottom: 30px;
    opacity: 0.9;
}

.promo-banner .btn-outline {
    background-color: var(--secondary-color);
    color: var(--white);
    border: 2px solid var(--secondary-color);
}

.promo-banner .btn-outline:hover {
    background-color: #c49555;
    border-color: #c49555;
    color: var(--white);
}

/* Testimonials - Arrow Navigation Design */
.testimonials {
    padding: 80px 0;
    background: white;
    text-align: center;
}

.testimonial-wrapper {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding: 0 60px;
}

.testimonial-slider {
    overflow: hidden;
    width: 100%;
}

.testimonial-track {
    display: flex;
    transition: transform 0.4s ease;
    will-change: transform;
}

.testimonial-slide {
    flex-shrink: 0;
    width: 100%;
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.07);
    position: relative;
    text-align: center;
}

.testimonial-slide::before {
    content: '"';
    position: absolute;
    top: 15px;
    left: 20px;
    font-size: 5rem;
    color: rgba(212,167,98,0.15);
    font-family: serif;
    line-height: 1;
}

.testimonial-content {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 20px;
    color: #555;
    position: relative;
    z-index: 2;
    font-style: italic;
}

.testimonial-author {
    font-weight: 700;
    color: #333;
    margin-bottom: 4px;
    font-size: 1rem;
}

.testimonial-role {
    color: #999;
    font-size: 0.85rem;
}

.testimonial-rating {
    color: #f9d423;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

/* Testimonial Navigation Arrows */
.testimonial-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: var(--secondary-color);
    color: white;
    border: none;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}
.testimonial-nav-btn:hover {
    background: var(--primary-color);
    transform: translateY(-50%) scale(1.05);
}
.testimonial-nav-btn.prev { left: 0; }
.testimonial-nav-btn.next { right: 0; }

.testimonial-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}
.testimonial-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ddd;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}
.testimonial-dot.active {
    background: var(--secondary-color);
    width: 24px;
    border-radius: 4px;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 2000;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.product-modal {
    background-color: var(--white);
    border-radius: 8px;
    width: 90%;
    max-width: 1000px;
    max-height: 90vh;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    transform: translateY(50px);
    transition: var(--transition);
}

.modal-overlay.active .product-modal {
    transform: translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid var(--border-color);
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 600;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--light-text);
    transition: var(--transition);
}

.close-modal:hover {
    color: var(--accent-color);
}

.modal-content {
    display: flex;
    flex-direction: column;
    padding: 20px;
}

@media (min-width: 768px) {
    .modal-content {
        flex-direction: row;
        gap: 30px;
    }
}

.modal-image {
    flex: 1;
    min-height: 300px;
    border-radius: 8px;
    overflow: hidden;
}

.modal-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.modal-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--secondary-color);
}

.modal-old-price {
    text-decoration: line-through;
    color: var(--light-text);
    font-size: 1.2rem;
    margin-right: 10px;
}

.modal-discount {
    background-color: var(--accent-color);
    color: var(--white);
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 0.9rem;
}

.modal-description {
    color: var(--light-text);
    line-height: 1.7;
}

.modal-features {
    margin-top: 10px;
}

.modal-features ul {
    list-style-position: inside;
    margin-top: 5px;
}

.modal-features li {
    margin-bottom: 5px;
    color: var(--light-text);
}

.size-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
}

.size-btn {
    padding: 8px 15px;
    border: 1px solid var(--border-color);
    background: none;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
}

.size-btn:hover,
.size-btn.active {
    background-color: var(--secondary-color);
    color: var(--white);
    border-color: var(--secondary-color);
}

.color-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
}

.color-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    position: relative;
    transition: var(--transition);
}

.color-btn::after {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    border: 1px solid var(--border-color);
    border-radius: 50%;
    opacity: 0;
    transition: var(--transition);
}

.color-btn:hover::after,
.color-btn.active::after {
    opacity: 1;
    border-color: var(--secondary-color);
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--bg-light);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
}

.quantity-input {
    width: 50px;
    text-align: center;
    padding: 5px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
}

.modal-actions {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.btn-primary {
    background-color: var(--secondary-color);
    color: var(--white);
    padding: 12px 25px;
    border-radius: 4px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: var(--transition);
    flex: 1;
}

.btn-primary:hover {
    background-color: #c49555;
}

 .btn-outline {
            background-color: transparent;
            color: var(--secondary-color);
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 500;
            border: 1px solid var(--secondary-color);
            cursor: pointer;
            transition: var(--transition);
            flex: 1;
        }

        .btn-outline:hover {
            background-color: rgba(212, 167, 98, 0.1);
            color: var(--secondary-color);
        }

.modal-footer {
    display: flex;
    justify-content: space-between;
    padding: 15px 20px;
    border-top: 1px solid var(--border-color);
    color: var(--light-text);
    font-size: 0.9rem;
}

.modal-sku {
    font-weight: 500;
}

.modal-category {
    text-transform: capitalize;
}

/* Cart Notification */
.cart-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: var(--secondary-color);
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 15px;
}

.cart-notification.show {
    transform: translateY(0);
    opacity: 1;
}

.cart-notification a {
    color: white;
    text-decoration: underline;
    font-weight: 600;
}

/* Wishlist Notification */
.wishlist-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #4CAF50;
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 15px;
}

.wishlist-notification.show {
    transform: translateY(0);
    opacity: 1;
}

/* Compare Notification */
.compare-notification {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #4CAF50;
    color: white;
    padding: 15px 25px;
    border-radius: 5px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 15px;
}

.compare-notification.show {
    transform: translateY(0);
    opacity: 1;
}

.compare-notification a {
    color: white;
    text-decoration: underline;
    font-weight: 600;
}

/* Auth Alert */
.auth-alert {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.7);
    z-index: 2000;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.auth-alert.show {
    opacity: 1;
    visibility: visible;
}

.auth-alert-content {
    background: white;
    padding: 30px;
    border-radius: 8px;
    max-width: 400px;
    text-align: center;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.auth-alert.show .auth-alert-content {
    transform: translateY(0);
}

.auth-alert h3 {
    margin-top: 0;
    color: var(--primary-color);
}

.auth-alert p {
    margin: 15px 0 25px;
    color: var(--text-color);
}

.auth-alert-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
}


/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes pulse {
    0% {
        transform: rotate(15deg) scale(1);
    }
    50% {
        transform: rotate(15deg) scale(1.05);
    }
    100% {
        transform: rotate(15deg) scale(1);
    }
}


/* Responsive Adjustments */
@media (max-width: 1024px) {
    .hero h1 {
        font-size: 4.5rem;
    }

    .hero p {
        font-size: 1.4rem;
    }

    .hero-content {
        padding: 0 15px;
    }

    .featured-products .product-grid,
    .category-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 772px) {
    .hero h1 {
        font-size: 3rem;
    }

    .hero p {
        font-size: 1.2rem;
    }

    .promo-banner h2 {
        font-size: 2.2rem;
    }

    .promo-banner p {
        font-size: 1.2rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .testimonial-slide {
        padding: 30px;
    }

    .featured-products .product-grid,
    .category-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .modal-content {
        flex-direction: column;
    }

    .modal-image {
        min-height: 200px;
    }

    .modal-actions {
        flex-direction: column;
    }

    .season-tag {
        top: 80px;
        right: 30px;
        font-size: 0.9rem;
    }

    .hero-buttons .btn {
        padding: 10px 20px;
        font-size: 0.9rem;
    }

}

@media (max-width: 600px) {
    .search-box {
        display: none; /* Hide search box below 600px */
    }
}

@media (max-width: 500px) {
    .featured-products .product-grid,
    .category-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero h1 {
        font-size: 2.5rem;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 15px;
    }

    .season-tag {
        top: 60px;
        right: 20px;
        padding: 8px 15px;
    }

    .fashion-icons {
        display: none;
    }
}

    </style>
</head>
<body>
    <?php include '../../app/views/partials/header.php'; ?>

<main>
    <!-- Enhanced Hero Banner -->
    <section class="hero">
        <div class="hero-slideshow">
            <div class="hero-slide active"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
        </div>
        
        <div class="fashion-icons">
            <i class="fas fa-tshirt fashion-icon"></i>
            <i class="fas fa-shoe-prints fashion-icon"></i>
            <i class="fas fa-ring fashion-icon"></i>
            <i class="fas fa-glasses fashion-icon"></i>
            <i class="fas fa-hat-cowboy fashion-icon"></i>
        </div>
        
        <div class="hero-content">
 
            <h1>Elevate Your Style With Premium Fashion</h1>
            <p>Discover our curated selection of high-quality clothing and accessories designed to make you look and feel your best.</p>
            <div class="hero-buttons">
                <a href="shop.php" class="btn btn-primary">Shop Now</a>
                <a href="shop.php?category=new-arrivals" class="btn btn-outline">New Arrivals</a>
            </div>
        </div>
        
        <div class="hero-controls">
            <div class="hero-control active" data-slide="0"></div>
            <div class="hero-control" data-slide="1"></div>
            <div class="hero-control" data-slide="2"></div></div>
        </div>
    </section>

  <section class="featured-categories">
        <div class="container">
            <h2 class="section-title">Shop by Category</h2>
            <div class="category-grid">
                <a href="shop.php?category=shirts" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1598033129183-c4f50c736f10?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1025&q=80" alt="Shirts" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Shirts</h3>
                </a>
                <a href="shop.php?category=jeans" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1541099649105-f69ad21f3246?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Jeans" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Jeans</h3>
                </a>
                <a href="shop.php?category=jackets" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1035&q=80" alt="Jackets" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Jackets</h3>
                </a>
                <a href="shop.php?category=dresses" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Dresses" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Dresses</h3>
                </a>
                <a href="shop.php?category=accessories" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1038&q=80" alt="Accessories" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Accessories</h3>
                </a>
                <a href="shop.php?category=activewear" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1064&q=80" alt="Activewear" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Activewear</h3>
                </a>
                <a href="shop.php?category=footwear" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1460353581641-37baddab0fa2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1001&q=80" alt="Footwear" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Footwear</h3>
                </a>
                <a href="shop.php?category=formal" class="category-card" style="position: relative;">
                    <div class="skeleton" style="position:absolute; top:0; left:0; width:100%; height:100%; z-index:1;"></div>
                    <img src="https://images.unsplash.com/photo-1551232864-3f0890e580d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Formal Wear" loading="lazy" onload="this.previousElementSibling.style.display='none'" style="position:relative; z-index:2;">
                    <h3 style="z-index: 3;">Formal Wear</h3>
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products Section - API Driven (8 products, 2 rows x 4 cols) -->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="product-grid" id="featuredProductGrid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <!-- Products loaded by JS -->
            </div>
            <div style="text-align:center; margin-top: 30px;">
                <a href="shop.php" class="btn btn-primary" style="display:inline-block; padding: 12px 40px;">View All Products</a>
            </div>
        </div>
    </section>


                
            </div>
            <div style="text-align:center; margin-top: 30px;">
            </div>
        </div>
    </section>
    
    <!-- Promo Banner -->
    <section class="promo-banner">
        <div class="promo-content">
            <h2>Summer Sale - Up to 50% Off</h2>
            <p>Limited time offer on selected items. Don't miss out on these amazing deals!</p>
            <a href="shop.php?category=sale" class="btn-outline">Shop Sale</a>
        </div>
    </section>

    <!-- Testimonials - Arrow Navigation -->
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">What Our Customers Say</h2>
            <div class="testimonial-wrapper">
                <button class="testimonial-nav-btn prev" id="testimonialPrev" aria-label="Previous testimonial">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="testimonial-slider">
                    <div class="testimonial-track" id="testimonialTrack">
                        <div class="testimonial-slide">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "I absolutely love the quality of the clothes from FashionHub. The fit is perfect and the materials are so comfortable. I'll definitely be shopping here again!"
                            </div>
                            <div class="testimonial-author">Sarah Johnson</div>
                            <div class="testimonial-role">Happy Customer</div>
                        </div>
                        <div class="testimonial-slide">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "The shipping was incredibly fast and the customer service was excellent when I had a question about sizing. Highly recommend FashionHub for all your fashion needs!"
                            </div>
                            <div class="testimonial-author">Michael Smith</div>
                            <div class="testimonial-role">Happy Customer</div>
                        </div>
                        <div class="testimonial-slide">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <div class="testimonial-content">
                                "I've purchased multiple items from FashionHub and each one has exceeded my expectations. The quality is outstanding and the prices are very reasonable."
                            </div>
                            <div class="testimonial-author">Emily Wilson</div>
                            <div class="testimonial-role">Loyal Customer</div>
                        </div>
                        <div class="testimonial-slide">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "FashionHub has become my go-to store for all fashion needs. The variety is amazing and I always find exactly what I'm looking for. Fantastic experience every time!"
                            </div>
                            <div class="testimonial-author">David Martinez</div>
                            <div class="testimonial-role">Regular Shopper</div>
                        </div>
                        <div class="testimonial-slide">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>
                            </div>
                            <div class="testimonial-content">
                                "Great selection and the clothes arrived quickly. The packaging was beautiful too. Will definitely recommend FashionHub to my friends and family!"
                            </div>
                            <div class="testimonial-author">Lisa Chen</div>
                            <div class="testimonial-role">Verified Buyer</div>
                        </div>
                    </div>
                </div>
                <button class="testimonial-nav-btn next" id="testimonialNext" aria-label="Next testimonial">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="testimonial-dots" id="testimonialDots"></div>
        </div>
    </section>
</main>



 <?php include '../../app/views/partials/footer.php'; ?>
   
<script>
    // Product Data
    let products = [];
    
    async function fetchFeaturedProducts() {
        try {
            const response = await fetch('../../app/api/products/get_products.php?limit=8&category=featured');
            const data = await response.json();
            
            if (data.status === 'success') {
                products = data.products.map(p => ({
                    id: parseInt(p.id),
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
        
        grid.innerHTML = '';
        products.forEach(product => {
            const productCard = createProductCard(product);
            grid.appendChild(productCard);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchFeaturedProducts();
        // Hero Slider Functionality
        const slides = document.querySelectorAll('.hero-slide');
        const controls = document.querySelectorAll('.hero-control');
        let currentSlide = 0;
        
        // Auto slide change
        function nextSlide() {
            slides[currentSlide].classList.remove('active');
            controls[currentSlide].classList.remove('active');
            
            currentSlide = (currentSlide + 1) % slides.length;
            
            slides[currentSlide].classList.add('active');
            controls[currentSlide].classList.add('active');
        }
        
        // Manual slide control
        controls.forEach(control => {
            control.addEventListener('click', function() {
                const slideIndex = parseInt(this.dataset.slide);
                
                slides[currentSlide].classList.remove('active');
                controls[currentSlide].classList.remove('active');
                
                currentSlide = slideIndex;
                
                slides[currentSlide].classList.add('active');
                controls[currentSlide].classList.add('active');
                
                // Reset timer when manually changing slides
                clearInterval(slideInterval);
                slideInterval = setInterval(nextSlide, 5000);
            });
        });
        
        // Start auto slide
        let slideInterval = setInterval(nextSlide, 5000);
        
        // Pause on hover
        const hero = document.querySelector('.hero');
        hero.addEventListener('mouseenter', function() {
            clearInterval(slideInterval);
        });
        
        hero.addEventListener('mouseleave', function() {
            slideInterval = setInterval(nextSlide, 5000);
        });

        // Testimonial Slider Functionality
        const testimonialTrack = document.getElementById('testimonialTrack');
        const testimonialSlides = document.querySelectorAll('.testimonial-slide');
        const testimonialPrev = document.getElementById('testimonialPrev');
        const testimonialNext = document.getElementById('testimonialNext');
        const testimonialDotsContainer = document.getElementById('testimonialDots');
        
        if (testimonialTrack && testimonialSlides.length > 0) {
            let currentTestimonial = 0;
            const maxTestimonials = testimonialSlides.length;

            // Create dots
            testimonialSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `testimonial-dot ${index === 0 ? 'active' : ''}`;
                dot.dataset.index = index;
                dot.setAttribute('aria-label', `Go to testimonial ${index + 1}`);
                dot.addEventListener('click', () => goToTestimonial(index));
                testimonialDotsContainer.appendChild(dot);
            });

            const testimonialDots = document.querySelectorAll('.testimonial-dot');

            function updateTestimonialSlider() {
                testimonialTrack.style.transform = `translateX(-${currentTestimonial * 100}%)`;
                testimonialDots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentTestimonial);
                });
            }

            function goToTestimonial(index) {
                currentTestimonial = index;
                updateTestimonialSlider();
            }

            if (testimonialPrev) {
                testimonialPrev.addEventListener('click', () => {
                    currentTestimonial = (currentTestimonial - 1 + maxTestimonials) % maxTestimonials;
                    updateTestimonialSlider();
                });
            }

            if (testimonialNext) {
                testimonialNext.addEventListener('click', () => {
                    currentTestimonial = (currentTestimonial + 1) % maxTestimonials;
                    updateTestimonialSlider();
                });
            }

            // Auto-advance testimonials
            let testimonialInterval = setInterval(() => {
                currentTestimonial = (currentTestimonial + 1) % maxTestimonials;
                updateTestimonialSlider();
            }, 6000);

            // Pause on hover
            const testimonialWrapper = document.querySelector('.testimonial-wrapper');
            if (testimonialWrapper) {
                testimonialWrapper.addEventListener('mouseenter', () => clearInterval(testimonialInterval));
                testimonialWrapper.addEventListener('mouseleave', () => {
                    testimonialInterval = setInterval(() => {
                        currentTestimonial = (currentTestimonial + 1) % maxTestimonials;
                        updateTestimonialSlider();
                    }, 6000);
                });
            }
        }
    });
</script>
</body>
</html>
