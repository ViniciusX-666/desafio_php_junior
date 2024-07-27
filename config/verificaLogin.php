<?php

if (!isset($_SESSION['usuario_id'])) {

    header('Location: /desafio_php_junior/views/login.php');
    exit();
}
?>
