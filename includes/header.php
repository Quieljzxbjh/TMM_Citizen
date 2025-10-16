<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">TMM Operator Portal</a>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown me-3">
            <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" onclick="showProfile(); return false;"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" onclick="confirmLogout(); return false;"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    <?php endif; ?>
    
    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" style="margin-right: 15px;">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>