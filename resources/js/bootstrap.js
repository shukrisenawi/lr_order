import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add CSRF token to axios requests
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Function to refresh CSRF token by making a request to keep session alive
function refreshCsrfToken() {
    // Make a simple authenticated request to keep session alive
    window.axios.get('/api/user').then(response => {
        // Session is still active, no need to do anything
        console.log('Session refreshed successfully');
    }).catch(error => {
        if (error.response && (error.response.status === 401 || error.response.status === 419)) {
            // Session expired, redirect will be handled by interceptor
            console.log('Session expired during refresh');
        } else {
            console.log('Failed to refresh session:', error);
        }
    });
}

// Refresh session every 30 minutes (half of session lifetime)
setInterval(refreshCsrfToken, 30 * 60 * 1000);

// Handle expired sessions (419 error) and redirect to login
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            if (error.response.status === 419) {
                // CSRF token expired or session expired
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesi Tamat',
                    text: 'Sesi anda telah tamat. Sila log masuk semula.',
                    confirmButtonText: 'Log Masuk',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = '/login';
                });
            } else if (error.response.status === 401) {
                // User not authenticated
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Disahkan',
                    text: 'Sila log masuk untuk meneruskan.',
                    confirmButtonText: 'Log Masuk',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    window.location.href = '/login';
                });
            }
        }
        return Promise.reject(error);
    }
);
