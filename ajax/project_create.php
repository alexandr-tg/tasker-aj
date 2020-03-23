<?php
require_once '../vendor/autoload.php';
session_start();

$name = $_POST['project_name'];

$query = "INSERT INTO projects(project_name, user_id) VALUES (:n, :u)";
$prepare = \ajax\connect\Connection::gI()->prepare($query);
$prepare->bindValue('n', $name);
$prepare->bindValue('u', $_SESSION['user_id']);
$prepare->execute();

$id = \ajax\connect\Connection::gI()->lastInsertId();

echo "<li class='list-group-item prj-$id'>
    <span class='pro_link prj-id-$id' prj_id='$id'>$name</span>
    <input type='button' class='btn btn-danger btn-sm del_btn' value='Delete' prj_id='$id'>
    <input type='button' class='btn btn-primary btn-sm upd_btn' value='Update' prj_id='$id'>
</li>";