<?php
session_start();
session_unset();
session_destroy();

// Redirect to the login page or homepage
header("Location: goodbye.php");
exit();
?>
