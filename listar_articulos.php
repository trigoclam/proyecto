<?php
// Conectar a la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'mi_proyecto');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener todos los artículos
$resultado = $conexion->query("SELECT id, titulo, autor, fecha_creacion FROM articulos");

if ($resultado->num_rows > 0) {
    echo "<h2>Lista de Artículos</h2>";
    echo "<ul>";
    while ($row = $resultado->fetch_assoc()) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($row['titulo']) . "</strong> - " . htmlspecialchars($row['autor']) . " (" . $row['fecha_creacion'] . ")";
        echo " - <a href='eliminar_articulo.php?id=" . $row['id'] . "' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este artículo?\");'>Eliminar</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "No hay artículos disponibles.";
}

$conexion->close();
?>
