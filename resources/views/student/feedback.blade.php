
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/feedback.css') }}">
</head>
<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="student-info">
                <div class="student-avatar">
                    {{ strtoupper(substr($student_name ?? 'Student', 0, 2)) }}
                </div>
                <h5>{{ $student_name ?? 'Student' }}</h5>
                <p>Student Account</p>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('student.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}" class="{{ Request::is('student/equipment-list*') || Request::is('student/equipment-detail*') ? 'active' : '' }}">
                    <i class="fas fa-basketball-ball"></i>
                    <span>Equipment List</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-status') }}">
                    <i class="fas fa-calendar-check"></i>
                    <span>My Bookings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.booking-history') }}">
                    <i class="fas fa-history"></i>
                    <span>Booking History</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
                    <i class="fas fa-filter"></i>
                    <span>Filter Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.equipment-list') }}">
                    <i class="fas fa-plus-circle"></i>
                    <span>Request Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('student.feedback') }}" class="{{ Request::is('student/feedback*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Submit Feedback</span>
                </a>
            </li>
        </ul>
        
        <div class="sidebar-footer">
            <a href="{{ route('student.logout') }}" class="btn btn-danger btn-sm w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Submit Feedback</h1>
            <p>Share your experience and help us improve our service</p>
        </div>
        
        <!-- Equipment Info -->
        <div class="equipment-info">
            <div class="equipment-details">
                <div class="equipment-icon">
                    <i class="{{ $equipment_icon ?? 'fas fa-box' }}"></i>
                </div>
                <div class="equipment-text">
                    <h5>{{ $equipment_name ?? 'Equipment' }}</h5>
                    <p>{{ $category ?? 'Uncategorized' }} Equipment • Booking #{{ str_pad($booking_id ?? 0, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="booking-badge">
                <i class="fas fa-calendar-check me-2"></i> Recently Returned
            </div>
        </div>
        
        <!-- Feedback Form -->
        <div class="feedback-card">
            <div class="feedback-header">
                <div class="feedback-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h4>Share Your Experience</h4>
                <p>Your feedback helps us improve our equipment and service</p>
            </div>
            
            <div class="feedback-body">
                <!-- Main Form -->
                <form id="feedbackForm">
                    <!-- Overall Rating -->
                    <div class="rating-section">
                        <label class="form-label">
                            <i class="fas fa-star"></i>
                            Overall Experience Rating
                        </label>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="overallRating" value="5">
                            <label for="star5" title="Excellent">★</label>
                            <input type="radio" id="star4" name="overallRating" value="4">
                            <label for="star4" title="Good">★</label>
                            <input type="radio" id="star3" name="overallRating" value="3">
                            <label for="star3" title="Average">★</label>
                            <input type="radio" id="star2" name="overallRating" value="2">
                            <label for="star2" title="Below Average">★</label>
                            <input type="radio" id="star1" name="overallRating" value="1">
                            <label for="star1" title="Poor">★</label>
                        </div>
                        <div class="rating-labels">
                            <span>Poor</span>
                            <span>Excellent</span>
                        </div>
                    </div>
                    
                    <!-- Equipment Condition -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-clipboard-check"></i>
                            Equipment Condition
                        </label>
                        <select class="form-select" id="equipmentCondition" required>
                            <option value="">How was the equipment condition?</option>
                            <option value="excellent">Excellent - Like new</option>
                            <option value="good">Good - Minor signs of use</option>
                            <option value="average">Average - Normal wear and tear</option>
                            <option value="poor">Poor - Significant wear/damage</option>
                            <option value="damaged">Damaged - Required repair</option>
                        </select>
                        <div class="form-text">Please rate the physical condition of the equipment</div>
                    </div>
                    
                    <!-- Category Ratings -->
                    <div class="category-ratings">
                        <div class="category-title">
                            <i class="fas fa-chart-bar"></i>
                            Detailed Ratings
                        </div>
                        
                        <div class="category-item">
                            <div class="category-name">Equipment Quality</div>
                            <div class="star-rating-small">
                                <input type="radio" id="quality5" name="qualityRating" value="5">
                                <label for="quality5">★</label>
                                <input type="radio" id="quality4" name="qualityRating" value="4">
                                <label for="quality4">★</label>
                                <input type="radio" id="quality3" name="qualityRating" value="3">
                                <label for="quality3">★</label>
                                <input type="radio" id="quality2" name="qualityRating" value="2">
                                <label for="quality2">★</label>
                                <input type="radio" id="quality1" name="qualityRating" value="1">
                                <label for="quality1">★</label>
                            </div>
                        </div>
                        
                        <div class="category-item">
                            <div class="category-name">Ease of Booking</div>
                            <div class="star-rating-small">
                                <input type="radio" id="booking5" name="bookingRating" value="5">
                                <label for="booking5">★</label>
                                <input type="radio" id="booking4" name="bookingRating" value="4">
                                <label for="booking4">★</label>
                                <input type="radio" id="booking3" name="bookingRating" value="3">
                                <label for="booking3">★</label>
                                <input type="radio" id="booking2" name="bookingRating" value="2">
                                <label for="booking2">★</label>
                                <input type="radio" id="booking1" name="bookingRating" value="1">
                                <label for="booking1">★</label>
                            </div>
                        </div>
                        
                        <div class="category-item">
                            <div class="category-name">Staff Support</div>
                            <div class="star-rating-small">
                                <input type="radio" id="staff5" name="staffRating" value="5">
                                <label for="staff5">★</label>
                                <input type="radio" id="staff4" name="staffRating" value="4">
                                <label for="staff4">★</label>
                                <input type="radio" id="staff3" name="staffRating" value="3">
                                <label for="staff3">★</label>
                                <input type="radio" id="staff2" name="staffRating" value="2">
                                <label for="staff2">★</label>
                                <input type="radio" id="staff1" name="staffRating" value="1">
                                <label for="staff1">★</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments -->
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-comment-dots"></i>
                            Detailed Feedback
                        </label>
                        <textarea class="form-control" id="comments" rows="4" placeholder="Share your detailed experience, suggestions, or any issues you faced..." required></textarea>
                        <div class="form-text">Your comments help us improve our service</div>
                    </div>
                    
                    <!-- Recommend -->
                    <div class="form-group mb-4">
                        <label class="form-label">
                            <i class="fas fa-thumbs-up"></i>
                            Would you recommend our service?
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recommend" id="recommendYes" value="yes" required>
                            <label class="form-check-label" for="recommendYes">
                                Yes, definitely
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recommend" id="recommendMaybe" value="maybe">
                            <label class="form-check-label" for="recommendMaybe">
                                Maybe
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="recommend" id="recommendNo" value="no">
                            <label class="form-check-label" for="recommendNo">
                                Probably not
                            </label>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Submit Feedback
                        </button>
                        <a href="{{ route('student.booking-history') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
                
                <!-- Thank You Message (Initially hidden) -->
                <div class="thank-you-message" id="thankYouMessage">
                    <div class="thank-you-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Thank You for Your Feedback!</h3>
                    <p>Your feedback has been submitted successfully. We appreciate you taking the time to share your experience with us. Your input helps us improve our equipment and service for everyone.</p>
                    <a href="dashboard.php" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© {{ date("Y") }} Sports Equipment Rental Portal | Submit Feedback</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/student/js/feedback.js') }}"></script>
</body>
</html>