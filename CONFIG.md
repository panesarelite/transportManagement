# Configuration Guide

This document explains how to configure the Captain Dispatch Software system.
Developed by PanesarElite for professional transportation management.

## Hosting Configuration

### Current Setup
- **Testing URL**: https://panesarelite.com/site/final/captain/
- **Production URL**: pos.captaintransport.ca (planned)
- **Developer**: PanesarElite

### Subfolder Configuration
The system is configured to work in a subfolder environment. The `.htaccess` file includes:
```apache
RewriteBase /site/final/captain/
```

When moving to production domain, update:
1. Remove or modify the RewriteBase directive
2. Update Firebase authDomain in firebase-init.js
3. Update any absolute paths if needed

## Firebase Setup

### 1. Create Firebase Project
1. Go to https://console.firebase.google.com
2. Click "Create a project"
3. Follow the setup wizard
4. Enable Google Analytics (optional)

### 2. Enable Authentication
1. In Firebase Console, go to Authentication
2. Click "Get started"
3. Go to "Sign-in method" tab
4. Enable "Email/Password"
5. Disable "Email link (passwordless sign-in)" unless needed

### 3. Enable Firestore Database
1. Go to Firestore Database
2. Click "Create database"
3. Choose "Start in production mode"
4. Select a location (preferably close to your users)

### 4. Configure Web App
1. Go to Project Settings (gear icon)
2. Scroll to "Your apps" section
3. Click "Add app" and select Web
4. Register your app with a nickname
5. Copy the configuration object

### 5. Update Firebase Configuration
Edit `/assets/js/firebase-init.js` and replace the `firebaseConfig` object with your configuration:

```javascript
const firebaseConfig = {
  apiKey: "your-api-key",
  authDomain: "your-project.firebaseapp.com",
  projectId: "your-project-id",
  storageBucket: "your-project.appspot.com",
  messagingSenderId: "123456789",
  appId: "your-app-id"
};
```

### 6. Deploy Security Rules
1. Install Firebase CLI: `npm install -g firebase-tools`
2. Login: `firebase login`
3. Initialize project: `firebase init firestore`
4. Copy contents of `firebase.rules` to `firestore.rules`
5. Deploy: `firebase deploy --only firestore:rules`

### 7. Create Firestore Indexes
1. Copy contents of `firebase.indexes.json` to `firestore.indexes.json`
2. Deploy: `firebase deploy --only firestore:indexes`

## Google Maps Setup (Optional)

### 1. Get API Key
1. Go to https://console.cloud.google.com
2. Create a new project or select existing
3. Enable Maps JavaScript API and Places API
4. Create credentials (API key)
5. Restrict the API key to your domain

### 2. Update Map Integration
Edit the map loading code in tracking pages to include your API key:

```javascript
import { loadGoogleMapsAPI } from '/assets/js/map.js';
await loadGoogleMapsAPI('your-google-maps-api-key');
```

## User Setup

### 1. Create Admin User
1. Go to Firebase Console > Authentication
2. Click "Add user"
3. Enter email: `admin@yourcompany.com`
4. Set password
5. Note the User UID

### 2. Set Custom Claims
Use Firebase Admin SDK or Firebase CLI to set custom claims:

```javascript
// Using Admin SDK
await admin.auth().setCustomUserClaims(uid, {
  role: 'admin',
  companyRID: 'your-company-id'
});
```

### 3. Create Company Document
1. Go to Firestore Console
2. Create collection: `companies`
3. Create document with your company ID
4. Add company information fields

## Environment Configuration

### 1. Web Server
- **Apache**: Ensure mod_rewrite is enabled for `.htaccess`
- **Nginx**: Configure URL rewriting for clean URLs
- **PHP**: Version 7.4+ recommended

### 2. SSL Certificate
- Enable HTTPS for production
- Update Firebase Auth domain settings
- Configure secure cookies

### 3. Domain Configuration
- Update Firebase Auth authorized domains
- Configure CORS if needed
- Set up proper DNS records

## Company Onboarding

### 1. Create Company
1. Generate unique company RID
2. Create company document in Firestore
3. Set up initial admin user
4. Configure company profile

### 2. Add Users
1. Use the User Management interface
2. Assign appropriate roles
3. Set custom claims via Firebase Admin
4. Send login credentials securely

### 3. Seed Initial Data
1. Login as admin
2. Go to Company Profile
3. Click "Seed Sample Data"
4. Customize drivers, trucks, and settings

## Security Configuration

### 1. Firestore Rules
- Deploy the provided security rules
- Test with different user roles
- Monitor security rule usage

### 2. Authentication
- Configure password requirements
- Set up email verification if needed
- Configure session timeout

### 3. API Security
- Restrict Firebase API keys to your domain
- Use HTTPS only
- Implement rate limiting if needed

## Customization

### 1. Branding
- Update company logo in navigation
- Modify color scheme in `/assets/css/theme.css`
- Customize email templates

### 2. Menu Configuration
Edit `/assets/settings/leftmenu.json` to customize navigation:

```json
{
  "title": "Custom Page",
  "icon": "fa-solid fa-custom",
  "link": "/custom/page.php"
}
```

### 3. Role Permissions
Modify security rules and JavaScript role checks to customize permissions.

## Monitoring & Maintenance

### 1. Firebase Monitoring
- Set up Firebase Performance Monitoring
- Configure Crashlytics for error tracking
- Monitor authentication usage

### 2. Database Maintenance
- Regular backup of Firestore data
- Monitor query performance
- Clean up old dispatch data as needed

### 3. User Management
- Regular audit of user accounts
- Remove inactive users
- Update roles as needed

## Troubleshooting

### Common Issues

**Authentication not working:**
- Check Firebase configuration
- Verify custom claims are set
- Check browser console for errors

**Database access denied:**
- Verify security rules are deployed
- Check user has proper role and company RID
- Ensure user is authenticated

**Maps not loading:**
- Verify Google Maps API key
- Check API key restrictions
- Ensure required APIs are enabled

**Menu not loading:**
- Check `/assets/settings/leftmenu.json` syntax
- Verify file permissions
- Check browser console for errors

### Debug Mode
Add `?debug=true` to any URL to enable debug logging in browser console.

## Support

For technical support from PanesarElite:
1. Check browser console for errors
2. Verify Firebase configuration
3. Test with demo accounts
4. Contact PanesarElite development team with specific error messages

## Version History

- **v2.1.0**: Current version with full feature set (Developed by PanesarElite)
- **v2.0.0**: Major rewrite with Firebase v9
- **v1.x**: Legacy PHP/MySQL version