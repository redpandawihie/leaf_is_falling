<?php
$enteredPassword = "QWERTY";
$storedHash = "$2y$10$R58q";

if (password_verify($enteredPassword, $storedHash)) {
    echo "✅ PASSWORD MATCHES!";
} else {
    echo "❌ PASSWORD DOES NOT MATCH!";
}
?>
