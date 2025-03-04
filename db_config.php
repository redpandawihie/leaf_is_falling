<?php
include 'navbar.php';

// Databasekonfigurasjon
define('DB_SERVER', 'localhost'); // Databasevert, vanligvis 'localhost'
define('DB_USERNAME', 'root');    // Database brukernavn
define('DB_PASSWORD', '');        // Database passord
define('DB_NAME', 'sikker_nettsted'); // Navn på databasen

// Koble til MySQL-databasen
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Sjekk tilkoblingen
if($link === false){
    die("ERROR: Kunne ikke koble til databasen. " . mysqli_connect_error());
}
?>
