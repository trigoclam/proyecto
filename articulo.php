<?php
include 'db_connection.php';

// Validar que el parámetro 'id' existe y es numérico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
} else {
    die("Error: ID de artículo no válido.");
}

try {
    // Consulta para obtener el artículo específico
    $sql_article = "SELECT * FROM articulos WHERE id = :id";
    $stmt_article = $conn->prepare($sql_article);
    $stmt_article->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_article->execute();

    if ($stmt_article->rowCount() > 0) {
        $article = $stmt_article->fetch(PDO::FETCH_ASSOC);
        echo "<h1>" . htmlspecialchars($article['titulo']) . "</h1>";
        echo "<p class='article-meta'>Publicado el " . htmlspecialchars($article['fecha']) . " por " . htmlspecialchars($article['autor']) . "</p>";
        echo "<img src='" . htmlspecialchars($article['imagen']) . "' alt='Imagen del artículo'>";
        echo "<p>" . htmlspecialchars($article['contenido']) . "</p>";
    } else {
        echo "Artículo no encontrado.";
    }

    // Consulta para obtener los comentarios asociados al artículo
    $sql_comments = "SELECT usuario, comment, created_at FROM adria_comentarios WHERE article_id = :id ORDER BY created_at DESC";
    $stmt_comments = $conn->prepare($sql_comments);
    $stmt_comments->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_comments->execute();

    echo "<div class='comments-section'>";
    echo "<h3>Comentarios</h3>";

    if ($stmt_comments->rowCount() > 0) {
        while ($comment = $stmt_comments->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='comment'>";
            echo "<p><strong>" . htmlspecialchars($comment['usuario']) . "</strong> dijo:</p>";
            echo "<p>" . htmlspecialchars($comment['comment']) . "</p>";
            echo "<p class='comment-meta'>Publicado el " . htmlspecialchars($comment['created_at']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay comentarios aún.</p>";
    }

    echo "</div>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!-- Formulario para agregar un comentario -->
<div class="comment-form">
    <h4>Agregar un comentario</h4>
    <form action="add_coment.php" method="post">
    <input type="hidden" name="article_id" value="<?php echo $id; ?>">
    <input type="text" name="usuario" placeholder="Tu nombre" required>
    <textarea name="comment" placeholder="Escribe tu comentario..." required></textarea>
    <button type="submit">Enviar</button>
</form>

</div>
