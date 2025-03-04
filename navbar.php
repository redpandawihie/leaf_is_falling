<?php
if (!isset($navbarIncluded)) {
    $navbarIncluded = true;
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <style>
        .navbar {
            background: #007bff;
            padding: 10px;
            text-align: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            font-size: 18px;
            margin: 0 10px;
        }
        .navbar a:hover {
            background: #0056b3;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="register.php">📝 Register</a>
        <a href="login_form.php">🔑 Login</a>
        <a href="qr_code.php?brukernavn=YOUR_USERNAME">📸 QR Code</a>
        <a href="dashboard.php">🔐 Dashboard</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
<?php } ?>
