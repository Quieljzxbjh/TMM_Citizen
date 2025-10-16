<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMM Commuter Portal - Caloocan City</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/commuter.css">
</head>
<body>
    <?php 
    include '../includes/config.php'; 
    
    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']);
    $userName = $isLoggedIn ? $_SESSION['name'] ?? 'User' : '';
    ?>
    
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-bus me-2"></i>TMM Commuter Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="routes.php">Routes</a></li>
                    <li class="nav-item"><a class="nav-link" href="terminals.php">Terminals</a></li>
                    <li class="nav-item"><a class="nav-link" href="franchise-check.php">Franchise Check</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../gsm_login/Login/index.html"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class="dropdown ms-3">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($userName); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#" onclick="showProfile(); return false;"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="confirmLogout(); return false;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-4 fw-bold mb-4">Plan Your Journey with Confidence</h1>
                    <p class="lead mb-4">Real-time transport information, route planning, and service updates for Caloocan City commuters.</p>
                    <div class="d-flex gap-3">
                        <a href="routes.php" class="btn btn-primary btn-lg">Find Routes</a>
                        <a href="franchise-check.php" class="btn btn-outline-primary btn-lg">Check Franchise</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-clock feature-icon"></i>
                        <h5>Real-Time Updates</h5>
                        <p>Get live information on vehicle availability and schedules</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-map-marked-alt feature-icon"></i>
                        <h5>Route Planning</h5>
                        <p>Find the best routes and alternative paths for your journey</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h5>Franchise Verification</h5>
                        <p>Verify if vehicles and operators are properly registered</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card text-center">
                        <i class="fas fa-comments feature-icon"></i>
                        <h5>Feedback System</h5>
                        <p>Share your experience and help improve transport services</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Current Demand Forecast -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Current Transport Status</h2>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-chart-line me-2"></i>Demand Forecast</h5>
                        </div>
                        <div class="card-body">
                            <div id="demandForecast">Loading forecast data...</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-bullhorn me-2"></i>Announcements</h5>
                        </div>
                        <div class="card-body">
                            <div id="announcements">Loading announcements...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user me-2"></i>User Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-4x text-success"></i>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Name:</strong></div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($userName); ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4"><strong>Email:</strong></div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4"><strong>Role:</strong></div>
                        <div class="col-sm-8"><?php echo htmlspecialchars(ucfirst($_SESSION['role'] ?? 'N/A')); ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4"><strong>User ID:</strong></div>
                        <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['user_id'] ?? 'N/A'); ?></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-sign-out-alt me-2"></i>Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out of your account?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="doLogout()">Yes, Logout</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/commuter.js"></script>
    <script>
    function showProfile() {
        var profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
        profileModal.show();
    }
    
    function confirmLogout() {
        var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        logoutModal.show();
    }
    
    function doLogout() {
        window.location.href = '../gsm_login/Login/logout.php';
    }
    </script>
</body>
</html>