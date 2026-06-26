import React, { useState } from 'react';
import {
  AppBar,
  Toolbar,
  Typography,
  Box,
  TextField,
  IconButton,
  Badge,
  Stack,
  Container,
  useTheme,
  useMediaQuery
} from '@mui/material';
import { styled } from '@mui/material/styles';
import MenuOutlinedIcon from '@mui/icons-material/MenuOutlined';
import PersonOutlineOutlinedIcon from '@mui/icons-material/PersonOutlineOutlined';
import FavoriteOutlinedIcon from '@mui/icons-material/FavoriteOutlined';
import ShoppingBagOutlinedIcon from '@mui/icons-material/ShoppingBagOutlined';
import ManageSearchOutlinedIcon from '@mui/icons-material/ManageSearchOutlined';

const StyledAppBar = styled(AppBar)(({ theme }) => ({
  backgroundColor: theme.palette.background.paper,
  color: theme.palette.text.primary,
  boxShadow: '0 2px 10px rgba(0, 0, 0, 0.1)',
  position: 'sticky'
}));

const Logo = styled(Typography)(({ theme }) => ({
  fontFamily: 'Playfair Display, serif',
  fontWeight: 700,
  fontSize: '1.8rem',
  color: theme.palette.primary.main,
  textDecoration: 'none',
  cursor: 'pointer'
}));

const SearchContainer = styled(Box)(({ theme }) => ({
  display: 'flex',
  border: `1px solid ${theme.palette.grey[300]}`,
  borderRadius: theme.shape.borderRadius,
  overflow: 'hidden',
  backgroundColor: theme.palette.background.paper
}));

const SearchInput = styled(TextField)(({ theme }) => ({
  '& .MuiOutlinedInput-root': {
    border: 'none',
    '& fieldset': {
      border: 'none'
    }
  },
  '& .MuiInputBase-input': {
    padding: '8px 12px',
    minWidth: '200px'
  }
}));

const SearchButton = styled(IconButton)(({ theme }) => ({
  backgroundColor: theme.palette.grey[50],
  borderRadius: 0,
  padding: '8px 12px',
  '&:hover': {
    backgroundColor: theme.palette.grey[100]
  }
}));

const UserActionButton = styled(IconButton)(({ theme }) => ({
  color: theme.palette.primary.main,
  fontSize: '1.2rem'
}));

interface CheckoutHeaderProps {
  cartCount?: number;
  wishlistCount?: number;
}

const CheckoutHeader: React.FC<CheckoutHeaderProps> = ({ 
  cartCount = 0, 
  wishlistCount = 0 
}) => {
  const theme = useTheme();
  const isMobile = useMediaQuery(theme.breakpoints.down('md'));
  const [searchValue, setSearchValue] = useState('');

  const handleSearch = () => {
    console.log('Search:', searchValue);
  };

  return (
    <StyledAppBar>
      <Container maxWidth="lg">
        <Toolbar sx={{ padding: '15px 0', justifyContent: 'space-between' }}>
          <Stack direction="row" alignItems="center" spacing={2}>
            {isMobile && (
              <IconButton sx={{ display: { xs: 'block', md: 'none' } }}>
                <MenuOutlinedIcon />
              </IconButton>
            )}
            <Logo component="a" href="/">
              FashionHub
            </Logo>
          </Stack>

          {!isMobile && (
            <SearchContainer>
              <SearchInput
                placeholder="Search products..."
                value={searchValue}
                onChange={(e) => setSearchValue(e.target.value)}
                onKeyPress={(e) => e.key === 'Enter' && handleSearch()}
                size="small"
              />
              <SearchButton onClick={handleSearch}>
                <ManageSearchOutlinedIcon />
              </SearchButton>
            </SearchContainer>
          )}

          <Stack direction="row" spacing={2} alignItems="center">
            <UserActionButton>
              <PersonOutlineOutlinedIcon />
            </UserActionButton>
            
            <UserActionButton>
              <Badge 
                badgeContent={wishlistCount} 
                color="secondary"
                sx={{
                  '& .MuiBadge-badge': {
                    backgroundColor: theme.palette.secondary.main,
                    color: theme.palette.secondary.contrastText,
                    fontSize: '0.7rem',
                    minWidth: '18px',
                    height: '18px'
                  }
                }}
              >
                <FavoriteOutlinedIcon />
              </Badge>
            </UserActionButton>
            
            <UserActionButton>
              <Badge 
                badgeContent={cartCount} 
                color="secondary"
                sx={{
                  '& .MuiBadge-badge': {
                    backgroundColor: theme.palette.secondary.main,
                    color: theme.palette.secondary.contrastText,
                    fontSize: '0.7rem',
                    minWidth: '18px',
                    height: '18px'
                  }
                }}
              >
                <ShoppingBagOutlinedIcon />
              </Badge>
            </UserActionButton>
          </Stack>
        </Toolbar>
      </Container>
    </StyledAppBar>
  );
};

export default CheckoutHeader;