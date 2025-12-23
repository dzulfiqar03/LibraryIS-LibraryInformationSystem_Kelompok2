/**
 * LibraryIS - Frontend Application JavaScript
 */

// Utility function to show toast notifications
function showToast(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div');
    const bgColor = {
        'success': 'bg-success-600',
        'error': 'bg-danger-600',
        'warning': 'bg-warning-600',
        'info': 'bg-primary-600'
    }[type] || 'bg-primary-600';

    toast.className = `fixed top-4 right-4 px-6 py-3 text-white rounded-lg shadow-lg ${bgColor} z-50 animate-fade-in`;
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, duration);
}

// Handle form submissions with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Add form validation feedback
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validate required fields
            const inputs = this.querySelectorAll('[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('Please fill in all required fields', 'error');
            }
        });

        // Remove error styling on input
        form.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('change', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
});

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Format date
function formatDate(date, format = 'short') {
    const options = {
        'short': { month: 'short', day: 'numeric', year: 'numeric' },
        'long': { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' },
        'time': { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }
    };

    return new Date(date).toLocaleDateString('en-US', options[format]);
}

// Debounce function for search inputs
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func(...args), delay);
    };
}

// Export functions for global use
window.showToast = showToast;
window.formatCurrency = formatCurrency;
window.formatDate = formatDate;
window.debounce = debounce;
