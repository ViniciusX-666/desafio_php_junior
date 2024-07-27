<?php
class ReservasModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //Create
    public function cadastrarReservas($dados) {
        
        $sql = "INSERT INTO reservations (room_id , user_id , start_time,end_time) VALUES (:room_id, :user_id, :start_time,:end_time)";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':room_id', $dados['roomId']);
        $stmt->bindParam(':user_id', $dados['userId']);
        $stmt->bindParam(':start_time', $dados['startTime']);        
        $stmt->bindParam(':end_time', $dados['endTime']);        
        
        return $stmt->execute();
    }

    //Read
    public function buscarTodos() {
        $sql = "SELECT r.id, r.start_time AS dataInicio, r.end_time AS dataFim, u.name AS nomeUsuario, ro.name AS nomeSala 
                FROM reservations AS r
                INNER JOIN users AS u ON u.id = r.user_id
                INNER JOIN rooms AS ro ON ro.id = r.room_id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM reservations where id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Update
    public function editar($id, $dados) {
        $sql = "UPDATE reservations SET start_time = :start_time, end_time = :end_time WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->bindParam(':start_time', $dados['start_time']);
        $stmt->bindParam(':end_time', $dados['end_time']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    //Delete    
    public function excluir($id) {
        $sql = "DELETE FROM reservations WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Verifica se a sala ja foi reservada no horario
    public function verificaReserva($startTime, $endTime) {
        $sql = "SELECT * FROM reservations WHERE start_time < :end_time AND end_time > :start_time";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->bindParam(':end_time', $endTime);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $stmt = null;
    
        if ($resultado) {
            return true;
        }
    
        return false;
    }
    
    
}
?>
