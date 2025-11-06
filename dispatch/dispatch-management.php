<?php
$pageTitle = "Dispatch Management - Captain Dispatch";
$currentPage = "dispatch-management";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dispatch Management</h1>
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

            <!-- Status Management -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Management</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="newStatus" class="form-label">Change Status</label>
                                <select class="form-select" id="newStatus">
                                    <option value="">Select new status...</option>
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
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="statusNote" class="form-label">Status Note</label>
                                <input type="text" class="form-control" id="statusNote" 
                                       placeholder="Optional note about status change">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning" onclick="updateStatus()">
                        <i class="fa-solid fa-edit me-2"></i>Update Status
                    </button>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notes & Communication</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="newNote" class="form-label">Add Note</label>
                        <textarea class="form-control" id="newNote" rows="3" 
                                  placeholder="Enter note or communication..."></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addNote()">
                        <i class="fa-solid fa-plus me-2"></i>Add Note
                    </button>
                    
                    <hr>
                    
                    <div id="notesList">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info w-100 mb-2" onclick="reassignDispatch()">
                                <i class="fa-solid fa-user-check me-2"></i>Reassign
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-warning w-100 mb-2" onclick="trackDispatch()">
                                <i class="fa-solid fa-map-location-dot me-2"></i>Track
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success w-100 mb-2" onclick="editDispatch()">
                                <i class="fa-solid fa-edit me-2"></i>Edit Details
                            </button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="duplicateDispatch()">
                                <i class="fa-solid fa-copy me-2"></i>Duplicate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { getDispatch, changeStatus, appendNote } from '/assets/js/dao.js';
import { renderStatusBadge, showToast, showLoading, hideLoading } from '/assets/js/ui.js';

let currentDispatch = null;

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
        displayNotes();
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
                <p><strong>Dangerous Goods:</strong> ${currentDispatch.dangerousGoods}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Start Location:</strong> ${currentDispatch.startLocation}</p>
                <p><strong>Destination:</strong> ${currentDispatch.destinationAddress || 'Not specified'}</p>
                <p><strong>Contact:</strong> ${currentDispatch.contactPerson}</p>
                <p><strong>Phone:</strong> ${currentDispatch.contactPhone || 'Not specified'}</p>
                <p><strong>Reefer Required:</strong> ${currentDispatch.reeferRequired ? 'Yes' : 'No'}</p>
                <p><strong>Driver:</strong> ${currentDispatch.driverId ? 'Assigned' : 'Unassigned'}</p>
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

function displayNotes() {
    const notesList = document.getElementById('notesList');
    
    if (!currentDispatch.notes || currentDispatch.notes.length === 0) {
        notesList.innerHTML = '<p class="text-muted">No notes yet</p>';
        return;
    }
    
    notesList.innerHTML = currentDispatch.notes.map(note => `
        <div class="border-bottom pb-2 mb-2">
            <div class="d-flex justify-content-between">
                <small class="text-muted">
                    <strong>${note.byRole}</strong> - ${formatTimestamp(note.ts)}
                </small>
            </div>
            <p class="mb-0">${note.text}</p>
        </div>
    `).join('');
}

function formatTimestamp(timestamp) {
    if (!timestamp) return 'Unknown time';
    
    try {
        // Handle Firestore timestamp
        const date = timestamp.toDate ? timestamp.toDate() : new Date(timestamp);
        return date.toLocaleString('en-CA', {
            timeZone: 'America/Edmonton',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        return 'Invalid timestamp';
    }
}

// Global functions
window.updateStatus = async function() {
    const newStatus = document.getElementById('newStatus').value;
    const statusNote = document.getElementById('statusNote').value;
    
    if (!newStatus) {
        showToast('Please select a status', 'error');
        return;
    }
    
    try {
        showLoading('Updating status...');
        
        await changeStatus(
            currentDispatch.year,
            currentDispatch.month,
            currentDispatch.day,
            currentDispatch.id,
            newStatus,
            statusNote || `Status changed to ${newStatus}`
        );
        
        hideLoading();
        showToast('Status updated successfully!', 'success');
        
        // Reload dispatch data
        await loadDispatchData(currentDispatch.year, currentDispatch.month, currentDispatch.day, currentDispatch.id);
        
        // Clear form
        document.getElementById('newStatus').value = '';
        document.getElementById('statusNote').value = '';
        
    } catch (error) {
        console.error('Error updating status:', error);
        hideLoading();
        showToast('Error updating status: ' + error.message, 'error');
    }
};

window.addNote = async function() {
    const noteText = document.getElementById('newNote').value.trim();
    
    if (!noteText) {
        showToast('Please enter a note', 'error');
        return;
    }
    
    try {
        showLoading('Adding note...');
        
        await appendNote(
            currentDispatch.year,
            currentDispatch.month,
            currentDispatch.day,
            currentDispatch.id,
            noteText
        );
        
        hideLoading();
        showToast('Note added successfully!', 'success');
        
        // Reload dispatch data
        await loadDispatchData(currentDispatch.year, currentDispatch.month, currentDispatch.day, currentDispatch.id);
        
        // Clear form
        document.getElementById('newNote').value = '';
        
    } catch (error) {
        console.error('Error adding note:', error);
        hideLoading();
        showToast('Error adding note: ' + error.message, 'error');
    }
};

window.reassignDispatch = function() {
    window.location.href = `/dispatch/dispatch-assign.php?id=${currentDispatch.id}&year=${currentDispatch.year}&month=${currentDispatch.month}&day=${currentDispatch.day}`;
};

window.trackDispatch = function() {
    window.location.href = `/dispatch/dispatch-tracking.php?id=${currentDispatch.id}&year=${currentDispatch.year}&month=${currentDispatch.month}&day=${currentDispatch.day}`;
};

window.editDispatch = function() {
    window.location.href = `/dispatch/new-dispatch.php?edit=${currentDispatch.id}&year=${currentDispatch.year}&month=${currentDispatch.month}&day=${currentDispatch.day}`;
};

window.duplicateDispatch = function() {
    // Create URL with dispatch data as query params for pre-filling
    const params = new URLSearchParams({
        duplicate: 'true',
        startLocation: currentDispatch.startLocation,
        destinationAddress: currentDispatch.destinationAddress || '',
        contactPerson: currentDispatch.contactPerson,
        contactPhone: currentDispatch.contactPhone || '',
        taskType: currentDispatch.taskType,
        reeferRequired: currentDispatch.reeferRequired,
        dangerousGoods: currentDispatch.dangerousGoods,
        specialInstructions: currentDispatch.specialInstructions || ''
    });
    
    window.location.href = `/dispatch/new-dispatch.php?${params.toString()}`;
};
</script>