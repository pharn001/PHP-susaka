<?php
session_start();

// Destroy the session
$_SESSION = [];
session_destroy();

// Redirect to login page
header('Location: login/index.php');
exit;
?>
