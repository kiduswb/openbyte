<?php 

    require_once 'lib/OpenByte.php';

    if(!isset($_SESSION['userid'])) {
        header('Location: /dashboard/login/?auth=false');
        exit;
    }

    $site = Site::get($siteid);

    if($site == null) {
        header('Location: /dashboard/home');
        exit;
    }

    // Handle Update Site Label Request
    if(isset($_POST['updateSiteLabel'])) 
    {
        // Validate label
        if(empty($_POST['label']) || !preg_match('/^[a-zA-Z0-9\s]{1,30}$/', $_POST['label'])) {
            echo 
            '<div class="alert rounded-0 bg-danger text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Invalid website label.
            </div>';
            exit;
        }

        if($site->label == $_POST['label']) exit;

        // Update Label

        $site->label = $_POST['label'];

        if(!$site->update()) {
            echo 
            '<div class="alert rounded-0 bg-danger text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error processing request.
            </div>';
            exit;
        }

        echo 
        '<div class="alert rounded-0 bg-success text-white">
            <i class="fas fa-info-circle me-2"></i>
            Label updated successfully.
        </div>
        <script>document.getElementById("site-label").contentWindow.location.reload(true);</script>
        <script>document.getElementById("updateLabelBtn").disabled = true;</script>
        ';
        exit;
    }

    // Handle Password Update Request
    if(isset($_POST['updatePanelPassword'])) 
    {
        // Validate password
        if (strlen($_POST['password']) < 8) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Password must be at least 8 characters.
                </div>
            </div>';
            exit;
        }

        if ($_POST['password'] !== $_POST['confirm-password']) {
            echo 
            '<div class="mb-3">
                <div class="alert rounded-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Passwords do not match.
                </div>
            </div>';
            exit;
        }

        if($_POST['password'] == $site->cpanel_password) {
            echo 
            '<div class="alert rounded-0 bg-warning-custom text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Please enter a new password.
            </div>';
            exit;
        }

        if(!$site->change_cpanel_password($_POST['password'])) {
            echo 
            '<div class="alert rounded-0 bg-danger text-white">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Error processing request.
            </div>';
            exit;
        }

        $site = Site::get($siteid);

        echo 
        '<div class="alert rounded-0 bg-success text-white">
            <i class="fas fa-info-circle me-2"></i>
            cPanel password updated successfully.
            <script>document.getElementById("cpanelPassword").textContent = "'.$site->cpanel_password.'";</script>
            <script>document.getElementById("ftpPassword").textContent = "'.$site->cpanel_password.'";</script>
            <script>document.getElementById("mysqlPassword").textContent = "'.$site->cpanel_password.'";</script>
            <script>document.getElementById("updatePasswordBtn").disabled = true;</script>
        </div>
        ';
        exit;
    }


    $pageTitle = "$site->label - OpenByte Hosting";
    include 'header.php';

