// Penalty data storage (in real app, this would be from server)
let penaltyData = [
    { id: 1, student: "Rahul Sharma", studentId: "STU001", equipment: "Cricket Bat", equipmentCode: "BAT-001", reason: "late", reasonDetails: "3 days late", amount: 300, issuedDate: "2026-02-10", dueDate: "2026-02-15", status: "unpaid" },
    { id: 2, student: "Amit Patel", studentId: "STU002", equipment: "Football", equipmentCode: "FB-002", reason: "damage", reasonDetails: "Minor damage", amount: 500, issuedDate: "2026-02-08", dueDate: "2026-02-13", status: "paid" },
    { id: 3, student: "Neha Verma", studentId: "STU003", equipment: "Badminton Racket", equipmentCode: "BR-003", reason: "lost", reasonDetails: "Not returned", amount: 1200, issuedDate: "2026-02-05", dueDate: "2026-02-10", status: "unpaid" },
    { id: 4, student: "Priya Singh", studentId: "STU004", equipment: "Basketball", equipmentCode: "BB-004", reason: "late", reasonDetails: "1 day late", amount: 100, issuedDate: "2026-02-11", dueDate: "2026-02-16", status: "partial", partialAmount: 50 },
    { id: 5, student: "Raj Kumar", studentId: "STU005", equipment: "Dumbbell Set", equipmentCode: "DB-005", reason: "other", reasonDetails: "Improper use", amount: 200, issuedDate: "2026-02-09", dueDate: "2026-02-14", status: "waived" }
];

let nextId = 6;

// Charts
let reasonsChart, penaltyTrendChart;

