<?php
include 'conexion.php';

function generarNuevoID($conn) {
    $stmt = $conn->query("SELECT MAX(id_usuario) AS max_id FROM usuarios");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['max_id'] ? $row['max_id'] + 1 : 1;
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $rol = "usuario";
    $id_usuario = generarNuevoID($conn);

    // Verificar si correo o nombre ya existen
    $sql_check = "SELECT * FROM usuarios WHERE correo = :correo OR nombre = :nombre";
    $stmt = $conn->prepare($sql_check);
    $stmt->execute(['correo' => $correo, 'nombre' => $nombre]);
    $existe = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existe) {
        if ($existe['correo'] === $correo) {
            $mensaje = "El correo ya está registrado.";
        } elseif ($existe['nombre'] === $nombre) {
            $mensaje = "El nombre ya está registrado.";
        }
    } else {
        // Insertar nuevo usuario
        $sql_insert = "INSERT INTO usuarios (id_usuario, correo, nombre, contrasena, rol)
                       VALUES (:id_usuario, :correo, :nombre, :clave, :rol)";
        $stmt = $conn->prepare($sql_insert);
        $params = [
            'id_usuario' => $id_usuario,
            'correo' => $correo,
            'nombre' => $nombre,
            'clave' => $contraseña,
            'rol' => $rol
        ];

        if ($stmt->execute($params)) {
    // Redirigir si se registró con éxito
    header("Location: registro_exitoso.html");
    exit(); // Importante para detener la ejecución después de redirigir
} else {
    $mensaje = "Error al registrar usuario.";
}

}
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
     <link rel="stylesheet" href="estilor.css">
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
 
</head>
<body>
    <style>

        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
           h1 {
    text-align: center;
    color: #000000;
    margin-bottom: 10px;
    
}

.barra-amarilla {
    background-color: #fff36e;
    height: 150px;
    width: 100%;
   
   
}

   
       nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }
       .logo {
            position: absolute;
            top: 0;
            left: 1100px;
            height: 120px; /* Ajusta el tamaño del logo */
        }
    </style>
  <div class="barra-amarilla">
<img src="imagenes/dulceria.logo.png" alt="Logo" class="logo">
 
   <h1>Formulario de Registro</h1> 
    
       <nav>
        <a href="inicionormal.html">Inicio</a>
        <a href="contactonormal.html">Contacto</a>
        <a href="productosnormal.php">Productos</a>
        <a href="login.html">Login</a>
       
    </nav>
  </div>



     <div class="form-container">
    <h2>Ingresa tus Datos</h2>

    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Correo:</label><br>
        <input type="email" name="correo" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="contraseña" required><br><br>

        <?php if ($mensaje): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

        <input type="submit" value="Registrarse">
    </form>
              </div>
    
</body>
</html>
