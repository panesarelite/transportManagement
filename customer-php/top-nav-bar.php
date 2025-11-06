<!-- Navigation -->
<nav class="navbar navbar-expand navbar-dark topbar mb-4 static-top shadow" style="background: linear-gradient(135deg, #6A307E 0%, #3B256E 100%);">
    
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars text-white"></i>
    </button>
    
    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center" href="#" onclick="goToHome()">
        <svg width="24" height="24" viewBox="0 0 24 24" class="me-2">
            <polygon points="12,2 15,9 22,9 17,14 19,21 12,17 5,21 7,14 2,9 9,9" fill="#ff6b6b"/>
        </svg>
        <span class="fw-bold">Captain Dispatch</span>
    </a>
    
    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search dispatches..." 
                   aria-label="Search" aria-describedby="basic-addon2" id="globalSearch">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" onclick="performGlobalSearch()">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Search Dropdown (Responsive) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" 
                               placeholder="Search for..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        
        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                <span class="mr-2 d-none d-lg-inline text-white small" id="topNavUserName">Loading...</span>
                <img class="img-profile rounded-circle" src="#" id="userAvatar" width="32" height="32">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <h6 class="dropdown-header">
                    <span id="topNavUserRole">Loading...</span>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="goToProfile()">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#" onclick="showSettingsModal()">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="performLogout()">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
        
    </ul>
    
</nav>

<script type="module">
import { buildUrl } from '/assets/js/config.js';
import { logout } from '/assets/js/auth.js';

// Set default avatar
document.addEventListener('DOMContentLoaded', function() {
    const avatar = document.getElementById('userAvatar');
    if (avatar) {
        avatar.src = buildUrl('assets/img/avatar1.svg');
    }
});

// Global navigation functions
window.goToHome = function() {
    window.location.href = buildUrl('index.php');
};

window.goToProfile = function() {
    window.location.href = buildUrl('admin/company-profile.php');
};

window.performLogout = function() {
    logout();
};
</script>