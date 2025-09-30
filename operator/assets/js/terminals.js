// Load terminal assignments
function loadTerminals() {
    fetch('api/terminals.php')
        .then(response => response.json())
        .then(data => {
            // Render active terminals cards
            const activeTerminalsDiv = document.getElementById('activeTerminals');
            activeTerminalsDiv.innerHTML = '';

            const activeTerminals = data.filter(terminal => terminal.status === 'Active');
            activeTerminals.forEach(terminal => {
                const card = document.createElement('div');
                card.className = 'col-md-4 mb-4';
                card.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${terminal.terminal_name}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Code: ${terminal.terminal_code}</h6>
                            <p class="card-text">
                                <strong>Location:</strong> ${terminal.location}<br>
                                <strong>Operating Hours:</strong> ${terminal.operating_hours}<br>
                                <strong>Capacity:</strong> ${terminal.capacity} vehicles
                            </p>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: ${(terminal.occupied_slots / terminal.capacity) * 100}%">
                                    ${terminal.occupied_slots}/${terminal.capacity}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                activeTerminalsDiv.appendChild(card);
            });

            // Render terminals table
            const tableBody = document.querySelector('#terminalsTable tbody');
            tableBody.innerHTML = '';

            data.forEach(terminal => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${terminal.terminal_name}</td>
                    <td>${terminal.terminal_code}</td>
                    <td>${terminal.location}</td>
                    <td>${terminal.operating_hours}</td>
                    <td>${new Date(terminal.assigned_date).toLocaleDateString()}</td>
                    <td>
                        <span class="badge ${terminal.status === 'Active' ? 'bg-success' : 'bg-secondary'}">
                            ${terminal.status}
                        </span>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading terminals:', error));
}

// Initialize page
document.addEventListener('DOMContentLoaded', loadTerminals);