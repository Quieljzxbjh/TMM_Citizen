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
    include '../includes/header.php';
    
    // The operator_id will come from the session managed by the main system
    $operator_id = $_SESSION['operator_id'] ?? null;
    ?>

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

    <?php include '../includes/footer.php'; ?>
</body>
</html>