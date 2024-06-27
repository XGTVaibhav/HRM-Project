<?php
session_start();

// Update the last activity time in the session
$_SESSION['last_activity'] = time();
?>
