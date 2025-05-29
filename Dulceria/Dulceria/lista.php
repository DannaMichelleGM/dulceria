<?php
// Parámetros de conexión a PostgreSQL
$host = 'localhost';          // Cambia si tu servidor no es local
$dbname = 'Dulceria'; // Pon el nombre real de tu base de datos
$user = 'admin';         // Cambia por tu usuario de PostgreSQL
$password = '12345'; // Cambia por tu contraseña

try {
    // Crear la conexión con PDO
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $sql = "SELECT descripcion, precio FROM producto";
    $stmt = $pdo->query($sql);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar resultados en una tabla HTML
    echo "<table border='1' style='border-collapse: collapse; width: 50%; margin: auto;'>";
    echo "<thead>
            <tr style='background-color: #4CAF50; color: white;'>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
          </thead>
          <tbody>";

    foreach ($productos as $producto) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($producto['descripcion']) . "</td>";
        echo "<td>$" . number_format($producto['precio'], 2) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

