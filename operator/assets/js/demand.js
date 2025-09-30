// Load demand forecast data
function loadDemandData() {
    fetch('api/demand.php')
        .then(response => response.json())
        .then(data => {
            // Load alerts
            const alertsBody = document.querySelector('#alertsTable tbody');
            alertsBody.innerHTML = '';

            data.alerts.forEach(alert => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(alert.forecast_date).toLocaleDateString()}</td>
                    <td>${alert.terminal_name}</td>
                    <td>${alert.message}</td>
                    <td>
                        <span class="badge ${alert.is_read ? 'bg-secondary' : 'bg-warning'}">
                            ${alert.is_read ? 'Read' : 'New'}
                        </span>
                    </td>
                `;
                alertsBody.appendChild(row);
            });

            // Render capacity chart
            renderCapacityChart(data.capacity);

            // Render peak hours chart
            renderPeakHoursChart(data.capacity);
        })
        .catch(error => console.error('Error loading demand data:', error));
}

// Render terminal capacity chart
function renderCapacityChart(data) {
    const ctx = document.getElementById('capacityChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(item => item.terminal_name),
            datasets: [{
                label: 'Current Occupancy',
                data: data.map(item => item.occupied_slots),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Total Capacity',
                data: data.map(item => item.capacity),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Render peak hours chart
function renderPeakHoursChart(data) {
    const ctx = document.getElementById('peakHoursChart').getContext('2d');
    const peakHours = data.map(item => {
        const hours = JSON.parse(item.peak_hours);
        return {
            terminal: item.terminal_name,
            hours: hours
        };
    });

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: Array.from({length: 24}, (_, i) => `${i}:00`),
            datasets: peakHours.map(ph => ({
                label: ph.terminal,
                data: ph.hours,
                borderColor: getRandomColor(),
                fill: false
            }))
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Utilization Rate (%)'
                    }
                }
            }
        }
    });
}

// Generate random color for chart lines
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

// Initialize page
document.addEventListener('DOMContentLoaded', loadDemandData);