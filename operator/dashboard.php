<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Portal - Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../commuter/assets/css/commuter.css">
    <link rel="stylesheet" href="assets/css/operator-override.css">
</head>
<body>
    <?php
    include '../includes/config.php';
    
    // Check if user is logged in
    $isLoggedIn = isset($_SESSION['user_id']);
    $userName = $isLoggedIn ? $_SESSION['name'] ?? 'User' : '';
    
    // The operator_id will come from the session managed by the main system
    $operator_id = $_SESSION['operator_id'] ?? null;
    ?>

    <?php include '../includes/header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card fade-in-up clickable" style="animation-delay: 0.1s">
                            <i class="fas fa-car icon"></i>
                            <div class="stat-value" id="activeVehiclesCount">Loading...</div>
                            <div class="stat-label">Active Vehicles</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card fade-in-up clickable" style="animation-delay: 0.2s">
                            <i class="fas fa-exclamation-triangle icon"></i>
                            <div class="stat-value" id="pendingViolationsCount">Loading...</div>
                            <div class="stat-label">Pending Violations</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card fade-in-up clickable" style="animation-delay: 0.3s">
                            <i class="fas fa-clipboard-check icon"></i>
                            <div class="stat-value" id="upcomingInspectionsCount">Loading...</div>
                            <div class="stat-label">Upcoming Inspections</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card fade-in-up clickable" style="animation-delay: 0.4s">
                            <i class="fas fa-file-contract icon"></i>
                            <div class="stat-value" id="franchiseStatus">Loading...</div>
                            <div class="stat-label">Franchise Status</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card fade-in-up" style="animation-delay: 0.5s">
                            <div class="card-header">
                                <h5><i class="fas fa-history me-2"></i>Recent Violations</h5>
                            </div>
                            <div class="card-body">
                                <div id="recentViolations" class="loading">Loading...</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card fade-in-up" style="animation-delay: 0.6s">
                            <div class="card-header">
                                <h5><i class="fas fa-calendar-alt me-2"></i>Upcoming Schedules</h5>
                            </div>
                            <div class="card-body">
                                <div id="upcomingSchedules" class="loading">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
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
    
    function showVerificationModal() {
        var verificationModal = new bootstrap.Modal(document.getElementById('verificationModal'));
        verificationModal.show();
    }
    
    // Handle verification form submission
    document.getElementById('verificationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('full_name', document.getElementById('fullName').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('license_number', document.getElementById('licenseNumber').value);
        formData.append('documents', document.getElementById('documents').files[0]);
        
        fetch('api/submit_verification.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Verification request submitted successfully! You will be notified once reviewed.');
                bootstrap.Modal.getInstance(document.getElementById('verificationModal')).hide();
                document.getElementById('verificationForm').reset();
            } else {
                alert('Error: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting verification request');
        });
    });
    </script>

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

    <!-- Account Verification Modal -->
    <div class="modal fade" id="verificationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-shield-alt me-2"></i>Account Verification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="verificationForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Complete your account verification to access all operator features and build trust with commuters.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" id="fullName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Address *</label>
                            <textarea class="form-control" id="address" rows="2" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Driver's License Number</label>
                            <input type="text" class="form-control" id="licenseNumber">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Documents *</label>
                            <input type="file" class="form-control" id="documents" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Upload driver's license, certificates, or other verification documents (PDF, JPG, PNG)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-paper-plane me-2"></i>Submit Verification
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>