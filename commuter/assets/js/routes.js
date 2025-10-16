// Routes JavaScript

document.addEventListener('DOMContentLoaded', function() {
    loadRoutes();
    
    // Add Enter key support for search inputs
    document.getElementById('originInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRoutes();
        }
    });
    
    document.getElementById('destinationInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchRoutes();
        }
    });
});

function loadRoutes() {
    fetch('api/routes.php')
        .then(response => response.json())
        .then(data => {
            displayRoutes(data);
        })
        .catch(error => {
            console.error('Error loading routes:', error);
            document.getElementById('routesList').innerHTML = '<div class="alert alert-danger">Error loading routes</div>';
        });
}

function searchRoutes() {
    const origin = document.getElementById('originInput').value.trim();
    const destination = document.getElementById('destinationInput').value.trim();
    
    let url = 'api/routes.php';
    const params = new URLSearchParams();
    
    if (origin) {
        params.append('origin', origin);
    }
    
    if (destination) {
        params.append('destination', destination);
    }
    
    if (params.toString()) {
        url += '?' + params.toString();
    }
    
    document.getElementById('routesList').innerHTML = '<div class="loading">Searching routes...</div>';
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            displayRoutes(data);
        })
        .catch(error => {
            console.error('Error searching routes:', error);
            document.getElementById('routesList').innerHTML = '<div class="alert alert-danger">Error searching routes</div>';
        });
}

function displayRoutes(routes) {
    const routesDiv = document.getElementById('routesList');
    
    if (routes.length === 0) {
        routesDiv.innerHTML = '<div class="alert alert-info">No routes found matching your search</div>';
        return;
    }
    
    let html = '';
    
    routes.forEach(route => {
        html += `
            <div class="route-card mb-3" onclick="showRouteDetails(${route.route_id})">
                <div class="route-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="route-code">${route.route_code}</span>
                            <h5 class="mb-1 mt-2">${route.route_name}</h5>
                        </div>
                        <div class="text-end">
                            <div class="route-fare">₱${route.fare_amount}</div>
                            <small class="text-muted">${route.estimated_travel_time} mins</small>
                        </div>
                    </div>
                </div>
                
                <div class="route-details">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">From:</small><br>
                            <strong>${route.origin}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">To:</small><br>
                            <strong>${route.destination}</strong>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <small class="text-muted">Distance: ${route.distance_km} km</small>
                    </div>
                </div>
            </div>
        `;
    });
    
    routesDiv.innerHTML = html;
}

function showRouteDetails(routeId) {
    // Show modal with route details
    const modal = new bootstrap.Modal(document.getElementById('routeModal'));
    document.getElementById('routeDetails').innerHTML = '<div class="loading">Loading route details...</div>';
    modal.show();
    
    // Load route details (waypoints, schedules)
    fetch(`api/route-details.php?id=${routeId}`)
        .then(response => response.json())
        .then(data => {
            displayRouteDetails(data);
        })
        .catch(error => {
            console.error('Error loading route details:', error);
            document.getElementById('routeDetails').innerHTML = '<div class="alert alert-danger">Error loading route details</div>';
        });
}

function displayRouteDetails(data) {
    const detailsDiv = document.getElementById('routeDetails');
    
    let html = `
        <h6>Route Information</h6>
        <table class="table table-sm">
            <tr><td><strong>Route:</strong></td><td>${data.route_name}</td></tr>
            <tr><td><strong>Code:</strong></td><td>${data.route_code}</td></tr>
            <tr><td><strong>Distance:</strong></td><td>${data.distance_km} km</td></tr>
            <tr><td><strong>Travel Time:</strong></td><td>${data.estimated_travel_time} minutes</td></tr>
            <tr><td><strong>Fare:</strong></td><td>₱${data.fare_amount}</td></tr>
        </table>
    `;
    
    if (data.waypoints && data.waypoints.length > 0) {
        html += `
            <h6 class="mt-4">Route Stops</h6>
            <ol class="list-group list-group-numbered">
        `;
        
        data.waypoints.forEach(waypoint => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">${waypoint.waypoint_name}</div>
                        ${waypoint.is_terminal ? '<small class="text-primary">Terminal</small>' : ''}
                    </div>
                </li>
            `;
        });
        
        html += '</ol>';
    }
    
    detailsDiv.innerHTML = html;
}

function clearSearch() {
    document.getElementById('originInput').value = '';
    document.getElementById('destinationInput').value = '';
    loadRoutes();
}