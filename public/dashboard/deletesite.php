<?php 

require_once "lib/OpenByte.php";

if(!isset($_SESSION['userid'])) {    
    header('Location: /404');
    exit;
}

$site = Site::get($siteid);

if($site == null) {
    header('Location: /404');
    exit;
}

$site->delete();
header("Location: /dashboard/?site_deleted=true");
exit;