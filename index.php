<?php
$pageTitle = "Dashboard - Captain Dispatch";
$currentPage = "dashboard";
include 'customer-php/header.php';
include 'customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include 'customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <input type="date" id="dateFilter" class="form-control" />
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshDashboard()">
                        <i class="fa-solid fa-rotate-right"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Authentication Status -->
            <div class="alert alert-info" id="authStatus" style="display: none;">
                <i class="fa-solid fa-info-circle me-2"></i>
                <span id="authStatusText">Checking authentication...</span>
            </div>

            <!-- KPI Cards -->
            <div class="row mb-4">
                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Today's Dispatches</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-total">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Assigned</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-assigned">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">En Route</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-enroute">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-truck-fast fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">On Site</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-onsite">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-location-dot fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-completed">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Delayed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpi-delayed">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select class="form-select" id="statusFilter" multiple>
                                <option value="New">New</option>
                                <option value="Needs Info">Needs Info</option>
                                <option value="Approved">Approved</option>
                                <option value="Assigned">Assigned</option>
                                <option value="En Route">En Route</option>
                                <option value="On Site">On Site</option>
                                <option value="Completed">Completed</option>
                                <option value="Delayed">Delayed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="taskTypeFilter" class="form-label">Task Type</label>
                            <select class="form-select" id="taskTypeFilter">
                                <option value="">All Types</option>
                                <option value="City">City</option>
                                <option value="Highway">Highway</option>
                                <option value="Moves">Moves</option>
                                <option value="Highway + City">Highway + City</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="reeferFilter" class="form-label">Reefer Required</label>
                            <select class="form-select" id="reeferFilter">
                                <option value="">All</option>
                                <option value="true">Yes</option>
                                <option value="false">No</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="dateFrom" class="form-label">Date From</label>
                            <input type="date" class="form-control" id="dateFrom" />
                        </div>
                        <div class="col-md-2">
                            <label for="dateTo" class="form-label">Date To</label>
                            <input type="date" class="form-control" id="dateTo" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
                            <button type="button" class="btn btn-outline-secondary ms-2" onclick="clearFilters()">Clear</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Dispatches -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Dispatches</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dashboardTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Start Location</th>
                                    <th>Destination</th>
                                    <th>Task Type</th>
                                    <th>Status</th>
                                    <th>Driver</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="dashboardTableBody">
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <br><br>Loading dispatches...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Canada Map Visualization -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Route Visualization</h6>
                        </div>
                        <div class="card-body">
                            <svg viewBox="0 0 800 600" class="w-100" style="max-height: 400px;">
                                <!-- Simplified Canada map with Calgary focus -->
                                <defs>
                                    <radialGradient id="pulseGradient" cx="50%" cy="50%" r="50%">
                                        <stop offset="0%" style="stop-color:#6A307E;stop-opacity:1" />
                                        <stop offset="100%" style="stop-color:#6A307E;stop-opacity:0" />
                                    </radialGradient>
                                </defs>
                                
                                <!-- Canada outline (simplified) -->
                                <path d="M100,200 L700,200 L700,150 L650,100 L600,80 L500,70 L400,80 L300,90 L200,110 L150,140 L100,180 Z" 
                                      fill="#f8f9fa" stroke="#dee2e6" stroke-width="2"/>
                                
                                <!-- Calgary (origin point) -->
                                <circle cx="300" cy="250" r="8" fill="#6A307E">
                                    <animate attributeName="r" values="8;12;8" dur="2s" repeatCount="indefinite"/>
                                </circle>
                                <text x="300" y="275" text-anchor="middle" class="small">Calgary</text>
                                
                                <!-- Route lines to major cities -->
                                <line x1="300" y1="250" x2="450" y2="200" stroke="#6A307E" stroke-width="2" opacity="0.6">
                                    <animate attributeName="stroke-dasharray" values="0,1000;1000,0" dur="3s" repeatCount="indefinite"/>
                                </line>
                                <line x1="300" y1="250" x2="200" y2="180" stroke="#6A307E" stroke-width="2" opacity="0.6">
                                    <animate attributeName="stroke-dasharray" values="0,1000;1000,0" dur="3.5s" repeatCount="indefinite"/>
                                </line>
                                <line x1="300" y1="250" x2="550" y2="180" stroke="#6A307E" stroke-width="2" opacity="0.6">
                                    <animate attributeName="stroke-dasharray" values="0,1000;1000,0" dur="4s" repeatCount="indefinite"/>
                                </line>
                                
                                <!-- Destination cities -->
                                <circle cx="450" cy="200" r="4" fill="#3B256E"/>
                                <text x="450" y="190" text-anchor="middle" class="small">Edmonton</text>
                                
                                <circle cx="200" cy="180" r="4" fill="#3B256E"/>
                                <text x="200" y="170" text-anchor="middle" class="small">Vancouver</text>
                                
                                <circle cx="550" cy="180" r="4" fill="#3B256E"/>
                                <text x="550" y="170" text-anchor="middle" class="small">Toronto</text>
                                
                                <!-- Developer credit -->
                                <text x="400" y="580" text-anchor="middle" class="small" fill="#6c757d">Developed by PanesarElite</text>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <button onclick="goToNewDispatch()" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-plus me-2"></i>New Dispatch
                                    </button>
                                </div>
                                <div class="col-6 mb-3">
                                    <button onclick="goToAssign()" class="btn btn-info w-100">
                                        <i class="fa-solid fa-user-check me-2"></i>Assign
                                    </button>
                                </div>
                                <div class="col-6 mb-3">
                                    <button onclick="goToTracking()" class="btn btn-warning w-100">
                                        <i class="fa-solid fa-truck-fast me-2"></i>Track
                                    </button>
                                </div>
                                <div class="col-6 mb-3">
                                    <button onclick="goToDispatchList()" class="btn btn-success w-100">
                                        <i class="fa-solid fa-table me-2"></i>View All
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Debug Actions -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <hr>
                                    <h6 class="text-muted">Debug Actions:</h6>
                                    <button onclick="testFirebaseConnection()" class="btn btn-outline-secondary btn-sm me-2">
                                        Test Firebase
                                    </button>
                                    <button onclick="seedSampleData()" class="btn btn-outline-primary btn-sm">
                                        Seed Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include 'customer-php/footer.php'; ?>

