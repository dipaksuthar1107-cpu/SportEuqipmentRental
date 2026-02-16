
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Equipment | Sports Rental</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/student/css/request-book.css') }}">
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
                <a href="{{ route('student.equipment-list') }}" class="active">
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
        <!-- Page Header -->
        <div class="page-header">
            <h1>Request Equipment</h1>
            <p>Submit a request to book sports equipment for rental</p>
        </div>
        
        <!-- Equipment Info -->
        <div class="equipment-info">
            <div class="equipment-details">
                <h4>Requesting: {{ $equipment->name }}</h4>
                <p>Complete the form below to submit your booking request</p>
            </div>
            <div class="equipment-badge">
                <i class="fas fa-clock me-2"></i> 24-48 hour approval
            </div>
        </div>
        
        <!-- Request Form -->
        <div class="request-card">
            <div class="request-header">
                <div class="request-icon" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background: #fff; border-radius: 12px; border: 1px solid #eee;">
                    @if($equipment->image)
                        <img src="{{ asset('storage/' . $equipment->image) }}" alt="{{ $equipment->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-calendar-plus"></i>
                    @endif
                </div>
                <h4>Booking Request Form</h4>
                <p>Fill in the details for your equipment rental</p>
            </div>
            
            <div class="request-body">
                <form id="requestForm">
                    @csrf
                    <input type="hidden" id="equipment_id" value="{{ $equipment->id }}">
                    <!-- Equipment Details -->
                    <div class="form-group">
                        <label class="form-label">Equipment</label>
                        <div class="input-group">
                            <span class="input-group-text" style="padding: 0; width: 40px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                @if($equipment->image)
                                    <img src="{{ asset('storage/' . $equipment->image) }}" alt="{{ $equipment->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="{{ $equipment->icon ?? 'fas fa-dumbbell' }}"></i>
                                @endif
                            </span>
                            <input type="text" class="form-control" value="{{ $equipment->name }}" readonly>
                        </div>
                        <div class="form-text">If you want to request different equipment, go back to the equipment list</div>
                    </div>
                    
                    <!-- Quantity & Duration -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-boxes"></i>
                                </span>
                                <input type="number" class="form-control" id="quantity" min="1" max="{{ $equipment->available }}" value="1" required>
                            </div>
                            <div class="form-text">Maximum {{ $equipment->available }} items available</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Rental Duration (Days)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </span>
                                <select class="form-select" id="duration" required>
                                    <option value="">Select Duration</option>
                                    <option value="1">1 Day</option>
                                    <option value="2">2 Days</option>
                                    <option value="3">3 Days</option>
                                    <option value="4">4 Days</option>
                                    <option value="5">5 Days</option>
                                    <option value="7">1 Week</option>
                                    <option value="14">2 Weeks</option>
                                </select>
                            </div>
                            <div class="form-text">Maximum rental period is 2 weeks</div>
                        </div>
                    </div>
                    
                    <!-- Date & Time -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Pickup Date</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <input type="date" class="form-control" id="pickupDate" required>
                            </div>
                            <div class="form-text">Equipment will be available from this date</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Pickup Time</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <select class="form-select" id="pickupTime" required>
                                    <option value="">Select Time</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                </select>
                            </div>
                            <div class="form-text">Sports department hours: 9AM - 5PM</div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="form-group">
                        <label class="form-label">Purpose / Special Instructions</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-comment"></i>
                            </span>
                            <textarea class="form-control" id="purpose" rows="3" placeholder="e.g., For college tournament practice, need 2 cricket bats and 1 football..."></textarea>
                        </div>
                        <div class="form-text">Optional: Let us know how you plan to use the equipment</div>
                    </div>
                    
                    <!-- Emergency Contact -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Emergency Contact Number</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" class="form-control" id="emergencyContact" placeholder="+91 98765 43210">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Alternate Contact (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-mobile-alt"></i>
                                </span>
                                <input type="tel" class="form-control" id="alternateContact" placeholder="+91 98765 43210">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rules Section -->
                    <div class="rules-section">
                        <div class="rules-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Rental Rules & Agreement
                        </div>
                        <ul class="rules-list">
                            @if($equipment->rules)
                                @foreach($equipment->rules as $rule)
                                <li>{{ $rule }}</li>
                                @endforeach
                            @else
                                <li>Equipment must be returned in the same condition</li>
                                <li>Late returns will incur penalty fees (₹{{ $equipment->daily_rate ?? '100' }}/day)</li>
                                <li>Damage to equipment will result in deposit forfeiture</li>
                                <li>Student ID must be presented at pickup</li>
                            @endif
                            <li>Booking approval takes 24-48 hours</li>
                        </ul>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" id="agreeRules" required>
                            <label class="form-check-label" for="agreeRules">
                                I agree to the rental rules and conditions
                            </label>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Submit Request
                        </button>
                        <a href="{{ route('student.equipment-list') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p class="mb-0">© {{ date("Y") }} Sports Equipment Rental Portal | Request Equipment</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/student/js/request-book.js') }}"></script>
</body>
</html>