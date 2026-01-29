// Password Toggle Visibility
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
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
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const email = this.querySelector('input[name="email"]').value;
    const password = this.querySelector('input[name="password"]').value;

    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all required fields.');
    }
});

// Auto-fill demo credentials on click
document.querySelectorAll('.demo-credentials p').forEach(item => {
    item.addEventListener('click', function () {
        const text = this.textContent;
        if (text.includes('Email:')) {
            document.querySelector('input[name="email"]').value = 'student@gmail.com';
        } else if (text.includes('Password:')) {
            document.getElementById('password').value = '12345';
        }
    });
});

// Social login buttons
document.querySelectorAll('.social-btn').forEach(button => {
    button.addEventListener('click', function () {
        const provider = this.classList.contains('google') ? 'Google' : 'Microsoft';
        alert(`${provider} login would be integrated here in a real application.`);
    });
});

// Check if coming from registration
if (window.location.search.includes('registered=success')) {
    // Scroll to form
    document.querySelector('.login-card').scrollIntoView({ behavior: 'smooth' });
}