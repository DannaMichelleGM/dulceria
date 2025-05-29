<?php
require 'conexion2.php';

function calcularPresupuesto($productos) {
    global $pdo;
    $total = 0;
    $detalle = [];

    foreach ($productos as $id => $cantidad) {
        if ($cantidad > 0) {
            $stmt = $pdo->prepare("SELECT descripcion, precio FROM producto WHERE id_producto = :id");
            $stmt->execute(['id' => $id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                $subtotal = $producto['precio'] * $cantidad;
                $total += $subtotal;

                $detalle[] = [
                    'descripcion' => $producto['descripcion'],
                    'precio_unitario' => $producto['precio'],
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }
        }
    }

    return ['detalle' => $detalle, 'total' => $total];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito y Presupuesto - Dulcería</title>
    <link rel="stylesheet" href="estilo2.css">

  <div class="barra-amarilla">

<img src="imagenes/dulceria.logo.png" alt="Logo" class="logo">
 
   <h1>Carrito de Compras</h1> 
    
       <nav>
        <a href="inicio.html">Inicio</a>
        <a href="contacto.html">Contacto</a>
        <a href="productos.php">Productos</a>
        
       
    </nav>
  </div>

</head>

<body>
    <br><br>
  
   
<main class="container">
  

    <form method="POST">
        <div class="producto-grid">
            <?php
            try {
                $query = $pdo->query("SELECT * FROM producto ORDER BY id_producto ASC");

                while ($producto = $query->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <article class="producto-card">
                        <img src="<?= $producto['imagen_url'] ?>" alt="Imagen de <?= $producto['descripcion'] ?>">
                        <h3><?= htmlspecialchars($producto['descripcion']) ?></h3>
                        <p>Precio: $<?= number_format($producto['precio'], 2) ?></p>
                        <label>
                            Cantidad:
                            <input type="number" name="productos[<?= $producto['id_producto'] ?>]" value="0" min="0">
                        </label>
                    </article>
                    <?php
                }
            } catch (PDOException $e) {
                echo "<p>Error al obtener productos: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
        <button type="submit">Calcular presupuesto</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
        $resultado = calcularPresupuesto($_POST['productos']);

        if ($resultado['detalle']) {
            echo "<h2>Presupuesto</h2>";
            echo "<table role='grid'>";
            echo "<thead><tr><th>Descripción</th><th>Precio Unitario</th><th>Cantidad</th><th>Subtotal</th></tr></thead><tbody>";

            foreach ($resultado['detalle'] as $item) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($item['descripcion']) . "</td>";
                echo "<td>$" . number_format($item['precio_unitario'], 2) . "</td>";
                echo "<td>{$item['cantidad']}</td>";
                echo "<td>$" . number_format($item['subtotal'], 2) . "</td>";
                echo "</tr>";
            }

            echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>$" . number_format($resultado['total'], 2) . "</strong></td></tr>";
            echo "</tbody></table>";
        } else {
            echo "<p>No seleccionaste ningún producto.</p>";
        }
    }
    ?>
</main>
</body>
</html>
