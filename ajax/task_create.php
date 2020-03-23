<?php
require_once '../vendor/autoload.php';

$id = $_POST['id'];
$name = $_POST['tsk_name'];
$priority = $_POST['priority'];
$d_line = $_POST['d_line'];

$query = "INSERT INTO tasks(task_name, project_id, priority, dead_line) VALUES (:n, :id, :p, :d)";
$prepare = \ajax\connect\Connection::gI()->prepare($query);
$prepare->bindValue('n', $name);
$prepare->bindValue('id', $id);
$prepare->bindValue('p', $priority);
$prepare->bindValue('d', $d_line);
$prepare->execute();

$tsk_id = \ajax\connect\Connection::gI()->lastInsertId();

$tsk_query = "SELECT * FROM tasks WHERE id = :id";
$tsk_stmnt = \ajax\connect\Connection::gI()->prepare($tsk_query);
$tsk_stmnt->bindValue('id', $tsk_id);
$tsk_stmnt->execute();
$tsk_data = $tsk_stmnt->fetchAll(\PDO::FETCH_ASSOC);
?>

    <li class='list-group-item tsk-<?=$tsk_data[0]['id']?>'>
        <span class='tsk_name tsk-<?=$tsk_data[0]['id']?>' tsk_id='<?=$tsk_data[0]['id']?>'><?=$name?></span>
        <input type='button' class='btn btn-danger btn-sm del_btn' value='Delete'>
        <input type='button' class='btn btn-primary btn-sm task_upd_btn' value='Update'>
        <input type='button' class='btn btn-success btn-sm dne_btn' value='Done'>
        <span class='dead_line tsk-<?=$tsk_data[0]['id']?>'><?=$tsk_data[0]['dead_line']?></span>
        <span class='priority tsk-<?=$tsk_data[0]['id']?>'><?=$tsk_data[0]['priority']?></span>
    </li>