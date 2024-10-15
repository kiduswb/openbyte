<?php 

require_once "lib/OpenByte.php";

if(!isset($_SESSION['userid'])) {    
    header('Location: /404');
    exit;
}

//...