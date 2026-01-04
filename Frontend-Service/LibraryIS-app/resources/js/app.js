// Form Validation Utilities
const FormValidator = {
  /**
   * Validate email format
   */
  validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  },

  /**
   * Validate password strength
   */
  validatePassword(password) {
    const minLength = password.length >= 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumbers = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    return {
      isValid: minLength && hasUpperCase && hasLowerCase && hasNumbers,
      strength: this.calculatePasswordStrength(password),
      requirements: {
        minLength,
        hasUpperCase,
        hasLowerCase,
        hasNumbers,
        hasSpecialChar,
      },
    };
  },

  /**
   * Calculate password strength
   */
  calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

    if (strength <= 2) return 'weak';
    if (strength <= 4) return 'medium';
    return 'strong';
  },

  /**
   * Validate required field
   */
  validateRequired(value) {
    return value && value.trim().length > 0;
  },

  /**
   * Validate minimum length
   */
  validateMinLength(value, minLength) {
    return value && value.length >= minLength;
  },

  /**
   * Validate maximum length
   */
  validateMaxLength(value, maxLength) {
    return value && value.length <= maxLength;
  },

  /**
   * Validate number
   */
  validateNumber(value) {
    return !isNaN(value) && isFinite(value);
  },

  /**
   * Validate phone number
   */
  validatePhone(phone) {
    const phoneRegex = /^[+]?[(]?[0-9]{3}[)]?[-\s]?[0-9]{3}[-\s]?[0-9]{4,6}$/;
    return phoneRegex.test(phone);
  },

  /**
   * Validate URL
   */
  validateUrl(url) {
    try {
      new URL(url);
      return true;
    } catch {
      return false;
    }
  },
};

// API Request Helper
const ApiHelper = {
  /**
   * Make GET request
   */
  async get(endpoint, params = {}) {
    try {
      const queryString = new URLSearchParams(params).toString();
      const url = `${endpoint}${queryString ? '?' + queryString : ''}`;

      const response = await fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
      });

      return await this.handleResponse(response);
    } catch (error) {
      console.error('GET request failed:', error);
      throw error;
    }
  },

  /**
   * Make POST request
   */
  async post(endpoint, data = {}) {
    try {
      const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
        body: JSON.stringify(data),
      });

      return await this.handleResponse(response);
    } catch (error) {
      console.error('POST request failed:', error);
      throw error;
    }
  },

  /**
   * Make PUT request
   */
  async put(endpoint, data = {}) {
    try {
      const response = await fetch(endpoint, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
        body: JSON.stringify(data),
      });

      return await this.handleResponse(response);
    } catch (error) {
      console.error('PUT request failed:', error);
      throw error;
    }
  },

  /**
   * Make DELETE request
   */
  async delete(endpoint) {
    try {
      const response = await fetch(endpoint, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
      });

      return await this.handleResponse(response);
    } catch (error) {
      console.error('DELETE request failed:', error);
      throw error;
    }
  },

  /**
   * Handle response
   */
  async handleResponse(response) {
    if (response.status === 401) {
      window.location.href = '/auth/login';
      return null;
    }

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Request failed');
    }

    return data;
  },
};

// Toast Notification Helper
const Toast = {
  show(message, type = 'info', duration = 3000) {
    const id = `toast-${Date.now()}`;
    const colors = {
      success: 'bg-success-100 text-success-800',
      error: 'bg-danger-100 text-danger-800',
      warning: 'bg-warning-100 text-warning-800',
      info: 'bg-primary-100 text-primary-800',
    };

    const html = `
      <div id="${id}" class="fixed bottom-4 right-4 ${colors[type]} px-4 py-3 rounded-lg shadow-lg animate-slide-up">
        ${message}
      </div>
    `;

    document.body.insertAdjacentHTML('beforeend', html);

    setTimeout(() => {
      const element = document.getElementById(id);
      if (element) {
        element.classList.remove('animate-slide-up');
        element.classList.add('opacity-0', 'transition-opacity', 'duration-300');
        setTimeout(() => element.remove(), 300);
      }
    }, duration);
  },

  success(message, duration = 3000) {
    this.show(message, 'success', duration);
  },

  error(message, duration = 5000) {
    this.show(message, 'error', duration);
  },

  warning(message, duration = 4000) {
    this.show(message, 'warning', duration);
  },

  info(message, duration = 3000) {
    this.show(message, 'info', duration);
  },
};

// Date formatting helper
const DateHelper = {
  format(date, format = 'MM/DD/YYYY') {
    const d = new Date(date);
    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = d.getFullYear();
    const hours = String(d.getHours()).padStart(2, '0');
    const minutes = String(d.getMinutes()).padStart(2, '0');
    const seconds = String(d.getSeconds()).padStart(2, '0');

    return format
      .replace('DD', day)
      .replace('MM', month)
      .replace('YYYY', year)
      .replace('HH', hours)
      .replace('mm', minutes)
      .replace('ss', seconds);
  },

  relative(date) {
    const now = new Date();
    const diff = now - new Date(date);
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (seconds < 60) return 'just now';
    if (minutes < 60) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    if (hours < 24) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    if (days < 7) return `${days} day${days > 1 ? 's' : ''} ago`;

    return this.format(date);
  },

  daysUntil(date) {
    const now = new Date();
    const d = new Date(date);
    const diff = d - now;
    return Math.ceil(diff / (1000 * 60 * 60 * 24));
  },
};

// String utilities
const StringHelper = {
  truncate(str, length = 100) {
    return str.length > length ? str.substring(0, length) + '...' : str;
  },

  capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  },

  slugify(str) {
    return str.toLowerCase().replace(/[^\w\s-]/g, '').replace(/\s+/g, '-');
  },

  formatCurrency(amount, currency = 'USD') {
    return new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: currency,
    }).format(amount);
  },

  formatNumber(number, decimals = 0) {
    return number.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  },
};

// Modal Helper
const Modal = {
  open(id) {
    const modal = document.getElementById(id);
    if (modal) {
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
  },

  close(id) {
    const modal = document.getElementById(id);
    if (modal) {
      modal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    }
  },

  closeAll() {
    document.querySelectorAll('[data-modal]').forEach(modal => {
      modal.classList.add('hidden');
    });
    document.body.style.overflow = 'auto';
  },
};

// Initialize event listeners
document.addEventListener('DOMContentLoaded', () => {
  // Auto-close alerts after 5 seconds
  document.querySelectorAll('[data-alert]').forEach(alert => {
    setTimeout(() => {
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 300);
    }, 5000);
  });

  // Modal close buttons
  document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const modal = e.target.closest('[data-modal]');
      if (modal) Modal.close(modal.id);
    });
  });

  // Close modal on background click
  document.querySelectorAll('[data-modal]').forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) Modal.close(modal.id);
    });
  });
});
