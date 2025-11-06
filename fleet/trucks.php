<?php
$pageTitle = "Truck Management - Captain Dispatch";
$currentPage = "trucks";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Truck Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTruckModal">
                        <i class="fa-solid fa-plus"></i> Add Truck
                    </button>
                </div>
            </div>

            <!-- Trucks Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fleet Vehicles</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="trucksTable">
                            <thead>
                                <tr>
                                    <th>Unit No</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>VIN</th>
                                    <th>Plate</th>
                                    <th>Reefer</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="trucksTableBody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Truck Modal -->
<div class="modal fade" id="addTruckModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Truck</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTruckForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="unitNo" class="form-label">Unit Number *</label>
                                <input type="text" class="form-control" id="unitNo" name="unitNo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="plateNumber" class="form-label">Plate Number *</label>
                                <input type="text" class="form-control" id="plateNumber" name="plateNumber" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="make" class="form-label">Make *</label>
                                <input type="text" class="form-control" id="make" name="make" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="model" class="form-label">Model *</label>
                                <input type="text" class="form-control" id="model" name="model" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="year" class="form-label">Year *</label>
                                <input type="number" class="form-control" id="year" name="year" min="1990" max="2030" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="vin" class="form-label">VIN *</label>
                        <input type="text" class="form-control" id="vin" name="vin" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="reeferCapable" name="reeferCapable">
                            <label class="form-check-label" for="reeferCapable">
                                Reefer Capable
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createTruck()">Add Truck</button>
            </div>
        </div>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
// Truck Management - Developed by PanesarElite
import { listTrucks } from '/assets/js/dao.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';
import { getCurrentCompanyRID } from '/assets/js/auth.js';
import { doc, setDoc, serverTimestamp } from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js';

let currentTrucks = [];

document.addEventListener('DOMContentLoaded', function() {
    loadTrucks();
});

async function loadTrucks() {
    try {
        showLoading('Loading trucks...');
        
        currentTrucks = await listTrucks();
        updateTrucksTable();
        
        hideLoading();
    } catch (error) {
        console.error('Error loading trucks:', error);
        showToast('Error loading trucks', 'error');
        hideLoading();
    }
}

function updateTrucksTable() {
    const tbody = document.getElementById('trucksTableBody');
    if (!tbody) return;
    
    if (currentTrucks.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center text-muted">
                    <i class="fa-solid fa-truck fa-2x mb-2"></i>
                    <br>No trucks found
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = currentTrucks.map(truck => `
        <tr>
            <td><strong>${truck.unitNo}</strong></td>
            <td>${truck.make}</td>
            <td>${truck.model}</td>
            <td>${truck.year}</td>
            <td><code>${truck.vin}</code></td>
            <td>${truck.plateNumber}</td>
            <td>
                <span class="badge bg-${truck.reeferCapable ? 'info' : 'secondary'}">
                    ${truck.reeferCapable ? 'Yes' : 'No'}
                </span>
            </td>
            <td>
                <span class="badge bg-${truck.active ? 'success' : 'secondary'}">
                    ${truck.active ? 'Active' : 'Inactive'}
                </span>
            </td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-sm" onclick="editTruck('${truck.id}')" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-${truck.active ? 'warning' : 'success'} btn-sm" 
                            onclick="toggleTruckStatus('${truck.id}', ${truck.active})" 
                            title="${truck.active ? 'Deactivate' : 'Activate'}">
                        <i class="fa-solid fa-${truck.active ? 'ban' : 'check'}"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

window.createTruck = async function() {
    try {
        const form = document.getElementById('addTruckForm');
        const formData = new FormData(form);
        
        const truckData = {
            unitNo: formData.get('unitNo'),
            make: formData.get('make'),
            model: formData.get('model'),
            year: parseInt(formData.get('year')),
            vin: formData.get('vin'),
            plateNumber: formData.get('plateNumber'),
            reeferCapable: document.getElementById('reeferCapable').checked,
            active: true,
            createdAt: serverTimestamp()
        };
        
        showLoading('Creating truck...');
        
        const companyRID = getCurrentCompanyRID();
        const truckId = 'truck_' + Date.now();
        const truckRef = doc(window.firebaseDb, `companies/${companyRID}/trucks`, truckId);
        
        await setDoc(truckRef, truckData);
        
        hideLoading();
        showToast('Truck created successfully!', 'success');
        
        // Close modal and refresh
        const modal = bootstrap.Modal.getInstance(document.getElementById('addTruckModal'));
        modal.hide();
        form.reset();
        
        await loadTrucks();
        
    } catch (error) {
        console.error('Error creating truck:', error);
        hideLoading();
        showToast('Error creating truck: ' + error.message, 'error');
    }
};

window.editTruck = function(truckId) {
    showToast('Truck editing functionality coming soon!', 'info');
};

window.toggleTruckStatus = function(truckId, currentStatus) {
    showToast('Truck status toggle functionality coming soon!', 'info');
};
</script>