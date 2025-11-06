
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Debug Panel -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999; max-width: 350px;">
    <div class="card shadow-sm" style="font-size: 11px;">
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <strong class="text-muted">Debug - PanesarElite</strong>
            <button class="btn btn-sm btn-outline-secondary py-0 px-1" onclick="toggleDebugPanel()" style="font-size: 10px;">
                <i class="fa-solid fa-eye" id="debugToggleIcon"></i>
            </button>
        </div>
        <div class="card-body py-2" id="debugPanelBody" style="display: none;">
            <div class="mb-1">
                <strong>Firebase:</strong>
                <span id="debugFirebaseStatus" class="text-warning">Loading...</span>
            </div>
            <div class="mb-1">
                <strong>Auth:</strong>
                <span id="debugAuthStatus" class="text-warning">Loading...</span>
            </div>
            <div class="mb-1">
                <strong>User:</strong>
                <span id="debugUserStatus" class="text-muted">None</span>
            </div>
            <div class="mb-1">
                <strong>Page:</strong>
                <span id="debugPageStatus" class="text-info"><?php echo $currentPage ?? 'unknown'; ?></span>
            </div>
            <div>
                <strong>Path:</strong>
                <span class="text-secondary" style="font-size: 9px;"><?php echo $_SERVER['REQUEST_URI'] ?? '-'; ?></span>
            </div>
        </div>
    </div>
</div>

<script>
// Debug panel toggle
let debugPanelVisible = false;

window.toggleDebugPanel = function() {
    debugPanelVisible = !debugPanelVisible;
    const body = document.getElementById('debugPanelBody');
    const icon = document.getElementById('debugToggleIcon');

    if (debugPanelVisible) {
        body.style.display = 'block';
        icon.className = 'fa-solid fa-eye-slash';
    } else {
        body.style.display = 'none';
        icon.className = 'fa-solid fa-eye';
    }
};

// Update debug status
function updateDebugStatus() {
    const firebaseStatus = document.getElementById('debugFirebaseStatus');
    const authStatus = document.getElementById('debugAuthStatus');
    const userStatus = document.getElementById('debugUserStatus');

    if (firebaseStatus) {
        if (window.firebaseApp && window.firebaseAuth && window.firebaseDb) {
            firebaseStatus.innerHTML = '<span class="text-success">✅ Ready</span>';
        } else {
            firebaseStatus.innerHTML = '<span class="text-danger">❌ Failed</span>';
        }
    }

    if (authStatus) {
        if (window.firebaseAuth && window.firebaseAuth.currentUser) {
            authStatus.innerHTML = '<span class="text-success">✅ Signed In</span>';
        } else if (window.firebaseAuth) {
            authStatus.innerHTML = '<span class="text-warning">⚠️ No User</span>';
        } else {
            authStatus.innerHTML = '<span class="text-danger">❌ Failed</span>';
        }
    }

    if (userStatus && window.firebaseAuth && window.firebaseAuth.currentUser) {
        const email = window.firebaseAuth.currentUser.email;
        const shortEmail = email.length > 20 ? email.substring(0, 20) + '...' : email;
        userStatus.innerHTML = `<span class="text-success">${shortEmail}</span>`;
    } else if (userStatus) {
        userStatus.innerHTML = '<span class="text-muted">None</span>';
    }
}

// Update debug status every 2 seconds
setInterval(updateDebugStatus, 2000);

// Update immediately
setTimeout(updateDebugStatus, 500);

console.log('✅ Footer loaded - PanesarElite');
</script>

<!-- Global Navigation Functions -->
<script type="module">
import { buildUrl } from '/site/final/captain/assets/js/config.js';

// Global navigation functions
window.goToNewDispatch = function() {
    window.location.href = buildUrl('/dispatch/new-dispatch.php');
};

window.goToDispatchList = function() {
    window.location.href = buildUrl('/dispatch/dispatch-list.php');
};

window.goToAssign = function() {
    window.location.href = buildUrl('/dispatch/dispatch-assign.php');
};

window.goToTracking = function() {
    window.location.href = buildUrl('/dispatch/dispatch-tracking.php');
};

window.refreshDashboard = function() {
    window.location.reload();
};

console.log('✅ Global navigation functions loaded');
</script>

</body>
</html>
