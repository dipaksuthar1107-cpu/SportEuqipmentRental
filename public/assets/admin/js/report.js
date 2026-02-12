// Sidebar toggle
document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('mainContent').classList.toggle('expanded');
    document.getElementById('footer').classList.toggle('expanded');
});

// Set current year
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Initialize Charts
document.addEventListener('DOMContentLoaded', function () {
    const data = window.reportData || { bookings: [], categories: [], usage: [], revenue: [] };

    // 1. Bookings Overview (Line Chart)
    const ctxBookings = document.getElementById('bookingsChart').getContext('2d');
    new Chart(ctxBookings, {
        type: 'line',
        data: {
            labels: data.bookings.map(d => d.date),
            datasets: [{
                label: 'Bookings',
                data: data.bookings.map(d => d.count),
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 2. Category Distribution (Pie Chart)
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCategory, {
        type: 'doughnut',
        data: {
            labels: data.categories.map(d => d.category),
            datasets: [{
                data: data.categories.map(d => d.total),
                backgroundColor: ['#4361ee', '#4cc9f0', '#f72585', '#7209b7', '#3f37c9']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 3. Equipment Usage (Bar Chart)
    const ctxUsage = document.getElementById('usageChart').getContext('2d');
    new Chart(ctxUsage, {
        type: 'bar',
        data: {
            labels: data.usage.map(d => d.equipment ? d.equipment.name : 'Unknown'),
            datasets: [{
                label: 'Times Rented',
                data: data.usage.map(d => d.count),
                backgroundColor: '#4cc9f0'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 4. Revenue Trend (Line Chart)
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: data.revenue.map(d => d.date),
            datasets: [{
                label: 'Revenue (₹)',
                data: data.revenue.map(d => d.total),
                borderColor: '#f72585',
                backgroundColor: 'rgba(247, 37, 133, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});

// CSV Export
document.getElementById('exportCSV').addEventListener('click', function () {
    let csv = 'Metric,Value\n';
    csv += `Total Equipment,${document.getElementById('totalEquipment').innerText}\n`;
    csv += `Total Bookings,${document.getElementById('totalBookings').innerText}\n`;
    csv += `Total Penalty,${document.getElementById('totalPenalty').innerText}\n`;

    downloadFile(csv, 'report_summary.csv', 'text/csv');
});

// PDF Export (Basic using jsPDF)
document.getElementById('exportPDF').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(20);
    doc.text('Sports Equipment Rental Report', 10, 20);

    doc.setFontSize(12);
    doc.text(`Total Equipment: ${document.getElementById('totalEquipment').innerText}`, 10, 40);
    doc.text(`Total Bookings: ${document.getElementById('totalBookings').innerText}`, 10, 50);
    doc.text(`Total Penalty: ${document.getElementById('totalPenalty').innerText}`, 10, 60);

    doc.save('report.pdf');
});

function downloadFile(content, fileName, contentType) {
    const a = document.createElement('a');
    const file = new Blob([content], { type: contentType });
    a.href = URL.createObjectURL(file);
    a.download = fileName;
    a.click();
}

// Global alert shim
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `${message} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}