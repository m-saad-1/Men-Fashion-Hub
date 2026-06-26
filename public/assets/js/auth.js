// Authentication and Route Guards
(function() {
    const auth = {
        currentUser: null,
        apiBaseUrl: '../../app/api'
    };

    const protectedRoutes = ['cart.php', 'checkout.php', 'account.php'];

    async function checkAuthAndProtectRoutes() {
        try {
            const response = await fetch(`${auth.apiBaseUrl}/auth/validate_session.php`, {
                credentials: 'include',
                headers: {
                    'Cache-Control': 'no-cache'
                }
            });
            
            const data = await response.json();
            const isAuthenticated = data.status === 'success' && data.user;
            
            if (isAuthenticated) {
                auth.currentUser = data.user;
            } else {
                auth.currentUser = null;
            }

            const currentPath = window.location.pathname.split('/').pop();
            
            if (!isAuthenticated && protectedRoutes.includes(currentPath)) {
                // Redirect to login if trying to access protected route
                window.location.href = 'login.php?redirect=' + encodeURIComponent(currentPath);
            }
        } catch (error) {
            console.error('Auth check failed:', error);
            // On error, default to unauthenticated
            auth.currentUser = null;
            
            const currentPath = window.location.pathname.split('/').pop();
            if (protectedRoutes.includes(currentPath)) {
                window.location.href = 'login.php?redirect=' + encodeURIComponent(currentPath);
            }
        }
    }

    // Run the check when the script loads
    document.addEventListener('DOMContentLoaded', checkAuthAndProtectRoutes);
})();
