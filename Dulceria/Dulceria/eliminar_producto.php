<?php
// eliminar_producto.php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'Dulceria';
$user = 'admin';
$password = '12345678';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Leer los datos JSON enviados desde JavaScript
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_producto'])) {
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
        exit;
    }

    $id = $data['id_producto'];

    // Preparar y ejecutar la eliminación
    $stmt = $pdo->prepare("DELETE FROM producto WHERE id_producto = :id");
    $stmt->execute(['id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No se encontró el producto']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
