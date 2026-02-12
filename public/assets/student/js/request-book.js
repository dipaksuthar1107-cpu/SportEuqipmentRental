// Mobile sidebar toggle
document.getElementById('mobileToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('mobileToggle');

    if (window.innerWidth <= 992 &&
        !sidebar.contains(event.target) &&
        !toggleBtn.contains(event.target) &&
        sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});

// Set minimum pickup date to tomorrow
document.addEventListener('DOMContentLoaded', function () {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowFormatted = tomorrow.toISOString().split('T')[0];
    document.getElementById('pickupDate').min = tomorrowFormatted;
});

// Calculate return date based on duration
document.getElementById('duration').addEventListener('change', function () {
    const pickupDate = document.getElementById('pickupDate').value;
    const duration = parseInt(this.value);

    if (pickupDate && duration) {
        const pickup = new Date(pickupDate);
        const returnDate = new Date(pickup);
        returnDate.setDate(pickup.getDate() + duration);

        // Show return date info
        const returnFormatted = returnDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Update form text
        const durationField = this.closest('.form-group');
        let infoText = durationField.querySelector('.form-text');
        if (!infoText.querySelector('.return-info')) {
            const returnInfo = document.createElement('div');
            returnInfo.className = 'return-info mt-1';
            returnInfo.style.color = 'var(--accent)';
            returnInfo.style.fontWeight = '600';
            infoText.appendChild(returnInfo);
        }

        const returnInfo = infoText.querySelector('.return-info');
        returnInfo.innerHTML = `<i class="fas fa-calendar-check me-1"></i> Expected return: ${returnFormatted}`;
    }
});

// Update return date when pickup date changes
document.getElementById('pickupDate').addEventListener('change', function () {
    const duration = document.getElementById('duration');
    if (duration.value) {
        duration.dispatchEvent(new Event('change'));
    }
});

// Form submission
document.getElementById('requestForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form values
    const equipment = document.querySelector('input[type="text"]').value;
    const quantity = document.getElementById('quantity').value;
    const duration = document.getElementById('duration').value;
    const pickupDate = document.getElementById('pickupDate').value;
    const pickupTime = document.getElementById('pickupTime').value;
    const agreeRules = document.getElementById('agreeRules').checked;

    // Validation
    if (!agreeRules) {
        alert('You must agree to the rental rules and conditions.');
        return;
    }

    if (!pickupDate || !pickupTime || !duration) {
        alert('Please fill in all required fields.');
        return;
    }

    // Show loading state
    const submitBtn = this.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
    submitBtn.disabled = true;

    // AJAX Call
    const formData = {
        _token: document.querySelector('input[name="_token"]').value,
        equipment_id: document.getElementById('equipment_id').value,
        quantity: quantity,
        duration: duration,
        pickup_date: pickupDate,
        pickup_time: pickupTime,
        purpose: document.getElementById('purpose').value
    };

    fetch('/student/request-book', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': formData._token,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
});

// Quantity validation
document.getElementById('quantity').addEventListener('change', function () {
    const value = parseInt(this.value);
    if (value < 1) {
        this.value = 1;
    } else if (value > 5) {
        this.value = 5;
        alert('Maximum quantity per request is 5 items.');
    }
});

// Phone number formatting
document.getElementById('emergencyContact').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');

    if (value.length > 0) {
        if (value.length <= 3) {
            value = value;
        } else if (value.length <= 5) {
            value = `${value.slice(0, 3)} ${value.slice(3)}`;
        } else if (value.length <= 8) {
            value = `${value.slice(0, 3)} ${value.slice(3, 5)} ${value.slice(5)}`;
        } else {
            value = `${value.slice(0, 3)} ${value.slice(3, 5)} ${value.slice(5, 8)} ${value.slice(8, 12)}`;
        }
    }

    e.target.value = value;
});

// Add hover effect to form elements
const formControls = document.querySelectorAll('.form-control, .form-select');
formControls.forEach(control => {
    control.addEventListener('focus', function () {
        this.style.borderColor = 'var(--primary)';
        this.style.boxShadow = '0 0 0 3px rgba(42, 92, 170, 0.2)';
    });

    control.addEventListener('blur', function () {
        this.style.borderColor = '#ddd';
        this.style.boxShadow = 'none';
    });
});