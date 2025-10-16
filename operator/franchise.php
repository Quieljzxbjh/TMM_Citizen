<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Franchise Applications - TMM Operator Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../commuter/assets/css/commuter.css">
    <link rel="stylesheet" href="assets/css/operator-override.css">
</head>
<body>
    <?php
    include '../includes/config.php';
    include '../includes/header.php';
    
    $isVerified = isset($_SESSION['user_id']) ? isOperatorVerified($_SESSION['user_id']) : false;
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Franchise Applications</h1>
                    <?php if ($isVerified): ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newApplicationModal">
                        <i class="fas fa-plus"></i> New Application
                    </button>
                    <?php endif; ?>
                </div>

                <?php if (!$isVerified): ?>
                    <?php echo getVerificationMessage(); ?>
                <?php else: ?>
                <!-- Applications Table -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Application History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="applicationsTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Vehicle</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Documents</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamically populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($isVerified): ?>
                <!-- New Application Modal -->
                <div class="modal fade" id="newApplicationModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">New Franchise Application</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="applicationForm">
                                    <div class="mb-3">
                                        <label for="vehicle_id" class="form-label">Vehicle</label>
                                        <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                                            <!-- Populated by JavaScript -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="application_type" class="form-label">Application Type</label>
                                        <select class="form-select" id="application_type" name="application_type" required>
                                            <option value="New">New Franchise</option>
                                            <option value="Renewal">Renewal</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="documents" class="form-label">Upload Documents</label>
                                        <input type="file" class="form-control" id="documents" name="documents[]" multiple>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitApplication">Submit Application</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/franchise.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>