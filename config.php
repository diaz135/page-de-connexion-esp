<?php
// config.php
$servername = "localhost";
$username = "root"; // Change si nécessaire
$password = "";     // Change si nécessaire
$dbname = "esp32_cam_db";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
