// Form validation utilities
// Developed by PanesarElite

export function validateRequired(value, fieldName) {
    if (!value || value.trim() === '') {
        return `${fieldName} is required`;
    }
    return null;
}

export function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return 'Please enter a valid email address';
    }
    return null;
}

export function validatePhone(phone) {
    if (!phone) return null; // Optional field
    
    // Remove all non-digit characters
    const cleaned = phone.replace(/\D/g, '');
    
    // Check if it's a valid North American number
    if (cleaned.length === 10) {
        return null; // Valid
    } else if (cleaned.length === 11 && cleaned.startsWith('1')) {
        return null; // Valid with country code
    }
    
    return 'Please enter a valid phone number';
}

export function normalizePhone(phone) {
    if (!phone) return '';
    
    const cleaned = phone.replace(/\D/g, '');
    
    if (cleaned.length === 10) {
        return `+1${cleaned}`;
    } else if (cleaned.length === 11 && cleaned.startsWith('1')) {
        return `+${cleaned}`;
    }
    
    return phone; // Return as-is if can't normalize
}

export function validateDate(dateString) {
    if (!dateString) return 'Date is required';
    
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(dateString)) {
        return 'Date must be in YYYY-MM-DD format';
    }
    
    const date = new Date(dateString);
    if (isNaN(date.getTime())) {
        return 'Please enter a valid date';
    }
    
    return null;
}

export function validateTime(timeString) {
    if (!timeString) return null; // Optional field
    
    const timeRegex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
    if (!timeRegex.test(timeString)) {
        return 'Time must be in HH:MM format (24-hour)';
    }
    
    return null;
}

export function validateDateRange(startDate, endDate) {
    if (!startDate || !endDate) return null;
    
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    if (start > end) {
        return 'End date must be after start date';
    }
    
    return null;
}

export function validateTimeRange(startTime, endTime) {
    if (!startTime || !endTime) return null;
    
    // Convert to minutes for comparison
    const startMinutes = timeToMinutes(startTime);
    const endMinutes = timeToMinutes(endTime);
    
    if (startMinutes >= endMinutes) {
        return 'End time must be after start time';
    }
    
    return null;
}

function timeToMinutes(timeString) {
    const [hours, minutes] = timeString.split(':').map(Number);
    return hours * 60 + minutes;
}

export function validateDispatchForm(formData) {
    const errors = {};
    
    // Required fields
    const requiredFields = [
        'dateStart',
        'timeStart', 
        'startLocation',
        'contactPerson',
        'taskType',
        'dangerousGoods'
    ];
    
    requiredFields.forEach(field => {
        const error = validateRequired(formData[field], field.replace(/([A-Z])/g, ' $1').toLowerCase());
        if (error) errors[field] = error;
    });
    
    // Date validation
    if (formData.dateStart) {
        const dateError = validateDate(formData.dateStart);
        if (dateError) errors.dateStart = dateError;
    }
    
    if (formData.dateEnd) {
        const dateError = validateDate(formData.dateEnd);
        if (dateError) errors.dateEnd = dateError;
        
        // Check date range if both dates present
        if (formData.dateStart && !errors.dateStart && !errors.dateEnd) {
            const rangeError = validateDateRange(formData.dateStart, formData.dateEnd);
            if (rangeError) errors.dateEnd = rangeError;
        }
    }
    
    // Time validation
    if (formData.timeStart) {
        const timeError = validateTime(formData.timeStart);
        if (timeError) errors.timeStart = timeError;
    }
    
    if (formData.timeEnd) {
        const timeError = validateTime(formData.timeEnd);
        if (timeError) errors.timeEnd = timeError;
        
        // Check time range if both times present and same day
        if (formData.timeStart && !formData.multiDay && !errors.timeStart && !errors.timeEnd) {
            const rangeError = validateTimeRange(formData.timeStart, formData.timeEnd);
            if (rangeError) errors.timeEnd = rangeError;
        }
    }
    
    // Phone validation
    if (formData.contactPerson) {
        const phoneError = validatePhone(formData.contactPerson);
        if (phoneError) errors.contactPerson = phoneError;
    }
    
    return {
        isValid: Object.keys(errors).length === 0,
        errors
    };
}

export function displayValidationErrors(errors) {
    // Clear existing errors
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.remove();
    });
    
    // Display new errors
    Object.keys(errors).forEach(fieldName => {
        const field = document.getElementById(fieldName) || document.querySelector(`[name="${fieldName}"]`);
        if (field) {
            field.classList.add('is-invalid');
            
            const feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            feedback.textContent = errors[fieldName];
            
            field.parentNode.appendChild(feedback);
        }
    });
}

export function clearValidationErrors() {
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.remove();
    });
}