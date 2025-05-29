<?php
// Mostrar errores durante desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezado de respuesta JSON
header('Content-Type: application/json');

// Parámetros de conexión — reemplaza con los correctos
$host = "localhost";
$dbname = "Dulceria";     // ← AJUSTAR
$user = "admin";             // ← AJUSTAR
$password = "12345678";     // ← AJUSTAR

try {
    // Conexión a PostgreSQL
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Leer el JSON recibido
    $input = json_decode(file_get_contents("php://input"), true);

    if (
        !empty($input['id_producto']) &&
        !empty($input['descripcion']) &&
        !empty($input['precio']) &&
        !empty($input['imagen_url']) &&
        !empty($input['tipo_producto']) &&
        !empty($input['existencia'])
    ) {
        // Preparar el INSERT
        $stmt = $conn->prepare("INSERT INTO producto (id_producto, descripcion, precio, imagen_url, tipo_producto, existencia)
                                VALUES (:id_producto, :descripcion, :precio, :imagen_url, :tipo_producto, :existencia)");

        $stmt->bindParam(':id_producto', $input['id_producto']);
        $stmt->bindParam(':descripcion', $input['descripcion']);
        $stmt->bindParam(':precio', $input['precio']);
        $stmt->bindParam(':imagen_url', $input['imagen_url']);
        $stmt->bindParam(':tipo_producto', $input['tipo_producto']);
        $stmt->bindParam(':existencia', $input['existencia']);

        $success = $stmt->execute();
        $filas = $stmt->rowCount();

        if ($success && $filas > 0) {
            echo json_encode(['success' => true, 'mensaje' => "Producto insertado. Filas afectadas: $filas"]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se insertó ninguna fila (posible ID duplicado o restricción fallida).']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Faltan datos en la solicitud.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}


?>


