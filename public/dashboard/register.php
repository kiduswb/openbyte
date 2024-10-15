<?php 

    require_once 'lib/OpenByte.php';
    require_once 'lib/Emails.php';

    if(isset($_SESSION['userid'])) {
        header('Location: /dashboard/');
        exit;
    }

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password != $confirmPassword) {
            echo '
            <div class="mb-3">
                <div class="alert bg-danger rounded-0 border-0 text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Passwords do not match.
                </div>
            </div>';
            exit;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '
            <div class="mb-3">
                <div class="alert bg-danger rounded-0 border-0 text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Invalid email address.
                </div>
            </div>';
            exit;
        }

        if(strlen($password) < 8) {
            echo '
            <div class="mb-3">
                <div class="alert bg-danger rounded-0 border-0 text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Password must be at least 8 characters.
                </div>
            </div>';
            exit;
        }

        if(User::check_email_exists($email)) {
            echo '
            <div class="mb-3">
                <div class="alert bg-danger rounded-0 border-0 text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Email already exists.
                </div>
            </div>';
            exit;
        }

        $userid = User::register($email, $password);

        if($userid == '') {
            echo '
            <div class="mb-3">
                <div class="alert bg-danger rounded-0 border-0 text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    There was an error processing your request.
                </div>
            </div>';
            exit;
        }

    
        // Send verification link

        $user = new User($userid);
        sendTransactionalEmail($user->email, "Verify your OpenByte Hosting Account", generateVerificationEmail($userid));

        $_SESSION['userid'] = $userid;
        echo '<script>window.location.href = "/dashboard/";</script>';
        exit;
    }

    $pageTitle = "Register - OpenByte Hosting";
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

                        <h4 class="card-title text-center">Create an Account</h4>
                        <form hx-post="/dashboard/register" hx-target="#error-msg" hx-swap="innerHTML">
                            <div id="error-msg"></div>
                            <div class="mb-3">
                                <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="email@example.com" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Enter Password" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-0" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                            <div class="mb-3 d-flex justify-content-center flex-column gap-3">
                                <p>By creating an account, you agree to our <a href="/terms" class="link">Terms of Service</a> and <a href="/privacy" class="link">Privacy Policy</a>.</p>
                                <button type="submit" name="submit" class="btn btn-outline-success rounded-0">Create Account <i class="fas fa-user-plus fa-fw ms-2"></i></button>
                                <a href="/dashboard/login" class="btn btn-outline-prussian-blue rounded-0">Login <i class="fas fa-sign-in-alt fa-fw ms-2"></i></a>
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