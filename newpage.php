<?php
include 'navbar.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login_form.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Velkommen!</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Velkommen, <?php echo htmlspecialchars($_SESSION["brukernavn"]); ?>!</h2>
    <p>Du er nå logget inn 🎉</p>

    <!-- Display your image -->
    <img src="meowlogin.jpg" alt="Welcome Image" width="500px">

    <br><br>
    <a href="logout.php">Logg ut</a>
</body>
</html>
