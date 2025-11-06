// Configuration management - Developed by PanesarElite
// Centralized configuration for easy deployment changes

console.log('⚙️ Loading configuration - PanesarElite');

// CHANGE THIS PATH FOR DIFFERENT HOSTING ENVIRONMENTS
export const CONFIG = {
    // Current subfolder hosting
    BASE_PATH: '/site/final/captain',
    
    // For production domain (change to this when moving to pos.captaintransport.ca)
    // BASE_PATH: '',
    
    // Firebase configuration
    FIREBASE: {
  apiKey: "AIzaSyAp2XMMtts117nO7vRZxuU-rn10Fx6cPRo",
  authDomain: "dispatch-management-pec.firebaseapp.com",
  databaseURL: "https://dispatch-management-pec-default-rtdb.firebaseio.com",
  projectId: "dispatch-management-pec",
  storageBucket: "dispatch-management-pec.appspot.com",
  messagingSenderId: "935397115682",
  appId: "1:935397115682:web:4fcb5fde4467265a9b077b",
  measurementId: "G-0KZKQ1YC4M"
    },
    
    // Google Maps API key (optional)
    GOOGLE_MAPS_API_KEY: '',
    
    // Company settings
    COMPANY: {
        defaultTimezone: "America/Edmonton",
        defaultCountry: "Canada",
        defaultCompanyRID: "captain_transport_demo"
    },
    
    // Debug settings
    DEBUG: {
        enabled: true,
        logLevel: 'verbose'
    }
};

// Helper function to build URLs with correct base path
export function buildUrl(path) {
    // Remove leading slash if present
    const cleanPath = path.startsWith('/') ? path.substring(1) : path;
    
    // Handle empty path
    if (!cleanPath) {
        return CONFIG.BASE_PATH || '/';
    }
    
    const fullPath = CONFIG.BASE_PATH ? `${CONFIG.BASE_PATH}/${cleanPath}` : `/${cleanPath}`;
    
    console.log(`🔗 Building URL: "${path}" -> "${fullPath}"`);
    return fullPath;
}

// Helper function for absolute URLs
export function getAbsoluteUrl(path) {
    const baseUrl = window.location.origin;
    const fullPath = buildUrl(path);
    return `${baseUrl}${fullPath}`;
}

// Debug logging function
export function debugLog(message, data = null) {
    if (CONFIG.DEBUG.enabled) {
        console.log(`🐛 [DEBUG] ${message}`, data || '');
    }
}

// Get current environment info
export function getEnvironmentInfo() {
    return {
        basePath: CONFIG.BASE_PATH,
        currentUrl: window.location.href,
        origin: window.location.origin,
        pathname: window.location.pathname,
        isSubfolder: !!CONFIG.BASE_PATH,
        isProduction: !CONFIG.BASE_PATH
    };
}

console.log('✅ Configuration loaded - PanesarElite');
console.log('🌐 Base path:', CONFIG.BASE_PATH);
console.log('🔧 Environment:', getEnvironmentInfo());