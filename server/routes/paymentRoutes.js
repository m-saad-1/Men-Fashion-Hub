const express = require('express');
const { createPaymentIntent, saveOrder } = require('../controllers/payments');

const router = express.Router();

router.post('/create-payment-intent', createPaymentIntent);
router.post('/save-order', saveOrder);

module.exports = router;