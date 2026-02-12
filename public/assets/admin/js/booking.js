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
    if (!confirm(`Are you sure you want to mark this booking as ${status}?`)) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/admin/booking/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            booking_id: bookingId,
            status: status
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                // Reload page to update table and stats
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert(data.message || 'Error updating status', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred. Please try again.', 'danger');
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
    const table = document.getElementById('bookingTable');
    if (!table) return;

    const rows = Array.from(table.querySelectorAll('tr'));
    if (rows.length === 0) return;

    showAlert('Preparing booking export...', 'info');

    const csvContent = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td'));
        // Skip Actions column
        const rowData = cells.slice(0, -1).map(cell => {
            let text = cell.innerText.replace(/\n/g, ' ').trim();
            if (text.includes(',') || text.includes('"')) {
                text = `"${text.replace(/"/g, '""')}"`;
            }
            return text;
        });
        return rowData.join(',');
    }).join('\n');

    downloadCSV('bookings_export.csv', csvContent);
});

// Helper function to download CSV
function downloadCSV(filename, content) {
    const blob = new Blob([content], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    if (link.download !== undefined) {
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', filename);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showAlert(`${filename} downloaded successfully!`, 'success');
    }
}

// Add animation to cards on load
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.fade-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});