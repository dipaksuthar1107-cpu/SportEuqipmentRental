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

// Search functionality
const searchInput = document.getElementById('searchInput');
const feedbackFilter = document.getElementById('feedbackFilter');
const categoryFilter = document.getElementById('categoryFilter');
const historyCards = document.querySelectorAll('.history-card');
const emptyState = document.getElementById('emptyState');
const historyContainer = document.getElementById('historyContainer');

function filterHistory() {
    const searchTerm = searchInput.value.toLowerCase();
    const feedbackValue = feedbackFilter.value;
    const categoryValue = categoryFilter.value;

    let visibleCount = 0;

    historyCards.forEach(card => {
        const equipment = card.getAttribute('data-equipment');
        const category = card.getAttribute('data-category');
        const feedback = card.getAttribute('data-feedback');

        const matchesSearch = equipment.includes(searchTerm) ||
            category.includes(searchTerm) ||
            searchTerm === '';

        const matchesFeedback = feedbackValue === 'all' || feedback === feedbackValue;
        const matchesCategory = categoryValue === 'all' || category === categoryValue;

        if (matchesSearch && matchesFeedback && matchesCategory) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide empty state
    if (visibleCount === 0) {
        emptyState.style.display = 'block';
        historyContainer.style.display = 'none';
    } else {
        emptyState.style.display = 'none';
        historyContainer.style.display = 'grid';
    }
}

// Event listeners for filters
searchInput.addEventListener('input', filterHistory);
feedbackFilter.addEventListener('change', filterHistory);
categoryFilter.addEventListener('change', filterHistory);

// Reset filters
function resetFilters() {
    searchInput.value = '';
    feedbackFilter.value = 'all';
    categoryFilter.value = 'all';
    filterHistory();
}

// View history details
function viewHistoryDetails(historyId) {
    alert('Viewing details for history item #' + historyId + '\n\nThis would show detailed rental history information in a real application.');
}

// Submit feedback
function submitFeedback(historyId) {
    window.location.href = '/student/feedback/' + historyId;
}

// Add hover effects to history cards
historyCards.forEach(card => {
    card.addEventListener('mouseenter', function () {
        this.style.transform = 'translateY(-5px)';
    });

    card.addEventListener('mouseleave', function () {
        this.style.transform = 'translateY(0)';
    });
});

// Initialize filter
filterHistory();