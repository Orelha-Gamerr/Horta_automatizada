<?php
include_once 'db_class.php';
$db = new db("medicao");

date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário para São Paulo
$dados = [
    'umidade' => $_POST['umidade'] ?? '0',
    'data' => date('Y-m-d H:i:s')
];

$db->store($dados);
?>
