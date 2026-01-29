// Report data storage (in real app, this would be from server)
let reportData = {
    equipment: [
        { id: 1, name: "Cricket Bat", code: "BAT-001", category: "Outdoor", rentals: 142, usage: 92, trend: 12 },
        { id: 2, name: "Football", code: "FB-002", category: "Outdoor", rentals: 118, usage: 78, trend: 8 },
        { id: 3, name: "Badminton Racket", code: "BR-003", category: "Indoor", rentals: 96, usage: 65, trend: 15 },
        { id: 4, name: "Basketball", code: "BB-004", category: "Outdoor", rentals: 84, usage: 58, trend: -5 },
        { id: 5, name: "Tennis Racket", code: "TR-005", category: "Outdoor", rentals: 72, usage: 50, trend: 8 },
        { id: 6, name: "Dumbbell Set", code: "DB-006", category: "Fitness", rentals: 65, usage: 45, trend: 12 }
    ],
    borrowers: [
        { id: 1, name: "Rahul Sharma", studentId: "STU001", rentals: 28 },
        { id: 2, name: "Amit Patel", studentId: "STU002", rentals: 22 },
        { id: 3, name: "Neha Verma", studentId: "STU003", rentals: 19 },
        { id: 4, name: "Priya Singh", studentId: "STU004", rentals: 16 },
        { id: 5, name: "Raj Kumar", studentId: "STU005", rentals: 14 }
    ],
    stats: {
        totalEquipment: 156,
        totalBookings: 342,
        returnedItems: 298,
        totalPenalty: 4850,
        activeUsers: 128,
        returnRate: 94.2
    }
};

// Charts
let bookingsChart, categoryChart, usageChart, revenueChart;

// Initialize the application
document.addEventListener('DOMContentLoaded', function () {
    initializeSidebar();
    initializeCharts();
    initializeEventListeners();
    loadReportData();

    // Set current year in footer
    document.getElementById('currentYear').textContent = new Date().getFullYear();

    // Initialize stats
    updateStats();
});

// Sidebar functionality
function initializeSidebar() {
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
}

