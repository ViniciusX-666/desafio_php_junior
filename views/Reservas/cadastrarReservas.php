<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/config.php'; 

require_once __DIR__ . '/../../model/reservasModel.php';
require_once __DIR__ . '/../../model/usuarioModel.php';
require_once __DIR__ . '/../../model/salasModel.php';

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
$usuarioModel = new UsuarioModel($db);
$salasModel = new SalasModel($db);

function getIdFromUrl() {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $pathSegments = explode('/', trim($path, '/'));
    return !empty($pathSegments) ? intval(end($pathSegments)) : 0;
}

function formatarData($data) {
    $dateTime = new DateTime($data);
    return $dateTime->format('Y-m-d\TH:i');
}

$id = getIdFromUrl();

$reserva = null;

if ($id) {
    $reserva = $reservasModel->buscarPorId($id);    
}

$usuarios = $usuarioModel->buscarTodos();
$salas = $salasModel->buscarTodos();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Reservas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/desafio_php_junior/public/css/usuario.css?v=1.0">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3><?php echo $id ? 'Editar Reserva' : 'Cadastrar Reserva'; ?></h3>
                <?php if ($mensagem): ?>
                    <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>                        
                    </div>
                <?php endif; ?>
                <form id="reservaForm" action="<?php echo $id ? '/desafio_php_junior/controllers/reservas.php?acao=editarReservas' : '/desafio_php_junior/controllers/reservas.php?acao=cadastrarReservas'; ?>" method="post">  
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="user_id">Usuário:</label>
                        <select class="form-control" id="user_id" name="user_id" <?php echo $id ? 'readonly' : ''; ?>>
                            <option value="" disabled <?php echo !$reserva ? 'selected' : ''; ?>>Selecione</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?php echo $usuario['id']; ?>" <?php echo ($reserva && $reserva[0]['user_id'] == $usuario['id']) ? 'selected' : ''; ?>>
                                    <?php echo $usuario['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                    </div>
                    <div class="form-group">
                        <label for="room_id">Sala:</label>
                        <select class="form-control" id="room_id" name="room_id" <?php echo $id ? 'readonly' : ''; ?>>
                            <option value="" disabled <?php echo !$reserva ? 'selected' : ''; ?>>Selecione</option>
                            <?php foreach ($salas as $sala): ?>
                                <option value="<?php echo $sala['id']; ?>" <?php echo ($reserva && $reserva[0]['room_id'] == $sala['id']) ? 'selected' : ''; ?>>
                                    <?php echo $sala['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Horário de Início:</label>
                        <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo isset($reserva[0]['start_time']) ? formatarData($reserva[0]['start_time']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="end_time">Horário de Término:</label>
                        <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo isset($reserva[0]['end_time']) ? formatarData($reserva[0]['end_time']) : ''; ?>">
                    </div>
                    <div class="d-flex justify-content-between">
                    <a href="/desafio_php_junior/views/Reservas/listarReservas.php" class="btn btn-secondary">Voltar</a>
                        <input type="hidden" name="registerReserva" value="1">
                        <button id="submit" type="submit" class="btn btn-primary"><?php echo $id ? 'Atualizar' : 'Cadastrar'; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-Kc0eL9j36HgpKkKKt3FwTvCWScC4jKGvxuO9ZyBmMJJ5GUKsL5n0YgWoG5iXpCz6" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="../../public/js/reservasValidation.js"></script>

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
