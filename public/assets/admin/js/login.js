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
    const username = this.querySelector('input[name="username"]').value;
    const password = this.querySelector('input[name="password"]').value;

    if (!username || !password) {
        e.preventDefault();
        showAlert('Please fill in all required fields.', 'warning');
        return;
    }

    // Add loading state to button
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Authenticating...';
    submitBtn.disabled = true;

    // Reset button after 3 seconds (in case form submission fails)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Auto-fill demo credentials
document.querySelectorAll('.demo-credentials p').forEach(item => {
    item.addEventListener('click', function () {
        const text = this.textContent;
        if (text.includes('Username:')) {
            const usernameInput = document.querySelector('input[name="username"]');
            usernameInput.value = 'admin@gmail.com';
            usernameInput.focus();
            showAlert('Demo username filled. Tab to password field.', 'info');
        } else if (text.includes('Password:')) {
            const passwordInput = document.getElementById('adminPassword');
            passwordInput.value = '12345';
            passwordInput.focus();
            showAlert('Demo password filled. Click Login to proceed.', 'info');
        }
    });
});

// Show alert function
function showAlert(message, type) {
    // Remove any existing alert
    const existingAlert = document.querySelector('.alert-toast');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'warning' ? 'warning' : 'danger'} alert-toast fade-in`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        animation: fadeIn 0.3s ease forwards;
    `;

    const icon = type === 'warning' ? 'fa-exclamation-triangle' :
        type === 'info' ? 'fa-info-circle' :
            'fa-exclamation-circle';

    alertDiv.innerHTML = `
        <i class="fas ${icon}"></i>
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

// Focus on username field when page loads
document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.querySelector('input[name="username"]');
    if (usernameInput && !usernameInput.value) {
        usernameInput.focus();
    }

    // Add security warning for admin access
    console.log('%c⚠️ SECURITY WARNING ⚠️', 'color: #dc3545; font-size: 18px; font-weight: bold;');
    console.log('%cThis is a restricted admin portal. Unauthorized access attempts will be logged and reported.', 'color: #ffc107; font-size: 14px;');

    // Initialize idle timer for security
    initIdleTimer();

    // Add click handler for remember me checkbox
    const rememberCheckbox = document.getElementById('rememberAdmin');
    if (rememberCheckbox) {
        rememberCheckbox.addEventListener('change', function () {
            if (this.checked) {
                showAlert('Device will be remembered for 30 days. Do not use on public computers.', 'warning');
            }
        });
    }

    // Add auto-clear on wrong credentials
    const errorAlert = document.querySelector('.alert-danger');
    if (errorAlert) {
        // Clear password field on error
        const passwordInput = document.getElementById('adminPassword');
        if (passwordInput) {
            passwordInput.value = '';
            passwordInput.focus();
        }
    }
});

// Auto-logout warning for idle time
let idleTimer;
let idleWarningShown = false;

function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleWarningShown = false;

    idleTimer = setTimeout(() => {
        const username = document.querySelector('input[name="username"]').value;
        const password = document.getElementById('adminPassword').value;

        if (username || password) {
            if (!idleWarningShown) {
                showAlert('For security, form will reset due to inactivity.', 'warning');
                idleWarningShown = true;

                // Reset form after additional 30 seconds
                setTimeout(() => {
                    document.getElementById('adminLoginForm').reset();
                    showAlert('Form has been reset for security.', 'info');
                }, 30000);
            }
        }
    }, 180000); // 3 minutes of inactivity
}

function initIdleTimer() {
    // Reset timer on user activity
    ['mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
        document.addEventListener(event, resetIdleTimer);
    });

    // Initialize idle timer
    resetIdleTimer();
}

// Add keyboard shortcuts
document.addEventListener('keydown', function (e) {
    // Ctrl+Enter to submit form
    if (e.ctrlKey && e.key === 'Enter') {
        document.getElementById('adminLoginForm').submit();
    }

    // Escape to clear form
    if (e.key === 'Escape') {
        if (confirm('Clear all form fields?')) {
            document.getElementById('adminLoginForm').reset();
            document.querySelector('input[name="username"]').focus();
        }
    }
});

// Add form auto-save for username (localStorage)
const usernameInput = document.querySelector('input[name="username"]');
if (usernameInput) {
    // Load saved username if exists
    const savedUsername = localStorage.getItem('admin_username');
    if (savedUsername) {
        usernameInput.value = savedUsername;
    }

    // Save username on input
    usernameInput.addEventListener('input', function () {
        if (this.value) {
            localStorage.setItem('admin_username', this.value);
        }
    });
}

// Add form submission tracking
const loginForm = document.getElementById('adminLoginForm');
if (loginForm) {
    let attempts = 0;

    loginForm.addEventListener('submit', function () {
        attempts++;

        // Log attempts (in real app, send to server)
        console.log(`Admin login attempt #${attempts}`);

        // Show warning after 3 attempts
        if (attempts >= 3) {
            showAlert('Multiple failed attempts may lock your account.', 'warning');
        }
    });
}

// Add security timer
let startTime = Date.now();
setInterval(() => {
    const elapsedSeconds = Math.floor((Date.now() - startTime) / 1000);
    if (elapsedSeconds > 300) { // 5 minutes
        console.log('Security: Admin login page open for', elapsedSeconds, 'seconds');
    }
}, 60000); // Log every minute