<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Equipment Rental Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    {{-- <link rel="stylesheet" href="css/style.css"> --}}
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Sport<span>Rental</span></a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#equipment">Equipment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#categories">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <a href="{{ route('student.login') }}" class="btn btn-outline-primary">Student Login</a>
                    <a href="{{ route('admin.login') }}" class="btn btn-primary ms-2">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1>Sports Equipment Rental Portal</h1>
                    <p>Access a wide range of high-quality sports gear for indoor, outdoor, and fitness activities. Easy booking, flexible scheduling, and convenient pickup options for students and staff.</p>
                    <div class="mt-4">
                        <a href="{{ route('student.register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Register Now
                        </a>
                        <a href="#equipment" class="btn btn-secondary btn-lg">
                            <i class="fas fa-search me-2"></i> Browse Equipment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose SportRental?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-basketball-ball"></i>
                        </div>
                        <h4>Wide Range of Equipment</h4>
                        <p>From indoor sports to outdoor activities and fitness gear, we have everything you need for your sporting endeavors.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Easy Online Booking</h4>
                        <p>Book equipment in just a few clicks. Select your preferred date and time for pickup and return.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Real-time Status Tracking</h4>
                        <p>Monitor your booking status anytime online - from pending approval to collected and returned.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipment Categories -->
    <section class="categories" id="categories">
        <div class="container">
            <div class="section-title">
                <h2>Equipment Categories</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREv8VDYOOXi4MT4xvwfQe4pqaGE4K13Z_6Zw&s');"></div>
                        <div class="category-content">
                            <span class="badge-category">Indoor</span>
                            <h4>Indoor Sports</h4>
                            <p>Table tennis, badminton, chess, carrom, and more indoor equipment.</p>
                            <a href="{{ route('student.equipment-list') }}" class="btn btn-outline-primary btn-sm">View Equipment</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1575361204480-aadea25e6e68?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                        <div class="category-content">
                            <span class="badge-category">Outdoor</span>
                            <h4>Outdoor Sports</h4>
                            <p>Football, cricket, basketball, volleyball, and other outdoor gear.</p>
                            <a href="{{ route('student.equipment-list') }}" class="btn btn-outline-primary btn-sm">View Equipment</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTbfDAWy8FhkWk5-3vUSDWnR6FMjFKKPiMN-Q&s');"></div>
                        <div class="category-content">
                            <span class="badge-category">Fitness</span>
                            <h4>Fitness Equipment</h4>
                            <p>Dumbbells, yoga mats, resistance bands, skipping ropes, and more.</p>
                            <a href="{{ route('student.equipment-list') }}" class="btn btn-outline-primary btn-sm">View Equipment</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="category-card">
                        <div class="category-img" style="background-image: url('https://images.unsplash.com/photo-1527525443983-6e60c75fff46?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                        <div class="category-content">
                            <span class="badge-category">Other</span>
                            <h4>Other Equipment</h4>
                            <p>Camping gear, hiking equipment, adventure sports gear, and more.</p>
                            <a href="{{ route('student.equipment-list') }}" class="btn btn-outline-primary btn-sm">View Equipment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Equipment -->
    <section class="equipment" id="equipment">
        <div class="container">
            <div class="section-title">
                <h2>Popular Equipment</h2>
                <p class="text-muted">Browse our most frequently rented items</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-table-tennis"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Table Tennis Set</h4>
                            <p class="text-muted small mb-3">Complete set with paddles, balls, and net</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 8 left</span>
                                <span><i class="fas fa-tag me-1"></i> Indoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$20 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-futbol"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Football</h4>
                            <p class="text-muted small mb-3">Size 5 professional match football</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 12 left</span>
                                <span><i class="fas fa-tag me-1"></i> Outdoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$15 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Dumbbell Set (10kg)</h4>
                            <p class="text-muted small mb-3">Pair of 10kg adjustable dumbbells</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 5 left</span>
                                <span><i class="fas fa-tag me-1"></i> Fitness</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$25 deposit</div>
                                <span class="equipment-status status-low">Low Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-basketball-ball"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Basketball</h4>
                            <p class="text-muted small mb-3">Official size 7 basketball</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 10 left</span>
                                <span><i class="fas fa-tag me-1"></i> Outdoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$18 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-table-tennis"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Badminton Set</h4>
                            <p class="text-muted small mb-3">2 rackets, shuttlecocks, and net</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 6 left</span>
                                <span><i class="fas fa-tag me-1"></i> Indoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$22 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-spa"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Yoga Mat</h4>
                            <p class="text-muted small mb-3">Premium non-slip yoga mat</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 15 left</span>
                                <span><i class="fas fa-tag me-1"></i> Fitness</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$10 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-volleyball-ball"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Volleyball Set</h4>
                            <p class="text-muted small mb-3">Complete volleyball set with net</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 4 left</span>
                                <span><i class="fas fa-tag me-1"></i> Outdoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$30 deposit</div>
                                <span class="equipment-status status-low">Low Stock</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="equipment-card">
                        <div class="equipment-img">
                            <i class="fas fa-chess"></i>
                        </div>
                        <div class="equipment-content">
                            <h4>Chess Board</h4>
                            <p class="text-muted small mb-3">Standard tournament chess set</p>
                            <div class="equipment-meta">
                                <span><i class="fas fa-box me-1"></i> 9 left</span>
                                <span><i class="fas fa-tag me-1"></i> Indoor</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="equipment-price">$5 deposit</div>
                                <span class="equipment-status status-available">Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('student.login') }}" class="btn btn-primary">View All Equipment</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="features bg-light" id="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>How It Works</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="display-6">1</span>
                        </div>
                        <h4>Browse & Select</h4>
                        <p>Explore our catalog and select the equipment you need for your activity.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="display-6">2</span>
                        </div>
                        <h4>Submit Request</h4>
                        <p>Submit your booking request for approval by sports department staff.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="display-6">3</span>
                        </div>
                         <h4>Pickup & Return</h4>
                        <p>Collect approved equipment and return on time to avoid penalties.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <span class="display-6">4</span>
                        </div>
                        <h4>Pickup & Return</h4>
                        <p>Collect approved equipment and return on time to avoid penalties.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Our Users Say</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            The equipment rental process is so easy and convenient. I can book footballs for our weekend matches with just a few clicks!
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">S</div>
                            <div class="author-info">
                                <h5>Sanjay</h5>
                                <p>Football Team Captain</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            As a fitness enthusiast, I regularly rent dumbbells and yoga mats. The quality is excellent and the deposit return process is seamless.
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">M</div>
                            <div class="author-info">
                                <h5>Mitesh</h5>
                                <p>Fitness Club Member</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-text">
                            The admin dashboard makes it easy to manage equipment and approve requests. Analytics reports help us track usage patterns.
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">D</div>
                            <div class="author-info">
                                <h5>Dipak Suthar</h5>
                                <p>Sports Department Staff</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="500">0</div>
                        <div class="stat-label">Equipment Items</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="1250">0</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="3200">0</div>
                        <div class="stat-label">Bookings This Year</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number" data-count="98">0</div>
                        <div class="stat-label">% Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Ready to Rent Sports Equipment?</h2>
            <p>Join hundreds of students and staff who are already using SportRental for their sporting needs. Register now to get started!</p>
            <div class="mt-4">
                <a href="{{ route('student.register') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i> Register as Student
                </a>
                <a href="{{ route('admin.login') }}" class="btn btn-secondary btn-lg">
                    <i class="fas fa-user-cog me-2"></i> Admin Portal
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-logo">Sport<span>Rental</span></div>
                    <p>Providing premium sports equipment rental services for students and staff with easy booking, flexible options, and excellent support.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/dipak-suthar0560" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Quick Links</h5>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="#equipment">Equipment</a></li>
                            <li><a href="#categories">Categories</a></li>
                            <li><a href="#how-it-works">How It Works</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-links">
                        <h5>Student</h5>
                        <ul>
                            <li><a href="{{ route('student.login') }}">Login</a></li>
                            <li><a href="{{ route('student.register') }}">Register</a></li>
                            <li><a href="{{ route('student.booking-status') }}">My Bookings</a></li>
                            <li><a href="{{ route('student.feedback') }}">Submit Feedback</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="footer-links">
                        <h5>Contact Info</h5>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i> Sports Complex, University Campus</li>
                            <li><i class="fas fa-phone me-2"></i><a href="tel:+916352364846"> +91 6352364846</a></li>
                            <li><i class="fas fa-envelope me-2"></i><a href="mailto:dipaksuthar1107@gmail.com"> dipaksuthar1107@gmail.com</a></li>
                            <li><i class="fas fa-clock me-2"></i> Mon-Fri: 9AM-6PM, Sat: 10AM-4PM</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> Sports Equipment Rental Portal.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    {{-- <script src="js/script.js"></script> --}}
    <link rel="stylesheet" href="{{ asset('/assets/js/script.css') }}">

</body>
</html>