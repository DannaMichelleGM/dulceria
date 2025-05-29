<?php
require 'conexion.php';


// Función que recibe productos con cantidades y calcula el presupuesto
function calcularPresupuesto($productos) {
    global $pdo;
    $total = 0;
    $detalle = [];

    foreach ($productos as $id => $cantidad) {
        if ($cantidad > 0) {
            // Consulta el producto por ID (ajustado a 'id_producto')
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
<html>
<head>
    <style>
    .producto-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        height: 300px;
        padding: 1rem;
        border: 1px solid var(--pico-muted-border-color, #ccc);
        border-radius: var(--pico-border-radius, 0.5rem);
        box-shadow: var(--pico-card-box-shadow, 0 0.2rem 0.4rem rgba(0, 0, 0, 0.1));
    }

    .producto-card img {
        max-width: 100px;
        max-height: 100px;
        object-fit: cover;
        margin-bottom: 0.5rem;
    }

    .producto-card h3 {
        font-size: 1rem;
        margin: 0.5rem 0;
        text-align: center;
    }

    .producto-card p,
    .producto-card label {
        font-size: 0.9rem;
        text-align: center;
    }
</style>

    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.blue.min.css"> -->
    <title>Carrito y Presupuesto - Dulcería</title>
</head>
<body>

<h2>Carrito de Compras</h2>
<form method="POST">
    <div style="display: flex; flex-wrap: wrap;">
        <?php
        // Mostrar productos disponibles
        $query = $pdo->query("SELECT * FROM producto");
        while ($producto = $query->fetch(PDO::FETCH_ASSOC)) {
            echo '<div style="border:1px solid #ccc; padding:10px; margin:10px;">';
            echo '<img src="' . $producto['imagen_url'] . '" width="100"><br>';
            echo '<strong>' . $producto['descripcion'] . '</strong><br>';
            echo 'Precio: $' . $producto['precio'] . '<br>';
            echo 'Cantidad: <input type="number" name="productos[' . $producto['id_producto'] . ']" value="0" min="0"><br>';
            echo '</div>';
        }
        ?>
    </div>
    <button type="submit">Calcular presupuesto</button>
</form>

<?php
// Procesar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos'])) {
    $resultado = calcularPresupuesto($_POST['productos']);

    echo "<h2>Presupuesto</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Descripción</th><th>Precio Unitario</th><th>Cantidad</th><th>Subtotal</th></tr>";

    foreach ($resultado['detalle'] as $item) {
        echo "<tr>";
        echo "<td>{$item['descripcion']}</td>";
        echo "<td>\${$item['precio_unitario']}</td>";
        echo "<td>{$item['cantidad']}</td>";
        echo "<td>\${$item['subtotal']}</td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'><strong>Total</strong></td><td><strong>\${$resultado['total']}</strong></td></tr>";
    echo "</table>";
}
?>

</body>
</html>
