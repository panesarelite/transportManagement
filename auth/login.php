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
    
    <!-- Firebase v9 SDK Bundle -->
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore-compat.js"></script>
    
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
                                
                                <!-- Firebase Status Alert -->
                                <div class="alert alert-warning" id="firebaseStatusAlert">
                                    <i class="fa-solid fa-spinner fa-spin me-2"></i>
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
                                <div class="mt-4" id="testButtonsSection" style="display: none;">
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
        <div class="card-body py-2">
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

<!-- Firebase Initialization Script -->
<script>
console.log('🚀 Login page starting - PanesarElite');

// Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyC38q2zby3TLMuHQEwrShiW-eoeBjjVDYo",
    authDomain: "test-dispatch010925.firebaseapp.com",
    projectId: "test-dispatch010925",
    storageBucket: "test-dispatch010925.firebasestorage.app",
    messagingSenderId: "501630575030",
    appId: "1:501630575030:web:6643f228b2f84f8e5da117"
};

let firebaseReady = false;
let authReady = false;
let errorCount = 0;
let debugDetailsVisible = false;

// Initialize Firebase
function initializeFirebase() {
    console.log('🔥 Initializing Firebase...');
    
    try {
        // Check if Firebase is loaded
        if (typeof firebase === 'undefined') {
            throw new Error('Firebase SDK not loaded');
        }
        
        console.log('📦 Firebase SDK loaded successfully');
        
        // Initialize Firebase app
        console.log('🚀 Initializing Firebase app...');
        const app = firebase.initializeApp(firebaseConfig);
        console.log('✅ Firebase app initialized');
        
        // Initialize Auth
        console.log('🔐 Initializing Firebase Auth...');
        window.firebaseAuth = firebase.auth();
        console.log('✅ Firebase Auth initialized');
        
        // Initialize Firestore
        console.log('📊 Initializing Firestore...');
        window.firebaseDb = firebase.firestore();
        console.log('✅ Firestore initialized');
        
        // Make available globally
        window.firebaseApp = app;
        window.firebaseReady = true;
        
        console.log('🎉 Firebase initialization complete!');
        console.log('📋 Project ID:', app.options.projectId);
        
        firebaseReady = true;
        enableLoginForm();
        
        // Set up auth state listener
        window.firebaseAuth.onAuthStateChanged((user) => {
            console.log('👤 Auth state changed:', user ? user.email : 'No user');
            updateDebugStatus();
        });
        
        return { app, auth: window.firebaseAuth, db: window.firebaseDb };
        
    } catch (error) {
        console.error('❌ Firebase initialization failed:', error);
        errorCount++;
        
        const statusAlert = document.getElementById('firebaseStatusAlert');
        const statusText = document.getElementById('firebaseStatusText');
        
        if (statusAlert && statusText) {
            statusAlert.className = 'alert alert-danger';
            statusText.innerHTML = `
                <strong>Firebase initialization failed!</strong><br>
                ${error.message}<br>
                <button class="btn btn-sm btn-outline-light mt-2" onclick="retryFirebaseInit()">
                    🔄 Retry
                </button>
            `;
        }
        
        alert(`Firebase initialization failed!

Error: ${error.message}

Possible solutions:
1. Check internet connection
2. Refresh the page
3. Try different browser
4. Check if Firebase CDN is accessible

Technical details:
- Firebase SDK loaded: ${typeof firebase !== 'undefined'}
- Error type: ${error.name}`);
        
        throw error;
    }
}

// Enable login form
function enableLoginForm() {
    console.log('🔓 Enabling login form');
    
    const loginBtn = document.getElementById('loginBtn');
    const loginBtnText = document.getElementById('loginBtnText');
    const quickLoginSection = document.getElementById('quickLoginSection');
    const testButtonsSection = document.getElementById('testButtonsSection');
    const statusAlert = document.getElementById('firebaseStatusAlert');
    
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
    
    if (testButtonsSection) {
        testButtonsSection.style.display = 'block';
    }
    
    if (statusAlert) {
        statusAlert.style.display = 'none';
    }
}

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
}

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

// Retry Firebase initialization
window.retryFirebaseInit = function() {
    console.log('🔄 Retrying Firebase initialization...');
    
    const statusAlert = document.getElementById('firebaseStatusAlert');
    const statusText = document.getElementById('firebaseStatusText');
    
    if (statusAlert && statusText) {
        statusAlert.className = 'alert alert-warning';
        statusText.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Retrying Firebase initialization...';
        statusAlert.style.display = 'block';
    }
    
    setTimeout(() => {
        initializeFirebase();
    }, 1000);
};

