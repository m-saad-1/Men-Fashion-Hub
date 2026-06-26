import { createTheme } from '@mui/material/styles';

const theme = createTheme({
  palette: {
    primary: {
      main: '#2a2a2a',
      contrastText: '#ffffff'
    },
    secondary: {
      main: '#d4a762',
      light: '#c49555',
      contrastText: '#ffffff'
    },
    error: {
      main: '#f44336',
      contrastText: '#ffffff'
    },
    warning: {
      main: '#ff9800',
      contrastText: '#ffffff'
    },
    success: {
      main: '#4caf50',
      contrastText: '#ffffff'
    },
    text: {
      primary: '#333333',
      secondary: '#777777',
      disabled: '#cccccc'
    },
    background: {
      default: '#f9f9f9',
      paper: '#ffffff'
    },
    grey: {
      50: '#f9f9f9',
      100: '#f5f5f5',
      200: '#eeeeee',
      300: '#e0e0e0',
      400: '#bdbdbd',
      500: '#9e9e9e',
      600: '#757575',
      700: '#616161',
      800: '#424242',
      900: '#212121'
    },
    divider: '#e0e0e0'
  },
  typography: {
    fontFamily: 'Roboto, sans-serif',
    h1: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '2.5rem'
    },
    h2: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '2rem'
    },
    h3: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '1.75rem'
    },
    h4: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '1.5rem'
    },
    h5: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '1.25rem'
    },
    h6: {
      fontFamily: 'Playfair Display, serif',
      fontWeight: 700,
      fontSize: '1.1rem'
    }
  },
  shape: {
    borderRadius: 4
  },
  components: {
    MuiButton: {
      styleOverrides: {
        root: {
          textTransform: 'none',
          fontWeight: 500,
          padding: '10px 20px'
        }
      }
    }
  }
});

export default theme;