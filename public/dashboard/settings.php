<?php 

    require_once 'lib/OpenByte.php';
    require_once 'lib/Emails.php';

    if(!isset($_SESSION['userid'])) {
        header('Location: /dashboard/login/?auth=false');
        exit;
    }

    $user = new User($_SESSION['userid']);

    // Handle updating account password:
    if(isset($_POST['updatePassword'])) 
    {
        // Validate Password
        if(!User::login($user->email, $_POST['password']))
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Incorrect password.
            </div>
            ';
            exit;
        }

        if($_POST['new-password'] != $_POST['confirm-password'])
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Passwords don\'t match.
            </div>
            ';
            exit;
        }

        if(strlen($_POST['new-password']) < 8)
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Your password must be at least 8 characters.
            </div>
            ';
            exit;
        }

        // Update Password
        $user->pwd_hash = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
        
        if(!$user->update())
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Error processing request.
            </div>
            ';
            exit;
        }

        echo '
        <div class="alert bg-success rounded-0 border-0 text-white">
            <i class="fas fa-info-circle me-1"></i>
            Password updated successfully.
        </div>
        ';
        exit;

    }

    // Handle updating email address:
    if(isset($_POST['updateEmail']))
    {
        // Validate email address
        if(User::check_email_exists($_POST['newemail']))
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                This email address is already in use.
            </div>
            ';
            exit;
        }

        if(!filter_var($_POST['newemail'], FILTER_VALIDATE_EMAIL)) {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Invalid email address.
            </div>
            ';
            exit;
        }

        // Validate password
        if(!User::login($user->email, $_POST['password']))
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Incorrect password.
            </div>
            ';
            exit;
        }

        // Update email address
        $user->email = $_POST['newemail'];
        $user->is_verified = 0;

        if(!$user->update())
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Error processing request.
            </div>
            ';
            exit;
        }

        echo '
        <div class="alert bg-success rounded-0 border-0 text-white">
            <i class="fas fa-info-circle me-1"></i>
            Email address updated successfully. Please check your inbox for a verification link.
        </div>
        <script>
            document.getElementById("userEmail").textContent = "'.$user->email.'";
        </script>
        ';

        sendTransactionalEmail($user->email, "Verify your OpenByte Hosting Account", generateVerificationEmail($userid));

        exit;
    }

    // Handle resending verification link email:
    if(isset($_POST['resendVerificationLink'])) 
    {
        // Failsafe
        if($user->is_verified) exit;

        // Validate reCaptcha
        $recaptchaSecretKey = $_ENV['RECAPTCHA_SECRET_KEY'];
		$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

		$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
		$recaptchaData = [
			'secret' => $recaptchaSecretKey,
			'response' => $recaptchaResponse,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		];

		$recaptchaOptions = [
			'http' => [
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($recaptchaData)
			]
		];

		$recaptchaContext = stream_context_create($recaptchaOptions);
		$recaptchaResult = file_get_contents($recaptchaUrl, false, $recaptchaContext);
		$recaptchaJson = json_decode($recaptchaResult);

        if ($recaptchaJson->success !== true) {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Please complete reCaptcha.
            </div>
            ';
            exit;
        }

        // Resend Email
        sendTransactionalEmail($user->email, "Verify your OpenByte Hosting Account", generateVerificationEmail($userid));
        echo '
        <div class="alert bg-success rounded-0 border-0 text-white">
            <i class="fas fa-info-circle me-1"></i>
            Verification link has been sent to your email. Please don\'t forget
            to check your spam folder.
        </div>
        <script>
            document.getElementById("resendEmailBtn").disabled = true;
        </script>
        ';
        exit;
        
    }

    $pageTitle = "Account Settings - OpenByte Hosting";
    $activePage = "settings";
    include "header.php";

?>

<body class="d-flex flex-column min-vh-100">
    <?php include "navbar.php"; ?>

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h2>Manage Account</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 ms-auto">
                <div class="d-flex flex-column gap-3">

                    <div class="col-lg-12">
                        <div class="card p-1 border-dark rounded-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Update Password</h5>
                                <form hx-post="/dashboard/settings" hx-target="#update-account-password-msg" hx-swap="innerHTML">
                                    <div class="mb-3">
                                        <div id="update-account-password-msg"></div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="currentPassword" name="password" placeholder="Enter your current password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="newPassword" name="new-password" placeholder="Enter your new password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="confirmPassword" name="confirm-password" placeholder="Confirm your new password">
                                    </div>
                                    <button type="submit" name="updatePassword" class="btn btn-dark w-100 rounded-0"><i class="fa fa-lock me-2"></i> Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <div class="card p-2 border-dark rounded-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Update Email Address</h5>
                                <form hx-post="/dashboard/settings" hx-target="#update-email-msg" hx-swap="innerHTML">
                                    <div class="mb-3">
                                        <div id="update-email-msg"></div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control rounded-0" id="newEmail" name="newemail" placeholder="Enter New Email Address">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Enter Password">
                                    </div>
                                    <button type="submit" name="updateEmail" class="btn btn-dark w-100 rounded-0"><i class="fa fa-envelope me-2"></i> Update Email</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 me-auto">
                <div class="d-flex flex-column gap-3">

                    <div class="col-lg-12">
                        <div class="card p-2 border-dark rounded-0">
                            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                <i class="fa-regular fa-user-circle fa-4x mb-4"></i>
                                <p>
                                    <span id="userEmail"><?php echo $user->email; ?></span>
                                    <?php if($user->is_verified == 1): ?>
                                        <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                    <?php else: ?>
                                        <span class="badge bg-warning-custom rounded-0 ms-1">Unverified</span>
                                    <?php endif; ?>
                                </p>

                                <?php if($user->is_verified == 0): ?>
                                <form hx-post="/dashboard/settings" hx-target="#resend-verif-msg" hx-swap="innerHTML">
                                    <div class="mb-3">
                                        <div id="resend-verif-msg"></div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
                                    </div>
                                    <div class="mb-3">
                                        <button id="resendEmailBtn" type="submit" name="resendVerificationLink" class="btn btn-dark w-100 rounded-0">
                                            <i class="fa fa-envelope-circle-check me-2"></i> Resend Verification Link
                                        </button>
                                    </div>
                                </form>
                                <?php endif; ?>

                                <p>Member since <?php echo date("M d, Y", $user->timestamp) ?></p>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card p-1 border-dark rounded-0">
                            <div class="card-body">
                                <h5 class="card-title">Danger Zone</h5>
                                <p class="card-text">Delete your account and all of your data.</p>
                                <button class="btn btn-danger w-100 rounded-0" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="fa fa-trash me-2"></i> Delete Account
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete your account?</p>
                    <ul>
                        <li>Your websites will be permanently deleted</li>
                        <li>Your account data will be permanently deleted</li>
                        <li>You will lose access to all of your cPanel logins</li>
                        <li>Your subdomains will be unavailable for registration for up to 60 days</li>
                    </ul>
                    <p><b>This action cannot be undone.</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded-0 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="/dashboard/settings/delete-account/<?php echo $user->id; ?>" class="btn rounded-0 btn-danger">Delete Account</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "footer.php"; ?>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>
