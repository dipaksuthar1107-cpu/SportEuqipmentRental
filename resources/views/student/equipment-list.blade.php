
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Equipment Details | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Equipment Details CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/equipment-list.css') }}">
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
                <a href="{{ route('student.feedback') }}">
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
        <!-- Equipment Header -->
        <div class="equipment-header">
            <div class="equipment-title">
                <h1>{{ $equipment->name }}</h1>
                <p>{{ $equipment->description }}</p>
                <div class="equipment-badges">
                    <span class="badge badge-category">{{ $equipment->category }}</span>
                    <span class="badge badge-condition">{{ $equipment->condition }} Condition</span>
                    <span class="badge badge-available">{{ $equipment->available }} Available</span>
                </div>
            </div>
            <div class="equipment-icon">
                <i class="{{ $equipment->icon }}"></i>
            </div>
        </div>
        
        <!-- Equipment Details Card -->
        <div class="equipment-card">
            <div class="card-header">
                <h4><i class="fas fa-info-circle me-2"></i> Equipment Details</h4>
                <p>Complete information about this equipment</p>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-section">
                        <div class="info-title">
                            <i class="fas fa-clipboard-list"></i> Basic Information
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Equipment Name</span>
                            <span class="detail-value">{{ $equipment->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Category</span>
                            <span class="detail-value">{{ $equipment->category }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Condition</span>
                            <span class="detail-value">
                                <span class="badge" style="background: rgba(0, 201, 167, 0.1); color: var(--accent);">
                                    {{ $equipment->condition }}
                                </span>
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total Quantity</span>
                            <span class="detail-value">{{ $equipment->quantity }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Available Now</span>
                            <span class="detail-value">{{ $equipment->available }}</span>
                        </div>
                    </div>
                    
                    <div class="info-section">
                        <div class="info-title">
                            <i class="fas fa-money-bill-wave"></i> Pricing & Rental
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Security Deposit</span>
                            <span class="detail-value">₹{{ $equipment->deposit ?? '0' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Daily Rental Rate</span>
                            <span class="detail-value">₹{{ $equipment->daily_rate ?? '0' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Max Rental Period</span>
                            <span class="detail-value">{{ $equipment->max_days ?? 7 }} days</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Late Return Fine</span>
                            <span class="detail-value">₹{{ $equipment->daily_rate ?? '100' }}/day</span>
                        </div>
                    </div>
                </div>
                
                <div class="rules-features-grid">
                    <div class="rules-card">
                        <h5><i class="fas fa-exclamation-triangle"></i> Rental Rules & Regulations</h5>
                        <ul class="rules-list">
                            @if($equipment->rules)
                                @foreach($equipment->rules as $rule)
                                <li>{{ $rule }}</li>
                                @endforeach
                            @else
                                <li>No specific rules mentioned.</li>
                            @endif
                        </ul>
                    </div>
                    
                    <div class="features-card">
                        <h5><i class="fas fa-star"></i> Equipment Features</h5>
                        <ul class="features-list">
                            @if($equipment->features)
                                @foreach($equipment->features as $feature)
                                <li>{{ $feature }}</li>
                                @endforeach
                            @else
                                <li>General sports equipment.</li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <!-- Rating Section -->
                <div class="rating-section">
                    <div class="rating-display">
                        <div class="stars">
                            <?php 
                            $rating = $equipment->rating ?? 0;
                            $fullStars = floor($rating);
                            $hasHalfStar = $rating - $fullStars >= 0.5;
                            
                            for($i = 1; $i <= 5; $i++): 
                                if($i <= $fullStars): ?>
                                    <i class="fas fa-star"></i>
                                <?php elseif($i == $fullStars + 1 && $hasHalfStar): ?>
                                    <i class="fas fa-star-half-alt"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif;
                            endfor; ?>
                        </div>
                        <div class="rating-value">{{ $equipment->rating ?? '0.0' }}</div>
                        <div class="reviews-count">({{ $equipment->reviews ?? 0 }} reviews)</div>
                    </div>
                    <p class="mb-0">Based on feedback from {{ $equipment->reviews ?? 0 }} previous renters</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="btn-request" id="requestEquipmentBtn">
                        <a href="{{ route('student.request-book', ['id' => $equipment->id]) }}" class="btn-request-link">
                            <i class="fas fa-calendar-plus"></i> Request This Equipment
                        </a>
                    </button>
                    <a href="{{ route('student.equipment-list') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Equipment List
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© {{ date("Y") }} Sports Equipment Rental Portal | Equipment Details</p>
        </div>
    </div>

     <!-- Request Modal -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus me-2"></i> Request <?php echo $equipment['name']; ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="equipmentRequestForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pickup Date</label>
                                <input type="date" class="form-control" id="pickupDate" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Return Date</label>
                                <input type="date" class="form-control" id="returnDate" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pickup Time</label>
                                <select class="form-control" id="pickupTime" required>
                                    <option value="">Select Time</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Quantity (Max: <?php echo $equipment['available']; ?>)</label>
                                <input type="number" class="form-control" id="quantity" min="1" max="<?php echo $equipment['available']; ?>" value="1" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Special Instructions (Optional)</label>
                            <textarea class="form-control" id="instructions" rows="3" placeholder="Any specific requirements or notes..."></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> Equipment must be returned in the same condition. Late returns will incur penalty fees of <?php echo $equipment['daily_rate']; ?> per additional day.
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-paper-plane me-2"></i> Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Equipment Details JS -->
    <script src="{{ asset('assets/student/js/equipment-list.js') }}"></script>
</body>
</html>