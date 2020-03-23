<?php
session_start();

require_once '../vendor/autoload.php';

if(!empty($_POST['email']) && !empty($_POST['password'])){
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    if(!(is_string($email) && is_string($password))){
        die('Type is wrong');
    }

    if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 45)){
        die('Email invalid');
    }

    if(!(strlen($password) >= 6 && strlen($password) < 20)){
        die('Your password must be between 6 and 20 character');
    }

    $query = 'SELECT * FROM users WHERE email = :e';
    $statement = \ajax\connect\Connection::gI()->prepare($query);
    $statement->bindValue('e', $email);
    $statement->execute();
    $result = $statement->fetchAll(\PDO::FETCH_ASSOC)[0];

    if($result){
        $id = $result['id'];

        if (password_verify($_POST['password'], $result['password'])) {
            $_SESSION['user_id'] = $id;

            if(!isset($_SESSION['csrf_token']))
            {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            echo 'Authorization success';
        } else {
            die('Email or Password is wrong');
        }
    } else {
        die('1Email or Password is wrong');
    }
}