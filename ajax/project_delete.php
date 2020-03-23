<?php
require_once '../vendor/autoload.php';

$prj_id = $_POST['id'];

$query = "DELETE FROM projects WHERE id = :id";
$prepare = \ajax\connect\Connection::gI()->prepare($query);
$prepare->bindValue('id', $prj_id);
$prepare->execute();