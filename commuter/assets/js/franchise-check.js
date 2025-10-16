// Franchise Check JavaScript

document.getElementById('franchiseCheckForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const plateNumber = document.getElementById('plateNumber').value.trim();
    if (!plateNumber) {
        alert('Please enter a plate number');
        return;
    }
    
    checkFranchise(plateNumber);
});

function checkFranchise(plateNumber) {
    const resultsDiv = document.getElementById('franchiseResults');
    resultsDiv.innerHTML = '<div class="loading">Checking franchise status...</div>';
    
    fetch(`api/franchise-check.php?plate=${encodeURIComponent(plateNumber)}`)
        .then(response => response.json())
        .then(data => {
            displayFranchiseResults(data);
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<div class="alert alert-danger">Error checking franchise status</div>';
        });
}

function displayFranchiseResults(data) {
    const resultsDiv = document.getElementById('franchiseResults');
    
    if (!data.found) {
        resultsDiv.innerHTML = `
            <div class="franchise-result franchise-invalid">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Vehicle Not Found</h5>
                    <p>The plate number you entered is not registered in our system.</p>
                </div>
            </div>
        `;
        return;
    }
    
    const vehicle = data.vehicle;
    const statusClass = data.valid ? 'franchise-valid' : 
                       (data.status_message.includes('expired') ? 'franchise-expired' : 'franchise-invalid');
    const statusIcon = data.valid ? 'fa-check-circle text-success' : 'fa-times-circle text-danger';
    
    resultsDiv.innerHTML = `
        <div class="franchise-result ${statusClass}">
            <div class="d-flex align-items-center mb-3">
                <i class="fas ${statusIcon} me-2 fs-4"></i>
                <h5 class="mb-0">${data.status_message}</h5>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <h6>Vehicle Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Plate Number:</strong></td><td>${vehicle.plate_number}</td></tr>
                        <tr><td><strong>Type:</strong></td><td>${vehicle.vehicle_type}</td></tr>
                        <tr><td><strong>Make/Model:</strong></td><td>${vehicle.make} ${vehicle.model}</td></tr>
                        <tr><td><strong>Capacity:</strong></td><td>${vehicle.seating_capacity} passengers</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Operator Information</h6>
                    <table class="table table-sm">
                        <tr><td><strong>Name:</strong></td><td>${vehicle.first_name} ${vehicle.last_name}</td></tr>
                        <tr><td><strong>Contact:</strong></td><td>${vehicle.contact_number || 'N/A'}</td></tr>
                        ${vehicle.franchise_number ? `<tr><td><strong>Franchise #:</strong></td><td>${vehicle.franchise_number}</td></tr>` : ''}
                        ${vehicle.expiry_date ? `<tr><td><strong>Expires:</strong></td><td>${new Date(vehicle.expiry_date).toLocaleDateString()}</td></tr>` : ''}
                    </table>
                </div>
            </div>
            
            ${vehicle.route_name ? `<div class="mt-3"><strong>Assigned Route:</strong> ${vehicle.route_name}</div>` : ''}
        </div>
    `;
}