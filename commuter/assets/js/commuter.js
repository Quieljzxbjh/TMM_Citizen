// Commuter Portal JavaScript

document.addEventListener('DOMContentLoaded', function() {
    loadDemandForecast();
    loadAnnouncements();
});

function loadDemandForecast() {
    fetch('api/forecasts.php')
        .then(response => response.json())
        .then(data => {
            const forecastDiv = document.getElementById('demandForecast');
            if (data.length > 0) {
                let html = '<div class="row">';
                data.forEach(forecast => {
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6>${forecast.terminal_name}</h6>
                                    <div class="progress mb-2">
                                        <div class="progress-bar" style="width: ${forecast.utilization_rate}%"></div>
                                    </div>
                                    <small class="text-muted">${forecast.utilization_rate}% capacity</small>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                forecastDiv.innerHTML = html;
            } else {
                forecastDiv.innerHTML = '<p class="text-muted">No forecast data available</p>';
            }
        })
        .catch(error => {
            console.error('Error loading forecast:', error);
            document.getElementById('demandForecast').innerHTML = '<p class="text-danger">Error loading forecast data</p>';
        });
}

function loadAnnouncements() {
    fetch('api/announcements.php')
        .then(response => response.json())
        .then(data => {
            const announcementsDiv = document.getElementById('announcements');
            if (data.success && data.data.length > 0) {
                let html = '';
                data.data.slice(0, 3).forEach(announcement => {
                    const priorityClass = getPriorityClass(announcement.priority);
                    const categoryClass = announcement.priority === 'urgent' ? 'emergency' : 'advisory';
                    
                    html += `
                        <div class="announcement-item ${categoryClass} mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">${announcement.title}</h6>
                                <span class="announcement-priority ${priorityClass}">${announcement.priority}</span>
                            </div>
                            <p class="small mb-1">${announcement.content.substring(0, 100)}${announcement.content.length > 100 ? '...' : ''}</p>
                            <small class="text-muted">${new Date(announcement.created_at).toLocaleDateString()}</small>
                        </div>
                    `;
                });
                announcementsDiv.innerHTML = html;
            } else {
                announcementsDiv.innerHTML = '<p class="text-muted">No announcements</p>';
            }
        })
        .catch(error => {
            console.error('Error loading announcements:', error);
            document.getElementById('announcements').innerHTML = '<p class="text-danger">Error loading announcements</p>';
        });
}

function getPriorityClass(priority) {
    switch(priority) {
        case 'urgent':
        case 'high':
            return 'priority-high';
        default:
            return 'priority-normal';
    }
}