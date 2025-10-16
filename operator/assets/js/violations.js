// Load violations data
function loadViolations() {
    fetch('api/violations.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#violationsTable tbody');
            tableBody.innerHTML = '';

            data.forEach(violation => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(violation.date_issued).toLocaleDateString()}</td>
                    <td>${violation.plate_number}</td>
                    <td>${violation.violation_type}</td>
                    <td>${violation.location}</td>
                    <td>${violation.fine_amount}</td>
                    <td>
                        <span class="badge ${violation.settlement_status === 'Pending' ? 'bg-warning' : 'bg-success'}">
                            ${violation.settlement_status}
                        </span>
                    </td>
                    <td>
                        ${!violation.complaint_id && violation.settlement_status === 'Pending' ? 
                            `<button class="btn btn-sm btn-outline-primary file-complaint" data-violation-id="${violation.violation_id}">
                                File Complaint
                            </button>` : 
                            (violation.complaint_id ? 
                                `<span class="badge bg-info">Complaint ${violation.complaint_status}</span>` : 
                                '-'
                            )
                        }
                    </td>
                `;
                tableBody.appendChild(row);
            });

            // Add event listeners to complaint buttons
            document.querySelectorAll('.file-complaint').forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('violation_id').value = button.dataset.violationId;
                    new bootstrap.Modal(document.getElementById('complaintModal')).show();
                });
            });
        })
        .catch(error => console.error('Error loading violations:', error));
}

// Submit complaint
document.getElementById('submitComplaint').addEventListener('click', function() {
    const formData = new FormData(document.getElementById('complaintForm'));

    fetch('api/violations.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('complaintModal')).hide();
            loadViolations();
        } else {
            alert('Error submitting complaint');
        }
    })
    .catch(error => console.error('Error submitting complaint:', error));
});

// Load violations on page load
document.addEventListener('DOMContentLoaded', loadViolations);