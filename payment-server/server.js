require('dotenv').config();
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const paymentRoutes = require('./routes/paymentRoutes');

const app = express();

// Middleware
app.use(cors({
  origin: process.env.FRONTEND_URL || 'http://localhost:3000'
}));
app.use(bodyParser.json());

// Serve static files from the project root (where index.php, css, js are)
app.use(express.static('../'));

// Routes
app.use('/api/payments', paymentRoutes);

// Start server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => 
  console.log(`Server running on port ${PORT}`)
);
