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
    <?php include '../includes/config.php'; ?>
    
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
</body>
</html>