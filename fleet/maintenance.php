<?php
$pageTitle = "Maintenance - Captain Dispatch";
$currentPage = "maintenance";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Fleet Maintenance</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Schedule Maintenance
                    </button>
                </div>
            </div>

            <!-- Maintenance Overview -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Due Soon</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Overdue</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Scheduled</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Schedule -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Maintenance Schedule</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Maintenance management functionality is coming soon. This will include scheduling, tracking, and reporting for all fleet vehicles.
                    </div>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-wrench fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Maintenance Module</h5>
                        <p class="text-muted">Advanced maintenance scheduling and tracking features will be available in the next update.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script>
// Maintenance Management - Developed by PanesarElite
console.log('Maintenance module loaded - Developed by PanesarElite');
</script>