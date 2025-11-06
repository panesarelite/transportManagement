// Data Access Object - Developed by PanesarElite
import { 
    collection, 
    doc, 
    getDoc, 
    getDocs, 
    setDoc, 
    updateDoc, 
    query, 
    where, 
    orderBy, 
    limit,
    addDoc,
    serverTimestamp,
    writeBatch
} from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js';
import { getCurrentCompanyRID, getCurrentRole, getCurrentUser } from './auth.js';
import { formatDateForPath, getCurrentDateEdmonton } from './utils-timezone.js';

const db = window.firebaseDb;

// Helper to ensure document path exists
export async function createPath(path) {
    console.log('📁 Creating Firestore path:', path);
    
    const pathParts = path.split('/');
    let currentPath = '';
    
    const batch = writeBatch(db);
    
    for (let i = 0; i < pathParts.length - 1; i += 2) {
        currentPath += pathParts[i] + '/' + pathParts[i + 1];
        const docRef = doc(db, currentPath);
        
        try {
            const docSnap = await getDoc(docRef);
            if (!docSnap.exists()) {
                console.log('📄 Creating path document:', currentPath);
                batch.set(docRef, { 
                    createdAt: serverTimestamp(),
                    _placeholder: true 
                });
            }
        } catch (error) {
            console.warn('⚠️ Path creation check failed for:', currentPath, error);
        }
        
        if (i < pathParts.length - 3) {
            currentPath += '/';
        }
    }
    
    try {
        await batch.commit();
        console.log('✅ Path created successfully');
    } catch (error) {
        console.warn('⚠️ Batch path creation failed:', error);
    }
}

// Get user document
export async function getUserDoc(uid) {
    console.log('👤 Getting user document for UID:', uid);
    
    const companyRID = getCurrentCompanyRID();
    if (!companyRID) {
        throw new Error('No company RID available');
    }
    
    // Try company users first
    let userRef = doc(db, `companies/${companyRID}/users`, uid);
    let userDoc = await getDoc(userRef);
    
    // If not found, try global users collection
    if (!userDoc.exists()) {
        console.log('📋 User not found in company, checking global users...');
        userRef = doc(db, 'users', uid);
        userDoc = await getDoc(userRef);
    }
    
    console.log('📄 User document exists:', userDoc.exists());
    return userDoc;
}

// Get company document
export async function getCompanyDoc() {
    console.log('🏢 Getting company document');
    
    const companyRID = getCurrentCompanyRID();
    if (!companyRID) {
        throw new Error('No company RID available');
    }
    
    const companyRef = doc(db, 'companies', companyRID);
    const companyDoc = await getDoc(companyRef);
    
    console.log('📄 Company document exists:', companyDoc.exists());
    return companyDoc;
}

// Create dispatch
export async function createDispatch(dispatchData) {
    console.log('📋 Creating new dispatch:', dispatchData);
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const dateStart = dispatchData.dateStart;
    const [year, month, day] = dateStart.split('-');
    const scheduleKey = `${year}/${month}/${day}`;
    
    const dispatchPath = `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}`;
    
    console.log('📁 Creating dispatch path:', dispatchPath);
    
    // Ensure path exists
    await createPath(dispatchPath + '/dispatches');
    
    const dispatchesRef = collection(db, dispatchPath + '/dispatches');
    
    const fullDispatchData = {
        ...dispatchData,
        customerID: companyRID,
        scheduleKey: scheduleKey,
        status: 'New',
        statusColor: 'secondary',
        createdAt: serverTimestamp(),
        updatedAt: serverTimestamp(),
        createdBy: user.uid,
        notes: [{
            byUid: user.uid,
            byRole: getCurrentRole(),
            text: 'Dispatch created',
            ts: serverTimestamp()
        }]
    };
    
    console.log('💾 Saving dispatch to Firestore...');
    const docRef = await addDoc(dispatchesRef, fullDispatchData);
    
    console.log('✅ Dispatch created with ID:', docRef.id);
    return docRef.id;
}

// Update dispatch
export async function updateDispatch(year, month, day, dispatchRID, updateData) {
    console.log('📝 Updating dispatch:', { year, month, day, dispatchRID });
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const dispatchRef = doc(db, 
        `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`, 
        dispatchRID
    );
    
    const updatePayload = {
        ...updateData,
        updatedAt: serverTimestamp(),
        updatedBy: user.uid
    };
    
    console.log('💾 Updating dispatch in Firestore...');
    await updateDoc(dispatchRef, updatePayload);
    console.log('✅ Dispatch updated successfully');
}

