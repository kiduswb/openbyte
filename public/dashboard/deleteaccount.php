<?php 

require_once "lib/OpenByte.php";
require_once "lib/Emails.php";

error_reporting(E_ALL);

if(!isset($_SESSION['userid'])) {    
    header('Location: /404');
    exit;
}

$user = User::get($userid);

if($user == null) {
    header('Location: /404');
    exit;
}

$sites = Site::get_user_sites($user->id);

// Delete all of the user's hosted websites
if(count($sites)) {
    foreach($sites as $site) 
        $site->delete();
}

// Delete user account
sendTransactionalEmail($user->email, "OpenByte Hosting Account Deleted", generateAccountDeletionEmail());
$user->delete();
unset($_SESSION['userid']);
header("Location: /dashboard/login/?deleted=true");
exit;