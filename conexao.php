<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mobilidade_segura"; // ou o nome que você usou

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
