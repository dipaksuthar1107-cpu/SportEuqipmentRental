// Password Toggle Visibility
function setupPasswordToggle(passwordId, toggleId) {
    const passwordInput = document.getElementById(passwordId);
    const toggleButton = document.getElementById(toggleId);

    toggleButton.addEventListener('click', function () {
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
}

// Initialize password toggles
document.addEventListener('DOMContentLoaded', function () {
    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('confirmPassword', 'toggleConfirmPassword');

    // Focus on first input field
    document.querySelector('input[name="fullname"]').focus();
});

// Password strength checker
document.getElementById('password').addEventListener('input', function () {
    const password = this.value;
    const strengthBar = document.getElementById('passwordStrengthBar');
    const reqLength = document.getElementById('reqLength');
    const reqUppercase = document.getElementById('reqUppercase');
    const reqNumber = document.getElementById('reqNumber');

    let strength = 0;
    let barWidth = 0;
    let barClass = '';

    // Check length
    if (password.length >= 6) {
        strength++;
        reqLength.classList.remove('invalid');
        reqLength.classList.add('valid');
        reqLength.querySelector('i').className = 'fas fa-check-circle';
    } else {
        reqLength.classList.remove('valid');
        reqLength.classList.add('invalid');
        reqLength.querySelector('i').className = 'fas fa-circle';
    }

    // Check uppercase
    if (/[A-Z]/.test(password)) {
        strength++;
        reqUppercase.classList.remove('invalid');
        reqUppercase.classList.add('valid');
        reqUppercase.querySelector('i').className = 'fas fa-check-circle';
    } else {
        reqUppercase.classList.remove('valid');
        reqUppercase.classList.add('invalid');
        reqUppercase.querySelector('i').className = 'fas fa-circle';
    }

    // Check number
    if (/[0-9]/.test(password)) {
        strength++;
        reqNumber.classList.remove('invalid');
        reqNumber.classList.add('valid');
        reqNumber.querySelector('i').className = 'fas fa-check-circle';
    } else {
        reqNumber.classList.remove('valid');
        reqNumber.classList.add('invalid');
        reqNumber.querySelector('i').className = 'fas fa-circle';
    }

    // Calculate strength percentage and color
    if (strength === 0) {
        barWidth = 0;
        barClass = '';
    } else if (strength === 1) {
        barWidth = 33;
        barClass = 'strength-weak';
    } else if (strength === 2) {
        barWidth = 66;
        barClass = 'strength-medium';
    } else if (strength === 3) {
        barWidth = 100;
        barClass = 'strength-strong';
    }

    // Update strength bar
    strengthBar.style.width = barWidth + '%';
    strengthBar.className = 'password-strength-bar ' + barClass;

    // Check password match
    checkPasswordMatch();
});

// Check if passwords match
function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const matchError = document.getElementById('passwordMatchError');

    if (confirmPassword === '') {
        matchError.style.display = 'none';
        return;
    }

    if (password === confirmPassword) {
        matchError.style.display = 'none';
        document.getElementById('confirmPassword').classList.remove('is-invalid');
        document.getElementById('confirmPassword').classList.add('is-valid');
    } else {
        matchError.style.display = 'flex';
        document.getElementById('confirmPassword').classList.add('is-invalid');
        document.getElementById('confirmPassword').classList.remove('is-valid');
    }
}

// Check password match on confirm password input
document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);

// Form validation
document.getElementById('registrationForm').addEventListener('submit', function (e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const agreeTerms = document.getElementById('agreeTerms').checked;

    // Check password match
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match. Please check and try again.');
        return;
    }

    // Check password strength
    if (password.length < 6) {
        e.preventDefault();
        alert('Password must be at least 6 characters long.');
        return;
    }

    // Check terms agreement
    if (!agreeTerms) {
        e.preventDefault();
        alert('You must agree to the terms and conditions.');
        return;
    }

    // If all validations pass, show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...';
    submitBtn.disabled = true;
});

// Auto-format phone number
document.querySelector('input[name="phone"]').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length > 0) {
        if (value.length <= 3) {
            value = value;
        } else if (value.length <= 6) {
            value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
        } else {
            value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6, 10)}`;
        }
    }

    e.target.value = value;
});