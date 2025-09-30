# TMM Operator Portal - System Documentation

## Overview
The TMM Operator Portal is a web-based system that allows transport operators (drivers, franchise holders) to manage compliance, monitor official records, and communicate with the LGU transport management system.

## System Architecture

### Database Structure
```
┌─────────────────┐    ┌──────────────────────┐
│   citizen_db    │    │ transport_mobility_db│
│   (Local Data)  │◄──►│   (Admin System)     │
└─────────────────┘    └──────────────────────┘
```

**citizen_db (Local Operator Data):**
- operator_profiles
- operator_user_logs
- violation_complaints
- franchise_applications
- application_documents
- inspection_requests
- demand_alerts

**transport_mobility_db (Admin System Integration):**
- operators
- vehicles
- franchise_records
- violation_history
- inspection_records
- terminals
- terminal_assignments

## Core Features & Data Flow

### 1. Profile Dashboard
**Process Flow:**
```
User Login → Session Check → Load Dashboard Stats → Display Real-time Data
```

**API Endpoints:**
- `GET /api/profile.php` - Fetch operator profile
- `GET /api/dashboard_stats.php` - Get dashboard statistics
- `POST /api/operator/{id}/log` - Record login/logout

**Data Flow:**
```
Frontend → API → transport_mobility_db → JSON Response → Dashboard Display
```

### 2. Vehicle Management
**Process Flow:**
```
Load Vehicles → Display Table → Add/Edit Vehicle → Update Database
```

**API Endpoints:**
- `GET /api/vehicles.php` - Fetch operator vehicles
- `POST /api/vehicles.php` - Add new vehicle

**Data Sources:**
- vehicles (transport_mobility_db)
- franchise_records (transport_mobility_db)

### 3. Violation Management
**Process Flow:**
```
View Violations → File Complaint → Track Status → Resolution
```

**API Endpoints:**
- `GET /api/violations.php` - Fetch violations
- `POST /api/violations.php` - File complaint

**Data Flow:**
```
violation_history (admin_db) → Display → Complaint → violation_complaints (citizen_db)
```

### 4. Franchise Applications
**Process Flow:**
```
New Application → Upload Documents → Submit → Track Status → Approval
```

**API Endpoints:**
- `GET /api/franchise.php` - List applications
- `POST /api/franchise.php` - Submit application
- `POST /api/franchise/{id}/upload` - Upload documents

**Data Flow:**
```
Application Form → franchise_applications (citizen_db) → Admin Review → franchise_records (admin_db)
```

### 5. Inspection Scheduling
**Process Flow:**
```
Request Inspection → Select Date → Submit → Admin Approval → Schedule → Complete
```

**API Endpoints:**
- `GET /api/inspections.php` - List requests/history
- `POST /api/inspections.php` - Submit request

**Data Flow:**
```
Request → inspection_requests (citizen_db) → Admin → inspection_records (admin_db)
```

### 6. Demand Forecast Alerts
**Process Flow:**
```
Admin Creates Alert → System Notification → Operator Views → Mark as Read
```

**API Endpoints:**
- `GET /api/demand.php` - Fetch alerts
- `PATCH /api/alerts/{id}/read` - Mark as read

### 7. Terminal Assignments
**Process Flow:**
```
Admin Assigns Terminal → Operator Views Assignment → Terminal Details
```

**API Endpoints:**
- `GET /api/terminals.php` - Fetch assignments

## Integration Points

### Session Management
```php
// Session-based authentication
$operator_id = $_SESSION['operator_id'] ?? null;
```

### Cross-Database Queries
```php
// Example: Violations with complaints
$stmt = $transport_db->prepare("
    SELECT vh.*, vc.complaint_id, vc.status as complaint_status
    FROM violation_history vh
    LEFT JOIN citizen_db.violation_complaints vc 
        ON vh.violation_id = vc.violation_id 
    WHERE vh.operator_id = ?
");
```

### API Response Format
```json
{
    "success": true,
    "data": [...],
    "message": "Operation successful"
}
```

## Security Implementation

### Authentication
- Session-based operator authentication
- Operator ID validation on all API calls

### Data Protection
- Prepared statements for SQL injection prevention
- Input validation and sanitization
- Error handling without data exposure

### Access Control
```php
if (!$operator_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}
```

## File Structure
```
operator/
├── api/                    # API endpoints
│   ├── dashboard_stats.php
│   ├── vehicles.php
│   ├── violations.php
│   ├── franchise.php
│   ├── inspections.php
│   ├── terminals.php
│   └── demand.php
├── assets/
│   ├── css/style.css      # Responsive styling
│   └── js/                # Frontend logic
├── includes/
│   ├── config.php         # Database connections
│   ├── header.php         # Navigation header
│   └── sidebar.php        # Navigation sidebar
├── dashboard.php          # Main dashboard
├── vehicles.php           # Vehicle management
├── violations.php         # Violation tracking
├── franchise.php          # Franchise applications
├── inspections.php        # Inspection scheduling
├── terminals.php          # Terminal assignments
└── demand.php            # Demand forecasts
```

## Mobile Responsiveness

### Table Optimization
- Sticky first column for key data
- Hidden non-essential columns on mobile
- Reduced font sizes and padding
- Horizontal scroll prevention

### Touch-Friendly Interface
- Larger touch targets (12px+ padding)
- Stacked button layouts
- Optimized form controls

## Integration Checklist

### Prerequisites
- ✅ transport_mobility_db exists with admin data
- ✅ Web server with PHP 7.4+
- ✅ MySQL 5.7+
- ✅ Session management configured

### Deployment Steps
1. Copy operator portal files to web directory
2. Configure database connections in config.php
3. Run initial database setup (creates citizen_db)
4. Set up session integration with main system
5. Configure operator authentication flow

### Testing Endpoints
```bash
# Test API endpoints
GET /operator/api/profile.php
GET /operator/api/vehicles.php
GET /operator/api/violations.php
POST /operator/api/franchise.php
```

## Data Synchronization

### Real-time Updates
- Dashboard stats refresh every 5 minutes
- Violation status updates from admin system
- Inspection results sync from admin system

### Batch Operations
- Daily demand forecast alerts
- Weekly compliance reports
- Monthly franchise renewals

## Error Handling

### API Errors
```php
try {
    // Database operations
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}
```

### Frontend Error Display
```javascript
.catch(error => {
    console.error('Error:', error);
    alert('Operation failed. Please try again.');
});
```

## Performance Considerations

### Database Optimization
- Indexed foreign keys
- Prepared statements
- Connection pooling

### Frontend Optimization
- Lazy loading for large datasets
- Pagination for tables
- Cached API responses

## Maintenance

### Regular Tasks
- Database backup and cleanup
- Log file rotation
- Session cleanup
- Security updates

### Monitoring
- API response times
- Database connection health
- Error rate tracking
- User activity logs

## Support & Troubleshooting

### Common Issues
1. **Session timeout** - Check session configuration
2. **Database connection** - Verify credentials and server status
3. **API errors** - Check error logs and database connectivity
4. **Mobile display** - Clear browser cache and check CSS

### Debug Mode
```php
// Enable in config.php for development
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

**System Status:** ✅ Ready for Production Integration
**Last Updated:** Current
**Version:** 1.0