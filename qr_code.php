<?php
include 'navbar.php';

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $redirect);
    exit();
}
require 'vendor/autoload.php';
require 'db_config.php';

$brukernavn = $_GET['brukernavn']; // Hent brukernavnet fra URL eller økt
$ga = new PHPGangsta_GoogleAuthenticator();

// Hent den hemmelige nøkkelen fra databasen
$sql = "SELECT secret FROM brukere WHERE brukernavn = ?";
if ($stmt = $link->prepare($sql)) {
    $stmt->bind_param("s", $brukernavn);
    $stmt->execute();
    $stmt->bind_result($secret);
    $stmt->fetch();
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>QR-kode</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
if ($secret) {
    // Lag QR-kode URL for Google Authenticator
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('DittProsjektNavn', $secret);
    echo "<h3>Skann denne QR-koden med Google Authenticator:</h3>";
    echo "<img src='{$qrCodeUrl}' />";
} else {
    echo "Bruker ikke funnet.";
}
?>
</body>
</html>
