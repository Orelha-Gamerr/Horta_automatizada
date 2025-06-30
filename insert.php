<?php
include_once 'db_class.php';
$db = new db("medicao");

$dados = [
    'umidade' => $_POST['umidade'] ?? '0',
    'data' => date('Y-m-d H:i:s')
];

$db->store($dados);
?>
