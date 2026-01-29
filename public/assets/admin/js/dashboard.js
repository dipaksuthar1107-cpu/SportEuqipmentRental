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

// Set current date
const now = new Date();
const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', options);

// Set current year in footer
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Charts
let bookingTrendChart, equipmentUsageChart, statusChart;

// Initialize charts
function initializeCharts() {
    // Booking Trend Chart
    const trendCtx = document.getElementById('bookingTrendChart').getContext('2d');
    bookingTrendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Bookings',
                data: [12, 19, 8, 15, 22, 18, 25],
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

    // Equipment Usage Chart
    const usageCtx = document.getElementById('equipmentUsageChart').getContext('2d');
    equipmentUsageChart = new Chart(usageCtx, {
        type: 'bar',
        data: {
            labels: ['Cricket', 'Football', 'Badminton', 'Basketball', 'Tennis', 'Other'],
            datasets: [{
                label: 'Times Used',
                data: [45, 38, 28, 22, 18, 12],
                backgroundColor: [
                    'rgba(67, 97, 238, 0.7)',
                    'rgba(76, 201, 240, 0.7)',
                    'rgba(248, 150, 30, 0.7)',
                    'rgba(247, 37, 133, 0.7)',
                    'rgba(46, 204, 113, 0.7)',
                    'rgba(155, 89, 182, 0.7)'
                ],
                borderColor: [
                    '#4361ee',
                    '#4cc9f0',
                    '#f8961e',
                    '#f72585',
                    '#2ecc71',
                    '#9b59b6'
                ],
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

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Collected', 'Returned'],
            datasets: [{
                data: [12, 62, 28, 80],
                backgroundColor: [
                    'rgba(248, 150, 30, 0.7)',
                    'rgba(46, 204, 113, 0.7)',
                    'rgba(67, 97, 238, 0.7)',
                    'rgba(155, 89, 182, 0.7)'
                ],
                borderColor: [
                    '#f8961e',
                    '#2ecc71',
                    '#4361ee',
                    '#9b59b6'
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

// Update booking status
function updateBookingStatus(bookingId, status) {
    const bookingRow = document.getElementById(`booking-${bookingId}`);
    if (!bookingRow) return;

    const statusCell = bookingRow.querySelector('td:nth-child(7)');
    const actionCell = bookingRow.querySelector('td:nth-child(8)');

    const statusMap = {
        'approved': { class: 'status-approved', text: 'Approved', color: '#27ae60' },
        'rejected': { class: 'status-rejected', text: 'Rejected', color: '#c2185b' },
        'collected': { class: 'status-collected', text: 'Collected', color: '#2d4bc4' },
        'returned': { class: 'status-returned', text: 'Returned', color: '#8e44ad' }
    };

    const statusInfo = statusMap[status];
    if (!statusInfo) return;

    // Update status badge
    statusCell.innerHTML = `<span class="status-badge ${statusInfo.class}">${statusInfo.text}</span>`;

    // Update action buttons
    let actionButtons = '';
    if (status === 'approved') {
        actionButtons = `
            <button class="btn btn-sm btn-info" onclick="viewBookingDetails('${bookingId}')">
                <i class="fas fa-eye"></i> View
            </button>
        `;
        updateStatCard(3, '+1'); // Approved count
        updateStatCard(2, '-1'); // Pending count
        updateChartData(1, '+1'); // Update pie chart
    } else if (status === 'rejected') {
        actionButtons = `
            <button class="btn btn-sm btn-danger" onclick="deleteBooking('${bookingId}')">
                <i class="fas fa-trash"></i> Delete
            </button>
        `;
        updateStatCard(2, '-1'); // Pending count
    } else if (status === 'collected') {
        actionButtons = `
            <button class="btn btn-sm btn-secondary" onclick="updateBookingStatus('${bookingId}', 'returned')">
                <i class="fas fa-undo-alt"></i> Mark Returned
            </button>
        `;
        updateStatCard(3, '-1'); // Approved count
        updateChartData(1, '-1'); // Update pie chart
        updateChartData(2, '+1'); // Update pie chart
    } else if (status === 'returned') {
        actionButtons = `
            <button class="btn btn-sm btn-success" onclick="completeBooking('${bookingId}')">
                <i class="fas fa-flag-checkered"></i> Complete
            </button>
        `;
        updateStatCard(4, '+1'); // Returned count
        updateChartData(2, '-1'); // Update pie chart
        updateChartData(3, '+1'); // Update pie chart
    }

    actionCell.innerHTML = actionButtons;

    showAlert(`Booking #${bookingId} status updated to ${statusInfo.text}`, 'success');
}

// Update stat card
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

        // Add animation effect
        cards[cardIndex].style.transform = 'scale(1.2)';
        setTimeout(() => {
            cards[cardIndex].style.transform = 'scale(1)';
        }, 300);
    }
}

// Update chart data
function updateChartData(chartIndex, change) {
    if (statusChart && statusChart.data && statusChart.data.datasets[0]) {
        let currentValue = statusChart.data.datasets[0].data[chartIndex];
        if (change.startsWith('+')) {
            statusChart.data.datasets[0].data[chartIndex] += parseInt(change.substring(1));
        } else if (change.startsWith('-')) {
            statusChart.data.datasets[0].data[chartIndex] = Math.max(0, currentValue - parseInt(change.substring(1)));
        }
        statusChart.update();
    }
}

// View booking details
function viewBookingDetails(bookingId) {
    showAlert(`Viewing details for Booking #${bookingId}`, 'info');
}

// Complete booking
function completeBooking(bookingId) {
    if (confirm('Mark this booking as completed?')) {
        const bookingRow = document.getElementById(`booking-${bookingId}`);
        bookingRow.style.opacity = '0.5';
        setTimeout(() => {
            bookingRow.remove();
            showAlert(`Booking #${bookingId} marked as completed`, 'success');
            updateStatCard(4, '-1'); // Returned count
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

// Show alert message
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
    alertDiv.style.boxShadow = '0 5px 15px rgba(0,0,0,0.2)';
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

// Notification button click
document.getElementById('notificationBtn').addEventListener('click', function () {
    showAlert('You have 5 new notifications', 'info');
});

// Trend filter change
document.getElementById('trendFilter').addEventListener('change', function () {
    const value = this.value;
    showAlert(`Chart updated to show ${value}`, 'info');

    // Update chart data based on selection
    if (value === 'Last 7 Days') {
        bookingTrendChart.data.labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        bookingTrendChart.data.datasets[0].data = [12, 19, 8, 15, 22, 18, 25];
    } else if (value === 'Last 30 Days') {
        bookingTrendChart.data.labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        bookingTrendChart.data.datasets[0].data = [85, 92, 78, 105];
    } else if (value === 'Last 3 Months') {
        bookingTrendChart.data.labels = ['Jan', 'Feb', 'Mar'];
        bookingTrendChart.data.datasets[0].data = [320, 280, 350];
    }
    bookingTrendChart.update();
});

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function () {
    initializeCharts();
});