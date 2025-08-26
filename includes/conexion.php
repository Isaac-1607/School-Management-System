<?php
$host = 'localhost';
$dbname = 'instituto';
$username = 'root';
$password = 'Apple123';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "¡Conexión exitosa a la base de datos!"; // Mensaje de éxito
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

