<?php
$pageTitle = "New Dispatch - Captain Dispatch";
$currentPage = "new-dispatch";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2" id="pageTitle">New Dispatch</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dispatch Information</h6>
                </div>
                <div class="card-body">
                    <form id="dispatchForm">
                        <div class="row">
                            <!-- Date and Time -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateStart" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control" id="dateStart" name="dateStart" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timeStart" class="form-label">Start Time *</label>
                                    <input type="time" class="form-control" id="timeStart" name="timeStart" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="multiDay" name="multiDay">
                                    <label class="form-check-label" for="multiDay">
                                        Multi-day dispatch
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="endDateTimeRow" style="display: none;">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateEnd" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="dateEnd" name="dateEnd">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timeEnd" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="timeEnd" name="timeEnd">
                                </div>
                            </div>
                        </div>

                        <!-- Locations -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startLocation" class="form-label">Start Location *</label>
                                    <input type="text" class="form-control" id="startLocation" name="startLocation" 
                                           placeholder="Enter pickup address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="destinationAddress" class="form-label">Destination Address</label>
                                    <input type="text" class="form-control" id="destinationAddress" name="destinationAddress" 
                                           placeholder="Enter delivery address">
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contactPerson" class="form-label">Contact Person *</label>
                                    <input type="text" class="form-control" id="contactPerson" name="contactPerson" 
                                           placeholder="Contact name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contactPhone" class="form-label">Contact Phone</label>
                                    <input type="tel" class="form-control" id="contactPhone" name="contactPhone" 
                                           placeholder="+1 (555) 123-4567">
                                </div>
                            </div>
                        </div>

                        <!-- Task Details -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="taskType" class="form-label">Task Type *</label>
                                    <select class="form-select" id="taskType" name="taskType" required>
                                        <option value="">Select task type</option>
                                        <option value="City">City</option>
                                        <option value="Highway">Highway</option>
                                        <option value="Moves">Moves</option>
                                        <option value="Highway + City">Highway + City</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="reeferRequired" class="form-label">Reefer Required</label>
                                    <select class="form-select" id="reeferRequired" name="reeferRequired">
                                        <option value="false">No</option>
                                        <option value="true">Yes</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dangerousGoods" class="form-label">Dangerous Goods *</label>
                                    <select class="form-select" id="dangerousGoods" name="dangerousGoods" required>
                                        <option value="No">No</option>
                                        <option value="Class 1 - Explosives">Class 1 - Explosives</option>
                                        <option value="Class 2 - Gases">Class 2 - Gases</option>
                                        <option value="Class 3 - Flammable Liquids">Class 3 - Flammable Liquids</option>
                                        <option value="Class 4 - Flammable Solids">Class 4 - Flammable Solids</option>
                                        <option value="Class 5 - Oxidizing Substances">Class 5 - Oxidizing Substances</option>
                                        <option value="Class 6 - Toxic Substances">Class 6 - Toxic Substances</option>
                                        <option value="Class 7 - Radioactive">Class 7 - Radioactive</option>
                                        <option value="Class 8 - Corrosives">Class 8 - Corrosives</option>
                                        <option value="Class 9 - Miscellaneous">Class 9 - Miscellaneous</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="specialInstructions" class="form-label">Special Instructions</label>
                                    <textarea class="form-control" id="specialInstructions" name="specialInstructions" 
                                              rows="3" placeholder="Any special handling instructions..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save me-2"></i>Save Dispatch
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="resetForm()">
                                    <i class="fa-solid fa-refresh me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { createDispatch, updateDispatch, getDispatch } from '/assets/js/dao.js';
import { validateDispatchForm, displayValidationErrors, clearValidationErrors } from '/assets/js/validators.js';
import { getCurrentDateEdmonton, getCurrentTimeEdmonton } from '/assets/js/utils-timezone.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';

let isEditMode = false;
let editDispatchData = null;

