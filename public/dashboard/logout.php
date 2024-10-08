<?php 
    unset($_SESSION['userid']);
    header('Location: /dashboard/login/?logout=true');
    exit;
?>