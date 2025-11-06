// Authentication module - Developed by PanesarElite
import { buildUrl } from './config.js';

console.log('🔐 Auth module loading - PanesarElite');

let currentUser = null;
let authInitialized = false;

// Initialize authentication system
export async function initializeAuth() {
    console.log('🔐 Initializing authentication system...');
    
    if (!window.firebaseAuth) {
        throw new Error('Firebase Auth not available');
    }
    
    const { onAuthStateChanged } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
    
    return new Promise((resolve) => {
        onAuthStateChanged(window.firebaseAuth, async (user) => {
            console.log('👤 Auth state changed:', user ? user.email : 'No user');
            
            if (user) {
                currentUser = user;
                console.log('✅ User authenticated:', user.email);
                
                // Try to get user profile
                try {
                    await loadUserProfile(user);
                } catch (error) {
                    console.error('❌ Error loading user profile:', error);
                    // Continue anyway - profile might not exist yet
                }
            } else {
                currentUser = null;
                console.log('❌ No authenticated user');
            }
            
            authInitialized = true;
            resolve(user);
        });
    });
}

// Load user profile from Firestore
async function loadUserProfile(user) {
    console.log('👤 Loading user profile for:', user.email);
    
    try {
        const { doc, getDoc } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js');
        
        // Try to find user in global users collection first
        let userRef = doc(window.firebaseDb, 'users', user.uid);
        let userDoc = await getDoc(userRef);
        
        if (userDoc.exists()) {
            const userData = userDoc.data();
            console.log('✅ User profile found in global collection:', userData);
            
            // Store user data globally
            window.currentUserData = userData;
            
            // Update top nav if available
            updateTopNavUser(userData);
            
            return userData;
        }
        
        // If not found in global, try company collection
        const companyRID = 'captain_transport_demo'; // Default for demo
        userRef = doc(window.firebaseDb, `companies/${companyRID}/users`, user.uid);
        userDoc = await getDoc(userRef);
        
        if (userDoc.exists()) {
            const userData = userDoc.data();
            console.log('✅ User profile found in company collection:', userData);
            
            window.currentUserData = userData;
            updateTopNavUser(userData);
            
            return userData;
        }
        
        console.warn('⚠️ User profile not found, creating basic profile...');
        
        // Create basic user profile
        const basicUserData = {
            uid: user.uid,
            email: user.email,
            displayName: user.displayName || user.email.split('@')[0],
            role: 'admin', // Default role for demo
            companyRID: 'captain_transport_demo',
            active: true,
            createdAt: new Date(),
            updatedAt: new Date()
        };
        
        // Save to global users collection
        const { setDoc, serverTimestamp } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js');
        await setDoc(doc(window.firebaseDb, 'users', user.uid), {
            ...basicUserData,
            createdAt: serverTimestamp(),
            updatedAt: serverTimestamp()
        });
        
        console.log('✅ Basic user profile created');
        window.currentUserData = basicUserData;
        
        return basicUserData;
        
    } catch (error) {
        console.error('❌ Error loading/creating user profile:', error);
        throw error;
    }
}

// Update top navigation with user info
function updateTopNavUser(userData) {
    const userNameEl = document.getElementById('topNavUserName');
    const userRoleEl = document.getElementById('topNavUserRole');
    
    if (userNameEl) {
        userNameEl.textContent = userData.displayName || userData.email;
    }
    
    if (userRoleEl) {
        userRoleEl.textContent = userData.role || 'User';
    }
}

// Login function
export async function login(email, password) {
    console.log('🔑 Attempting login for:', email);
    
    if (!window.firebaseAuth) {
        throw new Error('Firebase Auth not initialized');
    }
    
    try {
        const { signInWithEmailAndPassword } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
        
        console.log('📧 Signing in with Firebase Auth...');
        const userCredential = await signInWithEmailAndPassword(window.firebaseAuth, email, password);
        
        console.log('✅ Firebase Auth successful for:', userCredential.user.email);
        
        // Load user profile
        await loadUserProfile(userCredential.user);
        
        console.log('🎯 Login complete, redirecting to dashboard...');
        
        // Redirect to dashboard
        setTimeout(() => {
            window.location.href = buildUrl('/index.php');
        }, 500);
        
        return userCredential.user;
        
    } catch (error) {
        console.error('❌ Login failed:', error);
        
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
        throw new Error(errorMessage);
    }
}

// Logout function
export async function logout() {
    console.log('🚪 Logging out...');
    
    if (!window.firebaseAuth) {
        console.warn('⚠️ Firebase Auth not available for logout');
        window.location.href = buildUrl('/auth/login.php');
        return;
    }
    
    try {
        const { signOut } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
        await signOut(window.firebaseAuth);
        
        console.log('✅ Logout successful');
        currentUser = null;
        window.currentUserData = null;
        
        // Redirect to login
        window.location.href = buildUrl('/auth/login.php');
        
    } catch (error) {
        console.error('❌ Logout error:', error);
        alert('Logout failed: ' + error.message);
    }
}

// Register function
export async function register(email, password, userData) {
    console.log('📝 Registering new user:', email);
    
    if (!window.firebaseAuth) {
        throw new Error('Firebase Auth not initialized');
    }
    
    try {
        const { createUserWithEmailAndPassword } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-auth.js');
        const { doc, setDoc, serverTimestamp } = await import('https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js');
        
        // Create Firebase Auth user
        const userCredential = await createUserWithEmailAndPassword(window.firebaseAuth, email, password);
        console.log('✅ Firebase Auth user created');
        
        // Create user document
        const userDoc = {
            ...userData,
            uid: userCredential.user.uid,
            email: email,
            createdAt: serverTimestamp(),
            updatedAt: serverTimestamp()
        };
        
        // Save to global users collection
        await setDoc(doc(window.firebaseDb, 'users', userCredential.user.uid), userDoc);
        console.log('✅ User profile created');
        
        // Auto-login after registration
        currentUser = userCredential.user;
        window.currentUserData = userDoc;
        
        // Redirect to dashboard
        setTimeout(() => {
            window.location.href = buildUrl('/index.php');
        }, 500);
        
        return userCredential.user;
        
    } catch (error) {
        console.error('❌ Registration failed:', error);
        
        let errorMessage = 'Registration failed: ';
        
        switch (error.code) {
            case 'auth/email-already-in-use':
                errorMessage += 'An account with this email already exists.';
                break;
            case 'auth/weak-password':
                errorMessage += 'Password is too weak. Please use at least 6 characters.';
                break;
            case 'auth/invalid-email':
                errorMessage += 'Invalid email address format.';
                break;
            default:
                errorMessage += error.message;
        }
        
        alert(errorMessage);
        throw new Error(errorMessage);
    }
}

// Utility functions
export function getCurrentUser() {
    return currentUser;
}

export function getCurrentRole() {
    return window.currentUserData?.role || null;
}

export function getCurrentCompanyRID() {
    return window.currentUserData?.companyRID || 'captain_transport_demo';
}

export function isAuthInitialized() {
    return authInitialized;
}

export function hasRole(...roles) {
    const userRole = getCurrentRole();
    return roles.includes(userRole);
}

export function requireAuth() {
    if (!currentUser) {
        console.log('🔒 Authentication required, redirecting to login');
        window.location.href = buildUrl('/auth/login.php');
        return false;
    }
    return true;
}

console.log('✅ Auth module loaded - PanesarElite');