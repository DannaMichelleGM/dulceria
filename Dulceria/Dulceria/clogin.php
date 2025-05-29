<?php
session_start();

// Conexión a la base de datos
$host = "localhost";
$dbname = "Dulceria";
$user = "admin";
$password = "12345678";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

// Verifica si se enviaron los datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    // Consulta preparada para buscar al usuario
    $sql = "SELECT nombre, contrasena, rol FROM usuarios WHERE nombre = :username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($usuario && password_verify($pass, $usuario['contrasena'])) {
        // Inicio de sesión valido
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redireccionar según el rol
        if ($usuario['rol'] === 'admin') {
            header("Location: inicioadmi.html"); // Cambia a tu archivo real de administrador
        } elseif ($usuario['rol'] === 'usuario') {
            header("Location: inicio.html"); // Cambia a tu archivo real de usuario
        } else {
            echo "Rol no reconocido.";
        }
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='login.html';</script>";
        exit();
    }
}
?>

