<?php
$pageTitle = "Dispatch List - Captain Dispatch";
$currentPage = "dispatch-list";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dispatch List</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="exportToCSV()">
                            <i class="fa-solid fa-download"></i> Export CSV
                        </button>
                    </div>
                    <a href="/dispatch/new-dispatch.php" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> New Dispatch
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
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
                        <div class="col-md-2">
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
                        <div class="col-md-2">
                            <label for="searchTerm" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchTerm" placeholder="Search..." />
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

            <!-- Dispatches Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dispatches</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dispatchTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Start Location</th>
                                    <th>Destination</th>
                                    <th>Contact</th>
                                    <th>Task Type</th>
                                    <th>Reefer</th>
                                    <th>Status</th>
                                    <th>Driver</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="dispatchTableBody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <nav aria-label="Dispatch pagination">
                        <ul class="pagination justify-content-center" id="pagination">
                            <!-- Populated by JS -->
                        </ul>
                    </nav>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { listDispatches } from '/assets/js/dao.js';
import { renderStatusBadge, showToast, showLoading, hideLoading } from '/assets/js/ui.js';
import { getCurrentDateEdmonton } from '/assets/js/utils-timezone.js';

let currentDispatches = [];
let currentPage = 1;
const itemsPerPage = 20;

document.addEventListener('DOMContentLoaded', function() {
    // Set default date range to last 7 days
    const today = getCurrentDateEdmonton();
    const weekAgo = new Date();
    weekAgo.setDate(weekAgo.getDate() - 7);
    const weekAgoStr = weekAgo.toISOString().split('T')[0];
    
    document.getElementById('dateFrom').value = weekAgoStr;
    document.getElementById('dateTo').value = today;
    
    // Load initial data
    loadDispatches();
});

async function loadDispatches() {
    try {
        showLoading('Loading dispatches...');
        
        const filters = getFilters();
        const dispatches = await listDispatches(filters);
        
        currentDispatches = dispatches;
        updateTable();
        updatePagination();
        
        hideLoading();
    } catch (error) {
        console.error('Error loading dispatches:', error);
        showToast('Error loading dispatches', 'error');
        hideLoading();
    }
}

function getFilters() {
    const statusFilter = document.getElementById('statusFilter');
    const selectedStatuses = Array.from(statusFilter.selectedOptions).map(option => option.value);
    
    return {
        dateFrom: document.getElementById('dateFrom').value,
        dateTo: document.getElementById('dateTo').value,
        status: selectedStatuses.length > 0 ? selectedStatuses : undefined,
        taskType: document.getElementById('taskTypeFilter').value || undefined,
        reeferRequired: document.getElementById('reeferFilter').value ? 
                       document.getElementById('reeferFilter').value === 'true' : undefined,
        searchTerm: document.getElementById('searchTerm').value || undefined
    };
}

