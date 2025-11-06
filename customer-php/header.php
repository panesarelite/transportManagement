<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Captain Dispatch'; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Theme -->
    <link rel="stylesheet" href="/site/final/captain/assets/css/theme.css">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/site/final/captain/assets/img/star.svg">

    <!-- Firebase SDK -->
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.2/firebase-firestore-compat.js"></script>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: linear-gradient(180deg, #6A307E 0%, #3B256E 100%);
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-left: 3px solid transparent;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #ff6b6b;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: #ff6b6b;
        }

        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }

        .collapse-item {
            display: block;
            padding: 0.5rem 1rem 0.5rem 3rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .collapse-item:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        main {
            margin-left: 16.66667%;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -100%;
            }
            main {
                margin-left: 0;
            }
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }
    </style>

    <!-- Firebase Initialization Script -->
    <script>
        console.log('🔥 Initializing Firebase - PanesarElite');

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyAp2XMMtts117nO7vRZxuU-rn10Fx6cPRo",
            authDomain: "dispatch-management-pec.firebaseapp.com",
            databaseURL: "https://dispatch-management-pec-default-rtdb.firebaseio.com",
            projectId: "dispatch-management-pec",
            storageBucket: "dispatch-management-pec.appspot.com",
            messagingSenderId: "935397115682",
            appId: "1:935397115682:web:4fcb5fde4467265a9b077b",
            measurementId: "G-0KZKQ1YC4M"
        };

        // Wait for Firebase SDK to load
        function initializeFirebaseApp() {
            if (typeof firebase === 'undefined') {
                console.log('⏳ Waiting for Firebase SDK...');
                setTimeout(initializeFirebaseApp, 100);
                return;
            }

            try {
                console.log('📦 Firebase SDK loaded, initializing...');

                // Initialize Firebase
                const app = firebase.initializeApp(firebaseConfig);
                window.firebaseApp = app;

                // Initialize Auth
                window.firebaseAuth = firebase.auth();

                // Initialize Firestore
                window.firebaseDb = firebase.firestore();

                console.log('✅ Firebase initialized successfully');
                console.log('📋 Project ID:', app.options.projectId);

                // Set global flag
                window.firebaseReady = true;

                // Dispatch event for other scripts
                window.dispatchEvent(new Event('firebaseReady'));

            } catch (error) {
                console.error('❌ Firebase initialization failed:', error);
                alert('Firebase initialization failed: ' + error.message);
            }
        }

        // Start initialization
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeFirebaseApp);
        } else {
            initializeFirebaseApp();
        }
    </script>
</head>
<body>