document.addEventListener('DOMContentLoaded', function() {
    // Set default date and time
    document.getElementById('dateStart').value = getCurrentDateEdmonton();
    document.getElementById('timeStart').value = getCurrentTimeEdmonton();
    
    // Check if we're in edit mode
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');
    const year = urlParams.get('year');
    const month = urlParams.get('month');
    const day = urlParams.get('day');
    
    if (editId && year && month && day) {
        isEditMode = true;
        loadDispatchForEdit(year, month, day, editId);
    }
    
    // Multi-day checkbox handler
    document.getElementById('multiDay').addEventListener('change', function() {
        const endDateTimeRow = document.getElementById('endDateTimeRow');
        if (this.checked) {
            endDateTimeRow.style.display = 'block';
        } else {
            endDateTimeRow.style.display = 'none';
            document.getElementById('dateEnd').value = '';
            document.getElementById('timeEnd').value = '';
        }
    });
    
    // Form submission
    document.getElementById('dispatchForm').addEventListener('submit', handleFormSubmit);
});

async function loadDispatchForEdit(year, month, day, dispatchId) {
    try {
        showLoading('Loading dispatch data...');
        
        editDispatchData = await getDispatch(year, month, day, dispatchId);
        
        if (editDispatchData) {
            // Update page title
            document.getElementById('pageTitle').textContent = 'Edit Dispatch';
            
            // Populate form fields
            Object.keys(editDispatchData).forEach(key => {
                const field = document.getElementById(key);
                if (field) {
                    if (field.type === 'checkbox') {
                        field.checked = editDispatchData[key];
                    } else {
                        field.value = editDispatchData[key] || '';
                    }
                }
            });
            
            // Handle multi-day checkbox
            if (editDispatchData.dateEnd) {
                document.getElementById('multiDay').checked = true;
                document.getElementById('endDateTimeRow').style.display = 'block';
            }
        }
        
        hideLoading();
    } catch (error) {
        console.error('Error loading dispatch:', error);
        hideLoading();
        showToast('Error loading dispatch data', 'error');
    }
}

async function handleFormSubmit(event) {
    event.preventDefault();
    
    try {
        clearValidationErrors();
        
        const formData = new FormData(event.target);
        const dispatchData = Object.fromEntries(formData.entries());
        
        // Convert checkbox values
        dispatchData.multiDay = document.getElementById('multiDay').checked;
        dispatchData.reeferRequired = dispatchData.reeferRequired === 'true';
        
        // Validate form
        const validation = validateDispatchForm(dispatchData);
        if (!validation.isValid) {
            displayValidationErrors(validation.errors);
            showToast('Please fix the validation errors', 'error');
            return;
        }
        
        showLoading(isEditMode ? 'Updating dispatch...' : 'Creating dispatch...');
        
        if (isEditMode && editDispatchData) {
            // Update existing dispatch
            await updateDispatch(
                editDispatchData.year, 
                editDispatchData.month, 
                editDispatchData.day, 
                editDispatchData.id, 
                dispatchData
            );
            showToast('Dispatch updated successfully!', 'success');
        } else {
            // Create new dispatch
            const dispatchId = await createDispatch(dispatchData);
            showToast('Dispatch created successfully!', 'success');
        }
        
        hideLoading();
        
        // Redirect to dispatch list
        setTimeout(() => {
            window.location.href = '/dispatch/dispatch-list.php';
        }, 1000);
        
    } catch (error) {
        console.error('Error saving dispatch:', error);
        hideLoading();
        showToast('Error saving dispatch: ' + error.message, 'error');
    }
}

window.resetForm = function() {
    document.getElementById('dispatchForm').reset();
    document.getElementById('dateStart').value = getCurrentDateEdmonton();
    document.getElementById('timeStart').value = getCurrentTimeEdmonton();
    document.getElementById('endDateTimeRow').style.display = 'none';
    clearValidationErrors();
};
</script>