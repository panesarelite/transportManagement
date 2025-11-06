<?php
$pageTitle = "Dispatch Tracking - Captain Dispatch";
$currentPage = "dispatch-tracking";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dispatch Tracking</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-outline-secondary" onclick="refreshTracking()">
                        <i class="fa-solid fa-rotate-right"></i> Refresh
                    </button>
                    <button type="button" class="btn btn-outline-secondary ms-2" onclick="window.history.back()">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </button>
                </div>
            </div>

            <!-- Dispatch Summary -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dispatch Summary</h6>
                </div>
                <div class="card-body" id="dispatchSummary">
                    <!-- Populated by JS -->
                </div>
            </div>

            <div class="row">
                <!-- Map -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Route & Live Tracking</h6>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 400px; background-color: #f8f9fa; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center;">
                                <div class="text-center text-muted">
                                    <i class="fa-solid fa-map fa-3x mb-3"></i>
                                    <p>Google Maps integration ready<br>
                                    <small>Configure Google Maps API key to enable live tracking</small></p>
                                </div>
                            </div>
                            
                            <!-- Live Location Controls -->
                            <div class="mt-3" id="liveControls" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success w-100" onclick="shareLocation()">
                                            <i class="fa-solid fa-location-dot me-2"></i>Share Live Location
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100" onclick="stopSharing()">
                                            <i class="fa-solid fa-stop me-2"></i>Stop Sharing
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Status Timeline -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Timeline</h6>
                        </div>
                        <div class="card-body">
                            <div id="statusTimeline">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Live Location Info -->
                    <div class="card shadow mb-4" id="liveLocationCard" style="display: none;">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Live Location</h6>
                        </div>
                        <div class="card-body">
                            <div id="liveLocationInfo">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script type="module">
import { getDispatch, updateLiveLocation } from '/assets/js/dao.js';
import { renderStatusBadge, showToast, showLoading, hideLoading } from '/assets/js/ui.js';
import { getCurrentRole } from '/assets/js/auth.js';

let currentDispatch = null;
let watchId = null;
let isSharing = false;

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const dispatchId = urlParams.get('id');
    const year = urlParams.get('year');
    const month = urlParams.get('month');
    const day = urlParams.get('day');
    
    if (!dispatchId || !year || !month || !day) {
        showToast('Invalid dispatch parameters', 'error');
        window.history.back();
        return;
    }
    
    loadDispatchData(year, month, day, dispatchId);
    
    // Show live controls for drivers
    const role = getCurrentRole();
    if (role === 'driver') {
        document.getElementById('liveControls').style.display = 'block';
    }
});

async function loadDispatchData(year, month, day, dispatchId) {
    try {
        showLoading('Loading dispatch...');
        
        currentDispatch = await getDispatch(year, month, day, dispatchId);
        
        if (!currentDispatch) {
            showToast('Dispatch not found', 'error');
            window.history.back();
            return;
        }
        
        displayDispatchSummary();
        displayStatusTimeline();
        displayLiveLocation();
        hideLoading();
        
    } catch (error) {
        console.error('Error loading dispatch:', error);
        showToast('Error loading dispatch', 'error');
        hideLoading();
    }
}

