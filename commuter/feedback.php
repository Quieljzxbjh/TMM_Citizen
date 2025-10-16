<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback & Complaints - TMM Commuter Portal</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="routes.php">Routes</a></li>
                    <li class="nav-item"><a class="nav-link" href="terminals.php">Terminals</a></li>
                    <li class="nav-item"><a class="nav-link" href="franchise-check.php">Franchise Check</a></li>
                    <li class="nav-item"><a class="nav-link active" href="feedback.php">Feedback</a></li>
                </ul>
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
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-success text-white py-5">
        <div class="container">
            <h1 class="display-5 fw-bold">Feedback & Complaints</h1>
            <p class="lead">Share your experience and help improve transport services</p>
        </div>
    </section>

    <!-- Feedback Forms -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-star me-2"></i>Rate Service</h5>
                        </div>
                        <div class="card-body">
                            <form id="feedbackForm">
                                <div class="mb-3">
                                    <label class="form-label">Plate Number</label>
                                    <input type="text" class="form-control" id="feedbackPlate" placeholder="e.g., ABC-1234" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <div class="rating-stars" id="ratingStars">
                                        <i class="fas fa-star star" data-rating="1"></i>
                                        <i class="fas fa-star star" data-rating="2"></i>
                                        <i class="fas fa-star star" data-rating="3"></i>
                                        <i class="fas fa-star star" data-rating="4"></i>
                                        <i class="fas fa-star star" data-rating="5"></i>
                                    </div>
                                    <input type="hidden" id="rating" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Comments (Optional)</label>
                                    <textarea class="form-control" id="comments" rows="3" placeholder="Share your experience..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Feedback
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-exclamation-triangle me-2"></i>File Complaint</h5>
                        </div>
                        <div class="card-body">
                            <form id="complaintForm">
                                <div class="mb-3">
                                    <label class="form-label">Plate Number</label>
                                    <input type="text" class="form-control" id="complaintPlate" placeholder="e.g., ABC-1234" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Complaint Type</label>
                                    <select class="form-select" id="complaintType" required>
                                        <option value="">Select complaint type</option>
                                        <option value="Overcharging">Overcharging</option>
                                        <option value="Reckless Driving">Reckless Driving</option>
                                        <option value="Poor Service">Poor Service</option>
                                        <option value="Vehicle Condition">Vehicle Condition</option>
                                        <option value="Route Violation">Route Violation</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="complaintDescription" rows="4" placeholder="Describe the incident..." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Your Contact (Optional)</label>
                                    <input type="text" class="form-control" id="complaintContact" placeholder="Phone or email for follow-up">
                                </div>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-file-alt me-2"></i>Submit Complaint
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Feedback Display -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5><i class="fas fa-comments me-2"></i>Community Feedback</h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="loadFeedback()">
                                <i class="fas fa-refresh me-1"></i>Refresh
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="feedbackList">
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Loading feedback...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Guidelines -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle me-2"></i>Guidelines</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>For Feedback:</h6>
                                    <ul class="small">
                                        <li>Rate your overall experience (1-5 stars)</li>
                                        <li>Be honest and constructive</li>
                                        <li>Help operators improve their service</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>For Complaints:</h6>
                                    <ul class="small">
                                        <li>Provide accurate plate number</li>
                                        <li>Include date, time, and location</li>
                                        <li>Be specific about the incident</li>
                                        <li>Complaints are reviewed within 3-5 business days</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feedback.js"></script>
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
    
    function loadFeedback() {
        $('#feedbackList').html('<div class="text-center py-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted">Loading feedback...</p></div>');
        
        $.get('api/get_feedback.php')
            .done(function(data) {
                displayFeedback(data);
            })
            .fail(function() {
                $('#feedbackList').html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Failed to load feedback. Please try again.</div>');
            });
    }
    
    function displayFeedback(feedbacks) {
        if (!feedbacks || feedbacks.length === 0) {
            $('#feedbackList').html('<div class="empty-state"><i class="fas fa-comment-slash"></i><p class="mb-0">No feedback available yet</p></div>');
            return;
        }
        
        let html = '';
        feedbacks.forEach(function(feedback) {
            const stars = '★'.repeat(feedback.rating) + '☆'.repeat(5 - feedback.rating);
            const date = new Date(feedback.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
            
            html += `
                <div class="feedback-item border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="feedback-stars">${stars}</div>
                            <small class="feedback-date">Operator: ${feedback.operator_name || 'Anonymous'} • ${date}</small>
                        </div>
                        <span class="badge bg-primary feedback-rating-badge">${feedback.rating}/5</span>
                    </div>
                    ${feedback.comments ? `<p class="mt-2 mb-0 text-dark">${feedback.comments}</p>` : '<p class="mt-2 mb-0 text-muted fst-italic">No additional comments</p>'}
                </div>
            `;
        });
        
        $('#feedbackList').html(html);
    }
    
    // Load feedback on page load
    $(document).ready(function() {
        loadFeedback();
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
</body>
</html>