const stripe = require('../config/stripe');

exports.createPaymentIntent = async (req, res) => {
  try {
    const { amount, currency = 'usd' } = req.body;
    
    const paymentIntent = await stripe.paymentIntents.create({
      amount: Math.round(amount * 100), // Convert to cents
      currency,
      automatic_payment_methods: {
        enabled: true,
      },
      metadata: {
        integration_check: 'accept_a_payment'
      }
    });

    res.json({ clientSecret: paymentIntent.client_secret });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};

exports.saveOrder = async (req, res) => {
  try {
    const order = req.body;
    
    // In a real app, save to database here
    console.log('Order received:', order);
    
    res.json({ 
      success: true, 
      order: {
        ...order,
        id: Date.now().toString(),
        status: 'completed',
        paymentStatus: 'paid'
      }
    });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
};