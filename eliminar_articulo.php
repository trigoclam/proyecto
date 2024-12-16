<?php
// Conectar a la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'mi_proyecto');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el artículo
    $stmt = $conexion->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Artículo eliminado con éxito.";
    } else {
        echo "Error al eliminar el artículo: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
