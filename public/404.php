<?php 
    $pageTitle = '404 - Page Not Found';
    include 'main/header.php';
?>
<body class="d-flex flex-column min-vh-100 body-bg-space">

    <?php include 'main/navbar.php'; ?>

    <div class="container py-5 text-white">
        <div class="row py-5 mb-5">
            <div class="col-lg-9 mx-auto" data-aos="fade-up" data-aos-delay="100">
                <h1 class="display-1 fw-bold">404 - Not Found</h1>
                <p class="lead">The page you are looking for does not exist.</p>
                <a href="/" class="btn btn-light btn-lg rounded-0">
                    <i class="fa fa-arrow-left me-3"></i>
                    Return Home
                </a>
            </div>
        </div>
    </div>

    <?php include 'main/footer.php'; ?>

</body>
</html>
