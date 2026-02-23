// Mobile sidebar toggle
const mobileToggle = document.getElementById('mobileToggle');
if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('active');
    });
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('mobileToggle');

    if (window.innerWidth <= 992 &&
        sidebar &&
        !sidebar.contains(event.target) &&
        toggleBtn &&
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
const emptyFilterState = document.getElementById('emptyFilterState');
const historyContainer = document.getElementById('historyContainer');

function filterHistory() {
    if (!searchInput || !feedbackFilter || !categoryFilter) return;

    const searchTerm = searchInput.value.toLowerCase();
    const feedbackValue = feedbackFilter.value;
    const categoryValue = categoryFilter.value;

    let visibleCount = 0;
    const totalCount = historyCards.length;

    historyCards.forEach(card => {
        const equipment = card.getAttribute('data-equipment') || '';
        const category = card.getAttribute('data-category') || '';
        const feedback = card.getAttribute('data-feedback') || '';

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

    // Show/hide empty states
    if (totalCount === 0) {
        // No bookings at all (already handled by Blade initial display, but for safety)
        if (emptyState) emptyState.style.display = 'block';
        if (emptyFilterState) emptyFilterState.style.display = 'none';
        if (historyContainer) historyContainer.style.display = 'none';
    } else if (visibleCount === 0) {
        // Bookings exist but none match filters
        if (emptyState) emptyState.style.display = 'none';
        if (emptyFilterState) emptyFilterState.style.display = 'block';
        if (historyContainer) historyContainer.style.display = 'none';
    } else {
        // Bookings match filters
        if (emptyState) emptyState.style.display = 'none';
        if (emptyFilterState) emptyFilterState.style.display = 'none';
        if (historyContainer) historyContainer.style.display = 'grid';
    }
}

// Event listeners for filters
if (searchInput) searchInput.addEventListener('input', filterHistory);
if (feedbackFilter) feedbackFilter.addEventListener('change', filterHistory);
if (categoryFilter) categoryFilter.addEventListener('change', filterHistory);

// Reset filters
function resetFilters() {
    if (searchInput) searchInput.value = '';
    if (feedbackFilter) feedbackFilter.value = 'all';
    if (categoryFilter) categoryFilter.value = 'all';
    filterHistory();
}

// View history details
function viewHistoryDetails(historyId) {
    alert('Viewing details for history item #' + historyId);
}

// Submit feedback
function submitFeedback(historyId) {
    window.location.href = '/student/feedback/' + historyId;
}

// Initialize filter
if (historyCards.length > 0) {
    filterHistory();
}