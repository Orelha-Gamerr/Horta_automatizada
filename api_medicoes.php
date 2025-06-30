<?php
include_once 'db_class.php';
$db = new db("medicao");
$medicoes = $db->all();

// Retorna os dados em JSON
header('Content-Type: application/json');
echo json_encode($medicoes);
?>