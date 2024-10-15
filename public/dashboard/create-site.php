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

    if(count(Site::get_user_sites($user->id)) >= 3) {
        header('Location: /dashboard/');
        exit;
    }

    if(isset($_POST['submit'])) 
    {
        // Validate label
        if(empty($_POST['label']) || !preg_match('/^[a-zA-Z0-9\s]{1,30}$/', $_POST['label'])) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Invalid website label.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }

        // Validate subdomain
        if(!Site::subdomain_available($_POST['domain'].'.obyte.site')) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Subdomain already registered.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }

        if (!preg_match('/^[a-zA-Z0-9]{1,59}$/', $_POST['domain'])) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Invalid subdomain.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }

        // Validate password
        if (strlen($_POST['password']) < 8) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Password must be at least 8 characters.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }

        if ($_POST['password'] !== $_POST['confirm-password']) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Passwords do not match.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }

        $full_domain = $_POST['domain'].'.obyte.site';
        $internal_id = "obp".(rand(1000, 9999));
        $site = Site::create($_SESSION['userid'], $_POST['label'], $full_domain, $internal_id, $_POST['password']);

        if(!empty($site)) {
            echo '<script>window.location.href = "/dashboard/?site_created=true";</script>';
            exit;
        }

        else {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Internal Error.
                </div>
            </div>
            <script>
                document.getElementById("submit-btn").disabled = false;
            </script>';
            exit;
        }
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
                        <form id="create-site-form" hx-post="/dashboard/create-site" hx-target="#create-site-response" hx-swap="innerHTML">
                            <div id="create-site-response"></div>
                            <div class="mb-3">
                                <label for="label" class="form-label">Website Label</label>
                                <input type="text" class="form-control rounded-0" id="label" name="label" placeholder="My Website" required>
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
                                <button name="submit" id="submit-btn" type="submit" class="btn btn-success w-100 rounded-0">Create Website</button>
                                <script>
                                    document.getElementById('create-site-form').addEventListener('submit', function() {
                                        document.getElementById('submit-btn').disabled = true;
                                    });
                                </script>
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