// Feedback JavaScript

// Rating stars functionality
document.querySelectorAll('.rating-stars .star').forEach(star => {
    star.addEventListener('click', function() {
        const rating = this.dataset.rating;
        document.getElementById('rating').value = rating;
        
        // Update star display
        document.querySelectorAll('.rating-stars .star').forEach((s, index) => {
            if (index < rating) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
    
    star.addEventListener('mouseover', function() {
        const rating = this.dataset.rating;
        document.querySelectorAll('.rating-stars .star').forEach((s, index) => {
            if (index < rating) {
                s.style.color = '#ffc107';
            } else {
                s.style.color = '#ddd';
            }
        });
    });
});

document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
    const currentRating = document.getElementById('rating').value;
    document.querySelectorAll('.rating-stars .star').forEach((s, index) => {
        if (index < currentRating) {
            s.style.color = '#ffc107';
        } else {
            s.style.color = '#ddd';
        }
    });
});

// Feedback form submission
document.getElementById('feedbackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('plate_number', document.getElementById('feedbackPlate').value);
    formData.append('rating', document.getElementById('rating').value);
    formData.append('comments', document.getElementById('comments').value);
    
    fetch('api/feedback.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert('Thank you for your feedback!');
            document.getElementById('feedbackForm').reset();
            document.querySelectorAll('.rating-stars .star').forEach(s => s.classList.remove('active'));
        } else {
            alert('Error: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting feedback');
    });
});

// Complaint form submission
document.getElementById('complaintForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('plate_number', document.getElementById('complaintPlate').value);
    formData.append('complaint_type', document.getElementById('complaintType').value);
    formData.append('description', document.getElementById('complaintDescription').value);
    formData.append('contact', document.getElementById('complaintContact').value);
    
    fetch('api/complaints.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert('Complaint submitted successfully. Reference ID: ' + data.complaint_id);
            document.getElementById('complaintForm').reset();
        } else {
            alert('Error: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error submitting complaint');
    });
});