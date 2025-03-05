<?php
include 'navbar.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}

require 'vendor/autoload.php';
require_once 'db_config.php'; // Koble til databasen

$ga = new PHPGangsta_GoogleAuthenticator();

// Definer variabler og sett dem til tomme verdier
$brukernavn = $email = $passord = "";
$brukernavn_err = $email_err = $passord_err = "";

// Behandle skjema når det sendes inn
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Valider brukernavn
    if (empty(trim($_POST["brukernavn"]))) {
        $brukernavn_err = "Vennligst oppgi et brukernavn.";
    } else {
        $sql = "SELECT id FROM brukere WHERE brukernavn = ?";

        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $param_brukernavn);
            $param_brukernavn = trim($_POST["brukernavn"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $brukernavn_err = "Dette brukernavnet er allerede tatt.";
                } else {
                    $brukernavn = trim($_POST["brukernavn"]);
                }
            } else {
                echo "❌ Feil: Kunne ikke utføre spørring.";
            }
            $stmt->close();
        }
    }

    // Valider e-post
    if (empty(trim($_POST["email"]))) {
        $email_err = "Vennligst oppgi en e-postadresse.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Valider passord
    if (empty(trim($_POST["passord"]))) {
        $passord_err = "Vennligst oppgi et passord.";
    } elseif (strlen(trim($_POST["passord"])) < 6) {
        $passord_err = "Passordet må ha minst 6 tegn.";
    } else {
        $passord = trim($_POST["passord"]);
    }

    // Sjekk input feil før du setter inn i databasen
    if (empty($brukernavn_err) && empty($email_err) && empty($passord_err)) {
        $secret = $ga->createSecret();
        $param_passord = password_hash($passord, PASSWORD_DEFAULT);

        // 🔍 Debugging: Check if hash is generated correctly
        // echo "DEBUG: Generated password hash (should be ~60 chars): " . $param_passord . "<br>";

        $sql = "INSERT INTO brukere (brukernavn, email, passord_hash, secret) VALUES (?, ?, ?, ?)";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("ssss", $brukernavn, $email, $param_passord, $secret);

            if ($stmt->execute()) {
                // Remove debug messages, only show the button
                echo '<p>✅ Registrering vellykket!</p>';
                echo '<a href="dashboard.php">
                        <button>➡️ Gå til Dashboard</button>
                      </a>';
                echo '<a href="qr_code.php?brukernavn=' . $brukernavn . '">
                        <button>📷 Gå til QR-kode</button>
                      </a>';
            } else {
                echo "❌ Feil under registrering.";
            }
            $stmt->close();
        } else {
            echo "❌ Kunne ikke forberede SQL-spørring.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Registrering</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registrer deg</h2>
    <form action="register.php" method="post">
        <label for="brukernavn">Brukernavn:</label>
        <input type="text" name="brukernavn" id="brukernavn" required><br><br>
        <label for="email">E-post:</label>
        <input type="email" name="email" id="email" required><br><br>
        <label for="passord">Passord:</label>
        <input type="password" name="passord" id="passord" required><br><br>
        <input type="submit" value="Registrer">
    </form>
</body>
</html>