<script type="module">
import { loadDashboardData, applyDashboardFilters, clearDashboardFilters, showToast } from '/site/final/captain/assets/js/ui.js';
import { getCurrentDateEdmonton } from '/site/final/captain/assets/js/utils-timezone.js';
import { buildUrl } from '/site/final/captain/assets/js/config.js';
import { getCurrentUser, requireAuth, isAuthInitialized } from '/site/final/captain/assets/js/auth.js';
import { seedSampleData } from '/site/final/captain/assets/js/seed.js';

console.log('📊 Dashboard page loaded - PanesarElite');

document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Dashboard DOM loaded');
    
    // Show auth status
    const authStatusEl = document.getElementById('authStatus');
    const authStatusText = document.getElementById('authStatusText');
    
    if (authStatusEl) {
        authStatusEl.style.display = 'block';
    }
    
    // Check authentication with timeout
    let authCheckCount = 0;
    const maxAuthChecks = 50; // 5 seconds
    
    const checkAuth = setInterval(() => {
        authCheckCount++;
        
        if (authStatusText) {
            authStatusText.textContent = `Checking authentication... (${authCheckCount}/${maxAuthChecks})`;
        }
        
        if (isAuthInitialized()) {
            const user = getCurrentUser();
            
            if (user) {
                console.log('✅ User authenticated, loading dashboard');
                clearInterval(checkAuth);
                
                if (authStatusEl) {
                    authStatusEl.style.display = 'none';
                }
                
                // Set default date to today
                const dateFilter = document.getElementById('dateFilter');
                if (dateFilter) {
                    dateFilter.value = getCurrentDateEdmonton();
                }
                
                // Load dashboard data
                loadDashboardData();
                
            } else {
                console.log('❌ No authenticated user, redirecting to login');
                clearInterval(checkAuth);
                
                if (authStatusText) {
                    authStatusText.textContent = 'Not authenticated, redirecting...';
                }
                
                setTimeout(() => {
                    window.location.href = buildUrl('/auth/login.php');
                }, 1000);
            }
        } else if (authCheckCount >= maxAuthChecks) {
            console.error('❌ Authentication check timeout');
            clearInterval(checkAuth);
            
            if (authStatusText) {
                authStatusText.textContent = 'Authentication timeout - please refresh';
            }
            
            showToast('Authentication timeout. Please refresh the page.', 'error');
            alert('Authentication timeout. Please refresh the page.');
        }
    }, 100);
});

// Test Firebase connection
window.testFirebaseConnection = async function() {
    console.log('🧪 Testing Firebase connection');
    
    try {
        if (!window.firebaseAuth || !window.firebaseDb) {
            throw new Error('Firebase not initialized');
        }
        
        const user = getCurrentUser();
        if (!user) {
            throw new Error('No authenticated user');
        }
        
        // Test Firestore read
        const { getCompanyDoc } = await import('/site/final/captain/assets/js/dao.js');
        const companyDoc = await getCompanyDoc();
        
        console.log('✅ Firebase connection test passed');
        showToast('Firebase connection successful!', 'success');
        
        alert(`Firebase Test Results:
✅ Firebase App: ${window.firebaseApp ? 'Connected' : 'Failed'}
✅ Authentication: ${window.firebaseAuth ? 'Connected' : 'Failed'}  
✅ Firestore: ${window.firebaseDb ? 'Connected' : 'Failed'}
✅ User: ${user.email}
✅ Company Doc: ${companyDoc.exists() ? 'Found' : 'Not found'}`);
        
    } catch (error) {
        console.error('❌ Firebase connection test failed:', error);
        showToast('Firebase connection failed: ' + error.message, 'error');
        
        alert(`Firebase Test Failed:
❌ Error: ${error.message}
🔍 Check console for details`);
    }
};

// Seed sample data
window.seedSampleData = async function() {
    console.log('🌱 Seeding sample data');
    
    if (!requireAuth()) {
        return;
    }
    
    try {
        await seedSampleData();
    } catch (error) {
        console.error('❌ Error seeding data:', error);
        showToast('Error seeding data: ' + error.message, 'error');
    }
};
</script>