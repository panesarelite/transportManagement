<?php
$pageTitle = "Driver Management - Captain Dispatch";
$currentPage = "drivers";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Driver Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDriverModal">
                        <i class="fa-solid fa-plus"></i> Add Driver
                    </button>
                </div>
            </div>

            <!-- Drivers Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Company Drivers</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="driversTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>License Number</th>
                                    <th>License Class</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="driversTableBody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Driver Modal -->
<div class="modal fade" id="addDriverModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDriverForm">
                    <div class="mb-3">
                        <label for="displayName" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="displayName" name="displayName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="licenseNumber" class="form-label">License Number *</label>
                        <input type="text" class="form-control" id="licenseNumber" name="licenseNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="licenseClass" class="form-label">License Class *</label>
                        <select class="form-select" id="licenseClass" name="licenseClass" required>
                            <option value="">Select class...</option>
                            <option value="Class 1">Class 1</option>
                            <option value="Class 2">Class 2</option>
                            <option value="Class 3">Class 3</option>
                            <option value="Class 4">Class 4</option>
                            <option value="Class 5">Class 5</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createDriver()">Add Driver</button>
            </div>
        </div>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
// Driver Management - Developed by PanesarElite
import { listDrivers } from '/assets/js/dao.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';
import { getCurrentCompanyRID } from '/assets/js/auth.js';
import { doc, setDoc, serverTimestamp } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js';

let currentDrivers = [];

document.addEventListener('DOMContentLoaded', function() {
    loadDrivers();
});

async function loadDrivers() {
    try {
        showLoading('Loading drivers...');
        
        currentDrivers = await listDrivers();
        updateDriversTable();
        
        hideLoading();
    } catch (error) {
        console.error('Error loading drivers:', error);
        showToast('Error loading drivers', 'error');
        hideLoading();
    }
}

function updateDriversTable() {
    const tbody = document.getElementById('driversTableBody');
    if (!tbody) return;
    
    if (currentDrivers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted">
                    <i class="fa-solid fa-user-tie fa-2x mb-2"></i>
                    <br>No drivers found
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = currentDrivers.map(driver => `
        <tr>
            <td>${driver.displayName}</td>
            <td>${driver.email}</td>
            <td>${driver.phone}</td>
            <td>${driver.licenseNumber}</td>
            <td>${driver.licenseClass}</td>
            <td>
                <span class="badge bg-${driver.active ? 'success' : 'secondary'}">
                    ${driver.active ? 'Active' : 'Inactive'}
                </span>
            </td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-sm" onclick="editDriver('${driver.id}')" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-${driver.active ? 'warning' : 'success'} btn-sm" 
                            onclick="toggleDriverStatus('${driver.id}', ${driver.active})" 
                            title="${driver.active ? 'Deactivate' : 'Activate'}">
                        <i class="fa-solid fa-${driver.active ? 'ban' : 'check'}"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

window.createDriver = async function() {
    try {
        const form = document.getElementById('addDriverForm');
        const formData = new FormData(form);
        
        const driverData = {
            displayName: formData.get('displayName'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            licenseNumber: formData.get('licenseNumber'),
            licenseClass: formData.get('licenseClass'),
            active: true,
            createdAt: serverTimestamp()
        };
        
        showLoading('Creating driver...');
        
        const companyRID = getCurrentCompanyRID();
        const driverId = 'driver_' + Date.now();
        const driverRef = doc(window.firebaseDb, `companies/${companyRID}/drivers`, driverId);
        
        await setDoc(driverRef, driverData);
        
        hideLoading();
        showToast('Driver created successfully!', 'success');
        
        // Close modal and refresh
        const modal = bootstrap.Modal.getInstance(document.getElementById('addDriverModal'));
        modal.hide();
        form.reset();
        
        await loadDrivers();
        
    } catch (error) {
        console.error('Error creating driver:', error);
        hideLoading();
        showToast('Error creating driver: ' + error.message, 'error');
    }
};

window.editDriver = function(driverId) {
    showToast('Driver editing functionality coming soon!', 'info');
};

window.toggleDriverStatus = function(driverId, currentStatus) {
    showToast('Driver status toggle functionality coming soon!', 'info');
};
</script>