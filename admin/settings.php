<?php
$pageTitle = "System Settings - Captain Dispatch";
$currentPage = "settings";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">System Settings</h1>
            </div>

            <!-- System Configuration -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Configuration</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Advanced system settings and configuration options coming soon.
                    </div>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-cog fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">System Settings</h5>
                        <p class="text-muted">Advanced configuration options will be available in the next update.</p>
                        <div class="mt-4">
                            <small class="text-muted">Developed by <strong>PanesarElite</strong></small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script>
// System Settings - Developed by PanesarElite
console.log('System Settings module loaded - Developed by PanesarElite');
</script>