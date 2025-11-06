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
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block" style="background: linear-gradient(135deg, #6A307E 0%, #3B256E 100%);">
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
                                    <button type="submit" class="btn btn-primary btn-user btn-block w-100" id="loginBtn">
                                        <span id="loginBtnText">Login</span>
                                        <span id="loginSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                                    </button>
                                </form>
                                
                                <!-- Quick Login Buttons -->
                                <div class="mt-4">
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
        </div>
        <div class="card-body py-2">
            <div id="debugInfo">
                <p class="mb-1">🔥 Firebase App: <span id="firebaseStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">🔐 Firebase Auth: <span id="authStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">📊 Firestore: <span id="firestoreStatus" class="text-warning">Loading...</span></p>
                <p class="mb-1">👤 User: <span id="userStatus" class="text-muted">None</span></p>
                <p class="mb-1">🌐 Base Path: <span id="basePathStatus" class="text-info">/site/final/captain</span></p>
                <p class="mb-0">⏰ Last Check: <span id="lastCheckTime">-</span></p>
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

// Update debug status
function updateDebugStatus() {
    const now = new Date().toLocaleTimeString();
    
    document.getElementById('firebaseStatus').innerHTML = window.firebaseApp ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('authStatus').innerHTML = window.firebaseAuth ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('firestoreStatus').innerHTML = window.firebaseDb ? 
        '<span class="text-success">✅ Ready</span>' : '<span class="text-danger">❌ Failed</span>';
    document.getElementById('lastCheckTime').textContent = now;
    
    if (window.firebaseAuth && window.firebaseAuth.currentUser) {
        document.getElementById('userStatus').innerHTML = 
            `<span class="text-success">${window.firebaseAuth.currentUser.email}</span>`;
    } else {
        document.getElementById('userStatus').innerHTML = '<span class="text-muted">None</span>';
    }
}

// Wait for Firebase
function waitForFirebase() {
    console.log('⏳ Waiting for Firebase...');
    
    let attempts = 0;
    const maxAttempts = 50;
    
    const checkFirebase = setInterval(() => {
        attempts++;
        updateDebugStatus();
        
        if (window.firebaseAuth && window.firebaseDb) {
            console.log('✅ Firebase is ready!');
            clearInterval(checkFirebase);
            firebaseReady = true;
            
            // Initialize auth system
            initializeAuthSystem();
            
        } else if (attempts >= maxAttempts) {
            console.error('❌ Firebase timeout');
            clearInterval(checkFirebase);
            alert('Firebase initialization timeout!\n\nPlease refresh the page and try again.');
        }
    }, 100);
}

// Initialize auth system
async function initializeAuthSystem() {
    try {
        console.log('🔐 Initializing auth system...');
        const { initializeAuth } = await import('../assets/js/auth.js');
        await initializeAuth();
        console.log('✅ Auth system ready');
    } catch (error) {
        console.error('❌ Auth system error:', error);
        alert('Authentication system failed: ' + error.message);
    }
}

// Handle login
async function handleLogin(event) {
    event.preventDefault();
    console.log('🔑 Login form submitted');
    
    if (!firebaseReady) {
        alert('Firebase is not ready yet. Please wait.');
        return;
    }
    
    try {
        const formData = new FormData(event.target);
        const email = formData.get('email');
        const password = formData.get('password');
        
        console.log('📧 Attempting login for:', email);
        
        // Show loading
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        const loginSpinner = document.getElementById('loginSpinner');
        
        if (loginBtn) loginBtn.disabled = true;
        if (loginBtnText) loginBtnText.textContent = 'Signing in...';
        if (loginSpinner) loginSpinner.style.display = 'inline-block';
        
        // Import and use login
        const { login } = await import('../assets/js/auth.js');
        await login(email, password);
        
    } catch (error) {
        console.error('❌ Login failed:', error);
        
        // Reset button
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        const loginSpinner = document.getElementById('loginSpinner');
        
        if (loginBtn) loginBtn.disabled = false;
        if (loginBtnText) loginBtnText.textContent = 'Login';
        if (loginSpinner) loginSpinner.style.display = 'none';
    }
}

// Quick login
window.quickLogin = async function(role) {
    console.log('⚡ Quick login for role:', role);
    
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
        document.getElementById('loginForm').dispatchEvent(new Event('submit'));
    }
};

// Create demo users
window.createDemoUsers = async function() {
    console.log('👥 Creating demo users');
    
    if (!firebaseReady) {
        alert('Firebase is not ready yet.');
        return;
    }
    
    try {
        console.log('📦 Loading Firebase modules for user creation...');
        console.log('📦 Loading Firebase modules for user creation...');
        const { createUserWithEmailAndPassword } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
        const { doc, setDoc, serverTimestamp } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js');
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
        ];
        
        let created = 0;
        let existing = 0;
        
        for (const account of demoAccounts) {
            try {
                console.log('👤 Creating user:', account.email);
                
                // Try to create user
                const userCredential = await createUserWithEmailAndPassword(
                    window.firebaseAuth, 
                    account.email, 
                    account.password
                );
                
                // Create user document
                const userDoc = {
                    ...account.userData,
                    uid: userCredential.user.uid,
                    email: account.email,
                    createdAt: serverTimestamp(),
                };
                
                // Save to Firestore
                await setDoc(doc(window.firebaseDb, 'users', userCredential.user.uid), userDoc);
                
                console.log('✅ Created user:', account.email);
                created++;
                
            } catch (error) {
                if (error.code === 'auth/email-already-in-use') {
                    console.log('ℹ️ User already exists:', account.email);
                    existing++;
                } else {
                    console.error('❌ Error creating user:', account.email, error);
                }
            }
        }
        
        alert(`Demo Users Created!

✅ New users: ${created}
ℹ️ Already existed: ${existing}

You can now login with the demo accounts!`);
        
    } catch (error) {
        console.error('❌ Demo user creation failed:', error);
        alert('Demo user creation failed: ' + error.message);
    }
};

// Test Firebase
window.testFirebaseConnection = async function() {
    console.log('🧪 Testing Firebase');
    
    try {
        if (!window.firebaseAuth || !window.firebaseDb) {
            throw new Error('Firebase not initialized');
        }
        
        alert(`Firebase Test Results:

✅ Firebase App: ${!!window.firebaseApp}
✅ Authentication: ${!!window.firebaseAuth}  
✅ Firestore: ${!!window.firebaseDb}
📋 Project ID: ${window.firebaseApp?.options?.projectId}

🎉 All systems ready!`);
        
    } catch (error) {
        console.error('❌ Firebase test failed:', error);
        alert('Firebase test failed: ' + error.message);
    }
};

// Other functions
window.showForgotPassword = function() {
    alert('Password reset coming soon!\n\nUse demo accounts for now.');
};

// Initialize when DOM ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Login page DOM loaded');
    
    // Update debug status every second
    setInterval(updateDebugStatus, 1000);
    
    // Wait for Firebase
    waitForFirebase();
    
    // Set up form handler
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    
    console.log('🎯 Login page setup complete');
});

// Listen for Firebase ready
window.addEventListener('firebaseReady', function() {
    console.log('🎉 Firebase ready event received');
    firebaseReady = true;
});

console.log('✅ Login page script loaded - PanesarElite');
</script>

</body>
</html>