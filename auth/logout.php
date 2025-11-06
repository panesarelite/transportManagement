<?php
// Logout page - Firebase auth handles the actual logout
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - Captain Dispatch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body text-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <h5>Logging out...</h5>
                        <p class="text-muted">Please wait while we sign you out securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
    import { logout } from '/assets/js/auth.js';
    
    document.addEventListener('DOMContentLoaded', function() {
        // Automatically logout when page loads
        logout();
    });
    </script>
</body>
</html>