<?php 
    $pageTitle = "[Site] - OpenByte Hosting";
    include 'header.php';
?>
<body class="d-flex flex-column min-vh-100">

    <?php include 'navbar.php'; ?>

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h2>Manage Website</h2>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <div class="card p-2 rounded-0 border-dark">
                            <div class="card-body">
                                <div class="nav nav-pills d-flex flex-column align-items-center gap-3 rounded-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link rounded-0 w-100 bg-dark active text-white" id="v-pills-overview-tab" data-bs-toggle="pill" data-bs-target="#v-pills-overview" type="button" role="tab" aria-controls="v-pills-overview" aria-selected="true"><i class="fa fa-info-circle me-2"></i> Overview</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-files-tab" data-bs-toggle="pill" data-bs-target="#v-pills-files" type="button" role="tab" aria-controls="v-pills-files" aria-selected="false"><i class="fa fa-file-alt me-2"></i> FTP Connection</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-database-tab" data-bs-toggle="pill" data-bs-target="#v-pills-database" type="button" role="tab" aria-controls="v-pills-database" aria-selected="false"><i class="fa fa-database me-2"></i> MySQL Connection</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-cog me-2"></i> Website Settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Overview</h5>
                                        <p class="card-text">This is the overview of the website.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-files" role="tabpanel" aria-labelledby="v-pills-files-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">FTP Connection Details</h5>
                                        <p class="card-text">This is the overview of the website.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-database" role="tabpanel" aria-labelledby="v-pills-database-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">MySQL Connection Details</h5>
                                        <p class="card-text">This is the overview of the website.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Website Settings</h5>
                                        <p class="card-text">This is the overview of the website.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>