// Initialize the application
document.addEventListener('DOMContentLoaded', function () {
    initializeSidebar();
    initializeCharts();
    initializeTooltips();
    initializeForm();
    initializeFilters();
    loadPenaltyData();

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
    // Reasons Chart
    const reasonsCtx = document.getElementById('reasonsChart').getContext('2d');
    reasonsChart = new Chart(reasonsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Late Return', 'Damage', 'Lost Equipment', 'Other'],
            datasets: [{
                data: [45, 30, 15, 10],
                backgroundColor: [
                    '#f8961e',
                    '#e74c3c',
                    '#f72585',
                    '#6c757d'
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

    // Penalty Trend Chart
    const trendCtx = document.getElementById('penaltyTrendChart').getContext('2d');
    penaltyTrendChart = new Chart(trendCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Penalty Amount (₹)',
                data: [4500, 5200, 4850, 6100, 5550, 8450],
                backgroundColor: 'rgba(247, 37, 133, 0.7)',
                borderColor: '#f72585',
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
                    },
                    ticks: {
                        callback: function (value) {
                            return '₹' + value;
                        }
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

// Initialize tooltips
function initializeTooltips() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Initialize form functionality
function initializeForm() {
    // Reason change event for custom amount
    document.getElementById('penaltyReason').addEventListener('change', function () {
        const reason = this.value;
        const customSection = document.getElementById('customAmountSection');
        const amountField = document.getElementById('penaltyAmount');

        if (reason === 'other') {
            customSection.style.display = 'block';
            amountField.value = '';
        } else {
            customSection.style.display = 'none';
            // Set default amounts based on reason
            switch (reason) {
                case 'late':
                    amountField.value = 100;
                    break;
                case 'damage':
                    amountField.value = 300;
                    break;
                case 'lost':
                    amountField.value = 500;
                    break;
                default:
                    amountField.value = '';
            }
        }
    });

    // Form submission
    document.getElementById('addPenaltyForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const student = document.getElementById('penaltyStudent').value;
        const equipment = document.getElementById('penaltyEquipment').value;
        const reason = document.getElementById('penaltyReason').value;
        let amount = document.getElementById('penaltyAmount').value;

        if (reason === 'other') {
            const customAmount = document.getElementById('customAmount').value;
            if (customAmount) amount = customAmount;
        }

        if (!student || !equipment || !reason || !amount) {
            showAlert('Please fill all required fields', 'danger');
            return;
        }

        // Show loading state
        const submitBtn = document.getElementById('addPenaltyBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Adding...';
        submitBtn.disabled = true;

        // Simulate API call
        setTimeout(() => {
            // Create new penalty
            const newPenalty = {
                id: nextId++,
                student: student.split(' (')[0],
                studentId: student.split(' (')[1]?.replace(')', '') || '',
                equipment: equipment.split(' (')[0],
                equipmentCode: equipment.split(' (')[1]?.replace(')', '') || '',
                reason: reason,
                reasonDetails: getReasonDetails(reason),
                amount: parseInt(amount),
                issuedDate: new Date().toISOString().split('T')[0],
                dueDate: new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0],
                status: 'unpaid'
            };

            // Add to data
            penaltyData.unshift(newPenalty);

            // Update UI
            addPenaltyToTable(newPenalty);
            updateStats();
            updateCharts();

            // Reset form
            document.getElementById('addPenaltyForm').reset();
            document.getElementById('customAmountSection').style.display = 'none';

            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            showAlert('Penalty added successfully', 'success');
        }, 1000);
    });
}

// Initialize filters
function initializeFilters() {
    // Filter button
    document.getElementById('applyFilter').addEventListener('click', function () {
        const statusFilter = document.getElementById('filterStatus').value;
        const reasonFilter = document.getElementById('filterReason').value;
        const dateFilter = document.getElementById('filterDate').value;

        filterPenalties(statusFilter, reasonFilter, dateFilter);
    });

    // Search functionality
    document.getElementById('searchPenalty').addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#penaltyTableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Export button
    document.getElementById('exportBtn').addEventListener('click', function () {
        showAlert('Exporting penalty data...', 'info');
        // In real app, this would generate and download a file
        setTimeout(() => {
            showAlert('Penalty data exported successfully', 'success');
        }, 1500);
    });
}

// Load penalty data into table
function loadPenaltyData() {
    const tableBody = document.getElementById('penaltyTableBody');

    if (penaltyData.length === 0) {
        tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>No Penalties Found</h4>
                        <p>No penalty records available. Add a new penalty to get started.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    // Sort by latest first
    const sortedData = [...penaltyData].sort((a, b) => new Date(b.issuedDate) - new Date(a.issuedDate));

    tableBody.innerHTML = '';
    sortedData.forEach(penalty => {
        addPenaltyToTable(penalty);
    });
}

// Add penalty to table
function addPenaltyToTable(penalty) {
    const tableBody = document.getElementById('penaltyTableBody');

    // Remove empty state if exists
    if (tableBody.querySelector('.empty-state')) {
        tableBody.innerHTML = '';
    }

    const reasonText = getReasonText(penalty.reason);
    const reasonClass = getReasonClass(penalty.reason);
    const statusClass = getStatusClass(penalty.status);
    const statusText = getStatusText(penalty);

    const row = document.createElement('tr');
    row.id = `penalty-${penalty.id}`;
    row.innerHTML = `
        <td>${penalty.id}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <strong>${penalty.student}</strong>
                    <div class="text-muted small">ID: ${penalty.studentId}</div>
                </div>
            </div>
        </td>
        <td>
            <div class="d-flex align-items-center">
                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                    <i class="${getEquipmentIcon(penalty.equipment)}"></i>
                </div>
                <span>${penalty.equipment}</span>
            </div>
        </td>
        <td>
            <span class="${reasonClass}">${reasonText}</span>
            <div class="text-muted small">${penalty.reasonDetails}</div>
        </td>
        <td>
            <div class="amount-display">${penalty.amount}</div>
        </td>
        <td>${formatDate(penalty.issuedDate)}</td>
        <td>${formatDate(penalty.dueDate)}</td>
        <td>
            <span class="status-badge ${statusClass}">${statusText}</span>
        </td>
        <td>
            ${getActionButtons(penalty.id, penalty.status)}
        </td>
    `;

    // Insert at the beginning
    tableBody.prepend(row);

    // Add event listeners to buttons
    addButtonEventListeners(penalty.id);
}

// Get action buttons based on status
function getActionButtons(penaltyId, status) {
    if (status === 'paid') {
        return `
            <button class="btn btn-sm btn-secondary me-1 generate-receipt-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Generate Receipt">
                <i class="fas fa-receipt"></i>
            </button>
            <button class="btn btn-sm btn-info view-details-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
        `;
    } else if (status === 'partial') {
        return `
            <button class="btn btn-sm btn-success mark-paid-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Mark as Paid">
                <i class="fas fa-check"></i>
            </button>
            <button class="btn btn-sm btn-warning add-payment-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Add Payment">
                <i class="fas fa-money-bill"></i>
            </button>
        `;
    } else if (status === 'waived') {
        return `
            <button class="btn btn-sm btn-info view-details-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-secondary reinstate-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Reinstate">
                <i class="fas fa-redo"></i>
            </button>
        `;
    } else { // unpaid
        return `
            <button class="btn btn-sm btn-success mark-paid-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Mark as Paid">
                <i class="fas fa-check"></i>
            </button>
            <button class="btn btn-sm btn-warning partial-payment-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Partial Payment">
                <i class="fas fa-money-bill-wave"></i>
            </button>
            <button class="btn btn-sm btn-info view-details-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-danger delete-btn" data-id="${penaltyId}" data-bs-toggle="tooltip" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        `;
    }
}

// Add event listeners to buttons
function addButtonEventListeners(penaltyId) {
    const row = document.getElementById(`penalty-${penaltyId}`);

    // Mark as paid
    const markPaidBtn = row.querySelector('.mark-paid-btn');
    if (markPaidBtn) {
        markPaidBtn.addEventListener('click', () => updatePenaltyStatus(penaltyId, 'paid'));
    }

    // Partial payment
    const partialPaymentBtn = row.querySelector('.partial-payment-btn');
    if (partialPaymentBtn) {
        partialPaymentBtn.addEventListener('click', () => updatePenaltyStatus(penaltyId, 'partial'));
    }

    // Add payment
    const addPaymentBtn = row.querySelector('.add-payment-btn');
    if (addPaymentBtn) {
        addPaymentBtn.addEventListener('click', () => addPayment(penaltyId));
    }

    // View details
    const viewDetailsBtn = row.querySelector('.view-details-btn');
    if (viewDetailsBtn) {
        viewDetailsBtn.addEventListener('click', () => viewPenaltyDetails(penaltyId));
    }

    // Generate receipt
    const generateReceiptBtn = row.querySelector('.generate-receipt-btn');
    if (generateReceiptBtn) {
        generateReceiptBtn.addEventListener('click', () => generateReceipt(penaltyId));
    }

    // Delete
    const deleteBtn = row.querySelector('.delete-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => deletePenalty(penaltyId));
    }

    // Reinstate
    const reinstateBtn = row.querySelector('.reinstate-btn');
    if (reinstateBtn) {
        reinstateBtn.addEventListener('click', () => reinstatePenalty(penaltyId));
    }

    // Reinitialize tooltips for new buttons
    initializeTooltips();
}

// Update penalty status
function updatePenaltyStatus(penaltyId, newStatus) {
    const penaltyIndex = penaltyData.findIndex(p => p.id == penaltyId);
    if (penaltyIndex === -1) return;

    const penalty = penaltyData[penaltyIndex];
    const oldStatus = penalty.status;
    penalty.status = newStatus;

    // For partial payment, ask for amount
    if (newStatus === 'partial') {
        const amount = prompt(`Enter partial payment amount (max ₹${penalty.amount}):`);
        if (!amount || isNaN(amount) || amount <= 0 || amount > penalty.amount) {
            penalty.status = oldStatus;
            showAlert('Invalid amount entered', 'danger');
            return;
        }
        penalty.partialAmount = parseInt(amount);
    } else if (newStatus === 'waived') {
        if (!confirm('Are you sure you want to waive this penalty?')) {
            penalty.status = oldStatus;
            return;
        }
    }

    // Update the table row
    updatePenaltyRow(penaltyId);

    // Update stats
    updateStats();

    showAlert(`Penalty #${penaltyId} updated to ${getStatusText(penalty)}`, 'success');
}

// Update penalty row in table
function updatePenaltyRow(penaltyId) {
    const penaltyIndex = penaltyData.findIndex(p => p.id == penaltyId);
    if (penaltyIndex === -1) return;

    const penalty = penaltyData[penaltyIndex];
    const row = document.getElementById(`penalty-${penaltyId}`);

    if (!row) return;

    // Update status cell
    const statusCell = row.querySelector('td:nth-child(8)');
    statusCell.innerHTML = `<span class="status-badge ${getStatusClass(penalty.status)}">${getStatusText(penalty)}</span>`;

    // Update action buttons
    const actionCell = row.querySelector('td:nth-child(9)');
    actionCell.innerHTML = getActionButtons(penalty.id, penalty.status);

    // Add event listeners to new buttons
    addButtonEventListeners(penaltyId);
}

// Filter penalties
function filterPenalties(status, reason, date) {
    const rows = document.querySelectorAll('#penaltyTableBody tr');
    let visibleCount = 0;

    rows.forEach(row => {
        if (row.classList.contains('empty-state')) return;

        const penaltyId = row.id.split('-')[1];
        const penalty = penaltyData.find(p => p.id == penaltyId);
        if (!penalty) return;

        let showRow = true;

        // Filter by status
        if (status && penalty.status !== status) {
            showRow = false;
        }

        // Filter by reason
        if (reason && penalty.reason !== reason) {
            showRow = false;
        }

        // Filter by date
        if (date) {
            const filterDate = new Date(date).toISOString().split('T')[0];
            if (penalty.issuedDate !== filterDate) {
                showRow = false;
            }
        }

        row.style.display = showRow ? '' : 'none';
        if (showRow) visibleCount++;
    });

    showAlert(`Filter applied: ${visibleCount} penalties found`, 'info');
}

// View penalty details
function viewPenaltyDetails(penaltyId) {
    const penalty = penaltyData.find(p => p.id == penaltyId);
    if (!penalty) return;

    const details = `
        <strong>Penalty Details #${penalty.id}</strong><br><br>
        <strong>Student:</strong> ${penalty.student} (${penalty.studentId})<br>
        <strong>Equipment:</strong> ${penalty.equipment} (${penalty.equipmentCode})<br>
        <strong>Reason:</strong> ${getReasonText(penalty.reason)}<br>
        <strong>Details:</strong> ${penalty.reasonDetails}<br>
        <strong>Amount:</strong> ₹${penalty.amount}<br>
        <strong>Issued Date:</strong> ${formatDate(penalty.issuedDate)}<br>
        <strong>Due Date:</strong> ${formatDate(penalty.dueDate)}<br>
        <strong>Status:</strong> ${getStatusText(penalty)}<br>
        ${penalty.partialAmount ? `<strong>Partial Payment:</strong> ₹${penalty.partialAmount}<br>` : ''}
    `;

    showAlert(details, 'info', 5000);
}

// Delete penalty
function deletePenalty(penaltyId) {
    if (!confirm('Are you sure you want to delete this penalty?')) {
        return;
    }

    const penaltyIndex = penaltyData.findIndex(p => p.id == penaltyId);
    if (penaltyIndex === -1) return;

    const penaltyRow = document.getElementById(`penalty-${penaltyId}`);
    if (penaltyRow) {
        penaltyRow.style.opacity = '0.5';
        setTimeout(() => {
            penaltyRow.remove();
            penaltyData.splice(penaltyIndex, 1);

            // If no penalties left, show empty state
            if (penaltyData.length === 0) {
                loadPenaltyData();
            }

            updateStats();
            showAlert(`Penalty #${penaltyId} deleted successfully`, 'danger');
        }, 300);
    }
}

// Generate receipt
function generateReceipt(penaltyId) {
    const penalty = penaltyData.find(p => p.id == penaltyId);
    if (!penalty) return;

    const receiptContent = `
        RECEIPT #${penalty.id}<br>
        Date: ${formatDate(new Date())}<br><br>
        Received from: ${penalty.student}<br>
        For: ${penalty.equipment} Penalty<br>
        Reason: ${getReasonText(penalty.reason)}<br>
        Amount: ₹${penalty.amount}<br>
        Status: Paid in Full<br><br>
        Thank you for your payment.
    `;

    showAlert(receiptContent, 'success', 5000);

    // In real app, this would open a print dialog
    setTimeout(() => {
        if (confirm('Open print dialog?')) {
            window.print();
        }
    }, 1000);
}

// Add payment
function addPayment(penaltyId) {
    const penalty = penaltyData.find(p => p.id == penaltyId);
    if (!penalty) return;

    const maxAmount = penalty.amount - (penalty.partialAmount || 0);
    const amount = prompt(`Enter additional payment amount (max ₹${maxAmount}):`);

    if (!amount || isNaN(amount) || amount <= 0 || amount > maxAmount) {
        showAlert('Invalid amount entered', 'danger');
        return;
    }

    const newPartialAmount = (penalty.partialAmount || 0) + parseInt(amount);

    if (newPartialAmount >= penalty.amount) {
        penalty.status = 'paid';
        delete penalty.partialAmount;
    } else {
        penalty.partialAmount = newPartialAmount;
    }

    updatePenaltyRow(penaltyId);
    updateStats();
    showAlert(`Payment of ₹${amount} recorded for Penalty #${penaltyId}`, 'success');
}

// Reinstate penalty
function reinstatePenalty(penaltyId) {
    if (!confirm('Reinstate this waived penalty?')) {
        return;
    }

    const penaltyIndex = penaltyData.findIndex(p => p.id == penaltyId);
    if (penaltyIndex === -1) return;

    penaltyData[penaltyIndex].status = 'unpaid';
    updatePenaltyRow(penaltyId);
    updateStats();
    showAlert(`Penalty #${penaltyId} reinstated`, 'warning');
}

// Update stats
function updateStats() {
    const totalPenalties = penaltyData.reduce((sum, p) => sum + p.amount, 0);
    const pendingPenalties = penaltyData
        .filter(p => p.status === 'unpaid' || p.status === 'partial')
        .reduce((sum, p) => sum + (p.amount - (p.partialAmount || 0)), 0);
    const collectedPenalties = penaltyData
        .filter(p => p.status === 'paid' || p.status === 'partial')
        .reduce((sum, p) => sum + ((p.partialAmount || 0) + (p.status === 'paid' ? p.amount : 0)), 0);

    const studentsWithPenalties = new Set(penaltyData.map(p => p.studentId)).size;

    // Update DOM
    document.getElementById('totalPenalties').textContent = `₹${totalPenalties}`;
    document.getElementById('pendingPenalties').textContent = `₹${pendingPenalties}`;
    document.getElementById('collectedPenalties').textContent = `₹${collectedPenalties}`;
    document.getElementById('studentsWithPenalties').textContent = studentsWithPenalties;

    // Add animation effect
    ['totalPenalties', 'pendingPenalties', 'collectedPenalties', 'studentsWithPenalties'].forEach(id => {
        const elem = document.getElementById(id);
        elem.style.transform = 'scale(1.1)';
        setTimeout(() => {
            elem.style.transform = 'scale(1)';
        }, 300);
    });
}

// Update charts with new data
function updateCharts() {
    // Calculate new data for reasons chart
    const reasonsCount = {
        late: penaltyData.filter(p => p.reason === 'late').length,
        damage: penaltyData.filter(p => p.reason === 'damage').length,
        lost: penaltyData.filter(p => p.reason === 'lost').length,
        other: penaltyData.filter(p => p.reason === 'other').length
    };

    const totalCount = penaltyData.length;

    // Update reasons chart
    reasonsChart.data.datasets[0].data = [
        (reasonsCount.late / totalCount * 100) || 0,
        (reasonsCount.damage / totalCount * 100) || 0,
        (reasonsCount.lost / totalCount * 100) || 0,
        (reasonsCount.other / totalCount * 100) || 0
    ];
    reasonsChart.update();

    // In real app, update trend chart with actual monthly data
    console.log('Charts updated with latest data');
}

// Helper functions
function getReasonText(reason) {
    const reasons = {
        'late': 'Late Return',
        'damage': 'Damage',
        'lost': 'Lost Equipment',
        'other': 'Other'
    };
    return reasons[reason] || 'Other';
}

function getReasonDetails(reason) {
    const details = {
        'late': 'Late return penalty',
        'damage': 'Equipment damage',
        'lost': 'Lost equipment replacement',
        'other': 'Other violation'
    };
    return details[reason] || 'Other violation';
}

function getReasonClass(reason) {
    const classes = {
        'late': 'reason-late',
        'damage': 'reason-damage',
        'lost': 'reason-lost',
        'other': 'reason-other'
    };
    return classes[reason] || 'reason-other';
}

function getStatusClass(status) {
    const classes = {
        'unpaid': 'status-unpaid',
        'paid': 'status-paid',
        'waived': 'status-waived',
        'partial': 'status-partial'
    };
    return classes[status] || 'status-unpaid';
}

function getStatusText(penalty) {
    if (penalty.status === 'partial' && penalty.partialAmount) {
        return `Partial (₹${penalty.partialAmount})`;
    }
    const texts = {
        'unpaid': 'Unpaid',
        'paid': 'Paid',
        'waived': 'Waived',
        'partial': 'Partial'
    };
    return texts[penalty.status] || 'Unpaid';
}

function getEquipmentIcon(equipment) {
    const icons = {
        'Cricket Bat': 'fa-baseball-bat-ball',
        'Football': 'fa-futbol',
        'Badminton Racket': 'fa-table-tennis-paddle-ball',
        'Basketball': 'fa-basketball',
        'Tennis Racket': 'fa-table-tennis-paddle-ball',
        'Dumbbell Set': 'fa-dumbbell'
    };
    return icons[equipment] || 'fa-dumbbell';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const day = date.getDate().toString().padStart(2, '0');
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
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
        <span>${message.replace(/<br>/g, '\n')}</span>
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