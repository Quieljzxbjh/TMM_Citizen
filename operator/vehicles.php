<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles - TMM Operator Portal</title>
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
                    <h1 class="h2">Vehicles</h1>
                    <?php if ($isVerified): ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                        <i class="fas fa-plus"></i> Add Vehicle
                    </button>
                    <?php endif; ?>
                </div>

                <?php if (!$isVerified): ?>
                    <?php echo getVerificationMessage(); ?>
                <?php else: ?>
                <!-- Vehicles Table -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Registered Vehicles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="vehiclesTable">
                                <thead>
                                    <tr>
                                        <th>Plate Number</th>
                                        <th>Type</th>
                                        <th>Make/Model</th>
                                        <th>Year</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
                <!-- Add Vehicle Modal -->
                <div class="modal fade" id="addVehicleModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Vehicle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="vehicleForm">
                                    <div class="mb-3">
                                        <label for="plate_number" class="form-label">Plate Number</label>
                                        <input type="text" class="form-control" id="plate_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="vehicle_type" class="form-label">Vehicle Type</label>
                                        <select class="form-select" id="vehicle_type" required>
                                            <option value="Tricycle">Tricycle</option>
                                            <option value="Jeepney">Jeepney</option>
                                            <option value="Bus">Bus</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="make" class="form-label">Make</label>
                                        <input type="text" class="form-control" id="make" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" class="form-control" id="model" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <input type="number" class="form-control" id="year" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="capacity" class="form-label">Seating Capacity</label>
                                        <input type="number" class="form-control" id="capacity" required>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="saveVehicle">Save Vehicle</button>
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
    <script src="assets/js/vehicles.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>