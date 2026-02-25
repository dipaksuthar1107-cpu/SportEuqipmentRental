// Sidebar toggle functionality
document.getElementById('toggleSidebar').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');

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

// Set current date
const now = new Date();
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
const currentDateElem = document.getElementById('currentDate');
if (currentDateElem) {
    currentDateElem.textContent = now.toLocaleDateString('en-US', options);
}

// Initialize charts
let bookingTrendChart, equipmentUsageChart, statusChart;

document.addEventListener('DOMContentLoaded', function () {
    initializeCharts();

    // Notification button click
    const notificationBtn = document.getElementById('notificationBtn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function () {
            showAlert('You have 5 new notifications', 'info');
        });
    }
});

function initializeCharts() {
    if (!window.adminDashboardData) return;
    const chartData = window.adminDashboardData;

    // Booking Trend Chart
    const trendCanvas = document.getElementById('bookingTrendChart');
    if (trendCanvas) {
        const trendCtx = trendCanvas.getContext('2d');
        bookingTrendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: chartData.bookings_labels,
                datasets: [{
                    label: 'Bookings',
                    data: chartData.bookings_counts,
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                }
            }
        });
    }

    // Equipment Usage Chart (By Category)
    const usageCanvas = document.getElementById('equipmentUsageChart');
    if (usageCanvas) {
        const usageCtx = usageCanvas.getContext('2d');
        equipmentUsageChart = new Chart(usageCtx, {
            type: 'bar',
            data: {
                labels: chartData.categories.map(c => c.category),
                datasets: [{
                    label: 'Equipment Count',
                    data: chartData.categories.map(c => c.count),
                    backgroundColor: 'rgba(67, 97, 238, 0.7)',
                    borderColor: '#4361ee',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Status Chart (Simplified)
    const statusCanvas = document.getElementById('statusChart');
    if (statusCanvas && window.adminStats) {
        const statusCtx = statusCanvas.getContext('2d');
        statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Active'],
                datasets: [{
                    data: [window.adminStats.pending_requests, window.adminStats.active_rentals],
                    backgroundColor: [
                        'rgba(248, 150, 30, 0.7)',
                        'rgba(67, 97, 238, 0.7)'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
}

function updateBookingStatus(bookingId, status) {
    if (!confirm(`Are you sure you want to mark this booking as ${status}?`)) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(window.routes.updateBookingStatus, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
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
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert(data.message || 'Failed to update status', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred while updating status', 'danger');
        });
}

function updateStatCard(cardIndex, change) {
    const cards = document.querySelectorAll('.stats-card h3');
    if (cards[cardIndex]) {
        let currentValue = parseInt(cards[cardIndex].textContent);
        if (change.startsWith('+')) {
            currentValue += parseInt(change.substring(1));
        } else if (change.startsWith('-')) {
            currentValue = Math.max(0, currentValue - parseInt(change.substring(1)));
        }
        cards[cardIndex].textContent = currentValue;
    }
}

function viewBookingDetails(bookingId) {
    showAlert(`Viewing details for Booking #${bookingId}`, 'info');
}

function completeBooking(bookingId) {
    if (confirm('Mark this booking as completed?')) {
        showAlert(`Booking #${bookingId} marked as completed`, 'success');
    }
}

function showAlert(message, type) {
    // Remove any existing alert
    const existingAlert = document.querySelector('.alert-toast');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-toast position-fixed`;
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