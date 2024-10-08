<?php 

    require_once 'lib/OpenByte.php';

    if(!isset($_SESSION['userid'])) {
        header('Location: /dashboard/login/?auth=false');
        exit;
    }

    $user = new User($_SESSION['userid']);

    if(!$user->is_verified) {
        header('Location: /dashboard/');
        exit;
    }

    $pageTitle = "Create Site - OpenByte Hosting";
    include 'header.php';
?>
<body class="d-flex flex-column min-vh-100">

    <?php include 'navbar.php'; ?>

    <section class="container py-5">
        <div class="row mb-5" data-aos="fade-in">
            <div class="col-lg-12 text-center mb-4">
                <h2>Create New Website</h2>
            </div>
            <div class="col-lg-6 mx-auto">
                <div class="card p-2 rounded-0">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3 d-none">
                                <div class="alert rounded-0 bg-danger text-white">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Error Message
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="domain" class="form-label">Create Subdomain</label>
                                <div class="input-group">
                                    <input type="text" class="form-control rounded-0" id="domain" name="domain" placeholder="example" required>
                                    <span class="input-group-text rounded-0">.obyte.site</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">cPanel Username</label>
                                <input type="text" disabled class="form-control rounded-0" placeholder="Generated Automatically">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">cPanel, MySQL and FTP Password</label>
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Create Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control rounded-0" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                            </div>
                            <div class="mt-2 mb-3">
                                <button type="submit" class="btn btn-success w-100 rounded-0">Create Website</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>