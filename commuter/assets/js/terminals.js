// Terminals JavaScript

document.addEventListener('DOMContentLoaded', function() {
    loadTerminals();
});

function loadTerminals() {
    fetch('api/terminals.php')
        .then(response => response.json())
        .then(data => {
            displayTerminals(data);
        })
        .catch(error => {
            console.error('Error loading terminals:', error);
            document.getElementById('terminalsList').innerHTML = '<div class="alert alert-danger">Error loading terminals</div>';
        });
}

function displayTerminals(terminals) {
    const terminalsDiv = document.getElementById('terminalsList');
    
    if (terminals.length === 0) {
        terminalsDiv.innerHTML = '<div class="alert alert-info">No terminals found</div>';
        return;
    }
    
    let html = '<div class="row">';
    
    terminals.forEach(terminal => {
        const occupancyRate = terminal.current_occupancy && terminal.capacity ? 
            Math.round((terminal.current_occupancy / terminal.capacity) * 100) : 0;
        
        const statusClass = occupancyRate > 80 ? 'full' : 'active';
        const statusText = occupancyRate > 80 ? 'High Occupancy' : 'Available';
        
        html += `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="terminal-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="mb-0">${terminal.terminal_name}</h5>
                        <span class="terminal-status ${statusClass}">${statusText}</span>
                    </div>
                    
                    <div class="mb-2">
                        <strong>Code:</strong> ${terminal.terminal_code}
                    </div>
                    
                    <div class="mb-2">
                        <strong>Location:</strong> ${terminal.location}
                    </div>
                    
                    ${terminal.address ? `<div class="mb-2"><strong>Address:</strong> ${terminal.address}</div>` : ''}
                    
                    <div class="mb-2">
                        <strong>Capacity:</strong> ${terminal.capacity} vehicles
                    </div>
                    
                    ${terminal.current_occupancy ? `
                        <div class="mb-2">
                            <strong>Current Occupancy:</strong> ${terminal.current_occupancy}/${terminal.capacity}
                            <div class="progress mt-1">
                                <div class="progress-bar" style="width: ${occupancyRate}%"></div>
                            </div>
                        </div>
                    ` : ''}
                    
                    <div class="mb-2">
                        <strong>Operating Hours:</strong> ${terminal.operating_hours || 'Not specified'}
                    </div>
                    
                    ${terminal.contact_person ? `
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted">
                                <strong>Contact:</strong> ${terminal.contact_person}<br>
                                ${terminal.contact_number ? `<strong>Phone:</strong> ${terminal.contact_number}` : ''}
                            </small>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    terminalsDiv.innerHTML = html;
}