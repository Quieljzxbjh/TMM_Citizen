<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violations - TMM Operator Portal</title>
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
    ?>

    <div class="container-fluid">
        <div class="row">
            <?php include '../includes/sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Violations</h1>
                </div>

                <!-- Violations Table -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Violation History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="violationsTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Vehicle</th>
                                        <th>Type</th>
                                        <th>Location</th>
                                        <th>Fine</th>
                                        <th>Status</th>
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

                <!-- File Complaint Modal -->
                <div class="modal fade" id="complaintModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">File a Complaint</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="complaintForm">
                                    <input type="hidden" id="violation_id" name="violation_id">
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Reason for Complaint</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="submitComplaint">Submit Complaint</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/violations.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>