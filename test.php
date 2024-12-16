<?php
include __DIR__ . '/add_coment.php';

if (file_exists('add_coment.php')) {
    echo "El archivo add_coment.php existe.";
} else {
    echo "El archivo add_coment.php no se encuentra.";
}

phpinfo();
?>
