<?php 

    require_once 'lib/OpenByte.php';
    require_once 'lib/Emails.php';

    if(isset($_SESSION['userid']))
    {
        header('Location: /dashboard/');
        exit;
    }

    // Process sending reset code email
    if(isset($_POST['sendResetCode']))
    {
        // Validate email
        if(!User::check_email_exists($_POST['email']))
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Invalid email or password.
            </div>
            ';
            exit;
        }

        $user = User::get(User::get_id_by_email($_POST['email']));
        
        if($user == null)
        {
            echo '
            <div class="alert bg-danger rounded-0 border-0 text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error processing request.
            </div>
            ';
            exit;
        }

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

        // Send email
        sendTransactionalEmail($user->email, "Your OpenByte Hosting Password Reset Code", generatePasswordResetEmail(User::generate_reset_token($user->id)));
        echo '<script>window.location.href = "/dashboard/reset-password/' . $user->id . '";</script>';
        exit;
    }

    $pageTitle = "Forgot Password - OpenByte Hosting";
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

                    <h4 class="card-title text-center">Forgot Password?</h4>
                    <form hx-post="/dashboard/forgot-password" hx-target="#fp-err-msg" hx-swap="innerHTML">
                        <div class="mb-3">
                            <p>Enter the email address you registered with and you'll receive an email with a code to reset your password.</p>
                        </div>
                        <div class="mb-3">
                            <div id="fp-err-msg"></div>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="Your Email Address" required>
                        </div>
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
                        </div>
                        <div class="mb-3 d-flex justify-content-center flex-wrap gap-3">
                            <button name="sendResetCode" type="submit" class="btn btn-outline-prussian-blue rounded-0"><i class="fa fa-envelope-circle-check me-1"></i> Send Reset Code</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
</html>