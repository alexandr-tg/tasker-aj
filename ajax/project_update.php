<?php
require_once '../vendor/autoload.php';

$name = $_POST['prj_name'];
$id = $_POST['prj_id'];

$query = "UPDATE projects SET project_name = :prj_name WHERE id = :prj_id";
$statement = \ajax\connect\Connection::gI()->prepare($query);
$statement->bindValue('prj_name', $name);
$statement->bindValue('prj_id', $id);
$statement->execute();