// Handle login form submission
async function handleLogin(event) {
    event.preventDefault();
    console.log('🔑 Login form submitted');
    
    if (!firebaseReady) {
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
        
        // Sign in with Firebase
        console.log('🔐 Signing in with Firebase Auth...');
        const userCredential = await firebase.auth().signInWithEmailAndPassword(email, password);
        console.log('✅ Firebase Auth successful for:', userCredential.user.email);
        
        // Load user profile
        console.log('👤 Loading user profile...');
        await loadUserProfile(userCredential.user);
        
        console.log('🎯 Login complete, redirecting to dashboard...');
        
        // Redirect to dashboard
        setTimeout(() => {
            window.location.href = '/site/final/captain/index.php';
        }, 500);
        
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
        
        let errorMessage = 'Login failed: ';
        
        switch (error.code) {
            case 'auth/user-not-found':
                errorMessage += 'No account found with this email address.';
                break;
            case 'auth/wrong-password':
                errorMessage += 'Incorrect password.';
                break;
            case 'auth/invalid-email':
                errorMessage += 'Invalid email address format.';
                break;
            case 'auth/too-many-requests':
                errorMessage += 'Too many failed attempts. Please try again later.';
                break;
            default:
                errorMessage += error.message;
        }
        
        alert(errorMessage);
    }
}

