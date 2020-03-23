<?php
require_once '../vendor/autoload.php';

if(isset($_POST['name']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']))
{
    $name = htmlentities($_POST['name']);
    $surname = htmlentities($_POST['surname']);
    $email = htmlentities($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(!(strlen($name) >= 4 && strlen($name) < 20)){
        die('Your name must be between 4 and 20 character');
    }

    if(!(strlen($surname) >= 4 && strlen($surname) < 20)){
        die('Your surname must be between 4 and 20 character');
    }

    if(!(filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) < 45)){
        die('Email invalid');
    }

    if(!(strlen($password) >= 6 && strlen($password) < 20)){
        die('Your password must be between 6 and 20 character');
    }

    if(!($password === $password2)){
        die('Passwords do not match');
    }

    if(!(ctype_alnum($name) && ctype_alnum($surname))){
        die();
    }

    $query = "INSERT INTO users (email, password, name, surname) VALUES (:e, :p, :n, :s)";
    $statement = \ajax\connect\Connection::gI()->prepare($query);
    $statement->bindValue('e', $email);
    $statement->bindValue('p', password_hash($password, PASSWORD_DEFAULT));
    $statement->bindValue('n', $name);
    $statement->bindValue('s', $surname);
    $statement->execute();

}