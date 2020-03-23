<?php
require_once '../vendor/autoload.php';

$id = $_POST['task_id'];

$query = "DELETE FROM tasks WHERE id = :id";
$prepare = \ajax\connect\Connection::gI()->prepare($query);
$prepare->bindValue('id', $id);
$prepare->execute();