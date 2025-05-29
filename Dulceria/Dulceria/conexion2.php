<?php
$host = 'localhost';
$db   = 'Dulceria';
$user = 'admin';
$pass = '12345678';
$charset = 'utf8mb4';

$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Opcional: configurar errores como excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>
