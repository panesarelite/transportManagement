<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebar">
    <div class="position-sticky pt-3">
        <div class="sidebar-content" id="sidebarContent">
            <!-- Will be populated by JavaScript from leftmenu.json -->
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <br><br>
                <small class="text-muted">Loading menu...</small>
            </div>
        </div>
    </div>
</nav>

<script type="module">
import { initializeMenu } from '/site/final/captain/assets/js/ui.js';
import { getCurrentUser, isAuthInitialized } from '/site/final/captain/assets/js/auth.js';
import { buildUrl } from '/site/final/captain/assets/js/config.js';

console.log('📋 Menu component loaded - PanesarElite');

document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Menu DOM loaded, waiting for authentication...');
    
    // Wait for authentication to complete before loading menu
    let menuCheckCount = 0;
    const maxMenuChecks = 50; // 5 seconds
    
    const checkAuth = setInterval(() => {
        menuCheckCount++;
        
        if (isAuthInitialized()) {
            const user = getCurrentUser();
            
            if (user) {
                console.log('✅ User authenticated, loading menu');
                clearInterval(checkAuth);
                initializeMenu();
            } else {
                console.log('❌ No authenticated user, redirecting to login');
                clearInterval(checkAuth);
                window.location.href = buildUrl('/auth/login.php');
            }
        } else if (menuCheckCount >= maxMenuChecks) {
            console.error('❌ Menu authentication check timeout');
            clearInterval(checkAuth);
            
            const sidebarContent = document.getElementById('sidebarContent');
            if (sidebarContent) {
                sidebarContent.innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fa-solid fa-exclamation-triangle fa-2x mb-2"></i>
                        <br>Authentication timeout
                        <br><small>Please refresh the page</small>
                    </div>
                `;
            }
        }
    }, 100);
});
</script>