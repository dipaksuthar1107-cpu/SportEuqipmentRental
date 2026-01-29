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

// Equipment data storage (in real app, this would be from server)
let equipmentData = [
    { id: 1, name: "Cricket Bat", code: "BAT-001", category: "Outdoor", quantity: 20, available: 15, condition: "good" },
    { id: 2, name: "Football", code: "FB-002", category: "Outdoor", quantity: 15, available: 10, condition: "excellent" },
    { id: 3, name: "Tennis Racket", code: "TR-003", category: "Indoor", quantity: 12, available: 8, condition: "average" },
    { id: 4, name: "Basketball", code: "BB-004", category: "Outdoor", quantity: 18, available: 12, condition: "good" },
    { id: 5, name: "Dumbbell Set", code: "DB-005", category: "Fitness", quantity: 25, available: 20, condition: "excellent" }
];

let nextId = 6;

// Form submission
document.getElementById('addEquipmentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('equipmentName').value;
    const category = document.getElementById('equipmentCategory').value;
    const quantity = parseInt(document.getElementById('equipmentQuantity').value);
    const condition = document.getElementById('equipmentCondition').value;

    // Generate equipment code
    const categoryCode = category.substring(0, 2).toUpperCase();
    const code = `${categoryCode}-${String(nextId).padStart(3, '0')}`;

    // Create new equipment
    const newEquipment = {
        id: nextId++,
        name: name,
        code: code,
        category: category.charAt(0).toUpperCase() + category.slice(1),
        quantity: quantity,
        available: quantity,
        condition: condition
    };

    // Add to data array
    equipmentData.push(newEquipment);

    // Add to table
    addEquipmentToTable(newEquipment);

    // Update stats
    updateStats('add');

    // Show success message
    showAlert(`${name} added successfully!`, 'success');

    // Reset form
    this.reset();
});

