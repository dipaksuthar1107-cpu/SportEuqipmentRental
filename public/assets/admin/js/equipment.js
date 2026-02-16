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

// Add Equipment
document.getElementById('addEquipmentForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const submitBtn = document.getElementById('addEquipmentBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
    submitBtn.disabled = true;
    const formData = new FormData(this);

    fetch('/admin/equipment/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert(data.message || 'Error adding equipment', 'danger');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
});

// Edit Equipment - Populate Modal
function editEquipment(id) {
    const item = window.dbEquipment.find(e => e.id == id);
    if (!item) return;

    document.getElementById('editEquipmentId').value = item.id;
    document.getElementById('editEquipmentName').value = item.name;
    document.getElementById('editEquipmentCategory').value = item.category;
    document.getElementById('editEquipmentQuantity').value = item.quantity;
    document.getElementById('editEquipmentDeposit').value = item.deposit;
    document.getElementById('editEquipmentDailyRate').value = item.daily_rate;
    document.getElementById('editEquipmentDescription').value = item.description || '';

    // Image Preview
    const previewDiv = document.getElementById('currentImagePreview');
    if (item.image) {
        previewDiv.innerHTML = `
            <p class="small text-muted mb-1">Current Image:</p>
            <img src="/storage/${item.image}" class="img-thumbnail" style="max-height: 100px;">
        `;
    } else {
        previewDiv.innerHTML = '<p class="small text-muted mb-1">No image uploaded.</p>';
    }

    const editModal = new bootstrap.Modal(document.getElementById('editEquipmentModal'));
    editModal.show();
}

// Update Equipment
document.getElementById('updateEquipmentBtn').addEventListener('click', function () {
    const btn = this;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
    btn.disabled = true;

    const form = document.getElementById('editEquipmentForm');
    const formData = new FormData(form);

    fetch('/admin/equipment/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert(data.message || 'Error updating equipment', 'danger');
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

// Delete Equipment
function deleteEquipment(id) {
    if (!confirm('Are you sure you want to delete this equipment? This cannot be undone.')) return;

    fetch('/admin/equipment/delete', {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert(data.message || 'Error deleting equipment', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred', 'danger');
        });
}

// View functionality (Stub)
function viewEquipment(id) {
    const item = window.dbEquipment.find(e => e.id == id);
    if (item) {
        showAlert(`Viewing details for: ${item.name}`, 'info');
    }
}

// Search functionality
document.getElementById('searchEquipment').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#equipmentTable tbody tr');

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
    const rows = Array.from(document.querySelectorAll('#equipmentTable tr'));
    const csvContent = rows.map(row => {
        const cells = Array.from(row.querySelectorAll('th, td')).slice(0, -1);
        return cells.map(cell => `"${cell.innerText.trim()}"`).join(',');
    }).join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'equipment_list.csv';
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