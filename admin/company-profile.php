<?php
$pageTitle = "Company Profile - Captain Dispatch";
$currentPage = "company-profile";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Company Profile</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-outline-primary" onclick="seedSampleData()">
                        <i class="fa-solid fa-database"></i> Seed Sample Data
                    </button>
                </div>
            </div>

            <!-- Company Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Company Information</h6>
                </div>
                <div class="card-body">
                    <form id="companyForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name *</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="businessNumber" class="form-label">Business Number</label>
                                    <input type="text" class="form-control" id="businessNumber" name="businessNumber" 
                                           placeholder="123456789RC0001">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address *</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="province" class="form-label">Province *</label>
                                    <select class="form-select" id="province" name="province" required>
                                        <option value="">Select province...</option>
                                        <option value="AB">Alberta</option>
                                        <option value="BC">British Columbia</option>
                                        <option value="MB">Manitoba</option>
                                        <option value="NB">New Brunswick</option>
                                        <option value="NL">Newfoundland and Labrador</option>
                                        <option value="NS">Nova Scotia</option>
                                        <option value="ON">Ontario</option>
                                        <option value="PE">Prince Edward Island</option>
                                        <option value="QC">Quebec</option>
                                        <option value="SK">Saskatchewan</option>
                                        <option value="NT">Northwest Territories</option>
                                        <option value="NU">Nunavut</option>
                                        <option value="YT">Yukon</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="postalCode" class="form-label">Postal Code *</label>
                                    <input type="text" class="form-control" id="postalCode" name="postalCode" 
                                           placeholder="T2P 1J9" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           placeholder="+1 (403) 555-0123" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website</label>
                                    <input type="url" class="form-control" id="website" name="website" 
                                           placeholder="https://www.company.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-select" id="timezone" name="timezone">
                                        <option value="America/Edmonton">Mountain Time (Edmonton)</option>
                                        <option value="America/Vancouver">Pacific Time (Vancouver)</option>
                                        <option value="America/Toronto">Eastern Time (Toronto)</option>
                                        <option value="America/Winnipeg">Central Time (Winnipeg)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-save me-2"></i>Save Changes
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2" onclick="resetForm()">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Company Statistics -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Company Statistics</h6>
                        </div>
                        <div class="card-body">
                            <div id="companyStats">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">System Information</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Company ID:</strong> <code id="companyRID">Loading...</code></p>
                            <p><strong>Account Created:</strong> <span id="accountCreated">Loading...</span></p>
                            <p><strong>Last Updated:</strong> <span id="lastUpdated">Loading...</span></p>
                            <p><strong>System Version:</strong> v2.1.0</p>
                            <p><strong>Developer:</strong> PanesarElite</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { getCompanyDoc, updateCompanyProfile, listCompanyUsers, listDrivers, listTrucks } from '/assets/js/dao.js';
import { getCurrentCompanyRID } from '/assets/js/auth.js';
import { seedSampleData } from '/assets/js/seed.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';

let currentCompanyData = null;

document.addEventListener('DOMContentLoaded', function() {
    loadCompanyData();
    loadCompanyStats();
    
    document.getElementById('companyForm').addEventListener('submit', handleFormSubmit);
});

async function loadCompanyData() {
    try {
        showLoading('Loading company data...');
        
        const companyDoc = await getCompanyDoc();
        
        if (companyDoc.exists()) {
            currentCompanyData = companyDoc.data();
            populateForm(currentCompanyData);
        } else {
            // Set default values for new company
            document.getElementById('timezone').value = 'America/Edmonton';
        }
        
        // Display company RID
        document.getElementById('companyRID').textContent = getCurrentCompanyRID();
        
        if (currentCompanyData) {
            document.getElementById('accountCreated').textContent = formatDate(currentCompanyData.createdAt);
            document.getElementById('lastUpdated').textContent = formatDate(currentCompanyData.updatedAt);
        }
        
        hideLoading();
    } catch (error) {
        console.error('Error loading company data:', error);
        showToast('Error loading company data', 'error');
        hideLoading();
    }
}

function populateForm(data) {
    Object.keys(data).forEach(key => {
        const field = document.getElementById(key);
        if (field && data[key]) {
            field.value = data[key];
        }
    });
}

async function loadCompanyStats() {
    try {
        const [users, drivers, trucks] = await Promise.all([
            listCompanyUsers(),
            listDrivers(),
            listTrucks()
        ]);
        
        const statsContainer = document.getElementById('companyStats');
        statsContainer.innerHTML = `
            <div class="row">
                <div class="col-6">
                    <div class="text-center">
                        <div class="h3 text-primary">${users.length}</div>
                        <div class="small text-muted">Total Users</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <div class="h3 text-info">${drivers.length}</div>
                        <div class="small text-muted">Active Drivers</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6">
                    <div class="text-center">
                        <div class="h3 text-warning">${trucks.length}</div>
                        <div class="small text-muted">Fleet Vehicles</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <div class="h3 text-success">${trucks.filter(t => t.reeferCapable).length}</div>
                        <div class="small text-muted">Reefer Units</div>
                    </div>
                </div>
            </div>
        `;
        
    } catch (error) {
        console.error('Error loading stats:', error);
        document.getElementById('companyStats').innerHTML = '<p class="text-muted">Error loading statistics</p>';
    }
}

async function handleFormSubmit(event) {
    event.preventDefault();
    
    try {
        const formData = new FormData(event.target);
        const companyData = Object.fromEntries(formData.entries());
        
        showLoading('Saving company profile...');
        
        await updateCompanyProfile(companyData);
        
        hideLoading();
        showToast('Company profile updated successfully!', 'success');
        
        // Reload data
        await loadCompanyData();
        
    } catch (error) {
        console.error('Error saving company profile:', error);
        hideLoading();
        showToast('Error saving company profile: ' + error.message, 'error');
    }
}

function formatDate(timestamp) {
    if (!timestamp) return 'N/A';
    
    try {
        const date = timestamp.toDate ? timestamp.toDate() : new Date(timestamp);
        return date.toLocaleDateString('en-CA', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    } catch (error) {
        return 'Invalid date';
    }
}

// Global functions
window.resetForm = function() {
    if (currentCompanyData) {
        populateForm(currentCompanyData);
    } else {
        document.getElementById('companyForm').reset();
        document.getElementById('timezone').value = 'America/Edmonton';
    }
};

window.seedSampleData = function() {
    seedSampleData();
};
</script>