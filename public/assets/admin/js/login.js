// Password Toggle Visibility
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('adminPassword');
    const icon = this.querySelector('i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Form validation
document.getElementById('adminLoginForm').addEventListener('submit', function (e) {
    const email = this.querySelector('input[name="email"]').value;
    const password = this.querySelector('input[name="password"]').value;

    if (!email || !password) {
        e.preventDefault();
        showAlert('Please fill in all required fields.', 'warning');
    }
});

// Auto-fill demo credentials
document.querySelectorAll('.demo-credentials p').forEach(item => {
    item.addEventListener('click', function () {
        const text = this.textContent;
        if (text.includes('Username:')) {
            document.querySelector('input[name="email"]').value = 'admin@gmail.com';
        } else if (text.includes('Password:')) {
            document.getElementById('adminPassword').value = '12345';
        }
    });
});

// Show alert function
function showAlert(message, type) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'warning' ? 'warning' : 'danger'} fade-in`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    `;
    alertDiv.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    `;

    document.body.appendChild(alertDiv);

    // Remove alert after 4 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 4000);
}

// Focus on email field
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.querySelector('input[name="email"]');
    if (emailInput) emailInput.focus();

    // Add security warning for admin access
    console.log('%c⚠️ SECURITY WARNING ⚠️', 'color: #dc3545; font-size: 18px; font-weight: bold;');
    console.log('%cThis is a restricted admin portal. Unauthorized access attempts will be logged and reported.', 'color: #ffc107; font-size: 14px;');
});

// Auto-logout warning
let idleTimer;
function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(() => {
        const emailValue = document.querySelector('input[name="email"]').value;
        const passwordValue = document.querySelector('input[name="password"]').value;
        if (emailValue || passwordValue) {
            showAlert('For security, session will expire due to inactivity.', 'warning');
        }
    }, 300000); // 5 minutes
}

// Reset timer on user activity
['mousemove', 'keypress', 'click'].forEach(event => {
    document.addEventListener(event, resetIdleTimer);
});

// Initialize idle timer
resetIdleTimer();