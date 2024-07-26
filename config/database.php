<?php
$dsn = 'mysql:host=desafio-tecnico.cf1afo0ns4vr.us-west-2.rds.amazonaws.com;dbname=vinicius_ribeiro';
$username = 'vinicius_ribeiro';
$password = 'DesafioAvant@2024';
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Erro na conexao: ' . $e->getMessage());
}
echo 'aqyui';die;
print_r($pdo);
return $pdo;
?>