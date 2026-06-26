import React, { useState } from 'react';
import {
  Card,
  CardContent,
  Typography,
  TextField,
  Button,
  Stack,
  Box,
  FormControlLabel,
  Checkbox,
  MenuItem,
  useTheme
} from '@mui/material';
import { styled } from '@mui/material/styles';

const StyledCard = styled(Card)(({ theme }) => ({
  backgroundColor: theme.palette.background.paper,
  borderRadius: '8px',
  padding: '30px',
  boxShadow: '0 2px 15px rgba(0,0,0,0.05)',
  marginBottom: '30px'
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

const ActionButtons = styled(Stack)(({ theme }) => ({
  flexDirection: 'row',
  justifyContent: 'space-between',
  marginTop: '30px',
  [theme.breakpoints.down('md')]: {
    flexDirection: 'column-reverse',
    gap: '15px'
  }
}));

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

interface ShippingFormProps {
  onNext: (data: ShippingFormData) => void;
  onBack: () => void;
  initialData?: Partial<ShippingFormData>;
}

const countries = [
  { value: 'US', label: 'United States' },
  { value: 'UK', label: 'United Kingdom' },
  { value: 'CA', label: 'Canada' },
  { value: 'AU', label: 'Australia' },
  { value: 'DE', label: 'Germany' },
  { value: 'FR', label: 'France' }
];

const ShippingForm: React.FC<ShippingFormProps> = ({ 
  onNext, 
  onBack, 
  initialData = {} 
}) => {
  const theme = useTheme();
  const [formData, setFormData] = useState<ShippingFormData>({
    email: '',
    firstName: '',
    lastName: '',
    address: '',
    address2: '',
    city: '',
    country: '',
    state: '',
    zip: '',
    phone: '',
    saveAddress: false,
    ...initialData
  });

  const [errors, setErrors] = useState<Partial<ShippingFormData>>({});

  const handleChange = (field: keyof ShippingFormData) => (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    const value = event.target.type === 'checkbox' 
      ? event.target.checked 
      : event.target.value;
    
    setFormData(prev => ({ ...prev, [field]: value }));
    
    // Clear error when user starts typing
    if (errors[field]) {
      setErrors(prev => ({ ...prev, [field]: undefined }));
    }
  };

  const validateForm = (): boolean => {
    const newErrors: Partial<ShippingFormData> = {};
    
    if (!formData.email) newErrors.email = 'Email is required';
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
      newErrors.email = 'Please enter a valid email address';
    }
    
    if (!formData.firstName) newErrors.firstName = 'First name is required';
    if (!formData.lastName) newErrors.lastName = 'Last name is required';
    if (!formData.address) newErrors.address = 'Address is required';
    if (!formData.city) newErrors.city = 'City is required';
    if (!formData.country) newErrors.country = 'Country is required';
    if (!formData.state) newErrors.state = 'State/Province is required';
    if (!formData.zip) newErrors.zip = 'ZIP/Postal code is required';
    if (!formData.phone) newErrors.phone = 'Phone number is required';

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
        Shipping Information
      </Typography>
      
      <Box component="form" onSubmit={handleSubmit}>
        <Stack spacing={3}>
          <TextField
            fullWidth
            label="Email Address"
            type="email"
            value={formData.email}
            onChange={handleChange('email')}
            error={!!errors.email}
            helperText={errors.email}
            required
          />
          
          <FormRow>
            <TextField
              fullWidth
              label="First Name"
              value={formData.firstName}
              onChange={handleChange('firstName')}
              error={!!errors.firstName}
              helperText={errors.firstName}
              required
            />
            <TextField
              fullWidth
              label="Last Name"
              value={formData.lastName}
              onChange={handleChange('lastName')}
              error={!!errors.lastName}
              helperText={errors.lastName}
              required
            />
          </FormRow>
          
          <TextField
            fullWidth
            label="Address"
            value={formData.address}
            onChange={handleChange('address')}
            error={!!errors.address}
            helperText={errors.address}
            required
          />
          
          <TextField
            fullWidth
            label="Apartment, suite, etc. (optional)"
            value={formData.address2}
            onChange={handleChange('address2')}
          />
          
          <FormRow>
            <TextField
              fullWidth
              label="City"
              value={formData.city}
              onChange={handleChange('city')}
              error={!!errors.city}
              helperText={errors.city}
              required
            />
            <TextField
              fullWidth
              select
              label="Country"
              value={formData.country}
              onChange={handleChange('country')}
              error={!!errors.country}
              helperText={errors.country}
              required
            >
              <MenuItem value="">Select Country</MenuItem>
              {countries.map((country) => (
                <MenuItem key={country.value} value={country.value}>
                  {country.label}
                </MenuItem>
              ))}
            </TextField>
          </FormRow>
          
          <FormRow>
            <TextField
              fullWidth
              label="State/Province"
              value={formData.state}
              onChange={handleChange('state')}
              error={!!errors.state}
              helperText={errors.state}
              required
            />
            <TextField
              fullWidth
              label="ZIP/Postal Code"
              value={formData.zip}
              onChange={handleChange('zip')}
              error={!!errors.zip}
              helperText={errors.zip}
              required
            />
          </FormRow>
          
          <TextField
            fullWidth
            label="Phone"
            type="tel"
            value={formData.phone}
            onChange={handleChange('phone')}
            error={!!errors.phone}
            helperText={errors.phone}
            required
          />
          
          <FormControlLabel
            control={
              <Checkbox
                checked={formData.saveAddress}
                onChange={handleChange('saveAddress')}
                sx={{ color: theme.palette.secondary.main }}
              />
            }
            label="Save this information for next time"
            sx={{ marginTop: '25px' }}
          />
        </Stack>
        
        <ActionButtons>
          <Button
            variant="outlined"
            onClick={onBack}
            sx={{
              color: theme.palette.secondary.main,
              borderColor: theme.palette.secondary.main,
              '&:hover': {
                backgroundColor: 'rgba(212, 167, 98, 0.1)',
                borderColor: theme.palette.secondary.main
              }
            }}
          >
            Back to Cart
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
            Continue to Payment
          </Button>
        </ActionButtons>
      </Box>
    </StyledCard>
  );
};

export default ShippingForm;