// Add equipment to table
function addEquipmentToTable(equipment) {
    const tableBody = document.getElementById('equipmentTableBody');
    const conditionClass = getConditionClass(equipment.condition);
    const conditionText = getConditionText(equipment.condition);

    const row = document.createElement('tr');
    row.id = `equipment-${equipment.id}`;
    row.innerHTML = `
        <td>${equipment.id}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                    <i class="fas ${getEquipmentIcon(equipment.category)}"></i>
                </div>
                <div>
                    <strong>${equipment.name}</strong>
                    <div class="text-muted small">${equipment.code}</div>
                </div>
            </div>
        </td>
        <td>${equipment.category}</td>
        <td>${equipment.quantity}</td>
        <td>${equipment.available}</td>
        <td>
            <span class="status-badge ${conditionClass}">${conditionText}</span>
        </td>
        <td>
            <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${equipment.id}" data-bs-toggle="tooltip" title="Edit">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger me-1 delete-btn" data-id="${equipment.id}" data-bs-toggle="tooltip" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
            <button class="btn btn-sm btn-info view-btn" data-id="${equipment.id}" data-bs-toggle="tooltip" title="View Details">
                <i class="fas fa-eye"></i>
            </button>
        </td>
    `;

    tableBody.appendChild(row);

    // Reinitialize tooltips
    const tooltipTriggerList = [].slice.call(row.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Get equipment icon based on category
function getEquipmentIcon(category) {
    const icons = {
        'Outdoor': 'fa-baseball-bat-ball',
        'Indoor': 'fa-table-tennis-paddle-ball',
        'Fitness': 'fa-dumbbell',
        'Other': 'fa-basketball'
    };
    return icons[category] || 'fa-basketball';
}

// Get condition class
function getConditionClass(condition) {
    const classes = {
        'excellent': 'status-excellent',
        'good': 'status-good',
        'average': 'status-average'
    };
    return classes[condition] || 'status-good';
}

// Get condition text
function getConditionText(condition) {
    const texts = {
        'excellent': 'Excellent',
        'good': 'Good',
        'average': 'Average'
    };
    return texts[condition] || 'Good';
}

// Update stats
function updateStats(action) {
    const totalElem = document.getElementById('totalEquipment');
    const availableElem = document.getElementById('availableEquipment');

    if (action === 'add') {
        totalElem.textContent = parseInt(totalElem.textContent) + 1;
        availableElem.textContent = parseInt(availableElem.textContent) + 1;
    } else if (action === 'delete') {
        totalElem.textContent = parseInt(totalElem.textContent) - 1;
        availableElem.textContent = Math.max(0, parseInt(availableElem.textContent) - 1);
    }

    // Add animation effect
    [totalElem, availableElem].forEach(elem => {
        elem.style.transform = 'scale(1.2)';
        setTimeout(() => {
            elem.style.transform = 'scale(1)';
        }, 300);
    });
}

// Delete equipment
document.addEventListener('click', function (e) {
    if (e.target.closest('.delete-btn')) {
        const deleteBtn = e.target.closest('.delete-btn');
        const equipmentId = deleteBtn.dataset.id;

        if (confirm('Are you sure you want to delete this equipment?')) {
            // Remove from data array
            equipmentData = equipmentData.filter(eq => eq.id != equipmentId);

            // Remove from table
            const row = document.getElementById(`equipment-${equipmentId}`);
            if (row) {
                row.style.opacity = '0.5';
                setTimeout(() => {
                    row.remove();
                    // Update stats
                    updateStats('delete');
                    // Show alert
                    showAlert('Equipment deleted successfully!', 'danger');
                }, 300);
            }
        }
    }

    // Edit equipment
    if (e.target.closest('.edit-btn')) {
        const editBtn = e.target.closest('.edit-btn');
        const equipmentId = editBtn.dataset.id;
        editEquipment(equipmentId);
    }

    // View equipment
    if (e.target.closest('.view-btn')) {
        const viewBtn = e.target.closest('.view-btn');
        const equipmentId = viewBtn.dataset.id;
        viewEquipment(equipmentId);
    }
});

// Edit equipment
function editEquipment(equipmentId) {
    const equipment = equipmentData.find(eq => eq.id == equipmentId);
    if (!equipment) return;

    // In real app, open a modal with form pre-filled
    showAlert(`Editing: ${equipment.name}`, 'warning');

    // For demo, let's update some values
    const newName = prompt('Enter new equipment name:', equipment.name);
    if (newName) {
        equipment.name = newName;
        updateEquipmentRow(equipmentId);
        showAlert(`${equipment.name} updated successfully!`, 'success');
    }
}

// View equipment details
function viewEquipment(equipmentId) {
    const equipment = equipmentData.find(eq => eq.id == equipmentId);
    if (!equipment) return;

    const details = `
        Equipment Details:
        -----------------
        ID: ${equipment.id}
        Name: ${equipment.name}
        Code: ${equipment.code}
        Category: ${equipment.category}
        Total Quantity: ${equipment.quantity}
        Available: ${equipment.available}
        Condition: ${equipment.condition.charAt(0).toUpperCase() + equipment.condition.slice(1)}
        Rented: ${equipment.quantity - equipment.available}
    `;

    showAlert(details, 'info');
}

// Update equipment row
function updateEquipmentRow(equipmentId) {
    const equipment = equipmentData.find(eq => eq.id == equipmentId);
    if (!equipment) return;

    const row = document.getElementById(`equipment-${equipmentId}`);
    if (!row) return;

    // Update name
    const nameCell = row.querySelector('td:nth-child(2) strong');
    nameCell.textContent = equipment.name;

    // Update other cells if needed
    // row.cells[2].textContent = equipment.category;
    // row.cells[3].textContent = equipment.quantity;
    // row.cells[4].textContent = equipment.available;
}

// Search functionality
document.getElementById('searchEquipment').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#equipmentTable tbody tr');

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Export functionality
document.getElementById('exportBtn').addEventListener('click', function () {
    showAlert('Exporting equipment data to CSV...', 'info');
    // In real app, generate and download CSV
});

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
        ${message.replace(/\n/g, '<br>')}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Add animation to cards on load
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.fade-in');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Calculate initial stats
    calculateStats();
});

// Calculate and display stats
function calculateStats() {
    const total = equipmentData.length;
    const available = equipmentData.reduce((sum, eq) => sum + eq.available, 0);
    const rented = equipmentData.reduce((sum, eq) => sum + (eq.quantity - eq.available), 0);

    // Update DOM
    document.getElementById('totalEquipment').textContent = total;
    document.getElementById('availableEquipment').textContent = available;
    document.getElementById('rentedEquipment').textContent = rented;

    // For demo, maintenance is 10% of total
    const maintenance = Math.floor(total * 0.1);
    document.getElementById('maintenanceEquipment').textContent = maintenance;
}