function updateTable() {
    const tbody = document.getElementById('dispatchTableBody');
    if (!tbody) return;
    
    // Apply search filter
    let filteredDispatches = currentDispatches;
    const searchTerm = document.getElementById('searchTerm').value?.toLowerCase();
    
    if (searchTerm) {
        filteredDispatches = currentDispatches.filter(dispatch => 
            dispatch.id.toLowerCase().includes(searchTerm) ||
            dispatch.startLocation?.toLowerCase().includes(searchTerm) ||
            dispatch.destinationAddress?.toLowerCase().includes(searchTerm) ||
            dispatch.contactPerson?.toLowerCase().includes(searchTerm)
        );
    }
    
    if (filteredDispatches.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="11" class="text-center text-muted">
                    <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                    <br>No dispatches found
                </td>
            </tr>
        `;
        return;
    }
    
    // Pagination
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const pageDispatches = filteredDispatches.slice(startIndex, endIndex);
    
    tbody.innerHTML = pageDispatches.map(dispatch => `
        <tr>
            <td><code>${dispatch.id.substring(0, 8)}</code></td>
            <td>${dispatch.dateStart}</td>
            <td>${dispatch.timeStart || '-'}</td>
            <td title="${dispatch.startLocation}">${truncateText(dispatch.startLocation, 25)}</td>
            <td title="${dispatch.destinationAddress || '-'}">${truncateText(dispatch.destinationAddress || '-', 25)}</td>
            <td>${dispatch.contactPerson || '-'}</td>
            <td>${dispatch.taskType}</td>
            <td>${dispatch.reeferRequired ? 'Yes' : 'No'}</td>
            <td>${renderStatusBadge(dispatch.status)}</td>
            <td>${dispatch.driverId ? 'Assigned' : 'Unassigned'}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-sm" onclick="viewDispatch('${dispatch.year}', '${dispatch.month}', '${dispatch.day}', '${dispatch.id}')" title="View">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="editDispatch('${dispatch.year}', '${dispatch.month}', '${dispatch.day}', '${dispatch.id}')" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-info btn-sm" onclick="assignDispatch('${dispatch.year}', '${dispatch.month}', '${dispatch.day}', '${dispatch.id}')" title="Assign">
                        <i class="fa-solid fa-user-check"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function updatePagination() {
    const pagination = document.getElementById('pagination');
    if (!pagination) return;
    
    const totalPages = Math.ceil(currentDispatches.length / itemsPerPage);
    
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        return;
    }
    
    let paginationHtml = '';
    
    // Previous button
    paginationHtml += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
        </li>
    `;
    
    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage || i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>
            `;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            paginationHtml += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    // Next button
    paginationHtml += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
        </li>
    `;
    
    pagination.innerHTML = paginationHtml;
}

function truncateText(text, maxLength) {
    if (!text || text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}

// Global functions
window.applyFilters = function() {
    currentPage = 1;
    loadDispatches();
};

window.clearFilters = function() {
    document.getElementById('statusFilter').selectedIndex = -1;
    document.getElementById('taskTypeFilter').selectedIndex = 0;
    document.getElementById('reeferFilter').selectedIndex = 0;
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('searchTerm').value = '';
    currentPage = 1;
    loadDispatches();
};

window.changePage = function(page) {
    const totalPages = Math.ceil(currentDispatches.length / itemsPerPage);
    if (page >= 1 && page <= totalPages) {
        currentPage = page;
        updateTable();
        updatePagination();
    }
};

window.viewDispatch = function(year, month, day, id) {
    window.location.href = `/dispatch/dispatch-tracking.php?id=${id}&year=${year}&month=${month}&day=${day}`;
};

window.editDispatch = function(year, month, day, id) {
    window.location.href = `/dispatch/new-dispatch.php?edit=${id}&year=${year}&month=${month}&day=${day}`;
};

window.assignDispatch = function(year, month, day, id) {
    window.location.href = `/dispatch/dispatch-assign.php?id=${id}&year=${year}&month=${month}&day=${day}`;
};

window.exportToCSV = function() {
    if (currentDispatches.length === 0) {
        showToast('No data to export', 'warning');
        return;
    }
    
    const headers = ['ID', 'Date', 'Time', 'Start Location', 'Destination', 'Contact Person', 'Contact Phone', 'Task Type', 'Reefer Required', 'Dangerous Goods', 'Status'];
    
    const csvContent = [
        headers.join(','),
        ...currentDispatches.map(dispatch => [
            dispatch.id,
            dispatch.dateStart,
            dispatch.timeStart || '',
            `"${dispatch.startLocation || ''}"`,
            `"${dispatch.destinationAddress || ''}"`,
            `"${dispatch.contactPerson || ''}"`,
            dispatch.contactPhone || '',
            dispatch.taskType,
            dispatch.reeferRequired ? 'Yes' : 'No',
            `"${dispatch.dangerousGoods || ''}"`,
            dispatch.status
        ].join(','))
    ].join('\n');
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `dispatches_${new Date().toISOString().split('T')[0]}.csv`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
    
    showToast('CSV exported successfully!', 'success');
};
</script>