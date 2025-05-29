<?php
// Configuración de conexión a PostgreSQL
$host = 'localhost';
$db   = 'Dulceria';
$user = 'admin';
$pass = '12345678';
$dsn = "pgsql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);

    // Seleccionar todos los usuarios
    $stmt = $pdo->query("SELECT id_usuario, contraseña FROM usuarios");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id = $row['id_usuario'];
        $plainPassword = $row['contraseña'];

        // Verificar si ya está hasheada (por ejemplo, empieza con $2y$)
        if (!str_starts_with($plainPassword, '$2y$')) {
            // Hashear la contraseña
            $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Actualizar en la base de datos
            $update = $pdo->prepare("UPDATE usuarios SET contraseña = :hashed WHERE id_usuario = :id");
            $update->execute([':hashed' => $hashedPassword, ':id' => $id]);

            echo "Contraseña del usuario con ID $id actualizada.<br>";
        } else {
            echo "Usuario con ID $id ya tiene la contraseña en formato hash.<br>";
        }
    }

    echo "<strong>Actualización completada.</strong>";
} catch (PDOException $e) {
    echo "Error al conectar o actualizar: " . $e->getMessage();
}
?>