function displayDispatchSummary() {
    const summaryContainer = document.getElementById('dispatchSummary');
    
    summaryContainer.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h5>${renderStatusBadge(currentDispatch.status)} <code>${currentDispatch.id.substring(0, 8)}</code></h5>
                <p class="mb-1"><strong>Date:</strong> ${currentDispatch.dateStart} at ${currentDispatch.timeStart || 'TBD'}</p>
                <p class="mb-1"><strong>Task Type:</strong> ${currentDispatch.taskType}</p>
                <p class="mb-1"><strong>Contact:</strong> ${currentDispatch.contactPerson}</p>
                ${currentDispatch.contactPhone ? `<p class="mb-1"><strong>Phone:</strong> ${currentDispatch.contactPhone}</p>` : ''}
            </div>
            <div class="col-md-6">
                <p class="mb-1"><strong>From:</strong> ${currentDispatch.startLocation}</p>
                <p class="mb-1"><strong>To:</strong> ${currentDispatch.destinationAddress || 'Not specified'}</p>
                <p class="mb-1"><strong>Reefer:</strong> ${currentDispatch.reeferRequired ? 'Required' : 'Not required'}</p>
                <p class="mb-1"><strong>Dangerous Goods:</strong> ${currentDispatch.dangerousGoods}</p>
                ${currentDispatch.driverId ? `<p class="mb-1"><strong>Driver:</strong> Assigned</p>` : ''}
            </div>
        </div>
    `;
}

function displayStatusTimeline() {
    const timeline = document.getElementById('statusTimeline');
    
    if (!currentDispatch.notes || currentDispatch.notes.length === 0) {
        timeline.innerHTML = '<p class="text-muted">No status updates yet</p>';
        return;
    }
    
    timeline.innerHTML = currentDispatch.notes.map((note, index) => `
        <div class="d-flex mb-3">
            <div class="flex-shrink-0">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 32px; height: 32px;">
                    <i class="fa-solid fa-circle text-white" style="font-size: 8px;"></i>
                </div>
            </div>
            <div class="flex-grow-1 ms-3">
                <div class="fw-bold">${note.byRole}</div>
                <div class="text-muted small">${formatTimestamp(note.ts)}</div>
                <div class="mt-1">${note.text}</div>
            </div>
        </div>
        ${index < currentDispatch.notes.length - 1 ? '<hr class="my-2">' : ''}
    `).join('');
}

function displayLiveLocation() {
    const liveCard = document.getElementById('liveLocationCard');
    const liveInfo = document.getElementById('liveLocationInfo');
    
    if (currentDispatch.live && currentDispatch.live.lastKnownLat && currentDispatch.live.lastKnownLng) {
        liveCard.style.display = 'block';
        
        liveInfo.innerHTML = `
            <p class="mb-1"><strong>Last Known Position:</strong></p>
            <p class="mb-1">Lat: ${currentDispatch.live.lastKnownLat.toFixed(6)}</p>
            <p class="mb-1">Lng: ${currentDispatch.live.lastKnownLng.toFixed(6)}</p>
            <p class="mb-0"><strong>Last Update:</strong> ${formatTimestamp(currentDispatch.live.lastLiveTs)}</p>
        `;
    } else {
        liveCard.style.display = 'none';
    }
}

function formatTimestamp(timestamp) {
    if (!timestamp) return 'Unknown time';
    
    try {
        const date = timestamp.toDate ? timestamp.toDate() : new Date(timestamp);
        return date.toLocaleString('en-CA', {
            timeZone: 'America/Edmonton',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        return 'Invalid timestamp';
    }
}

// Global functions
window.refreshTracking = function() {
    loadDispatchData(currentDispatch.year, currentDispatch.month, currentDispatch.day, currentDispatch.id);
};

window.shareLocation = function() {
    if (!navigator.geolocation) {
        showToast('Geolocation is not supported by this browser', 'error');
        return;
    }
    
    if (isSharing) {
        showToast('Location sharing is already active', 'warning');
        return;
    }
    
    const options = {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 60000 // 1 minute
    };
    
    watchId = navigator.geolocation.watchPosition(
        async function(position) {
            try {
                await updateLiveLocation(
                    currentDispatch.year,
                    currentDispatch.month,
                    currentDispatch.day,
                    currentDispatch.id,
                    position.coords.latitude,
                    position.coords.longitude
                );
                
                if (!isSharing) {
                    isSharing = true;
                    showToast('Location sharing started', 'success');
                }
                
                // Update display
                displayLiveLocation();
                
            } catch (error) {
                console.error('Error updating location:', error);
                showToast('Error updating location', 'error');
            }
        },
        function(error) {
            console.error('Geolocation error:', error);
            showToast('Error getting location: ' + error.message, 'error');
        },
        options
    );
};

window.stopSharing = function() {
    if (watchId) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
        isSharing = false;
        showToast('Location sharing stopped', 'info');
    }
};
</script>