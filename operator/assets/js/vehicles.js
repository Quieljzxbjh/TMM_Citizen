// Load vehicles data
function loadVehicles() {
    fetch('api/vehicles.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#vehiclesTable tbody');
            tableBody.innerHTML = '';

            data.forEach(vehicle => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${vehicle.plate_number}</td>
                    <td>${vehicle.vehicle_type}</td>
                    <td>${vehicle.make} ${vehicle.model}</td>
                    <td>${vehicle.year_manufactured}</td>
                    <td>${vehicle.seating_capacity}</td>
                    <td>
                        <span class="badge ${vehicle.status === 'Active' ? 'bg-success' : 'bg-danger'}">
                            ${vehicle.status}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary edit-vehicle" data-vehicle-id="${vehicle.vehicle_id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-vehicle" data-vehicle-id="${vehicle.vehicle_id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Add event listeners
            document.querySelectorAll('.edit-vehicle').forEach(button => {
                button.addEventListener('click', () => {
                    // Handle edit
                });
            });

            document.querySelectorAll('.delete-vehicle').forEach(button => {
                button.addEventListener('click', () => {
                    // Handle delete
                });
            });
        })
        .catch(error => console.error('Error loading vehicles:', error));
}

// Save new vehicle
document.getElementById('saveVehicle')?.addEventListener('click', function() {
    const formData = {
        plate_number: document.getElementById('plate_number').value,
        vehicle_type: document.getElementById('vehicle_type').value,
        make: document.getElementById('make').value,
        model: document.getElementById('model').value,
        year_manufactured: document.getElementById('year').value,
        seating_capacity: document.getElementById('capacity').value
    };

    fetch('api/vehicles.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            document.getElementById('vehicleForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('addVehicleModal')).hide();
            loadVehicles();
        } else {
            alert('Error adding vehicle');
        }
    })
    .catch(error => console.error('Error:', error));
});

// Initialize page
document.addEventListener('DOMContentLoaded', loadVehicles);