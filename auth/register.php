<?php
$pageTitle = "Register - Captain Dispatch";
include '../customer-php/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block" style="background: linear-gradient(135deg, #6A307E 0%, #3B256E 100%); position: relative;">
                            <div class="p-5 text-white d-flex flex-column justify-content-center h-100">
                                <div class="text-center">
                                    <svg width="80" height="80" viewBox="0 0 24 24" class="mb-4">
                                        <polygon points="12,2 15,9 22,9 17,14 19,21 12,17 5,21 7,14 2,9 9,9" fill="#ff6b6b"/>
                                    </svg>
                                    <h2 class="mb-4">Captain Dispatch</h2>
                                    <p class="lead">Join the professional dispatch management platform</p>
                                </div>
                                <div class="mt-5">
                                    <h5>System Features:</h5>
                                    <div class="small">
                                        <p class="mb-1">✓ Real-time tracking</p>
                                        <p class="mb-1">✓ Multi-role access control</p>
                                        <p class="mb-1">✓ Canadian compliance</p>
                                        <p class="mb-0">✓ Mobile-friendly interface</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" id="registerForm">
                                    <div class="form-group row mb-3">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" 
                                                   id="firstName" name="firstName" placeholder="First Name" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" 
                                                   id="lastName" name="lastName" placeholder="Last Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-user" 
                                               id="email" name="email" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control form-control-user" 
                                               id="companyName" name="companyName" placeholder="Company Name" required>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" 
                                                   id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user" 
                                                   id="confirmPassword" name="confirmPassword" placeholder="Repeat Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <select class="form-control form-control-user" id="role" name="role" required>
                                            <option value="">Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="dispatcher">Dispatcher</option>
                                            <option value="customer">Customer</option>
                                            <option value="driver">Driver</option>
                                            <option value="accountant">Accountant</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block w-100">
                                        Register Account
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/auth/login.php">Already have an account? Login!</a>
                                </div>
                                <div class="text-center mt-3">
                                    <small class="text-muted">Developed by <strong>PanesarElite</strong></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<style>
.form-control-user {
    border-radius: 10rem;
    padding: 1.5rem 1rem;
}

.btn-user {
    border-radius: 10rem;
    padding: 0.75rem 1rem;
    font-weight: 600;
}

.card {
    border-radius: 1rem;
}
</style>

<script type="module">
import { register } from '/assets/js/auth.js';
import { showToast, showLoading, hideLoading } from '/assets/js/ui.js';

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('registerForm').addEventListener('submit', handleRegister);
});

async function handleRegister(event) {
    event.preventDefault();
    
    try {
        const formData = new FormData(event.target);
        const firstName = formData.get('firstName');
        const lastName = formData.get('lastName');
        const email = formData.get('email');
        const companyName = formData.get('companyName');
        const password = formData.get('password');
        const confirmPassword = formData.get('confirmPassword');
        const role = formData.get('role');
        
        // Validation
        if (password !== confirmPassword) {
            showToast('Passwords do not match', 'error');
            return;
        }
        
        if (password.length < 6) {
            showToast('Password must be at least 6 characters', 'error');
            return;
        }
        
        showLoading('Creating account...');
        
        // Generate company RID
        const companyRID = 'company_' + Date.now();
        
        const userData = {
            displayName: `${firstName} ${lastName}`,
            firstName,
            lastName,
            companyName,
            role,
            companyRID,
            active: true
        };
        
        await register(email, password, userData);
        
        hideLoading();
        // Redirect will be handled by auth state change
        
    } catch (error) {
        console.error('Registration error:', error);
        hideLoading();
        // Error toast is shown by register function
    }
}
</script>