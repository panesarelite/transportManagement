<?php
$pageTitle = "User Management - Captain Dispatch";
$currentPage = "users";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa-solid fa-plus"></i> Add User
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Company Users</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Populated by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="displayName" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="displayName" name="displayName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role *</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select role...</option>
                            <option value="admin">Admin</option>
                            <option value="dispatcher">Dispatcher</option>
                            <option value="customer">Customer</option>
                            <option value="driver">Driver</option>
                            <option value="accountant">Accountant</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Temporary Password *</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1 (555) 123-4567">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="createUser()">Create User</button>
            </div>
        </div>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { listCompanyUsers } from '/assets/js/dao.js';
import { register } from '/assets/js/auth.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';
import { getCurrentCompanyRID } from '/assets/js/auth.js';

let currentUsers = [];

document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

async function loadUsers() {
    try {
        showLoading('Loading users...');
        
        currentUsers = await listCompanyUsers();
        updateUsersTable();
        
        hideLoading();
    } catch (error) {
        console.error('Error loading users:', error);
        showToast('Error loading users', 'error');
        hideLoading();
    }
}

function updateUsersTable() {
    const tbody = document.getElementById('usersTableBody');
    if (!tbody) return;
    
    if (currentUsers.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    <i class="fa-solid fa-users fa-2x mb-2"></i>
                    <br>No users found
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = currentUsers.map(user => `
        <tr>
            <td>${user.displayName || 'N/A'}</td>
            <td>${user.email}</td>
            <td>
                <span class="badge bg-${getRoleBadgeColor(user.role)}">${user.role}</span>
            </td>
            <td>
                <span class="badge bg-${user.active !== false ? 'success' : 'secondary'}">
                    ${user.active !== false ? 'Active' : 'Inactive'}
                </span>
            </td>
            <td>${formatDate(user.lastLogin) || 'Never'}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-sm" onclick="editUser('${user.id}')" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                    <button class="btn btn-outline-${user.active !== false ? 'warning' : 'success'} btn-sm" 
                            onclick="toggleUserStatus('${user.id}', ${user.active !== false})" 
                            title="${user.active !== false ? 'Deactivate' : 'Activate'}">
                        <i class="fa-solid fa-${user.active !== false ? 'ban' : 'check'}"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function getRoleBadgeColor(role) {
    const colors = {
        'admin': 'danger',
        'dispatcher': 'primary',
        'customer': 'info',
        'driver': 'warning',
        'accountant': 'success'
    };
    return colors[role] || 'secondary';
}

function formatDate(timestamp) {
    if (!timestamp) return null;
    
    try {
        const date = timestamp.toDate ? timestamp.toDate() : new Date(timestamp);
        return date.toLocaleDateString('en-CA');
    } catch (error) {
        return null;
    }
}

// Global functions
window.createUser = async function() {
    try {
        const form = document.getElementById('addUserForm');
        const formData = new FormData(form);
        
        const userData = {
            displayName: formData.get('displayName'),
            email: formData.get('email'),
            role: formData.get('role'),
            phone: formData.get('phone'),
            companyRID: getCurrentCompanyRID(),
            active: true
        };
        
        const password = formData.get('password');
        
        showLoading('Creating user...');
        
        await register(userData.email, password, userData);
        
        hideLoading();
        showToast('User created successfully!', 'success');
        
        // Close modal and refresh
        const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
        modal.hide();
        form.reset();
        
        await loadUsers();
        
    } catch (error) {
        console.error('Error creating user:', error);
        hideLoading();
        // Error toast is shown by register function
    }
};

window.editUser = function(userId) {
    showToast('User editing functionality coming soon!', 'info');
};

window.toggleUserStatus = function(userId, currentStatus) {
    showToast('User status toggle functionality coming soon!', 'info');
};
</script>