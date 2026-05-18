/**
 * Affected People Dashboard - JavaScript
 * Handles profile modal and interactive features
 */

// Profile Modal Functions
function openProfileModal() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.add('open');
        // Prevent body scroll when modal is open
        document.body.style.overflow = 'hidden';
    }
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    if (modal) {
        modal.classList.remove('open');
        // Restore body scroll
        document.body.style.overflow = '';
    }
}

function handleProfileBackdropClick(event) {
    // Close modal if clicking on the backdrop (not the card)
    if (event.target === document.getElementById('profileModal')) {
        closeProfileModal();
    }
}

// Close modal on Escape key press
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeProfileModal();
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Affected People Dashboard loaded successfully');
    
    // Add smooth scroll behavior for any anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Optional: Auto-refresh stats every 30 seconds (if needed in future)
// Uncomment below to enable
/*
setInterval(function() {
    // Add AJAX call here to refresh stats without page reload
    console.log('Stats refresh interval');
}, 30000);
*/
