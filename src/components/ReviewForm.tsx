import React, { useState } from 'react';
import {
  Card,
  CardContent,
  Typography,
  Button,
  Stack,
  Box,
  FormControlLabel,
  Checkbox,
  Link,
  Divider,
  useTheme,
  CircularProgress
} from '@mui/material';
import { styled } from '@mui/material/styles';

const StyledCard = styled(Card)(({ theme }) => ({
  backgroundColor: theme.palette.background.paper,
  borderRadius: '8px',
  padding: '30px',
  boxShadow: '0 2px 15px rgba(0,0,0,0.05)',
  marginBottom: '30px'
}));

const ReviewSection = styled(Box)(({ theme }) => ({
  marginBottom: '25px',
  paddingBottom: '20px',
  borderBottom: `1px solid ${theme.palette.grey[200]}`
}));

const SectionHeader = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  justifyContent: 'space-between',
  marginBottom: '10px'
}));

const EditLink = styled(Link)(({ theme }) => ({
  color: '#2a5c8d',
  textDecoration: 'none',
  cursor: 'pointer',
  '&:hover': {
    textDecoration: 'underline'
  }
}));

const OrderItem = styled(Box)(({ theme }) => ({
  display: 'flex',
  padding: '15px',
  borderBottom: `1px solid ${theme.palette.grey[200]}`,
  alignItems: 'center',
  '&:last-child': {
    borderBottom: 'none'
  },
  [theme.breakpoints.down('md')]: {
    flexWrap: 'wrap'
  }
}));

const ItemImage = styled('img')(({ theme }) => ({
  width: '80px',
  height: '80px',
  borderRadius: '4px',
  objectFit: 'cover',
  marginRight: '15px',
  flexShrink: 0
}));

const ItemDetails = styled(Box)(({ theme }) => ({
  flex: 1
}));

const ItemTotal = styled(Typography)(({ theme }) => ({
  fontWeight: 700,
  color: '#2a5c8d',
  marginLeft: 'auto',
  paddingLeft: '15px',
  [theme.breakpoints.down('md')]: {
    marginLeft: 0,
    width: '100%',
    textAlign: 'right',
    marginTop: '10px',
    paddingLeft: '95px'
  }
}));

const SummaryRow = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  justifyContent: 'space-between',
  marginBottom: '10px'
}));

const TotalRow = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  justifyContent: 'space-between',
  marginTop: '15px',
  paddingTop: '15px',
  borderTop: `1px solid ${theme.palette.grey[200]}`,
  fontWeight: 600,
  fontSize: '18px'
}));

const ActionButtons = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  justifyContent: 'space-between',
  marginTop: '30px',
  [theme.breakpoints.down('md')]: {
    flexDirection: 'column-reverse',
    gap: '15px'
  }
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

interface ShippingInfo {
  email: string;
  firstName: string;
  lastName: string;
  address: string;
  address2?: string;
  city: string;
  state: string;
  zip: string;
  country: string;
  phone: string;
}

interface PaymentInfo {
  paymentMethod: 'credit-card' | 'cash-on-delivery';
  cardholderName?: string;
}

interface ReviewFormProps {
  shippingInfo: ShippingInfo;
  paymentInfo: PaymentInfo;
  orderItems: OrderItem[];
  onBack: () => void;
  onEditShipping: () => void;
  onEditPayment: () => void;
  onSubmit: () => void;
}

