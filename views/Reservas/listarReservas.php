<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/config.php'; 

require_once __DIR__ . '/../../model/reservasModel.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header('Location: /desafio_php_junior/views/login.php');
    exit();
}
$banco = new BancoDados();
$db = $banco->ConectarBanco();
$reservasModel = new ReservasModel($db);

$reservas = $reservasModel->buscarTodos();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

function formatarData($data) {
    $dateTime = new DateTime($data);
    return $dateTime->format('d/m/Y H:i');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Reservas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/css/salaLista.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Reservas</h3>
                    <a href="cadastrarReservas.php" class="btn btn-success"><i class="bi bi-person-plus-fill"></i> Cadastrar</a>
                </div>
                <?php if ($mensagem): ?>
                    <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>Sala</th>
                            <th>De</th>
                            <th>Até</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($reservas)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma reserva encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr>
                                    <td><?php echo $reserva['nomeUsuario']; ?></td>
                                    <td><?php echo $reserva['nomeSala']; ?></td>
                                    <td><?php echo formatarData($reserva['dataInicio']); ?></td>
                                    <td><?php echo formatarData($reserva['dataFim']);?></td>
                                    <td>
                                        <a href="cadastrarReservas.php/<?php echo urlencode($reserva['id']); ?>" class="btn btn-primary"><i class="bi bi-pencil"></i></a>
                                        <a href="/desafio_php_junior/controllers/reservas.php?acao=apagarReservas&id=<?php echo urlencode($reserva['id']); ?>" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <a href="/desafio_php_junior/views/home.php" class="btn btn-secondary">Voltar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
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
