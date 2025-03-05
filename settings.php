<?php
include 'navbar.php';
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Database connection
require_once "db_config.php";

// Variables
$new_email = $new_password = "";
$email_err = $password_err = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty(trim($_POST["email"]))) {
        $new_email = trim($_POST["email"]);
        $sql = "UPDATE brukere SET email = ? WHERE id = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("si", $new_email, $_SESSION["id"]);
            if ($stmt->execute()) {
                echo "<p>✅ E-post oppdatert!</p>";
            }
            $stmt->close();
        }
    }

    if (!empty(trim($_POST["password"])) && strlen($_POST["password"]) >= 6) {
        $new_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);
        $sql = "UPDATE brukere SET passord_hash = ? WHERE id = ?";
        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("si", $new_password, $_SESSION["id"]);
            if ($stmt->execute()) {
                echo "<p>✅ Passord oppdatert!</p>";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Innstillinger</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #00c6ff, #0072ff);
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
        input {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: none;
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

        .title {
        color: #fff78c; 
        font-size: 28px;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

    </style>
</head>
<body>

    <div class="container">
    <h2><span class="title">⚙️ Innstillinger</span></h2>
        <form action="settings.php" method="post">
            <label for="email">Ny E-post:</label>
            <input type="email" name="email" id="email" placeholder="Skriv ny e-post">
            <br>
            <label for="password">Nytt Passord:</label>
            <input type="password" name="password" id="password" placeholder="Minst 6 tegn">
            <br>
            <input type="submit" class="btn" value="Lagre endringer">
        </form>
        <br>
        <a href="dashboard.php" class="btn">🔙 Tilbake til Dashboard</a>
    </div>

</body>
</html>
