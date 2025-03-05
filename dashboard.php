<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            width: 50%;
            margin: auto;
        }
        h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background: #ff4081;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn:hover {
            background: #ff79b0;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Velkommen til Dashboardet!</h2>
        <p>Du er nå logget inn som <b><?php echo htmlspecialchars($_SESSION["brukernavn"]); ?></b></p>
        
        <a href="qr_code.php" class="btn">📷 QR-kode</a>
        <a href="settings.php" class="btn">⚙️ Innstillinger</a>
        <a href="logout.php" class="btn">🚪 Logg ut</a>
    </div>

</body>
</html>
