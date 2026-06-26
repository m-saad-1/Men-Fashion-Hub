// public/assets/js/footer.js

document.addEventListener('DOMContentLoaded', function() {
    // Newsletter form logic
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('input[type="email"]');
            const email = input.value.trim();
            
            if (email) {
                // Future integration point for newsletter API
                console.log(`Subscribing ${email} to newsletter...`);
                input.value = '';
                
                // Show simple feedback
                const btn = this.querySelector('button');
                const originalText = btn.textContent;
                btn.textContent = 'Subscribed!';
                btn.style.backgroundColor = 'var(--success-color)';
                
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.backgroundColor = '';
                }, 3000);
            }
        });
    }
});
