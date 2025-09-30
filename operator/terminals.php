<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminal Assignments - TMM Operator Portal</title>
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
                    <h1 class="h2">Terminal Assignments</h1>
                </div>

                <!-- Active Terminals -->
                <div class="row mb-4" id="activeTerminals">
                    <!-- Dynamically populated by JavaScript -->
                </div>

                <!-- Terminal List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Terminal History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="terminalsTable">
                                <thead>
                                    <tr>
                                        <th>Terminal</th>
                                        <th>Code</th>
                                        <th>Location</th>
                                        <th>Operating Hours</th>
                                        <th>Assigned Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamically populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/terminals.js"></script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>