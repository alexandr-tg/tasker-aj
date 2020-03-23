<?php
require_once '../vendor/autoload.php';

if($_POST['data_set'] == 'update'){
    $query = "UPDATE tasks SET task_name = :task_name, priority = :priority, dead_line = :dead_line WHERE id = :id";
} elseif($_POST['data_set'] == 'done') {
    $query = "UPDATE tasks SET status = 'done' WHERE id = :id";
} else {
    return false;
}

array_pop($_POST);

$statement = \ajax\connect\Connection::gI()->prepare($query);
$statement->execute($_POST);

