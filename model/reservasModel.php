<?php
class ReservasModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //Create
    public function cadastrarReservas($dados) {
        
        $sql = "INSERT INTO reservations (room_id , user_id , start_time,end_time  ) VALUES (:room_id, :user_id, :start_time,:end_time)";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':room_id', $dados['roomId']);
        $stmt->bindParam(':user_id', $dados['userId']);
        $stmt->bindParam(':start_time', $dados['startTime']);        
        $stmt->bindParam(':end_time', $dados['endTime']);        
        $this->pdo = null;
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Read
    public function buscarTodos(){

        $sql = "SELECT * FROM reservations";
        $stmt = $this->pdo->prepare($sql);

        $this->pdo = null;
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Update
    public function editar($id, $dados) {
        $sql = "UPDATE reservation SET name = :name, room_id = :room_id,user_id = :user_id, start_time = :start_time, end_time = :end_time WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $dados['name']);
        $stmt->bindParam(':room_id', $dados['room_id']);
        $stmt->bindParam(':user_id', $dados['user_id']);
        $stmt->bindParam(':start_time', $dados['start_time']);
        $stmt->bindParam(':end_time', $dados['end_time']);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    //Delete    
    public function excluir($id) {
        $sql = "DELETE FROM reservation WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $this->pdo = null;
        return $stmt->execute();
    }

    // Verifica se a sala ja foi reservada no horario
    public function verificaReserva($startTime) {
        
        $sql = "SELECT * FROM reservations WHERE start_time = :start_time";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':start_time', $startTime);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $stmt = null;
        $this->pdo = null;

        if($resultado){
            return true
        }

        return false;
    }
    
}
?>