// Initialize charts
function initializeCharts() {
    // Bookings Chart
    const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
    bookingsChart = new Chart(bookingsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Bookings',
                data: [65, 75, 80, 85, 90, 95, 100, 105, 95, 85, 75, 70],
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
                    display: true,
                    position: 'top'
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

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Outdoor', 'Indoor', 'Fitness', 'Other'],
            datasets: [{
                data: [45, 30, 15, 10],
                backgroundColor: [
                    '#4361ee',
                    '#4cc9f0',
                    '#f8961e',
                    '#f72585'
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

    // Usage Chart
    const usageCtx = document.getElementById('usageChart').getContext('2d');
    usageChart = new Chart(usageCtx, {
        type: 'bar',
        data: {
            labels: ['Cricket Bat', 'Football', 'Badminton', 'Basketball', 'Tennis', 'Dumbbells'],
            datasets: [{
                label: 'Times Rented',
                data: [142, 118, 96, 84, 65, 52],
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

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Penalty Revenue (₹)',
                data: [850, 1200, 950, 1850],
                borderColor: '#f72585',
                backgroundColor: 'rgba(247, 37, 133, 0.1)',
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
                    display: true,
                    position: 'top'
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

// Initialize event listeners
function initializeEventListeners() {
    // Generate report button
    document.getElementById('generateReport').addEventListener('click', function () {
        generateReport();
    });

    // Time filter change
    document.getElementById('timeFilter').addEventListener('change', function () {
        const filterValue = this.value;
        showAlert(`Showing data for ${filterValue}`, 'info');
        updateReportData(filterValue);
    });

    // Export buttons
    document.getElementById('exportExcel').addEventListener('click', () => exportReport('excel'));
    document.getElementById('exportPDF').addEventListener('click', () => exportReport('pdf'));
    document.getElementById('exportCSV').addEventListener('click', () => exportReport('csv'));
    document.getElementById('exportPrint').addEventListener('click', () => exportReport('print'));

    // Quick export buttons
    document.getElementById('exportBookings').addEventListener('click', () => exportData('bookings'));
    document.getElementById('exportEquipment').addEventListener('click', () => exportData('equipment'));
    document.getElementById('exportUsers').addEventListener('click', () => exportData('users'));
}

// Load report data
function loadReportData() {
    // Load equipment data
    loadEquipmentData();

    // Load borrowers data
    loadBorrowersData();
}

// Load equipment data into table
function loadEquipmentData() {
    const tableBody = document.getElementById('equipmentTableBody');

    if (reportData.equipment.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-dumbbell"></i>
                        <h4>No Equipment Data</h4>
                        <p>No equipment usage data available.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = '';
    reportData.equipment.forEach((equipment, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                        <i class="${getEquipmentIcon(equipment.name)}"></i>
                    </div>
                    <div>
                        <strong>${equipment.name}</strong>
                        <div class="text-muted small">${equipment.code}</div>
                    </div>
                </div>
            </td>
            <td>${equipment.category}</td>
            <td>${equipment.rentals}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="progress-custom flex-grow-1 me-2">
                        <div class="progress-bar ${getUsageColor(equipment.usage)}" style="width: ${equipment.usage}%"></div>
                    </div>
                    <span class="fw-bold">${equipment.usage}%</span>
                </div>
            </td>
            <td>
                <span class="badge ${equipment.trend >= 0 ? 'bg-success' : 'bg-danger'}">
                    <i class="fas fa-${equipment.trend >= 0 ? 'arrow-up' : 'arrow-down'} me-1"></i>
                    ${Math.abs(equipment.trend)}%
                </span>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Load borrowers data into table
function loadBorrowersData() {
    const tableBody = document.getElementById('borrowersTableBody');

    if (reportData.borrowers.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="3" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>No Borrower Data</h4>
                        <p>No top borrower data available.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tableBody.innerHTML = '';
    reportData.borrowers.forEach((borrower, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>${borrower.name}</strong>
                        <div class="text-muted small">${borrower.studentId}</div>
                    </div>
                </div>
            </td>
            <td>${borrower.rentals}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Generate report
function generateReport() {
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    const reportType = document.getElementById('reportType').value;

    // Show loading
    const generateBtn = document.getElementById('generateReport');
    const originalText = generateBtn.innerHTML;
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Generating...';
    generateBtn.disabled = true;

    // Simulate API call
    setTimeout(() => {
        showAlert(`Generating ${reportType} report from ${formatDateDisplay(fromDate)} to ${formatDateDisplay(toDate)}`, 'info');

        // Update charts with new data based on date range
        updateChartsWithDateRange(fromDate, toDate, reportType);

        // Update equipment data based on filter
        const timeFilter = document.getElementById('timeFilter').value;
        updateEquipmentData(timeFilter);

        // Reset button
        generateBtn.innerHTML = originalText;
        generateBtn.disabled = false;

        // Show success message
        setTimeout(() => {
            showAlert('Report generated successfully!', 'success');
        }, 500);
    }, 2000);
}

// Update charts with date range
function updateChartsWithDateRange(fromDate, toDate, reportType) {
    // In real app, fetch new data from API based on date range
    // For demo, we'll simulate with random data

    const newBookingsData = generateRandomData(12, 60, 120);
    const newCategoryData = generateRandomData(4, 5, 50);
    const newUsageData = generateRandomData(6, 40, 160);
    const newRevenueData = generateRandomData(4, 500, 2000);

    // Update charts
    bookingsChart.data.datasets[0].data = newBookingsData;
    bookingsChart.update();

    categoryChart.data.datasets[0].data = newCategoryData;
    categoryChart.update();

    usageChart.data.datasets[0].data = newUsageData;
    usageChart.update();

    revenueChart.data.datasets[0].data = newRevenueData;
    revenueChart.update();

    // Update stats based on new data
    updateStatsWithNewData(newBookingsData, newRevenueData);
}

// Update equipment data based on time filter
function updateEquipmentData(timeFilter) {
    // In real app, fetch new equipment data from API
    // For demo, we'll adjust existing data based on filter

    const multiplier = timeFilter === 'month' ? 1 :
        timeFilter === 'quarter' ? 3 :
            timeFilter === 'year' ? 12 : 1;

    const updatedEquipment = reportData.equipment.map(eq => ({
        ...eq,
        rentals: Math.round(eq.rentals * multiplier / 12 * (timeFilter === 'year' ? 12 : timeFilter === 'quarter' ? 3 : 1)),
        usage: Math.min(100, Math.round(eq.usage * multiplier / 12 * (timeFilter === 'year' ? 12 : timeFilter === 'quarter' ? 3 : 1))),
        trend: Math.floor(Math.random() * 21) - 10 // Random trend between -10 and +10
    }));

    // Update table
    updateEquipmentTable(updatedEquipment);
}

// Update equipment table
function updateEquipmentTable(equipmentData) {
    const tableBody = document.getElementById('equipmentTableBody');
    tableBody.innerHTML = '';

    equipmentData.forEach((equipment, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                        <i class="${getEquipmentIcon(equipment.name)}"></i>
                    </div>
                    <div>
                        <strong>${equipment.name}</strong>
                        <div class="text-muted small">${equipment.code}</div>
                    </div>
                </div>
            </td>
            <td>${equipment.category}</td>
            <td>${equipment.rentals}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="progress-custom flex-grow-1 me-2">
                        <div class="progress-bar ${getUsageColor(equipment.usage)}" style="width: ${equipment.usage}%"></div>
                    </div>
                    <span class="fw-bold">${equipment.usage}%</span>
                </div>
            </td>
            <td>
                <span class="badge ${equipment.trend >= 0 ? 'bg-success' : 'bg-danger'}">
                    <i class="fas fa-${equipment.trend >= 0 ? 'arrow-up' : 'arrow-down'} me-1"></i>
                    ${Math.abs(equipment.trend)}%
                </span>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

// Update stats with new data
function updateStatsWithNewData(bookingsData, revenueData) {
    const totalBookings = bookingsData.reduce((sum, val) => sum + val, 0);
    const totalRevenue = revenueData.reduce((sum, val) => sum + val, 0);

    // Update stats cards with animation
    const statsToUpdate = [
        { id: 'totalBookings', value: totalBookings },
        { id: 'totalPenalty', value: `₹${totalRevenue}` },
        { id: 'returnedItems', value: Math.round(totalBookings * 0.9) },
        { id: 'activeUsers', value: Math.round(totalBookings / 3) },
        { id: 'returnRate', value: `${(85 + Math.random() * 15).toFixed(1)}%` }
    ];

    statsToUpdate.forEach(stat => {
        const element = document.getElementById(stat.id);
        if (element) {
            // Animate the value change
            animateValueChange(element, stat.value);
        }
    });
}

// Update stats cards
function updateStats() {
    const stats = reportData.stats;

    document.getElementById('totalEquipment').textContent = stats.totalEquipment;
    document.getElementById('totalBookings').textContent = stats.totalBookings;
    document.getElementById('returnedItems').textContent = stats.returnedItems;
    document.getElementById('totalPenalty').textContent = `₹${stats.totalPenalty}`;
    document.getElementById('activeUsers').textContent = stats.activeUsers;
    document.getElementById('returnRate').textContent = `${stats.returnRate}%`;
}

// Export report
function exportReport(format) {
    let message = '';
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;

    switch (format) {
        case 'excel':
            message = 'Exporting to Excel format...';
            break;
        case 'pdf':
            message = 'Generating PDF report...';
            break;
        case 'csv':
            message = 'Downloading CSV data...';
            break;
        case 'print':
            message = 'Opening print preview...';
            window.print();
            break;
    }

    if (format !== 'print') {
        showAlert(message, 'info');

        // Simulate file download
        setTimeout(() => {
            showAlert(`${format.toUpperCase()} report exported successfully for ${formatDateDisplay(fromDate)} to ${formatDateDisplay(toDate)}!`, 'success');

            // In real app, trigger file download here
            // const filename = `report_${fromDate}_to_${toDate}.${format}`;
            // downloadFile(filename, reportData);
        }, 1500);
    }
}

// Export specific data
function exportData(type) {
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;

    showAlert(`Exporting ${type} data for ${formatDateDisplay(fromDate)} to ${formatDateDisplay(toDate)}...`, 'info');

    setTimeout(() => {
        showAlert(`${type.charAt(0).toUpperCase() + type.slice(1)} data exported successfully!`, 'success');

        // In real app, generate and download specific data
        // const data = getExportData(type);
        // downloadFile(`${type}_export_${new Date().toISOString().split('T')[0]}.csv`, data);
    }, 1000);
}

// Update report data based on filter
function updateReportData(timeFilter) {
    // In real app, fetch new data from API based on time filter
    // For demo, we'll simulate with adjusted data

    const factor = {
        'month': 1,
        'quarter': 3,
        'year': 12
    }[timeFilter] || 1;

    // Update equipment data
    const updatedEquipment = reportData.equipment.map(eq => ({
        ...eq,
        rentals: Math.round(eq.rentals * factor),
        usage: Math.min(100, eq.usage * factor),
        trend: Math.floor(Math.random() * 21) - 10
    }));

    updateEquipmentTable(updatedEquipment);

    // Update borrower data
    const updatedBorrowers = reportData.borrowers.map(b => ({
        ...b,
        rentals: Math.round(b.rentals * factor)
    }));

    updateBorrowersTable(updatedBorrowers);
}

// Update borrowers table
function updateBorrowersTable(borrowersData) {
    const tableBody = document.getElementById('borrowersTableBody');
    tableBody.innerHTML = '';

    borrowersData.forEach((borrower, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <strong>${borrower.name}</strong>
                        <div class="text-muted small">${borrower.studentId}</div>
                    </div>
                </div>
            </td>
            <td>${borrower.rentals}</td>
        `;
        tableBody.appendChild(row);
    });
}

// Helper functions
function getEquipmentIcon(equipmentName) {
    const icons = {
        'Cricket Bat': 'fa-baseball-bat-ball',
        'Football': 'fa-futbol',
        'Badminton Racket': 'fa-table-tennis-paddle-ball',
        'Basketball': 'fa-basketball',
        'Tennis Racket': 'fa-table-tennis-paddle-ball',
        'Dumbbell Set': 'fa-dumbbell'
    };
    return icons[equipmentName] || 'fa-dumbbell';
}

function getUsageColor(usage) {
    if (usage >= 80) return 'bg-success';
    if (usage >= 60) return 'bg-info';
    if (usage >= 40) return 'bg-warning';
    return 'bg-danger';
}

function formatDateDisplay(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
}

function generateRandomData(count, min, max) {
    return Array.from({ length: count }, () =>
        Math.floor(Math.random() * (max - min + 1)) + min
    );
}

function animateValueChange(element, newValue) {
    const oldValue = element.textContent;
    element.style.transform = 'scale(1.1)';
    element.style.color = '#4361ee';

    setTimeout(() => {
        element.textContent = newValue;
        element.style.transform = 'scale(1)';
        element.style.color = '';
    }, 300);
}

function showAlert(message, type, duration = 3000) {
    // Remove any existing alert
    const existingAlert = document.querySelector('.alert-toast');
    if (existingAlert) {
        existingAlert.remove();
    }

    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-toast fade-in`;
    alertDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    `;

    const icon = type === 'success' ? 'fa-check-circle' :
        type === 'danger' ? 'fa-exclamation-circle' :
            type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

    alertDiv.innerHTML = `
        <i class="fas ${icon} me-2"></i>
        <span>${message}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after duration
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, duration);
}

// Add animation to cards on load
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.fade-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});