// Load inspection data
function loadInspections() {
    fetch('api/inspections.php')
        .then(response => response.json())
        .then(data => {
            // Load pending requests
            const requestsBody = document.querySelector('#requestsTable tbody');
            requestsBody.innerHTML = '';
            
            data.requests.forEach(request => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(request.requested_date).toLocaleDateString()}</td>
                    <td>${request.plate_number} (${request.vehicle_type})</td>
                    <td>
                        <span class="badge ${getBadgeClass(request.status)}">
                            ${request.status}
                        </span>
                    </td>
                    <td>
                        ${request.status === 'Pending' ? 
                            '<button class="btn btn-sm btn-outline-danger cancel-request">Cancel</button>' : 
                            '-'
                        }
                    </td>
                `;
                requestsBody.appendChild(row);
            });

            // Load inspection history
            const historyBody = document.querySelector('#historyTable tbody');
            historyBody.innerHTML = '';

            data.inspections.forEach(inspection => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(inspection.inspection_date).toLocaleDateString()}</td>
                    <td>${inspection.plate_number} (${inspection.vehicle_type})</td>
                    <td>${inspection.inspector_name}</td>
                    <td>
                        <span class="badge ${inspection.result === 'Pass' ? 'bg-success' : 'bg-danger'}">
                            ${inspection.result}
                        </span>
                    </td>
                    <td>
                        ${inspection.certificate_number ? 
                            `<a href="api/certificate.php?id=${inspection.inspection_id}" class="btn btn-sm btn-primary">
                                Download
                            </a>` : 
                            '-'
                        }
                    </td>
                `;
                historyBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading inspections:', error));
}

function getBadgeClass(status) {
    switch (status) {
        case 'Pending': return 'bg-warning';
        case 'Approved': return 'bg-success';
        case 'Completed': return 'bg-info';
        default: return 'bg-secondary';
    }
}

// Load vehicles for the dropdown
function loadVehicles() {
    fetch('api/vehicles.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('vehicle_id');
            select.innerHTML = '<option value="">Select a vehicle</option>';
            
            data.forEach(vehicle => {
                const option = document.createElement('option');
                option.value = vehicle.vehicle_id;
                option.textContent = `${vehicle.plate_number} - ${vehicle.make} ${vehicle.model}`;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading vehicles:', error));
}

// Submit inspection request
document.getElementById('submitRequest').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('inspectionRequestForm'));

    fetch('api/inspections.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('requestInspectionModal')).hide();
            loadInspections();
        } else {
            alert('Error submitting request');
        }
    })
    .catch(error => console.error('Error submitting request:', error));
});

// Set minimum date for request
document.getElementById('requested_date').min = new Date().toISOString().split('T')[0];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadInspections();
    loadVehicles();
});