const ReviewForm: React.FC<ReviewFormProps> = ({
  shippingInfo,
  paymentInfo,
  orderItems,
  onBack,
  onEditShipping,
  onEditPayment,
  onSubmit
}) => {
  const theme = useTheme();
  const [termsAgreed, setTermsAgreed] = useState(false);
  const [termsError, setTermsError] = useState(false);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const subtotal = orderItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  const shipping = 0; // Free shipping
  const paymentFee = paymentInfo.paymentMethod === 'cash-on-delivery' ? 5.00 : 0;
  const total = subtotal + shipping + paymentFee;

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    
    if (!termsAgreed) {
      setTermsError(true);
      return;
    }
    
    setIsSubmitting(true);
    
    try {
      await onSubmit();
      // Smooth scroll to top after successful submission
      window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (error) {
      console.error('Order submission failed:', error);
    } finally {
      setIsSubmitting(false);
    }
  };

  const handleTermsChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setTermsAgreed(event.target.checked);
    if (event.target.checked) {
      setTermsError(false);
    }
  };

  const handleEditClick = (editFunction: () => void) => {
    editFunction();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <StyledCard>
      <Typography 
        variant="h4" 
        sx={{ 
          marginBottom: '20px', 
          color: '#2a5c8d',
          fontFamily: 'Playfair Display, serif'
        }}
      >
        Review Your Order
      </Typography>
      
      <Box component="form" onSubmit={handleSubmit}>
        {/* Shipping Information */}
        <ReviewSection>
          <SectionHeader>
            <Typography variant="h6">Shipping Information</Typography>
            <EditLink onClick={() => handleEditClick(onEditShipping)}>
              Edit
            </EditLink>
          </SectionHeader>
          <Box sx={{ lineHeight: 1.8 }}>
            <Typography>{shippingInfo.email}</Typography>
            <Typography>{shippingInfo.firstName} {shippingInfo.lastName}</Typography>
            <Typography>{shippingInfo.address}</Typography>
            {shippingInfo.address2 && <Typography>{shippingInfo.address2}</Typography>}
            <Typography>{shippingInfo.city}, {shippingInfo.state} {shippingInfo.zip}</Typography>
            <Typography>{shippingInfo.country}</Typography>
            <Typography>{shippingInfo.phone}</Typography>
          </Box>
        </ReviewSection>

        {/* Payment Method */}
        <ReviewSection>
          <SectionHeader>
            <Typography variant="h6">Payment Method</Typography>
            <EditLink onClick={() => handleEditClick(onEditPayment)}>
              Edit
            </EditLink>
          </SectionHeader>
          <Typography sx={{ fontWeight: 500 }}>
            {paymentInfo.paymentMethod === 'credit-card' 
              ? 'Credit/Debit Card ending in ••••' 
              : 'Pay on Delivery (+$5.00 fee)'
            }
          </Typography>
        </ReviewSection>

        {/* Order Items */}
        <ReviewSection>
          <SectionHeader>
            <Typography variant="h6">Order Items</Typography>
          </SectionHeader>
          <Box sx={{ border: `1px solid ${theme.palette.grey[200]}`, borderRadius: '8px', overflow: 'hidden' }}>
            {orderItems.map((item) => (
              <OrderItem key={item.id}>
                <ItemImage src={item.image} alt={item.title} />
                <ItemDetails>
                  <Typography sx={{ fontWeight: 600, marginBottom: '5px', color: theme.palette.text.primary }}>
                    {item.title}
                  </Typography>
                  {item.size && (
                    <Typography variant="body2" sx={{ fontSize: '14px', color: theme.palette.text.secondary, marginBottom: '5px' }}>
                      Size: {item.size}
                    </Typography>
                  )}
                  {item.color && (
                    <Typography variant="body2" sx={{ fontSize: '14px', color: theme.palette.text.secondary, marginBottom: '5px' }}>
                      Color: {item.color}
                    </Typography>
                  )}
                  <Typography sx={{ color: '#2a5c8d', fontWeight: 600 }}>
                    ${item.price.toFixed(2)} × {item.quantity}
                  </Typography>
                </ItemDetails>
                <ItemTotal>
                  ${(item.price * item.quantity).toFixed(2)}
                </ItemTotal>
              </OrderItem>
            ))}
          </Box>
        </ReviewSection>

        {/* Order Summary */}
        <ReviewSection>
          <Typography variant="h6" sx={{ marginBottom: '15px' }}>Order Summary</Typography>
          <Box>
            <SummaryRow>
              <Typography>Subtotal</Typography>
              <Typography>${subtotal.toFixed(2)}</Typography>
            </SummaryRow>
            <SummaryRow>
              <Typography>Shipping</Typography>
              <Typography>Free</Typography>
            </SummaryRow>
            {paymentFee > 0 && (
              <SummaryRow>
                <Typography>Payment Fee</Typography>
                <Typography>${paymentFee.toFixed(2)}</Typography>
              </SummaryRow>
            )}
            <TotalRow>
              <Typography>Total</Typography>
              <Typography>${total.toFixed(2)}</Typography>
            </TotalRow>
          </Box>
        </ReviewSection>

        {/* Terms and Conditions */}
        <Box sx={{ margin: '25px 0' }}>
          <FormControlLabel
            control={
              <Checkbox
                checked={termsAgreed}
                onChange={handleTermsChange}
                sx={{ 
                  color: termsError ? theme.palette.error.main : theme.palette.secondary.main,
                  '&.Mui-checked': {
                    color: theme.palette.secondary.main
                  }
                }}
              />
            }
            label={
              <Typography sx={{ fontWeight: 'normal' }}>
                I agree to the{' '}
                <Link href="#" sx={{ color: '#2a5c8d' }}>Terms and Conditions</Link>
                {' '}and{' '}
                <Link href="#" sx={{ color: '#2a5c8d' }}>Privacy Policy</Link>
              </Typography>
            }
          />
          {termsError && (
            <Typography variant="body2" sx={{ color: theme.palette.error.main, marginTop: '5px' }}>
              You must agree to the terms to proceed
            </Typography>
          )}
        </Box>

        <ActionButtons>
          <Button
            variant="outlined"
            onClick={() => {
              onBack();
              window.scrollTo({ top: 0, behavior: 'smooth' });
            }}
            disabled={isSubmitting}
            sx={{
              color: theme.palette.secondary.main,
              borderColor: theme.palette.secondary.main,
              '&:hover': {
                backgroundColor: 'rgba(212, 167, 98, 0.1)',
                borderColor: theme.palette.secondary.main
              }
            }}
          >
            Back to Payment
          </Button>
          <Button
            type="submit"
            variant="contained"
            disabled={isSubmitting}
            sx={{
              backgroundColor: theme.palette.secondary.main,
              '&:hover': {
                backgroundColor: theme.palette.secondary.light
              },
              display: 'flex',
              alignItems: 'center',
              gap: 1
            }}
          >
            <span>Place Order</span>
            {isSubmitting && <CircularProgress size={20} color="inherit" />}
          </Button>
        </ActionButtons>
      </Box>
    </StyledCard>
  );
};

export default ReviewForm;