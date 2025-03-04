<?php
// Force HTTPS Redirect
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);

session_start(); // Start session after setting session parameters

require 'vendor/autoload.php';
require 'db_config.php';

include 'navbar.php'; // Navbar after session start

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brukernavn = $_POST['brukernavn'];
    $passord = $_POST['passord'];
    $otp = $_POST['otp']; // Engangskode fra Google Authenticator

    // Debugging
    echo "DEBUG: Entered username: " . $_POST['brukernavn'] . "<br>";
    echo "DEBUG: Entered password: " . $_POST['passord'] . "<br>";

    // Secure SQL Query
    $sql = "SELECT id, passord_hash, secret FROM brukere WHERE brukernavn = ?";
    if ($stmt = $link->prepare($sql)) {
        $stmt->bind_param("s", $brukernavn);
        $stmt->execute();
        $stmt->bind_result($id, $passord_hash, $secret);
        $stmt->fetch();
        $stmt->close();
    }

    // Debugging
    echo "DEBUG: Stored hash in DB: " . ($passord_hash ? $passord_hash : "NULL") . "<br>";

    if (!empty($passord_hash) && password_verify($passord, $passord_hash)) {
        echo "✅ PASSWORD MATCH!<br>";

        $ga = new PHPGangsta_GoogleAuthenticator();
        $checkResult = $ga->verifyCode($secret, $otp, 2); // 2 = 60 sekunders margin

        if ($checkResult) {
            $_SESSION["loggedin"] = true;
            $_SESSION["brukernavn"] = $brukernavn;
            echo "Innlogging vellykket!";
        } else {
            echo "Feil engangskode. Prøv igjen.";
        }
    } else {
        echo "❌ PASSWORD DOES NOT MATCH!<br>";
        echo "Feil brukernavn eller passord.";
    }
}
?>