// Get dispatches with filters
export async function listDispatches(filters = {}, pagination = {}) {
    console.log('📋 Listing dispatches with filters:', filters);
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const results = [];
    
    // If specific date range provided, query those dates
    if (filters.dateFrom && filters.dateTo) {
        const startDate = new Date(filters.dateFrom);
        const endDate = new Date(filters.dateTo);
        
        console.log('📅 Querying date range:', filters.dateFrom, 'to', filters.dateTo);
        
        for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
            const [year, month, day] = formatDateForPath(d).split('/');
            const dispatchPath = `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`;
            
            try {
                let q = collection(db, dispatchPath);
                
                // Apply filters
                if (filters.status && filters.status.length > 0) {
                    q = query(q, where('status', 'in', filters.status));
                }
                
                if (filters.taskType) {
                    q = query(q, where('taskType', '==', filters.taskType));
                }
                
                if (filters.reeferRequired !== undefined) {
                    q = query(q, where('reeferRequired', '==', filters.reeferRequired));
                }
                
                if (filters.driverId) {
                    q = query(q, where('driverId', '==', filters.driverId));
                }
                
                q = query(q, orderBy('createdAt', 'desc'));
                
                if (pagination.limitCount) {
                    q = query(q, limit(pagination.limitCount));
                }
                
                const snapshot = await getDocs(q);
                snapshot.forEach(doc => {
                    results.push({
                        id: doc.id,
                        ...doc.data(),
                        year,
                        month,
                        day
                    });
                });
            } catch (error) {
                console.warn('⚠️ Error querying date:', year, month, day, error);
            }
        }
    } else {
        // Default to today if no date range
        const today = getCurrentDateEdmonton();
        const [year, month, day] = today.split('-');
        const dispatchPath = `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`;
        
        console.log('📅 Querying today\'s dispatches:', dispatchPath);
        
        try {
            let q = collection(db, dispatchPath);
            q = query(q, orderBy('createdAt', 'desc'), limit(20));
            
            const snapshot = await getDocs(q);
            snapshot.forEach(doc => {
                results.push({
                    id: doc.id,
                    ...doc.data(),
                    year,
                    month,
                    day
                });
            });
        } catch (error) {
            console.warn('⚠️ Error querying today\'s dispatches:', error);
        }
    }
    
    console.log('📊 Found', results.length, 'dispatches');
    return results;
}

// Get single dispatch
export async function getDispatch(year, month, day, dispatchRID) {
    console.log('📋 Getting dispatch:', { year, month, day, dispatchRID });
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const dispatchRef = doc(db, 
        `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`, 
        dispatchRID
    );
    
    const docSnap = await getDoc(dispatchRef);
    if (docSnap.exists()) {
        console.log('✅ Dispatch found');
        return {
            id: docSnap.id,
            ...docSnap.data(),
            year,
            month,
            day
        };
    }
    
    console.log('❌ Dispatch not found');
    return null;
}

// Assign driver and truck
export async function assignDriverTruck(year, month, day, dispatchRID, driverId, truckId) {
    console.log('👥 Assigning driver and truck:', { driverId, truckId });
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const dispatchRef = doc(db, 
        `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`, 
        dispatchRID
    );
    
    // Get driver and truck info for note
    const driverDoc = await getDoc(doc(db, `companies/${companyRID}/drivers`, driverId));
    const truckDoc = await getDoc(doc(db, `companies/${companyRID}/trucks`, truckId));
    
    const driverName = driverDoc.exists() ? driverDoc.data().displayName : 'Unknown Driver';
    const truckUnit = truckDoc.exists() ? truckDoc.data().unitNo : 'Unknown Truck';
    
    const currentDispatch = await getDispatch(year, month, day, dispatchRID);
    const notes = currentDispatch?.notes || [];
    
    notes.push({
        byUid: user.uid,
        byRole: getCurrentRole(),
        text: `Assigned to ${driverName} with truck ${truckUnit}`,
        ts: serverTimestamp()
    });
    
    await updateDoc(dispatchRef, {
        driverId: driverId,
        truckId: truckId,
        status: 'Assigned',
        statusColor: 'info',
        notes: notes,
        updatedAt: serverTimestamp()
    });
    
    console.log('✅ Assignment completed');
}

