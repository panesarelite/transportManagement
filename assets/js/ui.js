// UI utilities and components - Developed by PanesarElite
import { getCurrentRole, hasRole, getCurrentUser, requireAuth } from './auth.js';
import { buildUrl, debugLog } from './config.js';

console.log('🎨 UI module loading - PanesarElite');

// Enhanced toast system with console logging and alerts
export function showToast(message, type = 'info', duration = 5000) {
    console.log(`🍞 Toast: [${type.toUpperCase()}] ${message}`);
    
    // Enhanced console logging
    if (type === 'error') {
        console.error('🚨 ERROR:', message);
        console.trace('Error trace:');
    } else if (type === 'warning') {
        console.warn('⚠️ WARNING:', message);
    } else if (type === 'success') {
        console.log('✅ SUCCESS:', message);
    } else {
        console.info('ℹ️ INFO:', message);
    }
    
    // Show alert for errors and warnings as requested
    if (type === 'error' || type === 'warning') {
        alert(`${type.toUpperCase()}: ${message}`);
    }
    
    const toastContainer = document.getElementById('global-toast');
    if (!toastContainer) {
        console.warn('⚠️ Toast container not found, using alert instead');
        alert(`${type.toUpperCase()}: ${message}`);
        return;
    }
    
    const toastId = 'toast_' + Date.now();
    const bgClass = type === 'error' ? 'bg-danger' : 
                   type === 'success' ? 'bg-success' : 
                   type === 'warning' ? 'bg-warning' : 'bg-info';
    
    const toastHtml = `
        <div class="toast ${bgClass} text-white" role="alert" aria-live="assertive" aria-atomic="true" id="${toastId}">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-${getToastIcon(type)} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    const toastElement = document.getElementById(toastId);
    if (window.bootstrap && window.bootstrap.Toast) {
        const toast = new bootstrap.Toast(toastElement, { delay: duration });
        toast.show();
        
        // Clean up after toast is hidden
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    } else {
        console.warn('⚠️ Bootstrap Toast not available');
        // Fallback: remove after delay
        setTimeout(() => {
            if (toastElement) {
                toastElement.remove();
            }
        }, duration);
    }
}

function getToastIcon(type) {
    switch(type) {
        case 'error': return 'exclamation-triangle';
        case 'success': return 'check-circle';
        case 'warning': return 'exclamation-circle';
        default: return 'info-circle';
    }
}

// Loading modal with error handling
export function showLoading(message = 'Loading...') {
    console.log('⏳ Loading:', message);
    
    const loadingModal = document.getElementById('loadingModal');
    const loadingMessage = document.getElementById('loadingMessage');
    
    if (loadingMessage) {
        loadingMessage.textContent = message;
    }
    
    if (loadingModal && window.bootstrap && window.bootstrap.Modal) {
        const modal = new bootstrap.Modal(loadingModal);
        modal.show();
    } else {
        console.warn('⚠️ Loading modal not available');
    }
}

export function hideLoading() {
    console.log('✅ Hiding loading modal');
    
    const loadingModal = document.getElementById('loadingModal');
    if (loadingModal && window.bootstrap && window.bootstrap.Modal) {
        const modal = bootstrap.Modal.getInstance(loadingModal);
        if (modal) {
            modal.hide();
        }
    }
}

// Initialize sidebar menu from JSON with error handling
export async function initializeMenu() {
    console.log('📋 Initializing sidebar menu - PanesarElite');
    
    try {
        const menuUrl = buildUrl('/assets/settings/leftmenu.json');
        console.log('📄 Loading menu from:', menuUrl);
        
        const response = await fetch(menuUrl);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const menuItems = await response.json();
        console.log('📄 Menu items loaded:', menuItems.length);
        
        const sidebarContent = document.getElementById('sidebarContent');
        if (!sidebarContent) {
            throw new Error('Sidebar content element not found');
        }
        
        const currentRole = getCurrentRole();
        console.log('👤 Building menu for role:', currentRole);
        
        let menuHtml = '<ul class="nav flex-column">';
        
        menuItems.forEach(item => {
            // Role-based visibility
            if (item.title === 'Admin' && !hasRole('admin', 'dispatcher')) {
                console.log('🚫 Hiding Admin menu for role:', currentRole);
                return;
            }
            
            if (item.cascade) {
                // Collapsible menu item
                const collapseId = item.title.replace(/\s+/g, '');
                menuHtml += `
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapse${collapseId}" 
                           aria-expanded="false" aria-controls="collapse${collapseId}">
                            <i class="${item.icon}"></i>
                            <span>${item.title}</span>
                        </a>
                        <div id="collapse${collapseId}" class="collapse">
                            <div class="bg-light py-2 collapse-inner rounded">
                `;
                
                item.cascade.forEach(subItem => {
                    const subItemUrl = buildUrl('/' + subItem.link);
                    menuHtml += `
                        <a class="collapse-item" href="${subItemUrl}">
                            <i class="${subItem.icon} me-2"></i>${subItem.title}
                        </a>
                    `;
                });
                
                menuHtml += `
                            </div>
                        </div>
                    </li>
                `;
            } else {
                // Regular menu item
                const currentPath = window.location.pathname;
                const itemPath = buildUrl('/' + item.link);
                const isActive = currentPath === itemPath || 
                               (item.link === 'index.php' && (currentPath === '/' || currentPath === buildUrl('/')));
                
                const itemUrl = buildUrl('/' + item.link);
                menuHtml += `
                    <li class="nav-item">
                        <a class="nav-link ${isActive ? 'active' : ''}" href="${itemUrl}">
                            <i class="${item.icon}"></i>
                            <span>${item.title}</span>
                        </a>
                    </li>
                `;
            }
        });
        
        menuHtml += '</ul>';
        sidebarContent.innerHTML = menuHtml;
        
        console.log('✅ Menu initialized successfully');
        
        // Initialize sidebar toggle
        initializeSidebarToggle();
        
    } catch (error) {
        console.error('❌ Error loading menu:', error);
        showToast('Error loading navigation menu: ' + error.message, 'error');
        
        // Fallback menu
        const sidebarContent = document.getElementById('sidebarContent');
        if (sidebarContent) {
            sidebarContent.innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fa-solid fa-exclamation-triangle fa-2x mb-2"></i>
                    <br>Menu loading failed
                    <br><small>Error: ${error.message}</small>
                    <br><small>Check console for details</small>
                </div>
            `;
        }
    }
}

