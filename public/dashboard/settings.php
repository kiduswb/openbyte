<?php 

    require_once 'lib/OpenByte.php';

    if(!isset($_SESSION['userid'])) {
        header('Location: /dashboard/login/?auth=false');
        exit;
    }

    $user = new User($_SESSION['userid']);

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
                                <form>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="currentPassword" placeholder="Enter your current password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="newPassword" placeholder="Enter your new password">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="confirmPassword" placeholder="Confirm your new password">
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 rounded-0"><i class="fa fa-lock me-2"></i> Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <div class="card p-2 border-dark rounded-0">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Update Email Address</h5>
                                <form>
                                    <div class="mb-3">
                                        <input type="email" class="form-control rounded-0" id="newEmail" placeholder="Enter New Email Address">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control rounded-0" id="password" placeholder="Enter Password">
                                    </div>
                                    <button type="submit" class="btn btn-dark w-100 rounded-0"><i class="fa fa-envelope me-2"></i> Update Email</button>
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
                                    <?php echo $user->email; ?>
                                    <?php if($user->is_verified == 1): ?>
                                        <i class="fa-solid fa-circle-check text-success ms-1"></i>
                                    <?php else: ?>
                                        <span class="badge bg-warning ms-1">Unverified</span>
                                    <?php endif; ?>
                                </p>

                                <?php if($user->is_verified == 0): ?>
                                    <p><a href="#" class="btn btn-warning w-100 rounded-0"><i class="fa fa-envelope me-2"></i> Resend Verification Link</a></p>
                                <?php endif; ?>

                                <p>Member since <?php echo date("M d, Y", $user->timestamp) ?></p>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card p-1 border-dark rounded-0">
                            <div class="card-body">
                                <h5 class="card-title">Danger Zone</h5>
                                <p class="card-text">Delete your account and all your data.</p>
                                <button 
                                    class="btn btn-danger w-100 rounded-0" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteAccountModal"
                                >
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
                    <p>Are you sure you want to delete your account? This will erase all of your websites and data.</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn rounded-0 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn rounded-0 btn-danger">Delete Account</button>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "footer.php"; ?>
</body>
</html>
