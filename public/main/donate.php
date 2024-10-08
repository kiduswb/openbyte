<?php 
    $pageTitle = 'OpenByte Hosting - Contribute';
    $activePage = 'donate';
    include 'header.php';
?>
<body class="d-flex flex-column min-vh-100 body-bg-space">
    <?php include 'navbar.php'; ?>

    <section class="container py-5">
        <div class="row py-5">
            <div class="col-lg-12 mx-auto">
                <div class="card bg-columbia-blue shadow rounded-0 p-3" data-aos="fade-up">
                    <div class="card-body">
                        <h1 class="py-1">Enjoying OpenByte's services?</h1>
                        <p class="lead">
                            OpenByte's hosting bills and other costs are fully covered by the developer.
                            We run absolutely no ads whatsoever on hosted websites. If you'd like to 
                            donate to help with the costs, you can do by sponsoring the developer on GitHub.
                            If you're a developer, you can also contribute to the project on GitHub.
                        </p>
                        <br />
                        <div class="d-flex gap-2">
                            <a href="https://github.com/sponsors/kiduswb" target="_blank" class="btn btn-light rounded-0">
                                Sponsor &nbsp;<i class="fa-regular fa-heart text-danger"></i>
                            </a>
                            <a href="https://github.com/kiduswb/openbyte" target="_blank" class="btn btn-dark rounded-0">
                                Contribute &nbsp;<i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>