// Sidebar toggle functionality
function initializeSidebarToggle() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleTop = document.getElementById('sidebarToggleTop');
    const sidebar = document.getElementById('sidebar');
    
    function toggleSidebar() {
        if (sidebar) {
            sidebar.classList.toggle('collapsed');
            document.body.classList.toggle('sidebar-collapsed');
        }
    }
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('show');
            } else {
                toggleSidebar();
            }
        });
    }
}

// Render status badge
export function renderStatusBadge(status) {
    const statusColors = {
        'New': 'secondary',
        'Needs Info': 'dark',
        'Approved': 'primary',
        'Assigned': 'info',
        'En Route': 'warning',
        'On Site': 'success',
        'Completed': 'success',
        'Delayed': 'danger',
        'Cancelled': 'outline-secondary'
    };
    
    const colorClass = statusColors[status] || 'secondary';
    return `<span class="badge bg-${colorClass}">${status}</span>`;
}

// Dashboard specific functions with error handling
export async function loadDashboardData() {
    console.log('📊 Loading dashboard data - PanesarElite');
    
    try {
        if (!requireAuth()) {
            return;
        }
        
        showLoading('Loading dashboard data...');
        
        const filters = {
            dateFrom: document.getElementById('dateFrom')?.value,
            dateTo: document.getElementById('dateTo')?.value
        };
        
        console.log('🔍 Dashboard filters:', filters);
        
        const { listDispatches } = await import('./dao.js');
        const dispatches = await listDispatches(filters, { limitCount: 20 });
        
        console.log('📋 Dispatches loaded:', dispatches.length);
        
        // Update KPIs
        updateKPIs(dispatches);
        
        // Update table
        updateDashboardTable(dispatches);
        
        hideLoading();
        
    } catch (error) {
        console.error('❌ Error loading dashboard:', error);
        showToast('Error loading dashboard data: ' + error.message, 'error');
        hideLoading();
    }
}

function updateKPIs(dispatches) {
    console.log('📈 Updating KPIs with', dispatches.length, 'dispatches');
    
    const kpis = {
        total: dispatches.length,
        assigned: dispatches.filter(d => d.status === 'Assigned').length,
        enroute: dispatches.filter(d => d.status === 'En Route').length,
        onsite: dispatches.filter(d => d.status === 'On Site').length,
        completed: dispatches.filter(d => d.status === 'Completed').length,
        delayed: dispatches.filter(d => d.status === 'Delayed').length
    };
    
    console.log('📊 KPI values:', kpis);
    
    Object.keys(kpis).forEach(key => {
        const element = document.getElementById(`kpi-${key}`);
        if (element) {
            element.textContent = kpis[key];
        }
    });
}

