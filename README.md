# TMM Citizen Portal System

## Overview
Transport Mobility Management (TMM) Citizen Portal System for Caloocan City - A comprehensive web-based platform providing transparency and efficiency in public transport management.

## System Components

### 🚌 Operator Portal
- **URL:** `http://localhost/TMM_citizen/operator/`
- **Purpose:** Vehicle operators management interface
- **Features:** Dashboard, vehicles, violations, franchise applications, inspections, demand forecasting, terminal assignments

### 🚍 Commuter Portal  
- **URL:** `http://localhost/TMM_citizen/commuter/`
- **Purpose:** Public-facing commuter information system
- **Features:** Route planning, franchise verification, feedback system, real-time updates, public announcements

## Quick Start

### Prerequisites
- XAMPP with PHP 7.4+ and MySQL 5.7+
- Web browser (Chrome, Firefox, Safari, Edge)

### Installation
1. Clone/download project to `C:\xampp\htdocs\TMM_citizen\`
2. Start XAMPP (Apache + MySQL)
3. Import database schema from `/includes/citizen_db.sql`
4. Access portals via localhost URLs above

### Database Setup
```sql
-- Import the citizen_db schema
SOURCE C:/xampp/htdocs/TMM_citizen/includes/citizen_db.sql;

-- Ensure transport_mobility_db exists (admin system)
-- This should be set up separately for full functionality
```

## Features

### Operator Portal Features
- ✅ **Dashboard:** Real-time statistics and activity overview
- ✅ **Vehicle Management:** Registration, tracking, maintenance
- ✅ **Violations:** View and contest traffic violations
- ✅ **Franchise Applications:** Submit and track applications
- ✅ **Inspections:** Schedule and manage vehicle inspections
- ✅ **Demand Forecasting:** Route demand analytics
- ✅ **Terminal Assignments:** Terminal allocation management

### Commuter Portal Features
- ✅ **Real-Time Information:** Terminal capacity and demand forecasting
- ✅ **Route Planning:** Search routes by origin/destination
- ✅ **Terminal Directory:** Official terminal locations and contacts
- ✅ **Franchise Verification:** Check vehicle registration status
- ✅ **Feedback System:** Rate services and file complaints
- ✅ **Public Announcements:** LGU advisories and emergency alerts

## Technical Stack

### Frontend
- **HTML5/CSS3** - Modern web standards
- **Bootstrap 5** - Responsive framework
- **JavaScript (ES6+)** - Interactive functionality
- **Font Awesome** - Icon library
- **Google Fonts (Inter)** - Typography

### Backend
- **PHP 7.4+** - Server-side logic
- **MySQL 5.7+** - Database management
- **PDO** - Database abstraction layer

### Design System
- **Color Scheme:** Green primary theme (`#059669`)
- **Typography:** Inter font family
- **Layout:** Mobile-first responsive design
- **Components:** Card-based interface with modern animations

## Database Architecture

### citizen_db (Local Database)
```
├── operator_profiles          # Operator information
├── operator_user_logs        # Activity tracking
├── violation_complaints      # Violation disputes
├── franchise_applications    # Application submissions
├── application_documents     # Document uploads
├── inspection_requests       # Inspection scheduling
├── demand_alerts            # Demand notifications
├── commuter_complaints      # Public complaints
└── commuter_feedback        # Service ratings
```

### transport_mobility_db (Admin System - External)
```
├── official_routes          # Route definitions
├── terminals               # Terminal information
├── terminal_capacity_tracking # Real-time capacity
├── route_schedules         # Schedule data
├── route_waypoints         # Route stops
├── franchise_records       # Official franchises
├── operators              # Operator registry
├── vehicles               # Vehicle registry
└── public_announcements   # System announcements
```

## API Endpoints

### Operator Portal APIs
- `/operator/api/dashboard_stats.php` - Dashboard statistics
- `/operator/api/vehicles.php` - Vehicle management
- `/operator/api/violations.php` - Violation data
- `/operator/api/franchise.php` - Franchise applications
- `/operator/api/inspections.php` - Inspection requests

### Commuter Portal APIs
- `/commuter/api/routes.php` - Route information
- `/commuter/api/terminals.php` - Terminal directory
- `/commuter/api/franchise-check.php` - Franchise verification
- `/commuter/api/feedback.php` - Service feedback
- `/commuter/api/complaints.php` - Complaint submission
- `/commuter/api/forecasts.php` - Demand forecasting
- `/commuter/api/announcements.php` - Public announcements

## Security Features

### Data Protection
- Input validation and sanitization
- SQL injection prevention (PDO prepared statements)
- XSS protection
- CSRF token implementation (recommended for production)

### Privacy
- Anonymous feedback system
- No personal data collection from commuters
- Secure operator session management

## Mobile Responsiveness

### Design Features
- Touch-friendly interface elements
- Responsive breakpoints for all screen sizes
- Optimized navigation for mobile devices
- Fast loading times on mobile networks

### Performance
- Compressed assets and images
- Lazy loading for large datasets
- Cached API responses
- Minimal JavaScript footprint

## Development Guidelines

### Code Standards
- PSR-4 autoloading standards
- Consistent naming conventions
- Comprehensive error handling
- Documented API responses

### File Structure
```
TMM_citizen/
├── includes/              # Shared components
│   ├── config.php        # Database configuration
│   ├── header.php        # Shared header
│   ├── sidebar.php       # Navigation sidebar
│   ├── footer.php        # Shared footer
│   └── citizen_db.sql    # Database schema
├── operator/             # Operator portal
│   ├── api/             # Backend APIs
│   ├── assets/          # CSS, JS, images
│   └── *.php            # Portal pages
├── commuter/            # Commuter portal
│   ├── api/             # Backend APIs
│   ├── assets/          # CSS, JS, images
│   └── *.php            # Portal pages
└── README.md            # This file
```

## Deployment

### Production Checklist
- [ ] Configure production database credentials
- [ ] Enable HTTPS/SSL certificates
- [ ] Set up proper file permissions
- [ ] Configure error logging
- [ ] Implement backup procedures
- [ ] Set up monitoring and analytics

### Environment Configuration
```php
// Production config example
$config = [
    'db_host' => 'production-server',
    'db_name' => 'tmm_production',
    'debug_mode' => false,
    'error_reporting' => false
];
```

## Contributing

### Development Setup
1. Fork the repository
2. Create feature branch (`git checkout -b feature/new-feature`)
3. Make changes and test thoroughly
4. Commit changes (`git commit -am 'Add new feature'`)
5. Push to branch (`git push origin feature/new-feature`)
6. Create Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write comprehensive comments
- Include error handling
- Test on multiple browsers and devices

## Support & Documentation

### Additional Documentation
- **Operator Portal:** `/operator/OPERATOR_PORTAL_DOCUMENTATION.md`
- **Commuter Portal:** `/commuter/COMMUTER_PORTAL_DOCUMENTATION.md`

### Troubleshooting
- Check XAMPP services are running
- Verify database connections
- Clear browser cache for CSS/JS updates
- Check PHP error logs for debugging

## License
This project is developed for Caloocan City Government transport management.

## Version History
- **v1.0** - Initial release with operator and commuter portals
- **Current Status:** ✅ Production Ready

---

**System URLs:**
- **Operator Portal:** `http://localhost/TMM_citizen/operator/`
- **Commuter Portal:** `http://localhost/TMM_citizen/commuter/`

**Last Updated:** Current  
**Compatibility:** PHP 7.4+, MySQL 5.7+, Modern Browsers