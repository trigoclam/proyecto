<?php

// Datos de conexión
$servername = "db.fmesasc.com";
$username = "daw2";
$password = "Gimbernat1";
$dbname = "daw2";

try {
    // Crear la conexión usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa.";
} catch (PDOException $e) {
    // Capturar errores de conexión
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recoger datos del formulario
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $foto = '';

    // Procesar la foto si se ha subido
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombreFoto = basename($_FILES['foto']['name']);
        $directorioDestino = 'uploads/' . $nombreFoto;

        // Asegurarse de que la carpeta `uploads` exista
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Mover la foto al directorio de destino
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $directorioDestino)) {
            $foto = $directorioDestino;
        } else {
            die("Error al subir la foto.");
        }
    }

    // Preparar la consulta SQL
    $sql = "INSERT INTO articulos_adriOscar (titulo, autor, contenido, foto) VALUES (:titulo, :autor, :contenido, :foto)";
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    $stmt->bindParam(':autor', $autor, PDO::PARAM_STR);
    $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_STR);

    // Ejecutar la consulta y manejar errores
    try {
        $stmt->execute();
        echo "Artículo añadido con éxito.";
    } catch (PDOException $e) {
        die("Error al añadir el artículo: " . $e->getMessage());
    }

     // Redirigir de nuevo al archivo HTML
     header("Location: formularioArt.html");
     exit; 
}

?>
