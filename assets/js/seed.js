// Sample data seeding - Developed by PanesarElite
import { 
    collection, 
    doc, 
    setDoc, 
    writeBatch,
    serverTimestamp 
} from 'https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore.js';
import { getCurrentCompanyRID, getCurrentUser } from './auth.js';
import { showToast, showLoading, hideLoading } from './ui.js';

const db = window.firebaseDb;

export async function seedSampleData() {
    try {
        const user = getCurrentUser();
        if (!user) {
            showToast('Please log in to seed data', 'error');
            return;
        }
        
        showLoading('Seeding sample data...');
        
        const companyRID = getCurrentCompanyRID();
        if (!companyRID) {
            throw new Error('No company RID available');
        }

        const batch = writeBatch(db);

        // Create demo users first
        const demoUsers = [
            {
                id: 'admin_demo',
                displayName: 'Admin User',
                email: 'admin@captaintransport.com',
                role: 'admin',
                companyRID: companyRID,
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'dispatcher_demo',
                displayName: 'Dispatcher User',
                email: 'dispatcher@captaintransport.com',
                role: 'dispatcher',
                companyRID: companyRID,
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'driver_demo',
                displayName: 'Driver User',
                email: 'driver@captaintransport.com',
                role: 'driver',
                companyRID: companyRID,
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'customer_demo',
                displayName: 'Customer User',
                email: 'customer@captaintransport.com',
                role: 'customer',
                companyRID: companyRID,
                active: true,
                createdAt: serverTimestamp()
            }
        ];

        demoUsers.forEach(user => {
            const userRef = doc(db, `companies/${companyRID}/users`, user.id);
            batch.set(userRef, user);
        });

        // Sample drivers
        const drivers = [
            {
                id: 'driver1',
                displayName: 'John Smith',
                email: 'john.smith@captaintransport.com',
                phone: '+15551234567',
                licenseNumber: 'AB123456789',
                licenseClass: 'Class 1',
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'driver2',
                displayName: 'Sarah Johnson',
                email: 'sarah.johnson@captaintransport.com',
                phone: '+15559876543',
                licenseNumber: 'AB987654321',
                licenseClass: 'Class 1',
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'driver3',
                displayName: 'Mike Wilson',
                email: 'mike.wilson@captaintransport.com',
                phone: '+15555551234',
                licenseNumber: 'AB456789123',
                licenseClass: 'Class 1',
                active: true,
                createdAt: serverTimestamp()
            }
        ];

        drivers.forEach(driver => {
            const driverRef = doc(db, `companies/${companyRID}/drivers`, driver.id);
            batch.set(driverRef, driver);
        });

        // Sample trucks
        const trucks = [
            {
                id: 'truck1',
                unitNo: 'T001',
                make: 'Freightliner',
                model: 'Cascadia',
                year: 2022,
                vin: '1FUJGHDV8NLAA1234',
                plateNumber: 'AB-1234',
                reeferCapable: true,
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'truck2',
                unitNo: 'T002',
                make: 'Peterbilt',
                model: '579',
                year: 2021,
                vin: '1XP5DB9X5MD123456',
                plateNumber: 'AB-5678',
                reeferCapable: false,
                active: true,
                createdAt: serverTimestamp()
            },
            {
                id: 'truck3',
                unitNo: 'T003',
                make: 'Kenworth',
                model: 'T680',
                year: 2023,
                vin: '1XKYDP9X5NJ654321',
                plateNumber: 'AB-9012',
                reeferCapable: true,
                active: true,
                createdAt: serverTimestamp()
            }
        ];

        trucks.forEach(truck => {
            const truckRef = doc(db, `companies/${companyRID}/trucks`, truck.id);
            batch.set(truckRef, truck);
        });

        // Sample dispatches for today
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');
        const dateStr = `${year}-${month}-${day}`;

        const dispatches = [
            {
                id: 'dispatch1',
                customerID: companyRID,
                scheduleKey: `${year}/${month}/${day}`,
                dateStart: dateStr,
                timeStart: '08:00',
                startLocation: 'Calgary, AB, Canada',
                destinationAddress: 'Edmonton, AB, Canada',
                contactPerson: 'Jane Doe',
                contactPhone: '+15551112222',
                taskType: 'Highway',
                reeferRequired: false,
                dangerousGoods: 'No',
                status: 'Assigned',
                statusColor: 'info',
                driverId: 'driver1',
                truckId: 'truck1',
                notes: [
                    {
                        byUid: 'system',
                        byRole: 'system',
                        text: 'Dispatch created and assigned to John Smith with truck T001',
                        ts: serverTimestamp()
                    }
                ],
                createdAt: serverTimestamp(),
                updatedAt: serverTimestamp()
            },
            {
                id: 'dispatch2',
                customerID: companyRID,
                scheduleKey: `${year}/${month}/${day}`,
                dateStart: dateStr,
                timeStart: '10:30',
                startLocation: 'Calgary, AB, Canada',
                destinationAddress: 'Vancouver, BC, Canada',
                contactPerson: 'Bob Smith',
                contactPhone: '+15553334444',
                taskType: 'Highway + City',
                reeferRequired: true,
                dangerousGoods: 'Class 3 - Flammable Liquids',
                status: 'En Route',
                statusColor: 'warning',
                driverId: 'driver2',
                truckId: 'truck3',
                notes: [
                    {
                        byUid: 'system',
                        byRole: 'system',
                        text: 'Dispatch created and assigned to Sarah Johnson with truck T003',
                        ts: serverTimestamp()
                    },
                    {
                        byUid: 'system',
                        byRole: 'system',
                        text: 'Driver departed from origin',
                        ts: serverTimestamp()
                    }
                ],
                live: {
                    lastKnownLat: 51.2538,
                    lastKnownLng: -113.5000,
                    lastLiveTs: serverTimestamp()
                },
                createdAt: serverTimestamp(),
                updatedAt: serverTimestamp()
            },
            {
                id: 'dispatch3',
                customerID: companyRID,
                scheduleKey: `${year}/${month}/${day}`,
                dateStart: dateStr,
                timeStart: '14:00',
                startLocation: 'Calgary, AB, Canada',
                destinationAddress: 'Toronto, ON, Canada',
                contactPerson: 'Alice Brown',
                contactPhone: '+15555556666',
                taskType: 'Highway',
                reeferRequired: false,
                dangerousGoods: 'No',
                status: 'New',
                statusColor: 'secondary',
                notes: [],
                createdAt: serverTimestamp(),
                updatedAt: serverTimestamp()
            }
        ];

        dispatches.forEach(dispatch => {
            const dispatchRef = doc(db, 
                `customer-management/customers/${companyRID}/departments/dispatch/${year}/${month}/${day}/dispatches`, 
                dispatch.id
            );
            batch.set(dispatchRef, dispatch);
        });

        await batch.commit();
        
        hideLoading();
        showToast('Sample data seeded successfully!', 'success');
        
        // Refresh the page to show new data
        setTimeout(() => {
            window.location.reload();
        }, 1000);
        
    } catch (error) {
        console.error('Error seeding data:', error);
        hideLoading();
        showToast('Error seeding sample data: ' + error.message, 'error');
    }
}

// Seed function for company setup
export async function seedCompanyData(companyRID, companyData) {
    try {
        const batch = writeBatch(db);
        
        // Create company document
        const companyRef = doc(db, 'companies', companyRID);
        batch.set(companyRef, {
            ...companyData,
            createdAt: serverTimestamp(),
            updatedAt: serverTimestamp()
        });
        
        await batch.commit();
        
        showToast('Company data initialized successfully!', 'success');
        
    } catch (error) {
        console.error('Error seeding company data:', error);
        showToast('Error initializing company data: ' + error.message, 'error');
    }
}