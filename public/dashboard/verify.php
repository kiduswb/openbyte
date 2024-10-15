<?php

require_once "lib/OpenByte.php";

$user = User::get($userid);

if ($user == null) {
    header("Location: /404");
    exit;
}

if($user->is_verified) {
    header("Location: /dashboard");
    exit;
}

$user->verify();
header("Location: /dashboard/login/?verified=true");
exit;
