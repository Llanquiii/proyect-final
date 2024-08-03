<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hardware_store";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
