<?php
$pageTitle = "Assign Dispatch - Captain Dispatch";
$currentPage = "dispatch-assign";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Assign Dispatch</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>

            <!-- Dispatch Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dispatch Details</h6>
                </div>
                <div class="card-body" id="dispatchDetails">
                    <!-- Populated by JS -->
                </div>
            </div>

            <!-- Assignment Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assignment</h6>
                </div>
                <div class="card-body">
                    <form id="assignmentForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="driverId" class="form-label">Select Driver *</label>
                                    <select class="form-select" id="driverId" name="driverId" required>
                                        <option value="">Choose a driver...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="truckId" class="form-label">Select Truck *</label>
                                    <select class="form-select" id="truckId" name="truckId" required>
                                        <option value="">Choose a truck...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="assignmentNotes" class="form-label">Assignment Notes</label>
                                    <textarea class="form-control" id="assignmentNotes" name="assignmentNotes" 
                                              rows="3" placeholder="Any special instructions for the driver..."></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-user-check me-2"></i>Assign Dispatch
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="window.history.back()">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Available Resources -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Available Drivers</h6>
                        </div>
                        <div class="card-body">
                            <div id="driversList">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Available Trucks</h6>
                        </div>
                        <div class="card-body">
                            <div id="trucksList">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { getDispatch, assignDriverTruck, listDrivers, listTrucks } from '/assets/js/dao.js';
import { renderStatusBadge, showToast, showLoading, hideLoading } from '/assets/js/ui.js';

let currentDispatch = null;
let availableDrivers = [];
let availableTrucks = [];

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const dispatchId = urlParams.get('id');
    const year = urlParams.get('year');
    const month = urlParams.get('month');
    const day = urlParams.get('day');
    
    if (!dispatchId || !year || !month || !day) {
        showToast('Invalid dispatch parameters', 'error');
        window.history.back();
        return;
    }
    
    loadDispatchData(year, month, day, dispatchId);
    loadDriversAndTrucks();
    
    // Form submission
    document.getElementById('assignmentForm').addEventListener('submit', handleAssignment);
});

async function loadDispatchData(year, month, day, dispatchId) {
    try {
        showLoading('Loading dispatch...');
        
        currentDispatch = await getDispatch(year, month, day, dispatchId);
        
        if (!currentDispatch) {
            showToast('Dispatch not found', 'error');
            window.history.back();
            return;
        }
        
        displayDispatchDetails();
        hideLoading();
        
    } catch (error) {
        console.error('Error loading dispatch:', error);
        showToast('Error loading dispatch', 'error');
        hideLoading();
    }
}

