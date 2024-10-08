<?php
    $pageTitle = "Dashboard - OpenByte Hosting";
    $activePage = "dashboard";
    include "header.php";
?>
<body class="d-flex flex-column min-vh-100">
    <?php include "navbar.php"; ?>
    
    <section class="container py-5">
        
        <div class="row mb-5">
            <div class="col-lg-12">
                <h2>Welcome!</h2>
            </div>
            <div class="col-lg-12 mt-3" data-aos="fade-in" data-aos-delay="300">
                <div class="alert bg-warning-custom rounded-0 text-white">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Please <a href="/dashboard/settings" class="text-white">verify your account</a> to create and manage your websites.
                </div>
            </div>
            <div class="col-lg-12 mt-3" data-aos="fade-in" data-aos-delay="300">
                <div class="alert bg-success rounded-0 text-white">
                    <i class="fa fa-check-circle me-2"></i>
                    Website created successfully! Please allow up to 72 hours for DNS propagation.
                </div>
            </div>
            <div class="col-lg-12 mt-3" data-aos="fade-in" data-aos-delay="300">
                <div class="alert bg-primary rounded-0 text-white">
                    <i class="fa fa-info-circle me-2"></i>
                    Website [example.com] has been scheduled for deletion.
                </div>
            </div>
        </div>

        <div class="row" data-aos="fade-in">
            <div class="col-lg-4 mb-4">
                <div class="card p-3 rounded-0 border-dotted">
                    <div class="card-body text-center">
                        <i class="fa fa-globe text-success fa-6x mb-3"></i>
                        <div class="mt-4 mb-3">
                            <h4>Site Label</h4>
                            <p><span class="badge bg-success">Active</span></p>
                            <a href="https://www.example.com" target="_blank" class="link">example.com</a>  
                        </div>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/dashboard/site/1" class="btn btn-outline-dark rounded-0"><i class="fa fa-cog me-2"></i> Manage</a>
                            <a href="https://cpanel.obyte.site" target="_blank" class="btn btn-outline-dark rounded-0">
                                <i class="fa fa-arrow-up-right-from-square me-2"></i> cPanel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card p-3 rounded-0 border-dotted">
                    <div class="card-body text-center">
                        <i class="fa fa-globe fa-6x mb-3"></i>
                        <div class="mt-4 mb-3">
                            <h4 class="text-muted">Empty Slot</h4>
                        </div>
                        <div class="mt-4">
                            <a href="/dashboard/create-site" class="btn btn-outline-dark rounded-0"><i class="fa fa-plus-circle me-1"></i> Create Website</a>   
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card p-3 rounded-0 border-dotted">
                    <div class="card-body text-center">
                        <i class="fa fa-globe fa-6x mb-3"></i>
                        <div class="mt-4 mb-3">
                            <h4 class="text-muted">Empty Slot</h4>
                        </div>
                        <div class="mt-4">
                            <a href="/dashboard/create-site" class="btn btn-outline-dark rounded-0"><i class="fa fa-plus-circle me-1"></i> Create Website</a>   
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <p>1/3 Slots Used - <a class="link" href="/premium">Upgrade to Premium</a></p>
            </div>
        </div>
    </section>

    <?php include "footer.php"; ?>
</body>
</html>