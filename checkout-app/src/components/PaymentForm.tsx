import React, { useState, useEffect } from 'react';
import {
  Card,
  CardContent,
  Typography,
  TextField,
  Button,
  Stack,
  Box,
  Radio,
  RadioGroup,
  FormControlLabel,
  FormControl,
  Paper,
  useTheme
} from '@mui/material';
import { styled } from '@mui/material/styles';
import InfoOutlinedIcon from '@mui/icons-material/InfoOutlined';

const StyledCard = styled(Card)(({ theme }) => ({
  backgroundColor: theme.palette.background.paper,
  borderRadius: '8px',
  padding: '30px',
  boxShadow: '0 2px 15px rgba(0,0,0,0.05)',
  marginBottom: '30px'
}));

const PaymentOption = styled(Paper)(({ theme, highlighted }: { theme: any; highlighted?: boolean }) => ({
  border: `1px solid ${highlighted ? '#2a5c8d' : theme.palette.grey[300]}`,
  borderRadius: '8px',
  overflow: 'hidden',
  marginBottom: '15px',
  transition: 'all 0.3s ease',
  boxShadow: highlighted ? '0 0 15px rgba(42, 92, 141, 0.2)' : 'none'
}));

const PaymentLabel = styled('label')(({ theme }) => ({
  display: 'block',
  padding: '15px 20px',
  background: theme.palette.grey[50],
  cursor: 'pointer',
  fontWeight: 600,
  position: 'relative',
  paddingLeft: '50px',
  transition: 'all 0.2s ease',
  '&:hover': {
    background: theme.palette.grey[100]
  }
}));

const PaymentDetails = styled(Box)(({ theme }) => ({
  padding: '20px',
  backgroundColor: theme.palette.background.paper,
  borderTop: `1px solid ${theme.palette.grey[200]}`
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

const FormRow = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  gap: '20px',
  marginBottom: '20px',
  [theme.breakpoints.down('md')]: {
    flexDirection: 'column',
    gap: '0'
  }
}));

interface PaymentFormData {
  paymentMethod: 'credit-card' | 'cash-on-delivery';
  cardholderName: string;
}

interface PaymentFormProps {
  onNext: (data: PaymentFormData) => void;
  onBack: () => void;
  initialData?: Partial<PaymentFormData>;
}

