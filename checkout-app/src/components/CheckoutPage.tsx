import React, { useState, useEffect } from 'react';
import {
  Container,
  Typography,
  Box,
  useTheme
} from '@mui/material';
import { styled } from '@mui/material/styles';
import CheckoutHeader from './CheckoutHeader';
import ShippingForm from './ShippingForm';
import PaymentForm from './PaymentForm';
import ReviewForm from './ReviewForm';

const PageContainer = styled(Box)(({ theme }) => ({
  padding: '40px 0',
  backgroundColor: theme.palette.grey[50],
  minHeight: '100vh'
}));

const PageHeader = styled(Box)(({ theme }) => ({
  marginBottom: '30px',
  textAlign: 'center'
}));

interface OrderItem {
  id: string;
  title: string;
  image: string;
  size?: string;
  color?: string;
  quantity: number;
  price: number;
}

interface ShippingFormData {
  email: string;
  firstName: string;
  lastName: string;
  address: string;
  address2: string;
  city: string;
  country: string;
  state: string;
  zip: string;
  phone: string;
  saveAddress: boolean;
}

interface PaymentFormData {
  paymentMethod: 'credit-card' | 'cash-on-delivery';
  cardholderName: string;
}

const CheckoutPage: React.FC = () => {
  const theme = useTheme();
  const [currentStep, setCurrentStep] = useState(0);
  const [shippingData, setShippingData] = useState<ShippingFormData | null>(null);
  const [paymentData, setPaymentData] = useState<PaymentFormData | null>(null);
  
  // Mock order items - in real app this would come from cart/props
  const [orderItems] = useState<OrderItem[]>([
    {
      id: '1',
      title: 'Classic White Shirt',
      image: 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=300&h=300&fit=crop',
      size: 'M',
      color: 'White',
      quantity: 1,
      price: 49.99
    },
    {
      id: '2',
      title: 'Blue Denim Jeans',
      image: 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=300&h=300&fit=crop',
      size: '32',
      color: 'Blue',
      quantity: 2,
      price: 79.99
    }
  ]);

  const [cartCount, setCartCount] = useState(2);
  const [wishlistCount, setWishlistCount] = useState(0);

  // Smooth scroll to top when step changes
  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [currentStep]);

  const handleShippingNext = (data: ShippingFormData) => {
    setShippingData(data);
    setCurrentStep(1);
  };

  const handlePaymentNext = (data: PaymentFormData) => {
    setPaymentData(data);
    setCurrentStep(2);
  };

  const handleBackToCart = () => {
    // In real app, navigate to cart page
    console.log('Navigate to cart');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handleBackToShipping = () => {
    setCurrentStep(0);
  };

  const handleBackToPayment = () => {
    setCurrentStep(1);
  };

  const handleEditShipping = () => {
    setCurrentStep(0);
  };

  const handleEditPayment = () => {
    setCurrentStep(1);
  };

  const handleOrderSubmit = async () => {
    try {
      // Mock order submission
      console.log('Submitting order:', {
        shipping: shippingData,
        payment: paymentData,
        items: orderItems
      });
      
      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 2000));
      
      // Show success message
      alert('Order placed successfully! Thank you for your purchase.');
      
      // In real app, navigate to confirmation page
      console.log('Order submitted successfully');
      
    } catch (error) {
      console.error('Order submission failed:', error);
      throw error;
    }
  };

  const renderCurrentStep = () => {
    switch (currentStep) {
      case 0:
        return (
          <ShippingForm
            onNext={handleShippingNext}
            onBack={handleBackToCart}
            initialData={shippingData || undefined}
          />
        );
      case 1:
        return (
          <PaymentForm
            onNext={handlePaymentNext}
            onBack={handleBackToShipping}
            initialData={paymentData || undefined}
          />
        );
      case 2:
        if (!shippingData || !paymentData) {
          setCurrentStep(0);
          return null;
        }
        return (
          <ReviewForm
            shippingInfo={shippingData}
            paymentInfo={paymentData}
            orderItems={orderItems}
            onBack={handleBackToPayment}
            onEditShipping={handleEditShipping}
            onEditPayment={handleEditPayment}
            onSubmit={handleOrderSubmit}
          />
        );
      default:
        return null;
    }
  };

  return (
    <>
      <CheckoutHeader cartCount={cartCount} wishlistCount={wishlistCount} />
      
      <PageContainer>
        <Container maxWidth="md">
          <PageHeader>
            <Typography 
              variant="h1" 
              sx={{ 
                fontSize: '32px', 
                color: '#2a5c8d', 
                marginBottom: '10px',
                fontFamily: 'Playfair Display, serif'
              }}
            >
              Checkout
            </Typography>
          </PageHeader>
          
          <Box>
            {renderCurrentStep()}
          </Box>
        </Container>
      </PageContainer>
    </>
  );
};

export default CheckoutPage;