function displayDispatchDetails() {
    const detailsContainer = document.getElementById('dispatchDetails');
    
    detailsContainer.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> <code>${currentDispatch.id}</code></p>
                <p><strong>Date:</strong> ${currentDispatch.dateStart}</p>
                <p><strong>Time:</strong> ${currentDispatch.timeStart || 'Not specified'}</p>
                <p><strong>Task Type:</strong> ${currentDispatch.taskType}</p>
                <p><strong>Status:</strong> ${renderStatusBadge(currentDispatch.status)}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Start Location:</strong> ${currentDispatch.startLocation}</p>
                <p><strong>Destination:</strong> ${currentDispatch.destinationAddress || 'Not specified'}</p>
                <p><strong>Contact:</strong> ${currentDispatch.contactPerson}</p>
                <p><strong>Phone:</strong> ${currentDispatch.contactPhone || 'Not specified'}</p>
                <p><strong>Reefer Required:</strong> ${currentDispatch.reeferRequired ? 'Yes' : 'No'}</p>
            </div>
        </div>
        ${currentDispatch.specialInstructions ? `
            <div class="row">
                <div class="col-md-12">
                    <p><strong>Special Instructions:</strong></p>
                    <div class="alert alert-info">${currentDispatch.specialInstructions}</div>
                </div>
            </div>
        ` : ''}
    `;
}

async function loadDriversAndTrucks() {
    try {
        const [drivers, trucks] = await Promise.all([
            listDrivers(),
            listTrucks()
        ]);
        
        availableDrivers = drivers;
        availableTrucks = trucks;
        
        populateDriverSelect();
        populateTruckSelect();
        displayDriversList();
        displayTrucksList();
        
    } catch (error) {
        console.error('Error loading resources:', error);
        showToast('Error loading drivers and trucks', 'error');
    }
}

function populateDriverSelect() {
    const driverSelect = document.getElementById('driverId');
    
    availableDrivers.forEach(driver => {
        const option = document.createElement('option');
        option.value = driver.id;
        option.textContent = `${driver.displayName} (${driver.licenseClass})`;
        driverSelect.appendChild(option);
    });
}

function populateTruckSelect() {
    const truckSelect = document.getElementById('truckId');
    
    // Filter trucks based on reefer requirement
    const suitableTrucks = currentDispatch?.reeferRequired ? 
        availableTrucks.filter(truck => truck.reeferCapable) : 
        availableTrucks;
    
    suitableTrucks.forEach(truck => {
        const option = document.createElement('option');
        option.value = truck.id;
        option.textContent = `${truck.unitNo} - ${truck.make} ${truck.model} (${truck.year})`;
        truckSelect.appendChild(option);
    });
    
    if (currentDispatch?.reeferRequired && suitableTrucks.length === 0) {
        truckSelect.innerHTML = '<option value="">No reefer-capable trucks available</option>';
    }
}

function displayDriversList() {
    const driversList = document.getElementById('driversList');
    
    if (availableDrivers.length === 0) {
        driversList.innerHTML = '<p class="text-muted">No drivers available</p>';
        return;
    }
    
    driversList.innerHTML = availableDrivers.map(driver => `
        <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
            <div>
                <strong>${driver.displayName}</strong><br>
                <small class="text-muted">${driver.licenseClass} | ${driver.phone}</small>
            </div>
            <button class="btn btn-sm btn-outline-primary" onclick="selectDriver('${driver.id}')">
                Select
            </button>
        </div>
    `).join('');
}

function displayTrucksList() {
    const trucksList = document.getElementById('trucksList');
    
    const suitableTrucks = currentDispatch?.reeferRequired ? 
        availableTrucks.filter(truck => truck.reeferCapable) : 
        availableTrucks;
    
    if (suitableTrucks.length === 0) {
        trucksList.innerHTML = '<p class="text-muted">No suitable trucks available</p>';
        return;
    }
    
    trucksList.innerHTML = suitableTrucks.map(truck => `
        <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
            <div>
                <strong>${truck.unitNo}</strong><br>
                <small class="text-muted">${truck.make} ${truck.model} (${truck.year})${truck.reeferCapable ? ' - Reefer' : ''}</small>
            </div>
            <button class="btn btn-sm btn-outline-primary" onclick="selectTruck('${truck.id}')">
                Select
            </button>
        </div>
    `).join('');
}

async function handleAssignment(event) {
    event.preventDefault();
    
    try {
        const formData = new FormData(event.target);
        const driverId = formData.get('driverId');
        const truckId = formData.get('truckId');
        const notes = formData.get('assignmentNotes');
        
        if (!driverId || !truckId) {
            showToast('Please select both driver and truck', 'error');
            return;
        }
        
        showLoading('Assigning dispatch...');
        
        await assignDriverTruck(
            currentDispatch.year,
            currentDispatch.month,
            currentDispatch.day,
            currentDispatch.id,
            driverId,
            truckId
        );
        
        // Add assignment note if provided
        if (notes) {
            const { appendNote } = await import('/assets/js/dao.js');
            await appendNote(
                currentDispatch.year,
                currentDispatch.month,
                currentDispatch.day,
                currentDispatch.id,
                `Assignment Notes: ${notes}`
            );
        }
        
        hideLoading();
        showToast('Dispatch assigned successfully!', 'success');
        
        // Redirect to tracking page
        setTimeout(() => {
            window.location.href = `/dispatch/dispatch-tracking.php?id=${currentDispatch.id}&year=${currentDispatch.year}&month=${currentDispatch.month}&day=${currentDispatch.day}`;
        }, 1000);
        
    } catch (error) {
        console.error('Error assigning dispatch:', error);
        hideLoading();
        showToast('Error assigning dispatch: ' + error.message, 'error');
    }
}

// Global functions
window.selectDriver = function(driverId) {
    document.getElementById('driverId').value = driverId;
};

window.selectTruck = function(truckId) {
    document.getElementById('truckId').value = truckId;
};
</script>