<?php
$pageTitle = "Dispatch Reports - Captain Dispatch";
$currentPage = "dispatch-reports";
include '../customer-php/header.php';
include '../customer-php/top-nav-bar.php';
?>

<div class="container-fluid">
    <div class="row">
        <?php include '../customer-php/menu.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dispatch Reports</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary">
                        <i class="fa-solid fa-download"></i> Generate Report
                    </button>
                </div>
            </div>

            <!-- Report Filters -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Report Parameters</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="reportType" class="form-label">Report Type</label>
                                <select class="form-select" id="reportType">
                                    <option value="summary">Dispatch Summary</option>
                                    <option value="detailed">Detailed Report</option>
                                    <option value="performance">Performance Analysis</option>
                                    <option value="financial">Financial Summary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dateFrom" class="form-label">Date From</label>
                                <input type="date" class="form-control" id="dateFrom">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dateTo" class="form-label">Date To</label>
                                <input type="date" class="form-control" id="dateTo">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="format" class="form-label">Format</label>
                                <select class="form-select" id="format">
                                    <option value="pdf">PDF</option>
                                    <option value="csv">CSV</option>
                                    <option value="excel">Excel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Advanced reporting functionality is coming soon. This will include comprehensive analytics, performance metrics, and financial summaries.
                    </div>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Reporting Module</h5>
                        <p class="text-muted">Comprehensive reporting and analytics features will be available in the next update.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../customer-php/footer.php'; ?>

<script>
// Dispatch Reports - Developed by PanesarElite
console.log('Reports module loaded - Developed by PanesarElite');
</script>