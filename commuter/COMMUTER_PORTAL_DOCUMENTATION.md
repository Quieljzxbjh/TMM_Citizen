# TMM Commuter Portal - System Documentation

## Overview
The TMM Commuter Portal is a public-facing web application that provides transparency and real-time transport information for Caloocan City commuters. It enables citizens to access route information, verify vehicle franchises, provide feedback, and stay updated with transport advisories.

## System Architecture

### Database Structure
```
┌─────────────────┐    ┌──────────────────────┐
│   citizen_db    │    │ transport_mobility_db│
│ (Commuter Data) │◄──►│   (Admin System)     │
└─────────────────┘    └──────────────────────┘
```

**citizen_db (Commuter Feedback Data):**
- commuter_complaints
- commuter_feedback

**transport_mobility_db (Read-Only Admin Data):**
- official_routes
- terminals
- terminal_capacity_tracking
- route_schedules
- route_waypoints
- franchise_records
- operators
- vehicles
- public_announcements

## Core Features & Data Flow

### 1. Real-Time Availability & Forecasts
**Process Flow:**
```
Load Dashboard → Fetch Terminal Capacity → Display Demand Forecast → Show Peak Hours
```

**API Endpoints:**
- `GET /api/forecasts.php` - Terminal capacity and demand data

**Data Flow:**
```
terminal_capacity_tracking → API → Dashboard Display
```

**Features:**
- Terminal occupancy rates
- Peak hour indicators
- Capacity utilization charts

### 2. Terminal & Route Information
**Process Flow:**
```
Browse Routes → Search by Origin/Destination → View Route Details → Check Schedules
```

**API Endpoints:**
- `GET /api/routes.php` - List all active routes with search
- `GET /api/terminals.php` - Terminal directory

**Data Sources:**
- official_routes (transport_mobility_db)
- terminals (transport_mobility_db)
- route_waypoints (transport_mobility_db)

**Features:**
- Route search by origin/destination
- Terminal directory with contact info
- Route waypoints and stops
- Fare and travel time information

### 3. Franchise Transparency
**Process Flow:**
```
Enter Plate Number → Verify in Database → Display Franchise Status → Show Operator Info
```

**API Endpoints:**
- `GET /api/franchise-check.php?plate={number}` - Verify vehicle franchise

**Data Flow:**
```
vehicles → franchise_records → operators → Franchise Status Display
```

**Features:**
- Vehicle registration verification
- Franchise validity checking
- Operator information display
- Expiry date warnings

### 4. Feedback & Grievances
**Process Flow:**
```
Select Vehicle → Rate Service (1-5 stars) → Submit Feedback → File Complaints
```

**API Endpoints:**
- `POST /api/feedback.php` - Submit service rating
- `POST /api/complaints.php` - File complaint

**Data Flow:**
```
User Input → Validate Vehicle → Store in citizen_db → Confirmation
```

**Features:**
- 5-star rating system
- Complaint categorization
- Anonymous feedback option
- Complaint tracking

### 5. Public Announcements
**Process Flow:**
```
Admin Creates Announcement → System Display → Priority-based Sorting → Auto-expiry
```

**API Endpoints:**
- `GET /api/announcements.php` - Active announcements

**Data Sources:**
- public_announcements (transport_mobility_db)

**Features:**
- LGU advisories
- Emergency alerts
- Priority-based display
- Category filtering (Advisory, Emergency, Update)

## Technical Implementation

### Frontend Architecture
```
commuter/
├── index.php              # Main portal dashboard
├── routes.php             # Route search and information
├── terminals.php          # Terminal directory
├── franchise-check.php    # Vehicle verification
├── feedback.php           # Rating and complaints
├── api/                   # Backend API endpoints
├── assets/
│   ├── css/commuter.css   # Main styling
│   └── js/                # Interactive functionality
```

### API Response Format
```json
{
    "success": true,
    "data": [...],
    "message": "Operation successful"
}
```

