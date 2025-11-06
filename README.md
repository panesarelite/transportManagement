# Captain Dispatch Software

A comprehensive dispatch management system designed specifically for the Canadian transportation industry, built with PHP, Bootstrap 5, and Firebase. Developed by PanesarElite.

## Developer Information

**Developed by**: PanesarElite  
**Current Hosting**: https://panesarelite.com/site/final/captain/  
**Production Domain**: pos.captaintransport.ca (planned)  
**Version**: 2.1.0  

## Features

### Core Dispatch Management
- **Daily Sharded Structure**: Efficient Firestore organization by date (`/customer-management/customers/{companyRID}/departments/dispatch/{year}/{month}/{day}/dispatches/{id}`)
- **Multi-Day Dispatches**: Support for complex, multi-day transportation schedules
- **Canadian Specialization**: Edmonton timezone, dangerous goods classification, reefer transport
- **Real-Time Tracking**: Live GPS location sharing and route visualization
- **Status Management**: Complete workflow from creation to completion

### Role-Based Access Control
- **Admin**: Full system access, user management, company settings
- **Dispatcher**: Dispatch creation, assignment, tracking, management
- **Customer**: View dispatches, track shipments, limited access
- **Driver**: Mobile-friendly tracking, status updates, location sharing
- **Accountant**: Read-only access for billing and reporting

### Advanced Features
- **Google Maps Integration**: Route planning and live tracking
- **CSV Export**: Comprehensive data export capabilities
- **Responsive Design**: Mobile-first approach with Bootstrap 5.3
- **Security**: Firebase Auth with custom claims and Firestore security rules
- **Canadian Compliance**: Dangerous goods classification, provincial regulations

## Technology Stack

- **Frontend**: PHP includes + Bootstrap 5.3 + Vanilla JavaScript ES6 modules
- **Backend**: Firebase v9 (Authentication + Firestore)
- **Maps**: Google Maps JavaScript API
- **Icons**: Font Awesome 6
- **Styling**: Custom CSS with Captain Transport branding

## Quick Start

### 1. Environment Setup
```bash
# For subfolder testing at panesarelite.com/site/final/captain/
# Upload files to web server with PHP support

# Start PHP development server
php -S localhost:8000

# Or use any web server (Apache, Nginx)
```

### 2. Firebase Configuration
1. Create a Firebase project at https://console.firebase.google.com
2. Enable Authentication (Email/Password)
3. Add panesarelite.com to authorized domains
3. Enable Firestore Database
4. Update `/assets/js/firebase-init.js` with your config
5. Deploy the security rules from `firebase.rules`
6. Create the indexes from `firebase.indexes.json`

### 3. Google Maps Setup (Optional)
1. Get a Google Maps API key
2. Enable Maps JavaScript API and Places API
3. Update the map integration in tracking pages

### 4. Demo Data
1. Visit `https://panesarelite.com/site/final/captain/auth/login.php`
2. Login with: `admin@captaintransport.com` / `admin123`
3. Go to Company Profile and click "Seed Sample Data"

## Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@captaintransport.com | admin123 |
| Dispatcher | dispatcher@captaintransport.com | dispatch123 |
| Driver | driver@captaintransport.com | driver123 |
| Customer | customer@captaintransport.com | customer123 |
| Accountant | accountant@captaintransport.com | account123 |

## File Structure

```
/
├── index.php                 # Dashboard
├── auth/
│   ├── login.php            # Login page
│   └── logout.php           # Logout handler
├── dispatch/
│   ├── new-dispatch.php     # Create/edit dispatches
│   ├── dispatch-list.php    # List all dispatches
│   ├── dispatch-assign.php  # Driver/truck assignment
│   ├── dispatch-management.php # Status & notes management
│   └── dispatch-tracking.php   # Live tracking & maps
├── admin/
│   ├── users.php            # User management
│   └── company-profile.php  # Company settings
├── customer-php/
│   ├── header.php           # HTML head
│   ├── top-nav-bar.php      # Navigation bar
│   ├── menu.php             # Sidebar menu
│   └── footer.php           # Footer & scripts
├── assets/
│   ├── js/
│   │   ├── firebase-init.js # Firebase configuration
│   │   ├── auth.js          # Authentication logic
│   │   ├── dao.js           # Data access layer
│   │   ├── ui.js            # UI utilities
│   │   ├── map.js           # Google Maps integration
│   │   ├── validators.js    # Form validation
│   │   ├── utils-timezone.js # Timezone utilities
│   │   └── seed.js          # Sample data seeding
│   ├── css/
│   │   └── theme.css        # Custom styling
│   └── settings/
│       ├── leftmenu.json    # Menu configuration
│       └── config.sample.json # Configuration template
├── firebase.rules           # Firestore security rules
├── firebase.indexes.json    # Firestore indexes
└── .htaccess               # Apache configuration
```

## Key Features Explained

### Daily Sharding
The system uses a daily sharding structure for optimal Firestore performance:
```
/customer-management/customers/{companyRID}/departments/dispatch/{year}/{month}/{day}/dispatches/{id}
```

This allows for:
- Efficient date-range queries
- Automatic data organization
- Scalable architecture
- Easy backup and archival

### Role-Based Security
Firebase security rules enforce strict access control:
- Users can only access their company's data
- Role-based permissions for different operations
- Secure API endpoints with authentication

### Canadian Transportation Focus
- **Dangerous Goods**: Full classification system (Classes 1-9)
- **Reefer Transport**: Temperature-controlled cargo support
- **Provincial Compliance**: Canadian provinces and territories
- **Timezone Handling**: Proper Edmonton/Mountain time support

## Development

### Adding New Features
1. Create new PHP pages in appropriate directories
2. Add JavaScript modules in `/assets/js/`
3. Update menu configuration in `/assets/settings/leftmenu.json`
4. Update Firebase security rules if needed

### Database Operations
All database operations go through `/assets/js/dao.js` for consistency and security.

### UI Components
Use the utility functions in `/assets/js/ui.js` for consistent user experience.

## Security Considerations

- All Firebase operations require authentication
- Role-based access control at database level
- Input validation on both client and server
- Secure session management
- HTTPS recommended for production

## Production Deployment

1. **Web Server**: Deploy to Apache/Nginx with PHP support
2. **Firebase**: Configure production Firebase project
3. **SSL**: Enable HTTPS for security
4. **Environment**: Set up proper environment variables
5. **Monitoring**: Configure Firebase monitoring and alerts

## Support

For technical support or feature requests, contact PanesarElite development team.

## License

Proprietary software for Captain Transport and authorized partners.  
**Developed by PanesarElite** - Professional software development services.