<?php
require_once '../vendor/autoload.php';

$prj_id = $_POST['prj_id'];
$prj_query = "SELECT * FROM projects WHERE id = :prj_id";
$prj_stmnt = \ajax\connect\Connection::gI()->prepare($prj_query);
$prj_stmnt->bindValue('prj_id', $prj_id);
$prj_stmnt->execute();
$prj_data = $prj_stmnt->fetchAll(\PDO::FETCH_ASSOC);


$task_query = "SELECT * FROM tasks WHERE project_id = :prj_id AND status = 'active'";
$task_stmnt = \ajax\connect\Connection::gI()->prepare($task_query);
$task_stmnt->bindValue('prj_id', $prj_id);
$task_stmnt->execute();
$task_data = $task_stmnt->fetchAll(\PDO::FETCH_ASSOC);

?>

<h3 class='display-4 prj_name' prj_id="<?=$prj_data[0]['id']?>"><?=$prj_data[0]['project_name']?></h3>
<h3 class='display-4'>Create new Task:</h3>
<div id="message"></div>
<form action='#' method='POST'>
    <div class='row justify-content-md-center'>
        <input type='text' class='form-control col-md-8 tsk_name' placeholder='Your task name'>
        <input type="date" id="d_line" class="form-control col-2 tsk_date" value="">
        <select name="priority" id="priority">
            <option value="High">High</option>
            <option value="Middle">Middle</option>
            <option value="Low">Low</option>
        </select>
        <input type='button' class='btn btn-info col-md-1 task_crt' value='Create'>
    </div>
</form>
<h3 class='display-4 task_of'>Tasks of: <?=$prj_data[0]['project_name']?></h3>
<ul id="tsk_list" class='list-group'>

    <?php foreach ($task_data as $value): ?>
    <li class='list-group-item tsk-<?=$value['id']?>'>
        <span class='tsk_name tsk-<?=$value['id']?>' tsk_id="<?=$value['id']?>"><?= $value['task_name'] ?></span>
        <input type='button' class='btn btn-danger btn-sm del_btn' value='Delete'>
        <input type='button' class='btn btn-primary btn-sm task_upd_btn' value='Update'>
        <input type='button' class='btn btn-success btn-sm dne_btn' value='Done'>
        <span class='dead_line tsk-<?=$value['id']?>'><?=$value['dead_line']?></span>
        <span class='priority tsk-<?=$value['id']?>'><?=$value['priority']?><span>
    </li>
    <? endforeach; ?>

</ul>