### Database Integration
```php
// Cross-database query example
$stmt = $transport_db->prepare("
    SELECT v.plate_number, f.franchise_number, o.first_name, o.last_name
    FROM vehicles v
    JOIN franchise_records f ON v.vehicle_id = f.vehicle_id
    JOIN operators o ON v.operator_id = o.operator_id
    WHERE v.plate_number = ?
");
```

## Security & Privacy

### Data Protection
- No personal data collection from commuters
- Anonymous feedback system
- Input validation and sanitization
- SQL injection prevention

### Access Control
- Public read-only access to transport data
- No authentication required for basic features
- Rate limiting on API endpoints

## Mobile Responsiveness

### Design Features
- Touch-friendly interface
- Responsive grid layouts
- Optimized search forms
- Mobile-first approach

### Performance Optimization
- Lazy loading for large datasets
- Cached API responses
- Compressed images and assets
- Minimal JavaScript footprint

## Integration Points

### Admin System Connection
- Real-time data sync from transport_mobility_db
- Automatic updates for route changes
- Franchise status synchronization

### Feedback Loop
```
Commuter Feedback → citizen_db → Admin Dashboard → Service Improvements
```

## Color Scheme & Branding

### Primary Colors
- **Green Theme:** `#059669` (Primary), `#10b981` (Light), `#047857` (Dark)
- **Complementary:** Blue `#0ea5e9` (Info), Orange `#f59e0b` (Warning), Red `#ef4444` (Danger)

### Visual Elements
- Hero section with background image
- Green gradient navigation
- Card-based information display
- Interactive hover effects

## API Documentation

### Routes API
```
GET /api/routes.php
Parameters:
- origin (optional): Filter by origin location
- destination (optional): Filter by destination location

Response: Array of route objects with fare, distance, and timing info
```

### Franchise Check API
```
GET /api/franchise-check.php?plate={number}
Parameters:
- plate: Vehicle plate number (required)

Response: Franchise status, operator info, and validity details
```

### Feedback API
```
POST /api/feedback.php
Body:
- plate_number: Vehicle plate
- rating: 1-5 star rating
- comments: Optional feedback text

Response: Success confirmation
```

## Deployment Checklist

### Prerequisites
- ✅ XAMPP with PHP 7.4+ and MySQL 5.7+
- ✅ transport_mobility_db with admin data
- ✅ citizen_db for feedback storage
- ✅ Web server configuration

### Setup Steps
1. Copy commuter portal files to web directory
2. Configure database connections
3. Set up background image in includes folder
4. Test all API endpoints
5. Verify mobile responsiveness

### Testing URLs
```
Main Portal: http://localhost/TMM_citizen/commuter/
Routes: http://localhost/TMM_citizen/commuter/routes.php
Franchise Check: http://localhost/TMM_citizen/commuter/franchise-check.php
Feedback: http://localhost/TMM_citizen/commuter/feedback.php
Terminals: http://localhost/TMM_citizen/commuter/terminals.php
```

## Maintenance & Updates

### Regular Tasks
- Monitor API performance
- Update announcement content
- Review feedback submissions
- Database cleanup and optimization

### Content Management
- Route information updates
- Terminal directory maintenance
- Announcement publishing
- Franchise record synchronization

## User Experience Features

### Search Functionality
- Real-time route search
- Auto-complete suggestions
- Clear and reset options
- Enter key support

### Interactive Elements
- 5-star rating system
- Hover animations
- Loading states
- Success/error notifications

### Accessibility
- Keyboard navigation support
- Screen reader compatibility
- High contrast colors
- Mobile touch targets

## Performance Metrics

### Target Benchmarks
- Page load time: < 3 seconds
- API response time: < 500ms
- Mobile performance score: > 90
- Accessibility score: > 95

## Support & Troubleshooting

### Common Issues
1. **Background image not loading** - Check image path and permissions
2. **API errors** - Verify database connections and table structure
3. **Search not working** - Check JavaScript console for errors
4. **Mobile display issues** - Clear browser cache and test responsive design

### Debug Information
```php
// Enable debugging in development
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

---

**System Status:** ✅ Production Ready
**Last Updated:** Current
**Version:** 1.0
**Target Audience:** Caloocan City Commuters
**Accessibility Level:** WCAG 2.1 AA Compliant