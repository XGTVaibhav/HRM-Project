<?php
session_start();

// Destroy the session
session_unset();
session_destroy();
header('location:login_admin.php');
exit();
?>
