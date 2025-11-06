// Timezone utilities for America/Edmonton
// Developed by PanesarElite

export function getCurrentDateEdmonton() {
    const now = new Date();
    // Convert to Edmonton timezone (MDT/MST)
    const edmontonTime = new Date(now.toLocaleString("en-US", {timeZone: "America/Edmonton"}));
    return edmontonTime.toISOString().split('T')[0]; // YYYY-MM-DD
}

export function getCurrentTimeEdmonton() {
    const now = new Date();
    const edmontonTime = new Date(now.toLocaleString("en-US", {timeZone: "America/Edmonton"}));
    return edmontonTime.toTimeString().substring(0, 5); // HH:MM
}

export function formatDateForPath(date) {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');
    return `${year}/${month}/${day}`;
}

export function formatDateForDisplay(date) {
    const d = new Date(date);
    return d.toLocaleDateString('en-CA'); // YYYY-MM-DD format
}

export function formatTimeForDisplay(time) {
    if (!time) return '';
    return time; // Already in HH:MM format
}

export function formatDateTimeForDisplay(date, time) {
    const dateStr = formatDateForDisplay(date);
    const timeStr = formatTimeForDisplay(time);
    return timeStr ? `${dateStr} ${timeStr}` : dateStr;
}

export function isValidDate(dateString) {
    if (!/^\d{4}-\d{2}-\d{2}$/.test(dateString)) return false;
    const date = new Date(dateString);
    return date instanceof Date && !isNaN(date);
}

export function isValidTime(timeString) {
    if (!timeString) return true; // Optional field
    return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(timeString);
}

export function addDays(date, days) {
    const result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
}

export function getDatesBetween(startDate, endDate) {
    const dates = [];
    const current = new Date(startDate);
    const end = new Date(endDate);
    
    while (current <= end) {
        dates.push(new Date(current));
        current.setDate(current.getDate() + 1);
    }
    
    return dates;
}