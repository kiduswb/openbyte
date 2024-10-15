<?php 

    require_once 'lib/OpenByte.php';
    require_once 'lib/Emails.php';

    if(isset($_SESSION['userid']))
    {
        header('Location: /dashboard/');
        exit;
    }

    $user = User::get($userid);

    if($user == null) {
        header('Location: /404');
        exit;
    }

    // Process password reset
    if(isset($_POST['resetPassword']))
    {
        // Validate password
        if($_POST['new-password'] != $_POST['confirm-password'])
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Passwords do not match.
            </div>
            ';
            exit;
        }

        if(strlen($_POST['new-password']) < 8) {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Password must be at least 8 characters.
            </div>
            ';
            exit;
        }

        // Validate token
        if(User::validate_reset_token($user->id, $_POST['token']))
        {
            $user->pwd_hash = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
            $user->update();
            $user->delete_token();
            echo '<script>window.location.href = "/dashboard/login/?reset=true";</script>';
            exit;
        }

        else
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Invalid password reset code.
            </div>
            ';
            exit;
        }
    }

    $pageTitle = "Reset Password - OpenByte Hosting";
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
                        <a href="/dashboard/login" class="text-center link d-block">&larr; Back to Login</a>
                    </div>

                    <h4 class="card-title text-center">Reset Password</h4>
                    <form hx-post="/dashboard/reset-password/<?php echo $user->id; ?>" hx-target="#reset-err-msg" hx-swap="innerHTML">
                        <div class="mb-3">
                            <p>Enter the email address you registered with and you'll receive an email with a code to reset your password.</p>
                        </div>
                        <div class="mb-3">
                            <div id="reset-err-msg"></div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-0" id="token" name="token" placeholder="Password Reset Code" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control rounded-0" id="password" name="new-password" placeholder="New Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control rounded-0" id="confirm-password" name="confirm-password" placeholder="Confirm New Password" required>
                        </div>
                        <div class="mb-4 d-flex justify-content-center flex-wrap gap-3">
                            <button name="resetPassword" type="submit" class="btn btn-outline-prussian-blue rounded-0"><i class="fa fa-lock me-1"></i> Reset Password</button>
                        </div>
                        <div class="text-center">
                            Didn't get the email? <a href="/dashboard/forgot-password" class="link">Resend Code</a>
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