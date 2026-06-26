const Stripe = require('stripe');

// Initialize Stripe with your secret key
// In production, use environment variables for security
const stripeSecretKey = process.env.STRIPE_SECRET_KEY || 'sk_test_your_secret_key_here';

if (!stripeSecretKey || stripeSecretKey === 'sk_test_your_secret_key_here') {
  console.warn('Warning: Using placeholder Stripe secret key. Please set STRIPE_SECRET_KEY environment variable.');
}

const stripe = Stripe(stripeSecretKey);

module.exports = stripe;