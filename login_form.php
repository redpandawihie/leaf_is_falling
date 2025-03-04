<?php
include 'navbar.php';
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="post">
        <label>Brukernavn:</label>
        <input type="text" name="brukernavn" required><br>

        <label>Passord:</label>
        <input type="password" name="passord" required><br>

        <label>Engangskode:</label>
        <input type="text" name="otp" required><br>

        <input type="submit" value="Logg inn">
    </form>
</body>
</html>