// Change dispatch status
export async function changeStatus(year, month, day, dispatchRID, newStatus, noteText) {
    console.log('🔄 Changing status to:', newStatus);
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    const role = getCurrentRole();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    // Status color mapping
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
    
    const dispatchRef = doc(db, 
        `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`, 
        dispatchRID
    );
    
    const currentDispatch = await getDispatch(year, month, day, dispatchRID);
    const notes = currentDispatch?.notes || [];
    
    if (noteText) {
        notes.push({
            byUid: user.uid,
            byRole: role,
            text: noteText,
            ts: serverTimestamp()
        });
    }
    
    await updateDoc(dispatchRef, {
        status: newStatus,
        statusColor: statusColors[newStatus] || 'secondary',
        notes: notes,
        updatedAt: serverTimestamp()
    });
    
    console.log('✅ Status changed successfully');
}

// Add note to dispatch
export async function appendNote(year, month, day, dispatchRID, noteText) {
    console.log('📝 Adding note to dispatch');
    
    const user = getCurrentUser();
    const role = getCurrentRole();
    
    if (!user) {
        throw new Error('Authentication required');
    }
    
    const currentDispatch = await getDispatch(year, month, day, dispatchRID);
    const notes = currentDispatch?.notes || [];
    
    notes.push({
        byUid: user.uid,
        byRole: role,
        text: noteText,
        ts: serverTimestamp()
    });
    
    await updateDispatch(year, month, day, dispatchRID, { notes });
    console.log('✅ Note added successfully');
}

// Update live location
export async function updateLiveLocation(year, month, day, dispatchRID, lat, lng) {
    console.log('📍 Updating live location:', { lat, lng });
    
    await updateDispatch(year, month, day, dispatchRID, {
        'live.lastKnownLat': lat,
        'live.lastKnownLng': lng,
        'live.lastLiveTs': serverTimestamp()
    });
    
    console.log('✅ Live location updated');
}

// Get drivers
export async function listDrivers() {
    console.log('👥 Listing drivers');
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const driversRef = collection(db, `companies/${companyRID}/drivers`);
    const q = query(driversRef, where('active', '==', true), orderBy('displayName'));
    
    const snapshot = await getDocs(q);
    const drivers = [];
    snapshot.forEach(doc => {
        drivers.push({
            id: doc.id,
            ...doc.data()
        });
    });
    
    console.log('👥 Found', drivers.length, 'drivers');
    return drivers;
}

// Get trucks
export async function listTrucks() {
    console.log('🚛 Listing trucks');
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const trucksRef = collection(db, `companies/${companyRID}/trucks`);
    const q = query(trucksRef, where('active', '==', true), orderBy('unitNo'));
    
    const snapshot = await getDocs(q);
    const trucks = [];
    snapshot.forEach(doc => {
        trucks.push({
            id: doc.id,
            ...doc.data()
        });
    });
    
    console.log('🚛 Found', trucks.length, 'trucks');
    return trucks;
}

// Get company users
export async function listCompanyUsers() {
    console.log('👥 Listing company users');
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const usersRef = collection(db, `companies/${companyRID}/users`);
    const q = query(usersRef, orderBy('displayName'));
    
    const snapshot = await getDocs(q);
    const users = [];
    snapshot.forEach(doc => {
        users.push({
            id: doc.id,
            ...doc.data()
        });
    });
    
    console.log('👥 Found', users.length, 'users');
    return users;
}

// Update company profile
export async function updateCompanyProfile(companyData) {
    console.log('🏢 Updating company profile');
    
    const companyRID = getCurrentCompanyRID();
    const user = getCurrentUser();
    
    if (!companyRID || !user) {
        throw new Error('Authentication required');
    }
    
    const companyRef = doc(db, 'companies', companyRID);
    await setDoc(companyRef, {
        ...companyData,
        updatedAt: serverTimestamp()
    }, { merge: true });
    
    console.log('✅ Company profile updated');
}

// Exports for backward compatibility
export { getCurrentCompanyRID as getCompanyRID };
export { getCurrentRole as getRole };
export { getUserDoc };