const PaymentForm: React.FC<PaymentFormProps> = ({ 
  onNext, 
  onBack, 
  initialData = {} 
}) => {
  const theme = useTheme();
  const [formData, setFormData] = useState<PaymentFormData>({
    paymentMethod: 'credit-card',
    cardholderName: '',
    ...initialData
  });

  const [errors, setErrors] = useState<Partial<PaymentFormData>>({});
  const [highlightedOption, setHighlightedOption] = useState<string | null>(null);

  const handlePaymentMethodChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const value = event.target.value as 'credit-card' | 'cash-on-delivery';
    setFormData(prev => ({ ...prev, paymentMethod: value }));
    
    if (value === 'cash-on-delivery') {
      setHighlightedOption('cash-on-delivery');
      // Smooth scroll to payment methods section
      setTimeout(() => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }, 100);
      
      // Remove highlight after 3 seconds
      setTimeout(() => {
        setHighlightedOption(null);
      }, 3000);
    }
  };

  const handleChange = (field: keyof PaymentFormData) => (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    setFormData(prev => ({ ...prev, [field]: event.target.value }));
    
    // Clear error when user starts typing
    if (errors[field]) {
      setErrors(prev => ({ ...prev, [field]: undefined }));
    }
  };

  const validateForm = (): boolean => {
    const newErrors: Partial<PaymentFormData> = {};
    
    if (formData.paymentMethod === 'credit-card' && !formData.cardholderName) {
      newErrors.cardholderName = 'Cardholder name is required';
    }

    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = (event: React.FormEvent) => {
    event.preventDefault();
    
    if (validateForm()) {
      onNext(formData);
      // Smooth scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
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
        Payment Method
      </Typography>
      
      <Box component="form" onSubmit={handleSubmit}>
        <FormControl component="fieldset" fullWidth sx={{ margin: '30px 0' }}>
          <RadioGroup
            value={formData.paymentMethod}
            onChange={handlePaymentMethodChange}
          >
            {/* Credit Card Payment */}
            <PaymentOption highlighted={false}>
              <FormControlLabel
                value="credit-card"
                control={<Radio sx={{ display: 'none' }} />}
                label=""
                sx={{ margin: 0 }}
              />
              <PaymentLabel>
                <Radio
                  checked={formData.paymentMethod === 'credit-card'}
                  onChange={handlePaymentMethodChange}
                  value="credit-card"
                  sx={{
                    position: 'absolute',
                    left: '20px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: theme.palette.grey[400],
                    '&.Mui-checked': {
                      color: '#2a5c8d'
                    }
                  }}
                />
                Pay with Card
              </PaymentLabel>
              
              {formData.paymentMethod === 'credit-card' && (
                <PaymentDetails>
                  <Stack spacing={3}>
                    <TextField
                      fullWidth
                      label="Name on Card"
                      placeholder="John Smith"
                      value={formData.cardholderName}
                      onChange={handleChange('cardholderName')}
                      error={!!errors.cardholderName}
                      helperText={errors.cardholderName}
                      required
                    />
                    
                    <TextField
                      fullWidth
                      label="Card Number"
                      placeholder="1234 5678 9012 3456"
                      disabled
                      helperText="Stripe integration would be implemented here"
                    />
                    
                    <FormRow>
                      <TextField
                        fullWidth
                        label="Expiration Date"
                        placeholder="MM/YY"
                        disabled
                        helperText="Stripe element"
                      />
                      <TextField
                        fullWidth
                        label="CVC"
                        placeholder="123"
                        disabled
                        helperText="Stripe element"
                      />
                    </FormRow>
                    
                    <TextField
                      fullWidth
                      label="Postal Code"
                      placeholder="12345"
                      disabled
                      helperText="Stripe element"
                    />
                  </Stack>
                </PaymentDetails>
              )}
            </PaymentOption>

            {/* Cash on Delivery */}
            <PaymentOption highlighted={highlightedOption === 'cash-on-delivery'}>
              <FormControlLabel
                value="cash-on-delivery"
                control={<Radio sx={{ display: 'none' }} />}
                label=""
                sx={{ margin: 0 }}
              />
              <PaymentLabel>
                <Radio
                  checked={formData.paymentMethod === 'cash-on-delivery'}
                  onChange={handlePaymentMethodChange}
                  value="cash-on-delivery"
                  sx={{
                    position: 'absolute',
                    left: '20px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: theme.palette.grey[400],
                    '&.Mui-checked': {
                      color: '#2a5c8d'
                    }
                  }}
                />
                Pay on Delivery
              </PaymentLabel>
              
              {formData.paymentMethod === 'cash-on-delivery' && (
                <PaymentDetails>
                  <Typography sx={{ marginBottom: '15px' }}>
                    Pay with cash upon delivery. An additional $5.00 fee will be charged for this service.
                  </Typography>
                  <Box sx={{ display: 'flex', alignItems: 'center', gap: 1 }}>
                    <InfoOutlinedIcon sx={{ color: '#2a5c8d', fontSize: '1rem' }} />
                    <Typography variant="body2">
                      Please have exact change ready for the delivery person.
                    </Typography>
                  </Box>
                </PaymentDetails>
              )}
            </PaymentOption>
          </RadioGroup>
        </FormControl>
        
        <ActionButtons>
          <Button
            variant="outlined"
            onClick={() => {
              onBack();
              window.scrollTo({ top: 0, behavior: 'smooth' });
            }}
            sx={{
              color: theme.palette.secondary.main,
              borderColor: theme.palette.secondary.main,
              '&:hover': {
                backgroundColor: 'rgba(212, 167, 98, 0.1)',
                borderColor: theme.palette.secondary.main
              }
            }}
          >
            Back to Shipping
          </Button>
          <Button
            type="submit"
            variant="contained"
            sx={{
              backgroundColor: theme.palette.secondary.main,
              '&:hover': {
                backgroundColor: theme.palette.secondary.light
              }
            }}
          >
            Review Order
          </Button>
        </ActionButtons>
      </Box>
    </StyledCard>
  );
};

export default PaymentForm;