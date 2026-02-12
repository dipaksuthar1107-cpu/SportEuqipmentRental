// Mobile sidebar toggle
document.getElementById('mobileToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('active');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('mobileToggle');

    if (window.innerWidth <= 992 &&
        !sidebar.contains(event.target) &&
        !toggleBtn.contains(event.target) &&
        sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});

// Filter functionality
const filterButtons = document.querySelectorAll('.filter-btn');
const searchInput = document.getElementById('searchInput');
const equipmentCards = document.querySelectorAll('.equipment-card');
const resultsCount = document.getElementById('resultsCount');
const equipmentGrid = document.getElementById('equipmentGrid');

let activeCategory = 'all';
let searchTerm = '';

// Filter by category buttons
filterButtons.forEach(button => {
    button.addEventListener('click', function () {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));

        // Add active class to clicked button
        this.classList.add('active');

        activeCategory = this.getAttribute('data-category');
        filterEquipment();
    });
});

// Search functionality
searchInput.addEventListener('input', function () {
    searchTerm = this.value.toLowerCase().trim();
    filterEquipment();
});

// Filter equipment based on category and search
function filterEquipment() {
    let visibleCount = 0;

    equipmentCards.forEach(card => {
        const category = card.getAttribute('data-category');
        const name = card.getAttribute('data-name');

        const matchesCategory = activeCategory === 'all' || category === activeCategory;
        const matchesSearch = searchTerm === '' || name.includes(searchTerm);

        if (matchesCategory && matchesSearch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Update results count
    resultsCount.textContent = visibleCount;

    // Show empty state if no results
    if (visibleCount === 0) {
        showEmptyState();
    } else {
        removeEmptyState();
    }
}

// Show empty state
function showEmptyState() {
    let emptyState = document.getElementById('emptyState');
    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'emptyState';
        emptyState.className = 'empty-state';
        emptyState.innerHTML = `
            <i class="fas fa-search"></i>
            <h4>No equipment found</h4>
            <p>Try adjusting your search or filter criteria</p>
            <button class="btn btn-primary" onclick="resetFilters()">
                <i class="fas fa-redo me-2"></i> Reset Filters
            </button>
        `;
        equipmentGrid.appendChild(emptyState);
    }
}

// Remove empty state
function removeEmptyState() {
    const emptyState = document.getElementById('emptyState');
    if (emptyState) {
        emptyState.remove();
    }
}

// Reset all filters
function resetFilters() {
    // Reset category filter
    filterButtons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-category') === 'all') {
            btn.classList.add('active');
        }
    });

    // Reset search
    searchInput.value = '';

    // Reset variables
    activeCategory = 'all';
    searchTerm = '';

    // Apply filters
    filterEquipment();
}

// View equipment details
function viewEquipment(equipmentId) {
    window.location.href = `/student/equipment-detail/${equipmentId}`;
}

// Request equipment
function requestEquipment(equipmentId) {
    window.location.href = `/student/request-book/${equipmentId}`;
}

// Add hover effects to equipment cards
equipmentCards.forEach(card => {
    card.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-5px)';
    });

    card.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
    });
});

// Initialize filter
filterEquipment();