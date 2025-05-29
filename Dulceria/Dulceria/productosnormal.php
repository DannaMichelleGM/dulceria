<?php
// Configuración de conexión
$host = 'localhost';
$dbname = 'Dulceria';
$user = 'admin';
$password = '12345678';

try {
    // Conexión a PostgreSQL con PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta todos los productos
    $stmt = $pdo->query("SELECT * FROM producto ORDER BY id_producto ASC");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todos los Productos</title>
    <link rel="stylesheet" href="estilosstock.css">

     <style>
           h1 {
    text-align: center;
    color: #000000;
    margin-bottom: 10px;
    
}

.barra-amarilla {
    background-color: #fff36e;
    height: 120px;
    width: 100%;
    position: relative;
    top: 0px;
   
}

   
       nav {
            text-align: center;
            margin-top: 20px;
        }

        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
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
 
   <h1>Listado de todos los Productos</h1> 
    
       <nav>
        <a href="inicionormal.html">Inicio</a>
        <a href="contacto.html">Contacto</a>
        <a href="login.php">Login</a>
        <a href="registro.php">Registrarse</a>
       
       
    </nav>
  </div>

</head>
<body>
    <br>
   

    <?php if (count($productos) > 0): ?>
        <ul>
            <?php foreach ($productos as $producto): ?>
                <li>
                    <strong><?= htmlspecialchars($producto['descripcion']) ?></strong><br>
                    Precio: $<?= number_format($producto['precio'], 2) ?><br>
                    Tipo: <?= htmlspecialchars($producto['tipo_producto']) ?><br>
                    <?php if (!empty($producto['imagen_url'])): ?>
                        <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" alt="Imagen del producto">
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="text-align:center;">No hay productos registrados en la base de datos.</p>
    <?php endif; ?>
</body>
</html>