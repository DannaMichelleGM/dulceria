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

    // Verificar si se envió un término de búsqueda
    if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
        $buscar = $_GET['buscar'];

        // Consulta preparada con LIKE para buscar coincidencias parciales
        $stmt = $pdo->prepare("SELECT * FROM producto WHERE descripcion ILIKE :buscar");
        $stmt->execute(['buscar' => "%$buscar%"]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resultados = [];
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="estilosbuscador.css">
    <meta charset="UTF-8">
    <title>Buscador de Productos</title>

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
 
   <h1>Buscador de Productos</h1> 
    
       <nav>
        <a href="inicioadmi.html">Inicio</a>
        <a href="modifpro.html">Moficar Productos</a>
        <a href="stock.php">Stock</a>
    
       
    </nav>
  </div>

</head>
<body>
   
    <form method="GET" action="">
        <input type="text" name="buscar" placeholder="Ingrese nombre del producto">
        <button type="submit">Buscar</button>
    </form>

    <?php if (isset($_GET['buscar'])): ?>
        <h2>Resultados para: <?= htmlspecialchars($_GET['buscar']) ?></h2>
        <?php if (count($resultados) > 0): ?>
           <div class="grid">
    <?php foreach ($resultados as $producto): ?>
        <div class="producto">
            <?php if (!empty($producto['imagen_url'])): ?>
                <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" alt="Imagen del producto">
            <?php endif; ?>
            <strong><?= htmlspecialchars($producto['descripcion']) ?></strong>
            <p>Precio: $<?= number_format($producto['precio'], 2) ?></p>
            <p>Existencia: <?= $producto['existencia'] ?></p>
            <p>Tipo: <?= htmlspecialchars($producto['tipo_producto']) ?></p>
        </div>
    <?php endforeach; ?>
</div>

        <?php else: ?>
            <p>No se encontraron productos con ese nombre.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
