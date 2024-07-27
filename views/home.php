<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /desafio_php_junior/views/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/usuarioLista.css">   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
</head>
<body>
<div class="container">
        <div class="card">
            <div class="card-header">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3>Bem-vindo, <?php echo ($_SESSION['usuario_nome']); ?>!</h3>
                    <a href="/desafio_php_junior/controllers/logout.php" class="btn btn-secondary"><i class="bi bi-box-arrow-in-right"></i> Sair</a>
                </div>
            </div>    
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="/desafio_php_junior/views/Usuarios/listarUsuarios.php" class="btn btn-primary btn-block">Usuários</a>
                    </div>
                    <div class="col-md-4">
                        <a href="/desafio_php_junior/views/Reservas/listarReservas.php" class="btn btn-success btn-block">Reservas</a>
                    </div>
                    <div class="col-md-4">
                        <a href="/desafio_php_junior/views/Salas/listarSalas.php" class="btn btn-warning btn-block">Salas</a>
                    </div>
                </div>
            </div>
        </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="../../public/js/usuarioValidation.js"></script>

    <script>
        $(document).ready(function() {
            var $alert = $('#alert');
            if ($alert.length) {
                setTimeout(function() {
                    $alert.alert('close');  
                }, 5000);
            }
        });
    </script>
</body>
</html>
