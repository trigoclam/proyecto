<?php
include 'db_connection.php';

$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;
$comment = isset($_POST['comment']) ? $_POST['comment'] : null;
$article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : null;

if ($usuario && $comment && $article_id) {
    $sql = "INSERT INTO adria_comentarios (article_id, usuario, comment, created_at) 
            VALUES (:article_id, :usuario, :comment, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "Comentario agregado exitosamente.";
    } else {
        echo "Error al agregar el comentario.";
    }
} else {
    echo "Faltan datos para agregar el comentario.";
}

?>
