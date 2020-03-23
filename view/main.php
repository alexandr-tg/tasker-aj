<?php require_once "parts/header.php";

    $query = "SELECT * FROM projects WHERE user_id = :id";
    $statement = \ajax\connect\Connection::gI()->prepare($query);
    $statement->bindValue('id', $_SESSION['user_id']);
    $statement->execute();
    $data = $statement->fetchAll(\PDO::FETCH_ASSOC);
?>
<div class="container bg-light main">
    <h3 class="display-4">Create New Project</h3>
    <form action="#" method="POST" id="pro_crt_frm">
        <div id="message">
            <input type="text" class="form-control col-8 prj_name" placeholder="Your project name" required>
            <input type="button" id="prj_crt_btn" class="btn btn-info col-1" value="Create">
        </div>

    </form>

    <h3 class="display-4">Your Projects:</h3>
    <ul id="prj_list" class="list-group">
        <?php foreach ($data as $value): ?>
        <li class="list-group-item prj-<?=$value['id']?>">
            <span class='pro_link prj-id-<?=$value['id']?>' prj_id='<?=$value['id']?>'><?=$value['project_name'] ?></span>
            <input type='button' class='btn btn-danger btn-sm del_btn' value='Delete' prj_id='<?=$value['id']?>'>
            <input type='button' class='btn btn-primary btn-sm upd_btn' value='Update' prj_id='<?=$value['id']?>'>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php require_once "parts/footer.php" ?>
