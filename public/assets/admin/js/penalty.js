// Set current year in footer
document.getElementById('currentYear').textContent = new Date().getFullYear();

// Common headers for fetch
const getHeaders = () => {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
    };
};

// Add Penalty
document.getElementById('addPenaltyForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const btn = document.getElementById('addPenaltyBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    btn.disabled = true;

    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => { data[key] = value });

    fetch('/admin/penalty/store', {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert(data.message || 'Error adding penalty', 'danger');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'danger');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
});

// Update Penalty Status
function updatePenaltyStatus(id, status) {
    if (!confirm(`Are you sure you want to mark this penalty as ${status}?`)) return;

    fetch('/admin/penalty/update-status', {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify({
            penalty_id: id,
            status: status
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert(data.message || 'Error updating status', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'danger');
        });
}

// View Penalty (Stub)
function viewPenalty(id) {
    const item = window.dbPenalties.find(p => p.id == id);
    if (item) {
        showAlert(`Viewing details for penalty #${item.id}: ${item.reason}`, 'info');
    }
}

// Search functionality
document.getElementById('searchPenalty').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#penaltyTable tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Show alert message
function showAlert(message, type) {
    const existing = document.querySelector('.alert-custom');
    if (existing) existing.remove();

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-custom position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// Export functionality
document.getElementById('exportBtn').addEventListener('click', function () {
    const rows = Array.from(document.querySelectorAll('#penaltyTable tr'));
    const csvContent = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td')).slice(0, -1);
        return cells.map(cell => `"${cell.innerText.trim()}"`).join(',');
    }).join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'penalty_list.csv';
    a.click();
    showAlert('Export downloaded successfully', 'success');
});

// Animation on load
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.fade-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});