// Load user profile
async function loadUserProfile(user) {
    console.log('👤 Loading user profile for:', user.email);
    
    try {
        const companyRID = 'captain_transport_demo';
        
        // Try to find user in global users collection first
        console.log('📄 Checking global users collection...');
        let userDoc = await firebase.firestore().collection('users').doc(user.uid).get();
        
        if (userDoc.exists) {
            const userData = userDoc.data();
            console.log('✅ User profile found in global collection:', userData);
            window.currentUserData = userData;
            return userData;
        }
        
        // Try company collection
        console.log('📄 Checking company users collection...');
        userDoc = await firebase.firestore()
            .collection('companies').doc(companyRID)
            .collection('users').doc(user.uid).get();
        
        if (userDoc.exists) {
            const userData = userDoc.data();
            console.log('✅ User profile found in company collection:', userData);
            window.currentUserData = userData;
            return userData;
        }
        
        console.warn('⚠️ User profile not found, creating basic profile...');
        
        // Create basic user profile
        const basicUserData = {
            uid: user.uid,
            email: user.email,
            displayName: user.displayName || user.email.split('@')[0],
            role: 'admin', // Default role for demo
            companyRID: companyRID,
            active: true,
            createdAt: firebase.firestore.FieldValue.serverTimestamp(),
            updatedAt: firebase.firestore.FieldValue.serverTimestamp()
        };
        
        // Save to global users collection
        console.log('💾 Creating user profile...');
        await firebase.firestore().collection('users').doc(user.uid).set(basicUserData);
        
        console.log('✅ Basic user profile created');
        window.currentUserData = basicUserData;
        
        return basicUserData;
        
    } catch (error) {
        console.error('❌ Error loading/creating user profile:', error);
        throw error;
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
window.testFirebaseConnection = function() {
    console.log('🧪 Testing Firebase connection');
    
    try {
        if (!window.firebaseAuth || !window.firebaseDb) {
            throw new Error('Firebase not initialized');
        }
        
        const testResult = {
            app: !!window.firebaseApp,
            auth: !!window.firebaseAuth,
            firestore: !!window.firebaseDb,
            projectId: window.firebaseApp?.options?.projectId || 'Unknown',
            authDomain: window.firebaseApp?.options?.authDomain || 'Unknown',
            currentUser: window.firebaseAuth?.currentUser?.email || 'None'
        };
        
        console.log('🧪 Test results:', testResult);
        
        alert(`Firebase Connection Test Results:

✅ Firebase App: ${testResult.app ? 'Connected' : 'Failed'}
✅ Authentication: ${testResult.auth ? 'Connected' : 'Failed'}  
✅ Firestore: ${testResult.firestore ? 'Connected' : 'Failed'}
📋 Project ID: ${testResult.projectId}
🔐 Auth Domain: ${testResult.authDomain}
👤 Current User: ${testResult.currentUser}

${testResult.app && testResult.auth && testResult.firestore ? 
  '🎉 All systems ready!' : 
  '❌ Some systems failed - check console'}`);
        
    } catch (error) {
        console.error('❌ Firebase connection test failed:', error);
        errorCount++;
        
        alert(`Firebase Test Failed:

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

// Create demo users
window.createDemoUsers = async function() {
    console.log('👥 Creating demo users');
    
    if (!firebaseReady) {
        alert('Firebase is not ready yet. Please wait for initialization to complete.');
        return;
    }
    
    try {
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
        
        console.log('🔄 Starting demo user creation process...');
        alert('Creating demo users...\n\nThis may take a moment. Please wait for the success message.');
        
        let created = 0;
        let existing = 0;
        const errors = [];
        
        for (const account of demoAccounts) {
            try {
                console.log('👤 Creating user:', account.email);
                
                let userCredential;
                let isNewUser = false;
                
                try {
                    // Try to create new user
                    userCredential = await firebase.auth().createUserWithEmailAndPassword(
                        account.email, 
                        account.password
                    );
                    isNewUser = true;
                    console.log('✅ New Firebase Auth user created:', account.email);
                    
                } catch (authError) {
                    if (authError.code === 'auth/email-already-in-use') {
                        console.log('ℹ️ User already exists in Firebase Auth:', account.email);
                        
                        // Try to sign in to get the user object
                        userCredential = await firebase.auth().signInWithEmailAndPassword(account.email, account.password);
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
                    createdAt: firebase.firestore.FieldValue.serverTimestamp(),
                    updatedAt: firebase.firestore.FieldValue.serverTimestamp()
                };
                
                // Create in company collection
                console.log('💾 Saving to company users collection...');
                await firebase.firestore()
                    .collection('companies').doc(account.userData.companyRID)
                    .collection('users').doc(userCredential.user.uid)
                    .set(userDoc);
                
                // Create in global users collection for compatibility
                console.log('💾 Saving to global users collection...');
                await firebase.firestore()
                    .collection('users').doc(userCredential.user.uid)
                    .set(userDoc);
                
                if (isNewUser) {
                    console.log('✅ Created new user:', account.email);
                    created++;
                } else {
                    console.log('✅ Updated existing user:', account.email);
                    existing++;
                }
                
            } catch (error) {
                console.error('❌ Error creating user:', account.email, error);
                errors.push(`${account.email}: ${error.message}`);
            }
        }
        
        const resultMessage = `Demo Users Creation Results:

✅ Created: ${created} new users
ℹ️ Existing: ${existing} users already existed
❌ Errors: ${errors.length}

${errors.length > 0 ? 'Error Details:\n' + errors.join('\n') : ''}

You can now use the demo accounts to login!`;
        
        console.log('📊 Demo user creation completed:', { created, existing, errors: errors.length });
        alert(resultMessage);
        
    } catch (error) {
        console.error('❌ Error in demo user creation:', error);
        errorCount++;
        
        alert(`Demo user creation failed!

Error: ${error.message}

Possible solutions:
1. Check internet connection
2. Verify Firebase configuration
3. Try refreshing the page
4. Check browser console for details

Technical details:
- Error type: ${error.name}
- Firebase ready: ${firebaseReady}`);
    }
};

// Other utility functions
window.showForgotPassword = function() {
    alert('Password reset functionality coming soon!\n\nFor now, use the demo accounts provided.');
};

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('📄 Login page DOM loaded');
    
    // Start debug status updates
    setInterval(updateDebugStatus, 1000);
    
    // Wait for Firebase SDK to load, then initialize
    if (typeof firebase !== 'undefined') {
        console.log('✅ Firebase SDK already loaded');
        initializeFirebase();
    } else {
        console.log('⏳ Waiting for Firebase SDK to load...');
        
        let attempts = 0;
        const maxAttempts = 50;
        
        const checkFirebaseSDK = setInterval(() => {
            attempts++;
            
            if (typeof firebase !== 'undefined') {
                console.log('✅ Firebase SDK loaded after', attempts, 'attempts');
                clearInterval(checkFirebaseSDK);
                initializeFirebase();
            } else if (attempts >= maxAttempts) {
                console.error('❌ Firebase SDK loading timeout');
                clearInterval(checkFirebaseSDK);
                errorCount++;
                
                const statusAlert = document.getElementById('firebaseStatusAlert');
                const statusText = document.getElementById('firebaseStatusText');
                
                if (statusAlert && statusText) {
                    statusAlert.className = 'alert alert-danger';
                    statusText.innerHTML = `
                        <strong>Firebase SDK loading timeout!</strong><br>
                        This usually indicates network or CDN issues.<br>
                        <button class="btn btn-sm btn-outline-light mt-2" onclick="window.location.reload()">
                            🔄 Refresh Page
                        </button>
                    `;
                }
                
                alert(`Firebase SDK loading timeout!

This usually indicates:
1. Network connectivity issues
2. Firebase CDN blocked by firewall
3. Browser security settings
4. Ad blocker interference

Solutions:
1. Check internet connection
2. Try refreshing the page
3. Disable ad blockers
4. Try a different browser/network

Current status:
- Firebase SDK loaded: ${typeof firebase !== 'undefined'}`);
            }
        }, 100);
    }
    
    // Set up form handler
    document.getElementById('loginForm').addEventListener('submit', handleLogin);
    
    console.log('🎯 Login page setup complete');
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