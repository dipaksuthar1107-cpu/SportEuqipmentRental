// Sidebar toggle functionality
document.getElementById('toggleSidebar').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const footer = document.getElementById('footer');

    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
    footer.classList.toggle('expanded');

    // Change icon based on state
    const icon = this.querySelector('i');
    if (sidebar.classList.contains('collapsed')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-chevron-right');
    } else {
        icon.classList.remove('fa-chevron-right');
        icon.classList.add('fa-bars');
    }
});

// Set current year in footer
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Update booking status
function updateStatus(bookingId, status) {
    const bookingRow = document.getElementById(`booking-${bookingId}`);
    const statusCell = bookingRow.querySelector('td:nth-child(8)');
    const actionCell = bookingRow.querySelector('td:nth-child(9)');

    const statusMap = {
        'pending': { class: 'status-pending', text: 'Pending' },
        'approved': { class: 'status-approved', text: 'Approved' },
        'collected': { class: 'status-collected', text: 'Collected' },
        'returned': { class: 'status-returned', text: 'Returned' },
        'rejected': { class: 'status-rejected', text: 'Rejected' }
    };

    // Update status badge
    statusCell.innerHTML = `<span class="status-badge ${statusMap[status].class}">${statusMap[status].text}</span>`;

    // Update action buttons based on status
    let actionButtons = '';

    if (status === 'approved') {
        actionButtons = `
            <button class="btn btn-sm btn-info me-1" onclick="updateStatus(${bookingId}, 'collected')" data-bs-toggle="tooltip" title="Mark as Collected">
                <i class="fas fa-box-open"></i>
            </button>
            <button class="btn btn-sm btn-warning" onclick="editBooking(${bookingId})" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
        `;
    } else if (status === 'collected') {
        actionButtons = `
            <button class="btn btn-sm btn-secondary me-1" onclick="updateStatus(${bookingId}, 'returned')" data-bs-toggle="tooltip" title="Mark as Returned">
                <i class="fas fa-undo-alt"></i>
            </button>
            <button class="btn btn-sm btn-warning" onclick="editBooking(${bookingId})" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
        `;
    } else if (status === 'returned') {
        actionButtons = `
            <button class="btn btn-sm btn-success me-1" onclick="completeBooking(${bookingId})" data-bs-toggle="tooltip" title="Complete">
                <i class="fas fa-flag-checkered"></i>
            </button>
            <button class="btn btn-sm btn-info" onclick="viewBookingDetails(${bookingId})" data-bs-toggle="tooltip" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
        `;
    } else if (status === 'rejected') {
        actionButtons = `
            <button class="btn btn-sm btn-warning me-1" onclick="editBooking(${bookingId})" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" onclick="deleteBooking(${bookingId})" data-bs-toggle="tooltip" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        `;
    }

    actionCell.innerHTML = actionButtons;

    // Show success message
    showAlert(`Booking #${bookingId} status updated to ${statusMap[status].text}`, 'success');

    // Reinitialize tooltips for new buttons
    var tooltipTriggerList = [].slice.call(actionCell.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// View booking details
function viewBookingDetails(bookingId) {
    showAlert(`Viewing details for Booking #${bookingId}`, 'info');
    // In real app, this would open a modal with booking details
}

// Edit booking
function editBooking(bookingId) {
    showAlert(`Editing Booking #${bookingId}`, 'warning');
    // In real app, this would open an edit modal
}

// Complete booking
function completeBooking(bookingId) {
    if (confirm('Mark this booking as completed?')) {
        const bookingRow = document.getElementById(`booking-${bookingId}`);
        bookingRow.style.opacity = '0.5';
        setTimeout(() => {
            bookingRow.remove();
            showAlert(`Booking #${bookingId} marked as completed`, 'success');
        }, 300);
    }
}

// Delete booking
function deleteBooking(bookingId) {
    if (confirm('Are you sure you want to delete this booking?')) {
        const bookingRow = document.getElementById(`booking-${bookingId}`);
        bookingRow.style.opacity = '0.5';
        setTimeout(() => {
            bookingRow.remove();
            showAlert(`Booking #${bookingId} deleted successfully`, 'danger');
        }, 300);
    }
}

// Search functionality
document.getElementById('searchBooking').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#bookingTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Filter functionality
document.getElementById('applyFilter').addEventListener('click', function () {
    const statusFilter = document.getElementById('filterStatus').value;
    const categoryFilter = document.getElementById('filterCategory').value;
    const dateFilter = document.getElementById('filterDate').value;

    const rows = document.querySelectorAll('#bookingTable tbody tr');

    rows.forEach(row => {
        const status = row.querySelector('td:nth-child(8) span').textContent.toLowerCase();
        const category = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const date = row.querySelector('td:nth-child(6)').textContent;

        let showRow = true;

        if (statusFilter && !status.includes(statusFilter)) {
            showRow = false;
        }

        if (categoryFilter && category !== categoryFilter.toLowerCase()) {
            showRow = false;
        }

        if (dateFilter && date !== formatDate(new Date(dateFilter))) {
            showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    });

    showAlert('Filters applied successfully', 'info');
});

// Helper function to format date
function formatDate(date) {
    const day = date.getDate().toString().padStart(2, '0');
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

// Show alert message
function showAlert(message, type) {
    // Remove any existing alert
    const existingAlert = document.querySelector('.alert-custom');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-custom position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 3 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

// Export functionality
document.getElementById('exportBtn').addEventListener('click', function () {
    showAlert('Exporting booking data...', 'info');
    // In real app, this would generate and download a CSV/Excel file
});

// Add animation to cards on load
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.fade-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});