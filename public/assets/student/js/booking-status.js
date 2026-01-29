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

// Filter bookings by status
const filterButtons = document.querySelectorAll('.filter-btn');
const bookingCards = document.querySelectorAll('.booking-card');

filterButtons.forEach(button => {
    button.addEventListener('click', function () {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));

        // Add active class to clicked button
        this.classList.add('active');

        const filter = this.getAttribute('data-filter');

        // Show/hide cards based on filter
        bookingCards.forEach(card => {
            if (filter === 'all' || card.getAttribute('data-status') === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// View booking details
function viewBookingDetails(bookingId) {
    alert('Viewing details for booking #' + bookingId + '\n\nThis would show detailed booking information in a real application.');
}

// Cancel booking
function cancelBooking(bookingId) {
    if (confirm('Are you sure you want to cancel this booking?\n\nDeposit will be refunded if cancelled before pickup.')) {
        alert('Booking #' + bookingId + ' has been cancelled.\n\nDeposit refund will be processed within 3-5 business days.');
        // In real app, update database and refresh page
    }
}

// Add hover effects to booking cards
bookingCards.forEach(card => {
    card.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-5px)';
    });

    card.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
    });
});