// Load applications data
function loadApplications() {
    fetch('api/franchise.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#applicationsTable tbody');
            tableBody.innerHTML = '';

            data.forEach(app => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(app.date_submitted).toLocaleDateString()}</td>
                    <td>${app.plate_number} (${app.vehicle_type})</td>
                    <td>${app.application_type}</td>
                    <td>
                        <span class="badge ${getBadgeClass(app.status)}">
                            ${app.status}
                        </span>
                    </td>
                    <td>
                        ${app.documents ? 
                            app.documents.split(',').map(doc => 
                                `<a href="${doc}" class="btn btn-sm btn-link" target="_blank">View</a>`
                            ).join(' ') : 
                            'No documents'
                        }
                    </td>
                    <td>
                        ${app.status === 'Pending' ? 
                            `<button class="btn btn-sm btn-outline-primary upload-doc" data-app-id="${app.application_id}">
                                Upload Document
                            </button>` : 
                            '-'
                        }
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Add event listeners
            document.querySelectorAll('.upload-doc').forEach(button => {
                button.addEventListener('click', () => {
                    // Handle document upload
                });
            });
        })
        .catch(error => console.error('Error loading applications:', error));
}

function getBadgeClass(status) {
    switch (status) {
        case 'Pending': return 'bg-warning';
        case 'Approved': return 'bg-success';
        case 'Rejected': return 'bg-danger';
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

// Submit new application
document.getElementById('submitApplication').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('applicationForm'));

    fetch('api/franchise.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('newApplicationModal')).hide();
            loadApplications();
        } else {
            alert('Error submitting application');
        }
    })
    .catch(error => console.error('Error submitting application:', error));
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    loadApplications();
    loadVehicles();
});