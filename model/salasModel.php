<?php
class SalasModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //Create
    public function cadastrarSalas($dados) {
        
        $sql = "INSERT INTO rooms  (name, capacity , location) VALUES (:nome, :capacidade, :locacao)";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':capacidade', $dados['capacidade']);
        $stmt->bindParam(':locacao', $dados['locacao']);        
    
        return $stmt->execute();
 
    }

    //Read
    public function buscarTodos(){

        $sql = "SELECT * FROM rooms";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM rooms where id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Update
    public function editar($id, $dados) {
        $sql = "UPDATE rooms SET name = :name, capacity = :capacity,location = :location WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $dados['name']);
        $stmt->bindParam(':capacity', $dados['capacity']);
        $stmt->bindParam(':location', $dados['location']);
        
        $stmt->bindParam(':id', $id);
        return $stmt->execute();

    }

    //Delete    
    public function excluir($id) {
        $sql = "DELETE FROM rooms WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $this->pdo = null;
        return $stmt->execute();
    }
    
}
?>
