<?php 

require_once "lib/OpenByte.php";
require_once "lib/Emails.php";

if(!isset($_SESSION['userid'])) {    
    header('Location: /404');
    exit;
}

$user = User::get($userid);
$sites = Site::get_user_sites($user->id);

// Delete all of the user's hosted websites
if(count($sites)) {
    foreach($sites as $site) 
        $site->delete();
}

// Delete user account
sendTransactionalEmail($user->email, "OpenByte Hosting Account Deleted", generateAccountDeletionEmail());
$user->delete();
header("Location: /dashboard/login/?deleted=true");
exit;