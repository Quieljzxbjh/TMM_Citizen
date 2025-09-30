# TMM Commuter Portal

## Quick Start Guide

### Access URLs
- **Main Portal:** `http://localhost/TMM_citizen/commuter/`
- **Routes & Schedules:** `http://localhost/TMM_citizen/commuter/routes.php`
- **Terminal Directory:** `http://localhost/TMM_citizen/commuter/terminals.php`
- **Franchise Check:** `http://localhost/TMM_citizen/commuter/franchise-check.php`
- **Feedback & Complaints:** `http://localhost/TMM_citizen/commuter/feedback.php`

## Features

### 🚌 Real-Time Information
- Terminal capacity tracking
- Demand forecasting
- Peak hour indicators

### 🗺️ Route Planning
- Search routes by origin/destination
- View route details and waypoints
- Check schedules and fares

### 🔍 Franchise Verification
- Verify vehicle registration
- Check operator information
- Validate franchise status

### ⭐ Feedback System
- Rate service quality (1-5 stars)
- File complaints by category
- Anonymous feedback option

### 📢 Public Announcements
- LGU advisories and updates
- Emergency alerts
- Priority-based notifications

## Technical Stack
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend:** PHP 7.4+, MySQL 5.7+
- **Database:** citizen_db, transport_mobility_db
- **Styling:** Green color theme with responsive design

## Setup Requirements
1. XAMPP with Apache and MySQL running
2. Database setup (citizen_db and transport_mobility_db)
3. Background image in `/includes/image.png`
4. Proper file permissions

## API Endpoints
- `/api/routes.php` - Route information and search
- `/api/terminals.php` - Terminal directory
- `/api/franchise-check.php` - Vehicle verification
- `/api/feedback.php` - Service ratings
- `/api/complaints.php` - Complaint submission
- `/api/forecasts.php` - Demand forecasting
- `/api/announcements.php` - Public announcements

## Documentation
See `COMMUTER_PORTAL_DOCUMENTATION.md` for detailed technical documentation.

## Support
For technical issues or questions, refer to the troubleshooting section in the main documentation.