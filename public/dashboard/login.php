<?php 
    $pageTitle = "Login - OpenByte Hosting";
    include 'header.php';
?>
<body class="d-flex flex-column min-vh-100 body-bg-space">

    <section class="container py-5">
        <div class="row py-5">
            <div class="col-lg-4 mx-auto">
                <div class="card shadow border-0 rounded-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body d-flex flex-column justify-content-center gap-3">
                        
                        <div class="d-flex flex-column align-items-center mb-3">
                            <h2 class="text-center logo-font">OpenByte</h2>
                            <a href="/" class="text-center link d-block">&larr; Back to Home</a>
                        </div>

                        <h4 class="card-title text-center">Dashboard Login</h4>
                        <form action="/dashboard/login" method="POST">
                            <?php if (isset($error)): ?>
                                <div class="mb-3">
                                    <div class="alert bg-danger rounded-0 border-0 text-white">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <?php echo $error; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($redirectMsg)): ?>
                                <div class="mb-3">
                                    <div class="alert bg-warning-custom rounded-0 border-0 text-white">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <?php echo $redirectMsg; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="email@example.com" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Enter Password" required>
                            </div>
                            <div class="mb-3 d-flex justify-content-center flex-wrap gap-3">
                                <button type="submit" class="btn btn-success rounded-0">Login <i class="fas fa-sign-in-alt fa-fw ms-2"></i></button>
                                <a href="/dashboard/register" class="btn btn-outline-prussian-blue rounded-0">Register <i class="fas fa-user-plus fa-fw ms-2"></i></a>
                                <a href="/dashboard/forgot-password" class="text-center link d-block mt-3">Forgot Password?</a>
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
