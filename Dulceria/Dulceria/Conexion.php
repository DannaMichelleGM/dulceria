<?php
// Datos de conexión a PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "Dulceria";
$user = "admin";         // Asegúrate que este usuario existe en PostgreSQL
$password = "12345678";     // Y que tiene acceso a la base de datos

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