?>
<body class="d-flex flex-column min-vh-100">

    <?php include 'navbar.php'; ?>

    <section class="container py-5">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <h2>Manage Website</h2>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <div class="card p-2 rounded-0 border-dark">
                            <div class="card-body">
                                <div class="nav nav-pills d-flex flex-column align-items-center gap-3 rounded-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <button class="nav-link rounded-0 w-100 bg-dark active text-white" id="v-pills-overview-tab" data-bs-toggle="pill" data-bs-target="#v-pills-overview" type="button" role="tab" aria-controls="v-pills-overview" aria-selected="true"><i class="fa fa-info-circle me-2"></i> Overview</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-files-tab" data-bs-toggle="pill" data-bs-target="#v-pills-files" type="button" role="tab" aria-controls="v-pills-files" aria-selected="false"><i class="fa fa-file-alt me-2"></i> FTP Connection</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-database-tab" data-bs-toggle="pill" data-bs-target="#v-pills-database" type="button" role="tab" aria-controls="v-pills-database" aria-selected="false"><i class="fa fa-database me-2"></i> MySQL Connection</button>
                                    <button class="nav-link rounded-0 w-100 bg-dark text-white" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="fa fa-cog me-2"></i> Website Settings</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-overview" role="tabpanel" aria-labelledby="v-pills-overview-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Overview</h5>
                                        <div class="card-text">
                                            <p>Your website is currently active on <a class="link" href="http://<?php echo $site->subdomain; ?>" target="_blank"><?php echo $site->subdomain; ?></a>.</p>
                                            <div class="border-dotted p-3 mb-3">
                                                <p><b>cPanel Username</b> - <?php echo $site->cpanel_username; ?></p>
                                                <p><b>cPanel Password</b> -
                                                    <span id="cpanelPasswordLabel"><i class="fa fa-eye-slash"></i></span>
                                                    <code id="cpanelPassword" style="display: none;"><?php echo $site->cpanel_password; ?></code>
                                                    <button id="showPasswordBtn" class="btn btn-sm btn-outline-secondary rounded-0 ms-2" onclick="togglePassword()">Show Password</button>
                                                </p>
                                            </div>
                                            <a href="https://cpanel.obyte.site/" target="_blank" class="btn btn-outline-dark rounded-0">
                                                cPanel Login <i class="fa fa-arrow-up-right-from-square ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-files" role="tabpanel" aria-labelledby="v-pills-files-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">FTP Connection Details</h5>
                                        <div class="card-text">
                                            <div class="border-dotted p-3 mb-3">
                                                <p><b>FTP Username</b> - <?php echo $site->cpanel_username; ?></p>
                                                <p><b>FTP Password</b> -
                                                    <span id="ftpPasswordLabel"><i class="fa fa-eye-slash"></i></span>
                                                    <code id="ftpPassword" style="display: none;"><?php echo $site->cpanel_password; ?></code>
                                                    <button id="showFTPPasswordBtn" class="btn btn-sm btn-outline-secondary rounded-0 ms-2" onclick="toggleFTPPassword()">Show Password</button>
                                                </p>
                                                <p><b>FTP Host</b> - ftpupload.net</p>
                                                <p><b>FTP Port</b> - 21</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-database" role="tabpanel" aria-labelledby="v-pills-database-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title mb-3">MySQL Connection Details</h5>
                                        <div class="card-text">
                                            <div class="border-dotted p-3 mb-3">
                                                <p><b>MySQL Host</b> - <i>(View in cPanel)</i></p>
                                                <p><b>MySQL Username</b> - <?php echo $site->cpanel_username; ?></p>
                                                <p><b>MySQL Password</b> -
                                                    <span id="mysqlPasswordLabel"><i class="fa fa-eye-slash"></i></span>
                                                    <code id="mysqlPassword" style="display: none;"><?php echo $site->cpanel_password; ?></code>
                                                    <button id="showMySQLPasswordBtn" class="btn btn-sm btn-outline-secondary rounded-0 ms-2" onclick="toggleMySQLPassword()">Show Password</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                <div class="card p-2 rounded-0 border-dark">
                                    <div class="card-body">
                                        <h5 class="card-title mb-4">Website Settings</h5>
                                        <div class="card-text mb-4">
                                            <form hx-post="/dashboard/site/<?php echo $siteid; ?>" hx-target="#update-label-msg" hx-swap="innerHTML">
                                                <h6>Update Site Label</h6>
                                                <div class="mb-3">
                                                    <div id="update-label-msg"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control rounded-0" id="site-label" name="label" value="<?php echo $site->label; ?>">
                                                </div>
                                                <button type="submit" id="updateLabelBtn" name="updateSiteLabel" class="btn btn-outline-dark rounded-0">Save Changes</button>
                                            </form>
                                        </div>
                                        <div class="card-text mb-4">
                                            <form hx-post="/dashboard/site/<?php echo $siteid; ?>" hx-target="#update-password-msg" hx-swap="innerHTML">
                                                <h6>Update cPanel Password</h6>
                                                <div class="mb-3">
                                                    <div id="update-password-msg"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Enter New Password">
                                                </div>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control rounded-0" id="passwordConfirm" name="confirm-password" placeholder="Confirm New Password">
                                                </div>
                                                <button type="submit" id="updatePasswordBtn" name="updatePanelPassword" class="btn btn-outline-dark rounded-0">Update Password</button>
                                            </form>
                                        </div>
                                        <div class="card-text">
                                            <div class="border-dotted p-3 mt-2">
                                                <h5 class="mb-3">Danger Zone</h5>
                                                <a href="#" class="btn btn-danger rounded-0" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Site</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DELETE SITE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this site? This action cannot be undone. 
                    <br><br>
                    You may not be able to reuse the subdomain for up to 60 days. 
                    <br><br>
                    <b>All of your site's data and files will be permanently lost!</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <a href="/dashboard/site/delete/<?php echo $siteid; ?>" class="btn btn-danger rounded-0">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function togglePassword() {
            var passwordLabel = document.getElementById('cpanelPasswordLabel');
            var passwordSpan = document.getElementById('cpanelPassword');
            var button = document.getElementById('showPasswordBtn');
            if (passwordSpan.style.display === 'none') {
                passwordLabel.style.display = 'none';
                passwordSpan.style.display = 'inline';
                button.textContent = 'Hide Password';
            } else {
                passwordLabel.style.display = 'inline';
                passwordSpan.style.display = 'none';
                button.textContent = 'Show Password';
            }
        }

        function toggleFTPPassword() {
            var passwordLabel = document.getElementById('ftpPasswordLabel');
            var passwordSpan = document.getElementById('ftpPassword');
            var button = document.getElementById('showFTPPasswordBtn');
            if (passwordSpan.style.display === 'none') {
                passwordLabel.style.display = 'none';
                passwordSpan.style.display = 'inline';
                button.textContent = 'Hide Password';
            } else {
                passwordLabel.style.display = 'inline';
                passwordSpan.style.display = 'none';
                button.textContent = 'Show Password';
            }
        }

        function toggleMySQLPassword() {
            var passwordLabel = document.getElementById('mysqlPasswordLabel');
            var passwordSpan = document.getElementById('mysqlPassword');
            var button = document.getElementById('showMySQLPasswordBtn');
            if (passwordSpan.style.display === 'none') {
                passwordLabel.style.display = 'none';
                passwordSpan.style.display = 'inline';
                button.textContent = 'Hide Password';
            } else {
                passwordLabel.style.display = 'inline';
                passwordSpan.style.display = 'none';
                button.textContent = 'Show Password';
            }
        }
    </script>

</body>
</html>