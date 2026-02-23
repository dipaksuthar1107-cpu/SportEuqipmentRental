// Mobile sidebar toggle
document.getElementById('mobileToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('mobileToggle');

    if (window.innerWidth <= 992 &&
        sidebar &&
        !sidebar.contains(event.target) &&
        !toggleBtn.contains(event.target) &&
        sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});

// Star rating hover effect enhancement
const starLabels = document.querySelectorAll('.star-rating label, .star-rating-small label');
starLabels.forEach(label => {
    label.addEventListener('mouseenter', function () {
        const rating = this.getAttribute('for').replace(/\D/g, '');
        const stars = this.parentElement.querySelectorAll('label');

        stars.forEach((star, index) => {
            const starRating = star.getAttribute('for').replace(/\D/g, '');
            if (starRating <= rating) {
                star.style.color = '#ffc107';
                star.style.transform = 'scale(1.1)';
            }
        });
    });

    label.addEventListener('mouseleave', function () {
        const stars = this.parentElement.querySelectorAll('label');
        const checkedInput = this.parentElement.querySelector('input:checked');

        stars.forEach(star => {
            if (!checkedInput || star.getAttribute('for') !== checkedInput.id) {
                star.style.color = '#ddd';
                star.style.transform = 'scale(1)';
            }
        });

        // Restore checked state
        if (checkedInput) {
            const checkedLabel = document.querySelector(`label[for="${checkedInput.id}"]`);
            if (checkedLabel) {
                checkedLabel.style.color = '#ffc107';
            }
        }
    });
});

// Form submission
document.getElementById('feedbackForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Validation
    if (!data.overallRating || !data.condition || !data.comments || !data.recommend) {
        alert('Please complete all required fields before submitting.');
        return;
    }

    // Show loading state
    const submitBtn = this.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Submitting...';
    submitBtn.disabled = true;

    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // AJAX Call
    fetch('/student/feedback', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                // Hide form and show thank you message
                this.style.display = 'none';
                document.getElementById('thankYouMessage').style.display = 'block';

                // Optional: redirect after delay
                setTimeout(() => {
                    window.location.href = result.redirect || '/student/booking-history';
                }, 3000);
            } else {
                alert(result.message || 'Something went wrong. Please try again.');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please check your connection.');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
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

// Character counter for comments
const commentsTextarea = document.getElementById('comments');
if (commentsTextarea) {
    const commentCounter = document.createElement('div');
    commentCounter.className = 'form-text text-end';
    commentCounter.innerHTML = '<span id="charCount">0</span>/500 characters';
    commentsTextarea.parentElement.appendChild(commentCounter);

    commentsTextarea.addEventListener('input', function () {
        const charCount = this.value.length;
        document.getElementById('charCount').textContent = charCount;

        if (charCount > 500) {
            commentCounter.style.color = '#dc3545';
        } else if (charCount > 400) {
            commentCounter.style.color = '#ffc107';
        } else {
            commentCounter.style.color = '#666';
        }
    });

    // Trigger initial count
    commentsTextarea.dispatchEvent(new Event('input'));
}