function updateDashboardTable(dispatches) {
    console.log('📋 Updating dashboard table with', dispatches.length, 'dispatches');
    
    const tbody = document.getElementById('dashboardTableBody');
    if (!tbody) {
        console.error('❌ Dashboard table body not found');
        return;
    }
    
    if (dispatches.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center text-muted">
                    <i class="fa-solid fa-inbox fa-2x mb-2"></i>
                    <br>No dispatches found for the selected date
                    <br><small>Try seeding sample data from Company Profile</small>
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = dispatches.map(dispatch => `
        <tr>
            <td><code>${dispatch.id.substring(0, 8)}</code></td>
            <td>${dispatch.dateStart}</td>
            <td>${dispatch.timeStart || '-'}</td>
            <td title="${dispatch.startLocation}">${truncateText(dispatch.startLocation, 30)}</td>
            <td title="${dispatch.destinationAddress || '-'}">${truncateText(dispatch.destinationAddress || '-', 30)}</td>
            <td>${dispatch.taskType}</td>
            <td>${renderStatusBadge(dispatch.status)}</td>
            <td>${dispatch.driverId ? 'Assigned' : 'Unassigned'}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary btn-sm" onclick="viewDispatch('${dispatch.year}', '${dispatch.month}', '${dispatch.day}', '${dispatch.id}')">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="editDispatch('${dispatch.year}', '${dispatch.month}', '${dispatch.day}', '${dispatch.id}')">
                        <i class="fa-solid fa-edit"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Filter functions
export function applyDashboardFilters() {
    console.log('🔍 Applying dashboard filters');
    loadDashboardData();
}

export function clearDashboardFilters() {
    console.log('🧹 Clearing dashboard filters');
    
    const dateFilter = document.getElementById('dateFilter');
    const statusFilter = document.getElementById('statusFilter');
    const taskTypeFilter = document.getElementById('taskTypeFilter');
    const reeferFilter = document.getElementById('reeferFilter');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    
    if (dateFilter) dateFilter.value = '';
    if (statusFilter) statusFilter.selectedIndex = -1;
    if (taskTypeFilter) taskTypeFilter.selectedIndex = 0;
    if (reeferFilter) reeferFilter.selectedIndex = 0;
    if (dateFrom) dateFrom.value = '';
    if (dateTo) dateTo.value = '';
    
    loadDashboardData();
}

// Utility functions
function truncateText(text, maxLength) {
    if (!text || text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}

// Global functions with proper URL building and auth checks
window.viewDispatch = function(year, month, day, id) {
    console.log('👁️ Viewing dispatch:', { year, month, day, id });
    if (!requireAuth()) return;
    window.location.href = buildUrl(`/dispatch/dispatch-tracking.php?id=${id}&year=${year}&month=${month}&day=${day}`);
};

window.editDispatch = function(year, month, day, id) {
    console.log('✏️ Editing dispatch:', { year, month, day, id });
    if (!requireAuth()) return;
    window.location.href = buildUrl(`/dispatch/new-dispatch.php?edit=${id}&year=${year}&month=${month}&day=${day}`);
};

window.performGlobalSearch = function() {
    const searchTerm = document.getElementById('globalSearch')?.value;
    console.log('🔍 Global search:', searchTerm);
    
    if (!requireAuth()) return;
    
    if (searchTerm) {
        window.location.href = buildUrl(`/dispatch/dispatch-list.php?search=${encodeURIComponent(searchTerm)}`);
    }
};

window.showSettingsModal = function() {
    showToast('Settings panel coming soon!', 'info');
};

// Navigation functions with auth checks and proper URLs
window.goToNewDispatch = function() {
    console.log('➕ Navigating to new dispatch');
    if (!requireAuth()) return;
    const url = buildUrl('/dispatch/new-dispatch.php');
    console.log('🔗 Redirecting to:', url);
    window.location.href = url;
};

window.goToAssign = function() {
    console.log('👥 Navigating to assignment');
    if (!requireAuth()) return;
    window.location.href = buildUrl('/dispatch/dispatch-assign.php');
};

window.goToTracking = function() {
    console.log('📍 Navigating to tracking');
    if (!requireAuth()) return;
    window.location.href = buildUrl('/dispatch/dispatch-tracking.php');
};

window.goToDispatchList = function() {
    console.log('📋 Navigating to dispatch list');
    if (!requireAuth()) return;
    window.location.href = buildUrl('/dispatch/dispatch-list.php');
};

window.goToHome = function() {
    console.log('🏠 Navigating to home');
    if (!requireAuth()) return;
    window.location.href = buildUrl('/index.php');
};

window.goToProfile = function() {
    console.log('👤 Navigating to profile');
    if (!requireAuth()) return;
    window.location.href = buildUrl('/admin/company-profile.php');
};

window.performLogout = async function() {
    console.log('🚪 Performing logout');
    try {
        const { logout } = await import('./auth.js');
        await logout();
    } catch (error) {
        console.error('❌ Logout error:', error);
        alert(`Logout Error!\n\n${error.message}`);
    }
};

// Dashboard refresh functions
window.refreshDashboard = function() {
    console.log('🔄 Refreshing dashboard');
    loadDashboardData();
};

window.applyFilters = function() {
    console.log('🔍 Applying filters');
    applyDashboardFilters();
};

window.clearFilters = function() {
    console.log('🧹 Clearing filters');
    clearDashboardFilters();
};

console.log('✅ UI module loaded - Developed by PanesarElite');