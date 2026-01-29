// Mobile sidebar toggle
document.addEventListener('DOMContentLoaded', function () {
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebar = document.getElementById('sidebar');

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function () {
            sidebar.classList.toggle('active');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('mobileToggle');

        if (window.innerWidth <= 992 &&
            sidebar && toggleBtn &&
            !sidebar.contains(event.target) &&
            !toggleBtn.contains(event.target) &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    // Request Equipment Button
    const requestBtn = document.getElementById('requestEquipmentBtn');
    if (requestBtn) {
        requestBtn.addEventListener('click', function () {
            // Show the request modal
            const requestModal = new bootstrap.Modal(document.getElementById('requestModal'));
            requestModal.show();
        });
    }

    // Form submission
    const requestForm = document.getElementById('equipmentRequestForm');
    if (requestForm) {
        requestForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form values
            const pickupDate = document.getElementById('pickupDate').value;
            const returnDate = document.getElementById('returnDate').value;
            const pickupTime = document.getElementById('pickupTime').value;
            const quantity = document.getElementById('quantity').value;
            const instructions = document.getElementById('instructions').value;

            // Validate dates
            if (!pickupDate || !returnDate) {
                alert('Please select both pickup and return dates.');
                return;
            }

            // Check if return date is after pickup date
            const pickup = new Date(pickupDate);
            const returnD = new Date(returnDate);

            if (returnD < pickup) {
                alert('Return date must be after pickup date.');
                return;
            }

            // Calculate days
            const timeDiff = returnD.getTime() - pickup.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

            // Check if exceeds max days
            const maxDays = 14;
            if (daysDiff > maxDays) {
                alert(`Maximum rental period is ${maxDays} days. Please adjust your dates.`);
                return;
            }

            // Calculate total cost
            const dailyRate = 1000;
            const deposit = 500;
            const totalCost = (daysDiff * dailyRate * quantity) + (deposit * quantity);

            // Show success message with booking details
            const equipmentName = "<?php echo $equipment['name']; ?>";
            const message = `
            ✅ Booking Request Submitted Successfully!
            
            Equipment: ${equipmentName}
            Quantity: ${quantity}
            Pickup Date: ${pickupDate} at ${pickupTime}
            Return Date: ${returnDate}
            Rental Period: ${daysDiff} days
            
            Estimated Total: ₹${totalCost}
            (Deposit: ₹${deposit * quantity} + Rental: ₹${daysDiff * dailyRate * quantity})
            
            You will receive confirmation within 24 hours.
            `;

            alert(message);

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('requestModal'));
            modal.hide();

            // Reset form
            requestForm.reset();

            // Redirect to booking status page
            setTimeout(() => {
                window.location.href = 'booking-status.php';
            }, 2000);
        });
    }

    // Set minimum date to today
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    const todayStr = today.toISOString().split('T')[0];
    const tomorrowStr = tomorrow.toISOString().split('T')[0];

    const pickupDateInput = document.getElementById('pickupDate');
    const returnDateInput = document.getElementById('returnDate');

    if (pickupDateInput) {
        pickupDateInput.min = todayStr;
        pickupDateInput.value = todayStr;
    }

    if (returnDateInput) {
        returnDateInput.min = tomorrowStr;
        returnDateInput.value = tomorrowStr;
    }

    // Update return date min when pickup date changes
    if (pickupDateInput && returnDateInput) {
        pickupDateInput.addEventListener('change', function () {
            const selectedDate = new Date(this.value);
            const nextDay = new Date(selectedDate);
            nextDay.setDate(nextDay.getDate() + 1);

            returnDateInput.min = nextDay.toISOString().split('T')[0];

            // If current return date is before new min, update it
            const currentReturn = new Date(returnDateInput.value);
            if (currentReturn < nextDay) {
                returnDateInput.value = nextDay.toISOString().split('T')[0];
            }
        });
    }

    // Add active class to sidebar links
    const currentPage = window.location.pathname.split('/').pop();
    const sidebarLinks = document.querySelectorAll('.sidebar-menu a');

    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || (currentPage === 'equipment-details.php' && href === 'equipment-list.php')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }

        // Add click event to navigate
        link.addEventListener('click', function (e) {
            if (this.getAttribute('href') !== '#') {
                window.location.href = this.getAttribute('href');
            }
        });
    });
});