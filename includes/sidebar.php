<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'vehicles.php' ? 'active' : ''; ?>" href="vehicles.php">
                    <i class="fas fa-car"></i>
                    Vehicles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'violations.php' ? 'active' : ''; ?>" href="violations.php">
                    <i class="fas fa-exclamation-triangle"></i>
                    Violations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'franchise.php' ? 'active' : ''; ?>" href="franchise.php">
                    <i class="fas fa-file-contract"></i>
                    Franchise
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'inspections.php' ? 'active' : ''; ?>" href="inspections.php">
                    <i class="fas fa-clipboard-check"></i>
                    Inspections
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'demand.php' ? 'active' : ''; ?>" href="demand.php">
                    <i class="fas fa-chart-line"></i>
                    Demand Forecast
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'terminals.php' ? 'active' : ''; ?>" href="terminals.php">
                    <i class="fas fa-building"></i>
                    Terminal Assignments
                </a>
            </li>
        </ul>
    </div>
</nav>