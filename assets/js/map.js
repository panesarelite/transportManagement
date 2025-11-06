// Google Maps integration
// Developed by PanesarElite

let map = null;
let directionsService = null;
let directionsRenderer = null;
let markers = [];

export async function initializeMap(containerId, options = {}) {
    const defaultOptions = {
        zoom: 10,
        center: { lat: 51.0447, lng: -114.0719 }, // Calgary
        mapTypeId: 'roadmap'
    };
    
    const mapOptions = { ...defaultOptions, ...options };
    
    try {
        map = new google.maps.Map(document.getElementById(containerId), mapOptions);
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            suppressMarkers: false,
            draggable: false
        });
        directionsRenderer.setMap(map);
        
        return map;
    } catch (error) {
        console.error('Error initializing map:', error);
        throw error;
    }
}

export async function geocodeAddress(address) {
    return new Promise((resolve, reject) => {
        if (!window.google || !window.google.maps) {
            reject(new Error('Google Maps not loaded'));
            return;
        }
        
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: address }, (results, status) => {
            if (status === 'OK' && results[0]) {
                const location = results[0].geometry.location;
                resolve({
                    lat: location.lat(),
                    lng: location.lng(),
                    formatted_address: results[0].formatted_address
                });
            } else {
                reject(new Error(`Geocoding failed: ${status}`));
            }
        });
    });
}

export function addMarker(position, options = {}) {
    if (!map) return null;
    
    const defaultOptions = {
        position: position,
        map: map,
        title: options.title || ''
    };
    
    const marker = new google.maps.Marker({ ...defaultOptions, ...options });
    markers.push(marker);
    
    if (options.infoWindow) {
        const infoWindow = new google.maps.InfoWindow({
            content: options.infoWindow
        });
        
        marker.addListener('click', () => {
            infoWindow.open(map, marker);
        });
    }
    
    return marker;
}

export function clearMarkers() {
    markers.forEach(marker => {
        marker.setMap(null);
    });
    markers = [];
}

export async function showRoute(start, end, options = {}) {
    if (!directionsService || !directionsRenderer) {
        throw new Error('Directions service not initialized');
    }
    
    return new Promise((resolve, reject) => {
        const request = {
            origin: start,
            destination: end,
            travelMode: google.maps.TravelMode.DRIVING,
            ...options
        };
        
        directionsService.route(request, (result, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(result);
                resolve(result);
            } else {
                reject(new Error(`Directions request failed: ${status}`));
            }
        });
    });
}

export function updateLiveMarker(position, title = 'Live Location') {
    // Remove existing live marker
    const existingLiveMarker = markers.find(m => m.getTitle() === 'Live Location');
    if (existingLiveMarker) {
        existingLiveMarker.setMap(null);
        markers = markers.filter(m => m !== existingLiveMarker);
    }
    
    // Add new live marker with pulse animation
    const marker = addMarker(position, {
        title: title,
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: '#ff6b6b',
            fillOpacity: 0.8,
            strokeColor: '#fff',
            strokeWeight: 2
        },
        animation: google.maps.Animation.BOUNCE
    });
    
    // Stop animation after 2 seconds
    setTimeout(() => {
        if (marker) {
            marker.setAnimation(null);
        }
    }, 2000);
    
    return marker;
}

export function panToLocation(position) {
    if (map) {
        map.panTo(position);
        map.setZoom(15);
    }
}

// Load Google Maps API
export function loadGoogleMapsAPI(apiKey) {
    return new Promise((resolve, reject) => {
        if (window.google && window.google.maps) {
            resolve();
            return;
        }
        
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
        script.async = true;
        script.defer = true;
        
        script.onload = () => resolve();
        script.onerror = () => reject(new Error('Failed to load Google Maps API'));
        
        document.head.appendChild(script);
    });
}