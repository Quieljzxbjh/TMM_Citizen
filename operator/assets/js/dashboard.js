// Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Load dashboard data
    loadDashboardStats();
    loadRecentViolations();
    loadUpcomingSchedules();

    // Set up auto-refresh every 5 minutes
    setInterval(function() {
        loadDashboardStats();
        loadRecentViolations();
        loadUpcomingSchedules();
    }, 300000);
});

function loadDashboardStats() {
    fetch('api/dashboard_stats.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('activeVehiclesCount').textContent = data.activeVehicles;
            document.getElementById('pendingViolationsCount').textContent = data.pendingViolations;
            document.getElementById('upcomingInspectionsCount').textContent = data.upcomingInspections;
            document.getElementById('franchiseStatus').textContent = data.franchiseStatus;
        })
        .catch(error => console.error('Error loading dashboard stats:', error));
}

function loadRecentViolations() {
    fetch('api/recent_violations.php')
        .then(response => response.json())
        .then(data => {
            const violationsHtml = data.map(violation => `
                <div class="violation-item mb-2">
                    <strong>${violation.date}</strong> - ${violation.type}
                    <span class="badge ${violation.status === 'Pending' ? 'bg-warning' : 'bg-success'}">${violation.status}</span>
                </div>
            `).join('');
            document.getElementById('recentViolations').innerHTML = violationsHtml || 'No recent violations';
        })
        .catch(error => console.error('Error loading recent violations:', error));
}

function loadUpcomingSchedules() {
    fetch('api/upcoming_schedules.php')
        .then(response => response.json())
        .then(data => {
            const schedulesHtml = data.map(schedule => `
                <div class="schedule-item mb-2">
                    <strong>${schedule.date}</strong> - ${schedule.type}
                    <span class="badge bg-info">${schedule.status}</span>
                </div>
            `).join('');
            document.getElementById('upcomingSchedules').innerHTML = schedulesHtml || 'No upcoming schedules';
        })
        .catch(error => console.error('Error loading upcoming schedules:', error));
}