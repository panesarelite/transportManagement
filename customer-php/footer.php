<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Captain Dispatch</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Theme -->
    <link rel="stylesheet" href="../assets/css/theme.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="../assets/img/star.svg">
    
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

        .debug-panel {
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body class="bg-light">

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
                                    <p class="lead">Professional dispatch management for the Canadian transportation industry</p>
                                </div>
                                <div class="mt-5">
                                    <h5>Demo Accounts:</h5>
                                    <div class="small">
                                        <p class="mb-1"><strong>Admin:</strong> admin@captaintransport.com / admin123</p>
                                        <p class="mb-1"><strong>Dispatcher:</strong> dispatcher@captaintransport.com / dispatch123</p>
                                        <p class="mb-1"><strong>Driver:</strong> driver@captaintransport.com / driver123</p>
                                        <p class="mb-0"><strong>Customer:</strong> customer@captaintransport.com / customer123</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                
                                <!-- Firebase Status Alert -->
                                <div class="alert alert-warning" id="firebaseStatusAlert" style="display: none;">
                                    <i class="fa-solid fa-exclamation-triangle me-2"></i>
                                    <span id="firebaseStatusText">Initializing Firebase...</span>
                                </div>
                                
                                <!-- Login Form -->
                                <form class="user" id="loginForm">
                                    <div class="form-group mb-3">
                                        <input type="email" class="form-control form-control-user" 
                                               id="email" name="email" placeholder="Enter Email Address..." 
                                               value="admin@captaintransport.com" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" class="form-control form-control-user" 
                                               id="password" name="password" placeholder="Password" 
                                               value="admin123" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                                            <label class="custom-control-label" for="rememberMe">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block w-100" id="loginBtn" disabled>
                                        <span id="loginBtnText">Waiting for Firebase...</span>
                                        <span id="loginSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                                    </button>
                                </form>
                                
                                <!-- Quick Login Buttons -->
                                <div class="mt-4" id="quickLoginSection" style="display: none;">
                                    <h6 class="text-center mb-3">Quick Demo Login:</h6>
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <button class="btn btn-outline-primary btn-sm w-100" onclick="quickLogin('admin')">
                                                Admin
                                            </button>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <button class="btn btn-outline-info btn-sm w-100" onclick="quickLogin('dispatcher')">
                                                Dispatcher
                                            </button>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <button class="btn btn-outline-warning btn-sm w-100" onclick="quickLogin('driver')">
                                                Driver
                                            </button>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <button class="btn btn-outline-success btn-sm w-100" onclick="quickLogin('customer')">
                                                Customer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Test Buttons -->
                                <div class="mt-4">
                                    <button class="btn btn-outline-info btn-sm w-100 mb-2" onclick="createDemoUsers()">
                                        👥 Create Demo Users First
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="testFirebaseConnection()">
                                        🧪 Test Firebase Connection
                                    </button>
                                </div>
                                
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#" onclick="showForgotPassword()">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="../auth/register.php">Create an Account!</a>
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

<!-- Debug Panel -->
<div class="position-fixed bottom-0 start-0 p-3" style="z-index: 9999;">
    <div class="card" style="width: 350px; font-size: 12px;">
        <div class="card-header py-2">
            <strong>Debug Info - PanesarElite</strong>
            <button class="btn btn-sm btn-outline-secondary float-end" onclick="toggleDebugDetails()">
                <i class="fa-solid fa-eye" id="debugToggleIcon"></i>
            </button>
        </div>
        <div class="card-body py-2" id="debugBody">
            <div id="debugInfo">
                <p class="mb-1">🔥 Firebase App: <span id="firebaseStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">🔐 Firebase Auth: <span id="authStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">📊 Firestore: <span id="firestoreStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">👤 User: <span id="userStatus" class="text-muted">None</span></p>
                <p class="mb-1">🌐 Base Path: <span id="basePathStatus" class="text-info">/site/final/captain</span></p>
                <p class="mb-0">⏰ Last Check: <span id="lastCheckTime">-</span></p>
            </div>
            <div id="debugDetails" style="display: none;">
                <hr>
                <div class="small">
                    <p class="mb-1"><strong>Project ID:</strong> <span id="projectId">-</span></p>
                    <p class="mb-1"><strong>Auth Domain:</strong> <span id="authDomain">-</span></p>
                    <p class="mb-1"><strong>Current URL:</strong> <span id="currentUrl">-</span></p>
                    <p class="mb-0"><strong>Errors:</strong> <span id="errorCount" class="text-danger">0</span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Firebase and Auth Scripts -->
<script type="module">
import { buildUrl } from '../assets/js/config.js';

console.log('🚀 Login page script starting - PanesarElite');

let firebaseReady = false;
let authReady = false;
let errorCount = 0;
let debugDetailsVisible = false;

// Update debug status function
window.updateDebugStatus = function() {
    const now = new Date().toLocaleTimeString();
    
    // Basic status
    document.getElementById('firebaseStatus').innerHTML = window.firebaseApp ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('authStatus').innerHTML = window.firebaseAuth ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('firestoreStatus').innerHTML = window.firebaseDb ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('lastCheckTime').textContent = now;
    
    // User status
    if (window.firebaseAuth && window.firebaseAuth.currentUser) {
        document.getElementById('userStatus').innerHTML = 
            `<span class="text-success">${window.firebaseAuth.currentUser.email}</span>`;
    } else {
        document.getElementById('userStatus').innerHTML = '<span class="text-muted">None</span>';
    }
    
    // Detailed info
    if (window.firebaseApp) {
        document.getElementById('projectId').textContent = window.firebaseApp.options.projectId || '-';
        document.getElementById('authDomain').textContent = window.firebaseApp.options.authDomain || '-';
    }
    document.getElementById('currentUrl').textContent = window.location.href;
    document.getElementById('errorCount').textContent = errorCount;
};

// Toggle debug details
window.toggleDebugDetails = function() {
    debugDetailsVisible = !debugDetailsVisible;
    const details = document.getElementById('debugDetails');
    const icon = document.getElementById('debugToggleIcon');
    
    if (debugDetailsVisible) {
        details.style.display = 'block';
        icon.className = 'fa-solid fa-eye-slash';
    } else {
        details.style.display = 'none';
        icon.className = 'fa-solid fa-eye';
    }
};

// Wait for Firebase to be ready
function waitForFirebase() {
    console.log('⏳ Waiting for Firebase to initialize...');
    
    let attempts = 0;
    const maxAttempts = 100; // 10 seconds
    
    const checkFirebase = setInterval(() => {
        attempts++;
        updateDebugStatus();
        
        if (window.firebaseAuth && window.firebaseDb) {
            console.log('✅ Firebase is ready!');
            clearInterval(checkFirebase);
            firebaseReady = true;
            
            // Hide Firebase status alert
            const statusAlert = document.getElementById('firebaseStatusAlert');
            if (statusAlert) {
                statusAlert.style.display = 'none';
            }
            
            // Enable login form
            enableLoginForm();
            
            // Initialize auth system
            initializeAuthSystem();
            
        } else if (attempts >= maxAttempts) {
            console.error('❌ Firebase initialization timeout after 10 seconds');
            clearInterval(checkFirebase);
            errorCount++;
            
            const statusAlert = document.getElementById('firebaseStatusAlert');
            const statusText = document.getElementById('firebaseStatusText');
            
            if (statusAlert && statusText) {
                statusAlert.className = 'alert alert-danger';
                statusText.textContent = 'Firebase initialization failed - check console for details';
                statusAlert.style.display = 'block';
            }
            
            alert('Firebase initialization failed!\n\nPlease check:\n1. Internet connection\n2. Firebase configuration\n3. Browser console for errors\n\nTry refreshing the page.');
        } else {
            // Show progress
            const statusAlert = document.getElementById('firebaseStatusAlert');
            const statusText = document.getElementById('firebaseStatusText');
            
            if (statusAlert && statusText) {
                statusAlert.style.display = 'block';
                statusText.textContent = `Initializing Firebase... (${attempts}/${maxAttempts})`;
            }
        }
    }, 100);
}

// Enable login form
function enableLoginForm() {
    console.log('🔓 Enabling login form');
    
    const loginBtn = document.getElementById('loginBtn');
    const loginBtnText = document.getElementById('loginBtnText');
    const quickLoginSection = document.getElementById('quickLoginSection');
    
    if (loginBtn) {
        loginBtn.disabled = false;
        loginBtn.className = 'btn btn-primary btn-user btn-block w-100';
    }
    
    if (loginBtnText) {
        loginBtnText.textContent = 'Login';
    }
    
    if (quickLoginSection) {
        quickLoginSection.style.display = 'block';
    }
}

// Initialize auth system
async function initializeAuthSystem() {
    try {
        console.log('🔐 Initializing authentication system...');
        
        const { initializeAuth } = await import('../assets/js/auth.js');
        await initializeAuth();
        
        console.log('✅ Authentication system initialized');
        authReady = true;
        
    } catch (error) {
        console.error('❌ Error initializing auth system:', error);
        errorCount++;
        alert(`Authentication system failed to initialize!\n\nError: ${error.message}\n\nCheck console for details.`);
    }
}

// Handle login form submission
async function handleLogin(event) {
    event.preventDefault();
    console.log('🔑 Login form submitted');
    
    if (!firebaseReady) {
        console.error('❌ Firebase not ready for login');
        alert('Firebase is not ready yet. Please wait for initialization to complete.');
        return;
    }
    
    try {
        const formData = new FormData(event.target);
        const email = formData.get('email');
        const password = formData.get('password');
        
        console.log('📧 Attempting login for:', email);
        
        // Show loading state
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        const loginSpinner = document.getElementById('loginSpinner');
        
        if (loginBtn) loginBtn.disabled = true;
        if (loginBtnText) loginBtnText.textContent = 'Signing in...';
        if (loginSpinner) loginSpinner.style.display = 'inline-block';
        
        // Import and use login function
        const { login } = await import('../assets/js/auth.js');
        await login(email, password);
        
        console.log('✅ Login completed successfully');
        
    } catch (error) {
        console.error('❌ Login failed:', error);
        errorCount++;
        
        // Reset button state
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        const loginSpinner = document.getElementById('loginSpinner');
        
        if (loginBtn) loginBtn.disabled = false;
        if (loginBtnText) loginBtnText.textContent = 'Login';
        if (loginSpinner) loginSpinner.style.display = 'none';
        
        // Show error
        alert(`Login Failed!\n\nError: ${error.message}\n\nPlease check your credentials and try again.`);
    }
}

// Quick login function
window.quickLogin = async function(role) {
    console.log('⚡ Quick login for role:', role);
    
    if (!firebaseReady) {
        alert('Firebase is not ready yet. Please wait for initialization to complete.');
        return;
    }
    
    const credentials = {
        admin: { email: 'admin@captaintransport.com', password: 'admin123' },
        dispatcher: { email: 'dispatcher@captaintransport.com', password: 'dispatch123' },
        driver: { email: 'driver@captaintransport.com', password: 'driver123' },
        customer: { email: 'customer@captaintransport.com', password: 'customer123' }
    };
    
    const cred = credentials[role];
    if (cred) {
        document.getElementById('email').value = cred.email;
        document.getElementById('password').value = cred.password;
        
        // Trigger form submission
        const form = document.getElementById('loginForm');
        if (form) {
            form.dispatchEvent(new Event('submit'));
        }
    }
};

// Test Firebase connection
window.testFirebaseConnection = async function() {
    console.log('🧪 Testing Firebase connection');
    
    try {
        if (!window.firebaseAuth || !window.firebaseDb) {
            throw new Error('Firebase not initialized');
        }
        
        console.log('✅ Firebase modules available');
        
        // Test basic Firebase functionality
        const testResult = {
            app: !!window.firebaseApp,
            auth: !!window.firebaseAuth,
            firestore: !!window.firebaseDb,
            projectId: window.firebaseApp?.options?.projectId || 'Unknown',
            authDomain: window.firebaseApp?.options?.authDomain || 'Unknown'
        };
        
        console.log('🧪 Test results:', testResult);
        
        alert(`Firebase Connection Test Results:

✅ Firebase App: ${testResult.app ? 'Connected' : 'Failed'}
✅ Authentication: ${testResult.auth ? 'Connected' : 'Failed'}  
✅ Firestore: ${testResult.firestore ? 'Connected' : 'Failed'}
📋 Project ID: ${testResult.projectId}
🔐 Auth Domain: ${testResult.authDomain}

${testResult.app && testResult.auth && testResult.firestore ? 
  '🎉 All systems ready!' : 
  '❌ Some systems failed - check console'}`);
        
    } catch (error) {
        console.error('❌ Firebase connection test failed:', error);
        errorCount++;
        
        alert(`Firebase Test Failed:
❌ Error: ${error.message}
🔍 Check browser console for details
🔄 Try refreshing the page`);
    }
};

// Create demo users
window.createDemoUsers = async function() {
    console.log('👥 Creating demo users');
    
    if (!firebaseReady) {
        alert('Firebase is not ready yet. Please wait for initialization to complete.');
        return;
    }
    
    try {
        console.log('📦 Loading Firebase modules for user creation...');
        console.log('📦 Loading Firebase modules for user creation...');
        console.log('📦 Loading Firebase modules for user creation...');
        console.log('📦 Loading Firebase modules for user creation...');
        console.log('📦 Loading Firebase modules for user creation...');
        const { createUserWithEmailAndPassword } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
        const { doc, setDoc, serverTimestamp } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js');
        console.log('✅ Firebase modules loaded for user creation');
        console.log('✅ Firebase modules loaded for user creation');
        console.log('✅ Firebase modules loaded for user creation');
        console.log('✅ Firebase modules loaded for user creation');
        console.log('✅ Firebase modules loaded for user creation');
        
        const demoAccounts = [
            {
                email: 'admin@captaintransport.com',
                password: 'admin123',
                userData: {
                    displayName: 'Admin User',
                    role: 'admin',
                    companyRID: 'captain_transport_demo',
                    active: true
                }
            },
            {
                email: 'dispatcher@captaintransport.com',
                password: 'dispatch123',
                userData: {
                    displayName: 'Dispatcher User',
                    role: 'dispatcher',
                    companyRID: 'captain_transport_demo',
                    active: true
                }
            },
            {
                email: 'driver@captaintransport.com',
                password: 'driver123',
                userData: {
                    displayName: 'Driver User',
                    role: 'driver',
                    companyRID: 'captain_transport_demo',
                    active: true
                }
            },
            {
                email: 'customer@captaintransport.com',
                password: 'customer123',
                userData: {
                    displayName: 'Customer User',
                    role: 'customer',
                    companyRID: 'captain_transport_demo',
                    active: true
                }
            }
4. Contacting support if the issue persists`);
    }
};

👤 Current User: ${testResult.currentUser}
        ];
        
        console.log('🔄 Starting demo user creation process...');
        alert('Creating demo users...\n\nThis may take a moment. Please wait for the success message.');
        
        let created = 0;
        let existing = 0;
                statusText.innerHTML = `
                    <strong>Firebase initialization timeout!</strong><br>
                    This usually indicates network or configuration issues.<br>
                    <button class="btn btn-sm btn-outline-light mt-2" onclick="retryFirebaseInit()">
                        🔄 Retry Initialization
                    </button>
                `;
        const errorDetails = [];
        
        for (const account of demoAccounts) {
            try {
                console.log('👤 Creating user:', account.email);
                
                let userCredential;
                let isNewUser = false;
                
                try {
                    // Try to create new user
                    userCredential = await createUserWithEmailAndPassword(
                        window.firebaseAuth, 
                        account.email, 
                        account.password
                    );
                    isNewUser = true;
                    console.log('✅ New Firebase Auth user created:', account.email);
                    
                } catch (authError) {
                    if (authError.code === 'auth/email-already-in-use') {
                        console.log('ℹ️ User already exists in Firebase Auth:', account.email);
                        
                        // Try to sign in to get the user object
                        const { signInWithEmailAndPassword } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
                        userCredential = await signInWithEmailAndPassword(window.firebaseAuth, account.email, account.password);
                        console.log('✅ Signed in existing user:', account.email);
                        
                    } else {
                        throw authError;
                    }
                }
                
                // Create user document
                console.log('📄 Creating Firestore user document for:', account.email);
                const userDoc = {
                    ...account.userData,
                    uid: userCredential.user.uid,
                    email: account.email,
                    createdAt: serverTimestamp(),
                    updatedAt: serverTimestamp()
                };
                
                // Create in company collection
                console.log('💾 Saving to company users collection...');
                await setDoc(doc(window.firebaseDb, `companies/${account.userData.companyRID}/users`, userCredential.user.uid), userDoc);
                
                // Create in global users collection for compatibility
                console.log('💾 Saving to global users collection...');
                await setDoc(doc(window.firebaseDb, 'users', userCredential.user.uid), userDoc);
                
                if (isNewUser) {
                    console.log('✅ Created new user:', account.email);
                    created++;
            alert(`Firebase initialization timeout!

This usually indicates:
1. Network connectivity issues
2. Firebase CDN blocked by firewall
3. Browser security settings
4. Firebase configuration problems

Solutions:
1. Check internet connection
2. Try refreshing the page
3. Check browser console for errors
4. Try a different browser/network

Current status:
- Firebase App: ${!!window.firebaseApp}
- Firebase Auth: ${!!window.firebaseAuth}
- Firestore: ${!!window.firebaseDb}`);
                    console.log('✅ Updated existing user:', account.email);
                    existing++;
                }
                
            } catch (error) {
                console.error('❌ Error creating user:', account.email, error);
                errorDetails.push(`${account.email}: ${error.message}`);
                statusText.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin me-2"></i>
                    Initializing Firebase... (${attempts}/${maxAttempts})
                `;
            }
        }
        
        const resultMessage = `Demo Users Creation Results:

✅ Created: ${created} new users
ℹ️ Existing: ${existing} users already existed
❌ Errors: ${errors}

${errors > 0 ? 'Error Details:\n' + errorDetails.join('\n') : ''}

You can now use the demo accounts to login!`;
        
        console.log('📊 Demo user creation completed:', { created, existing, errors });
        alert(resultMessage);
        
    } catch (error) {
        console.error('❌ Error in demo user creation:', error);
        
        const errorMessage = `Demo user creation failed!

Error: ${error.message}

Possible solutions:
1. Check internet connection
2. Verify Firebase configuration
3. Try refreshing the page
4. Check browser console for details

Technical details:
- Error type: ${error.name}
- Firebase ready: ${window.firebaseReady || false}
        alert(`Firebase Test Failed!

❌ Error: ${error.message}

Debug Information:
- Firebase App: ${!!window.firebaseApp}
- Firebase Auth: ${!!window.firebaseAuth}
- Firestore: ${!!window.firebaseDb}
- Error Type: ${error.name}

Solutions:
1. Check internet connection
2. Verify Firebase configuration
3. Check browser console for details
4. Try refreshing the page
5. Try different browser/network`);
    }
};

// Other utility functions
window.showForgotPassword = function() {
    alert('Password reset functionality coming soon!\n\nFor now, use the demo accounts provided.');
};

window.goToRegister = function() {
    window.location.href = buildUrl('/auth/register.php');
};

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Login page DOM loaded');
    
    // Start debug status updates
    setInterval(updateDebugStatus, 1000);
    
    // Wait for Firebase
    waitForFirebase();
    
    // Set up form handler
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    
    console.log('🎯 Login page setup complete');
});

// Listen for Firebase ready event
window.addEventListener('firebaseReady', function() {
    console.log('🎉 Firebase ready event received');
    firebaseReady = true;
    enableLoginForm();
});

// Error handling
window.addEventListener('error', function(event) {
    console.error('💥 Global error:', event.error);
    errorCount++;
    updateDebugStatus();
});

console.log('✅ Login page script loaded - PanesarElite');
</script>

</body>
</html>